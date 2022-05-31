<?php
function setThemeDetails1($db, $template_name, $reg_type,$theme_id=NULL)
{

    if($theme_id==NULL){

    $query = "SELECT default_theme FROM exp_template WHERE `template_id`='$template_name'";
    $query_arr = $db->selectDB($query);
    if ($query_arr['rowCount'] > 0) {
        foreach ($query_arr['data'] as $row) {
            if ($reg_type == 'AUTH_DISTRIBUTOR_PASSCODE') {
                $theme_id = $row['default_theme'] . '_pas';
            } else {
                $theme_id = $row['default_theme'] . '_' . $reg_type;
            }
        }
        $theme_id_check = $db->getValueAsf("SELECT theme_id AS f FROM exp_themes WHERE theme_id = '$theme_id' LIMIT 1");
        if(strlen($theme_id_check)<1){
            $theme_id = $row['default_theme'];
        }
    }
}
    $theme_data_set = $db->getTheme($theme_id, 'en');
    $theme_details_id = $theme_data_set[0]['theme_details_id'];
    $rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_themes_details'");
    //$rowe = mysql_fetch_array($br);
    $auto_inc = $rowe['Auto_increment'];
    $db->execDB("INSERT INTO `exp_themes_details` (
        `unique_id`,
        `theme_data`,
        `create_date`,
        `updated_by`
        )SELECT 
            '$auto_inc',
            `theme_data`,
            `create_date`,
            `updated_by` FROM `exp_themes_details` WHERE `unique_id`='$theme_details_id'");

    return $auto_inc;
}

if($_GET['data']=='set'){
    $theme_submit = $_COOKIE['theme_submit'];
    $edit_theme_name = $_COOKIE['theme_name'];
    $edit_location_ssid = $_COOKIE['location_ssid'];
    $edit_title_t = $_COOKIE['title_t'];
    $edit_reditct_typ = $_COOKIE['redirect_type'];
    $pathspalsh_t = $_COOKIE['splash_url'];
    $secspalsh_t = $_COOKIE['splash_url_http'];
    $edit_template_name1 = $_COOKIE['template_name'];
    $edit_registration_type = $_COOKIE['reg_type'];
    $edit_enc = $_GET['enc'];
    $edit_is_active = $_COOKIE['is_active'];
    $theme_id = $_COOKIE['theme_id'];
    $old_enc = $_COOKIE['old_enc'];
    $theme_edit = $_COOKIE['theme_edit'];

    $edit_host_tc_url = $_COOKIE['host_tc_url'];
    $edit_tc_url = $_COOKIE['sponsor_tc_url'];

   
}else{
    setcookie("theme_name", "", time() - 3600);
    setcookie("location_ssid", "", time() - 3600);
    setcookie("title_t", "", time() - 3600);
    setcookie("redirect_type", "", time() - 3600);
    setcookie("splash_url", "", time() - 3600);
    setcookie("template_name", "", time() - 3600);
    setcookie("reg_type", "", time() - 3600);
    setcookie("enc", "", time() - 3600); 
    setcookie("is_active", "", time() - 3600);
    setcookie("old_enc", "", time() - 3600);
    setcookie("theme_id", "", time() - 3600);
    setcookie("theme_submit", "", time() - 3600);
    setcookie("theme_edit", "", time() - 3600);
    setcookie("host_tc_url", "", time() - 3600);
    setcookie("sponsor_tc_url", "", time() - 3600);
}

if(strlen($theme_submit)< 1){
    $theme_submit = "theme_submit_s";
    setcookie("theme_submit", "theme_submit_s");
}

