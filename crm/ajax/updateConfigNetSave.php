<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

$user_name = $_SESSION['user_name'];

require_once '../classes/dbClass.php';
$db = new db_functions(); 

include_once '../classes/systemPackageClass.php';
$ajax_package_fn = new package_functions();


include_once '../classes/messageClass.php';
$message_functions=new message_functions($ajax_package_fn->getPackage($user_name));

include_once '../classes/logClass.php';
$create_log=new logs('updateConfigNetSave',$user_name);


	$network_profile = $_GET['network_profile'];
	$network_profile = htmlentities( urldecode($network_profile), ENT_QUOTES, 'utf-8' );

	$network_name = $_GET['network_name'];
	$network_name = htmlentities( urldecode($network_name), ENT_QUOTES, 'utf-8' );

	$verify_with_redirection = $_GET['verify_with_redirection'];
	$verify_with_redirection = htmlentities( urldecode($verify_with_redirection), ENT_QUOTES, 'utf-8' );
	
	$mac_exists_return_flow = $_GET['mac_exists_return_flow'];
	$mac_exists_return_flow = htmlentities( urldecode($mac_exists_return_flow), ENT_QUOTES, 'utf-8' );
	
	$red_group = $_GET['red_group'];
	$red_group = htmlentities( urldecode($red_group), ENT_QUOTES, 'utf-8' );
	
	$redirect_method = $_GET['redirect_method'];
	$redirect_method = htmlentities( urldecode($redirect_method), ENT_QUOTES, 'utf-8' );
	
	$mac_parameter = $_GET['mac_parameter'];
	$mac_parameter = htmlentities( urldecode($mac_parameter), ENT_QUOTES, 'utf-8' );
	
	$ap_parameter = $_GET['ap_parameter'];
	$ap_parameter = htmlentities( urldecode($ap_parameter), ENT_QUOTES, 'utf-8' );
	
	$ssid_parameter = $_GET['ssid_parameter'];
	$ssid_parameter = htmlentities( urldecode($ssid_parameter), ENT_QUOTES, 'utf-8' );
	
	$ip_parameter = $_GET['ip_parameter'];
	$ip_parameter = htmlentities( urldecode($ip_parameter), ENT_QUOTES, 'utf-8' );
	
	$loc_string_parameter = $_GET['loc_string_parameter'];
	$loc_string_parameter = htmlentities( urldecode($loc_string_parameter), ENT_QUOTES, 'utf-8' );
	
	$network_ses_parameter = $_GET['network_ses_parameter'];
	$network_ses_parameter = htmlentities( urldecode($network_ses_parameter), ENT_QUOTES, 'utf-8' );
	
	$ses_creation_method = $_GET['ses_creation_method'];
	$ses_creation_method = htmlentities( urldecode($ses_creation_method), ENT_QUOTES, 'utf-8' );
	
	$ses_base_url = urldecode($_GET['ses_base_url']);
	$ses_base_url = htmlentities( urldecode($ses_base_url), ENT_QUOTES, 'utf-8' );
	
	$ses_deny_url = $_GET['ses_deny_url'];
	$ses_deny_url = htmlentities( urldecode($ses_deny_url), ENT_QUOTES, 'utf-8' );
	
	$ses_new_user_name = $_GET['ses_new_user_name'];
	$ses_new_user_name = htmlentities( urldecode($ses_new_user_name), ENT_QUOTES, 'utf-8' );
	
	$ses_new_password = $_GET['ses_new_password'];
	$ses_new_password = htmlentities( urldecode($ses_new_password), ENT_QUOTES, 'utf-8' );
	
	$ses_full_username = $_GET['ses_full_username'];
	$ses_full_username = htmlentities( urldecode($ses_full_username), ENT_QUOTES, 'utf-8' );
	
	$ses_full_password = $_GET['ses_full_password'];
	$ses_full_password = htmlentities( urldecode($ses_full_password), ENT_QUOTES, 'utf-8' );
	
	$ses_creation_wating_time = $_GET['ses_creation_wating_time'];
	$ses_creation_wating_time = htmlentities( urldecode($ses_creation_wating_time), ENT_QUOTES, 'utf-8' );
	
	$ses_username_sufix = $_GET['ses_username_sufix'];
	$ses_username_sufix = htmlentities( urldecode($ses_username_sufix), ENT_QUOTES, 'utf-8' );
	

	$temp_account_timegap = $_GET['temp_account_timegap'];
	$temp_account_timegap = htmlentities( urldecode($temp_account_timegap), ENT_QUOTES, 'utf-8' );
	
	$temp_account_creation = $_GET['temp_account_creation'];
	$temp_account_creation = htmlentities( urldecode($temp_account_creation), ENT_QUOTES, 'utf-8' );
	
	$other_parameters = $_GET['other_parameters'];
	$other_parameters = htmlentities( urldecode($other_parameters), ENT_QUOTES, 'utf-8' );
	
	
	$temp_session_creation = $_GET['temp_session_creation'];
	$temp_session_creation = htmlentities( urldecode($temp_session_creation), ENT_QUOTES, 'utf-8' );
	
	$full_session_creation = $_GET['full_session_creation'];
	$full_session_creation = htmlentities( urldecode($full_session_creation), ENT_QUOTES, 'utf-8' );
	
	$with_session_creation = $_GET['with_session_creation'];
	$with_session_creation = htmlentities( urldecode($with_session_creation), ENT_QUOTES, 'utf-8' );
	
	$return_user_session_creation = $_GET['return_user_session_creation'];
	$return_user_session_creation = htmlentities( urldecode($return_user_session_creation), ENT_QUOTES, 'utf-8' );
	
	
	$ses_logout = $_GET['ses_logout'];
	$ses_logout = htmlentities( urldecode($ses_logout), ENT_QUOTES, 'utf-8' );
	
	$ses_logout_url = $_GET['ses_logout_url'];
	$ses_logout_url = htmlentities( urldecode($ses_logout_url), ENT_QUOTES, 'utf-8' );
	
	$api_network_auth_method = $_GET['api_network_auth_method'];
	$api_network_auth_method = htmlentities( urldecode($api_network_auth_method), ENT_QUOTES, 'utf-8' );
	
	$api_login = $_GET['api_login'];
	$api_login = htmlentities( urldecode($api_login), ENT_QUOTES, 'utf-8' );
	
	$api_password = $_GET['api_password'];
	$api_password = htmlentities( urldecode($api_password), ENT_QUOTES, 'utf-8' );
	
	$api_base_url = $_GET['api_base_url'];
	$api_base_url = htmlentities( urldecode($api_base_url), ENT_QUOTES, 'utf-8' );
	
	$api_time_zone = $_GET['api_time_zone'];
	$api_time_zone = htmlentities( urldecode($api_time_zone), ENT_QUOTES, 'utf-8' );
	
	$api_acc_org = $_GET['api_acc_org'];
	$api_acc_org = htmlentities( urldecode($api_acc_org), ENT_QUOTES, 'utf-8' );
	
	$api_acc_profile = $_GET['api_acc_profile'];
	$api_acc_profile = htmlentities( urldecode($api_acc_profile), ENT_QUOTES, 'utf-8' );
	
	$api_mater_timegap = $_GET['api_mater_timegap'];
	$api_mater_timegap = htmlentities( urldecode($api_mater_timegap), ENT_QUOTES, 'utf-8' );
	
	$api_master_acc_type = $_GET['api_master_acc_type'];
	$api_master_acc_type = htmlentities( urldecode($api_master_acc_type), ENT_QUOTES, 'utf-8' );
	
	$api_master_acces_type = $_GET['api_master_acces_type'];
	$api_master_acces_type = htmlentities( urldecode($api_master_acces_type), ENT_QUOTES, 'utf-8' );
	
	$api_master_service_profile = $_GET['api_master_service_profile'];
	$api_master_service_profile = htmlentities( urldecode($api_master_service_profile), ENT_QUOTES, 'utf-8' );
	
	$api_master_concurrent_login = $_GET['api_master_concurrent_login'];
	$api_master_concurrent_login = htmlentities( urldecode($api_master_concurrent_login), ENT_QUOTES, 'utf-8' );
	
	$api_sub_timegap = $_GET['api_sub_timegap'];
	$api_sub_timegap = htmlentities( urldecode($api_sub_timegap), ENT_QUOTES, 'utf-8' );
	
	$purge_delay_time = $_GET['purge_delay_time'];
	$purge_delay_time = htmlentities( urldecode($purge_delay_time), ENT_QUOTES, 'utf-8' );
	
	$api_sub_acc_type = $_GET['api_sub_acc_type'];
	$api_sub_acc_type = htmlentities( urldecode($api_sub_acc_type), ENT_QUOTES, 'utf-8' );
	
	$api_sub_acces_type = $_GET['api_sub_acces_type'];
	$api_sub_acces_type = htmlentities( urldecode($api_sub_acces_type), ENT_QUOTES, 'utf-8' );
	
	$api_sub_service_profile = $_GET['api_sub_service_profile'];
	$api_sub_service_profile = htmlentities( urldecode($api_sub_service_profile), ENT_QUOTES, 'utf-8' );
	
	$api_sub_concurrent_login = $_GET['api_sub_concurrent_login'];
	$api_sub_concurrent_login = htmlentities( urldecode($api_sub_concurrent_login), ENT_QUOTES, 'utf-8' );
	
	$post_url_method = $_GET['post_url_method'];
	$post_url_method = htmlentities( urldecode($post_url_method), ENT_QUOTES, 'utf-8' );
	
	$post_url = $_GET['post_url'];
	$post_url = htmlentities( urldecode($post_url), ENT_QUOTES, 'utf-8' );
	
	$fieldslist = $_GET['fieldslist'];
	$fieldslist = htmlentities( urldecode($fieldslist), ENT_QUOTES, 'utf-8' );

	$api_base_url_new = $_GET['api_base_url_new'];
	$api_base_url_new = htmlentities( urldecode($api_base_url_new), ENT_QUOTES, 'utf-8' );

	$vm_api_username = $_GET['vm_api_username'];
	$vm_api_username = htmlentities( urldecode($vm_api_username), ENT_QUOTES, 'utf-8' );

	$vm_api_password = $_GET['vm_api_password'];
	$vm_api_password = htmlentities( urldecode($vm_api_password), ENT_QUOTES, 'utf-8' );

	$aaa_root_zone = $_GET['aaa_root_zone'];
	$aaa_root_zone = htmlentities( urldecode($aaa_root_zone), ENT_QUOTES, 'utf-8' );
	
	/// get original theme fiedls list
	
	$q_select = sprintf("SELECT fields_json,`aaa_data` FROM `exp_network_profile` WHERE `network_profile` = '%s'", $fieldslist);
	$r_select = $db->selectDB($q_select);
	foreach ($r_select['data'] as $rrr) {
		$fieldslist_submit = $rrr['fields_json'];
		$aaa_data_j = $rrr['aaa_data'];
	}

	if(strlen($aaa_root_zone)>0){
		include '../src/AAA/'.$api_network_auth_method.'/index.php';
		$aaa_root_zone_id = '';
		$aaa_group_name = '';
		$aaa_root_group_id = '';
		$aaa = new aaa($fieldslist,'ADMIN');
		$zoneRes = json_decode($aaa->getAllZones(),true);
		if($zoneRes['status']=='success'){
			foreach ($zoneRes['Description'] as $value) {
				if($value['Name']==$aaa_root_zone){
					$aaa_root_zone_id = $value['Id'];
				}
			}
		}

		$groupRes = json_decode($aaa->getAllGroupsNew(),true);
		if($groupRes['status']=='success'){
			foreach ($groupRes['Description'] as $value) {
				if($value['Id']==$aaa_root_zone_id){
					$aaa_group_name = $value['Name'];
					$aaa_root_group_id = $value['Id'];
				}
			}
		}
	}
	
	$aaa_data=json_decode($aaa_data_j,true);
	$aaa_data['aaa_root_zone']=$aaa_root_zone;
	$aaa_data['aaa_root_zone_id']=$aaa_root_zone_id;
	$aaa_data['aaa_root_group_name']=$aaa_group_name;
   	$aaa_data['aaa_root_group_id']=$aaa_root_group_id;
   	$aaa_data_json=json_encode($aaa_data);
  

	//$query="UPDATE `exp_network_profile` SET `ses_base_url`='$api_base_url' WHERE network_profile='$fieldslist'";

	
	$query = sprintf("REPLACE INTO exp_network_profile(
	`network_name`,
	`network_profile`,
	`verify_with_redirection`,
	`mac_exists_return_flow`,
	`group_parameter`,
	`redirect_method`,
	`mac_parameter`,
	`ap_parameter`,
	`ssid_parameter`,
	`ip_parameter`,
	`loc_string_parameter`,
	`network_ses_parameter`,
	temp_account_timegap,
	temp_account_creation,
	temp_session_creation,
	full_session_creation,
	return_user_session_creation,
	session_after_account_creation,
	other_parameters,
	`ses_creation_method`,
	`ses_base_url`,
	`ses_deny_url`,
	`ses_new_user_name`,
	`ses_new_password`,
	`ses_full_username`,
	`ses_full_password`,
	`ses_username_sufix`,
	`ses_creation_wating_time`,
	`ses_logout`,
	`ses_logout_url`,
	`api_network_auth_method`,
	`api_login`,
	`api_password`,
	`api_base_url`,
	`api_time_zone`,
	`api_acc_org`,
	`api_acc_profile`,
	`api_mater_timegap`,
	`api_master_acc_type`,
	`api_master_acces_type`,
	`api_master_service_profile`,
	`api_master_concurrent_login`,
	`api_sub_timegap`,
	`purge_delay_time`,
	`api_sub_acc_type`,
	`api_sub_acces_type`,
	`api_sub_service_profile`,
	`api_sub_concurrent_login`,
	`post_url_method`,
	`post_url`,
	`fields_json`,
	`api_base_url_new`,
	`vm_api_username`,
	`vm_api_password`,
	`aaa_data`
	)
	VALUES('%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s',
	'%s')", $network_name, 
	$fieldslist,
	$verify_with_redirection,
	$mac_exists_return_flow,
	$red_group,
	$redirect_method,
	$mac_parameter,
	$ap_parameter,
	$ssid_parameter,
	$ip_parameter,
	$loc_string_parameter,
	$network_ses_parameter,
	$temp_account_timegap,
	$temp_account_creation,
	$temp_session_creation,
	$full_session_creation,
	$return_user_session_creation,
	$with_session_creation,
	$other_parameters,
	$ses_creation_method,
	$ses_base_url,
	$ses_deny_url,
	$ses_new_user_name,
	$ses_new_password,
	$ses_full_username,
	$ses_full_password,
	$ses_username_sufix,
	$ses_creation_wating_time,
	$ses_logout,
	$ses_logout_url,
	$api_network_auth_method,
	$api_login,
	$api_password,
	$api_base_url,
	$api_time_zone,
	$api_acc_org,
	$api_acc_profile,
	$api_mater_timegap,
	$api_master_acc_type,
	$api_master_acces_type,
	$api_master_service_profile,
	$api_master_concurrent_login,
	$api_sub_timegap,
	$purge_delay_time,
	$api_sub_acc_type,
	$api_sub_acces_type,
	$api_sub_service_profile,
	$api_sub_concurrent_login,
	$post_url_method,
	$post_url,
	$fieldslist_submit,
	$api_base_url_new,
	$vm_api_username,
	$vm_api_password,
	$aaa_data_json
	 );

		 $result = $db->execDB($query);

		if ($result===true) {
            $show_msg=$message_functions->showMessage('api_network_profile_update_succe');
            $create_log->save('3001',$show_msg,"");
			echo $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_msg . "</strong></div>";
		 } else {
            $show_msg=$message_functions->showMessage('api_network_profile_update_faile','2001');
            $create_log->save('2001',$show_msg,$query);
		 	echo $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_msg . "</strong></div>";
		 }
		 


?>