<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/systemPackageClass.php');

include_once('function.php');

require_once dirname(__FILE__).'/../../LOG/Logger.php';

class aaa

{
	private $system_package;

	public function __construct($network_name,$system_package,$data_arr = [])
	{

		$this->db = new db_functions();

		//$this->network_name = $db_class->setVal("network_name",'ADMIN');

		$this->lib_name = $network_name;
		$this->system_package = $system_package;
		$this->data_arr = $data_arr;

		//$this->auth_token = '933ab16d-9587-47a2-bfbc-8565157d7b9f';
		$this->networkArr = $this->initialConfig($this->lib_name);
		$this->auth_token = $this->getNetworkConfig($this->lib_name,'api_acc_org');

	}

	private function initialConfig($network){

		$query = "SELECT * FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

		$isDynamic = package_functions::isDynamic($this->system_package);
		$row=$this->db->select1DB($query);
		//$row = mysql_fetch_array($query_results);
		if (!empty($this->data_arr)) {
			$row['api_master_acc_type'] = $this->data_arr['api_master_acc_type'];
			$row['api_login'] = $this->data_arr['api_login'];
			$row['api_password'] = $this->data_arr['api_password'];
			$row['api_acc_profile'] = $this->data_arr['api_acc_profile'];
			$row['api_acc_org'] = $this->data_arr['api_acc_org'];
			$row['ses_base_url'] = $this->data_arr['api_base_url'];
			$row['api_base_url'] = $this->data_arr['api_base_url'];
		}elseif($isDynamic){
			$q="SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$this->system_package'";
			$qra=$this->db->select1DB($q);
			//$qra=mysql_fetch_assoc($qr);
			$qraj = json_decode($qra['settings'],true); 
			$row['api_master_acc_type'] = $qraj['aaa_configuration']['AAA_PRODUCT_OWNER']['options'];
			$row['api_login'] = $qraj['aaa_configuration']['AAA_USERNAME']['options'];
			$row['api_password'] = $qraj['aaa_configuration']['AAA_PASSWORD']['options'];
			$row['api_acc_profile'] = $qraj['aaa_configuration']['AAA_TENANT']['options'];
			if (strlen($qraj['aaa_configuration']['AAA_SECURITY_TOKEN']['options'])>0) {
				$row['api_acc_org'] = $qraj['aaa_configuration']['AAA_SECURITY_TOKEN']['options'];
			}
			$row['ses_base_url'] = $qraj['aaa_configuration']['AAA_URL']['options'];
			$row['api_base_url'] = $qraj['aaa_configuration']['AAA_URL']['options'];
		}
		return $row;
	}

	public function getoptdatabyrealm($realm){
        
        $data = json_decode($this->db->getValueAsf("SELECT m.aaa_data as f FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id WHERE emd.verification_number='$realm' LIMIT 1"),true);
        return $data;
    }

	public function getNetworkConfig($network,$field)

