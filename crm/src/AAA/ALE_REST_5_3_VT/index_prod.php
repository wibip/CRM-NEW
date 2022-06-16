<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/systemPackageClass.php');

include_once('function.php');

require_once dirname(__FILE__).'/../../LOG/Logger.php';

//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');

//require_once('../../../db/config.php');




class network_functions
{

	private $system_package;

	public function __construct($network_name,$access_method,$system_package=NULL)
	{
		$this->db_class = new db_functions();
		$this->lib_name = $network_name;
		$this->system_package = $system_package;
		$this->networkArr = $this->initialConfig($this->lib_name);
		$this->url = $this->network('api_base_url');
		$this->ses_url = $this->network('ses_base_url');
		$this->auth_token = $this->network('api_acc_org');

				//$this->network_name = $db_class->setVal("network_name",'ADMIN');

		//$this->lib_name = 'ALE_5_REST_ATT';

		
	}

	
	private function initialConfig($network){

		$query = "SELECT * FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";

		$row=$this->db_class->select1DB($query);
		$isDynamic = package_functions::isDynamic($this->system_package);
		//$row = mysql_fetch_array($query_results);
		if($isDynamic){
			$q="SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$this->system_package'";
			$qra=$this->db_class->select1DB($q);
			//$qra=mysql_fetch_assoc($qr);
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

		
	}

	

	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null,$mac=NULL,$ale_username=null){
		
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
		$log->setMacid($mac);
		$log->setAleusername($ale_username);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
	}

	public function lognew($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$realm=null,$mac=null,$ale_username=null){
		
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
		$log->setAleusername($ale_username);

		$logger = Logger::getLogger();

		$logger->InsertLog($log);
    }

  

	 public function getUserName($realm,$user_name,$append_realm,$ref_number=null){
        //$macc= str_replace('-','',$mac);
        if($append_realm == '1'){
            return $user_name.'@'.$realm;
        }
        else{
            return $user_name.'@'.$realm;
        }

    }

    public function getMacName($realm,$mac,$append_realm,$ref_number=null){
		 $macc= str_replace('-','',$mac);
		 if($append_realm == '1'){
		  return $macc.'@'.$realm;
		 }
		 else{
		  return $macc.'@'.$realm;
		 }
		  
		}

	public function getproduct($realm){
		$query="SELECT product_code as f FROM exp_products_distributor p LEFT JOIN mdu_distributor_organizations g ON p.`distributor_code`=g.`distributor_code` WHERE g.`property_id` ='$realm' AND p.`network_type`='VT-DEFAULT'";
		$service_profile_product=$this->db_class->getValueAsf($query);

		$product=$this->checkProduct($service_profile_product,$organization);
		 		
		  return $product;
		  
		}
	public function getoptdatabyrealm($realm){
        
        $data = json_decode($this->db_class->getValueAsf("SELECT m.aaa_data as f FROM exp_mno m JOIN exp_mno_distributor emd on m.mno_id = emd.mno_id JOIN mdu_distributor_organizations g on emd.`distributor_code`=g.`distributor_code` WHERE g.property_id='$realm' LIMIT 1"),true);

        return $data;
    }

