<?php

// $theme_template_name = $_GET['template_name'];
// if($theme_template_name==''){
//     echo"Invalid Request";
//     exit();
// }

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL&~E_WARNING&~E_NOTICE);

require_once __DIR__.'/../../classes/dbClass.php';
require_once __DIR__.'/../../classes/dbApiClass.php';
require_once __DIR__.'/../../classes/systemPackageClass.php';

$extt = 0;
$db_query = new db_functions();
$api_db = new api_db_functions();
$package_functions=new package_functions();
$template_id = $_GET['template_name'];
$registration_type = $_GET['reg_type'];
$theme_id = $_GET['theme_id']; //if strlen($theme_id)>0 = modify theme
$enc = $_GET['enc']; //if strlen($enc)>0 = already created theme details ID  
$action = $_GET['action'];
$page = $_GET['page'];
$from_theme_upload = 'false';
$modify_st = $_GET['modify_st'];
$bi_v = preg_replace("/[^0-9]/","",$db_query->setVal('footer_copy','ADMIN'));
if(isset($_GET['from_theme_upload'])){
    $from_theme_upload = 'true';
}

if(isset($_COOKIE['host_tc_url'])){
    $host_tc_url = $_COOKIE['host_tc_url'];
}else{
    $host_tc_url = "https://www.klydewarrenpark.org/legal/privacy-policy.html";
}
if(isset($_COOKIE['sponsor_tc_url'])){
    $privacy_policy_url = $_COOKIE['sponsor_tc_url'];
}else{
    $privacy_policy_url = "http://www.dallasnews.com/privacy-policy";
}

$reg_type_changed = 'false';

$user_distributor = $_GET['dist'];


$query = "SELECT d.bussiness_type,d.mno_id,m.`system_package` AS mno_package,d.property_id,d.system_package FROM exp_mno_distributor d,exp_mno m WHERE `distributor_code`='$user_distributor' AND d.mno_id=m.`mno_id`";
    $query_arr = $db_query->selectDB($query);
    if($query_arr['rowCount']>0){
        foreach ($query_arr['data'] as $row){
            $bussiness_type = $row['bussiness_type'];
            $mno = $row['mno_id'];
            $mno_package = $row['mno_package'];
            $system_package = $row['system_package'];
            $prop_id = $row['property_id'];
        }
    }

    $reg_first_name = 1;
    $reg_last_name = 1;
    $reg_email = 1;
    $reg_gender = 1;
    $age_group = 1;
    $mobile_number = 1;

    $man_query = "SELECT * FROM exp_manual_reg_profile WHERE `distributor`='$mno'";
    $man_query_arr = $db_query->selectDB($man_query);

    if($man_query_arr['rowCount']>0){
        foreach ($man_query_arr['data'] as $row){
            $reg_first_name = $row['first_name'];
            $reg_last_name = $row['last_name'];
            $reg_email = $row['email'];
            $reg_gender = $row['gender'];
            $age_group = $row['age_group'];
            $mobile_number = $row['mobile_number'];
        }
    }

if($from_theme_upload == 'true'){
   $mno_package = $_GET['mno_package'];
   $system_package = $_GET['mvno_package'];
}

if(strlen($theme_id)>0){
    $row_check = $db_query->select1DB("SELECT template_name,registration_type FROM exp_themes WHERE theme_id = '$theme_id' LIMIT 1");
    $old_template_name = $row_check['template_name'];
    $old_registration_type = $row_check['registration_type'];
    if($template_id!=$old_template_name){
        $theme_id = '';
    }
    if($registration_type!=$old_registration_type){
         $reg_type_changed = 'true';
    }
}else{
    $theme_id = $package_functions->getOptions('WYSIWYG_DEFAULT_THEME', $system_package);
}

if(strlen($page) < 1){
    $page = 'theme_s';
}


    $camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $system_package); 

    $query = "SELECT default_theme,settings FROM exp_template WHERE `template_id`='$template_id'";
    $query_arr = $db_query->selectDB($query);
    $template_settings = json_decode($query_arr['data'][0]['settings'],true);

