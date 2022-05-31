<?php  
ob_start();

if (!isset($_SESSION)) {  session_start(); }

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';


/*classes & libraries*/
include_once( str_replace('//','/',dirname(__FILE__).'/') .'db/dbTasks.php');

require_once 'classes/systemPackageClass.php';
$package_function=new package_functions();


// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

$db = new dbTasks();
$extension = $db->setVal("extentions","ADMIN");
$login_design = $_GET['login'];
$system_product = $_GET['product'];
$global_base_url = trim($db->setVal('global_url','ADMIN'),"/");

	$login_main_url = $db->getSystemURL('login',$login_design); 
	 $veri_login = $db->getSystemURL('verification',$login_design);	


if (((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")) || isset($_POST['logoutToNewUser'])){
	
	$local_logout_list = $package_function->getOptions("LOCAL_AUTH_LOGOUT", $login_design);
	$auth_profile = $package_function->getOptions("AUTH_PROFILE", $login_design);
	
	$lo_list_array = explode(',',$local_logout_list);

	// Logout product code validation

	if(in_array($system_product,$lo_list_array)){
		$auth_profile = 'local_auth';
	}
	 

	
	if(strlen($auth_profile)=='0'){
		$auth_profile = 'local_auth';
	}
	
	include 'src/auth/'.$auth_profile.'/logout.php';
	
	
	

  if(isset($_POST['logoutToNewUser'])){
      $logoutGoTo = $veri_login;
  }else{
      $logoutGoTo = $login_main_url;
  }
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
	
    exit;
  }
}

if(isset($_POST['logoutToNewUser'])){
    ?>
    <meta http-equiv="refresh" content="0; url=<?php echo $veri_login ; ?>">
    <?php
}
else if(isset($_GET['doLogout'])){
	include 'src/auth/'.$auth_profile.'/logout.php';
    ?>
    <meta http-equiv="refresh" content="0; url=<?php echo $login_main_url ; ?>">
    <?php
}
?>