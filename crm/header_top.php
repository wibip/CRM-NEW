<?php
ob_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

foreach ($_POST as $key => $value) {
    //echo $key;
    // var_dump($value);
    if(strpos($value,'<script') !== false && !is_array($value)){
        //echo $key;
        $_POST[$key] = strip_tags($value);
    }
    else{
		
	}
}

foreach ($_GET as $key => $value) {
	if(strpos($value,'<script') !== false && !is_array($value)){
		$_GET[$key] = strip_tags($value);
	}
	else{
		
	}

}

define("__WIFI_TEXT__", $_SESSION['wifi_text']);
define("__THEME_TEXT__", $_SESSION['theme_text']);

// GET PAGE SCRIPT
$script = basename($_SERVER['PHP_SELF'],".php");
// var_dump($_SESSION['login']);
// echo '=======------';die;
/////// Login session failed ////
if($_SESSION['login'] != 'yes' && $script!='verification'){
//	$redirect_url = "index".$extension;
//$redirect_url = '//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$redirect_url ='logout'.$extension.'?doLogout=true&product='.$_COOKIE["system_package"].'&login='.$_COOKIE["load_login_design"];
header('location:'.$redirect_url);
exit();
}


?>