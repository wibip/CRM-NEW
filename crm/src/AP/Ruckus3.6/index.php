<?php
require_once __DIR__.'/../apClass.php';
require_once __DIR__.'/../ruckus.php';

class ap_wag extends ruckus
{
    protected $url_postfix = '/wsg/api/public/v6_0';
    protected $ap;

	public function __construct($ap=NULL)
	{
        $this->ap = $ap;
        parent::__construct();
	
	}
	
	
	
	
	public function getConfig($field)
	{
		$db_class= new db_functions();
		$profile_name = $this->profile_name;
		$query = "SELECT $field AS f FROM exp_wag_ap_profile WHERE wag_ap_name = '$profile_name' LIMIT 1";
		$query_results = $db_class->selectDB($query);
        foreach($query_results['data'] AS $row){
			return $row['f'];
		}
	}

    /**
     * @param null $realm
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }
	
	public function getController()
    {
        return  $this->ap;
    }
	
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$rlm){

		$db_class= new db_functions();
		$api_details = $db_class->escapeDB($api_details);

		/* $query = "INSERT INTO `exp_wag_ap_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,unixtimestamp)
		VALUES ('$rlm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API', UNIX_TIMESTAMP())";
		$query_results=mysql_query($query); */


		$log = logObjectProvider::getLogObjectProvider()->getObjectVsz();

		//$log->

		$log->setFunction($function);
		$log->setFunctionName($function_name);
		$log->setDescription($description);
		$log->setApiMethod($method);
		$log->setApiStatus($api_status);
		$log->setApiDescription($api_details);
		$log->setApiData($api_data);
		$log->setRealm($rlm);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
	
	}
	

	//////////////////////////////////
    ///
    ///
    ///////////////query ap/////////////////

    public function queryAP(array $data){

        $input=$this->session();

        $url2=$input[baseurl].'/query/ap';
        $ch2 = curl_init($url2);

        //Encode the array into JSON.
        $jsonDataEncoded2 = json_encode($data);

        curl_setopt($ch2,CURLOPT_POST,1);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded2);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $result2 = curl_exec($ch2);
        //print_r(json_decode($result2));


        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($result2, 0, $header_size);
        $message = substr($result2, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Query AP', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

        curl_close ($ch2);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }

    }



    ///////////////rkszones/////////////////
	/*public function rkszones(){
		
		$input=$this->session();
		//$login=$this->login();
		
		$url2=$input[baseurl].'/rkszones?listSize=100000';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


        $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		$myText = (string)$message;
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $myText, '',$this->realm);
		
//$this->log(__FUNCTION__,'Check Zones', $url2 ,'GET', $status , $message , '');
		
		//echo $message;

		$message = urlencode($message);

        if($status == '200' || $status=='204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
	

	}
	*/
	///////////////creat zones/////////////////
	
	public function createzone($name,$setuname,$setpassword){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/rkszones';
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
        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Zones', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
		$message = urlencode($message);

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

		

		$url2=$input[baseurl].'/rkszones/'.$zoneid;

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Zone', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		$message = urlencode($message);

		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}

		curl_close($ch2);
	
	}
	
		/////////////////////////////////////////////////////////////////////////
				///////modify zone///////////////
	public function moveAPToZone($zoneId,$apMac,$apName,$apDescription){

		$input=$this->session();

		$jsonData2 = array(
            "zoneId"=> $zoneId,
            "name"=> $apName,
            "description"=> $apDescription
        );
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);



		$url2=$input[baseurl].'/aps/'.$apMac;

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);

		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Move AP to Zone', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);
        curl_close($ch2);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////wlans SSID//////////////////////////////////
		////////////////////////////////////////////////////////////////////////
	
	///////////////creat network///////////////
	 public function createnetwork($zoneid,$name,$ssid, array $data = NULL){
	
		$input=$this->session();
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans';
		$ch2 = curl_init($url2);
	
		$jsonData2 = array(
	
			'name'   => $name,
			'ssid'   => $ssid,
			'vlan' => array('accessVlan' => (int)$accessVlan)
		);

		if ($data != NULL) {
			$jsonData2 = array_merge($jsonData2,$data);
		}
	
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

         //ADD FROM RACUS V5
         curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
         curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
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
		
		$message = urlencode($message);

		if($status == '201'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
	
		curl_close ($ch2);
		
	}




///////////////////////////////////delete netword/////////////////////
	function deleteSSID($zone,$id){

		$input=$this->session();

		$url2=$input[baseurl].'/rkszones/'.$zone.'/wlans/'.$id;

		$curl = curl_init($url2);



		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		// Make the REST call, returning the result
		$response = curl_exec($curl);

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Delete Network', $url2,'DELETE', $status, $message, '',$this->realm);

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}


	///////modify network///////////////
	public function modifynetwork($zoneid,$id,$name,$ssid,$description,$tunnel){
	
		$input=$this->session();
	
		$jsonData2 = array(
		'name'=>$name,
		'ssid'=>$ssid,
		'description'=>$description,
		'accessTunnelType'=>$tunnel
		);
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id;

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Network', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		$message = urlencode($message);

		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}

		curl_close($ch2);
	
	}
	

	///////modify avcEnabled///////////////
	public function modifyavcEnabled($zoneid,$id,$avcEnabled){
	
		$input=$this->session();
		
		if($avcEnabled==NULL||$avcEnabled==""){
			$jsonData2 = array(
				'advancedOptions'=>array('avcEnabled'=>false)
				);
		}
		else{
			$jsonData2 = array(
				'advancedOptions'=>array('avcEnabled'=>$avcEnabled));
		}
		
		
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id;

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify AVCEnabled', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		$message = urlencode($message);

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
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		if($icom==NULL||$icom==""){
			
			$this->log(__FUNCTION__,'SSID List', $url2,'GET', $status, $message, '',$this->realm);
			
		}else{

		$this->log(__FUNCTION__,'SSID List', $url2,'GET', $status, $message, '',$icom);
			
		}

		$message = urlencode($message);
		
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
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'retrieve one SSID', $url2,'GET', $status, $message, '',$this->realm);
		
		$message = urlencode($message);

		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}

