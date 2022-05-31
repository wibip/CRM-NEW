<?php
require_once __DIR__.'/../apClass.php';
require_once __DIR__.'/../ruckus.php';
class ap_wag extends ruckus
{
	protected $url_postfix = '/wsg/api/public/v9_1';
	protected $switch_url_postfix = '/switchm/api/v9_1';
    protected $ap;
    private $serviceTicket;
	protected $zoneListSize = 1000;

	public function __construct($ap=NULL)
	{
        $this->ap = $ap;
        parent::__construct();

        $this->serviceTicket = NULL;

	}

	public function getServiceTicket(){
        if($this->serviceTicket===NULL){
            $this->serviceTicket = $this->serviceTicket();
        }
        return $this->serviceTicket;
    }

    public function queryAP(array $data){

        //$input=$this->session();

        $url2=$this->baseurl.'/query/ap';

        $ch2 = curl_init($url2);

        //Encode the array into JSON.
        $jsonDataEncoded2 = json_encode($data);

        curl_setopt($ch2,CURLOPT_POST,1);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();
		//$login=$this->login();

		$url2=$this->baseurl.'/rkszones?listSize=100000';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


	}*/

	///////////////creat zones/////////////////

	public function createzone($name,$setuname,$setpassword,$domain_id=NULL,$latitude=NULL,$longitude=NULL,$jsonData2=NULL){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones';
		$ch2 = curl_init($url2);

		if(!empty($jsonData2)){
			$jsonData2['name'] = $name;

			//Change Schema
			$bandBalancing = $jsonData2['bandBalancing'];
			$clientLoadBalancing24 = $jsonData2['clientLoadBalancing24'];
			$clientLoadBalancing50 = $jsonData2['clientLoadBalancing50'];
			unset($jsonData2['clientLoadBalancing24']);
			unset($jsonData2['clientLoadBalancing50']);
			unset($jsonData2['bandBalancing']);
			$jsonData2['loadBalancing'] = [
				"clientLoadBalancing24"=>$clientLoadBalancing24,
				"clientLoadBalancing50"=>$clientLoadBalancing50,
				"bandBalancing"=>["wifi24Percentage"=>$bandBalancing['wifi24Percentage']]
			];
        }else{
            	$jsonData2 = array(
								'name'   => $name,
								'login'  => array('apLoginName' => $setuname,
													'apLoginPassword' => $setpassword)
							);

        }



		if(strlen($domain_id) > 0){
                $jsonData2['domainId'] = $domain_id;
            }
		if(strlen($latitude) > 0){
                $jsonData2['latitude'] = $latitude;
            }
		if(strlen($longitude) > 0){
                $jsonData2['longitude'] = $longitude;
            }


		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$jsonData2 = array(

    "tunnelType"  => $type,
	'tunnelProfile'   => array('id' => $id,
									'name' => $name)
		);
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);



		$url2=$this->baseurl.'/rkszones/'.$zoneid;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
        curl_close($ch2);
		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

    ///////MOve AP to zone///////////////
    public function moveAPToZone($zoneId,$apMac,$apName,$apDescription){

        //$input=$this->session();

        $jsonData2 = array(
            "zoneId"=> $zoneId,
            "name"=> $apName,
            "description"=> $apDescription
        );
        //APLBO\",\"RuckusGRE
        //Encode the array into JSON.
        $data = json_encode($jsonData2);



        $url2=$this->baseurl.'/aps/'.$apMac;

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Move AP to Zone', $url2,'PATCH', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    /////////////Get switch group details/////////////////////
    public function getGroupDetail($id){
        $url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));
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



        $this->log(__FUNCTION__,'Get Switch Groups Details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
    }



    /////////////////////////////////////////////////////////////////////////

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////wlans SSID//////////////////////////////////
		////////////////////////////////////////////////////////////////////////
    /////////////////retrieve Auth list///////////////////

	public function retrieveAuthList(){

		//$input=$this->session();

		$url2=$this->baseurl.'/profiles/auth';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

			$this->log(__FUNCTION__,'Get AuthService Profile', $url2,'GET', $status, $message, '',$this->realm);

		}else{

		$this->log(__FUNCTION__,'Get AuthService Profile', $url2,'GET', $status, $message, '',$icom);

		}

		$message = urlencode($message);

		if($status == '200'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}


	public function retrieveAccountList(){

		//$input=$this->session();

		$url2=$this->baseurl.'/profiles/acct';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

			$this->log(__FUNCTION__,'Get Account Profile', $url2,'GET', $status, $message, '',$this->realm);

		}else{

		$this->log(__FUNCTION__,'Get Account Profile', $url2,'GET', $status, $message, '',$icom);

		}

