<?php 
header("Cache-Control: no-cache, must-revalidate");


include_once(__DIR__.'/../../classes/dbClass.php');
include_once(__DIR__ .'/../../classes/systemPackageClass.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
class crm
{

    public function __construct($crm_profile,$system_package)
    {

        $this->package_functions = new package_functions();
        $this->db = new db_functions();
        $this->crm_profile = $crm_profile;
        $this->system_package = $system_package;
        $this->networkArr = $this->getAllConfig($this->crm_profile);
    }

    public function getAllConfig($crm_profile){
    if (!isset($crm_profile)) {
        $crm_profile = 'CRM_HOSTED';
    }
    $q = "SELECT `api_url`,`api_password`,`api_user_name` FROM `exp_other_profile` WHERE distributor='ADMIN' AND type='CRM' AND `profile_name` = '$crm_profile'";
    $data = $this->db->select1DB($q);
    return $data;
    }

    public function getOtherConfig($field)

    {
        $networkArr = $this->networkArr;
        return $networkArr[$field];

    }

    public function getToken(){
    //API Url
    $url = $this->getOtherConfig('api_url').'/token';
    //Initiate cURL.
    $ch = curl_init($url);
    
    //The JSON data.
    $data = array(
            'username'   => $this->getOtherConfig('api_user_name'),
            'password'   => $this->getOtherConfig('api_password')
    );
    $jsondata = json_encode($data);
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

        $sus=json_decode($body,true);
        //echo $sus[auth_token];
        return $sus['data']['token'];

    }

    public function createParent($jsonData){

        $access_token = $this->getToken();
        //API Url
        $url2 = $this->getOtherConfig('api_url').'/accounts';
        //echo $url2;

        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        $header_parameters = array(
            'Authorization: Bearer '.$access_token.'',
            'Content-Type: application/json');
        print_r($header_parameters);
        //curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        //echo $this->session() ;
        
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
        // echo $body;
        $q = "INSERT INTO `exp_crm_logs` (`name`,`description`,`request`,`response`,`status_code`,`create_user`,`create_date`)
        VALUES('createProperty','Create CRM Property','$req','$result','$httpcode','',NOW())";
        $this->db->execDB($q);

        return $decoded; 
    }
}
?>