<?php 

class ap_wag
{
	
	
	public function __construct($ap=NULL)
	{
		$db_class = new db_functions();
		$this->profile_name = $db_class->setVal("wag_ap_name",'ADMIN');
		
		$this->ap = $ap;
				
		$this->run_user_name = $_SESSION['user_name'];
		$this->realm=$db_class->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_name`='$this->run_user_name' LIMIT 1");
	
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	
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
	
	
	
	
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$rlm){
		$query = "INSERT INTO `exp_wag_ap_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`, unixtimestamp)
		VALUES ('$rlm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API', UNIX_TIMESTAMP())";
		$query_results=mysql_query($query);
	
	}
	
	
	
	
	
	/////////////////login data////////////////////
	public function login($t=NULL){
		
		$ap_cnt=$this->ap;
		
		if($this->ap == NULL){				
	
		return $inData = array(
				'username'   => $this->getConfig('api_user_name'),//'admin',
				'password'   => $this->getConfig('api_password'),//'ruckus1234!',
				'baseurl' 	 => $this->getConfig('api_url')//'https://10.1.6.8:7443'
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
				'baseurl' 	 => $url//'https://10.1.6.8:7443'
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
				'baseurl' 	 => $url//'https://10.1.6.8:7443'
		);		
			
			
		}
		
	}
	
	
	
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
		$url = $login[baseurl].'/api/public/v2_1/session';
		
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
			'baseurl'  => $login[baseurl]
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
		
	///////////////rkszones/////////////////
	public function rkszones(){
		
		$input=$this->session();
		//$login=$this->login();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $message, '',$this->realm);
		
		return $message;
	

	}
	
	///////////////creat zones/////////////////
	
	public function createzone($name,$setuname,$setpassword){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones';
		$ch2 = curl_init($url2);
		
		$jsonData2 = array(
		
				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);
		
		
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
		
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Zones', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
		
		curl_close ($ch2);
		
	}
	
	
						///////modify zone///////////////
	public function modifyzone($zoneid,$type,$id,$name){
	
		$input=$this->session();
	
		$jsonData2 = array(

    "tunnelType"  => $type,
	'tunnelProfile'   => array('id' => $id,
									'name' => $name)
		);
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);

		

		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Zone', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}

		curl_close($ch2);
	
	}
	
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////wlans SSID//////////////////////////////////
		////////////////////////////////////////////////////////////////////////


	/////////////////zone delete////////////////////v3_1/profiles/utp/{id}

	function deletezone($id){

		$input=$this->session();

		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$id;

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		// Make the REST call, returning the result
		$response = curl_exec($curl);

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Delete zone', $url2,'DELETE', $status, '', '');

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}




	/////////////////////////////////////////////////////////////////////////

	///////////////creat network///////////////
	 public function createnetwork($zoneid,$name,$ssid){
	
		$input=$this->session();
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans';
		$ch2 = curl_init($url2);
	
		$jsonData2 = array(
	
			'name'   => $name,
			'ssid'   => $ssid
		);
	
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
	
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

		curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		//output is ID
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Network', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
	
		curl_close ($ch2);
		
	}	
	
	///////modify network///////////////
	public function modifynetwork($zoneid,$id,$name,$ssid,$description){
	
		$input=$this->session();
	
		$jsonData2 = array(
		'name'=>$name,
		'ssid'=>$ssid,
		'description'=>$description,
		'accessTunnelType'=>'APLBO'
		);
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans/'.$id;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Network', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}

		curl_close($ch2);
	
	}
	
	/////////////////retrieve ssid list///////////////////
	
	public function retrieveNetworkList($zoneid,$icom=NULL){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		if($icom==NULL||$icom==""){
			
			$this->log(__FUNCTION__,'SSID List', $url2,'GET', $status, $message, $url2,$this->realm);
			
		}else{

		$this->log(__FUNCTION__,'SSID List', $url2,'GET', $status, $message, $url2,$icom);
			
		}
		
		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}



/////////////////////////////////////////////////////////////////////////

/////////////////retrieve 1 ssid details///////////////////
	
	public function retrieveOneNetwork($zoneid,$id){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans/'.$id;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'retrieve one SSID', $url2,'GET', $status, $message, $url2,$this->realm);
		
		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}

	/////////////////retrieve zone details///////////////////
	
	public function retrieveZonedata($zoneid){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve Zone details', $url2,'GET', $status, $message, $url2,$this->realm);
		
		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}
	
		////////////Modify zone time zone/////////////////
	public function modifyZoneTimeZone($zoneid,$abbreviation,$gmtOffset,$gmtOffsetMinute){
	
		$input=$this->session();
	
		$jsonData2 = array(
		
				'customizedTimezone'   => array('abbreviation' => $abbreviation,
												'gmtOffset' => $gmtOffset,
												'gmtOffsetMinute' => $gmtOffsetMinute)
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/timezone';
	
		$ch2=curl_init();
	
		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Zone Timezone', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	
		curl_close($ch2);
	
	}

/////////////////////////////////////////////////////////////////////////		
	
	
	
	////////////Modify Encryption/////////////////
	public function modifynetworkEncryption($zoneid,$id,$method,$algorithm,$passphrase){
	
		$input=$this->session();
	
		$jsonData2 = array(
				'method'=>$method,
				'algorithm'=>$algorithm,
				'passphrase'=>$passphrase,
				'mfp' => 'disabled'
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans/'.$id.'/encryption';
	
		$ch2=curl_init();
	
		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Encryption', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	
		curl_close($ch2);
	
	}
	
	
	
	/////////////////////////////////////////////////////////////////////
	///////////////////////AP creation//////////////////////////////////
	///////////////////////////////////////////////////////////////////
	
	
	
	
	public function createap($zoneid,$mac){
	
		$input=$this->session();
		$url2=$input[baseurl].'/api/public/v2_1/aps';
		$ch2 = curl_init($url2);
	
		$jsonData2 = array(
	
				'mac'   => $mac,
				'zoneId'   => $zoneid
		);
	
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
	
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        //output is ID
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'AP Creation', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	
		curl_close ($ch2);
	
	}
	
	///////////////////APs retrieve///////////////////
	public function retrieveaplist(){
	
		$input=$this->session();
	
	
		$url2=$input[baseurl].'/api/public/v2_1/aps';
		$ch2 = curl_init($url2);
	
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
	
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
	
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
	
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
		$this->log(__FUNCTION__,'retrieve scheduler List', $url2,'GET', $status, $message, '',$this->realm);
	
		if($status == '200'){
	
			return 'status=success&status_code=200&Description='.$message;
	
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
	
		}
	
	
	
	}
	
	
	///////////////////APs retrieve from zoneid///////////////////
	public function retrieveaplistzone($zoneid,$icom=NULL){
	
		$input=$this->session();
	
	
		$url2=$input[baseurl].'/api/public/v2_1/aps?zoneId='.$zoneid;
		$ch2 = curl_init($url2);
	
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
	
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
	
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
	
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
		if($icom==NULL||$icom==""){
			
			$this->log(__FUNCTION__,'APs retrieve from zoneid', $url2,'GET', $status, $message, $url2,$this->realm);
			
		}else{

		$this->log(__FUNCTION__,'APs retrieve from zoneid', $url2,'GET', $status, $message, $url2,$icom);
			
		}
	
		if($status == '200'){
	
			return 'status=success&status_code=200&Description='.$message;
	
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
	
		}
	
	
	
	}
	
	
	

		///////////////////////////////////////////////////////////////////////
		///////////////////////////USER TRAFFIC PROFILE////////////////////////
		//////////////////////////////////////////////////////////////////////

	///////////////////create utp///////////////////
	public function createUTP($name,$defaultAction){
	
		$input=$this->session();
	
		$url2=$input[baseurl].'/api/public/v2_1/profiles/utp';
		$ch2 = curl_init($url2);
	
		$jsonData2 = array(
	
			'name'   => $name,
			'defaultAction'   => 'ALLOW'
		);
	
	
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
	
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create UTP', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
	
		curl_close ($ch2);	
	
	}

	/////////////////////modify User traffic profile///////////////////////
	public function modifyUTP($name,$description,$defaultAction,$id){
	//
		$input=$this->session();
		$jsonData2 = array(
			'name'=>$name,
			'description'=>$description,
			'defaultAction'=>'ALLOW'
		);
	
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/api/public/v2_1/profiles/utp/'.$id;
	
		$ch2=curl_init();
	
		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify UTP', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	
		curl_close($ch2);
		
	}
	
	
	/////////////////////////////Retrieve User Traffic Profiles//////////////////////////
	public function retrieveUTPlist(){
		
		$input=$this->session();
		
		
		$url2=$input[baseurl].'/api/public/v2_1/profiles/utp';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve UTP', $url2,'GET', $status, $message, '',$this->realm);
		
		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}
	
	
	/////////////////delete utp////////////////////v2_1/profiles/utp/{id}
	
	public function deleteeutp($id){
	
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/profiles/utp/'.$id;
	
		$curl = curl_init($input[baseurl].'/api/public/v2_1/profiles/utp/'.$id.'');
	
	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        // Make the REST call, returning the result
		$response = curl_exec($curl);
		
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Delete UTP', $url2,'DELETE', $status, $message, '',$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
	
	}
	
	

		/////////////////////////////////////////////////
		/////////////////WLAN Scheduler//////////////////
		////////////////////////////////////////////////

	//create scheduler
	public function createScheduler($zoneid,$data){
	
		$input=$this->session();

		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlanSchedulers';
		$ch2 = curl_init($url2);
	
		$jsonData2 = $data;
	
		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
	
		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Scheduler', $url2,'POST', $status, $message, $jsonData2,$this->realm);
		
		if($status == '201'){

			$obj = (array)json_decode($message);
			$idr=$obj['id'];
			return 'status=success&status_code=200&id='.$idr;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
	
		curl_close ($ch2);

	}

	//delete scheduler
	public function deleteeScheduler($zoneid,$id){
	
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlanSchedulers/'.$id;
	
		$curl = curl_init($input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlanSchedulers/'.$id.'');
	
	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        // Make the REST call, returning the result
		$response = curl_exec($curl);
		
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Delete Scheduler', $url2,'DELETE', $status, $message, '',$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
	
}

///////////////////retrieve scheduler List///////////////////
public function retrieveSchedulelist($zoneid){

	$input=$this->session();


	$url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlanSchedulers';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

    $resultl=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'retrieve scheduler List', $url2,'GET', $status, $message, '',$this->realm);
	
	if($status == '200'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}



}


//////////////////////////////////modify Schedule////


function modifySchedule($zoneid,$id,$type,$SU_id=NULL,$name=NULL){
	
		$input=$this->session();
		$jsonData2 = array(
			'type'=> $type,
			'id'=> $SU_id,
			'name'=> $name
		);
	

		$data = json_encode($jsonData2);
	
	//print_r($data);
		 $url2=$input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans/'.$id.'/schedule';
	
		$ch2=curl_init();
	
		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

    $response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Schedule', $url2,'PATCH', $status, $message, $url2,$this->realm);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	
		curl_close($ch2);
		
	}






//////////////////////////////////////////////////////////////////////
/////////////////////////////Access Control List//////////////////////
/////////////////////////////////////////////////////////////////////


public function ACLupdate($zoneid,$id,$name,$ACLid,$name){
	
	$input=$this->session();
	$jsonData2 = array(
			'id'=> $ACLid,
			'name'=> $name
	);
	
	$data = json_encode($jsonData2);
	
	
	$url2=$input[baseurl].'/api/public//v2_1/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';
	
	$ch2=curl_init();
	
	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

    $response=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'ACL Update', $url2,'PATCH', $status, $message, '',$this->realm);
	
	if($status == '204'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}
	
	curl_close($ch2);
		
	
}

//////////////////////////Delete ACL/////////////////////////
public function ACLdelete($zoneid,$id){
	
	$input=$this->session();
	
	$curl = curl_init($input[baseurl].'/api/public/v2_1/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL');
	
	
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    // Make the REST call, returning the result
	$response = curl_exec($curl);
	
	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'Delete ACL', $url2,'DELETE', $status, $message, '',$this->realm);
	
	if($status == '204'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}
	
	
}

/////////////////////////////Retrieve Client List apmac//////////////////////////
public function retrieveopapmaclist($apmac){

	$input=$this->session();


	echo $url2=$input[baseurl].'/api/public/v2_1/aps/'.$apmac.'/operational/client';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

    $resultl=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Retrieve UTP', $url2,'GET', $status, $message, '',$this->realm);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}



}




/////////////////retrieve APmac details///////////////////
	
	 public function retrieveAPmac($mac){
		
		$input=$this->session();
		
	 $url2=$input[baseurl].'/api/public/v2_1/aps/'.$mac;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

         curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

         $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve APmac details', $url2,'GET', $status, $message, $url2,$this->realm);
		
		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}


//show hide SSID


function hideSSID($zoneid,$id,$enable){
	
	$input=$this->session();
	$jsonData2 = array(
			'hideSsidEnabled'=> $enable
	);
	
	$data = json_encode($jsonData2);
	
	
	$url2=$input[baseurl]."/api/public/v2_1/rkszones/$zoneid/wlans/$id/advancedOptions";
	
	$ch2=curl_init();
	
	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

    $response=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	//$this->log(__FUNCTION__,'ACL Update', $url2,'PATCH', $status, '', '');
	
	$this->log(__FUNCTION__,'Hide SSID', $url2,'PATCH', $status, $message, $url2,$this->realm);
	
	if($status == '204'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}
	
	curl_close($ch2);
		
	
}	


public function Functionlist(){
		
		$jsonData_funtionlist = array(
			'createUTP'=> 'Create UTP',
			'createzone'=> 'Create Zones',
			'createnetwork'=> 'Create Network',
			'deleteeutp'=> 'Delete UTP',
			'rkszones'=> 'Check Zones',
			'retrieveNetworkList'=> 'SSID List',
			'retrieveaplistzone'=> 'APs retrieved from Zone ID',
			'modifynetwork'=> 'Modify Network',
			'retrieveSchedulelist'=> 'Retrieve scheduler List',
			'modifynetworkEncryption'=> 'Modify Encryption',
			'retrieveOneNetwork'=> 'Retrieve one SSID',
			'createScheduler'=> 'Create Scheduler',
			'deleteeScheduler'=> 'Delete Scheduler',
			'modifySchedule'=> 'Modify Schedule',
			'retrieveTunnelGREProfile'=> 'Retrieve Tunnel GRE',
			'modifyTunnelProfile'=> 'Modify Tunnel Profile',
			'deletezone'=> 'Delete zone',
			'retrieveZonedata'=> 'Retrieve Zone details',
			'modifyZoneTimeZone'=> 'Modify Zone Timezone',
			'modifyzone'=> 'Modify Zone',
			'retrieveAPmac'=> 'Retrieve APmac details',
			'hideSSID'=> 'Hide SSID'
		);

	return	$data = json_encode($jsonData_funtionlist);
		
	}

	
}

?>