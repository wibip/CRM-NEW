<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');

include_once('function.php');



//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');

//require_once('../../../db/config.php');




class network_functions
{


	public function __construct($network_name,$access_method)
	{
		$db_class = new db_functions();

		$this->url = $this->network('api_base_url');
		$this->ses_url = $this->network('ses_base_url');
		$this->auth_token = $this->network('api_acc_org');

		
		$this->lib_name = $network_name;
		//$this->network_name = $db_class->setVal("network_name",'ADMIN');

		//$this->lib_name = 'ALE_5_REST_ATT';

		
	}

	
	
	
	public function network($parameter) {

        $query = "SELECT $parameter AS val FROM exp_network_profile p WHERE p.network_profile='$this->lib_name'";
        $query_results=mysql_query($query);
        while($row=mysql_fetch_array($query_results)){
            $result = $row['val'];
        }
        return $result;
		
	}

	

	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null){
		 $query = "INSERT INTO `exp_aaa_logs`
		(`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id,`unixtimestamp`)
		VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'VTENANT','$group_id',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query);
	}

	public function lognew($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$realm=null,$mac=null){
        $query = "INSERT INTO `exp_session_profile_logs`
        (`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,`realm`,`mac`,`unixtimestamp`)
        VALUES ('$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'VTENANT','$realm','$mac',UNIX_TIMESTAMP())";
        $query_results=mysql_query($query);
    }

  

	 public function getUserName($realm,$user_name,$append_realm,$ref_number=null){
        //$macc= str_replace('-','',$mac);
        if($append_realm == '1'){
            return $user_name.'@'.$realm;
        }
        else{
            return $user_name;
        }

    }

    public function getMacName($realm,$mac,$append_realm,$ref_number=null){
		 $macc= str_replace('-','',$mac);
		 if($append_realm == '1'){
		  return $macc.'@'.$realm;
		 }
		 else{
		  return $macc;
		 }
		  
		}
	
	public function session(){

		$url = $this->network('api_base_url').'/tokens';
        $this->auth_token = $this->network('api_acc_org');
		
		//Initiate cURL.
		$ch = curl_init($url);
		
		//The JSON data.
		$jsonData = array(	
				'Tenant'   	 => $this->network('api_acc_profile'),
				'User-Name'   => $this->network('api_login'),
				'password'   => $this->network('api_password')
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
           $this->log('',__FUNCTION__, 'Unauthorized User', $url, 'POST', $status_code,mysql_escape_string($body), $jsonDataEncoded ,'','');
           
    
        }
        $sus=json_decode($body,true);
        //curl_close ($ch);
        //echo $sus[auth_token];
        return $sus['auth_token'];
	}
	////////////////////////////////////////////////////////////////////////

	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time,$country,$address,$state,$city,$zip,$secret_question,$secret_answer,$vlan_id){
	
		
		$user_name=$email.'@'.$organization;
		//echo $service_profile_product;
		
		$product=$this->checkProduct($service_profile_product,$organization);
		
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
        
		
		
		// $product_list =  explode(',',$service_profile_product);
		// //$product_list = explode(',',$this->network('PRODUCT'));
		
		// $srvice_profile_array = array();
		// foreach ($product_list as $key => $value){
		// 	$srvice_profile_array[$value] = 'true';
		// }
		
		$group=$this->network('api_acc_profile');
		$jsonData = array(
				'User-Name'     => $user_name,
				'Password'      => $password,
				'Product-Owner'     => $group,
				'Account-State' => 'Active',//$this->network('master_account_status'),
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'User-Data' => $user_date_array

		);
		
		
		$jsonDataEncoded =json_encode($jsonData);
		
		$url2 = $this->network('api_base_url').'/accounts';
		
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
		
		$this->log($username,__FUNCTION__, 'Create Account', $url2, 'POST', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
				
				
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.$status_code;
						
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					
				}
		
			
		
	}
	
	

	
	////////////////////////////////////////////////////////////////////////
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
		//$mac_name=$mac.'@'.$organization;
		$mac_name=explode('@', $mac);
		$macc=$mac_name[0];
		$user_name=$email.'@'.$organization;
		$group=$this->network('api_acc_profile');

		/*$srvice_profile_array = array(
				//'Aptilo-WiFi-Account-Charge-Master-SP'      => 'true'
				$this->network('api_master_concurrent_login')      => 'true'
		);*/

		$user_data = array(
            	'VT-Vlan-Id' => $vlan_id );

		$jsonData = array(
            	'User-Name'     => $mac,
                'Password'      => $macc,
                'Product-Owner'     => $group, //copy="true"
                'Account-State' => 'Active',
                'Master-Account' => $user_name,
                'PAS-Last-Name'     => $last_name,
                //'Service-Profiles' => $srvice_profile_array,
                'User-Data' => $user_data
                
                
            );

		$jsonDataEncoded=json_encode($jsonData);
		
		$url2 = $this->network('api_base_url').'/accounts';

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

		$body= mysql_escape_string($body);
       
		$this->log($mac,__FUNCTION__, 'Create Account', $url2, 'REST', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
		
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

		$body= mysql_escape_string($body);
       
		$this->log($mac,__FUNCTION__, 'Add Device', $url2, 'POST', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
		
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
	
	
	
	
	public function modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string,$vlan_id){
	

		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		$group=$this->network('api_acc_profile');

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
					

		$jsonData = array(
				'User-Name'     => $cust_uname,
				'Password'      => $password,
				'Product-Owner'     => $group,
				'Account-State' => $acc_state,//$this->network('master_account_status'),
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' => $uuid,
				'User-Data' => $user_date_array

		);
		
		if(strlen($password)>0){
			$jsonData['Password'] = $password;
		}
		
		
		$jsonDataEncoded = json_encode($jsonData);
		//Tell cURL that we want to send a POST request.
			//API Url
		$url2 = $this->network('api_base_url').'/accounts/'.$cust_uname;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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

		$body= mysql_escape_string($body);

		$this->log($cust_uname,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	
	
	
	
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
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;

		//$url2 = $this->network('api_base_url').'/products/'.$product;
		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";

		//Attach our encoded JSON string to the POST fields.
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		
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
		//$organization=$decoded['Group'];


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	

		$this->log($user_name,__FUNCTION__, 'Remove Profile', $url2, 'DELETE', $status_code, $body, '',$organization);
	
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
            	'VT-Vlan-Id' => $vlan_id,
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
		

		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Product-Owner'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product_list,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);
	

		$jsonDataEncoded=json_encode($jsonData);
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name.'/product';

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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
		
		$this->log($user_name,__FUNCTION__, 'Modify Profile', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	
	
	}
	

	
	////////////////////////////////////////////////////////
	
	
	public function modifyValidityTime($user_name,$validity_time){
	
		$group=$this->network('api_acc_profile');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$group=$this->network('api_acc_profile');

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
            	'VT-Vlan-Id' => $vlan_id,
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
		

		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Product-Owner'     => $group,
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
		$jsonDataEncoded=json_encode($jsonData);
		
	
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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

		$body= mysql_escape_string($body);
		
		$this->log($user_name,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
	
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
		
		
		$group=$this->network('api_acc_profile');
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
            	'VT-Vlan-Id' => $vlan_id,
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
		

		
		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Product-Owner'     => $group,
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
		
		$jsonDataEncoded=json_encode($jsonData);
		
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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
		
		$this->log($user_name,__FUNCTION__, 'AUP Modify Account', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
				
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

			
		$user_date_array = array(
            	'VT-Vlan-Id' => $vlan_id,
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
	
	
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Product-Owner'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);

		$jsonDataEncoded=json_encode($jsonData);
		
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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
		
		$this->log($user_name,__FUNCTION__, 'AUP Activate', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$organization);
		
		
	
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
                'ispremium' => 'ispremium',
                'secret_answer'      => $secret_answer,
                'secret_question'      => $secret_question
                
            );
		

		
		$jsonData = array(
				'User-Name' => $user_name,
				'Password' => $password,
				'Product-Owner'     => $group,
				'Account-State' => $acc_state,
				'Product'     => $product,
				'Email' => $email,
				'MSISDN' => $mobile_number,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'UUID' =>  $uuid,
				'User-Data' => $user_date_array
		
		);
	
	

		$jsonDataEncoded=json_encode($jsonData);
	
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name_ale;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";
		curl_setopt($ch, CURLOPT_POST, 1);
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
		

		$this->log($user_name,__FUNCTION__, 'Update Account', $url2, 'PUT', $status_code, mysql_escape_string($body), $jsonDataEncoded,$group);
	
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
		
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;
         
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

        
					
		$this->log($user_name,__FUNCTION__, 'Get Device', $url2, 'GET', $status_code, $body, '',$organization);
				
		
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
		

		$jsonDataEncoded=json_encode($jsonData);
	
		$group=$this->network('api_acc_profile');
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;
         
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

        
					
		$this->log($user_name,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$organization);
				
		
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
		
		$url2 = $this->network('api_base_url').'/accounts/'.$user_name;
         
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

	public function findUsers($search_parameter1, $term1,$realm=null){
	
	
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
		
		$url2 = $this->network('api_base_url').'/accounts?filter['.$search_parameter1.']='.$term1.'*&filter[Email]=*';
         
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

        		
		$this->log($realm,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$term1);
		
		
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
		
		$url2 = $this->network('api_base_url').'/accounts?filter['.$search_parameter1.']='.$term1.'*&filter[Master-Account]=*';
         
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

        		
		$this->log($realm,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, $body, '',$organization);
		
		
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

		$url2 = $this->network('api_base_url').'/groups';
         
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
        
		$this->log($cust_uname,__FUNCTION__, 'Search Group', $url2, 'GET', $status_code, mysql_escape_string($body), '',$organization);
				
		
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

		$url2 = $this->network('api_base_url').'/accounts?filter['.$search_parameter1.']='.$term1.'&filter['.$search_parameter2.']='.$term2; //.'&filter[Product]='.$product;
         
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
		
		$this->log($term2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($body), '',$property);

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

        $url2 = $this->network('api_base_url').'/accounts?filter['.$search_parameter1.']='.$term1.'&filter['.$search_parameter2.']='.$term2.'&filter['.$search_parameter3.']='.$term3;
         
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

		$this->log($params2,__FUNCTION__, 'Get Account', $url2, 'GET', $status_code, mysql_escape_string($body), '',$organization);


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
		
		
		$group=$this->network('api_acc_profile');
		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		$sync_limit = $this->network('record_limit');

		$url2 = $this->network('api_base_url').'/accounts?filter[Group]='.$group.'*&filter[Master-Account]='.$master_user;
         
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
		$this->log($master_user,__FUNCTION__, 'Get Device', $url2, 'GET', $status_code, mysql_escape_string($body), '',$organization);

		$session_response = $this->getDeviceSessions($master_user);
		$newdecoded = json_decode($session_response, true);

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

		//$organization=$groups[2];
		
		
		// This is an archaic parameter list
		$params = array(
				'User-Name' => $network_user
		);
		
		$group=$this->network('api_acc_profile');
		$url2 = $this->network('api_base_url').'/accounts/'.$network_user;

		$ch = curl_init($url2);
		$header_parameters = "Content-Type: application/json;charset=UTF-8";

		//Attach our encoded JSON string to the POST fields.
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");

		
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

		$decoded = json_decode($body, true);
		$valid_until=$decoded['Valid-Until'];
		//$organization=$decoded['Group'];
		$ac_state=$decoded['Account-State'];
		$desc=$decoded['internal-debug-message'];
		
		$this->log($network_user,__FUNCTION__, 'Delete Account', $url2, 'DELETE', $status_code, mysql_escape_string($body), '',$organization);
		
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
		$group=$this->network('api_acc_profile');

		
		//$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
		$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization.'*&filter[Sender-Type]=Aptilo-AC';

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
	
		
		$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', $status_code,mysql_escape_string($body), '' ,$username,$organization);
				
				
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
		$group=$this->network('api_acc_profile');

		
		//$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter[Access-Group]='.$organization;
		$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter[AAA-User-Name]='.$master_uname.'&filter[Sender-Type]=Aptilo-AC';

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
	
		
		$this->lognew(__FUNCTION__, 'Device Session Search', $url2, 'GET', $status_code,mysql_escape_string($body), '' ,$username,$organization);
				
				
		if($status_code==200){
				
				return $body;
			}

			else{
				 return $body;

			}
	
	}


	public function getSessions($username,$parameter){
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
		$group=$this->network('api_acc_profile');
		if ($parameter=='AAA-User-Name') {
			$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'*&filter[Access-Profile]=FULL&filter[Sender-Type]=Aptilo-AC';
		}
		else{
			$url2 =$this->network('api_base_url').'/sessions?filter[Zone]='.$group.'*&filter['.$parameter.']='.$username.'&filter[Sender-Type]=Aptilo-AC';
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
	
		if ($parameter=='AAA-User-Name') {
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,mysql_escape_string($body), '' ,$username,$username);
			}
		else{
		$this->lognew(__FUNCTION__, 'Session Search', $url2, 'GET', $status_code,mysql_escape_string($body), '' ,$username,$organization);	
		}	
				if(strlen($username)>0){
					$ex_1 = mysql_query($q_lo);
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
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	public function delSessions($session_token){
	
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$group=$this->network('api_acc_profile');
		// This is an archaic parameter list
		$params = array(
				'ID'      => $ses_id
		);
	
	
		
		$url2 =$this->network('api_base_url').'/sessions/'.$session_token;  

        $ch2 = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";

        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array($header_parameters));

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
		
		$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,mysql_escape_string($body), '' ,$username,$group);
	
	
				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}

   
	
	public function checkProduct($product,$organization){

		//$macc= str_replace('-','',$mac);
		
		

		$url2 = $this->network('api_base_url').'/products/'.$product;
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

	$this->log($product, __FUNCTION__, 'Get Product', $url2, 'GET', $status, mysql_real_escape_string($body), '', $organization);

	if($status == '200'){
		return $product;
	}

	else{
		 return $product;
	}
	}
	
	
	
	public function disconnectUserSessions($ses_id,$user_name){
	
		$group=$this->network('api_acc_profile');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$groups=explode('@', $user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
		
		$params = array(
				'AAA-User-Name'      => $user_name
		);
		$params2 = array(
				'Sender-Type'      => 'Aptilo-AC'
		);
	
		$url2 =$this->network('api_base_url').'/sessions/'.$ses_id;  
        //echo $url2;

        $ch2 = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";



        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array($header_parameters));

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

        $this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,mysql_escape_string($body), '' ,$user_name,$organization);


				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}	
	
	
	
	
	
	public function disconnectDeviceSessions($session_token,$aaa_user_name = NULL){

		$groups=explode('@', $aaa_user_name);
		$b=sizeof($groups);
		$a=$b-1;
		$organization=$groups[$a];
	
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
		
		$url2 =$this->network('api_base_url').'/sessions/'.$session_token;  
        //echo $url2;

        $ch2 = curl_init($url2);
        $header_parameters = "Content-Type: application/json;charset=UTF-8";



        curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch2,CURLOPT_HEADER,1);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_VERBOSE, 1);
        curl_setopt($ch2,CURLOPT_USERPWD,$this->session().":");

        //Set the content type to application/json
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array($header_parameters));

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

		$this->lognew(__FUNCTION__, 'Session Delete', $url2, 'DELETE', $status_code,mysql_escape_string($body), '' ,$user_name,$organization);
	
	
				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
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
		$this->lognew(__FUNCTION__, 'Session Start', $log_data, 'POST', $status_code,mysql_escape_string($body), $log_data ,$mac,$group);
	
	
		return 'status='.$status_wag.'&status_code='.$status_code.'&Description='.$details ;
	}
	
	
	
	


}
?>
