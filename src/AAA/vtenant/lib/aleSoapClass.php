<?php



//Current Page URL
$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80")
{
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else
{
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}



include_once 'dbClass.php';
$db = new db_functions();


//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');





class network_functions
{

	public function __construct()
	{


		$this->url = $this->network('ACC_API_URL');
		$this->ses_url = $this->network('ACC_SES_API_URL');
		
		
	
	}

	
	
	
	
	public function network($parameter) {
	
	 	$query = "SELECT settings_value FROM mdu_settings WHERE settings_code = '$parameter' LIMIT 1";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$result = $row[settings_value];
		}
		return $result;
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string){
	

		//echo $service_profile_product;
		$tz_object = new DateTimeZone($this->network('TIMEZONE'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		$datetime->add(new DateInterval($this->network('MASTER_ACC_TIMEGAP_MINUTES')));
		$enddate = $datetime->format('Y-m-d H:i:s');
	
		$differenceInSeconds = strtotime($enddate) - $begindate;
		
		
		require_once('lib/nusoap.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Create Account', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		//echo $secret_question;
		//echo $secret_answer;
		
		

		$user_date_array = array(
				
				'secret_answer'      => $secret_answer,
				'warning'      => $warning,
				'zip'      => $zip,
				'country'      => $country,
				'usermessage'      => $usermessage,
				'city'      => $city,
				'violation'      => $violation,
				'company'      => $company,
				'secret_question'      => $secret_question,
				'address'      => $address,
				'state'      => $state,		
				'address2' => 	$address2,
				'ispremium' => $this->network('IS_PREMIUM'), //'false'				
		);
		
		
		$credits_array = array(
		
				'Bucket-1'      => '1000000000000000'
		);
		
		
		$product_list =  explode(',',$service_profile_product);
		//$product_list = explode(',',$this->network('PRODUCT'));
		
		$srvice_profile_array = array();
		foreach ($product_list as $key => $value){
			$srvice_profile_array[$value] = 'true';
		}
		
	/* 	
	 * $srvice_profile_array = array(
		
				$this->network('PRODUCT')      => 'true'
		);
		 */
		
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'Password'      => $password,
				'User-Name'     => $username,
				'Group' => $organization, //'MSISDN,copy',	// copy="true"
				'Account-State' => $this->network('MASER_ACC_STATUS'),//'Inactive', // Active or Inactive
				'MSISDN' => $mobile_number,
				'Email' => $email,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				
			//	'First-Access'     => '0',
			 //	'Last-Access'     => '0',
			 
			    'Service-Profiles' => $srvice_profile_array, //$this->network('PRODUCT'),
				'User-Data' => $user_date_array,//$user_data_string,
				'PAS-Account-Locked' => $this->network('PAS_Account_Locked'),//'False',
				'Credits' => $credits_array,  //'Bucket-1=1',
				'PAS-Account-Type' => $this->network('PAS_Account_Type'),//'credits',
				'PAS-Allow-Extend' => $this->network('PAS_Allow_Extend'),//'True',
				'PAS-Password-Secret-Answer' => $secret_answer,
				'PAS-Password-Secret-Question' => $secret_question,
				'PAS-Allow-Overwrite' => $this->network('PAS_Allow_Overwrite'),//'True',
				'Valid-From'    => $begindate,	// 1415092796.2
				'Valid-Until'   => $enddate,
				'Validity-Time' => $this->network('VALIDITY_TIME')
			//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))

		);
		
		
		
		
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Create Account', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */

		}
		
		else {
			

				
			$err = $client->getError();
			if ($err) {
				
			
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Create Account', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				
				
				/* SOAP Fault Error */
			}
				
			else {
				// Soap Success
				//print_r($result);
		
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
					//$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
				
/* 				$status_code = $result['result']['!code'];
				$desc = $result['result']['!message'];
				$status = $result['result']['!status'];
				$details = $result['details'];
				$ref = $result['!reference'];
		 */
		//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
          		VALUES ('Create Account', '$username', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Creation Success - '.$status_code;
						
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
		//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	}
	
	

	
	////////////////////////////////////////////////////////////////////////
	
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number){
	
	
		$tz_object = new DateTimeZone($this->network('TIMEZONE'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		$datetime->add(new DateInterval($this->network('SUB_ACC_TIMEGAP_MINUTES')));
		$enddate = $datetime->format('Y-m-d H:i:s');
	

	
		require_once('lib/nusoap.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Add Device', '$mac', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
		
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$srvice_profile_array = array(
		
				//'Aptilo-WiFi-Account-Charge-Master-SP'      => 'true'
				$this->network('SUB_PRODUCT')      => 'true'
		);

		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'Password'      => $mac, //copy="true"
				'User-Name'     => $mac,
				'Master-Account' => $username,
				'Group' => $organization, //'MSISDN', //copy="true"
				'Account-State' => $this->network('SUB_ACC_STATUS'),//'Active',
				'MSISDN' => $mobile_number,// This is equal to MAC => $mac,
				'Email' => $email,
				//'Validity-Time' => urlencode($this->network('TIME_LEFT')),
				'PAS-Account-Locked' => $this->network('PAS_Account_Locked'),//'False',
				'PAS-Account-Type' => $this->network('PAS_Account_Type'),//'credits',
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'PAS-Allow-Extend' => $this->network('PAS_Allow_Extend'),//'True',
				'PAS-Allow-Overwrite' => $this->network('PAS_Allow_Overwrite'),//'True',
				'First-Access'     => $begindate,
				'Last-Access'     => $begindate,
				'Service-Profiles' => $srvice_profile_array,
			//	'Service-Profiles' => urlencode($this->network('PRODUCT')),
			//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
		);
		
		

		
		
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Add Device', '$mac', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Add Device', '$mac', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($client->response);
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
		
/* 				$status_code = $result['result']['!code'];
				$desc = $result['result']['!message'];
				$status = $result['result']['!status'];
				$details = $result['details'];
				$ref = $result['!reference']; */
		
				//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				
				
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Add Device', '$mac', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Device Creation Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
	}
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	
	public function modifyAcc($email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string){
	

		require_once('lib/nusoap-update.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Account', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
		
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		$client->setUseCurl($useCURL);
		
		
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		
		$user_date_array = array(
		
				'secret_answer'      => $secret_answer,
				'warning'      => $warning,
				'zip'      => $zip,
				'country'      => $country,
				'usermessage'      => $usermessage,
				'city'      => $city,
				'violation'      => $violation,
				'company'      => $company,
				'secret_question'      => $secret_question,
				'address'      => $address,
				'state'      => $state
		);
		

		
		

		
		
		
		$params_update = array(
				
				'Group' => $organization,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'EMAIL' => $email,
				'MSISDN' => $mobile_number,
			//	'Service-Profiles' => urlencode($this->network('PRODUCT')),
				'User-Data' => $user_date_array //$user_data_string,


		);
		
		if(strlen($password)>0){
			$params_update['Password'] = $password;
		}
		
		
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
		
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Account', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Account', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($result);
		
				
				//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
					//$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
				
/*  				$status_code = $result['code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				$details = $result['details'];
				$ref = $result['!reference']; 
				
				if(strlen($status_code) == 0){
					$status_code = $result['!code'];
					$desc = $result['!message'];
				} */
		
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Account', '$email', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
	
		
		
	}
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	public function modifyProfile($email,$product_list){
	
	
		require_once('lib/nusoap-update.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Service Profile', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);
	
		$product_list = explode(',',$product_list);
		
		$srvice_profile_array = array();
		foreach ($product_list as $key => $value){
			$srvice_profile_array[$value] = 'true';
		}
	

		$params_update = array(
	
				'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);
	

	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		if ($client->fault) {
	
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Service Profile', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Service Profile', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
				//print_r($result);
	
	
			//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
						
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
					//$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
	

	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Service Profile', '$email', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
	
	
	
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function AUP($email,$user_message_text,$aup_message_text){
		
		require_once('lib/nusoap-update.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$aup_text_log = $email.', AUP Message = '.$aup_message_text;
		
		$err = $client->getError();
		if ($err) {
		
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('AUP Violation', '$aup_text_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		$client->setUseCurl($useCURL);
		
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		
		$credits_reservation_array = array(
		
				'Bucket-1' => 'REMOVE|'
				//'Bucket-1'      => '0'
		);
		
		
		$credits_array = array(
		
				'Bucket-1'      => '0'
		);
		
		
		$user_date_array = array(
		
				'warning'      => $aup_message_text,
			//	'usermessage'      => $user_message_text//,
			//	'violation'      => $aup_message_text
		);
		
		
		$params_update = array(
		
	
				'User-Data' => $user_date_array,
				'Credits' => $credits_array,  //'Bucket-1=1',
				'Credit-Reservations' => $credits_reservation_array // (ADD|10,REMOVE|)
		
		);
		
		
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('AUP Violation', '$aup_text_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('AUP Violation', '$aup_text_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($client->response);
				
				//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				
				//print_r($result);
		
				/* 				
				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				$details = $result['details'];
				$ref = $result['!reference'];
				
				if($status_code != 200){
	 				$status_code = $result[result]['!code'];
					//$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$desc = $result[details]['detail']['!message'];
					$ref = $result[result]['!reference']; 
				}
				
				
				 */
				
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				//	$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
				
				
		
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('AUP Violation', '$aup_text_log', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
	}
	
	
	
	////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////////////////
	
	public function AUP_Activate($email){
	
		require_once('lib/nusoap-update.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Reconnect User', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);
	
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
		$credits_array = array(
	
				'Bucket-1'      => '1000000000000000'
		);
	
	
		$user_date_array = array(
	
				'warning'      => '0',
			//	'usermessage'      => '0',
				'violation'      => '0'
		);
	
	
		$params_update = array(
	
	
				'User-Data' => $user_date_array,
				'Credits' => $credits_array,  //'Bucket-1=1',
	
		);
	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		if ($client->fault) {
			
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Reconnect User', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Reconnect User', '$email', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
				//print_r($client->response);
	
				//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				//	$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
	
	
/* 				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				$details = $result['details'];
				$ref = $result['!reference']; */
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Reconnect User', '$email', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
	}	
	
	
	
	
	
	////////////////////////////////////////////
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function UserMessage($email,$user_message_text){
	
		require_once('lib/nusoap-update.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$user_message_log = $email.', usermessage = '.$user_message_text;
	
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('User Message', '$user_message_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);
	
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
	
		$user_date_array = array(
	
				'usermessage'      => $user_message_text//,

		);
	
	
		$params_update = array(
	
	
				'User-Data' => $user_date_array,
	
		);
	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		if ($client->fault) {
			
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('User Message', '$user_message_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('User Message', '$user_message_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
				//print_r($client->response);
	
				//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
	
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					//$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					//$desc = $result[details][detail]['!message'];
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
	
/* 				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				$details = $result['details'];
				$ref = $result['!reference']; */
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('User Message', '$user_message_log', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=User message update Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
	}
	
	
	
	
	////////////////////////////////////////////
	////////////////////////////////////////////
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function findUsers($search_parameter, $term){
	

/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsers',
				$search_parameter => urlencode($term)
		);
	 */
		//return $fields;
		
		$search_string_log = $search_parameter.' = '.$term;
	
		require_once('lib/nusoap-find.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
		
		
		$err = $client->getError();
		if($err) {
		
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Search Users', '$search_string_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				//'Master-Account' => NULL
				$search_parameter      => $term
				//'Account-State'      => 'Inactive'

		);
		
		
		
		$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Search Users', '$search_string_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Search Users', '$search_string_log', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($result);
				

				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
				
/* 				$status_code = $result['result']['!code'];
				$desc = $result['result']['!message'];
				$status = $result['result']['!status'];
				$details = $result['details'];
				$ref = $result['!reference'];   */
				
				//print_r($result[responses][response]);
		
				//echo $parameter_string = json_encode($result[responses][response]);
				
				
				
				
				
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				
				$profile_string_final = '';
				
				$master_array = $result[responses][response];
				//print_r($master_array);
				$master_array_size = sizeof($master_array);
				
			
				$key_array_1 = array_keys($master_array);
				
				
				
				//	$key_array_value = '1';
				$key_array_value = strtoupper($key_array_1[0]);
				
				if($key_array_value == 'PARAMETER'){
					
					//echo $key_array_value;
						
				//	foreach ($master_array as $key_this => $obj){
							
					$obj = $master_array;
						$para_array = $obj['parameter'];
						$group_array = $obj['group'];
							
						//print_r($para_array);
							
						$profile_string = '';
							
						for($i=0;$i<sizeof($para_array);$i++){
							$obj_name = $obj['parameter'][$i]['!name'];
							$obj_value = $obj['parameter'][$i]['!value'];
							$profile_string .= $obj_name.'='.$obj_value.'&';
						}
						
						
						
						for($k=0;$k<sizeof($group_array);$k++){
							
							
							$group_name = $group_array[$k]['!name'];
							$sub_group_array = $group_array[$k]['parameter'];
						
							if($group_name == 'User-Data'){
								for($j=0;$j<sizeof($sub_group_array);$j++){
						
									$sub_name = $sub_group_array[$j]['!name'];
									$sub_val = $sub_group_array[$j]['!value'];
						
									$sub_str_text = $sub_name.'='.$sub_val.'&';
									$profile_string .= $sub_str_text;
						
								}
							}
								
							if($group_name == 'Service-Profiles'){
								//print_r($sub_group_array);
								$service_profile_list = $sub_group_array[0]['!name'].','.$sub_group_array[1]['!name'].','.$sub_group_array[2]['!name'];
								$profile_string .= 'Service-Profiles='.$service_profile_list.'&';
							}
					
								
							/*
							 if($group_name == 'Credits'){
							 $profile_string .= 'Credits='.$sub_group_array['!name'].'#'.$sub_group_array['!value'].'&';
							 }
							 	
							 */
						
						}

							
						//echo $profile_string;
						$profile_string_final .= $profile_string.'|';
				//	}
				
				
						
				}
				
				
				else{
				
					foreach ($master_array as $key_this => $obj){
						
						/* if main array has single element*/
						if(($master_array_size == 1)){
							$obj = $master_array;
						}
						/* if main array has single element*/
	
						
						$para_array = $obj['parameter'];
						$group_array = $obj['group'];
						
						//print_r($para_array);
						
						$profile_string = '';
						
						for($i=0;$i<sizeof($para_array);$i++){
							$obj_name = $para_array[$i]['!name'];
							$obj_value = $para_array[$i]['!value'];
							$profile_string .= $obj_name.'='.$obj_value.'&';
						}
						
						
						for($k=0;$k<sizeof($group_array);$k++){
						
							$group_name = $group_array[$k]['!name'];
							$sub_group_array = $group_array[$k]['parameter'];
						
							if($group_name == 'User-Data'){
								for($j=0;$j<sizeof($sub_group_array);$j++){
						
									$sub_name = $sub_group_array[$j]['!name'];
									$sub_val = $sub_group_array[$j]['!value'];
						
									$sub_str_text = $sub_name.'='.$sub_val.'&';
									$profile_string .= $sub_str_text;
						
								}
							}
							
							if($group_name == 'Service-Profiles'){
								$service_profile_list = $sub_group_array[0]['!name'].','.$sub_group_array[1]['!name'].','.$sub_group_array[2]['!name'];
								
								$profile_string .= 'Service-Profiles='.$service_profile_list.'&';
							}
						
							
							/* 						
	 						if($group_name == 'Credits'){
								$profile_string .= 'Credits='.$sub_group_array['!name'].'#'.$sub_group_array['!value'].'&';
							}
							
							*/
						
						}
						
						//echo $profile_string;
						$profile_string .='|';
						//echo $profile_string.'<br />';
						//echo '<br><br><br>';
						$profile_string_final .= $profile_string;
					}
				}
				
				
				
				
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				
					//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
					//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				
			//	echo $profile_string_final;
				
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Search Users', '$search_string_log', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	//	
		
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	public function findUsersByMaster($master_user){
	
	
/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsersByMaster',
				'master' => urlencode($master_user)
		); */
	
		//return $fields;

		require_once('lib/nusoap-find.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
		
		
		$err = $client->getError();
		if ($err) {
		
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Devices', '$master_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		
		
		$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Devices', '$master_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Devices', '$master_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($result);
			//	$parameter_string = json_encode($result[responses][response]);
			

				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
				
				
/*  			$status_code = $result['result']['!code'];
				$desc = $result['result']['!message'];
				$status = $result['result']['!status'];
				$details = $result['details'];
				$ref = $result['!reference'];   */
				
				
				
				
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				
				$profile_string_final = '';
				
				$master_array = $result[responses][response];
				//print_r($master_array);
				
				
				
				
				$master_array_size = sizeof($master_array);	

				$key_array_1 = array_keys($master_array);
				
			//	print_r($key_array);
			//	$key_array_value = '1';
				$key_array_value = strtoupper($key_array_1[0]);
				
				if($key_array_value == '0'){
					
					foreach ($master_array as $key_this => $obj){
					
					
						$para_array = $obj['parameter'];
					
							
					
						$profile_string = '';
							
						for($i=0;$i<sizeof($para_array);$i++){
							$obj_name = $obj['parameter'][$i]['!name'];
							$obj_value = $obj['parameter'][$i]['!value'];
							$profile_string .= $obj_name.'='.$obj_value.'&';
						}
					
						//echo $profile_string;
						$profile_string_final .= $profile_string.'|';
					}
 					

					
				}

				 
				else{ 
				
				 
				
					$para_array = $master_array['parameter'];
					$profile_string = '';
					
					for($i=0;$i<sizeof($para_array);$i++){
						$obj_name = $master_array['parameter'][$i]['!name'];
						$obj_value = $master_array['parameter'][$i]['!value'];
						$profile_string .= $obj_name.'='.$obj_value.'&';
					
					
					}
					$profile_string_final .= $profile_string.'|';
						

				
				}

				
					
			
					
					
					
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				/* Profile Data Formatting XML to Text */
				
				//echo $profile_string_final;
				
				
				//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Devices', '$master_user', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Device get Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	//	
	}
	
	
	
	

	
	
	
	
	public function delUser($network_user){

	
		require_once('lib/nusoap-delete.php');
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if($err) {
		
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Delete Account', '$network_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'User-Name' => $network_user
		);
		
		
		
		$result = $client->call('deleteAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Delete Account', '$network_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Delete Account', '$network_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
		
			else {
				// Soap Success
				//print_r($result);
				
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
					//$desc = $result[details][detail]['!message'];
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
		
/*  				$status_code = $result['result']['!code'];
				$desc = $result['result']['!message'];
				$status = $result['result']['!status'];
				$details = $result['details'];
				$ref = $result['!reference'];  */
				
	/* 			if(strlen($status_code) == 0){
					$status_code = $result['!code'];
					$desc = $result['!message'];
				} */
				
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Delete Account', '$network_user', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
		
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Delete Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			}
		}
		
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
	}
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////


	public function getSessions($username,$parameter){
	
		require_once('lib/nusoap-get-sessions.php');
		//require_once('lib/nusoap-find.php');

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
	
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Sessions', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
	
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				$parameter => $username
			//	'USERNAME'      => $username
		);
	
	
	//	$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		$result = $client->call('getSessionRequest', $params, 'Aptilo-AC', 'http://soap.amazon.com');
	
		echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
		
		if ($client->fault) {
				
			$desc = $client->fault;
				
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Sessions', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Sessions', '$username', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
				//print_r($result);
	
	
				if(is_array($result[result])){
					$status_code = $result[result]['!code'];
					$desc = $result[result]['!message'];
					$status = $result[result]['!status'];
					$details = $result[result]['details'];
					$ref = $result[result]['!reference'];
						
					if(is_array($result[details][detail])){
						$desc = $result[details][detail]['!message'];
					}
				}else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
					$details = $result['details'];
					$ref = $result['!reference'];
				}
	

	
				$profile_string_final = '';
	
				$master_array = $result[responses][response];
				//print_r($master_array);
				$master_array_size = sizeof($master_array);
	
					
				$key_array_1 = array_keys($master_array);
	
	
	
				//	$key_array_value = '1';
				$key_array_value = strtoupper($key_array_1[0]);
	
				if($key_array_value == 'PARAMETER'){
						
					//echo $key_array_value;
	
					//	foreach ($master_array as $key_this => $obj){
						
					$obj = $master_array;
					$para_array = $obj['parameter'];
					//$group_array = $obj['group'];
						
					//print_r($para_array);
						
					$profile_string = '';
						
					for($i=0;$i<sizeof($para_array);$i++){
						$obj_name = $obj['parameter'][$i]['!name'];
						$obj_value = $obj['parameter'][$i]['!value'];
						$profile_string .= $obj_name.'='.$obj_value.'&';
					}
	
	
	

						
					//echo $profile_string;
					$profile_string_final .= $profile_string.'|';
					//	}
		
				}
	
	
				else{
	
					foreach ($master_array as $key_this => $obj){
	
						/* if main array has single element*/
						if(($master_array_size == 1)){
							$obj = $master_array;
						}
						/* if main array has single element*/
	
	
						$para_array = $obj['parameter'];
						//$group_array = $obj['group'];
	
						//print_r($para_array);
	
						$profile_string = '';
	
						for($i=0;$i<sizeof($para_array);$i++){
							$obj_name = $para_array[$i]['!name'];
							$obj_value = $para_array[$i]['!value'];
							$profile_string .= $obj_name.'='.$obj_value.'&';
						}
	
	
						$profile_string .='|';
						$profile_string_final .= $profile_string;
					}
				}
	

	

				//	echo $profile_string_final;
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Sessions', '$username', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				
				if(strlen($username)>0){
					$ex_1 = mysql_query($q_lo);
				}
				
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
		//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		//
	
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	

	
	
	
	
	
	
	
	
	public function delSessions($ses_id){
	
		require_once('lib/nusoap-del-sessions.php');
		//require_once('lib/nusoap-find.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
	
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Del Sessions', '$ses_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
	
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'ID'      => $ses_id
		);
	
	
		//	$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		$result = $client->call('deleteSessionRequest', $params, 'Aptilo-AC', 'http://soap.amazon.com');
	
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
	
		if ($client->fault) {
	
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Del Sessions', '$ses_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Del Sessions', '$ses_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
				//print_r($result);
	
				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
		

				//	echo $profile_string_final;	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Del Sessions', '$ses_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
		//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		//
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function disconnectUserSessions($user_name){
	
		require_once('lib/nusoap-disc-sessions.php');
		//require_once('lib/nusoap-find.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
	
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
	
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'AAA-User-Name'      => $user_name
		);
	
	
		//	$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		$result = $client->call('disconnectSessionRequest', $params, 'Aptilo-AC', 'http://soap.amazon.com');
	
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
	
		if ($client->fault) {
	
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
			//	print_r($result);
	
				if(is_array($result[result])){
					$status_code = $result['result']['!code'];
					if(is_array($result['details'])){
						$desc = $result['details']['detail']['!message'];
					}
					else{
						$desc = $result['result']['!message'];
					}
					//$desc = $result['result']['!message'];
					$status = $result['result']['!status'];					
				}
				else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
				}
				

	
	
				//	echo $profile_string_final;
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
		//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		//
	
	}	
	
	
	
	
	
	
	
	
	
	
	public function disconnectDeviceSessions($user_name){
	
		require_once('lib/nusoap-disc-sessions.php');
		//require_once('lib/nusoap-find.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ACC_LOGIN'),$this->network('ACC_PASS'),'basic');
	
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
	
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'USERNAME'      => $user_name
		);
	
	
		//	$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		$result = $client->call('disconnectSessionRequest', $params, 'Aptilo-AC', 'http://soap.amazon.com');
	
		//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
	
		if ($client->fault) {
	
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
				// Soap Success
			//print_r($result);
	
/* 				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				 */
				if(is_array($result[result])){
					$status_code = $result['result']['!code'];
					if(is_array($result['details'])){
						$desc = $result['details']['detail']['!message'];
					}
					else{
						$desc = $result['result']['!message'];
					}
					$status = $result['result']['!status'];
				}
				else{
					$status_code = $result['!code'];
					$desc = $result['!message'];
					$status = $result['!status'];
				}
	
	
				//	echo $profile_string_final;
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	
		//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		//
	
	}	
	
	
	
	
	
	
	


}
?>