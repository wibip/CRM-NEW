<?php 
require_once dirname(__FILE__).'/../../LOG/logObjectProvider.php';
require_once dirname(__FILE__).'/../../LOG/Logger.php';
class switch_wag
{
	private $url1_postfix = '/wsg/api/public/v8_2';
	private $switch_url1_postfix = '/switchm/api/v8_2';
	private $baseurl = '';
	private $cookie = '';
	
	public function __construct($ap=NULL)
	{
		$db_class = new db_functions();
		$this->profile_name = $db_class->setVal("wag_ap_name",'ADMIN');
		
		$this->ap = $ap;
		
		$this->run_user_name = $_SESSION['user_name'];
		$this->realm=$db_class->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_name`='$this->run_user_name' LIMIT 1");
	
		//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

		$input=$this->session();
		$this->baseurl = $input[baseurl];
		$this->switch_baseurl = $input[switch_baseurl];
		$this->cookie = $input[cookie];
		
		$this->serviceTicket = NULL;

	}

    public function getServiceTicket(){
        if($this->serviceTicket===NULL){
            $this->serviceTicket = $this->serviceTicket();
        }
        return $this->serviceTicket;
    }

	public function getConfig($field)
	{
		$db_class = new db_functions();
		$profile_name = $this->profile_name;
		$query = "SELECT $field AS f FROM exp_wag_ap_profile WHERE wag_ap_name = '$profile_name' LIMIT 1";
		$query_results = $db_class->selectDB($query);
        foreach($query_results['data'] AS $row){
			return $row['f'];
		}
	}


    /**
     * @param null $realm
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }
	
	
    public function getController()
    {
        return  $this->ap;
    }
	
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$rlm){
		/* $query = "INSERT INTO `exp_wag_ap_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`, unixtimestamp)
		VALUES ('$rlm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */

		$log = logObjectProvider::getLogObjectProvider()->getObjectVsz();

		//$log->

		$log->setFunction($function);
		$log->setFunctionName($function_name);
		$log->setDescription($description);
		$log->setApiMethod($method);
		$log->setApiStatus($api_status);
		$log->setApiDescription($api_details);
		$log->setApiData($api_data);
		$log->setRealm($rlm);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
	
	}
	
	
	
		///////////////session start/////////////////
	
	public function session($c=NULL,$d=NULL){
		
		if($c==NULL){
			
			$c=rand(1,2);
		}
		
		if($d==NULL){
			
			$d=1;
		}else{
			
			$d=0;
		}		
		
		$login=$this->login($c);
		
		//API Url
		$url = $login[baseurl].'/session';
		
		//Initiate cURL.
		$ch = curl_init($url);
		
		//The JSON data.
		$jsonData = array(
				'username'   => $login[username],
				'password'   => $login[password]
		);
		
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		
		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=UTF-8'));

		//ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


		//Execute the request
		$result = curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		

		curl_close ($ch);
		
		$cookies = array();
		preg_match_all('/Set-Cookie:(?<cookie>\s{0,}.*)$/im', $result, $cookies);
		
		$cookies['cookie'][0]; // show harvested cookies
		
		$pieces = explode(";", $cookies['cookie'][0]);
		$pieces[0];
		
		$sus=json_decode($body,true);
		
		$results=array(
			'cookie'   => $pieces[0],
			'baseurl'  => $login[baseurl],
			'switch_baseurl'  => $login[switch_baseurl]
			);
		
		  if($sus[controllerVersion]){
			  
			  return $results;
			 // session(1);
		  }else if($c==1 && $d==1){
			  
			  return $this->session(2,1);
		  }else if($c==2 && $d==1){
			  
			 return $this->session(1,1);
			  
		  }else{
			  
			  return $results;
		  }
	
	}
	
	/////////////////login data////////////////////
	public function login($t=NULL){
		
		$ap_cnt=$this->ap;
		
		if($this->ap == NULL){				
	
		return $inData = array(
				'username'   => $this->getConfig('api_user_name'),//'admin',
				'password'   => $this->getConfig('api_password'),//'ruckus1234!',
				'baseurl' 	 => $this->getConfig('api_url')/*'https://10.1.6.8:7443'*/.$this->url1_postfix,
				'switch_baseurl' 	 => $this->getConfig('api_url').$this->switch_url1_postfix
		);
	}else{
		
		if($t==NULL||$t==2){
			$db_class = new db_functions();
		$uname=$db_class->getValueAsf("SELECT `api_username` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		$pword=$db_class->getValueAsf("SELECT `api_password` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		$url=$db_class->getValueAsf("SELECT `api_url` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		
		$url2=$db_class->getValueAsf("SELECT `api_url_se` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		
				return $inData = array(
				'username'   => $uname,//'admin',
				'password'   => $pword,//'ruckus1234!',
				'baseurl' 	 => $url/*'https://10.1.6.8:7443'*/.$this->url1_postfix,
				'switch_baseurl' 	 => $url.$this->switch_url1_postfix
		);
		
		}else if($t==1){
			
				$db_class = new db_functions();
		$uname=$db_class->getValueAsf("SELECT `api_username` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		$pword=$db_class->getValueAsf("SELECT `api_password` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		//$url=$db_class->getValueAsf("SELECT `api_url` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		
		$url=$db_class->getValueAsf("SELECT `api_url_se` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
		
		if($url==NULL||$url==''){
			
			$url=$db_class->getValueAsf("SELECT `api_url` AS f FROM `exp_locations_ap_controller` WHERE `controller_name`='$ap_cnt' LIMIT 1");
			
		}		
		
				return $inData = array(
				'username'   => $uname,//'admin',
				'password'   => $pword,//'ruckus1234!',
				'baseurl' 	 => $url/*'https://10.1.6.8:7443'*/.$this->url1_postfix,
				'switch_baseurl' 	 => $url.$this->switch_url1_postfix
		);		
			
			
		}
		
	}

}

	    public function serviceTicket($c=NULL,$d=NULL){

       //$input=$this->session();

    	if($c==NULL){
			
			$c=rand(1,2);
		}
		
		if($d==NULL){
			
			$d=1;
		}else{
			
			$d=0;
		}		
		
		$login=$this->login($c);
		
		$url2=$this->baseurl.'/serviceTicket';
		$ch2 = curl_init($url2);
		
		$jsonData2 = array(
				'username'   => $login[username],
				'password'   => $login[password]
		);
		
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
		
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

            curl_close ($ch2);
            if($status!='200'){
                $this->log(__FUNCTION__,'Service Ticket', $ch2,'POST', $status, $message, $jsonDataEncoded2,'');
            }

		
		$res_arr = json_decode($message,true);
		
		return $res_arr['serviceTicket'];




    }

    function deleteServiceTicket(){

		//$input=$this->session();

		$url2=$this->baseurl.'/serviceTicket?serviceTicket='.$this->getServiceTicket();

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		// Make the REST call, returning the result
		$response = curl_exec($curl);

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$message = urlencode($message);

		if($status == '200'){
            $this->serviceTicket = NULL;
			return 'status=success&status_code=200&Description='.$message;
		}
		else{
			$this->log(__FUNCTION__,'Delete Service ticket', $url2,'DELETE', $status, '', '','');

			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}

    /////////////Get switch group details/////////////////////
    public function getGroupDetail($id){
        $url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);



        $this->log(__FUNCTION__,'Get Switch Groups Details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
    }



    public function createSwitchGroup($name=NULL,$description=NULL,$domain_id=NULL){
		
		//$input=$this->session();
		
		$url2=$this->switch_baseurl.'/group?serviceTicket='.$this->getServiceTicket();
		$ch2 = curl_init($url2);
		
		$jsonData2 = array(
		
				'name'   => $name,
				'description'   => $description,
				'domainId'   => $domain_id
		);
		
		
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
		
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
		
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

		curl_close ($ch2);
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Switch Group', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		$message = urlencode($message);

		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		

	}

	/////////////////switch group delete////////////////////

	function deleteswitchgroup($id){

		//$input=$this->session();

		$url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		// Make the REST call, returning the result
		$response = curl_exec($curl);

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Delete Switch Group', $url2,'DELETE', $status, '', '');

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}

	public function getSwitches(array $data_ar){

        //$input=$this->session();


        $url2=$this->switch_baseurl.'/switch?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);
		
		/*$jsonData2 = array(
		
				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data_ar;
		
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
		
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
		
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close ($ch2);
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Get Switches', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		$message = urlencode($message);

		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}

    }

     public function getSwitchDetails($id){


        $url2=$this->switch_baseurl.'/switch/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Get Switch Details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


     public function getSwitchGroup($id){


        $url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Get Switch Group', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


    public function moveToSwitchGroup(array $switch,$switch_group){

       // $input=$this->session();

    	$jsonDataEncoded = json_encode($switch);

        $url2=$this->switch_baseurl.'/switch/move/'.$switch_group.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PUT');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        $log_request = $url2.'\nData: '.json_encode($switch);

        $this->log(__FUNCTION__,'Move To Switch Group', $url2,'PUT', $status, $message, $log_request,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

        /////////////////retrieve domains///////////////////

    public function retrieveDomains(){

        //$input=$this->session();

        $url2=$this->baseurl.'/domains?listSize=100000';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Retrieve Domains', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    public function retrieveDomainsNew(array $filters)
    {

        //$input=$this->session();


        $jsonData2 = array(
            'filters' => $filters,
        );

        $data = json_encode($jsonData2);

        $url2 = $this->baseurl . '/group/tree/apgroup?includeStagingZone=true';

        $ch2 = curl_init();

        curl_setopt($ch2, CURLOPT_URL, $url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Cookie:" . $this->cookie . "", 'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__, 'Retrieve Domains New', $url2, 'GET', $status, $message, $data, $this->realm);

        $message = urlencode($message);

        if ($status == '200') {

            return 'status=success&status_code=200&Description=' . $message;

        } else {
            return 'status=failed&status_code=' . $status . '&Description=' . $message;

        }


    }

    /////////////////get System Time///////////////////

    public function retrieveSystemTime(){

       // $input=$this->session();

        $url2=$this->baseurl.'/system/systemTime';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Retrieve System Time', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


        /////////////////create a domain///////////////////

    public function createDomain($domain_name,$parent_domain=null){

        //$input=$this->session();


        $jsonData2 = array(
            'name'=>$domain_name
        );

        if(strlen($parent_domain) > 1){
        	$jsonData2['parentDomainId'] = $parent_domain;
        }

        $data = json_encode($jsonData2);

        $url2=$this->baseurl.'/domains';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Create Domain', $url2,'POST', $status, $message, $data,$this->realm);

        $message = urlencode($message);
        
        if($status == '201'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

        /////////////////retrieve sub domains///////////////////

    public function retrieveSubDomains($domain_id){

        //$input=$this->session();

        $url2=$this->baseurl.'/domains/'.$domain_id.'/subdomain?listSize=100000';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Retrieve Sub Domains', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    public function getGroupsUnderSystemDomain(){

        $jsonDataEncoded = json_encode(array("sortInfo"=>array('sortColumn'=>'text','dir'=>'ASC')));

        $url2=$this->switch_baseurl.'/group/tree?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);



        $this->log(__FUNCTION__,'Get Switch Groups Under System Domain', $url2,'POST', $status, $message, $jsonDataEncoded,$this->realm);

        $message = urlencode($message);

        if($status == '204' || $status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
    }

    public function Functionlist(){

    	$jsonData_funtionlist = array(
    		'createSwitchGroup'=>'Create Switch Group',
           	'getSwitches'=>'Get Switches',
           	'getSwitchGroup'=>'Get Switch Group',
           	'getSwitchDetails'=>'Get Switch Details',
           	'moveToSwitchGroup'=>'Move To Switch Group',
           	'retrieveDomains'=>'retrieve Domains',
           	'createDomain'=>'Create Domain',
           	'retrieveSubDomains'=>'Retrieve Sub Domains'
		);

	return	$data = json_encode($jsonData_funtionlist);
		
	}


	/////////////////Delete a switch///////////////////

public function deleteSwitch($switch_id){

	//$input=$this->session();


	$url2=$this->switch_baseurl.'/switch/'.$switch_id.'?serviceTicket='.$this->getServiceTicket();
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

	//ADD FROM RACUS V5
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
	curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$resultl=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Delete Switch', $url2,'DELETE', $status, $message, '',$this->realm);

	$message = urlencode($message);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}

	

}
    public function getGroupsByDomain($domain){
        $jsonDataEncoded = json_encode(array("filters"=>array(array('type'=>'DOMAIN','value'=>$domain))));

        $url2=$this->switch_baseurl.'/group/tree?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);



        $this->log(__FUNCTION__,'Get Switch Groups By Domain', $url2,'POST', $status, $message, $jsonDataEncoded,$this->realm);

        $message = urlencode($message);

        if($status == '204' || $status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
    }
}
	