if(strlen($theme_id)<1 || $reg_type_changed=='true'){
    $theme_id = $package_functions->getOptions('WYSIWYG_DEFAULT_THEME', $system_package);

    if(strlen($theme_id)<1){
        if($query_arr['rowCount']>0){
            foreach ($query_arr['data'] as $row){
                if($registration_type=='AUTH_DISTRIBUTOR_PASSCODE'){
                    $theme_id=$row['default_theme'].'_pas';
                }else{
                    $theme_id=$row['default_theme'].'_'.$registration_type;
                }
            }
    
            $theme_id_check = $db_query->getValueAsf("SELECT theme_id AS f FROM exp_themes WHERE theme_id = '$theme_id' LIMIT 1");
            if(strlen($theme_id_check)<1){
                $theme_id = $row['default_theme'];
            }
            $theme_id;
        }
    }
}
$sup_mobile = $api_db->getPackageOptions($system_package, 'SUPPORT_NUMBER');

$base_url = trim($db_query->setVal('portal_base_url', 'ADMIN'), "/");
$portal_base_folder = trim($db_query->setVal('portal_base_folder', 'ADMIN'), "/");
$global_url = trim($db_query->setVal('global_url', 'ADMIN'), "/");
$theme_data_set = $db_query->getTheme($theme_id,'en');
$theme_name_set = $theme_data_set[0]['theme_name'];
// $registration_type = $theme_data_set[0]['registration_type'];
$title = $theme_data_set[0]['title'];
$welcome_txt = $theme_data_set[0]['welcome_txt'];
$greeting_txt = $theme_data_set[0]['greeting_txt'];
$registration_btn = $theme_data_set[0]['registration_btn'];
$theme_logo = $theme_data_set[0]['theme_logo'];
$btn_color = $theme_data_set[0]['btn_color'];
$btn_border = $theme_data_set[0]['btn_border'];
$bg_color_1 = $theme_data_set[0]['bg_color_1'];
$bg_color_2 = $theme_data_set[0]['bg_color_2'];
$font_color_1 = $theme_data_set[0]['font_color_1'];
$hr_color = $theme_data_set[0]['hr_color'];
$login_secret_field = $theme_data_set[0]['login_secret_field'];
$btn_color_disable = $theme_data_set[0]['btn_color_disable'];
$btn_text_color = $theme_data_set[0]['btn_text_color'];
$theme_bg_image = $theme_data_set[0]['theme_bg_image'];
$theme_template_name = $theme_data_set[0]['template_name'];
$theme_verticle_image_name = $theme_data_set[0]['theme_verticle_image'];
$theme_horizontal_image_name = $theme_data_set[0]['theme_horizontal_image'];
$theme_details_id = $theme_data_set[0]['theme_details_id']; 

if($action!='view'){

    if(strlen($enc)<1 || $reg_type_changed=='true'){
        $rowe = $db_query->select1DB("SHOW TABLE STATUS LIKE 'exp_themes_details'");
        //$rowe = mysql_fetch_array($br);
        $t_data_q = $db_query->select1DB("SELECT `theme_data` FROM `exp_themes_details` WHERE `unique_id`='$theme_details_id'");
        $auto_inc = $rowe['Auto_increment'];
        $t_data = json_decode($t_data_q['theme_data'],true);

        foreach ($t_data['upload_arr'] as $key => $value) {
            if(strlen($value['value'])>0){
                $exp_v = explode('.',$value['value']);
                $vert_path = $exp_v[0].'_'.strtolower($bussiness_type).'.'.$exp_v[1];
                $ver_full_path = '../../'.$portal_base_folder.'/template/'.$theme_template_name.'/gallery/'.$value['folder'].'/'.$vert_path;
                if(file_exists($ver_full_path)){
                    $value['value'] = $vert_path;
                    $t_data['upload_arr'][$key] = $value;
                }
            }
        }

        $t_data = $db_query->escapeDB(json_encode($t_data));
         $in_q = "INSERT INTO `exp_themes_details` (
            `unique_id`,
            `theme_data`,
            `create_date`,
            `updated_by`
        )VALUES
            (
            '$auto_inc',
            '$t_data',
            NOW(),
            '$user_distributor')";
        $db_query->execDB($in_q);
        
        $theme_details_id = $auto_inc;
    }else{
        $theme_details_id = $enc;
    }   
}
$text = $db_query->textVal_vertical("TOC", $mno, $bussiness_type);

if (strlen($text) == 0) {
    $text = $db_query->textVal("TOC", $mno_package);
}


