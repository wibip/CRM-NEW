
<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'header_top.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

require_once 'classes/CommonFunctions.php';
?> 
<head>
<meta charset="utf-8">
<title>Operations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!--Alert message css--> 
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<!--    <link rel="stylesheet" href="css/bootstrapValidator.css"/> -->
<link rel="stylesheet" type="text/css" href="css/formValidation.css">
<link rel="stylesheet" href="css/tablesaw.css?v1.0">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/locationpicker.jquery.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--table colimn show hide-->
<script type="text/javascript" src="js/tablesaw.js"></script>
<script type="text/javascript" src="js/tablesaw-init.js"></script>
<!--table colimn show hide-->
 <!--Encryption -->
<script type="text/javascript" src="js/aes.js"></script>
<script type="text/javascript" src="js/aes-json-format.js"></script>


<?php
include 'header.php';

// TAB Organization
if (isset($_GET['t'])) {
    $variable_tab = 'tab' . $_GET['t'];
    $$variable_tab = 'set';
} else {
    $tab8 = "set";
}

require_once './classes/systemPackageClass.php';
$package_functions = new package_functions();
//load countries
$country_sql="SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
                            UNION ALL
                            SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b";
$country_result = $db->selectDB($country_sql);
//load country states
$regions_sql="SELECT `states_code`, `description` FROM `exp_country_states` ORDER BY description";
$get_regions = $db->selectDB($regions_sql);
$s_a = '';
$s_a_val = '';
foreach ($get_regions['data'] as $state) {
    $s_a .= $state['description'].'|';
    $s_a_val .= $state['states_code'].'|';
}

$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);

$key_query2 = "SELECT settings_value FROM exp_settings WHERE settings_code = 'service_account_form' LIMIT 1";
$query_result2 = $db->select1DB($key_query2);
$mno_form_type = $query_result2['settings_value'];

if (isset($_POST['create_operation_submit'])) {//5


        $create_location_btn_action = $_POST['btn_action'];


        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {

                $update_id = $_POST['update_id'];
                $provisioning_data = json_decode($db->getValueAsf("SELECT property_details as f FROM exp_provisioning_properties WHERE id='$update_id'"),true);
                $parent_code = $_POST['business_id'];
                $parent_ac_name = $_POST['business_name'];
                $service_type = $_POST['service_type'];


                $provisioning_setting = json_decode($db->getValueAsf("SELECT setting as f FROM exp_provisioning_setting WHERE id='$service_type'"),true);
                $user_type1 = 'MVNO';

                $icomme_number = $_POST['icomme'];

                //  exit();/// need create vtenant icomme

                $customer_type = trim($provisioning_setting['mvno_package']);
                $parent_package = $provisioning_setting['parent_package'];
                $guest_wlan_count = trim($provisioning_data['network_info']['Guest']['count']);
                $pvt_wlan_count = trim($provisioning_data['network_info']['Private']['count']);
                $gateway_type = trim($provisioning_setting['guest_gateway_type']);
                $pr_gateway_type = trim($provisioning_setting['private_gateway_type']);
                $business_type = 'MVNO';
                $location_name_old = trim($_POST['location_name_old']);
                $dpsk_conroller = trim($provisioning_setting['admin_features']['controller']);
                $dpsk_policies = trim($provisioning_setting['admin_features']['policie']);
                $network_type = $provisioning_setting['package_type'];

                 $category_mvnx = $_POST['category_mvnx'];

                $dpsk_voucher = $db->escapeDB(trim($_POST['dpsk_voucher']));
                $mno_first_name = $db->escapeDB(trim($_POST['mno_first_name']));
                $mno_last_name = $db->escapeDB(trim($_POST['mno_last_name']));
                $mvnx_full_name = $mno_first_name . ' ' . $mno_last_name;
                $mvnx_email = trim($_POST['client_email']);
                $mvnx_address_1 = $db->escapeDB(trim($_POST['client_address_1']));
                $mvnx_address_2 = $db->escapeDB(trim($_POST['client_address_2']));
                $mvnx_address_3 = $db->escapeDB(trim($_POST['client_address_3']));
                $mvnx_mobile_1 = $db->escapeDB(trim($_POST['client_mobile_1']));
                $mvnx_mobile_2 = $db->escapeDB(trim($_POST['client_mobile_2']));
                $mvnx_mobile_3 = $db->escapeDB(trim($_POST['client_mobile_3']));
                $mvnx_country = $db->escapeDB(trim($_POST['client_country']));
                $mvnx_state = $db->escapeDB(trim($_POST['client_state']));
                $mvnx_zip_code = trim($_POST['client_zip_code']);
                $mvnx_time_zone = $_POST['client_time_zone'];
                
                $dtz = new DateTimeZone($mvnx_time_zone);

                $time_in_sofia = new DateTime('now', $dtz);
                $offset = $dtz->getOffset($time_in_sofia) / 3600;

                $timezone_abbreviation = $time_in_sofia->format('T');
                // get first 4 characters
                $timezone_abbreviation = substr($timezone_abbreviation, 0, 4);


                $offset1 = $dtz->getOffset($time_in_sofia);
                $offset_val = CommonFunctions::formatOffset($offset1);

                if ($offset_val == ' 00:00') {

                    $offset_val = '+00:00';
                }
                $user_type1 = 'PROVISIONING';

                if ($account_edit == '1') {
                    $update_user = "UPDATE admin_users SET verification_number='$vt_icomme_number' WHERE user_distributor='$edit_distributor_code' AND `verification_number` IS NOT NULL";
                                $db->execDB($update_user);

                    $db->execDB($update_dis);
                    $query02 = "UPDATE `admin_users`
                                        SET `user_name`='$dis_user_name',
                                            `password`=CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))),
                                            `access_role`='admin',
                                            `user_type`='$user_type1',
                                            `user_distributor`='$mvnx_id',
                                            `full_name`='',
                                            `email`='',
                                            `mobile`='',
                                            `is_enable`='1',
                                            `create_date`=NOW(),
                                            `create_user`='$user_name' WHERE `verification_number`='$icomme_number'";
                    $db->execDB($query02);
                }else{

                    $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
                    //$rowe = mysql_fetch_array($br);
                    $auto_inc = $br['Auto_increment'];

                    $mvnx_id = $user_type1 . $auto_inc;
                    $distributor_code_new=$mvnx_id;
                    $mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
                        $unique_id = '2' . $mvnx;

                        $dis_user_name = uniqid($mvnx_id);
                        $parent_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));

                    echo $query01 = "INSERT INTO `exp_mno_distributor` (`offset_val`,`verification_number`,`system_package`,`unique_id`,`distributor_code`, `distributor_name`,`bussiness_type`, `distributor_type`,`category`,num_of_ssid, `mno_id`, `parent_code`,`bussiness_address1`,`bussiness_address2`,`bussiness_address3`,`country`,`state_region`,`zip`,`phone1`,`phone2`,`phone3`,theme,site_title,time_zone,`language`,`advanced_features`,`is_enable`,`create_date`,`create_user`,`sw_controller`,`groupsid`,`default_campaign_id`,`dpsk_voucher`,`automation_enable`,`firewall_controller`,`organizations_id`,`wlan_count`)
                    VALUES ('$offset_val','$icomme_number','$customer_type','$unique_id','$mvnx_id', '$location_name', '$business_type','$user_type1','$category_mvnx','$mvnx_num_ssid', '$mno_id', '$user_distributor1','$mvnx_address_1','$mvnx_address_2','$mvnx_address_3','$mvnx_country','$mvnx_state','$mvnx_zip_code','$mvnx_mobile_1','$mvnx_mobile_2','$mvnx_mobile_3','$theme','$title','$tz','en','$advanced_features','0',now(),'$live_user_name','$sw_controller', '$groupsid','0','$dpsk_voucher','$automation_enable','$firewall_conroller','$firewall_organizations','$wlan_arr')"; 
                    $ex0 = $db->execDB($query01);

                    $query0 = "INSERT INTO `admin_users` (`user_name`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `timezone`, `is_enable`,create_user, `create_date`,`admin`)
            VALUES ('$dis_user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))), 'admin', '$user_type1', '$user_distributor', '$mvnx_full_name', '$mvnx_email', '$mvnx_mobile_1', '$mvnx_time_zone', '1','$login_user_name', NOW(), '$user_type1')";
                            $ex1 = $db->execDB($query0);
                            exit();
                }
                if ($ex1 == 1) {
                    $db->userLog($user_name, $script, 'Update Location', $location_name_s);
                                $success_msg = $message_functions->showNameMessage('property_creation_success', $location_name_s);
                                $sess_msg_id = 'msg_location_update';
                                $_SESSION[msg5] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                }else{
                    $success_msg = $message_functions->showNameMessage('property_creation_failed', $location_name_s, 2002); //"[2002] Account [" . $location_name_s . "] update failed";
                                $sess_msg_id = 'msg_location_update';
                                $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
                }
            
        }else{
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);

            
            $_SESSION['msg6'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: operations.php');
        }
    }