if (isset($_POST['theme_submit_s'])) {

    if($_POST['form_secret_createTheme'] == $_SESSION['FORM_SECRET_createTheme']){

    $redirect_type = $_POST['redirect_type'];
    $splash_url = $_POST['urlsecure'].$_POST['splash_url'];
    $template_name = $_POST['template_name'];
    $language = 'en';
    $title_t = $db->escapeDB($_POST['title_t']);
    $reg_type = $_POST['reg_type'];
    $loading = 'Loading';
    $theme_name = $db->escapeDB($_POST['theme_name']);
    $location_ssid = $_POST['location_ssid'];
    $is_active = $_POST['is_active'];
    if ($is_active == 'on') {
        $active = 1;
        $q12 = "UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `language`='$language'";
        $ex_update12=$db->execDB($q12);
    }else {
        $active = 0;
    }
    // $theme_details_id = $_POST['enc']; fancybox method
    $theme_details_id = $_POST['enc'];

//    $sponsor_text = $_POST['sponsor_text'];
//    $sponsor_text2 = $_POST['sponsor_short_text'];
//    $sponsor_url = $_POST['sponsor_tc_url'];

    $extra_fields = json_encode(['host_tc_url'=>$_POST['host_tc_url'],'sponsor_tc_url'=>$_POST['sponsor_tc_url']]);

    if (strlen($theme_details_id) < 1) {
        $def_theme_id = $package_functions->getOptions('WYSIWYG_DEFAULT_THEME', $system_package);
        if(strlen($def_theme_id)> 0){
            $theme_details_id = setThemeDetails1($db, $template_name, $reg_type,$def_theme_id);
        }else{
            $theme_details_id = setThemeDetails1($db, $template_name, $reg_type);
        }
        
    }

    $is_enable = $_POST['is_active'];
    $rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_themes'");
    //$rowe = mysql_fetch_array($br);
    $auto_increment = $rowe['Auto_increment'];
    $theme_unique_id = 'th_' . $language . '_' . $auto_increment;

    $query = "REPLACE INTO `exp_themes` (`extra_fields`,`redirect_type`,`advanced_theme`,`splash_url`,`template_name`, `theme_id`, `theme_name`, `distributor`, `language`,title, `registration_type`,`loading_txt`, `create_date`, `updated_by`,ref_id,is_enable,theme_type,theme_details_id)
        VALUES ('$extra_fields','$redirect_type','ADVANCED','$splash_url','$template_name','$theme_unique_id', '$theme_name', '$user_distributor', '$language', '$title_t','$reg_type','$loading',now(), '$user_name','$location_ssid','$active','MASTER_THEME','$theme_details_id')";
    $ex = $db->execDB($query);

    $qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";
    $query_prp_id_results = $db->selectDB($qu);
    
    foreach ($query_prp_id_results['data'] AS $row) {
        $lan = $row['language'];
        $the_id = $row['theme_id'];
        $lan_update_result[$lan] = $the_id;
    }

    $lan_update_result_json = json_encode($lan_update_result);

    if($other_multi_area!=1){

        if($lan_update_result_json == 'null'){
            $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = NULL WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";
            $ex_update4=$db->execDB($qq11);

        }else{
            $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = '$lan_update_result_json' WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";
            $ex_update4=$db->execDB($qq11);
        }
    }

    if ($ex === true) {
        if($other_multi_area!=1){
            $msgTag = 'manageTheme';
            $active_tab = 'tab_manageTheme';
            $$active_tab = 'set';
            $_GET['t'] = 'tab_manageTheme';
        }else{
            $msgTag = 'manage_SSID_splash';
            $active_tab = 'tab_manage_SSID_splash';
            $$active_tab = 'set';
            $_GET['t'] = 'tab_manage_SSID_splash';
        }
        $them_create_msg = $message_functions->showNameMessage('theme_create_success', $_POST['theme_name']);
        $them_create_msg = strtr($them_create_msg, $txt_replace);
        $_SESSION[$msgTag] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $them_create_msg . "</strong></div>";
    } else {
        $active_tab = 'tab_createTheme';
        $$active_tab = 'set';
        $them_create_msg = $message_functions->showMessage('theme_create_failed', '2001');
        $them_create_msg = strtr($them_create_msg, $txt_replace);
        $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $them_create_msg . "</strong></div>";
    }
}else{
    $db->userErrorLog('2004', $user_name, 'script - '.$script);

    $active_tab = 'tab_createTheme';
    $$active_tab = 'set';

    $_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           	<strong> ".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
}
}