	{
		$networkArr = $this->networkArr;
		return $networkArr[$field];

		/* $query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

		$query_results=mysql_query($query);

		while($row=mysql_fetch_array($query_results)){

			return $row['f'];

		} */

	}



	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null,$mac=null){
		/*  $query = "INSERT INTO `exp_aaa_logs`
		(`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id,`unixtimestamp`)
		VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'Support','$group_id',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */
		$mac= str_replace('-','',$mac);
		$mac= str_replace(':','',$mac);

		$log = Logger::getLogger()->getObjectProvider()->getObjectAaa();

		//$log->

		$log->setFunction($function);
		$log->setFunctionName($function_name);
		$log->setDescription($description);
		$log->setApiMethod($method);
		$log->setApiStatus($api_status);
		$log->setApiDescription($api_details);
		$log->setApiData($api_data);
		$log->setUsername($aaa_username);
		$log->setgroupid($group_id);
		$log->setMacid($mac);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
	}

	public function lognew($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$realm=null,$mac=null){
       /*  $query = "INSERT INTO `exp_session_profile_logs`
        (`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,`realm`,`mac`,`unixtimestamp`)
        VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API','$realm','$mac',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */
		$mac= str_replace('-','',$mac);
		$mac= str_replace(':','',$mac);
		$log = Logger::getLogger()->getObjectProvider()->getObjectSession();

		//$log->

		$log->setFunction($function);
		$log->setFunctionName($function_name);
		$log->setDescription($description);
		$log->setApiMethod($method);
		$log->setApiStatus($api_status);
		$log->setApiDescription($api_details);
		$log->setApiData($api_data);
		$log->getRealm($realm);
		$log->getmac($mac);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
    }




	public function getAllZones(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function deleteLookupZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function deleteZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function getAllLookupZones(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function getAllGroupsNew(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function createGroup(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}

	public function createZone(){
		$json = array('status_code' => 200,
                    'status' => 'success',
                    'Description'=>array());
        $encoded=json_encode($json);
		return $encoded;
	}


	public function getGroup($token){

	

		 $query = "SELECT `group` from exp_security_tokens

		WHERE token_id = '$token'";

	

		$query_results=$this->db->selectDB($query);

		foreach ($query_results['data'] as $row) {
			$group = $row[group];

		}

	
		return $group;
	

		//$other_parameters_array = (array)json_decode($other_parameters);

		//return $other_parameters_array[realm];

	}


	public function getPurgeTime($realm){



		 $query = "SELECT purge_time AS f FROM `exp_products_distributor` p ,`exp_mno_distributor` d 
                  WHERE d.distributor_code=p.`distributor_code` 
                  AND d.`verification_number`='$realm'
                 AND p.network_type='guest'";



		$query_results=$this->db->selectDB($query);

		foreach ($query_results['data'] as $row) {

			$purg_time = $row[f];

		}


		return $purg_time;


		//$other_parameters_array = (array)json_decode($other_parameters);

		//return $other_parameters_array[realm];

	}


	public function getToken($mac){

		
		$macc= str_replace('-','',$mac);
		$query = "SELECT token FROM exp_customer_sessions_mac WHERE mac = '$macc' LIMIT 1";

		
		$query_results=$this->db->selectDB($query);
		foreach ($query_results['data'] as $row) {
			$token = $row[token];

		}		

			return $token;

	}

	///////////////session start/////////////////
	
	public function session(){
			
		//API Url
		$url = $this->getNetworkConfig($this->lib_name,'api_base_url').'/tokens';
		
		//Initiate cURL.
		$ch = curl_init($url);
		
		//The JSON data.
		$jsonData = array(	
				'Tenant'   	 => $this->getNetworkConfig($this->lib_name,'api_acc_profile'),
				'User-Name'   => $this->getNetworkConfig($this->lib_name,'api_login'),
				'password'   => $this->getNetworkConfig($this->lib_name,'api_password')
		);
		
		$jsonDataEncoded = json_encode($jsonData);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->auth_token.":"); 

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($status_code!= '201'){
           $this->log('',__FUNCTION__, 'Unauthorized User', $url, 'POST', $status_code,$this->db->escapeDB($body), $jsonDataEncoded ,'','','');
           
    
        }
         //$this->log('',__FUNCTION__, 'Test', $url, 'REST', $status_code,$this->db->escapeDB($body), $jsonDataEncoded ,'','');
        $sus=json_decode($body,true);
        //curl_close ($ch);
        //echo $sus[auth_token];
        return $sus['auth_token'];
        

	}

	public function updateAccount($account_type,$portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm){

		$timezone='Africa/Blantyre';
		$tz_object = new DateTimeZone($timezone);
		$datetime = new DateTime(null,$tz_object);
		$begindate = $datetime->format('Y-m-d H:i:s');
		$startdate= strtotime($begindate);
		$datetime->add(new DateInterval($timegap));
		$enddate = $datetime->format('Y-m-d H:i:s');
		$finaldate= strtotime($enddate);

		//$base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');
		$organization = $realm;

		
		if(strlen($organization)=='0'){
			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

			//$organization = $this->getNetworkConfig($this->lib_name,'api_acc_org');

		}
		$macc= str_replace('-','',$mac);

		$owner = $this->getNetworkConfig($this->lib_name,'api_acc_profile');//api_acc_profile

		$user_name_ale = $macc.'@'.$organization; 

		if($account_type == 'new'){       

			$jsonData=array(
		 				'Valid-Until'=>$finaldate,
						'Signup-Type' => 'click_and_connect',
						'Valid-From'=>$startdate,
						'Credits'     => array('aaa' =>'5' ,
												'aba' =>'3'), 
						'Account-State'=> 'Active',
						'Product' => $product,
						'Product-Owner' => $owner,
						'Password' => $user_name_ale,
						'Purge-Delay-Time' => 0,
						'UUID' => '9bbd4eca-66fe-4284-9cf1-074f09805714',
						'User-Data' => array('plugin_id' => 'Free access without sms loop',
												'question_answer' => 'Arris_Offices' ),
						'User-Name'      => $user_name_ale,
						'Group'     => $owner				
						);
			 			
			}

		else if($account_type == 'ex'){


			$jsonData = array(

					'Purge-Delay-Time'   	=> $purge_delay_time,
					'First-Access'   	=> 'REMOVE|',
					'Last-Access'   	=> 'REMOVE|',
					'Valid-Until'   => $enddate,

			);

		}

		$jsonDataEncoded = json_encode($jsonData);
		//Tell cURL that we want to send a POST request.
			//API Url
		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$this->log($user_name_ale,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $this->db->escapeDB($body), $jsonDataEncoded,$organization,$mac);

		if($status_code == '200'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$decoded);
        		$encoded=json_encode($json1);
				return $encoded;
			}

		else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

		}


	}


	

	public function createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm,$urln,$token){

		/*$timezone='America/New_York';
		$tz_object = new DateTimeZone($timezone);
		$datetime = new DateTime(null,$tz_object);
		$begindate = $datetime->format('Y-m-d H:i:s');
		$startdate= strtotime($begindate);
		$datetime->add(new DateInterval($timegap));
		$enddate = $datetime->format('Y-m-d H:i:s');
		$finaldate= strtotime($enddate);*/
		$macc= str_replace('-','',$mac);
		$organization = $realm;


		if(strlen($organization)=='0'){

			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

		}
		
		$macc= str_replace('-','',$mac);
		$user_name_ale = $macc.'@'.$organization;
		
		$owner = $this->getNetworkConfig($this->lib_name,'api_acc_profile');//api_acc_profile

		

		//$owner= $this->getNetworkConfig($this->lib_name,'api_acc_profile');
		// This is an archaic parameter list
        //json aray
		 $jsonData=array(
						'Account-State'=> 'Active',
						'Product' => $product,
						'Product-Owner' => $owner,
						'Password' => $user_name_ale,
						'User-Name' => $user_name_ale		
						);

		$jsonDataEncoded = json_encode($jsonData);
		//echo $jsonDataEncoded;
		//Tell cURL that we want to send a POST request.
			//API Url
		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts';

		$session=$this->getSessionsbymac($mac,$realm);

		$sessionstatus=json_decode($session,true);
		$token=$sessionstatus['Description'];
		$status=$sessionstatus['status_code'];
		$ses_type=$sessionstatus['status'];


		
		if ($status==200) {
			$getaccount=$this->checkMacAccount($mac,$realm,$type);
			$accounttatus=json_decode($getaccount,true);
			$statuss=$accounttatus['status_code'];

			if ($statuss==200) { // && $ses_type==FULL
				$json1 = array('status_code' => '409',
                            'status' => 'error',
                            'Description'=>'');
        		$encoded=json_encode($json1);
				return $encoded;
				# code...
			}
			/*if ($statuss==200 && $ses_type==REDIRECT) {
				$startsession=$this->Startsession($mac,$realm,$token);
				$json1 = array('status_code' => '200',
                            'status' => 'error',
                            'Description'=>'');
        		$encoded=json_encode($json1);
				return $encoded;
				# code...
			}*/
			else{
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$this->log($user_name_ale,__FUNCTION__, 'Create Account', $url2, 'POST', $status_code, $this->db->escapeDB($body), $jsonDataEncoded,$organization,$mac);

		if($status_code == '201'){
			$startsession=$this->Startsession($mac,$realm,$token);
				$json1 = array('status_code' => '200',
                            'status' => 'success',
                            'Description'=>$decoded);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => '404',
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}
		

			}
		}
		else{
			$getaccount=$this->checkMacAccount($mac,$realm,$type);
			$accounttatus=json_decode($getaccount,true);
			$statuss=$accounttatus['status_code'];
			if ($statuss==200) {
				$json1 = array('status_code' => '409',
                            'status' => 'error',
                            'Description'=>'');
        		$encoded=json_encode($json1);
				return $encoded;
				# code...
			}
			else{
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$this->log($user_name_ale,__FUNCTION__, 'Create Account', $url2, 'POST', $status_code, $this->db->escapeDB($body), $jsonDataEncoded,$organization,$mac);

		if($status_code == '201'){
				$json1 = array('status_code' => '200',
                            'status' => 'success',
                            'Description'=>$decoded);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}
		
				
			}
			# code...


		}

		

	}

	///////////////////////////////////////////////////////////////
	public function getAllGroup(){


		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/groups';
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];
        
		$this->log($user_name_ale,__FUNCTION__, 'Get Group', $url2, 'GET', $status_code, $this->db->escapeDB($body), '',$organization,$mac);
				
		
				if($status_code == '200'){
					return $body;

		
				}
				else{
					return $body;
					/* SOAP Parameter Error */
				}
		
		
	}

	public function checkAccount($mac,$realm){

		
		//$base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');

		$organization = $realm;


		if(strlen($organization)=='0'){

			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

		}
		
		$macc= str_replace('-','',$mac);
		$user_name_ale = $macc.'@'.$organization;

		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;
		// $url2;
		$request_array=array(

					'First-Access'   	=> $macc.'@'.$organization,
					'url' => $url2

				);
		$Encoded=json_encode($request_array);
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$decoded = json_decode($body, true);
		$valid_until=$decoded['Valid-Until'];
		$ac_state=$decoded['Account-State'];
		$desc=$decoded['internal-debug-message'];

		$this->log($user_name_ale,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $this->db->escapeDB($body), '',$organization,$mac);
	
				 
			if($status_code == '200'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$decoded);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}

	
	}

	public function deleteAccount($mac,$realm){

		$organization = $realm;			

		
		if(strlen($organization)=='0'){
			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

			//$organization = $this->getNetworkConfig($this->lib_name,'api_acc_org');

		}
		$macc= str_replace('-','',$mac);

		
		$user_name_ale = $macc.'@'.$organization;        



		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";

		//Attach our encoded JSON string to the POST fields.
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);	


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$decoded = json_decode($body, true);
		$valid_until=$decoded['Valid-Until'];
		$ac_state=$decoded['Account-State'];
		$desc=$decoded['internal-debug-message'];



		$this->log($user_name_ale,__FUNCTION__, 'Delete Account', $url2, 'DELETE', $status_code, $this->db->escapeDB($body),'', $organization,$mac);

	

			if($status_code == '204'){
				$json1 = array('status_code' => '200',
                            'status' => 'success',
                            'Description'=>$decoded);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}

			

	}

	public function getSessionsbymac($mac,$realm){
        
        $organization=$realm;

        $macc= str_replace('-','',$mac);
        $group=$this->getNetworkConfig($this->lib_name,'api_acc_profile');
        $url2 =$this->getNetworkConfig($this->lib_name,'api_base_url').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        $decoded = json_decode($body, true);
        
       foreach ($decoded as $value){
       	
        	if($value['User-Name']==$mac){ 
        		$master_uname=$value['AAA-User-Name'];
                $Access_Profile = $value['Access-Profile'];
                $token = $value['Session-Token'];

                break;
			}
		}
		

        $desc=$decoded['internal-debug-message'];
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        
       $this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db->escapeDB($body), '' ,$organization,$mac);
                 
            if($Access_Profile==REDIRECT){
				$json1 = array('status_code' => '200',
                            'status' => $Access_Profile,
                            'Description'=>$token);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => '404',
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}
                
            
    
    }

	public function checkMacAccount($mac,$realm,$type){
	
		$organization = $realm;


		if(strlen($organization)=='0'){

			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

		}
		
		$macc= str_replace('-','',$mac);
		$user_name_ale = $macc.'@'.$organization;

		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;
		// $url2;
		$request_array=array(

					'First-Access'   	=> $macc.'@'.$organization,

				);
		$Encoded=json_encode($request_array);
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$profile_string_final = json_decode($body, true);
		$valid_until=$profile_string_final['Valid-Until'];
		$ac_state=$profile_string_final['Account-State'];
		$desc=$profile_string_final['internal-debug-message'];

		$array1=array($profile_string_final);
		

		$this->log($user_name_ale,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $this->db->escapeDB($body), '',$organization,$mac);

		if (empty($array1) ||$status_code == '404'){
			$res_arr = array();
			$res_arr3 = array();
		}
		else{
		if (strlen($array1array1['Product'])>0) {
			$single_profile_data=1;
			$array1[0]=$array1;
		}
		else{
			$single_profile_data=sizeof($array1);
		}
		
		$res_arr = array();
		$res_arr3=array();
		for($k=0;$k<$single_profile_data;$k++){
			
				$Master_Account = '';
				$array_get_profile_value = '';
				$array_get_profile_value= $array1[$k];

				$User_Name = $array_get_profile_value['User-Name'];
				
				$macc=explode('@', $User_Name);
				$mac=$macc['0'];
				$realm=$macc['1'];

				$newarray1=array("Mac"=>$mac,
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $realm,
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $mac,
                    			"Ses_token"=> $session_id,
                    			"User-Name"=> $User_Name,
                    			"TYPE"=> $type);
					
				array_push($res_arr, $newarray1);

			
		}

		}
		$finalarray = $this->uniqueAssocArray($res_arr, 'User-Name', 'Realm');
	
				 
			if($status_code == '200'||$status_code == '404'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$finalarray);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}

	
			
		
	}

	public function checkRealmAccount($realm,$type){
	
		$organization = $realm;//$realm;

		if(strlen($organization)=='0'){

			$organization = $this->getNetworkConfig($this->lib_name,'api_acc_profile');

		}
		//$Frontier=$this->getNetworkConfig($this->lib_name,'api_acc_profile');
		$json=$this->getAllGroup();
		$decode=json_decode($json,true);
		//print_r($decode[0]);

		$arraylength=sizeof($decode);

		$res_array=array();

		for ($i=0; $i < $arraylength; $i++) { 
		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts?filter[Group]='.$decode[$i];
		 
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		

		$decoded = json_decode($body, true);
		$length=sizeof($decoded);

		if (sizeof($decoded)<1) {
			$res_arr = array();
			$res_arr3=array();
		}
		else{
			$res_array = array_merge($res_array, $decoded);
		}
		
		$this->log($organization,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $this->db->escapeDB($body), '' ,$organization,$mac);
		
		}

	 $key_query1 = "SELECT m.`property_id` FROM `exp_mno_distributor` d INNER JOIN mdu_distributor_organizations m ON d.`distributor_code`=m.`distributor_code` WHERE `verification_number`='$organization'";
         $query_resultsnew=$this->db->selectDB($key_query1);

        foreach ($query_resultsnew['data'] as $row) {
                 //$Realmn = $row['property_id'];
                           }
        //echo $Realmn;

		$newarray=array();
		foreach ($res_array as $value2) {
			
			$username=($value2['User-Name']);
			$parem_r=explode("@",$username);
			$arr_realm=$parem_r[1];

			/*if ((strpos($organization, $arr_realm)>-1) || (strpos($organization, $arr_realm)>-1)){
				array_push($newarray, $value2);
			}*/
			$realm_new=explode('-',$organization);
            $realm_new = $realm_new[0];
			if ($arr_realm==$organization || (substr($arr_realm, 0, strlen($realm_new)) === $realm_new)) {
				array_push($newarray, $value2);
			}

		}

		if (empty($newarray)) {
			$res_arr = array();
			$res_arr3 = array();
		}
		else{
		if (strlen($newarray['Product'])>0) {
			$single_profile_data=1;
			$newarray[0]=$newarray;
		}
		else{
			$single_profile_data=sizeof($newarray);
		}
		
		$res_arr = array();
		$res_arr3=array();
		for($k=0;$k<$single_profile_data;$k++){
			
				$Master_Account = '';
				$array_get_profile_value = '';
				$array_get_profile_value= $newarray[$k];

				$User_Name = $array_get_profile_value['User-Name'];
				
				$macc=explode('@', $User_Name);
				$mac=$macc['0'];
				$realm=$macc['1'];

				$newarray1=array("Mac"=>$mac,
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $realm,
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $mac,
                    			"Ses_token"=> $session_id,
                    			"User-Name"=> $User_Name,
                    			"TYPE"=> $type);
					
				array_push($res_arr, $newarray1);

		}

		}
		$finalarray = $this->uniqueAssocArray($res_arr, 'User-Name', 'Realm');
		
		$valid_until=$newarray['Valid-Until'];
		$ac_state=$newarray['Account-State'];
		$desc=$newarray['internal-debug-message'];



		
	
				 
			if($status_code == '200'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$finalarray);
        		$encoded=json_encode($json1);
				return $encoded;
			}

			else{
				$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;

			}
			
	}

