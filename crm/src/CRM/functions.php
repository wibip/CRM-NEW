<?php 
header("Cache-Control: no-cache, must-revalidate");
include_once(__DIR__.'/../../classes/dbClass.php');
include_once(__DIR__ .'/../../classes/systemPackageClass.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
class crm
{
    private $package_functions;
    private $db;
    private $crm_profile;
    private $system_package;
    private $networkArr;

    public function __construct($crm_profile,$system_package) {
        $this->package_functions = new package_functions();
        $this->db = new db_functions();
        $this->crm_profile = $crm_profile;
        $this->system_package = $system_package;
        $this->networkArr = $this->getAllConfig($this->crm_profile);
    }

    public function getAllConfig($crm_profile){
        $q = "SELECT `api_url`,`api_password`,`api_username`,`controller_name`
            FROM `exp_locations_ap_controller` 
            WHERE `id` = '$crm_profile'";
        $data = $this->db->select1DB($q);
        return $data;
    }

    public function getOtherConfig($field) {
        $networkArr = $this->networkArr;
        return $networkArr[$field];

    }

    public function getToken(){
        //API Url
        $url = $this->getOtherConfig('api_url').'/api/'.$this->getOtherConfig('controller_name').'/token';
        
        //The JSON data.
        $data = array(
                'username'   => $this->getOtherConfig('api_username'),
                'password'   => $this->getOtherConfig('api_password')
        );
        $jsondata = json_encode($data);

        try {
            //Initiate cURL.
            $ch = curl_init($url);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);

            // Receive server response ...
            $header_parameters = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

            $result = curl_exec($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $sus=json_decode($body,true);
            // $q = "INSERT INTO `exp_crm_logs` (`name`,`description`,`request`,`response`,`status_code`,`create_user`,`create_date`)
            //     VALUES('createToken','Create CRM Token','$jsondata','$result','$httpcode','',NOW())";
            // $this->db->execDB($q);

            $this->db->addApiLogs('createToken', 'Create CRM Token', 'SUCCESS', 'crm token generation', $url, $jsondata, $result, $httpcode, $_SESSION['user_id']);
            return $sus['data']['token'];
        } catch(Exception $e) {
            $this->db->addApiLogs('createToken', 'Create CRM Token', 'ERROR', 'crm token generation', $url, $jsondata, $e->getMessage(), 0, $_SESSION['user_id']);
            return 'Error';
        }
        
    }

    public function createParent($jsonData, $mno_id){
        $access_token = $this->getToken();
        //API Url
        $url2 = $this->getOtherConfig('api_url').'/api/'.$this->getOtherConfig('controller_name').'/accounts';
        
        try{
            $ch = curl_init($url2);
            $header_parameters = "Content-Type: application/json;charset=UTF-8";
            $header_parameters = array(
                'Authorization: Bearer '.$access_token.'',
                'Accept: application/json',
                'Content-Type: application/json');
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_parameters);

            curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            //Execute the request
            $result = curl_exec($ch);
                
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            $decoded = json_decode($body, true);
            
            $req = $url2.'->'.$this->db->escapeDB($jsonData);
        
            // $q = "INSERT INTO `exp_crm_logs` (`name`,`description`,`request`,`response`,`status_code`,`create_user`,`create_date`)
            // VALUES('createProperty','Create CRM Property','$req','$result','$httpcode','',NOW())";

            //$this->db->execDB($q);
            if ($decoded['status'] == 'success') {
                $ex = $this->db->execDB("UPDATE exp_crm SET `status` = 'Completed' WHERE id = '$mno_id'");
                $this->db->addApiLogs('createClient', 'Create CRM Client', 'SUCCESS', 'crm client generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }else{
                $ex = $this->db->execDB("UPDATE exp_crm SET `status` = 'Failed' WHERE id = '$mno_id'");
                $this->db->addApiLogs('createClient', 'Create CRM Client', 'ERROR', 'crm client generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }

            return $decoded; 

        } catch(Exception $e) {
            $this->db->addApiLogs('createToken', 'Create CRM Token', 'ERROR', 'crm token generation', $url2, $jsonData, $e->getMessage(), 0, $_SESSION['user_id']);
            return 'Error';
        }
        
    }

    public function createLocation($property_id,$jsonData, $location_id){
        $access_token = $this->getToken();
        //API Url
        $url2 = $this->getOtherConfig('api_url').'/api/'.$this->getOtherConfig('controller_name').'/accounts/'.$property_id.'/locations';
        
        try{
            $ch = curl_init($url2);
            $header_parameters = "Content-Type: application/json;charset=UTF-8";
            $header_parameters = array(
                'Authorization: Bearer '.$access_token.'',
                'Accept: application/json',
                'Content-Type: application/json');
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_parameters);

            curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            //Execute the request
            $result = curl_exec($ch);
                
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            $decoded = json_decode($body, true);
            
            $req = $url2.'->'.$this->db->escapeDB($jsonData);

            if ($decoded['status'] == 'success') {
                $ex = $this->db->execDB("UPDATE crm_exp_mno_locations SET `is_enable` = 1 WHERE id = '$location_id'");
                $this->db->addApiLogs('createLocation', 'Create CRM Location', 'SUCCESS', 'crm location generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }else{
                $ex = $this->db->execDB("UPDATE crm_exp_mno_locations SET `is_enable` = 0 WHERE id = '$location_id'");
                $this->db->addApiLogs('createLocation', 'Create CRM Location', 'ERROR', 'crm location generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }

            return $decoded; 

        } catch(Exception $e) {
            $this->db->addApiLogs('createToken', 'Create CRM Token', 'ERROR', 'crm token generation', $url2, $jsonData, $e->getMessage(), 0, $_SESSION['user_id']);
            return 'Error';
        }
        
    }

    public function updateLocation($property_id,$jsonData, $location_id){
        $access_token = $this->getToken();
        //API Url
        $url2 = $this->getOtherConfig('api_url').'/api/'.$this->getOtherConfig('controller_name').'/accounts/'.$property_id.'/locations';
        
        try{
            $ch = curl_init($url2);
            $header_parameters = "Content-Type: application/json;charset=UTF-8";
            $header_parameters = array(
                'Authorization: Bearer '.$access_token.'',
                'Accept: application/json',
                'Content-Type: application/json');
            //Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_parameters);

            curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            //Execute the request
            $result = curl_exec($ch);
                
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            $decoded = json_decode($body, true);
            
            $req = $url2.'->'.$this->db->escapeDB($jsonData);

            if ($decoded['status'] == 'success') {
                $ex = $this->db->execDB("UPDATE crm_exp_mno_locations SET `is_enable` = 1 WHERE id = '$location_id'");
                $this->db->addApiLogs('createLocation', 'Create CRM Location', 'SUCCESS', 'crm location generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }else{
                $ex = $this->db->execDB("UPDATE crm_exp_mno_locations SET `is_enable` = 0 WHERE id = '$location_id'");
                $this->db->addApiLogs('createLocation', 'Create CRM Location', 'ERROR', 'crm location generation', $url2, $req, $result, $httpcode, $_SESSION['user_id']);
            }

            return $decoded; 

        } catch(Exception $e) {
            $this->db->addApiLogs('createToken', 'Create CRM Token', 'ERROR', 'crm token generation', $url2, $jsonData, $e->getMessage(), 0, $_SESSION['user_id']);
            return 'Error';
        }
        
    }
}
?>