if (isset($_POST['theme_update_s'])) {
    if($_POST['form_secret_createTheme'] == $_SESSION['FORM_SECRET_createTheme']){

    $theme_unique_id = $_POST['theme_id'];
    $redirect_type = $_POST['redirect_type'];
    $splash_url = $_POST['urlsecure'].$_POST['splash_url'];
    $template_name = $_POST['template_name'];
    $edit_template_name1 = $_POST['edit_template_name1'];
    $edit_registration_type = $_POST['edit_registration_type'];
    $language = 'en';
    $title_t = $db->escapeDB($_POST['title_t']);
    $reg_type = $_POST['reg_type'];
    $loading = 'Loading';
    $theme_name = $db->escapeDB($_POST['theme_name']);
    $location_ssid = $_POST['location_ssid'];
    //$theme_details_id = $_POST['enc']; fancybox method
    $theme_details_id = $_POST['enc'];
    $old_theme_details_id = $_POST['old_enc'];
    $is_enable = $_POST['is_active'];
    $is_active = $_POST['is_active'];

//    $sponsor_text = $_POST['sponsor_text'];
//    $sponsor_text2 = $_POST['sponsor_short_text'];
//    $sponsor_url = $_POST['sponsor_tc_url'];

    $extra_fields = json_encode(['host_tc_url'=>$_POST['host_tc_url'],'sponsor_tc_url'=>$_POST['sponsor_tc_url']]);

        if ($is_active == 'on') {
        $active = 1;
        $q12 = "UPDATE `exp_themes` SET `is_enable` = '0' WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `language`='$language'";
        $ex_update12=$db->execDB($q12);
    }else {
        $active = 0;
    }
    if (strlen($theme_details_id) < 1) {
        if($edit_template_name1!=$template_name || $edit_registration_type!=$reg_type){
            $def_theme_id = $package_functions->getOptions('WYSIWYG_DEFAULT_THEME', $system_package);
            if(strlen($def_theme_id)> 0){
                $theme_details_id = setThemeDetails1($db, $template_name, $reg_type,$def_theme_id);
            }else{
                $theme_details_id = setThemeDetails1($db, $template_name, $reg_type);
            }
            
        }else{
            $theme_details_id = $old_theme_details_id;
        }
    } else {
        $db->execDB("DELETE FROM exp_themes_details WHERE unique_id='$old_theme_details_id'");
    }


    $query = "REPLACE INTO `exp_themes` (`extra_fields`,`redirect_type`,`advanced_theme`,`splash_url`,`template_name`, `theme_id`, `theme_name`, `distributor`, `language`,title, `registration_type`,`loading_txt`, `create_date`, `updated_by`,ref_id,is_enable,theme_type,theme_details_id)
        VALUES ('$extra_fields','$redirect_type','ADVANCED','$splash_url','$template_name','$theme_unique_id', '$theme_name', '$user_distributor', '$language', '$title_t','$reg_type','$loading',now(), '$user_name','$location_ssid','$active','MASTER_THEME','$theme_details_id')";
    $ex = $db->execDB($query);

    $qu = "SELECT `language`,`theme_id` FROM `exp_themes` WHERE `ref_id` = '$location_ssid' AND `distributor`='$user_distributor' AND `is_enable`= '1'";
            $query_prp_id_results = $db->selectDB($qu);
           
            foreach ($query_prp_id_results['data'] AS $row) {
                $lan = $row['language'];
                $the_id = $row['theme_id'];
                $lan_update_result[$lan] = $the_id;
            }

            $lan_update_result_json = json_encode($lan_update_result);

            if($other_multi_area!=1){
                if($lan_update_result_json == 'null'){
                    $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = NULL WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";
                    $ex_update4=$db->execDB($qq11);

                }else{
                    $qq11 = "UPDATE exp_mno_distributor_group_tag SET theme_name = '$lan_update_result_json' WHERE tag_name = '$location_ssid' AND `distributor`='$user_distributor' LIMIT 1";
                    $ex_update4=$db->execDB($qq11);
                }
            }

    if ($ex === true) {
        if($other_multi_area!=1){

            //UPdate group_tag
            if($active == 1){
                //{"en":"th_en_3707"}
                $tn = '{"'.$language.'":"'.$theme_unique_id.'"}';
                $tn_q = "UPDATE exp_mno_distributor_group_tag set `theme_name`='$tn' WHERE tag_name='$location_ssid' AND distributor='$user_distributor'";
                $db->execDB($tn_q);
            }

            $msgTag = 'manageTheme';
            $active_tab = 'tab_manageTheme';
            $$active_tab = 'set';
            $_GET['t'] = 'tab_manageTheme';
        }else{
            $msgTag = 'manage_SSID_splash';
            $active_tab = 'tab_manage_SSID_splash';
            $$active_tab = 'set';
            $_GET['t'] = 'tab_manage_SSID_splash';
        }
        $them_create_msg = $message_functions->showNameMessage('theme_updated_success', $_POST['theme_name']);
        $them_create_msg = strtr($them_create_msg, $txt_replace);
        $_SESSION[$msgTag] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $them_create_msg . "</strong></div>";
    } else {
        $active_tab = 'tab_createTheme';
        $$active_tab = 'set';
        $them_create_msg = $message_functions->showMessage('theme_create_failed', '2001');
        $them_create_msg = strtr($them_create_msg, $txt_replace);
        $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $them_create_msg . "</strong></div>";
    }
}else{
    $db->userErrorLog('2004', $user_name, 'script - '.$script);

    $active_tab = 'tab_createTheme';
    $$active_tab = 'set';

    $_SESSION['msg1']= "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>

           	<strong> ".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
}
}

