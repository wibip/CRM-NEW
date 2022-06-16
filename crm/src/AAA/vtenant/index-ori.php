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


		$this->url = $this->network('api_base_url');
		
	
	}

	
	
	
	
	public function network($parameter) {
	
	 	//$query = "SELECT settings_value FROM mdu_settings WHERE settings_code = '$parameter' LIMIT 1";

        $query = "SELECT $parameter AS val FROM mdu_network_profile p WHERE p.network_profile='mdu_vtenant'";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$result = $row['val'];
		}
		return $result;
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function masterAcc($username,$password,$organization,$first_name,$last_name,$email,$mobile_number,$user_data_string,$product,$validity_time){


		$tz_object = new DateTimeZone($this->network('api_time_zone'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		$datetime->add(new DateInterval('PT'.$validity_time.'S'));
		$enddate = $datetime->format('Y-m-d H:i:s');
	
		$differenceInSeconds = strtotime($enddate) - $begindate;
		
		
		require_once('lib/nusoap.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Create Account', '$username','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		//echo $secret_question;
		//echo $secret_answer;
		
		

		if(isset($vlan_id)){

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
                'ispremium' => $this->network('premium_feature'), //'false'
                'VT-Vlan-Id' => $vlan_id
            );
        }else{

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
                'ispremium' => $this->network('premium_feature') //'false'
            );
        }
		
		
		
		$credits_array = array(
		
				'Bucket-1'      => '1000000000000000'
		);
		
		
		$product_list = explode(',',$product/*$this->network('PRODUCT')*/);
		
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
				'Account-State' => $this->network('master_account_status'),//'Inactive', // Active or Inactive
				'MSISDN' => $mobile_number,
				'Email' => $email,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				
			//	'First-Access'     => '0',
			 //	'Last-Access'     => '0',
			 
			    'Service-Profiles' => $srvice_profile_array, //$this->network('PRODUCT'),
				'User-Data' => $user_date_array,//$user_data_string,
				'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
				'Credits' => $credits_array,  //'Bucket-1=1',
				'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
				'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
				'PAS-Password-Secret-Answer' => $secret_answer,
				'PAS-Password-Secret-Question' => $secret_question,
				'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
				'Valid-From'    => $begindate,	// 1415092796.2
				'Valid-Until'   => $enddate,
				'Validity-Time' => $validity_time //$this->network('1000000')
			//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))

		);
		
		
		
		
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		if ($client->fault) {
			
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Create Account', '$username','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */

		}
		
		else {
			

				
			$err = $client->getError();
			if ($err) {
				
			
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Create Account', '$username','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
          		VALUES ('Create Account', '$username', '$u_id','$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlanid=NULL){
	
	
		$tz_object = new DateTimeZone($this->network('api_time_zone'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		//$datetime->add(new DateInterval('P1M'/*$this->network('SUB_ACC_TIMEGAP_MINUTES')*/));
		//$enddate = $datetime->format('Y-m-d H:i:s');
	
	
	
		require_once('lib/nusoap.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Add Device', '$mac','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
	
		$srvice_profile_array = array(

            $this->network('sub_product')      => 'true'
		);


    $client->setUseCurl($useCURL);
		// This is an archaic parameter list

    if(is_null($vlanid)){
      $params = array(
				'Password'      => $mac, //copy="true"
				'User-Name'     => $mac,
				'Master-Account' => $username,
				'Group' => $organization, //'MSISDN', //copy="true"
				'Account-State' => $this->network('sub_account_status'),//'Active',
				'MSISDN' => $mobile_number,// This is equal to MAC => $mac,
				'Email' => $email,
				//'Validity-Time' => urlencode($this->network('TIME_LEFT')),
				'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
				'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
				'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
				//'First-Access'     => $begindate,
				//'Last-Access'     => $begindate,
				'Service-Profiles' => $srvice_profile_array,
        
				//	'Service-Profiles' => urlencode($this->network('PRODUCT')),
				//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
		);
    }else{
    
    $user_date_array = array(

            'VT-Vlan-Id' => $vlanid,
        );
      $params = array(
				'Password'      => $mac, //copy="true"
				'User-Name'     => $mac,
				'Master-Account' => $username,
				'Group' => $organization, //'MSISDN', //copy="true"
				'Account-State' => $this->network('sub_account_status'),//'Active',
				'MSISDN' => $mobile_number,// This is equal to MAC => $mac,
				'Email' => $email,
				//'Validity-Time' => urlencode($this->network('TIME_LEFT')),
				'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
				'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
				'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
				//'First-Access'     => $begindate,
				//'Last-Access'     => $begindate,
				'Service-Profiles' => $srvice_profile_array,
                'User-Data' => $user_date_array,
				//	'Service-Profiles' => urlencode($this->network('PRODUCT')),
				//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
		);
    }

        
	
		
		
	
	
	
	
	
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
	
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
	
	
		if ($client->fault) {
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Add Device', '$mac','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Add Device', '$mac','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Add Device', '$mac','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Account', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		
		if ($client->fault) {
		
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Account', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				
				$desc = $client->getError();
					$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Account', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Account', '$email','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
	
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	public function resetPassword($email,$password){
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,unique_id,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Password', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);
	
	
	
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
	
		if(strlen($password)>0){
			$params_update['Password'] = $password;
		}
	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$email,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');



        $request_html = $client->request;
        $response_html = $client->response;
        $advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
        $advanced_log_ex= mysql_query($advanced_log);

        
        if ($client->fault) {
	
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,unique_id,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Modify Password', '$email', '$u_id','', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,unique_id,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Password', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
			
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
	
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,unique_id,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Modify Password', '$email','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	public function AUP_Activate($email){
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Reconnect User', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Reconnect User', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Reconnect User', '$email','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Reconnect User', '$email','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		//$client->setCredentials('admin','admin','basic');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');
        //echo $this->network('api_login').$this->network('api_password').'88';
		
		$err = $client->getError();
		if($err) {
		
			$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Search Users', '$search_string_log','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Search Users', '$search_string_log','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Search Users', '$search_string_log','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
								$profile_string .= 'Service-Profiles='.$sub_group_array['!name'].'&';
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
								$profile_string .= 'Service-Profiles='.$sub_group_array['!name'].'&';
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
				
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Search Users', '$search_string_log','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');
	
	
		$err = $client->getError();
		if ($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Devices', '$master_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
	
	
	
		$client->setCredentials($this->network('api_login'),$this->network('api_password'));
		if ($client->fault) {
				
			$desc = $client->fault;
				
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Get Devices', '$master_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Devices', '$master_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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

						$group_array = $obj['group'];


						for($i=0;$i<sizeof($group_array);$i++){
							$obj_name = $obj['group'][$i]['parameter']['!name'];
							$obj_value = $obj['group'][$i]['parameter']['!value'];
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

					$group_array = $master_array['group'];


					for($i=0;$i<sizeof($group_array);$i++){
						$obj_name = $master_array['group'][$i]['parameter']['!name'];
						$obj_value = $master_array['group'][$i]['parameter']['!value'];
						$profile_string .= $obj_name.'='.$obj_value.'&';


					}
					$profile_string_final .= $profile_string.'|';
	
	
	
				}
	
	

				/* Profile Data Formatting XML to Text */
	
				//echo $profile_string_final;
	
	
				//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Get Devices', '$master_user','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
					$u_id = rand(1,9).uniqid().rand(1111,9999);
	
					$err = $client->getError();
					if($err) {
	
					$desc = $client->getError();
					$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
							VALUES ('Delete Account', '$network_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
	
					$request_html = $client->request;
					$response_html = $client->response;
					$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
					VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
					$advanced_log_ex= mysql_query($advanced_log);
	
	
					if ($client->fault) {
	
						$desc = $client->fault;
	
						$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
								VALUES ('Delete Account', '$network_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
						$ex_1 = mysql_query($q_lo);
	
						return 'status=failed&status_code=1021&Description=SOAP Eror';
						/* SOAP Fault Error */
					}
	
					else {
	
						$err = $client->getError();
						if ($err) {
	
							$desc = $client->getError();
							$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
									VALUES ('Delete Account', '$network_user','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
							$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
									VALUES ('Delete Account', '$network_user','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
	
	
	
	
	
	
	
	/*
	
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
			
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Delete Account', '$network_user', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
				
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				
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
		

				
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Delete Account', '$network_user', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
		
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Delete Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					
				}
		
			}
		}
		
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
	}
	
	*/
	////////////////////////////////////////////////////////////////////////
	public function disconnectDeviceSessions($user_name){

		require_once('lib/nusoap-disc-sessions.php');
		//require_once('lib/nusoap-find.php');

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');

		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$err = $client->getError();
		if($err) {

			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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



		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);

		if ($client->fault) {

			$desc = $client->fault;

			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);


			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}

		else {

			$err = $client->getError();
			if ($err) {

				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name', '$u_id','$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	public function disconnectUserSessions($user_name){
		require_once('lib/nusoap-disc-sessions.php');
		//require_once('lib/nusoap-find.php');

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');

		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$err = $client->getError();
		if($err) {

			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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


		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);


		if ($client->fault) {

			$desc = $client->fault;

			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);


			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}

		else {

			$err = $client->getError();
			if ($err) {

				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions','$user_name','$u_id', '', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`)
						VALUES ('Disconnect User Sessions', '$user_name','$u_id', '$status_code', '%s', 'API', NOW())",  mysql_real_escape_string($desc));
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
	//////////////////////////////////////////////////////////////////////////

	
	
	


}
?>