if (isset($_POST['submit_mno_form'])) { //6
        if (isset($_GET['mno_edit'])) {
            $edit_mno_id = $_GET['mno_edit_id'];
            $get_edit_get = 1;
            $get_mno_unque_q = "SELECT `unique_id`,`features` FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
            $get_mno_unque = $db->selectDB($get_mno_unque_q);

            foreach ($get_mno_unque['data'] as $get_mno_unque_arr) {
                $mno_unque = $get_mno_unque_arr['unique_id'];
                $featurearrold = $get_mno_unque_arr['features'];
            }
        }

        $isDynamic_q = "SELECT `access_method` FROM `admin_product_controls` WHERE `product_code`='DYNAMIC_MNO_001' AND `feature_code`='IS_DYNAMIC'";
        $isDynamic_res = $db->select1DB($isDynamic_q);
        //$isDynamic_row = mysql_fetch_assoc($isDynamic_res);
        $isDynamic = $isDynamic_res['access_method'];

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret6']) { //refresh validate
            $mno_account_name = $db->escapeDB(trim($_POST['mno_account_name']));
            $mno_user_type = trim($_POST['mno_user_type']);
            $mno_sys_package = trim($_POST['mno_sys_package']);
            $mnoAccType=$mno_user_type;
            $mno_user_type = 'MNO';
        
            $mno_system_package = $mno_sys_package;

            if ($user_type != 'SALES') { //advanced_menu
                    //$mno_customer_type = trim($_POST['mno_customer_type']);
                    $mno_first_name = $db->escapeDB(trim($_POST['mno_first_name']));
                    $mno_last_name = $db->escapeDB(trim($_POST['mno_last_name']));
                    $mno_full_name = $mno_first_name . ' ' . $mno_last_name;
                    $mno_email = trim($_POST['mno_email']);
                    $mno_address_1 = $db->escapeDB(trim($_POST['mno_address_1']));
                    $mno_address_2 = $db->escapeDB(trim($_POST['mno_address_2']));
                    $mno_address_3 = $db->escapeDB(trim($_POST['mno_address_3']));
                    $mno_mobile_1 = $db->escapeDB(trim($_POST['mno_mobile_1']));
                    $mno_mobile_2 = $db->escapeDB(trim($_POST['mno_mobile_2']));
                    $mno_mobile_3 = $db->escapeDB(trim($_POST['mno_mobile_3']));
                    $mno_country = trim($_POST['mno_country']);
                    $mno_state = $db->escapeDB(trim($_POST['mno_state']));
                    $mno_zip_code = trim($_POST['mno_zip_code']);
                    $mno_time_zone = $_POST['mno_time_zone'];
                    $dtz = new DateTimeZone($mno_time_zone);
                    $time_in_sofia = new DateTime('now', $dtz);
                    $offset = $dtz->getOffset($time_in_sofia) / 3600;
                    $time_offset = ($offset < 0 ? $offset : "+" . $offset);

                    $featurearr = $_POST['api_profile'];
                    if (in_array('VTENANT_MODULE', $featurearr)) {
                        $vtenant_module = 'Vtenant';
                    } else {
                        $vtenant_module = '';
                    }

                    $feature_json = $db->escapeDB(json_encode($featurearr));
               
                $login_user_name = $_SESSION['user_name'];

                $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno'");
                // var_dump($br);die;
                //$rowe = mysql_fetch_array($br);
                $auto_inc = $br['Auto_increment'];
                $mno_id = "MNO" . $auto_inc;
                $u_id = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
                $unique_id = '1' . $u_id;

                $new_user_name = str_replace(' ', '_', strtolower(substr($mno_full_name, 0, 5) . 'm' . $auto_inc));
                $password = CommonFunctions::randomPassword();

                $dynamic_id = substr(md5(uniqid(rand(), true)), 0, 20);
                $dynamic_product_id = implode('-', str_split($dynamic_id, 5));
                $dynamic_product_id = 'dy-' . $dynamic_product_id;

                $dynamic_id2 = substr(md5(uniqid(rand(), true)), 0, 20);
                $dynamic_mvno_id = implode('-', str_split($dynamic_id2, 5));
                $dynamic_mvno_id = 'dy-' . $dynamic_mvno_id;

                $dynamic_id3 = substr(md5(uniqid(rand(), true)), 0, 20);
                $dynamic_admin_id = implode('-', str_split($dynamic_id3, 5));
                $dynamic_admin_id = 'dy-' . $dynamic_admin_id;

                $automation_on = $package_functions->getSectionType('NETWORK_AUTOMATION', $mno_sys_package);
                
                $camphaign_id = 0;
                
                if ($get_edit_get == 1) {
                    if ($wag_ap_name == 'NO_PROFILE') {
                        //API not call//
                        $status_code = '200';
                    } else {

                        $status_code = '200';
                    }
                } else {
                    if ($wag_ap_name == 'NO_PROFILE') {
                        //API not call//
                        $status_code = '200';
                    } else {

                        $status_code = '200';
                    }
                }

                if ($status_code == '200') { //1
                    ////////////MNO Default theme insert///////////////////////////////////
                    if ($get_edit_get == 1) {
                        //*************************UPDATE********************************************
                        if ($mno_form_type == 'advanced_menu') { //advanced_menu
                            $query0 = "UPDATE `exp_mno`
                                        SET
                                        `api_prefix`=$mno_api_prefix,
                                        `mno_description`='$mno_account_name',
                                        `ap_controller_name`='$Ap_controller',
                                        `mno_type`='$mnoAccType',
                                        `bussiness_address1`='$mno_address_1',
                                        `bussiness_address2`='$mno_address_2',
                                        `bussiness_address3`='$mno_address_3',
                                        `features`='$feature_json',
                                        `country`='$mno_country',
                                        `state_region`='$mno_state',
                                        `zip`='$mno_zip_code',
                                        `phone1`='$mno_mobile_1',
                                        `phone2`='$mno_mobile_2',
                                        `phone3`='$mno_mobile_3',
                                        `timezones`='$mno_time_zone',
                                        `aaa_data`='$aaa_data_op'
                                        WHERE `mno_id`='$edit_mno_id'";

                            $query1 = "UPDATE
                                        `admin_users`
                                        SET
                                        `full_name` = '$mno_full_name',
                                        `email` = '$mno_email',
                                        `mobile` = '$mno_mobile_1',
                                        `timezone` = '$mno_time_zone'
                                        WHERE `user_distributor` = '$edit_mno_id' AND user_type='MNO' AND access_role='admin' ORDER BY id LIMIT 1"; //AND `verification_number` IS NOT NULL

                            if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {
                                $dynamicSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$get_dynamic_product_id'";
                                $dynamicSettings_res = $db->select1DB($dynamicSettings);
                                $product_controls_custom_settings = json_decode($dynamicSettings_res['settings'], true);
                                $admin_product_id = $product_controls_custom_settings['general']['MVNO_ADMIN_PRODUCT']['options'];
                                $mvno_product_id = $product_controls_custom_settings['general']['MVNO_PRODUCTS']['options'];
                                $operator_allowed_tab = $product_controls_custom_settings['general']['ALLOWED_TAB']['options'];
                                $network_pro = $product_controls_custom_settings_default['general']['NETWORK_PROFILE']['options'][$aaa_api_type];
                                $vt_network_pro = $product_controls_custom_settings_default['general']['VTENANT_NETWORK_PROFILE']['options'][$aaa_api_type];
                                $product_controls_custom_settings['general']['NETWORK_PROFILE']['options'] = $network_pro;
                                $product_controls_custom_settings['general']['VTENANT_NETWORK_PROFILE']['options'] = $vt_network_pro;
                                $product_controls_custom_settings['general']['LOGIN_SIGN']['options'] = $mno_short_name;
                                $product_controls_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_controls_custom_settings['general']['SUPPORT_NUMBER']['options'] = $mno_support_number;
                                $product_controls_custom_settings['general']['SUPPORT_EMAIL']['options'] = $mno_support_email;
                                $product_controls_custom_settings['general']['VTENANT_MODULE']['options'] = $vtenant_module;
                                $product_controls_custom_settings['branding']['ABOUT_URL']['options'] = $mno_about_url;
                                $product_controls_custom_settings['branding']['PRIVACY_URL']['options'] = $mno_privacy_url;
                                $product_controls_custom_settings['branding']['TOC_URL']['options'] = $mno_toc_url;
                                $product_controls_custom_settings['branding']['PRIMARY_COLOR']['options'] = $mno_primary_color;
                                $product_controls_custom_settings['branding']['SECONDARY_COLOR']['options'] = $mno_secondary_color;
                                $product_controls_custom_settings['branding']['LOGO_IMAGE_URL']['options'] = $mno_logo_image_url;
                                $product_controls_custom_settings['branding']['EMAIL_IMAGE_URL']['options'] = $mno_email_image_url;
                                $product_controls_custom_settings['branding']['FAVICON_IMAGE_URL']['options'] = $mno_favicon_image_url;
                                $product_controls_custom_settings['aaa_configuration']['AAA_USERNAME']['options'] = $aaa_api_username;
                                $product_controls_custom_settings['aaa_configuration']['AAA_PASSWORD']['options'] = $aaa_api_password;
                                $product_controls_custom_settings['aaa_configuration']['AAA_TENANT']['options'] = $aaa_tenant;
                                $product_controls_custom_settings['aaa_configuration']['AAA_USERNAME_VM']['options'] = $aaa_api_username_vm;
                                $product_controls_custom_settings['aaa_configuration']['AAA_PASSWORD_VM']['options'] = $aaa_api_password_vm;
                                $product_controls_custom_settings['aaa_configuration']['AAA_SECURITY_TOKEN']['options'] = $aaa_api_acc_org;
                                $product_controls_custom_settings['aaa_configuration']['AAA_DATA']['options'] = $aaa_data;
                                $product_controls_custom_settings['aaa_configuration']['AAA_URL']['options'] = $aaa_api_url;
                                $product_controls_custom_settings['aaa_configuration']['AAA_URL2']['options'] = $aaa_api_url2;
                                $product_controls_custom_settings['aaa_configuration']['AAA_TYPE']['options'] = $aaa_api_type;
                                $product_controls_custom_settings['aaa_configuration']['AAA_PRODUCT_OWNER']['options'] = $aaa_product_owner;
                                $product_controls_custom_settings['dsf_configuration']['DSF_URL']['options'] = $dsf_api_url;
                                $product_controls_custom_settings['dsf_configuration']['DSF_USERNAME']['options'] = $dsf_api_username;
                                $product_controls_custom_settings['dsf_configuration']['DSF_PASSWORD']['options'] = $dsf_api_password;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_URL']['options'] = $abuse_api_url;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_USERNAME']['options'] = $abuse_api_username;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_PASSWORD']['options'] = $abuse_api_password;

                                //update default_mvno_admin

                                $dynamicAdminSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$admin_product_id'";
                                $dynamicAdminSettings_res = $db->select1DB($dynamicAdminSettings);
                                $product_admin_custom_settings = json_decode($dynamicAdminSettings_res['settings'], true);
                                $product_admin_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_admin_custom_settings = json_encode($product_admin_custom_settings);

                                $query6 = "UPDATE `admin_product_controls_custom` SET `settings` = '$product_admin_custom_settings' WHERE `product_id` = '$admin_product_id' ";
                                //update default_mvno_admin

                                $dynamicMvnoSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$mvno_product_id'";
                                $dynamicMvnoSettings_res = $db->select1DB($dynamicMvnoSettings);
                                //$dynamicMvnoSettings_row = mysql_fetch_assoc($dynamicMvnoSettings_res);
                                $product_mvno_custom_settings = $dynamicMvnoSettings_res['settings'];
                                if ($mnoAccType == 'Factory_Manager') {
                                $product_mvno_custom_settings_default = $db->getValueAsf("SELECT `settings` as f FROM `admin_product_controls_custom` WHERE `product_id`='factory_manager_default_mvno'");
                                }else{
                                $product_mvno_custom_settings_default = $db->getValueAsf("SELECT `settings` as f FROM `admin_product_controls_custom` WHERE `product_id`='default_mvno'");
                                }
                                //$data_json=$value['settings'];
                                $data_array = json_decode($product_mvno_custom_settings, true);
                                //print_r($product_mvno_custom_settings_default);
                                if ($edit_account == 1) {
                                    $data_array = json_decode($dynamicMvnoSettings_res, true);
                                }
                                if (in_array('CAMPAIGN_MODULE', $featurearr)) {
                                    $allowed_page = $data_array['general']['ALLOWED_PAGE']['options'];
                                    $parent_product_code = $data_array['general']['PARENT_PRODUCT_CODE']['options'];
                                    $campaign_page = json_decode($package_functions->getOptions('CAMPAIGN_MODULE', $parent_product_code), true);
                                    foreach ($campaign_page as $value) {
                                        if (!in_array($value, $allowed_page)) {
                                            array_push($allowed_page, $value);
                                        }
                                    }

                                    $data_array['general']['ALLOWED_PAGE']['options'] = $allowed_page;
                                    $data_array['general']['CAMPAIGN_OFF_ON']['options'] = 'ON';
                                    $final_array = json_encode($data_array);


                                    if (!in_array('CAMP_DEFAULT', $operator_allowed_tab)) {
                                        array_push($operator_allowed_tab, 'CAMP_DEFAULT');
                                    }
                                    //print_r($operator_allowed_tab);
                                    $product_controls_custom_settings['general']['ALLOWED_TAB']['options'] = $operator_allowed_tab;
                                } else {
                                    $operator_allowed_tab = array_diff($operator_allowed_tab, array('CAMP_DEFAULT'));
                                    $product_controls_custom_settings['general']['ALLOWED_TAB']['options'] = $operator_allowed_tab;
                                    if ($edit_account == 1) {
                                        $data_array_default = json_decode($dynamicMvnoSettings_res, true);
                                    } else {
                                        $data_array_default = json_decode($product_mvno_custom_settings_default, true);
                                    }

                                    $allowed_page = $data_array_default['general']['ALLOWED_PAGE']['options'];;

                                    $data_array['general']['ALLOWED_PAGE']['options'] = $allowed_page;
                                    $data_array['general']['CAMPAIGN_OFF_ON']['options'] = 'OFF';
                                    $final_array = json_encode($data_array);

                                    //$final_array=$product_mvno_custom_settings_default;

                                }

                                //print_r($final_array); $db->escapeDB(strtr($product_mvno_custom_settings, $settings_vars_mvno));
                                $settings_vars_mvno_new = array(
                                    '{active_template}' => $get_dynamic_product_id
                                );

                                $final_array = $db->escapeDB(strtr($final_array, $settings_vars_mvno_new));
                                $query22 = "UPDATE `admin_product_controls_custom` SET `settings` = '$final_array' WHERE `product_id` = '$mvno_product_id' ";
                                $ex_mvno = $db->execDB($query22);
                                $product_controls_custom_settings = json_encode($product_controls_custom_settings);
                                $query2 = "UPDATE `admin_product_controls_custom` SET `settings` = '$product_controls_custom_settings' WHERE `product_id` = '$get_dynamic_product_id' ";


                                //update default_mvno_admin

                                $new_theme_data = array();
                                $new_contenteditable_arr = array();
                                $new_upload_arr = array();
                                $new_mac_arr = array();
                                $new_color_arr = array();

                                $cont_value['element'] = 'welcome_txt';
                                $cont_value['value'] = 'Welcome';

                                $cont_value1['element'] = 'registration_btn';
                                $cont_value1['value'] = 'Register';

                                array_push($new_contenteditable_arr, $cont_value);
                                array_push($new_contenteditable_arr, $cont_value1);


                                $up_value['element'] = '.login_screen_logo';
                                $up_value['type'] = 'theme_img_logo';
                                $up_value['folder'] = 'logo';
                                $up_value['value'] = 'default_arris_vtenant_login.jpg';

                                $up_value1['element'] = '.login_img';
                                $up_value1['type'] = 'background';
                                $up_value1['folder'] = 'logo';
                                $up_value1['value'] = 'default_arris_vtenant_top.png';

                                $up_value2['element'] = '.index-body';
                                $up_value2['type'] = 'background';
                                $up_value2['folder'] = 'logo';
                                $up_value2['maxSize'] = '1000';
                                $up_value2['value'] = 'default_arris_vtenant_login.jpg';

                                array_push($new_upload_arr, $up_value);
                                array_push($new_upload_arr, $up_value1);
                                array_push($new_upload_arr, $up_value2);


                                $mac_value['element'] = '.contact-us-txt';
                                $mac_value['value'] = '<p style=\"text-align: center;\"><strong>Need help? Call ' . $mno_support_number . '</strong></p>';

                                array_push($new_mac_arr, $mac_value);

                                $new_theme_data['contenteditable_arr'] = $new_contenteditable_arr;
                                $new_theme_data['upload_arr'] = $new_upload_arr;
                                $new_theme_data['mce_arr'] = $new_mac_arr;
                                $new_theme_data['color_arr'] = $new_color_arr;
                                $new_theme_data = $db->escapeDB(json_encode($new_theme_data));

                                $default_campaign_id = $db->getValueAsf("SELECT `default_campaign_id` AS f FROM `exp_mno` WHERE `mno_id` = '$edit_mno_id'");

                                $query3 = "UPDATE `admin_product_controls` SET `product_code` = '$mno_short_name' WHERE `product_code` = '$prev_short_name';";

                                $get_logins_q = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code`='ALLOWED_LOGIN_PROFILES'";
                                $get_logins = $db->select1DB($get_logins_q);
                                //$logins_res = mysql_fetch_assoc($get_logins);


                                $settings_val = str_replace($prev_short_name, $mno_short_name, $get_logins['settings_value']);

                                $query5 = "UPDATE `exp_settings` SET `settings_value` = '$settings_val' WHERE `settings_code` = 'ALLOWED_LOGIN_PROFILES' ";


                                $get_up_texts_q = "SELECT `text_details`,`text_code`,`title` FROM `exp_texts` WHERE `distributor`='$edit_mno_id'";
                                $get_up_texts = $db->selectDB($get_up_texts_q);

                                $text_replace = array($mno_account_name, $mno_support_number, $mno_support_email);
                                $text_search = array($mno_account_name_prev, $mno_support_number_prev, $mno_support_email_prev);

                                foreach ($get_up_texts['data'] as $get_texts_row) {

                                    $up_text_code = $get_texts_row['text_code'];
                                    $text_details_new = str_replace($text_search, $text_replace, $get_texts_row['text_details']);
                                    $text_title_new = str_replace(ucfirst($mno_account_name_prev), ucfirst($mno_account_name), $get_texts_row['title']);

                                    $query4 = "UPDATE `exp_texts` SET `title` = '$text_title_new', `text_details` = '$text_details_new' WHERE `distributor` = '$edit_mno_id' AND `text_code` = '$up_text_code'";

                                    $update_texts = $db->execDB($query4);
                                }

                                $o_url = 'image_upload/logo/' . $image_logo_name;
                                $t_url = $base_folder . '/template/' . $get_dynamic_product_id . '/gallery/logo/default_footer.png';
                                copy($o_url, $t_url);

                                $o_url1 = 'image_upload/welcome/' . $image_favicon_name;
                                $t_url1 = $base_folder . '/template/' . $get_dynamic_product_id . '/img/DYNAMIC-favicon.ico';
                                copy($o_url1, $t_url1);
                            }
                        } else {
                            $query0 = "UPDATE `exp_mno` SET `full_name`='$mno_full_name',`email`='$mno_email',`mno_type`='$mnoAccType' WHERE `user_distributor`='$edit_mno_id' AND `access_role`='admin'";

                            $query1 = "UPDATE
                                        `admin_users`
                                        SET
                                        `full_name` = '$mno_full_name',
                                        `email` = '$mno_email',
                                        `mobile` = '$mno_mobile_1',
                                        `timezone` = '$mno_time_zone'
                                        WHERE `user_distributor` = '$edit_mno_id' ORDER BY id LIMIT 1";

                            if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {
                                $dynamicSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$get_dynamic_product_id'";
                                $dynamicSettings_res = $db->select1DB($dynamicSettings);
                                //$dynamicSettings_row = mysql_fetch_assoc($dynamicSettings_res);
                                
                                $product_controls_custom_settings = json_decode($dynamicSettings_res['settings'], true);

                                $admin_product_id = $product_controls_custom_settings['general']['MVNO_ADMIN_PRODUCT']['options'];
                                $mvno_product_id = $product_controls_custom_settings['general']['MVNO_PRODUCTS']['options'];
                                $operator_allowed_tab = $product_controls_custom_settings['general']['ALLOWED_TAB']['options'];
                                $product_controls_custom_settings['general']['LOGIN_SIGN']['options'] = $mno_short_name;
                                $product_controls_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_controls_custom_settings['general']['SUPPORT_NUMBER']['options'] = $mno_support_number;
                                $product_controls_custom_settings['general']['SUPPORT_EMAIL']['options'] = $mno_support_email;
                                $product_controls_custom_settings['general']['VTENANT_MODULE']['options'] = $vtenant_module;
                                $product_controls_custom_settings['branding']['ABOUT_URL']['options'] = $mno_about_url;
                                $product_controls_custom_settings['branding']['PRIVACY_URL']['options'] = $mno_privacy_url;
                                $product_controls_custom_settings['branding']['TOC_URL']['options'] = $mno_toc_url;
                                $product_controls_custom_settings['branding']['PRIMARY_COLOR']['options'] = $mno_primary_color;
                                $product_controls_custom_settings['branding']['SECONDARY_COLOR']['options'] = $mno_secondary_color;
                                $product_controls_custom_settings['branding']['LOGO_IMAGE_URL']['options'] = $mno_logo_image_url;
                                $product_controls_custom_settings['branding']['EMAIL_IMAGE_URL']['options'] = $mno_email_image_url;
                                $product_controls_custom_settings['branding']['FAVICON_IMAGE_URL']['options'] = $mno_favicon_image_url;
                                $product_controls_custom_settings['aaa_configuration']['AAA_USERNAME']['options'] = $aaa_api_username;
                                $product_controls_custom_settings['aaa_configuration']['AAA_PASSWORD']['options'] = $aaa_api_password;
                                $product_controls_custom_settings['aaa_configuration']['AAA_TENANT']['options'] = $aaa_tenant;
                                $product_controls_custom_settings['aaa_configuration']['AAA_PRODUCT_OWNER']['options'] = $aaa_product_owner;
                                $product_controls_custom_settings['dsf_configuration']['DSF_URL']['options'] = $dsf_api_url;
                                $product_controls_custom_settings['dsf_configuration']['DSF_USERNAME']['options'] = $dsf_api_username;
                                $product_controls_custom_settings['dsf_configuration']['DSF_PASSWORD']['options'] = $dsf_api_password;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_URL']['options'] = $abuse_api_url;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_USERNAME']['options'] = $abuse_api_username;
                                $product_controls_custom_settings['abuse_configuration']['ABUSE_PASSWORD']['options'] = $abuse_api_password;


                                $product_controls_custom_settings = json_encode($product_controls_custom_settings);

                                $query2 = "UPDATE `admin_product_controls_custom` SET `settings` = '$product_controls_custom_settings' WHERE `product_id` = '$get_dynamic_product_id' ";


                                //update default_mvno_admin

                                $dynamicAdminSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$admin_product_id'";
                                $dynamicAdminSettings_res = $db->select1DB($dynamicAdminSettings);

                                $product_admin_custom_settings = json_decode($dynamicAdminSettings_res['settings'], true);
                                $product_admin_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_admin_custom_settings = json_encode($product_admin_custom_settings);

                                
                                $query6 = "UPDATE `admin_product_controls_custom` SET `settings` = '$product_admin_custom_settings' WHERE `product_id` = '$admin_product_id' ";

                                $query7 = "UPDATE `mdu_themes` SET `login_screen_logo` = '$image_logo_name',`favcon` = '$image_favicon_name' WHERE `distributor_code` = '$edit_mno_id' AND `property_id` IS NULL;";


                                //update default_mvno_admin

                                $query3 = "UPDATE `admin_product_controls` SET `product_code` = '$mno_short_name' WHERE `product_code` = '$prev_short_name'";

                                $get_logins_q = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code`='ALLOWED_LOGIN_PROFILES'";
                                $get_logins = $db->select1DB($get_logins_q);
                                //$logins_res = mysql_fetch_assoc($get_logins);


                                $settings_val = str_replace($prev_short_name, $mno_short_name, $get_logins['settings_value']);

                                $query5 = "UPDATE `exp_settings` SET `settings_value` = '$settings_val' WHERE `settings_code` = 'ALLOWED_LOGIN_PROFILES' ";


                                $get_up_texts_q = "SELECT `text_details`,`text_code`,`title` FROM `exp_texts` WHERE `distributor`='$edit_mno_id'";
                                $get_up_texts = $db->selectDB($get_up_texts_q);

                                $text_replace = array($mno_account_name, $mno_support_number, $mno_support_email);
                                $text_search = array($mno_account_name_prev, $mno_support_number_prev, $mno_support_email_prev);


                                foreach ($get_up_texts['data'] as $get_texts_row) {

                                    $up_text_code = $get_texts_row['text_code'];
                                    $text_details_new = str_replace($text_search, $text_replace, $get_texts_row['text_details']);
                                    $text_title_new = str_replace(ucfirst($mno_account_name_prev), ucfirst($mno_account_name), $get_texts_row['title']);

                                    $query4 = "UPDATE `exp_texts` SET `title` = '$text_title_new', `text_details` = '$text_details_new' WHERE `distributor` = '$edit_mno_id' AND `text_code` = '$up_text_code'";

                                    $update_texts = $db->execDB($query4);
                                }

                                $o_url = 'image_upload/logo/' . $image_logo_name;
                                $t_url = $base_folder . '/template/' . $get_dynamic_product_id . '/gallery/logo/default_footer.png';
                                copy($o_url, $t_url);

                                $o_url1 = 'image_upload/welcome/' . $image_favicon_name;
                                $t_url1 = $base_folder . '/template/' . $get_dynamic_product_id . '/img/DYNAMIC-favicon.ico';

                                copy($o_url1, $t_url1);
                            }
                        }

                        $lastfeatures = json_decode($featurearrold, true);


                        $ex0 = $db->execDB($query0);
                        //$ex0 = '';
                        //////////////////////////////////////////////////////////////////////////////////////////////////

                        //if (strlen($ex0) == 1) {
                        if ($ex0 === true) {
                            $ex1 = $db->execDB($query1);

                            $query0_del = "DELETE FROM exp_mno_ap_controller WHERE `mno_id`='$edit_mno_id'";
                            $ex0del = $db->execDB($query0_del);

                            foreach ($_POST['AP_cont'] as $selectedOptionap) {
                                $ap = $selectedOptionap;
                                $query_01 = "INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
                                VALUES ('$edit_mno_id', '$ap', '$user_name',NOW())";
                                $ex01 = $db->execDB($query_01);
                            }

                            $get_oraganization_q = "SELECT * FROM mdu_mno_organizations WHERE `mno`='$edit_mno_id'";
                            $get_oraganization = $db->selectDB($get_oraganization_q);
                            foreach ($get_oraganization['data'] as $get_org_row) {
                                $vt_property_id_mno = $get_texts_row['property_id'];
                                $query0_org = "UPDATE `mdu_organizations` SET `mno_system_package` = '$mno_sys_package' WHERE `property_id` = '$vt_property_id_mno'";
                                $exquery0_org = $db->execDB($query0_org);
                            }


                            $query0_del = "DELETE FROM mdu_mno_organizations WHERE `mno`='$edit_mno_id'";
                            $ex0del = $db->execDB($query0_del);

                            foreach ($_POST['vt_group'] as $vtenants) {
                                $str = "INSERT INTO mdu_mno_organizations(`mno`,`property_id`,`create_user`,`create_date`) VALUES ('%s','%s','%s',NOW())";
                                $sql = sprintf($str, $edit_mno_id, $vtenants, $user_name);

                                $ex01 = $db->execDB($sql);
                            }

                            if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {
                                $ex2 = $db->execDB($query2);
                                $ex3 = $db->execDB($query3);
                                $ex5 = $db->execDB($query5);
                                $ex6 = $db->execDB($query6);
                                $ex6 = $db->execDB($query7);
                                $ex6 = $db->execDB($query7_1);
                            }

                            $_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_update_success') . "</strong></div>";
                        } else {
                            $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                            $_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_update_failed', '2001') . "</strong></div>";
                        }


                        //******************************************************************


                    } else {
                        ////////////////////////////////////////////////////////////////////////////
                        if ($mno_form_type == 'advanced_menu') { //advanced_menu
                            $query0 = "INSERT INTO `exp_mno` (
                          `mno_id`,
                          `unique_id`,
                          `mno_description`,
                          `bussiness_address1`,
                          `bussiness_address2`,
                          `bussiness_address3`,
                          `features`,
                          `country`,
                          `state_region`,
                          `zip`,
                          `phone1`,
                          `phone2`,
                          `phone3`,
                          `timezones`,
                          `is_enable`,
                          `create_date`,
                          create_user,
                          `system_package`,
                          `mno_type`,
                          `default_campaign_id`)
                        VALUES
                          ( '$mno_id',
                            '$unique_id',
                            '$mno_account_name',
                            '$mno_address_1',
                            '$mno_address_2',
                            '$mno_address_3',
                            '$feature_json',
                            '$mno_country',
                            '$mno_state',
                            '$mno_zip_code',
                            '$mno_mobile_1',
                            '$mno_mobile_2',
                            '$mno_mobile_3',
                            '$mno_time_zone',
                            '2',
                            NOW(),
                            '$login_user_name'
                            ,'$mno_system_package',
                            '$mnoAccType',
                            '$camphaign_id')";
                        } else {
                            $query0 = "INSERT INTO `exp_mno` (`system_package`,`mno_id`, `mno_description`, `zip`, `default_campaign_id`, `mno_type`, `is_enable`,create_user, `create_date`)
        VALUES ('$mno_sys_package','$mno_id', '$mno_account_name', '$mno_zip_code', '$camphaign_id', '$mnoAccType','0','$login_user_name', NOW())";
                        }
                        //echo $query0;


                        $ex0 = $db->execDB($query0);
// echo($ex0);die;
                        if ($ex0 === true) {
                            /*foreach ($featurearr as $value) {
                                $db->changeFeature(new FeatureChange($value, 'Activated', $mno_id, $user_type, ''));
                            }

                            foreach ($_POST['AP_cont'] as $selectedOptionap) {}
                            foreach ($_POST['vt_group'] as $vtgroup) {
                                $query_01 = "INSERT INTO `mdu_mno_organizations` (`mno`, `property_id`, `create_user`, `create_date`)
                VALUES ('$mno_id', '$vtgroup', '$user_name',NOW())";
                                $ex01 = $db->execDB($query_01);

                                $query0_org = "UPDATE `mdu_organizations` SET `mno_system_package` = '$mno_sys_package' WHERE `property_id` = '$vtgroup'";
                                $exquery0_org = $db->execDB($query0_org);
                            }
*/

                            $query0 = "INSERT INTO `admin_users` (`user_name`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `timezone`, `is_enable`,create_user, `create_date`,`admin`)
            VALUES ('$new_user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))), 'admin', '$mno_user_type', '$mno_id', '$mno_full_name', '$mno_email', '$mno_mobile_1', '$mno_time_zone', '2','$login_user_name', NOW(), '$user_type')";
                        //    var_dump($query0);die;
                            $ex0 = $db->execDB($query0);

                            /*
                            $to = $mno_email;
                            $from = strip_tags($db->setVal("email", $mno_id));
                            if (empty($from)) {
                                $from = strip_tags($db->setVal("email", "ADMIN"));
                            }

                            $title = $db->setVal("short_title", "ADMIN");


                            $link = $db->getSystemURL('login', $package_functions->getSectionType("LOGIN_SIGN", $mno_sys_package));

                            if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {


                                $link = $db->getSystemURL('login', $mno_short_name);
                            }

                            $email_content = $db->getEmailTemplate('MAIL', $system_package, 'ADMIN');

                            $a = $email_content[0]['text_details'];

                            $subject = $email_content[0]['title'];

                            $vars = array(

                                '{$user_full_name}' => $mno_full_name,
                                '{$short_name}' => $title,
                                '{$account_type}' => 'MNO',
                                '{$user_name}' => $new_user_name,
                                '{$password}' => $password,
                                '{$link}' => $link
                            );

                            $message_full = strtr($a, $vars);
                            //$message = mysql_escape_string($message_full);
                            $message = $db->escapeDB($message_full);

                            $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`distributor`,`user_name`,`password_re`, `create_date`)
                    VALUES ('$to', '$subject', '$message', '$mno_id', '$new_user_name','$password', now())";
                            $rrr = $db->execDB($qu);

                            $rrr1 = $db->execDB($qu1);

                            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                            include_once 'src/email/' . $email_send_method . '/index.php';

                           $cunst_var = array();
                            
                            $cunst_var['system_package'] = $mno_sys_package;
                            $cunst_var['mno_package'] = $system_package;
                            $cunst_var['mno_id'] = $mno_id;
                            $cunst_var['verticle'] = $verticle;


                            $mail_obj = new email($cunst_var);
                            $mail_obj->mno_system_package = $system_package;

                            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                            */
                            if (isset($mno_sys_package)) {

                                // echo '1';

                                $access_role_id = $mno_id . "_support";
                                $access_role_name = $mno_id . " Support";


                                if ($package_functions->getSectionType("SUPPORT_AVAILABLE", $mno_sys_package, 'MNO') == '1') {

                                    // echo '2';


                                    $query0 = "INSERT INTO `admin_access_roles` (`access_role`,`description`,`distributor`,`create_user`,`create_date`)
                    VALUES ('$access_role_id', 'Support', '$mno_id', '$user_name',now())";
                                    $result0 = $db->execDB($query0);


                                    $sys_pack = $mno_sys_package;

                                    $gt_support_optioncode = $package_functions->getOptions('SUPPORT_AVAILABLE', $sys_pack, 'MNO');

                                    $pieces1 = explode(",", $gt_support_optioncode);


                                    //print_r($pieces1);

                                    $len1 = count($pieces1);

                                    for ($i = 0; $i < $len1; $i++) {


                                        $query1 = "INSERT INTO `admin_access_roles_modules`
                        (`access_role`, `module_name`, `distributor` , `create_user`, `create_date`)
                        VALUES ('$access_role_id', '$pieces1[$i]', '$mno_id', '$user_name', now())";
                                        $result1 = $db->execDB($query1);
                                    }
                                }

                                if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {

                                    //$data_json=$value['settings'];
                                    $data_array = json_decode($product_mvno_custom_settings, true);
                                    //print_r($product_controls_custom_settings);
                                    $data_array_opt = json_decode($product_controls_custom_settings, true);
                                    $network_pro = $data_array_opt['general']['NETWORK_PROFILE']['options'][$aaa_api_type];
                                    $vt_network_pro = $data_array_opt['general']['VTENANT_NETWORK_PROFILE']['options'][$aaa_api_type];
                                    $data_array_opt['general']['NETWORK_PROFILE']['options'] = $network_pro;
                                    $data_array_opt['general']['VTENANT_NETWORK_PROFILE']['options'] = $vt_network_pro;
                                    $data_array_opt['aaa_configuration']['AAA_DATA']['options'] = $aaa_data;
                                    if ($aaa_api_type == 'ALE53') {
                                    } else {
                                    }
                                    //print_r($data_array_opt);
                                    if (in_array('CAMPAIGN_MODULE', $featurearr)) {
                                        $allowed_page = $data_array['general']['ALLOWED_PAGE']['options'];
                                        $operator_allowed_tab = $data_array_opt['general']['ALLOWED_TAB']['options'];
                                        $parent_product_code = $data_array['general']['PARENT_PRODUCT_CODE']['options'];
                                        $campaign_page = json_decode($package_functions->getOptions('CAMPAIGN_MODULE', $parent_product_code), true);
                                        foreach ($campaign_page as $value) {
                                            if (!in_array($value, $allowed_page)) {
                                                array_push($allowed_page, $value);
                                            }
                                        }

                                        if (!empty($data_array)) {
                                            $data_array['general']['ALLOWED_PAGE']['options'] = $allowed_page;
                                            $data_array['general']['CAMPAIGN_OFF_ON']['options'] = 'ON';
                                            $final_array = json_encode($data_array);
                                        } else {
                                            $final_array = $product_mvno_custom_settings;
                                        }
                                        if (!in_array('CAMP_DEFAULT', $operator_allowed_tab)) {
                                            array_push($operator_allowed_tab, 'CAMP_DEFAULT');
                                        }
                                        //print_r($operator_allowed_tab);
                                        $data_array_opt['general']['ALLOWED_TAB']['options'] = $operator_allowed_tab;
                                        
                                    } else {
                                        //$operator_allowed_tab=array_diff($operator_allowed_tab, array('CAMP_DEFAULT'));
                                        //$product_controls_custom_settings['general']['ALLOWED_TAB']['options']=$operator_allowed_tab;
                                        $final_array = $product_mvno_custom_settings;
                                    }
                                    $product_controls_custom_settings = json_encode($data_array_opt);
                                    $product_mvno_custom_settings = $final_array;
                                    $product_controls_custom_settings = $db->escapeDB($product_controls_custom_settings);

                                    $get_texts_q = "SELECT * FROM `exp_texts` WHERE `distributor`='DYNAMIC_MNO_001'";
                                    $get_texts = $db->selectDB($get_texts_q);

                                    $text_replace = array($mno_account_name, $mno_support_number, $mno_support_email);
                                    $text_search = array("[OPERATOR]", "[OPERATOR_NUMBER]", "[OPERATOR_EMAIL]");


                                    foreach ($get_texts['data'] as $get_texts_row) {

                                        $text_code_new = $get_texts_row['text_code'];

                                        $text_title_new = str_replace("[OPERATOR]", ucfirst($mno_account_name), $get_texts_row['title']);
                                        $text_veritcal_new = $get_texts_row['vertical'];
                                        $text_updated_by_new = $get_texts_row['updated_by'];

                                        $text_details_new = str_replace($text_search, $text_replace, $get_texts_row['text_details']);


                                        /*
                                        $insert_texts_q = "INSERT INTO `exp_texts` (`text_code`,`title`,`text_details`,`vertical`,`distributor`,`create_date`, `updated_by`)
                        VALUES ('$text_code_new', '$text_title_new', '$text_details_new', '$text_veritcal_new','$mno_id', now(), '$text_updated_by_new')";

                                        $insert_texts = $db->execDB($insert_texts_q);*/
                                    }

                                    $get_logins_q = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code`='ALLOWED_LOGIN_PROFILES'";
                                    $get_logins = $db->select1DB($get_logins_q);
                                    //$logins_res = mysql_fetch_assoc($get_logins);

                                    $login_sign_list = json_decode($get_logins['settings_value'], true);
                                    $login_sign_list[$mno_short_name] = "1";
                                    $settings_val = json_encode($login_sign_list);


                                    $login_q = "UPDATE `exp_settings` SET `settings_value` = '$settings_val' WHERE `settings_code` = 'ALLOWED_LOGIN_PROFILES' ";

                                    $result_login = $db->execDB($login_q);

                                    //insert into admin_product_controls_custom
                                    $adminProductControlsStatus ='1';
                                    if ($mnoAccType == 'Factory_Manager') {
                                    $adminProductControlsStatus ='2';
                                    }
                                    
                                    $query_custom1 = "INSERT INTO `admin_product_controls_custom` (`product_id`, `product_name`, `product_description` , `settings`, `status`,`create_user`,`create_date`) VALUES ('$dynamic_mvno_id', 'MVNO', 'Dynamic MVNO Profile', '$product_mvno_custom_settings','$adminProductControlsStatus','admin', now())";

                                    $result_custom1 = $db->execDB($query_custom1);


                                    $query_custom2 = "INSERT INTO `admin_product_controls_custom` (`product_id`, `product_name`, `product_description` , `settings`, `status`,`create_user`,`create_date`) VALUES ('$dynamic_admin_id', 'MVNO Admin', 'Dynamic MVNO Admin Profile', '$product_admin_custom_settings','$adminProductControlsStatus','admin', now())";

                                    $result_custom2 = $db->execDB($query_custom2);


                                    $query_custom3 = "INSERT INTO `admin_product_controls_custom` (`product_id`, `product_name`, `product_description` , `settings`, `status`,`create_user`,`create_date`) VALUES ('$dynamic_product_id', 'Operator', 'Dynamic Profile', '$product_controls_custom_settings','$adminProductControlsStatus','admin', now())";

                                    $result_custom3 = $db->execDB($query_custom3);


                                    $insert_camp_q = "INSERT INTO `admin_product_controls` (`product_code`,`discription`,`feature_code`,`type`,`user_type`, `access_method`, `options`, `create_user`, `create_date`)
                    VALUES ('$mno_short_name', 'layout description', 'CAMP_LAYOUT', 'option', 'ADMIN','DYNAMIC', '', 'admin', now())";

                                    $insert_camp = $db->execDB($insert_camp_q);

                                    $login_restrict_ar = array($dynamic_mvno_id, $dynamic_admin_id, $dynamic_product_id);
                                    $login_restrict = implode(',', $login_restrict_ar);

                                    $insert_login_q = "INSERT INTO `admin_product_controls` (`product_code`,`discription`,`feature_code`,`type`,`user_type`, `access_method`, `options`, `create_user`, `create_date`)
                    VALUES ('$mno_short_name', 'Login Restriction', 'LOGIN_RESTRICTION', 'option', 'ADMIN','', '$login_restrict', 'admin', now())";

                                    $insert_login = $db->execDB($insert_login_q);

                                    $insert_prod_q = "INSERT INTO `admin_product_controls` (`product_code`,`discription`,`feature_code`,`type`,`user_type`, `access_method`, `options`, `create_user`, `create_date`)
                    VALUES ('$mno_short_name', 'Operator product code', 'DEFAULT_PROFILE', 'option', 'ADMIN','', '$dynamic_product_id', 'admin', now())";

                                    $insert_prod = $db->execDB($insert_prod_q);


                                    $query_prod = "INSERT INTO `admin_product` (`product_name`, `discription` , `product_code`, `user_type`,`is_enable`,`create_user`,`create_date`) VALUES ('Dynamic Admin', 'Dynamic Admin', '$dynamic_admin_id', 'MVNO_ADMIN','1','admin', now())";

                                    $result_prod = $db->execDB($query_prod);


                                    $query_prod2 = "INSERT INTO `admin_product` (`product_name`, `discription` , `product_code`, `user_type`,`is_enable`,`create_user`,`create_date`) VALUES ('$mno_account_name', 'Dynamic user', '$dynamic_mvno_id', 'VENUE','1','admin', now())";

                                    $result_prod2 = $db->execDB($query_prod2);

                                    $db->createTemplate($base_folder . '/template/', $dynamic_product_id, $mno_account_name);
                                    $o_url = 'image_upload/logo/' . $image_logo_name;
                                    $t_url = $base_folder . '/template/' . $dynamic_product_id . '/gallery/logo/default_footer.png';
                                    copy($o_url, $t_url);

                                    $o_url1 = 'image_upload/welcome/' . $image_favicon_name;
                                    $t_url1 = $base_folder . '/template/' . $dynamic_product_id . '/img/DYNAMIC-favicon.ico';
                                    copy($o_url1, $t_url1);
                                }
                            }



                            ///////////////////////////////////////////////
                            $db->userLog($user_name, $script, 'Create Operator', '');

                            $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_success') . "</strong></div>";
                        } else {
                            $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                            $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_failed', '2001') . "</strong></div>";
                        }
                    }
                } //1

                else { //1
                    $db->userErrorLog('2009', $user_name, 'script - ' . $script);
                    $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_failed', '2009') . "</strong></div>";
                } //1
            } else {
                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_success') . "</strong></div>";
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);

            
            $_SESSION['msg6'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: operations.php');
        }
    }

     elseif (isset($_GET['edit_mno_id'])) {
        if ($_SESSION['FORM_SECRET'] == $_GET['token10']) {
            $edit_mno_id = $_GET['edit_mno_id'];
            $get_edit_mno_details_q = "SELECT * FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
            $mno_data = $db->select1DB($get_edit_mno_details_q);
            //        print_r($get_edit_mno_details);
            //        while($mno_data=mysql_fetch_assoc($get_edit_mno_details)){
            $get_edit_mno_id = $mno_data['id'];
            $get_edit_mno_mno_id = $mno_data['mno_id'];
            $get_edit_mno_unique_id = $mno_data['unique_id'];
            $get_edit_mno_description = $mno_data['mno_description'];
            $get_edit_mno_mno_type = $mno_data['mno_type'];
            $get_edit_mno_ad1 = $mno_data['bussiness_address1'];
            $get_edit_mno_ad2 = $mno_data['bussiness_address2'];
            $get_edit_mno_ad3 = $mno_data['bussiness_address3'];
            $get_edit_mno_country = $mno_data['country'];
            $get_edit_mno_state_region = $mno_data['state_region'];
            $get_edit_mno_zip = $mno_data['zip'];
            $get_edit_mno_phone1 = $mno_data['phone1'];
            $get_edit_mno_phone2 = $mno_data['phone2'];
            $get_edit_mno_phone3 = $mno_data['phone3'];
            $get_edit_mno_timezones = $mno_data['timezones'];
            $get_edit_mno_api_prefix = $mno_data['api_prefix'];
            //$get_edit_mno_operator_zone = $mno_data['ale_opt_zone'];
            //$get_edit_mno_operator_group = $mno_data['ale_opt_group'];
            $get_edit_mno_features = $mno_data['features'];
            $get_edit_mno_featuresar = json_decode($get_edit_mno_features, true);
            if (strlen($get_edit_mno_api_prefix) > 0) {
                $edit_mno_api_access = '1';
            } else {
                $edit_mno_api_access = '0';
            }

            $get_edit_mno_sys_pack = $mno_data['system_package'];
            $get_sys_package_arr = explode('-', $get_edit_mno_sys_pack);
            $get_sys_package_prefix = array_shift($get_sys_package_arr);

            if ($get_sys_package_prefix == 'dy') {

                $get_dynamic_product_id = $get_edit_mno_sys_pack;
                $get_edit_mno_sys_pack = 'DYNAMIC_MNO_001';
                $get_edit_dynamic_details_q = "SELECT * FROM `admin_product_controls_custom` WHERE `product_id`='$get_dynamic_product_id' LIMIT 1";
                $mno_dynamic_data = $db->select1DB($get_edit_dynamic_details_q);

                $custom_settings = json_decode($mno_dynamic_data['settings'], true);


                $get_mno_short_name = $custom_settings['general']['LOGIN_SIGN']['options'];
                $get_mno_about_url = $custom_settings['branding']['ABOUT_URL']['options'];
                $get_mno_privacy_url = $custom_settings['branding']['PRIVACY_URL']['options'];
                $get_mno_toc_url = $custom_settings['branding']['TOC_URL']['options'];
                $get_mno_primary_color = $custom_settings['branding']['PRIMARY_COLOR']['options'];
                $get_mno_secondary_color = $custom_settings['branding']['SECONDARY_COLOR']['options'];
                $get_mno_support_number = $custom_settings['general']['SUPPORT_NUMBER']['options'];
                $get_mno_support_email = $custom_settings['general']['SUPPORT_EMAIL']['options'];
                $get_aaa_api_username = $custom_settings['aaa_configuration']['AAA_USERNAME']['options'];
                $get_aaa_api_password = $custom_settings['aaa_configuration']['AAA_PASSWORD']['options'];
                $get_aaa_tenant = $custom_settings['aaa_configuration']['AAA_TENANT']['options'];
                $get_api_acc_org = $custom_settings['aaa_configuration']['AAA_SECURITY_TOKEN']['options'];
                $get_vm_aaa_api_username = $custom_settings['aaa_configuration']['AAA_USERNAME_VM']['options'];
                $get_vm_aaa_api_password = $custom_settings['aaa_configuration']['AAA_PASSWORD_VM']['options'];
                $get_aaa_data = $custom_settings['aaa_configuration']['AAA_DATA']['options'];
                $get_api_root_zone_name = $get_aaa_data['aaa_root_zone'];
                $get_aaa_api_url = $custom_settings['aaa_configuration']['AAA_URL']['options'];
                $get_vm_aaa_api_url = $custom_settings['aaa_configuration']['AAA_URL2']['options'];
                $get_aaa_api_type = $custom_settings['aaa_configuration']['AAA_TYPE']['options'];
                $get_aaa_product_owner = $custom_settings['aaa_configuration']['AAA_PRODUCT_OWNER']['options'];
                $get_dsf_api_url = $custom_settings['dsf_configuration']['DSF_URL']['options'];
                $get_dsf_api_username = $custom_settings['dsf_configuration']['DSF_USERNAME']['options'];
                $get_dsf_api_password = $custom_settings['dsf_configuration']['DSF_PASSWORD']['options'];
                $get_abuse_api_url = $custom_settings['abuse_configuration']['ABUSE_URL']['options'];
                $get_abuse_api_username = $custom_settings['abuse_configuration']['ABUSE_USERNAME']['options'];
                $get_abuse_api_password = $custom_settings['abuse_configuration']['ABUSE_PASSWORD']['options'];


                $get_image_logo_url = $custom_settings['branding']['LOGO_IMAGE_URL']['options'];
                $get_logo_name = explode("/", $get_image_logo_url);
                $get_logo_name = end($get_logo_name);

                $get_image_email_url = $custom_settings['branding']['EMAIL_IMAGE_URL']['options'];
                $get_email_name = explode("/", $get_image_email_url);
                $get_email_name = end($get_email_name);

                $get_image_favicon_url = $custom_settings['branding']['FAVICON_IMAGE_URL']['options'];
                $get_favicon_name = explode("/", $get_image_favicon_url);
                $get_favicon_name = end($get_favicon_name);
            }

            //}
            if ($user_type != 'SALES') {
                $get_edit_mno_details_q = "SELECT `full_name`,`email`,`user_type`,`mobile` FROM `admin_users` WHERE `user_distributor`='$edit_mno_id' AND `access_role`='admin' LIMIT 1";
                $mno_data = $db->select1DB($get_edit_mno_details_q);
                //while($mno_data=mysql_fetch_assoc($get_edit_mno_details)){
                $get_edit_mno_fulname = $mno_data['full_name'];
                $get_edit_mno_user_type = $mno_data['user_type'];
                $get_ful_name_array = explode(' ', $get_edit_mno_fulname, 2);
                $get_edit_mno_first_name = $get_ful_name_array[0];
                $get_edit_mno_last_name = $get_ful_name_array[1];
                $get_edit_mno_email = $mno_data['email'];
                $get_edit_mno_mobile = $mno_data['mobile'];

                //}

                $get_ap_controllers_q = "SELECT c.ap_controller,ap.type FROM `exp_mno_ap_controller` c LEFT JOIN exp_locations_ap_controller ap ON c.ap_controller = ap.controller_name WHERE c.mno_id='$edit_mno_id'";
                $get_ap_controllers = $db->selectDB($get_ap_controllers_q);
                $ap_controler_array = array();
                foreach ($get_ap_controllers['data'] as $get_ap_controller) {
                    array_push($ap_controler_array, array($get_ap_controller['ap_controller'], $get_ap_controller['type']));
                }

                //echo "string";
                $features_controler_array = $get_edit_mno_featuresar;
                /*foreach($get_features['data'] as $get_feature){
            array_push($features_controler_array,array($get_feature['ap_controller'],$get_feature['type']));
        }*/

                //print_r($ap_controler_array);
                $get_mno_wags_q = "SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                    WHERE w.`ap_controller`=c.`ap_controller` AND c.`mno_id`='$edit_mno_id' GROUP BY w.`wag_code`";
                $get_mno_wags_r = $db->selectDB($get_mno_wags_q);
                $edit_wag_prof_string = '';
                foreach ($get_mno_wags_r['data'] as $get_mno_wags) {
                    $edit_wag_prof_string .= $get_mno_wags[wag_name] . '
 ';
                }
                //$edit_wag_prof_string;
                $mno_edit = 1;
            } else {
            }
        } //key validation
    } //edit_mno
    elseif (isset($_GET['remove_mno_id'])) {
        // if ($_SESSION['FORM_SECRET'] == $_GET['token10']) {
            $remove_mno_id = $_GET['remove_mno_id'];
            if ($user_type != 'SALES') {
                //archive
                //*********************
                $archive_q = "INSERT INTO `exp_mno_archive` (
                      `id`,
                      `mno_id`,
                      `unique_id`,
                      `mno_description`,
                      `mno_portal_text`,
                      `logo`,
                      `top_line_color`,
                      `mno_type`,
                      `bussiness_address1`,
                      `bussiness_address2`,
                      `bussiness_address3`,
                      `country`,
                      `state_region`,
                      `zip`,
                      `phone1`,
                      `phone2`,
                      `phone3`,
                      `is_enable`,
                      `top_line_size`,
                      `favicon_image`,
                      `top_bg_pattern_image`,
                      `theme_site_title`,
                      `theme_logo`,
                      `theme_style_type`,
                      `theme_top_line_color`,
                      `theme_color`,
                      `theme_light_color`,
                      `timezones`,
                      `create_user`,
                      `create_date`,
                      `last_update`,
                      `delete_by`,
                      `delete_date`
                    )
                    SELECT
                      `id`,
                      `mno_id`,
                      `unique_id`,
                      `mno_description`,
                      `mno_portal_text`,
                      `logo`,
                      `top_line_color`,
                      `mno_type`,
                      `bussiness_address1`,
                      `bussiness_address2`,
                      `bussiness_address3`,
                      `country`,
                      `state_region`,
                      `zip`,
                      `phone1`,
                      `phone2`,
                      `phone3`,
                      `is_enable`,
                      `top_line_size`,
                      `favicon_image`,
                      `top_bg_pattern_image`,
                      `theme_site_title`,
                      `theme_logo`,
                      `theme_style_type`,
                      `theme_top_line_color`,
                      `theme_color`,
                      `theme_light_color`,
                      `timezones`,
                      `create_user`,
                      `create_date`,
                      `last_update`,
                      '$username',
                      NOW()
                    FROM
                      `exp_mno` WHERE mno_id = '$remove_mno_id'";

                    $keyquery = $db->execDB($archive_q);

                    $delete = $db->execDB("DELETE
                            FROM
                              `exp_mno`
                            WHERE `mno_id` = '$remove_mno_id'");
var_dump($delete);
                    $delete2 = $db->execDB("DELETE FROM `exp_mno_ap_controller` WHERE `mno_id`='$remove_mno_id'");
                    $delete2 = $db->execDB("DELETE FROM `admin_users` WHERE `user_distributor`='$remove_mno_id'");
                    $delete2 = $db->execDB("DELETE FROM `mdu_mno_organizations` WHERE `mno`='$remove_mno_id'");
                    $delete2_1 = $db->execDB("DELETE FROM `exp_camphaign_ads` WHERE `ad_id` = '$default_campaign_id'");

                    if ($delete === true) {
                        $db->userErrorLog('2004', $user_name, 'script - ' . $script);
                        $db->userLog($user_name, $script, 'Remove Operator', $rm_unique);
                        $create_log->save('3001', $message_functions->showNameMessage('operator_remove_success', $remove_mno_id, '3001'), '');
                        $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('operator_remove_success', $remove_mno_id) . "</strong></div>";
                    } else {
                        $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                        $create_log->save('2001', $message_functions->showMessage('operator_remove_failed', '2001'), '');
                        $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_remove_failed', '2001') . "</strong></div>";
                    }
                
            } else {
                $create_log->save('3001', $message_functions->showNameMessage('operator_remove_success', $remove_mno_id, '3001'), '');
                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('operator_remove_success', $remove_mno_id) . "</strong></div>";
            }
        // } //key validation
        // else {
        //     $db->userErrorLog('2004', $user_name, 'script - ' . $script);
        //     $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

        //     $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
        //     //header('Location: location.php?t=1');
        // }
    } //remove_mno_id

?>
<style>
#live_camp .tablesaw-columntoggle-popup .btn-group > label {
    float: left !important;
}
</style>
<script language="javascript">
  // Countries
    var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

    // States
    var s_a = new Array();
    var s_a_val = new Array();
    s_a[0] = "";
    s_a_val[0] = "";
    <?php
    $s_a = rtrim($s_a,"|");
    $s_a_val = rtrim($s_a_val,"|");

    ?>
    s_a[1] = "<?php echo $s_a; ?>";
    s_a_val[1] = "<?php echo $s_a_val; ?>";
    s_a[2] = "Others";
    s_a[3] = "Others";
    s_a[4] = "Others";
    s_a[5] = "Others";
    s_a[6] = "Others";
    s_a[7] = "Others";
    s_a[8] = "Others";
    s_a[9] = "Others";
    s_a[10] = "Others";
    s_a[11] = "Others";
    s_a[12] = "Others";
    s_a[13] = "Others";
    s_a[14] = "Others";
    s_a[15] = "Others";
    s_a[16] = "Others";
    s_a[17] = "Others";
    s_a[18] = "Others";
    s_a[19] = "Others";
    s_a[20] = "Others";
    s_a[21] = "Others";
    s_a[22] = "Others";
    s_a[23] = "Others";
    s_a[24] = "Others";
    s_a[25] = "Others";
    s_a[26] = "Others";
    s_a[27] = "Others";
    s_a[28] = "Others";
    s_a[29] = "Others";
    s_a[30] = "Others";
    s_a[31] = "Others";
    s_a[32] = "Others";
    s_a[33] = "Others";
    s_a[34] = "Others";
    s_a[35] = "Others";
    s_a[36] = "Others";
    s_a[37] = "Others";
    s_a[38] = "Others";
    s_a[39] = "Others";
    s_a[40] = "Others";
    s_a[41] = "Others";
    s_a[42] = "Others";
    s_a[43] = "Others";
    s_a[44] = "Others";
    s_a[45] = "Others";
    s_a[46] = "Others";
    s_a[47] = "Others";
    s_a[48] = "Others";
    // <!-- -->
    s_a[49] = "Others";
    s_a[50] = "Others";
    s_a[51] = "Others";
    s_a[52] = "Others";
    s_a[53] = "Others";
    s_a[54] = "Others";
    s_a[55] = "Others";
    s_a[56] = "Others";
    s_a[57] = "Others";
    s_a[58] = "Others";
    s_a[59] = "Others";
    s_a[60] = "Others";
    s_a[61] = "Others";
    s_a[62] = "Others";
    // <!-- -->
    s_a[63] = "Others";
    s_a[64] = "Others";
    s_a[65] = "Others";
    s_a[66] = "Others";
    s_a[67] = "Others";
    s_a[68] = "Others";
    s_a[69] = "Others";
    s_a[70] = "Others";
    s_a[71] = "Others";
    s_a[72] = "Others";
    s_a[73] = "Others";
    s_a[74] = "Others";
    s_a[75] = "Others";
    s_a[76] = "Others";
    s_a[77] = "Others";
    s_a[78] = "Others";
    s_a[79] = "Others";
    s_a[80] = "Others";
    s_a[81] = "Others";
    s_a[82] = "Others";
    s_a[83] = "Others";
    s_a[84] = "Others";
    s_a[85] = "Others";
    s_a[86] = "Others";
    s_a[87] = "Others";
    s_a[88] = "Others";
    s_a[89] = "Others";
    s_a[90] = "Others";
    s_a[91] = "Others";
    s_a[92] = "Others";
    s_a[93] = "Others";
    s_a[94] = "Others";
    s_a[95] = "Others";
    s_a[96] = "Others";
    s_a[97] = "Others";
    s_a[98] = "Others";
    s_a[99] = "Others";
    s_a[100] = "Others";
    s_a[101] = "Others";
    s_a[102] = "Others";
    s_a[103] = "Others";
    s_a[104] = "Others";
    s_a[105] = "Others";
    s_a[106] = "Others";
    s_a[107] = "Others";
    s_a[108] = "Others";
    s_a[109] = "Others";
    s_a[110] = "Others";
    s_a[111] = "Others";
    s_a[112] = "Others";
    s_a[113] = "Others";
    s_a[114] = "Others";
    s_a[115] = "Others";
    s_a[116] = "Others";
    s_a[117] = "Others";
    s_a[118] = "Others";
    s_a[119] = "Others";
    s_a[120] = "Others";
    s_a[121] = "Others";
    s_a[122] = "Others";
    s_a[123] = "Others";
    s_a[124] = "Others";
    s_a[125] = "Others";
    s_a[126] = "Others";
    s_a[127] = "Others";
    s_a[128] = "Others";
    s_a[129] = "Others";
    s_a[130] = "Others";
    s_a[131] = "Others";
    s_a[132] = "Others";
    s_a[133] = "Others";
    s_a[134] = "Others";
    s_a[135] = "Others";
    s_a[136] = "Others";
    s_a[137] = "Others";
    s_a[138] = "Others";
    s_a[139] = "Others";
    s_a[140] = "Others";
    s_a[141] = "Others";
    s_a[142] = "Others";
    s_a[143] = "Others";
    s_a[144] = "Others";
    s_a[145] = "Others";
    s_a[146] = "Others";
    s_a[147] = "Others";
    s_a[148] = "Others";
    s_a[149] = "Others";
    s_a[150] = "Others";
    s_a[151] = "Others";
    s_a[152] = "Others";
    s_a[153] = "Others";
    s_a[154] = "Others";
    s_a[155] = "Others";
    s_a[156] = "Others";
    s_a[157] = "Others";
    s_a[158] = "Others";
    s_a[159] = "Others";
    s_a[160] = "Others";
    s_a[161] = "Others";
    s_a[162] = "Others";
    s_a[163] = "Others";
    s_a[164] = "Others";
    s_a[165] = "Others";
    s_a[166] = "Others";
    s_a[167] = "Others";
    s_a[168] = "Others";
    s_a[169] = "Others";
    s_a[170] = "Others";
    s_a[171] = "Others";
    s_a[172] = "Others";
    s_a[173] = "Others";
    s_a[174] = "Others";
    s_a[175] = "Others";
    s_a[176] = "Others";
    s_a[177] = "Others";
    s_a[178] = "Others";
    s_a[179] = "Others";
    s_a[180] = "Others";
    s_a[181] = "Others";
    s_a[182] = "Others";
    s_a[183] = "Others";
    s_a[184] = "Others";
    s_a[185] = "Others";
    s_a[186] = "Others";
    s_a[187] = "Others";
    s_a[188] = "Others";
    s_a[189] = "Others";
    s_a[190] = "Others";
    s_a[191] = "Others";
    s_a[192] = "Others";
    s_a[193] = "Others";
    s_a[194] = "Others";
    s_a[195] = "Others";
    s_a[196] = "Others";
    s_a[197] = "Others";
    s_a[198] = "Others";
    s_a[199] = "Others";
    s_a[200] = "Others";
    s_a[201] = "Others";
    s_a[202] = "Others";
    s_a[203] = "Others";
    s_a[204] = "Others";
    s_a[205] = "Others";
    s_a[206] = "Others";
    s_a[207] = "Others";
    s_a[208] = "Others";
    s_a[209] = "Others";
    s_a[210] = "Others";
    s_a[211] = "Others";
    s_a[212] = "Others";
    s_a[213] = "Others";
    s_a[214] = "Others";
    s_a[215] = "Others";
    s_a[216] = "Others";
    s_a[217] = "Others";
    s_a[218] = "Others";
    s_a[219] = "Others";
    s_a[220] = "Others";
    s_a[221] = "Others";
    s_a[222] = "Others";
    s_a[223] = "Others";
    s_a[224] = "Others";
    s_a[225] = "Others";
    s_a[226] = "Others";
    s_a[227] = "Others";
    s_a[228] = "Others";
    s_a[229] = "Others";
    s_a[230] = "Others";
    s_a[231] = "Others";
    s_a[232] = "Others";
    s_a[233] = "Others";
    s_a[234] = "Others";
    s_a[235] = "Others";
    s_a[236] = "Others";
    s_a[237] = "Others";
    s_a[238] = "Others";
    s_a[239] = "Others";
    s_a[240] = "Others";
    s_a[241] = "Others";
    s_a[242] = "Others";
    s_a[243] = "Others";
    s_a[244] = "Others";
    s_a[245] = "Others";
    s_a[246] = "Others";
    s_a[247] = "Others";
    s_a[248] = "Others";
    s_a[249] = "Others";
    s_a[250] = "Others";
    s_a[251] = "Others";
    s_a[252] = "Others";
    
    s_a_val[2] = "N/A";
    s_a_val[3] = "N/A";
    s_a_val[4] = "N/A";
    s_a_val[5] = "N/A";
    s_a_val[6] = "N/A";
    s_a_val[7] = "N/A";
    s_a_val[8] = "N/A";
    s_a_val[9] = "N/A";
    s_a_val[10] = "N/A";
    s_a_val[11] = "N/A";
    s_a_val[12] = "N/A";
    s_a_val[13] = "N/A";
    s_a_val[14] = "N/A";
    s_a_val[15] = "N/A";
    s_a_val[16] = "N/A";
    s_a_val[17] = "N/A";
    s_a_val[18] = "N/A";
    s_a_val[19] = "N/A";
    s_a_val[20] = "N/A";
    s_a_val[21] = "N/A";
    s_a_val[22] = "N/A";
    s_a_val[23] = "N/A";
    s_a_val[24] = "N/A";
    s_a_val[25] = "N/A";
    s_a_val[26] = "N/A";
    s_a_val[27] = "N/A";
    s_a_val[28] = "N/A";
    s_a_val[29] = "N/A";
    s_a_val[30] = "N/A";
    s_a_val[31] = "N/A";
    s_a_val[32] = "N/A";
    s_a_val[33] = "N/A";
    s_a_val[34] = "N/A";
    s_a_val[35] = "N/A";
    s_a_val[36] = "N/A";
    s_a_val[37] = "N/A";
    s_a_val[38] = "N/A";
    s_a_val[39] = "N/A";
    s_a_val[40] = "N/A";
    s_a_val[41] = "N/A";
    s_a_val[42] = "N/A";
    s_a_val[43] = "N/A";
    s_a_val[44] = "N/A";
    s_a_val[45] = "N/A";
    s_a_val[46] = "N/A";
    s_a_val[47] = "N/A";
    s_a_val[48] = "N/A";
    // <!-- -->
    s_a_val[49] = "N/A";
    s_a_val[50] = "N/A";
    s_a_val[51] = "N/A";
    s_a_val[52] = "N/A";
    s_a_val[53] = "N/A";
    s_a_val[54] = "N/A";
    s_a_val[55] = "N/A";
    s_a_val[56] = "N/A";
    s_a_val[57] = "N/A";
    s_a_val[58] = "N/A";
    s_a_val[59] = "N/A";
    s_a_val[60] = "N/A";
    s_a_val[61] = "N/A";
    s_a_val[62] = "N/A";
    // <!-- -->
    s_a_val[63] = "N/A";
    s_a_val[64] = "N/A";
    s_a_val[65] = "N/A";
    s_a_val[66] = "N/A";
    s_a_val[67] = "N/A";
    s_a_val[68] = "N/A";
    s_a_val[69] = "N/A";
    s_a_val[70] = "N/A";
    s_a_val[71] = "N/A";
    s_a_val[72] = "N/A";
    s_a_val[73] = "N/A";
    s_a_val[74] = "N/A";
    s_a_val[75] = "N/A";
    s_a_val[76] = "N/A";
    s_a_val[77] = "N/A";
    s_a_val[78] = "N/A";
    s_a_val[79] = "N/A";
    s_a_val[80] = "N/A";
    s_a_val[81] = "N/A";
    s_a_val[82] = "N/A";
    s_a_val[83] = "N/A";
    s_a_val[84] = "N/A";
    s_a_val[85] = "N/A";
    s_a_val[86] = "N/A";
    s_a_val[87] = "N/A";
    s_a_val[88] = "N/A";
    s_a_val[89] = "N/A";
    s_a_val[90] = "N/A";
    s_a_val[91] = "N/A";
    s_a_val[92] = "N/A";
    s_a_val[93] = "N/A";
    s_a_val[94] = "N/A";
    s_a_val[95] = "N/A";
    s_a_val[96] = "N/A";
    s_a_val[97] = "N/A";
    s_a_val[98] = "N/A";
    s_a_val[99] = "N/A";
    s_a_val[100] = "N/A";
    s_a_val[101] = "N/A";
    s_a_val[102] = "N/A";
    s_a_val[103] = "N/A";
    s_a_val[104] = "N/A";
    s_a_val[105] = "N/A";
    s_a_val[106] = "N/A";
    s_a_val[107] = "N/A";
    s_a_val[108] = "N/A";
    s_a_val[109] = "N/A";
    s_a_val[110] = "N/A";
    s_a_val[111] = "N/A";
    s_a_val[112] = "N/A";
    s_a_val[113] = "N/A";
    s_a_val[114] = "N/A";
    s_a_val[115] = "N/A";
    s_a_val[116] = "N/A";
    s_a_val[117] = "N/A";
    s_a_val[118] = "N/A";
    s_a_val[119] = "N/A";
    s_a_val[120] = "N/A";
    s_a_val[121] = "N/A";
    s_a_val[122] = "N/A";
    s_a_val[123] = "N/A";
    s_a_val[124] = "N/A";
    s_a_val[125] = "N/A";
    s_a_val[126] = "N/A";
    s_a_val[127] = "N/A";
    s_a_val[128] = "N/A";
    s_a_val[129] = "N/A";
    s_a_val[130] = "N/A";
    s_a_val[131] = "N/A";
    s_a_val[132] = "N/A";
    s_a_val[133] = "N/A";
    s_a_val[134] = "N/A";
    s_a_val[135] = "N/A";
    s_a_val[136] = "N/A";
    s_a_val[137] = "N/A";
    s_a_val[138] = "N/A";
    s_a_val[139] = "N/A";
    s_a_val[140] = "N/A";
    s_a_val[141] = "N/A";
    s_a_val[142] = "N/A";
    s_a_val[143] = "N/A";
    s_a_val[144] = "N/A";
    s_a_val[145] = "N/A";
    s_a_val[146] = "N/A";
    s_a_val[147] = "N/A";
    s_a_val[148] = "N/A";
    s_a_val[149] = "N/A";
    s_a_val[150] = "N/A";
    s_a_val[151] = "N/A";
    s_a_val[152] = "N/A";
    s_a_val[153] = "N/A";
    s_a_val[154] = "N/A";
    s_a_val[155] = "N/A";
    s_a_val[156] = "N/A";
    s_a_val[157] = "N/A";
    s_a_val[158] = "N/A";
    s_a_val[159] = "N/A";
    s_a_val[160] = "N/A";
    s_a_val[161] = "N/A";
    s_a_val[162] = "N/A";
    s_a_val[163] = "N/A";
    s_a_val[164] = "N/A";
    s_a_val[165] = "N/A";
    s_a_val[166] = "N/A";
    s_a_val[167] = "N/A";
    s_a_val[168] = "N/A";
    s_a_val[169] = "N/A";
    s_a_val[170] = "N/A";
    s_a_val[171] = "N/A";
    s_a_val[172] = "N/A";
    s_a_val[173] = "N/A";
    s_a_val[174] = "N/A";
    s_a_val[175] = "N/A";
    s_a_val[176] = "N/A";
    s_a_val[177] = "N/A";
    s_a_val[178] = "N/A";
    s_a_val[179] = "N/A";
    s_a_val[180] = "N/A";
    s_a_val[181] = "N/A";
    s_a_val[182] = "N/A";
    s_a_val[183] = "N/A";
    s_a_val[184] = "N/A";
    s_a_val[185] = "N/A";
    s_a_val[186] = "N/A";
    s_a_val[187] = "N/A";
    s_a_val[188] = "N/A";
    s_a_val[189] = "N/A";
    s_a_val[190] = "N/A";
    s_a_val[191] = "N/A";
    s_a_val[192] = "N/A";
    s_a_val[193] = "N/A";
    s_a_val[194] = "N/A";
    s_a_val[195] = "N/A";
    s_a_val[196] = "N/A";
    s_a_val[197] = "N/A";
    s_a_val[198] = "N/A";
    s_a_val[199] = "N/A";
    s_a_val[200] = "N/A";
    s_a_val[201] = "N/A";
    s_a_val[202] = "N/A";
    s_a_val[203] = "N/A";
    s_a_val[204] = "N/A";
    s_a_val[205] = "N/A";
    s_a_val[206] = "N/A";
    s_a_val[207] = "N/A";
    s_a_val[208] = "N/A";
    s_a_val[209] = "N/A";
    s_a_val[210] = "N/A";
    s_a_val[211] = "N/A";
    s_a_val[212] = "N/A";
    s_a_val[213] = "N/A";
    s_a_val[214] = "N/A";
    s_a_val[215] = "N/A";
    s_a_val[216] = "N/A";
    s_a_val[217] = "N/A";
    s_a_val[218] = "N/A";
    s_a_val[219] = "N/A";
    s_a_val[220] = "N/A";
    s_a_val[221] = "N/A";
    s_a_val[222] = "N/A";
    s_a_val[223] = "N/A";
    s_a_val[224] = "N/A";
    s_a_val[225] = "N/A";
    s_a_val[226] = "N/A";
    s_a_val[227] = "N/A";
    s_a_val[228] = "N/A";
    s_a_val[229] = "N/A";
    s_a_val[230] = "N/A";
    s_a_val[231] = "N/A";
    s_a_val[232] = "N/A";
    s_a_val[233] = "N/A";
    s_a_val[234] = "N/A";
    s_a_val[235] = "N/A";
    s_a_val[236] = "N/A";
    s_a_val[237] = "N/A";
    s_a_val[238] = "N/A";
    s_a_val[239] = "N/A";
    s_a_val[240] = "N/A";
    s_a_val[241] = "N/A";
    s_a_val[242] = "N/A";
    s_a_val[243] = "N/A";
    s_a_val[244] = "N/A";
    s_a_val[245] = "N/A";
    s_a_val[246] = "N/A";
    s_a_val[247] = "N/A";
    s_a_val[248] = "N/A";
    s_a_val[249] = "N/A";
    s_a_val[250] = "N/A";
    s_a_val[251] = "N/A";
    s_a_val[252] = "N/A";

    function populateStates(countryElementId, stateElementId) {

        var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


        var stateElement = document.getElementById(stateElementId);

        stateElement.length = 0; // Fixed by Julian Woods
        stateElement.options[0] = new Option('Select State', '');
        stateElement.selectedIndex = 0;

        var state_arr = s_a[selectedCountryIndex].split("|");
        var state_arr_val = s_a_val[selectedCountryIndex].split("|");

        if(selectedCountryIndex != 0){
        for (var i = 0; i < state_arr.length; i++) {
            stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
        }
        }

    }

    function populateCountries(countryElementId, stateElementId) {

        var countryElement = document.getElementById(countryElementId);

        if (stateElementId) {
            countryElement.onchange = function () {
                populateStates(countryElementId, stateElementId);
            };
        }
    }
    </script>
<div class="main" >
		<div class="main-inner" >
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs">
                                    <?php
                                    
                                     if($user_type == 'ADMIN'){ ?>
                                        <li <?php if(isset($tab8)){?>class="active" <?php }?>><a href="#active_operations" data-toggle="tab">Active Operations</a></li>
                                    <?php }
										if($user_type == 'ADMIN'){
									?>
										<li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#operation_account" data-toggle="tab"><?php if($mno_edit==1){echo"Edit Operations Account";}else{echo"Create Operations Account";};?></a></li>
									<?php }
                                        if($user_type == 'ADMIN'){
                                    ?>
                                        <!--<li < ?php if(isset($tab11)){?>class="active" < ?php }?>><a href="#saved_mno" data-toggle="tab">Pending Account Activation Operations</a></li>-->
                                    <?php } ?>
									</ul>
									<br>
									<div class="tab-content">

                                        <?php if (isset($_SESSION['msg6'])) {
                                            echo $_SESSION['msg6'];
                                            unset($_SESSION['msg6']);
                                        } ?>
                                        <!-- **************Create Operations Account********************** -->
                                        <div <?php if(isset($tab6)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="operation_account">
                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="form-horizontal" method="POST" action="operations.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >
                                                <?php
                                                echo '<input type="hidden" name="form_secret6" id="form_secret6" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                ?>

                                                <fieldset>
                                                    <div id="response_mno"></div>
                                                    <style type="text/css">
                                                        .ms-container{
                                                            display: inline-block !important;
                                                        }
                                                    </style>
                                                    <div class="control-group mno_feature" style="">
                                                        <label class="control-label" for="api_profile">API Profile<sup>
                                                                <font color="#FF0000"></font>
                                                            </sup></label>
                                                        <div class="controls col-lg-5 form-group" readonly>
                                                            <select onchange="add_module(this)" multiple="multiple" name="api_profile[]" id="api_profile" class="span4 form-control">
                                                                    <?php
                                                                    $key_query="SELECT c.controller_name,c.description,c.brand,c.api_profile,c.id,count(c.id) as assign_count FROM `exp_locations_ap_controller` c ";
                                                                    $query_results=$db->selectDB($key_query);
                                                                            foreach($query_results['data'] AS $rowe){
                                                                                if($get_edit_api_profile==$rowe[id]){
                                                                                    $select="selected";
                                                                                }else{
                                                                                    $select="";
                                                                                }
                                                                                echo '<option '.$select.' value='.$rowe[id].' data-vt="'.$rowe[controller_name].'" >'.$rowe[api_profile].'</option>';
                                                                            }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_account_name">Operations Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier" name="mno_account_name" type="text" value="<?php echo $get_edit_mno_description;?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    <!-- /control-group -->
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_account_name">BI System Name<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier DMZ" name="mno_account_name" type="text" value="<?php echo$get_edit_mno_description;?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    
                                                    <?php
                                                    $mno_operator_check="SELECT p.product_code,p.`product_name`,c.options
                                                                            FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                                                            WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'";

                                                    $mno_op=$db->selectDB($mno_operator_check);

                                                    if ($mno_op['rowCount']>1) {
                                                    ?>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_sys_package">Operations Type<sup><font color="#FF0000"></font></sup></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?>>
                                                                    <option value="">Select Type of Operator</option>
                                                                    <?php
                                                                        if($user_type == 'ADMIN'){
                                                                            foreach($mno_op['data'] AS $mno_op_row){
                                                                                if($get_edit_mno_sys_pack==$mno_op_row[product_code]){
                                                                                    $select="selected";
                                                                                }else{
                                                                                    $select="";
                                                                                }
                                                                                echo '<option '.$select.' value='.$mno_op_row[product_code].' data-vt="'.$mno_op_row[options].'" >'.$mno_op_row[product_name].'</option>';
                                                                            }
                                                                          }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        <?php
                                                    }

                                                    ?>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_first_name">Admin First Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_last_name">Admin Last Name<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo$get_edit_mno_last_name;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_email">Admin Email<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo$get_edit_mno_email;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                                                                <option value="">Select Country</option>
                                                                <?php
                                                                $select="";
                                                                foreach ($country_result['data'] as $row) {
                                                                    // if($row[a]==$get_edit_mno_country || $row[a]== "US"){
                                                                    //     $select="selected";
                                                                    // }
                                                                    echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <script language="javascript">
                                                       populateCountries("mno_country", "mno_state");
                                                    </script>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                        <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                            <?php
                                                                echo '<option value="">Select State</option>';
                                                                foreach ($get_regions as $state) {
                                                                    //edit_state_region , get_edit_mno_state_region
                                                                    // if($get_edit_mno_state_region==$state['states_code']) {
                                                                    //     echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    // }else{
                                                                        echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    // }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        $("#mno_zip_code").keydown(function (e) {
                                                            var mac = $('#mno_zip_code').val();
                                                            var len = mac.length + 1;
                                                            // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                        // Allow: Ctrl+A, Command+A
                                                                    (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                        // Allow: Ctrl+C, Command+C
                                                                    (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                        // Allow: Ctrl+x, Command+x
                                                                    (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                        // Allow: Ctrl+V, Command+V
                                                                    (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                        // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                // let it happen, don't do anything
                                                                return;
                                                            }
                                                            // Ensure that it is a number and stop the keypress
                                                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                e.preventDefault();
                                                            }
                                                        });
                                                    });
                                                    </script>

                                                    <div class="control-group">
                                                            <label class="control-label" for="mno_mobile">Phone Number 1<sup><font color="#FF0000"></font></sup></label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_mobile?>" autocomplete="off">
                                                            </div>
                                                    </div>

                                                    <script type="text/javascript">
                                                        $(document).ready(function() {
                                                            $('#mno_form #mno_mobile_1').focus(function(){
                                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                            });

                                                            $('#mno_form #mno_mobile_1').keyup(function(){
                                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                            });

                                                            $("#mno_form #mno_mobile_1").keydown(function (e) {
                                                                var mac = $('#mno_form #mno_mobile_1').val();
                                                                var len = mac.length + 1;
                                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                    mac1 = mac.replace(/[^0-9]/g, '');
                                                                }
                                                                else{
                                                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);

                                                                    if(len == 4){
                                                                        $('#mno_form #mno_mobile_1').val(function() {
                                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                                            //console.log('mac1 ' + mac);

                                                                        });
                                                                    }
                                                                    else if(len == 8 ){
                                                                        $('#mno_form #mno_mobile_1').val(function() {
                                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                                            //console.log('mac2 ' + mac);

                                                                        });
                                                                    }
                                                                }

                                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                            // Allow: Ctrl+A, Command+A
                                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                            // Allow: Ctrl+C, Command+C
                                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                            // Allow: Ctrl+x, Command+x
                                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                            // Allow: Ctrl+V, Command+V
                                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                            // Allow: home, end, left, right, down, up
                                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                    // let it happen, don't do anything
                                                                    return;
                                                                }
                                                                // Ensure that it is a number and stop the keypress
                                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                    e.preventDefault();
                                                                }
                                                            });
                                                        });
                                                        </script>
                                                        <div class="control-group">
                                                            <label class="control-label" for="mno_mobile">Phone Number 2<sup><font color="#FF0000"></font></sup></label>
                                                            <div class="controls col-lg-5 form-group">

                                                                <input class="span4 form-control" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone2?>" autocomplete="off" >
                                                            </div>
                                                        </div>

                                                        <script type="text/javascript">

                                                            $(document).ready(function() {
                                                                $('#mno_mobile_2').focus(function(){
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                });
                                                                $('#mno_mobile_2').keyup(function(){
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                });
                                                                $("#mno_mobile_2").keydown(function (e) {
                                                                    var mac = $('#mno_mobile_2').val();
                                                                    var len = mac.length + 1;
                                                                    if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                        mac1 = mac.replace(/[^0-9]/g, '');
                                                                    }
                                                                    else{
                                                                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
                                                                    }
                                                                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                                // Allow: Ctrl+A, Command+A
                                                                            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+C, Command+C
                                                                            (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+x, Command+x
                                                                            (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: Ctrl+V, Command+V
                                                                            (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                // Allow: home, end, left, right, down, up
                                                                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                        // let it happen, don't do anything
                                                                        return;
                                                                    }
                                                                    // Ensure that it is a number and stop the keypress
                                                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                        e.preventDefault();
                                                                    }
                                                                });
                                                            });
                                                            </script>
                                                            <div class="control-group">
                                                                <label class="control-label" for="mno_mobile">Phone Number 3<sup><font color="#FF0000"></font></sup></label>
                                                                <div class="controls col-lg-5 form-group">
                                                                    <input class="span4 form-control" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_phone3?>" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <script type="text/javascript">
                                                                $(document).ready(function() {
                                                                    $('#mno_mobile_3').focus(function(){
                                                                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                    });
                                                                    $('#mno_mobile_3').keyup(function(){
                                                                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
                                                                    });
                                                                    $("#mno_mobile_3").keydown(function (e) {
                                                                        var mac = $('#mno_mobile_3').val();
                                                                        var len = mac.length + 1;
                                                                        if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                                            mac1 = mac.replace(/[^0-9]/g, '');
                                                                        }
                                                                        else{
                                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);
                                                                            }
                                                                        // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                        if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                                    // Allow: Ctrl+A, Command+A
                                                                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                    // Allow: Ctrl+C, Command+C
                                                                                (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                    // Allow: Ctrl+x, Command+x
                                                                                (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                    // Allow: Ctrl+V, Command+V
                                                                                (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                                    // Allow: home, end, left, right, down, up
                                                                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                            // let it happen, don't do anything
                                                                            return;
                                                                        }
                                                                        // Ensure that it is a number and stop the keypress
                                                                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                            e.preventDefault();
                                                                        }
                                                                    });
                                                                });
                                                            </script>

                                                            <div class="control-group">
                                                                <label class="control-label" for="mno_timezone">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                                <div class="controls col-lg-5 form-group">
                                                                    <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off">
                                                                        <option value="">Select Time Zone</option>
                                                                        <?php
                                                                        foreach ($priority_zone_array as $tz){
                                                                            $current_tz = new DateTimeZone($tz);
                                                                            $offset =  $current_tz->getOffset($dt);
                                                                            $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                            $abbr = $transition[0]['abbr'];
                                                                            if($get_edit_mno_timezones==$tz){
                                                                                $select="selected";
                                                                            }else{
                                                                                $select="";
                                                                            }
                                                                            echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                        }
                                                                        foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                            //Skip
                                                                            if(in_array($tz,$priority_zone_array))
                                                                                continue;

                                                                            $current_tz = new DateTimeZone($tz);
                                                                            $offset =  $current_tz->getOffset($dt);
                                                                            $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                            $abbr = $transition[0]['abbr'];
                                                                            /*if($abbr=="EST" || $abbr=="CT" || $abbr=="MT" || $abbr=="PST" || $abbr=="AKST" || $abbr=="HST" || $abbr=="EDT"){
                                                                            echo $get_edit_mno_timezones;*/
                                                                            if($get_edit_mno_timezones==$tz){
                                                                                $select="selected";
                                                                            }else{
                                                                                $select="";
                                                                            }
                                                                            echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                            // $select="";
                                                                            /*}*/
                                                                        }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions">
                                                                    <button type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?php if($mno_edit==1){echo "Update Account";}else{echo "Create Account";}?></button>
                                                                    <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>
                                                            </div>
                                                            <script>
                                                                function submit_mno_formfn() {
                                                                    //alert("fn");
                                                                    $("#submit_mno_form").prop('disabled', false);
                                                                }

                                                                function goto(url){
                                                                window.location = "?";
                                                                }
                                                            </script>
                                                    <!-- /form-actions -->
                                                </fieldset>
                                            </form>
                                                <!-- /widget -->
                                        </div>
                                        
                                        <!-- ***************Activate Accounts List******************* -->
                                        <div <?php if(isset($tab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_operations">
											<div id="response_d1"></div>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													<h3>Active Operations</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
                                                    <div style="overflow-x:auto">
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Operations</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API Profile</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Edit</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Remove</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    $key_query = "SELECT m.mno_description,m.mno_id,u.full_name, u.email , u.verification_number
                                                                                    FROM exp_mno m, admin_users u
                                                                                    WHERE u.user_type = 'MNO' AND u.user_distributor = m.mno_id AND u.`access_role`='admin'
                                                                                    GROUP BY m.mno_id
                                                                                    ORDER BY mno_description ";
                                                                    $query_results = $db->selectDB($key_query);
                                                                    foreach ($query_results['data'] as $row) {
                                                                        $mno_description = $row[mno_description];
                                                                        $mno_id = $row[mno_id];
                                                                        $full_name = $row[full_name];
                                                                        $email = $row[email];
                                                                        $s= $row[s];
                                                                        $is_enable= $row[is_enable];
                                                                        $icomm_num=$row[verification_number];
                                                                        echo '<tr>
                                                                        <td> '.$mno_description.' </td>
                                                                        <td> '.trim($ap_c, ",").' </td>	';
                                                                        echo '<td> '.

                                                                            //******************************** Edit ************************************
                                                                            '<a href="javascript:void();" id="EDITMNOACC_'.$mno_id.'"  class="btn btn-small btn-info">
                                                                            <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                                $(\'#EDITMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                    title: \'Account Edit\',
                                                                                    text: \'Are you sure you want to edit this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                    }});

                                                                                $(\'#EDITMNOACC_'.$mno_id.'\').click(function() {
                                                                                    window.location = "?token10='.$secret.'&t=6&edit_mno_id='.$mno_id.'"
                                                                                });
                                                                            });

                                                                            </script></td>';
                                                                            // $distributor_exi = "SELECT * FROM `exp_mno_distributor` WHERE mno_id = '$mno_id'";
                                                                            // $query_results01 = $db->selectDB($distributor_exi);
                                                                            // $count_records_exi = count($query_results01);
                                                                            // if($count_records_exi == 0){

                                                                            //*********************************** Remove  *****************************************
                                                                            echo '<td><a href="javascript:void();" id="REMMNOACC_'.$mno_id.'"  class="btn btn-small btn-danger">

                                                                            <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">

                                                                                                    $(document).ready(function() {
                                                                                                    $(\'#REMMNOACC_'.$mno_id.'\').easyconfirm({locale: {
                                                                                                            title: \'Account Remove\',
                                                                                                            text: \'Are you sure you want to remove this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                            button: [\'Cancel\',\' Confirm\'],
                                                                                                            closeText: \'close\'
                                                                                                            }});

                                                                                                        $(\'#REMMNOACC_'.$mno_id.'\').click(function() {
                                                                                                            window.location = "?token10='.$secret.'&t=8&remove_mno_id='.$mno_id.'"

                                                                                });
                                                                                });
                                                                            </script>';


                                                                            // }else{

                                                                            //     echo '<td><a class="btn btn-small btn-warning" disabled >&nbsp;<i class="icon icon-lock"></i>Remove</a></center>';
                                                                            // }
                                                                        //****************************************************************************************
                                                                        echo ' </td>';
                                                                        echo '</tr>';
                                                                    }
                                                                ?>

                                                            </tbody>
                                                        </table>
												    </div>
                                                </div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->
                                        </div>
                                        <!-- ***************Operation Account Create********************** -->
                                        <div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_operation">
                                            <form  autocomplete="off"   id="location_form" name="location_form" method="post" class="form-horizontal"   action="<?php if($_POST['p_update_button_action']=='add_location' || isset($_GET['location_parent_id'])){echo '?token7='.$secret.'&t=edit_parent&edit_parent_id='.$edit_parent_id;}else{echo'?t=active_properties';} ?>" >
                                                <?php
                                                echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';
                                                ?>
                                                <fieldset>
                                                    <div id="response_d1"></div>
                                                    <br>
                                                    <div class="control-group guest_icomme" id="icomme_div">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="customer_type">Customer Account Number<?php if ($field_array['icomms_number'] == "mandatory") { ?><font color="#FF0000"></font><?php } ?></label>
                                            <input type="text" class="span4 form-control" id="icomme" name="icomme" value="<?php echo $edit_distributor_verification_number; ?>" <?php if ($edit_account == 1) { ?>readonly<?php } ?>>
                                            <div style="display: none" id="img_icom"><img src="img/loading_ajax.gif"></div>
                                        </div>
                                        <script type="text/javascript">
                                            function check_icom(icomval, type) {


                if ($('#icomme').is('[readonly]')) {


                } else if ($('#icomme_pvt').is('[readonly]')) {


                } else {

                    var valic = icomval.value;
                    var valic = valic.trim();
                    var distributor = "";
                    <?php
                    if ($edit_account == 1) {
                        echo "distributor='" . $edit_distributor_code . "';";
                    }
                    ?>


                    if (valic != "") {
                        if (type == 0) {
                            $('#img_icom_pvt').css('display', 'inline-block');
                        } else {
                            $('#img_icom').css('display', 'inline-block');
                        }
                        var formData = {
                            icom: valic,
                            edit: "<?php echo $edit_account; ?>",
                            distributor: distributor
                        };
                        $.ajax({
                            url: "ajax/validateIcom.php",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                /*  if:new ok->1
                                 * if:new exist->2 */


                                if (data == '1') {
                                    /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                    if (type == 0) {
                                        $('#img_icom_pvt').hide();
                                    } else {
                                        $('#img_icom').hide();
                                    }

                                    document.getElementById("realm").value = valic;
                                    <?php if ($field_array['network_config'] == 'display_none') { ?>
                                        document.getElementById("zone_name").value = valic;
                                        document.getElementById("zone_dec").value = valic;
                                    <?php } ?>


                                } else if (data == '2') {
                                    //alert(data);
                                    if (type == 0) {
                                        $('#img_icom_pvt').hide();
                                        document.getElementById('icomme_pvt').value = "";
                                        document.getElementById("realm").value = "";
                                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                                            document.getElementById("zone_name").value = "";
                                            document.getElementById("zone_dec").value = "";
                                        <?php } ?>
                                        /* $('#mno_account_name').removeAttr('value'); */
                                        document.getElementById('icomme_pvt').placeholder = "Please enter new Customer Account number";
                                        $("#icomme_div_p small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme_pvt', 'NOT_VALIDATED').validateField('icomme_pvt');

                                    } else {
                                        $('#img_icom').hide();
                                        document.getElementById('icomme').value = "";
                                        document.getElementById("realm").value = "";
                                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                                            document.getElementById("zone_name").value = "";
                                            document.getElementById("zone_dec").value = "";
                                        <?php } ?>
                                        /* $('#mno_account_name').removeAttr('value'); */
                                        document.getElementById('icomme').placeholder = "Please enter new Customer Account number";

                                        $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');
                                    }
                                }



                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                //alert("error");
                                document.getElementById('icomme').value = "";
                                document.getElementById("realm").value = "";
                                <?php if ($field_array['network_config'] == 'display_none') { ?>
                                    document.getElementById("zone_name").value = "";
                                    document.getElementById("zone_dec").value = "";
                                <?php } ?>
                                if (type == 0) {
                                    $("#icomme_div_p small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                    $('#location_form').data('bootstrapValidator').updateStatus('icomme_pvt', 'NOT_VALIDATED').validateField('icomme_pvt');

                                } else {
                                    $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');


                                    $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');
                                }




                            }



                        });
                        var bootstrapValidator2 = $('#location_form').data('bootstrapValidator');
                        bootstrapValidator2.enableFieldValidators('realm', true);
                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                            bootstrapValidator2.enableFieldValidators('zone_name', true);
                            bootstrapValidator2.enableFieldValidators('zone_dec', true);

                        <?php } ?>
                    }


                }
            }
                                            $(document).ready(function() {




                                                $("#icomme").keypress(function(e) {

                                                    var ew = event.which;

                                                    //alert(ew);
                                                    // if(ew == 32)
                                                    //   return true;

                                                    if (ew == 45 || ew == 95) {
                                                        /*allow - and _ characters */
                                                        return true;
                                                    }

                                                    if (48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0 || ew == 8 || ew == 189) {
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }



                                                });


                                            });
                                        </script>
                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_first_name">First Name<?php if($field_array['f_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if(isset($edit_first_name)){ ?>readonly<?php } ?> class="span4 form-control" id="client_first_name" placeholder="First Name" name="client_first_name" type="text" maxlength="30" value="<?php echo $edit_first_name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_last_name">Last Name<?php if($field_array['l_name']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if(isset($edit_last_name)){ ?>readonly<?php } ?> class="span4 form-control" id="client_last_name" placeholder="Last Name" name="client_last_name" maxlength="30" type="text" value="<?php echo $edit_last_name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_email">Email<?php if($field_array['email']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if(isset($edit_email)){ ?>readonly<?php } ?> class="span4 form-control" id="client_email" name="client_email" type="text" placeholder="wifi@company.com"   value="<?php echo $edit_email; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_address_1">Address<?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if($field_array['add1']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="client_address_1" placeholder="Address" name="client_address_1" type="text"   value="<?php echo $edit_bussiness_address1; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_address_2">City<?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if($field_array['add2']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="client_address_2" placeholder="City" name="client_address_2" type="text"   value="<?php echo $edit_bussiness_address2; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_country" >Country<?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select <?php if($field_array['country']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> name="client_country" id="country" class="span4 form-control">
                                                                <option value="">Select Country</option>
                                                                <?php
                                                                $select="";
                                                                foreach ($country_result['data'] AS $row) {
                                                                    // if($row[a]==$edit_country_code || $row[a]== "US"){
                                                                    //     $select="selected";
                                                                    // }
                                                                    echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <script language="javascript">
                                                        populateCountries("country", "state");
                                                    </script>
                                                    <!-- /controls -->
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_state">State/Region<?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="client_state" >
                                                                <option value="">Select State</option>
                                                                <?php
                                                                foreach ($get_regions['data'] AS $state) {
                                                                    if($edit_state_region==$state['states_code']) {
                                                                        echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    }else{

                                                                        echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_region">ZIP Code<?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input <?php if($field_array['zip_code']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control zip_vali" id="client_zip_code" maxlength="5" placeholder="XXXXX" name="client_zip_code" type="text" value="<?php echo $edit_zip; ?>">
                                                        </div>
                                                    </div>

                                                    <script type="text/javascript">
                                                        $(document).ready(function() {
                                                            $(".zip_vali").keydown(function (e) {
                                                                var mac = $('.zip_vali').val();
                                                                var len = mac.length + 1;
                                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                                    // Allow: Ctrl+A, Command+A
                                                                    (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                    // Allow: Ctrl+C, Command+C
                                                                    (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                    // Allow: Ctrl+x, Command+x
                                                                    (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                    // Allow: Ctrl+V, Command+V
                                                                    (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                                    // Allow: home, end, left, right, down, up
                                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                                    // let it happen, don't do anything
                                                                    return;
                                                                }
                                                                // Ensure that it is a number and stop the keypress
                                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                                    e.preventDefault();
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                    <div class="control-group">
                                                        <label class="control-label" for="client_timezone">Time Zone <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?><sup><font color="#FF0000"></font></sup><?php } ?></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select <?php if($field_array['time_zone']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="client_time_zone" name="client_time_zone" >
                                                                <option value="">Select Time Zone</option>
                                                                <?php
                                                                foreach ($priority_zone_array as $tz){
                                                                    $current_tz = new DateTimeZone($tz);
                                                                    $offset =  $current_tz->getOffset($dt);
                                                                    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                    $abbr = $transition[0]['abbr'];
                                                                    if($edit_timezone==$tz){
                                                                        $select="selected";
                                                                    }else{
                                                                        $select="";
                                                                    }
                                                                    echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                }

                                                                foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                                    //Skip
                                                                    if(in_array($tz,$priority_zone_array))
                                                                        continue;

                                                                    $current_tz = new DateTimeZone($tz);
                                                                    $offset =  $current_tz->getOffset($dt);
                                                                    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                    $abbr = $transition[0]['abbr'];
                                                                    if($edit_timezone==$tz){
                                                                        $select="selected";
                                                                    }
                                                                    echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                    $select="";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <?php if($edit_account=='1')$btn_name='Update Location & Save';else $btn_name='Add Location & Save';
                                                        if($edit_account=='1'){
                                                            echo '<button  type="submit" name="create_operation_submit" id="create_operation_submit" class="btn btn-primary"> Update Client</button><strong><font color="#FF0000"></font> </strong>';
                                                            
                                                        }else{
                                                            echo '<button  type="submit" name="create_operation_submit" id="create_operation_submit"
                                                                                                class="btn btn-primary">Create Account</button><strong><font color="#FF0000"></font> </strong>';

                                                        }

                                                        if($edit_account=='1' || $_POST['p_update_button_action']=='add_location' || $_POST['btn_action']=='add_location_next'){?>
                                                            <a href="?token7=<?php echo $secret;?>&t=edit_parent&edit_parent_id=<?php echo $edit_parent_id  ;?>" style="text-decoration:none;" class="btn btn-info inline-btn" >Cancel</a>
                                                        <?php } ?>
                                                        <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                                                        <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                                                        <input type="hidden" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                                                        <input type="hidden" name="btn_action"  id = "btn_action" value="create_operation_submit" />
                                                        <input type="hidden" name="add_new_location"  value="<?php echo  $_POST['p_update_button_action']=='add_location'?'1':'0' ?>" />
                                                        <script type="text/javascript">
                                                            function btn_action_change(action) {
                                                                $('#btn_action').val(action);
                                                            }

                                                            $(document).ready(function() {
                                                                $(window).keydown(function(event){
                                                                    if(event.keyCode == 13) {
                                                                        event.preventDefault();
                                                                        return false;
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                
                                                <!-- /form-actions -->
                                                </fieldset>
                                            </form>
                                        </div>

                                        <!-- ***************Operation Accounts List********************** -->
                                        <div <?php if(isset($tab9)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_op">
                                            <div id="response_d1"></div>
                                            <div class="widget widget-table action-table">
                                            <div class="widget-content table_response">
                                                <div style="overflow-x:auto">
                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#
                                                                </th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Serial</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Model</th>
                                                                <?php // echo$package_functions->getSectionType('AP_ACTIONS',$system_package);
                                                                if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') { ?>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Actions</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        
                                                            $key_query = "SELECT d.`id` ,d.`distributor_code`,u.`verification_number`,d.`distributor_name`
FROM `exp_mno_distributor` d LEFT JOIN `admin_users` u  ON u.`verification_number`=d.`verification_number` WHERE d.mno_id='$user_distributor' GROUP BY d.verification_number";

                                                            $query_results = $db->selectDB($key_query);
                                                            foreach ($query_results['data'] AS $row) {

                                                                $cpe_id = $row[id];
                                                                $cpe_name = $row[ap_code];
                                                                $ip = $row[distributor_name];

                                                                if (empty($row[verification_number])) {
                                                                    $icoms = "N/A";
                                                                } else {
                                                                    $icoms = $row[verification_number];
                                                                }

                                                                if (empty($row[mac_address])) {
                                                                    $mac_address = "N/A";
                                                                } else {
                                                                    $mac_address = $row[mac_address];
                                                                }

                                                                if (empty($row[create_date])) {
                                                                    $created_date = "N/A";
                                                                } else {
                                                                    $created_date = $row[create_date];
                                                                }

                                                                if (empty($row[serial])) {
                                                                    $serial = "N/A";
                                                                } else {
                                                                    $serial = $row[serial];
                                                                }

                                                                if (empty($row[model])) {
                                                                    $model = "N/A";
                                                                } else {
                                                                    $model = $row[model];
                                                                }


                                                                echo '<tr>
                                                                        <td> ' . $view_loc_code . ' </td>
                                                                        <td> ' . $icoms . ' </td>
                                                                        <td> ' . $mac_address . ' </td>
                                                                        <td> ' . $serial . ' </td>

                                                                        <td> ' . $model . ' </td>';
                                                            if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') {
                                                                echo '<td>';
                                                                $action_event = (array)json_decode($package_functions->getOptions('AP_ACTIONS', $system_package));

                                                                if (in_array('edit', $action_event) || $system_package == 'N/A') {
                                                                    echo '<a href="javascript:void();" id="EDITAP_' . $cpe_id . '"  class="btn btn-small btn-info">
                                                                                            <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                                        $(document).ready(function() {
                                                                                        $(\'#EDITAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                                                                title: \'CPE Edit\',
                                                                                                text: \'Are you sure,you want to edit this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                }});

                                                                                            $(\'#EDITAP_' . $cpe_id . '\').click(function() {
                                                                                                window.location = "?token7=' . $secret . '&t=2&edit_ap_id=' . $cpe_id . '&edit_loc_code=' . $view_loc_code . '&edit_loc_name=' . $view_loc_name . '"

                                                                                            });

                                                                                            });

                                                                                        </script>&nbsp;&nbsp;';
                                                                }
                                                                if (in_array('remove', $action_event) || $system_package == 'N/A') {
                                                                    echo '<a href="javascript:void();" id="REMAP_' . $cpe_id . '"  class="btn btn-small btn-danger">
                                                                                            <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
                                                                                        $(document).ready(function() {
                                                                                        $(\'#REMAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                                                                title: \'CPE Remove\',
                                                                                                text: \'Are you sure,you want to remove this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                                closeText: \'close\'
                                                                                                }});

                                                                                            $(\'#REMAP_' . $cpe_id . '\').click(function() {
                                                                                                window.location = "?token7=' . $secret . '&t=active_properties&view_loc_name=' . $view_loc_name . '&remove_ap_name=' . $cpe_name . '&rem_ap_id=' . $cpe_id . '&view_loc_code=' . $view_loc_code . '"

                                                                                            });

                                                                                            });

                                                                                        </script>';
                                                                                                    }

                                                                                                    echo '</td>';
                                                                                                }
                                                                                                echo '</tr>';
                                                                                            }
                                                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
							<!-- /widget-content -->
						</div>
						<!-- /widget -->
					</div>
					<!-- /span8 -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /main-inner -->
	</div>
	<!-- /main -->

<style type="text/css">

</style>
<!-- /widget -->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#api_profile').multiSelect();  
    });
  </script>
