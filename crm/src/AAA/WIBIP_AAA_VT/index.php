<?php

include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../classes/dbClass.php');

require_once dirname(__FILE__).'/../../LOG/Logger.php';



class network_functions

{

	public function __construct($network_name)

	{


		$this->network_name = $network_name;


	}

	public function getConfig($field)

	{



		$profile_name = $this->profile_name;

		$query = "SELECT $field AS f FROM exp_wag_ap_profile WHERE wag_ap_name = '$profile_name' LIMIT 1";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){

			return $row['f'];
		}
	}

	public function getNetworkConfig($field)

	{

		$network = $this->network_name;
		
		$query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			return $row['f'];
		}



	}

	public function getUserName($realm,$mac,$guest_private,$ref_number=null){
		$macc= str_replace('-','',$mac);
		if($guest_private == 'PRIVATE'){
		 return $macc.'@'.$realm;
		}
		else{
		 return $macc.'@'.$realm;
		}
		
	}

	public function lognew($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$realm=null,$mac=null){
        /* $query = "INSERT INTO `exp_session_profile_logs`
        (`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,`realm`,`mac`,`unixtimestamp`)
        VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API','$realm','$mac',UNIX_TIMESTAMP())";
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
		$log->getRealm($realm);
		$log->getmac($mac);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
    }

	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$organization){
		/* $query = "INSERT INTO `exp_aaa_logs`
		(`username`,`group_id`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`, `unixtimestamp`)
		VALUES ('$aaa_username','$organization','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API', UNIX_TIMESTAMP())";
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



	public function jsonPost($url, $jsonData, $action,$auth_token)
	{
		$ch = curl_init($url);

		$jsonDataEncoded = json_encode($jsonData);


		switch ($action) {

			case "POST":

				if (empty($auth_token)) {
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
				}
				else{
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization:Bearer '.$auth_token));
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
				}

				break;

			case "GET":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization:Bearer '.$auth_token));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				break;

			case "PUT":

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization:Bearer '.$auth_token));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

				break;

			case "DELETE":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization:Bearer '.$auth_token));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");



				break;



			default:

				break;

		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		return $result = curl_exec($ch);

	}

	public function auth_token(){
		

		$call_url = $this->getNetworkConfig('ses_base_url').'/auth_token';
		$wsuser=$this->getNetworkConfig('ses_full_username');
		$wspass=$this->getNetworkConfig('ses_full_password');
		$group_id=$this->getNetworkConfig('api_acc_profile');
		
		$json_data=array(
				"username"=>$wsuser,
				"password"=>$wspass,
				"group_id"=>$group_id
				
		);
		
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST');

		
		$obj = (array)json_decode($results,true);
		
		
		$resultcode = $obj[status];
		$auth_token= $obj[data][token];
		$status_code= $obj[data][statusCode];
		
			
		return $auth_token;
                 
            
       

    }



	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time,$country,$address,$state,$city,$zip,$secret_question,$secret_answer,$vlan_id){

	
		$user_name=$email.'@'.$organization;

		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber';
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		$group_id =$this->getNetworkConfig('api_acc_profile');
		//$expires = strtotime($timegap, now());


		$auth_token=$this->auth_token();
		$date =date("Y-m-d H:i:s");
		$start = new DateTime($date);
		$datetime = $start->modify('+3 day');
		$endate=$datetime->format('Y-m-d H:i:s');

		 $user_date_array = array(
            	'VT-Vlan-Id' => $vlan_id,
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => '0',
                'usermessage'      => '0',
                'violation'      => '0',
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
          

		$json_data = array(
				'username'     => $user_name,
				'password'      => $password,
				'package_id'     => $service_profile_product,
				'status' => '1',				
				'email' => $email,
				'phone' => $mobile_number,
				'first_name'    => $first_name,
				'last_name'     => $last_name,
				'location_id'     => $organization,
				'createdate'    => $date,
				'expiry'     => $endate,
				"user_profile" => array("social_media" => 1),
   				"devices" => array(array())
				//'User-Data' => $user_date_array

		);

		
	//$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);
		  

	$request_array = json_encode($json_data);
	$results=$this->jsonPost($call_url, $json_data, 'POST',$auth_token);
	$obj = (array)json_decode($results,true);
	
	$statusCode = $obj[statusCode];
	$replymessage = $obj[data];
	$replymessage=json_encode($replymessage);
	
	$this->log($user_name, __FUNCTION__, 'Create Account', $call_url, 'POST', $statusCode, mysql_real_escape_string($results), $request_array, $organization);

	//$statusCode = '201';
	
	if($statusCode == '201' || $statusCode == '200'){
		$json1 = array('status_code' => '200',
					'status' => 'success',
					'Description'=>$results);
		$encoded=json_encode($json1);

		return $encoded;
	}

	else{

		$json2 = array('status_code' => $statusCode,
					'status' => 'failed',
					'Description'=>'');
		$encoded2=json_encode($json2);

		return $statusCode;

	}


}

public function findUsersByMaster($master_user){

		$groups=explode('@', $master_user);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		//return $fields;
	
		
		
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber/'.$master_user;
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$auth_token=$this->auth_token();  
		  

		
		//$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		$obj = (array)json_decode($results,true);
		
		$status_code = $obj[statusCode];
		$array1 = $obj[data];
		$group_id=$this->getNetworkConfig('api_acc_profile');

		$finalarr=array();
		foreach ($array1 as $value) {
			$device=$value['devices'];
			$User_Name=$value['username'];
			$first_name=$value['first_name'];
			foreach ($device as $value2) {
				$newarray=array(
				'User-Name'     => $value2['username'],
				'Account-State'  => 'Active',
				'password'      => $value2['password'],
				'Master-Account'      => $User_Name,
				'PAS-Last-Name'  => $value2['device_name'],
				'User-Data' => array(
					'VT-Vlan-Id'=> ''
					),
				'Group' => $group_id
				);
				array_push($finalarr, $newarray);
			}
			
		}
	
		//$newarr=

        
		$this->log($master_user,__FUNCTION__, 'Get Device', $call_url, 'GET', $status_code, mysql_escape_string($results), '',$organization);
		$session_response = $this->getDeviceSessions($master_user);
		$newdecoded = json_decode($session_response, true);

			if($status_code == '200'){
					$json1 = array('status_code' => $status_code,
                            'status' => $newdecoded,
                            'Description'=>$finalarr);
		        		$encoded=json_encode($json1);
						return $encoded;
					//return 'status=success&status_code='.$status_code.'&Description=Device get Success - '.$status_code.'&parameters='.$body;
		
				}
				else{
					$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>'');
        		$encoded2=json_encode($json2);
				 return $encoded2;
					//return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
}

////////////////////////////////////////////////////////////////////////
	public function getDeviceSessions($master_uname){
	

		$groups=explode('@', $master_uname);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		$organization=$groups[$a];

		$call_url = $this->getNetworkConfig('ses_base_url').'/session?mac='.$mac.'&realm='.$realm;
		
		$auth_token=$this->auth_token();
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		
		$obj = (array)json_decode($results,true);

		
	
		 
		$status_code = $obj[statusCode];
		$status = $obj[status];
		$replymessage = $obj[data];
		$session_data = $obj[data][session];
		$session_dataen=json_encode($session_data);

		//print_r($session_data);
		//$finalarray=$this->getSessions($session_dataen,$status_code);
		
		
		$this->lognew(__FUNCTION__, 'Session Search', $call_url, 'GET', $status_code,mysql_escape_string($results), '' ,$realm,$mac); 
	
		return $finalarray;
	
		if($status_code==200){
				
				return $results;
			}

			else{
				 return $results;

			}
	
	}


	public function getSessionsbymac($username){
	

		$groups=explode('@', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		$organization=$groups[$a];

		$call_url = $this->getNetworkConfig('ses_base_url').'/session?mac='.$mac.'&realm='.$organization;
		
		$auth_token=$this->auth_token();
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		
		$obj = (array)json_decode($results,true);

		 
		$status_code = $obj[statusCode];
		$status = $obj[status];
		$replymessage = $obj[data];
		$session_data = $obj[data][session];
		$mtoken=$session_data['multisession_id'];
		$nas_type=$session_data['nas_type'];
		$session_dataen=json_encode($session_data);

		$this->lognew(__FUNCTION__, 'Session Search', $call_url, 'GET', $status_code,mysql_escape_string($results), '' ,$organization,$mac); 
	
	
		if($status_code==200){
			$returnarr=array(
				"status_code" => $status_code,
				"status" => $nas_type,
				"Description" => $mtoken
			);
			$result=json_encode($returnarr);
				
				return $result;
			}

			else{
				$returnarr=array(
				"status_code" => $status_code,
				"status" => '',
				"Description" => ''
			);
			$result=json_encode($returnarr);
				
				return $result;

			}
	
	}

	public function getSessions($username,$parameter){

		if ($parameter=='Access-Group') {
			$parameter='realm';
		}
		if ($parameter=='User-Name') {
			$parameter='mac';
		}
		if ($parameter=='Session-IP') {
			$parameter='ip';
		}
		if ($parameter=='AAA-User-Name') {
			$parameter='email';
		}
	

		$call_url = $this->getNetworkConfig('ses_base_url').'/session?'.$parameter.'='.$username;
		
		$auth_token=$this->auth_token();
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		
		$obj = (array)json_decode($results,true);

		 
		$status_code = $obj[statusCode];
		$status = $obj[status];
		$replymessage = $obj[data];
		$session_data = $obj[data][session];
		$mtoken=$session_data['multisession_id'];
		$nas_type=$session_data['nas_type'];
		$session_dataen=json_encode($session_data);

		$this->lognew(__FUNCTION__, 'Session Search', $call_url, 'GET', $status_code,mysql_escape_string($results), '' ,$organization,$username);

	
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


	public function disconnectDeviceSessions($token,$mac_address){
	

		$groups=explode('@', $master_uname);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		$organization=$groups[$a];



		$call_url = $this->getNetworkConfig('ses_base_url').'/logout';
		
		$auth_token=$this->auth_token();
		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));

		$user_name_ale=$this->getUserName($realm,$mac);

		$json_data = array(
				'multisession_id'     => $token
				

		);
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST',$auth_token);
		
		$obj = (array)json_decode($results,true);
		
		$status_code = $obj[statusCode];
		$status = $obj[status];
		$replymessage = $obj[data];
		$session_data = $obj[data][session];
		$session_dataen=json_encode($session_data);
		//print_r($replymessage);

		$this->lognew(__FUNCTION__, 'Session Delete', $call_url, 'DELETE', $status_code,mysql_escape_string($results),$request_array,$realm,$mac); 
		if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Device get Success - '.$status_code.'&parameters='.$session_data;
                    /*$json1 = array('status_code' => '200',
                            'status' => 'success',
                            'Description'=>$replymessage);
                    $encoded=json_encode($json1);
                    return $encoded;*/
    
                }
                else{
                	return 'status=success&status_code='.$status_code.'&Description=Device get Success - '.$status_code.'&parameters='.$results;
                    /*$json2 = array('status_code' => $status_code,
                            'status' => 'failed',
                            'Description'=>$replymessage);
                    $encoded2=json_encode($json2); */

                    return $encoded2;
                    
                }
	
	
	}


	////////////////////////////////////////////////////////////////////////
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
		$mac_name=explode('@', $mac);
		$macc=$mac_name[0];
		$mac= str_replace('-','',$macc);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));
		$user_name=$email.'@'.$organization;


		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));


	
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber/'.$user_name.'/device';
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		$group_id =$this->getNetworkConfig('api_acc_profile');
		//$expires = strtotime($timegap, now());


		$auth_token=$this->auth_token();
		$date =date("Y-m-d H:i:s");
		$start = new DateTime($date);
		$datetime = $start->modify('+3 day');
		$endate=$datetime->format('Y-m-d H:i:s');

		$user_data = array(
            	'VT-Vlan-Id' => $vlan_id );

		$json_data = array(array(
            	'MAC'     => $mac,
                'device_name'      => $last_name
            ));

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST',$auth_token);
		$obj = (array)json_decode($results,true);

		$status_code = $obj[statusCode];
		$replymessage = $obj[data];
		$replymessage=json_encode($replymessage);
	
		
		$this->log($mac,__FUNCTION__, 'Add Device', $call_url, 'POST', $status_code, mysql_escape_string($results), $request_array,$organization);
		
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Device Creation Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$replymessage.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	}

	public function modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string,$vlan_id){
	

		
		
		/*$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		

		$json=$this->findUser($cust_uname);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$mobile_number=$decodednew['MSISDN'];
		if (strlen($vlan_id)==0) {
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
			
		}
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$user_message_text=$decodednew['User-Data']['usermessage'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		
		$user_date_array = array(
            	'VT-Vlan-Id' => $vlan_id,
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => $warning,
                'usermessage'      => $user_message_text,
                'violation'      => (string)$violation,
                'ispremium' => 'false',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
*/			
		
        $call_url = $this->getNetworkConfig('api_base_url').'/subscriber';
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));
		

		$date =date("Y-m-d H:i:s");
		$start = new DateTime($date);
		$datetime = $start->add(new DateInterval('P3D'));
		$endate=$datetime->format('Y-m-d H:i:s');
		
		

		$user_name_ale = $this->getUserName($organization,$mac,$pvt_gst,$ref_number);
		
		$json_data=array(
				"username"=>$cust_uname,
				//"password"=>$user_name_ale,
				//"package_id"=>$product,
				"email" => $email,
				"phone" => $mobile_number,
				"first_name"    => $first_name,
				"last_name"     => $last_name,
				"expiry"=>$endate,
				"location_id"=>$organization,
				"user_profile"=>array("payment_status" => "1")
				
		); 
		
		if(strlen($password)>0){
			$json_data['password'] = $password;
		}

		$auth_token=$this->auth_token();

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'PUT',$auth_token);
	
		$obj = (array)json_decode($results);
		
		$status_code = $obj[statusCode];
		$replymessage = $obj[replymessage];
		$session_data = $obj[session];
		
		$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, mysql_escape_string($results), $request_array,$organization);
		
				if($status_code == '200' || $status_code == '201'){
					return 'status=success&status_code=200&Description=Account Update is Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$replymessage.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}

	public function findUsers($search_parameter1, $term1,$realm=null){

		
	
		$group_id=$this->getNetworkConfig('api_acc_profile');
		
		
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber?'.$search_parameter1.'='.$realm; 
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$auth_token=$this->auth_token();  
		  

		
		//$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		$obj = (array)json_decode($results,true);
		//print_r($results);
		$status_code = $obj[statusCode];
		$array1 = $obj[data];
		//print_r($array1);

		$finalarr=array();
		foreach ($array1 as $value) {
			//print_r(expression)
			$device=$value['devices'];
			$User_Name=$value['username'];
			$first_name=$value['first_name'];
			$last_name=$value['last_name'];
			
				$newarray=array(
				'Valid-Until' => $value['expiy_date'],
				'User-Name'     => $value['username'],
				'Valid-From'  => $value['createdate'],
				'Product' => $value['package_id'],
				'PAS-First-Name'      => $value['first_name'],
				'MSISDN'      => $value['phone'],
				'Email'      => $value['email'],
				'Password'      => $value['password'],
				'Account-State'      => 'Active',
				'PAS-Last-Name'  => $value['last_name'],
				'User-Data' => array(
					'VT-Vlan-Id'=> ''
					),
				'Group' => $group_id
				);
				array_push($finalarr, $newarray);
			
			
		}
		

        
		$this->log($term1,__FUNCTION__, 'Get Account', $call_url, 'GET', $status_code, mysql_escape_string($results), '',$realm);
		
		
				if($status_code == '200'){
					$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$finalarr);
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

	public function delUser($network_user,$username){

		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $network_user);
		$mac=$groups[0];
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];

		if (isset($username)){
			$call_url = $this->getNetworkConfig('api_base_url').'/subscriber/'.$username.'/device/'.$mac;
		}
		else{
			$call_url = $this->getNetworkConfig('api_base_url').'/subscriber/'.$network_user;
		}
		
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$auth_token=$this->auth_token();      

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'DELETE',$auth_token);
		

		$obj = (array)json_decode($results);

	//print_r($obj);


		$status_code = $obj[statusCode];
		$replymessage = $obj[data];
		$replymessage=json_encode($replymessage);
		$session_data = $obj[session];

		if (isset($username)){
			$this->log($mac, __FUNCTION__, 'Delete Device', $call_url, 'DELETE', $status_code, mysql_real_escape_string($results), $request_array, $organization);
		}
		else{
			$this->log($network_user, __FUNCTION__, 'Delete Account', $call_url, 'DELETE', $status_code, mysql_real_escape_string($results), $request_array, $organization);
		}
		
		
		
		
				if($status_code == '204' || $status_code == '200'){
					return 'status=success&status_code='.'200'.'&Description=Account Delete Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$replymessage.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}

public function deleteAccount($mac,$realm){

		$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber/'.$user_name_ale;
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');


		$auth_token=$this->auth_token();      

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'DELETE',$auth_token);

		//$this->log($user_name_ale,__FUNCTION__, 'Delete Account', $url2, 'DELETE', $status_code, mysql_escape_string($body),'', $organization);
		

		$obj = (array)json_decode($results);

	//print_r($obj);


		$status_code = $obj[statusCode];
		$replymessage = $obj[data];
		$replymessage=json_encode($replymessage);
		$session_data = $obj[session];

		$this->log($user_name_ale, __FUNCTION__, 'Delete Account', $call_url, 'DELETE', $status_code, mysql_real_escape_string($results), $request_array, $realm);

	

			if($status_code == '200'){
				$json1 = array('status_code' => '200',
                            'status' => 'success',
                            'Description'=>$replymessage);
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
	
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber?&realm='.$realm;
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$auth_token=$this->auth_token();      
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);


		$obj = (array)json_decode($results,true);

		$status_code = $obj[statusCode];
		$decoded = $obj[data];



		
		
		$this->log($realm,__FUNCTION__, 'Get Account', $call_url, 'GET', $status_code, mysql_escape_string($results),'', $realm);
		
	

		$newarray=$decoded;
		

		if (empty($newarray)) {
			$res_arr = array();
			$res_arr3 = array();
		}
		else{
		if (strlen($newarray['username'])>0) {
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

				//$User_Name = $this->getUserName($array_get_profile_value['location_id'],$array_get_profile_value['mac'],$type,'');
				
				$macc=explode('@', $User_Name);
				$mac=$macc['0'];
				$realm=$macc['1'];

				$newarray1=array("Mac"=>$array_get_profile_value['mac'],
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $array_get_profile_value['location_id'],
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $array_get_profile_value['mac'],
                    			"Ses_token"=> $session_id,
                    			"User-Name"=> $array_get_profile_value['username'],
                    			"Product"=> $array_get_profile_value['package_id'],
                    			"TYPE"=> $type);
					
				array_push($res_arr, $newarray1);

		}

		}
		//$finalarray = $this->uniqueAssocArray($res_arr, 'User-Name', 'Realm');
		
		

		

		
	
				 
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

	public function checkMacAccount($mac,$realm,$type){
		
		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));
		
		$mac= str_replace('','-',$mac);
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber?mac='.$mac.'&realm='.$realm;
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$auth_token=$this->auth_token();  
		  

		
		//$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		

		
		$obj = (array)json_decode($results,true);
		//print_r($obj);
		

		$status_code = $obj[statusCode];
		$array1 = $obj[data];
		$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);
		
		

		$this->log($user_name_ale,__FUNCTION__, 'Get Account', $call_url, 'GET', $status_code, mysql_escape_string($results), '',$realm);

		if (empty($array1) ||$status_code == '404'){
			$res_arr = array();
			$res_arr3 = array();
		}
		else{
		if (strlen($array1['username'])>0) {
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

				//$User_Name = $array_get_profile_value['User-Name'];
				
				

				$newarray1=array("Mac"=>$array_get_profile_value['mac'],
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $array_get_profile_value['location_id'],
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $array_get_profile_value['mac'],
                    			"Ses_token"=> $session_id,
                    			"User-Name"=> $array_get_profile_value['username'],
                    			"Product"=> $array_get_profile_value['package_id'],
                    			"TYPE"=> $type);
					
				array_push($res_arr, $newarray1);

			
		}

		}
		//$finalarray = $this->uniqueAssocArray($res_arr, 'User-Name', 'Realm');
	
				 
			if($status_code == '200'||$status_code == '404'){
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

	public function createLocation($realm,$location_match_entry,$timezone){
		$auth_token=$this->auth_token();

		$json_data = array(
			"location_id"=>$realm,
			"location_match_entry"=>$location_match_entry,
			"timezone"=>$timezone
		);

		$call_url = $this->getNetworkConfig('api_base_url').'/location';

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST',$auth_token);
		$obj = (array)json_decode($results,true);

		$statusCode = $obj[statusCode];
		$replymessage = $obj[data];
		$replymessage=json_encode($replymessage);
		
		$this->log($realm, __FUNCTION__, 'Location Account', $call_url, 'POST', $statusCode, mysql_real_escape_string($results), $request_array, $realm);

		//$statusCode = '201';
		
		if($statusCode == '201' || $statusCode == '200'){
			$json1 = array('status_code' => '200',
						'status' => 'success',
						'Description'=>'');
			$encoded=json_encode($json1);

			return $encoded;
		}

		else{

			$json2 = array('status_code' => $statusCode,
						'status' => 'failed',
						'Description'=>'');
			$encoded2=json_encode($json2);

			return $statusCode;

		}
	}

public function checkAccount($mac,$realm,$pvt_gst=NULL,$session_network=NULL){

$call_url = $this->getNetworkConfig('api_base_url');
$wsuser=$this->getNetworkConfig('api_login');
$wspass=$this->getNetworkConfig('api_password');

$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);
$json_data=array(
	"wsuser"=>$wsuser,
	"wspass"=>$wspass,
	"method"=>"getsubscriber",
	"username" => $user_name_ale
	);
$auth_token=$this->auth_token();


	//print_r($json_data);

$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);