/////////////////retrieve 1 ssid details///////////////////

    public function retrieveAPOperationalSummary($apmac){

        $input=$this->session();

        $url2=$input[baseurl].'/aps/'.$apmac.'/operational/summary';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'AP Operational Summary', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



/////////////////retrieve 1 ssid details///////////////////

    public function retrieveAPMacList($apmac){

        $input=$this->session();

        $url2=$input[baseurl].'/aps/'.$apmac.'/operational/client';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'AP Client details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

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
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve Zone details', $url2,'GET', $status, $message, '',$this->realm);
		
		$message = urlencode($message);

		if($status == '200'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
		
		
	}
	

    /////////////////retrieve zone Mesh details///////////////////

	public function retrieveZoneMeshData($zoneid){

		$input=$this->session();

		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/mesh';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);

		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Retrieve Zone Mesh Details', $url2,'GET', $status, $message, '',$this->realm);

		$message = urlencode($message);

		if($status == '200'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

		////////////Modify zone time zone/////////////////
	public function modifyZoneTimeZone($zoneid,$abbreviation,$gmtOffset,$gmtOffsetMinute,$timeZone=null){
	
		$input=$this->session();
	
		$jsonData2 = array(
		
				'customizedTimezone'   => array('abbreviation' => $abbreviation,
												'gmtOffset' => $gmtOffset,
												'gmtOffsetMinute' => $gmtOffsetMinute)
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/timezone';
	
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Zone Timezone', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		$message = urlencode($message);

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
				'mfp' => 'disabled',
				'support80211rEnabled' => false
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id.'/encryption';
	
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Encryption', $url2,'PATCH', $status, $message, $data,$this->realm);
		
		$message = urlencode($message);

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
	
	
	
	
	public function createap($zoneid,$mac,$description=null){
	
		$input=$this->session();
		$url2=$input[baseurl].'/aps';
		$ch2 = curl_init($url2);
	
		$jsonData2 = array(
            'mac'   => $mac,
            'zoneId'   => $zoneid,
            'name' =>'ROOT',
            'administrativeState'=>'Unlocked'
		);

		if(!is_null($description)){
		    $jsonData2['description']=$description;
        }
	
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
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
		
		$message = urlencode($message);

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
	
	
		$url2=$input[baseurl].'/aps';
		$ch2 = curl_init($url2);
	
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
	
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


		$resultl=curl_exec($ch2);
	
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
	
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
		$this->log(__FUNCTION__,'retrieve scheduler List', $url2,'GET', $status, $message, '',$this->realm);
	
		$message = urlencode($message);

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
	
	
		$url2=$input[baseurl].'/aps?zoneId='.$zoneid;
		$ch2 = curl_init($url2);
	
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
	
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);
	
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
	
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
		if($icom==NULL||$icom==""){
			
			$this->log(__FUNCTION__,'APs retrieve from zoneid', $url2,'GET', $status, $message, '',$this->realm);
			
		}else{

		$this->log(__FUNCTION__,'APs retrieve from zoneid', $url2,'GET', $status, $message, '',$icom);
			
		}

		$message = urlencode($message);
	
		if($status == '200'){
	
			return 'status=success&status_code=200&Description='.$message;
	
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
	
		}
	
	
	
	}
	
////////////////////////////////////////////////////////////////////


	/////////////////zone delete////////////////////v6_0/profiles/utp/{id}

	function deletezone($id){

		$input=$this->session();

		$url2=$input[baseurl].'/rkszones/'.$id;

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		// Make the REST call, returning the result
		$response = curl_exec($curl);

		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

		$this->log(__FUNCTION__,'Delete zone', $url2,'DELETE', $status, '', '');

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}




	/////////////////////////////////////////////////////////////////////////
	

		///////////////////////////////////////////////////////////////////////
		///////////////////////////USER TRAFFIC PROFILE////////////////////////
		//////////////////////////////////////////////////////////////////////




	///////////////////create utp///////////////////
	public function createUTP($name,$defaultAction){
	
		$input=$this->session();
	
		$url2=$input[baseurl].'/profiles/utp';
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create UTP', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);
		
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
	
	
		$url2=$input[baseurl].'/profiles/utp/'.$id;
	
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify UTP', $url2,'PATCH', $status, $message, $data,$this->realm );

		$message = urlencode($message);
		
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
		
		
		$url2=$input[baseurl].'/profiles/utp';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve UTP', $url2,'GET', $status, $message, '',$this->realm);

		$message = urlencode($message);
		
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
		
		$url2=$input[baseurl].'/profiles/utp/'.$id;
	
		$curl = curl_init($url2);
	
	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	
		// Make the REST call, returning the result
		$response = curl_exec($curl);
		
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Delete UTP', $url2,'DELETE', $status, $message, '',$this->realm);

		$message = urlencode($message);
		
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

		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlanSchedulers';
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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
		$result2 = curl_exec($ch2);
		//print_r(json_decode($result2));
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($result2, 0, $header_size);
		$message = substr($result2, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Create Scheduler', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);
		
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
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlanSchedulers/'.$id;
	
		$curl = curl_init($url2);
	
	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt ($curl, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	
		// Make the REST call, returning the result
		$response = curl_exec($curl);
		
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Delete Scheduler', $url2,'DELETE', $status, $message, '',$this->realm);

		$message = urlencode($message);
		
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


	$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlanSchedulers';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

    //ADD FROM RACUS V5
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$resultl=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'retrieve scheduler List', $url2,'GET', $status, $message, '',$this->realm);

	$message = urlencode($message);
	
	if($status == '200'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}



}


///////////////////retrieve scheduler///////////////////
    public function retrieveSchedule($zoneID,$scheduleID){

        $input=$this->session();


        $url2=$input[baseurl].'/rkszones/'.$zoneID.'/wlanSchedulers/'.$scheduleID;
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Retrieve Scheduler', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


///////////////////Modify Power scheduler Times///////////////////
    public function modifyPowerSchedule($zoneID,$scheduleID,array $data_ar){

        $input=$this->session();

        $data = json_encode($data_ar);

        $url2=$input[baseurl].'/rkszones/'.$zoneID.'/wlanSchedulers/'.$scheduleID;
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
        $api_data = $url2.". Json data -> ".$data;

        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Modify Power Schedule', $url2,'PATCH', $status, $message,$api_data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



//////////////////////////Modify WLan Schedule //////////////////////////////////////////////////////
    function modifySchedule($zoneid,$id,$type,$SU_id=NULL,$name=NULL){
	
		$input=$this->session();
		$jsonData2 = array(
			'type'=> $type,
			'id'=> $SU_id,
			'name'=> $name
		);
	

		$data = json_encode($jsonData2);
	
	//print_r($data);
		 $url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id.'/schedule';
	
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

    //ADD FROM RACUS V5
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
		$response=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Modify Schedule', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);
		
		if($status == '204'){
		
			return 'status=success&status_code=200&Description='.$message;
		
		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;
		
		}
		
	

		
	}




//////////////////////////////////////////////////////////////////////
/////////////////////////////Access Control List//////////////////////
/////////////////////////////////////////////////////////////////////


public function ACLupdate($zoneid,$id,$name,$ACLid){
	
	$input=$this->session();
	$jsonData2 = array(
			'id'=> $ACLid,
			'name'=> $name
	);
	
	$data = json_encode($jsonData2);
	
	
	$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';
	
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

    //ADD FROM RACUS V5
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
	$response=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'ACL Update', $url2,'PATCH', $status, $message, $data,$this->realm);

	$message = urlencode($message);
	
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
	$url2 = $input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';

	$curl = curl_init($url2);
	
	
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
	
	// Make the REST call, returning the result
	$response = curl_exec($curl);
	
	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	
	
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	$this->log(__FUNCTION__,'Delete ACL', $url2,'DELETE', $status, $message, '',$this->realm);

	$message = urlencode($message);
	
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


	$url2=$input[baseurl].'/aps/'.$apmac.'/operational/client';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

    //ADD FROM RACUS V5
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$resultl=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Retrieve UTP', $url2,'GET', $status, $message, '',$this->realm);

	$message = urlencode($message);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}



}



/////////////////////////////Retrieve Client List apmac//////////////////////////
	public function retrieveTunnelGREProfile($tunnelType){

		$input=$this->session();


		$url2=$input[baseurl].'/profiles/tunnel/'.$tunnelType;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$resultl=curl_exec($ch2);

		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


		$this->log(__FUNCTION__,'Retrieve Tunnel GRE', $url2,'GET', $status, $message, '',$this->realm);

		$message = urlencode($message);

		if($status == '200'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}




//////////modify tunnel profile/////


	function modifyTunnelProfile($zoneid,$tunnelProfileID,$tunnelProfileName){
		//
		$input=$this->session();
		$jsonData2 = array(
			'id'=> $tunnelProfileID,
			'name'=> $tunnelProfileName
		);

		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);

		//print_r($data);
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/tunnelProfile';

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);

		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


		$this->log(__FUNCTION__,'Modify Tunnel Profile', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}


		curl_close($ch2);

	}
	
	
	
		/////////////////retrieve APmac details///////////////////
	
	 public function retrieveAPmac($mac){
		
		$input=$this->session();
		
	 $url2=$input[baseurl].'/aps/'.$mac;
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

         //ADD FROM RACUS V5
         curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
         curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
         curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
		
		$resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);
		
		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Retrieve APmac details', $url2,'GET', $status, $message, '',$this->realm);

		$message = urlencode($message);
		
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
	
	
	$url2=$input[baseurl]."/rkszones/$zoneid/wlans/$id/advancedOptions";
	
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

    //ADD FROM RACUS V5
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
    curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
	
	$response=curl_exec($ch2);
	
	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
	
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);
	
	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

    curl_close($ch2);
	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
	
	//$this->log(__FUNCTION__,'ACL Update', $url2,'PATCH', $status, '', '');
	
	$this->log(__FUNCTION__,'Hide SSID', $url2,'PATCH', $status, $message, '',$this->realm);


	$message = urlencode($message);
	
	if($status == '204'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}
	

		
	
}


    /////////////////retrieve DNS Profile details///////////////////

    public function retrieveDNSServerProfile(){

        $input=$this->session();

        $url2=$input[baseurl].'/profiles/dnsserver';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Retrieve DNS Server Profile', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


    /////////////////create DNS Profile details///////////////////

    public function createDNSServerProfile($data){

        $input=$this->session();

        $data = json_encode($data);

        $url2=$input[baseurl].'/profiles/dnsserver';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'POST');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Create DNS Server Profile', $url2,'POST', $status, $message, $url2,$this->realm);

        $message = urlencode($message);

        if($status == '201'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

/////////////////modify DNS Profile details///////////////////

    public function modifyZoneDNSServerProfile($zone,$dnsProfileId,$dnsProfileName){

        $wlans = $this->retrieveNetworkList($zone,$this->realm);
        parse_str($wlans,$wlan_responce);
        $wlans_dis =  json_decode($wlan_responce['Description'],true);
        $wlan_list = $wlans_dis['list'];
        $status = '200';
        foreach ($wlan_list as $value){
            $wLanDNSUpdate = $this->modifyWLanDNSServerProfile($zone,$value['id'],$dnsProfileId,$dnsProfileName);
            parse_str($wLanDNSUpdate,$wLanDNSUpdateArray);

            if($wLanDNSUpdateArray['status']=='failed'){
                $status = '400';
                break;
            }

        }

        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        $url2 = '';
        $message = 'modifyWLanDNSServerProfile()';
        $this->log(__FUNCTION__,'Modify DNS Server Profile', $url2,'PATCH', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



    /////////////////modify DNS Profile details///////////////////

    public function disableZoneDNSServerProfile($zone){

        $wlans = $this->retrieveNetworkList($zone,$this->realm);
        parse_str($wlans,$wlan_responce);
        $wlans_dis =  json_decode($wlan_responce['Description'],true);
        $wlan_list = $wlans_dis['list'];
        $status = '200';
        foreach ($wlan_list as $value){
            $wLanDNSUpdate = $this->disableWLanDNSServerProfile($zone,$value['id']);
            parse_str($wLanDNSUpdate,$wLanDNSUpdateArray);

            if($wLanDNSUpdateArray['status']=='failed'){
                $status = '400';
                break;
            }

        }

        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        $url2 = '';
        $message = 'disableWLanDNSServerProfile()';
        $this->log(__FUNCTION__,'Disable DNS Server Profile', $url2,'DELETE', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



    /////////////////modify wlan DNS Profile details///////////////////

    public function modifyWLanDNSServerProfile($zone,$id,$dnsProfileId,$dnsProfileName){

        $input=$this->session();

        $data = json_encode(array("id"=>$dnsProfileId,"name"=>$dnsProfileName));

        $url2=$input[baseurl].'/rkszones/'.$zone.'/wlans/'.$id.'/dnsServerProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PATCH');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        $url2 = $url2.$data;
        $this->log(__FUNCTION__,'Modify WLan DNS Server Profile', $url2,'PATCH', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }





    /////////////////modify wlan DNS Profile details///////////////////

    public function disableWLanDNSServerProfile($zone,$id){

        $input=$this->session();

        //$data = json_encode(array("id"=>$dnsProfileId,"name"=>$dnsProfileName));

        $url2=$input[baseurl].'/rkszones/'.$zone.'/wlans/'.$id.'/dnsServerProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        //curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        //$url2 = $url2.$data;
        $this->log(__FUNCTION__,'Disable WLan DNS Server Profile', $url2,'DELETE', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



    ////////////Modify mesh option/////////////////
    public function modifyAPmeshOption($ap_mac,$meshMode,$upLinkSelection=null,array $meshUpLinkEntryList=null){

        $input=$this->session();

        $jsonData2 = array(
            'meshMode'   => $meshMode,
        );
        if(!is_null($upLinkSelection)){
            $jsonData2['uplinkSelection'] = $upLinkSelection;
        }
        if(!is_null($meshUpLinkEntryList)){
            $jsonData2['meshUplinkEntryList'] = $meshUpLinkEntryList;
        }

        $data = json_encode($jsonData2);

        $url2=$input[baseurl].'/aps/'.$ap_mac.'/meshOptions';

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Modify AP Mesh Option', $url2,'PATCH', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }




    }

/////////////////////////////////////////////////////////////////////////

////////////Disable mesh option/////////////////
    public function disableAPmeshOption($ap_mac){

        $input=$this->session();

        $url2=$input[baseurl].'/aps/'.$ap_mac.'/meshOptions';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'DELETE');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Disable AP Mesh Option', $url2,'DELETE', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }




    }

/////////////////////////////////////////////////////////////////////////



/////////////////get DHCP Pool List///////////////////

    public function getZoneDHCPProfile($zoneID){

        $input=$this->session();

        $url2=$input[baseurl].'/rkszones/'.$zoneID.'/dhcpSite/dhcpProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Get Zone DHCP Pool List', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


/////////////////////////////////////////////////////////////////////////


    ///////modify zone dhcpSiteConfig///////////////
    public function modifyZoneDHCPSiteConfig($zoneId,$siteEnabled,$manualSelect,$siteMode,array $siteAps , array $siteProfileIds ){

        $input=$this->session();


        $jsonData2 = array(
            'siteEnabled'=>$siteEnabled,
            'manualSelect'=>$manualSelect,
            'siteMode'=>$siteMode,
            'siteAps'=>$siteAps,
            'siteProfileIds'=>$siteProfileIds,
        );

        $data = json_encode($jsonData2);

        $url2=$input[baseurl].'/rkszones/'.$zoneId.'/dhcpSiteConfig';

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Modify Zone DHCP Site Config', $url2,'PATCH', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    /////////////////////////////////////////////////////////////////////////

    /////////////////reboot AP///////////////////

    public function rebootAP($APMac){

        $input=$this->session();

        $url2=$input[baseurl].'/aps/'.$APMac.'/reboot';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'PUT');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Reboot AP', $url2,'PUT', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



    /////////////////delete AP///////////////////

    public function deleteAP($APMac){

        $input=$this->session();

        $url2=$input[baseurl].'/aps/'.$APMac;
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $message = substr($resultl, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Delete AP', $url2,'DELETE', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

/////////////////////////////////////////////////////////////////////////

    ///////Query Client///////////////
    public function queryClient(array $filters ){

        $input=$this->session();


        $jsonData2 = array(
            'filters'=>$filters,
        );

        $data = json_encode($jsonData2);

        $url2=$input[baseurl].'/query/client?listSize=100000';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Query Client From VSZ', $url2,'POST', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    /////////////////////////////////////////////////////////////////////////


            ///////modify DhcpProfile///////////////
    public function modifyDhcpProfile($zoneId,$id, array $jsonData2 ){

        $input=$this->session();

        $data = json_encode($jsonData2);

        $url2=$input[baseurl].'/rkszones/'.$zoneId.'/dhcpSite/dhcpProfile/'.$id;

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

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response=curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__,'Modify DHCP Profile', $url2,'PATCH', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

	
/////// create a new Zone AAA.///////////////
	
public function createZoneAAA($zoneid,$name,$port,$primary_ip,$sharedSecret,$second=NULL,$seprimary_ip,$sesharedSecret){

	//$input=$this->session();
	$input=$this->session();
		//$login=$this->login();
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/aaa/radius';
	$ch2 = curl_init($url2);

	if($second == NULL){

	$jsonData2 = array(

		'name'   => $name,
		'primary'   => array('ip' => $primary_ip,
								'port' => (int)$port,
								'sharedSecret' => $sharedSecret)
	);
}else{

	$jsonData2 = array(

		'name'   => $name,
		'primary'   => array('ip' => $primary_ip,
								'port' => (int)$port,
								'sharedSecret' => $sharedSecret),
		
		'secondary'   => array('ip' => $seprimary_ip,
										'port' => (int)$port,
										'sharedSecret' => $sesharedSecret)								
			);
		
}
	
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

	 //ADD FROM RACUS V5
	 curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
	 curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
	 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	//output is ID
	$result2 = curl_exec($ch2);
	//print_r(json_decode($result2));


	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($result2, 0, $header_size);
	$message = substr($result2, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Create New Zone AAA', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

	$message = urlencode($message);

	if($status == '201'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}



	curl_close ($ch2);

}



/////////////////////////////Retrieve Zone AAA//////////////////////////
public function retrieveZoneAAA($zoneid){

//$input=$this->session();


$input=$this->session();
		//$login=$this->login();
		
$url2=$input[baseurl].'/rkszones/'.$zoneid.'/aaa/radius';
$ch2 = curl_init($url2);

curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch2,CURLOPT_HEADER,1);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch2, CURLOPT_VERBOSE, 1);

//ADD FROM RACUS V5
curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

$resultl=curl_exec($ch2);

$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

$header = substr($resultl, 0, $header_size);
$message = substr($resultl, $header_size);

$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

$this->log(__FUNCTION__,'Retrieve Zone AAA', $url2,'GET', $status, $message, '',$this->realm);

$message = urlencode($message);

if($status == '200'){

	return 'status=success&status_code=200&Description='.$message;

}
else{
	return 'status=failed&status_code='.$status.'&Description='.$message;

}



}




/////////////////////////////Retrieve Zone AAA//////////////////////////
public function retrieveZoneAAAID($zoneid,$id){

	//$input=$this->session();


	$input=$this->session();
		//$login=$this->login();
	$url2=$input[baseurl].'/rkszones/'.$zoneid.'/aaa/radius/'.$id;
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$input[cookie]."",'Content-Type: application/json;charset=UTF-8'));

	curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch2,CURLOPT_HEADER,1);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');

	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch2, CURLOPT_VERBOSE, 1);

	//ADD FROM RACUS V5
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
	curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$resultl=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($resultl, 0, $header_size);
	$message = substr($resultl, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Retrieve Zone AAA ID', $url2,'GET', $status, $message, '',$this->realm);

	$message = urlencode($message);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}



}


///////modify zone AAA ID///////////////
public function modifyZoneAAA($zoneid,$id,$name,$primary_ip,$port,$sharedSecret,$second=NULL,$seprimary_ip,$sesharedSecret){

	//$input=$this->session();

	if($second==NULL){

	$jsonData2 = array(

"name"  => $name,
'primary'   => array('ip' => $primary_ip,
								'port' => (int)$port,
								'sharedSecret' => $sharedSecret),
	);


}else{

	$jsonData2 = array(

		"name"  => $name,
		'primary'   => array('ip' => $primary_ip,
										'port' => (int)$port,
										'sharedSecret' => $sharedSecret),
		'secondary'   => array('ip' => $seprimary_ip,
										'port' => (int)$port,
										'sharedSecret' => $sesharedSecret)								
			);
		
}
	//APLBO\",\"RuckusGRE
	//Encode the array into JSON.
	$data = json_encode($jsonData2);



	$input=$this->session();
		//$login=$this->login();
		
		$url2=$input[baseurl].'/rkszones/'.$zoneid.'/aaa/radius/'.$id;

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

	//ADD FROM RACUS V5
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
	curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$response=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Modify Zone AAA ID', $url2,'PATCH', $status, $message, $data,$this->realm);

	$message = urlencode($message);

	if($status == '204'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}

	curl_close($ch2);

}



/////// create a create - 802.1x.///////////////

public function create802($zoneid,$name,$ssid,$id,$au_name,$method,$algorithm,array $data = NULL){
$input=$this->session();
		//$login=$this->login();
$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/standard8021X';
$ch2 = curl_init($url2);

$jsonData2 = array(

	'name'   => $name,
	'ssid'   => $ssid,
	'authServiceOrProfile'   => array('throughController' => false,
							'id' => $id,
							'name' => $au_name),

	'vlan' => array('accessVlan' => (int)$accessVlan),
	'encryption'   => array('method' => $method,
	'algorithm' => $algorithm,
	'mfp' => 'disabled')
);

if ($data != NULL) {
	$jsonData2 = array_merge($jsonData2, $data);
}

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

 //ADD FROM RACUS V5
 curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
 curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

//output is ID
$result2 = curl_exec($ch2);
//print_r(json_decode($result2));


$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

$header = substr($result2, 0, $header_size);
$message = substr($result2, $header_size);

$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

$this->log(__FUNCTION__,'Create New 802.1X', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

$message = urlencode($message);

if($status == '201'){

	return 'status=success&status_code=200&Description='.$message;

}
else{
	return 'status=failed&status_code='.$status.'&Description='.$message;

}



curl_close ($ch2);

}

///////modify 802x///////////////


public function modify802($zoneid,$id,$name,$ssid,$au_id,$au_name,$method,$algorithm){
	
	//$input=$this->session();
	
	$jsonData2 = array(
	'name'   => $name,
	'ssid'   => $ssid,
	'authServiceOrProfile'   => array(
							'id' => $au_id,
							'name' => $au_name),
	  
	'encryption'   => array('method' => $method,
	'algorithm' => $algorithm,
	'mfp' => 'disabled')
	/* 'advancedOptions'   => array(
	'support80211dEnabled' => false,
	'support80211kEnabled' => false), */
	
	
	);   
	//APLBO\",\"RuckusGRE
	//Encode the array into JSON.
	$data = json_encode($jsonData2);

	$input=$this->session();

	$url2=$input[baseurl].'/rkszones/'.$zoneid.'/wlans/'.$id;

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

	//ADD FROM RACUS V5
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
	curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
	curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

	$response=curl_exec($ch2);

	$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);

	$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Modify 802.1x', $url2,'PATCH', $status, $message, $data,$this->realm);

	$message = urlencode($message);

	if($status == '204'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}

	curl_close($ch2);

}



}
