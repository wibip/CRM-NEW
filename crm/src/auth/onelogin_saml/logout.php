<?php

session_start();
/**
 *  SAML Handler
 */

 $user_name = $_SESSION['user_name'];
	$log_query = "INSERT INTO admin_user_logs (user_name,module,create_date) 
	VALUES ('$user_name','Logout',now())";
	$query_ex_log=mysql_query($log_query);

	$redirect_url = $global_base_url; //"index".$extension; 
	//header( "Refresh:0; url=$redirect_url", true, 303);

	
  //to fully log out a visitor we need to clear the session varialbles
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
	

require_once '_toolkit_loader.php';


require_once 'settings.php';


$auth = new OneLogin_Saml2_Auth($settingsInfo);

// if (isset($_GET['slo'])) {
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

//} 


/*
 else if (isset($_GET['sls'])) {
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

*/