public	function uniqueAssocArray($array, $uniqueKey, $uniqueKey2) {
    //print_r($array);
  if (!is_array($array)) {
    return array();
  }
  $uniqueKeys = array();
  foreach ($array as $key => $item) {
    if ((!in_array($item[$uniqueKey], $uniqueKeys)) AND (!in_array($item[$uniqueKey2], $uniqueKeys))) {
      $uniqueKeys[$item[$uniqueKey]] = $item;
    }
  }
  return $uniqueKeys;
}

	public function getAllProducts($realm=null){

		
		$organization = $realm;

		if (strlen($organization=='0')){
			$organization=$this->getNetworkConfig($this->lib_name,'api_acc_profile');	
		}
		$owner=$this->getNetworkConfig($this->lib_name,'api_acc_profile');

		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/products';
		//echo $url2;
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	$this->log($organization, __FUNCTION__, 'Get Product', $url2, 'GET', $status_code, $this->db->escapeDB($body), '', $organization,$mac);

	if($status_code == '200'){
		return $body;
	}

	else{
		 return $desc;
	}
	}

	public function Startsession($mac,$realm,$token){
        $group=$realm;
        

        // Operation
        $macc= str_replace('-','',$mac);
        $jsonData = array(
                    
                'User-Name'    => $macc.'@'.$group,
                'Password'     => $macc.'@'.$group
    
        );
    

        $jsonDataEncoded = json_encode($jsonData);

        //API Url
        $url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/sessions/'.$token.'/login';
        //echo $url2;

        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        //curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
        //echo $this->session() ;

        
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
        $result = curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];
        


        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //echo $status_code;
        curl_close ($ch);
         
                //$status_code = 200;
                if($status_code == '201'){
                    $status_wag = 200;
    
                }
                else{
                    $status_wag = 1021;

                }




    
       $this->lognew(__FUNCTION__, 'Session Start', $url2, 'POST', $status_code,$this->db->escapeDB($body), $url2 ,$organization,$mac);

        //return $encoded; 
        
    
    }



}

?>