$isDynamic = package_functions::isDynamic($mno_package);
$primary_color = '';
if($isDynamic){
    $primary_color = $package_functions->getOptionsBranding('PRIMARY_COLOR', $mno_package);
}

    // $welcome_txt = $theme_data_set[0]['theme_details_id'];
    $style_str = "<style> ";
    $query = "SELECT theme_data AS f FROM exp_themes_details WHERE unique_id = '$theme_details_id'";
    $row=$db_query->getValueAsf($query);
    $theme_data = json_decode($row,true);
    if(array_key_exists("main",$template_settings)){
        foreach ($template_settings['main'] as $key => $value) {
            foreach ($value as $value1) {
                if(array_key_exists("element",$value1)){
                    $check_has_key = false;
                    foreach ($theme_data[$key] as $key2 => $value2) {
                        if(array_key_exists("element",$value2)){
                            if($value2['element']==$value1['element']){
                                $check_has_key = true;
                                break;
                            }
                        }
                    }
                    if(!$check_has_key){
                        array_push($theme_data[$key],$value1);
                    }
                }
            }
        }
    }
    
	//while($row=mysql_fetch_array($query_results)){
        
        foreach ($theme_data['contenteditable_arr'] as $key => $value) {
            $x = $value['element'];
            $$x = '<'.$value['element'].' data-max-length="'.$value['max-length'].'">'.$value['value'].'</'.$value['element'].'>';
        }
        $upCss = array();
        foreach ($theme_data['upload_arr'] as $key => $value) {
            if(strlen($value['value'])>0){
                if($value['element']=='.logo'){
                    if (!array_key_exists('alt-txt', $value)) {
                        $theme_data['upload_arr'][$key]['alt-txt'] = "enabled";
                        $theme_data['upload_arr'][$key]['alt-txt-value'] = "Logo Text";
                        $theme_data['upload_arr'][$key]['alt-txt-save'] = "notsaved";
                    }
                }
                if($value['folder']=='logo'){
                    $theme_logo = $value['value']; 
                        if($value['alt-txt']=='enabled' && $value['alt-txt-save']=='saved'){
                            $theme_logo = $value['alt-txt-value'];
                            $theme_def_logo = $value['value'];
                        }
                        
                }
                if($value['folder']=='bg'){
                    $theme_bg_image = $value['value'];
                    $theme_bg_image_4to = $value['value'];
                    $theme_bg_image_4to_path = 'bg';
                }
                if($value['folder']=='verticle_img'){
                    $theme_verticle_image_name = $value['value'];
                }
                if($value['folder']=='Horizontal_img'){
                    $theme_horizontal_image_name = $value['value'];
                }
                if($value['folder']=='other'){
                    if($value['element']=='[upload_img_1]'){
                        $upload_img_1 = $value['value'];
                    }
                    if($value['element']=='[upload_img_2]'){
                        $upload_img_2 = $value['value'];
                    }
                    if($value['element']=='[upload_img_3]'){
                        $upload_img_3 = $value['value'];
                    }
                }

            }
            $upCss[$value['element']] =$value['css'];
        }
        foreach ($theme_data['color_arr'] as $key => $value) {
            if (strpos($value['value'], '!important') !== false) {
                $style_str .= $value['element'].' {  '.$value['property'].': '.$value['value'].' } ';
            }else{
                $style_str .= $value['element'].' {  '.$value['property'].': '.$value['value'].' !important } ';
            }

            if(strlen($value['disabled-color-value'])>0){
                if (strpos($value['disabled-color-value'], '!important') !== false){ 
                    $style_str .= $value['element'].'[disabled] {  '.$value['property'].': '.$value['disabled-color-value'].' } ';
                }else{
                    $style_str .= $value['element'].'[disabled] {  '.$value['property'].': '.$value['disabled-color-value'].' !important ; } ';
                }
            }
        }
        $style_2 = "<style id='field_color_style'> ";
        $style_3 = "<style id='field_bg_style'> ";

        if(isset($theme_data['field_color_arr'])){
            if(!empty($theme_data['field_color_arr'])){
                if(strlen($theme_data['field_color_arr']['bg-color'])>0){
                    $style_3 .= '.survey-form .input { background : '.$theme_data['field_color_arr']['bg-color'].'} ';
                    $style_3 .= '.nice-select .list { background : '.$theme_data['field_color_arr']['bg-color'].'} ';
                    $style_3 .= '.nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus  { background : '.$theme_data['field_color_arr']['bg-color'].' } ';
                }
                if(strlen($theme_data['field_color_arr']['font-color'])>0){
                    $style_2 .= ' ::-webkit-input-placeholder { color : '.$theme_data['field_color_arr']['font-color'].' } ';
                    $style_2 .= ' ::-moz-placeholder { color : '.$theme_data['field_color_arr']['font-color'].' } ';
                    $style_2 .= ' :-ms-input-placeholder { color : '.$theme_data['field_color_arr']['font-color'].' } ';
                    $style_2 .= ' :-moz-placeholder { color : '.$theme_data['field_color_arr']['font-color'].' } ';
                    $style_2 .= ' .form-element .input input { color : '.$theme_data['field_color_arr']['font-color'].' } ';
                    $style_2 .= ' .nice-select.ele .current, .nice-select, .nice-select .option.disabled { color : '.$theme_data['field_color_arr']['font-color'].'} .nice-select:after { border-color : '.$theme_data['field_color_arr']['font-color'].' }';
                    $style_2 .= ' input:-webkit-autofill,input:-webkit-autofill:hover,input:-webkit-autofill:focus,input:-webkit-autofill:active { -webkit-text-fill-color : '.$theme_data['field_color_arr']['font-color'].'}';
                }
            }
        }
        
    //}
    $style_str .= "</style> ";
    $style_2 .= "</style> ";
    $style_3 .= "</style> ";
    $style_str .= $style_2.$style_3;
    if($action!='view'){
        $editable = $theme_data;
    }

    if($from_theme_upload =='true'){
        $editable = $theme_data;
    }