	public function getfeaturesbyrealm($realm)
	{

		$data = $this->db_class->getValueAsf("SELECT p.features AS f FROM mno_distributor_parent p JOIN `exp_mno_distributor` d ON p.`parent_id`=d.`parent_id` 
		JOIN `mdu_distributor_organizations` g ON d.`distributor_code`=g.`distributor_code`
		WHERE  g.`property_id` ='$realm' ");

		return $data;
	}
	
	public function session(){

		$url = $this->network('api_base_url').'/tokens';
        $this->auth_token = $this->network('api_acc_org');
		
		//Initiate cURL.
		$ch = curl_init($url);
		
		//The JSON data.
		$jsonData = array(	
				'Tenant'   	 => $this->network('api_acc_profile'),
				'User-Name'   => $this->network('vm_api_username'),
				'password'   => $this->network('vm_api_password')
		);
		
		$jsonDataEncoded = json_encode($jsonData);

		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->auth_token.":"); 

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($status_code!= '201'){
           $this->log('',__FUNCTION__, 'Unauthorized User', $url, 'POST', $status_code,$this->db_class->escapeDB($body), $jsonDataEncoded ,'','','');
           
    
        }
        $sus=json_decode($body,true);
        //curl_close ($ch);
        //echo $sus[auth_token];
        return $sus['auth_token'];
	}
	////////////////////////////////////////////////////////////////////////

	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time,$country,$address,$state,$city,$zip,$secret_question,$secret_answer,$vlan_id,$passcode_key=null,$property_type=null){
	
		
		$user_name=$email.'@'.$organization;
		//echo $service_profile_product;
		
		$product=$this->checkProduct($service_profile_product,$organization);
		
		
				
			
			
			if(!empty($passcode_key)){
				$user_date_array = array(
					'country'      => $country,
					'address'      => $address,
					'state'      => $state,
					'city'      => $city,
					'zip'      => $zip,
					'warning'      => '0',
					'usermessage'      => '0',
					'violation'      => '0',
					'ispremium' => 'false',
					'secret_answer'      => $secret_answer,
					'secret_question'      => $secret_question,
					'dpsk'      => $passcode_key
					
				);
				}else{
					$user_date_array = array(
						'country'      => $country,
						'address'      => $address,
						'state'      => $state,
						'city'      => $city,
						'zip'      => $zip,
						'warning'      => '0',
						'usermessage'      => '0',
						'violation'      => '0',
						'ispremium' => 'false',
						'secret_answer'      => $secret_answer,
						'secret_question'      => $secret_question
					);
	
				}
        
		if ($property_type == 'VTENANT') {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}

		$advanced_features_di = $this->getfeaturesbyrealm($organization);
		$af_decode =  json_decode($advanced_features_di, true);

		
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		
		
		$jsonData = array(
				'User-Name'     => $user_name,
				'Password'      => $password,
				'Account-State' => 'Active',//$this->network('master_account_status'),
				"Group" => $group,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'User-Data' => $user_date_array

		);		
		if (array_key_exists('CLOUD_PATH_DPSK', $af_decode)) {
			$jsonData['Private-VLAN-ID'] = $organization."auto-".$vlan_id;
		}

		$jsonDataEncoded =json_encode($jsonData);
		
		$url2 = $this->network('api_base_url_new').'/accounts';
		
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($username,__FUNCTION__, 'Create Account', $url2, 'POST', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,'',$ale_username);
				
				
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.$status_code.'&Response='.$body;
						
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					
				}
		
			
		
	}
	
	

	
	////////////////////////////////////////////////////////////////////////
	
	public function subAcc($mac,$user_name,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
		//$mac_name=$mac.'@'.$organization;
		$mac_name=explode('@', $mac);
		$macc=$mac_name[0];
		//$user_name=$email.'@'.$organization;
		//$group=$this->network('api_acc_profile');

		/*$srvice_profile_array = array(
				//'Aptilo-WiFi-Account-Charge-Master-SP'      => 'true'
				$this->network('api_master_concurrent_login')      => 'true'
		);*/
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		if (empty($vlan_id)) {

			$jsonData = array(
	            	'User-Name'     => $mac,
	                'Password'      => $macc,
	                'Group'     => $group, //copy="true"
	                'Account-State' => 'Active',
	                'Master-Account' => $user_name,
	                'PAS-Last-Name'     => $last_name
	                //'Service-Profiles' => $srvice_profile_array,
	                
	                
	            );
		}else{
			$user_data = array(
            	'VT-Vlan-Id' => $vlan_id );

			$jsonData = array(
	            	'User-Name'     => $mac,
	                'Password'      => $macc,
	                'Group'     => $group, //copy="true"
	                'Account-State' => 'Active',
	                'Master-Account' => $user_name,
	                'PAS-Last-Name'     => $last_name,
	                //'Service-Profiles' => $srvice_profile_array,
	                'User-Data' => $user_data
	                
	                
	            );
		}
		

		$jsonDataEncoded=json_encode($jsonData);
		
		$url2 = $this->network('api_base_url_new').'/accounts';

		/*$session=$this->getSessionsbymac($mac);
		$sessionstatus=json_decode($session,true);
		//print_r($sessionstatus);
		$token=$sessionstatus['Description'];
		$status=$sessionstatus['status_code'];
		$ses_type=$sessionstatus['status'];

		if ($status==200) {
			$getaccount=$this->checkMacAccount($mac);
			$accounttatus=json_decode($getaccount,true);
			$statuss=$accounttatus['status_code'];

			if ($statuss==200) { // && $ses_type==FULL
				return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
				# code...
			}

			else{
		
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$body= $this->db_class->escapeDB($body);
       
		$this->log($mac,__FUNCTION__, 'Create Account', $url2, 'REST', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization);
		
				if($status_code == '201'){
					$parameter_array=array();
					$parameter_array['mac']=$mac;
					$parameter_array['realm']=$organization;
					$parameter_array['token']=$token;
					$startsession=$this->startSession($parameter_array);
					return 'status=success&status_code='.'200'.'&Description=Device Creation Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
				
				}
		}


	}*/

	/*else{
		//echo $mac_name;
			$getaccount=$this->checkMacAccount($mac);
			$accounttatus=json_decode($getaccount,true);
			$statuss=$accounttatus['status_code'];
			if ($statuss==200) {
				return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
				# code...
			}
			else{*/
			$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$body= $this->db_class->escapeDB($body);
		$ale_username = $this->network('vm_api_username');
       
		$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', $status_code, $body, $jsonDataEncoded,$organization,$macc,$ale_username);
		
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Device Creation Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		//}


	//}
	}
	////////////////////////////////////////////////////////////////////////

	////////////////////////////////////////////////////////////////////////
	
	public function modifysubAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
		//$mac_name=$mac.'@'.$organization;
		$mac_name=explode('@', $mac);
		$macc=$mac_name[0];
		$user_name=$email.'@'.$organization;
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}


		$json=$this->findUser($mac);
		$decodednew=json_decode($json,true);
		$uuid=$decodednew['UUID'];

		$auto_created = $decodednew['User-Data']['auto_created'];

		if (empty($vlan_id)) {
			$jsonData = array(
	            	'User-Name'     => $mac,
	                'Password'      => $macc,
	                'Group'     => $group, //copy="true"
	                'Account-State' => 'Active',
	                'Master-Account' => $user_name,
	                'PAS-Last-Name'     => $last_name,
	                'UUID' => $uuid
	                
	                
	        );
		}else{
			$user_data = array(
            	'VT-Vlan-Id' => $vlan_id );

			$jsonData = array(
	            	'User-Name'     => $mac,
	                'Password'      => $macc,
	                'Group'     => $group, //copy="true"
	                'Account-State' => 'Active',
	                'Master-Account' => $user_name,
	                'PAS-Last-Name'     => $last_name,
	                'UUID' => $uuid,
	                'User-Data' => $user_data
	                
	                
	            );
		}
		if ($auto_created == true) {
    		$jsonData['User-Data']['auto_created'] = "true";
    	}
    	$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($decodednew as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$jsonDataEncoded=json_encode($finalarr);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$mac;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$body= $this->db_class->escapeDB($body);
		$ale_username = $this->network('vm_api_username');
       
		$this->log($mac,__FUNCTION__, 'Modify Device', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$macc,$ale_username);
		
		if($status_code == '200'){
			return 'status=success&status_code='.'200'.'&Description=Device Creation Success - '.$status_code;

		}
		else{
			return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
			/* SOAP Parameter Error */
		}
		//}


	//}
	}
	////////////////////////////////////////////////////////////////////////
	
	
	public function modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string,$vlan_id = null){
	

		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);

		//$usermessage;
		
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		//echo $cust_uname;
		$json=$this->findUser($cust_uname);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		
		$uuid=$decodednew['UUID'];
		//$mobile_number=$decodednew['MSISDN'];
		if (strlen($vlan_id)==0) {
		$vlan_id=$decodednew['User-Data']['QoS-Override'];
			
		}
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$user_message_text=$decodednew['User-Data']['usermessage'];
		$qos_override=$decodednew['User-Data']['QoS-Override'];

		//$country=$decodednew['User-Data']['country'];
		//$address=$decodednew['User-Data']['address'];
		//$state=$decodednew['User-Data']['state'];
		//$city=$decodednew['User-Data']['city'];
		//$zip=$decodednew['User-Data']['zip'];
		//$secret_answer=$decodednew['User-Data']['secret_answer'];
		//$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		
		
			$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => (string)$warning,
                'usermessage'      => (string)$user_message_text,
                'violation'      => (string)$violation,
                'ispremium' => 'false',
                'secret_answer'      => (string)$secret_answer,
                'secret_question'      => (string)$secret_question                
                
            );

		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}

		$advanced_features_di = $this->getfeaturesbyrealm($organization);
		$af_decode =  json_decode($advanced_features_di, true);

		$jsonData = array(
				'User-Name'     => $cust_uname,
				'Password'      => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,//$this->network('master_account_status'),
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' => $uuid,
				'User-Data' => $user_date_array

		);
		if (array_key_exists('CLOUD_PATH_DPSK', $af_decode)) {
			$jsonData['Private-VLAN-ID'] = $organization."auto-".$vlan_id;
		}
		if(strlen($password)>0){
			$jsonData['Password'] = $password;
		}
		if(strlen($qos_override)>0){
			$jsonData['User-Data']['QoS-Override'] =(string)$qos_override;
		}

		$Response1 = $this->findUsers("User-Name", $cust_uname,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
		//Tell cURL that we want to send a POST request.
			//API Url
		$url2 = $this->network('api_base_url_new').'/accounts/'.$cust_uname;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//$organization=$decoded['Group'];

		$body= $this->db_class->escapeDB($body);
		$ale_username = $this->network('vm_api_username');

		$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $body, $jsonDataEncoded,$organization,'');
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	

	
	public function modifyAccDpsk($user_name,$passcode_key){
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
	
		/*$user_date_array = array(
				'VT-Vlan-Id' => $vlan_id,
				'warning'      => $aup_message_text,
			//	'usermessage'      => $user_message_text//,
				'violation'      => $violation
		);*/
		
	
		
		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();

		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}

		$finalarr['User-Data']['dpsk']=$passcode_key;
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		//$organization=$decoded['Group'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $body, $jsonDataEncoded,$organization,$ale_username);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////////
	public function removeProfile($user_name){
	
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		$group=$this->network('api_acc_profile');
		$params_update = array(
	
				'Service-Profiles' => '0',
				//'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		//$url2 = $this->network('api_base_url_new').'/products/'.$product;
		$ch = curl_init($url2);
		//$header_parameters = "Content-Type: application/json;charset=UTF-8";
		$header_parameters = array(
		    "Content-Length: 0",
		    "Content-Type: application/json;charset=UTF-8"
		  );
		//Attach our encoded JSON string to the POST fields.
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_parameters);

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);	
		//$organization=$decoded['Group'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
	

		$this->log($user_name,__FUNCTION__, 'Remove Profile', $url2, 'DELETE', $status_code, $body, '',$organization,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			
	
	
	}

	////////////////////////////////////////////////////////
	
	
	public function modifyProfile($user_name,$product_list,$password=NULL){
	
	
		$group=$this->network('api_acc_profile');
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
	
		$json=$this->findUser($user_name);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$password=$decodednew['Password'];
		$email=$decodednew['Email'];
		$mobile_number=$decodednew['MSISDN'];

		$first_name=$decodednew['PAS-First-Name'];
		$last_name=$decodednew['PAS-Last-Name'];
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$user_message_text=$decodednew['User-Data']['usermessage'];
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		
		$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => $warning,
                'usermessage'      => $user_message_text,
                'violation'      => $violation,
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		
		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}
		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product_list,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);
	

		$Response1 = $this->findUsers("User-Name", $cust_uname,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);

		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name.'/product';

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		//print_r($body);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
//		$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'Modify Profile', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	
	
	}

	public function modifyQOSProfile($user_name,$qos_profile,$password=NULL){
	
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		
		/*$user_date_array = array(
                'QoS-Override' => $qos_profile
            );
		
*/
		
	
	

		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}

		
		$finalarr['User-Data']['QoS-Override']=$qos_profile;
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);

		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		//print_r($body);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
