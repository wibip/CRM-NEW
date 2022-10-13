<?php ob_start(); ?>
<!DOCTYPE html>

<html lang="en">

<?php
session_start();
include 'header_top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);

/* No cache*/
//header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
require_once 'classes/systemPackageClass.php';
require_once 'classes/dbApiClass.php';
require_once 'classes/customerClass.php';

/*Encryption script*/
include_once 'classes/cryptojs-aes.php';
require_once 'classes/VlanID.php';
$vlanOb = new VlanID();

$db = new db_functions();
$customerOb = new customer();
$wag_ap_name = $db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
//echo $wag_ap_name='NO_PROFILE';
if ($wag_ap_name != 'NO_PROFILE') {

    $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

    if ($ap_control_var == 'SINGLE') {
        include 'src/AP/' . $wag_ap_name . '/index.php';
        $test = new ap_wag();
    }
}

$package_functions = new package_functions();

$api_db = new api_db_functions();

require_once 'models/vtenantModel.php';
$vtenant_model = new vtenantModel();

require_once 'classes/CommonFunctions.php';

require_once 'src/DPSKS/dpsks_factory.php';


////////////randon pasword ////
/*function randomPasswordlength($length)
{

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

function mob_format($mobile_no)
{

    if (!empty($mobile_no)) {
        $mobile_no = str_replace("-", "", $mobile_no);
        return $to = sprintf("%s-%s-%s",
            substr($mobile_no, 0, 3),
            substr($mobile_no, 3, 3),
            substr($mobile_no, 6));
    }
}*/


function freeRealm($realm, db_functions $db)
{
    $q = "UPDATE exp_api_icom_pool SET status='0' WHERE icom='$realm'";

    $db->execDB($q);
}

?>