/*Template engine start*/
require_once "../../".$portal_base_folder."/lib/template_engine/BladeOne.php";

$compile = __DIR__.'/../../'.$portal_base_folder.'/lib/template_engine/compiles';
$view = __DIR__.'/../../'.$portal_base_folder.'/template';
$blade = new \eftec\bladeone\BladeOne($view, $compile, \eftec\bladeone\BladeOne::MODE_AUTO);
$blade->setFileExtension('.Template.html');
$template = $theme_template_name . ".Main";

require_once '../../'.$portal_base_folder.'/src/registration/' . $registration_type . '/index-preview.php';
$css = "";
if(file_exists('../../css/fonts/css.css')){
    $css .= '<link rel="stylesheet" href="'.$global_url.'/css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600">';
}
if(file_exists('../../'.$portal_base_folder.'/src/registration/' . $registration_type . '/css/reg.style.css')){
    $css .= '<link rel="stylesheet" href="'.$base_url.'/src/registration/' . $registration_type . '/css/reg.style.css">';
}
if(file_exists('../../layout/' . $camp_layout . '/css/theme_create.css')){
    $css .= '<link rel="stylesheet" href="'.$global_url.'/layout/' . $camp_layout . '/css/theme_create.css">';
}
$base_path = $base_url.'/template/'.$theme_template_name;
$theme_verticle_image = $base_path.'/gallery/verticle_img/'.$theme_verticle_image_name;
$theme_horizontal_image = $base_path.'/gallery/Horizontal_img/'.$theme_horizontal_image_name;
$headers = '<base href="'.$base_path.'/"  target="_blank" />
<script type="text/javascript" src="'.$global_url.'/js/jquery.min.js"></script>
<script type="text/javascript" src="'.$global_url.'/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="'.$global_url.'/plugins/img_upload/croppic_theme.js?v='.$bi_v.'"></script>
<link href="'.$global_url.'/plugins/img_upload/assets/css/croppic.css" rel="stylesheet">
<script type="text/javascript" src="'.$base_url.'/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="'.$global_url.'/plugins/theme_create/js/maxlength-contenteditable.js"></script>
<script type="text/javascript"> $(window).on("load", function() { maxlengthContentEditable(); });</script>
<script src="'.$global_url.'/js/sweetalert.min.js"></script>
<script type="text/javascript" src="'.$global_url.'/js/spectrum.js"></script>
<link rel="stylesheet" href="'.$global_url.'/css/jquery-ui.css">
<link rel="stylesheet" href="'.$base_url.'/css/jquery.fancybox.css">
<link rel="stylesheet" href="'.$global_url.'/css/spectrum.css">
<link rel="stylesheet" href="'.$global_url.'/plugins/theme_create/css/theme-create-int.css?v='.$bi_v.'">
'.$css.'
    <!--[if lte IE 6]></base><![endif]-->';

    if (strlen($theme_logo)) {
        if (pathinfo($theme_logo, PATHINFO_EXTENSION)) {

            if(file_exists('../../'.$portal_base_folder.'/template/'.$theme_template_name.'/gallery/logo/'.$theme_logo)){
    
            $_TEMPLATE_LOGO_ = '<div class="logo"><img alt="" class="img-responsive2" data-name="'.$theme_logo.'" src="gallery/logo/' . $theme_logo . '?v=1" style="" /></div>';
        }else{
            $_TEMPLATE_LOGO_ = '<div class="logo"><img alt="" class="img-responsive2" data-name="campaign_portal/img/no-image.png" src="/campaign_portal/img/no-image.png" style="" /></div>';
        }
    
        } else {
    
            $_TEMPLATE_LOGO_ = '<div class="logo"><img alt="" class="img-responsive2" data-name="'.$theme_def_logo.'" src="gallery/logo/' . $theme_def_logo . '" style="" /></div>';
        }
    } else {
    
        $_TEMPLATE_LOGO_ = '<div class="logo"><img alt="" class="img-responsive" src="img/generic_logo.png" style="" /></div>';
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
$helps = $db_query->getEmailTemplate('CAPTIVE_HELP_TEXT',$system_package,'MVNO',$user_distributor);
$helps_details= json_decode($helps[0]['text_details']);
//print_r($helps);
$help_link = $helps_details->help_text_config;
$help_txt = $helps_details->support_language;
$help_content = $helps_details->support_content;
$help_link_txt = $helps[0]['title'];

$bodies = $style_str; 
$act = "off";
if($_COOKIE['is_active']==1){ $act = "on" ;}

$hidden_form = "<form style='display:none' target='_parent' enctype=\"multipart/form-data\" id=\"theme_create_form\" class=\"form-horizontal\" method=\"POST\" action=\"".$global_url."/".$page."\">
                <input type='hidden' name='theme_name' value='".$_COOKIE['theme_name']."'>
                <input type='hidden' name='location_ssid' value='".$_COOKIE['location_ssid']."'>
                <input type='hidden' name='title_t' value='".$_COOKIE['title_t']."'>
                <input type='hidden' name='redirect_type' value='".$_COOKIE['redirect_type']."'>
                <input type='hidden' name='urlsecure' value='".$_COOKIE['splash_url_http']."'>
                <input type='hidden' name='splash_url' value='".$_COOKIE['splash_url']."'>
                <input type='hidden' name='is_active' value='".$act."'>
                <input type='hidden' name='template_name' value='".$template_id."'>
                <input type='hidden' name='enc' value='".$theme_details_id."'>
                <input type='hidden' name='reg_type' value='".$registration_type."'>
                <input type='hidden' name='host_tc_url' value='".$host_tc_url."'>
                <input type='hidden' name='sponsor_tc_url' value='".$privacy_policy_url."'>
                <input type='hidden' name='theme_id' value='".$_COOKIE['theme_id']."'>
                <input type='hidden' name='form_secret_createTheme' value='". $_SESSION['FORM_SECRET_createTheme'] . "' />
                <button type='submit' id='theme_create_form_submit' name='".$_COOKIE['theme_submit']."'></button>
                </form>
                ";
$bodies .= $hidden_form;
$bodies .= '<div id="servicear-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="z-index: 9999999999999999999999;max-height : 200px; max-width: 280px; height: auto; width: auto;  left: 40%; display: none;margin-top: -100px;top: 50%;position: fixed; <?php echo $style; ?>">

    <div class="dialog confirm ui-dialog-content ui-widget-content" id="ap_id" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto; text-align: center;">
    </div>
    <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
        <div class="ui-dialog-buttonset">
            <button style="display: none" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text"></span>
            </button>
            <button style="display: block;" id="servicearr-check-submit" onclick="hidediv();" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                <span class="ui-button-text"> OK</span>
            </button>
        </div>
    </div>
</div>

<div id="sess-front-div" class="ui-widget-overlay ui-front" style="display: none; z-index: 100;"></div>';
$script_blade = new \eftec\bladeone\BladeOne(__DIR__, $compile, \eftec\bladeone\BladeOne::MODE_AUTO);
$bodies.=$script_blade->run('js.theme-create-js', [
    "_GLOBAL_URL_" => $global_url,
    "_TEMPLATE_NAME_" => $theme_template_name,
    "_MODIFY_ST_" => $modify_st,
    "_UPCSS_" => $upCss,
    "_EDITABLE_" => $editable,
    "_DISABLED_BTN_COLOR_"=>$template_settings['disabled_btn_color'],
    "_FIELD_COLOR_"=>$template_settings['field_color'],
    "_ENC_" => $theme_details_id,
    "_ACTION_" => $action,
    "_FROM_THEME_UPLOAD_" => $from_theme_upload,
    "_USER_DISTRIBUTOR_" => $user_distributor,
    "_REG_TYPE_" => $registration_type,
    "_BASE_URL_" => $base_url,
    "_PAGE_" => $page,
    "_BI_V_"=>$bi_v
]);
echo $blade->run($template, [
    "_HEAD_" => $headers,
    "_TITLE_"=>$title,
    "_BODY_" => $bodies,
    "_TERMS_OF_USE" => $text,
    "_COLOR_1_" => 'data-cus="color_1"',
    "_COLOR_2_" => 'data-cus="color_2"',
    "_COLOR_3_" => 'data-cus="color_3"',
    "_BG_COLOR_1_" => 'data-bg-cus="bg_color_1"',
    "_BG_COLOR_2_" => 'data-bg-cus="bg_color_2"',
    "_BG_COLOR_3_" => 'data-bg-cus="bg_color_3"',
    "_THEME_NAME_" => $need_help_theme,
    "_PASSCODE_" => $passcode,
    "_GREETING_TEXT_" => $greeting_txt,
    "_HOST_TC_URL_" => $host_tc_url,
    "_PRIVACY_POLICY_URL_" => $privacy_policy_url,
    "_TOP_CENTER_TXT_" => $top_center_txt,
    "_REGISTRATION_FORM_" => $reg_form,
    "_TEMPLATE_LOGO_" => $_TEMPLATE_LOGO_,
    "_UPLOAD_IMG_1_" => 'upload_img_1',
    "_UPLOAD_IMG_2_" => 'upload_img_2',
    "_UPLOAD_IMG_3_" => 'upload_img_3',
    "_UPLOAD_IMG_1_NAME_" => $upload_img_1,
    "_UPLOAD_IMG_2_NAME_" => $upload_img_2,
    "_UPLOAD_IMG_3_NAME_" => $upload_img_3,
    "_THEME_IMAGE_VERTICAL_URL" => $theme_verticle_image,
    "_THEME_IMAGE_VERTICAL_NAME" => $theme_verticle_image_name,
    "_THEME_IMAGE_HORIZONTAL_URL" => $theme_horizontal_image,
    "_THEME_IMAGE_HORIZONTAL_NAME" => $theme_horizontal_image_name,
    "_WELCOME_TXT_" => $welcome_txt,
    "_EDIT_TXT_1_" => $edit_txt1,
    "_EDIT_TXT_2_" => $edit_txt2,
    "_EDIT_TXT_3_" => $edit_txt3,
    "_THEME_IMAGE_1_" => $theme_logo.'?v=1',
    "_BACKGROUND_COLOR_" => $bg_color_1,
    "_GREETING_FONT_COLOR_" => $font_color_1,
    "_HR_COLOR_" => $hr_color,
    "_SUPORT_MOBILE_" => $sup_mobile,
    "_PROPERTY_ID_" => $prop_id,
    "_BG_IMG_FILE_"=>$theme_bg_image.'?v=1',
    "_BG_IMG_FILE_2_"=>$theme_bg_image_4to.'?v=1',
    "_BG_IMG_FILE_2_PATH_"=>$theme_bg_image_4to_path,
    "_PRIMARY_COLOR_" => $primary_color,
    "_SUBMIT_BUTTON_ID_" => $submit_button_id,
    "_SUPPORT_NUMBER_" => $support_number,
    "_BTN_COLOR_" => $btn_color,
    "_BTN_BORDER_" => $btn_border,
    "_UNIQID_" => uniqid(),
    "_BTN_TEXT_COLOR_" => $btn_text_color,
    "_BTN_COLOR_DISABLE_" => $btn_color_disable,
    "_HELP_LINK_"=>$help_link,
    "_HELP_LINK_TXT_"=>$help_link_txt,
    "_HELP_TXT_"=>$help_txt,
    "_HELP_CONTENT_"=>$help_content,
    "_BI_V_"=>$bi_v
]);