//		$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'Modify QOS Profile', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	
	
	}



	public function removeQOSProfile($user_name,$qos_profile,$password=NULL){
	
	
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}	



		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		$user_data=$newarr['Description'][0]['User-Data'];
		foreach ($newarr['Description'][0] as $key => $value) {

			if ($key!='User-Data') {
				if ($key=='Product') {
					# code...
				}
				$finalarr[$key]=$value;
			}
			
		}
		foreach ($user_data as $keynew => $value2) {

			if ($keynew!='QoS-Override') {
				$finalarr['User-Data'][$keynew]=$value2;
			}
			
		}
		
		$finalarr['Group']=$group;
		$jsonDataEncoded = json_encode($finalarr);

		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		//print_r($body);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
//		$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'Modify QOS Profile', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=QOS Delete is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	}
	

	
	////////////////////////////////////////////////////////
	
	
	public function modifyValidityTime($user_name,$validity_time){
	
		//$group=$this->network('api_acc_profile');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$group=$this->network('api_acc_profile');
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];

		$json=$this->findUser($user_name);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$password=$decodednew['Password'];
		$email=$decodednew['Email'];
		$mobile_number=$decodednew['MSISDN'];

		$first_name=$decodednew['PAS-First-Name'];
		$last_name=$decodednew['PAS-Last-Name'];
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$user_message_text=$decodednew['User-Data']['usermessage'];
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		$qos_override=$decodednew['User-Data']['QoS-Override'];

		
		$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => $warning,
                'usermessage'      => $user_message_text,
                'violation'      => (string)$violation,
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		
		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}
		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array,
				'Validity-Time' => $validity_time,
		
		);
		if(strlen($qos_override)>0){
			$jsonData['User-Data']['QoS-Override'] =(string)$qos_override;
		}
	
		/*$params_update = array(
	
				//'Service-Profiles' => 'REMOVE|',
				'Product-Owner'     => $group,
				'Account-State' => $acc_state,
				'User-Name' => $user_name,
				'Password' => $user_name,
				'Product'     => $product,
				'UUID' =>  $uuid,
				'Validity-Time' => $validity_time //$this->network('PRODUCT'),
		);*/
		$Response1 = $this->findUsers("User-Name", $cust_uname,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
		
	
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		//$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');

		//$body= $this->db_class->escapeDB($body);
		
		$this->log($user_name,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	}	
	
	
	
	
	////////////////////////////////////////////////////////
	
	
	public function AUP($user_name,$user_message_text,$aup_message_text){
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		//$group=$this->network('api_acc_profile');
		$aup_text_log = $user_name.', AUP Message = '.$aup_message_text;

		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		$credits_reservation_array = array(
		
				'Bucket-1' => '0'
				//'Bucket-1'      => '0'
		);
		
		
		$credits_array = array(
		
				'Bucket-1'      => '0'
		);
		
		$json=$this->findUser($user_name);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$password=$decodednew['Password'];
		$email=$decodednew['Email'];
		$mobile_number=$decodednew['MSISDN'];

		$first_name=$decodednew['PAS-First-Name'];
		$last_name=$decodednew['PAS-Last-Name'];
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		$qos_override=$decodednew['User-Data']['QoS-Override'];

		
		if ($warning==0) {
			$violation=$violation;
		}
		else{
			$violation=$violation+1;
		}
		/*$user_date_array = array(
				'VT-Vlan-Id' => $vlan_id,
				'warning'      => $aup_message_text,
			//	'usermessage'      => $user_message_text//,
				'violation'      => $violation
		);*/
		$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => $aup_message_text,
                'usermessage'      => $user_message_text,
                'violation'      => (string)$violation,
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		
		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}
		
		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array,
				'Credits' => $credits_array,  //'Bucket-1=1',
				'Credit-Reservations' => $credits_reservation_array // (ADD|10,REMOVE|)
		
		);
		if(strlen($qos_override)>0){
			$jsonData['User-Data']['QoS-Override'] =(string)$qos_override;
		}
		
		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		//$organization=$decoded['Group'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}

	////////////////////////////////////////////////////////
	
	
	public function UpdateProduct($user_name,$product){
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		
		$jsonData = array(
				'Product'     => $product
			);
		
		
		
		$jsonDataEncoded = json_encode($jsonData);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name.'/product';

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		//$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'Update Product', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	
	
	////////////////////////////////////////////
	
	////////////////////////////////////////////////////////////////////////
	
	public function AUP_Activate($user_name,$violation_count=null){
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
		
		$group=$this->network('api_acc_profile');
		$credits_array = array(
	
				'Bucket-1'      => '1000000000000000'
		);
		$json=$this->findUser($user_name);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$email=$decodednew['Email'];
		$mobile_number=$decodednew['MSISDN'];

		$first_name=$decodednew['PAS-First-Name'];
		$last_name=$decodednew['PAS-Last-Name'];
		$user_message_text=$decodednew['User-Data']['usermessage'];
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		$password=$decodednew['Password'];
		$qos_override=$decodednew['User-Data']['QoS-Override'];


			
		$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => '0',
                'usermessage'      => $user_message_text,
                'violation'      => '0',//$violation,
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}
	
	
		$jsonData = array(
				'Valid-Until'=>$valid_until,
				'User-Name' => $user_name,
				'Valid-From' => $valid_from,
				'Password' => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);

		if(strlen($qos_override)>0){
			$jsonData['User-Data']['QoS-Override'] =(string)$qos_override;
		}

		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		//$organization=$decoded['Group'];

		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,$mac,$ale_username);
		
		
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=AUP message update Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	}	
	
	
	
	
	
	////////////////////////////////////////////
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function UserMessage($user_name,$user_message_text){
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$user_message_log = $user_name.', usermessage = '.$user_message_text;

		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		
		//$organization=$decoded['Group'];
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
		$group=$this->network('api_acc_profile');
		$json=$this->findUser($user_name);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];
		$password=$decodednew['Password'];
		$email=$decodednew['Email'];
		$mobile_number=$decodednew['MSISDN'];
		$validity_time=$decodednew['Validity-Time'];

		$first_name=$decodednew['PAS-First-Name'];
		$last_name=$decodednew['PAS-Last-Name'];
		$warning=$decodednew['User-Data']['warning'];
		$violation=$decodednew['User-Data']['violation'];
		$vlan_id=$decodednew['User-Data']['VT-Vlan-Id'];
		$country=$decodednew['User-Data']['country'];
		$address=$decodednew['User-Data']['address'];
		$state=$decodednew['User-Data']['state'];
		$city=$decodednew['User-Data']['city'];
		$zip=$decodednew['User-Data']['zip'];
		$secret_answer=$decodednew['User-Data']['secret_answer'];
		$secret_question=$decodednew['User-Data']['secret_question'];
		$acc_state=$decodednew['Account-State'];
		$qos_override=$decodednew['User-Data']['QoS-Override'];

		
		$user_date_array = array(
            	'country'      => $country,
            	'address'      => $address,
                'state'      => $state,
                'city'      => $city,
                'zip'      => $zip,
                'warning'      => $warning,
                'usermessage'      => $user_message_text,
                'violation'      => (string)$violation,
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		
		if (!empty($vlan_id)) {
			$user_date_array['VT-Vlan-Id'] = $vlan_id;
		}
		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Group'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);
		if(strlen($qos_override)>0){
			$jsonData['User-Data']['QoS-Override'] =(string)$qos_override;
		}
	
		$Response1 = $this->findUsers("User-Name", $user_name,$organization);
		$newarr=json_decode($Response1,true);
		$finalarr=array();
		//print_r($newarr['Description']);
		foreach ($newarr['Description'][0] as $key => $value) {
			if (!empty($jsonData[$key])) {
				$finalarr[$key]=$jsonData[$key];
			}
			else{
				$finalarr[$key]=$value;
			}
		}
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		$finalarr['Group']=$group;
		
		$jsonDataEncoded = json_encode($finalarr);
	
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name_ale;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //Execute the request
		$result = curl_exec($ch);

		//Execute the request
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		$ale_username = $this->network('vm_api_username');

		$this->log($user_name,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$group,$mac,$ale_username);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=User message update Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	}

	public function checkMacAccount($user_name){
	
	
		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		// This is an archaic parameter list
		

		$jsonDataEncoded=json_encode($jsonData);
	
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];

        
					
		$this->log($user_name,__FUNCTION__, 'Get Device', $url2, 'GET', $status_code, $body, '',$organization,$mac,$ale_username);
				
		
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
	
	public function checkMasterAccount($user_name){
	
		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		// This is an archaic parameter list
		//echo $user_name;

		$jsonDataEncoded=json_encode($jsonData);
	
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $product_old=$decoded['Product'];
        $desc=$decoded['internal-debug-message'];

        $groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		/*$product=$this->getproduct($organization);
		if ($product_old != $product) {
			$modifyproduct=$this->UpdateProduct($user_name,$product);
			}*/	

        $ale_username = $this->network('vm_api_username');
					
		$this->log($user_name,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$organization,$mac,$ale_username);
				
		
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
	
	
	
	public function findUser($user_name){
	
	
		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		// This is an archaic parameter list
		$params = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1,
				//'Account-State'      => 'Inactive'

		);
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$user_name;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if($status_code == '200'){
					
					return $body;

				}
				else{
					return $body;
				}
		
		
	}

	public function findUsersStep($search_parameter1, $term1,$realm=null,$stage=null,$final=null){

		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $realm);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		// This is an archaic parameter list
		$jsonData = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1,
				//'Account-State'      => 'Inactive'

		);


		$jsonDataEncoded=json_encode($jsonData);
	
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		if ($stage == 1) {
			$url2 = $this->network('api_base_url_new').'/accounts?sort=true&limit=10000&filter['.$search_parameter1.']='.$term1.'*&filter[Email]=*';
		}else{
			$final_val = $final['__continuation'];

			$url2 = $this->network('api_base_url_new').'/accounts?limit=10000&__continuation='.$final_val.'&filter['.$search_parameter1.']='.$term1.'*&filter[Email]=*';
		}
		
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];

        $ale_username = $this->network('vm_api_username');		
		$this->log($term1,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$realm,$mac,$ale_username);
		
		return $decoded;
		
	}

	public function findUsers($search_parameter1, $term1,$realm=null){
		$decoded = $this->findUsersStep($search_parameter1, $term1,$realm,'1',$final);
        $final = end($decoded);
        $final_val_le = strlen($final['__continuation']);
        while ($final_val_le > 0) {
        	$decodednew = $this->findUsersStep($search_parameter1, $term1,$realm,'2',$final);
			$final =end($decodednew);
			$final_val_le = strlen($final['__continuation']);
			if (!empty($decodednew)) {
				$decoded = array_merge($decodednew,$decoded);
			}
        }
        if (!empty($decoded)) {
        	$status_code = '200';
        }
		
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

	public function findDeviceUsers($search_parameter1, $term1,$realm=null){
	
	
		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $realm);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		// This is an archaic parameter list
		$jsonData = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1,
				//'Account-State'      => 'Inactive'

		);

		$jsonDataEncoded=json_encode($jsonData);
	
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url_new').'/accounts?filter['.$search_parameter1.']='.$term1.'*&filter[Master-Account]=*';
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];

        $ale_username = $this->network('vm_api_username');		
		$this->log($realm,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$organization,$mac,$ale_username);
		
		
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
	
	///////////////////////////////////////////////////////////////
	public function getGroup(){

		$url2 = $this->network('api_base_url_new').'/groups';
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];
        $ale_username = $this->network('vm_api_username');
        
		$this->log($cust_uname,__FUNCTION__, 'Search Group', $url2, 'GET', $status_code, $this->db_class->escapeDB($body), '',$organization,$mac,$ale_username);
				
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Group get is Success - '.$status_code.'&parameters='.$body;

		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
		
	}
	
	////////////////////////////////////////////////////////////////////////
	

	public function findMasterUsers($search_parameter1, $term1,$search_parameter2, $term2,$property=null){



		$search_string_log1 = $search_parameter1.' = '.$term1;
		$search_string_log2 = $search_parameter2.' = '.$term2;
		$groups=explode('@', $term1);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];

        $log_string=$search_string_log1."-".$search_string_log2;

		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$group=$this->network('api_acc_profile');
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

		$jsonDataEncoded=json_encode($params2);
		//$product='frontier-product-15min';
		$sync_limit = $this->network('record_limit');//1000;
		/*$json=$this->findUser($cust_uname);
		$decodednew=json_decode($json,true);
		$product=$decodednew['Product'];
		$uuid=$decodednew['UUID'];*/

		$url2 = $this->network('api_base_url_new').'/accounts?filter['.$search_parameter1.']='.$term1.'&filter['.$search_parameter2.']='.$term2; //.'&filter[Product]='.$product;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];
        $ale_username = $this->network('vm_api_username');
		
		$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $this->db_class->escapeDB($body), '',$property,$mac,$ale_username);

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
        $groups=explode('@', $term1);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];

        $search_string_log1 = $search_parameter1.' = '.$term1;
        $search_string_log2 = $search_parameter2.' = '.$term2;
        $search_string_log3 = $search_parameter3.' = '.$term3;

        $log_string=$search_string_log1."/".$search_string_log2."/".$search_string_log3;

        $u_id = rand(1,9).uniqid().rand(1111,9999);

        
        $group=$this->network('api_acc_profile');
        // This is an archaic parameter list
        $params = array(

            $search_parameter1      => $term1


        );
        $params2 = array(
            $search_parameter2      => $term2,
            $search_parameter3      => $term3,
        );

        $jsonDataEncoded=json_encode($params2);
        $sync_limit = $this->network('record_limit');//1000;

        $url2 = $this->network('api_base_url_new').'/accounts?filter['.$search_parameter1.']='.$term1.'&filter['.$search_parameter2.']='.$term2.'&filter['.$search_parameter3.']='.$term3;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];
        $ale_username = $this->network('vm_api_username');

		$this->log($params2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $this->db_class->escapeDB($body), '',$organization,$mac,$ale_username);


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


    ////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////
	public function findUsersByMaster($master_user){
	
	
/* 		$fields = array(
				'login' => urlencode($this->network('ACC_LOGIN')),
				'pwd' => urlencode($this->network('ACC_PASS')),
				'method' => 'findUsersByMaster',
				'master' => urlencode($master_user)
		); */
		
		$groups=explode('@', $master_user);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		//return $fields;
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		$group = $this->getoptdatabyrealm($organization)['operator_group_id'];
		if (strlen($group)<0) {
			$group=$this->network('api_acc_profile');
		}
		//$group=$this->network('api_acc_profile');

		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		$sync_limit = $this->network('record_limit');

		$url2 = $this->network('api_base_url_new').'/accounts?filter[Group]='.$group.'*&filter[Master-Account]='.$master_user;
         
        $ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $valid_until=$decoded['Valid-Until'];
        $ac_state=$decoded['Account-State'];
        $desc=$decoded['internal-debug-message'];

        //print_r($decoded);

        //$organization=$decoded['Group'];
        $ale_username = $this->network('vm_api_username');
		$this->log($master_user,__FUNCTION__, 'Get Device', $url2, 'GET', $status_code, $this->db_class->escapeDB($body), '',$organization,$mac,$ale_username);

		$session_response = $this->getDeviceSessions($master_user);
		$newdecoded = json_decode($session_response, true);
		if (empty($newdecoded)) {
			$session_response = $this->getSessions($organization,'Access-Group',$organization);
			$newdecoded = json_decode($session_response, true)['Description'];
		}

			if($status_code == '200'){
					$json1 = array('status_code' => $status_code,
                            'status' => $newdecoded,
                            'Description'=>$decoded);
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
	
	
	public function delUser($network_user){
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $network_user);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		$mac=$groups[0];

		//$organization=$groups[2];
		
		
		// This is an archaic parameter list
		$params = array(
				'User-Name' => $network_user
		);
		
		$group=$this->network('api_acc_profile');
		$url2 = $this->network('api_base_url_new').'/accounts/'.$network_user;

		$ch = curl_init($url2);
		//$header_parameters = "Content-Type: application/json;charset=UTF-8";
		$header_parameters = array(
		    "Content-Length: 0",
		    "Content-Type: application/json;charset=UTF-8"
		  );
		//Attach our encoded JSON string to the POST fields.
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header_parameters);

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);	


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$decoded = json_decode($body, true);
		$valid_until=$decoded['Valid-Until'];
		//$organization=$decoded['Group'];
		$ac_state=$decoded['Account-State'];
		$desc=$decoded['internal-debug-message'];

		$ale_username = $this->network('vm_api_username');
		
		$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', $status_code, $this->db_class->escapeDB($body), '',$organization,$mac,$ale_username);
		
				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Account Delete Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}

	public function getSessionsbymac($username,$organization=null){
	

		$groups=explode('@', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		if (empty($organization)) {
			$organization=$groups[$a];
		}
		
		/*$params = array(
				$parameter => $username,
		);*/
		//$user_name='FrontierMagnusBlr';
		
		$group = $this->getoptdatabyrealm($organization)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }

		
		//$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
		$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization.'*&filter[Sender-Type]=Aptilo-AC&limit=10000';

		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        
        $decoded = json_decode($body, true);

        foreach ($decoded as $value){
        	if($value['User-Name']==$mac){
                $master_uname=$value['AAA-User-Name'];
                $Access_Profile = $value['Access-Profile'];
                $token = $value['Session-Token'];

                break;
			}
		}

        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,$mac,$ale_username);

				
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
	
	
	////////////////////////////////////////////////////////////////////////
	public function getDeviceSessions($master_uname){
	

		$groups=explode('@', $master_uname);
		$b=sizeof($groups);
		$a=$b-1;
		$mac=$groups[0];
		$organization=$groups[$a];

		/*$params = array(
				$parameter => $username,
		);*/
		//$user_name='FrontierMagnusBlr';
		$group = $this->getoptdatabyrealm($organization)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }

		
		//$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
		$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[AAA-User-Name]='.$master_uname.'&filter[Sender-Type]=Aptilo-AC&filter[Access-Profile]=FULL&limit=10000';

		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        
        $decoded = json_decode($body, true);

        $desc=$decoded['internal-debug-message'];
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $ale_username = $this->network('vm_api_username');
	
		
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,$organization,$ale_username);
			
				
		if($status_code==200){
				
				return $body;
			}

			else{
				 return $body;

			}
	
	}

	////////////////////////////////////////////////////////////////////////
	public function getVtenantSessionsbyrealm($realm, $time_zone){
	

		
		$organization=$realm;

		/*$params = array(
				$parameter => $username,
		);*/
		//$user_name='FrontierMagnusBlr';
		$group = $this->getoptdatabyrealm($organization)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }

		
		//$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
		$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$realm.'*&filter[Sender-Type]=Aptilo-AC&filter[Access-Profile]=FULL&limit=10000';

		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$realm,'');
				
				
		if($status_code==200){
				
				return $decoded;
			}

			else{
				 return $decoded;

			}
	
	}

	public function getSessionsDevice($username,$parameter,$property_id=null){
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;

		$groups=explode('@', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$property_id;
		$group = $this->getoptdatabyrealm($property_id)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }
		
		
		$params = array(
				$parameter => $username,
		);
		//$user_name='FrontierMagnusBlr';
		//$group=$this->network('api_acc_profile');
		$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'&limit=10000';
			
		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        
        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $res_arr1=array();
        foreach ($decoded as $newarray) {
        	if(array_key_exists($newarray['Session-MAC'], $check_arr)){

                  if($check_arr[$newarray['Session-MAC']]=='FULL'){
                    continue;
                  }else{
                    $check_arr[$newarray['Session-MAC']]=$newarray['Access-Profile'];
                  }

                }else{
                  $check_arr[$newarray['Session-MAC']] = $newarray['Access-Profile'];
                }
                array_push($res_arr1, $newarray);
        }
        $ale_username = $this->network('vm_api_username');
	
		
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,'',$ale_username);	
	
				if($status_code == '200'){
					$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$res_arr1);
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


	public function getSessions($username,$parameter,$property_id=null){
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;

		$groups=explode('@', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$property_id;
		$group = $this->getoptdatabyrealm($property_id)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }
		
		
		$params = array(
				$parameter => $username,
		);
		//$user_name='FrontierMagnusBlr';
		//$group=$this->network('api_acc_profile');
		if ($parameter=='AAA-User-Name') {
			$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'*&filter[Access-Profile]=FULL&filter[Sender-Type]=Aptilo-AC&limit=10000';
		}
		else{
			$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'&filter[Sender-Type]=Aptilo-AC&limit=10000';
		}
			
		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        
        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $res_arr1=array();
        foreach ($decoded as $newarray) {
        	if(array_key_exists($newarray['Session-MAC'], $check_arr)){

                  if($check_arr[$newarray['Session-MAC']]=='FULL'){
                    continue;
                  }else{
                    $check_arr[$newarray['Session-MAC']]=$newarray['Access-Profile'];
                  }

                }else{
                  $check_arr[$newarray['Session-MAC']] = $newarray['Access-Profile'];
                }
                array_push($res_arr1, $newarray);
        }
        $ale_username = $this->network('vm_api_username');
	
		if ($parameter=='AAA-User-Name') {
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,'',$ale_username);
			}
		else{
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,'',$ale_username);	
		}	
				if(strlen($username)>0){
					$ex_1 = $this->db_class->execDB($q_lo);
				}
				
	
	
				if($status_code == '200'){
					$json1 = array('status_code' => $status_code,
                            'status' => 'success',
                            'Description'=>$res_arr1);
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
	
	public function getSessionsRuckus($username,$parameter){
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;

		$groups=explode('@', $username);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		
		
		$params = array(
				$parameter => $username,
		);
		//$user_name='FrontierMagnusBlr';
		$group = $this->getoptdatabyrealm($organization)['operator_zone_id'];
	    if (strlen($group)<0) {
	      $group=$this->network('api_acc_profile');
	    }
		$url2 =$this->network('api_base_url_new').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'&filter[Sender-Type]=Ruckus-SCG&limit=10000';
		
			
		$ch = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";
        
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $result=curl_exec($ch);
            
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        
        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $ale_username = $this->network('vm_api_username');
	
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,$this->db_class->escapeDB($body), '' ,$organization,'');

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
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	public function delSessions($session_token){
	
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$group=$this->network('api_acc_profile');
		// This is an archaic parameter list
		$params = array(
				'ID'      => $ses_id
		);
	
		$getsessionV=$this->getSessionbytoken($mac,$session_token,$organization);
        $decoded1=json_decode($getsessionV,true);
        $Access_Profile=$decoded1['Access-Profile'];
        $Sender_Type=$decoded1['Sender-Type'];

        if ($Access_Profile=='REDIRECT') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        elseif ($Access_Profile=='FULL') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG'||$Sender_Type=='Aptilo-AC') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        else{
        	$url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
        } 

        $ch2 = curl_init($url2);
        //$header_parameters = "Content-Type: application/json;charset=UTF-8";
		$header_parameters = array(
		    "Content-Length: 0",
		    "Content-Type: application/json;charset=UTF-8"
		  );
        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $header_parameters);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $body = substr($resultl, $header_size);
        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];

        $status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
	    $ale_username = $this->network('vm_api_username');
	
	
				if($status_code == '204'){
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,'204 = deletion is success', '' ,$group,$mac,$ale_username);
				return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,$this->db_class->escapeDB($body), '' ,$group,$mac,$ale_username);
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}

   
	
	public function checkProduct($product,$organization){

		//$macc= str_replace('-','',$mac);
		
		

		$url2 = $this->network('api_base_url_new').'/products/'.$product;
		//echo $url2;
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	$decoded = json_decode($body, true);
	$valid_until=$decoded['Valid-Until'];

	$product=$decoded['Id'];
	$Service_Profiles=$decoded['Service-Profiles'][0];
	$desc=$decoded['internal-debug-message'];
	$ale_username = $this->network('vm_api_username');

	$this->log($product, __FUNCTION__, 'Get Product', $url2, 'GET', $status, $this->db_class->escapeDB($body), '', $organization,$mac,$ale_username);

	if($status == '200'){
		return $product;
	}

	else{
		 return $product;
	}
	}


	public function getQOSProfile(){

		//$macc= str_replace('-','',$mac);
		
		

		$url2 = $this->network('api_base_url').'/service_profiles';
		//echo $url2;
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	$decoded = json_decode($body, true);
	$qosarr=array();
	/*foreach ($decoded as $value) {
		array_push($qosarr, $value['Name']);
	}
	$final=json_encode($qosarr);*/
	$ale_username = $this->network('vm_api_username');

	$this->log($product, __FUNCTION__, 'Get QOS', $url2, 'GET', $status, $this->db_class->escapeDB($body), '', $organization,$mac,$ale_username);

	if($status == '200'){
		return $body;
	}

	else{
		 return $body;
	}
	}

	public function getSessionbytoken($mac,$session_token,$group){
            
        
            //API Url
        $url2 = $this->network('api_base_url_new').'/sessions/'.$session_token;
        $ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        //ADD FROM RACUS V5
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		$result=curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$ale_username = $this->network('vm_api_username');
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status,$this->db_class->escapeDB($body), '' ,$group,$mac,$ale_username);
	
     return $body;
   
}
	
	
	
	public function disconnectUserSessions($session_token,$user_name){
	
		$group=$this->network('api_acc_profile');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		$mac=$groups[0];
	
		
		$params = array(
				'AAA-User-Name'      => $user_name
		);
		$params2 = array(
				'Sender-Type'      => 'Aptilo-AC'
		);

		$getsessionV=$this->getSessionbytoken($mac,$session_token,$organization);
        $decoded1=json_decode($getsessionV,true);
        $Access_Profile=$decoded1['Access-Profile'];
        $Sender_Type=$decoded1['Sender-Type'];

        if ($Access_Profile=='REDIRECT') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        elseif ($Access_Profile=='FULL') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG'||$Sender_Type=='Aptilo-AC') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        else{
        	$url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
        }
	
		//$url2 =$this->network('api_base_url_new').'/sessions/'.$ses_id;  
        //echo $url2;

        $ch2 = curl_init($url2);
        //$header_parameters = "Content-Type: application/json;charset=UTF-8";
		$header_parameters = array(
		    "Content-Length: 0",
		    "Content-Type: application/json;charset=UTF-8"
		  );


        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $header_parameters);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);
        //print_r($resultl);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $body = substr($resultl, $header_size);

        $status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $ale_username = $this->network('vm_api_username');

				if($status_code == '204'){
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,'204 = deletion is success', '' ,$organization,$mac,$ale_username);
					return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,$this->db_class->escapeDB($body), '' ,$organization,$mac,$ale_username);
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}	
	
	
	
	
	
	public function disconnectDeviceSessions($session_token,$aaa_user_name = NULL){

		$groups=explode('@', $aaa_user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
		$mac=$groups[0];
	
		$group=$this->network('api_acc_profile');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		
		// This is an archaic parameter list
		$params = array(
				'USERNAME'      => $user_name
		);
	
		if(is_null($aaa_user_name)){
			$params2 = array(
					'Sender-Type'      => 'Aptilo-AC'
			);
		}
		else{
			$params2 = array(
					'AAA-User-Name'      => $aaa_user_name,
					'Sender-Type'      => 'Aptilo-AC'
			);
		}

		$getsessionV=$this->getSessionbytoken($mac,$session_token,$organization);
        $decoded1=json_decode($getsessionV,true);
        $Access_Profile=$decoded1['Access-Profile'];
        $Sender_Type=$decoded1['Sender-Type'];

        if ($Access_Profile=='REDIRECT') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        elseif ($Access_Profile=='FULL') {
            if ($Sender_Type=='Benu'||$Sender_Type=='Ruckus-SCG'||$Sender_Type=='Aptilo-AC') {
               $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
            else{
                $url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
            }
        }
        else{
        	$url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;
        }
		
		//$url2 =$this->network('api_base_url_new').'/sessions/'.$session_token;  
        //echo $url2;

        $ch2 = curl_init($url2);
        //$header_parameters = "Content-Type: application/json;charset=UTF-8";
        $header_parameters = array(
		    "Content-Length: 0",
		    "Content-Type: application/json;charset=UTF-8"
		  );


        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $header_parameters);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);

        $resultl=curl_exec($ch2);

        $header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);

        $header = substr($resultl, 0, $header_size);
        $body = substr($resultl, $header_size);

        $status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);

        $decoded = json_decode($body, true);
        $desc=$decoded['internal-debug-message'];
        $ale_username = $this->network('vm_api_username');
	
				if($status_code == '204'){
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,'204 = deletion is success', '' ,$organization,$mac,$ale_username);
					return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;

	
				}
				else{
				$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,$this->db_class->escapeDB($body), '' ,$organization,$mac,$ale_username);
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	}

		
	
	
	//////////////////////////////
	
	
	public function startSession($parameter_array){
	
		$mac = $parameter_array['mac'];
		$url = $parameter_array['url'];
		$token = $parameter_array['token'];
		$group = $parameter_array['realm'];

		$groups=explode('@', $mac);
		$b=sizeof($groups);
		$a=$b-1;
		$macc=$groups[0];
		$organization=$groups[$a];
	
		
		/*$group=$this->network('api_acc_profile');
		$group = $group;//$this->getGroup($token_id);*/
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		// get Variables
		$ses_base_url = $this->network($this->ses_url);

	
		
		$params_update = array(
				'User-Name'   => $mac,
				'Password'    => $macc
		);
	
	$jsonDataEncoded=json_encode($params_update);
	
		$sndmacex= explode("@",$mac);
	
		$sndmac=$sndmacex[0];

		$url2 = $this->network('ses_base_url').'/sessions/'.$token.'/login';
		//echo $url2;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		
		$return_array = array(
				'status'     => $status_wag,
				'description'     => $details.' ('.$status_code.')',
		);

		$log_data = $url2.'&nbsp&nbsp&nbspData : '.$jsonDataEncoded;
        $ale_username = $this->network('api_login');

		$this->lognew(__FUNCTION__, 'Session Start', $log_data, 'POST', $status_code,$this->db_class->escapeDB($body), $log_data ,$group,$mac,$ale_username);
	
	
		return 'status='.$status_wag.'&status_code='.$status_code.'&Description='.$details ;
	}
	
	
	/////////////////Authenticate User///////////////////////

	public function  authenticate_user($username,$password,$organization){
	
		
		
		
		$jsonData = array(	
			'Tenant'   	 => $this->network('api_acc_profile'),
			'password'   => $password
		);
		
		
		$jsonDataEncoded =json_encode($jsonData);
		
		$url2 = $this->network('api_base_url_new').'/accounts/'.$username.'/authenticate';
		
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		//curl_setopt($ch, CURLOPT_POST, 1);
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");
		//echo $this->session() ;

		
		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));

        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
			
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		$decoded = json_decode($body, true);
		$desc=$decoded['internal-debug-message'];
		
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $ale_username = $this->network('vm_api_username');
		
		$this->log($username,__FUNCTION__, 'Authenticate User', $url2, 'POST', $status_code, $this->db_class->escapeDB($body), $jsonDataEncoded,$organization,'',$ale_username);
				
				
				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.$status_code;
						
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					
				}
		
			
		
	}
	
	

	
	////////////////////////////////////////////////////////////////////////
	


}
?>
