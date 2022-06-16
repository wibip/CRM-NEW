<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/systemPackageClass.php');

require_once dirname(__FILE__).'/../../LOG/Logger.php';

class rnd

{
	public function __construct($get_details)
	{

		$this->db = new db_functions();

		//$this->network_name = $db_class->setVal("network_name",'ADMIN');

		$this->baseurl = $get_details['api_url'];
        $this->username = $get_details['api_user_name'];
        $this->password = $get_details['api_password'];
		//$this->auth_token = '933ab16d-9587-47a2-bfbc-8565157d7b9f';
		
	}


	public function log($function, $function_name, $description, $method, $api_status, $api_details, $api_data, $rlm)
    {

        $logger = Logger::getLogger();
        $log = $logger->getObjectProvider()->getObjectVsz();

        //$log->

        $log->setFunction($function);
        $log->setFunctionName($function_name);
        $log->setDescription($description);
        $log->setApiMethod($method);
        $log->setApiStatus($api_status);
        $log->setApiDescription($api_details);
        $log->setApiData($api_data);
        $log->setRealm($rlm);



        $logger->InsertLog($log);

    }


	public function Login()
    {

        $url2 = $this->baseurl . '/login';

        $ch2 = curl_init($url2);

        $data=array('username'=> $this->username,
    				'password' => $this->password);
        //Encode the array into JSON.
        $jsonDataEncoded2 = json_encode($data);

        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $result2 = curl_exec($ch2);


        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($result2, 0, $header_size);
        $message = substr($result2, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        curl_close($ch2);

        //$message = urlencode($message);
        $decode=json_decode($message,true);
        return $decode['token'];

    }


    public function CreateAp(array $data)
    {
        $url2 = $this->baseurl . '/aps';

        $ch2 = curl_init($url2);

        //Encode the array into JSON.
        $jsonDataEncoded2 = json_encode($data,JSON_UNESCAPED_SLASHES);

        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array("x-access-token:" . $this->login() . "", 'Content-Type: application/json;charset=UTF-8'));

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $result2 = curl_exec($ch2);
        //print_r(json_decode($result2));


        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($result2, 0, $header_size);
        $message = substr($result2, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__, 'RND Create AP', $url2, 'POST', $status, $message, $jsonDataEncoded2, $this->realm);

        curl_close($ch2);
        $msg_arr = json_decode($message,true);
        $message = urlencode($message);

        if ($status == '200') {
            if($msg_arr['success']){
                return json_encode(['status_code'=>$status,'status'=>'success','Description'=>$message]);
            }else{
                return json_encode(['status_code'=>$status,'status'=>'failed','Description'=>$message]);
            }

        } else {
            return json_encode(['status_code'=>$status,'status'=>'failed','Description'=>$message]);
        }
    }

    public function DeleteAp($ap_serial)
    {
        $url2 = $this->baseurl . '/aps/'.$ap_serial.'/false';

        $ch2 = curl_init($url2);

        //Encode the array into JSON.
        //$jsonDataEncoded2 = json_encode($data,JSON_UNESCAPED_SLASHES);

        curl_setopt($ch2, CURLOPT_HTTPHEADER, array("x-access-token:" . $this->login() . "", 'Content-Type: application/json;charset=UTF-8'));

        //Attach our encoded JSON string to the POST fields.
        //curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $result2 = curl_exec($ch2);
        //print_r(json_decode($result2));


        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($result2, 0, $header_size);
        $message = substr($result2, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__, 'RND Delete AP', $url2, 'DELETE', $status, $message, '', $this->realm);

        curl_close($ch2);
        $msg_arr = json_decode($message,true);
        $message = urlencode($message);

        if ($status == '200') {
            if($msg_arr['success']){
                return json_encode(['status_code'=>$status,'status'=>'success','Description'=>$message]);
            }else{
                return json_encode(['status_code'=>$status,'status'=>'failed','Description'=>$message]);
            }

        } else {
            return json_encode(['status_code'=>$status,'status'=>'failed','Description'=>$message]);
        }
    }




}