if (($_GET['modify_s'] == 1 || strlen($_POST['modify_s'])>0) && !isset($_POST['theme_update_s'])) {
    $active_tab = 'tab_createTheme';
    $$active_tab = 'set';
    $theme_id = $_GET['id'];
    $theme_submit = "theme_update_s";
    $theme_edit = 'edit';
    $modify_mode = 1;
    $query = $db->selectDB("SELECT * FROM `exp_themes` WHERE `theme_id`='$theme_id'");

    foreach ($query['data'] AS $row) {
        $edit_theme_name = $row['theme_name'];
        $edit_location_ssid = $row['ref_id'];
        $edit_title_t = $row['title'];
        $edit_reditct_typ = $row['redirect_type'];
        $edit_splash_url_t = $row['splash_url'];
        $splasharray_t=explode("//",$edit_splash_url_t);
        $secspalsh_t=$splasharray_t[0].'//';
        $pathspalsh_t=$splasharray_t[1];
        $edit_template_name1 = $row['template_name'];
        $edit_registration_type = $row['registration_type'];
        $edit_is_active = $row['is_enable'];
        $old_enc = $row['theme_details_id'];

        $extra = json_decode($row['extra_fields'],true);
        $edit_host_tc_url=$extra['host_tc_url'];
        $edit_tc_url=$extra['sponsor_tc_url'];
    }

    setcookie("theme_id", $theme_id);
    setcookie("old_enc", $old_enc);
    setcookie("theme_submit", "theme_update_s");
    setcookie("theme_edit", $theme_edit);
}
// if($theme_edit=='edit'){
//     $template_edit_disabled = "disabled";
// }
if (isset($_GET['modify_st'])){
    if($_GET['modify_st'] == 1){
        $modify_mode = 1;
    }
}
?>