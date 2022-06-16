<?php

// $theme_template_name = $_GET['template_name'];
// if($theme_template_name==''){
//     echo"Invalid Request";
//     exit();
// }

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

require_once __DIR__ . '/../../classes/dbClass.php';
require_once __DIR__ . '/../../classes/dbApiClass.php';
require_once __DIR__ . '/../../classes/systemPackageClass.php';

$extt = 0;
$db_query = new db_functions();
$api_db = new api_db_functions();
$package_functions = new package_functions();
$template_id = $_GET['template_name'];
$registration_type = $_GET['reg_type'];
$theme_id = $_GET['theme_id']; //if strlen($theme_id)>0 = modify theme
$modify_id = $_GET['theme_id_ori']; //if strlen($theme_id)>0 = modify theme
$enc = $_GET['enc']; //if strlen($enc)>0 = already created theme details ID  
$action = $_GET['action'];
$page = $_GET['page'];
$chatbot = $_GET['chatbot'];
$chatbot_url = urldecode($_COOKIE["chatbot_url"]);;
$from_theme_upload = 'false';
$temp_property_id = $_GET['property'];
$redirect_property_id = htmlentities(urldecode($temp_property_id), ENT_QUOTES, 'utf-8');
if (isset($_GET['from_theme_upload'])) {
    $from_theme_upload = 'true';
}

$user_distributor = $_GET['dist'];


