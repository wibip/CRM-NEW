<?php

include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');





class aaa

{

	public function __construct($network_name,$access_method)

	{



		$db_class = new db_functions();



		$this->network_name = $db_class->setVal("network_name",'ADMIN');



	



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

	public function getNetworkConfig($network,$field)

	{


		$query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			return $row['f'];
		}



	}

	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data){
		$query = "INSERT INTO `exp_aaa_logs`
		(`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`)
		VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API')";
		$query_results=mysql_query($query);
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

	public function createAP($refid,$clientip,$secret)

	{
		$call_url = 'http://97.74.236.76:8080/api/system/';//$this->getNetworkConfig($this->network_name, 'api_base_url');
		$wsuser=$this->getNetworkConfig($this->network_name,'api_login');
		$wspass=$this->getNetworkConfig($this->network_name,'api_password');

	//	{"wsuser":"test","wspass":"test12","method":"addradclient","refid":"1234","clientip":"1.1.1.1","secret":"secret"}
		$jsonData = array(

			"wsuser" => $wsuser,
			"wspass" => $wspass,
			"method" => "addradclient",
			"refid" => $refid,
			"clientip" => $clientip,
			"secret" => $secret
		);

		print_r($jsonData);

		$request_array = json_encode($jsonData);
		$results=$this->jsonPost($call_url, $jsonData, 'POST');

		 $obj = (array)json_decode($results);

         print_r($obj);
         $resultcode = $obj[resultcode];
         $replymessage = $obj[replymessage];

         $this->log(__FUNCTION__, 'AP Creation', $call_url, 'POST', $resultcode, $replymessage, $request_array);
         
         if($resultcode == 2000){

			 return 'status=success&status_code=200&Description=Account Creation Success';
         }

         else{

			 return 'status=failed&status_code='.$resultcode.'&Description=Account Creation Failed';

         }

	}

	public function getAP($account_type,$portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timezone,$timegap)
	{

		$call_url = $this->getNetworkConfig($this->network_name, 'api_base_url');
		$wsuser=$this->getNetworkConfig($this->network_name,'api_login');
		$wspass=$this->getNetworkConfig($this->network_name,'api_password');

		//$call_url = 'http://97.74.236.76:8080/api/aaa/';

		//echo $call_url;

		$tz_object = new DateTimeZone($timezone);
		$datetime = new DateTime(null,$tz_object);
		$begindate = $datetime->format('Y-m-d H:i:s');
		$datetime->add(new DateInterval($timegap));
		$enddate = $datetime->format('Y-m-d H:i:s');

		$jsonData = array(

/* 			"wsuser"=>$wsuser,
			"wspass"=>$wspass,
			"method"=>"changeattribs",
			"username"=>$portal_number,
			"locationid"=>"LOC01",
			"status"=>"1",
			"password"=>$portal_number */
				
				"wsuser" => $wsuser,
				"wspass" => $wspass,
				"method" => "rechargeuser",
				"username" => $portal_number,
				"packageid" => $product,
				"expiry" => $enddate,
				"locationid" => "LOC01",
				"rechargetype" => 2,
				"rechargekey" => uniqid()


		);

		//print_r($jsonData);
		
		
		if($account_type=="ex"){
/* 			$ar=$this->accountRecharge($portal_number,$product, $enddate, $locationid, $rechargetype);
			parse_str($ar);
			if($status_code==200){ */

				$results=$this->jsonPost($call_url, $jsonData, 'POST');

				 $obj = (array)json_decode($results);

				 //print_r($obj);
				 $resultcode = $obj[resultcode];

				 $replymessage = $obj[replymessage];
			//}
		}
		else if($account_type=="new"){
			$results=$this->jsonPost($call_url, $jsonData, 'POST');

			$obj = (array)json_decode($results);

			 //print_r($obj);
			$resultcode = $obj[resultcode];

			$replymessage = $obj[replymessage];
		}
		
		
		$request_array = json_encode($jsonData);
		

		$this->log(__FUNCTION__, 'Account Recharge', $call_url, 'POST', $resultcode, $replymessage, $request_array);
		 
         if($resultcode == 2000){

			 return 'status=success&status_code=200&Description=Account Update Success';

         }

         else{

			 return 'status=failed&status_code='.$resultcode.'&Description=Account Update Failed';

         }

	}


}

?>