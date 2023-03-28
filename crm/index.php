<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login </title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);


session_start();   
include_once( str_replace('//','/',dirname(__FILE__).'/') .'db/dbTasks.php');
require_once 'classes/systemPackageClass.php';

$dbT = new dbTasks();
$package_functions=new package_functions();
/* No cache*/
header("Cache-Control: no-cache, must-revalidate");

$script = basename($_SERVER['PHP_SELF'],".php");
$extension = trim($dbT->setVal('extentions','ADMIN'),"/");
$global_base_url = trim($dbT->setVal('global_url','ADMIN'),"/");
 
  
?>
<link href="<?php echo $global_base_url; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $global_base_url; ?>/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $global_base_url; ?>/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $global_base_url; ?>/css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo $global_base_url; ?>/css/style.css?v=1" rel="stylesheet" type="text/css">
<link href="<?php echo $global_base_url; ?>/css/pages/signin.css?v=14" rel="stylesheet" type="text/css">
<script src="<?php echo $global_base_url; ?>/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $global_base_url; ?>/js/bootstrap.js"></script>
<script src="<?php echo $global_base_url; ?>/js/signin.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<?php


include 'login_header.php';



require_once 'classes/appClass.php';
include_once 'classes/cryptojs-aes.php';


$app = new app_functions();

if(!(isset($_SESSION['login']))){
	$_SESSION['login'] = 'no';

}

if(isset($_REQUEST['acs'])){
	$_SESSION['login'] = 'no';
}

// var_dump($_SESSION['login']);
// echo '=<<<<>>>>-';die;

if($_SESSION['login'] == 'yes' && !isset($_GET['auto_login'])){


	$user_name = $_SESSION['user_name'];
    require_once __DIR__.'/classes/AccessUser.php';
    $access_user = unserialize($_SESSION['access_user']);
    require_once __DIR__.'/classes/AccessController.php';
	$acc_cont = new AccessController($dbT,$access_user);
	
//////////////////////////////////////////////////////////////////////////


	$key_query0 = sprintf("SELECT  `access_role`, `group`, user_distributor 
	FROM  admin_users WHERE user_name ='%s'", $user_name);

  $query_results=$dbT->selectDB($key_query0);



	foreach( $query_results['data'] as $row ){
		$access_role = $row['access_role'];
		$user_group = $row['group'];
		$user_distributor = $row['user_distributor'];

		$access_role=strtolower($access_role);
	}

	
$system_package=$dbT->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

if($system_package=="N/A" || $system_package=="") {
    $package_features="all";
     $system_package="N/A";
}

$network_type=$dbT->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

$wifi_text = $package_functions->getMessageOptions('WIFI_TEXT',$system_package);
$theme_text = $package_functions->getMessageOptions('THEME_TEXT',$system_package);

if(empty($wifi_text) || $wifi_text ==''){
  $wifi_text='WiFi';
}

$_SESSION['wifi_text'] = $wifi_text;


if(empty($theme_text) || $theme_text ==''){
  $theme_text='theme';
  }

  $_SESSION['theme_text'] = $theme_text;


	/////////////////////////////////////////////////////////////////////////////

	$acc_cont->loginSuccess();

}

$robot_verify_method = $package_functions->getOptions("ROBOT_VERIFY_PROFILE", $admin_system_package);
if(empty($robot_verify_method)){
    $robot_verify_method = 'no_verify';
}
include 'src/auth/ROBOT_VERIFY/'.$robot_verify_method.'/index.php';
$robot_verify_functions = new robot_verify();

$auth_profile = $package_functions->getOptions("AUTH_PROFILE", $admin_system_package);
if(strlen($auth_profile)=='0'){
	$auth_profile = 'local_auth';
}

include 'src/auth/'.$auth_profile.'/login.php';


if(!isset($MMFailed)){
	$MMFailed = '';
}




 
        if($login_title_position=="body_top_center"){
        	?>

        	 <br>
            <center>
            	<h2><?php echo $dbT->setVal("login_title","ADMIN"); ?></h2>
            </center>

        	<?php }else{

        	if(isset($logo2) && $logo2 != "") {
            ?>
            <br><br>
            <center>
<?php if(file_exists("image_upload/welcome/".$logo2)){  ?>
                <img class="logo-center" src="<?php echo $global_base_url; ?>/image_upload/welcome/<?php echo $logo2; ?>" border="0" style="max-height:65px;" />

<?php } ?>
            </center>

        <?php
        } }
 

?>

<div class="account-container">

	<span class="logo-top-img"></span>

	<div class="content clearfix">

<?php

include 'src/auth/'.$auth_profile.'/form.php';


?>


	</div>

</div> 

<br><br>
<center>
        <?php echo $dbT->setVal('footer_copy','ADMIN'); ?>
        </center>
 <?php 
            
            if($camp_layout=="COX"){
         ?>

         <script>

            $(document).ready(function() {
                $( "input" ).attr( "oninvalid", "validate_func(this)" );

                $("*").on("invalid", function(event) {
                        event.preventDefault();
                    });
            });

            function validate_func(this_is){

                $(this_is).nextAll('div.error-wrapper').first().remove();
                $( this_is ).after( "<div style='display: inline-block;' class='error-wrapper bubble-pointer mbubble-pointer'><p>This field is required.</p></div>" );
                $(this_is).addClass("error");
            }
         </script>
          <?php } ?>

          <script type="text/javascript">
            (function ($) {
    "use strict";

    // Detecting IE
    var oldIE;
    if ($('html').is('.lt-ie7, .lt-ie8, .lt-ie9')) {
        oldIE = true;
    }

    if (oldIE) {
        alert('Your browser version is not supported.');
    } else {
        // ..And here's the full-fat code for everyone else
    }

}(jQuery));
          </script>
</body>


</html>
