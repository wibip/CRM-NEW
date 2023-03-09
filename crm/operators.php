<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<?php
include 'header_new.php';
$page = "Operators";
$priority_zone_array = array(
    "America/New_York",
    "America/Chicago",
    "America/Denver",
    "America/Los_Angeles",
    "America/Anchorage",
    "Pacific/Honolulu",
);

require_once './classes/systemPackageClass.php';
$package_functions = new package_functions();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();
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

$mno_operator_check="SELECT p.product_code,p.`product_name`,c.options
                        FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                        WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'";
$mno_op=$db->selectDB($mno_operator_check);

$key_query="SELECT c.controller_name,c.description,c.brand,c.api_profile,c.id FROM `exp_locations_ap_controller` c ";
$query_results=$db->selectDB($key_query);

$operators = $OperatorClass->getOperators();

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

            //$mno_customer_type = trim($_POST['mno_customer_type']);
            $mno_first_name = $db->escapeDB(trim($_POST['mno_first_name']));
            $mno_last_name = $db->escapeDB(trim($_POST['mno_last_name']));
            $mno_full_name = $mno_first_name . ' ' . $mno_last_name;
            $mno_email = trim($_POST['mno_email']);
            $mno_address_1 = $db->escapeDB(trim($_POST['mno_address_1']));
            $mno_address_2 = $db->escapeDB(trim($_POST['mno_address_2']));
            $mno_address_3 = $db->escapeDB(trim($_POST['mno_address_3']));
            $mno_mobile_1 = $db->escapeDB(trim($_POST['mno_mobile_1']));
            $mno_country = trim($_POST['mno_country']);
            $mno_state = $db->escapeDB(trim($_POST['mno_state']));
            $mno_zip_code = trim($_POST['mno_zip_code']);
            $mno_time_zone = $_POST['mno_time_zone'];
            $dtz = new DateTimeZone($mno_time_zone);
            $time_in_sofia = new DateTime('now', $dtz);
            $offset = $dtz->getOffset($time_in_sofia) / 3600;
            $time_offset = ($offset < 0 ? $offset : "+" . $offset);
            $api_profile = $_POST['api_profile'];
            $login_user_name = $_SESSION['user_name'];

            $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno'");

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
                                    `mno_description`='$mno_account_name',
                                    `mno_type`='$mnoAccType',
                                    `bussiness_address1`='$mno_address_1',
                                    `bussiness_address2`='$mno_address_2',
                                    `bussiness_address3`='$mno_address_3',
                                    `features`='$api_profile ',
                                    `country`='$mno_country',
                                    `state_region`='$mno_state',
                                    `zip`='$mno_zip_code',
                                    `phone1`='$mno_mobile_1',
                                    `timezones`='$mno_time_zone'
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
                    // var_dump($ex0);die;
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


                        $message_response = $message_functions->showMessage('operator_update_success') ;
                        $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify Operation',$edit_mno_id,'3001',$message_response);
                        $_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                    } else {
                        $message_response = $message_functions->showMessage('operator_update_failed', '2001');
                        $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify Operation',$edit_mno_id,'2001',$message_response);
                        // $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                        $_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response. "</strong></div>";
                    }

                } else {
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
                                '$api_profile',
                                '$mno_country',
                                '$mno_state',
                                '$mno_zip_code',
                                '$mno_mobile_1',
                                '$mno_time_zone',
                                '1',
                                NOW(),
                                '$login_user_name'
                                ,'$mno_system_package',
                                '$mnoAccType',
                                '$camphaign_id')";
                    } else {
                        $query0 = "INSERT INTO `exp_mno` (`system_package`,`mno_id`, `mno_description`, `zip`, `default_campaign_id`, `mno_type`, `is_enable`,create_user, `create_date`)
                                    VALUES ('$mno_sys_package','$mno_id', '$mno_account_name', '$mno_zip_code', '$camphaign_id', '$mnoAccType','1','$login_user_name', NOW())";
                    }
                    $ex0 = $db->execDB($query0);
                    $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                    
                    if ($ex0 === true) {
                        $query0 = "INSERT INTO `admin_users` (`user_name`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `timezone`, `is_enable`,create_user, `create_date`,`admin`)
                                    VALUES ('$new_user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))), 'operation', '$mno_user_type', '$mno_id', '$mno_full_name', '$mno_email', '$mno_mobile_1', '$mno_time_zone', '1','$login_user_name', NOW(), '$user_type')";
    
                        $ex0 = $db->execDB($query0);
                        if (isset($mno_sys_package)) {
                            $access_role_id = $mno_id . "_support";
                            $access_role_name = $mno_id . " Support";
                            if ($package_functions->getSectionType("SUPPORT_AVAILABLE", $mno_sys_package, 'MNO') == '1') {
                                $query0 = "INSERT INTO `admin_access_roles` (`access_role`,`description`,`distributor`,`create_user`,`create_date`)
                                            VALUES ('$access_role_id', 'Support', '$mno_id', '$user_name',now())";
                                $result0 = $db->execDB($query0);
                                $sys_pack = $mno_sys_package;
                                $gt_support_optioncode = $package_functions->getOptions('SUPPORT_AVAILABLE', $sys_pack, 'MNO');
                                $pieces1 = explode(",", $gt_support_optioncode);
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
                                }

                                $get_logins_q = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code`='ALLOWED_LOGIN_PROFILES'";
                                $get_logins = $db->select1DB($get_logins_q);
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
                        $message_response = $message_functions->showMessage('operator_create_success') ;
                        $db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create Operatorn',$idContAutoInc,'3001',$message_response);
                        // $db->userLog($user_name, $script, 'Create Operator', '');
                        $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                    } else {
                        $message_response = $message_functions->showMessage('operator_create_failed', '2001');
                        $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Operatorn',$idContAutoInc,'2001',$message_response);
                        // $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                        $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                    }
                }
            } //1

            else { //1
                $message_response = $message_functions->showMessage('operator_create_failed', '2009');
                $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Operatorn',0,'2009',$message_response);
                // $db->userErrorLog('2009', $user_name, 'script - ' . $script);
                $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
            } //1
        } //key validation
        else {
            $message_response = $message_functions->showMessage('transection_fail', '2004');
            $db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Operatorn',$idContAutoInc,'2004',$message_response);
            // $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg6'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
            header('Location: operations.php');
        }
} elseif (isset($_GET['edit_mno_id'])) {
    var_dump('ssssssss');
    $edit_mno_id = $_GET['edit_mno_id'];
    $get_edit_mno_details_q = "SELECT * FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
    $mno_data = $db->select1DB($get_edit_mno_details_q);
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

        $get_edit_mno_details_q = "SELECT `full_name`,`email`,`user_type`,`mobile` FROM `admin_users` WHERE `user_distributor`='$edit_mno_id' AND `access_role`='admin' LIMIT 1";
        $mno_data = $db->select1DB($get_edit_mno_details_q);
        $get_edit_mno_fulname = $mno_data['full_name'];
        $get_edit_mno_user_type = $mno_data['user_type'];
        $get_ful_name_array = explode(' ', $get_edit_mno_fulname, 2);
        $get_edit_mno_first_name = $get_ful_name_array[0];
        $get_edit_mno_last_name = $get_ful_name_array[1];
        $get_edit_mno_email = $mno_data['email'];
        $get_edit_mno_mobile = $mno_data['mobile'];
        $get_ap_controllers_q = "SELECT c.ap_controller,ap.type FROM `exp_mno_ap_controller` c LEFT JOIN exp_locations_ap_controller ap ON c.ap_controller = ap.controller_name WHERE c.mno_id='$edit_mno_id'";
        $get_ap_controllers = $db->selectDB($get_ap_controllers_q);
        $ap_controler_array = array();
        foreach ($get_ap_controllers['data'] as $get_ap_controller) {
            array_push($ap_controler_array, array($get_ap_controller['ap_controller'], $get_ap_controller['type']));
        }

        $features_controler_array = $get_edit_mno_featuresar;
        $get_mno_wags_q = "SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                            WHERE w.`ap_controller`=c.`ap_controller` AND c.`mno_id`='$edit_mno_id' GROUP BY w.`wag_code`";
        $get_mno_wags_r = $db->selectDB($get_mno_wags_q);
        $edit_wag_prof_string = '';
        foreach ($get_mno_wags_r['data'] as $get_mno_wags) {
            $edit_wag_prof_string .= $get_mno_wags['wag_name'] . '';
        }
        $mno_edit = 1;
} //edit_mno
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operators</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Operators</h1>
                                        <table class="table table-striped" style="width:100%" id="operator-table">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>Operator Name</th>
                                                    <th>Sub Operator Code</th>
                                                    <th>Sub Operator Name</th>
                                                    <th>Environment</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($operators['rowCount'] > 1){ 
                                                    //foreach($operators['data'] AS $operator) {
                                                    foreach ($operators['data'] as $row) {
                                                        $mno_description = $row['mno_description'];
                                                        $mno_id = $row['mno_id'];
                                                        $full_name = $row['full_name'];
                                                        $email = $row['email'];
                                                        $mobile = $row['mobile'];
                                                        // $s= $row[s];
                                                        $is_enable = ($row['is_enable'] == 1 ? "Active" : "Inactive");
                                                        // $icomm_num=$row[verification_number];
                                                        $api_profiles = json_decode($row['features']);
                                                        $show_profile = "";
                                                        foreach($api_profiles as $api_profile) {
                                                            $profile = $db->getValueAsf("SELECT `api_profile` as f FROM `exp_locations_ap_controller` WHERE `id`=".$api_profile);
                                                            $show_profile .= $profile."<br/>";
                                                        }
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?=$full_name?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?=$is_enable?></td>
                                                    </tr>
                                                <?php
                                                        } 
                                                    } 
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <span class="fs-5"><?= ($mno_edit==1 ? "Update" : "Create")?> Operator</span>
                                                </div>
                                            </div>
                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="row g-3 p-4" method="POST" action="operators.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >
                                                <input type="hidden" name="form_secret6" id="form_secret6" value="<?=$_SESSION['FORM_SECRET']?>" />
                                                <div class="col-md-6">
                                                    <label class="control-label" for="api_profile">BI API Profile</label>
                                                    <select onchange="add_module(this)" name="api_profile" id="api_profile" class="span4 form-control" required>
                                                        <option value="">Select API profile</option>
                                                        <?php
                                                        if($query_results['rowCount'] > 1) {
                                                            foreach($query_results['data'] AS $rowe){
                                                                if(in_array($rowe['id'], $features_controler_array)){
                                                                    $select="selected";
                                                                }else{
                                                                    $select="";
                                                                }
                                                                echo '<option '.$select.' value='.$rowe['id'].' data-vt="'.$rowe['controller_name'].'" >'.$rowe['api_profile'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>                                                
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_first_name">Operator Code</label>
                                                    <input class="span4 form-control" id="product_code" maxlength="12" placeholder="Operator Code" name="product_code" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_account_name">Operations Name</label>
                                                    <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier" name="mno_account_name" type="text" value="<?php echo $get_edit_mno_description;?>" required>
                                                </div>                                                    
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_sys_package">Operations Type</label>
                                                    <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?> required>
                                                        <option value="">Select Type of Operator</option>
                                                        <?php
                                                            if($mno_op['rowCount']>1 && ($user_type == 'ADMIN' || $user_type == 'SADMIN')){
                                                                foreach($mno_op['data'] AS $mno_op_row){
                                                                    if($get_edit_mno_sys_pack==$mno_op_row['product_code']){
                                                                        $select="selected";
                                                                    }else{
                                                                        $select="";
                                                                    }
                                                                    echo '<option '.$select.' value='.$mno_op_row['product_code'].' data-vt="'.$mno_op_row['options'].'" >'.$mno_op_row['product_name'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_first_name">Admin First Name</label>
                                                    <input class="span4 form-control" id="mno_first_name" maxlength="12" placeholder="First Name" name="mno_first_name" type="text" value="<?php echo$get_edit_mno_first_name;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_last_name">Admin Last Name</label>
                                                    <input class="span4 form-control" id="mno_last_name" maxlength="12" placeholder="Last Name" name="mno_last_name" type="text" value="<?php echo$get_edit_mno_last_name;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_email">Admin Email</label>
                                                    <input class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo$get_edit_mno_email;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_address_1">Address</label>
                                                    <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_address_2">City</label>
                                                    <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
                                                    <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off" required>
                                                        <option value="">Select Country</option>
                                                        <?php
                                                            if($country_result['rowCount']>1) {
                                                                foreach ($country_result['data'] as $row) {
                                                                    $select="";
                                                                    if($row['a']==$get_edit_mno_country){
                                                                        $select="selected";
                                                                    }
                                                                    echo '<option value="'.$row['a'].'" '.$select.'>'.$row['b'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <script language="javascript">
                                                    populateCountries("mno_country", "mno_state");
                                                </script>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                        <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                            <option value="">Select State</option>
                                                            <?php
                                                                if($get_regions['rowCount']>1) {
                                                                    foreach ($get_regions['data'] AS $state) {
                                                                        //edit_state_region , get_edit_mno_state_region
                                                                        if($get_edit_mno_state_region == 'N/A') {
                                                                            echo '<option selected value="N/A">Others</option>';
                                                                        } else {
                                                                            if ($get_edit_mno_state_region == $state['states_code']) {
                                                                                echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                            } else {
                                                                                echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="mno_region">ZIP Code</label>
                                                        <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="mno_mobile">Phone Number</label>
                                                        <input class="span4 form-control" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="12" value="<?php echo $get_edit_mno_mobile?>" autocomplete="off" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="mno_timezone">Time Zone</label>
                                                        <select class="span4 form-control" id="mno_time_zone" name="mno_time_zone" autocomplete="off" required>
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
                                                    <div  class="col-md-12">
                                                        <button type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?= ($mno_edit==1 ? "Update" : "Create")?> Account</button>
                                                        <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>
                                                    </div>
                                            </form>
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

<script>
    $(document).ready(function () {
        $('#operator-table').dataTable();

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

    function submit_mno_formfn() {
        //alert("fn");
        $("#submit_mno_form").prop('disabled', false);
    }

    function goto(url){
        window.location = "?";
    }
</script>

<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('#api_profile').multiSelect();  
    });
  </script>
