<?php
require_once __DIR__.'/../apClass.php';
require_once __DIR__.'/../ruckus.php';
class ap_wag extends ruckus
{
    protected $url_postfix = '/api/public/v4_0';
    protected $ap;
	
	public function __construct($ap=NULL)
	{
        $this->ap = $ap;
        parent::__construct();
	
	}
	
	
	public function getConfig($field)
	{
		$db_class = new db_functions();
		$profile_name = $this->profile_name;
		$query = "SELECT $field AS f FROM exp_wag_ap_profile WHERE wag_ap_name = '$profile_name' LIMIT 1";
		$query_results = $db_class->selectDB($query);
        foreach($query_results['data'] AS $row){
			return $row['f'];
		}
	}

	public function getAPGroups($zone)
    {

		$input=$this->session();

        $url2 = $input[baseurl].'/api/public/v4_0/rkszones/' . $zone . '/apgroups';
        

        //$data = $this->call(__FUNCTION__, $url2, 'GET');
        

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
        
        $myText = (string)$message;
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        
        $this->log(__FUNCTION__,'Retrieve AP Groups', $url2,'GET', $status, $myText, $url2,$this->realm);

        if ($status == '200') {

            $res = json_decode($message, true);

            return ['status' => true, "status_code" => 200, "data" => $res['list']];
        } else {
            return ['status' => false, "status_code" => $status, "error" => $message];
        }
    }

	

	    ////////////////Get Wlan Groups/////////
    public function getWLanGroups($zone_id)
    {
        $input=$this->session();

        $url2 = $input[baseurl] . '/rkszones/' . $zone_id . '/wlangroups';
        
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
        
        $myText = (string)$message;
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
        
        $this->log(__FUNCTION__,'Get WlLan Groups', $url2,'GET', $status, $myText, $url2,$this->realm);

        if ($status == '200') {
            $res = json_decode($message, true);
            return ['status' => true, "status_code" => 200, "data" => $res];
        } else {
            return ['status' => false, "status_code" => $status, "error" => $message];
        }
    }

    public function modifyavcEnabled($zoneid, $id, $avcEnabled)
    {

    	$message = 'Not allowed in this vsz version. return success';
    	$this->log(__FUNCTION__,'Modify AVCEnabled', $url2,'GET', $status, $message, $url2,$this->realm);
    	return 'status=success&status_code=200&Description=' . $message;
    }

