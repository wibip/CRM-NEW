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


	public function log1($function,$function_name,$description,$method,$api_status,$api_details,$api_data){
		/* $query = "INSERT INTO `exp_aaa_logs`
		(`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`)
		VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API')";
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


	public function jsonPost($url, $jsonData, $action)
	{
		$ch = curl_init($url);

		$jsonDataEncoded = json_encode($jsonData);

		switch ($action) {

			case "POST":

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

				break;

			case "GET":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				break;

			case "PUT":

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

				break;

			case "DELETE":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");



				break;



			default:

				break;

		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		return $result = curl_exec($ch);

	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function sessionGet()

	{
		
		
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		$org=$this->getNetworkConfig('api_acc_org');
		//$call_url = 'http://97.74.236.76:8080/api/aaa/';//$this->getNetworkConfig($this->network_name, 'api_base_url');
	//	$wsuser='api_user1';//$this->getNetworkConfig($this->network_name,'api_login');
		//$wspass='aaa@api';//$this->getNetworkConfig($this->network_name,'api_password');

		$jsonData = array(

			"wsuser" => $wsuser,
			"wspass" => $wspass,
			"method" => "getonlinesession",
			"WISPR_LOCATIONID" => $org,
			
				
				
		);

		//print_r($jsonData);

		 $request_array = json_encode($jsonData);
		 $results=$this->jsonPost($call_url, $jsonData, 'POST');

		 $obj = (array)json_decode($results);

        //print_r($obj);
         
         $resultcode = $obj[resultcode];
         $replymessage = $obj[replymessage];
         $session_data = $obj[session];

        //print_r($session_data);
         //echo json_encode($session_data);
        if($resultcode == 2000){
        	$this->log1(__FUNCTION__, 'Session Search', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
        	 
         	return json_encode($obj);
			// echo 'status=success&status_code=200&Description=Account Creation Success';
         }
         else{
         	return "Failled";
         	
			// echo 'status=failed&status_code='.$resultcode.'&Description=Account Creation Failed';
         }

	}
	
	
	
	
	
	
	
	
	
	//create packages
	public function create_package($product_code,$uplink,$downlink,$quota,$time){
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		
		$json_data=array(
				"wsuser"=>$wsuser,
				"wspass"=>$wspass,
				"method"=>"addpackage",
				"packageid"=>$product_code,
				"uplink"=>$uplink,
				"downlink"=>$downlink,
				"volumequota"=>$quota,
				"timequota"=>$time,
				"idletime"=>"300"
				
		);
		
		//print_r($json_data);
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST');
		
		$obj = (array)json_decode($results);
		
		//print_r($obj);
	
		 
		$resultcode = $obj[resultcode];
		$replymessage = $obj[replymessage];
		$session_data = $obj[session];
		
		$this->log1(__FUNCTION__, 'Package Creation', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
			
		return $resultcode;
		
	}
	
	
	
	//edit_package
	public function edit_package($product_code,$uplink,$downlink,$quota,$time){
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		
		$json_data=array(
				"wsuser"=>$wsuser,
				"wspass"=>$wspass,
				"method"=>"modpackage",
				"packageid"=>$product_code,
				"uplink"=>$uplink,
				"downlink"=>$downlink,
				"volumequota"=>$quota,
				"timequota"=>$time,
				"idletime"=>"300"
				
		);
		//print_r($json_data);
		//print("<br/>");
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST');
		
		$obj = (array)json_decode($results);
		//print_r($obj);
		//print("<br/>");
		$resultcode = $obj[resultcode];
		$replymessage = $obj[replymessage];
		$session_data = $obj[session];
		
		$this->log1(__FUNCTION__, 'Package Modify', $call_url, 'POST', $resultcode, $replymessage, $request_array);
			
		
		return $resultcode;
	}
	
	
	
	



	//create location
	//{"wsuser":"test","wspass":"test12","method":"addlocation","locationid":"TEST01","nasid":"test01","timezoneoffset":"+05:30"}

	public function create_location($locationid,$nasid,$timezoneoffset){
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		
		$json_data=array(
				"wsuser"=>$wsuser,
				"wspass"=>$wspass,
				"method"=>"addlocation",
				"locationid"=>$locationid,
				"nasid"=>$nasid,
				"timezoneoffset"=>$timezoneoffset,
				
				
		);
		
		//print_r($json_data);
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST');
		
		$obj = (array)json_decode($results);
		
		//print_r($obj);
	
		 
		$resultcode = $obj[resultcode];
		$replymessage = $obj[replymessage];
		$session_data = $obj[session];
		
		$this->log1(__FUNCTION__, 'Package Creation', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
			
		return $resultcode;
		
	}
	

	//create customer
	//{"wsuser":"test","wspass":"test12","method":"addradclient","refid":"1234","clientip":"1.1.1.1","secret":"secret111"}

	public function create_customer($refid,$secret){
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');
		
		$json_data=array(
				"wsuser"=>$wsuser,
				"wspass"=>$wspass,
				"method"=>"addradclient",
				"refid"=>$refid,
				"clientip"=>"0.0.0.0",
				"secret"=>$secret,
				
		);
		
		//print_r($json_data);
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'POST');
		
		$obj = (array)json_decode($results);
		
		//print_r($obj);
	
		 
		$resultcode = $obj[resultcode];
		$replymessage = $obj[replymessage];
		$session_data = $obj[session];
		
		$this->log1(__FUNCTION__, 'Package Creation', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
			
		return $resultcode;
		
	}


	public function createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm,$urln,$token){

	
		$call_url = $this->getNetworkConfig('api_base_url');
		$wsuser=$this->getNetworkConfig('api_login');
		$wspass=$this->getNetworkConfig('api_password');


		
		$json_data=array(
			"wsuser"=>$wsuser,
			"wspass"=>$wspass,
			"method"=>"createuser",
			"username"=>$mac,
			"password"=>"0.0.0.0",
			"packageid"=>$product,
			"status"=>'1',
			"createdate"=>now(),
			"locationid"=>$realm,
			"physical_location"=>$secret,
			"department"=>$secret,
			"token_ref"=>$token,
			
	);
	
	//print_r($json_data);
	
	$request_array = json_encode($json_data);
	$results=$this->jsonPost($call_url, $json_data, 'POST');
	
	$obj = (array)json_decode($results);
	
	//print_r($obj);

	 
	$statusCode = $obj[statusCode];
	$replymessage = $obj[replymessage];
	$session_data = $obj[session];
	
	$this->log1(__FUNCTION__, 'Create Account', $this->network_name, 'POST', $statusCode, $replymessage, $request_array);
		
	if($status_code == '200'){
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
public function checkAccount($mac,$realm,$pvt_gst=NULL,$session_network=NULL){

	$call_url = $this->getNetworkConfig('api_base_url');
$wsuser=$this->getNetworkConfig('api_login');
$wspass=$this->getNetworkConfig('api_password');

$organization = $realm;


//$getsessiondata=$this->getSessionacc($mac,$session_network,$organization);
$getsessiondata=$this->getAccount($mac,$session_network,$organization,$pvt_gst);
$macc= str_replace('-','',$mac);

$user_name_ale = $this->getUserName($realm,$mac,$pvt_gst,$ref_number);


$call_url = $this->getNetworkConfig('api_base_url');
$wsuser=$this->getNetworkConfig('api_login');
$wspass=$this->getNetworkConfig('api_password');


$json_data=array(
	"wsuser"=>$wsuser,
	"wspass"=>$wspass,
	"method"=>"getsubscriber",
	"username" => $user_name_ale
	);


	//print_r($json_data);

$request_array = json_encode($json_data);
$results=$this->jsonPost($call_url, $json_data, 'POST');

$obj = (array)json_decode($results);



$resultcode = $obj[resultcode];
$replymessage = $obj[replymessage];
$session_data = $obj[session];



//$this->log1(__FUNCTION__, 'Get Account', $this->network_name, 'POST', $resultcode, $replymessage, $request_array);
$this->log($user_name_ale, __FUNCTION__, 'Get Account', $call_url, 'POST', $resultcode, mysql_real_escape_string($replymessage), $request_array, $organization);

//return $resultcode;

$other_param='';


$array1 = array('status_code' => 'Active',
			 'Description'=>$other_param);
$json1=json_encode($array1);

$array2 = array('status_code' => 'Return',
			 'Description'=>$other_param);
$json2=json_encode($array2);

$array3 = array('status_code' => 'New',
			 'Description'=>$other_param);
$json3=json_encode($array3);

$array4 = array('status_code' => 'failed',
			 'Description'=>$other_param);
$json4=json_encode($array4);


if ($getsessiondata=='FULL') {
return $json1;

}
elseif (($getsessiondata=='REDIRECT')&&($resultcode == '2000')) {
return $json2;
}

elseif(($getsessiondata=='REDIRECT')&&($resultcode == '1002')){
return $json3;
}

else{
 return $json4;
}



}


}

?>