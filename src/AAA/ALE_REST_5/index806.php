<?phpheader("Cache-Control: no-cache, must-revalidate");include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');include_once('function.php');class aaa{	 public function __construct($network_name,$access_method)	{		$db_class = new db_functions();		//$this->network_name = $db_class->setVal("network_name",'ADMIN');		$this->lib_name = 'ALE_5_REST';		//$this->auth_token = '933ab16d-9587-47a2-bfbc-8565157d7b9f';		$this->auth_token = $this->getNetworkConfig($this->lib_name,'api_acc_org');	}	public function getNetworkConfig($network,$field)	{		$query = "SELECT $field AS f FROM exp_network_profile WHERE network_profile = '$network' LIMIT 1";		$query_results=mysql_query($query);		while($row=mysql_fetch_array($query_results)){			return $row['f'];		}	}	public function log($aaa_username,$function,$function_name,$description,$method,$api_status,$api_details,$api_data,$group_id=null){		 $query = "INSERT INTO `exp_aaa_logs`		(`username`,`function`, function_name,`description`,api_method, `api_status`, `api_description`, `api_data`, `create_date`, `create_user`,group_id)		VALUES ('$aaa_username','$function','$function_name', '$description','$method', '$api_status', '$api_details', '$api_data', NOW(), 'Support','$group_id')";		$query_results=mysql_query($query);	}	public function getGroup($token){			 $query = "SELECT `group` from exp_security_tokens		WHERE token_id = '$token'";			$query_results=mysql_query($query);		while($row=mysql_fetch_array($query_results)){			$group = $row[group];		}	return $group;			//$other_parameters_array = (array)json_decode($other_parameters);		//return $other_parameters_array[realm];	}	public function getPurgeTime($realm){		 $query = "SELECT purge_time AS f FROM `exp_products_distributor` p ,`exp_mno_distributor` d                   WHERE d.distributor_code=p.`distributor_code`                   AND d.`verification_number`='$realm'                 AND p.network_type='guest'";		$query_results=mysql_query($query);		while($row=mysql_fetch_array($query_results)){			$purg_time = $row[f];		}return $purg_time;		//$other_parameters_array = (array)json_decode($other_parameters);		//return $other_parameters_array[realm];	}	public function getToken($mac){				$macc= str_replace('-','',$mac);		$query = "SELECT token FROM exp_customer_sessions_mac WHERE mac = '$macc' LIMIT 1";				$query_results=mysql_query($query);		while($row=mysql_fetch_array($query_results)){			$token = $row[token];		}					return $token;	}	///////////////session start/////////////////		public function session(){					//API Url		$url = $this->getNetworkConfig($this->lib_name,'api_base_url').'/tokens';				//Initiate cURL.		$ch = curl_init($url);				//The JSON data.		$jsonData = array(					'Tenant'   	 => $this->getNetworkConfig($this->lib_name,'api_acc_profile'),				'User-Name'   => $this->getNetworkConfig($this->lib_name,'api_login'),				'password'   => $this->getNetworkConfig($this->lib_name,'api_password')		);				$jsonDataEncoded = json_encode($jsonData);		$header_parameters = "Content-Type: application/json;charset=UTF-8";		//Tell cURL that we want to send a POST request.		curl_setopt($ch, CURLOPT_POST, 1);		//Attach our encoded JSON string to the POST fields.		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		curl_setopt($ch, CURLOPT_HEADER, 1);		curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->auth_token.":"); 				//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		//Execute the request		$result = curl_exec($ch);					$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);				$sus=json_decode($body,true);				curl_close ($ch);		//echo $sus[auth_token];		return $sus['auth_token'];	}	public function updateAccount($account_type,$portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm){		$timezone='America/New_York';		$tz_object = new DateTimeZone($timezone);		$datetime = new DateTime(null,$tz_object);		$begindate = $datetime->format('Y-m-d H:i:s');		$startdate= strtotime($begindate);		$datetime->add(new DateInterval($timegap));		$enddate = $datetime->format('Y-m-d H:i:s');		$finaldate= strtotime($enddate);		//$base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');		$organization = $realm;				if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');			//$organization = $this->getNetworkConfig($this->lib_name,'api_acc_org');		}		$macc= str_replace('-','',$mac);		$owner = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');//api_acc_profile		$user_name_ale = $macc.'@'.$organization;        			$jsonData=array(		 				'Valid-Until'=>$finaldate,						'Signup-Type' => 'click_and_connect',						'Valid-From'=>$startdate,						'Credits'     => array('aaa' =>'5' ,												'aba' =>'3'), 						'Account-State'=> 'Active',						'Product' => $product,						'Product-Owner' => $owner,						'Password' => $user_name_ale,						'Purge-Delay-Time' => 0,						'UUID' => '9bbd4eca-66fe-4284-9cf1-074f09805714',						'User-Data' => array('plugin_id' => 'Free access without sms loop',												'question_answer' => 'Arris_Offices' ),						'User-Name'      => $user_name_ale,						'Group'     => $owner										);			 						$jsonDataEncoded = json_encode($jsonData);		//Tell cURL that we want to send a POST request.			//API Url		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";		curl_setopt($ch, CURLOPT_POST, 1);		//Attach our encoded JSON string to the POST fields.		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch, CURLOPT_HEADER, 1);		curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");		//echo $this->session() ;				//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);        //Execute the request		$result = curl_exec($ch);		//Execute the request		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);		$decoded = json_decode($body, true);		$desc=$decoded['internal-debug-message'];		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);		//echo $status_code;			$this->log($user_name_ale,__FUNCTION__, 'Update Account', $url2, 'REST', $status, $body, $jsonDataEncoded,$organization);		if($status == '200'){			return 'status=success&status_code='.$status.'&Description=Account Modified Success - '.$status;		}		else{			return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;						/* SOAP Parameter Error */		}	}		public function createAccount($portal_number,$mac,$first_name,$last_name,$birthday,$gender,$relationship,$email,$mobile_number,$product,$timegap,$realm){		$timezone='America/New_York';		$tz_object = new DateTimeZone($timezone);		$datetime = new DateTime(null,$tz_object);		$begindate = $datetime->format('Y-m-d H:i:s');		$startdate= strtotime($begindate);		$datetime->add(new DateInterval($timegap));		$enddate = $datetime->format('Y-m-d H:i:s');		$finaldate= strtotime($enddate);		$organization = $realm;		if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');		}				$macc= str_replace('-','',$mac);		$user_name_ale = $macc.'@'.$organization;				$owner = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');//api_acc_profile				//$owner= $this->getNetworkConfig($this->lib_name,'api_acc_profile');		// This is an archaic parameter list        //json aray		 $jsonData=array(		 				'Valid-Until'=>$finaldate,						'Signup-Type' => 'click_and_connect',						'Valid-From'=>$startdate,						'Credits'     => array('aaa' =>'5' ,												'aba' =>'3'), 						'Account-State'=> 'Active',						'Product' => $product,						'Product-Owner' => $owner,						'Password' => $user_name_ale,						'Purge-Delay-Time' => 0,						'User-Data' => array('plugin_id' => 'Free access without sms loop',												'question_answer' => 'Arris_Offices' ),						'User-Name' => $user_name_ale,						'Group'  => $organization									);		$jsonDataEncoded = json_encode($jsonData);		//echo $jsonDataEncoded;		//Tell cURL that we want to send a POST request.			//API Url		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts';		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";		//curl_setopt($ch, CURLOPT_POST, 1);		//Attach our encoded JSON string to the POST fields.		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch, CURLOPT_HEADER, 1);		curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");		//echo $this->session() ;				//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		//Execute the request		$result = curl_exec($ch);					$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);		$decoded = json_decode($body, true);		$desc=$decoded['internal-debug-message'];				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);			$this->log($user_name_ale,__FUNCTION__, 'Create Account', $url2, 'REST', $status, $body, $jsonDataEncoded,$organization);		if($status == '201'){		return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.'200';		//return 'status=success&status_code='.'200'.'&Description=Account Creation Success - '.$body;		}		else{			return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;		}			}		public function checkAccount($mac,$realm){				//$base_url = $this->getNetworkConfig($this->network_name, 'api_base_url');		$organization = $realm;		if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');		}				$macc= str_replace('-','',$mac);		$user_name_ale = $macc.'@'.$organization;		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;		// $url2;		$request_array=array(					'First-Access'   	=> $macc.'@'.$organization,					'url' => $url2				);		$Encoded=json_encode($request_array);		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";								curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch,CURLOPT_HEADER,1);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);				curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");		//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        //ADD FROM RACUS V5        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		$result=curl_exec($ch);		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);		$decoded = json_decode($body, true);		$valid_until=$decoded['Valid-Until'];		$ac_state=$decoded['Account-State'];		$desc=$decoded['internal-debug-message'];		$this->log($user_name_ale,__FUNCTION__, 'Get Account', $url2, 'REST', $status, $body, $Encoded,$organization);					 			if($status == '200'){				return 'status=success&status_code='.$status.'&Description=Account Retrieving Success - '.$status.'&expire='.$valid_until.'&validity='.$ac_state;			}			else{				 return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;			}		}	public function deleteAccount($mac,$realm){		$organization = $realm;							if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');			//$organization = $this->getNetworkConfig($this->lib_name,'api_acc_org');		}		$macc= str_replace('-','',$mac);				$user_name_ale = $macc.'@'.$organization;        		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";		//Attach our encoded JSON string to the POST fields.				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');                curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch, CURLOPT_HEADER, 1);		curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");				//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		//Execute the request		$result = curl_exec($ch);					$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		$decoded = json_decode($body, true);		$valid_until=$decoded['Valid-Until'];		$ac_state=$decoded['Account-State'];		$desc=$decoded['internal-debug-message'];		$this->log($user_name_ale,__FUNCTION__, 'Delete Account', $url2, 'REST', $status_code, $body,$url2, $organization);					if($status_code == '200'){					return 'status=success&status_code=200'.'&Description=Account Delete Success - '.$status_code;				}				else{					 return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;					}				}	public function checkMacAccount($mac,$realm){					$organization = $realm;		if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');		}				$macc= str_replace('-','',$mac);		$user_name_ale = $macc.'@'.$organization;		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$user_name_ale;		//echo $url2;		$request_array=array(					'First-Access'   	=> $macc.'@'.$organization,					'url' => $url2				);		$Encoded=json_encode($request_array);		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";								curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch,CURLOPT_HEADER,1);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);				curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");		//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        //ADD FROM RACUS V5        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		$result=curl_exec($ch);		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);		$decoded = json_decode($body, true);		$valid_until=$decoded['Valid-Until'];		$ac_state=$decoded['Account-State'];		$desc=$decoded['internal-debug-message'];		$this->log($user_name_ale,__FUNCTION__, 'Get Account', $url2, 'REST', $status, $body, $Encoded,$organization);					 			if($status == '200'){				return 'status=success&status_code='.$status.'&Description=Account Retrieving Success - '.$status.'&expire='.$valid_until.'&validity='.$ac_state;			}			else{				 return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;			}						}	public function checkRealmAccount($realm){			$organization = $realm;//$realm;		if(strlen($organization)=='0'){			$organization = $this->getNetworkConfig($this->lib_name,'api_master_acc_type');		}		$url2 = $this->getNetworkConfig($this->lib_name,'api_base_url').'/accounts/'.$organization;		 		$ch = curl_init($url2);		$header_parameters = "Content-Type: application/json;charset=UTF-8";								curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);		curl_setopt($ch,CURLOPT_HEADER,1);		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);				curl_setopt($ch, CURLOPT_VERBOSE, 1);		curl_setopt($ch,CURLOPT_USERPWD,$this->session().":");		//Set the content type to application/json		curl_setopt($ch, CURLOPT_HTTPHEADER, array($header_parameters));        //ADD FROM RACUS V5        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);        curl_setopt ($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);		$result=curl_exec($ch);		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);		$header = substr($result, 0, $header_size);		$body = substr($result, $header_size);				$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);		$decoded = json_decode($body, true);		$valid_until=$decoded['Valid-Until'];		$ac_state=$decoded['Account-State'];		$desc=$decoded['internal-debug-message'];									$this->log($organization,__FUNCTION__, 'Get Account', $url2, 'REST', $status_code, $body, $url2 ,$organization);					if($status == '200'){					return 'status=success&status_code='.$status.'&Description=Account Retrieving Success - '.$status.'&expire='.$valid_until.'&validity='.$ac_state;				}				else{					 return 'status=failed&status_code='.$status.'&Description='.$desc.' - '.$status;				}				}	}?>