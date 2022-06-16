<?php

include_once 'dbClass.php';
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/


class api_db_functions
{

	public function __construct()
	{
		//Connect::getConnect();
		$this->db = new db_functions();

	}


	public function errorLog($token,$error,$comment=NULL){
		$query = "INSERT INTO `exp_error_log` (`error_id`, `token`,error_details) VALUES ('$error', '$token','$comment')";
		$query_results=$this->db->execDB($query);
	}
	
	
	/////////////////////////////////////
	public function getPackageOptions($package,$feature){
		$query = "SELECT `options` AS a FROM `admin_product_controls` 
		WHERE `feature_code` = '$feature' AND `product_code` = '$package'";
	
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result = $row[a];
		}
		return $result;
	}
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function accessLog($token,$access,$comment=NULL){
		$query = "INSERT INTO `exp_points_logs` (`access_id`, `token`, `access_details`, `create_date`) 
				VALUES ('$access', '$token', '$comment', NOW())";
		$query_results=$this->db->execDB($query);
	}	
	
	////////////////////////////////////////////////////////////////////////
	public function auth($email)
	{
		$query = "SELECT * FROM exp_customer WHERE email = '$email'";
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}


	////////////////////////////////////////////////////////////////////////
	public function authCount($email)
	{
		$query = "SELECT email, first_name,last_name, `password` FROM exp_customer WHERE email = '$email'";
		$query_results=$this->db->selectDB($query);
		return $query_results['rowCount'];
	}	
	
	
	////////////////////////////////////////////////////////////////////////
