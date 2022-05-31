<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

$user_name = $_SESSION['user_name'];
include_once '../classes/systemPackageClass.php';
$ajax_package_fn = new package_functions();

$system_package = $ajax_package_fn->getPackage($user_name);

include_once '../classes/messageClass.php';
$message_functions=new message_functions($system_package);

include_once '../classes/logClass.php';
$create_log=new logs('updateConfig',$user_name);

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

$type = $_GET['type'];

if($type == 'system'){

	$base_url = $_GET['base_url'];
	$base_url = htmlentities( urldecode($base_url), ENT_QUOTES, 'utf-8' );
	$noc_email = $_GET['noc_email'];
	$noc_email = htmlentities( urldecode($noc_email), ENT_QUOTES, 'utf-8' );
	$main_title = $_GET['main_title'];
	$main_title = htmlentities( urldecode($main_title), ENT_QUOTES, 'utf-8' );
	$master_email = $_GET['master_email'];
	$master_email = htmlentities( urldecode($master_email), ENT_QUOTES, 'utf-8' );
	$camp_url = $_GET['camp_url'];
	$camp_url = htmlentities( urldecode($camp_url), ENT_QUOTES, 'utf-8' );
	$captive_portal_url = $_GET['captive_portal_url'];
	$captive_portal_url = htmlentities( urldecode($captive_portal_url), ENT_QUOTES, 'utf-8' );
	$menu_type=$_GET['menu_type'];
	$menu_type = htmlentities( urldecode($menu_type), ENT_QUOTES, 'utf-8' );
    $header_color = $_GET['header_color'];
    $header_color = htmlentities( urldecode($header_color), ENT_QUOTES, 'utf-8' );
    $style_type = $_GET['style_type'];
    $style_type = htmlentities( urldecode($style_type), ENT_QUOTES, 'utf-8' );
    $light_color = $_GET['light_color'];
    $light_color = htmlentities( urldecode($light_color), ENT_QUOTES, 'utf-8' );
    $top_line_color = $_GET['top_line_color'];
    $top_line_color = htmlentities( urldecode($top_line_color), ENT_QUOTES, 'utf-8' );
    $flatform = $_GET['flatform'];
    $flatform = htmlentities( urldecode($flatform), ENT_QUOTES, 'utf-8' );
    $time_zone = $_GET['time_zone'];
    $time_zone = htmlentities( urldecode($time_zone), ENT_QUOTES, 'utf-8' );
    $global_url = $_GET['global_url'];
	$global_url = htmlentities( urldecode($global_url), ENT_QUOTES, 'utf-8' );
	$tenant_url = $_GET['tenant_url'];
    $tenant_url = htmlentities( urldecode($tenant_url), ENT_QUOTES, 'utf-8' );
    $tenant_internal_url = $_GET['tenant_internal_url'];
    $tenant_internal_url = htmlentities( urldecode($tenant_internal_url), ENT_QUOTES, 'utf-8' );
    $ssl_on = $_GET['ssl_on'];
    $ssl_on = htmlentities( urldecode($ssl_on), ENT_QUOTES, 'utf-8' );
    $login_title = $_GET['login_title'];
    $login_title = htmlentities( urldecode($login_title), ENT_QUOTES, 'utf-8' );
    $header_logo_img5 = $_GET['header_logo_img5'];
    $header_logo_img5 = htmlentities( urldecode($header_logo_img5), ENT_QUOTES, 'utf-8' );

    $g_recap_key = $_GET['g-recap-key'];
    $g_recap_key = htmlentities( urldecode($g_recap_key), ENT_QUOTES, 'utf-8' );
    $g_recap_site = $_GET['g-recap-site'];
    $g_recap_site = htmlentities( urldecode($g_recap_site), ENT_QUOTES, 'utf-8' );

    $captive_theme_up_tmp = $_GET['captive_theme_up_tmp'];
    $captive_theme_up_tmp = htmlentities( urldecode($captive_theme_up_tmp), ENT_QUOTES, 'utf-8' );

    $dbr_key = $_GET['dbr_key'];
    $dbr_key = htmlentities( rawurldecode($dbr_key), ENT_QUOTES, 'utf-8' );
    $tech_barcode_reader_status = $_GET['tech_barcode_reader_status'];
    $tech_barcode_reader_status = htmlentities( rawurldecode($tech_barcode_reader_status), ENT_QUOTES, 'utf-8' );

    $login_profile = $_GET['login_profile'];
    //$login_profile = htmlentities( urldecode($login_profile), ENT_QUOTES, 'utf-8' );

    /////////////////////////
	/// update noc email
	$noc_update_q = sprintf("UPDATE admin_product_controls SET options ='%s' WHERE product_code='$system_package' AND feature_code='TECH_BCC_EMAIL'",$noc_email);
	$noc_update = $db->execDB($noc_update_q);
    
    $query2_ar = "INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
				SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
				FROM `exp_settings`
				WHERE distributor = 'ADMIN' AND settings_code = 'portal_base_url'";
    $ex21_ar = $db->execDB($query2_ar);

	$query2 = sprintf("UPDATE exp_settings set settings_value = '%s' where distributor = 'ADMIN' AND settings_code = 'portal_base_url'", $base_url);
	$ex21 = $db->execDB($query2);
	

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

if($type == 'system1'){

	$deni_url = $_GET['deni_url'];
	$deni_url = htmlentities( urldecode($deni_url), ENT_QUOTES, 'utf-8' );
	$noc_email1 = $_GET['noc_email1'];
	$noc_email1 = htmlentities( urldecode($noc_email1), ENT_QUOTES, 'utf-8' );
	$main_title = $_GET['main_title'];
	$main_title = htmlentities( urldecode($main_title), ENT_QUOTES, 'utf-8' );
	$short_title = $_GET['short_title'];
	$short_title = htmlentities( urldecode($short_title), ENT_QUOTES, 'utf-8' );
	$master_email = $_GET['master_email'];
	$master_email = htmlentities( urldecode($master_email), ENT_QUOTES, 'utf-8' );
	$dist = $_GET['dist'];
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
	$mno_header_color = $_GET['mno_header_color'];
	$mno_header_color = htmlentities( urldecode($mno_header_color), ENT_QUOTES, 'utf-8' );
	$header_logo_img = $_GET['header_logo_img'];
	$header_logo_img = htmlentities( urldecode($header_logo_img), ENT_QUOTES, 'utf-8' );

	$user_type = $_GET['user_type'];
    $user_type = htmlentities( urldecode($user_type), ENT_QUOTES, 'utf-8' );
    $style_type = $_GET['style_type'];
    $style_type = htmlentities( urldecode($style_type), ENT_QUOTES, 'utf-8' );
    $light_color = $_GET['light_color'];
    $light_color = htmlentities( urldecode($light_color), ENT_QUOTES, 'utf-8' );
    $top_line_color = $_GET['top_line_color'];
    $top_line_color = htmlentities( urldecode($top_line_color), ENT_QUOTES, 'utf-8' );


	$tech_aps = $_GET['tech_aps'];
    $tech_aps = htmlentities( urldecode($tech_aps), ENT_QUOTES, 'utf-8' );

	$tech_switch = $_GET['tech_switch'];
    $tech_switch = htmlentities( urldecode($tech_switch), ENT_QUOTES, 'utf-8' );

	$tech_data= Array();
	$tech_data['tech_ap']=$tech_aps;
	$tech_data['tech_switch']=$tech_switch;
    $tech_data_js=json_encode($tech_data);


	


    if($ajax_package_fn->isDynamic($system_package)){
		$dy_product = json_decode($db->getValueAsf("SELECT settings AS f FROM admin_product_controls_custom WHERE product_id='$system_package'"),true);
		$dy_product['general']['TECH_BCC_EMAIL']=["description"=>'tool post installation email address',"source"=>"","access_method"=>"","options"=>$noc_email1];
		$noc_update_q = sprintf("UPDATE admin_product_controls_custom SET settings ='%s' WHERE product_id='$system_package'",json_encode($dy_product));
	}else{
		$noc_update_q = sprintf("REPLACE INTO `admin_product_controls` (`product_code`, `discription`, `feature_code`, `options`, `type`, `user_type`, `last_update`, `create_date`, `create_user`) 
		VALUES ('$system_package', 'tool post installation email address', 'TECH_BCC_EMAIL', '$noc_email1', 'option', 'MNO', NOW(), NOW(), '$user_name')");
		//$noc_update_q = sprintf("UPDATE admin_product_controls SET options ='%s' WHERE product_code='$system_package' AND feature_code='TECH_BCC_EMAIL'",$noc_email1);
	}
	$noc_update = $db->execDB($noc_update_q);
/*	$query1 = "REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`)
	VALUES ('MNO Theme Color', 'MNO Theme Color', 'SYSTEM', 'mno_color', '$mno_header_color', '$dist', NOW(), '$user_name')";
	$ex21 = $db->execDB($query1);*/
    
    $query2_ar = sprintf("INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
    SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
    FROM `exp_settings`
    WHERE distributor = '%s' AND  settings_code = 'deni_url'", $dist);
    $ex21_ar = $db->execDB($query2_ar);

	$query2 = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('Unauthorized URL', 'Unauthorized URL', 'SYSTEM', 'deni_url', '%s', '%s', NOW(), '$user_name')", $deni_url, $dist);
	$ex21 = $db->execDB($query2);

/*	$query3 = "REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`)
	VALUES ('Campaign Title', 'Campaign Title', 'SYSTEM', 'site_title', '$main_title', '$dist', NOW(), '$user_name')";
	$ex3 = $db->execDB($query3);*/
	
	$query4_ar = sprintf("INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = '%s' AND  settings_code = 'short_title'", $dist);
	$ex4_ar = $db->execDB($query4_ar);	
	

	$query4 = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('Short Title', 'Short Title', 'SYSTEM', 'short_title', '%s', '%s', NOW(), '$user_name')", $short_title, $dist);
	$ex4 = $db->execDB($query4);

	////////////////////////////////////////////
	
	$query5_ar = sprintf("INSERT INTO `exp_settings_archive` (`settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,`archive_time`,`archive_by`,`action`)
	SELECT `settings_name`,`description`,`category`,`settings_code`,`settings_value`,`distributor`,`create_date`,`create_user`,`last_update`,NOW(),'$user_name','update'
	FROM `exp_settings`
	WHERE distributor = '%s' AND  settings_code = 'email'", $dist);
	$ex5_ar = $db->execDB($query5_ar);

	$query5 = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('Email Address', 'Email Address', 'SYSTEM', 'email', '%s', '%s', NOW(), '$user_name')", $master_email, $dist);
	$ex5 = $db->execDB($query5);

	$query6_te = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('MNO Tech Configuration', 'MNO Tech Configuration', 'SYSTEM', 'mno_tech_configuration', '%s', '%s', NOW(), '$user_name')", $tech_data_js, $dist);
	$ex6_te = $db->execDB($query6_te);

	//////////////////////

	
	
	if ($user_type == 'MVNO_ADMIN') {
		$query8= sprintf("UPDATE mno_distributor_parent SET account_name = '%s' WHERE parent_id = '%s'", $main_title, $dist);
    	$ex8 = $db->execDB($query8);
		$ex7 = true; $ex7_ar = true;
	}else{
		$query7_ar = sprintf("INSERT INTO `exp_mno_archive` (`mno_id`,`unique_id`,`mno_description`,`mno_portal_text`,`logo`,`top_line_color`,`mno_type`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,`is_enable`,`top_line_size`,`favicon_image`,`top_bg_pattern_image`,`theme_site_title`,`theme_logo`,`theme_style_type`,`theme_top_line_color`,`theme_color`,`theme_light_color`,`timezones`,`create_user`,`create_date`,`last_update`,`delete_by`,`delete_date`,`action`)
	SELECT `mno_id`,`unique_id`,`mno_description`,`mno_portal_text`,`logo`,`top_line_color`,`mno_type`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,`is_enable`,`top_line_size`,`favicon_image`,`top_bg_pattern_image`,`theme_site_title`,`theme_logo`,`theme_style_type`,`theme_top_line_color`,`theme_color`,`theme_light_color`,`timezones`,`create_user`,`create_date`,`last_update`,'$user_name',NOW(),'update'
	FROM `exp_mno`
	WHERE mno_id = '%s'", $dist);
	$ex7_ar = $db->execDB($query7_ar);

    $query7 = sprintf("UPDATE exp_mno SET theme_color = '%s', theme_style_type = '%s', theme_top_line_color = '%s', theme_light_color = '%s',theme_site_title = '%s'
	where mno_id = '%s'", $mno_header_color, $style_type, $top_line_color, $light_color, $main_title, $dist);
    $ex7 = $db->execDB($query7);

    $query8= sprintf("UPDATE exp_mno SET theme_logo = '%s' WHERE mno_id = '%s'", $header_logo_img, $dist);
    $ex8 = $db->execDB($query8);
	}


    if($noc_update===true && $ex21===true && $ex4===true && $ex5===true && $ex7===true && $ex8===true){
        $show_msg=$message_functions->showMessage('config_operation_success');
        $create_log->save('3002',$show_msg,"");
		$_SESSION['system1_msg']='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
    	//echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>'.$show_msg.'</div>';
		 
    
    }else{
        $show_msg=$message_functions->showMessage('config_operation_failed','2002');
        $create_log->save('2002',$show_msg,"");
		$_SESSION['system1_msg']='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
    	//echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>'.$show_msg.'</div>';
    
    }



	
}

if($type == 'loc'){
	$title = $_GET['title'];
	$title = htmlentities( urldecode($title), ENT_QUOTES, 'utf-8' );
	$php_time_zone = $_GET['php_time_zone'];
	$php_time_zone = htmlentities( urldecode($php_time_zone), ENT_QUOTES, 'utf-8' );
	$portal_language = $_GET['portal_language'];
	$portal_language = htmlentities( urldecode($portal_language), ENT_QUOTES, 'utf-8' );
	$distributor_code = $_GET['distributor_code'];
	$distributor_code = htmlentities( urldecode($distributor_code), ENT_QUOTES, 'utf-8' );
	$header_color = $_GET['header_color'];
	$header_color = htmlentities( urldecode($header_color), ENT_QUOTES, 'utf-8' );

    $style_type = $_GET['style_type'];
	$light_color = $_GET['light_color'];
	$top_line_color = $_GET['top_line_color'];

	 $query7 = sprintf("UPDATE exp_mno_distributor SET camp_theme_color = '%s', theme_style_type = '%s', theme_top_line_color = '%s', theme_light_color = '%s',site_title = '%s', time_zone = '%s',language = '%s'
	where distributor_code = '%s'", $header_color, $style_type, $top_line_color, $light_color, $title, $php_time_zone, $portal_language, $distributor_code);
	$ex7 = $db->execDB($query7);

	
	if($ex7===true){
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	
	}else{
	
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !</div>';
	
	}
	
	
	
	
}


if($type == 'loc_thm'){

    $header_color = $_GET['header_color'];
    $header_color = htmlentities( urldecode($header_color), ENT_QUOTES, 'utf-8' );
    $header_logo_img23 = $_GET['header_logo_img23'];
    $header_logo_img23 = htmlentities( urldecode($header_logo_img23), ENT_QUOTES, 'utf-8' );

    $query1 = sprintf("UPDATE exp_settings SET  settings_value = '%s' WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'", $header_color);
    $ex1 = $db->execDB($query1);

    $query2 = sprintf("UPDATE exp_settings SET  settings_value = '%s' WHERE settings_code = 'LOGIN_SCREEN_LOGO'", $header_logo_img23);
    $ex2 = $db->execDB($query2);

    if($ex1 && $ex2){
    	
    	$mess=$message_functions->showMessage('config_login_update_success');
    	
    	$create_log->save('3001',$mess,'');
    
    	echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>'.$mess.'<div>';
    
    }else{
    
    	$mess=$message_functions->showMessage('config_login_update_failed','2001');
    	$create_log->save('2001',$mess,'');
    	echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>'.$mess.'</div>';
    
    }
    
    
    
}


if($type == 'network'){
	$network_name = $_GET['network_name'];
	$network_name = htmlentities( urldecode($network_name), ENT_QUOTES, 'utf-8' );
	
	$query0 = sprintf("UPDATE exp_settings set settings_value = '%s' where settings_code = 'network_name'", $network_name);
	$ex0 = $db->execDB($query0);
	
	
	if($ex0){

        $show_msg=$message_functions->showMessage('api_network_profile_activate');
        $create_log->save('3002',$show_msg,"");
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>'.$show_msg.'<div>';
	
	}else{

        $show_msg=$message_functions->showMessage('api_network_profile_activate_fai');
        $create_log->save('2002',$show_msg,"");
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>'.$show_msg.'</div>';
	
	}
	
	
}

if($type == 'toc'){
	$toc = $_GET['toc'];
	$dist = $_GET['dist'];
	$toc = htmlentities( urldecode($toc), ENT_QUOTES, 'utf-8' );
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );

	$query0 = sprintf("REPLACE INTO exp_texts (text_code,text_details,distributor,create_date,updated_by)
	values ('TOC','%s','%s',now(),'$user_name')", $toc, $dist);
	$ex0 = $db->execDB($query0);
	
	if($ex0){
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	
	}else{
	
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !</div>';
	
	}

	
}

if($type == 'aup'){
	$aup = $_GET['aup'];
	$dist = $_GET['dist'];
	$aup = htmlentities( urldecode($aup), ENT_QUOTES, 'utf-8' );
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );

	$query0 = sprintf("REPLACE INTO exp_texts (text_code,text_details,distributor,create_date,updated_by)
	values ('AUP','%s','%s',now(),'$user_name')", $aup, $dist);
	$ex0 = $db->execDB($query0);

	if($ex0){
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	
	}else{
	
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !</div>';
	
	}
	
	
	
}

if($type == 'email'){
	$email = $db->escapeDB($_GET['email']);
	$email = htmlentities( urldecode($email), ENT_QUOTES, 'utf-8' );
	$dist = $_GET['dist'];
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );

	$query0 = sprintf("REPLACE INTO exp_texts (text_code,text_details,distributor,create_date,updated_by)
	values ('MAIL','%s','%s',now(),'$user_name')", $email, $dist);
	$ex0 = $db->execDB($query0);

	if($ex0){
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	
	}else{
	
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !</div>';
	
	}
	
	
	
}

if($type == 'caphaign'){
	
	$default_ad_waiting = $_GET['default_ad_waiting'];
	$default_ad_welcome = $_GET['default_ad_welcome'];
	$default_ad_waiting = htmlentities( urldecode($default_ad_waiting), ENT_QUOTES, 'utf-8' );
	$default_ad_welcome = htmlentities( urldecode($default_ad_welcome), ENT_QUOTES, 'utf-8' );
	$dist = $_GET['dist'];
	$dist = htmlentities( urldecode($dist), ENT_QUOTES, 'utf-8' );
	
	$query0 = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('Default Waiting Time', 'Default Ad Waiting Time', 'ADS', 'ad_waiting', '%s', '%s', NOW(), '$user_name')", $default_ad_waiting, $dist);
			
	$ex0 = $db->execDB($query0);
	

	$query1 = sprintf("REPLACE INTO `exp_settings` (`settings_name`, `description`, `category`, `settings_code`, `settings_value`, `distributor`, `create_date`, `create_user`) 
	VALUES ('Default Waiting Time', 'Default Ad Waiting Time', 'ADS', 'ad_welcome_page', '%s', '%s', NOW(), '$user_name')", $default_ad_welcome, $dist);
	$ex1 = $db->execDB($query1);

	
	if($ex0 && $ex1){
	
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	
	}else{
	
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !</div>';
	
	}
	
	
	
}

if($type == 'fb'){

	$fb_app_id = $_GET['fb_app_id'];
	$fb_app_version = $_GET['fb_app_version'];
	$fb_status = $_GET['fb_status'];
	$app_cookie = $_GET['app_cookie'];
	$app_xfbml = $_GET['app_xfbml'];
	$distributor = $_GET['distributor'];
	$social_profile = $_GET['social_profile'];
	$fb_additional_fields = $_GET['fb_additional_fields'];

	$fb_app_id = htmlentities( urldecode($fb_app_id), ENT_QUOTES, 'utf-8' );
	$fb_app_version = htmlentities( urldecode($fb_app_version), ENT_QUOTES, 'utf-8' );
	$fb_status = htmlentities( urldecode($fb_status), ENT_QUOTES, 'utf-8' );
	$app_cookie = htmlentities( urldecode($app_cookie), ENT_QUOTES, 'utf-8' );
	$app_xfbml = htmlentities( urldecode($app_xfbml), ENT_QUOTES, 'utf-8' );
	$distributor = htmlentities( urldecode($distributor), ENT_QUOTES, 'utf-8' );
	$social_profile = htmlentities( urldecode($social_profile), ENT_QUOTES, 'utf-8' );
	$fb_additional_fields = htmlentities( urldecode($fb_additional_fields), ENT_QUOTES, 'utf-8' );

	$fb_additional_fields = trim($fb_additional_fields,',');
	//$array_add_fields =  explode('/', $fb_additional_fields);

	$query0 = sprintf("REPLACE INTO exp_social_profile 
					(`social_profile`, `social_media`,`app_id`,`app_version`,`fields`,`app_xfbml`,`app_cookie`,`distributor`,create_date)
					VALUES ('%s','FACEBOOK', '%s', '%s','%s','%s', '%s', '%s',now())", $social_profile, $fb_app_id, $fb_app_version, $fb_additional_fields, $app_xfbml, $app_cookie, $distributor);
	$ex0 = $db->execDB($query0);


	if ($ex0) {
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>Records have been updated !<div>';
	} else {
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>Records have not been updated !<div>';
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