if (strlen($page) < 1) {
    $page = 'terms';
}
$mno_system_package = $db_query->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id` = '$user_distributor'");
$isDynamic = package_functions::isDynamic($mno_system_package);

$camp_layout = $template_id;

$modify_st = '';

if (strlen($theme_id) < 1) {
    if ($isDynamic) {
        $theme_id = $db_query->getValueAsf("select `theme_code` AS f from `mdu_themes` where `distributor_code`='$user_distributor' and `theme_name` like '%Default THEME'");
    } else {
        $theme_id = 'DEFAULT_THEME_' . $template_id;
    }
}

if (strlen($modify_id) > 0) {
    $modify_st = '1';
}

$sup_mobile = $api_db->getPackageOptions($system_package, 'SUPPORT_NUMBER');

$base_url = trim($db_query->setVal('mdu_portal_base_url', 'ADMIN'), "/");
$portal_base_url = trim($db_query->setVal('portal_base_url', 'ADMIN'), "/");
$base_path = $base_url;
$portal_base_folder = trim($db_query->setVal('mdu_portal_base_folder', 'ADMIN'), "/");
$global_url = trim($db_query->setVal('global_url', 'ADMIN'), "/");


require_once "../../" . $portal_base_folder . "/lib/template_engine/BladeOne.php";
$compile = __DIR__ . '/../../' . $portal_base_folder . '/lib/template_engine/compiles';
$view = __DIR__ . '/../../' . $portal_base_folder . '/layout';

$distributor_data = $db_query->select1DB("SELECT d.system_package , d.`distributor_code`, d.`wired`,d.`bussiness_type` FROM exp_mno_distributor d JOIN mdu_distributor_organizations o ON d.`distributor_code`= o.`distributor_code` WHERE o.`property_id`= '$redirect_property_id'");
$user_distributor_vertical = $distributor_data['bussiness_type'];

$theme_data = $db_query->select1DB("SELECT * FROM mdu_themes WHERE theme_code = '$theme_id'");

$portal_title_val = $theme_data['title'];
/*$style_type_val = $theme_data->style_type;*/
$camp_theme_color = $theme_data['theme_color'];
$camp_btn_color = $theme_data['btn_color'];
$camp_btn_secondary_color = $theme_data['btn_secondary_color'];
$camp_bg_color = $theme_data['bg_color'];
$camp_f_bg_color = $theme_data['footer_color'];
//$welcome_text = $theme_data->welcome_text;
$welcome_des = $theme_data['welcome_des'];
/*$top_line_color_val = $theme_data->top_line_color;*/

$favicon = $theme_data['favcon'];
$login_logo_val = $theme_data['login_screen_logo'];
$lop_logo_val = $theme_data['top_logo'];
// $contact_us = $theme_data['contact_us'];
$contact_us = urldecode($_COOKIE["theme_contactus"]);
$login_img1 = $theme_data['login_img'];
$theme_details_id = $theme_data['theme_details_id'];
$chatbot_support = "";
if ($chatbot == "true") {
    $contact_us = "";
    $chatbot_support = "on";
    $browser_msg = "<i data-toggle='tooltip' title='If you are having issues with the Support link on this device, please use a different browser.' class='icon icon-question-sign'></i>";
    $chatbot_tag = "<style>.chatbot_div img{ max-width: 40px;margin-right: 3px;margin-bottom: 5px;padding: 0px; } .chatbot_div{ text-align:center }</style><div class='chatbot_div'><a id='chatbot' class='signup' target='_blank' href='" . $chatbot_url . "'> Support " . $browser_msg . "</a></div>";
}
if ($action != 'view') {

    if (strlen($enc) < 1) {
        $rowe = $db_query->select1DB("SHOW TABLE STATUS LIKE 'mdu_themes_details'");
        //$rowe = mysql_fetch_array($br);
        $auto_inc = $rowe['Auto_increment'];
        $db_query->execDB("INSERT INTO `mdu_themes_details` (
            `unique_id`,
            `theme_data`,
            `create_date`,
            `updated_by`
        )SELECT 
            '$auto_inc',
            `theme_data`,
            `create_date`,
            `updated_by` FROM `mdu_themes_details` WHERE `unique_id`='$theme_details_id'");

        $theme_details_id = $auto_inc;
    } else {
        $theme_details_id = $enc;
    }
}


$style_str = "<style> ";
$query = "SELECT theme_data AS f FROM mdu_themes_details WHERE unique_id = '$theme_details_id'";
$row = $db_query->getValueAsf($query);
//while($row=mysql_fetch_array($query_results)){
$theme_data = json_decode($row, true);
foreach ($theme_data['contenteditable_arr'] as $key => $value) {
    $x = $value['element'];
    $$x = '<' . $value['element'] . ' data-max-length="' . $value['max-length'] . '">' . $value['value'] . '</' . $value['element'] . '>';
}
$upCss = array();
foreach ($theme_data['upload_arr'] as $key => $value) {
    if (strlen($value['value']) > 0) {
        if ($value['folder'] == 'logo') {
            $theme_logo = $value['value'];
            if ($value['alt-txt'] == 'enabled' && $value['alt-txt-save'] == 'saved') {
                $theme_logo = $value['alt-txt-value'];
                $theme_def_logo = $value['value'];
            }

            if ($value['element'] == '.login_screen_logo') {
                $login_screen_logo_val = $value['value'];
            }
            if ($value['element'] == '.login_img') {
                $login_img1 = $value['value'];
                $login_img_2 = $value['value'];
            }
            if ($value['element'] == '.index-body') {
                $lop_logo_val = $value['value'];
            }
        }
        if ($value['folder'] == 'bg') {
            $theme_bg_image = $value['value'];
            $theme_bg_image_4to = $value['value'];
            $theme_bg_image_4to_path = 'bg';
        }
        if ($value['folder'] == 'verticle_img') {
            $theme_verticle_image_name = $value['value'];
        }
        if ($value['folder'] == 'Horizontal_img') {
            $theme_horizontal_image_name = $value['value'];
        }
        if ($value['folder'] == 'other') {
            if ($value['element'] == '[upload_img_1]') {
                $upload_img_1 = $value['value'];
            }
            if ($value['element'] == '[upload_img_2]') {
                $upload_img_2 = $value['value'];
            }
            if ($value['element'] == '[upload_img_3]') {
                $upload_img_3 = $value['value'];
            }
        }
    }
    $upCss[$value['element']] = $value['css'];
}
foreach ($theme_data['color_arr'] as $key => $value) {
    if (strpos($value['value'], '!important') !== false) {
        $style_str .= $value['element'] . ' {  ' . $value['property'] . ': ' . $value['value'] . ' } ';
    } else {
        $style_str .= $value['element'] . ' {  ' . $value['property'] . ': ' . $value['value'] . ' !important } ';
    }
}
// foreach ($theme_data['mce_arr'] as $key => $value) {
//     $contact_us = $value['value'];
// }

//}
$style_str .= "</style> ";

if ($action != 'view') {
    $editable = $theme_data;
}

if ($from_theme_upload == 'true') {
    $editable = $theme_data;
}

/* if (strlen($theme_logo)) {
        if (pathinfo($theme_logo, PATHINFO_EXTENSION)) {
    
            $theme_logo = '<div class="logo"><img alt="" class="img-responsive2" src="gallery/bg/' . $theme_logo . '" style="" /></div>';
    
        } else {
    
            $theme_logo = '<h1>' . $theme_logo . '</h1>';
        }
    } else {
    
        $theme_logo = '<div class="logo"><img alt="" class="img-responsive" src="img/generic_logo.png" style="" /></div>';
    } */

//CAPTIVE_HELP_TEXT
$helps = $db_query->getEmailTemplate('CAPTIVE_HELP_TEXT', $system_package, 'MVNO', $user_distributor);
$helps_details = json_decode($helps[0]['text_details']);
//print_r($helps);
$help_link = $helps_details->help_text_config;
$help_txt = $helps_details->support_language;
$help_content = $helps_details->support_content;
$help_link_txt = $helps[0]['title'];

$bodies = $style_str;
$login_style = $db_query->getValueAsf(sprintf("SELECT `login_style` as f FROM `mdu_template` WHERE `template_code` =%s", $db_query->GetSQLValueString($camp_layout, "text")));

if ($login_style == 'old') {
    $registration_type = 'Old_login';
} else {
    $registration_type = 'New_login';
}
require_once '../../' . $portal_base_folder . '/src/registration/' . $registration_type . '/index.php';

$script = '';
if ($MMFailed == '1' || $login_style == 'old') {
    $script = "$(document).ready(function () {
        login_bt();
    });";
}

$headers = '<base href="' . $base_path . '/" target="_blank" />
<script type="text/javascript" src="' . $global_url . '/js/jquery.min.js"></script>
<script type="text/javascript" src="' . $global_url . '/plugins/img_upload/croppic_theme.js?v=' . preg_replace("/[^0-9]/", "", $db_query->setVal('footer_copy', 'ADMIN')) . '"></script>
<link href="' . $global_url . '/plugins/img_upload/assets/css/croppic.css" rel="stylesheet">
<script type="text/javascript" src="' . $global_url . '/plugins/theme_create/js/maxlength-contenteditable.js"></script>
<script type="text/javascript"> $(window).on("load", function() { maxlengthContentEditable(); });

function avoid(){
    return false;
}

function login_bt() {

    document.getElementById("login_main").setAttribute("style", "display:none");
    document.getElementById("login_form").setAttribute("style", "display:block");
    $("#main-login-voucher").hide();
    }
    ' . $script . '
</script>
<script src="' . $global_url . '/js/sweetalert.min.js"></script>
<script type="text/javascript" src="' . $global_url . '/js/spectrum.js"></script>
<link rel="stylesheet" href="' . $global_url . '/css/jquery-ui.css">
<link rel="stylesheet" href="' . $global_url . '/css/spectrum.css">
<link rel="stylesheet" href="' . $global_url . '/plugins/theme_create/css/mdu-theme-create-int.css?v=' . preg_replace("/[^0-9]/", "", $db_query->setVal('footer_copy', 'ADMIN')) . '">';

if (strlen($favicon) && $camp_layout != "DYNAMIC") {
    $headers .= '<link rel="shortcut icon" href="img/logo/' . $favicon . '">';
}


if (strlen($camp_layout) == "0") {
    $camp_layout = "SUDDENLINK_OLD";
}

if (!isset($lop_logo_val) || $lop_logo_val == "") {
    $login_screen_logo_path = 'layout/' . $camp_layout . '/img/logo.png';
} else {
    $login_screen_logo_path = 'img/logo/' . $lop_logo_val;
}

if (!isset($login_img1) || $login_img1 == "") {
    $login_img1 = 'background.jpg';
}

if (!isset($login_img_2) || $login_img_2 == "") {
    $login_img_path = 'layout/' . $camp_layout . '/img/background.jpg';
} else {
    $login_img_path = 'img/logo/' . $login_img_2;
}

$login_img = '<div id="login_img" class="login_img" border="0" style="max-width:500px;display: block;margin-top: 13px"><img data-name="' . $login_img1 . '" style="max-width: 100%;" src="img/logo/' . $login_img1 . '" /></div>';


$_LOGO_ = '<div class="login_screen_logo" style="margin-left:0px"><img style="max-width: 100%;" data-name="' . $login_screen_logo_val . '" alt="" src="img/logo/' . $login_screen_logo_val . '"  /></div>';

//require_once '../../'.$portal_base_folder.'/layout/'.$camp_layout.'/index.php';
$headers .= '<link href="' . $base_url . '/layout/' . $camp_layout . '/css/pages/signin.css?v=23" rel="stylesheet" type="text/css">';

$check_file = '../../' . $portal_base_folder . '/layout/' . $camp_layout . '/terms.php';
$terms_file = '../../' . $portal_base_folder . '/layout/' . $camp_layout . '/terms.php?property_id=' . $redirect_property_id;

if (!file_exists($check_file)) {
    $terms_file = 'terms.html';
}

require_once '../../' . $portal_base_folder . '/layout/' . $camp_layout . '/navbar.php';

if (isset($login_screen_logo_val) && $login_screen_logo_val != "" && ($isDynamic)) {
    $logo = '<img class="login_screen_logo" src="layout/' . $camp_layout . '/img/' . $login_screen_logo_val . '" border="0" style="max-width:150px"/>';
} elseif (isset($login_screen_logo_val) && $login_screen_logo_val != "") {
    $logo = '<img class="login_screen_logo" src="img/logo/' . $login_screen_logo_val . '" border="0" style="max-width:150px"/>';
}

if (isset($login_logo_val) && $login_logo_val != "" && ($isDynamic)) {
    $logo_path = 'img/logo/' . $login_logo_val;
}

if (isset($welcome_des) && $welcome_des != "") {
    $welcome_des = '<p style="margin-top: 8px;line-height: normal;">' . $welcome_des . '</p>';
} else {
    $welcome_des = '';
}

$preview_mode = '';
$account_create = '';
$mainform = '';
if (strlen($preview_theme_code > '0')) {
    $preview_mode .= '<style> .account-container{ position: relative; } </style><div style="width: 100%;height: 100%;position: absolute;z-index: 33333333;"></div>';

    if ($dpsk_enable && $dpsk_voucher_enable == 1) {
        if ($sign_status) {
            $account_create = '<a class="button btn btn-large" onclick="voucher_bt()" style="border-radius: 8px;font-size: 19px;width: 85%;"> New Account </a>';
        }
    } else {
        $account_create = '<a class="button btn btn-large" href="javascript:void(0);" style="border-radius: 8px;font-size: 19px;width: 85%;"> Register </a>';
    }

    $add_d = '';

    if (isset($_GET['Redirect'])) {
        $add_d = "&Redirect='true'";
    }

    $mainform = '<form autocomplete="off" id="log_form" class="form-horizontal" target="_self" onSubmit="avoid()" action="javascript:void(0);" method="get" autocomplete="off">';
    $rest_link = '<a href="javascript:void(0)" target="_self" class="forgot_pass" style="font-size: 12px;">Forgot Password?</a>';
} else {
    if ($dpsk_enable && $dpsk_voucher_enable == 1) {
        if ($sign_status) {
            $account_create = '<a class="button btn btn-large" onclick="voucher_bt()" style="border-radius: 8px;font-size: 19px;width: 85%;"> New Account </a>';
        }
    } else {
        $account_create = '<a class="button btn btn-large" href="javascript:void(0);" style="border-radius: 8px;font-size: 19px;width: 85%;"> Register </a>';
    }

    $add_d = '';

    if (isset($_GET['Redirect'])) {
        $add_d = "&Redirect='true'";
    }

    $mainform = '<form autocomplete="off" id="log_form" class="form-horizontal" target="_self"  onSubmit="avoid()" action="javascript:void(0);" method="get" autocomplete="off">';
    $rest_link = '<a href="javascript:void(0);" target="_self" class="forgot_pass" style="font-size: 12px;">Forgot Password?</a>';
}

$dpsk_div = '';

if ($dpsk_enable && $dpsk_voucher_enable == 1) {
    $dpsk_div .= '<div  class="warning-msg"><br>';
    $dpsk_div .= '<p style="text-align: center;font-weight: bolder; margin-bottom: -2px;"><img src="layout/' . $camp_layout . '/img/warning-icon.png" style="height:20px;">On Android 10 Devices, please  
	disable MAC randomization';
    $dpsk_div .= '<i title="<b>How to Disable MAC Randomization in Android 10 (Android Q)</b><br><ol><li>Open <b>Settings</b> on your device.</li><li>Select <b>Network and Internet</b>.</li><li>Select <b>Wi-Fi</b>.</li><li>Connect to the <b>TEMPORARY Onboarding Wi-Fi network</b>.</li><li>Tap the <b>Gear icon</b> next to the current Wi-Fi connection.</li><li>Select <b>Advanced</b>.</li><li>Select <b>Privacy</b>.</li><li>Select <b>\'Use device MAC\'</b>.</li><li>You will need to repeat these steps when connecting  to the <b>SECURE Resident Wi-Fi Network</b>.</li></ol>" class="icon icon-question-sign tooltips" style="color : #078cc5;margin-top: 3px;font-size: 18px"></i></p></div>';
}

$login_fields = '';

$login_extra = 'New User? <a class="signup" target="_self" href="javascript:void(0)">Sign Up Here</a>';

if ($MMFailed == '0') {
    $login_fields = '<div class="alert alert-success"> Login successful. Redirecting....</div>';
} else {

    if ($MMFailed == '1') {
        $login_fields .= '<font size="small" color="red"  align="center" style="font-weight:bold" class="err_msg">' . $MMFailedMassage . '</font> <br><br>';
    }

    $login_fields .= '<div class="login-fields">' . $login_field_data . '<div class="field toc form-group field-remember">';
    $checked = '';
    $checked2 = '';
    if (isset($_COOKIE['ckey'])) {
        $checked = 'checked';
    }
    $login_fields .= '<input  type="checkbox" id="remember" name="remember" autocomplete="off"  style="display: inline-block;width: 15px;height: 15px;" class="form-control" ' . $checked . '><span style="display: inline-block;">Remember me</span>';
    $login_fields .= $rest_link . '</div>';
    if (isset($_COOKIE['agreecheck'])) {
        $checked2 = 'checked';
    }
    $login_fields .= '<div class="field toc form-group field-agree" style="display:none; "><input  type="checkbox" id="agreecheck"  name="agreecheck" checked autocomplete="off"  style="width: 15px;height: 15px;margin-top: -2px" class="form-control" ' . $checked2 . '>';
    $login_fields .= 'I agree to <a href="' . $terms_file . '" id="pre_id"  class="fancybox fancybox.iframe"  style="margin-top:0px ">Terms of Use</a><br><span style="color:red;" id="terms" hidden="true">Please agree to the terms</span></div><div class="form-group message_h"><div id="messages"></div></div></div>';
    $login_fields .= '<div class="login-actions"><button type="submit" id="ligin_btn" name="sign_in" class="button btn btn-large"   style="background-color: ' . $camp_theme_color . ';" ><font color="white">Log In</font></button></div>';
    $login_fields .= $login_extra;
}

$mainform .= $login_fields . '</form>';
//require_once 'layout/'.$camp_layout.'/login.php';
$dpsk_err = '';
if (isset($dpsk_error_msg)) {
    $dpsk_err = $dpsk_error_msg;
    unset($dpsk_error_msg);
}

//$js_cash_mode = $api_db->getCashMode('js','js');
$script_blade = new \eftec\bladeone\BladeOne(__DIR__, $compile, \eftec\bladeone\BladeOne::MODE_AUTO);

$bodies .= $script_blade->run('js.mdu-theme-create-js', [
    "_GLOBAL_URL_" => $global_url,
    "_TEMPLATE_NAME_" => $theme_template_name,
    "_MODIFY_ST_" => $modify_st,
    "_MODIFY_ID_" => $modify_id,
    "_UPCSS_" => $upCss,
    "_EDITABLE_" => $editable,
    "_ENC_" => $theme_details_id,
    "_ACTION_" => $action,
    "_FROM_THEME_UPLOAD_" => $from_theme_upload,
    "_USER_DISTRIBUTOR_" => $user_distributor,
    "_REG_TYPE_" => $registration_type,
    "_BASE_URL_" => $base_url,
    "_PAGE_" => $page,
    "_BI_V_" => preg_replace("/[^0-9]/", "", $db_query->setVal('footer_copy', 'ADMIN'))
]);

/*Template engine start*/
// $form_tmpl_cash_mode = $api_db->getCashMode($camp_layout,'Main');
$blade = new \eftec\bladeone\BladeOne($view, $compile, \eftec\bladeone\BladeOne::MODE_AUTO);
$blade->setFileExtension('.Template.html');

//$reg_cash_mode = $api_db->getCashMode($ret_cash_tmpl,'return');
require_once '../../' . $portal_base_folder . '/src/registration/' . $registration_type . '/index.php';

$greeting_txt = $greeting_txt . ' Review and agree to the Terms of Use, click SUBMIT and you’ll be on your way.';

$accept_checkbox_id = 'click_reg_submit_accept_toc_check';

$submit_button_id = 'click_reg_submit_unique_button';
$tocLink = $base_url . "/toc.php?distributor=" . $distributor_code . "&mno=" . $mno . "&captive_toc_type=" . $captive_toc_type;

$scp_version = $db_query->setVal('footer_copy', 'ADMIN');

$header_logo = 'top-logo';
$top_logo = 'myatt-logo';
if (file_exists('../../'.$portal_base_folder.'/layout/'.$camp_layout.'/img/'.$header_logo.'_'.strtolower($user_distributor_vertical).'.png')) {
	$header_logo = $header_logo.'_'.strtolower($user_distributor_vertical);
}

if (file_exists('../../'.$portal_base_folder.'/layout/'.$camp_layout.'/img/'.$top_logo.'_'.strtolower($user_distributor_vertical).'.png')) {
	$top_logo = $top_logo.'_'.strtolower($user_distributor_vertical);
}

$template = $camp_layout . ".Main";
echo $blade->run($template, [
    "_ACCEPT_CHECKBOX_ID_" => $accept_checkbox_id,
    "_HEAD_" => $headers,
    "_TITLE_" => $portal_title_val,
    "_SUBMIT_BUTTON_ID_" => $submit_button_id,
    "_INPUTS_" => $inputs,
    "_TOC_LINK_" => $tocLink,
    "_WELCOME_TXT_" => $welcome_txt,
    "_GREETING_TEXT_" => $greeting_txt,
    "_REG_BUTTON_TXT_" => $registration_btn,
    "_REGISTRATION_FORM_" => $reg_form,
    "_FORM_" => $mainform,
    "_ACCOUNT_CREATE_" => $account_create,
    "_ACCOUNT_CREATE_TXT_" => $dpsk_div,
    "_CAMP_BG_COLOR_" => $camp_bg_color,
    "_CAMP_BTN_COLOR_" => $camp_btn_color,
    "_CAMP_THEME_COLOR_" => $camp_btn_secondary_color,
    "_CAMP_BTN_SECONDARY_COLOR_" => $camp_theme_color,
    "_CAMP_LAYOUT_" => $camp_layout,
    "_LOGIN_SCREEN_PATH_" => $login_screen_logo_path,
    "_LOGIN_SCREEN_LOGO_" => $lop_logo_val,
    "_LOGIN_IMG_PATH_" => $login_img_path,
    "_LOGIN_IMG_2_" => $login_img_2,
    "_BODY_" => $bodies,
    "_LOGO_" => $_LOGO_,
    "_LOGO_PATH_" => $logo_path,
    "_LOGIN_IMG_" => $login_img,
    "_WELCOME_DES_" => $welcome_des,
    "_CONTACT_US_" => $contact_us,
    "_CHATBOT_" => $chatbot_tag,
    "_CHATBOT_SUPPORT_" => $chatbot_support,
    "_SCP_VERSION_" => $scp_version,
    "_PROPERTY_ID_" => $redirect_property_id,
    "_FAVICON_" => $favicon,
    "_REST_LINK_" => $rest_link,
    "_HEADER_LOGO_" => $header_logo.'.png',
	"_TOP_LOGO_" => $top_logo.'.png',
]);