<head>

    <meta charset="utf-8">
    <title>Operations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css?v=1" rel="stylesheet">
    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
    <link href="css/bootstrap-colorpicker.css?v=19" rel="stylesheet">
    <link href="plugins/img_upload/assets/css/croppic.css" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-toggle.min.css" />
    <link rel="stylesheet" href="css/tablesaw.css?v1.2">

    <style>
        #ms-network_type {
            display: inline-block !important;
        }

        #mno_mobile_1:valid~small[data-bv-validator-for="mno_mobile_1"] {
            display: none !important;
        }

        #mno_mobile_2:valid~small[data-bv-validator-for="mno_mobile_2"] {
            display: none !important;
        }

        #mno_mobile_3:valid~small[data-bv-validator-for="mno_mobile_3"] {
            display: none !important;
        }

        .controls:not(.support-wag) div.toggle {
            margin-bottom: 15px !important;
        }
    </style>
    <style type="text/css">
        .sele-disable {
            position: absolute;
            width: 100%;
            height: 37px;
            cursor: not-allowed;
            opacity: 0.2;
            background: #9a9999;
            margin-left: 0px;
        }

        .checkbox-disable {
            position: absolute;
            height: 28px;
            width: 28px;
            cursor: not-allowed;
            opacity: 0.2;
            background: #342626;
            margin-left: 0px;
            z-index: 7777;
            margin-top: 6px;
        }

        @media (max-width: 420px) {
            .sele-disable.span4 {
                width: 100% !important;
            }
        }
    </style>


    <!-- Add jQuery library -->
    <!--<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>-->


    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script src="js/locationpicker.jquery.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-toggle.min.js"></script>


    <!--Ajax File Uploading Function-->


    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesawNew.js"></script>
    <!--Encryption -->
    <script type="text/javascript" src="js/aes.js"></script>
    <script type="text/javascript" src="js/aes-json-format.js"></script>

    <link rel="stylesheet" href="css/bootstrapValidator.css" />


    <?php
    $data_secret = $db->setVal('data_secret', 'ADMIN');
    $url_mod_override = $db->setVal('url_mod_override', 'ADMIN');
    include 'header.php';

    require_once 'layout/' . $camp_layout . '/config.php';

    //added for reseller image upload
    $type = 'dynamic';


    $folder = $api_db->getPackageFeature($system_package, 'IMAGE_UPLOAD_LIBRARY');

    if (empty($folder)) {
        require_once 'src/upload/local_image/index.php';
    } else {
        $image_upload_to = 'src/upload/' . $folder . '/index.php';


        if (file_exists($image_upload_to)) {

            require_once $image_upload_to;
        } else {

            require_once 'src/upload/local_image/index.php';
        }
    }

    $upload_img = new image_library($type);
    $tenant_upload_img = new image_library('tenant');
    $campaign_upload_img = new image_library('campaign');

    //added for reseller image upload

    /*function randomPassword()
    {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }*/

    function rollbackaccount($parent_code, $user_distributor, db_functions $db)
    {
        $sql = "DELETE FROM `mno_distributor_parent` WHERE `parent_id` = '$parent_code'";
        ///$sql = "DELETE FROM `admin_users` WHERE `verification_number` = '$verification_number'";
        $db->execDB($sql);
    }

    $priority_zone_array = array(
        "America/New_York",
        "America/Chicago",
        "America/Denver",
        "America/Los_Angeles",
        "America/Anchorage",
        "Pacific/Honolulu",
    );

    ?>


    <script language="Javascript">
        function uploaodSMBValidation() {

            if (document.getElementById("smb_account_code").value == '') {
                document.getElementById("upload_smb_account").style.display = '';
            } else {
                document.getElementById("upload_smb_account").style.display = 'none';

            }


        }


        function fileUpload(form, action_url1, div_id) {

            //disable button//
            document.getElementById("upload_cont").disabled = true;
            var smb_account_code = document.getElementById("smb_account_code").value;
            var form_id = "ap_bulk_upload";

            if (smb_account_code == '') {
                document.getElementById("upload_smb_account").style.display = '';
                document.getElementById("upload_cont").disabled = false;
                return false;
            }

            //php word search////
            var n = action_url1.search(".php");

            if (n == "-1") {
                //extension not available//
                var action_url = action_url1 + "?smb_account_code=" + smb_account_code;
            } else {
                var action_url = action_url1 + "?smb_account_code=" + smb_account_code;
            }


            //alert(action_url);
            // Create the iframe...
            var iframe = document.createElement("iframe");
            iframe.setAttribute("id", "upload_iframe");
            iframe.setAttribute("name", "upload_iframe");
            iframe.setAttribute("width", "0");
            iframe.setAttribute("height", "0");
            iframe.setAttribute("border", "0");
            iframe.setAttribute("style", "width: 0; height: 0; border: none;");

            // Add to document...
            form.parentNode.appendChild(iframe);
            window.frames['upload_iframe'].name = "upload_iframe";

            iframeId = document.getElementById("upload_iframe");

            // Add event...
            var eventHandler = function() {

                if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
                else iframeId.removeEventListener("load", eventHandler, false);

                // Message from server...
                if (iframeId.contentDocument) {
                    content = iframeId.contentDocument.body.innerHTML;
                } else if (iframeId.contentWindow) {
                    content = iframeId.contentWindow.document.body.innerHTML;
                } else if (iframeId.document) {
                    content = iframeId.document.body.innerHTML;
                }

                document.getElementById(div_id).innerHTML = content;
                //form rest
                document.getElementById(form_id).reset();

                // Del the iframe...
                setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
            }

            if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
            if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);

            // Set properties of form...
            form.setAttribute("target", "upload_iframe");
            form.setAttribute("action", action_url);
            form.setAttribute("method", "post");
            form.setAttribute("enctype", "multipart/form-data");
            form.setAttribute("encoding", "multipart/form-data");

            // Submit the form...
            form.submit();
            //document.getElementById("up_cont").disabled=true;
            document.getElementById(div_id).innerHTML = "<font color=#4B8DF7 size=3><strong><?php echo $message_functions->showMessage('file_upload_waiting'); ?></strong><br><img src=img/uploader1.gif><br><br>";
        }
    </script>

    <?php

    /* function formatOffset($offset)
    {
        $hours = $offset / 3600;
        $remainder = $offset % 3600;
        $sign = $hours > 0 ? '+' : '-';
        $hour = (int)abs($hours);
        $minutes = (int)abs($remainder / 60);
        if ($hour == 0 AND $minutes == 0) {
            $sign = ' ';
        }
        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0');

    }



    function httpGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($ch,CURLOPT_HEADER, false);

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }*/

    ?>



    <?php
    //***************Field Filtor******************
    //echo $system_package;
    $json_fields = $package_functions->getOptions('VENUE_ACC_CREAT_FIELDS', $system_package);
    $field_array = json_decode($json_fields, true);
    //  print_r($field_array);
    ?>

    <?php

    $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'camp_base_url'";

    $query_results = $db->selectDB($key_query);
    foreach ($query_results['data'] as $row) {

        $settings_value = $row[settings_value];
        $base_url = trim($settings_value, "/");
    }
    $base_folder = $db->setVal('portal_base_folder', 'ADMIN');


    //admin -> Service Provider form type
    $key_query2 = "SELECT settings_value FROM exp_settings WHERE settings_code = 'service_account_form' LIMIT 1";
    $query_result2 = $db->select1DB($key_query2);
    //$row2 = mysql_fetch_array($query_result2);
    $mno_form_type = $query_result2['settings_value'];




    //echo $mno_form_type='basic_menu';

    //check API call enbale or not///
    //$wag_ap_name=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
    //refresh zones
    if (isset($_GET['refreshzone'])) {

        $rsk1 = $test->rkszones();
        $obj = (array)json_decode($rsk1);

        $dataarray = $obj['list'];

        $arrlength = count($dataarray);

        for ($x = 0; $x < $arrlength; $x++) {


            $array = json_decode(json_encode($dataarray[$x]), True);
            //print_r($array);
            $zid = $array['id'];
            $zname = $array['name'];

            $query0 = "REPLACE INTO exp_distributor_zones (zoneid,name,create_user,create_date)

                    values ('$zid','$zname','$user_name',now())";

            $db->execDB($query0);
        }
    } //Remove Aps///
    else if (isset($_GET['remove_code'])) { //3

        if ($_SESSION['FORM_SECRET'] == $_GET['token9']) { //refresh validate

            $remove_ap_id = $db->escapeDB($_GET['remove_code']);
            $user_name = $_SESSION['user_name'];
            if ($user_type != 'SALES') {
                //archive
                $query_ap_archive = "INSERT INTO `exp_mno_distributor_aps_archive`
        (`distributor_code`, `ap_code`, `assign_date`, `assigned_by`, `archive_by`, `archive_date`)
        SELECT distributor_code,ap_code,assign_date,assigned_by,'$user_name',now()
        from exp_mno_distributor_aps where id = '$remove_ap_id'";

                $ex1 = $db->execDB($query_ap_archive);

                if ($ex1 === true) {

                    //delete AP
                    $ex0 = $db->execDB("DELETE FROM `exp_mno_distributor_aps` WHERE `id` = '$remove_ap_id' ");
                }

                if ($ex0 === true) {
                    $db->userLog($user_name, $script, 'Remove CPE', '');
                    $_SESSION['msg9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('cpe_removing_success') . "</strong></div>";
                    $create_log->save('3003', $message_functions->showMessage('cpe_removing_success'), '');
                } else {

                    $db->userErrorLog('2003', $user_name, 'script - ' . $script);

                    $_SESSION['msg9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('cpe_removing_failed', '2003') . "</strong></div>";
                    $create_log->save('2003', $message_functions->showMessage('cpe_removing_failed'), '');
                }
            } else {
                $_SESSION['msg9'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('cpe_removing_success') . "</strong></div>";
                $create_log->save('3003', $message_functions->showMessage('cpe_removing_success'), '');
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);

            $_SESSION['msg9'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
            header('Location: location.php?t=9');
        }
    } //3


    ///Admin - Create MNO Account//////
    else if (isset($_POST['submit_mno_form'])) { //6
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

            if ($mno_user_type == 'RESELLER_ADMIN') {
                $mno_sys_package = 'RESELLER_ADMIN_001';
            }
            $mnoAccType=$mno_user_type;
            if ($mno_user_type == 'Factory_Manager') {
                $mno_user_type = 'MNO';
            }

            $mno_system_package = $mno_sys_package;


            if ($user_type != 'SALES') {
                if ($mno_form_type == 'advanced_menu') { //advanced_menu
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

                    $featurearr = $_POST['feature_cont'];
                    if (in_array('VTENANT_MODULE', $featurearr)) {
                        $vtenant_module = 'Vtenant';
                    } else {
                        $vtenant_module = '';
                    }

                    $feature_json = $db->escapeDB(json_encode($featurearr));


                    if (strlen($_POST['mno_api_prifix']) > 0) {
                        $mno_api_prefix = "'" . $_POST['mno_api_prifix'] . "'";
                    } else {
                        $mno_api_prefix = "NULL";
                    }

                    //$mno_ale_zone=$_POST['mno_operator_zone'];
                    //$mno_ale_group=$_POST['mno_operator_group'];


                } else {
                    $mno_full_name = $db->escapeDB(trim($_POST['mno_full_name']));
                    $mno_email = trim($_POST['mno_email']);
                    $mno_mobile_1 = $db->escapeDB(trim($_POST['mno_mobile_1']));
                }


                $login_user_name = $_SESSION['user_name'];

                $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno'");
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
                if ($automation_on == 'Yes') {

                    $network_name = $package_functions->getOptions('NETWORK_PROFILE', $mno_sys_package);

                    $network_name_new = $package_functions->getOptions('NETWORK_PROFILE_NEW', $mno_sys_package);
                    if (strlen($network_name_new) > 0) {
                        $network_name = $network_name_new;
                    }
                    if (strlen($network_name) == 0) {
                        $network_name = $db->setVal('network_name', 'ADMIN');
                    }
                    $row1 = $db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$network_name'");
                    $aaa_data = json_decode($row1['aaa_data'], true);
                    $operator_group_id = $row1['api_master_acc_type'] . '_' . $_POST['mno_api_prifix'];
                    $operator_group_name = $_POST['mno_api_prifix'];
                    $network_profile = $row1['api_network_auth_method'];


                    require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '/src/AAA/' . $network_profile . '/index.php');
                    $data_arr = array();
                    if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {
                    $data_arr['api_login'] = $db->escapeDB(trim($_POST['aaa_api_username']));
                    $data_arr['api_password'] = $db->escapeDB(trim($_POST['aaa_api_password']));
                    $data_arr['api_acc_profile'] = $db->escapeDB(trim($_POST['aaa_tenant']));
                    $data_arr['api_master_acc_type'] = $db->escapeDB(trim($_POST['aaa_product_owner']));
                    $data_arr['aaa_api_url'] = $db->escapeDB(trim($_POST['aaa_api_url']));
                    $data_arr['aaa_api_url2'] = $db->escapeDB(trim($_POST['vm_aaa_api_url']));
                    $data_arr['vm_api_username'] = $db->escapeDB(trim($_POST['vm_aaa_api_username']));
                    $data_arr['vm_api_password'] = $db->escapeDB(trim($_POST['vm_aaa_api_password']));
                    $data_arr['api_acc_org'] = $db->escapeDB(trim($_POST['api_acc_org']));
                    $operator_group_id = trim($_POST['aaa_product_owner']) . '_' . $_POST['mno_api_prifix'];
                    $aaa_data['aaa_root_zone'] = trim($_POST['api_root_zone_name']);
                    }

                    $aaa = new aaa($network_name, $mno_system_package,$data_arr);
                    $all_groups = json_decode($aaa->getAllGroupsNew(), true);
                    $op_group_exists = false;
                    if ($all_groups['status'] == 'success') {
                        $error_st = false;
                        foreach ($all_groups['Description'] as $value) {
                            if ($value['Id'] == $operator_group_id) {
                                $op_group_exists = true;
                                $operator_group_name = $value['Name'];
                            }
                        }

                        if (!$op_group_exists) {
                            $create_group = json_decode($aaa->createGroup(array('Id' => $operator_group_id, 'Name' => $operator_group_name)), true);
                            if ($create_group['status'] != 'success') {
                                $error_st = true;
                            }
                        }

                        if (!$error_st) {
                            $all_zones = json_decode($aaa->getAllZones(), true);
                            $op_zone_exists = false;
                            if ($all_zones['status'] == 'success') {
                                $default_zone_ext = false;
                                foreach ($all_zones['Description'] as $value) {
                                    if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {
                                        if($value['Name']==$aaa_data['aaa_root_zone']){
                                            $aaa_data['aaa_root_zone_id'] = $value['Id'];
                                        }
                                    }
                                    if ($value['Id'] == $aaa_data['aaa_root_zone_id']) {
                                        foreach ($value['Sub-Zones'] as $value1) {
                                            if ($value1['Name'] == $_POST['mno_api_prifix']) {
                                                $op_zone_exists = true;
                                                $op_zone_id = $value1['Id'];
                                            }
                                        }
                                        $default_zone_ext = true;
                                        $aaa_data_op = json_encode(array('operator_zone_name' => $_POST['mno_api_prifix'], 'operator_zone_id' => $op_zone_id, 'operator_group_id' => $operator_group_id));
                                    }
                                }

                                if ($default_zone_ext) {
                                    if (!$op_zone_exists) {
                                        $create_zone = json_decode($aaa->createZone(array('Name' => $_POST['mno_api_prifix'], 'Description' => 'This contains match table entry for ' . $_POST['mno_api_prifix'] . ' customer', 'Parent-Zone' => $aaa_data['aaa_root_zone_id'], 'Location-Group' => $operator_group_id)), true);
                                        if ($create_zone['status'] == 'success') {
                                            $op_zone_id = $create_zone['Description']['Id'];
                                            $aaa_data_op = json_encode(array('operator_zone_name' => $_POST['mno_api_prifix'], 'operator_zone_id' => $op_zone_id, 'operator_group_id' => $operator_group_id));
                                        } else {
                                            $error = true;
                                        }
                                    }
                                } else {
                                    $error = true;
                                }
                            } else {
                                $error = true;
                            }
                        }
                    } else {
                        $error = true;
                    }
                }

                $camphaign_id = 0;
                if (isset($mno_sys_package)) {
                    if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {


                        $mno_short_name = strtolower($db->escapeDB(trim($_POST['mno_short_name'])));
                        $mno_about_url = $db->escapeDB(trim($_POST['mno_about_url']));
                        $mno_privacy_url = $db->escapeDB(trim($_POST['mno_privacy_url']));
                        $mno_toc_url = $db->escapeDB(trim($_POST['mno_toc_url']));
                        $mno_primary_color = $db->escapeDB(trim($_POST['mno_primary_color']));
                        $mno_secondary_color = $db->escapeDB(trim($_POST['mno_secondary_color']));
                        $mno_support_number = $db->escapeDB(trim($_POST['mno_support_number']));
                        $mno_support_email = $db->escapeDB(trim($_POST['mno_support_email']));
                        $aaa_api_username = $db->escapeDB(trim($_POST['aaa_api_username']));
                        $aaa_api_password = $db->escapeDB(trim($_POST['aaa_api_password']));
                        $aaa_tenant = $db->escapeDB(trim($_POST['aaa_tenant']));
                        $aaa_product_owner = $db->escapeDB(trim($_POST['aaa_product_owner']));
                        $aaa_api_url = $db->escapeDB(trim($_POST['aaa_api_url']));
                        $aaa_api_url2 = $db->escapeDB(trim($_POST['vm_aaa_api_url']));
                        $aaa_api_username_vm = $db->escapeDB(trim($_POST['vm_aaa_api_username']));
                        $aaa_api_password_vm = $db->escapeDB(trim($_POST['vm_aaa_api_password']));
                        $aaa_api_acc_org = $db->escapeDB(trim($_POST['api_acc_org']));
                        $aaa_api_type = $db->escapeDB(trim($_POST['aaa_api_type']));
                        $dsf_api_url = $db->escapeDB(trim($_POST['dsf_api_url']));
                        $dsf_api_username = $db->escapeDB(trim($_POST['dsf_api_username']));
                        $dsf_api_password = $db->escapeDB(trim($_POST['dsf_api_password']));
                        $abuse_api_url = $db->escapeDB(trim($_POST['abuse_api_url']));
                        $abuse_api_username = $db->escapeDB(trim($_POST['abuse_api_username']));
                        $abuse_api_password = $db->escapeDB(trim($_POST['abuse_api_password']));

                        $get_dynamic_product_id = $_POST['get_dynamic_product_id'];
                        $prev_short_name = $_POST['prev_short_name'];
                        $mno_account_name_prev = $_POST['mno_account_name_prev'];
                        $mno_support_number_prev = $_POST['mno_support_number_prev'];
                        $mno_support_email_prev = $_POST['mno_support_email_prev'];
                        $mno_about_url_prev = $_POST['prev_about_url'];
                        $mno_privacy_url_prev = $_POST['prev_privacy_url'];
                        $mno_toc_url_prev = $_POST['prev_toc_url'];
                        $mno_primary_color_prev = $_POST['prev_primary_color'];
                        $mno_secondary_color_prev = $_POST['prev_secondary_color'];
                        $mno_logo_url_prev = $_POST['prev_image_logo_url'];
                        $mno_email_url_prev = $_POST['prev_image_email_url'];
                        $mno_aaa_username_prev = $_POST['prev_aaa_username'];
                        $mno_aaa_password_prev = $_POST['prev_aaa_password'];
                        $mno_aaa_tenant_prev = $_POST['prev_aaa_tenant'];
                        $mno_aaa_product_owner_prev = $_POST['prev_aaa_product_owner'];
                        $mno_dsf_username_prev = $_POST['prev_dsf_username'];
                        $mno_dsf_password_prev = $_POST['prev_dsf_password'];


                        $mno_system_package = $dynamic_product_id;
                        if ($get_edit_get == 1) {
                            $mno_system_package = $get_dynamic_product_id;
                        }

                        $base_image_url = $db->setVal('global_url', 'ADMIN');


                        if (isset($_POST['image_logo_name'])) {
                            $image_logo_name = $_POST['image_logo_name'];
                            $image_logo_name_prev = $_POST['image_logo_name_prev'];

                            if ($upload_img->is_exists($image_logo_name, 'logo') != 1) {
                                $moveResult1 = $upload_img->image_upload2($image_logo_name, 'logo');
                                if ($moveResult1) {
                                    $img1_uploaded = 1;
                                } else {
                                    $img1_uploaded = 0;
                                }
                            }

                            $mno_logo_image_path = $upload_img->get_image($image_logo_name, 'logo');

                            if ($image_logo_name != $image_logo_name_prev && $upload_img->is_exists($image_logo_name_prev, 'logo') == 1) {
                                $remove_orig_image1 = $upload_img->remove_image($image_logo_name_prev, 'logo');
                            }

                            //-----------------------------------------------


                            if ($campaign_upload_img->is_exists($image_logo_name) != 1) {
                                $moveResult1 = $campaign_upload_img->image_upload2($image_logo_name);
                                if ($moveResult1) {
                                    $img1_uploaded = 1;
                                } else {
                                    $img1_uploaded = 0;
                                }
                            }

                            $camp_image_path = $campaign_upload_img->get_image($image_logo_name);

                            if ($image_logo_name != $image_logo_name_prev && $campaign_upload_img->is_exists($image_logo_name_prev) == 1) {
                                $remove_orig_image1 = $campaign_upload_img->remove_image($image_logo_name_prev);
                            }

                            //-----------------------------------------------



                            if ($tenant_upload_img->is_exists($image_logo_name) != 1) {
                                $moveResult2 = $tenant_upload_img->image_upload($image_logo_name);
                                if ($moveResult2) {
                                    $imgt_uploaded = 1;
                                } else {
                                    $imgt_uploaded = 0;
                                }
                            }

                            $tenant_logo_image_path = $tenant_upload_img->get_image($image_logo_name);


                            if ($image_logo_name != $image_logo_name_prev && $tenant_upload_img->is_exists($image_logo_name_prev) == 1) {
                                $remove_orig_image2 = $tenant_upload_img->remove_image($image_logo_name_prev);
                            }
                        }


                        if (isset($_POST['image_email_name'])) {
                            $image_email_name = $_POST['image_email_name'];
                            $image_email_name_prev = $_POST['image_email_name_prev'];
                            if ($upload_img->is_exists($image_email_name, 'welcome') != 1) {
                                $moveResult1 = $upload_img->image_upload2($image_email_name, 'welcome');
                                if ($moveResult1) {
                                    $img1_uploaded = 1;
                                } else {
                                    $img1_uploaded = 0;
                                }
                            }

                            $mno_email_image_path = $upload_img->get_image($image_email_name, 'welcome');


                            if ($image_email_name != $image_email_name_prev && $upload_img->is_exists($image_email_name_prev, 'welcome') == 1) {
                                $remove_orig_image2 = $upload_img->remove_image($image_email_name_prev, 'welcome');
                            }


                            if ($campaign_upload_img->is_exists($image_email_name) != 1) {
                                $moveResult2 = $campaign_upload_img->image_upload2($image_email_name);
                                if ($moveResult2) {
                                    $campaign_uploaded = 1;
                                } else {
                                    $campaign_uploaded = 0;
                                }
                            }

                            $campaign_email_image_path = $campaign_upload_img->get_image($image_email_name);


                            if ($image_email_name != $image_email_name_prev && $campaign_upload_img->is_exists($image_email_name_prev) == 1) {
                                $remove_orig_image2 = $campaign_upload_img->remove_image($image_email_name_prev);
                            }


                            if ($tenant_upload_img->is_exists($image_email_name) != 1) {
                                $moveResult2 = $tenant_upload_img->image_upload($image_email_name);
                                if ($moveResult2) {
                                    $imgt_uploaded = 1;
                                } else {
                                    $imgt_uploaded = 0;
                                }
                            }

                            $tenant_email_image_path = $tenant_upload_img->get_image($image_email_name);


                            if ($image_email_name != $image_email_name_prev && $tenant_upload_img->is_exists($image_email_name_prev) == 1) {
                                $remove_orig_image2 = $tenant_upload_img->remove_image($image_email_name_prev);
                            }
                        }



                        if (isset($_POST['image_favicon_name'])) {
                            $image_favicon_name = $_POST['image_favicon_name'];
                            //$image_favicon_name = 'fav_'.$image_favicon_name;
                            $image_favicon_name_prev = $_POST['image_favicon_name_prev'];

                            if ($upload_img->is_exists($image_favicon_name, 'welcome') != 1) {
                                $moveResult1 = $upload_img->image_upload2($image_favicon_name, 'welcome');
                                if ($moveResult1) {
                                    $img1_uploaded = 1;
                                } else {
                                    $img1_uploaded = 0;
                                }
                            }

                            $mno_favicon_image_path = $upload_img->get_image($image_favicon_name, 'welcome');

                            if ($image_favicon_name != $image_favicon_name_prev && $upload_img->is_exists($image_favicon_name_prev, 'welcome') == 1) {
                                $remove_orig_image1 = $upload_img->remove_image($image_favicon_name_prev, 'welcome');
                            }



                            if ($tenant_upload_img->is_exists($image_favicon_name) != 1) {
                                $moveResult2 = $tenant_upload_img->image_upload($image_favicon_name);
                                if ($moveResult2) {
                                    $imgt_uploaded = 1;
                                } else {
                                    $imgt_uploaded = 0;
                                }
                            }

                            $tenant_favicon_image_path = $tenant_upload_img->get_image($image_favicon_name);


                            if ($image_favicon_name != $image_favicon_name_prev && $tenant_upload_img->is_exists($image_favicon_name_prev) == 1) {
                                $remove_orig_image2 = $tenant_upload_img->remove_image($image_favicon_name_prev);
                            }
                        }


                        //https://bi-dmz-2.arrisi.com/campaign_portal/layout/DYNAMIC/img/s5.png

                        $mno_logo_image_url = $base_image_url . '/' . $mno_logo_image_path;
                        $mno_email_image_url = $base_image_url . '/' . $mno_email_image_path;
                        $mno_favicon_image_url = $base_image_url . '/' . $mno_favicon_image_path;



                        //default mvno
                        if ($mnoAccType == 'Factory_Manager') {
                        $dynamicMvnoSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='factory_manager_default_mvno_new'";
                        }else{
                        $dynamicMvnoSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='default_mvno_new'";
                        }
                        $dynamicMvnoSettings_res = $db->select1DB($dynamicMvnoSettings);
                        //$dynamicMvnoSettings_row = mysql_fetch_assoc($dynamicMvnoSettings_res);
                        $product_mvno_custom_settings = $dynamicMvnoSettings_res['settings'];

                        //$final_array=$db->escapeDB($final_array);
                        //print_r($final_array);

                        //$ex=$db->execDB("UPDATE `admin_product_controls_custom` set settings='$final_array' WHERE `product_id`='$product_id'");




                        $settings_vars_mvno = array(
                            '{active_template}' => $dynamic_product_id
                        );

                        /*$settings_vars_mvno = array(
                        '{default_ad_id}' => '1000',
                        '{login_sign}' => $mno_short_name,
                        '{support_no}' => $mno_support_number,
                        '{support_em}' => $mno_support_email,
                        '{about_url}' => $mno_about_url,
                        '{privacy_url}' => $mno_privacy_url,
                        '{primary_color}' => $mno_primary_color,
                        '{secondary_color}' => $mno_secondary_color,
                        '{logo_image_url}' => $mno_logo_image_url,
                        '{email_image_url}' => $mno_email_image_url,
                        '{aaa_username}' => $aaa_api_username,
                        '{aaa_password}' => $aaa_api_password,
                        '{aaa_tenant}' => $aaa_tenant,
                        '{aaa_product_owner}' => $aaa_product_owner,
                        '{dsf_username}' => $dsf_api_username,
                        '{dsf_password}' => $dsf_api_password
                        );


                    $product_mvno_custom_settings = mysql_real_escape_string(strtr($product_mvno_custom_settings, $settings_vars_mvno));*/

                        //default mvno


                        //default mvno admin
                        $product_mvno_custom_settings = $db->escapeDB(strtr($product_mvno_custom_settings, $settings_vars_mvno));
                        if ($mnoAccType == 'Factory_Manager') {
                        $dynamicAdminSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='factory_manager_default_mvno_admin_new'";   
                        }else{
                        $dynamicAdminSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='default_mvno_admin_new'";
                        }
                        $dynamicAdminSettings_res = $db->select1DB($dynamicAdminSettings);
                        //$dynamicAdminSettings_row = mysql_fetch_assoc($dynamicAdminSettings_res);
                        $product_admin_custom_settings = $dynamicAdminSettings_res['settings'];


                        $settings_vars_admin = array(
                            '{login_sign}' => $mno_short_name,
                            '{location_package}' => $dynamic_mvno_id
                        );


                        $product_admin_custom_settings = $db->escapeDB(strtr($product_admin_custom_settings, $settings_vars_admin));

                        //default mvno admin


                        //default
                        if ($mnoAccType == 'Factory_Manager') {
                        $dynamicSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='factory_manager_default_new'";
                        }else{
                        $dynamicSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='default_new'";
                        }
                        $dynamicSettings_res = $db->select1DB($dynamicSettings);
                        //$dynamicSettings_row = mysql_fetch_assoc($dynamicSettings_res);
                        $product_controls_custom_settings = $dynamicSettings_res['settings'];
                        //$operator_allowed_tab=$product_controls_custom_settings['general']['ALLOWED_TAB']['options'];

                        $settings_vars = array(
                            '{default_ad_id}' => '1000',
                            '{login_sign}' => $mno_short_name,
                            '{support_no}' => $mno_support_number,
                            '{support_em}' => $mno_support_email,
                            '{about_url}' => $mno_about_url,
                            '{privacy_url}' => $mno_privacy_url,
                            '{toc_url}' => $mno_toc_url,
                            '{primary_color}' => $mno_primary_color,
                            '{secondary_color}' => $mno_secondary_color,
                            '{logo_image_url}' => $mno_logo_image_url,
                            '{email_image_url}' => $mno_email_image_url,
                            '{favicon_image_url}' => $mno_favicon_image_url,
                            '{aaa_username}' => $aaa_api_username,
                            '{aaa_password}' => $aaa_api_password,
                            '{aaa_username_vm}' => $aaa_api_username_vm,
                            '{aaa_password_vm}' => $aaa_api_password_vm,
                            '{aaa_api_acc_org}' => $aaa_api_acc_org,
                            '{aaa_url}' => $aaa_api_url,
                            '{aaa_url2}' => $aaa_api_url2,
                            '{aaa_type}' => $aaa_api_type,
                            '{aaa_tenant}' => $aaa_tenant,
                            '{aaa_auth_token}' => $aaa_api_acc_org,
                            '{aaa_product_owner}' => $aaa_product_owner,
                            '{dsf_url}' => $dsf_api_url,
                            '{dsf_username}' => $dsf_api_username,
                            '{dsf_password}' => $dsf_api_password,
                            '{abuse_url}' => $abuse_api_url,
                            '{abuse_username}' => $abuse_api_username,
                            '{abuse_password}' => $abuse_api_password,
                            '{mvno_admin_product}' => $dynamic_admin_id,
                            '{mvno_product}' => $dynamic_mvno_id
                        );


                        $product_controls_custom_settings = strtr($product_controls_custom_settings, $settings_vars);

                        $product_controls_custom_settings_default = json_decode($product_controls_custom_settings, true);

                        //default

                        if ($get_edit_get != 1) {

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


                            // $mac_value['element']='.contact-us-txt';
                            // $mac_value['value']='<p style=\"text-align: center;\"><strong>Need help? Call '.$mno_support_number.'</strong></p>';

                            // array_push($new_mac_arr, $mac_value);
                            $contact_us = '<p style=\"text-align: center;\"><strong>Need help? Call ' . $mno_support_number . '</strong></p>';
                            $new_theme_data['contenteditable_arr'] = $new_contenteditable_arr;
                            $new_theme_data['upload_arr'] = $new_upload_arr;
                            $new_theme_data['mce_arr'] = $new_mac_arr;
                            $new_theme_data['color_arr'] = $new_color_arr;
                            $new_theme_data = $db->escapeDB(json_encode($new_theme_data));


                            $rowe = $db->selectDB("SHOW TABLE STATUS LIKE 'mdu_themes_details'");
                            $auto_inc_theme = $mno_short_name . '_DEFAULT_THEME_' . $rowe['data'][0]['Auto_increment'];

                            $query_mdu_theme = "INSERT INTO `mdu_themes` (
                                          `theme_name`,
                                          `title`,
                                          `theme_code`,
                                          `theme_type`,
                                          `distributor_code`,
                                          `style_type`,
                                          `welcome_text`,
                                          `welcome_des`,
                                          `contact_us`,
                                          `theme_color`,
                                          `light_color`,
                                          `btn_secondary_color`,
                                          `btn_color`,
                                          `bg_color`,
                                          `footer_color`,
                                          `top_line_color`,
                                          `login_screen_logo`,
                                          `top_logo`,
                                          `login_img`,
                                          `bg_img`,
                                          `favcon`,
                                          `template_code`,
                                          `create_date`,
                                          `is_enable`,
                                          `create_by`,
                                          `theme_details_id`)
                                        (SELECT
                                          '$mno_short_name Default THEME',
                                          `title`,
                                          UUID(),
                                          'MANUAL',
                                          '$mno_id',
                                          `style_type`,
                                          'Welcome to $mno_short_name Mobility',
                                          `welcome_des`,
                                          '$contact_us',
                                          `theme_color`,
                                          `light_color`,
                                          '$mno_secondary_color',
                                          '$mno_primary_color',
                                          `bg_color`,
                                          `footer_color`,
                                          `top_line_color`,
                                          '$image_logo_name',
                                          `top_logo`,
                                          `login_img`,
                                          `bg_img`,
                                          '$image_favicon_name',
                                          `template_code`,
                                          now(),
                                          `is_enable`,
                                          '$user_name',
                                          '$auto_inc_theme'
                                        FROM
                                          `mdu_themes`
                                        WHERE `theme_code`='DEFAULT_THEME_DYNAMIC' LIMIT 1)";

                            $ex_mdu = $db->execDB($query_mdu_theme);

                            $Q = "INSERT INTO `mdu_themes_details` (
                                            `unique_id`,
                                            `theme_data`,
                                            `completed`,
                                            `create_date`,
                                            `updated_by`
                                          )
                                          VALUES
                                            (
                                              '$auto_inc_theme',
                                              '$new_theme_data',
                                              '1',
                                              NOW(),
                                              'system'
                                            )";
                            $Q1 = $db->execDB($Q);
                        }

                        $rowe4 = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_camphaign_ads'");

                        $camphaign_id = $rowe4['Auto_increment'];



                        $insert_campaign = $db->execDB("INSERT INTO `exp_camphaign_ads` (
                                        `ad_id`,
                                        `ad_name`,
                                        `ad_description`,
                                        `ad_type`,
                                        `ad_category`,
                                        `duration_seconds`,
                                        `top_text`,
                                        `bottom_text`,
                                        `image1`,
                                        `image5`,
                                        `background_color`,
                                        `welcome_url`,
                                        `distributor`,
                                        `create_date`
                                        )
                                        VALUES
                                        (
                                        '$camphaign_id',
                                        '$mno_short_name',
                                        '$mno_short_name',
                                        'countdown_image',
                                        'Default Ad Category',
                                        '5',
                                        '$mno_account_name',
                                        'Get Online',
                                        '$image_email_name',
                                        '$image_logo_name',
                                        '$mno_primary_color',
                                        '$mno_about_url',
                                        '$mno_id',
                                        NOW()
                                    )");
                    }
                }


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
            WHERE `user_distributor` = '$edit_mno_id' ORDER BY id LIMIT 1"; //AND `verification_number` IS NOT NULL

                            if ($mno_sys_package == 'DYNAMIC_MNO_001' && $isDynamic == 'yes') {

                                $dynamicSettings = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id`='$get_dynamic_product_id'";
                                $dynamicSettings_res = $db->select1DB($dynamicSettings);
                                //$dynamicSettings_row = mysql_fetch_assoc($dynamicSettings_res);
                                /*$product_controls_custom_settings = $dynamicSettings_row['settings'];

                                $settings_vars_up = array(
                                    $prev_short_name => $mno_short_name,
                                    $mno_support_number_prev => $mno_support_number,
                                    $mno_support_email_prev => $mno_support_email,
                                    $mno_about_url_prev => $mno_about_url,
                                    $mno_privacy_url_prev => $mno_privacy_url,
                                    $mno_primary_color_prev => $mno_primary_color,
                                    $mno_secondary_color_prev => $mno_secondary_color,
                                    $mno_logo_url_prev => $mno_logo_image_url,
                                    $mno_email_url_prev => $mno_email_image_url,
                                    $mno_aaa_username_prev => $aaa_api_username,
                                    $mno_aaa_password_prev => $aaa_api_password,
                                    $mno_aaa_tenant_prev => $aaa_tenant,
                                    $mno_aaa_product_owner_prev => $aaa_product_owner,
                                    $mno_dsf_username_prev => $dsf_api_username,
                                    $mno_dsf_password_prev => $dsf_api_password
                                );
                                $product_controls_custom_settings = mysql_real_escape_string(strtr($product_controls_custom_settings, $settings_vars_up));

                                $getAdmin = json_decode($dynamicSettings_row['settings'], true);
                                $admin_product_id = $getAdmin['general']['MVNO_ADMIN_PRODUCT']['options'];*/

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
                                //$dynamicAdminSettings_row = mysql_fetch_assoc($dynamicAdminSettings_res);


                                $product_admin_custom_settings = json_decode($dynamicAdminSettings_res['settings'], true);
                                $product_admin_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_admin_custom_settings = json_encode($product_admin_custom_settings);

                                //$product_admin_custom_settings = $dynamicAdminSettings_row['settings'];

                                /* $settings_var = array(
                                    $prev_short_name => $mno_short_name
                                );

                                $product_admin_custom_settings = mysql_real_escape_string(strtr($product_admin_custom_settings, $settings_var));*/


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

                                    /*if (!in_array('campaign', $allowed_page)) {
                                    array_push($allowed_page, 'campaign');
                                }
                                if (!in_array('reports', $allowed_page)) {
                                    array_push($allowed_page, 'reports');
                                }*/
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

                                $mdu_theme_exist = $db->getValueAsf("SELECT theme_code AS f FROM `mdu_themes`  WHERE `distributor_code` = '$edit_mno_id' AND `property_id` IS NULL");



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

                                if (strlen($mdu_theme_exist) < 1) {
                                    $rowe = $db->selectDB("SHOW TABLE STATUS LIKE 'mdu_themes_details'");
                                    $auto_inc_theme = $mno_short_name . '_DEFAULT_THEME_' . $rowe['data'][0]['Auto_increment'];



                                    $query7 = "INSERT INTO `mdu_themes` (
                                          `theme_name`,
                                          `title`,
                                          `theme_code`,
                                          `theme_type`,
                                          `distributor_code`,
                                          `style_type`,
                                          `welcome_text`,
                                          `welcome_des`,
                                          `contact_us`,
                                          `theme_color`,
                                          `light_color`,
                                          `btn_secondary_color`,
                                          `btn_color`,
                                          `bg_color`,
                                          `footer_color`,
                                          `top_line_color`,
                                          `login_screen_logo`,
                                          `top_logo`,
                                          `login_img`,
                                          `bg_img`,
                                          `favcon`,
                                          `template_code`,
                                          `create_date`,
                                          `is_enable`,
                                          `create_by`,
                                          `theme_details_id`)
                                        (SELECT
                                          '$mno_short_name Default THEME',
                                          `title`,
                                          UUID(),
                                          'MANUAL',
                                          '$edit_mno_id',
                                          `style_type`,
                                          'Welcome to $mno_short_name Mobility',
                                          `welcome_des`,
                                          `contact_us`,
                                          `theme_color`,
                                          `light_color`,
                                          '$mno_secondary_color',
                                          '$mno_primary_color',
                                          `bg_color`,
                                          `footer_color`,
                                          `top_line_color`,
                                          '$image_logo_name',
                                          `top_logo`,
                                          `login_img`,
                                          `bg_img`,
                                          '$image_favicon_name',
                                          `template_code`,
                                          now(),
                                          `is_enable`,
                                          '$user_name',
                                          '$auto_inc_theme'
                                        FROM
                                          `mdu_themes`
                                        WHERE `theme_code`='DEFAULT_THEME_DYNAMIC' LIMIT 1)";


                                    //$ex_mdu = $db->execDB($query_mdu_theme);

                                    $query7_1 = "INSERT INTO `mdu_themes_details` (
        `unique_id`,
        `theme_data`,
        `completed`,
        `create_date`,
        `updated_by`
      )
      VALUES
        (
          '$auto_inc_theme',
          '$new_theme_data',
          '1',
          NOW(),
          'system'
        )";
                                    //$Q1 = $db->execDB($Q);

                                } else {
                                    $mdu_theme_details_id = $db->getValueAsf("SELECT theme_details_id AS f FROM `mdu_themes`  WHERE `distributor_code` = '$edit_mno_id' AND `property_id` IS NULL");

                                    $query7 = "UPDATE `mdu_themes` SET `login_screen_logo` = '$image_logo_name',`favcon` = '$image_favicon_name' WHERE `distributor_code` = '$edit_mno_id' AND `property_id` IS NULL";
                                    $query7_1 = "UPDATE `mdu_themes_details` SET `theme_data` = '$new_theme_data' WHERE `unique_id` = '$mdu_theme_details_id'";
                                }

                                $default_campaign_id = $db->getValueAsf("SELECT `default_campaign_id` AS f FROM `exp_mno` WHERE `mno_id` = '$edit_mno_id'");

                                if (empty($default_campaign_id) || $default_campaign_id == 0) {

                                    $rowe4 = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_camphaign_ads'");

                                    $camphaign_id_ed = $rowe4['Auto_increment'];



                                    $insert_campaign = $db->execDB("INSERT INTO `exp_camphaign_ads` (
                                        `ad_id`,
                                        `ad_name`,
                                        `ad_description`,
                                        `ad_type`,
                                        `ad_category`,
                                        `duration_seconds`,
                                        `top_text`,
                                        `bottom_text`,
                                        `image1`,
                                        `image5`,
                                        `background_color`,
                                        `welcome_url`,
                                        `distributor`,
                                        `create_date`
                                        )
                                        VALUES
                                        (
                                        '$camphaign_id_ed',
                                        '$mno_short_name',
                                        '$mno_short_name',
                                        'countdown_image',
                                        'Default Ad Category',
                                        '5',
                                        '$mno_account_name',
                                        'Get Online',
                                        '$image_email_name',
                                        '$image_logo_name',
                                        '$mno_primary_color',
                                        '$mno_about_url',
                                        '$edit_mno_id',
                                        NOW()
                                    )");
                                    $update_mno_camp = $db->execDB("UPDATE `exp_mno` SET `default_campaign_id` = '$camphaign_id_ed' WHERE `mno_id` = '$edit_mno_id'");
                                } else {
                                    $update_mno_camp = $db->execDB("UPDATE `exp_camphaign_ads` SET `background_color` = '$mno_primary_color' , `image1` = '$image_email_name' , `image5` = '$image_logo_name' WHERE `ad_id` = '$default_campaign_id' ");
                                }



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
                                /*$product_controls_custom_settings = $dynamicSettings_row['settings'];

                                $settings_vars = array(
                                    $prev_short_name => $mno_short_name,
                                    $mno_support_number_prev => $mno_support_number,
                                    $mno_support_email_prev => $mno_support_email,
                                    $mno_about_url_prev => $mno_about_url,
                                    $mno_privacy_url_prev => $mno_privacy_url,
                                    $mno_primary_color_prev => $mno_primary_color,
                                    $mno_secondary_color_prev => $mno_secondary_color,
                                    $mno_logo_url_prev => $mno_logo_image_url,
                                    $mno_email_url_prev => $mno_email_image_url,
                                    $mno_aaa_username_prev => $aaa_api_username,
                                    $mno_aaa_password_prev => $aaa_api_password,
                                    $mno_aaa_tenant_prev => $aaa_tenant,
                                    $mno_aaa_product_owner_prev => $aaa_product_owner,
                                    $mno_dsf_username_prev => $dsf_api_username,
                                    $mno_dsf_password_prev => $dsf_api_password
                                );

                                $product_controls_custom_settings = mysql_real_escape_string(strtr($product_controls_custom_settings, $settings_vars));

                                $getAdmin = json_decode($dynamicSettings_row['settings'], true);
                                $admin_product_id = $getAdmin['general']['MVNO_ADMIN_PRODUCT']['options'];*/

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
                                //$dynamicAdminSettings_row = mysql_fetch_assoc($dynamicAdminSettings_res);
                                //$product_admin_custom_settings = $dynamicAdminSettings_row['settings'];

                                $product_admin_custom_settings = json_decode($dynamicAdminSettings_res['settings'], true);
                                $product_admin_custom_settings['general']['LOGIN_SIGN']['access_method'] = $mno_short_name;
                                $product_admin_custom_settings = json_encode($product_admin_custom_settings);

                                /* $settings_var = array(
                                    $prev_short_name => $mno_short_name
                                );

                                $product_admin_custom_settings = mysql_real_escape_string(strtr($product_admin_custom_settings, $settings_var));*/

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
                            foreach ($featurearr as $value) {
                                if (!in_array($value, $lastfeatures)) {
                                    $db->changeFeature(new FeatureChange($value, 'Activated', $mno_id, $user_type, ''));
                                }
                            }
                            foreach ($lastfeatures as $value2) {
                                if (!in_array($value, $featurearr)) {
                                    $db->changeFeature(new FeatureChange($value2, 'Deactivated', $mno_id, $user_type, ''));
                                }
                            }

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

                            $create_log->save('3002', $message_functions->showMessage('operator_update_success'), '');
                            $_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_update_success') . "</strong></div>";
                        } else {
                            $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                            $create_log->save('2001', $message_functions->showMessage('operator_update_failed', '2001'), '');
                            $_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_update_failed', '2001') . "</strong></div>";
                        }


                        //******************************************************************


                    } else {
                        $q_theme_insert = "INSERT INTO `exp_themes` (
          `theme_id`,
          `theme_name`,
          `distributor`,
          `language`,
          `registration_type`,
          `social_login_txt`,
          `manual_login_txt`,
          `welcome_txt`,
          `toc_txt`,
          `loading_txt`,
          `welcome_back_txt`,
          `registration_btn`,
          `connect_btn`,
          `fb_btn`,
          `male_field`,
          `female_field`,
          `email_field`,
          `age_group_field`,
          `gender_field`,
          `btn_color`,
          `btn_border`,
          `btn_text_color`,
          `create_date`,
          `updated_by`)
        (SELECT

          '$mno_id',
          '$mno_id THEME',
          'MNO',
          `language`,
          `registration_type`,
          `social_login_txt`,
          `manual_login_txt`,
          `welcome_txt`,
          `toc_txt`,
          `loading_txt`,
          `welcome_back_txt`,
          `registration_btn`,
          `connect_btn`,
          `fb_btn`,
          `male_field`,
          `female_field`,
          `email_field`,
          `age_group_field`,
          `gender_field`,
          `btn_color`,
          `btn_border`,
          `btn_text_color`,
          NOW(),
          '$login_user_name'
        FROM
          `exp_themes`
        WHERE `theme_id`='default_theme' LIMIT 1)";
                        $ex_theme_insert = $db->execDB($q_theme_insert);

                        ////////////////////////////////////////////////////////////////////////////
                        if ($mno_form_type == 'advanced_menu') { //advanced_menu
                            $query0 = "INSERT INTO `exp_mno` (
                          `api_prefix`,
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
                          `aaa_data`,
                          `default_campaign_id`)
                        VALUES
                          ( $mno_api_prefix,
                           '$mno_id',
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
                            '$aaa_data_op',
                            '$camphaign_id')";
                        } else {
                            $query0 = "INSERT INTO `exp_mno` (`system_package`,`mno_id`, `mno_description`, `mno_type`, `is_enable`,create_user, `create_date`)
        VALUES ('$mno_sys_package','$mno_id', '$mno_account_name','$mnoAccType','0','$login_user_name', NOW())";
                        }
                        //echo $query0;


                        $ex0 = $db->execDB($query0);

                        if ($ex0 === true) {
                            foreach ($featurearr as $value) {
                                $db->changeFeature(new FeatureChange($value, 'Activated', $mno_id, $user_type, ''));
                            }

                            foreach ($_POST['AP_cont'] as $selectedOptionap) {
                                $ap = $selectedOptionap;
                                $query_01 = "INSERT INTO `exp_mno_ap_controller` (`mno_id`, `ap_controller`, `create_user`, `create_date`)
                VALUES ('$mno_id', '$ap', '$user_name',NOW())";
                                $ex01 = $db->execDB($query_01);
                            }
                            foreach ($_POST['vt_group'] as $vtgroup) {
                                $query_01 = "INSERT INTO `mdu_mno_organizations` (`mno`, `property_id`, `create_user`, `create_date`)
                VALUES ('$mno_id', '$vtgroup', '$user_name',NOW())";
                                $ex01 = $db->execDB($query_01);

                                $query0_org = "UPDATE `mdu_organizations` SET `mno_system_package` = '$mno_sys_package' WHERE `property_id` = '$vtgroup'";
                                $exquery0_org = $db->execDB($query0_org);
                            }


                            $query0 = "INSERT INTO `admin_users` (`user_name`,`password`, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `mobile`, `timezone`, `is_enable`,create_user, `create_date`,`admin`)
            VALUES ('$new_user_name',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))), 'admin', '$mno_user_type', '$mno_id', '$mno_full_name', '$mno_email', '$mno_mobile_1', '$mno_time_zone', '2','$login_user_name', NOW(), '$user_type')";
                            $ex0 = $db->execDB($query0);


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

                            //email template
                            //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
                            $cunst_var = array();
                            /*if($emailTemplateType=='child'){
                    $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$mno_sys_package);
                }elseif($emailTemplateType=='owen'){
                    $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                }else{
                    $cunst_var['template']=$emailTemplateType;
                }*/
                            $cunst_var['system_package'] = $mno_sys_package;
                            $cunst_var['mno_package'] = $system_package;
                            $cunst_var['mno_id'] = $mno_id;
                            $cunst_var['verticle'] = $verticle;


                            $mail_obj = new email($cunst_var);
                            $mail_obj->mno_system_package = $system_package;

                            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                            //$mail_sent = @mail($to, $subject, $message, $headers);

                            //$_SESSION['msg6'] .= $mail_sent ? "Mail sent" : "Mail failed";

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



                                        $insert_texts_q = "INSERT INTO `exp_texts` (`text_code`,`title`,`text_details`,`vertical`,`distributor`,`create_date`, `updated_by`)
                        VALUES ('$text_code_new', '$text_title_new', '$text_details_new', '$text_veritcal_new','$mno_id', now(), '$text_updated_by_new')";

                                        $insert_texts = $db->execDB($insert_texts_q);
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
                            $create_log->save('', $message_functions->showMessage('operator_create_success'), '');

                            $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_success') . "</strong></div>";
                        } else {
                            $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                            $create_log->save('2001', $message_functions->showMessage('operator_create_failed', '2001'), '');
                            $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_failed', '2001') . "</strong></div>";
                        }
                    }
                } //1

                else { //1
                    $db->userErrorLog('2009', $user_name, 'script - ' . $script);
                    $create_log->save('2001', $message_functions->showMessage('operator_create_failed', '2009'), '');
                    $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_failed', '2009') . "</strong></div>";
                } //1
            } else {
                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_create_success') . "</strong></div>";
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);

            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

            $_SESSION['msg6'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php');
        }
    } //6

    ////   Resend Email  /////
    elseif (isset($_POST['resendMail']) || isset($_GET['resendMail'])) { //5.1
        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5'] || $_SESSION['FORM_SECRET'] == $_GET['form_secret5']) { //refresh validate


            if (isset($_POST['resendMail'])) {
                $distributor_code = $_POST['distributor_code'];
                $distributor_name = $_POST['distributor_name'];
            } else {
                $distributor_code = $_GET['distributor_code'];
                $distributor_name = $_GET['distributor_name'];
            }


            $query = "SELECT a.email,a.verification_number,a.full_name,a.user_type,e.* FROM admin_users a  LEFT JOIN `admin_invitation_email` e ON
                    a.user_distributor=e.distributor 
                    WHERE a.verification_number = '$distributor_code' AND a.`verification_number` IS NOT NULL";
            $result = $db->selectDB($query);


            foreach ($result['data'] as $row) {
                $resend_email = $row[email];
                $to = $row[to];
                $subject = $row[subject];
                $message = $row[message];
                $icomme_number = $row[verification_number];
                $f_name = $row[full_name];
                $user_type1 = $row[user_type];

                $uname = $row[user_name];
                $pw_re = $row[password_re];

                //$header = $row[header];
                //$to = $row[to];
            }
            $customer_type = $db->getValueAsf("SELECT system_package AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");
            $distributor_name = $db->getValueAsf("SELECT account_name AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");
            $dis_detail = $db->select1DB("SELECT system_package,bussiness_type FROM exp_mno_distributor WHERE parent_id='$icomme_number' ORDER BY `id` DESC LIMIT 1");
            $dis_sys_package = $dis_detail['system_package'];
            $dis_vertical = $dis_detail['bussiness_type'];

            $distributor_name = str_replace('\\', '', $distributor_name);

            //$customer_type = 'COX_SIMP_001';

            if ($resend_email != $to) {
                $db->execDB("UPDATE admin_invitation_email SET `to`='$resend_email' WHERE `distributor` = '$distributor_code'");
            }

            $title = $db->setVal("short_title", $user_distributor);
            //   echo $user_distributor;
            $from = strip_tags($db->setVal("email", $user_distributor));
            if ($from == '') {
                $from = strip_tags($db->setVal("email", 'ADMIN'));
            }


            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
            include_once 'src/email/' . $email_send_method . '/index.php';

            //email template
            //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
            $cunst_var = array();
            /*if($emailTemplateType=='child'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$customer_type);
        }elseif($emailTemplateType=='owen'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }elseif(strlen($emailTemplateType)>0){
            $cunst_var['template']=$emailTemplateType;
        }else{
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }*/
            $cunst_var['system_package'] = $dis_sys_package;
            $cunst_var['mno_package'] = $system_package;
            $cunst_var['mno_id'] = $mno_id;
            $cunst_var['verticle'] = $dis_vertical;

            $mail_obj = new email($cunst_var);


            // $to = $mvnx_email;
            // $title=$db->setVal("short_title", $mno_id);
            //$subject = $subject = $db->textTitle('MAIL',$user_distributor);

            /*if($url_mod_override=='ON'){
            //http://216.234.148.168/campaign_portal_demo/optimum/login
            $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $customer_type).'/verification';
        }else{
            $link = $db->setVal("global_url", "ADMIN").'/verification_login.php?new_signin&login='.$package_functions->getSectionType('LOGIN_SIGN',$customer_type);
        }*/
            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $customer_type);
            $link = $db->getSystemURL('verification', $login_design);

            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $system_package, $dis_vertical);


            $vars = array(
                '{$user_full_name}' => $f_name,
                '{$short_name}' => $title,
                '{$account_type}' => $user_type1,
                '{$business_id}' => $icomme_number,
                '{$user_name}' => $uname,
                '{$password}' => $pw_re,
                '{$support_number}' => $support_number,
                '{$link}' => $link
            );

            $email_content = $db->getEmailTemplateVertical('PARENT_INVITE_MAIL', $system_package, 'MNO', $dis_vertical, $user_distributor);



            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];

            $message_full = strtr($a, $vars);
            
            $mail_obj->mno_system_package = $system_package;
            $mail_sent = $mail_obj->sendEmail($from, $resend_email, $subject, $message_full, '', $title);

            if ($mail_sent || strlen($mail_send) < 1) {

                $ssmsg = $message_functions->showNameMessage('property_send_email_suceess', $distributor_name);

                $create_log->save('3001', $ssmsg, '');
                $_SESSION['msg11'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $ssmsg . "</strong></div>";
            } else {

                $ssmsg = $message_functions->showNameMessage('property_send_email_failed', $distributor_name);

                $create_log->save('2001', $ssmsg, '');
                $_SESSION['msg11'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $ssmsg . "</strong></div>";
            }
        } else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

            $_SESSION['msg11'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            //header('Location: location.php');

        }
    } //5.1

    ////   remind Email  /////
    elseif (isset($_POST['remindMail']) || isset($_GET['remindMail'])) { //5.1
        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5'] || $_SESSION['FORM_SECRET'] == $_GET['form_secret5']) { //refresh validate


            if (isset($_POST['remindMail'])) {
                $distributor_code = $_POST['distributor_code'];
                $distributor_name = $_POST['distributor_name'];
            } else {
                $distributor_code = $_GET['distributor_code'];
                $distributor_name = $_GET['distributor_name'];
            }


            $query = "SELECT a.user_name AS username,a.password, a.email,a.verification_number,a.full_name,a.user_type,e.* FROM admin_users a  LEFT JOIN `admin_invitation_email` e ON
                    a.user_distributor=e.distributor 
                    WHERE a.verification_number = '$distributor_code' AND a.`verification_number` IS NOT NULL";
            $result = $db->selectDB($query);


            foreach ($result['data'] as $row) {
                $resend_email = $row['email'];
                $to = $row['to'];
                $subject = $row['subject'];
                $message = $row['message'];
                $icomme_number = $row['verification_number'];
                $f_name = $row['full_name'];
                $user_type1 = $row['user_type'];

                $uname = $row['user_name'];
                $pw_re = $row['password_re'];

                $username = $row['username'];
                $password_re = $row['password'];

                //$header = $row[header];
                //$to = $row[to];
            }
            $customer_type = $db->getValueAsf("SELECT system_package AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");
            $distributor_name = $db->getValueAsf("SELECT account_name AS f FROM mno_distributor_parent WHERE parent_id='$icomme_number'");
            $dis_detail = $db->select1DB("SELECT system_package,bussiness_type,mno_id FROM exp_mno_distributor WHERE parent_id='$icomme_number' ORDER BY `id` DESC LIMIT 1");
            $dis_sys_package = $dis_detail['system_package'];
            $dis_vertical = $dis_detail['bussiness_type'];
            $dis_mno_id = $dis_detail['mno_id'];

            $distributor_name = str_replace('\\', '', $distributor_name);

            //$customer_type = 'COX_SIMP_001';


            $title = $db->setVal("short_title", $user_distributor);
            //   echo $user_distributor;
            $from = strip_tags($db->setVal("email", $user_distributor));
            if ($from == '') {
                $from = strip_tags($db->setVal("email", 'ADMIN'));
            }


            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
            include_once 'src/email/' . $email_send_method . '/index.php';

            //email template
            //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
            $cunst_var = array();
            /*if($emailTemplateType=='child'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$customer_type);
        }elseif($emailTemplateType=='owen'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }elseif(strlen($emailTemplateType)>0){
            $cunst_var['template']=$emailTemplateType;
        }else{
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }*/
            $cunst_var['system_package'] = $dis_sys_package;
            $cunst_var['mno_package'] = $system_package;
            $cunst_var['mno_id'] = $dis_mno_id;
            $cunst_var['verticle'] = $dis_vertical;

            $mail_obj = new email($cunst_var);

            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $dis_sys_package, $dis_vertical);

            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $customer_type);
            $link = $db->getSystemURL('verification', $login_design);

            $unscubscribeAR=array();
            $unscubscribeAR['verification_number']=$icomme_number;
            $unscubscribeAR['mno_id']=$dis_mno_id;
            $unscubscribeAR['email_code']='PENDING_PARENT_INVITE_MAIL';
            $unscubscribeAR['create_user']=$username;
          
            $unscubscribeUrl=$customerOb->CreateUnsubscribeLink($unscubscribeAR);

            $vars = array(
                '{$user_full_name}' => $f_name,
                '{$short_name}' => $title,
                '{$account_type}' => $user_type1,
                '{$business_id}' => $icomme_number,
                '{$user_name}' => $uname,
                '{$password}' => $pw_re,
                '{$support_number}' => $support_number,
                '{$link}' => $link,
                '{$unsubscribe}'=>$unscubscribeUrl
            );

            $email_content = $db->getEmailTemplateVertical('PENDING_PARENT_INVITE_MAIL', $system_package, 'MNO', $dis_vertical, $user_distributor);

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];

            $message_full = strtr($a, $vars);
            $mail_obj->mno_system_package = $system_package;
            $mail_sent = $mail_obj->sendEmail($from, $resend_email, $subject, $message_full, '', $title);

            if ($mail_sent) {

                $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`user_name`,`password_re`,`distributor`,`send_options`,`last_update`, `create_date`)
            VALUES ('$resend_email', '$subject', '$message_full', '$username','$password_re','$distributor_code','REMIND', now(), now())";
                $mysql_query = $db->execDB($qu);

                $ssmsg = $message_functions->showNameMessage('pending_property_email_suceess', $distributor_name);

                $create_log->save('3001', $ssmsg, '');
                $_SESSION['msg11'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $ssmsg . "</strong></div>";
            } else {

                $ssmsg = $message_functions->showNameMessage('pending_property_email_failed', $distributor_name);

                $create_log->save('2001', $ssmsg, '');
                $_SESSION['msg11'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $ssmsg . "</strong></div>";
            }
        } else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

            $_SESSION['msg11'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            //header('Location: location.php');

        }
    }
    // location active and suspend
    else if (isset($_GET['status_loc_id'])) { //8


        if ($_SESSION['FORM_SECRET'] == $_GET['token7']) { //refresh validate

            $status_loc_id = $_GET['status_loc_id'];
            $status_loc_name = $_GET['status_loc_name'];
            $status_code = $_GET['status_code'];


            $tab_display = $_GET['t'];


            $q = "SELECT m.mno_id,c.zone_id,m.system_package,u.user_name,c.ap_controller,c.distributor_code,c.verification_number,c.distributor_name,c.bussiness_address1,c.bussiness_address2,c.state_region,c.zip,c.time_zone,c.is_enable_ext,c.is_enable,c.`bussiness_type`,m.api_prefix FROM exp_mno m JOIN admin_users u ON m.mno_id=u.user_distributor AND u.access_role='admin'
  LEFT JOIN exp_mno_distributor c ON m.mno_id=c.mno_id
WHERE c.`id`= '$status_loc_id' ORDER BY m.id LIMIT 1";

            $data1 = $db->select1DB($q);


            $icomme_number_st = $data1['verification_number'];
            $mno_id_st = $data1['mno_id'];
            $system_package_st = $data1['system_package'];
            $distributor_code_st = $data1['distributor_code'];
            $distributor_name_st = $data1['distributor_name'];
            $bussiness_address1_st = $data1['bussiness_address1'];
            $bussiness_address2_st = $data1['bussiness_address2'];
            $state_region_st = $data1['state_region'];
            $zip_st = $data1['zip'];
            $time_zone_st = $data1['time_zone'];
            $is_enable_st = (int) $data1['is_enable'];
            $is_enable_ext_st = (int) $data1['is_enable_ext'];
            $api_prefix_st = $data1['api_prefix'];
            $bussiness_type_st = $data1['bussiness_type'];



            $req = array(
                'propertyIdentifier' => $icomme_number_st,
                'icomsNumber' => $icomme_number_st,
                'propertyName' => CommonFunctions::clean($distributor_name_st),
                'operator' => $api_prefix_st,
                'vertical' => $bussiness_type_st,
                'address' => array('street' => $bussiness_address1_st, 'city' => $bussiness_address2_st, 'state' => $state_region_st),
                'devicesToMonitor' => array('ruckus-vsz', 'ruckus-switch'),
                'vmEdgeIP' => '0.0.0.0',
                'acIntIP' => '0.0.0.0',
                'switchIP' => '0.0.0.0',
                'clliCode' => 'NA',
                'businessIdentifier' => 'NA',
                'circuitId' => 'NA'
            );



            include 'src/zabbix/index.php';
            $zabbix = new zabbix($package_functions->getOptions('ZABBIX_API_PROFILE', $system_package));


            if ($tab_display == '1') {
                $session_id = 'msg12';
            } else {
                $session_id = 'msg11';
            }

            if ($status_code == '3') {
                $zabbixSuspend = $zabbix->suspend($req);
                $succee_msg_code = "account_suspend_success";
                $faild_msg_code = "account_suspend_failed";

                $status_dis_unique_q = "UPDATE`exp_mno_distributor` SET `is_enable` = '$status_code' , `suspended_date` = NOW() WHERE  `id`='$status_loc_id'";
            } else {
                $zabbixSuspend = $zabbix->resume($req);
                $succee_msg_code = "account_active_success";
                $faild_msg_code = "account_active_failed";

                $status_dis_unique_q = "UPDATE`exp_mno_distributor` SET `is_enable` = '$status_code' WHERE  `id`='$status_loc_id'";
            }

            // echo $status_dis_unique_q;
            $decodedzabbixSuspend = json_decode($zabbixSuspend, true);

            if ($decodedzabbixSuspend['status_code'] == '200') {
                $ex0 = $db->execDB($status_dis_unique_q);




                if ($ex0 === true) {
                    $db->userLog($user_name, $script, 'Active location', $status_loc_name);
                    $loc_rm_message = $message_functions->showNameMessage($succee_msg_code, str_replace('\\', '', $status_loc_name));

                    $_SESSION[$session_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";


                    freeRealm($verification_number_del, $db);
                } else {
                    $db->userErrorLog('2003', $user_name, 'script - ' . $script);

                    $loc_rm_message = $message_functions->showNameMessage($faild_msg_code, str_replace('\\', '', $status_loc_name), '2003');
                    $_SESSION[$session_id] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
                }
            } else {
                $db->userErrorLog('2003', $user_name, 'script - ' . $script);

                $loc_rm_message = $message_functions->showNameMessage($faild_msg_code, str_replace('\\', '', $status_loc_name), '2003');
                $_SESSION[$session_id] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php?t=create_property');
        }
    }
    //Remove Locations///    
    else if (isset($_GET['remove_loc_id'])) { //8

        if ($_SESSION['FORM_SECRET'] == $_GET['token7']) { //refresh validate

            $remove_loc_id = $_GET['remove_loc_id'];
            $remove_loc_name = $db->escapeDB($_GET['remove_loc_name']);
            $remove_loc_code = $_GET['remove_loc_code'];
            $tab_display = $_GET['t'];

            if ($tab_display == '1') {
                $session_id = 'msg12';
            } else {
                $session_id = 'msg11';
            }

            //$user_name = $_SESSION['user_name'];

            //archive distributor attached APs
            $rm_dis_unique_q = "SELECT * FROM `exp_mno_distributor` WHERE `id`='$remove_loc_id' LIMIT 1";
            $rm_dis_unique_arr = $db->selectDB($rm_dis_unique_q);

            foreach ($rm_dis_unique_arr['data'] as $row) {
                $rm_dis_unique = $row[unique_id];
                $wired = $row['wired'];
                $user_distributor_de = $row['distributor_code'];
                $system_package_de = $row['system_package'];
                $bussiness_type_de = $row['bussiness_type'];
                $verification_number_de = $row['verification_number'];
                $distributor_name_de = $row['distributor_name'];
                $state_de = $row['state_region'];
                $bussiness_address1_de = $row['bussiness_address1'];
                $bussiness_address2_de = $row['bussiness_address2'];
                $mno_id_de = $row['mno_id'];
                $zoneid_de = $row['zone_id'];
                $api_prefix_de = $db->getValueAsf("SELECT `api_prefix` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id_de'");
                $switch_group_id_de = $row['switch_group_id'];
                $sw_controller_de = $row['sw_controller'];
                $ap_controller_de = $row['ap_controller'];
                $automation_enable = $row['automation_enable'];
                $network_type = $row['network_type'];
            }
            if ($network_type == 'VT' || $network_type == 'VT-GUEST' || $network_type == 'VT-PRIVATE' || $network_type == 'VT-BOTH') {
                $vt_realm = $db->getValueAsf("SELECT property_id AS f FROM `mdu_distributor_organizations` WHERE `distributor_code`='$user_distributor_de'");
                $rm_vtenant_q = "SELECT * FROM `mdu_vetenant` WHERE `property_id`='$vt_realm'";
                $rm_vtenant_arr = $db->selectDB($rm_vtenant_q);
                if ($rm_vtenant_arr['rowCount'] > 0) {
                    $vt_pro = $package_functions->getOptions('VTENANT_NETWORK_PROFILE', $system_package);

                    $network_profile = $db->getValueAsf("SELECT `api_network_auth_method` AS f FROM `exp_network_profile` WHERE `network_profile` ='$vt_pro' ");

                    if (strlen($network_profile) > 0) {
                        require_once 'src/AAA/' . $network_profile . '/index.php';
                        $nf = new network_functions($vt_pro, '', $system_package);
                    } else {
                        $nf = null;
                    }
                    foreach ($rm_vtenant_arr['data'] as $datanew) {
                        $cust_user_name = $datanew['username'];
                        $rm_customer_id = $datanew['customer_id'];
                        $del_response = $nf->delUser($cust_user_name);
                        parse_str($del_response, $dev_res);
                        if ($dev_res['status_code'] == 200 || $dev_res['status'] == 200 || $dev_res['status_code'] == 404) {

                            $query0 = "DELETE FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'";
                            $query_de = "DELETE FROM mdu_customer_devices WHERE `customer_id`='$rm_customer_id'";

                            $query_purge_del1 = "DELETE FROM `mdu_purge_device_accounts` WHERE `username`='$cust_user_name'";
                            $query_purge_del2 = "DELETE FROM `mdu_mastera_acc_purge` WHERE `username`='$cust_user_name'";
                            $query_purge_del3 = "DELETE FROM `mdu_purge_accounts` WHERE `username` ='$cust_user_name'";


                            $del_vlanid = $db->getValueAsf("SELECT vlan_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");
                            $del_prop = $db->getValueAsf("SELECT property_id as f FROM mdu_vetenant WHERE `customer_id`='$rm_customer_id'");

                            //delete sub acc**************************

                            $sub_ass_q = "SELECT `mac_address` AS 'net_user' FROM mdu_customer_devices WHERE customer_id = '$rm_customer_id'";
                            $sub_ass_r = $db->selectDB($sub_ass_q);
                            $not_del_sub_acc = array();
                            $sub_del_respo = array();
                            foreach ($sub_ass_r['data'] as $devRow) {
                                $sub_del = $nf->delUser($devRow['net_user']);
                                parse_str($sub_del, $dev_res);
                                $new_status = $dev_res['status_code'];

                                if ($dev_res['status_code'] == 200 || $dev_res['status_code'] == 404) {
                                    $del_ses_response = $nf->getSessionsbymac($devRow['net_user']);

                                    $sessionstatus = json_decode($del_ses_response, true);
                                    $token = $sessionstatus['Description'];
                                    $status = $sessionstatus['status_code'];
                                    $ses_type = $sessionstatus['status'];

                                    if ($status_code == 200 || $status == 200) {
                                        $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = '%s'", $customer_id);
                                        $del_response = $nf->disconnectDeviceSessions($token, $devRow['net_user']);
                                        parse_str($del_response, $dev_res);
                                        if ($dev_res['status_code'] == 204 || $dev_res['status'] == 200) {
                                            $ex2 = $db->execDB($query2);
                                        }
                                    }
                                    //print_r($sub_del_respo);
                                    if ($new_status != 200 && $new_status != 404) {
                                        array_push($not_del_sub_acc, $devRow['net_user']);
                                    }
                                }
                            }

                            foreach ($not_del_sub_acc as $key => $net_user) {
                                $sub_del = $nf->delUser($net_user);
                                parse_str($sub_del, $dev_res);

                                //parse_str($device_response);

                                if ($dev_res['status_code'] == 200 || $dev_res['status_code'] == 404) {


                                    $del_ses_response = $nf->getSessionsbymac($net_user);

                                    $sessionstatus = json_decode($del_ses_response, true);
                                    //print_r($sessionstatus);
                                    $token = $sessionstatus['Description'];
                                    $status = $sessionstatus['status_code'];
                                    $ses_type = $sessionstatus['status'];

                                    if ($status_code == 200 || $status == 200) {
                                        $query2 = sprintf("DELETE FROM mdu_customer_sessions where mac = '%s'", $customer_id);
                                        $del_response = $nf->disconnectDeviceSessions($token, $net_user);
                                        parse_str($del_response, $dev_res);
                                        if ($dev_res['status_code'] == 204 || $dev_res['status'] == 200) {
                                            $ex2 = $db->execDB($query2);
                                        }
                                    }
                                }
                            }

                            $vlanOb->addDeleteVlanID($del_prop, $del_vlanid);



                            $archive_query = "INSERT INTO `mdu_customer_archive` 
                        (`customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,`archived_by`)
                        SELECT `customer_id`,`first_name`,`last_name`,`email`,`username`,`password`,`first_login_date`,`last_login_date`,`property_id`,`room_apt_no`,`question_id`,`answer`,`company_name`,`address`,`city`,`state`,`postal_code`,`country`,`phone`,`is_enable`,`email_sent`,`registration_from`,`device_count`,`valid_from`,`valid_until`,`create_user`,`create_date`,`search_id`,'$user_name'
                        FROM `mdu_vetenant` WHERE `customer_id`='$rm_customer_id'";

                            $arc_delete = $db->execDB($archive_query);
                            $ex_delete_de = $db->execDB($query_de);

                            if ($ex_delete_de === true) {
                                $ex_delete = $db->execDB($query0);
                                $ex_purge_delete1 = $db->execDB($query_purge_del1);
                                $ex_purge_delete2 = $db->execDB($query_purge_del2);
                                $ex_purge_delete3 = $db->execDB($query_purge_del3);

                            }
                        }
                    }
                }
            }

            $acc_selete_api_ar = $package_functions->callApi('ACC_DELETE_API', $system_package, 'YES');
            $acc_selete_api = $acc_selete_api_ar['access_method'];

            if ($user_type != 'SALES') {
                //  $wag_ap_name='NO_PROFILE';
                if ($wag_ap_name != 'NO_PROFILE' && $wired == '0') {


                    //  echo $package_functions->getSectionType('ZONE_DELETE', $system_package); exit();
                    if (($acc_selete_api == '1' || $acc_selete_api == '2') || $package_functions->getSectionType('ZONE_DELETE', $system_package) == '1') {

                        //echo $wag_ap_name2;

                        $ap_control_var = $db->setVal('ap_controller', 'ADMIN');

                        if ($ap_control_var == 'MULTIPLE') {

                            $get_distributor_zon_ap_q = "SELECT `zone_id`,`ap_controller` FROM `exp_mno_distributor` WHERE `distributor_code`='$remove_loc_code'";
                            $get_distributor_zon_ap_r = $db->selectDB($get_distributor_zon_ap_q);

                            foreach ($get_distributor_zon_ap_r['data'] as $get_distributor_zon_ap) {
                                $get_distributor_zon = $get_distributor_zon_ap[zone_id];
                                $get_distributor_ap = $get_distributor_zon_ap[ap_controller];
                            }

                            $ap_q2 = "SELECT `api_profile`
                    FROM `exp_locations_ap_controller`
                    WHERE `controller_name`='$get_distributor_ap'
                    LIMIT 1";

                            $query_results_ap2 = $db->selectDB($ap_q2);

                            foreach ($query_results_ap2['data'] as $row) {
                                $wag_ap_name2 = $row['api_profile'];
                            }

                            //echo 'src/AP/' . $wag_ap_name2 . '/index.php';

                            include 'src/AP/' . $wag_ap_name2 . '/index.php';
                            if ($wag_ap_name2 == "") {
                                include 'src/AP/' . $wag_ap_name . '/index.php';
                            }

                            $dis_wag_obj = new ap_wag($get_distributor_ap);
                        } else if ($ap_control_var == 'SINGLE') {


                            include 'src/AP/' . $wag_ap_name . '/index.php';
                            $dis_wag_obj = new ap_wag();
                        }
                    }
                    if ($package_functions->getSectionType('ZONE_DELETE', $system_package) == '1') {

                        // $remove_ruc_zone=$dis_wag_obj->deletezone($get_distributor_zon);
                        // parse_str($remove_ruc_zone);

                        //********************************delete  zone////////////////////////////////////////////////


                        $ap_q3 = "SELECT `api_profile`,`api_url`
                        FROM `exp_locations_ap_controller`
                        WHERE `controller_name`='$sw_controller_de'
                        LIMIT 1";

                        $query_results_ap3 = $db->select1DB($ap_q3);
                        $wag_ap_name3 = $query_results_ap3['api_profile'];
                        $switch_api_url = $query_results_ap3['api_url'];

                        if ($automation_enable == 1 and $bussiness_type_de == 'SMB') {
                            if (!empty($wag_ap_name3)) {
                                if ($ap_control_var == 'MULTIPLE') {

                                    include 'src/AP/' . $wag_ap_name3 . '/switch_index.php';
                                    if ($wag_ap_name3 == "") {
                                        include 'src/AP/' . $wag_ap_name . '/switch_index.php';
                                    }
                                    $wag_objSw = new switch_wag($sw_controller_de);
                                } else if ($ap_control_var == 'SINGLE') {

                                    include 'src/AP/' . $wag_ap_name . '/switch_index.php';
                                    $wag_objSw = new switch_wag();
                                }


                                $wag_objSw->deleteswitchgroup($switch_group_id_de);
                            }

                            $dis_wag_obj->deletezone($zoneid_de);
                        }



                        $req = array(
                            'propertyIdentifier' => $verification_number_de,
                            'icomsNumber' => $verification_number_de,
                            'propertyName' => CommonFunctions::clean($distributor_name_de),
                            'operator' => $api_prefix_de,
                            'vertical' => $bussiness_type_de,
                            'address' => array('street' => $bussiness_address1_de, 'city' => $bussiness_address2_de, 'state' => $state_de),
                            'devicesToMonitor' => array('ruckus-vsz', 'ruckus-switch'),
                            'vmEdgeIP' => '0.0.0.0',
                            'acIntIP' => '0.0.0.0',
                            'switchIP' => '0.0.0.0',
                            'clliCode' => 'NA',
                            'businessIdentifier' => 'NA',
                            'circuitId' => 'NA'
                        );

                        $external_json = $package_functions->getOptions('PROPERTY_CREATE_EXTERNAL_JSON', $system_package);
                        $external_arr = json_decode($external_json, true);
                        if ((array_key_exists("zabbix", $external_arr)) and $bussiness_type_de == 'SMB') {
                            include 'src/zabbix/index.php';
                            $zabbix = new zabbix($package_functions->getOptions('ZABBIX_API_PROFILE', $system_package));
                            $zabbixDelete = $zabbix->delete($req);
                            $decodedzabbixDelete = json_decode($zabbixDelete, true);
                        }
                    }


                    if ($acc_selete_api == '1' || $acc_selete_api == '2') {

                        $get_dis_schedule_q = "SELECT `uniqu_id` FROM `exp_distributor_network_schedul` WHERE `distributor_id`='$remove_loc_code' GROUP BY `uniqu_id`";
                        $get_dis_schedule_r = $db->selectDB($get_dis_schedule_q);

                        foreach ($get_dis_schedule_r['data'] as $get_dis_schedule) {
                            $dis_wag_obj->deleteeScheduler($get_distributor_zon, $get_dis_schedule[uniqu_id]);
                        }
                        //********************************delete network in zone////////////////////////////////////////////////
                        if ($acc_selete_api == '2') {
                            $get_network_ids_q = "SELECT network_id as id FROM exp_locations_ssid WHERE distributor='$remove_loc_code'
                                    UNION
                                    SELECT network_id as id FROM exp_locations_ssid_private WHERE distributor='$remove_loc_code'";
                            $get_network_ids = $db->selectDB($get_network_ids_q);

                            foreach ($get_network_ids['data'] as $get_network_ids_r) {
                                $dis_wag_obj->deleteSSID($get_distributor_zon, $get_network_ids_r['id']);
                            }
                        }



                        $wlan_groups_q = "SELECT wlan_group_id,b.name ,ap_group_id
                                        FROM exp_distributor_ap_wlan_group a
                                            LEFT JOIN exp_distributor_wlan_group b ON a.distributor=b.distributor AND a.wlan_group_id=b.w_group_id
                                        WHERE a.distributor='$remove_loc_code' GROUP BY wlan_group_id,b.name ,ap_group_id ORDER BY FIELD(b.name,'default') DESC ";

                        $wlan_groups = $db->selectDB($wlan_groups_q);

                        if ($wlan_groups['rowCount'] > 0) {
                            $default_wg = $wlan_groups['data'][0]['wlan_group_id'];
                            foreach ($wlan_groups['data'] as $wg_row) {
                                if ($wg_row['name'] == 'default')
                                    continue;

                                $dis_wag_obj->modifyWLanGroup($get_distributor_zon, $wg_row['ap_group_id'], $default_wg, 'default');
                                $dis_wag_obj->removeWLanGroups($get_distributor_zon, $wg_row['wlan_group_id']);
                            }
                        }

                        //if ($package_functions->callApi('ACC_DELETE_API', $system_package) == '1') {

                        //}

                        //echo $status_code."****";
                        $status_code = 200; // NO API check with account deletion
                        // end  $package_functions->callApi('ACC_DELETE_API',$system_package)=='1' *******************************************************
                    } else {
                        $status_code = 200;
                    }
                } else {
                    $status_code = 200;
                }

                if ($status_code == 200) {
                    $automation_on = $package_functions->getSectionType('NETWORK_AUTOMATION', $system_package);
                    if ($automation_on == 'Yes') {

                        $network_name = $package_functions->getOptions('NETWORK_PROFILE', $system_package);
                        if (strlen($network_name) == 0) {
                            $network_name = $db->setVal('network_name', 'ADMIN');
                        }
                        $row1 = $db->select1DB("SELECT * FROM `exp_network_profile` WHERE network_profile = '$network_name'");
                        $network_profile = $row1['api_network_auth_method'];
                        $row = $db->select1DB("SELECT * FROM `exp_mno` WHERE mno_id='$user_distributor'");
                        $aaa_data_op = json_decode($row['aaa_data'], true);

                        require_once(str_replace('//', '/', dirname(__FILE__) . '/') . '/src/AAA/' . $network_profile . '/index.php');

                        $aaa = new aaa($network_name, $system_package);
                        $aaa_data = $aaa->getNetworkConfig($network_name,'aaa_data');
                        $property_zone_name = str_replace(" ", "-", $distributor_name_de . " " . $verification_number_de);
                        $property_zone_name = CommonFunctions::clean($property_zone_name);
                        $all_zones = json_decode($aaa->getAllZones(), true);

                        foreach ($all_zones['Description'] as $value) {
                            if ($value['Id'] == $aaa_data['aaa_root_zone_id']) {

                                foreach ($value['Sub-Zones'] as $value1) {
                                    if ($value1['Name'] == $aaa_data_op['operator_zone_name']) {
                                        $op_zone_exists = true;
                                        $op_zone_id = $value1['Id'];
                                        foreach ($value1['Sub-Zones'] as $value2) {
                                            if ($value2['Name'] == $property_zone_name) {
                                                $property_arr = $value2;
                                                $property_zone_id = $value2['Id'];
                                                if (!empty($value2['Sub-Zones'])) {
                                                    $prop_sub_zones = $value2['Sub-Zones'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        //print_r($prop_sub_zones);
                        foreach ($prop_sub_zones as $valuen) {
                            $lookupkey = $valuen['Zone-Data']['Location-Id'];
                            $zone_id = $valuen['Id'];
                            if (!empty($valuen['Sub-Zones'])) {
                                foreach ($valuen['Sub-Zones'] as $valuenew) {
                                    $lookupkeysub = $valuenew['Zone-Data']['Location-Id'];
                                    $zone_idsub = $valuenew['Id'];
                                    $aaa->deleteLookupZone($lookupkeysub);
                                    $aaa->deleteZone($zone_idsub);
                                }
                            }
                            $aaa->deleteLookupZone($lookupkey);
                            $aaa->deleteZone($zone_id);
                        }

                        $aaa->deleteZone($property_zone_id);
                    }

                    //Delete cloudpath

                    $get_poolid = "SELECT `dpsk_pool_id`, `id` AS mdu_pool_id  FROM `mdu_dpsk_pool` WHERE `distributor` = '$remove_loc_code'";

                    $get_poolid_data = $db->selectDB($get_poolid);

                    foreach ($get_poolid_data['data'] as $pool_data) {

                        $dpsk_pool_id = $pool_data['dpsk_pool_id'];
                        $mdu_dpsk_pool_id = $pool_data['mdu_pool_id'];


                        if (!empty($dpsk_pool_id)) {

                            $data_fr = array();
                            $data_fr['user_distributor'] = $remove_loc_code;
                            $dpsks_factory = new dpsks_factory($data_fr);


                            $token_ar = $dpsks_factory->create_token();

                            $token_re = json_decode($token_ar, true);
                            $token_data = json_decode($token_re['Description'], true);



                            $data = array();
                            $data['token'] = $token_data['token'];
                            $data['dpskspool_id'] = $dpsk_pool_id;

                            $pdsk_pool_res = $dpsks_factory->Delete_dpsk_pool($data);
                            $pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
                            $pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);

                            $dpsk_up_status = $pdsk_pool_res_data['status_code'];

                            if ($dpsk_up_status == 200 || $dpsk_up_status == 204) {
                                $pool_ar = "INSERT INTO `mdu_dpsk_pool_archive` 
                    (`mdu_dpsk_pool_id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,`delete_by`,`delete_date`)
                    SELECT `id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,'Admin',NOW()
                    FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";

                                $pool_delete_q = "DELETE FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";
                                //  echo '<br>';
                                $db->execDB($pool_ar);
                                $db->execDB($pool_delete_q);
                            }
                        }
                    }




                    //distributor aps archive
                    $query_distrutor_aps_archive = "INSERT INTO `exp_mno_distributor_aps_archive` (
                  `id`,
                  `distributor_code`,
                  `ap_code`,
                  `assign_date`,
                  `assigned_by`,
                  `archive_by`,
                  `archive_date`
                  )(SELECT
                  `id`,
                  `distributor_code`,
                  `ap_code`,
                  `assign_date`,
                  `assigned_by`,
                   '$user_name',
                   NOW()
                FROM
                  `exp_mno_distributor_aps`
                WHERE distributor_code='$remove_loc_code') ";

                    $ex1 = $db->execDB($query_distrutor_aps_archive);


                    //archive distributor

                    $query_distrutor_archive = "INSERT INTO `exp_mno_distributor_archive` (

                                        id,
                                        verification_number,
                                        zone_id,
                                        ap_controller,
                                        tunnel_type,
                                        wag_profile,
                                        wag_profile_enable,
                                        distributor_code,
                                        property_id,
                                        distributor_name,
                                        bussiness_type,
                                        distributor_type,
                                        system_package,
                                        network_type,
                                        category,
                                        num_of_ssid,
                                        mno_id,
                                        parent_code,
                                        bussiness_address1,
                                        bussiness_address2,
                                        bussiness_address3,
                                        country,
                                        state_region,
                                        zip,
                                        phone1,
                                        phone2,
                                        phone3,
                                        bg_image,
                                        logo_image,
                                        theme,
                                        time_zone,
                                        language,
                                        site_title,
                                        theme_logo,
                                        theme_style_type,
                                        theme_top_line_color,
                                        camp_theme_color,
                                        theme_light_color,
                                        default_campaign_id,
                                        is_enable,
                                        create_date,
                                        create_user,
                                        last_update_ar,
                                        unique_id,
                                        archive_by,
                                        archive_date)

                   (
                  SELECT
                  id,
                                        verification_number,
                                        zone_id,
                                        ap_controller,
                                        tunnel_type,
                                        wag_profile,
                                        wag_profile_enable,
                                        distributor_code,
                                        property_id,
                                        distributor_name,
                                        bussiness_type,
                                        distributor_type,
                                        system_package,
                                        network_type,
                                        category,
                                        num_of_ssid,
                                        mno_id,
                                        parent_code,
                                        bussiness_address1,
                                        bussiness_address2,
                                        bussiness_address3,
                                        country,
                                        state_region,
                                        zip,
                                        phone1,
                                        phone2,
                                        phone3,
                                        bg_image,
                                        logo_image,
                                        theme,
                                        time_zone,
                                        language,
                                        site_title,
                                        theme_logo,
                                        theme_style_type,
                                        theme_top_line_color,
                                        camp_theme_color,
                                        theme_light_color,
                                        default_campaign_id,
                                        is_enable,
                                        create_date,
                                        create_user,
                                        last_update,
                                        unique_id,
                                        '$user_name',
                                      NOW()
                                    FROM
                                      exp_mno_distributor
                                      WHERE
                                    id='$remove_loc_id' LIMIT 1)";

                    $ex2 = $db->execDB($query_distrutor_archive);

                    //admin user archive

                    $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `user_distributor`='$remove_loc_code' AND `verification_number` IS NOT NULL
                  ) ";
                    $ex3 = $db->execDB($query_admin_user_archive);


                    //distributor group arcque
                    $query_group_archive = "INSERT INTO `exp_distributor_groups_archive` (
                      `id`,
                      `group_name`,
                      `description`,
                      `group_number`,
                      `distributor`,
                      `create_date`,
                      `last_update`,
                      `archive_by`,
                      `archive_date`
                    )

                      (
                    SELECT
                      `id`,
                      `group_name`,
                      `description`,
                      `group_number`,
                      `distributor`,
                      `create_date`,
                      `last_update`,
                       '$user_name',
                       NOW()
                    FROM
                      `exp_distributor_groups`
                      WHERE distributor='$remove_loc_code'
                      )";

                    $ex4 = $db->execDB($query_group_archive);


                    //   schedule archive
                    $archive_schedule_q = "INSERT INTO `exp_distributor_network_schedul_archive` (
  `id`,
  `uniqu_id`,
  `uniqu_name`,
  `schedul_name`,
  `is_enable`,
  `schedul_description`,
  `network_method`,
  `distributor_id`,
  `day`,
  `active_fulltime`,
  `from`,
  `to`,
  `create_user`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
)
SELECT
  `id`,
  `uniqu_id`,
  `uniqu_name`,
  `schedul_name`,
  `is_enable`,
  `schedul_description`,
  `network_method`,
  `distributor_id`,
  `day`,
  `active_fulltime`,
  `from`,
  `to`,
  `create_user`,
  `create_date`,
  `last_update`,
  '$user_name',
  NOW()
FROM
  `exp_distributor_network_schedul`
 WHERE `distributor_id`='$remove_loc_code'";


                    $ex5 = $db->execDB($archive_schedule_q);


                    //schedule assing archive

                    $network_schedule_assign_archive_q = "INSERT INTO `exp_distributor_network_schedul_assign_archive` (
  `id`,
  `ssid_broadcast`,
  `shedule_uniqu_id`,
  `network_id`,
  `ssid`,
  `distributor`,
  `network_method`,
  `create_date`,
  `create_user`,
  `last_update`
)
SELECT
  `id`,
  `ssid_broadcast`,
  `shedule_uniqu_id`,
  `network_id`,
  `ssid`,
  `distributor`,
  `network_method`,
  `create_date`,
  `create_user`,
  `last_update`
FROM
  `exp_distributor_network_schedul_assign`
  WHERE `distributor`='$remove_loc_code'";


                    $db->execDB($network_schedule_assign_archive_q);

                    //distributor zone archive
                    $distributor_zone_archive_q = "INSERT INTO `exp_distributor_zones_archive` (
  `id`,
  `zoneid`,
  `search_id`,
  `name`,
  `ap_controller`,
  `create_user`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
)
SELECT
  `id`,
  `zoneid`,
  `search_id`,
  `name`,
  `ap_controller`,
  `create_user`,
  `create_date`,
  `last_update`,
  '$user_name',
  NOW()
FROM
  `exp_distributor_zones`
WHERE `zoneid`='$get_distributor_zon'";

                    $db->execDB($distributor_zone_archive_q);


                    $prduct_dist_ar = "INSERT INTO `exp_products_distributor_archive` (
  `id`,
  `product_code`,
  `duration_prof_code`,
  `product_id`,
  `product_name`,
  `QOS`,
  `QOS_up_link`,
  `distributor_code`,
  `network_type`,
  `time_gap`,
  `max_session`,
  `session_alert`,
  `active_on`,
  `purge_time`,
  `distributor_type`,
  `create_user`,
  `is_enable`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_date`
) 
SELECT 
  `id`,
  `product_code`,
  `duration_prof_code`,
  `product_id`,
  `product_name`,
  `QOS`,
  `QOS_up_link`,
  `distributor_code`,
  `network_type`,
  `time_gap`,
  `max_session`,
  `session_alert`,
  `active_on`,
  `purge_time`,
  `distributor_type`,
  `create_user`,
  `is_enable`,
  `create_date`,
  `last_update`,
  '$user_name' ,
  NOW()  
FROM
  `exp_products_distributor` 
WHERE 
  distributor_code='$remove_loc_code'";

                    $db->execDB($prduct_dist_ar);

                    $voucher_ar = "INSERT exp_customer_vouchers_archive
                    SELECT *,NOW(),'$user_name','delete mvno' FROM exp_customer_vouchers WHERE reference='$remove_loc_code'";

                    $db->execDB($voucher_ar);

                    if ($ex1 == true && $ex2 === true && $ex3 === true && $ex4 === true) {

                        $verification_number_del = $db->getValueAsf("SELECT verification_number as f FROM exp_mno_distributor WHERE distributor_code='$remove_loc_code'");
                        //deloete disrtibutor attached aps
                        $ex0 = $db->execDB("DELETE FROM `exp_mno_distributor_aps` WHERE `distributor_code` = '$remove_loc_code' ");

                        //delete Distributor
                        $ex9 = $db->execDB("DELETE FROM `exp_mno_distributor` WHERE `id` = '$remove_loc_id' ");

                        //delete exp_settings
                        $ex10 = $db->execDB("DELETE FROM `exp_settings` WHERE `distributor` = '$remove_loc_code' ");

                        //delete admin_invitation_email
                        $ex11 = $db->execDB("DELETE FROM `admin_invitation_email` WHERE `distributor` = '$remove_loc_code' ");
                        //delete group
                        $ex12 = $db->execDB("DELETE FROM `exp_distributor_groups` WHERE `distributor`='$remove_loc_code'");
                        //delete admin users
                        $ex13 = $db->execDB("DELETE FROM `admin_users` WHERE `user_distributor`='$remove_loc_code' AND `verification_number` IS NOT NULL");

                        //delete power Schedule
                        $ex14 = $db->execDB("DELETE FROM `exp_distributor_network_schedul` WHERE `distributor_id`='$remove_loc_code'");

                        //delete power schedule assign
                        $ex15 = $db->execDB("DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$remove_loc_code'");

                        //delete zone
                        $ex15 = $db->execDB("DELETE FROM `exp_distributor_zones` WHERE `zoneid`='$get_distributor_zon'");

                        $ex16 = $db->execDB("DELETE FROM `exp_products_distributor` WHERE `distributor_code` = '$remove_loc_code'");

                        $ex17 = $db->execDB("DELETE FROM exp_customer_vouchers WHERE reference='$remove_loc_code'");
                        //delete mdu distributor org
                        $ex18 = $db->execDB("DELETE FROM `mdu_distributor_organizations` WHERE `distributor_code`='$remove_loc_code'");
                        /*delete multi icoms*/
                        $ex19 = $db->execDB("DELETE FROM `exp_icoms` WHERE distributor='$remove_loc_code'");
                    }

                    if ($ex0 === true) {
                        $db->userLog($user_name, $script, 'Remove Location', $remove_loc_name);
                        $loc_rm_message = $message_functions->showNameMessage('account_remove_success', str_replace('\\', '', $remove_loc_name));

                        $_SESSION[$session_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";


                        freeRealm($verification_number_del, $db);
                    } else {
                        $db->userErrorLog('2003', $user_name, 'script - ' . $script);

                        $loc_rm_message = $message_functions->showNameMessage('account_remove_failed', str_replace('\\', '', $remove_loc_name), '2003');
                        $_SESSION[$session_id] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
                    }
                } else {
                    $db->userErrorLog('2009', $user_name, 'script - ' . $script);

                    $loc_rm_message = $message_functions->showNameMessage('account_remove_failed', str_replace('\\', '', $remove_loc_name), '2009');

                    $_SESSION[$session_id] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
                }
            } else {
                $loc_rm_message = $message_functions->showNameMessage('account_remove_success', str_replace('\\', '', $remove_loc_name));
                $_SESSION[$session_id] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php?t=create_property');
        }
    } //8

    else if (isset($_GET['remove_par_id'])) {

        $rm_par_q = "SELECT id, distributor_code FROM exp_mno_distributor WHERE parent_id='$_GET[remove_par_code]'";
        $rm_par_name_q = "SELECT account_name AS f FROM mno_distributor_parent WHERE parent_id='$_GET[remove_par_code]'";

        $rm_par_name = $db->getValueAsf($rm_par_name_q);
        if ($user_type != 'SALES') {
            $rm_par_r = $db->selectDB($rm_par_q);

            foreach ($rm_par_r['data'] as $rm_row) {
                $distributor_code_edit = $rm_row['distributor_code'];
                $db->execDB("DELETE FROM `exp_icoms` WHERE distributor='$distributor_code_edit'");
                $rmLocKey = 'remove_loc_id=' . $rm_row['id'] . '&remove_loc_code=' . $rm_row['distributor_code'];
                $rmLocKey = cryptoJsAesEncrypt($data_secret, $rmLocKey);
                $rm_loc_url = $base_url . '/ajax/removeLocation.php?key=' . urlencode($rmLocKey);
                CommonFunctions::httpGet($rm_loc_url);
            }

            $query_p_archive = "INSERT INTO `mno_distributor_parent_archive` (
        `id`,
        `parent_id`,
        `system_package`,
        `mno_id`,
        `features`,
        `account_name`,
        `create_date`,
        `create_user`,
        `last_update`,
        `archive_status`,
        `archive_by`,
        `archive_date`
      )
(
    SELECT
  `id`,
  `parent_id`,
  `system_package`,
  `mno_id`,
  `features`,
  `account_name`,
  `create_date`,
  `create_user`,
  `last_update`,
  '1',
  'manual',
  NOW()
FROM
  `mno_distributor_parent` 
  WHERE parent_id='$_GET[remove_par_code]'
)";

            $query_u_archive = "INSERT INTO `admin_users_archive` (
    `id`,
    `user_name`,
    `password`,
    `access_role`,
    `user_type`,
    `user_distributor`,
    `full_name`,
    `email`,
    `language`,
    `mobile`,
    `verification_number`,
    `is_enable`,
    `create_date`,
    `create_user`,
    `archive_by`,
    `archive_date`,
    `last_update`
  )
(
  SELECT
    `id`,
    `user_name`,
    `password`,
    `access_role`,
    `user_type`,
    `user_distributor`,
    `full_name`,
    `email`,
    `language`,
    `mobile`,
    `verification_number`,
    `is_enable`,
    `create_date`,
    `create_user`,
    'manual',
    NOW(),
    `last_update`
  FROM `admin_users`
  WHERE
    `verification_number`='$_GET[remove_par_code]'
    ) ";

            $query_p_archive_q = $db->execDB($query_p_archive);
            $query_u_archive_q = $db->execDB($query_u_archive);

            $db->execDB("DELETE FROM mno_distributor_parent WHERE parent_id='$_GET[remove_par_code]'");

            $db->execDB("DELETE FROM admin_users WHERE verification_number='$_GET[remove_par_code]' AND `verification_number` IS NOT NULL");

            $loc_rm_message = $message_functions->showNameMessage('account_remove_success', str_replace('\\', '', $rm_par_name));
            $db->userLog($user_name, $script, 'Remove Account', $rm_par_name);
            $_SESSION[msg5] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
        } else {
            $loc_rm_message = $message_functions->showNameMessage('account_remove_success', str_replace('\\', '', $rm_par_name));
            $_SESSION[msg5] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $loc_rm_message . "</strong></div>";
        }
    } //Edit Locations///
    else if (isset($_GET['edit_loc_id'])) { //8


        if ($_SESSION['FORM_SECRET'] == $_GET['token7']) { //refresh validate


            $edit_loc_id = $_GET['edit_loc_id'];
            $ex_get_q = "SELECT d.automation_enable,d.wired,d.wlan_count,d.sw_controller,d.switch_group_id, d.dns_profile, d.content_filter_enable, d.property_id ,d.parent_id , d.gateway_type,d.private_gateway_type, d.wag_profile_enable,d.wag_profile, d.ap_controller,d.id, d.`zone_id`, d.`tunnel_type`,d.`private_tunnel_type`, d.`bussiness_type`, d.`network_type`, d.`distributor_code`,
 d.`distributor_name`, d.`distributor_type`, d.`system_package`, d.`category`, d.`num_of_ssid`,
 d.`bussiness_address1`, d.`bussiness_address2`, d.`bussiness_address3`, d.`country`, c.`country_name`,d.`advanced_features`,
  d.`state_region`, d.`zip`, d.`phone1`, d.`phone2`, d.`phone3`, d.`time_zone`, u.`full_name`,
  u.`email`, u.mobile, u.`verification_number`, g.`group_name`,
  g.`group_number`, g.`description`,p.features,d.`dpsk_voucher`,d.other_settings,d.firewall_controller,d.organizations_id,p.dpsk_controller,p.dpsk_policies,d.migrated
FROM `exp_mno_distributor` d
LEFT JOIN exp_mno_country c ON d.`country` = c.`country_code`
LEFT JOIN `admin_users` u ON d.`distributor_code`=u.`user_distributor`
LEFT JOIN `exp_distributor_groups` g ON d.`distributor_code`=g.`distributor`
LEFT JOIN `mno_distributor_parent` p ON d.`parent_id`=p.`parent_id`
WHERE d.id='$edit_loc_id' AND u.`verification_number` IS NOT NULL LIMIT 1
";


            $rowE = $db->select1DB($ex_get_q);

            //$rowE = mysql_fetch_array($ex_get);
            $edit_distributor_code = $rowE[distributor_code];
            $edit_distributor_ap_controller = $rowE[ap_controller];
            $edit_distributor_sw_controller = $rowE[sw_controller];
            $edit_distributor_group_name = $rowE[group_name];
            $edit_distributor_property_id = $rowE[property_id];
            $edit_distributor_group_description = $rowE[description];
            $edit_distributor_wag_profile = $rowE[wag_profile];
            $edit_distributor_dns_profile = $rowE[dns_profile];
            $edit_distributor_dns_profile_enable = $rowE[content_filter_enable];
            $edit_distributor_wag_profile_enable = $rowE[wag_profile_enable];
            $edit_migrated = $rowE[migrated];
            $edit_distributor_group_number = $rowE[group_number];
            $edit_distributor_zone_id = $rowE[zone_id];
            $edit_distributor_sw_group_id = $rowE[switch_group_id];
            $edit_distributor_tunnel_type = $rowE[tunnel_type];
            $edit_distributor_pr_tunnel_type = $rowE[private_tunnel_type];
            $edit_distributor_gateway_type = $rowE[gateway_type];
            $edit_distributor_pr_gateway_type = $rowE[private_gateway_type];
            $edit_distributor_business_type = $rowE[bussiness_type];
            $edit_distributor_network_type = $rowE[network_type];
            $edit_distributor_verification_number = $edit_distributor_network_type != 'VT' ? $rowE[verification_number] : '';
            $edit_distributor_name = $rowE[distributor_name];
            $edit_distributor_type = $rowE[distributor_type];
            $edit_distributor_system_package = $rowE[system_package];
            $edit_category = $rowE[category];
            $edit_num_of_ssid = $rowE[num_of_ssid];
            $edit_bussiness_address1 = $rowE[bussiness_address1];
            $edit_bussiness_address2 = $rowE[bussiness_address2];
            $edit_bussiness_address3 = $rowE[bussiness_address3];
            $edit_country_code = $rowE[country];
            $edit_country_name = $rowE[country_name];
            $edit_state_region = $rowE[state_region];
            $edit_zip = $rowE[zip];
            $edit_phone1 = $rowE[phone1];
            $edit_phone2 = $rowE[phone2];
            $edit_phone3 = $rowE[phone3];
            $edit_full_name = $rowE[full_name];
            $exp_full_name = explode(' ', $edit_full_name);
            $edit_first_name = $exp_full_name[0];
            $edit_last_name = $exp_full_name[1];
            $edit_email = $rowE[email];
            $edit_mobile = $rowE[mobile];
            $edit_timezone = $rowE[time_zone];
            $edit_parent_id = $rowE[parent_id];
            $edit_dpsk_voucher = $rowE[dpsk_voucher];
            $edit_automation_enable = $rowE[automation_enable];
            $edit_wired_enable = $rowE['wired'];
            $edit_advanced_features = json_decode($rowE[advanced_features], true);
            $edit_wlan_count_arr = json_decode($rowE[wlan_count], true);
            $edit_firewall_controller = $rowE['firewall_controller'];
            $edit_organizations_id = $rowE['organizations_id'];
            $edit_dpsk_controller = $rowE['dpsk_controller'];
            $edit_dpsk_policies = $rowE['dpsk_policies'];


            $edit_admin_features = json_decode($rowE[features], true);
            $edit_parent_features = json_decode($db->getValueAsf("SELECT features AS f FROM `mno_distributor_parent` WHERE `parent_id`='$edit_parent_id' LIMIT 1"), true);
            //print_r($edit_parent_features);
            foreach ($edit_parent_features as $key => $value) {
                if ($key == 'VOUCHER') {
                    $edit_dpsk_enable = true;
                }
            }

            foreach (json_decode($rowE['other_settings']) as $other_setting => $other_setting_val) {
                $$other_setting = $other_setting_val;
            }


            $edit_account = 1;


            $query_realm_get = "SELECT `group_number` FROM `exp_distributor_groups` WHERE `distributor` = '$edit_distributor_code'";
            $ex_get_ww = $db->select1DB($query_realm_get);
            //$rowf = mysql_fetch_array($ex_get_ww);
            $edit_distributor_realm = $ex_get_ww[group_number];
            //$edit_distributor_product_id_p=$db->getValueAsf("SELECT product_id AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='PRIVATE' LIMIT 1");
            //$edit_distributor_product_id_g=$db->getValueAsf("SELECT product_id AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");

            /*
  * qos
  * */
            $get_qos_q = "SELECT time_gap,duration_prof_code,product_id,network_type FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code'";
            $qos_arr = $db->selectDB($get_qos_q);
            if ($qos_arr['rowCount'] > 0) {
                foreach ($qos_arr['data'] as $value) {
                    //echo strtoupper($value['network_type']);
                    switch (strtoupper($value['network_type'])) {
                        case 'PRIVATE':
                            $edit_distributor_product_id_p = $value['product_id'];
                            $edit_distributor_product_id_p_time = $value['duration_prof_code'];
                            break;
                        case 'GUEST':
                            $edit_distributor_product_id_g = $value['product_id'];
                            $edit_distributor_product_id_g_time = $value['duration_prof_code'];
                            $edit_distributor_product_id_g_time_default = $value['time_gap'];
                            break;
                        case 'VT-DEFAULT':
                            $edit_distributor_product_id_def = $value['product_id'];
                            break;
                        case 'VT-PROBATION':
                            $edit_distributor_product_id_pro = $value['product_id'];
                            break;
                        case 'VT-PREMIUM':
                            $edit_distributor_product_id_pri = $value['product_id'];
                            break;
                        case 'SUBCRIBE':
                            $edit_distributor_sub_id_def = $value['product_id'];
                            break;
                    }
                }
            }

            /*
  *
  * */

            //$edit_distributor_product_id_p_time=$db->getValueAsf("SELECT duration_prof_code AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='PRIVATE' LIMIT 1");
            //$edit_distributor_product_id_g_time=$db->getValueAsf("SELECT duration_prof_code AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");
            //$edit_distributor_product_id_g_time_default=$db->getValueAsf("SELECT time_gap AS f FROM `exp_products_distributor` WHERE `distributor_code`='$edit_distributor_code' AND UPPER(`network_type`)='GUEST' LIMIT 1");


            $ex_parent_q = "SELECT p.account_name,u.full_name,email,p.system_package FROM mno_distributor_parent p JOIN admin_users u ON p.parent_id=u.verification_number WHERE p.parent_id='$edit_parent_id'";

            $ex_parent_R = $db->selectDB($ex_parent_q);

            foreach ($ex_parent_R['data'] as $prRow) {
                $edit_parent_ac_name = $prRow['account_name'];
                $edit_parent_package = $prRow['system_package'];
                $edit_email = $prRow['email'];
                $edit_full_name = $prRow['full_name'];
                $edit_full_name = explode(" ", $edit_full_name);
                $edit_first_name = $edit_full_name[0];
                $edit_last_name = $edit_full_name[1];
            }
            //$edit_distributor_realm


        } //key validation


        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php?t=active_properties');
        }
    } //9


    //Edit CPE///
    else if (isset($_GET['edit_ap_id'])) { //10


        if ($_SESSION['FORM_SECRET'] == $_GET['token7']) { //refresh validate


            $edit_ap_id = $_GET['edit_ap_id'];
            $edit_loc_code = $_GET['edit_loc_code'];
            $edit_loc_name = $db->escapeDB($_GET['edit_loc_name']);

            $rowE = $db->select1DB("SELECT * FROM `exp_locations_ap` a
WHERE a.id='$edit_ap_id' LIMIT 1
");
            //$rowE = mysql_fetch_array($ex_get);

            $guest_enable = $rowE[guest_enable];

            $edit_ap_name = $rowE[ap_name];
            $edit_ap_code = $rowE[ap_code];
            $edit_ap_description = $rowE[ap_description];
            $edit_ap_mac_address = $rowE[mac_address];
            $edit_ap_wifi_radio = $rowE[wifi_radio];
            $edit_ap_mno = $rowE[mno];
            $edit_ap_private_upload_cpe = $rowE[private_upload_cpe];
            $edit_ap_private_download_cpe = $rowE[private_download_cpe];
            $edit_ap_private_ip = $rowE[private_ip];
            $edit_ap_private_netmask = $rowE[private_netmask];
            $edit_ap_private_max_users = $rowE[private_max_users];
            $edit_ap_private_dns1 = $rowE[private_dns1];
            $edit_ap_private_dns2 = $rowE[private_dns2];
            $edit_ap_guest_upload_cpe = $rowE[guest_upload_cpe];
            $edit_ap_guest_download_cpe = $rowE[guest_download_cpe];
            $edit_ap_guest_ip = $rowE[guest_ip];
            $edit_ap_guest_netmask = $rowE[guest_netmask];
            $edit_ap_guest_max_users = $rowE[guest_max_users];
            $edit_ap_guest_dns1 = $rowE[guest_dns1];
            $edit_ap_guest_dns2 = $rowE[guest_dns2];
            $edit_ap_guest_high_security = $rowE[guest_high_security];
            $edit_ap_guest_medium_security = $rowE[guest_medium_security];
            $edit_ap_guest_low_security = $rowE[guest_low_security];
            $edit_ap_guest_custom_security = $rowE[guest_custom_security];
            $edit_ap_portal = $rowE[portal_address];


            $edit_cpe_account = 1;


            $db->userLog($user_name, $script, 'Update Ap', $edit_ap_name);
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php?t=create_property');
        }
    } //10


    //Remove CPE Mac///
    else if (isset($_GET['rem_ap_id'])) { //11


        if ($_SESSION['FORM_SECRET'] == $_GET['token7']) { //refresh validate


            $remove_ap_id = $_GET['rem_ap_id'];
            $remove_ap_name = $_GET['remove_ap_name'];
            if ($user_type != 'SALES') {
                $get_mac = $db->getValueAsf("SELECT `mac_address` AS f FROM `exp_locations_ap` WHERE `id` = '$remove_ap_id'");


                if ($wag_ap_name == 'NO_PROFILE') {
                    //API not call//
                    $status_code = '200';
                } else {
                    //include 'src/AP/'.$wag_ap_name.'/index.php';
                    //$test =  new ap_wag();
                    $response = $test->cpeDelete($get_mac);
                    //status=success&status_code=200&Description=invalid json - colon unexpected
                    parse_str($response, $responseArr);

                    $status_code = $responseArr['status_code'];
                }

                if ($status_code == 200) {
                    //archive
                    $query_ap_archive = "INSERT INTO `exp_locations_ap_archive` (
                                      `ap_name`, `ap_code`, `ap_description`,mac_address,wifi_radio,mno,private_upload_cpe,`private_download_cpe`,`private_ip`,`private_netmask`,`private_max_users`,`private_dns1`,`private_dns2`,`guest_enable`,`guest_upload_cpe`,`guest_download_cpe`,`guest_ip`,`guest_netmask`,`guest_max_users`,`guest_dns1`,`guest_dns2`,guest_high_security,guest_medium_security,guest_low_security,guest_custom_security,`portal_address`,`create_user`,`create_date`,
                                      `update_user`,
                                      `update_date`) SELECT
                                      `ap_name`, `ap_code`, `ap_description`,mac_address,wifi_radio,mno,private_upload_cpe,`private_download_cpe`,`private_ip`,`private_netmask`,`private_max_users`,`private_dns1`,`private_dns2`,`guest_enable`,`guest_upload_cpe`,`guest_download_cpe`,`guest_ip`,`guest_netmask`,`guest_max_users`,`guest_dns1`,`guest_dns2`,guest_high_security,guest_medium_security,guest_low_security,guest_custom_security,`portal_address`,`create_user`,`create_date`,
                                      '$user_name',
                                      NOW()
                                    FROM
                                      `exp_locations_ap`
                                    WHERE id='$remove_ap_id'";

                    $ex1 = $db->execDB($query_ap_archive);

                    if ($ex1 === true) {
                        //delete AP
                        $ex0 = $db->execDB("DELETE FROM `exp_locations_ap` WHERE `id` = '$remove_ap_id' ");
                    }

                    if ($ex0 === true) {

                        $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_success', $remove_ap_name);
                        $db->userLog($user_name, $script, 'CPE Remove', $remove_ap_name);
                        $_SESSION['msg13'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $rm_cpe_msg . "</strong></div>";
                    } else {
                        $db->userErrorLog('2003', $user_name, 'script - ' . $script);
                        $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_failed', $remove_ap_name);
                        $_SESSION['msg13'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $rm_cpe_msg . "</strong></div>";
                    }
                } else {
                    $db->userErrorLog('2004', $user_name, 'script - ' . $script);
                    $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_failed', $remove_ap_name);
                    $_SESSION['msg13'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $rm_cpe_msg . "</strong></div>";
                }
            } else {
                $rm_cpe_msg = $message_functions->showNameMessage('cpe_removing_success', $remove_ap_name);

                $_SESSION['msg13'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $rm_cpe_msg . "</strong></div>";
            }
        } //key validation

        else {

            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg13'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            header('Location: location.php?t=1');
        }
    } //11
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
        if ($_SESSION['FORM_SECRET'] == $_GET['token10']) {
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

                if ($system_package == "COX_ADMIN_001") {
                    $archive_ap_controller = "INSERT INTO `exp_mno_ap_controller_archive`(`id`,`mno_id`,`ap_controller`,`create_user`,`create_date`,`last_update`)
                    SELECT * FROM `exp_mno_ap_controller` WHERE `mno_id`='"; //";
                }


                //Deleate API
                $rm_unique_arr = $db->select1DB("SELECT `unique_id`,`system_package`,`default_campaign_id` FROM `exp_mno` WHERE `mno_id`='$remove_mno_id'");
                //$rm_unique_arr = mysql_fetch_array($rm_unique_get);
                $rm_unique = $rm_unique_arr['unique_id'];
                $default_campaign_id = $rm_unique_arr['default_campaign_id'];

                $rm_int_unique = (int)$rm_unique;
                //$responcerm = $test->accountDelete($rm_int_unique)parse_str($responcerm);
                // echo $status_code;

                $rm_system_package = $rm_unique_arr['system_package'];
                $rm_sys_package_arr = explode('-', $rm_system_package);
                $rm_sys_package = array_shift($rm_sys_package_arr);


                $status_code = 200;
                if ($status_code == 200) {
                    $keyquery = $db->execDB($archive_q);
                    $keyquery = $db->execDB($archive_ap_controller);

                    $delete = $db->execDB("DELETE
                            FROM
                              `exp_mno`
                            WHERE `mno_id` = '$remove_mno_id'");

                    $delete2 = $db->execDB("DELETE FROM `exp_mno_ap_controller` WHERE `mno_id`='$remove_mno_id'");
                    $delete2 = $db->execDB("DELETE FROM `admin_users` WHERE `user_distributor`='$remove_mno_id'");
                    $delete2 = $db->execDB("DELETE FROM `mdu_mno_organizations` WHERE `mno`='$remove_mno_id'");
                    $delete2_1 = $db->execDB("DELETE FROM `exp_camphaign_ads` WHERE `ad_id` = '$default_campaign_id'");

                    if ($rm_sys_package == 'dy') {

                        $get_rm_custom = $db->select1DB("SELECT * FROM `admin_product_controls_custom` WHERE `product_id`='$rm_system_package'");
                        //$get_rm_custom = mysql_fetch_array($get_rm_custom_q);

                        $get_rm_settings = json_decode($get_rm_custom['settings'], true);
                        $get_rm_short_name = $get_rm_settings['general']['LOGIN_SIGN']['options'];
                        $get_rm_mvno_id = $get_rm_settings['general']['MVNO_PRODUCTS']['options'];
                        $get_rm_admin_id = $get_rm_settings['general']['MVNO_ADMIN_PRODUCT']['options'];

                        $rm_image_logo_url = $get_rm_settings['branding']['LOGO_IMAGE_URL']['options'];
                        $rm_logo_name = explode("/", $rm_image_logo_url);
                        $rm_logo_name = end($rm_logo_name);

                        $rm_image_email_url = $get_rm_settings['branding']['EMAIL_IMAGE_URL']['options'];
                        $rm_email_name = explode("/", $rm_image_email_url);
                        $rm_email_name = end($rm_email_name);

                        $rm_image_favicon_url = $get_rm_settings['branding']['FAVICON_IMAGE_URL']['options'];
                        $rm_favicon_name = explode("/", $rm_image_favicon_url);
                        $rm_favicon_name = end($rm_favicon_name);


                        $delete5 = $db->execDB("DELETE FROM `admin_product_controls` WHERE `product_code`='$get_rm_short_name'");

                        $rm_id_array = array($get_rm_mvno_id, $get_rm_admin_id, $rm_system_package);


                        for ($i = 0; $i < count($rm_id_array); $i++) {

                            $delete3 = $db->execDB("DELETE FROM `admin_product_controls_custom` WHERE `product_id`='$rm_id_array[$i]'");
                        }


                        $delete4 = $db->execDB("DELETE FROM `exp_texts` WHERE `distributor`='$remove_mno_id'");


                        if ($upload_img->is_exists($rm_logo_name, 'logo') == 1) {
                            $remove_logo_image = $upload_img->remove_image($rm_logo_name, 'logo');
                        }
                        if ($upload_img->is_exists($rm_email_name, 'welcome') == 1) {
                            $remove_email_image = $upload_img->remove_image($rm_email_name, 'welcome');
                        }
                        if ($upload_img->is_exists($rm_favicon_name, 'welcome') == 1) {
                            $remove_favicon_image = $upload_img->remove_image($rm_favicon_name, 'welcome');
                        }

                        if ($tenant_upload_img->is_exists($rm_logo_name) == 1) {
                            $remove_logo_image = $tenant_upload_img->remove_image($rm_logo_name);
                        }
                        if ($tenant_upload_img->is_exists($rm_email_name) == 1) {
                            $remove_email_image = $tenant_upload_img->remove_image($rm_email_name);
                        }
                        if ($tenant_upload_img->is_exists($rm_favicon_name) == 1) {
                            $remove_favicon_image = $tenant_upload_img->remove_image($rm_favicon_name);
                        }

                        $rm_logins_q = "SELECT `settings_value` FROM `exp_settings` WHERE `settings_code`='ALLOWED_LOGIN_PROFILES'";
                        $rm_logins_res = $db->select1DB($rm_logins_q);
                        //$rm_logins_res = mysql_fetch_assoc($rm_logins);

                        $login_sign_rm = json_decode($rm_logins_res['settings_value'], true);

                        foreach ($login_sign_rm as $key => $value) {
                            if ($key == $get_rm_short_name) {
                                unset($login_sign_rm[$key]);
                            }
                        }

                        $rm_settings_val = json_encode($login_sign_rm);

                        $delete5 = "UPDATE `exp_settings` SET `settings_value` = '$rm_settings_val' WHERE `settings_code` = 'ALLOWED_LOGIN_PROFILES' ";

                        $rm_login_res = $db->execDB($delete5);

                        $delete7 = $db->execDB("DELETE FROM `admin_product` WHERE `product_code`='$get_rm_mvno_id'");
                        $delete8 = $db->execDB("DELETE FROM `admin_product` WHERE `product_code`='$get_rm_admin_id'");


                        $theme_details_id = $db->getValueAsf("SELECT `theme_details_id` AS f FROM `mdu_themes` WHERE `distributor_code`='$remove_mno_id'");
                        if (!empty($theme_details_id)) {

                            $delete_9 = $db->execDB("DELETE FROM `mdu_themes_details` WHERE `unique_id`='$theme_details_id'");
                        }
                        $delete9 = $db->execDB("DELETE FROM `mdu_themes` WHERE `distributor_code`='$remove_mno_id'");
                    }


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
                    $db->userErrorLog('2009', $user_name, 'script - ' . $script);

                    $create_log->save('2009', $message_functions->showMessage('operator_remove_failed', '2009'), '');

                    $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('operator_remove_failed', '2009') . "</strong></div>";
                }
            } else {
                $create_log->save('3001', $message_functions->showNameMessage('operator_remove_success', $remove_mno_id, '3001'), '');
                $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('operator_remove_success', $remove_mno_id) . "</strong></div>";
            }
        } //key validation
        else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

            $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            //header('Location: location.php?t=1');
        }
    } //remove_mno_id


    if (isset($_GET['send_mail_mno_id'])) {

        $send_mail_mno_id = $_GET['send_mail_mno_id'];


        if ($_SESSION['FORM_SECRET'] == $_GET['tokenmail']) {


            $query = "SELECT a.email,a.`user_name`,a.full_name,a.user_type,e.* FROM `admin_invitation_email` e LEFT JOIN admin_users a ON
                    a.user_distributor=e.distributor 
                    WHERE `distributor` = '$send_mail_mno_id'";
            //"SELECT * FROM `admin_invitation_email` WHERE `distributor` = '$send_mail_mno_id'";
            $result = $db->selectDB($query);


            foreach ($result['data'] as $row) {

                $resend_email = $row[email];
                $to = $row[to];
                $subject = $row[subject];
                //$message = $row[message];
                $f_name = $row[full_name];
                $user_type1 = $row[user_type];
                $uname = $row[user_name];
                $pw_re = $row[password_re];
            }

            $customer_type = $db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='$send_mail_mno_id'");

            $title = $db->setVal("short_title", "ADMIN");
            $from = strip_tags($db->setVal("email", "ADMIN"));


            /*if($url_mod_override=='ON'){
            //http://216.234.148.168/campaign_portal_demo/optimum/login
            $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $customer_type).'/login';
        }else{

            $link = $db->setVal("global_url", "ADMIN") .'/index.php?login='.$package_functions->getSectionType('LOGIN_SIGN',$customer_type);
        }*/

            $login_design = $package_functions->getSectionType('LOGIN_SIGN', $customer_type);
            $link = $db->getSystemURL('login', $login_design);


            //$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL',$system_package,'ADMIN');
            $email_content = $db->getEmailTemplate('MAIL', $system_package, 'ADMIN');

            //$link = $db->getSystemURL('login',$package_functions->getSectionType("LOGIN_SIGN", $mno_sys_package));

            $get_sys_package_ar = explode('-', $customer_type);
            $get_sys_package_prefix = array_shift($get_sys_package_ar);

            if ($get_sys_package_prefix == 'dy') {

                $get_edit_dynamic_details_q = "SELECT `settings` FROM `admin_product_controls_custom` WHERE `product_id` IN (SELECT `system_package` FROM `exp_mno` WHERE `mno_id` = '$send_mail_mno_id');";


                $mno_dynamic_data = $db->selectDB($get_edit_dynamic_details_q);
                //$mno_dynamic_data = mysql_fetch_array($mno_dynamic_data);

                $custom_settings = json_decode($mno_dynamic_data['settings'], true);


                $get_mno_short_name = $custom_settings['general']['LOGIN_SIGN']['options'];

                $link = $db->getSystemURL('login', $get_mno_short_name);
            }

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];
            $vars = array(

                '{$user_full_name}' => $f_name,
                '{$short_name}' => $title,
                '{$account_type}' => $user_type1,
                '{$user_name}' => $uname,
                '{$password}' => $pw_re,
                '{$link}' => $link
            );


            $message_full = strtr($a, $vars);
            $message = $message_full;

            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
            include_once 'src/email/' . $email_send_method . '/index.php';

            //email template
            //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
            $cunst_var = array();
            /*if($emailTemplateType=='child'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$customer_type);
        }elseif($emailTemplateType=='owen'){
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }elseif(strlen($emailTemplateType)>0){
            $cunst_var['template']=$emailTemplateType;
        }else{
            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
        }*/
            $cunst_var['system_package'] = $customer_type;
            $cunst_var['mno_package'] = $system_package;
            $cunst_var['mno_id'] = $mno_id;
            $cunst_var['verticle'] = $vertical;

            $mail_obj = new email($cunst_var);

            if ($resend_email != $to) {
                $db->execDB("UPDATE admin_invitation_email SET `to`='$resend_email' WHERE `distributor` = '$distributor_code'");
                $to = $resend_email;
            }
            $mail_obj->mno_system_package = $system_package;
            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message, '', $title);

            $send_email_msg = $message_functions->showNameMessage('property_send_email_suceess', $f_name);
            $create_log->save('2004', $send_email_msg, $message);
            $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $send_email_msg . "</strong></div>";
        } else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $send_email_msg = $message_functions->showMessage('transection_fail', '2004');
            $create_log->save('2004', $send_email_msg, '');
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $send_email_msg . "</strong></div>";
            //header('Location: location.php');

        }
    } //send mail


    if ($_POST['p_update_button_action'] == 'submit_p_form') {
        if ($_POST['form_secret12'] == $_SESSION['FORM_SECRET']) {
            $parent_id = $_POST['parent_id'];
            $parent_ac_name = $db->escapeDB($_POST['parent_ac_name']);
            $parent_first_name = $_POST['parent_first_name'];
            $parent_last_name = $_POST['parent_last_name'];
            $parent_email = $_POST['parent_email'];
            $parent_username_change = $_POST['parent_username_change'];
            $parent_package_type = $_POST['parent_package_type'];
            $dpsk_conroller = $_POST['dpsk_conroller'];
            $dpsk_policies = $_POST['dpsk_policies'];
            $full_name = $parent_first_name . ' ' . $parent_last_name;
            if ($user_type != 'SALES') {
                $parent_old_email = $db->getValueAsf("SELECT email as f FROM admin_users WHERE verification_number='$parent_id'");

                $parent_enabel = $db->getValueAsf("SELECT is_enable as f FROM admin_users WHERE verification_number='$parent_id'");
                $dis_sys_package = $db->getValueAsf("SELECT system_package AS f FROM exp_mno_distributor WHERE parent_id='$parent_id' ORDER BY `id` DESC LIMIT 1");

                $parent_features = $_POST['parent_features'];
                $dis_detail = $db->select1DB("SELECT system_package,bussiness_type,dpsk_voucher FROM exp_mno_distributor WHERE parent_id='$parent_id' ORDER BY `id` DESC LIMIT 1");
                $dis_sys_package = $dis_detail['system_package'];
                $dis_vertical = $dis_detail['bussiness_type'];
                $dis_dpsk_voucher = $dis_detail['dpsk_voucher'];

                /*$result_loactin = $db->selectDB("SELECT * FROM `exp_mno_distributor` d INNER JOIN admin_product_controls_custom c ON d.`system_package`=c.`product_id` WHERE d.`parent_id` = '$parent_id'");
                foreach ($result_loactin['data'] as $value) {
                $product_id=$value['product_id'];
                $data_json=$value['settings'];
                $data_array=json_decode($data_json,true);
                if (in_array('CAMPAIGN_MODULE', $parent_features)) {
                        $allowed_page=$data_array['general']['ALLOWED_PAGE']['options'];
                        if (!in_array('campaign', $allowed_page)) {
                            array_push($allowed_page, 'campaign');
                        }
                        if (!empty($data_array)) {
                        $data_array['general']['ALLOWED_PAGE']['options']=$allowed_page;
                        $data_array['general']['CAMPAIGN_OFF_ON']['options']='ON';
                        $final_array=json_encode($data_array);
                        }else{
                        $final_array=$data_json;
                        }
                        
                }else{
                        $allow_page=$data_array['general']['ALLOWED_PAGE']['options'];
                        $allowed_page=array();
                        foreach ($allow_page as $value) {
                            if (!in_array('campaign', $allowed_page)) {
                            array_push($allowed_page, $value);
                        }
                        }
                        if (!empty($data_array)) {
                        $data_array['general']['ALLOWED_PAGE']['options']=$allowed_page;
                        $data_array['general']['CAMPAIGN_OFF_ON']['options']='OFF';
                        $final_array=json_encode($data_array);
                        }else{
                        $final_array=$data_json;
                        }                        
                        
                        
                    }
                    $final_array=$db->escapeDB($final_array);
                    //print_r($final_array);
                    
                    $ex=$db->execDB("UPDATE `admin_product_controls_custom` set settings='$final_array' WHERE `product_id`='$product_id'");

                }*/
                $array1 = array();
                foreach ($parent_features as $value) {
                    $parent_features_enable = $db->getValueAsf("SELECT feature_json as f FROM exp_service_activation_features WHERE service_id='$value'");
                    $access_type = json_decode($parent_features_enable, true)['id'];
                    $parent_features_access = $_POST[$access_type];
                    if (strlen($parent_features_access) < 1) {
                        $parent_features_access = 0;
                    }
                    $array = array($value => $parent_features_access);
                    $array1 = array_merge($array1, $array);
                }
                //print_r($array1);
                $feature_jsonn = $db->escapeDB(json_encode($array1));
                //$feature_jsonn=mysql_real_escape_string(json_encode($parent_features));





                if (array_key_exists('VOUCHER', $array1)) {


                    $get_mno_de = "SELECT * FROM `exp_mno_distributor`  WHERE `parent_id` = '$parent_id'";

                    $get_mno_data = $db->selectDB($get_mno_de);


                    foreach ($get_mno_data['data'] as $mno_data) {
                        $voucher_distributor_code = $mno_data['distributor_code'];
                        $vocher_mno_id = $mno_data['mno_id'];


                        $dis_voucher = $db->getValueAsf("SELECT `voucher_code` AS f FROM `mdu_customer_voucher` WHERE `distributor` = '$voucher_distributor_code' AND `voucher_type`='SHARED' AND `status` = '1'");

                        if (empty($dis_voucher)) {


                            $voucher_code = $vtenant_model->getuniqVoucherCode($vocher_mno_id);


                            $data_bulk = array();

                            $data_bulk['voucher'] = $voucher_code;
                            $data_bulk['voucher_type'] = 'SHARED';

                            $data_bulk['user_distributor'] = $voucher_distributor_code;
                            $data_bulk['user_name'] =  $user_name;


                            $add_voucher = $vtenant_model->add_voucher($data_bulk);
                        }

                        $dis_voucher_type = $db->getValueAsf("SELECT `dpsk_voucher` AS f FROM `exp_mno_distributor` WHERE `distributor_code` = '$voucher_distributor_code'");

                        if (empty($dis_voucher_type)) {
                            $query_default_voucher = "UPDATE `exp_mno_distributor` SET `dpsk_voucher` = 'SHARED' WHERE `distributor_code` = '$voucher_distributor_code'";
                            $db->execDB($query_default_voucher);
                        }
                        
                    }
                }


                if (array_key_exists('CLOUD_PATH_DPSK', $array1)) {

                    $get_poolid = "SELECT `distributor_code`,`mno_id`  FROM `exp_mno_distributor`  WHERE `parent_id` = '$parent_id'";

                    $get_poolid_data = $db->selectDB($get_poolid);

                    $dpsk_property_ar = array();

                    foreach ($get_poolid_data['data'] as $pool_data) {
                        $dpsk_distributor_code = $pool_data['distributor_code'];
                        $dpsk_mno_id = $pool_data['mno_id'];

                        $operator = $db->getValueAsf("SELECT `mno_description` AS f FROM `exp_mno` WHERE `mno_id` ='$dpsk_mno_id' ");

                        $dis_org = sprintf("SELECT o.`device_limit`, o.`property_id` FROM `mdu_organizations` o JOIN `mdu_distributor_organizations` d ON o.`property_id` = d.`property_id` WHERE `distributor_code`='%s'", $dpsk_distributor_code);
                        $org_data = $db->select1DB($dis_org);

                        $device_limit = $org_data['device_limit'];
                        $dpsk_property_id = $org_data['property_id'];


                        $pool_name = $operator . $parent_ac_name . $dpsk_property_id . "-" . rand(10, 100);

                        $internet_ssid = "CloudPath";
                        $ssid_list = array();


                        $data_fr = array();
                        $data_fr['controller_name'] = $dpsk_conroller;
                        $dpsks_factory = new dpsks_factory($data_fr);

                        $token_ar = $dpsks_factory->create_token();
                        $token_re = json_decode($token_ar, true);
                        $token_data = json_decode($token_re['Description'], true);

                        $data = array();
                        $data['token'] = $token_data['token'];

                        $data['device_count'] = $device_limit;
                        $data['policies'] = $dpsk_policies;


                        $data['displayName'] = $pool_name;
                        $data['description'] = $pool_name;

                        $qu_vo = "SELECT `displayName`,`description`,`dpsk_pool_id`,`assign_policy`,`ssidList` FROM `mdu_dpsk_pool` WHERE `distributor` = '$dpsk_distributor_code'";

                        if ($db->getNumRows($qu_vo) > 0) {
                            $dpsk_pool_re = $db->select1DB($qu_vo);
                            $dpsk_pool_id = $dpsk_pool_re['dpsk_pool_id'];
                            $dpsk_old_displayName = $dpsk_pool_re['displayName'];

                            $dpsk_displayName_ar = explode('-',$dpsk_old_displayName);
                            $dpsk_displayName_endVal = end($dpsk_displayName_ar);
                            $pool_name = $operator . $parent_ac_name . $dpsk_property_id . "-" . $dpsk_displayName_endVal;
                            $data['displayName'] = $pool_name;
                            $data['description'] = $pool_name;



                            $query_results_ss = $db->selectDB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code'");
                            $query_resident =   $db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%resident%' ORDER BY `wlan_name` ASC LIMIT 1");
                            $resident_ssid = $query_resident['ssid'];
                        
                            $query_vtenant =    $db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%vtenant%' ORDER BY `wlan_name` ASC LIMIT 1");
                            $vtenant_ssid = $query_vtenant['ssid'];
                            
                            $tenant_ssid = "";

                            foreach ($query_results_ss['data'] as $row_s) {
                                $ssid = $row_s['ssid'];
                                $wlan_name = $row_s['wlan_name'];
                                $networkNameLower = trim(strtolower($wlan_name));

                                // if (substr($networkNameLower, 0, strlen("resident")) === "resident") {
                                //     $internet_ssid = $row_s['ssid'];
                                //     array_push($ssid_list, $internet_ssid);
                                // }


                                if (substr($networkNameLower, 0, strlen("tenant")) === "tenant") {
                                    $tenant_ssid = $row_s['ssid'];
                                }
                            }


                            $internet_ssid = $resident_ssid;

                            if (empty($internet_ssid)) {
                                $internet_ssid = $vtenant_ssid;
                            }

                            if (empty($internet_ssid)) {
                                $internet_ssid = $tenant_ssid;
                            }

                            if (!empty($internet_ssid)) {
                                array_push($ssid_list, $internet_ssid);
                            }

                            if (empty($ssid_list)) {
                                array_push($ssid_list, "CloudPath");
                            }
                            $ssid_list_json = json_encode($ssid_list);

                            $data['ssidList'] = $ssid_list;
                            $data['dpskspool_id'] = $dpsk_pool_id;


                            $pdsk_pool_res = $dpsks_factory->update_dpsks_pool($data);
                            $pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
                            $pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);

                            if ($pdsk_pool_res_data['status_code'] == '200') {
                                $query_dpsk_pool_up = "UPDATE `mdu_dpsk_pool` SET `displayName` = '$pool_name' , `description` = '$pool_name' , `ssidList` = '$ssid_list_json' , `device_count` = '$device_limit' , `property_id` = '$dpsk_property_id' WHERE  `distributor` = '$dpsk_distributor_code' ";
                                $db->execDB($query_dpsk_pool_up);
                            }

                            //$dpsk_pool_id=$pdsk_pool_data['guid'];

                            //check curren dpsk pool
                            $get_dpskpool_policy_res = $dpsks_factory->get_dpskpool_policies($data);
                            $get_dpskpool_policy_res_data = json_decode($get_dpskpool_policy_res, true);
                            $get_dpskpool_policy_data = json_decode($get_dpskpool_policy_res_data['Description'], true);

                            foreach ($get_dpskpool_policy_data['contents'] as $content) {
                                foreach ($content['links'] as $links) {
                                    if ($links['rel'] == 'policy' || $links['rel'] == 'policies') {
                                        $policie_url = $links['href'];
                                        $policie_url_ex = explode("/", $policie_url);
                                        $current_police_id = end($policie_url_ex);
                                        //print_r($policie_url_ex);
                                    }
                                }
                            }


                            if (($dpsk_policies != $current_police_id) || empty($current_police_id)) {
                                $data_delete = array();
                                $data_delete['token'] = $token_data['token'];
                                $data_delete['dpskspool_id'] = $dpsk_pool_id;
                                $data_delete['policies'] = $current_police_id;

                                if (!empty($current_police_id)) {
                                    $dpsk_policy_del = $dpsks_factory->Delete_dpskspool_policies($data_delete);
                                    $dpsk_policy_del_data = json_decode($dpsk_policy_del, true);
                                    $pdsk_policy_del_data = json_decode($dpsk_policy_del_data['Description'], true);
                                    $police_del_sts = $dpsk_policy_del_data['status_code'];
                                }

                                if ($police_del_sts == '200' || empty($current_police_id)) {
                                    $pdsk_policy_res = $dpsks_factory->assign_policy($data);
                                    $pdsk_policy_res_data = json_decode($pdsk_policy_res, true);
                                    $pdsk_policy_data = json_decode($pdsk_policy_res_data['Description'], true);






                                    if ($pdsk_policy_res_data['status_code'] == '200') {
                                        $query_dpsk_pool = "UPDATE `mdu_dpsk_pool` SET `assign_policy` = '$dpsk_policies' WHERE  `distributor` = '$dpsk_distributor_code' ";
                                        $db->execDB($query_dpsk_pool);
                                    }
                                }
                            }
                        } else {

                            $query_results_ss = $db->selectDB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code'");
                            $query_resident =   $db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%resident%' ORDER BY `wlan_name` ASC LIMIT 1");
                            $resident_ssid = $query_resident['ssid'];
                        
                            $query_vtenant =    $db->select1DB("SELECT * FROM `exp_locations_ssid_vtenant` WHERE `distributor`= '$dpsk_distributor_code' AND `wlan_name` LIKE '%vtenant%' ORDER BY `wlan_name` ASC LIMIT 1");
                            $vtenant_ssid = $query_vtenant['ssid'];
                           
                            $tenant_ssid = "";

                            foreach ($query_results_ss['data'] as $row_s) {
                                $ssid = $row_s['ssid'];
                                $wlan_name = $row_s['wlan_name'];
                                $networkNameLower = trim(strtolower($wlan_name));

                                // if (substr($networkNameLower, 0, strlen("resident")) === "resident") {
                                //     $internet_ssid = $row_s['ssid'];
                                //     array_push($ssid_list, $internet_ssid);
                                // }

                              
                                if (substr($networkNameLower, 0, strlen("tenant")) === "tenant") {
                                    $tenant_ssid = $row_s['ssid'];
                                }
                            }

                            $internet_ssid = $resident_ssid;

                            if (empty($internet_ssid)) {
                                $internet_ssid = $vtenant_ssid;
                            }

                            if (empty($internet_ssid)) {
                                $internet_ssid = $tenant_ssid;
                            }

                            if (!empty($internet_ssid)) {
                                array_push($ssid_list, $internet_ssid);
                            }

                            if (empty($ssid_list)) {
                                array_push($ssid_list, "CloudPath");
                            }
                            $ssid_list_json = json_encode($ssid_list);

                            $data['ssidList'] = $ssid_list;
                            $pdsk_pool_res = $dpsks_factory->create_dpsks_pool($data);
                            $pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
                            $pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);
                            $dpsk_pool_id = $pdsk_pool_data['guid'];


                            $data['dpskspool_id'] = $dpsk_pool_id;

                            $pdsk_policy_res = $dpsks_factory->assign_policy($data);
                            $pdsk_policy_res_data = json_decode($pdsk_policy_res, true);
                            $pdsk_policy_data = json_decode($pdsk_policy_res_data['Description'], true);


                            if ($pdsk_pool_res_data['status_code'] == '200') {
                                $query_dpsk_pool = "INSERT INTO `mdu_dpsk_pool` (`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`) 
    VALUES ('$dpsk_pool_id', '$pool_name', '$pool_name', '$ssid_list_json', '$device_limit', '$dpsk_distributor_code', '$dpsk_property_id', '$dpsk_policies',NOW(), 'syncAp', NOW())";

                                $db->execDB($query_dpsk_pool);

                                if (!empty($dpsk_property_id)) {
                                    array_push($dpsk_property_ar, $dpsk_property_id);
                                }
                            }
                        }
                    }


                    //dpskpool add
                } else {
                    $query_code_mno = $db->getValueAsf("SELECT  d.mno_id as f
                    FROM admin_users u, mno_distributor_parent d
                    WHERE d.parent_id = '$parent_id' AND u.`verification_number`='$parent_id'");

                    $get_poolid = "SELECT `distributor_code`,`dpsk_pool_id`, p.`id` AS mdu_pool_id  FROM `exp_mno_distributor` m JOIN `mdu_dpsk_pool` p ON m.`distributor_code`=p.`distributor` WHERE `parent_id` = '$parent_id'";

                    $get_poolid_data = $db->selectDB($get_poolid);

                    foreach ($get_poolid_data['data'] as $pool_data) {
                        $dpsk_distributor_code = $pool_data['distributor_code'];
                        $dpsk_pool_id = $pool_data['dpsk_pool_id'];
                        $mdu_dpsk_pool_id = $pool_data['mdu_pool_id'];


                        if (!empty($dpsk_pool_id)) {

                            $data_fr = array();
                            $data_fr['user_distributor'] = $dpsk_distributor_code;
                            $dpsks_factory = new dpsks_factory($data_fr);


                            $token_ar = $dpsks_factory->create_token();

                            $token_re = json_decode($token_ar, true);
                            $token_data = json_decode($token_re['Description'], true);



                            $data = array();
                            $data['token'] = $token_data['token'];
                            $data['dpskspool_id'] = $dpsk_pool_id;

                            $pdsk_pool_res = $dpsks_factory->Delete_dpsk_pool($data);
                            $pdsk_pool_res_data = json_decode($pdsk_pool_res, true);
                            $pdsk_pool_data = json_decode($pdsk_pool_res_data['Description'], true);

                            $dpsk_up_status = $pdsk_pool_res_data['status_code'];

                            if ($dpsk_up_status == 200 || $dpsk_up_status == 204) {
                                $pool_ar = "INSERT INTO `mdu_dpsk_pool_archive` 
                    (`mdu_dpsk_pool_id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,`delete_by`,`delete_date`)
                    SELECT `id`,`dpsk_pool_id`, `displayName`, `description`, `ssidList`, `device_count`, `distributor`, `property_id`, `assign_policy`,`create_date`, `create_user`, `last_update`,'Admin',NOW()
                    FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";

                                $pool_delete_q = "DELETE FROM `mdu_dpsk_pool` WHERE `id`='$mdu_dpsk_pool_id'";
                                //  echo '<br>';
                                $db->execDB($pool_ar);
                                $db->execDB($pool_delete_q);
                            }
                        }
                    }
                    $dpsk_conroller = "";
                    $dpsk_policies = "";
                }



                $full_name = $db->escapeDB(trim($full_name));
                $p_update_q = "UPDATE admin_users SET full_name='$full_name' ,email='$parent_email' WHERE verification_number='$parent_id'";
                $p_update_q2 = "UPDATE mno_distributor_parent SET account_name='$parent_ac_name',system_package='$parent_package_type',features='$feature_jsonn',dpsk_controller='$dpsk_conroller',dpsk_policies='$dpsk_policies'  WHERE parent_id='$parent_id'";
                // if (strlen($dis_dpsk_voucher) < 1 && in_array('VOUCHER', $parent_features)) {
                //     $p_update_q3 = "UPDATE exp_mno_distributor SET dpsk_voucher='SHARED' WHERE parent_id='$parent_id'";
                //     $p_update_r3 = $db->execDB($p_update_q3);
                // }


                $p_update_r = $db->execDB($p_update_q);
                $p_update_r2 = $db->execDB($p_update_q2);



                //tenant update

                if (array_key_exists('CLOUD_PATH_DPSK', $array1)) {
                    foreach ($dpsk_property_ar as $dpsk_property_no) {

                        $exec_cmd = 'php -f' . dirname(__FILE__) . '/ajax/tenant_cloudpath_update.php ' . $dpsk_property_no . ' > /dev/null 2>&1 & echo $!; ';
                        $pid = exec($exec_cmd, $output);

                        //    $update_tenent = $base_url . '/ajax/tenant_cloudpath_update.php?property=' . $dpsk_property_no;

                        //    CommonFunctions::httpGet($update_tenent);
                    }
                }


                //over tenant update






                if ($p_update_r === true && $parent_username_change != 'on' && ($parent_old_email != $parent_email)) {

                    //$reset_method=$db->setVal("pass_reset_method",'ADMIN');

                    $qcehck = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package' 
                    FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                    WHERE u.`verification_number`='$parent_id' AND u.user_type IN ('MVNO_ADMIN') limit 1";

                    $rcheck = $db->selectDB($qcehck);


                    $cunst_var = array(
                        "template" => ""
                    );


                    foreach ($rcheck['data'] as $row) {

                        $user_system_package = $row['user_system_package'];
                        $email = $row['email'];
                        $user_name = $row['user_name'];
                        $full_name = $row['full_name'];
                        $distributor = $row['user_distributor'];

                        $admin_id = $row['mno_id'];

                        $t = date("ymdhis", time());

                        $string = $user_name . '|' . $t . '|' . $email;

                        $encript_resetkey = $app->encrypt_decrypt('encrypt', $string);

                        $unique_key = $db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");


                        $qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$user_name' AND status='pending'";
                        $rr = $db->execDB($qq);

                        if ($rr === true) {
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
                            $r1 = $db->execDB($q1);
                        }

                        if ($r1 === true) {

                            $to = $email;
                            $from = strip_tags($db->setVal("email", $admin_id));
                            /*$subject = $db->textTitle('PASSWORD_RESET_MAIL', $admin_id);
                        if (strlen($subject) == 0) {
                            $subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
                        }*/
                            $title = $db->setVal("short_title", $dist);

                            //$link = $db->setVal("global_url", 'ADMIN') . '/reset_password.php?reset=pwd&reset_key='.$unique_key.'&login='.$package_functions->getSectionType('LOGIN_SIGN',$user_system_package);
                            $login_design = $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
                            $link = $db->getSystemURL('reset_pwd', $login_design, $unique_key);

                            //$dis_sys_package = $db->getValueAsf("SELECT system_package AS f FROM exp_mno_distributor WHERE parent_id='$parent_id' ORDER BY `id` DESC LIMIT 1");

                            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $system_package, $dis_vertical);

                            $vars = array(
                                '{$user_ID}' => $user_name,
                                '{$user_full_name}' => $full_name,
                                '{$support_number}' => $support_number,
                                '{$link}' => $link
                            );

                            /*$mail_text = $db->textVal('PASSWORD_RESET_MAIL', $admin_id);
                        if (strlen($mail_text) == 0) {
                            $mail_text = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
                        }*/

                            $email_content = $db->getEmailTemplateVertical('PASSWORD_RESET_MAIL', $system_package, 'MNO', $dis_vertical, $admin_id);

                            $mail_text = $email_content[0]['text_details'];
                            $subject = $email_content[0]['title'];

                            $message = strtr($mail_text, $vars);

                            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                            if (strlen($email_send_method) == 0) {
                                $email_send_method = 'PHP_MAIL';
                            }
                            include_once 'src/email/' . $email_send_method . '/index.php';

                            //email template
                            //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
                            $cunst_var = array();
                            /*if($emailTemplateType=='child'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$user_system_package);
                        }elseif($emailTemplateType=='owen'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }elseif(strlen($emailTemplateType)>0){
                            $cunst_var['template']=$emailTemplateType;
                        }else{
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }
*/
                            $cunst_var['system_package'] = $dis_sys_package;
                            $cunst_var['mno_package'] = $system_package;
                            $cunst_var['mno_id'] = $mno_id;
                            $cunst_var['verticle'] = $dis_vertical;

                            $mail_obj = new email($cunst_var);
                            $mail_obj->mno_system_package = $system_package;
                            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message, '', $title);
                            $mail_obj = null;
                            unset($mail_obj);
                        }
                    }
                }

                if ($parent_username_change == 'on' && ($parent_old_email != $parent_email)) {


                    $query_code = "SELECT user_distributor, d.id, d.mno_id, u.user_name,d.system_package
      FROM admin_users u, mno_distributor_parent d
      WHERE d.parent_id = '$parent_id' AND u.`verification_number`='$parent_id'";

                    $query_results = $db->selectDB($query_code);

                    foreach ($query_results['data'] as $row) {
                        $user_distributor1 = $row[user_distributor];
                        $mno_id = $row[mno_id];
                        $user_name1 = $row[user_name];
                        $user_system_package = $row[system_package];
                    }


                    $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `verification_number`='$parent_id'
                  ) ";

                    $ex3 = $db->execDB($query_admin_user_archive);

                    if ($ex3 === true) {

                        $user_update = "UPDATE `admin_users` SET `is_enable` = '2' WHERE verification_number='$parent_id'";
                        $ex_query_de = $db->execDB($user_update);

                        /*$subject = $db->textTitle('MAIL',$mno_id);
                            if(strlen($subject)==0){
                                $subject=$db->textTitle('ICOMMS_MAIL','ADMIN');
                            }*/

                        $from = strip_tags($db->setVal("email", $mno_id));

                        if ($from == '') {
                            $from = strip_tags($db->setVal("email", 'ADMIN'));
                        }

                        $to = $mvnx_email;
                        $title = $db->setVal("short_title", $mno_id);

                        /*if($url_mod_override=='ON'){
                        //http://216.234.148.168/campaign_portal_demo/optimum/verification
                        $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $user_system_package).'/verification';
                    }else{

                        $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin&login='.$package_functions->getSectionType('LOGIN_SIGN',$user_system_package);
                    }*/

                        $login_design = $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
                        $link = $db->getSystemURL('verification', $login_design, $unique_key);

                        $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $system_package, $dis_vertical);


                        /*$a = $db->textVal('MAIL', $mno_id);

                    if(strlen($a)<1){
                        $a = $db->textVal('MAIL', 'ADMIN');
                    }*/

                        $email_content = $db->getEmailTemplateVertical('PARENT_INVITE_MAIL', $system_package, 'MNO', $dis_vertical, $mno_id);

                        $a = $email_content[0]['text_details'];
                        $subject = $email_content[0]['title'];

                        $vars = array(
                            '{$short_name}' => $db->setVal("short_title", $mno_id),
                            '{$business_id}' => $parent_id,
                            '{$user_name}' => $user_name1,
                            '{$password}' => $password,
                            '{$link}' => $link,
                            '{$user_full_name}' => $full_name,
                            '{$support_number}' => $support_number,
                            '{$account_type}' => 'MVNO_ADMIN',
                        );


                        $message_full = strtr($a, $vars);
                        //$message = mysql_escape_string($message_full);
                        $message = $db->escapeDB($message_full);

                        $qu = "INSERT INTO `admin_invitation_email` (`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
          VALUES ('$parent_email', '$subject', '$message', '$user_distributor1', '$user_name1', now())";
                        $rrr = $db->execDB($qu);


                        //if($parent_enabel == '2'){

                        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                        include_once 'src/email/' . $email_send_method . '/index.php';

                        //email template
                        //$emailTemplateType=$package_functions->getSectionType('EMAIL_TEMPLATE',$system_package);
                        $cunst_var = array();
                        /*if($emailTemplateType=='child'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$user_system_package);
                        }elseif($emailTemplateType=='owen'){
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }elseif(strlen($emailTemplateType)>0){
                            $cunst_var['template']=$emailTemplateType;
                        }else{
                            $cunst_var['template']=$package_functions->getOptions('EMAIL_TEMPLATE',$system_package);
                        }*/
                        $cunst_var['system_package'] = $dis_sys_package;
                        $cunst_var['mno_package'] = $system_package;
                        $cunst_var['mno_id'] = $mno_id;
                        $cunst_var['verticle'] = $dis_vertical;
                        $mail_obj = new email($cunst_var);

                        $mail_obj->mno_system_package = $system_package;
                        $mail_sent = $mail_obj->sendEmail($from, $parent_email, $subject, $message_full, '', $title);

                        //  }


                    }
                }
                $db->userLog($user_name, $script, 'Account Update', $user_name1);
                $show_message = $message_functions->showNameMessage('parent_update_success', str_replace('\\', '', $parent_ac_name));
                $create_log->save('', $show_message, '');

                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_message . "</strong></div>";
            } else {
                $show_message = $message_functions->showNameMessage('parent_update_success', str_replace('\\', '', $parent_ac_name));
                $create_log->save('', $show_message, '');

                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_message . "</strong></div>";
            }
        } else {
            $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
            //header('Location: location.php');

        }
    }


    if (isset($_GET['edit_parent_id']) && $_POST['p_update_button_action'] != 'add_location') {

        $edit_parent_q = "SELECT full_name,email,p.account_name,p.system_package,p.features,p.dpsk_controller,p.dpsk_policies FROM admin_users u, mno_distributor_parent p WHERE u.verification_number=p.parent_id  AND verification_number='$_GET[edit_parent_id]'";
        $edit_parent_r = $db->selectDB($edit_parent_q);

        foreach ($edit_parent_r['data'] as $row_ed_par) {
            $get_edit_parent_id = $_GET['edit_parent_id'];
            $get_edit_parent_ac_name = $row_ed_par['account_name'];
            $edit_parent_full_name = $row_ed_par['full_name'];
            $edit_parent_full_name = explode(" ", $edit_parent_full_name);
            $edit_parent_first_name = $edit_parent_full_name[0];
            $edit_parent_last_name = $edit_parent_full_name[1];
            $edit_parent_email = $row_ed_par['email'];
            $edit_parent_features_json = $row_ed_par['features'];
            $edit_parent_features = json_decode($edit_parent_features_json, true);
            $edit_parent_system_package = $row_ed_par['system_package'];
            $edit_dpsk_controller = $row_ed_par['dpsk_controller'];
            $edit_dpsk_policies = $row_ed_par['dpsk_policies'];
            $edit_parent_on = 1;
            $module_controls['edit_parent_on'] = 1;
        }
    }


    //refresh function

    if ($_GET['action'] == 'sync_data_tab1' || isset($_GET['view_loc_code'])) {

        if ($wag_ap_name != 'NO_PROFILE') {
            if ($ap_control_var == 'MULTIPLE') {

                $sync_q = "SELECT distributor_code FROM exp_mno_distributor WHERE parent_id='$_GET[view_loc_code]'";
                $sync_r = $db->selectDB($sync_q);

                foreach ($sync_r['data'] as $sync_row) {

                    $sync_ap_url = $base_url . '/ajax/syncAP.php?distributor=' . $sync_row['distributor_code'];

                    CommonFunctions::httpGet($sync_ap_url);
                }
            }

            //*********************************************************************

        }
    }

    if ($_POST['p_update_button_action'] == 'add_location') {
        $edit_parent_id = $_POST['parent_id'];
        $edit_parent_ac_name = $db->escapeDB($_POST['parent_ac_name']);
        $edit_parent_package = $_POST['parent_package_type'];
        $edit_first_name = $_POST['parent_first_name'];
        $edit_last_name = $_POST['parent_last_name'];
        $edit_email = $_POST['parent_email'];
        //unset($tab12);
        //$tab5 = 'set';

        $_GET['t'] = 'create_property';
        $_SESSION['new_location'] = 'yes';
    } else if ($_POST['btn_action'] == 'add_location_next' || $_POST['btn_action'] == 'add_location_submit') {
    } else {
        $_SESSION['new_location'] = '';
        unset($_SESSION['new_location']);
    }
    //edt Property Admin Unassign
    if (isset($_GET['unassign_loc_admin'])) {

        $unassign_user_id = $_GET['unassign_loc_admin'];
        if ($user_type != 'SALES') {

            $query02 = "UPDATE `admin_users` SET is_enable='8' WHERE  id='$unassign_user_id'";


            $ex_query02 = $db->execDB($query02);


            if ($ex_query02 === true) {
                $db->userLog($user_name, $script, 'Properties Unassign', $unassign_user_id);
                $properties_Unassignment_success = $message_functions->showMessage('properties_Unassignment_success');

                $_SESSION['msg10'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_Unassignment_success . "</strong></div>";
            } else {
                $properties_Unassignment_error = $message_functions->showMessage('properties_Unassignment_error');
                $_SESSION['msg10'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_Unassignment_error . "</strong></div>";
            }
        } else {
            $properties_Unassignment_success = $message_functions->showMessage('properties_Unassignment_success');

            $_SESSION['msg10'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_Unassignment_success . "</strong></div>";
        }
    }
    //edt Property Admin

    if (isset($_GET['assign_loc_admin'])) {


        $assign_dis_id = $_GET['assign_loc_admin'];

        $query_ed_v = "SELECT d.`distributor_name`,d.`property_id`,a.`user_name`,a.`full_name`,a.`id` AS uid,a.`email`,a.`mobile`,d.`distributor_code`,d.`verification_number`,d.`mno_id`,d.`system_package` ,d.parent_id
     FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor WHERE d.`id`='$assign_dis_id' AND a.`verification_number` IS NOT NULL";

        $query_ex_ed = $db->selectDB($query_ed_v);
        //if ($ed_result = mysql_fetch_array($query_ex_ed)) {
        foreach ($query_ex_ed['data'] as $ed_result) {

            $assign_edit_fulname = $ed_result['full_name'];

            $assign_ful_name_array = explode(' ', $assign_edit_fulname, 2);
            $assign_edit_first_name = $assign_ful_name_array[0];
            $assign_edit_last_name = $assign_ful_name_array[1];

            $assign_edit_propertyid = $ed_result['property_id'];
            $assign_edit_distributor_name = $ed_result['distributor_name'];
            $assign_edit_email = $ed_result['email'];
            $assign_ad_id = $ed_result['uid'];
            $assign_distributor_code = $ed_result['distributor_code'];
            $assign_verification_number = $ed_result['verification_number'];
            $assign_mno_id = $ed_result['mno_id'];
            $assign_customer_type = $ed_result['system_package'];
            $assign_edit_phone = $ed_result['mobile'];
            $assign_edit_parent_id = $ed_result['parent_id'];
        }
    } //

    if (isset($_POST['submit_assign_user'])) {

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {

            $ed_de_user_id = $_POST['ed_user_id'];
            $ed_de_distributor_code = $_POST['ed_distributor_code'];
            $ed_de_first_name = $db->escapeDB($_POST['ed_first_name']);
            $ed_de_last_name = $db->escapeDB($_POST['ed_last_name']);
            $ed_de_user_email = $db->escapeDB($_POST['ed_ad_email']);
            $ed_de_verification_number = $_POST['ed_verification_number'];
            $mno_id = $_POST['ed_mno'];
            $mvnx_full_name = $ed_de_first_name . " " . $ed_de_last_name;
            $user_type1 = "MVNO";
            $customer_type = trim($_POST['customer_type']);
            $mobile_1 = $db->escapeDB($_POST['mobile_1']);
            if ($user_type != 'SALES') {
                //$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
                //$rowe = mysql_fetch_array($br);
                //$auto_inc = $rowe['Auto_increment'];
                // $mvnx_id = $user_type1 . $auto_inc;
                ///$mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
                ///$unique_id = '2' . $mvnx;

                //$dis_user_name = str_replace(' ', '_', strtolower(substr($mvnx_full_name, 0, 5) . $auto_inc));
                $edit_mvne_user_details_q = "SELECT u.email, d.system_package,d.bussiness_type FROM admin_users u , exp_mno_distributor d WHERE u.user_distributor=d.distributor_code AND user_distributor='$ed_de_distributor_code' AND u.`verification_number` IS NOT NULL";
                $edit_mvne_user_details_r = $db->selectDB($edit_mvne_user_details_q);

                foreach ($edit_mvne_user_details_r['data'] as $row) {

                    $old_property_email = $row['email'];
                    $user_system_package = $row['system_package'];
                    $user_vertical = $row['bussiness_type'];
                }

                if ($old_property_email != $ed_de_user_email) {
                    $rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'admin_users'");
                    //$rowe = mysql_fetch_array($br);
                    $auto_inc = $rowe['Auto_increment'];

                    $dis_user_name = str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u' . $auto_inc));


                    $password = CommonFunctions::randomPassword();


                    if (isset($_POST['ed_user_id'])) {
                        //echo "ok";

                        $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `id`='$ed_de_user_id'
                  ) ";

                        $ex3 = $db->execDB($query_admin_user_archive);

                        if ($ex3 === true) {

                            $query_de = "delete from `admin_users` where id='$ed_de_user_id'";
                            $ex_query_de = $db->execDB($query_de);
                        }
                    }


                    $query02 = "INSERT INTO `admin_users` (`user_name`,`verification_number`,`password`,mobile, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `is_enable`, `create_date`)
            VALUES ('$dis_user_name','$ed_de_verification_number',CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$password'))))),'$mobile_1', 'admin', 'MVNO','$ed_de_distributor_code', '$mvnx_full_name', '$ed_de_user_email', '2', NOW())";


                    $ex_query02 = $db->execDB($query02);


                    /*Email Notification*/

                    $to = $ed_de_user_email;
                    $title = $db->setVal("short_title", $mno_id);
                    /*$subject = $db->textTitle('ICOMMS_MAIL_SUB', $mno_id);
            if (strlen($subject) == 0) {
                $subject = $db->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
            }*/
                    $from = strip_tags($db->setVal("email", $mno_id));
                    if ($from == '') {
                        $from = strip_tags($db->setVal("email", 'ADMIN'));
                    }

                    /*if($url_mod_override=='ON'){
                //http://216.234.148.168/campaign_portal_demo/optimum/verification
                $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $user_system_package).'/verification';
            }else{

                $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin&login=' . $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
            }*/


                    /*$a = $db->textVal('ICOMMS_MAIL_SUB', $mno_id);

            if (strlen($a) == 0) {
                $a = $db->textVal('ICOMMS_MAIL_SUB', 'ADMIN');
            }*/

                    $login_design = $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
                    $link = $db->getSystemURL('verification', $login_design);


                    $email_content = $db->getEmailTemplateVertical('VENUE_ADD_ADMIN', $system_package, 'MNO', $user_vertical, $mno_id);

                    $a = $email_content[0]['text_details'];
                    $subject = $email_content[0]['title'];
                    $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $user_system_package, $user_vertical);

                    $vars = array(
                        '{$user_full_name}' => $mvnx_full_name,
                        '{$short_name}' => $title,
                        '{$account_type}' => $user_type1,
                        '{$property_id}' => $ed_de_verification_number,
                        '{$user_name}' => $dis_user_name,
                        '{$support_number}' => $support_number,
                        '{$password}' => $password,
                        '{$link}' => $link
                    );


                    $message_full = strtr($a, $vars);
                    //$message = mysql_escape_string($message_full);
                    $message = $db->escapeDB($message_full);


                    if ($ex_query02 === true) {


                        $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
        VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                        $rrr = $db->execDB($qu);


                        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
                        include_once 'src/email/' . $email_send_method . '/index.php';

                        //email template
                        //$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
                        $cunst_var = array();
                        /*if ($emailTemplateType == 'child') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);
                    } elseif ($emailTemplateType == 'owen') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif (strlen($emailTemplateType) > 0) {
                        $cunst_var['template'] = $emailTemplateType;
                    } else {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    }*/
                        $cunst_var['system_package'] = $user_system_package;
                        $cunst_var['mno_package'] = $system_package;
                        $cunst_var['mno_id'] = $mno_id;
                        $cunst_var['verticle'] = $user_vertical;
                        $mail_obj = new email($cunst_var);

                        $mail_obj->mno_system_package = $system_package;
                        $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                        $userQ = "UPDATE admin_users SET activation_email_date =UNIX_TIMESTAMP() WHERE user_name = '$dis_user_name'";
                        $userR = $db->execDB($userQ);
                    }
                } else {
                    $query_admin_user_archive = "INSERT INTO `admin_users_archive` (
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  `archive_by`,
                  `archive_date`,
                  `last_update`
                )

                  (
                SELECT
                  `id`,
                  `user_name`,
                  `password`,
                  `access_role`,
                  `user_type`,
                  `user_distributor`,
                  `full_name`,
                  `email`,
                  `language`,
                  `mobile`,
                  `verification_number`,
                  `is_enable`,
                  `create_date`,
                  `create_user`,
                  '$user_name',
                  NOW(),
                  `last_update`
                FROM `admin_users`
                WHERE
                  `id`='$ed_de_user_id'
                  ) ";

                    $ex3 = $db->execDB($query_admin_user_archive);

                    $query02 = "UPDATE `admin_users` SET mobile='$mobile_1', `full_name`='$mvnx_full_name', `is_enable`='2' WHERE  id='$ed_de_user_id'";


                    $ex_query02 = $db->execDB($query02);
                }


                if ($ex_query02 === true) {
                    $db->userLog($user_name, $script, 'Edit Properties', $dis_user_name);
                    $properties_edit_success = $message_functions->showMessage('properties_edit_success');

                    $_SESSION['msg10'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
                } else {
                    $properties_edit_error = $message_functions->showMessage('properties_edit_error');
                    $_SESSION['msg10'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";
                }
            } else {
                $properties_edit_success = $message_functions->showMessage('properties_edit_success');
                $_SESSION['msg10'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            }
        }
    }

    //resend Property Admin invitation email
    if (isset($_GET['e_resend_a'])) {
        if ($_SESSION['FORM_SECRET'] == $_GET['tokene']) {
            $resend_dist_code = $_GET['e_resend_a'];

            $q = "SELECT u.email,u.full_name,u.user_type,u.verification_number,d.mno_id FROM admin_users u LEFT JOIN exp_mno_distributor d ON u.user_distributor=d.distributor_code WHERE d.distributor_code='$resend_dist_code' AND u.`verification_number` IS NOT NULL";
            $r = $db->selectDB($q);

            foreach ($r['data'] as $row) {
                $re_user_email = $row['email'];
                $mno_id = $row['mno_id'];
                $mvnx_full_name = $row['full_name'];
                $user_type1 = $row['user_type'];
                $resend_verification_number = $row['verification_number'];
            }

            /*Email Notification*/

            $to = $re_user_email;
            $title = $db->setVal("short_title", $mno_id);
            /*$subject = $db->textTitle('ICOMMS_MAIL_SUB', $mno_id);
        if (strlen($subject) == 0) {
            $subject = $db->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
        }*/
            $from = strip_tags($db->setVal("email", $mno_id));
            if ($from == '') {
                $from = strip_tags($db->setVal("email", 'ADMIN'));
            }

            $user_dist_details = $db->select1DB("SELECT `system_package`,bussiness_type FROM `exp_mno_distributor` WHERE `verification_number`='$resend_verification_number'");
            $user_system_package = $user_dist_details['system_package'];
            $user_vertical = $user_dist_details['bussiness_type'];

            /*if($url_mod_override=='ON'){
            //http://216.234.148.168/campaign_portal_demo/optimum/verification
            $link = $db->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $user_system_package).'/verification';
        }else{

            $link = $db->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin&login=' . $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
        }*/

            /*$a = $db->textVal('ICOMMS_MAIL_SUB', $mno_id);

        if (strlen($a) == 0) {
            $a = $db->textVal('ICOMMS_MAIL_SUB', 'ADMIN');
        }*/

            $login_design = $package_functions->getSectionType('LOGIN_SIGN', $user_system_package);
            $link = $db->getSystemURL('verification', $login_design);

            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $user_system_package, $user_vertical);

            $email_content = $db->getEmailTemplateVertical('VENUE_ADD_ADMIN', $system_package, 'MNO', $user_vertical, $mno_id);

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];


            $vars = array(
                '{$user_full_name}' => $mvnx_full_name,
                '{$short_name}' => $db->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$property_id}' => $resend_verification_number,
                '{$user_name}' => $dis_user_name,
                '{$support_number}' => $support_number,
                '{$password}' => $password,
                '{$link}' => $link
            );


            $message_full = strtr($a, $vars);
            //$message = mysql_escape_string($message_full);
            $message = $db->escapeDB($message_full);

            $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
        VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
            $rrr = $db->execDB($qu);


            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
            include_once 'src/email/' . $email_send_method . '/index.php';

            //email template
            //$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package);
            $cunst_var = array();
            /*if ($emailTemplateType == 'child') {
                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);
            } elseif ($emailTemplateType == 'owen') {
                $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
            } elseif (strlen($emailTemplateType) > 0) {
                $cunst_var['template'] = $emailTemplateType;
            }*/
            $cunst_var['system_package'] = $user_system_package;
            $cunst_var['mno_package'] = $system_package;
            $cunst_var['mno_id'] = $mno_id;
            $cunst_var['verticle'] = $user_vertical;
            $mail_obj = new email($cunst_var);

            $mail_obj->mno_system_package = $system_package;
            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);


            if ($mail_sent == '1') {
                $properties_edit_success = $message_functions->showNameMessage('property_send_email_suceess', $mvnx_full_name);

                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showNameMessage('property_send_email_failed', $mvnx_full_name);

                $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";
            }
        }
    } //
    foreach ($modules[$user_type][$script] as $value) {
        $submit_form = 'modules/' . $value['submit'] . '.php';
        if (file_exists($submit_form)) {
            //require_once 'modules/' . $modules['tab_menu']['submit'] . '.php';
            require_once $submit_form;
        }
    }

    //Form Refreshing avoid secret key/////
    $secret = md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET'] = $secret;


    /*$location_mid = 'layout/' . $camp_layout . '/views/location_mid.php';

    if (($new_design == 'yes') && file_exists($location_mid)) {

        include_once $location_mid;

    }
    else {*/
    // TAB Organization
    if (isset($_GET['t'])) {
        $variable_tab = 'tab_' . $_GET['t'];
        $$variable_tab = 'set';
    }

    if ($package_functions->getSectionType('MULTI_SERVICE_AREA', $system_package) == 'ON') {

        $multi_service_area = json_decode($package_functions->getOptions('MULTI_SERVICE_AREA', $system_package));
        //$package_functions->getOptions('MULTI_SERVICE_AREA',$system_package);

    }

    if ($edit_account == '1') {
        echo "<script type='text/javascript'>var edit_account = '1';</script>";
    } else {
        echo "<script type='text/javascript'>var edit_account = '0';</script>";
    }

    ?>

    <div class="main">
        <div class="custom-tabs"></div>
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <?php if (isset($_GET['view_loc_code'])) { ?>
                            <a href="location.php" class="btn_bac" style="font-size: 16px;  font-weight: 600; color: #0679CA;float:left; margin-top: 8px; position: relative; margin-left:20px;">
                                &lt; Back
                            </a>
                        <?php } ?>
                        <br class="hideBr"><br class="hideBr">
                        <div class="widget ">


                            <div class="widget-header">
                                <!-- <i class="icon-sitemap"></i> -->
                                <?php if ($user_type == 'ADMIN') {

                                ?>
                                    <h3>Manage Operations</h3>

                                <?php } else {
                                    if (isset($_GET['view_loc_code'])) {
                                        echo '<h3>View Property and AP information</h3>';
                                    } else {


                                        echo '<h3>View and Manage Properties</h3>';
                                    }
                                } ?>
                            </div><!-- /widget-header -->


                            <div class="widget-content">
                                <div class="tabbable">
                                    <?php
                                    if (!in_array('support', $access_modules_list) || $edit_account == '1' || $user_type == 'SALES') {
                                        $module_controls['create_location_on'] = 1;
                                    }
                                    if (in_array('support', $access_modules_list) && isset($_GET['assign_loc_admin'])) {
                                        $module_controls['assign_location_admin'] = 1;
                                    }

                                    //if ($user_type == 'MNO' || $user_type == 'MVNE' || $user_type == 'MVNO' || $user_type == 'SUPPORT' || $user_type == 'SALES') {
                                    require_once 'modules/' . $modules['tab_menu']['module'] . '.php';
                                    //}

                                    /*if ($user_type == 'ADMIN') {
                                            */ ?>
                                    <!--
                                            <ul class="nav nav-tabs newTabs">
                                                <li <?php /*if (isset($tab8)){ */ ?>class="active" <?php /*} */ ?>><a
                                                            href="#active_mno"
                                                            data-toggle="tab">Active <?php /*echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); */ ?></a>
                                                </li>
                                                <li <?php /*if (isset($tab6)){ */ ?>class="active" <?php /*} */ ?>><a
                                                            href="#mno_account"
                                                            data-toggle="tab"><?php /*if ($mno_edit == 1) {
                                                            echo "Edit " . $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'") . " Account";
                                                        } else {
                                                            echo "Create " . $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'") . " Account";
                                                        }; */ ?></a></li>
                                                <li <?php /*if (isset($tab11)){ */ ?>class="active" <?php /*} */ ?>><a
                                                            href="#saved_mno" data-toggle="tab">Pending Account
                                                        Activation <?php /*echo $db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='MNO'"); */ ?></a>
                                                </li>
                                            </ul>
                                            --><?php
                                                /*                                        }*/
                                                ?>
                                    <div class="tab-content">

                                        <?php

                                        if (isset($_SESSION['msg10'])) {
                                            echo $_SESSION['msg10'];
                                            unset($_SESSION['msg10']);
                                        }


                                        if (isset($_SESSION['msg9'])) {
                                            echo $_SESSION['msg9'];
                                            unset($_SESSION['msg9']);
                                        }


                                        if (isset($_SESSION['msg3'])) {
                                            echo $_SESSION['msg3'];
                                            unset($_SESSION['msg3']);
                                        }


                                        if (isset($_SESSION['msg14'])) {
                                            echo $_SESSION['msg14'];
                                            unset($_SESSION['msg14']);
                                        }


                                        if (isset($_SESSION['msg24'])) {
                                            echo $_SESSION['msg24'];
                                            unset($_SESSION['msg24']);
                                        }



                                        if (isset($_SESSION['msg6'])) {
                                            echo $_SESSION['msg6'];
                                            unset($_SESSION['msg6']);
                                        }





                                        if (isset($_SESSION['msg11'])) {
                                            echo $_SESSION['msg11'];
                                            unset($_SESSION['msg11']);
                                        }


                                        if (isset($_SESSION['msg5'])) {
                                            echo $_SESSION['msg5'];
                                            unset($_SESSION['msg5']);
                                        }


                                        if (isset($_SESSION['msg12'])) {
                                            echo $_SESSION['msg12'];
                                            unset($_SESSION['msg12']);
                                        }

                                        if (isset($_SESSION['msg13'])) {
                                            echo $_SESSION['msg13'];
                                            unset($_SESSION['msg13']);
                                        }



                                        if (isset($_SESSION['msg7'])) {
                                            echo $_SESSION['msg7'];
                                            unset($_SESSION['msg7']);
                                        }



                                        if (isset($_SESSION['msg20'])) {
                                            echo $_SESSION['msg20'];
                                            unset($_SESSION['msg20']);
                                        }



                                        //if($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == 'MVNE' || $user_type == 'SUPPORT' || $user_type == 'SALES'){
                                        foreach ($modules[$user_type][$script] as $value) {
                                            if (!ModuleFunction::filter($value['id'], $module_controls)) {
                                                continue;
                                            }
                                            //echo 'modules/'.$value['module'].'.php';
                                            include_once 'modules/' . $value['module'] . '.php';
                                        }
                                        //}
                                        ?>

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




    <script type="text/javascript" src="js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator_new.js?v=1"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            //create_location / MVN(X) account
            $('#location_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: [':disabled', function($field, validator) {
                    // Do not validate invisible element
                    if ($field.attr("id") == 'zone') {
                        if (!$('#automation_property').is(':checked')) {
                            if ($('#network_control').is(':visible')) {
                                //console.log('*');
                                //console.log($field.is(':hidden')+'hidden'+$field.attr("id"));
                                return false;
                            } else {
                                //console.log('step');
                                return true;
                            }
                        } else {
                            //console.log('auto');
                            return true;
                        }
                    } else if ($field.attr("id") == 'groups') {
                        if (!$('#automation_property').is(':checked')) {
                            if ($('#network_control').is(':visible')) {
                                //console.log('*');
                                //console.log($field.is(':hidden')+'hidden'+$field.attr("id"));
                                return false;
                            } else {
                                //console.log('step');
                                return true;
                            }
                        } else {
                            //console.log('auto');
                            return true;
                        }
                    } else {
                        //console.log($field.is(':visible')+'vesible'+$field.attr("id"));
                        return (!$field.is(':visible') || $field.is(':hidden'));
                    }

                }],
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

                    <?php if (($field_array['parent_id'] == "mandatory") && ($edit_account != '1')) { ?>
                        parent_id: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>,
                                <?php echo $db->validateField('parent_id'); ?>

                                <?php if ($edit_account != '1' && !isset($edit_parent_id)) { ?>,
                                    remote: {
                                        url: 'ajax/validateIcom.php',
                                        // Send { username: 'its value', email: 'its value' } to the back-end
                                        data: function(validator, $field, value) {
                                            return {
                                                //email: validator.getFieldElements('email').val()
                                            };
                                        },
                                        message: '<p>Business ID Account exists</p>',
                                        type: 'POST'
                                    }
                                <?php } ?>,
                                different: {
                                    field: 'zone_name',
                                    message: 'The value entered in Business ID matches value in Unique Property ID field. Please enter a new value.'
                                }
                            }
                        },
                    <?php } ?>


                    parent_package_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },

                    <?php if ($field_array['parent_ac_name'] == "mandatory") { ?>
                        parent_ac_name: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>
                    <?php if (($field_array['icomms_number'] == "mandatory") || ($field_array['icomms_number_m'] == "mandatory")) { ?>
                        icomme: {
                            validators: {
                                <?php echo $db->validateField('icom'); ?>
                            }
                        },
                        icomme_pvt: {
                            validators: {
                                <?php echo $db->validateField('icom'); ?>
                            }
                        },
                        vt_icomme: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>

                    <?php if ($field_array['pr_gateway_type'] == "mandatory") { ?>
                        pr_gateway_type: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>

                    <?php if ($field_array['account_type'] == "mandatory") { ?>
                        customer_type: {
                            validators: {
                                <?php echo $db->validateField('customer_type'); ?>
                            }
                        },
                    <?php } ?>
                    <?php if (array_key_exists('business_type', $field_array)) {
                        if ($field_array['business_type'] == "mandatory") { ?>
                            business_type: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>
                    <?php if (array_key_exists('add2', $field_array) || $package_features == "all") {
                        if ($field_array['add2'] == "mandatory" || $package_features == "all") { ?>
                            mno_address_2: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>
                    <?php if (array_key_exists('country', $field_array) || $package_features == "all") {
                        if ($field_array['country'] == "mandatory" || $package_features == "all") { ?>
                            mno_country: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>
                    <?php if (array_key_exists('zip_code', $field_array) || $package_features == "all") {
                        if ($field_array['zip_code'] == "mandatory" || $package_features == "all") { ?>
                            mno_zip_code: {
                                validators: {
                                    <?php echo $db->validateField('zip_code'); ?>
                                }
                            },
                    <?php }
                    } ?>
                    <?php if (array_key_exists('time_zone', $field_array) || $package_features == "all") {
                        if ($field_array['time_zone'] == "mandatory" || $package_features == "all") { ?>
                            mno_time_zone: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>

                    <?php if (array_key_exists('p_QOS', $field_array) || $package_features == "all") {
                        if ($field_array['p_QOS'] == "mandatory" || $package_features == "all") { ?>
                            AP_contrl: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>

                    <?php if (array_key_exists('g_QOS', $field_array) || $package_features == "all") {
                        if ($field_array['g_QOS'] == "mandatory" || $package_features == "all") { ?>
                            AP_contrl_guest: {
                                validators: {
                                    <?php echo $db->validateField('notEmpty'); ?>
                                }
                            },
                    <?php }
                    } ?>
                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        AP_contrl_guest_time: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>

                    <?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                        AP_contrl_time: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>

                    <?php if ($field_array['subcribers_def'] == "mandatory") { ?>
                        subcribers_pro: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>
                    network_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    conroller: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php if ($field_array['ne_WAG'] == "mandatory") { ?>
                        wag_name: {
                            validators: {
                                <?php //echo $db->validateField('notEmpty'); 
                                ?>
                            }
                        },
                    <?php } ?>
                    zone: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php if ($auto_account_type == "new") { ?>
                        groups: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        groups1: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        groups2: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                        groups3: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>
                    realm_map_val: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    gateway_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    <?php if ($field_array['network_config_realm'] == 'mandatory') { ?>
                        realm: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>
                    <?php if ($field_array['content_filter_dns'] == 'mandatory') { ?>
                        DNS_profile: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        },
                    <?php } ?>
                    user_type: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    location_name1: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    category_mvnx: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    }
                    <?php if ($mno_form_type == 'advanced_menu') { //advanced_menu
                    ?>

                        ,
                        mno_first_name: {
                            validators: {
                                <?php echo $db->validateField('person_full_name'); ?>
                            }
                        },

                        <?php if ($edit_account != '1') { ?>
                            mno_last_name: {
                                validators: {
                                    <?php echo $db->validateField('person_full_name'); ?>
                                }
                            },
                        <?php } ?>
                        mno_email: {
                            validators: {
                                <?php echo $db->validateField('email'); ?>
                            }
                        },
                        mno_address_1: {
                            validators: {
                                <?php echo $db->validateField('text_box'); ?>
                            }
                        },
                        mno_state: {
                            validators: {
                                <?php echo $db->validateField('text_box'); ?>
                            }
                        },
                        mno_mobile_1: {
                            validators: {
                                <?php echo $db->validateField('mobile'); ?>
                            }
                        },
                        mno_mobile_2: {
                            validators: {
                                <?php echo $db->validateField('mobile_non_req'); ?>
                            }
                        },
                        mno_mobile_3: {
                            validators: {
                                <?php echo $db->validateField('mobile_non_req'); ?>
                            }
                        },
                        <?php if (($field_array['unique_property_id'] != 'display_none')) { ?>
                            zone_name: {
                                validators: {
                                    <?php echo $db->validateField('person_full_name'); ?>,
                                    different: {
                                        field: 'parent_id',
                                        message: 'The value entered in Unique Property ID matches value in Business ID field. Please enter a new value.'
                                    }
                                }
                            },
                        <?php } ?>
                        <?php if ($field_array['network_config_des'] == 'mandatory') { ?>
                            zone_dec: {
                                validators: {
                                    <?php echo $db->validateField('description'); ?>
                                }
                            },
                        <?php } ?>
                        <?php if ($field_array['network_type'] == 'mandatory') { ?> 'network_type[]': {
                                validators: {
                                    <?php echo $db->validateField('multi_select'); ?>
                                }
                            },
                        <?php } ?>
                        zone_uid: {
                            validators: {
                                <?php echo $db->validateField('name'); ?>
                            }
                        },
                        wlan1_name: {
                            validators: {
                                <?php echo $db->validateField('name'); ?>
                            }
                        },
                        wlan1_ssid: {
                            validators: {
                                <?php echo $db->validateField('name'); ?>
                            }
                        },
                        wlan2_name: {
                            validators: {
                                <?php echo $db->validateField('name'); ?>
                            }
                        },
                        wlan2_ssid: {
                            validators: {
                                <?php echo $db->validateField('name'); ?>
                            }
                        },
                        apmac1: {
                            validators: {
                                <?php echo $db->validateField('mac'); ?>
                            }
                        }


                    <?php } else { ?>,
                        mvnx_full_name: {
                            validators: {
                                <?php echo $db->validateField('person_full_name'); ?>
                            }
                        },
                        mvnx_email: {
                            validators: {
                                <?php echo $db->validateField('email'); ?>
                            }
                        },
                        mvnx_mobile: {
                            validators: {
                                <?php echo $db->validateField('mobile'); ?>
                            }
                        },
                        mvnx_num_ssid: {
                            validators: {
                                <?php echo $db->validateField('dropdown'); ?>
                            }
                        }

                    <?php }
                    $buildCount = 25;
                    for ($i = 0; $i < $buildCount; $i++) {
                    ?>,
                        icom<?php echo ($i + 1); ?>: {
                            validators: {
                                <?php echo $db->validateField('notEmpty'); ?>
                            }
                        }

                    <?php } ?>
                }
            });
            //create ssid form validation
            $('#ssid_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    network_ssid: {
                        validators: {
                            <?php echo $db->validateField('network_ssid'); ?>
                        }
                    },
                    ssid_description: {
                        validators: {
                            <?php echo $db->validateField('description'); ?>
                        }
                    },
                    gt_mvnx: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    my_select: {
                        validators: {
                            <?php echo $db->validateField('multi_select'); ?>
                        }
                    }
                }
            });

            //assign ssid - ip form validation
            $('#ssid_asign_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    asign_ssid: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    grp_tg: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    my_select4: {
                        validators: {
                            <?php echo $db->validateField('multi_select'); ?>
                        }
                    }
                }
            });


            //Update AP(s)
            $('#location_update').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    category_ass_mvnx: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    my_select3: {
                        validators: {
                            <?php echo $db->validateField('multi_select'); ?>
                        }
                    }
                }
            });


            //Create AP(s)
            $('#ap_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {

                    <?php if ($edit_cpe_account != '1') { ?>
                        ap_code: {
                            validators: {
                                <?php echo $db->validateField('ap_code'); ?>
                            }
                        },
                        mac_address: {
                            validators: {
                                <?php echo $db->validateField('mac_address'); ?>
                            }
                        },
                    <?php } else { ?>

                        mac_address: {
                            validators: {
                                <?php echo $db->validateField('edit_mac_address'); ?>
                            }
                        },


                    <?php } ?>

                    category_ass_mvnx: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    private_upload_cpe: {
                        validators: {
                            <?php echo $db->validateField('internet_speed'); ?>
                        }
                    },
                    private_download_cpe: {
                        validators: {
                            <?php echo $db->validateField('internet_speed'); ?>
                        }
                    },
                    private_ip_address: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    private_netmask: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    private_max_users: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    private_dns1: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    private_dns2: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    guest_upload_cpe: {
                        validators: {
                            <?php echo $db->validateField('internet_speed'); ?>
                        }
                    },
                    guest_download_cpe: {
                        validators: {
                            <?php echo $db->validateField('internet_speed'); ?>
                        }
                    },
                    guest_ip_address: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    guest_netmask: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    guest_max_users: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    guest_dns1: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    guest_dns2: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    },
                    wifi_radio: {
                        validators: {
                            <?php echo $db->validateField('ip_address'); ?>
                        }
                    }

                }
            });

            // create mno account
            $('#mno_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    mno_account_name: {
                        validators: {
                            <?php echo $db->validateField('name'); ?>
                        }
                    },
                    mno_user_type: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },

                    'AP_cont[]': {
                        validators: {
                            <?php echo $db->validateField('list'); ?>
                        }
                    },
                    'feature_cont[]': {
                        validators: {
                            <?php //echo $db->validateField('list'); 
                            ?>
                        }
                    },
                    'vt_group[]': {
                        validators: {
                            <?php echo $db->validateField('list'); ?>
                        }
                    }

                    ,
                    mno_customer_type: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    mno_first_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    mno_last_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    mno_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    },
                    mno_address_1: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_address_2: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_address_3: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_state: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_country: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_mobile_1: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    },
                    mno_mobile_2: {
                        validators: {
                            <?php echo $db->validateField('mobile_non_req'); ?>
                        }
                    },
                    mno_mobile_3: {
                        validators: {
                            <?php echo $db->validateField('mobile_non_req'); ?>
                        }
                    },
                    mno_time_zone: {
                        validators: {
                            <?php echo $db->validateField('dropdown'); ?>
                        }
                    },
                    mno_zip_code: {
                        validators: {
                            <?php echo $db->validateField('text_box'); ?>
                        }
                    },
                    mno_api_prifix: {
                        validators: {
                            remote: {
                                message: 'Already exists',
                                url: 'ajax/ajax_operatorCode.php',

                                data: {
                                    previous_api_prifix: '<?php echo $get_edit_mno_api_prefix; ?>'
                                }

                            },
                            notEmpty: {
                                message: 'This is a required field'
                            }

                        }
                    },
                    mno_short_name: {
                        enabled: false,
                        validators: {
                            remote: {
                                message: 'Already exists',
                                url: 'ajax/ajax_loginSign.php',

                                data: {
                                    previous_short_name: '<?php echo $get_mno_short_name; ?>'
                                }

                            },
                            notEmpty: {
                                message: 'This is a required field'
                            }

                        }
                    },
                    mno_sys_package: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    },
                    logo_img1: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    },
                    email_img1: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    },
                    mno_support_number: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    },
                    mno_support_email: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    },
                    'vt_group[]': {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'This is a required field'
                            }
                        }
                    }


                }
            });


            var edit_account = "<?php echo $_GET['edit_loc_id']; ?>";
            var pr_gateway_type = "<?php echo $edit_distributor_pr_gateway_type; ?>";
            var gateway_type = "<?php echo $edit_distributor_gateway_type; ?>";
            try {
                wagnamevalidate(edit_account, pr_gateway_type, gateway_type);
            } catch (err) {

                //document.getElementById("demo").innerHTML = err.message;
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#edit_profile_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    ed_first_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    ed_last_name: {
                        validators: {
                            <?php echo $db->validateField('person_full_name'); ?>
                        }
                    },
                    ed_ad_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>
                        }
                    },
                    mobile_1: {
                        validators: {
                            <?php echo $db->validateField('mobile'); ?>
                        }
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            //Update Parents
            $('#parent_form').bootstrapValidator({
                framework: 'bootstrap',
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    parent_ac_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>,
                            <?php echo $db->validateField('parent_id'); ?>
                        }
                    },
                    parent_ac_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    parent_first_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    parent_last_name: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    parent_package_type: {
                        validators: {
                            <?php echo $db->validateField('notEmpty'); ?>
                        }
                    },
                    parent_email: {
                        validators: {
                            <?php echo $db->validateField('email'); ?>

                        }
                    },
                    change_0: {
                        validators: {
                            <?php echo $db->validateField('parent_email_change'); ?>
                        }
                    },
                    dpsk_conroller: {
                        validators: {

                        }
                    },
                    dpsk_policies: {
                        validators: {

                        }
                    }
                }
            });

            if ($('#parent_username_change').is(':checked')) {

                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
            } else {
                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
            }

            $('#submit_p_form').prop('disabled', true);


        });

        $('#parent_username_change').click(function(event) {

            if ($('#parent_username_change').is(':checked')) {

                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
            } else {
                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
            }

            $('#parent_form')
                .bootstrapValidator('validateField', 'change_0');

        });

        $('#parent_email').keyup(function(event) {

            if ($('#parent_username_change').is(':checked')) {

                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', true);
            } else {
                $('#parent_form')
                    .bootstrapValidator('enableFieldValidators', 'change_0', false)
            }

            $('#parent_form')
                .bootstrapValidator('validateField', 'change_0');

        });


        $(document).ready(function() {
            $('#mno_sys_package').on('change', function() {
                var sys_package = this.value;
                var bootstrapValidator = $('#mno_form').data('bootstrapValidator');
                bootstrapValidator.enableFieldValidators('mno_api_prifix', true,'remote');
                if (sys_package == 'DYNAMIC_MNO_001') {
                    bootstrapValidator.enableFieldValidators('mno_short_name', true);
                    bootstrapValidator.enableFieldValidators('logo_img1', true);
                    bootstrapValidator.enableFieldValidators('email_img1', true);
                    bootstrapValidator.enableFieldValidators('mno_support_number', true);
                    bootstrapValidator.enableFieldValidators('mno_support_email', true);
                    bootstrapValidator.enableFieldValidators('mno_api_prifix', false,'remote');
                    //bootstrapValidator.enableFieldValidators('vt_group[]', true);
                } else if (sys_package == 'ATT_MNO_001') {
                    bootstrapValidator.enableFieldValidators('mno_short_name', false);
                    bootstrapValidator.enableFieldValidators('logo_img1', false);
                    bootstrapValidator.enableFieldValidators('email_img1', false);
                    bootstrapValidator.enableFieldValidators('mno_support_number', false);
                    bootstrapValidator.enableFieldValidators('mno_support_email', false);
                    bootstrapValidator.enableFieldValidators('vt_group[]', true);
                } else {
                    bootstrapValidator.enableFieldValidators('mno_short_name', false);
                    bootstrapValidator.enableFieldValidators('logo_img1', false);
                    bootstrapValidator.enableFieldValidators('email_img1', false);
                    bootstrapValidator.enableFieldValidators('mno_support_number', false);
                    bootstrapValidator.enableFieldValidators('mno_support_email', false);
                    bootstrapValidator.enableFieldValidators('vt_group[]', false);
                }

            });


        });
    </script>

    <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'DYNAMIC_MNO_001') { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                var bootstrapValidator = $('#mno_form').data('bootstrapValidator');
                bootstrapValidator.enableFieldValidators('mno_short_name', true);
                bootstrapValidator.enableFieldValidators('mno_support_number', true);
                bootstrapValidator.enableFieldValidators('mno_support_email', true);
                bootstrapValidator.enableFieldValidators('vt_group[]', false);
                bootstrapValidator.enableFieldValidators('mno_api_prifix', false,'remote');
            });
        </script>

    <?php } ?>


    <?php if ($mno_edit == 1 && $get_edit_mno_sys_pack == 'ATT_MNO_001') { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                var bootstrapValidator = $('#mno_form').data('bootstrapValidator');
                bootstrapValidator.enableFieldValidators('vt_group[]', true);
            });
        </script>

    <?php } ?>

    <script src="js/jquery.multi-select.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#my_select').multiSelect();
            $('#my_select2').multiSelect();
            $('#my_select3').multiSelect({
                cssClass: "template",
                keepOrder: true
            });
            $('#my_select4').multiSelect();
            $('#my_select5').multiSelect();
            $('#network_type').multiSelect({
                cssClass: "mini",
                afterSelect: function(values) {
                    select_network_typeArr = $('#network_type').val();

                    var val = '';
                    if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                        val = 'VT-BOTH';
                    } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                        val = 'BOTH';
                    } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                        val = 'VT-GUEST';
                    } else if ((select_network_typeArr.indexOf("PRIVATE") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                        val = 'VT-PRIVATE';
                    } else if (select_network_typeArr.indexOf("PRIVATE") >= 0) {
                        val = 'PRIVATE';
                    } else if (select_network_typeArr.indexOf("GUEST") >= 0) {
                        val = 'GUEST';
                    } else if (select_network_typeArr.indexOf("VT") >= 0) {
                        val = 'VT';
                    } else {

                    }

                    if (typeof wlanAutomation == 'function') {
                        wlanAutomation(val);
                    }

                    changeProfileArea(val);
                    changeGetwayArea(val);
                    enableRealmGroups();


                },
                afterDeselect: function(values) {
                    var val = '';
                    select_network_typeArr = $('#network_type').val();


                    if (select_network_typeArr != null) {

                        if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                            val = 'VT-BOTH';
                        } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                            val = 'BOTH';
                        } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                            val = 'VT-GUEST';
                        } else if ((select_network_typeArr.indexOf("PRIVATE") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                            val = 'VT-PRIVATE';
                        } else if (select_network_typeArr.indexOf("PRIVATE") >= 0) {
                            val = 'PRIVATE';
                        } else if (select_network_typeArr.indexOf("GUEST") >= 0) {
                            val = 'GUEST';
                        } else if (select_network_typeArr.indexOf("VT") >= 0) {
                            val = 'VT';
                        } else {

                        }

                    }
                    if (typeof wlanAutomation == 'function') {
                        wlanAutomation(val);
                    }
                    changeProfileArea(val);
                    changeGetwayArea(val);
                    enableRealmGroups();


                }
            });
            $('#my_select7').multiSelect();

            $('#AP_cont').multiSelect();

            $('#feature_cont').multiSelect({

                afterSelect: function(values) {
                    var bootstrapValidator = $('#mno_form').data('bootstrapValidator');
                    if (values == 'VTENANT_MODULE') {
                        bootstrapValidator.enableFieldValidators('vt_group[]', true);
                        $('#vt-groups').show();
                    }
                },
                afterDeselect: function(values) {
                    var bootstrapValidator = $('#mno_form').data('bootstrapValidator');
                    if (values == 'VTENANT_MODULE') {
                        bootstrapValidator.enableFieldValidators('vt_group[]', false);
                        $('#vt-groups').hide();
                    }
                }
            });
            $('#vt_group').multiSelect();
            $('#admin_features').multiSelect({
                cssClass: "mini"
            });
            $('#parent_features').multiSelect({
                cssClass: "mini"
            });
        });


        $(document).on('change', '#AP_cont', function(event) {

            $select = $(event.target),
                val = $select.val(), /*selected items after event*/

                /* Store the array of selected elements  */
                $select.data('selected', val);

            /* console.log(val); */

            /* convert to json*/
            var wagdata = JSON.stringify(val);

            var formData = {
                loadWAG: true,
                wags: wagdata
            };

            /* alert(formData);  */

            $.ajax({
                url: "ajax/loadWAGs.php",
                type: "POST",
                data: formData,
                success: function(data) {
                    //alert(data);


                    $('#mno_wag_profiles').val(data);
                    //$('#getGREProfiles_error').html('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    /*alert(textStatus);*/
                    //$('#getGREProfiles_error').html('<font color="red">Network error</font>');
                }
            });

        });
    </script>


    <?php

    include 'footer.php';

    ?>

    <!--Alert message -->
    <link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

    <!-- tool tip css -->
    <link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
    <link rel="stylesheet" type="text/css" href="css/tooltipster.css" />


    <!--jquery code for upload browse button-->
    <script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8"></script>


    <script type="text/javascript" charset="utf-8">
        $(function() {
            $("input.browse").filestyle({
                image: "img/choosefile.gif",
                imageheight: 30,
                imagewidth: 82,
                width: 100,
                height: 10
            });
        });
    </script>


    <!-- Alert messages -->
    <?php
    if ($mno_edit == 1) {
    ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#submit_mno_form").easyconfirm({
                    locale: {

                        title: 'Operator Account',
                        text: 'Are you sure you want to edit this Operator Account?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'

                    }
                });

                $("#submit_mno_form").click(function() {});
            })
        </script>

    <?php
    } else {
    ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#submit_mno_form").easyconfirm({
                    locale: {

                        title: 'Operator Account',
                        text: 'Are you sure you want to create this Operator account?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'

                    }
                });

                $("#submit_mno_form").click(function() {});
            })
        </script>
    <?php } ?>


    <script type="text/javascript">
        $(document).ready(function() {


            $("#create_location_submit").easyconfirm({
                locale: {
                    title: 'Account <?php if ($edit_account == '1') {
                                        $set_name = 'edit';
                                        echo 'Edit';
                                    } else {
                                        $set_name = 'create';
                                        echo 'Creation';
                                    } ?>',
                    text: 'Are you sure you want to <?php echo $set_name; ?> this account?',
                    button: ['Cancel', ' Confirm'],
                    closeText: 'close'

                }
            });

            $("#create_location_submit").click(function() {});


            $("#create_location_next").easyconfirm({
                locale: {
                    title: 'Account Creation',
                    text: 'Are you sure you want to create this account?',
                    button: ['Cancel', ' Confirm'],
                    closeText: 'close'

                }
            });

            $("#create_location_next").click(function() {});

            <?php if ($edit_account != '1') { ?>
                $("#add_location_submit").easyconfirm({
                    locale: {
                        title: 'Add Location',
                        text: 'Are you sure you want to add this location and finish account <?php if ($_POST['p_update_button_action'] == 'add_location') {
                                                                                                    echo 'update';
                                                                                                } else {
                                                                                                    echo 'creation';
                                                                                                } ?>?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'

                    }
                });
            <?php } else { ?>
                $("#add_location_submit").easyconfirm({
                    locale: {
                        title: 'Update Location',
                        text: 'Are you sure you want to update this location?<br><small id="ap_assignment_warn" style="display:none;" class=""><p>Please save all app assignment</p></small>',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'

                    }
                });
            <?php } ?>

            $("#add_location_submit").click(function() {});

            <?php if ($edit_account != '1') { ?>
                $("#add_location_next").easyconfirm({
                    locale: {
                        title: 'Add Location',
                        text: 'Are you sure you want to add this location?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'

                    }
                });

                $("#add_location_next").click(function() {});

            <?php } ?>


            $("#submit_assign_user").easyconfirm({
                locale: {
                    title: 'Assign User',
                    text: 'Are you sure you want to assign this user?',
                    button: ['Cancel', ' Confirm'],
                    closeText: 'close'

                }
            });

            $("#submit_assign_user").click(function() {});


        });
    </script>
    <script type="text/javascript" id="easy_confirm">
        $(document).ready(function() {
            /*$("#submit_p_form").easyconfirm({locale: {
            title: 'Update Account',
            text: $("#parent_update_conf_msg").html(),

            button: ['Cancel',' Confirm'],
            closeText: 'close'

        }});*/

            $("#submit_p_form").click(function() {});
        });
    </script>
    <style>
        #submit_p_form_confirm.parent-update-conf-div-long {
            margin-left: -300px;
        }

        #submit_p_form_confirm.parent-update-conf-div-small {
            margin-left: -220px;
        }

        @media (max-width: 520px) {
            #submit_p_form_confirm {
                left: auto !important;
                margin: 10px !important;
            }
        }

        .ms-container.mini .ms-list {
            height: 110px;
        }
    </style>
    <div id="submit_p_form_confirm" class="parent-update-conf-div-small ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" style="height: auto; width: auto; top: 30%; left: 50%; display: none;" tabindex="-1" role="dialog" aria-describedby="ui-id-133" aria-labelledby="ui-id-134">
        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
            <span class="ui-dialog-title">Update Account</span>
            <button id="submit_p_form_confirm_cancel0" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
                <span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span>
                <span class="ui-button-text">close</span>
            </button>
        </div>
        <div id="submit_p_form_confirm_text" class="dialog confirm ui-dialog-content ui-widget-content" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto;">
        </div>
        <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
            <div class="ui-dialog-buttonset">
                <button id="submit_p_form_confirm_cancel" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                    <span class="ui-button-text">Cancel</span>
                </button>
                <button id="submit_p_form_confirm_ok" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
                    <span class="ui-button-text"> Confirm</span>
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#submit_p_form_confirm_cancel").click(function(event) {
                $('#submit_p_form_confirm').hide();
                $('.ui-widget-overlay').hide();
            });
            $("#submit_p_form_confirm_cancel0").click(function(event) {
                $('#submit_p_form_confirm').hide();
                $('.ui-widget-overlay').hide();
            });
            $("#submit_p_form_confirm_ok").click(function(event) {
                //$( "#submit_p_form" ).submit();
                //document.parent_form.submit();
                document.getElementById("parent_form").submit();
            });
        });
    </script>
    <script src="js/jquery.chained.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $("#product_code").chained("#category");
        });
    </script>

    <script type="text/javascript" src="js/jquery.form.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#photoimg').on('change', function() {
                $("#preview").html('');
                $("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');
                $("#imageform").ajaxForm({
                    target: '#preview'
                }).submit();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#photoimg1').on('change', function() {
                $("#preview1").html('');
                $("#preview1").html('<img src="img/loader.gif" alt="Uploading...."/>');
                $("#imageform1").ajaxForm({
                    target: '#preview1'
                }).submit();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#photoimg3').on('change', function() {
                $("#preview3").html('');
                $("#preview3").html('<img src="img/loader.gif" alt="Uploading...."/>');
                $("#imageform3").ajaxForm({
                    target: '#preview3'
                }).submit();
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#photoimg4').on('change', function() {
                $("#preview4").html('');
                $("#preview4").html('<img src="img/loader.gif" alt="Uploading...."/>');
                $("#imageform4").ajaxForm({
                    target: '#preview4'
                }).submit();
            });
        });
    </script>


    <!-- Uploaded file type check-->

    <script type="text/javascript">
        function check_extension(filename) {

            var re = /\..+$/;
            //get file extension
            var ext = filename.match(re);
            var upper_ext = ext.toString().substring(1);
            var y = upper_ext.toUpperCase();
            if (y == "CSV") {
                document.getElementById("upload_cont").disabled = false;
                return true;
            } else {
                alert("Invalid file type, Please Select a valid CSV file");
                document.getElementById("upload_cont").disabled = true;
                return false;
            }
        }
    </script>
    <script type="text/javascript">
        function validateDNS() {
            var add_location_form_validator = $('#location_form').data('bootstrapValidator');
            var select_network_typeArr = Array();
            select_network_typeArr = $('#network_type').val();
            var select_gateway_type = $('#gateway_type').val();
            var select_network_type = '';
            if (select_network_typeArr != null) {

                if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    val = 'VT-BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    val = 'BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    val = 'VT-GUEST';
                } else if ((select_network_typeArr.indexOf("PRIVATE") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    val = 'VT-PRIVATE';
                } else if (select_network_typeArr.indexOf("PRIVATE") >= 0) {
                    val = 'PRIVATE';
                } else if (select_network_typeArr.indexOf("GUEST") >= 0) {
                    val = 'GUEST';
                } else if (select_network_typeArr.indexOf("VT") >= 0) {
                    val = 'VT';
                } else {

                }

            }

            <?php if ((array_key_exists('content_filter_dns', $field_array) && $field_array['content_filter_dns'] == 'mandatory') || $package_features == "all") { ?>

                // if (select_network_type == 'VT' || select_gateway_type == 'AC' || select_gateway_type == 'WAG') {
                //     add_location_form_validator.enableFieldValidators('DNS_profile', false);
                // } else {
                //     add_location_form_validator.enableFieldValidators('DNS_profile', true);
                // }
            <?php  } ?>
        }

        $(document).ready(function() {
            var val = '';
            var select_network_typeArr = Array();
            var select_network_typeArr = $('#network_type').val();

            if (select_network_typeArr != null) {


                if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    val = 'VT-BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    val = 'BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    val = 'VT-GUEST';
                } else if ((select_network_typeArr.indexOf("PRIVATE") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    val = 'VT-PRIVATE';
                } else if (select_network_typeArr.indexOf("PRIVATE") >= 0) {
                    val = 'PRIVATE';
                } else if (select_network_typeArr.indexOf("GUEST") >= 0) {
                    val = 'GUEST';
                } else if (select_network_typeArr.indexOf("VT") >= 0) {
                    val = 'VT';
                } else {

                }

            }

            var gateway = $('#gateway_type').val();


            $('#gateway_type').bind('change', function() {
                gateway = $('#gateway_type').val();
                changeContentFilterArea(gateway);
                validateDNS();
            });

            if (typeof wlanAutomation == 'function') {
                wlanAutomation(val);
            }

            changeProfileArea(val);
            changeGetwayArea(val);

        });

        function changeProfileArea(val) {
            var x = $("#customer_type option:selected").attr("data-feature");
            var bootstrapValidator = $('#location_form').data('bootstrapValidator');
            //var x = $('#customer_type option:selected').attr('data-feature');
            $('#pg_prof').show();

            switch (val) {
                //AP_contrl_guest_time

                case 'GUEST': {

                    //$('#pg_prof').html('Assign Guest Profiles');
                    // var bootstrapValidator = $('#location_form').data('bootstrapValidator');

                    $('#g_prof2').show();

                    $('#gd_prof').show();
                    <?php if ($field_array['p_QOS'] != 'display_none') { ?>
                        $('#p_prof2').hide();
                        bootstrapValidator.enableFieldValidators('AP_contrl', false);
                    <?php }
                    if ($field_array['pd_QOS'] != 'display_none') { ?>
                        $('#pd_prof').hide();
                        try {
                            bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                        } catch (e) {}
                    <?php } ?>



                    //document.getElementById('pg_prof').style.display = 'block';
                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                    break;
                }
                case 'PRIVATE': {
                    //$('#pg_prof').html('Assign Private Profiles');
                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    if (x == 'ON') {
                        $('#p_prof2').hide();
                        <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                            bootstrapValidator.enableFieldValidators('AP_contrl', false);
                        <?php }  ?>
                        $('#pd_prof').hide();
                        <?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                            bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                        <?php } ?>


                    } else {
                        <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                            $('#p_prof2').show();
                            bootstrapValidator.enableFieldValidators('AP_contrl', true);
                        <?php }
                        if ($field_array['pd_QOS'] == 'mandatory') { ?>
                            $('#pd_prof').show();
                            bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                        <?php } else { ?>

                            //document.getElementById('pg_prof').style.display = 'none';
                        <?php } ?>

                    }
                    $('#g_prof2').hide();

                    $('#gd_prof').hide();
                    $('#pg_prof').hide();


                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', false);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', false);
                    break;
                }
                case 'BOTH': {
                    //$('#pg_prof').html('Assign Private and Guest Profiles');
                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    if (x == 'ON') {
                        $('#p_prof2').hide();
                        <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                            bootstrapValidator.enableFieldValidators('AP_contrl', false);
                        <?php } ?>
                        $('#pd_prof').hide();
                        <?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                            bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                        <?php } ?>
                    } else {
                        <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                            $('#p_prof2').show();
                            bootstrapValidator.enableFieldValidators('AP_contrl', true);
                        <?php }
                        if ($field_array['pd_QOS'] == 'mandatory') { ?>
                            $('#pd_prof').show();
                            bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                        <?php } ?>
                    }


                    $('#g_prof2').show();

                    $('#gd_prof').show();
                    //document.getElementById('pg_prof').style.display = 'block';


                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                    break;
                }
                case 'VT': {

                    <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                        $('#p_prof2').hide();
                        bootstrapValidator.enableFieldValidators('AP_contrl', false);
                    <?php }
                    if ($field_array['pd_QOS'] == 'mandatory') { ?>
                        $('#pd_prof').hide();
                        bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                    <?php } ?>

                    $('#g_prof2').hide();

                    $('#gd_prof').hide();
                    //document.getElementById('pg_prof').style.display = 'none';


                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', false);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', false);
                    break;
                }
                case 'VT-GUEST': {

                    $('#g_prof2').show();

                    $('#gd_prof').show();
                    <?php if ($field_array['p_QOS'] != 'display_none') { ?>
                        $('#p_prof2').hide();
                        bootstrapValidator.enableFieldValidators('AP_contrl', false);
                    <?php }
                    if ($field_array['pd_QOS'] != 'display_none') { ?>
                        $('#pd_prof').hide();
                        bootstrapValidator.enableFieldValidators('AP_contrl_time', false);
                    <?php } ?>



                    //document.getElementById('pg_prof').style.display = 'block';
                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                    break;
                }
                case 'VT-PRIVATE': {
                    <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                        $('#p_prof2').show();
                        bootstrapValidator.enableFieldValidators('AP_contrl', true);
                    <?php }
                    if ($field_array['pd_QOS'] == 'mandatory') { ?>
                        $('#pd_prof').show();
                        bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                    <?php } else { ?>

                        //document.getElementById('pg_prof').style.display = 'none';
                    <?php } ?>
                    $('#g_prof2').hide();

                    $('#gd_prof').hide();


                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', false);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', false);
                    break;
                }
                case 'VT-BOTH': {
                    <?php if ($field_array['p_QOS'] == 'mandatory') { ?>
                        $('#p_prof2').show();
                        bootstrapValidator.enableFieldValidators('AP_contrl', true);
                    <?php }
                    if ($field_array['pd_QOS'] == 'mandatory') { ?>
                        $('#pd_prof').show();
                        bootstrapValidator.enableFieldValidators('AP_contrl_time', true);
                    <?php } ?>
                    $('#g_prof2').show();

                    $('#gd_prof').show();
                    //document.getElementById('pg_prof').style.display = 'block';


                    <?php if ($field_array['g_QOS_du'] != "display_none") { ?>
                        bootstrapValidator.enableFieldValidators('AP_contrl_guest_time', true);
                    <?php } ?>
                    bootstrapValidator.enableFieldValidators('AP_contrl_guest', true);
                    break;
                }
            }
        }

        function changeGetwayArea(val) {
            var bootstrapValidator = $('#location_form').data('bootstrapValidator');

            switch (val) {
                //AP_contrl_guest_time

                case 'GUEST': {
                    //$('#pg_prof').html('Assign Guest Profiles');
                    $('#pr_geteway_div').hide();

                    $('#gu_geteway_div').show();
                    $('#vt_guest_def').hide();


                    bootstrapValidator.enableFieldValidators('pr_gateway_type', false);
                    bootstrapValidator.enableFieldValidators('gateway_type', true);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', false);
                    <?php } ?>

                    break;
                }
                case 'PRIVATE': {
                    //$('#pg_prof').html('Assign Private Profiles');
                    $('#pr_geteway_div').show();

                    $('#gu_geteway_div').hide();
                    $('#vt_guest_def').hide();

                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                    bootstrapValidator.enableFieldValidators('gateway_type', false);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', false);
                    <?php } ?>

                    break;
                }
                case 'BOTH': {
                    //$('#pg_prof').html('Assign Private and Guest Profiles');
                    $('#pr_geteway_div').show();

                    $('#gu_geteway_div').show();
                    $('#vt_guest_def').hide();

                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                    bootstrapValidator.enableFieldValidators('gateway_type', true);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', false);
                    <?php } ?>
                    break;
                }
                case 'VT': {

                    $('#pr_geteway_div').hide();

                    $('#gu_geteway_div').hide();
                    $('#vt_guest_def').show();

                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('pr_gateway_type', false);
                    bootstrapValidator.enableFieldValidators('gateway_type', false);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', true);
                    <?php } ?>
                    break;
                }
                case 'VT-GUEST': {

                    $('#pr_geteway_div').hide();

                    $('#gu_geteway_div').show();
                    $('#vt_guest_def').show();


                    bootstrapValidator.enableFieldValidators('pr_gateway_type', false);
                    bootstrapValidator.enableFieldValidators('gateway_type', true);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', true);
                    <?php } ?>

                    break;
                }
                case 'VT-PRIVATE': {
                    $('#pr_geteway_div').show();

                    $('#gu_geteway_div').hide();
                    $('#vt_guest_def').show();

                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                    bootstrapValidator.enableFieldValidators('gateway_type', false);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', true);
                    <?php } ?>

                    break
                }
                case 'VT-BOTH': {
                    $('#pr_geteway_div').show();

                    $('#gu_geteway_div').show();
                    $('#vt_guest_def').show();

                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('pr_gateway_type', true);
                    bootstrapValidator.enableFieldValidators('gateway_type', true);
                    <?php if (array_key_exists('vt_QOS_def', $field_array) || $package_features == "all") { ?>
                        bootstrapValidator.enableFieldValidators('vt_guest_def', true);
                    <?php } ?>
                    break;
                }
            }
        }


        /* $('#network_type').bind('change',function(){

                    });
*/
        function changeContentFilterArea(gateway) {
            var bootstrapValidator = $('#location_form').data('bootstrapValidator');
            gateway = gateway.toLowerCase();
            switch (gateway) {
                case 'wag': {
                    <?php if ($field_array['ne_WAG'] == "mandatory") { ?>
                        $('#wag_name').prop('required', true);
                        $('#gateway').show();
                        //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                        bootstrapValidator.enableFieldValidators('wag_name', true);
                        break;
                    <?php } ?>
                }
                default: {
                    $('#wag_name').prop('required', false);
                    $('#gateway').hide();
                    //var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    bootstrapValidator.enableFieldValidators('wag_name', false);

                    break;
                }
            }

        }
    </script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
    <script src="js/select2-3.5.2/select2.min.js"></script>
    <script src="js/bootstrap-colorpicker.js?v=6"></script>
    <script type="text/javascript" src="plugins/img_upload/croppic.js?v=4"></script>
    <script>
        $(document).ready(function() {
            $('#primary_div').colorpicker({
                color: '<?php if ($mno_edit == 1) {
                            echo $get_mno_primary_color;
                        } else {
                            echo "#333";
                        } ?>',
                useAlpha: false,
                align: 'left',

            });
            $('#secondary_div').colorpicker({
                color: '<?php if ($mno_edit == 1) {
                            echo $get_mno_secondary_color;
                        } else {
                            echo "#333";
                        } ?>',
                useAlpha: false,
                align: 'left'
            });
        });

        function UploadImg(that, parent, output, type) {

            var img_id = $('#' + output).val();
            var id2 = img_id.split('_');

            if (id2[0].toLowerCase() == 'default') {
                img_id = '';
            } else {
                img_id = img_id;
            }
            console.log(img_id);
            $.ajax({
                type: 'POST',
                url: 'ajax/ajax_delete_img.php',
                data: 'img_id=' + img_id
            });

            var name = that.files[0].name;

            if (name.length == 0) {
                return false;
            }

            var form_data = new FormData();
            form_data.append("file", that.files[0]);
            form_data.append("type", type);
            form_data.append("discode", '<?php echo $user_distributor; ?>');

            $.ajax({
                url: "ajax/ajaxthemeimage.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('#' + parent).append('<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>');

                },
                success: function(data) {
                    $('#' + parent + ' .loader.bubblingG').remove();
                    var respo = JSON.parse(data);
                    if (respo.status_code == '200') {
                        $('#' + parent + ' img.croppedImg').remove();
                        $('#' + parent).append('<img class="croppedImg" src="' + respo.response.srcdata + '">');
                        $('#' + output).val(respo.response.img_name);

                        if (type == 'theme_img_background') {
                            $('#background_img_check').val('1');
                        }

                    } else {
                        alert(respo.response);
                    }
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            <?php if (isset($field_array['content_filter_dns'])) { ?>
                /*var add_ap_form_validator1 = $('#location_form').data('bootstrapValidator');
         add_ap_form_validator1.enableFieldValidators('DNS_profile', false);*/
            <?php } ?>

        });
    </script>


    <script type="text/javascript">
        function enableRealmGroups() {
            var add_location_form_validator = $('#location_form').data('bootstrapValidator');
            var select_network_typeArr = Array();
            var select_network_typeArr = $('#network_type').val();
            var old_network_type = $('#old_network_type').val();
            var select_network_type = '';

            if (select_network_typeArr != null) {

                if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    select_network_type = 'VT-BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("PRIVATE") >= 0)) {
                    select_network_type = 'BOTH';
                } else if ((select_network_typeArr.indexOf("GUEST") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    select_network_type = 'VT-GUEST';
                } else if ((select_network_typeArr.indexOf("PRIVATE") >= 0) && (select_network_typeArr.indexOf("VT") >= 0)) {
                    select_network_type = 'VT-PRIVATE';
                } else if (select_network_typeArr.indexOf("PRIVATE") >= 0) {
                    select_network_type = 'PRIVATE';
                } else if (select_network_typeArr.indexOf("GUEST") >= 0) {
                    select_network_type = 'GUEST';
                } else if (select_network_typeArr.indexOf("VT") >= 0) {
                    select_network_type = 'VT';
                } else {

                }

            }
            validateDNS();

            //console.log(select_network_type);
            //$user_type == 'SUPPORT'
            var create_prop = $('#create_property').length;


            <?php
            if ($edit_account != '1') { ?>

                if (create_prop != 0) {

                    if (select_network_type == 'VT') {
                        $('#vt_icomme_div').show();
                        $('#icomme_div').hide();
                        $('#icomme').val('');
                        //$('select#vt_icomme option').removeAttr("selected");
                        try {
                            $('#location_form').bootstrapValidator('revalidateField', 'icomme');
                        } catch (e) {

                        }
                        add_location_form_validator.enableFieldValidators('icomme', false);
                        add_location_form_validator.enableFieldValidators('vt_icomme', true);

                    } else if (select_network_type == 'VT-GUEST' || select_network_type == 'VT-PRIVATE' || select_network_type == 'VT-BOTH') {
                        $('#vt_icomme_div').show();
                        $('#icomme_div').show();
                        $('#icomme').val('');
                        //$('select#vt_icomme option').removeAttr("selected");
                        add_location_form_validator.enableFieldValidators('icomme', true);
                        add_location_form_validator.enableFieldValidators('vt_icomme', true);
                        try {
                            $('#location_form').bootstrapValidator('revalidateField', 'icomme');
                        } catch (e) {

                        }

                    } else {
                        $('#vt_icomme_div').hide();
                        $('#icomme_div').show();
                        $('select#vt_icomme option').removeAttr("selected");
                        add_location_form_validator.enableFieldValidators('icomme', true);
                        add_location_form_validator.enableFieldValidators('vt_icomme', false);
                        //$('#icomme').val('');
                        try {
                            $('#location_form').bootstrapValidator('revalidateField', 'vt_icomme');
                        } catch (e) {

                        }


                    }
                }

            <?php } else {
            ?>

                if (select_network_type == 'VT') {
                    $('#vt_icomme_div').show();
                    $('#icomme_div').hide();
                    add_location_form_validator.enableFieldValidators('icomme', false);
                    add_location_form_validator.enableFieldValidators('vt_icomme', false);

                } else if (select_network_type == 'VT-GUEST' || select_network_type == 'VT-PRIVATE' || select_network_type == 'VT-BOTH') {
                    $('#vt_icomme_div').show();
                    $('#icomme_div').show();
                    add_location_form_validator.enableFieldValidators('icomme', true);
                    add_location_form_validator.enableFieldValidators('vt_icomme', true);

                    if (old_network_type == 'VT') {
                        document.getElementById("icomme").readOnly = false;
                    }
                } else {
                    $('#vt_icomme_div').hide();
                    $('#icomme_div').show();
                    add_location_form_validator.enableFieldValidators('icomme', false);
                    add_location_form_validator.enableFieldValidators('vt_icomme', false);

                    if (old_network_type == 'VT') {
                        document.getElementById("icomme").readOnly = false;
                    }

                    if (select_network_type == 'GUEST' || select_network_type == 'PRIVATE' || select_network_type == 'PUBLIC' || select_network_type == 'BOTH' || select_network_type == 'PUBLIC-PRIVATE') {
                        $("div").removeClass("sele-disable");

                    }

                }
            <?php
            } ?>
        }

        $(document).ready(function() {

            <?php if ($user_type != 'ADMIN') { ?>

                enableRealmGroups();

            <?php } ?>
        });
    </script>

    <script>
        function fillrealm(val) {
            if (!$('#icomme').is(":visible")) {
                $('#realm').val($(val).val());
            }
        }
    </script>
    <?php if (isset($edit_distributor_zone_id) && empty($edit_distributor_zone_name)) { ?>
        <script>
            $(document).ready(function() {
                $("#location_form").data("bootstrapValidator").updateStatus('zone', 'NOT_VALIDATED').validateField("zone");
            });
        </script>
    <?php }
    if ($field_array['content_filter_dns'] == 'mandatory') {
    ?>

        <script>
            $(document).ready(function() {
                dns_control();
            });
        </script>

    <?php } ?>

    <script type="text/javascript">
        function customProduct(selectObject) {
            var value = selectObject.value;
            if (value == 'DYNAMIC_MNO_001') {
                enableCustomProduct();
            } else {
                disableCustomProduct();
            }
        }

        function enableCustomProduct() {
            $('#custom_product_fields').show();
        }

        function disableCustomProduct() {
            $('#custom_product_fields').hide();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.tooltips').tooltipster({
                contentAsHTML: true,
                maxWidth: 350

            });
        });
    </script>
    </body>

</html> 