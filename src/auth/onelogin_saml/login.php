<?php
session_start();

include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/messageClass.php');

/**
 *  SAML Handler
 */

/*LOGIN USING*/

$login_using = 'verification_number'; //[verification_number,user_name]


require_once '_toolkit_loader.php';


require_once 'settings.php';



$auth = new OneLogin_Saml2_Auth($settingsInfo);


$oops_error_login_layout = $admin_system_package;
$oops_error_contact = $package_functions->getMessageOptions("SUPPORT_NUMBER", $admin_system_package);
$oops_error_layout = $package_functions->getSectionType("CAMP_LAYOUT", $admin_system_package);
$auth_config_properties = $package_functions->getOptions("AUTH_PROFILE_CONFIG", $admin_system_package);
$oops_query = "SELECT `reference3` FROM `exp_auth_profile` WHERE `profile_name` = '$auth_config_properties' LIMIT 1";
$query_results=mysql_query($oops_query);
$num_records = mysql_num_rows($query_results);
while($row=mysql_fetch_array($query_results)){
	$oops_error_goback = $row[reference3];
}

$message_functions=new message_functions($admin_system_package);



if (isset($_GET['sso'])) {
    $auth->login();

    # If AuthNRequest ID need to be saved in order to later validate it, do instead
    # $ssoBuiltUrl = $auth->login(null, array(), false, false, true);
    # $_SESSION['AuthNRequestID'] = $auth->getLastRequestID();
    # header('Pragma: no-cache');
    # header('Cache-Control: no-cache, must-revalidate');
    # header('Location: ' . $ssoBuiltUrl);
    # exit();

}  else if (isset($_GET['slo'])) {
    $returnTo = null;
    $parameters = array();
    $nameId = null;
    $sessionIndex = null;
    $nameIdFormat = null;

    if (isset($_SESSION['samlNameId'])) {
        $nameId = $_SESSION['samlNameId'];
    }
    if (isset($_SESSION['samlSessionIndex'])) {
        $sessionIndex = $_SESSION['samlSessionIndex'];
    }
    if (isset($_SESSION['samlNameIdFormat'])) {
        $nameIdFormat = $_SESSION['samlNameIdFormat'];
    }

    $auth->logout($returnTo, $parameters, $nameId, $sessionIndex, false, $nameIdFormat);

    # If LogoutRequest ID need to be saved in order to later validate it, do instead
    # $sloBuiltUrl = $auth->logout(null, $paramters, $nameId, $sessionIndex, true);
    # $_SESSION['LogoutRequestID'] = $auth->getLastRequestID();
    # header('Pragma: no-cache');
    # header('Cache-Control: no-cache, must-revalidate');
    # header('Location: ' . $sloBuiltUrl);
    # exit();

} else if (isset($_GET['acs'])) {
	
	
    if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
        $requestID = $_SESSION['AuthNRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processResponse($requestID);

    $errors = $auth->getErrors();

    if (!empty($errors)) {
        echo '<p>',implode(', ', $errors),'</p>';
    }

    if (!$auth->isAuthenticated()) {
		$oops_error_message = $message_functions->showMessage('saml_auth_failed');
		include_once 'layout/'.$oops_error_layout.'/views/saml_error.php';
		logs_saml($txtt,'400');
        exit();
    }

    $_SESSION['samlUserdata'] = $auth->getAttributes();
    $_SESSION['samlNameId'] = $auth->getNameId();
    $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
    $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
	
    unset($_SESSION['AuthNRequestID']);
    if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
        $auth->redirectTo($_POST['RelayState']);
    }
} else if (isset($_GET['sls'])) {
    if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
        $requestID = $_SESSION['LogoutRequestID'];
    } else {
        $requestID = null;
    }

    $auth->processSLO(false, $requestID);
    $errors = $auth->getErrors();
    if (empty($errors)) {
        echo '<p>Successfully logged out</p>';
    } else {
        echo '<p>', implode(', ', $errors), '</p>';
    }
}