		$message = urlencode($message);

		if($status == '200'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

	///////////////creat network///////////////
	 public function createnetwork($zoneid,$name,$ssid, array $data = NULL, $accessVlan,$alemac){

		//$input=$this->session();
		if ($alemac == 1) {
			$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/standardmac';
		}else{
			$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans';
		}
		$ch2 = curl_init($url2);

		$data['advancedOptions']['avcEnabled'] = true;

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
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zone.'/wlans/'.$id;

		$curl = curl_init($url2);



		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$jsonData2 = array(
		'name'=>$name,
		'ssid'=>$ssid,
		'description'=>$description,
		'accessTunnelType'=>$tunnel
		);
		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Modify Network', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

	///////modify avcEnable///////////////
	public function modifyavcEnabled($zoneid,$id,$avcEnabled){

		//$input=$this->session();

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


		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Modify AVCEnabled', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}

	/////////////////retrieve ssid list///////////////////

	public function retrieveNetworkList($zoneid,$icom=NULL){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        //$input=$this->session();

        $url2=$this->baseurl.'/aps/'.$apmac.'/operational/summary';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        //$input=$this->session();

        $url2=$this->baseurl.'/aps/'.$apmac.'/operational/client';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/mesh';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
	public function modifyZoneTimeZone($zoneid,$abbreviation,$gmtOffset,$gmtOffsetMinute,$timeZone){

		//$input=$this->session();

		/*$jsonData2 = array(

				'customizedTimezone'   => array('abbreviation' => $abbreviation,
												'gmtOffset' => $gmtOffset,
												'gmtOffsetMinute' => $gmtOffsetMinute)
		);*/
		$jsonData2 = array(
				'systemTimezone'   => $timeZone
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/timezone';

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$jsonData2 = array(
				'method'=>$method,
				'algorithm'=>$algorithm,
				'passphrase'=>$passphrase,
				'mfp' => 'disabled'
		);
		//"WPA2\",\"WPA_Mixed\",\"WEP_64\",\"WEP_128\",\"None\
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id.'/encryption';

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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




	public function createap($zoneid,$mac,$name,$administrativeState,$description,array $data_ar=null){

		//$input=$this->session();
		$url2=$this->baseurl.'/aps';
		$ch2 = curl_init($url2);

		$jsonData2 = array(
            'mac'   => $mac,
            'zoneId'   => $zoneid,
            'name' =>$name,
            'administrativeState'=>$administrativeState
		);

        if(!is_null($description)){
            $jsonData2['description']=$description;
        }

        if(!empty($data_ar)){

        	if(strlen($data_ar['caption']) > 0){
                $jsonData2['description'] = $data_ar['caption'];
            }

            if(strlen($data_ar['serial']) > 0){
                $jsonData2['serial'] = $data_ar['serial'];
            }

            if(strlen($data_ar['model']) > 0){
                $jsonData2['model'] = $data_ar['model'];
            }

            if(strlen($data_ar['ports']) > 0){
                $jsonData2['ports'] = $data_ar['ports'];
            }

            if(strlen($data_ar['latitude']) > 0){
                $jsonData2['latitude'] = $data_ar['latitude'];
            }

            if(strlen($data_ar['longitude']) > 0){
                $jsonData2['longitude'] = $data_ar['longitude'];
            }
        }

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();


		$url2=$this->baseurl.'/aps';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Retrieve AP List', $url2,'GET', $status, $message, '',$this->realm);

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

		//$input=$this->session();


		$url2=$this->baseurl.'/aps?zoneId='.$zoneid;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$id;

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/profiles/utp';
		$ch2 = curl_init($url2);

		$jsonData2 = array(

			'name'   => $name,
			'defaultAction'   => 'ALLOW'
		);


		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
		//$input=$this->session();
		$jsonData2 = array(
			'name'=>$name,
			'description'=>$description,
			'defaultAction'=>'ALLOW'
		);

		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);


		$url2=$this->baseurl.'/profiles/utp/'.$id;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();


		$url2=$this->baseurl.'/profiles/utp';
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/profiles/utp/'.$id;

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlanSchedulers';
		$ch2 = curl_init($url2);

		$jsonData2 = $data;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

		curl_close ($ch2);

	}

	//delete scheduler
	public function deleteeScheduler($zoneid,$id){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlanSchedulers/'.$id;

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

///////////////////retrieve scheduler///////////////////
    public function retrieveSchedule($zoneID,$scheduleID){

        //$input=$this->session();


        $url2=$this->baseurl.'/rkszones/'.$zoneID.'/wlanSchedulers/'.$scheduleID;
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

	$this->log(__FUNCTION__,'Retrieve WLan Scheduler List', $url2,'GET', $status, $message, '',$this->realm);

	$message = urlencode($message);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}



}



///////////////////retrieve scheduler List///////////////////
public function retrieveSchedulelist($zoneid){

	//$input=$this->session();


	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlanSchedulers';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


///////////////////Modify Power scheduler Times///////////////////
public function modifyPowerSchedule($zoneID,$scheduleID,array $data_ar, $id, $type, $schedule_name){

        //$input=$this->session();

        $data = json_encode($data_ar);

        $url2=$this->baseurl.'/rkszones/'.$zoneID.'/wlanSchedulers/'.$scheduleID;
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Modify Power Schedule', $url2,'PATCH', $status, $message, $api_data,$this->realm);

        if($status == '204'){


			$obj = (array)json_decode($message);
			$obj['id'] = $scheduleID;
			$message = json_encode($obj);

			$modify_sche_respo = $this->modifySchedule($zoneID, $id, $type, $scheduleID, $schedule_name);

            parse_str($modify_sche_respo,$modify_sche_respo_ar);

                if($modify_sche_respo_ar['status_code']=='200'){

                	return 'status=success&status_code=200&Description='.$message;
                }
                else{
					return 'status=failed&status_code='.$status.'&Description='.$message;
                }


        }
        else{

        	$message = urlencode($message);

            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }



//////////////////////////////////////
function modifySchedule($zoneid,$id,$type,$SU_id=NULL,$name=NULL){

		//$input=$this->session();
		$jsonData2 = array(
			'type'=> $type,
			'id'=> $SU_id,
			'name'=> $name
		);


		$data = json_encode($jsonData2);

	//print_r($data);
		 $url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id.'/schedule';

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Modify Schedule', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);

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

	//$input=$this->session();
	$jsonData2 = array(
			'id'=> $ACLid,
			'name'=> $name
	);

	$data = json_encode($jsonData2);


	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';

	$ch2=curl_init();

	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

	//$input=$this->session();

	$url = $this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id.'/l2ACL';
	$curl = curl_init($url);


	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

	// Make the REST call, returning the result
	$response = curl_exec($curl);

	$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$message = substr($response, $header_size);

	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


	//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

	$this->log(__FUNCTION__,'Delete ACL', $url,'DELETE', $status, $message, '',$this->realm);

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

	//$input=$this->session();


	$url2=$this->baseurl.'/aps/'.$apmac.'/operational/client';
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		//$input=$this->session();


		$url2=$this->baseurl.'/profiles/tunnel/'.$tunnelType;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
		//$input=$this->session();

		parse_str($this->retrieveNetworkList($zoneid),$net_res);
		$net_list = json_decode($net_res['Description'],true);

		foreach ($net_list['list'] as $net){

			$mod_data = ["accessTunnelType"=> "APLBO","accessTunnelProfile"=>null];
			$this->updateWlan($zoneid,$net['id'],$mod_data);
		}

		$jsonData2 = [
			"tunnelType" => "SoftGRE",
			"tunnelProfile" => array(
				'id' => $tunnelProfileID,
				'name' => $tunnelProfileName
			),
			"softGreTunnelProflies" => array(
				array(
					"id" => $tunnelProfileID,
					"name" => $tunnelProfileName,
					"aaaAffinityEnabled" => true
				)
			)
		];

		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);

		//print_r($data);
		$url=$this->baseurl.'/rkszones/'.$zoneid;
		$response = $this->call(__FUNCTION__,$url,'PATCH',$data);

		$message = urlencode($response['Description']);

		if($response['status_code'] != '204'){

			return 'status=failed&status_code='.$response['status_code'].'&Description='.$message;

		}
		/*$tunnels = $this->getZoneTunnelProfiles($zoneid);
		$tunnel_data = json_decode($tunnels['Description'],true);
		foreach ($tunnel_data['list'] as $tunnel){
			if($tunnel['tunnelType']=='SoftGRE' && $tunnel['name']==$tunnelProfileName){
				$zone_tunnel_id = $tunnel['id'];
				$zone_tunnel_name = $tunnel['name'];
				break;
			}
		}*/

		//Please comment this section after migrate all zones to 5.2
		//Start comment section
		$res36 = $this->modifyTunnelProfile36($zoneid,$tunnelProfileID,$tunnelProfileName);

		if($res36['status_code']==200){
			return 'status=success&status_code=200&Description='.$message;
		}
		//end comment section
		/*
			$this->log(__FUNCTION__,ruckus::FunctionList(true)[__FUNCTION__],'','GET','404','SoftGre Tunnel Profile Not Available in the zone','getZoneTunnelProfiles',$this->realm);
			return 'status=failed&status_code=404&Description=SoftGre Tunnel Profile Not Available in the zone';

		*/


		foreach ($net_list['list'] as $net){
			$networkNameLower=trim(strtolower($net['name']));
			if(!(substr($networkNameLower, 0, strlen("guest")) === "guest"))
				continue;

			$mod_data = ["accessTunnelType"=> "SoftGRE","accessTunnelProfile"=>["id"=>$tunnelProfileID,"name"=>$tunnelProfileName]];
			$updatewlanres = $this->updateWlan($zoneid,$net['id'],$mod_data);
			if($updatewlanres['status_code']!=200){
				return 'status=failed&status_code='.$updatewlanres['status_code'].'&Description='.$updatewlanres['Description'];
			}


		}


		return 'status=success&status_code=200&Description='.$message;



	}



	/////////////////retrieve APmac details///////////////////

	 public function retrieveAPmac($mac){

		//$input=$this->session();

	 $url2=$this->baseurl.'/aps/'.$mac;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


			/////////////////modify AP///////////////////

	 public function modifyAp($mac, $location=NULL, $model=NULL, $latitude=NULL, $longitude=NULL){

		//$input=$this->session();

		$jsonData2 = array();

		if(strlen($location) > 0){
			$jsonData2['location'] = $location;
		}

		if(strlen($model) > 0){
			$jsonData2['model'] = $model;
		}

		if(strlen($latitude) > 0){
			$jsonData2['latitude'] = $latitude;
		}

		if(strlen($longitude) > 0){
			$jsonData2['longitude'] = $longitude;
		}

		//APLBO\",\"RuckusGRE
		//Encode the array into JSON.
		$data = json_encode($jsonData2);

	 	$url2=$this->baseurl.'/aps/'.$mac;
		$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Modify AP', $url2,'PATCH', $status, $message, $data,$this->realm);

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}



	}


	//show hide SSID


function hideSSID($zoneid,$id,$enable){

	//$input=$this->session();
	$jsonData2 = array(
			'hideSsidEnabled'=> $enable
	);

	$data = json_encode($jsonData2);


	$url2=$this->baseurl."/rkszones/$zoneid/wlans/$id/advancedOptions";

	$ch2=curl_init();

	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

	$this->log(__FUNCTION__,'Hide SSID', $url2,'PATCH', $status, $message, $data,$this->realm);

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

        //$input=$this->session();

        $url2=$this->baseurl.'/profiles/dnsserver';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

    /////////////////create DNS Profile details///////////////////

    public function createDNSServerProfile($data){

        //$input=$this->session();

        $data = json_encode($data);

        $url2=$this->baseurl.'/profiles/dnsserver';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
        $this->log(__FUNCTION__,'Modify DNS Server Profile', $url2,'PATCH', $status, $message, $url2,$this->realm);

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

        //$input=$this->session();

        $data = json_encode(array("id"=>$dnsProfileId,"name"=>$dnsProfileName));

        $url2=$this->baseurl.'/rkszones/'.$zone.'/wlans/'.$id.'/dnsServerProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        //$input=$this->session();

        //$data = json_encode(array("id"=>$dnsProfileId,"name"=>$dnsProfileName));

        $url2=$this->baseurl.'/rkszones/'.$zone.'/wlans/'.$id.'/dnsServerProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

    ////////////Modify ap mesh option/////////////////
    public function modifyAPmeshOption($ap_mac,$meshMode,$upLinkSelection=null,array $meshUpLinkEntryList=null){

        //$input=$this->session();

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

        $url2=$this->baseurl.'/aps/'.$ap_mac.'/meshOptions';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
        $request = $url2.'\n'.$data;

        $this->log(__FUNCTION__,'Modify AP Mesh Option', $url2,'PATCH', $status, $message, $request,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }




    }

/////////////////////////////////////////////////////////////////////////

////////////Modify ap mesh option/////////////////
    public function disableAPmeshOption($ap_mac){



        $url2=$this->baseurl.'/aps/'.$ap_mac.'/meshOptions';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'DELETE');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

       // $input=$this->session();

        $url2=$this->baseurl.'/rkszones/'.$zoneID.'/dhcpSite/dhcpProfile';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        //$input=$this->session();


        $jsonData2 = array(
            'siteEnabled'=>$siteEnabled,
            'manualSelect'=>$manualSelect,
            'siteMode'=>$siteMode,
            'siteAps'=>$siteAps,
            'siteProfileIds'=>$siteProfileIds,
        );

        $data = json_encode($jsonData2);

        $url2=$this->baseurl.'/rkszones/'.$zoneId.'/dhcpSiteConfig';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

    /////////////////get System Time///////////////////

    public function retrieveSystemTime(){

       // $input=$this->session();

        $url2=$this->baseurl.'/system/systemTime';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Retrieve System Time', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    				///////modify zone///////////////
	public function modifyDNSServerProfile($data,$dnsServerId){

		//$input=$this->session();

		$data = json_encode($data);

        $url2=$this->baseurl.'/profiles/dnsserver/'.$dnsServerId;

		$ch2=curl_init();

		curl_setopt($ch2,CURLOPT_URL,$url2);
		//curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
		curl_setopt($ch2, CURLOPT_HEADER, 1);
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);
		curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

		$response=curl_exec($ch2);

		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$message = substr($response, $header_size);

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

		$this->log(__FUNCTION__,'Modify One DNS Service Profile', $url2,'PATCH', $status, $message, $data,$this->realm);

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

    /////////////////reboot AP///////////////////

    public function rebootAP($APMac){

       // $input=$this->session();

        $url2=$this->baseurl.'/aps/'.$APMac.'/reboot';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        //$input=$this->session();

        $url2=$this->baseurl.'/aps/'.$APMac;
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


    ///////Query Client///////////////
    public function queryClient(array $filters ){

        //$input=$this->session();


        $jsonData2 = array(
            'filters'=>$filters,
        );

        $data = json_encode($jsonData2);

        $url2=$this->baseurl.'/query/client?listSize=100000';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

    public function retrieveDomainsNew(array $filters)
    {

        //$input=$this->session();


        $jsonData2 = array(
            'filters' => $filters,
        );

        $data = json_encode($jsonData2);

        $url2 = $this->baseurl . '/group/tree/apgroup?includeStagingZone=true';

        $ch2 = curl_init();

        curl_setopt($ch2, CURLOPT_URL, $url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Cookie:" . $this->cookie . "", 'Content-Type: application/json;charset=UTF-8'));

        //ADD FROM RACUS V5
        curl_setopt($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch2);

//echo $response;

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($response, 0, $header_size);
        $message = substr($response, $header_size);

        $status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        curl_close($ch2);
        //$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));

        $this->log(__FUNCTION__, 'Retrieve Domains New', $url2, 'GET', $status, $message, $data, $this->realm);

        $message = urlencode($message);

        if ($status == '200') {

            return 'status=success&status_code=200&Description=' . $message;

        } else {
            return 'status=failed&status_code=' . $status . '&Description=' . $message;

        }


    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////create a domain///////////////////

    public function createDomain($domain_name,$parent_domain=null){

        //$input=$this->session();


        $jsonData2 = array(
            'name'=>$domain_name
        );

        if(strlen($parent_domain) > 1){
        	$jsonData2['parentDomainId'] = $parent_domain;
        }

        $data = json_encode($jsonData2);

        $url2=$this->baseurl.'/domains';

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Create Domain', $url2,'POST', $status, $message, $data,$this->realm);

        $message = urlencode($message);

        if($status == '201'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function retrieveHotspotList($zone_id){

        //$input=$this->session();

        $url2=$this->baseurl.'/rkszones/'.$zone_id.'/portals/hotspot';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Retrieve Hotspot List', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }
   ////////////////////////////////////

    public function getGreProfile(){

        //$input=$this->session();

        $url2=$this->baseurl.'/profiles/tunnel/ruckusgre';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get GRE Profile', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }   ////////////////////////////////////

    public function getRadius(){

        //$input=$this->session();

        $url2=$this->baseurl.'/services/auth/radius';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get Radius Details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }   ////////////////////////////////////

    public function getfirewallProfiles(){

        //$input=$this->session();

        $url2=$this->baseurl.'/firewallProfiles';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get Firewall Profiles', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }   ////////////////////////////////////

    public function getAccountingService(){

        //$input=$this->session();

        $url2=$this->baseurl.'/services/acct/radius';
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get Radius Accounting Service', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


    public function serviceTicket($c=NULL,$d=NULL){

       //$input=$this->session();

    	if($c==NULL){

			$c=rand(1,2);
		}

		if($d==NULL){

			$d=1;
		}else{

			$d=0;
		}

		$login=$this->login($c);

		$url2=$this->baseurl.'/serviceTicket';
		$ch2 = curl_init($url2);

		$jsonData2 = array(
				'username'   => $login[username],
				'password'   => $login[password]
		);

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));

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


		$res_arr = json_decode($message,true);

		return $res_arr['serviceTicket'];

		curl_close ($ch2);


	}
	
	function deleteServiceTicket(){

		//$input=$this->session();

		$url2=$this->baseurl.'/serviceTicket?serviceTicket='.$this->getServiceTicket();

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

		$message = urlencode($message);

		if($status == '200'){
			$this->serviceTicket = NULL;
			return 'status=success&status_code=200&Description='.$message;
		}
		else{
			$this->log(__FUNCTION__,'Delete Service ticket', $url2,'DELETE', $status, '', '','');

			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}


    ///////////////creat zones/////////////////

	public function createZoneDual($name,array $data,$domain_id=NULL,$latitude=NULL,$longitude=NULL){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/dual';
		$ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data;

		if(strlen($domain_id) > 0){
                $jsonData2['domainId'] = $domain_id;
            }
		if(strlen($latitude) > 0){
                $jsonData2['latitude'] = $latitude;
            }
		if(strlen($longitude) > 0){
                $jsonData2['longitude'] = $longitude;
            }


		$jsonData2['name'] = $name;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Create Zones Dual', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '201'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);

	}
    ///////////////creat zones/////////////////    ///////////////creat zones/////////////////

	public function createZoneapi($name,array $data,$domain_id=NULL,$latitude=NULL,$longitude=NULL){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones';
		$ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data;

		if(strlen($domain_id) > 0){
                $jsonData2['domainId'] = $domain_id;
            }
		if(strlen($latitude) > 0){
                $jsonData2['latitude'] = $latitude;
            }
		if(strlen($longitude) > 0){
                $jsonData2['longitude'] = $longitude;
            }


		$jsonData2['name'] = $name;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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
    ///////////////creat zones/////////////////

	public function createHotspot($zoneid, array $data_ar){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/portals/hotspot/external';
		$ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data_ar;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Create hotspot', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '201'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);

	}


	///////////////creat createGuestSSID/////////////////

	public function createGuestSSID($zoneid, array $data_ar,$guestAddParametres=[]){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/wisprmac';
		$ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/
		$data_ar['radiusOptions']['singleSessionIdAcctEnabled'] = true;
		$data_ar['advancedOptions']['avcEnabled'] = true;

		$jsonData2 = $data_ar;

		unset($jsonData2['defaultUserTrafficProfile']);
		$jsonData2 = array_merge($jsonData2,$guestAddParametres);

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Create Guest SSID', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '201'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);

	}

	///////////////creat createdhcpProfile/////////////////

	public function createdhcpProfile($zoneid, array $data_ar){

		//$input=$this->session();

		$url2=$this->baseurl.'/rkszones/'.$zoneid.'/dhcpSite/dhcpProfile';
		$ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data_ar;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Create DHCP Pool', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '201'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);

	}
  ///////////////creat zones/////////////////

	public function createSwitchGroup($name=NULL,$description=NULL,$domain_id=NULL){

		//$input=$this->session();

		$url2=$this->switch_baseurl.'/group?serviceTicket='.$this->getServiceTicket();
		$ch2 = curl_init($url2);

		$jsonData2 = array(

				'name'   => $name,
				'description'   => $description,
				'domainId'   => $domain_id
		);


		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Create Switch Group', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '201'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);

	}


	public function getSwitches(array $data_ar){

        //$input=$this->session();


        $url2=$this->switch_baseurl.'/switch?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

		/*$jsonData2 = array(

				'name'   => $name,
				'login'   => array('apLoginName' => $setuname,
									'apLoginPassword' => $setpassword)
		);*/

		$jsonData2 = $data_ar;

		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);

		curl_setopt($ch2,CURLOPT_POST,1);
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Get Switches', $url2,'POST', $status, $message, $jsonDataEncoded2,$this->realm);

		$message = urlencode($message);

		if($status == '200'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}




		curl_close ($ch2);



    }

     public function getSwitchDetails($id){


        $url2=$this->switch_baseurl.'/switch/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get Switch Details', $url2,'GET', $status, $message, '',$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


     public function getSwitchGroup($id){


        $url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

        $this->log(__FUNCTION__,'Get Switch Group', $url2,'GET', $status, $message, $url2,$this->realm);

        $message = urlencode($message);

        if($status == '200'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }


    public function moveToSwitchGroup(array $switch,$switch_group){

       // $input=$this->session();

    	$jsonDataEncoded = json_encode($switch);

        $url2=$this->switch_baseurl.'/switch/move/'.$switch_group.'?serviceTicket='.$this->getServiceTicket();
        $ch2 = curl_init($url2);

        curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonDataEncoded);
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



        $this->log(__FUNCTION__,'Move To Switch Group', $url2,'PUT', $status, $message, $jsonDataEncoded,$this->realm);

        $message = urlencode($message);

        if($status == '204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }



    }

    	/////////////////switch group delete////////////////////

	function deleteswitchgroup($id){

		//$input=$this->session();

		$url2=$this->switch_baseurl.'/group/'.$id.'?serviceTicket='.$this->getServiceTicket();

		$curl = curl_init($url2);


		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

		$this->log(__FUNCTION__,'Delete Switch Group', $url2,'DELETE', $status, '', '');

		$message = urlencode($message);

		if($status == '204'){

			return 'status=success&status_code=200&Description='.$message;

		}
		else{
			return 'status=failed&status_code='.$status.'&Description='.$message;

		}

	}


        ///////modify DhcpProfile///////////////
    public function modifyDhcpProfile($zoneId,$id, array $jsonData2 ){

        //$input=$this->session();

        $data = json_encode($jsonData2);

        $url2=$this->baseurl.'/rkszones/'.$zoneId.'/dhcpSite/dhcpProfile/'.$id;

        $ch2=curl_init();

        curl_setopt($ch2,CURLOPT_URL,$url2);
        //curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
        curl_setopt($ch2, CURLOPT_HEADER, 1);
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


///////////////////////////////////////////////////////////////////////////////////////////////////////////



/////// create a new Zone AAA.///////////////
	
public function createZoneAAA($zoneid,$name,$port,$primary_ip,$sharedSecret,$second=NULL,$seprimary_ip,$sesharedSecret){

	//$input=$this->session();
	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/aaa/radius';
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
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


$url2=$this->baseurl.'/rkszones/'.$zoneid.'/aaa/radius';
$ch2 = curl_init($url2);

curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/aaa/radius/'.$id;
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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



	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/aaa/radius/'.$id;

	$ch2=curl_init();

	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

public function create802($zoneid,$name,$ssid,$id,$au_name,$method,$algorithm,$accessVlan,array $data = NULL){

//$input=$this->session();
$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/standard8021X';
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
curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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


/////// create a create - 802.1x.///////////////

public function retrive802x($zoneid,$id){

//$input=$this->session();
$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/standard8021X/'.$id;
$ch2 = curl_init($url2);

		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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

//$this->log(__FUNCTION__,'Get 802.1X', $url2,'Get', $status, $message, $url2,$this->realm);

$message = urlencode($message);

if($status == '200'){

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




	$url2=$this->baseurl.'/rkszones/'.$zoneid.'/wlans/'.$id;

	$ch2=curl_init();

	curl_setopt($ch2,CURLOPT_URL,$url2);
	//curl_setopt($ch2, CURLOPT_POST, 1);
	curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch2,CURLOPT_CUSTOMREQUEST,'PATCH');
	curl_setopt($ch2, CURLOPT_HEADER, 1);
	curl_setopt($ch2, CURLOPT_VERBOSE, 1);
	curl_setopt($ch2,CURLOPT_POSTFIELDS,$data);
	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Cookie:".$this->cookie."",'Content-Type: application/json;charset=UTF-8'));

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



	/////////////////Delete a switch///////////////////

public function deleteSwitch($switch_id){

	//$input=$this->session();


	$url2=$this->switch_baseurl.'/switch/'.$switch_id.'?serviceTicket='.$this->getServiceTicket();
	$ch2 = curl_init($url2);

	curl_setopt($ch2,CURLOPT_HTTPHEADER,array('Content-Type: application/json;charset=UTF-8'));

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

	$this->log(__FUNCTION__,'Delete Switch', $url2,'DELETE', $status, $message, '',$this->realm);

	$message = urlencode($message);

	if($status == '200'){

		return 'status=success&status_code=200&Description='.$message;

	}
	else{
		return 'status=failed&status_code='.$status.'&Description='.$message;

	}

	

}


    public function addDPSKClient($zoneId,$wlanId,$mac,$passPhrase){
        $url = $this->baseurl . '/rkszones/'.$zoneId.'/wlans/'.$wlanId.'/dpsk/upload';
        $file_name = md5(uniqid(rand(), true)).'.csv';
        $file_path =__DIR__.'/../../../export/dpsk/tmp/'.$file_name;

        $date = new DateTime(date('Y/m/d H:i:s'), new DateTimeZone($this->time_zone));
        $Created_Date = $date->format('Y/m/d H:i:s');

        $user_name = preg_replace('/[^A-Za-z0-9]/', '', $mac);

        $q = "SELECT s.wlan_name,s.ssid,s.vlan FROM exp_locations_ssid_vtenant s WHERE s.distributor='$this->distributor' AND s.network_id='$wlanId'";

        $ssid_data = $this->db_class->select1DB($q);

		$wlan = $ssid_data['wlan_name'].' ('.$ssid_data['ssid'].')';
		$w_vlan = $ssid_data['vlan'];

        $list = array (
            array("User Name", "MAC Address" ,"WLAN (SSID)", "Passphrase", "User Role", "VLAN ID", "Created Date", "Expiration Date", "Group DPSK"),
            array($user_name, null , $wlan, $passPhrase, "UserRole-15x5", $w_vlan, $Created_Date, "Unlimited", "No")
        );

        $file = fopen($file_path,"w");

        foreach ($list as $line) {
            fputcsv($file, $line);
        }

        fclose($file);
        //$file_path =__DIR__.'/../../../export/dpsk/tmp/dpsk_1.csv';

        $response = $this->call(__FUNCTION__,$url,'POST',null,true,$file_path);


        if($response['status_code']=='201'){
            //status=success&status_code=200&Description=' . $message
            return json_encode([
                "status"=>"success",
                "status_code"=>"200",
                "Description"=>$response['message']
            ]);
        }else{
            return json_encode([
                "status"=>"fail",
                "status_code"=>$response['status_code'],
                "Description"=>$response['message']
            ]);
		}
		
		unlink($file_path);
        fclose($file);

    }

    public function getDPSKClient($zoneId,$wlanId,$mac,$passPhrase){

        $url = $this->baseurl . '/rkszones/'.$zoneId.'/wlans/'.$wlanId.'/dpsk';

        $response = $this->call(__FUNCTION__,$url,'GET',null);
        
        $message=$response['message'];
        parse_str($message);
        $json_decode=json_decode($message,true);
        
        //print_r($message);
        $list=$json_decode['list'];
        //print_r($list);
        
        $user_name = preg_replace('/[^A-Za-z0-9]/', '', $mac);
        $resultarr=array();
        foreach ($list as $value) {
            if ($value['userName']==$user_name) {
                array_push($resultarr, $value['id']);
                //$Result=$value['id'];
            }
        }


        //if ($status == '200') {
        if (sizeof($resultarr)>0) {
            return $resultarr;
        }
        else{
            return 0;
        }
    
    
    }


    public function deleteDPSKClient($zoneId,$wlanId,$mac,$passPhrase){

        $response = $this->getDPSKClient($zoneId,$wlanId,$mac,$passPhrase);

        $macarr=explode('@', $mac);
        $realm=$macarr['1'];

        //$input=$this->session();

        $url = $this->baseurl . '/rkszones/'.$zoneId.'/wlans/'.$wlanId.'/dpsk';
        $ch2 = curl_init($url);

        $jsonData2 = array(
            'idList' => $response
        );


        //Encode the array into JSON.
        $jsonDataEncoded2 = json_encode($jsonData2);
        //print_r($jsonDataEncoded2);

        $response = $this->call(__FUNCTION__,$url,'POST',$jsonDataEncoded2);

        
        if($response['status_code']=='200'){
            return json_encode([
                "status"=>"success",
                "status_code"=>"200",
                "Description"=>$response['message']
            ]);
        }else{
            return json_encode([
                "status"=>"fail",
                "status_code"=>$response['status_code'],
                "Description"=>$response['message']
            ]);
        }

    
    
    }

	public function modifyWLanGroup($zone_id,$groupId,$wlanGroupId,$wlanGroupName){
		$url = $this->baseurl .'/rkszones/'.$zone_id.'/apgroups/'.$groupId;
		$ch2 = curl_init($url);

		$jsonData2 = array(
			'wlanGroup24' => ['id'=>$wlanGroupId,'name'=>$wlanGroupName],
			'wlanGroup50' => ['id'=>$wlanGroupId,'name'=>$wlanGroupName]
		);


		//Encode the array into JSON.
		$jsonDataEncoded2 = json_encode($jsonData2);
		//print_r($jsonDataEncoded2);

		$response = $this->call(__FUNCTION__,$url,'PATCH',$jsonDataEncoded2);
		if ($response['status_code'] =='204') {
			//$res = json_decode($data['message'],true);
			return ['status'=>true,"status_code"=>200,"data"=>[]];
		} else {
			return ['status'=>false,"status_code"=>$response['status_code'],"error"=>$response['message']];
		}

	}

	


}
