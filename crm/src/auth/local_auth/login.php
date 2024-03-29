<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$redirect_url = $global_base_url;

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
} elseif(isset($_GET['source']) && $_GET['source']=='oid'){
	include_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../db/dbTasks.php'); 
	$dbT = new dbTasks();
	include_once( str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/systemPackageClass.php');
	$package_functions=new package_functions();   
	$robot_verify_method = 'no_verify';
	include '../../../src/auth/ROBOT_VERIFY/'.$robot_verify_method.'/index.php';
	$robot_verify_functions = new robot_verify();

	$redirect_url .= "/properties";

	foreach ($_SESSION['attributes'] as $key=>$value){
		if($key == 'email'){
			$username = $value;
		}
		if($key == 'groups'){
			$oid_group = $value;
			// echo $value;
			// if($value == 'crm-operations') { // For temporary solution for operations till fix the DB record issue in RM side
			// 	$oid_group = 'crm-admin';
			// }
		}
	}

	$checkUserSql = "SELECT COUNT(*) AS f FROM admin_users AS au
				  	INNER JOIN admin_access_roles AS aar ON aar.access_role=au.access_role 
				  	WHERE au.user_name='$username' AND aar.oid_group='$oid_group'";
	// echo $checkUserSql;
	// die;
	$checkUserResult = $dbT->selectDB($checkUserSql);

	if($checkUserResult["data"][0]["f"] == 0){
		unset($_SESSION['attributes']);
		$_SESSION['open_error'] = 1;
		$_SESSION['open_error_msg'] = 'User not authorized to login';
		header('Location: /crm/generic/login/');
		exit();
	}
}

if (isset($username)) {
	$password_local = '';
	if(!isset($_GET['auto_login']) && !isset($_GET['source'])) {
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
	
	$key_query0 = sprintf("SELECT  id,`access_role`,`group`, user_type, user_distributor,`group`,`level` 
	FROM  admin_users WHERE user_name = %s LIMIT 1",$dbT->GetSQLValueString($user_name, "text"));

	$query_results=$dbT->selectDB($key_query0);
	foreach($query_results['data'] AS $row){
		$_SESSION['user_id']  = $row['id'];
		$access_role = $row['access_role'];
		$user_type = $row['user_type'];
		$user_group = $row['group'];
		$user_distributor = $row['user_distributor'];
		$_SESSION['user_distributor']  = $row['user_distributor'];
		$access_role=strtolower($access_role);
		$user_group = $row['group'];
		$user_level = $row['level'];
	}
	
	if(($user_group=="super_admin") && !isset($_GET['auto_login'])){
		$_SESSION["SADMIN"] = true;
		// header('Location: '.$_SERVER['PHP_SELF']);
		header("Location: ".$_SERVER['PHP_SELF']."?auto_login&user_id=1");
		// var_dump('##########STEP03######');
		// die;
	}

	$suspended = false;
	if($user_group=="operation"){
		$system_package=$dbT->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	}else{
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

		$redirect_url .= "/verification".$extension.'?login='.$login_design;

			//	$redirect_url = "home".$extension;
		header( "Location: $redirect_url");	
		exit();
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
				//header( "Refresh:1; url=$redirect_url", true, 303);

	}
	else if(($password_local == $password) || isset($_GET['auto_login']) || (isset($_GET['source']) && $_GET['source']=='oid')){
		
		/// Package Validation
        // Get user package

        $user_pkg_name = $package_functions->getPackage($user_name);
    //    var_dump($user_pkg_name);die;
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

		require_once __DIR__.'/../../../classes/AccessUser.php';
		$access_user = new AccessUser($user_group,$user_level);
		$_SESSION['access_user'] = serialize($access_user);

		require_once __DIR__.'/../../../classes/AccessController.php';
		$acc_cont = new AccessController($dbT,$access_user);

		if(!$suspended){
			$dbT->userLog($user_name,'login','Login','N/A'); 

			if($access_role == 'admin'){
				$user_query = "SELECT module_name FROM admin_access_modules WHERE user_group = '$user_group' AND `order` IS NOT NULL AND module_name <> 'venue_support' AND module_name <> 'support' ORDER BY `order`";
			}
			else{
				$user_query = "SELECT module_name FROM admin_access_roles_modules WHERE access_role = '$access_role'";
			}
				// echo $user_query;
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

			$acc_cont->loginSuccess();
				
		}else{
			$redirect_url .= '/suspend'.$extension;
			header( "Location: $redirect_url");		
			exit();
		}   
		setcookie("system_package", $system_package, time() + (86400 * 30), "/");
		setcookie("load_login_design", $login_design, time() + (86400 * 30), "/"); 	
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