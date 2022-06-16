<?php



include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');



class auth
{
	
	private $access_token;
	
	public function __construct($profile)
	{
		$db_class = new db_functions();
		
		/*$profile_details = $this->profile($profile);
		$this->baseurl = $profile_details[0]['api_url']; //'https://api.us.onelogin.com';
		$this->Secret = $profile_details[0]['api_password']; //'40c2b5a5d1c6a8ea3dae06e544b45f1fa67871a483e651efc583b8b11fd2bc51';
		$this->client_id = $profile_details[0]['api_user_name']; //'287db945488ac4bf822d11481bba83d745d62cb47579e7d4bb2f8aeebdf2d2f9';*/
		$this->client_id = 'admin';
		$this->Secret = 'ruckus1234!';
		$session_details = $this->session($this->client_id,$this->Secret);
		$this->access_token = $session_details[data][0][access_token];
		
		 //print_r($session_details[data][0][access_token]);
		
	
	}
	
	///////////////////////////////////// session copy

	
	


	///////////////////////////////////////////////////////////////////////////
	
	
	
	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$rlm){
		$query = "INSERT INTO `exp_wag_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`)
		VALUES ('$rlm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API')";
		$query_results=mysql_query($query);
	
	}
	
	
	public function profile11($profile){
		$query = "SELECT * from exp_wag_profile WHERE profile_name = '$profile'";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$results[] = $row;
		}
		return $results;
	}
		
	


	///////////////session start/////////////////
	
	public function session(){
		
		$client_id = 'admin';
		$client_secret = 'ruckus1234!';
		/*$url_postfix = '/auth/oauth2/token';
		$url = $this->baseurl.$url_postfix;*/
		 $url = 'https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/session';
		
		$auth_code = 'client_id:'.$client_id.', client_secret:'.$client_secret;
		
		//Initiate cURL.
		$ch = curl_init($url);
		
		//The JSON data.
		/*$jsonData = array(
				'grant_type'   => 'client_credentials',
		);*/
		 
		$jsonData = array(
				'username'   => 'admin',
				'password'   => 'ruckus1234!',
				'timeZoneUtcOffset'   => '+05:30',
		);
		$header_array = array(
            
            'Content-Type: application/json');
		//print_r($header_array);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//print_r($jsonDataEncoded);
		//curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
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
		//print_r($sus);

		$results=array(
			'cookie'   => $pieces[0],
			'baseurl'  => $url
			);
		
		 //print_r($results);
			return $results;


		/*	
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		echo$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		/*return*/ //echo $sus=json_decode($body,true);*/	
		//print_r($sus);	

	}


   


	/////// Add User ///////////////
	public function addUser($user_data){
		
				/*
				'firstname',
				'lastname' 
				'email'   
				'username'   
				'password'   
				'access_role'
				'user_type' 
				'loation'  
				'mobile'   
				'language' 
				'verification_number'
				'account_state'  
				'created_by'  
				*/
	
		$data = json_encode($user_data);

		$url_postfix = '/api/1/users';
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData = array(
				'firstname'   => $user_data['firstname'],
				'lastname'   => $user_data['lastname'],
				'email'   => $user_data['email'],
				'username'   => $user_data['username'],
				'phone' => $user_data['mobile'],
				
		);
		
		$jsonDataEncoded2 = json_encode($data);
		
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		
		$full_name = $jsonData[firstname].' '.$jsonData[lastname];
		
		$this->log(__FUNCTION__,'Add User',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
	//	print_r($sus);
	 
		$status_code = $sus[status][code];	
		$status_message = $sus[status][message];			
		$remote_user_id = $sus[data][0][id];
		
		if($status_code ==200){
			$query = "INSERT INTO admin_users
			(user_name,global_user_id, `password`, access_role, user_type, user_distributor, full_name, email, `language`, mobile,verification_number, is_enable, create_date,create_user)
			VALUES ('$user_data[username]','$remote_user_id',PASSWORD('$user_data[password]'),'$user_data[access_role]','$user_data[user_type]','$user_data[loation]','$full_name','$user_data[email]','$user_data[language]','$user_data[mobile]','$user_data[verification_number]','$user_data[account_state]',now(),'$user_data[created_by]')";
			$ex = mysql_query($query);	
			$results[status] = 200;
			$results[description] = $status_message;
			$results[user_id] = $remote_user_id;
		}
		
		else{
			$results[status] = 400;
			$results[description] = $status_message;
			
		
		}
		
		print_r($results);
		return $results;
		
	
	}
	
	
		
	
	
	
	////////////// get user //////////
	public function getUser($id=null){
	
	//	$data = json_encode($user_data);
	//	$jsonDataEncoded2 = json_encode($data);

		if(isset($id)){
		$url_postfix = '/api/1/users/'.$id;
		}
		else{
			$url_postfix = '/api/1/users/';
		}
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;

		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		
		 $result = curl_exec($ch);
		 $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Get User',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		//print_r($sus[data][0]);
		$status_code = $sus[status][code];	
		$status_message = $sus[status][message];			
		
		if($status_code ==200){

			$results[status] = 200;
			$results[description] = $status_message;
			
			$results[data]['firstname'] = $sus[data][0][firstname];
			$results[data]['lastname'] = $sus[data][0][lastname];
			$results[data]['email'] = $sus[data][0][email];
			$results[data]['username'] = $sus[data][0][username];
			//$results[data]['password'] = $sus[data][0][];
			//$results[data]['access_role'] = $sus[data][0][];
			//$results[data]['user_type'] = $sus[data][0][];
			//$results[data]['loation'] = $sus[data][0][];
			$results[data]['mobile'] = $sus[data][0][phone];  
			//$results[data]['language'] = $sus[data][0][];
			//$results[data]['verification_number'] = $sus[data][0][];
			//$results[data]['account_state'] = $sus[data][0][]; 
			//$results[data]['created_by'] = $sus[data][0][];
		}
		
		else{
			$results[status] = 400;
			$results[description] = $status_message;
			
		
		}
		
		print_r($results);
		
	
	}
	
	

////////////////////// edit user //////////////
	public function editUser($user_data,$id){
		
		/*
				'firstname',
				'lastname' 
				'email'   
				'username'   
				'password'   
				'access_role'
				'user_type' 
				'loation'  
				'mobile'   
				'language' 
				'verification_number'
				'account_state'  
				'created_by'  
				*/
	
		$data = json_encode($user_data);
		$jsonDataEncoded2 = json_encode($data).'/'.$id;

		$url_postfix = '/api/1/users/'.$id;
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		
		$jsonData = array(
				'firstname'   => $user_data['firstname'],
				'lastname'   => $user_data['lastname'],
				'email'   => $user_data['email'],
				'username'   => $user_data['username'],
				'phone' => $user_data['mobile'],
				
		);
		
		$jsonData = array_filter($jsonData);
		print_r($jsonData);
		
		//echo "<br>";
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Edit User',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		//print_r($sus);
		echo "<br>";
	
	}

	
	

	
	//////////////// remove user //////////////
	public function removeUser($id){
	
		//$data = json_encode($user_data);

		$url_postfix = '/api/1/users/'.$id;
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData=$id;

		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//curl_setopt($ch, CURLOPT_DEL, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Remove User',$url,'POST',$status,$body,$id,'');
		return $sus;
		//print_r($sus);
		//echo "<br>";
	
	}
	
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////// get roles //////////////
	public function getRoles($user_data){
	
		//$id=$role_id_array[0];
		$data = json_encode($user_data);
		$jsonDataEncoded2 = json_encode($data);

		 //$url_postfix = '/api/1/roles';
		 $url = 'https://vsz50-so.arrisi.com:8443/api/v7_0/userGroups/roles';
		//$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData=$user_data;
		//$jsonData = array(
				
			//	 $user_data[0],
				// $user_data[1],
				
		//);
		//echo "<br>";
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//curl_setopt($ch, CURLOPT_DEL, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Get Roles',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		
		echo "<br>";
	
	}
	
	
/////////////////get roles by users//////////////
	public function getRolesforUser($user_data){
	
		//$id=$role_id_array[0];
		$data = json_encode($user_data);
		$jsonDataEncoded2 = json_encode($data);

		 $url_postfix = '/api/1/users/'.$user_data.'/roles';
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData=$user_data;
		//$jsonData = array(
				
			//	 $user_data[0],
				// $user_data[1],
				
		//);
		//echo "<br>";
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);
		//curl_setopt($ch, CURLOPT_DEL, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Get Roles for User',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		echo "<br>";
	
	}
	
	
	
	//////////////////// assign roles by users //////////////
	public function assignRoles($id,$user_data){
	
		//$id=$role_id_array[0];
		 $jsonData = json_encode($user_data);
		 $jsonDataEncoded2 = json_encode($jsonData).'/'.$id;

		$url_postfix = '/api/1/users/'.$id.'/add_roles';
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		
		
		//echo "<br>";
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Assign Roles',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		echo "<br>";
	
	}

	
	
	//////////////////// remove roles from users //////////////
	public function removeRoles($id,$user_data){
	
		//$id=$role_id_array[0];
		$jsonData = json_encode($user_data);
		$jsonDataEncoded2 = json_encode($jsonData).'/'.$id;
		$url_postfix = '/api/1/users/'.$id.'/remove_roles';
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);
			
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Remove Roles',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		echo "<br>";
	
	}
	
	
	
	///////////////Set Password by ID Using SHA ///////////
	public function setPasswordUC($id,$user_data){
	
		//$id=$role_id_array[0];
		$jsonData = json_encode($user_data);
		$jsonDataEncoded2 = json_encode($jsonData).'/'.$id;

		$url_postfix = '/api/1/users/set_password_clear_text/'.$id;
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Set Password',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		echo "<br>";
	
	}
	
	

	//////////// Generate Invite Link ////////////
	public function generatelink($user_data){
	
		//$id=$role_id_array[0];
		 $jsonData = json_encode($user_data);
		 $jsonDataEncoded2 = json_encode($jsonData);

		 $url_postfix = '/api/1/invites/get_invite_link';
		$url = $this->baseurl.$url_postfix;
		
		$access_code = 'bearer:'.$this->access_token;
		
		$header_array = array(
            'Authorization: '.$access_code.'',
            'Content-Type: application/json');
			
		//Initiate cURL.
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		$this->log(__FUNCTION__,'Get Invite Link',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		print_r($sus);
		echo "<br>";
	
	}
	//////////// login SERVICE TICKET   ////////////
	public function serviceTicket($user_data){
	
		//$id=$role_id_array[0];
		 $jsonData = json_encode($user_data);
		// $jsonDataEncoded2 = json_encode($jsonData);

		// $url_postfix = '/api/1/invites/get_invite_link';
		//$url = $this->baseurl.$url_postfix;
		// https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/serviceTicket
		echo $url = 'https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/serviceTicket';
		
		 $access_code = 'bearer:'.$this->access_token;
		
		$header_array = array(
            
            'Content-Type: application/json;charset=UTF-8');
			
		//Initiate cURL.
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header_array);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		//Execute the request
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);		
		curl_close ($ch);		
		$sus=json_decode($body,true);
		//print_r($sus);
		//return $sus;
		$this->log(__FUNCTION__,'Get Invite Link',$url,'POST',$status,$body,$jsonData,'');
		
		print_r($sus);
		return $sus;
		echo "<br> sedfg";
	
	
}

