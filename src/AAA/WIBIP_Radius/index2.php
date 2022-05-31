<?php
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');


class aaa
{
/*	public function __construct($network_name,$access_method)

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
	*/
	
	
	
	public function jsonPost($url, $jsonData, $action)
	{

		$ch = curl_init($url);
		$jsonDataEncoded = json_encode($jsonData);
		//print_r($jsonDataEncoded);
			
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
		echo $result = curl_exec($ch);
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	

	public	function accountGet($wsuser, $wspass, $username)
	{

		//$api_url = 'http://192.168.1.2/api/';
		//$api_path = 'aaa';
		$call_url = 'http://97.74.236.76:8080/api/aaa/';
		//echo $call_url;


		$jsonData = array(
			"wsuser"=>$wsuser,
			"wspass"=>$wspass,
			"method"=>"getsubscriber",
			"username"=>$username

		);

		$this->jsonPost($call_url, $jsonData, 'POST');
		// $obj = (array)json_decode($results);
         //print_r($obj);

        /* $status = $obj[status];
         $message = $obj[message];

        // $this->log(__FUNCTION__,'Create Account', $api_path,'POST', $status, $message, json_encode($jsonData));

         if($status == 200){
             return 'status=success&status_code='.$status.'&Description='.$message;

         }
         else{
             return 'status=failed&status_code='.$status.'&Description='.$message;

         } */
	}






	public function packageAdd($wsuser, $wspass, $packageid, $uplink, $downlink, $volumequota, $timequota)
	{

		//$api_url = 'http://192.168.1.2/api/';
		//$api_path = 'aaa';
		$call_url = 'http://97.74.236.76:8080/api/aaa/';
		echo $call_url;


	/*	$jsonData = array(
			"wsuser"=>$wsuser,
			"wspass"=>$wspass,
			"method"=>"addpackage",
			"packageid"=>$packageid,
			"uplink"=>$uplink,
			"downlink"=>$downlink,
			"volumequota"=>$volumequota,
			"timequota"=>$timequota

		);
		*/
		$jsonData=array
		(
			"wsuser"=>"test",
			"wspass"=>"test12",
			"method"=>"addpackage",
			"packageid"=>"NVISONPKG1",
			"uplink"=>"1024000",
			"downlink"=>"4096000",
			"volumequota"=>"102400000",
			"timequota"=>"43200"
		);	
		

		$this->jsonPost($call_url, $jsonData, 'POST');
	/*	$obj = (array)json_decode($results);
        print_r($obj);

       /*  $status = $obj[status];
         $message = $obj[message];

        // $this->log(__FUNCTION__,'Create Account', $api_path,'POST', $status, $message, json_encode($jsonData));

         if($status == 200){
             return 'status=success&status_code='.$status.'&Description='.$message;

         }
         else{
             return 'status=failed&status_code='.$status.'&Description='.$message;

         } */
	}


	public function packageGET($wsuser, $wspass, $packageid)
	{

		//$api_url = 'http://192.168.1.2/api/';
		//$api_path = 'aaa';
		$call_url = 'http://97.74.236.76:8080/api/aaa/';
		echo $call_url;


		$jsonData = array(
			"wsuser"=>"test",
			"wspass"=>"test12",
			"method"=>"getpackage",
			"packageid"=>"PKG01"

		);

		$results=$this->jsonPost($call_url, $jsonData, 'GET');
		 $obj = (array)json_decode($results);
        print_r($obj);
/*
         $status = $obj[status];
         $message = $obj[message];

        // $this->log(__FUNCTION__,'Create Account', $api_path,'POST', $status, $message, json_encode($jsonData));

         if($status == 200){
             return 'status=success&status_code='.$status.'&Description='.$message;

         }
         else{
             return 'status=failed&status_code='.$status.'&Description='.$message;

         }*/
	}


	public function packageUpdate($wsuser, $wspass, $method, $packageid, $uplink, $downlink, $volumequota, $timequota)
	{

		//$api_url = 'http://192.168.1.2/api/';
		//$api_path = 'aaa';
		$call_url = 'http://97.74.236.76:8080/api/aaa/';
		echo $call_url;


		$jsonData = array(
			"wsuser"=>"test",
			"wspass"=>"test12",
			"method"=>"modpackage",
			"packageid"=>"PKG01",
			"uplink"=>"1024000",
			"downlink"=>"2048000",
			"volumequota"=>"1024000000",
			"timequota"=>"3500"

		);

		$this->jsonPost($call_url, $jsonData, 'GET');
		/* $obj = (array)json_decode($results);
        // print_r($obj);

         $status = $obj[status];
         $message = $obj[message];

        // $this->log(__FUNCTION__,'Create Account', $api_path,'POST', $status, $message, json_encode($jsonData));

         if($status == 200){
             return 'status=success&status_code='.$status.'&Description='.$message;

         }
         else{
             return 'status=failed&status_code='.$status.'&Description='.$message;

         }*/
	}







}
?>