/* 	public function manual_registration_feilds($feild,$reg_code)
	{
		$query = "SELECT ".$feild." AS f FROM `exp_manual_reg_profile` WHERE `reg_name`='$reg_code' LIMIT 1";
		$query_results=$this->db->selectDB($query);
		$row=mysql_fetch_array($query_results);
		
		return $row['f'];
	} */
	
	////////////////////////////////////////////////////////////////////////
	
	public function getRegFields($distributor,$mno){
		$query = "SELECT * FROM exp_manual_reg_profile WHERE distributor = '$distributor'";
		$query_results=$this->db->selectDB($query);
	
		if($query_results['rowCount']==0){
			$query = "SELECT * FROM exp_manual_reg_profile WHERE distributor = '$mno'";
			$query_results=$this->db->selectDB($query);
				
			if($query_results['rowCount']==0){
				$query = "SELECT * FROM exp_manual_reg_profile WHERE distributor = 'ADMIN'";
				$query_results=$this->db->selectDB($query);
			}
				
		}
		
	//	echo $query;
	
	
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}
	
	
	/////////////////////////////////////////////////////////////////////////
	
	
	
	public function getAuthProfile($distributor,$mno,$auth_type){
		$query = "SELECT * FROM exp_auth_reg_profile WHERE auth_type ='$auth_type' AND distributor = '$distributor'";
		$query_results=$this->db->selectDB($query);
	
		if($query_results['rowCount']==0){
			$query = "SELECT * FROM exp_auth_reg_profile WHERE auth_type ='$auth_type' AND distributor = '$mno'";
			$query_results=$this->db->selectDB($query);
	
			if($query_results['rowCount']==0){
				$query = "SELECT * FROM exp_auth_reg_profile WHERE auth_type ='$auth_type' AND distributor = 'ADMIN'";
				$query_results=$this->db->selectDB($query);
			}
	
		}
	
		//	echo $query;
	
	
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}
	
	
	/////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	
	public function getProduct($distributor,$mno){
		

		
		$query = "SELECT product_code,time_gap FROM exp_products_distributor WHERE network_type = 'GUEST' AND distributor_code = '$distributor' AND is_enable = 1 LIMIT 1";
		$query_results=$this->db->selectDB($query);
		if($query_results['rowCount'] == '0'){
			$query = "SELECT product_code,time_gap FROM exp_products WHERE mno_id = '$mno' AND default_value = 1 LIMIT 1";
			$query_results=$this->db->selectDB($query);
		}
		
		foreach($query_results['data'] AS $row){
			$result[] = $row;
			//$result = $row[product_code];
		}
		return $result;
	}
	
	
	////////////////////////////////////////////////////////////////////////
	
	public function getApLocation($distributor){
		$query = "SELECT mno_id FROM exp_mno_distributor WHERE distributor_code = '$distributor'";
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}
	
	
	///////////////////////////////////////////////////////////////////////
	
		public function getAupText($mno){
		

		$get_value = "SELECT title FROM exp_texts WHERE text_code = 'AUP' and distributor = '$mno' LIMIT 1";
		$query_results=$this->db->selectDB($get_value);
		foreach($query_results['data'] AS $row){
			$result = $row[title];
		}
		return $result;
		
	}
	////////////////////////////////////////////////////////////////////////
	
	
	public function setSocialVal($distributor,$mno,$social_media){
		$query = "SELECT * FROM exp_social_profile WHERE distributor = '$distributor' AND social_media = '$social_media'";
		$query_results=$this->db->selectDB($query);
		
		if($query_results['rowCount']==0){
			$query = "SELECT * FROM exp_social_profile WHERE distributor = '$mno' AND social_media = '$social_media'";
			$query_results=$this->db->selectDB($query);
			
			if($query_results['rowCount']==0){
				$query = "SELECT * FROM exp_social_profile WHERE distributor = 'ADMIN' AND social_media = '$social_media'";
				$query_results=$this->db->selectDB($query);
			}
			
		}
	
		
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}

	
	////////////////////////////////////////////////////////////////////////
	public function startSession($token,$customer,$portal_id,$session_type,$auth_medium,$master_data,$browser_name,$browser_version,$is_mobile,$os_name,$os_version,$browser_language){
		$network_session_id = $master_data[0][network_session_id];
		$mac = $master_data[0][mac];
		$location_string = $master_data[0][location_string];
		
		// Get Location Parameters
		//$loc = getParameters($location_string);
		
		$ip = $master_data[0][ip];
		$create_date = $master_data[0][create_date];
		$ap = $master_data[0][ap];
		$ssid = $master_data[0][ssid];
		$other_parameters = $master_data[0][other_parameters];
		
		$group_tag = $master_data[0][group_tag];
		$distributor = $master_data[0][distributor];
		$distributor_type = $master_data[0][distributor_type];		
		
		$referrer = $master_data[0][referrer];
		$temp_user_name = $master_data[0][temp_user_name];
		$group = $master_data[0][group];
		
		$ap_data = $this->getApLocation($distributor);
		$mno = $ap_data[0][mno_id];
		
		//$referrer = $_SERVER['HTTP_REFERER'];
		
		 $query = "REPLACE INTO `exp_customer_session` 
				(`token_id`, `customer_id`, `portal_id`, `referrer`,temp_user_name,`network_session_id`, `session_type`, `mac`, `location_string`, `location_id`,distributor_type,group_tag,`mno`,`ap`,`ssid`, `ip`,other_parameters,browser_name,browser_version,is_mobile,os_name,os_version,browser_language,auth_medium, `session_status`, `session_starting_time`, `session_auth_time`,`group`) 
				VALUES ('$token', '$customer', '$portal_id','$referrer','$temp_user_name','$network_session_id', '$session_type', '$mac', '$location_string', '$distributor','$distributor_type','$group_tag','$mno','$ap','$ssid', '$ip','$other_parameters','$browser_name','$browser_version','$is_mobile','$os_name','$os_version','$browser_language','$auth_medium', '1', '$create_date', NOW(),'$group')";
		$query_results=$this->db->selectDB($query);
		
		if($query_results){
			
			
			
			
			
			return '1';
		}
		else{
			return '0';
		}
	}

	
	
	
	////////////////////////////////////////////////////////////////////////
	public function newUser($email,$first_name,$last_name,$media,$password,$mobile_number,$gender,$age_group,$proffession,$portal_id,$social_media_id,$social_media_url,
	$birthday,$street,$city,$location,$zip,$state,$country,$current_country,$locale,$timezone,$bio,$political,$religion,$website,$longitude,$latitude,$id_number=null){
		//echo $id_number;
		$query = "INSERT INTO exp_customer
		(email, first_name, last_name, `password`, mobile_number, gender, age_group,proffession,
		 portal_id, login_media,id_number, social_media_id, social_media_url, birthday, street, city,current_city, zip,
		 state, country,current_country, locale, timezone, bio, political, religion, website, longitude, latitude, first_login_date,last_login_date)
		VALUES ('$email','$first_name','$last_name','$password','$mobile_number','$gender','$age_group','$proffession','$portal_id',
		'$media','$id_number','$social_media_id','$social_media_url','$birthday','$street','$city','$location','$zip','$state','$country','$current_country','$locale',
		'$timezone','$bio','$political','$religion','$website','$longitude','$latitude',now(),now())";
		
		$query_results=$this->db->selectDB($query);
		if($query_results){
			return '1';
		}
		else{
			return '0';
		}
	}
	

	
	
	
	

	////////////////////////////////////////////////////////////////////////
	public function updateFbCustomer($email,$first_name,$last_name,$media,$password,$mobile_number,$gender,$age_group,$proffession,$portal_id,$social_media_id,$social_media_url,
		$birthday,$street,$city,$location,$zip,$state,$country,$current_country,$locale,$timezone,$bio,$political,$religion,$website,$longitude,$latitude){
	
		$query = "UPDATE exp_customer
		SET first_name = '$first_name',last_name = '$last_name', gender = '$gender', login_media = '$media', social_media_id = '$social_media_id', social_media_url = '$social_media_url',
		birthday = '$birthday',age_group = '$age_group', city = '$city', current_city = '$location', country = '$country', current_country = '$current_country', locale = '$locale', timezone = '$timezone'
		WHERE email = '$email'";
	
		$query_results=$this->db->execDB($query);
		if($query_results===true){
			return '1';
		}
		else{
			return '0';
		}
	}
	

	
	public function getTempUserName($token) {
		$rowe = $this->db->select1DB("SHOW TABLE STATUS LIKE 'exp_user_names'");
		//$rowe = mysql_fetch_array($br);
		$auto_increment = $rowe['Auto_increment'];
	
		$user_name = '1'.str_pad($auto_increment,8,"0",STR_PAD_LEFT);
		$query = "INSERT INTO `exp_user_names` (`user_name`, `token`, `create_date`)
		VALUES ('$user_name', '$token', NOW())";
	
		$ex = $this->db->execDB($query);
	
		if($ex===true){
		return $user_name;
		}
		else{
		getTempUserName($token);
		}
	}
	////////////////////////////////////////////////////////////////////////
	public function getPortalId($token=null){
			
		$portal_id = $this->getTempUserName($token);			
		$query2 = "INSERT INTO exp_portal_id (assigned_date,portal_id_status,portal_id) values (now(),1,'$portal_id')";
		$query_results=$this->db->execDB($query2);
		return $portal_id;
		
	}
	
	
	
	

	
	
	
	/////////////////////////////////////
	public function getSession($token){
		$query = "SELECT s.token_id,s.customer_id,s.portal_id,s.network_session_id,s.network_username,s.temp_user_name,s.session_type,s.mac,s.location_string,s.location_id,s.ip,s.session_status,s.other_parameters,c.first_name,c.last_name,c.email,c.mobile_number,c.birthday,c.age_group,c.gender,c.login_media,c.social_media_id,c.locale,s.os_name,s.group_tag,s.distributor_type,s.mno,s.ap,s.ssid,s.group
		FROM exp_customer_session s, exp_customer c
		WHERE s.customer_id = c.customer_id
		AND s.token_id = '$token'";
		
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}
	
	
	
	
	/////////////////////////////////////
	public function getPackageFeature($package,$feature){
		$query = "SELECT `access_method` FROM `admin_product_controls` 
		WHERE `feature_code` = '$feature' AND `product_code` = '$package'";
	
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result = $row[access_method];
		}
		return $result;
	}
	
	
	
	public function getDeviceId($customer_id){
		
		$query_device_count = "UPDATE exp_customer SET device_count = device_count + 1 WHERE customer_id = '$customer_id'";
		$query_results_ex=$this->db->execDB($query_device_count);
		
		$get_value = "SELECT device_count FROM  exp_customer WHERE customer_id = '$customer_id'";
		$query_results=$this->db->selectDB($get_value);
		foreach($query_results['data'] AS $row){
				$result = $row[device_count];
		}
		return $result;
		
	}
	

	
	
	
	
	
	public function updatePortalId($token,$device_id,$username,$mac,$customer_id,$temp_user_name,$product,$timegap,$duration){
	
									
		$query_token = "SELECT * FROM `exp_security_tokens` WHERE `token_id` = '$token'";
		$query_results_token=$this->db->selectDB($query_token);
		foreach($query_results_token['data'] AS $row1){
			$ssid_name = $row1[ssid];
			$distributor_name = $row1[distributor];
			$ap = $row1[ap];
				
		}
		
		$query_e = "REPLACE INTO exp_customer_sessions_mac (mac, customer_id,portal_id,distributor_code,ssid,ap,temp_user_name,token,create_date)
		VALUES ('$mac','$customer_id','$username','$distributor_name','$ssid_name','$ap','$temp_user_name','$token',NOW())";
		$query_results2=$this->db->execDB($query_e);
	
		
		
		$query_device_id = "UPDATE exp_customer_session SET  device_id = '$device_id', temp_user_name = '$temp_user_name',network_username = '$username',product = '$product',product_qty = '$timegap',product_qty_type = '$duration' WHERE token_id = '$token'";
		$query_results_ex=$this->db->execDB($query_device_id);
		
	}
	
	
	
	
	public function getRequestId(){
		$rowe = $this->db->select1DB("SHOW TABLE STATUS LIKE 'exp_camphaign_request_id'");
		//$rowe = mysql_fetch_array($br);
		$auto_increment = $rowe['Auto_increment'];		
		$query = "INSERT INTO `exp_camphaign_request_id` (`last_update`) VALUES (now())";
		$query_results2=$this->db->execDB($query);
		return $auto_increment;
		
	}
	
	
	
	public function getAdList($age_group,$gender,$distributor,$os,$group_tag,$ap,$prefered_category_list,$campaign_load_from,$mno,$sys_package){
		
		if($age_group == 'age_all'){
			$age = "";
		}
		else{
			$age = $age_group." = '1' AND";
		}
		
		
		if($gender == 'all'){
			$gen = "";
		}
		else{
			$gen = $gender." = '1' AND";
		}		
		
		
		if($campaign_load_from == 'mno'){
			$group_tag = $sys_package;
			$distributor = $mno;
		}
		
		$query = "SELECT priority, GROUP_CONCAT(id) AS ids, COUNT(id) AS c
		FROM exp_camphaign_ad_live
		WHERE ".$age." 
		".$gen."
		 distributor = '$distributor'
		AND $os = '1'
		AND group_tag = '$group_tag'
		AND $ap = '1'
		AND is_enable = '1'
		GROUP BY priority ORDER BY priority";
	
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
		$result[] = $row;
		}
		return $result;
	}
	

	////////////////////////////////////////	

	
	/////////////////////////////////////
	public function getLiveAd($id,$token){
	
		$query = "SELECT * FROM exp_camphaign_ad_live WHERE id = '$id' LIMIT 1";	
		$query_results=$this->db->selectDB($query);
		
		foreach($query_results['data'] AS $row){
			
			$query_update = "UPDATE exp_customer_session SET ad_id = '$id' WHERE token_id = '$token'";
			$query_results_ex=$this->db->execDB($query_update);
			
			$result[] = $row;
		}
		
		return $result;
	}
	
	
	
	
	
	/////////////////////////////////////
	public function getNormalAd($id,$token){
	
		$query = "SELECT * FROM exp_camphaign_ads WHERE ad_id = '$id' LIMIT 1";
		$query_results=$this->db->selectDB($query);
	
		foreach($query_results['data'] AS $row){
			
		$query_update = "UPDATE exp_customer_session SET ad_id = '$id' WHERE token_id = '$token'";
		$query_results_ex=$this->db->execDB($query_update);
			
		$result[] = $row;
		}
	
		return $result;
	}
	
	
	
	
	

	
	
	
	/////////////////////////////////////
	public function getSurvayOptions($ad_id){
	
		$query = "SELECT * FROM exp_camphaign_ad_survey_option WHERE ad_id = '$ad_id'";
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
		$result[] = $row;
		}
		return $result;
	}	
	
	
	
	/////////////////////////////////////
	public function updateSurvey($advert_id,$option,$token){
	
		$query = "UPDATE `exp_camphaign_ad_survey_option` 
		SET `option_".$option."_hits`=option_".$option."_hits+1 WHERE `ad_id`='$advert_id'";
		$query_results1=$this->db->execDB($query);
		
		$details = $this->getSurvayVal($advert_id, $option);
		
		$sql_insert = "INSERT INTO `exp_camphaign_ad_survey_option_results_hits`(`token`, `ad_id`, `result_id`,`result_data`, `create_date`)
		VALUES ('$token', '$advert_id', '$option','$details',now())";
		$query_results2=$this->db->execDB($sql_insert);
		
		if($query_results1 != true){
			$err = 'Updation is failed';
		}
		
		if(!$query_results2 != true){
			$err = $err.'| Insert is failed';
		}
		
		return $err;
		
	}	
	
	
	
	
	
	
	public function getSurvayVal($advert_id,$option){
		$query = "SELECT option_".$option." as a FROM exp_camphaign_ad_survey_option WHERE ad_id = '$advert_id'";
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result = $row[a];
		}
		return $result;
	}
	
	
	
	/////////////////////////////////////
	public function getAd($age_group,$gender,$distributor,$os,$group_tag,$ap,$prefered_category_list){
	/* 	$query = "SELECT *
		FROM exp_camphaign_ad_live
		WHERE $age_group = '1' 
		AND $gender = '1'
		AND distributor = '$distributor'
		AND $os = '1'
		AND group_tag = '$group_tag'
		AND $ap = '1'
		AND is_enable = '1'
		AND ad_category IN $prefered_category_list 
		LIMIT 1"; */
		
	
		
		$query = "SELECT *
		FROM exp_camphaign_ad_live
		WHERE $age_group = '1'
		AND $gender = '1'
		AND distributor = '$distributor'
		AND $os = '1'
		AND group_tag = '$group_tag'
		AND $ap = '1'
		AND is_enable = '1'
		LIMIT 1";
	
		$query_results=$this->db->selectDB($query);
		foreach($query_results['data'] AS $row){
			$result[] = $row;
		}
		return $result;
	}	
	
	

	
	
	
	public function adHits($ad_id,$token,$customer){
		$query = "INSERT INTO `exp_camphaign_logs` (`ad_id`, `token`, `customer_id`, `create_date`) 
		VALUES ('$ad_id', '$token', '$customer', NOW())";
	
		$query_results=$this->db->execDB($query);
		
		
		$hit_query = "UPDATE exp_camphaign_ads SET hits = hits + 1 WHERE ad_id = '$ad_id'";
		$query_results2=$this->db->execDB($hit_query);

	}







}

?>