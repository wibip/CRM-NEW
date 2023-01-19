<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// echo '>>>>><<<<------';die;
if(isset($_POST['sign_in'])){ 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$username = htmlentities( urldecode($username), ENT_QUOTES, 'utf-8' );
	$password = htmlentities( urldecode($password), ENT_QUOTES, 'utf-8' );
} elseif(isset($_GET['auto_login']) && $_GET['user_id'] != 0) {
	$autoSql = "SELECT user_name, password FROM admin_users WHERE id=".$_GET['user_id'];
	$auroResults = $dbT->selectDB($autoSql);  
	$username = $auroResults['data'][0]['user_name'];
	$password = 'pass@123';//$auroResults['data'][0]['password'];
} 

if (isset($username)) {
	$password_local = '';
	if(!isset($_GET['auto_login'])) {
		$user_query_pwd = sprintf("SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(%s))))) as f", $dbT->GetSQLValueString($password, "text")); 
		$query_results=$dbT->selectDB($user_query_pwd);  
		foreach($query_results['data'] AS $row){
			$password_local = strtoupper($row['f']);
		}
	}
	
	$user_query = sprintf("SELECT user_name, password, access_role, full_name,is_enable,user_distributor
	FROM admin_users WHERE user_name =%s AND is_enable<>8", $dbT->GetSQLValueString($username, "text"));
	
	$query_results=$dbT->selectDB($user_query);
	foreach($query_results['data'] AS $row){
		$user_name = $row['user_name'];
		$password = strtoupper($row['password']);
		$access_role = $row['access_role'];
		$full_name = $row['full_name'];
		$is_enable = $row['is_enable'];
		$user_distributor = $row['user_distributor'];

		$access_role=strtolower($access_role);
	}

	///////////////////////////////////////////////////////
	
	$key_query0 = sprintf("SELECT  id,`access_role`, user_type, user_distributor 
	FROM  admin_users WHERE user_name = %s LIMIT 1",$dbT->GetSQLValueString($user_name, "text"));
	
	$query_results=$dbT->selectDB($key_query0);
	foreach($query_results['data'] AS $row){
		$_SESSION['user_id']  = $row['id'];
		$access_role = $row['access_role'];
		$user_type = $row['user_type'];
		$user_distributor = $row['user_distributor'];
		$_SESSION['user_distributor']  = $row['user_distributor'];
		$access_role=strtolower($access_role);
	}

	if(($user_type=="SADMIN") && !isset($_GET['auto_login'])){
		$_SESSION[$user_type] = true;
		// header('Location: '.$_SERVER['PHP_SELF']);
		header("Location: ".$_SERVER['PHP_SELF']."?auto_login&user_id=1");
		// var_dump('##########STEP03######');
		// die;
	}

	$suspended = false;
	if($user_type=="MNO"){
		$system_package=$dbT->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	}elseif($user_type=="MVNO" || $user_type=="MVNE" || $user_type=="MVNA"){
		$q=$dbT->select1DB("SELECT `system_package`,`is_enable`,`wired` FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
		$system_package = $q['system_package'];
		$dis_is_enable = $q['is_enable'];
		$property_wired = $q['wired'];

		if($dis_is_enable == 3){
			$suspended = true;
		}

	}elseif($user_type=='MVNO_ADMIN'){
		$system_package=$dbT->getValueAsf("SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$user_distributor'");
	}
	else{
		$system_package=$dbT->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	}
	if($system_package=="N/A" || $system_package=="") {
		$package_features="all";
		$system_package="N/A";
	}

	//////////////////////////////////////////////////////

    if(!$robot_verify_functions->login($robot_v_user/*Variable inherit from robot verify index */)){
        $MMFailed = '1';
        $MMFailedMassage = 'Please validate recapture';
    }
    elseif($is_enable == '0'){
		$MMFailed = '1';
		$MMFailedMassage = 'User account is not active';
	}
	else if($password_local == $password && $is_enable == '2'){
		$MMFailed = '0';
		$MMFailedMassage = '';
		$_SESSION['login'] = 'no';
		$_SESSION['user_name'] = $user_name;
		
		$log_query = sprintf("INSERT INTO admin_user_logs (user_name,module,create_date,unixtimestamp)
		VALUES (%s,'Verification',now(),UNIX_TIMESTAMP())", $dbT->GetSQLValueString($user_name, "text"));
	
		$query_ex_log=$dbT->execDB($log_query);

		$redirect_url = $global_base_url."/verification".$extension.'?login='.$login_design;

			//	$redirect_url = "home".$extension;
		header( "Location: $redirect_url");	
		exit();
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
				//header( "Refresh:1; url=$redirect_url", true, 303);

	}
	else if(($password_local == $password) || isset($_GET['auto_login'])){
		
		/// Package Validation
        // Get user package
        $user_pkg_name = $package_functions->getPackage($user_name);
       
       if(strlen($login_design)=='0'){
       		$allowed_pkg_list = $package_functions->getOptions('LOGIN_RESTRICTION','generic');
       }else{
       		$allowed_pkg_list = $package_functions->getOptions('LOGIN_RESTRICTION',$login_design);
       }
        // get allowed logins
        $package_list_array = explode(',',$allowed_pkg_list);
        //print_r($allowed_pkg_list);
        if ((in_array($user_pkg_name, $package_list_array)) || ($allowed_pkg_list == 'ALL')){
        //	echo 'ALLOWED';
        	
        $MMFailed = '0';
		$MMFailedMassage = 'Success';
		$_SESSION['logout_design'] = $login_design;
		$_SESSION['login'] = 'yes';
		$_SESSION['user_name'] = $user_name;
		$_SESSION['access_role'] = $access_role;
		$_SESSION['full_name'] = $full_name;		
		$_SESSION['current_profile'] = $full_name;
		$_SESSION['user_distributor'] = $user_distributor;

		if(!$suspended){

			if($user_type=="MVNO" || $user_type=="MVNE" || $user_type=="MVNA"){
				$exec_cmd = 'php -f'.__DIR__.'/../../../ajax/syncAP.php '.$user_distributor.' > /dev/null &';
				exec($exec_cmd);
			}
			
			$dbT->userLog($user_name,'login','Login','N/A'); 

			if($access_role == 'admin'){
				$user_query = "SELECT module_name FROM admin_access_modules WHERE user_type = '$user_type' AND `order` IS NOT NULL AND module_name <> 'venue_support' AND module_name <> 'support' ORDER BY `order`";
			}
			else{
				$user_query = "SELECT module_name FROM admin_access_roles_modules WHERE access_role = '$access_role'";
			}
			
			$query_results=$dbT->selectDB($user_query);

			$wifi_text = $package_functions->getMessageOptions('WIFI_TEXT',$system_package);
			$theme_text = $package_functions->getMessageOptions('THEME_TEXT',$system_package);

			if(empty($wifi_text) || $wifi_text ==''){
			$wifi_text='WiFi';
			}
			if ($property_wired == '1') {
				$wifi_text = 'Network';
			}

			$_SESSION['wifi_text'] = $wifi_text;
			if(empty($theme_text) || $theme_text ==''){
				$theme_text='theme';
			}

			$_SESSION['theme_text'] = $theme_text;

			if($package_features=="all"||$system_package=="N/A"){
				$redirect_url = $global_base_url."/home".$extension;
				header( "Location: $redirect_url");
			}else{
				$m_n = json_decode($package_functions->getOptions('ALLOWED_PAGE',$system_package));
					var_dump($m_n);
					var_dump($query_results);
					die;
				foreach($query_results['data'] AS $row){
					$module_name = $row['module_name'];	
					// var_dump($module_name);
					// die;
					if($module_name != 'profile' && in_array($module_name,$m_n)){
						$redirect_url = $global_base_url.'/'.$module_name.$extension;
						setcookie("system_package", $system_package, time() + (86400 * 30), "/");
						setcookie("load_login_design", $login_design, time() + (86400 * 30), "/");
						header( "Location: $redirect_url");		
						exit();
					}
				}
			}
		}else{
			$redirect_url = $global_base_url.'/suspend'.$extension;
		
				setcookie("system_package", $system_package, time() + (86400 * 30), "/");
				setcookie("load_login_design", $login_design, time() + (86400 * 30), "/");
				
				header( "Location: $redirect_url");		
				exit();
		}    	
	}
	else{
			$log_query = sprintf("INSERT INTO admin_user_logs (user_name,module,create_date,unixtimestamp)
			VALUES (%s,'Login Restriction',now(),UNIX_TIMESTAMP())", $dbT->GetSQLValueString($user_name, "text"));
		
			$MMFailed = '1';
			$MMFailedMassage = 'Incorrect Domain';
		}

	}
	else {
		$MMFailed = '1';
		$MMFailedMassage = 'Incorrect Username or Password';
	}
}

?>