    ///////Query Client///////////////
    public function queryClient(array $filters){


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
	/////////////////////////
	
	
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
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`, unixtimestamp)
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

    ///////////////rkszones/////////////////
    public function retrieveAPOperationalSummary($apmac){

        $input=$this->session();
        //$login=$this->login();

        $url2=$input[baseurl].'/api/public/v4_0/aps/'.$apmac.'/operational/summary';
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

        $this->log(__FUNCTION__,'AP Operational Summary', $url2,'GET', $status, $header, '',$this->realm);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }

    }



    ///////////////rkszones/////////////////
    public function retrieveAPMacList($apmac){

        $input=$this->session();
        //$login=$this->login();

        $url2=$input[baseurl].'/api/public/v4_0/aps/'.$apmac.'/operational/client';
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

        $this->log(__FUNCTION__,'AP Client details', $url2,'GET', $status, $header, '',$this->realm);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }

    }



    ///////////////rkszones/////////////////
	public function rkszones(){
		
		$input=$this->session();
		//$login=$this->login();
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones';
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
		
		$myText = (string)$message;
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $myText, $url2,$this->realm);
		
//$this->log(__FUNCTION__,'Check Zones', $url2 ,'GET', $status , $message , '');
		
		//echo $message;
        if($status == '200' || $status=='204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
	

	}
	
	///////////////creat zones/////////////////
	
	public function createzone($name,$setuname,$setpassword){
		
		$input=$this->session();
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones';
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

		

		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid;

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
	
	///////////////creat network///////////////
	 public function createnetwork($zoneid,$name,$ssid){
	
		$input=$this->session();
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans';
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




///////////////////////////////////delete netword/////////////////////
	function deleteSSID($zone,$id){

		$input=$this->session();

		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zone.'/wlans/'.$id;

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

		$this->log(__FUNCTION__,'Delete Network', $url2,'DELETE', $status, $message, '',$this->realm);

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


		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id;

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
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans';
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
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id;
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
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid;
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
	
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/timezone';
	
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
				'mfp' => 'disabled',
				'support80211rEnabled' => false
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);
	
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id.'/encryption';
	
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
		$url2=$input[baseurl].'/api/public/v4_0/aps';
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
	
	
		$url2=$input[baseurl].'/api/public/v4_0/aps';
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
	
	
		$url2=$input[baseurl].'/api/public/v4_0/aps?zoneId='.$zoneid;
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
	
////////////////////////////////////////////////////////////////////


	/////////////////zone delete////////////////////v4_0/profiles/utp/{id}

	function deletezone($id){

		$input=$this->session();

		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$id;

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
	

		///////////////////////////////////////////////////////////////////////
		///////////////////////////USER TRAFFIC PROFILE////////////////////////
		//////////////////////////////////////////////////////////////////////




	///////////////////create utp///////////////////
	public function createUTP($name,$defaultAction){
	
		$input=$this->session();
	
		$url2=$input[baseurl].'/api/public/v4_0/profiles/utp';
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
	
	
		$url2=$input[baseurl].'/api/public/v4_0/profiles/utp/'.$id;
	
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
		
		$this->log(__FUNCTION__,'Modify UTP', $url2,'PATCH', $status, $message, $data,$this->realm );
		
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
		
		
		$url2=$input[baseurl].'/api/public/v4_0/profiles/utp';
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
		
		$url2=$input[baseurl].'/api/public/v4_0/profiles/utp/'.$id;
	
		$curl = curl_init($input[baseurl].'/api/public/v4_0/profiles/utp/'.$id.'');
	
	
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

		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlanSchedulers';
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
		
		$this->log(__FUNCTION__,'Create Scheduler', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);
		
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
		
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlanSchedulers/'.$id;
	
		$curl = curl_init($input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlanSchedulers/'.$id.'');
	
	
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


	$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlanSchedulers';
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
	
	$this->log(__FUNCTION__,'retrieve scheduler List', $url2,'GET', $status, $message, $url2,$this->realm);
	
	if($status == '200'){
	
		return 'status=success&status_code=200&Description='.$message;
	
	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;
	
	}



}




function modifySchedule($zoneid,$id,$type,$SU_id=NULL,$name=NULL){
	
		$input=$this->session();
		$jsonData2 = array(
			'type'=> $type,
			'id'=> $SU_id,
			'name'=> $name
		);
	

		$data = json_encode($jsonData2);
	
	//print_r($data);
		 $url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id.'/schedule';
	
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
		
		$this->log(__FUNCTION__,'Modify Schedule', $url2,'PATCH', $status, $message, $data,$this->realm);
		
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


public function ACLupdate($zoneid,$id,$name,$ACLid){
	
	$input=$this->session();
	$jsonData2 = array(
			'id'=> $ACLid,
			'name'=> $name
	);
	
	$data = json_encode($jsonData2);
	
	
	$url2=$input[baseurl].'/api/public//v4_0/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';
	
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
	
	$this->log(__FUNCTION__,'ACL Update', $url2,'PATCH', $status, $message, $data,$this->realm);
	
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
	$url2 = $input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';
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


	echo $url2=$input[baseurl].'/api/public/v4_0/aps/'.$apmac.'/operational/client';
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



/////////////////////////////Retrieve Client List apmac//////////////////////////
	public function retrieveTunnelGREProfile($tunnelType){

		$input=$this->session();


		$url2=$input[baseurl].'/api/public/v4_0/profiles/tunnel/'.$tunnelType;
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


		$this->log(__FUNCTION__,'Retrieve Tunnel GRE', $url2,'GET', $status, $message, '',$this->realm);

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
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/tunnelProfile';

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


		$this->log(__FUNCTION__,'Modify Tunnel Profile', $url2,'PATCH', $status, $message, $data,$this->realm);

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
		
	 $url2=$input[baseurl].'/api/public/v4_0/aps/'.$mac;
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
	
	
	$url2=$input[baseurl]."/api/public/v4_0/rkszones/$zoneid/wlans/$id/advancedOptions";
	
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
	 /////////////////retrieve DNS Profile details///////////////////

	 public function retrieveDNSServerProfile(){

        $input=$this->session();

        $url2=$input[baseurl].'/api/public/v4_0/profiles/dnsserver';
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

        $this->log(__FUNCTION__,'Retrieve DNS Server Profile', $url2,'GET', $status, $message, $url2,$this->realm);

        $message = urlencode($message);

        if($status == '200'){

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
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/aaa/radius';
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
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/aaa/radius';
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
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/aaa/radius/'.$id;
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
	
		$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/aaa/radius/'.$id;

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

public function create802($zoneid,$name,$ssid,$id,$au_name,$method,$algorithm){

//$input=$this->session();

$input=$this->session();
	
$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/standard80211';
$ch2 = curl_init($url2);

$jsonData2 = array(

	'name'   => $name,
	'ssid'   => $ssid,
	'authServiceOrProfile'   => array('throughController' => false,
							'id' => $id,
							'name' => $au_name)
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
							'name' => $au_name)/* ,
	  
	'encryption'   => array('method' => $method,
	'algorithm' => $algorithm,
	'mfp' => 'disabled') */
	/* 'advancedOptions'   => array(
	'support80211dEnabled' => false,
	'support80211kEnabled' => false), */
	
	
	);   
	//APLBO\",\"RuckusGRE
	//Encode the array into JSON.
	$data = json_encode($jsonData2);

	$input=$this->session();

	$url2=$input[baseurl].'/api/public/v4_0/rkszones/'.$zoneid.'/wlans/'.$id;

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

?>