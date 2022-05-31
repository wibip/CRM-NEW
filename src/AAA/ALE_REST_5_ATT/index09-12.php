<?php
header("Cache-Control: no-cache, must-revalidate");


include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');

include_once('function.php');



//include_once( str_replace('//','/',dirname(__FILE__).'/') .'../config/db_config.php');

//require_once('../../../db/config.php');




class network_functions
{


	public function __construct()
	{
		$db_class = new db_functions();

		$this->url = $this->network('api_base_url');
		$this->ses_url = $this->network('ses_base_url');
		$this->auth_token = $this->network('api_acc_org');

		

		//$this->network_name = $db_class->setVal("network_name",'ADMIN');

		//$this->lib_name = 'ALE_5_REST_ATT';

		
	}

	
	
	
	public function network($parameter) {

        $query = "SELECT $parameter AS val FROM exp_network_profile p WHERE p.network_profile='ALE_5_REST_ATT'";
        $query_results=mysql_query($query);
        while($row=mysql_fetch_array($query_results)){
            $result = $row['val'];
        }
        return $result;
		
	}

	

	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null){
		 $query = "INSERT INTO `exp_aaa_logs`
		(`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id)
		VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'MDU','$group_id')";
		$query_results=mysql_query($query);
	}
	
	
	public function session(){

		$url = $this->network('api_base_url').'/tokens';
		
		
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
           $this->log('',__FUNCTION__, 'Unauthorized User', $url, 'REST', $status_code,mysql_escape_string($body), $jsonData ,'','');
           
    
        }
        $sus=json_decode($body,true);
        //curl_close ($ch);
        //echo $sus[auth_token];
        return $sus['auth_token'];
	}
	////////////////////////////////////////////////////////////////////////

	public function masterAcc($username,$password,$organization,$service_profile_product,$first_name,$last_name,$email,$mobile_number,$user_data_string,$validity_time){
	

		/*//echo $service_profile_product;
		$tz_object = new DateTimeZone($this->network('api_time_zone'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		
		$validity_time_code = 'PT'.$validity_time.'S';
		$datetime->add(new DateInterval($validity_time_code));
		
		//$datetime->add(new DateInterval($this->network('MASTER_ACC_TIMEGAP_MINUTES')));
		$enddate = $datetime->format('Y-m-d H:i:s');
	
		$differenceInSeconds = strtotime($enddate) - $begindate;*/
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		
		//echo $secret_question;
		//echo $secret_answer;
		if(isset($vlan_id)){

            $user_date_array = array(

                'secret_answer'      => $secret_answer,
                'warning'      => $warning,
                'zip'      => $zip,
                'country'      => $country,
                'usermessage'      => $usermessage,
                'city'      => $city,
                'violation'      => $violation,
                'company'      => $company,
                'secret_question'      => $secret_question,
                'address'      => $address,
                'state'      => $state,
                'address2' => 	$address2,
                'ispremium' => $this->network('premium_feature'), //'false'
                'VT-Vlan-Id' => $vlan_id
            );
        }else{

            $user_date_array = array(

                'secret_answer'      => $secret_answer,
                'warning'      => $warning,
                'zip'      => $zip,
                'country'      => $country,
                'usermessage'      => $usermessage,
                'city'      => $city,
                'violation'      => $violation,
                'company'      => $company,
                'secret_question'      => $secret_question,
                'address'      => $address,
                'state'      => $state,
                'address2' => 	$address2,
                'ispremium' => $this->network('premium_feature') //'false'
            );


        }
		

		
		
		$credits_array = array(
		
				'Bucket-1'      => '1000000000000000'
		);
		
		
		$product_list =  explode(',',$service_profile_product);
		//$product_list = explode(',',$this->network('PRODUCT'));
		
		$srvice_profile_array = array();
		foreach ($product_list as $key => $value){
			$srvice_profile_array[$value] = 'true';
		}
		
		$group=$this->network('api_acc_profile');
		$jsonData = array(
				'Password'      => $password,
				'User-Name'     => $username,
				'Group' => $organization, //'MSISDN,copy',	// copy="true"
				'Account-State' => $this->network('master_account_status'),//'Inactive', // Active or Inactive
				'MSISDN' => $mobile_number,
				'Email' => $email,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				
			//	'First-Access'     => '0',
			 //	'Last-Access'     => '0',
			 
			    'Service-Profiles' => $srvice_profile_array, //$this->network('PRODUCT'),
				'User-Data' => $user_date_array,//$user_data_string,
				'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
				'Credits' => $credits_array,  //'Bucket-1=1',
				'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
				'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
				'PAS-Password-Secret-Answer' => $secret_answer,
				'PAS-Password-Secret-Question' => $secret_question,
				'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
				'Valid-From'    => $begindate,	// 1415092796.2
				'Valid-Until'   => $enddate,
				'Product-Owner'     => $group,
				'Product'     => $service_profile_product,
				'Validity-Time' => $validity_time
			//	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))

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
		
		$this->log($username,__FUNCTION__, 'Create Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
				
				
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.$status_code;
						
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					
				}
		
			
		
	}
	
	

	
	////////////////////////////////////////////////////////////////////////
	
	
	public function subAcc($mac,$username,$organization,$first_name,$last_name,$email,$mobile_number,$vlan_id=NULL){
	
	
		$tz_object = new DateTimeZone($this->network('api_time_zone'));
		$datetime = new DateTime(null,$tz_object);
		$begindate = strtotime($datetime->format('Y-m-d H:i:s'));
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		
		$srvice_profile_array = array(
		
				'Aptilo-WiFi-Account-Charge-Master-SP'      => 'true'
				//$this->network('sub_product')      => 'true'
		);
		
		
		if(is_null($vlan_id)){

			$jsonData = array(
                'Password'      => $mac, //copy="true"
                'User-Name'     => $mac,
                'Master-Account' => $username,
                'Group' => $organization, //'MSISDN', //copy="true"
                'Account-State' => $this->network('sub_account_status'),//'Active',
                'MSISDN' => $mobile_number,// This is equal to MAC => $mac,
                'Email' => $email,
                //'Validity-Time' => urlencode($this->network('TIME_LEFT')),
                'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
                'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
                'PAS-First-Name'    => $first_name,
                'PAS-Last-Name'     => $last_name,
                'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
                'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
                //'First-Access'     => $begindate,
                //'Last-Access'     => $begindate,
                'Service-Profiles' => $srvice_profile_array,
                'Product-Owner'     => $organization,
				'Product'     => $service_profile_product
                //	'Service-Profiles' => urlencode($this->network('PRODUCT')),
                //	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
            );




        }else{
            $user_date_array = array(

                'VT-Vlan-Id' => $vlan_id,
            );

            $jsonData = array(
                'Password'      => $mac, //copy="true"
                'User-Name'     => $mac,
                'Master-Account' => $username,
                'Group' => $organization, //'MSISDN', //copy="true"
                'Account-State' => $this->network('sub_account_status'),//'Active',
                'MSISDN' => $mobile_number,// This is equal to MAC => $mac,
                'Email' => $email,
                //'Validity-Time' => urlencode($this->network('TIME_LEFT')),
                'PAS-Account-Locked' => $this->network('pas_account_locked'),//'False',
                'PAS-Account-Type' => $this->network('pas_account_type'),//'credits',
                'PAS-First-Name'    => $first_name,
                'PAS-Last-Name'     => $last_name,
                'PAS-Allow-Extend' => $this->network('pas_allow_extent'),//'True',
                'PAS-Allow-Overwrite' => $this->network('pas_allow_overwrite'),//'True',
                //'First-Access'     => $begindate,
                //'Last-Access'     => $begindate,
                'Service-Profiles' => $srvice_profile_array,
                'User-Data' => $user_date_array,//$user_data_string,
                //	'Service-Profiles' => urlencode($this->network('PRODUCT')),
                //	'Purge-Delay-Time' => urlencode($this->network('TIME_LEFT'))
            );
        }

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

		$body= mysql_escape_string($body);
       
		$this->log($mac,__FUNCTION__, 'Create Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
		
				if($status_code == '201'){
					return 'status=success&status_code='.'200'.'&Description=Device Creation Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	
	
	
	public function modifyAcc($cust_uname,$email,$password,$first_name,$last_name,$organization,$mobile_number,$user_data_string){
	

		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		$userdata_decrypt = urldecode($user_data_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
		
		
		$user_date_array = array(
		
				'secret_answer'      => $secret_answer,
				'warning'      => $warning,
				'zip'      => $zip,
				'country'      => $country,
				'usermessage'      => $usermessage,
				'city'      => $city,
				'violation'      => $violation,
				'company'      => $company,
				'secret_question'      => $secret_question,
				'address'      => $address,
				'state'      => $state
		);
		

		
		
		
		$jsonData = array(
				
				'Group' => $organization,
				'PAS-First-Name'    => $first_name,
				'PAS-Last-Name'     => $last_name,
				'EMAIL' => $email,
				'MSISDN' => $mobile_number,
				'Product-Owner'     => $organization,
				'User-Name' => $cust_uname,
				'Product'     => 'frontier-product-15min',
			//	'Service-Profiles' => urlencode($this->network('PRODUCT')),
				'User-Data' => $user_date_array //$user_data_string,


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

		$body= mysql_escape_string($body);

		$this->log($cust_uname,__FUNCTION__, 'Modify Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
		
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
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		
		$params_update = array(
	
				'Service-Profiles' => 'REMOVE|',
				//'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);

		$url2 = $this->network('api_base_url').'/products/'.$product;
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
	

	
		$this->log($cust_uname,__FUNCTION__, 'Remove Profile', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account Update is Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
			
	
	
	}

	////////////////////////////////////////////////////////
	
	
	public function modifyProfile($user_name,$product_list){
	
	
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
	
		$product_list = explode(',',$product_list);
		
		$srvice_profile_array = array();
		foreach ($product_list as $key => $value){
			$srvice_profile_array[$value] = 'true';
		}
	

		$params_update = array(
	
				//'Service-Profiles' => 'REMOVE|',
				'Service-Profiles' => $srvice_profile_array //$this->network('PRODUCT'),
		);

		$jsonDataEncoded=json_encode($jsonData);
		$url2 = $this->network('api_base_url').'/products/'.$product;

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
	
		$this->log($cust_uname,__FUNCTION__, 'Modify Profile', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
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
	
	
		require_once('lib/nusoap-update.php');
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		
	
		$params_update = array(
	
				//'Service-Profiles' => 'REMOVE|',
				'Validity-Time' => $validity_time //$this->network('PRODUCT'),
		);
		$jsonDataEncoded=json_encode($params_update);
	
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
		
		$this->log($cust_uname,__FUNCTION__, 'Modify Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
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
		
		
		
		$aup_text_log = $user_name.', AUP Message = '.$aup_message_text;
		
		
		
		$credits_reservation_array = array(
		
				'Bucket-1' => 'REMOVE|'
				//'Bucket-1'      => '0'
		);
		
		
		$credits_array = array(
		
				'Bucket-1'      => '0'
		);
		
		
		$user_date_array = array(
		
				'warning'      => $aup_message_text,
			//	'usermessage'      => $user_message_text//,
			//	'violation'      => $aup_message_text
		);
		
		
		$params_update = array(
		
	
				'User-Data' => $user_date_array,
				'Credits' => $credits_array,  //'Bucket-1=1',
				'Credit-Reservations' => $credits_reservation_array // (ADD|10,REMOVE|)
		
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


		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		
		$this->log($cust_uname,__FUNCTION__, 'AUP Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
				
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
	
	public function AUP_Activate($user_name){
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	

	
		$credits_array = array(
	
				'Bucket-1'      => '1000000000000000'
		);
	
	
		$user_date_array = array(
	
				'warning'      => '0',
			//	'usermessage'      => '0',
				'violation'      => '0'
		);
	
	
		$params_update = array(
	
	
				'User-Data' => $user_date_array,
				'Credits' => $credits_array,  //'Bucket-1=1',
	
		);
	
	
		$this->log($cust_uname,__FUNCTION__, 'AUP Activate ', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
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
	
		
	
		$userdata_decrypt = urldecode($user_date_string);
		$userdate_2 = urldecode(urldecode($userdata_decrypt));
		parse_str($userdate_2);
	
	
		$user_date_array = array(
	
				'usermessage'      => $user_message_text//,

		);
	
	
		$params_update = array(
	
	
				'User-Data' => $user_date_array,
	
		);
	
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
		
		$this->log($cust_uname,__FUNCTION__, 'Modify Account', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=User message update Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	}
	
	
	
	
	
	public function findUsers($search_parameter1, $term1){
	
	
		$search_string_log = $search_parameter1.' = '.$term1;
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		// This is an archaic parameter list
		$params = array(
				//'Master-Account' => NULL
				$search_parameter1      => $term1,
				//'Account-State'      => 'Inactive'

		);
		
		
		$sync_limit = $this->network('record_limit');//1000;
		
		$url2 = $this->network('api_base_url').'/accounts?filter[Group]='.$group;
         
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
		
		$this->log($cust_uname,__FUNCTION__, 'Search Users', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
				
		
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
		
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	

	public function findMasterUsers($search_parameter1, $term1,$search_parameter2, $term2){



		$search_string_log1 = $search_parameter1.' = '.$term1;
		$search_string_log2 = $search_parameter2.' = '.$term2;

        $log_string=$search_string_log1."-".$search_string_log2;

		$u_id = rand(1,9).uniqid().rand(1111,9999);

		$client->setUseCurl($useCURL);
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


		$sync_limit = $this->network('record_limit');//1000;

		$url2 = $this->network('api_base_url').'/accounts?filter[Group]='.$group;
         
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
		
		$this->log($uname,__FUNCTION__, 'Search Users', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);


				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);

				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
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

        $search_string_log1 = $search_parameter1.' = '.$term1;
        $search_string_log2 = $search_parameter2.' = '.$term2;
        $search_string_log3 = $search_parameter3.' = '.$term3;

        $log_string=$search_string_log1."/".$search_string_log2."/".$search_string_log3;

        $u_id = rand(1,9).uniqid().rand(1111,9999);

        

        // This is an archaic parameter list
        $params = array(

            $search_parameter1      => $term1


        );
        $params2 = array(
            $search_parameter2      => $term2,
            $search_parameter3      => $term3,
        );


        $sync_limit = $this->network('record_limit');//1000;

        $url2 = $this->network('api_base_url').'/accounts?filter[Group]='.$group;
         
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


        $this->log($cust_uname,__FUNCTION__, 'Search Users', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);


                if($status_code == '200'){
                    return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);

                }
                else{
                    return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
                    /* SOAP Parameter Error */
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
	
		//return $fields;
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		
		// This is an archaic parameter list
		$params = array(
				'Master-Account'      => $master_user
		);
		
		$sync_limit = $this->network('record_limit');

		$url2 = $this->network('api_base_url').'/accounts?filter[Group]='.$group;
         
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
		
		$this->log($uname,__FUNCTION__, 'Search Users', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
				
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Device get Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
			
	}
	
	
	public function delUser($network_user){

	
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		
		
		// This is an archaic parameter list
		$params = array(
				'User-Name' => $network_user
		);
		
		
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
		$ac_state=$decoded['Account-State'];
		$desc=$decoded['internal-debug-message'];
		
		$this->log($cust_uname,__FUNCTION__, 'Delete Device', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
		
				if($status_code == '204'){
					return 'status=success&status_code='.'200'.'&Description=Account Delete Success - '.$status_code;
		
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
		
	}
	
	
	////////////////////////////////////////////////////////////////////////


	public function getSessions($username,$parameter){
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
		$search_term = $parameter.' = '.$username;
		
		
		$params = array(
				$parameter => $username,
		);
		
		$url2 =$this->network('api_base_url').'/sessions?filter[Group]='.$group.'&filter[Access-Group]='.$organization;
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
	
		
		$this->log($cust_uname,__FUNCTION__, 'Get Sessions', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
				
				if(strlen($username)>0){
					$ex_1 = mysql_query($q_lo);
				}
				
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Account get is Success - '.$status_code.'&parameters='.urlencode($profile_string_final);
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
	
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	
	

	
	
	
	
	
	
	
	
	public function delSessions($ses_id){
	
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		
		// This is an archaic parameter list
		$params = array(
				'ID'      => $ses_id
		);
	
	
		
		$url2 =$this->network('api_base_url').'/sessions/'.$session_token.'?forced=true';  

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
		
		$this->log($cust_uname,__FUNCTION__, 'Delete Session', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}
	
	
	
	
	public function disconnectUserSessions($user_name){
	
		
		
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		
		$params = array(
				'AAA-User-Name'      => $user_name
		);
		$params2 = array(
				'Sender-Type'      => 'Aptilo-AC'
		);
	
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

		$this->log($cust_uname,__FUNCTION__, 'Delete Session', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);

				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
				}
				else{
					return 'status=failed&status_code='.$status_code.'&Description='.$desc.' - '.$status_code;
					/* SOAP Parameter Error */
				}
	
		
	
	}	
	
	
	
	
	
	public function disconnectDeviceSessions($user_name,$aaa_user_name = NULL){
	
		
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

		$this->log($cust_uname,__FUNCTION__, 'Delete Session', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
	
				if($status_code == '200'){
					return 'status=success&status_code='.$status_code.'&Description=Session deleted Success - '.$status_code;
	
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
		$group = $parameter_array['group'];
	
		
	
		$group = $group;//$this->getGroup($token_id);
	
		$u_id = rand(1,9).uniqid().rand(1111,9999);
	
		// get Variables
		$ses_base_url = $this->network($this->ses_url);
	
		
		$params_update = array(
	
				'User-Name'    => $mac,
				'Password'     => $mac,
	
		);
	
	
	
		$sndmacex= explode("@",$mac);
	
		$sndmac=$sndmacex[0];

		$url2 = $this->network('ses_base_url').'/sessions/'.$session_token.'/login';
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
	
		$this->log($cust_uname,__FUNCTION__, 'Start Session', $url2, 'REST', $status_code, $body, $jsonDataEncoded,$organization);
	
	
		return 'status='.$status_wag.'&status_code='.$status_code.'&Description='.$details ;
	}
	
	
	
	


}
?>
