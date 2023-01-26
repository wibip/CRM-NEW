<?php



include_once('../../../classes/dbClass.php');



class auth
{
	
	private $access_token;
	
	public function __construct($profile)
	{
		$db_class = new db_functions();
		
		$profile_details = $this->profile($profile);
		$this->baseurl = $profile_details[0]['api_url']; //'https://api.us.onelogin.com';
		$this->Secret = $profile_details[0]['api_password']; //'40c2b5a5d1c6a8ea3dae06e544b45f1fa67871a483e651efc583b8b11fd2bc51';
		$this->client_id = $profile_details[0]['api_user_name']; //'287db945488ac4bf822d11481bba83d745d62cb47579e7d4bb2f8aeebdf2d2f9';

		 
	}
	
	
	
	


	///////////////////////////////////////////////////////////////////////////
	
	
	
	public function log($function,$function_name,$description,$method,$api_status,$api_details,$api_data,$rlm){
		$query = "INSERT INTO `exp_auth_profile_logs`
		(`realm`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`, `unixtimestamp`)
		VALUES ('$rlm','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'API',UNIX_TIMESTAMP())";
		$query_results=mysql_query($query);
	
	}
	
	
	public function profile($profile){
		$query = "SELECT * from exp_auth_profile WHERE profile_name = '$profile'";
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$results[] = $row;
		}
		return $results;
	}
		
	


   


	/////// Add User ///////////////
	public function addUser($user_data){
	
		$data = json_encode($user_data);

		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData = array(
				'firstname'   => $user_data['firstname'],
				'lastname'   => $user_data['lastname'],
				'email'   => $user_data['email'],
				'username'   => $user_data['username'],
		);
		

		$query = "INSERT INTO admin_users
		(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, mobile, is_enable, create_date,create_user)
		VALUES ('$user_name_peer',PASSWORD('$password'),'admin','$user_type_up','$user_distributor','$full_name','$email','$language','$mobile','2',now(),'$user_name')";
		$query_results=mysql_query($query);
		
		//$this->log(__FUNCTION__,'Add User',$url,'POST',$status,$body,$jsonDataEncoded2,'');
		
		//print_r($sus);
	
	}
	
	
	
	
	
	
	////////////// get user //////////
	public function getUser($id=null){
	
	$query = "INSERT INTO admin_users WHERE user_name = ''";
	
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$results[] = $row;
		}
		return $results;	
	
	}
	
	

////////////////////// edit user //////////////
	public function editUser($user_data,$id){
	
		$data = json_encode($user_data);

		
		$access_code = 'bearer:'.$this->access_token;
		$jsonData = array(
				'firstname'   => $user_data['firstname'],
				'lastname'   => $user_data['lastname'],
				'email'   => $user_data['email'],
				'username'   => $user_data['username'],
		);
		

		$query = "INSERT INTO admin_users
		(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, mobile, is_enable, create_date,create_user)
		VALUES ('$user_name_peer',PASSWORD('$password'),'admin','$user_type_up','$user_distributor','$full_name','$email','$language','$mobile','2',now(),'$user_name')";
		$query_results=mysql_query($query);
	
	
	}

	
	

	
	//////////////// remove user //////////////
	public function removeUser($id){
		
	$query = "INSERT INTO admin_users WHERE user_name = ''";
	$query_results=mysql_query($query);
	$query = "DELETE FROM admin_users WHERE user_name = ''";
	
	}
	
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////// get roles //////////////
	public function getRoles($user_data){
	

	
	}
	
	
/////////////////get roles by users//////////////
	public function getRolesforUser($user_data){
	
		$query_results=mysql_query($query);
		while($row=mysql_fetch_array($query_results)){
			$results[] = $row;
		}
		return $results;
	
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
}

?>