$obj = (array)json_decode($results);



$resultcode = $obj[resultcode];
$replymessage = $obj[replymessage];
$session_data = $obj[data];



//$this->log1(__FUNCTION__, 'Get Account', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
$this->log($user_name_ale, __FUNCTION__, 'Get Account', $call_url, 'POST', $resultcode, mysql_real_escape_string($replymessage), $request_array, $organization);

//return $resultcode;
if($status_code == '200'){
		$json1 = array('status_code' => '200',
					'status' => 'success',
					'Description'=>$session_data);
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

public function getAllProducts($realm=null){

		
		$organization = $realm;

		$call_url = $this->getNetworkConfig('api_base_url').'/package';
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		$group_id=$this->getNetworkConfig('api_acc_profile');

		$auth_token=$this->auth_token();      
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET',$auth_token);
		


		$obj = (array)json_decode($results,true);

		$status_code = $obj[statusCode];
		$decoded = $obj[data];

		


	
	$this->log($organization, __FUNCTION__, 'Get Product', $call_url, 'GET', $status_code, mysql_real_escape_string($results), '', $organization);

	if($status_code == '200'){
		if ($obj[data]['package_id']) {
			$arrsize=1;
		}
		else{
			$arrsize=sizeof($decoded);
		}
		$jsondata=array();
		for ($i=0; $i < $arrsize; $i++) {
			$dataarr = array('Id' => $decoded[$i]['package_id'],
					'Group' => $group_id
		 		);

			array_push($jsondata, $dataarr);
		}

		
		$jsonDataEncoded=json_encode($jsondata);
		return $jsonDataEncoded;
	}

	else{
		 return $desc;
	}
	}

public function updateAccount($mac,$realm,$product){
		
		$call_url = $this->getNetworkConfig('api_base_url').'/subscriber';
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');

		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));
		
		$organization = $realm;

		$date =date("Y-m-d H:i:s");
		$start = new DateTime($date);
		$datetime = $start->add(new DateInterval('P3D'));
		$endate=$datetime->format('Y-m-d H:i:s');
		
		

		$user_name_ale = $this->getUserName($organization,$mac,$pvt_gst,$ref_number);

		
			$json_data=array(
				"username"=>$user_name_ale,
				"password"=>$user_name_ale,
				"package_id"=>$product,
				"expiry"=>$endate,
				"locationid"=>$organization,
				//"rechargetype"=>'',
				//"rechargekey"=>'',
				"mac" => $mac
				
		);  
		

		$auth_token=$this->auth_token();

		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'PUT',$auth_token);
	
	$obj = (array)json_decode($results);
	
	//print_r($obj);

	 
	$statusCode = $obj[statusCode];
	$replymessage = $obj[replymessage];
	$session_data = $obj[session];


	$this->log($user_name_ale, __FUNCTION__, 'Update Account', $call_url, 'PUT', $statusCode, mysql_real_escape_string($results), $request_array, $realm);

	
	if($statusCode == '201' || $statusCode == '200'){
		$json1 = array('status_code' => '200',
					'status' => 'success',
					'Description'=>$results);
		$encoded=json_encode($json1);

		return $encoded;
	}

	else{

		$json2 = array('status_code' => $statusCode,
					'status' => 'failed',
					'Description'=>'');
		$encoded2=json_encode($json2);

		return $statusCode;

	}


	}


}

?>