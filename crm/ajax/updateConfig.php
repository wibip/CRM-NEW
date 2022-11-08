<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

$page = "General configurations";
$user_name = $_SESSION['user_name'];
// var_dup($user_name);
include_once '../classes/systemPackageClass.php';
$ajax_package_fn = new package_functions();

$system_package = $ajax_package_fn->getPackage($user_name);
// var_dup($system_package);die;
include_once '../classes/messageClass.php';
$message_functions=new message_functions($system_package);

include_once '../classes/logClass.php';
$create_log=new logs('updateConfig',$user_name);

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

$type = $_GET['type'];

if($type == 'system'){
	$main_title = $_GET['main_title'];
	$main_title = htmlentities( urldecode($main_title), ENT_QUOTES, 'utf-8' );
	$master_email = $_GET['master_email'];
	$master_email = htmlentities( urldecode($master_email), ENT_QUOTES, 'utf-8' );
	$global_url = $_GET['global_url'];
	$global_url = htmlentities( urldecode($global_url), ENT_QUOTES, 'utf-8' );
    $time_zone = $_GET['time_zone'];
    $time_zone = htmlentities( urldecode($time_zone), ENT_QUOTES, 'utf-8' );

	
	////////////////////////////
	
	$query22_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND settings_code = 'global_url'";
	$ex212_ar = $db->execDB($query22_ar);
	
	$query22 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND settings_code = 'global_url'", $global_url);
	$ex212 = $db->execDB($query22);

	///////////////////////////
	
	$query4_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'site_title'";
	$ex4_ar = $db->execDB($query4_ar);
	
	$query4 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'site_title'", $main_title);
	$ex4 = $db->execDB($query4);

	//////////////////////////

	$query6_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'email'";
	$ex6_ar = $db->execDB($query6_ar);
	
	$query6 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'email'", $master_email);
	$ex6 = $db->execDB($query6);

	/////////////////////////////
	
	$query7_ar = "INSERT INTO `exp_mno_archive` (`mno_id`,`unique_id`,`mno_description`,`mno_portal_text`,`logo`,`top_line_color`,`mno_type`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,`is_enable`,`top_line_size`,`favicon_image`,`top_bg_pattern_image`,`theme_site_title`,`theme_logo`,`theme_style_type`,`theme_top_line_color`,`theme_color`,`theme_light_color`,`timezones`,`create_user`,`create_date`,`last_update`,`delete_by`,`delete_date`,`action`)
	SELECT `mno_id`,`unique_id`,`mno_description`,`mno_portal_text`,`logo`,`top_line_color`,`mno_type`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,`is_enable`,`top_line_size`,`favicon_image`,`top_bg_pattern_image`,`theme_site_title`,`theme_logo`,`theme_style_type`,`theme_top_line_color`,`theme_color`,`theme_light_color`,`timezones`,`create_user`,`create_date`,`last_update`,'$user_name',NOW(),'update'
	FROM `exp_mno`
	WHERE mno_id = 'ADMIN'";
	$ex7_ar = $db->execDB($query7_ar);

    /*$query7 = sprintf("UPDATE exp_mno SET system_package='%s' , theme_color = '%s', theme_style_type = '%s', theme_top_line_color = '%s', theme_light_color = '%s',theme_site_title = '%s',timezones = '%s'
	where mno_id = 'ADMIN'", $flatform, $header_color, $style_type, $top_line_color, $light_color, $main_title, $time_zone);
    $ex7 = $db->execDB($query7);*/


	$query7 = sprintf("UPDATE exp_mno SET timezones = '%s' where mno_id = 'ADMIN'", $time_zone);
    $ex7 = $db->execDB($query7);
    
	
	if($ex212===true && $ex4===true && $ex6===true && $ex7===true ){
		$message_response = $message_functions->showMessage('config_general_update_success');
		$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify General configurations',0,'3001',$message_response);
		// $msg=$message_functions->showMessage('config_general_update_success');
		// $create_log->save('3001',$msg,'');
		$_SESSION['msgy'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
	}else{
		$message_response = $message_functions->showMessage('config_general_update_failed', '2001');
		$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify General configurations',0,'2001',$message_response);
		// $msg=$message_functions->showMessage('config_general_update_failed','2001');
		// $create_log->save('2001',$msg,'');
		$_SESSION['msgy']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
	}
}

?>