///////////////////////// index file editing start ////////////////////////////
////////////////////////////////////////////////////////////////////////////

///////////////rkszones/////////////////
	public function rkszones(){
		
	$input=$this->session();

	//echo $input[cookie];
		//$login=$this->login();
		
		/*$url2=$this->baseurl.'/rkszones';*/
		$url2='https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/rkszones';
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

		///////////////////
		curl_close ($ch);		
		$sus=json_decode($message,true);
		print_r($sus);
		////

		echo$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		$myText = (string)$message;
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $myText, $url2,$this->realm);
		
		//////
		
//$this->log(__FUNCTION__,'Check Zones', $url2 ,'GET', $status , $message , '');
		
		//echo $message;
        if($status == '200' || $status=='204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
	

	}

	///////////////firmware/////////////////
	public function firmware($user_data){
		
	$input=$this->session();
	$input1=$this->serviceTicket($user_data);
	echo "<br>";
	 echo $input[cookie];
	 echo $input1[serviceTicket];


	 //echo $jsonData = json_encode(array("serviceTicket"=>$input1[serviceTicket]));
		//$login=$this->login();
		
		/*$url2=$this->baseurl.'/rkszones';
				https://vsz50-so.arrisi.com:8443/switchm/api/v7_0/firmware*/
		echo $url2='https://vsz50-so.arrisi.com:8443/switchm/api/v7_0/firmware?'.$input1[serviceTicket];
		 //$url2 = 'https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/firmware';
		$ch2 = curl_init($url2);
		
		curl_setopt($ch2,CURLOPT_HTTPHEADER,array("Authorization:".$input[cookie]."",
			'Content-Type: application/json'));
		
		curl_setopt($ch2,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch2,CURLOPT_HEADER,1);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($ch2, CURLOPT_VERBOSE, 1);

        //ADD FROM RACUS V5
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 6);
        curl_setopt ($ch2, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
        curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);


          echo $resultl=curl_exec($ch2);
		
		$header_size = curl_getinfo($ch2, CURLINFO_HEADER_SIZE);
		
		$header = substr($resultl, 0, $header_size);
		$message = substr($resultl, $header_size);

		///////////////////
		curl_close ($ch);		
		$sus=json_decode($message,true);
		echo "<br>";
		print_r($sus);
		////

		$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		$myText = (string)$message;
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $myText, $url2,$this->realm);
		
		//////
		
//$this->log(__FUNCTION__,'Check Zones', $url2 ,'GET', $status , $message , '');
		
		//echo $message;
        if($status == '200' || $status=='204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
	

	}
///////////////rkszones/////////////////
	public function aps(){
		
	$input=$this->session();

	//echo $input[cookie];
		//$login=$this->login();
		
		/*$url2=$this->baseurl.'/rkszones';*/
		$url2='https://vsz50-so.arrisi.com:8443/wsg/api/public/v7_0/aps';
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

		///////////////////
		curl_close ($ch);		
		$sus=json_decode($message,true);
		print_r($sus);
		////

		echo$status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
		
		$myText = (string)$message;
		//$this->log(__FUNCTION__,'Create CPE', $api_path,'POST', $status, $message, json_encode($jsonData));
		
		$this->log(__FUNCTION__,'Check Zones', $url2,'GET', $status, $myText, $url2,$this->realm);
		
		//////
		
//$this->log(__FUNCTION__,'Check Zones', $url2 ,'GET', $status , $message , '');
		
		//echo $message;
        if($status == '200' || $status=='204'){

            return 'status=success&status_code=200&Description='.$message;

        }
        else{
            return 'status=failed&status_code='.$status.'&Description='.$message;

        }
	

	}



}



?>