$log_file_path = __DIR__ . DIRECTORY_SEPARATOR.'log.txt';
$text=getallheaders();
$txt = '-----';
$myfile = file_put_contents($log_file_path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
$txt = date('Ymdhis');
$myfile = file_put_contents($log_file_path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
$txtt = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$myfile = file_put_contents($log_file_path, $txtt.PHP_EOL , FILE_APPEND | LOCK_EX);
$txttt = json_encode($text);
$myfile = file_put_contents($log_file_path, $txttt.PHP_EOL , FILE_APPEND | LOCK_EX);
$txtttt = json_encode($_POST);
$myfile = file_put_contents($log_file_path, $txtttt.PHP_EOL , FILE_APPEND | LOCK_EX);

	
	
if (isset($_SESSION['samlUserdata']) || (isset($_SESSION['samlNameId']))) {
	
    if (!empty($_SESSION['samlUserdata']) || (!empty($_SESSION['samlNameId']))) {
		
		//echo $_SESSION['samlNameId'];
		
		if (!empty($_SESSION['samlUserdata'])){
			$attributes = $_SESSION['samlUserdata'];
			 $user_id = $attributes['PersonImmutableID'][0];
			 $firstname = $attributes['User.FirstName'][0];
			 $lastname = $attributes['User.LastName'][0];
			 $email = $attributes['User.email'][0];
			 $UniqueID = $attributes['arris_unique_id'][0];
			 
		}
		else if (!empty($_SESSION['samlNameId'])){
			//print_r($_SESSION);
			 $UniqueID = $_SESSION['samlNameId'];
		}
		
		 if(strlen($UniqueID)=='0'){
		 $oops_error_message = $message_functions->showMessage('saml_unique_id_missing');
		 include_once 'layout/'.$oops_error_layout.'/views/saml_error.php';
			logs_saml($txtt,'400');
			exit();
		 } 
			
	
		$txt = json_encode($_SESSION);
		$myfile = file_put_contents($log_file_path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	
		

		$_SESSION['user_name'] = NULL;
		$_SESSION['access_role'] = NULL;
		$_SESSION['login'] = NULL;
		$_SESSION['full_name'] = NULL;
		$_SESSION['default_key'] = NULL;

		$_SESSION['s_detail'] = NULL;
		$_SESSION['s_token'] = NULL;  

		unset($_SESSION['user_name']);
		unset($_SESSION['access_role']);
		unset($_SESSION['login']);
		unset($_SESSION['full_name']);
		unset($_SESSION['default_key']);

		unset($_SESSION['s_detail']);
		unset($_SESSION['s_token']);
		unset($_SESSION['full_name_old']);
		unset($_SESSION['remote']);
		unset($_SESSION['ori_user_uname']);

		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
		session_start();
		 
	
    } else {
		$oops_error_message = $message_functions->showMessage('saml_parameters_missing');
		include_once 'layout/'.$oops_error_layout.'/views/saml_error.php';
		logs_saml($txtt,'400');
		exit();
    }



	

$verification_number = $UniqueID;
$username = $user_id; //GET FROM PersonImmutableID

$username = htmlentities( urldecode($username), ENT_QUOTES, 'utf-8' );
$verification_number = htmlentities( urldecode($verification_number), ENT_QUOTES, 'utf-8' );


}


if(isset($_POST['sign_in'])){

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	$username = htmlentities( urldecode($username), ENT_QUOTES, 'utf-8' );
	$password = htmlentities( urldecode($password), ENT_QUOTES, 'utf-8' );

}


if (isset($username) || (isset($verification_number))) {


	if(($login_using == 'verification_number') && (isset($_SESSION['samlUserdata']))){
		$user_query = sprintf("SELECT user_name, password, access_role, full_name,is_enable
		FROM admin_users WHERE verification_number =%s", GetSQLValueString($verification_number, "text"));
		
	}
	else if($login_using == 'user_name'){
		$user_query = sprintf("SELECT user_name, password, access_role, full_name,is_enable
		FROM admin_users WHERE user_name =%s", GetSQLValueString($username, "text"));
		
	}
	else {
		$user_query = sprintf("SELECT user_name, password, access_role, full_name,is_enable
		FROM admin_users WHERE user_name =%s", GetSQLValueString($username, "text"));
		
	}
	
	

	$query_results=mysql_query($user_query);
	$num_records = mysql_num_rows($query_results);
	
	if($num_records == 0){
	$oops_error_message = $message_functions->showMessage('saml_not_activated');
	include_once 'layout/'.$oops_error_layout.'/views/saml_error.php';
	exit();
	}

	while($row=mysql_fetch_array($query_results)){
		
		$user_name = $row[user_name];
		$password = $row[password];
		$access_role = $row[access_role];
		$full_name = $row[full_name];
		$is_enable = $row[is_enable];

		$access_role=strtolower($access_role);

	}

	/////// product verification 
	// get product
	/// to be verify
	
	////////////////////////////////
	
	$key_query0 = sprintf("SELECT  `access_role`, user_type, user_distributor 
	FROM  admin_users WHERE user_name = %s LIMIT 1",GetSQLValueString($user_name, "text"));
	
	$query_results=mysql_query($key_query0);
	while($row=mysql_fetch_array($query_results)){
		$access_role = $row[access_role];
		$user_type = $row[user_type];
		$user_distributor = $row[user_distributor];
		$access_role=strtolower($access_role);
	}

	if($user_type=="MNO"){
		$system_package=$db1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	}elseif($user_type=="MVNO" || $user_type=="MVNE" || $user_type=="MVNA"){
		$system_package=$db1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
	}elseif($user_type=="MVNO_ADMIN"){
		$system_package=$db1->getValueAsf("SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$user_distributor'");
	}else{
		$system_package=$db1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	}
	
	

	
	if($system_package=="N/A" || $system_package=="") {
		$package_features="all";
		 $system_package="N/A";
	}

	if($is_enable == '0'){
		$MMFailed = '1';
		$oops_error_message = $message_functions->showMessage('saml_not_activated');
		include_once 'layout/'.$oops_error_layout.'/views/saml_error.php';
		$MMFailedMassage = 'User account is not active';
		exit();
		
	}
	else if($is_enable == '2'){
		
		//// Need to discuss
		$MMFailed = '0';
		$MMFailedMassage = '';
		$_SESSION['login'] = 'no';
		$_SESSION['user_name'] = $user_name;
		
		$log_query = sprintf("INSERT INTO admin_user_logs (user_name,module,create_date)
		VALUES (%s,'Verification',now())", GetSQLValueString($user_name, "text"));
	
	
		$query_ex_log=mysql_query($log_query);

		$redirect_url = $global_base_url."/verification".$extension.'?login='.$login_design;

			//	$redirect_url = "home".$extension;
				header( "Location: $redirect_url");	
				exit();
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	else if($is_enable == '1'){

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
               	
			$MMFailed = '0';
			$MMFailedMassage = 'Success';
			$_SESSION['logout_design'] = $login_design;
			$_SESSION['login'] = 'yes';
			$_SESSION['user_name'] = $user_name;
			$_SESSION['access_role'] = $access_role;
			$_SESSION['full_name'] = $full_name;
			if($user_type=="MVNO" || $user_type=="MVNE" || $user_type=="MVNA"){
                $exec_cmd = 'php -f'.__DIR__.'/../../../ajax/syncAP.php '.$user_distributor.' > /dev/null &';
                exec($exec_cmd);
			}
			
	
			$log_query = sprintf("INSERT INTO admin_user_logs (user_name,module,create_date)
			VALUES (%s,'Login',now())", GetSQLValueString($user_name, "text"));
			
				$query_ex_log=mysql_query($log_query);

			if($access_role == 'admin'){
				$user_query = "SELECT module_name FROM admin_access_modules WHERE user_type = '$user_type' AND `order` IS NOT NULL AND module_name <> 'venue_support' AND module_name <> 'support' ORDER BY `order`";
			}
			else{
				$user_query = "SELECT module_name FROM admin_access_roles_modules WHERE access_role = '$access_role'";
		
			}
			
			
			$query_results=mysql_query($user_query);
			$num_records = mysql_num_rows($query_results);
		
				
			if($package_features=="all"||$system_package=="N/A"){
			
						$redirect_url = $global_base_url."/home".$extension;
						header( "Location: $redirect_url");
		
			}else{
                $m_n = json_decode($package_functions->getOptions('ALLOWED_PAGE',$system_package));
				while($row=mysql_fetch_array($query_results)){
		
					$module_name = $row[module_name];	
					//$m_n=$db1->getValueAsf("SELECT `source` AS f FROM `admin_product_controls` WHERE `product_code`='$system_package' AND type='page' AND user_type='$user_type' AND access_method='1' AND source='$module_name'");
			
					if(in_array($module_name,$m_n)/*$module_name==$m_n*/){
			
					$redirect_url = $global_base_url.'/'.$module_name.$extension;
					
					setcookie("system_package", $system_package, time() + (86400 * 30), "/");
					setcookie("load_login_design", $login_design, time() + (86400 * 30), "/");
			
					logs_saml($txtt,'200');
					header( "Location: $redirect_url");		
					exit();
			
			
					}
		
				}
		
			}
        	
        }
        
        

		
	}
	else {
		$MMFailed = '1';
		$MMFailedMassage = 'Incorrect User ID or Password';
		//$redirect
	}

	
	
} 
/*
else {
    echo '<p><a href="?sso" >Login</a></p>';
   
}
*/

function logs_saml($description,$api_status){


	$function="SSO";
	$function_name = "SSO Login - SAML";
	//echo $description;
	// print_r($txtt);
	$api_method ="POST";
	 
	//$realm='';
	$api_description= json_encode($_SESSION);
	//$api_data = '';
	$create_user = 'SSO';

	$logsquery ="INSERT INTO `exp_auth_profile_logs` (`function`, `function_name`, `description`, `api_method`, `api_status`, `realm`, `api_description`, `api_data`, `create_date`, `create_user`) 
	VALUES ('$function', '$function_name', '$description', '$api_method', '$api_status', '', '$api_description', '', NOW(), '$create_user')";


	mysql_query($logsquery);

}

?>