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



include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/systemPackageClass.php');
$db = new db_functions();


//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');





class network_functions
{
	private $system_package;
	public function __construct($network_name,$access_method,$system_package)
	{
		$db_class = new db_functions();

		$this->lib_name= $network_name; 
		$this->system_package = $system_package;
		$this->networkArr = $this->initialConfig($this->lib_name);

		$this->url = $this->network('api_base_url');
		$this->ses_url = $this->network('ses_base_url');
		$this->auth_token = $this->network('api_acc_org');
		
		
	
	}

	
	private function initialConfig($network){

		$query = "SELECT * FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

		$query_results=mysql_query($query);
		$isDynamic = package_functions::isDynamic($this->system_package);
		$row = mysql_fetch_array($query_results);
		if($isDynamic){
			$q="SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$this->system_package'";
			$qr=mysql_query($q);
			$qra=mysql_fetch_assoc($qr);
			$qraj = json_decode($qra['settings'],true); 
			$row['api_master_acc_type'] = $qraj['aaa_configuration']['AAA_PRODUCT_OWNER']['options'];
			$row['api_login'] = $qraj['aaa_configuration']['AAA_USERNAME']['options'];
			$row['api_password'] = $qraj['aaa_configuration']['AAA_PASSWORD']['options'];
			$row['api_acc_profile'] = $qraj['aaa_configuration']['AAA_TENANT']['options'];
		}
		return $row;
	}
	
	
	public function network($parameter) {

		$networkArr = $this->networkArr;
		return $networkArr[$parameter];

       /*  $query = "SELECT $parameter AS val FROM exp_network_profile p WHERE p.network_profile='$this->lib_name'";
        $query_results=mysql_query($query);
        while($row=mysql_fetch_array($query_results)){
           $result = $row['val'];
        }
        return $result; */
		
	}

	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null){
		/*  $query = "INSERT INTO `exp_aaa_logs`
		(`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id,`unixtimestamp`)
		VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'VTENANT','$group_id',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */
		
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

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
	}

	public function lognew($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$realm=null,$mac=null){
        /* $query = "INSERT INTO `exp_session_profile_logs`
        (`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,`realm`,`mac`,`unixtimestamp`)
        VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'VTENANT','$realm','$mac',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */
		
		$log = Logger::getLogger()->getObjectProvider()->getObjectSession();

		//$log->

		$log->setFunction($function);
		$log->setFunctionName($function_name);
		$log->setDescription($description);
		$log->setApiMethod($method);
		$log->setApiStatus($api_status);
		$log->setApiDescription($api_details);
		$log->setApiData($api_data);
		$log->setRealm($realm);
		$log->setmac($mac);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
    }
	
	 public function getUserName($realm,$user_name,$append_realm,$ref_number=null){
        //$macc= str_replace('-','',$mac);
        if($append_realm == '1'){
            return $user_name.'/'.$realm;
        }
        else{
            return $user_name;
        }

    }

    public function getMacName($realm,$mac,$append_realm,$ref_number=null){
		 $macc= str_replace('-','',$mac);
		 if($append_realm == '1'){
		  return $macc.'/'.$realm;
		 }
		 else{
		  return $macc;
		 }
		  
		}	
	
	
	////////////////////////////////////////////////////////////////////////


	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time,$country,$address,$state,$city,$zip,$secret_question,$secret_answer,$vlan_id){
	

		//echo $this->network(`api_time_zone`);
		$tz_object = new DateTimeZone($this->network('api_time_zone'));
								
		$datetime = new DateTime(null,$tz_object);

		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));

		$validity_time_code = 'PT'.$validity_time.'S';
		$datetime->add(new DateInterval($validity_time_code));
		
		//$datetime->add(new DateInterval($this->network('MASTER_ACC_TIMEGAP_MINUTES')));
		$enddate = $datetime->format('Y-m-d H:i:s');
	
		$differenceInSeconds = strtotime($enddate) - $begindate;
		
		require_once('lib/nusoap.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();

		$this->log($username,__FUNCTION__, 'Create Account', $url2, 'POST', '1022', mysql_escape_string($body), $jsonDataEncoded,$organization);

			
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
				'Account-State' => 'Active',//'Inactive', // Active or Inactive
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
			//	'Validity-Time' => $this->network('VALIDITY_TIME')
				'Validity-Time' => $validity_time
			//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))

		);
		
		
		
		
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$this->log($username,__FUNCTION__, 'Create Account', '', 'POST', '1021', mysql_escape_string($body), $params,$organization);

			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */

		}
		
		else {
			

				
			$err = $client->getError();
			if ($err) {
				
			
				$desc = $client->getError();
				$this->log($username,__FUNCTION__, 'Create Account', $url2, 'POST', '1021', mysql_escape_string($params), $jsonDataEncoded,$organization);

				
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

				$this->log($username,__FUNCTION__, 'Create Account', $url2, 'POST', $status_code, $client->response, $client->request,$organization);
//print_r($params);
				
				
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
	
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
	
		$tz_object = new DateTimeZone($this->network('api_time_zone'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		//$datetime->add(new DateInterval($this->network('SUB_ACC_TIMEGAP_MINUTES')));
		//$enddate = $datetime->format('Y-m-d H:i:s');
	

	
		require_once('lib/nusoap.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', '1022', 'Soap Constructor Error', $jsonDataEncoded,$organization);

		
		
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$srvice_profile_array = array(
		
				//'Aptilo-WiFi-Account-Charge-Master-SP'      => 'true'
				$this->network('sub_product')      => 'true'
		);
		
		
		if(is_null($vlan_id)){

			$params = array(
                'Password'      => $mac, //copy="true"
                'User-Name'     => $mac,
                'Master-Account' => $username,
                'Group' => $organization, //'MSISDN', //copy="true"
                'Account-State' => 'Active',
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

                'VT-Vlan-Id' => $vlan_id,
            );

            $params = array(
                'Password'      => $mac, //copy="true"
                'User-Name'     => $mac,
                'Master-Account' => $username,
                'Group' => $organization, //'MSISDN', //copy="true"
                'Account-State' => 'Active',
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
                'User-Data' => $user_date_array,//$user_data_string,
                //	'Service-Profiles' => urlencode($this->network('PRODUCT')),
                //	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
            );
        }


        $client->setUseCurl($useCURL);
		// This is an archaic parameter list

		
		//print_r( $params );
		//exit();
		$result = $client->call('createAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			$desc = $client->fault;
			$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', '1021', $response_html, $request_html,$organization);

			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', '1021', $desc, $request_html,$organization);

			
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
				
				$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', $status_code, $response_html, $request_html,$organization);


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
	
	
	
	
	public function modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string){
		//echo "string";

		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', '1022', 'Soap Constructor Error', $jsonDataEncoded,$organization);

		
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
		
		
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$cust_uname,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
		
			$desc = $client->fault;
			$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', '1021', $desc, $request_html,$organization);

			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				
				$desc = $client->getError();
				$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', '1021', $response_html, $request_html,$organization);

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
		
				$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $response_html, $request_html,$organization);


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
	public function removeProfile($user_name){
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Remove Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);

		$params_update = array(
	
				'Service-Profiles' => 'REMOVE|',
				//'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);
	

		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
	
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
	
	
		if ($client->fault) {
	
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Remove Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Remove Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);
	
				return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				/* SOAP Fault Error */
			}
	
			else {
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
	
	
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Remove Service Profile', '$user_name','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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

	////////////////////////////////////////////////////////
	
	
	public function modifyProfile($user_name,$product_list){
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
				
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Modify Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
				//'Service-Profiles' => 'REMOVE|',
				'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		if ($client->fault) {
	
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Modify Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Modify Service Profile', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	

	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Modify Service Profile', '$user_name','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	

	
	////////////////////////////////////////////////////////
	
	
	public function modifyValidityTime($user_name,$validity_time){
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Modify Validity Time', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
	
		$client->setUseCurl($useCURL);
	

	
	
		$params_update = array(
	
				//'Service-Profiles' => 'REMOVE|',
				'Validity-Time' => $validity_time //$this->network('PRODUCT'),
		);
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
	
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
	
	
		if ($client->fault) {
	
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Modify Validity Time', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Modify Validity Time', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Modify Validity Time', '$user_name','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
	////////////////////////////////////////////////////////
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	////////////////////////////////////////////////////////
	
	
	public function AUP($user_name,$user_message_text,$aup_message_text){
		
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$aup_text_log = $user_name.', AUP Message = '.$aup_message_text;

		$err = $client->getError();
		if ($err) {
		
			$desc = $client->getError();
			$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
			
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
		
		
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, mysql_escape_string($response_html), $request_html,$organization);

			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, mysql_escape_string($response_html), $request_html,$organization);
				
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
				
				
		
				$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, mysql_escape_string($response_html), $request_html,$organization);
				
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
	
	public function AUP_Activate($user_name){
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
	
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
	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
	
			$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
			$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
				
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
	
				$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
	
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
	
	public function UserMessage($user_name,$user_message_text){
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		
		$user_message_log = $user_name.', usermessage = '.$user_message_text;
	
		$err = $client->getError();
		if ($err) {
			
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('User Message', '$user_message_log','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
		$result = $client->call('updateAccountRequest', $params_update,'User-Name',$user_name,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('User Message', '$user_message_log','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('User Message', '$user_message_log','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('User Message', '$user_message_log','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function findUsers($search_parameter1, $group, $term1){
	

/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsers',
				$search_parameter1 => urlencode($term1)
		);
	 */
		//return $fields;
		
		$search_string_log = $search_parameter1.' = '.$term1;
	
		require_once('lib/nusoap-find.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');
		
		
		$err = $client->getError();
		if($err) {
		
			$desc = $client->getError();
			$this->log($term1,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$realm);
			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1,
				//'Account-State'      => 'Inactive'

		);
		
		
		$sync_limit = 1000;
		
		
		$result = $client->call('getAccountRequest', $params, $sync_limit, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		
		$request_html = $client->request;
		$response_html = $client->response;
				
		
		if ($client->fault) {
			$this->log($term1,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $response_html, $request_html,$realm);

			
			$desc = $client->fault;
					
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$this->log($term1,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $response_html, $request_html,$realm);
				
				
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
				
				if($key_array_value == 'PARAMETER'|| $key_array_value== 'GROUP'){
					
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
					//print_r($master_array);
					//echo $master_array_size;
					foreach ($master_array as $key_this => $obj){
						
						/* if main array has single element*/
						if(($master_array_size == 1)){
							$obj = $master_array;
						}
						/* if main array has single element*/
	
						
						$para_array = $obj['parameter'];
						$group_array = $obj['group'];
						
						//print_r($obj);
						
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
				//for($i=1;$i<12;$i++){
				//$profile_string_final=$profile_string_final.'LLL'.$profile_string_final;
				//}
				$res_arr = array();
				$res_arr3 = array();
				//print_r($response_html);
				if (!empty($profile_string_final)) {
					        $single_profile_data = explode('|', $profile_string_final);
					        for($k=0;$k<sizeof($single_profile_data);$k++){
					        	  parse_str($single_profile_data[$k],$array_get_profile_value);
					        	   $Master_Name = $array_get_profile_value['Master-Account'];
					        	   if (strlen($Master_Name)<1) {
					        	   	array_push($res_arr, $array_get_profile_value);
					        	   				//print_r($array_get_profile_value);
					        	   						        }

					        }

        		}
        
				
				$this->log($term1,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $response_html, $request_html,$term1);
				
				
				if($status_code == '200'){
		        $json1 = array('status_code' => $status_code,
		                            'status' => 'success',
		                            'Description'=>'');
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
		}
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	//	
		
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	






	public function findMasterUsers($search_parameter1, $term1,$search_parameter2, $term2,$property=null){


/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsers',
				$search_parameter => urlencode($term)
		);
	 */
		//return $fields;

		$search_string_log1 = $search_parameter1.' = '.$term1;
		$search_string_log2 = $search_parameter2.' = '.$term2;

        $log_string=$search_string_log1."-".$search_string_log2;

		require_once('lib/nusoap-find.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');


		$err = $client->getError();
		if($err) {

			$desc = $client->getError();
			$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($response_html), $request_html,$property);


			$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
	        		$encoded2=json_encode($json2);
					 return $encoded2;			/* SOAP Constructor Error */
		}


		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1
				//$search_parameter2      => $term2
				//'Account-State'      => 'Inactive'

		);
        $params2 = array(
				$search_parameter2      => $term2

		);


		$sync_limit = $this->network('record_limit');//1000;


		$result = $client->callParms('getAccountRequest', $params,$params2, $sync_limit, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');



		$request_html = $client->request;
		$response_html = $client->response;
		


		if ($client->fault) {

			$desc = $client->fault;

			$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($response_html), $request_html,$property);



			$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
	        		$encoded2=json_encode($json2);
					 return $encoded2;			/* SOAP Fault Error */
		}

		else {

			$err = $client->getError();
			if ($err) {

				$desc = $client->getError();
				$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($response_html), $request_html,$property);



			$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
	        		$encoded2=json_encode($json2);
					 return $encoded2;				/* SOAP Fault Error */
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
				//for($i=1;$i<12;$i++){
				//$profile_string_final=$profile_string_final.'LLL'.$profile_string_final;
				//}


				$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($response_html), $request_html,$property);

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
		}

	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	//

	}



	////////////////////////////////////////////////////////////////////////


    public function findMasterUsersByParams($search_parameter1, $term1,$search_parameter2, $term2,$search_parameter3, $term3){


        /* 		$fields = array(
                        'login' => urlencode($this->network('ACC_LOGIN')),
                        'pwd' => urlencode($this->network('ACC_PASS')),
                        'method' => 'findUsers',
                        $search_parameter => urlencode($term)
                );
             */
        //return $fields;

        $search_string_log1 = $search_parameter1.' = '.$term1;
        $search_string_log2 = $search_parameter2.' = '.$term2;
        $search_string_log3 = $search_parameter3.' = '.$term3;

        $log_string=$search_string_log1."/".$search_string_log2."/".$search_string_log3;

        require_once('lib/nusoap-find.php');
        $u_id = rand(1,9).uniqid().rand(1111,9999);

        $useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $client = new nusoap_client("$this->url", false,'', '', '', '');
        $client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');


        $err = $client->getError();
        if($err) {

            $desc = $client->getError();
            $q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Search Users', '$log_string','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
            $ex_1 = mysql_query($q_lo);

            return 'status=failed&status_code=1022&Description=Soap Constructor Error';
            /* SOAP Constructor Error */
        }


        $client->setUseCurl($useCURL);
        // This is an archaic parameter list
        $params = array(

            $search_parameter1      => $term1


        );
        $params2 = array(
            $search_parameter2      => $term2,
            $search_parameter3      => $term3,
        );


        $sync_limit = $this->network('record_limit');//1000;


        $result = $client->callParms('getAccountRequest', $params,$params2, $sync_limit, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');



        $request_html = $client->request;
        $response_html = $client->response;
        $advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
        $advanced_log_ex= mysql_query($advanced_log);


        if ($client->fault) {

            $desc = $client->fault;

            $q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Search Users', '$log_string','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
            $ex_1 = mysql_query($q_lo);


            return 'status=failed&status_code=1021&Description=SOAP Eror';
            /* SOAP Fault Error */
        }

        else {

            $err = $client->getError();
            if ($err) {

                $desc = $client->getError();
                $q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Search Users', '$log_string','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
                //for($i=1;$i<12;$i++){
                //$profile_string_final=$profile_string_final.'LLL'.$profile_string_final;
                //}


                $q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Search Users', '$log_string','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
//////////////////////////////////////////////////////////////////////////////
	public function checkMasterAccount($master_user){
	
	
/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsersByMaster',
				'master' => urlencode($master_user)
		); */
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		//return $fields;
		require_once('lib/nusoap-find.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');
		
		
		$err = $client->getError();
		if ($err) {
		
			$desc = $client->getError();
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1022', 'Soap Constructor Error', '',$organization);

			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		//$sync_limit = 500'//$this->network('record_limit');
		$result = $client->call('getAccountRequest', $params, 10000, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		//$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1022', 'SOAP Error', $request_html ,$organization);

			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1021', 'SOAP Fault Error', $request_html ,$organization);

				
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
				//print_r($master_array); echo '<br>';

				
				
				
				
				$master_array_size = sizeof($master_array);	

				$key_array_1 = array_keys($master_array);
				
				//print_r($key_array_1);
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

					$grou_array = $master_array['group'];
										
					for($i=0;$i<sizeof($grou_array);$i++){
						$obj_name = $master_array['group'][$i]['parameter']['!name'];
						$obj_value = $master_array['group'][$i]['parameter']['!value'];
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
				$single_profile_data = explode('|', $profile_string_final);

				
				
				//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET',$status_code, $response_html, $request_html ,$organization);

				
				if($status_code == '200'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$desc);
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
		}
		
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	//	
	}


//////////////////////////////////////////////////////////////////////////////
	public function findUsersByMaster($master_user){
	
	
/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsersByMaster',
				'master' => urlencode($master_user)
		); */
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		//return $fields;
		require_once('lib/nusoap-find.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->url", false,'', '', '', '');
		$client->setCredentials($this->network('api_login'),$this->network('api_password'),'basic');
		
		
		$err = $client->getError();
		if ($err) {
		
			$desc = $client->getError();
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1022', 'Soap Constructor Error', '',$organization);

			
			return 'status=failed&status_code=1022&Description=Soap Constructor Error';
			/* SOAP Constructor Error */
		}
		
		
		$client->setUseCurl($useCURL);
		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		//$sync_limit = 500'//$this->network('record_limit');
		$result = $client->call('getAccountRequest', $params, 10000, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		//$result = $client->call('getAccountRequest', $params, 'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		
		
		if ($client->fault) {
			
			$desc = $client->fault;
			
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1022', 'SOAP Error', $request_html ,$organization);

			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
				$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET', '1021', 'SOAP Fault Error', $request_html ,$organization);

				
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
				//print_r($master_array); echo '<br>';

				
				
				
				
				$master_array_size = sizeof($master_array);	

				$key_array_1 = array_keys($master_array);
				
				//print_r($key_array_1);
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

					$grou_array = $master_array['group'];
										
					for($i=0;$i<sizeof($grou_array);$i++){
						$obj_name = $master_array['group'][$i]['parameter']['!name'];
						$obj_value = $master_array['group'][$i]['parameter']['!value'];
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
				$res_arr = array();
				$res_arr3 = array();

				if (!empty($profile_string_final)) {
					        $single_profile_data = explode('|', $profile_string_final);
					        for($k=0;$k<sizeof($single_profile_data);$k++){
					        	  parse_str($single_profile_data[$k],$array_get_profile_value);
					        	   $Master_Name = $array_get_profile_value['Master-Account'];
					        	   //if (strlen($Master_Name)<1) {
					        	   	array_push($res_arr, $array_get_profile_value);
					        	   				//print_r($array_get_profile_value);
					        	   						       // }

					        }

        		}

				
				
				//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
				//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
			$this->log($master_user,__FUNCTION__, 'Get Account', $url2, 'GET',$status_code, $response_html, $request_html ,$organization);

				
				if($status_code == '200'){
				$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$res_arr);
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
			$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', '1022', mysql_escape_string($body), '',$organization);

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
			
			$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', '1021', mysql_escape_string($response_html), $request_html,$organization);
			
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
		
		else {
		
			$err = $client->getError();
			if ($err) {
				
				$desc = $client->getError();
		$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', '1021', mysql_escape_string($body), '',$organization);

				
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
				
				$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', $status_code, mysql_escape_string($response_html), $request_html,$organization);
		
		
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
	public function getSessionsbymac($username,$params){

		$groups=explode('/', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		if (empty($organization)) {
			$organization=$groups[$a];
		}

	
		require_once('lib/nusoap-get-sessions.php');
		//require_once('lib/nusoap-find.php');

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ses_full_username'),$this->network('ses_full_password'),'basic');
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;
		
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', '1021',mysql_escape_string($body), '' ,$username,$organization);

				
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
	
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
		
		$request_html = $client->request;
		$response_html = $client->response;

				
		
		
		if ($client->fault) {
				
			$desc = $client->fault;
			$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', '1021',mysql_escape_string($response_html), $request_html ,$username,$organization);
				
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', '1021',mysql_escape_string($response_html), $request_html ,$username,$organization);
	
	
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
	
			$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', $status_code,mysql_escape_string($response_html), $request_html ,$username,$organization);
				
				
		if($Access_Profile==FULL || $Access_Profile==REDIRECT){
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
		}
	
		//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		//
	

	}

	
	
	
	
	
	////////////////////////////////////////////////////////////////////////


	public function getSessions($username,$parameter){
	
		require_once('lib/nusoap-get-sessions.php');
		//require_once('lib/nusoap-find.php');

		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ses_new_user_name'),$this->network('ses_new_password'),'basic');
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;
		
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Get Sessions', '$search_term','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		
		if ($client->fault) {
				
			$desc = $client->fault;
				
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Get Sessions', '$search_term','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
				
				
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Get Sessions', '$search_term','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Get Sessions', '$search_term','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
				
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
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ses_new_user_name'),$this->network('ses_new_password'),'basic');
	
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Del Sessions', '$ses_id','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
		
		$request_html = $client->request;
		$response_html = $client->response;
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
		
		
		if ($client->fault) {
	
			$desc = $client->fault;
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Del Sessions', '$ses_id','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Del Sessions', '$ses_id','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Del Sessions', '$ses_id','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
		$client->setCredentials($this->network('ses_new_user_name'),$this->network('ses_new_password'),'basic');
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Disconnect User Sessions','$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Disconnect User Sessions', '$user_name','$u_id', '$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
				$ex_1 = mysql_query($q_lo);

                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			}
		}
	

		//
	
	}	
	
	
	
	
	
	
	
	
	
	
	public function disconnectDeviceSessions($token,$user_name){
	
		require_once('lib/nusoap-disc-sessions.php');
		//require_once('lib/nusoap-find.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client("$this->ses_url", false,'', '', '', '');
		$client->setCredentials($this->network('ses_new_user_name'),$this->network('ses_new_password'),'basic');
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$err = $client->getError();
		if($err) {
	
			$desc = $client->getError();
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
			$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
					VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
			$ex_1 = mysql_query($q_lo);
	
	
			return 'status=failed&status_code=1021&Description=SOAP Eror';
			/* SOAP Fault Error */
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
	
				$desc = $client->getError();
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Disconnect User Sessions', '$user_name','$u_id', '', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
				$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
						VALUES ('Disconnect User Sessions', '$user_name', '$u_id','$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
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
	
	
	//////////////////////////////
	
	
	public function startSession($parameter_array){
	
		$mac = $parameter_array['mac'];
		$url = $parameter_array['url'];
		$token = $parameter_array['token'];
		$group = $parameter_array['group'];
	
		//$group = 'bi';
	
		//$token_id = $this->getToken($mac);
	
		$group = $group;//$this->getGroup($token_id);
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		// get Variables
		$ses_base_url = $this->network($this->ses_url);
	
		// Operation
		$network_URL = $url;
	
	
	
		require_once('lib/nusoap_ses_start.php');
	
		$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
		$client = new nusoap_client($this->ses_url, false,'', '', '', '');
	
		$err = $client->getError();
		if ($err) {
	
			$status_wag = 1022;			// SOAP Constructor Error
		}
	
		$client->setUseCurl($useCURL);
	
		$params_update = array(
	
				'User-Name'    => $mac,
				'Password'     => $mac,
	
		);
	
	
		//print_r($params_update);
	
		$sndmacex= explode("/",$mac);
	
		$sndmac=$sndmacex[1];
		
		//$sndmac='eeeeeeeeeeee';
	
		$result = $client->call('loginRequest', $params_update,'Session-MAC',$sndmac,'Aptilo-WiFi-Account-DB', 'http://soap.amazon.com');
	
		//$request_html1 = '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		//$response_html1= '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
		$request_html =  $client->request;
		$response_html=  $client->response;
	
	
		/*	$myFile4 = "../API/log/ale_session.txt";
		 $fh = fopen($myFile4, 'a') or die("can't open file");
		 $header = 'Request '.$client->request.' Response '.$client->response.'|';
		 fwrite($fh, $header); */
	
	
		if ($client->fault) {
	
			//return 'status=failed&status_code=1021&Description=SOAP Eror';
			$status_wag = 1021;
			//SOAP Fault Error
	
		}
	
		else {
	
			$err = $client->getError();
			if ($err) {
				//return 'status=failed&status_code=1021&Description=SOAP Fault Eror';
				$status_wag = 1021;// SOAP Fault Error
			}
	
			else {
				// Soap Success
	
				$status_code = $result['!code'];
				$desc = $result['!message'];
				$status = $result['!status'];
				$details = $result['details']['detail']['!message'];
				$status_code = $result['details']['detail']['!code'];
	
				//$status_code = 200;
				if($status_code == '200'){
					$status_wag = 200;
	
					//return 'status=success&status_code='.$status_code.'&Description=Account Modified Success - '.$status_code;
	
				}
				else{
					$status_wag = 1021;
					//return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					// SOAP Parameter Error
				}
	
			}
		}
	
	
	
		$return_array = array(
				'status'     => $status_wag,
				'description'     => $details.' ('.$status_code.')',
		);
	
		//$this->log(__FUNCTION__, 'Session Start', $this->ses_url, 'SOAP', $status_wag, $client->response, $client->request,$group,$mac);
	
		$q_lo = sprintf("INSERT INTO `mdu_network_logs` (`function`,`reference`,`unique_id`,`status`,`status_description`,`create_user`,`create_date`,`portal`)
				VALUES ('Start Session', '$mac', '$u_id','$status_code', '%s', 'API', NOW(),'mdu')",  mysql_real_escape_string($desc));
		$ex_1 = mysql_query($q_lo);
	
	
		$advanced_log = "INSERT INTO `mdu_network_logs_detail` (`unique_id`,`request`,`response`,`create_date`,`create_user`)
		VALUES ('$u_id','$request_html','$response_html',now(),'LOG')";
		$advanced_log_ex= mysql_query($advanced_log);
	
	
		return 'status='.$status_wag.'&status_code='.$status_code.'&Description='.$details ;
	}
	
	
	
	


}
?>
