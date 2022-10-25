<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

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
	$camp_url = $_GET['camp_url'];
	$camp_url = htmlentities( urldecode($camp_url), ENT_QUOTES, 'utf-8' );
    $time_zone = $_GET['time_zone'];
    $time_zone = htmlentities( urldecode($time_zone), ENT_QUOTES, 'utf-8' );
    

    /////////////////////////
	/// update noc email
	// $noc_update_q = sprintf("UPDATE admin_product_controls SET options ='%s' WHERE product_code='$system_package' AND feature_code='TECH_BCC_EMAIL'",$noc_email);
	// $noc_update = $db->execDB($noc_update_q);
    
    // $query2_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	-- 			SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	-- 			FROM `exp_settings`
	-- 			WHERE distributor = 'ADMIN' AND settings_code = 'portal_base_url'";
    // $ex21_ar = $db->execDB($query2_ar);

	// $query2 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND settings_code = 'portal_base_url'", $base_url);
	// $ex21 = $db->execDB($query2);
	

	/////////////////////////

	$query21_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND settings_code = 'captive_portal_url'";
	$ex211_ar = $db->execDB($query21_ar);
	
	$query21 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' 
	AND settings_code = 'captive_portal_url'", $captive_portal_url);
	$ex211 = $db->execDB($query21);
	
	////////////////////////////
	
	$query22_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND settings_code = 'camp_base_url'";
	$ex212_ar = $db->execDB($query22_ar);
	
	$query22 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND settings_code = 'camp_base_url'", $camp_url);
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

    $query7 = sprintf("UPDATE exp_mno SET system_package='%s' , theme_color = '%s', theme_style_type = '%s', theme_top_line_color = '%s', theme_light_color = '%s',theme_site_title = '%s',timezones = '%s'
	where mno_id = 'ADMIN'", $flatform, $header_color, $style_type, $top_line_color, $light_color, $main_title, $time_zone);
    $ex7 = $db->execDB($query7);

    //////////////////////////////
    
    $query8_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
    SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
    FROM `exp_settings`
    WHERE distributor = 'ADMIN' AND  settings_code = 'menu_type'";
    $ex6_ar = $db->execDB($query8_ar);

	$query8 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'menu_type'", $menu_type);
	$ex6 = $db->execDB($query8);
    
	///////////////////////////////
	
	$query9_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'SSL_ON'";
	$ex9_ar = $db->execDB($query9_ar);
	
	$query9 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'SSL_ON'", $ssl_on);
	$ex9 = $db->execDB($query9);

	
	
	$query10_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'global_url'";
	$ex10_ar = $db->execDB($query10_ar);
	
	$query10 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'global_url'", $global_url);
	$ex10 = $db->execDB($query10);

	

	$query11_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'login_title'";
	$ex11_ar = $db->execDB($query11_ar);

	$query11 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'login_title'", $login_title);
	$ex11 = $db->execDB($query11);


    $query12=sprintf("UPDATE exp_settings SET settings_value = '%s' WHERE settings_code = 'site_logo'", $header_logo_img5);
	$ex12 = $db->execDB($query12);
	

	$query14_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'mdu_portal_base_url'";
	$ex14_ar = $db->execDB($query14_ar);
	
	$query14 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'mdu_portal_base_url'", $tenant_url);
	$ex14 = $db->execDB($query14);


	$query16_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'mdu_camp_base_url'";
	$ex16_ar = $db->execDB($query16_ar);
	
	$query16 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'mdu_camp_base_url'", $tenant_internal_url);
	$ex16 = $db->execDB($query16);

    $query17_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'ALLOWED_LOGIN_PROFILES'";
    $ex17_ar = $db->execDB($query17_ar);

	$query17 = sprintf("UPDATE exp_settings SET settings_value = '%s' WHERE settings_code = 'ALLOWED_LOGIN_PROFILES' AND distributor = 'ADMIN'",$login_profile);
    $ex17 = $db->execDB($query17);

    /*Google Recapture*/

    $query18_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'g-reCAPTCHA'";
    $ex18_ar = $db->execDB($query18_ar);

    $query18 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'g-reCAPTCHA'", $g_recap_key);
    $ex18 = $db->execDB($query18);

    $query19_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'g-reCAPTCHA-site-key'";
    $ex19_ar = $db->execDB($query19_ar);

    $query19 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'g-reCAPTCHA-site-key'", $g_recap_site);
    $ex19 = $db->execDB($query19);

    $query20 = sprintf("UPDATE admin_users SET timezone = '%s'
	where user_name = '$user_name'", $time_zone);
    $ex20 = $db->execDB($query20);


    if(strlen($captive_theme_up_tmp)>0){
    $query23_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = 'ADMIN' AND  settings_code = 'captive_theme_up_tmp'";
    $ex23_ar = $db->execDB($query23_ar);

    $query23 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'captive_theme_up_tmp'", $captive_theme_up_tmp);
    $ex23 = $db->execDB($query23);
	}else{
		$ex23=true;
	}
    ///////////////////////////////

    $query24 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'dbr_key'", $dbr_key);
    $ex24 = $db->execDB($query24);

    $query25 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND  settings_code = 'tech_barcode_reader_status'", $tech_barcode_reader_status);
    $ex25 = $db->execDB($query25);

	
	///////////////////////////////
	
	if($ex24=== true && $noc_update===true && $ex21===true && $ex211===true && $ex211===true && $ex4===true && $ex6===true && $ex7===true && $ex6===true && $ex9===true && $ex10===true && $ex11===true && $ex12===true && $ex17===true && $ex18===true && $ex19===true && $ex23===true && $ex25===true){
		
		$msg=$message_functions->showMessage('config_general_update_success');
		
		$create_log->save('3001',$msg,'');
	
	
		$_SESSION['msgy'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg."</strong></div>";
		
	}else{
		
		$msg=$message_functions->showMessage('config_general_update_failed','2001');
		
		$create_log->save('2001',$msg,'');
		
		$_SESSION['msgy']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg."</strong></div>";
		
	}
	
}


if($type == 'manual'){

	$first_name_b = $_GET['first_name'];

	$last_name_b = $_GET['last_name'];	
	//$fb_status = $_GET['fb_status'];		
	$email_b = $_GET['email'];
	$age_group_b = $_GET['age_group'];
	$distributor = $_GET['distributor'];
	$gender_b = $_GET['gender'];
	$manual_profile = $_GET['manual_profile'];
	$mobile_b = $_GET['mobile_number'];

	$first_name_b = htmlentities( urldecode($first_name_b), ENT_QUOTES, 'utf-8' );
	$last_name_b = htmlentities( urldecode($last_name_b), ENT_QUOTES, 'utf-8' );
	$email_b = htmlentities( urldecode($email_b), ENT_QUOTES, 'utf-8' );
	$age_group_b = htmlentities( urldecode($age_group_b), ENT_QUOTES, 'utf-8' );
	$distributor = htmlentities( urldecode($distributor), ENT_QUOTES, 'utf-8' );
	$gender_b = htmlentities( urldecode($gender_b), ENT_QUOTES, 'utf-8' );
	$manual_profile = htmlentities( urldecode($manual_profile), ENT_QUOTES, 'utf-8' );
	$mobile_b = htmlentities( urldecode($mobile_b), ENT_QUOTES, 'utf-8' );
	
	//$array_add_fields =  explode('/', $fb_additional_fields);
	if ($first_name_b == 'true') {
		$first_name = 1;
	} else {
		$first_name = 0;
	}
	
	if ($last_name_b == 'true') {
		$last_name = 1;
	} else {
		$last_name = 0;
	}

	if ($email_b == 'true') {
		$email = 1;
	} else {
		$email = 0;
	}

	if ($age_group_b == 'true') {
		$age_group = 1;
	} else {
		$age_group = 0;
	}

	if ($gender_b == 'true') {
		$gender = 1;
	} else {
		$gender = 0;
	}
	
	if ($mobile_b == 'true') {
		$mobile = 1;
	} else {
		$mobile = 0;
	}

	$query10 = sprintf("REPLACE INTO exp_manual_reg_profile 
					(`name`,`first_name`, `last_name`,`email`,`gender`,`age_group`,`mobile_number`,`distributor`)
					VALUES ('%s','%s', '%s', '%s', '%s','%s','%s','%s')", $manual_profile, $first_name, $last_name, $email, $gender, $age_group, $mobile, $distributor);
	$ex10 = $db->execDB($query10);


	if ($ex10) {
        $show_msg=$message_functions->showMessage('config_operation_success');
        $create_log->save('3002',$show_msg,"");
        $_SESSION['system1_msg']='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';

        //echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	} else {
        $show_msg=$message_functions->showMessage('config_operation_failed','2002');
        $create_log->save('2002',$show_msg,"");
        $_SESSION['system1_msg']='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';

        //echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !<div>';
	}
}



?>
