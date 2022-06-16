<?php

include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../classes/dbClass.php');

require_once dirname(__FILE__).'/../../LOG/Logger.php';



class aaa

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
		$log->setgroupid($organization);

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



	public function createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm,$urln,$token){

		$mac= str_replace('-','',$mac);
		$mac= strtoupper($mac);
		$mac = implode("-", str_split($mac, 2));


	
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
		//$starttime=strtotime($date);
		//$endTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($date)));
		
		
		
		$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);
		  
		$json_data=array(
			"username"=>$user_name_ale,
			"password"=>$user_name_ale,
			"package_id"=>$product,
			"status"=>'1',
			"first_name"=>$first_name,
			"last_name"=>$last_name,
			"phone"=>$mobile_number,
			"email"=>$email,
			"location_id"=>$realm,
			"createdate"=>$date,
   			"expiry"=>$endate,
   			"user_profile" => array("social_media" => 1),
   			"devices" => array(array("MAC" => $mac, "device_name" => "d3"))
			); 
	
	
	
	$request_array = json_encode($json_data);
	$results=$this->jsonPost($call_url, $json_data, 'POST',$auth_token);
	$obj = (array)json_decode($results,true);
	
	

	 
	$statusCode = $obj[statusCode];
	$replymessage = $obj[data];
	$replymessage=json_encode($replymessage);
	
	$this->log($user_name_ale, __FUNCTION__, 'Create Account', $call_url, 'POST', $statusCode, mysql_real_escape_string($results), $request_array, $realm);

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
				$User_Name=$array_get_profile_value['username'];
				$macc=explode('@', $User_Name);
				$mac=$macc['0'];
				$realm=$macc['1'];

				$newarray1=array("Mac"=>$mac,
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $array_get_profile_value['location_id'],
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $mac,
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
				$User_Name=$array_get_profile_value['username'];
				$macc=explode('@', $User_Name);
				$mac=$macc['0'];
				$realm=$macc['1'];
				
				

				$newarray1=array("Mac"=>$mac,
								"AP_Mac"=> $array_get_profile_value['MAC'],
								"State" => $array_get_profile_value['States'],
								"SSID" => $array_get_profile_value['SSID'],
								"Realm" => $array_get_profile_value['location_id'],
								"GW_ip" => $array_get_profile_value['GW-NAS-IP-Address'],
								"GW-Type" => $array_get_profile_value['Sender-Type'],
								"Session-Start-Time" => $array_get_profile_value['Session-Start-Time'],
								"Device-Mac" => $mac,
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
				"location_id"=>$organization,
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