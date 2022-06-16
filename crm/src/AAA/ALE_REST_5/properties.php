<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include 'header_top.php';

//require_once('db/config.php');

/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';


/*classes & libraries*/
require_once 'classes/dbClass.php';
$db_class = new db_functions();
$db = new db_functions();
?>


<head>
    <meta charset="utf-8">
    <title>Your Properties</title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">

    <link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/formValidation.css">


    <!--Alert message css-->
    <link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css"/>

    <!-- tool tip css -->
    <link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css"/>
    <link rel="stylesheet" type="text/css" href="css/tooltipster.css"/>

    <!--toggle column-->
    <link rel="stylesheet" href="css/tablesaw.css">


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- tool tip js -->
    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>


    <style>
        .disabled {
            background-color: #eee;
            color: #aaa;
            cursor: text;
        }

        h1.head {
            padding: 60px !important;
        }
    </style>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!--table colimn show hide-->
    <script type="text/javascript" src="js/tablesaw.js"></script>
    <script type="text/javascript" src="js/tablesaw-init.js"></script>


    <?php

    //require_once('db/config.php');
    require_once 'classes/systemPackageClass.php';

    include 'header.php';
    // TAB Organization
    setcookie("system_package", $system_package, time() + (86400 * 30), "/");
    setcookie("load_login_design", $login_design, time() + (86400 * 30), "/");
    if (isset($_GET['t'])) {

        $variable_tab = 'tab' . $_GET['t'];
        $$variable_tab = 'set';

    } else {
        //initially page loading///

        $tab1 = "set";

    }

    $package_functions = new package_functions();

    $url_mod_override = $db_class->setVal('url_mod_override', 'ADMIN');

    function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function userUpdateLog($user_id, $action_type, $action_by)
    {
    }

    $mno_system_package = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");

    $json_fields = $package_functions->getOptions('VENUE_ACC_CREAT_FIELDS', $mno_system_package);

    $field_array = json_decode($json_fields, true);


    if (isset($_POST['submit_user']) || isset($_POST['edit_user_manage'])) {

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {

            $ed_de_user_id = $_POST['ed_user_id'];
            $ed_de_distributor_code = $_POST['ed_distributor_code'];
            $ed_de_first_name = $db_class->escapeDB($_POST['ed_first_name']);
            $ed_de_last_name = $db_class->escapeDB($_POST['ed_last_name']);
            $ed_de_user_email = $db_class->escapeDB($_POST['ed_ad_email']);
            $ed_de_verification_number = $_POST['ed_verification_number'];
            $mno_id_new = $_POST['ed_mno'];
            if (empty($mno_id_new)) {
                //$mno_id = $mno_id;
            } else {
                $mno_id = $mno_id_new;
            }
            $mvnx_full_name = $ed_de_first_name . " " . $ed_de_last_name;
            $user_type1 = "MVNO";
            $customer_type = trim($_POST['customer_type']);

            if (isset($_POST['edit_user_manage'])) {
                $mobile_1 = $db_class->escapeDB($_POST['mobile_2']);
            } else {
                $mobile_1 = $db_class->escapeDB($_POST['mobile_1']);
            }
            //$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_mno_distributor'");
            //$rowe = mysql_fetch_array($br);
            //$auto_inc = $rowe['Auto_increment'];
            // $mvnx_id = $user_type1 . $auto_inc;
            ///$mvnx = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
            ///$unique_id = '2' . $mvnx;

            $q = "SELECT email,verification_number AS f FROM admin_users WHERE id='$ed_de_user_id'";
            $old_property = $db_class->select1DB($q);
            $old_property_email = $old_property['email'];
            $verify_number = $old_property['f'];

            if ($old_property_email != $ed_de_user_email) {
                //$br = mysql_query("SHOW TABLE STATUS LIKE 'admin_users'");
                //$rowe = mysql_fetch_array($br);
                //$auto_inc = $rowe['Auto_increment'];

                $dis_user_name = uniqid(str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u')));


                $password = randomPassword();

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

                $ex3 = $db_class->execDB($query_admin_user_archive);

                if ($ex3===true) {
                    $query02 = "UPDATE  `admin_users` SET is_enable='2',`user_name`='$dis_user_name',`password`=PASSWORD('$password'),mobile='$mobile_1', `full_name`='$mvnx_full_name', `email`='$ed_de_user_email' WHERE id='$ed_de_user_id'";
                    $ex_query02 = $db_class->execDB($query02);
                }

                /*Email Notification*/

                $to = $ed_de_user_email;
                $title = $db_class->setVal("short_title", $mno_id);
                /*$subject = $db_class->textTitle('ICOMMS_MAIL_SUB', $mno_id);
                if (strlen($subject) == 0) {
                    $subject = $db_class->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
                }*/
                $from = strip_tags($db_class->setVal("email", $mno_id));
                if ($from == '') {
                    $from = strip_tags($db_class->setVal("email", 'ADMIN'));
                }

                $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
                $link = $db_class->getSystemURL('verification', $login_design);

                $system_package1 = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");


                $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
                $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $customer_type);
                if (empty($verify_number)) {
                    $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN_USER', $system_package1, 'MNO', $mno_id);
                } else {
                    $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN', $system_package1, 'MNO', $mno_id);
                }

                $a = $email_content[0]['text_details'];
                $subject = $email_content[0]['title'];

                $vars = array(
                    '{$user_full_name}' => $mvnx_full_name,
                    '{$short_name}' => $db_class->setVal("short_title", $mno_id),
                    '{$account_type}' => $user_type1,
                    '{$property_id}' => $ed_de_verification_number,
                    '{$user_name}' => $dis_user_name,
                    '{$support_number}' => $support_number,
                    '{$password}' => $password,
                    '{$link}' => $link
                );


                $message_full = strtr($a, $vars);
                $message = $db_class->escapeDB($message_full);


                if ($ex_query02===true) {


                    /*echo $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
	 	VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";*/

                    //$rrr = mysql_query($qu);
                    $rrr = $db_class->insertData('admin_invitation_email',[
                            "password_re"=>$password,
                            "to"=>$to,
                            "subject"=>$subject,
                            "message"=>$message,
                            "distributor"=>$mvnx_id,
                            "user_name"=>$dis_user_name,
                            "create_date"=>['SQL'=>'NOW()'],
                        ]
                    );

                    // $package_functions->getSectionType('VENUE_ACTIVATION_TYPE',$system_package1);

                    if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package1) == "ICOMMS NUMBER" || $package_features == "all") {


                        $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package1);
                        include_once 'src/email/' . $email_send_method . '/index.php';

                        //email template
                        /*$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package1);
                        $cunst_var = array();
                        if ($emailTemplateType == 'child') {
                            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                        } elseif ($emailTemplateType == 'owen') {
                            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                        } elseif (strlen($emailTemplateType) > 0) {
                            $cunst_var['template'] = $emailTemplateType;
                        } else {
                            $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                        }*/
                        $cunst_var['system_package'] = $system_package;
                        $cunst_var['mno_package'] = $system_package1;
                        $cunst_var['mno_id'] = $mno_id;

                        //echo "SELECT is_enable as f FROM admin_users WHERE verification_number='$ed_de_verification_number'";
                        //$acc_enabel=$db_class->getValueAsf("SELECT is_enable as f FROM admin_users WHERE verification_number='$ed_de_verification_number'");

                        $mail_obj = new email($cunst_var);

                        //if($acc_enabel == '2'){
                        $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
                        //}
                    }

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

                $ex3 = $db_class->execDB($query_admin_user_archive);

                $query02 = "UPDATE `admin_users` SET mobile='$mobile_1', `full_name`='$mvnx_full_name' WHERE  id='$ed_de_user_id'";


                $ex_query02 = $db_class->execDB($query02);
            }

            if ($ex_query02===true) {


                $properties_edit_success = $message_functions->showMessage('properties_edit_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('properties_edit_error');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }
        }
    } else if (isset($_POST['submit_user_manage'])) {

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret5']) {

            $ed_de_first_name = $db_class->escapeDB($_POST['ed_first_name']);
            $ed_de_last_name = $db_class->escapeDB($_POST['ed_last_name']);
            $ed_de_user_email = $db_class->escapeDB($_POST['ed_ad_email']);
            //$ed_de_verification_number = $_POST['ed_verification_number'];
            // $ed_de_verification_number = null;

            $mvnx_full_name = $ed_de_first_name . " " . $ed_de_last_name;
            $user_type1 = "MVNO";
            $ed_verification_no = $db_class->escapeDB($_POST['ed_property_id']);
            $mobile_1 = $db_class->escapeDB($_POST['mobile_2']);

            $ed_de_distributor_code = $db_class->getValueAsf("SELECT `distributor_code` AS f FROM `exp_mno_distributor` WHERE `verification_number` ='$ed_verification_no'");


            $rowe = $db_class->select1DB("SHOW TABLE STATUS LIKE 'admin_users'");
            //$rowe = mysql_fetch_array($br);
            $auto_inc = $rowe['Auto_increment'];

            $dis_user_name = str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u' . $auto_inc));


            $password = randomPassword();

            $q0 = "SELECT a.`is_enable`,a.`id`,a.user_name
                        FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
                        WHERE parent_id='$user_distributor' AND a.`verification_number` IS NOT NULL AND d.verification_number='$ed_verification_no'";
            $query12 = $db_class->selectDB($q0);
            
            foreach ($query12['data'] AS $row) {
                $is_enable = $row[is_enable];
                $user_id = $row[id];
                $top_user = $row['user_name'];

            }


            if ($is_enable == '8') {
                $dis_user_name = $top_user;
                $query02 = "UPDATE admin_users SET is_enable='2',`password`=PASSWORD('$password'),full_name='" . $mvnx_full_name . "',email='" . $ed_de_user_email . "',mobile='" . $mobile_1 . "' WHERE id='$user_id'";
            } else {
                $query02 = "INSERT INTO `admin_users` (`user_name`,`password`,mobile, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `is_enable`, `create_date`)
                    VALUES ('$dis_user_name',PASSWORD('$password'),'$mobile_1', 'admin', 'MVNO','$ed_de_distributor_code', '$mvnx_full_name', '$ed_de_user_email', '2', NOW())";
            }


            $ex_query02 = $db_class->execDB($query02);


            /*Email Notification*/

            $to = $ed_de_user_email;
            $title = $db_class->setVal("short_title", $mno_id);

            $from = strip_tags($db_class->setVal("email", $mno_id));
            if ($from == '') {
                $from = strip_tags($db_class->setVal("email", 'ADMIN'));
            }


            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
            $link = $db_class->getSystemURL('login', $login_design);

            $system_package1 = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");


            $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN_USER', $system_package1, 'MNO', $mno_id);

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];

            $vars = array(
                '{$user_full_name}' => $mvnx_full_name,
                '{$short_name}' => $db_class->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$property_id}' => $ed_de_verification_number,
                '{$user_name}' => $dis_user_name,
                '{$password}' => $password,
                '{$link}' => $link
            );


            $message_full = strtr($a, $vars);
            $message = $db_class->escapeDB($message_full);


            if ($ex_query02 === true) {


                $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
                 VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                $rrr = $db_class->execDB($qu);


                if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package1) == "ICOMMS NUMBER" || $package_features == "all") {


                    $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package1);
                    include_once 'src/email/' . $email_send_method . '/index.php';

                    //email template
                    /*$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package1);
                    $cunst_var = array();
                    if ($emailTemplateType == 'child') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif ($emailTemplateType == 'owen') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    } elseif (strlen($emailTemplateType) > 0) {
                        $cunst_var['template'] = $emailTemplateType;
                    } else {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    }*/
                    $cunst_var['system_package'] = $system_package;
                    $cunst_var['mno_package'] = $system_package1;
                    $cunst_var['mno_id'] = $mno_id;


                    //$acc_enabel = $db_class->getValueAsf("SELECT is_enable as f FROM admin_users WHERE verification_number='$ed_de_verification_number'");

                    $mail_obj = new email($cunst_var);

                    //if ($acc_enabel == '2') {
                        $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
                    //}
                }

            }


            if ($ex_query02 === true) {


                $properties_edit_success = $message_functions->showMessage('properties_edit_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('properties_edit_error');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }
        }
    } //edt Property Admin
    elseif (isset($_GET['ed_a'])) {


        $dis_id = $_GET['ed_a'];

        $query_ed_v = "SELECT d.`distributor_name`,d.`property_id`,a.`user_name`,a.`full_name`,a.`id` AS uid,a.`email`,a.mobile,d.`distributor_code`,d.`verification_number`,d.`mno_id`,d.`system_package` 
     FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor WHERE d.`id`='$dis_id'";

        $ed_result = $db_class->select1DB($query_ed_v);
        //if ($ed_result = mysql_fetch_array($query_ex_ed)) {

            $get_edit_fulname = $ed_result['full_name'];

            $get_ful_name_array = explode(' ', $get_edit_fulname, 2);
            $get_edit_first_name = $get_ful_name_array[0];
            $get_edit_last_name = $get_ful_name_array[1];

            $get_edit_propertyid = $ed_result['property_id'];
            $get_edit_distributor_name = $ed_result['distributor_name'];
            $get_edit_email = $ed_result['email'];
            $get_ad_id = $ed_result['uid'];
            $get_distributor_code = $ed_result['distributor_code'];
            $get_verification_number = $ed_result['verification_number'];
            $get_mno_id = $ed_result['mno_id'];
            $get_customer_type = $ed_result['system_package'];
            $get_edit_phone = $ed_result['mobile'];

        //}

    }//

//edt Property Admin manage
    elseif (isset($_GET['property_ed_a'])) {

        $dis_id = $_GET['property_ed_a'];

        $query_ed_v = "SELECT d.`distributor_name`,d.`property_id`,a.`user_name`,a.`full_name`,a.`id` AS uid,a.`email`,a.mobile,d.`distributor_code`,d.`verification_number`,d.`mno_id`,d.`system_package` 
     FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor WHERE a.`id`='$dis_id'";

        $ed_result = $db_class->select1DB($query_ed_v);
        //if ($ed_result = mysql_fetch_array($query_ex_ed)) {

            $pr_get_edit_fulname = $ed_result['full_name'];

            $pr_get_ful_name_array = explode(' ', $pr_get_edit_fulname, 2);
            $pr_get_edit_first_name = $pr_get_ful_name_array[0];
            $pr_get_edit_last_name = $pr_get_ful_name_array[1];

            $pr_get_edit_propertyid = $ed_result['property_id'];
            $pr_get_edit_distributor_name = $ed_result['distributor_name'];
            $pr_get_edit_email = $ed_result['email'];
            $pr_get_ad_id = $ed_result['uid'];
            $pr_get_distributor_code = $ed_result['distributor_code'];
            $pr_get_verification_number = $ed_result['verification_number'];
            $pr_get_mno_id = $ed_result['mno_id'];
            $pr_get_customer_type = $ed_result['system_package'];
            $pr_get_edit_phone = $ed_result['mobile'];

        //}

    } //edt Property Admin manage
    elseif (isset($_GET['edit_business_id'])) {


        $dis_id = $_GET['edit_business_id'];

        $query_ed_v = "SELECT a.`user_name`,a.`full_name`,a.`id` AS id,a.`email`,a.mobile FROM  `admin_users` a  WHERE a.`id`='$dis_id'";

        $ed_result = $db_class->select1DB($query_ed_v);
        //if ($ed_result = mysql_fetch_array($query_ex_ed)) {

            $b_get_edit_fulname = $ed_result['full_name'];

            $b_get_ful_name_array = explode(' ', $pr_get_edit_fulname, 2);
            $b_get_edit_first_name = $pr_get_ful_name_array[0];
            $pr_get_edit_last_name = $pr_get_ful_name_array[1];

            $b_get_edit_propertyid = $ed_result['property_id'];
            $b_get_edit_distributor_name = $ed_result['distributor_name'];
            $b_get_edit_email = $ed_result['email'];
            $b_get_ad_id = $ed_result['id'];
            $b_get_distributor_code = $ed_result['distributor_code'];
            $b_get_verification_number = $ed_result['verification_number'];
            $b_get_mno_id = $ed_result['mno_id'];
            $b_get_customer_type = $ed_result['system_package'];
            $b_get_edit_phone = $ed_result['mobile'];

        //}

    }

    //Remove Property Admins
    if (isset($_GET['property_rm_a'])) {
        if ($_SESSION['FORM_SECRET'] == $_GET['tokene']) {

            $user_id = $_GET['property_rm_a'];

            $dis_username = $_GET['unassign_a'];

            $check_q = "SELECT verification_number,user_distributor FROM admin_users WHERE id='$user_id'";
            $verify_number = $db_class->select1DB($check_q);
            $ex_query = false;
            if (empty($verify_number['verification_number'])) {
                $query_rm = "DELETE FROM admin_users WHERE id='$user_id'";
                $ex_query = $db_class->execDB($query_rm);
            } else {
                $get_all_users_q = "SELECT user_name FROM admin_users WHERE user_distributor='$verify_number[user_distributor]'";

                $all_users = $db_class->selectDB($get_all_users_q);
                if($all_users['rowCount']>1){
                    //$db_class->execDB("START TRANSACTION");
                    $db_class->autoCommit();
                    $query_rm = "DELETE FROM admin_users WHERE id='$user_id'";
                    $rm = $db_class->execDB($query_rm);
                    if($rm === true){
                        $query_rm = "UPDATE admin_users SET verification_number='$verify_number[verification_number]' WHERE user_distributor='$verify_number[user_distributor]' LIMIT 1";
                        $ex_query = $db_class->execDB($query_rm);
                        if($ex_query === true){
                            //$db_class->execDB("COMMIT");
                            $db_class->commit();
                        }
                    }else{
                        //$db_class->execDB("ROLLBACK");
                        $db_class->rollback();
                    }

                }elseif ($all_users['rowCount']==1){
                    $query_rm = "UPDATE admin_users SET is_enable='8' , full_name='',email='',mobile='' WHERE id='$user_id'";
                    $ex_query = $db_class->execDB($query_rm);
                }
            }


            //$ex_query = mysql_query($query_rm);
            if ($ex_query === true) {
                $properties_edit_success = $message_functions->showMessage('property_admin_remove_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('property_admin_remove_failed');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }


        }
    }

    //edit Business ID Admins
    if (isset($_POST['update_business_admin'])) {

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret6']) {
            $ed_de_full_name = $db_class->escapeDB($_POST['full_name_1']);

            $ed_de_user_email = $db_class->escapeDB($_POST['email_1']);

            $user_type1 = "MVNO_ADMIN";
            $loation = $db_class->escapeDB($_POST['loation']);
            $mobile_1 = $db_class->escapeDB($_POST['mobile_1']);
            $user_id = $db_class->escapeDB($_POST['user_idn']);
            $ed_de_distributor_code = $loation;


            $q = "SELECT email,verification_number AS f FROM admin_users WHERE id='$user_id'";
            $old_property = $db_class->select1DB($q);
            $old_property_email = $old_property['email'];
            $verify_number = $old_property['f'];

            if ($old_property_email != $ed_de_user_email) {
                $dis_user_name = uniqid(str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u')));
                $password = randomPassword();

                $to = $ed_de_user_email;
                $title = $db_class->setVal("short_title", $mno_id);

                $from = strip_tags($db_class->setVal("email", $mno_id));
                if ($from == '') {
                    $from = strip_tags($db_class->setVal("email", 'ADMIN'));
                }
                $query_edit = "UPDATE admin_users SET is_enable='2',`user_name`='$dis_user_name',`password`=PASSWORD('$password'),full_name='" . $ed_de_full_name . "',email='" . $ed_de_user_email . "',mobile='" . $mobile_1 . "' WHERE id='$user_id'";
                $ex_query = $db_class->execDB($query_edit);

                $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
                $link = $db_class->getSystemURL('login', $login_design);

                $system_package1 = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");

                $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN_USER', $system_package1, 'MNO', $mno_id);

                $a = $email_content[0]['text_details'];
                $subject = $email_content[0]['title'];

                $vars = array(
                    '{$user_full_name}' => $mvnx_full_name,
                    '{$short_name}' => $db_class->setVal("short_title", $mno_id),
                    '{$account_type}' => $user_type1,
                    '{$property_id}' => $ed_de_verification_number,
                    '{$user_name}' => $dis_user_name,
                    '{$password}' => $password,
                    '{$link}' => $link
                );


                $message_full = strtr($a, $vars);
                $message = $db_class->escapeDB($message_full);

                if ($ex_query === true) {
                    $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
                 VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                    $rrr = $db_class->execDB($qu);


                    $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package1);
                    include_once 'src/email/' . $email_send_method . '/index.php';

                    //email template
                    /*$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package1);
                    $cunst_var = array();
                    if ($emailTemplateType == 'child') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif ($emailTemplateType == 'owen') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    } elseif (strlen($emailTemplateType) > 0) {
                        $cunst_var['template'] = $emailTemplateType;
                    } else {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    }*/
                    $cunst_var['system_package'] = $system_package;
                    $cunst_var['mno_package'] = $system_package1;
                    $cunst_var['mno_id'] = $mno_id;


                    $mail_obj = new email($cunst_var);


                    $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                }
            } else {
                $query_edit = "UPDATE admin_users SET full_name='" . $ed_de_full_name . "',email='" . $ed_de_user_email . "',mobile='" . $mobile_1 . "' WHERE id='$user_id'";

                $ex_query = $db_class->execDB($query_edit);

            }

            if ($ex_query === true) {
                $properties_edit_success = $message_functions->showMessage('bussinus_admin_update_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('bussinus_admin_update_failed');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }


        }
    }

    //Remove Business ID Admins
    if (isset($_GET['remove_business_admin'])) {
        if ($_SESSION['FORM_SECRET'] == $_GET['token']) {

            $user_id = $_GET['remove_business_admin'];

            $query_rm = "DELETE FROM admin_users WHERE id='$user_id'";

            $ex_query = $db_class->execDB($query_rm);
            if ($ex_query === true) {
                $properties_edit_success = $message_functions->showMessage('bussinus_admin_remove_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('bussinus_admin_remove_failed');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }


        }
    }


    //create Business ID Admins
    if (isset($_POST['create_business_admin'])) {

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret6']) {

            $ed_de_full_name = $db_class->escapeDB($_POST['full_name_1']);

            $ed_de_user_email = $db_class->escapeDB($_POST['email_1']);
            //$ed_de_verification_number = $_POST['ed_verification_number'];
            // $ed_de_verification_number = null;


            $user_type1 = "MVNO_ADMIN";
            $loation = $db_class->escapeDB($_POST['loation']);
            $mobile_1 = $db_class->escapeDB($_POST['mobile_1']);

            $ed_de_distributor_code = $loation;


            $rowe = $db_class->select1DB("SHOW TABLE STATUS LIKE 'admin_users'");
            //$rowe = mysql_fetch_array($br);
            $auto_inc = $rowe['Auto_increment'];

            $dis_user_name = str_replace(' ', '_', strtolower(substr($ed_de_first_name, 0, 5) . 'u' . $auto_inc));


            $password = randomPassword();


            $query02 = "INSERT INTO `admin_users` (`user_name`,`password`,mobile, `access_role`, `user_type`, `user_distributor`, `full_name`, `email`, `is_enable`, `create_date`,`create_user`)
                    VALUES ('$dis_user_name',PASSWORD('$password'),'$mobile_1', 'admin', 'MVNO_ADMIN','$ed_de_distributor_code', '$ed_de_full_name', '$ed_de_user_email', '2', NOW(),'$user_name')";


            $ex_query02 = $db_class->execDB($query02);


            /*Email Notification*/

            $to = $ed_de_user_email;
            $title = $db_class->setVal("short_title", $mno_id);

            $from = strip_tags($db_class->setVal("email", $mno_id));
            if ($from == '') {
                $from = strip_tags($db_class->setVal("email", 'ADMIN'));
            }


            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
            $link = $db_class->getSystemURL('login', $login_design);

            $system_package1 = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");


            $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN_USER', $system_package1, 'MNO', $mno_id);

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];

            $vars = array(
                '{$user_full_name}' => $ed_de_full_name,
                '{$short_name}' => $db_class->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$property_id}' => $ed_de_verification_number,
                '{$user_name}' => $dis_user_name,
                '{$password}' => $password,
                '{$link}' => $link
            );


            $message_full = strtr($a, $vars);
            $message = $db_class->escapeDB($message_full);


            if ($ex_query02 === true) {


                $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
                 VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
                $rrr = $db_class->execDB($qu);


                if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package1) == "ICOMMS NUMBER" || $package_features == "all") {


                    $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package1);
                    include_once 'src/email/' . $email_send_method . '/index.php';

                    //email template
                    /*$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package1);
                    $cunst_var = array();
                    if ($emailTemplateType == 'child') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
                    } elseif ($emailTemplateType == 'owen') {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    } elseif (strlen($emailTemplateType) > 0) {
                        $cunst_var['template'] = $emailTemplateType;
                    } else {
                        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                    }*/
                    $cunst_var['system_package'] = $system_package;
                    $cunst_var['mno_package'] = $system_package1;
                    $cunst_var['mno_id'] = $mno_id;


                    $mail_obj = new email($cunst_var);


                    $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

                }

            }


            if ($ex_query02 === true) {


                $properties_edit_success = $message_functions->showMessage('bussinus_admin_create_success');

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showMessage('bussinus_admin_create_failed');
                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";

            }
        }
    } //remove Property Admin
    elseif (isset($_GET['unassign_a'])) {


        $dis_username = $_GET['unassign_a'];

        $check_q = "SELECT verification_number,user_distributor FROM admin_users WHERE user_name='$dis_username'";
        $verify_number = $db_class->select1DB($check_q);

        $get_all_users_q = "SELECT user_name,verification_number FROM admin_users WHERE user_distributor='$verify_number[user_distributor]'";

        $all_users = $db_class->selectDB($get_all_users_q);

        //$db_class->execDB("START TRANSACTION");
        $db_class->autoCommit();
        $success= true;

        foreach ($all_users['data'] as $row){

            if(!$success){
                continue;
            }
            if (empty($row['verification_number'])) {
                $query_rm_v = "DELETE FROM admin_users WHERE user_name='$row[user_name]'";
            } else {
                $query_rm_v = "UPDATE admin_users SET is_enable='8' , full_name='',email='',mobile='' WHERE user_name='$row[user_name]'";
            }
            //echo $query_rm_v;
            $query_ex_rm = $db_class->execDB($query_rm_v);
            if ($query_ex_rm !== true){
                $success= false;
            }
        }


        if ($success) {
            //$db_class->execDB("COMMIT");
            $db_class->commit();
            $properties_edit_success = $message_functions->showMessage('properties_remove_success');

            $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
        } else {
            //$db_class->execDB("ROLLBACK");
            $db_class->rollback();
            $properties_edit_error = $message_functions->showMessage('properties_remove_error', '2002');

            $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";
        }

    }//


//resend Property Admin invitation email
    elseif (isset($_GET['e_resend_a'])) {
        if ($_SESSION['FORM_SECRET'] == $_GET['tokene']) {
            $resend_username = $_GET['e_resend_a'];

            $q = "SELECT u.email,u.full_name,u.user_type,u.verification_number,d.mno_id,d.system_package FROM admin_users u LEFT JOIN exp_mno_distributor d ON u.user_distributor=d.distributor_code WHERE u.user_name='$resend_username'";
            $r = $db_class->selectDB($q);
            
            foreach ($r['data'] AS $row) {
                $re_user_email = $row['email'];
                $mno_id = $row['mno_id'];
                $mvnx_full_name = $row['full_name'];
                $user_system_package = $row['system_package'];
                $user_type1 = $row['user_type'];
                $resend_verification_number = $row['verification_number'];
            }

            /*Email Notification*/

            $to = $re_user_email;
            $title = $db_class->setVal("short_title", $mno_id);
            /*$subject = $db_class->textTitle('ICOMMS_MAIL_SUB', $mno_id);
            if (strlen($subject) == 0) {
                $subject = $db_class->textTitle('ICOMMS_MAIL_SUB', 'ADMIN');
            }*/
            $from = strip_tags($db_class->setVal("email", $mno_id));
            if ($from == '') {
                $from = strip_tags($db_class->setVal("email", 'ADMIN'));
            }


            /*if($url_mod_override=='ON'){
                //http://216.234.148.168/campaign_portal_demo/optimum/verification
                $link = $db_class->setVal("global_url", "ADMIN").'/'.$package_functions->getSectionType("LOGIN_SIGN", $system_package).'/verification';
            }else{

                $link = $db_class->setVal("global_url", "ADMIN") . '/verification_login.php?new_signin&login='.$package_functions->getSectionType('LOGIN_SIGN',$system_package);
            }*/

            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
            $link = $db_class->getSystemURL('verification', $login_design);

            $system_package1 = $db_class->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");
            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $user_system_package);

            /*$a = $db_class->textVal('ICOMMS_MAIL_SUB', $mno_id);

            if (strlen($a) == 0) {
                $a = $db_class->textVal('ICOMMS_MAIL_SUB', 'ADMIN');
            }*/

            $email_content = $db_class->getEmailTemplate('VENUE_ADD_ADMIN', $system_package1, 'MNO', $mno_id);

            $a = $email_content[0]['text_details'];
            $subject = $email_content[0]['title'];

            $vars = array(
                '{$user_full_name}' => $mvnx_full_name,
                '{$short_name}' => $db_class->setVal("short_title", $mno_id),
                '{$account_type}' => $user_type1,
                '{$property_id}' => $resend_verification_number,
                '{$user_name}' => $dis_user_name,
                '{$support_number}' => $support_number,
                '{$password}' => $password,
                '{$link}' => $link
            );


            $message_full = strtr($a, $vars);
            $message = $db_class->escapeDB($message_full);

            $qu = "INSERT INTO `admin_invitation_email` (`password_re`,`to`,`subject`,`message`,`distributor`,`user_name`, `create_date`)
	 	VALUES ('$password', '$to', '$subject', '$message', '$mvnx_id', '$dis_user_name', now())";
            $rrr = $db_class->execDB($qu);

            // $package_functions->getSectionType('VENUE_ACTIVATION_TYPE',$system_package1);

            if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package1) == "ICOMMS NUMBER" || $package_features == "all") {


                $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package1);
                include_once 'src/email/' . $email_send_method . '/index.php';

                //email template
                /*$emailTemplateType = $package_functions->getSectionType('EMAIL_TEMPLATE', $system_package1);
                $cunst_var = array();
                if ($emailTemplateType == 'child') {
                    $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                } elseif ($emailTemplateType == 'owen') {
                    $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                } elseif (strlen($emailTemplateType) > 0) {
                    $cunst_var['template'] = $emailTemplateType;
                } else {
                    $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package1);
                }
*/                $cunst_var['system_package'] = $system_package;
                $cunst_var['mno_package'] = $system_package1;
                $cunst_var['mno_id'] = $mno_id;
                $mail_obj = new email($cunst_var);


                $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);

            }

            if ($mail_sent == '1') {
                $properties_edit_success = $message_functions->showNameMessage('property_send_email_suceess', $mvnx_full_name);

                $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_success . "</strong></div>";
            } else {
                $properties_edit_error = $message_functions->showNameMessage('property_send_email_failed', $mvnx_full_name);

                $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $properties_edit_error . "</strong></div>";
            }

        }
    }//


    //Form Refreshing avoid secret key/////
    $secret = md5(uniqid(rand(), true));
    $_SESSION['FORM_SECRET'] = $secret;

    ?>


    <div class="main">
        <div class="custom-tabs"></div>
        <div class="main-inner">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="widget ">

                            <div class="widget-header">
                                <!-- <i class="icon-user"></i> -->
                                <h3 style="display: none;">Manage Your Location</h3>
                            </div>
                            <!-- /widget-header -->

                            <?php


                            /*if (isset($_SESSION['msg1'])) {
                                echo $_SESSION['msg1'];
                                unset($_SESSION['msg1']);


                            }*/


                            ?>

                            <div class="widget-content">


                                <div class="tabbable">


                                    <?php

                                    if ($new_design == 'yes') {

                                        $properties_inner = 'layout/' . $camp_layout . '/views/properties_inner.php';

                                        if (file_exists($properties_inner)) {
                                            include_once $properties_inner;
                                        }

                                    }
//print_r($features_array);
                                    ?>


                                    <ul class="nav nav-tabs newTabs">
                                        <?php if (in_array("PROPERTIES", $features_array) || $package_features == "all") { ?>
                                            <li class="  <?php if (isset($tab1)) { ?>active <?php } ?>"><a
                                                        href="#create_users" data-toggle="tab">Your Properties</a></li>
                                        <?php } else {
                                            if (!isset($_GET['t'])) {
                                                $tab2 = 'set';
                                                unset($tab1);
                                            }
                                        } ?>
                                        <?php if (in_array("PROPERTY_ADMIN", $features_array) || $package_features == "all") { ?>
                                            <li class="  <?php if (isset($tab2)) { ?>active <?php } ?>"><a
                                                        href="#manage_users" data-toggle="tab">Property Admins</a></li>
                                        <?php } else {
                                            if (!isset($_GET['t'])) {
                                                $tab3 = 'set';
                                                unset($tab2);
                                            }
                                        } ?>
                                        <?php if (in_array("PARENT_ADMIN", $features_array) || $package_features == "all") { ?>
                                            <li class="  <?php if (isset($tab3)) { ?>active <?php } ?>"><a
                                                        href="#business_id_users" data-toggle="tab">Business ID
                                                    Admins</a></li>
                                        <?php } else {
                                            if (!isset($_GET['t'])) {
                                                $tab4 = 'set';
                                                unset($tab3);
                                            }
                                        } ?>
                                    </ul>
                                    <br>


                                    <div class="tab-content">


                                        <!-- +++++++++++++++++++++++++++++ create users ++++++++++++++++++++++++++++++++ -->
                                        <div
                                            <?php if (isset($tab1)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
                                            id="create_users">
                                            <div id="response_d3">

                                            </div>

                                            <?php
                                              if(isset($tab1)){
                                                if (isset($_SESSION['msg1'])) {
                                                    echo $_SESSION['msg1'];
                                                    unset($_SESSION['msg1']);

                                                }
                                              }

                                            ?>

                                            <?php if (isset($_GET['ed_a'])) { ?>

                                                <div class="header2_part1 headName"><h2>Assign Property Administrator </h2></div>


                                                <p>Change the name and email to the person you want to assign as
                                                    property administrator and click the Assign button. The assigned
                                                    property administrator will receive an activation email with
                                                    instructions on how to activate the account. The assigned
                                                    administrator will log in to the property account using his or her
                                                    unique credentials. </p>
                                                <br><br>
                                                <form autocomplete="off" id="edit_profile" action="?t=1" method="post"
                                                      class="form-horizontal">

                                                    <fieldset>


                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Property
                                                                ID<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_property_id"
                                                                       name="ed_property_id" type="text"
                                                                       value="<?php echo $get_edit_propertyid; ?>"
                                                                       disabled>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>


                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Account Name
                                                                <sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_account_name"
                                                                       name="ed_account_name" type="text"
                                                                       value="<?php echo $get_edit_distributor_name; ?>"
                                                                       disabled>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <input id="ed_user_id" name="ed_user_id" type="hidden"
                                                               value="<?php echo $get_ad_id; ?>">
                                                        <input id="ed_distributor_code" name="ed_distributor_code"
                                                               type="hidden"
                                                               value="<?php echo $get_distributor_code; ?>">
                                                        <input id="ed_verification_number" name="ed_verification_number"
                                                               type="hidden"
                                                               value="<?php echo $get_verification_number; ?>">
                                                        <input id="ed_mno" name="ed_mno" type="hidden"
                                                               value="<?php echo $get_mno_id; ?>">

                                                        <input id="customer_type" name="customer_type" type="hidden"
                                                               value="<?php echo $get_customer_type; ?>">

                                                        <input type="hidden" name="form_secret5" id="form_secret5"
                                                               value="<?php echo $_SESSION['FORM_SECRET'] ?>">

                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Admin First
                                                                Name <sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_first_name"
                                                                       name="ed_first_name" type="text"
                                                                       value="<?php echo $get_edit_first_name; ?>">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Admin Last
                                                                Name <sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="ed_last_name"
                                                                       name="ed_last_name" type="text"
                                                                       value="<?php echo $get_edit_last_name; ?> ">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Admin
                                                                Email<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="ed_ad_email"
                                                                       name="ed_ad_email"
                                                                       value="<?php echo $get_edit_email; ?>"
                                                                       placeholder="name@mycompany.com">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Phone Number<sup><font
                                                                            color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="mobile_1"
                                                                       name="mobile_1"
                                                                       value="<?php echo $get_edit_phone; ?>"
                                                                       placeholder="xxx-xxx-xxxx" maxlength="12">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>


                                                        <div class="form-actions">
                                                            <button type="submit" name="submit_user" id="submit_user"
                                                                    class="btn btn-primary" disabled="disabled">Assign
                                                            </button>&nbsp; <strong><font color="#FF0000"></font>
                                                                <small></small>
                                                            </strong>

                                                            <a href="properties.php" style="text-decoration:none;"
                                                               class="btn btn-info inline-btn">Cancel</a>
                                                        </div>
                                                        <!-- /form-actions -->

                                                    </fieldset>
                                                </form>

                                            <?php } else {

                                                $properties_mid = 'layout/' . $camp_layout . '/views/properties_mid.php';

                                                if (($new_design == 'yes') && file_exists($properties_mid)) {

                                                    include_once $properties_mid;

                                                } else {
                                                    ?>
                                                    <div class="header2_part1"><h2>Manage Your Location </h2></div>


                                                    <p>The table below lists the properties that are assigned to this
                                                        Business ID  . You can manage an individual property including
                                                        SSID name change, splash page builder, and set a power schedule
                                                        by clicking the <strong>Manage Property</strong> link.</p>
                                                    <p>To assign a property administrator to a location, click <strong>Edit</strong>
                                                        in the Assigned Property Admin column, fill out the required
                                                        fields and click <strong>Update Account</strong>.</p>
                                                    <!-- <p>Once inside the property's management portal you can manage the individual property including but not  limited to SSID name change, Captive Portal Builder and set a Power Schedule.</p>
                                                    <p>If you want someone else to manage one or more locations, you can easily assign an admin to a Property ID by following these steps:</p>


                                                    <p><b>1.</b> Click Edit in the Assigned Admin column </p>
                                                    <p><b>2.</b> Change the admins First and Last Name</p>
                                                    <p><b>3.</b> Change the email address to your assigned admins address</p>
                                                    <p><b>4.</b> Click Update Account</p> -->

                                                <?php }
                                            } ?>

                                            <div id="response_d3">

                                            </div>

                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3></h3>
                                                </div>
                                                <!-- /widget-header -->
                                                <div class="widget-content table_response">
                                                    <div style="overflow-x:auto;overflow-y:hidden;">
                                                        <table class="table table-striped table-bordered tablesaw"
                                                               data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                                                            <?php

                                                            if (array_key_exists('how_many_buildings', $field_array)) {

                                                                $token_id = uniqid();
                                                                $_SESSION['security_token'] = $token_id;


                                                                $query_p = "SELECT t.*,GROUP_CONCAT(' ',j.`icom`) AS icom FROM ( SELECT d.par_default_login,d.bussiness_address1,d.bussiness_address2,d.bussiness_address3,d.`verification_number`,d.`distributor_code`,d.`property_id`,a.`user_name`,a.`full_name`,d.`id`, a.is_enable 
                                                        FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
                                                        WHERE parent_id='$user_distributor') t  LEFT JOIN `exp_icoms` j ON t.distributor_code=j.distributor GROUP BY j.distributor";

                                                                $query_ex = $db_class->selectDB($query_p);


                                                                //$parent_location_count = mysql_num_rows($query_ex);

                                                                $auto_login_feature = $package_functions->getSectionType('LOCATION_AUTO_LOGIN', $system_package);

                                                                if (!isset($_SESSION['parent_to_location_auto_login']) && $auto_login_feature == '1' && !isset($_SESSION['s_token'])) {
                                                                    $_SESSION['parent_to_location_auto_login'] = 'yes';
                                                                }

                                                                ?>
                                                                <thead>
                                                                <tr>

                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="1">PROPERTY ID
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist">ACCOUNT NUMBER
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="2">SERVICE ADDRESS
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="2">ASSIGNED PROPERTY
                                                                        ADMIN
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="3">PROPERTY ADMIN NAME
                                                                    </th>
                                                                    <?php if ($auto_login_feature == '1') { ?>
                                                                        <th scope="col" data-tablesaw-sortable-col
                                                                            data-tablesaw-priority="4">DEFAULT ACCOUNT
                                                                        </th>
                                                                    <?php } ?>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist">UNASSIGN ADMIN
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="10">RESEND
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                <?php
                                                                $default_login_tooltip = $message_functions->showMessage('parent_default_login_tooltip');

                                                                
                                                                foreach ($query_ex['data'] AS $resulr_pa) {

                                                                    $pa_verification_number = $resulr_pa['verification_number'];
                                                                    $icom = $resulr_pa['icom'];
                                                                    $pa_property_id = $resulr_pa['property_id'];
                                                                    $pa_user_name = $resulr_pa['user_name'];
                                                                    $pa_id = $resulr_pa['id'];
                                                                    $pa_full_name = $resulr_pa['full_name'];
                                                                    $u_is_enable = $resulr_pa['is_enable'];
                                                                    $par_default_login = $resulr_pa['par_default_login'];
                                                                    $bussiness_address = $resulr_pa['bussiness_address1'] . ', ' . $resulr_pa['bussiness_address2'] . ', ' . $resulr_pa['bussiness_address3'];

                                                                    if (empty($resulr_pa['user_name']) || $u_is_enable == 8) {
                                                                        $pa_act_user = "Not Assigned";
                                                                    } else {
                                                                        $pa_act_user = "YES";
                                                                    }


                                                                    if (empty($resulr_pa['full_name']) || $u_is_enable == 8) {
                                                                        $pa_full_name = "N/A";
                                                                    } else {
                                                                        $pa_full_name = $resulr_pa['full_name'];
                                                                    }
                                                                    ?>

                                                                    <tr>

                                                                        <td><?php echo $pa_property_id; ?></td>
                                                                        <td><?php echo $icom; ?></td>
                                                                        <td><?php echo trim($bussiness_address, ', '); ?></td>
                                                                        <td><?php echo $pa_act_user; ?> &nbsp;/
                                                                            <?php
                                                                            echo '<a href="javascript:void();" id="ed_' . $pa_verification_number . '"  class="btn btn-small btn-primary">
                      <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
                      $(document).ready(function() {
                      $(\'#ed_' . $pa_verification_number . '\').easyconfirm({locale: {
                          title: \'Assign Admin \',
                          text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                          button: [\'Cancel\',\' Confirm\'],
                          closeText: \'close\'
                             }});
                        $(\'#ed_' . $pa_verification_number . '\').click(function() {
                          window.location = "?tokene=' . $secret . '&ed_a=' . $pa_id . '"
                        });
                        });
                      </script>';

                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $pa_full_name; ?></td>

                                                                        <?php if ($auto_login_feature == '1') { ?>


                                                                            <td><input data-toggle=tooltip"
                                                                                       title='<?php echo $default_login_tooltip; ?>'
                                                                                       class="default-login"
                                                                                       id="default_login<?php echo $pa_id; ?>"
                                                                                       type="checkbox" <?php if ($par_default_login == '1') {
                                                                                    echo 'checked';
                                                                                } ?> >
                                                                                <img id="default_login_img<?php echo $pa_id; ?>"
                                                                                     src="img/loading_ajax.gif"
                                                                                     style="display: none">
                                                                                <script type="text/javascript">

                                                                                    $(document).ready(function () {

                                                                                        $('#default_login<?php echo $pa_id;?>').change(function () {
                                                                                            var status = $('#default_login<?php echo $pa_id; ?>').prop('checked');
                                                                                            changeDefaultLoginAcc('<?php echo $pa_id; ?>', '<?php echo $secret; ?>', '<?php echo $pa_verification_number; ?>', status);
                                                                                        });
                                                                                    });

                                                                                </script>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <?php
                                                                            if ($pa_act_user == 'YES') {
                                                                                echo '<a href="javascript:void();" id="unassigned_' . $pa_verification_number . '"  class="btn btn-small btn-primary">
                      <i class="btn-icon-only icon-remove-circle"></i>Unassign</a><script type="text/javascript">
                      $(document).ready(function() {
                      $(\'#unassigned_' . $pa_verification_number . '\').easyconfirm({locale: {
                          title: \'Unassign Admin \',
                          text: \'Are you sure you want to unassign this Admin?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                          button: [\'Cancel\',\' Confirm\'],
                          closeText: \'close\'
                             }});
                        $(\'#unassigned_' . $pa_verification_number . '\').click(function() {
                          window.location = "?tokene=' . $secret . '&unassign_a=' . $pa_user_name . '"
                        });
                        });
                      </script>';
                                                                            } else {
                                                                                echo '<a href="javascript:void();" disabled="disable" class="btn btn-small btn-primary">
                      <i class="btn-icon-only icon-remove-circle"></i>Unassign</a>';
                                                                            }

                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($pa_act_user == 'YES' && $u_is_enable == '2') {
                                                                                echo '<a href="javascript:void();" id="resend_' . $pa_verification_number . '"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_' . $pa_verification_number . '\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_' . $pa_verification_number . '\').click(function() {
                                                                    window.location = "?tokene=' . $secret . '&e_resend_a=' . $pa_user_name . '"
                                                                });
                                                                });
                                                            </script>';
                                                                            } else {
                                                                                echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php

                                                                            $string_pass = 'uname=' . $pa_user_name . '&fname=' . $pa_full_name . '&urole=' . $a_role;

                                                                            $encript_resetkey = $app->encrypt_decrypt('encrypt', $string_pass);

                                                                            if ($_SESSION['parent_to_location_auto_login'] == 'yes' && $par_default_login == '1' && $auto_login_feature == '1') {

                                                                                header('location:properties' . $extension . '?log_other=2&key=' . $encript_resetkey . '&security_token=' . $token_id);
                                                                                exit();

                                                                            }

                                                                            echo '<a href="properties' . $extension . '?log_other=2&key=' . $encript_resetkey . '&security_token=' . $token_id . '" id="AP_' . $pa_verification_number . '"  class="btn btn-small btn-primary">
                      <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Manage Property</a>';

                                                                            ?>

                                                                        </td>
                                                                    </tr>

                                                                <?php }
                                                                if ($query_ex['rowCount'] == 1) {
                                                                    ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function () {
                                                                            changeDefaultLoginAcc('<?php echo $pa_id;?>', '<?php echo $secret; ?>', '<?php echo $pa_verification_number; ?>', true);
                                                                        });
                                                                    </script>


                                                                    <?php
                                                                }
                                                                ?>


                                                                </tbody>

                                                                <?php

                                                            } else {

                                                                $token_id = uniqid();
                                                                $_SESSION['security_token'] = $token_id;


                                                                $query_p = "SELECT d.par_default_login,d.bussiness_address1,d.bussiness_address2,d.bussiness_address3,d.`verification_number`,d.`property_id`,a.`user_name`,a.`full_name`,d.`id`, a.is_enable,a.`id` as id_no , a.`verification_number` as user_verification_number,a.`user_distributor`
                                                        FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
                                                        WHERE parent_id='$user_distributor' AND a.`verification_number` IS NOT NULL";
                                                                $query_ex = $db_class->selectDB($query_p);


                                                                //$parent_location_count = mysql_num_rows($query_ex);

                                                                $auto_login_feature = $package_functions->getSectionType('LOCATION_AUTO_LOGIN', $system_package);

                                                                if (!isset($_SESSION['parent_to_location_auto_login']) && $auto_login_feature == '1' && !isset($_SESSION['s_token'])) {
                                                                    $_SESSION['parent_to_location_auto_login'] = 'yes';
                                                                }
                                                                //$property_acc = //$package_functions->getSectionType('PROPERTY_PAGE_ACCESS', $system_package);
                                                                if(in_array("PROPERTY_ADMIN", $features_array)){
                                                                    $property_acc="1";
                                                                }else{
                                                                    $property_acc="0";
                                                                }

                                                                ?>
                                                                <thead>
                                                                <tr>

                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="1">PROPERTY ID
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist">CUSTOMER
                                                                        ACCOUNT
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="2">SERVICE ADDRESS
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="2">ASSIGNED PROPERTY
                                                                        ADMIN
                                                                    </th>
                                                                    <?php if ($property_acc == '0') { ?>
                                                                        <th scope="col" data-tablesaw-sortable-col
                                                                            data-tablesaw-priority="3">PROPERTY ADMIN
                                                                            NAME
                                                                        </th>
                                                                    <?php }
                                                                    if ($auto_login_feature == '1') { ?>
                                                                        <th scope="col" data-tablesaw-sortable-col
                                                                            data-tablesaw-priority="4">DEFAULT ACCOUNT
                                                                        </th>
                                                                    <?php } ?>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist">UNASSIGN ADMIN
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="10">RESEND
                                                                    </th>
                                                                    <th scope="col" data-tablesaw-sortable-col
                                                                        data-tablesaw-priority="persist"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                <?php
                                                                $default_login_tooltip = $message_functions->showMessage('parent_default_login_tooltip');


                                                                
                                                                foreach ($query_ex['data'] AS $resulr_pa) {
                                                                    //print_r($resulr_pa);
                                                                    $pa_verification_number = $resulr_pa['verification_number'];
                                                                    $pa_user_verification_number = $resulr_pa['user_verification_number'];
                                                                    $pa_property_id = $resulr_pa['property_id'];
                                                                    $pa_user_name = $resulr_pa['user_name'];
                                                                    $pa_id = $resulr_pa['id'];
                                                                    $id_no = $resulr_pa['id_no'];
                                                                    $pa_full_name = $resulr_pa['full_name'];
                                                                    $u_is_enable = $resulr_pa['is_enable'];
                                                                    $par_default_login = $resulr_pa['par_default_login'];
                                                                    $user_distributor1 = $resulr_pa['user_distributor'];
                                                                    $bussiness_address = $resulr_pa['bussiness_address1'] . ', ' . $resulr_pa['bussiness_address2'] . ', ' . $resulr_pa['bussiness_address3'];

                                                                    $check_new = "SELECT a.`is_enable`, a.`verification_number` as user_verification_number
                                                                                        FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
                                                                                        WHERE a.`user_distributor`='$user_distributor1'";
                                                                    $query_ex2 = $db_class->selectDB($check_new);
                                                                    $n = 0;
                                                                    
                                                                    foreach ($query_ex2['data'] AS $resulr_n) {
                                                                        $enable = $resulr_n['is_enable'];
                                                                        if ($enable == '8') {
                                                                        } else {
                                                                            $n = 1;
                                                                        }

                                                                    }


                                                                    if (empty($resulr_pa['user_name']) || $u_is_enable == 8) {
                                                                        if ($n == 1) {
                                                                            $pa_act_user = "YES";
                                                                        } else {
                                                                            $pa_act_user = "Not Assigned";
                                                                        }
                                                                    } else {

                                                                        $pa_act_user = "YES";
                                                                    }


                                                                    if (empty($resulr_pa['full_name']) || $u_is_enable == 8) {
                                                                        $pa_full_name = "N/A";
                                                                    } else {
                                                                        $pa_full_name = $resulr_pa['full_name'];
                                                                    }
                                                                    ?>

                                                                    <tr>

                                                                        <td><?php echo $pa_property_id; ?></td>
                                                                        <td><?php echo $pa_verification_number; ?></td>
                                                                        <td><?php echo trim($bussiness_address, ', '); ?></td>
                                                                        <td><?php echo $pa_act_user; ?> <?php if ($property_acc == '0') { ?> &nbsp;/
                                                                                <?php
                                                                                echo '<a href="javascript:void();" id="ed1_' . $id_no . '"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
											$(document).ready(function() {
											$(\'#ed1_' . $id_no . '\').easyconfirm({locale: {
													title: \'Assign Admin \',
													text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
													button: [\'Cancel\',\' Confirm\'],
													closeText: \'close\'
												     }});
												$(\'#ed1_' . $id_no . '\').click(function() {
													window.location = "?tokene=' . $secret . '&ed_a=' . $id_no . '"
												});
												});
											</script>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <?php if ($property_acc == '0') { ?>
                                                                            <td><?php echo $pa_full_name; ?></td> <?php } ?>

                                                                        <?php if ($auto_login_feature == '1') { ?>


                                                                            <td><input data-toggle=tooltip"
                                                                                       title='<?php echo $default_login_tooltip; ?>'
                                                                                       class="default-login"
                                                                                       id="default_login<?php echo $id_no; ?>"
                                                                                       type="checkbox" <?php if ($par_default_login == '1') {
                                                                                    echo 'checked';
                                                                                } ?> >
                                                                                <img id="default_login_img<?php echo $id_no; ?>"
                                                                                     src="img/loading_ajax.gif"
                                                                                     style="display: none">
                                                                                <script type="text/javascript">

                                                                                    $(document).ready(function () {

                                                                                        $('#default_login<?php echo $id_no;?>').change(function () {
                                                                                            var status = $('#default_login<?php echo $id_no; ?>').prop('checked');
                                                                                            changeDefaultLoginAcc('<?php echo $id_no; ?>', '<?php echo $secret; ?>', '<?php echo $pa_verification_number; ?>', status);
                                                                                        });
                                                                                    });

                                                                                </script>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <?php
                                                                            if ($pa_act_user == 'YES') {
                                                                                echo '<a href="javascript:void(0);" id="unassigned_' . $id_no . '"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>Unassign</a><script type="text/javascript">
											$(document).ready(function() {
											$(\'#unassigned_' . $id_no . '\').easyconfirm({locale: {
													title: \'Unassign Admin \',
													text: \'Are you sure you want to unassign this Admin?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
													button: [\'Cancel\',\' Confirm\'],
													closeText: \'close\'
												     }});
												$(\'#unassigned_' . $id_no . '\').click(function() {
													window.location = "?tokene=' . $secret . '&unassign_a=' . $pa_user_name . '"
												});
												});
											</script>';
                                                                            } else {
                                                                                echo '<a href="javascript:void();" disabled="disable" class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>Unassign</a>';
                                                                            }

                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if ($pa_act_user == 'YES' && $u_is_enable == '2') {
                                                                                echo '<a href="javascript:void();" id="resend_' . $id_no . '"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_' . $id_no . '\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_' . $id_no . '\').click(function() {
                                                                    window.location = "?tokene=' . $secret . '&e_resend_a=' . $pa_user_name . '"
                                                                });
                                                                });
                                                            </script>';
                                                                            } else {
                                                                                echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php

                                                                            $string_pass = 'uname=' . $pa_user_name . '&fname=' . $pa_full_name . '&urole=' . $a_role;

                                                                            $encript_resetkey = $app->encrypt_decrypt('encrypt', $string_pass);

                                                                            if ($_SESSION['parent_to_location_auto_login'] == 'yes' && $par_default_login == '1' && $auto_login_feature == '1') {

                                                                                header('location:properties' . $extension . '?log_other=2&key=' . $encript_resetkey . '&security_token=' . $token_id);
                                                                                exit();

                                                                            }

                                                                            echo '<a href="properties' . $extension . '?log_other=2&key=' . $encript_resetkey . '&security_token=' . $token_id . '" id="AP_' . $pa_verification_number . '"  class="btn btn-small btn-primary">
											<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Manage Property</a>';

                                                                            ?>

                                                                        </td>
                                                                    </tr>

                                                                <?php }
                                                                if (mysql_num_rows($query_ex) == 1) {
                                                                    ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function () {
                                                                            changeDefaultLoginAcc('<?php echo $pa_id;?>', '<?php echo $secret; ?>', '<?php echo $pa_verification_number; ?>', true);
                                                                        });
                                                                    </script>


                                                                    <?php
                                                                }
                                                                ?>


                                                                </tbody>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /widget-content -->
                                            </div>
                                            <!-- /widget -->


                                        </div>


                                        <!-- +++++++++++++++++++++++++++++ create users ++++++++++++++++++++++++++++++++ -->
                                        <div
                                            <?php if (isset($tab2)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
                                            id="manage_users">
                                            <div id="response_d3">

                                            </div>

                                            <?php
                                              if(isset($tab2)){
                                                if (isset($_SESSION['msg1'])) {
                                                    echo $_SESSION['msg1'];
                                                    unset($_SESSION['msg1']);

                                                }
                                              }

                                            ?>


                                            <div class="header2_part1 headName"><h2>Assign Property Administrator </h2></div>


                                            <p>Select a property ID from the dropdown. Add the name and email to the
                                                person you want to assign as property administrator and click the Assign
                                                button. To add additional property admins to a property repeat this
                                                process. The assigned property administrator will receive an activation
                                                email with instructions on how to activate the account. The assigned
                                                administrator will log in to the property account using his or her
                                                unique credentials. </p>
                                            <br><br>
                                            <form autocomplete="off" id="user_profile" action="?t=2" method="post"
                                                  class="form-horizontal">

                                                <fieldset>


                                                    <div class="control-group">
                                                        <label class="control-label" for="full_name_1">Property
                                                            ID<sup><font color="#FF0000"></font></sup></label>

                                                        <div class="controls col-lg-5 form-group">

                                                            <select name="ed_property_id" id="ed_property_id"
                                                                    class="span4 form-control" autocomplete="off">
                                                                <option value="">Select Property ID</option>
                                                                <?php
                                                                $count_results = $db_class->selectDB(" SELECT `verification_number`,`property_id` FROM `exp_mno_distributor` WHERE `parent_id` ='$user_distributor'");
                                                                
                                                                foreach ($count_results['data'] AS $row) {

                                                                    if ($row[verification_number] == $pr_get_verification_number) {
                                                                        $select = "selected";
                                                                    } else {
                                                                        $select = "";
                                                                    }

                                                                    echo '<option ' . $select . ' value="' . $row[verification_number] . '" >' . $row[property_id] . '</option>';

                                                                }
                                                                ?>


                                                            </select>
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>


                                                    <!-- /control-group -->

                                                    <input id="ed_user_id" name="ed_user_id" type="hidden"
                                                           value="<?php echo $pr_get_ad_id; ?>">
                                                    <input id="ed_verification_number" name="ed_verification_number"
                                                           type="hidden"
                                                           value="<?php echo $pr_get_verification_number; ?>">

                                                    <input id="ed_distributor_code" name="ed_distributor_code"
                                                           type="hidden"
                                                           value="<?php echo $pr_get_distributor_code; ?>">
                                                    <!-- <input  id="ed_mno" name="ed_mno" type="hidden" value="<?php //echo  $get_mno_id; ?>" >

                                                                                 <input  id="customer_type" name="customer_type" type="hidden" value="<?php //echo  $get_customer_type; ?>" >
                                                                                  -->
                                                    <input type="hidden" name="form_secret5" id="form_secret5"
                                                           value="<?php echo $_SESSION['FORM_SECRET'] ?>">

                                                    <div class="control-group">
                                                        <label class="control-label" for="full_name_1">Admin First Name
                                                            <sup><font color="#FF0000"></font></sup></label>

                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="form-control span4" id="ed_first_name"
                                                                   name="ed_first_name" type="text"
                                                                   value="<?php echo $pr_get_edit_first_name; ?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->


                                                    <div class="control-group">
                                                        <label class="control-label" for="full_name_1">Admin Last Name
                                                            <sup><font color="#FF0000"></font></sup></label>

                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="form-control span4" id="ed_last_name"
                                                                   name="ed_last_name" type="text"
                                                                   value="<?php echo $pr_get_edit_last_name; ?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->


                                                    <div class="control-group">
                                                        <label class="control-label" for="email_1">Admin Email<sup><font
                                                                        color="#FF0000"></font></sup></label>

                                                        <div class="controls form-group col-lg-5">
                                                            <input class="form-control span4" id="ed_ad_email"
                                                                   name="ed_ad_email"
                                                                   value="<?php echo $pr_get_edit_email; ?>"
                                                                   placeholder="name@mycompany.com">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->


                                                    <div class="control-group">
                                                        <label class="control-label" for="email_1">Phone
                                                            Number<sup><font color="#FF0000"></font></sup></label>

                                                        <div class="controls form-group col-lg-5">
                                                            <input class="form-control span4" id="mobile_2"
                                                                   name="mobile_2"" placeholder="xxx-xxx-xxxx"
                                                            maxlength="12" value="<?php echo $pr_get_edit_phone; ?>">
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>


                                                    <div class="form-actions">
                                                        <?php if (isset($_GET['property_ed_a'])) { ?>
                                                            <button type="submit" name="edit_user_manage"
                                                                    id="edit_user_manage" class="btn btn-primary"
                                                                    disabled="disabled">Assign
                                                            </button>&nbsp; <strong><font color="#FF0000"></font>
                                                                <small></small>
                                                            </strong>

                                                        <?php } else { ?>
                                                            <button type="submit" name="submit_user_manage"
                                                                    id="submit_user_manage" class="btn btn-primary"
                                                                    disabled="disabled">Assign
                                                            </button>&nbsp; <strong><font color="#FF0000"></font>
                                                                <small></small>
                                                            </strong>
                                                        <?php } ?>
                                                        <a href="?t=2" style="text-decoration:none;"
                                                           class="btn btn-primary">Cancel</a>
                                                    </div>
                                                    <!-- /form-actions -->

                                                </fieldset>
                                            </form>


                                            <div id="response_d3">

                                            </div>

                                            <div class="widget tablesaw-widget widget-table widget-content table_response">
                                                <div style="overflow-x:auto;">
                                                    <table class="table table-striped table-bordered tablesaw"
                                                           data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                        <tr>

                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="1">PROPERTY ID
                                                            </th>
                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="persist">CUSTOMER ACCOUNT
                                                            </th>
                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="2">SERVICE ADDRESS
                                                            </th>
                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="3">PROPERTY ADMIN NAME
                                                            </th>
                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="1">Edit
                                                            </th>
                                                            <th scope="col" data-tablesaw-sortable-col
                                                                data-tablesaw-priority="5">Remove
                                                            </th>


                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?php
                                                        $default_login_tooltip = $message_functions->showMessage('parent_default_login_tooltip');

                                                        $query_p = "SELECT d.par_default_login,d.bussiness_address1,d.bussiness_address2,d.bussiness_address3,d.`verification_number`,d.`property_id`,a.`user_name`,a.`full_name`,d.`id`, a.is_enable,a.`id` as id_no , a.`verification_number` as user_verification_number
                                                                                        FROM `exp_mno_distributor` d LEFT JOIN `admin_users` a ON d.distributor_code = a.user_distributor 
                                                                                        WHERE parent_id='$user_distributor' ";
                                                        $query_ex = $db_class->selectDB($query_p);

                                                        
                                                        foreach ($query_ex['data'] AS $resulr_pa) {

                                                            $pa_verification_number = $resulr_pa['verification_number'];
                                                            $pa_user_verification_number = $resulr_pa['user_verification_number'];
                                                            $pa_property_id = $resulr_pa['property_id'];
                                                            $pa_user_name = $resulr_pa['user_name'];
                                                            $pa_id = $resulr_pa['id'];
                                                            $id_no = $resulr_pa['id_no'];
                                                            $pa_full_name = $resulr_pa['full_name'];
                                                            $u_is_enable = $resulr_pa['is_enable'];
                                                            $par_default_login = $resulr_pa['par_default_login'];
                                                            $bussiness_address = $resulr_pa['bussiness_address1'] . ', ' . $resulr_pa['bussiness_address2'] . ', ' . $resulr_pa['bussiness_address3'];

                                                            if (empty($resulr_pa['user_name']) || $u_is_enable == 8) {
                                                                $pa_act_user = "Not Assigned";
                                                            } else {
                                                                $pa_act_user = "YES";
                                                            }


                                                            if (empty($resulr_pa['full_name']) || $u_is_enable == 8) {
                                                                $pa_full_name = "N/A";
                                                            } else {
                                                                $pa_full_name = $resulr_pa['full_name'];
                                                            }
                                                            ?>

                                                            <tr>

                                                                <td><?php echo $pa_property_id; ?></td>
                                                                <td><?php echo $pa_verification_number; ?></td>
                                                                <td><?php echo trim($bussiness_address, ', '); ?></td>
                                                                <td><?php echo $pa_full_name; ?></td>
                                                                <td>
                                                                    <?php
                                                                    echo '<a href="javascript:void();" id="ed_' . $id_no . '"  class="btn btn-small btn-primary">
                                                                            <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                            $(\'#ed_' . $id_no . '\').easyconfirm({locale: {
                                                                                    title: \'Assign Admin \',
                                                                                    text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                    closeText: \'close\'
                                                                                     }});
                                                                                $(\'#ed_' . $id_no . '\').click(function() {
                                                                                    window.location = "?tokene=' . $secret . '&t=2&property_ed_a=' . $id_no . '"
                                                                                });
                                                                                });
                                                                            </script>';

                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    echo '<a href="javascript:void();" id="rm_' . $id_no . '"  class="btn btn-small btn-primary">
                                                      <i class="btn-icon-only icon-remove-circle"></i>&nbsp;DELETE</a><script type="text/javascript">
                                                      $(document).ready(function() {
                                                      $(\'#rm_' . $id_no . '\').easyconfirm({locale: {
                                                          title: \'Remove Admin \',
                                                          text: \'Are you sure you want to delete this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                          button: [\'Cancel\',\' Confirm\'],
                                                          closeText: \'close\'
                                                             }});
                                                        $(\'#rm_' . $id_no . '\').click(function() {
                                                          window.location = "?tokene=' . $secret . '&t=2&property_rm_a=' . $id_no . '"
                                                        });
                                                        });
                                                      </script>';

                                                                    ?>
                                                                </td>

                                                            </tr>

                                                        <?php }
                                                        if ($query_ex['rowCount'] == 1) {
                                                            ?>
                                                            <script type="text/javascript">
                                                                $(document).ready(function () {
                                                                    changeDefaultLoginAcc('<?php echo $pa_id;?>', '<?php echo $secret; ?>', '<?php echo $pa_verification_number; ?>', true);
                                                                });
                                                            </script>


                                                            <?php
                                                        }
                                                        ?>


                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>


                                        </div>


                                        <!-- +++++++++++++++++++++++++++++ create users ++++++++++++++++++++++++++++++++ -->
                                        <div
                                            <?php if (isset($tab3)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
                                            id="business_id_users">
                                            <div id="response_d3">

                                            </div>

                                            <?php
                                              if(isset($tab3)){
                                                if (isset($_SESSION['msg1'])) {
                                                    echo $_SESSION['msg1'];
                                                    unset($_SESSION['msg1']);

                                                }
                                              }

                                            ?>


                                            <div class="header2_part1 headName" style="display:none"><h2>Business ID Admins</h2></div>


                                            <p></p>
                                            <br><br>
                                            <?php
                                            if (!isset($_GET['edit_business_id'])) {
                                                ?>
                                                <form autocomplete="off" id="bi_edit_profile" action="?t=3"
                                                      method="post" class="form-horizontal">


                                                    <fieldset>

                                                        <?php
                                                        echo '<input type="hidden" name="user_type" id="user_type1" value="' . $user_type . '">';
                                                        ?>

                                                        <?php
                                                        echo '<input type="hidden" name="loation" id="loation1" value="' . $user_distributor . '">';
                                                        echo '<input type="hidden" name="loation" id="loation1" value="' . $user_distributor . '">';
                                                        ?>

                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Full
                                                                Name<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="full_name_1"
                                                                       name="full_name_1" maxlength="25" type="text">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Email<sup><font
                                                                            color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="email_1"
                                                                       name="email_1" placeholder="name@mycompany.com">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label"
                                                                   for="language_1">Language</label>

                                                            <div class="controls form-group col-lg-5">
                                                                <select class="form-control span4" name="language_1"
                                                                        id="language_1">

                                                                    <?php


                                                                    $key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";

                                                                    $query_results = $db_class->selectDB($key_query);
                                                                    
                                                                    foreach ($query_results['data'] AS $row) {
                                                                        $language_code = $row[language_code];
                                                                        $language = $row[language];
                                                                        echo '<option value="' . $language_code . '">' . $language . '</option>';


                                                                    }

                                                                    ?>

                                                                </select>

                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="mobile_1">Phone
                                                                Number<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">

                                                                <input class="form-control span4" id="mobile_1"
                                                                       name="mobile_1" type="text"
                                                                       placeholder="xxx-xxx-xxxx" maxlength="12">


                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        <script type="text/javascript">

                                                            $(document).ready(function () {

                                                                $("#mobile_1").keypress(function (event) {
                                                                    var ew = event.which;
                                                                    //alert(ew);
                                                                    //if(ew == 8||ew == 0||ew == 46||ew == 45)
                                                                    //if(ew == 8||ew == 0||ew == 45)
                                                                    if (ew == 8 || ew == 0)
                                                                        return true;
                                                                    if (48 <= ew && ew <= 57)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $('#mobile_1').focus(function () {
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                                                });

                                                                $('#mobile_1').keyup(function () {
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                                                });

                                                                $("#mobile_1").keydown(function (e) {


                                                                    var mac = $('#mobile_1').val();
                                                                    var len = mac.length + 1;
                                                                    //console.log(e.keyCode);
                                                                    //console.log('len '+ len);

                                                                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                        //console.log(valu);
                                                                        //$('#phone_num_val').val(valu);

                                                                    }
                                                                    else {

                                                                        if (len == 4) {
                                                                            $('#mobile_1').val(function () {
                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                                                //console.log('mac1 ' + mac);

                                                                            });
                                                                        }
                                                                        else if (len == 8) {
                                                                            $('#mobile_1').val(function () {
                                                                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }
                                                                    }


                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');

                                                                });


                                                            });


                                                        </script>
                                                        <input type="hidden" name="form_secret6" id="form_secret6"
                                                               value="<?php echo $_SESSION['FORM_SECRET'] ?>">

                                                        <div class="form-actions">
                                                            <button type="submit" name="create_business_admin"
                                                                    id="create_business_admin" class="btn btn-primary">
                                                                Save & Send Email Invitation
                                                            </button>&nbsp; <strong><font color="#FF0000"></font>
                                                                <small></small>
                                                            </strong>
                                                        </div>
                                                        <!-- /form-actions -->
                                                    </fieldset>
                                                </form>
                                            <?php }
                                            if (isset($_GET['edit_business_id'])) {
                                                ?>

                                                <form autocomplete="off" id="bi_edit_profile" action="?t=3"
                                                      method="post" class="form-horizontal">


                                                    <fieldset>

                                                        <?php
                                                        echo '<input type="hidden" name="user_type" id="user_type1" value="' . $user_type . '">';
                                                        ?>

                                                        <?php
                                                        echo '<input type="hidden" name="loation" id="loation1" value="' . $user_distributor . '">';
                                                        echo '<input type="hidden" name="user_idn" id="user_idn" value="' . $dis_id . '">';
                                                        ?>

                                                        <div class="control-group">
                                                            <label class="control-label" for="full_name_1">Full
                                                                Name<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls col-lg-5 form-group">
                                                                <input class="form-control span4" id="full_name_1"
                                                                       name="full_name_1" maxlength="25" type="text"
                                                                       value="<?php echo $b_get_edit_fulname; ?>">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="email_1">Email<sup><font
                                                                            color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">
                                                                <input class="form-control span4" id="email_1"
                                                                       name="email_1" placeholder="name@mycompany.com"
                                                                       value="<?php echo $b_get_edit_email; ?>">
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label"
                                                                   for="language_1">Language</label>

                                                            <div class="controls form-group col-lg-5">
                                                                <select class="form-control span4" name="language_1"
                                                                        id="language_1">

                                                                    <?php


                                                                    $key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";

                                                                    $query_results = $db_class->selectDB($key_query);
                                                                    
                                                                    foreach ($query_results['data'] AS $row) {
                                                                        $language_code = $row[language_code];
                                                                        $language = $row[language];
                                                                        echo '<option value="' . $language_code . '">' . $language . '</option>';


                                                                    }

                                                                    ?>

                                                                </select>

                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->


                                                        <div class="control-group">
                                                            <label class="control-label" for="mobile_1">Phone
                                                                Number<sup><font color="#FF0000"></font></sup></label>

                                                            <div class="controls form-group col-lg-5">

                                                                <input class="form-control span4" id="mobile_1"
                                                                       name="mobile_1" type="text"
                                                                       placeholder="xxx-xxx-xxxx" maxlength="12"
                                                                       value="<?php echo $b_get_edit_phone; ?>">


                                                            </div>

                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        <script type="text/javascript">

                                                            $(document).ready(function () {

                                                                $("#mobile_1").keypress(function (event) {
                                                                    var ew = event.which;
                                                                    //alert(ew);
                                                                    //if(ew == 8||ew == 0||ew == 46||ew == 45)
                                                                    //if(ew == 8||ew == 0||ew == 45)
                                                                    if (ew == 8 || ew == 0)
                                                                        return true;
                                                                    if (48 <= ew && ew <= 57)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $('#mobile_1').focus(function () {
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                                                });

                                                                $('#mobile_1').keyup(function () {
                                                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
                                                                });

                                                                $("#mobile_1").keydown(function (e) {


                                                                    var mac = $('#mobile_1').val();
                                                                    var len = mac.length + 1;
                                                                    //console.log(e.keyCode);
                                                                    //console.log('len '+ len);

                                                                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                        //console.log(valu);
                                                                        //$('#phone_num_val').val(valu);

                                                                    }
                                                                    else {

                                                                        if (len == 4) {
                                                                            $('#mobile_1').val(function () {
                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                                                //console.log('mac1 ' + mac);

                                                                            });
                                                                        }
                                                                        else if (len == 8) {
                                                                            $('#mobile_1').val(function () {
                                                                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }
                                                                    }


                                                                    $('#bi_edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');

                                                                });


                                                            });


                                                        </script>
                                                        <input type="hidden" name="form_secret6" id="form_secret6"
                                                               value="<?php echo $_SESSION['FORM_SECRET'] ?>">

                                                        <div class="form-actions">
                                                            <button type="submit" name="update_business_admin"
                                                                    id="update_business_admin" class="btn btn-primary">
                                                                Save
                                                            </button>&nbsp; <strong><font color="#FF0000"></font>
                                                                <small></small>
                                                            </strong>
                                                            <a href="properties.php?t=3" style="text-decoration:none;"
                                                               class="btn btn-info inline-btn">Cancel</a>
                                                        </div>
                                                        <!-- /form-actions -->
                                                    </fieldset>
                                                </form>
                                            <?php } ?>

                                            <script type="text/javascript">

                                                /* $(document).ready(function() {



                                                document.getElementById("create_business_admin").disabled = true;

                                                });

                                                function newus_ck(){

                                                var name=document.getElementById('full_name_1').value;
                                                var email=document.getElementById('email_1').value;
                                                var numb=document.getElementById('mobile_1').value;



                                                if(name==''||email==''||numb==''){
                                                document.getElementById("create_business_admin").disabled = true;

                                                }else{
                                                document.getElementById("create_business_admin").disabled = false;

                                                }

                                                }
                                                 */

                                            </script>


                                            <div id="response_d3">

                                            </div>

                                            <div class="widget tablesaw-widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->

                                                </div>
                                                <!-- /widget-header -->
                                                <div class="widget-content table_response">
                                                    <div style="overflow-x:auto;">
                                                        <table class="table table-striped table-bordered tablesaw"
                                                               data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col
                                                                    data-tablesaw-priority="persist">Username
                                                                </th>

                                                                <th scope="col" data-tablesaw-sortable-col
                                                                    data-tablesaw-priority="1">Full Name
                                                                </th>
                                                                <th scope="col" data-tablesaw-sortable-col
                                                                    data-tablesaw-priority="3">Email
                                                                </th>

                                                                <th scope="col" data-tablesaw-sortable-col
                                                                    data-tablesaw-priority="1">Edit
                                                                </th>
                                                                <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Disable</th> -->
                                                                <th scope="col" data-tablesaw-sortable-col
                                                                    data-tablesaw-priority="5">Remove
                                                                </th>


                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php


                                                            $key_query = "SELECT * FROM `admin_users` WHERE `user_distributor` = '$user_distributor' AND  `verification_number` IS NULL";


                                                            //echo $key_query;

                                                            $query_results = $db_class->selectDB($key_query);
                                                            foreach ($query_results['data'] AS $row) {
                                                                $id = $row[id];
                                                                $user_name1 = $row[user_name];
                                                                $full_name = $row[full_name];
                                                                $verification_number = $row[verification_number];

                                                                $access_role = $row[access_role];
                                                                $access_role_desc = $row['description'];

                                                                /*$q_desc_get = "SELECT description FROM `admin_access_roles` WHERE access_role = '$access_role'";
                                                                $query_results_a=mysql_query($q_desc_get);
                                                                while($row1=mysql_fetch_array($query_results_a)){
                                                                    $access_role_desc = $row1[description];

                                                                }*/


                                                                $user_type1 = $row[user_type];
                                                                $user_distributor1 = $row[user_distributor];
                                                                $email = $row[email];
                                                                $is_enable = $row[is_enable];

                                                                $create_user = $row[create_user];

                                                                if ($user_type1 == 'TECH') {


                                                                    $access_role_desc = 'Tech Admin';

                                                                } else if ($user_type1 == 'SUPPORT') {


                                                                    $access_role_desc = 'Support Admin';

                                                                }


                                                                if ($is_enable == '1' || $is_enable == '2') {
                                                                    $btn_icon = 'thumbs-down';
                                                                    $show_value = '<font color="#00CC00"><strong>Enable</strong></font>';
                                                                    $btn_color = 'warning';
                                                                    $btn_title = 'disable';
                                                                    $action_status = 0;
                                                                } else {

                                                                    $btn_icon = 'thumbs-up';
                                                                    $show_value = '<font color="#FF0000"><strong>Disable</strong></font>';
                                                                    $btn_color = 'success';
                                                                    $btn_title = 'enable';
                                                                    $action_status = 1;
                                                                }

                                                                echo '<tr>
                                    <td> ' . $user_name1 . ' </td>
                                    
                                    <td> ' . $full_name . ' </td>';
                                                                //echo '<td> '.$user_type1.' </td><td> '.$user_distributor1.' </td>';
                                                                echo '<td> ' . $email . ' </td>';


                                                                /////////////////////////////////////////////

                                                                echo '<td><a href="javascript:void();" id="APE_' . $id . '"  class="btn btn-small btn-primary">
                                    <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                    $(document).ready(function() {
                                    $(\'#APE_' . $id . '\').easyconfirm({locale: {
                                            title: \'Edit Admin\',
                                            text: \'Are you sure you want to edit this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#APE_' . $id . '\').click(function() {
                                            window.location = "?token=' . $secret . '&t=3&edit_business_id=' . $id . '"
                                        });
                                        });
                                    </script></td>';

                                                                /*  echo '<td><a href="javascript:void();" id="LS_'.$id.'"  class="btn btn-small btn-'.$btn_color.'">
                                                                  <i class="btn-icon-only icon-'.$btn_icon.'"></i>&nbsp;'.ucfirst($btn_title).'</a><script type="text/javascript">
                                                                  $(document).ready(function() {
                                                                  $(\'#LS_'.$id.'\').easyconfirm({locale: {
                                                                          title: \''.ucfirst($btn_title).' User\',
                                                                          text: \'Are you sure you want to '.$btn_title.' this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                          button: [\'Cancel\',\' Confirm\'],
                                                                          closeText: \'close\'
                                                                           }});
                                                                      $(\'#LS_'.$id.'\').click(function() {
                                                                          window.location = "?token='.$secret.'&t=1&status_change_id='.$id.'&action_sts='.$action_status.'"
                                                                      });
                                                                      });
                                                                  </script></td>'; */
                                                                  if ($user_name1==$user_name) {
                                                                          echo '<td><a disabled id="RU_' . $id . '"  class="btn btn-small btn-danger">
                                    <i class="btn-icon-only icon-remove"></i>&nbsp;Remove</a></td>';
                                                              }else{
                                                                echo '<td><a href="javascript:void();" id="RU_' . $id . '"  class="btn btn-small btn-danger">
                                    <i class="btn-icon-only icon-remove"></i>&nbsp;Remove</a><script type="text/javascript">
                                    $(document).ready(function() {
                                    $(\'#RU_' . $id . '\').easyconfirm({locale: {
                                            title: \'Remove Admin\',
                                            text: \'Are you sure you want to remove this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#RU_' . $id . '\').click(function() {
                                            window.location = "?token=' . $secret . '&t=3&remove_business_admin=' . $id . '"
                                        });
                                        });
                                    </script></td>';


                                                                echo '</tr>';


                                                            }
                                                          }

                                                            ?>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- /widget-content -->


                                            </div>
                                            <!-------------------------------------->


                                        </div>


                                    </div>
                                    <!-- /widget-content -->

                                </div>
                            </div>
                            <!-- /widget -->

                        </div>
                        <!-- /span12 -->


                    </div>
                    <!-- /row -->

                </div>
                <!-- /container -->

            </div>
            <!-- /main-inner -->

        </div>
        <!-- /main -->


        <script type="text/javascript" src="js/formValidation.js"></script>
        <script type="text/javascript" src="js/bootstrap_form.js"></script>
        <script type="text/javascript" src="js/bootstrapValidator_new.js?v=15"></script>


        <script type="text/javascript">

            $(document).ready(function () {

                $('#mobile_1').focus(function () {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    $('#edit_profile').bootstrapValidator('revalidateField', 'mobile_1');
                });

                $('#mobile_1').keyup(function () {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    $('#edit_profile').bootstrapValidator('revalidateField', 'mobile_1');
                });

                $("#mobile_1").keydown(function (e) {


                    var mac = $('#mobile_1').val();
                    var len = mac.length + 1;
                    //console.log(e.keyCode);
                    //console.log('len '+ len);

                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                        mac1 = mac.replace(/[^0-9]/g, '');


                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                        //console.log(valu);
                        //$('#phone_num_val').val(valu);

                    }
                    else {

                        if (len == 4) {
                            $('#mobile_1').val(function () {
                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                //console.log('mac1 ' + mac);

                            });
                        }
                        else if (len == 8) {
                            $('#mobile_1').val(function () {
                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                //console.log('mac2 ' + mac);

                            });
                        }
                    }


                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+C, Command+C
                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+x, Command+x
                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+V, Command+V
                        (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
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

        <script type="text/javascript">

            $(document).ready(function () {

                $('#mobile_2').focus(function () {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    $('#user_profile').bootstrapValidator('revalidateField', 'mobile_2');
                });

                $('#mobile_2').keyup(function () {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                    $('#user_profile').bootstrapValidator('revalidateField', 'mobile_2');
                });

                $("#mobile_2").keydown(function (e) {


                    var mac = $('#mobile_2').val();
                    var len = mac.length + 1;
                    //console.log(e.keyCode);
                    //console.log('len '+ len);

                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                        mac1 = mac.replace(/[^0-9]/g, '');


                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                        //console.log(valu);
                        //$('#phone_num_val').val(valu);

                    }
                    else {

                        if (len == 4) {
                            $('#mobile_2').val(function () {
                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                //console.log('mac1 ' + mac);

                            });
                        }
                        else if (len == 8) {
                            $('#mobile_2').val(function () {
                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                //console.log('mac2 ' + mac);

                            });
                        }
                    }


                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+C, Command+C
                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+x, Command+x
                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+V, Command+V
                        (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
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

        <script type="text/javascript">
            $(document).ready(function () {
                //create user form validation
                $('#edit_profile').bootstrapValidator({
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
                                <?php echo $db_class->validateField('person_full_name'); ?>
                            }
                        },
                        ed_last_name: {
                            validators: {
                                <?php echo $db_class->validateField('person_full_name'); ?>
                            }
                        },
                        ed_ad_email: {
                            validators: {
                                <?php echo $db_class->validateField('email_cant_upper'); ?>
                            }
                        },
                        mobile_1: {
                            validators: {
                                <?php echo $db_class->validateField('mobile'); ?>
                            }
                        }
                    }
                });


                $('#user_profile').bootstrapValidator({
                    framework: 'bootstrap',
                    excluded: ':disabled',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        ed_property_id: {
                            validators: {
                                <?php echo $db_class->validateField('notEmpty'); ?>
                            }
                        },
                        ed_first_name: {
                            validators: {
                                <?php echo $db_class->validateField('person_full_name'); ?>
                            }
                        },
                        ed_last_name: {
                            validators: {
                                <?php echo $db_class->validateField('person_full_name'); ?>
                            }
                        },
                        ed_ad_email: {
                            validators: {
                                <?php echo $db_class->validateField('email_cant_upper'); ?>
                            }
                        },
                        mobile_2: {
                            validators: {
                                <?php echo $db_class->validateField('mobile'); ?>
                            }
                        }
                    }
                });
                $('#bi_edit_profile').bootstrapValidator({
                    framework: 'bootstrap',
                    excluded: ':disabled',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        full_name_1: {
                            validators: {
                            <?php echo $db_class->validateField('person_full_name'); ?>,
                            <?php echo $db_class->validateField('not_require_special_character'); ?>
                        }
                    },
                    email_1: {
                        validators: {
                            <?php echo $db_class->validateField('email_cant_upper'); ?>
                        }
                    },
                    mobile_1: {
                        validators: {
                            <?php echo $db_class->validateField('mobile'); ?>
                        }
                    }
                }

            })
                ;
                //.on('status.field.bv', function(e, data) {
//
//		if($('#edit_profile').data('bootstrapValidator').isValid()){
//
//			data.bv.disableSubmitButtons(false);
//
//		}else{
//			
//			data.bv.disableSubmitButtons(true);
//		}
//
//	});


                /*
                     $('#edit_profile').on('change paste keyup', function () {

                        if($('#edit_profile').data('bootstrapValidator').isValid()){
                            $('#edit_profile').data('bootstrapValidator').disableSubmitButtons(false);
                        }
                        else{
                            $('#edit_profile').data('bootstrapValidator').disableSubmitButtons(true);

                        }
                    });  */


                // edit user
                /*  $('#edit-user-profile').formValidation({
                     framework: 'bootstrap',
                     fields: {
                         access_role_2: {
                             validators: {
<?php //echo $db_class->validateField('dropdown'); ?>
                }
            },
            full_name_2: {
                validators: {
                    <?php //echo $db_class->validateField('person_full_name'); ?>
                }
            },
            email_2: {
                validators: {
                    <?php //echo $db_class->validateField('email'); ?>
                }
            },
            mobile_2: {
                validators: {
                    <?php //echo $db_class->validateField('mobile'); ?>
                }
            }
        }
    }); */

                // Create access Roles


                // Assign access Roles


            });
        </script>


        <?php
        include 'footer.php';
        ?>

        <script src="js/base.js"></script>
        <script src="js/jquery.chained.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                $("#loation").chained("#user_type");

            });
        </script>


        <!-- Alert messages js-->
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {

                $("#submit_1").easyconfirm({
                    locale: {
                        title: 'New Admin Account',
                        text: 'Are you sure you want to save this information?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#submit_1").click(function () {
                });


                $("#assign_roles_submita").easyconfirm({
                    locale: {
                        title: 'Role Creation',
                        text: 'Are you sure you want to save this Role?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#assign_roles_submita").click(function () {

                    /* if($('#assign_roles_submit').data('formValidation').isValid()){

                    }
                    else{
                        $('#assign_roles_submit').formValidation('revalidateField', 'my_select[]');
                    $('#assign_roles_submit').formValidation('revalidateField', 'access_role_name');
                    } */

                });

                $("#edit-submita").easyconfirm({
                    locale: {
                        title: 'Edit User',
                        text: 'Are you sure you want to update this profile?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#edit-submita").click(function () {
                });


                $("#edit-submita-pass").easyconfirm({
                    locale: {
                        title: 'Password Reset',
                        text: 'Are you sure you want to update this password?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#edit-submita-pass").click(function () {
                });

                $("#assign_rolesa").easyconfirm({
                    locale: {
                        title: 'Manage Role',
                        text: 'Are you sure you want to save this information?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#assign_rolesa").click(function () {

                    if ($('#assign_roles_form').data('formValidation').isValid()) {

                    }
                    else {
                        $('#assign_roles_form').formValidation('revalidateField', 'my_select_roles[]');
                        $('#assign_roles_form').formValidation('revalidateField', 'access_role_field');
                    }

                });

                $("#submit_peer").easyconfirm({
                    locale: {
                        title: 'Create Peer Admin',
                        text: 'Are you sure you want to save this information?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#submit_peer").click(function () {
                });

                $("#submit_user_manage").easyconfirm({
                    locale: {
                        title: 'Create Property Admin',
                        text: 'Are you sure you want to save this information?',
                        button: ['Cancel', ' Confirm'],
                        closeText: 'close'
                    }
                });
                $("#submit_user_manage").click(function () {
                });

            });
        </script>
        <style type="text/css">
            .ms-container {
                display: inline-block !important;
            }
        </style>


        <script type="text/javascript">

            function GetXmlHttpObject() {
                var xmlHttp = null;
                try {
                    // Firefox, Opera 8.0+, Safari
                    xmlHttp = new XMLHttpRequest();
                }
                catch (e) {
                    //Internet Explorer
                    try {
                        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
                    }
                    catch (e) {
                        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                }
                return xmlHttp;
            }

        </script>

        <script src="js/jquery.multi-select.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#my_select').multiSelect();
                $('#my_select_roles').multiSelect({
                    afterSelect: function (values) {
                        validate_btn();
                    },
                    afterDeselect: function (values) {
                        validate_btn();
                    }
                });
            });

            function validate_btn() {
                $('#assign_rolesa').attr('disabled', false);
            }

        </script>
        <script>
            $(document).ready(function () {

                $('.default-login').tooltip();

            });
        </script>

        <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>


        <!--Change defalut login Function-->
        <script type="text/javascript">
            function changeDefaultLoginAcc(pa_id, secret, verification_number, status) {

                $('#default_login_img' + pa_id).show();
                //var status=$('#default_login'+pa_id).prop('checked');
                /*if($('input[type="checkbox"].default-login').length == 1){
                    $('input[type="checkbox"].default-login').prop('checked',true);
                    status=true;
                }*/
                var formData = {status: status, secret: 'w' + secret, verification_number: verification_number};
                $.ajax({
                    url: "ajax/update_default.php",
                    type: "POST",
                    data: formData,
                    success: function (data) {
                        $('#default_login_img' + pa_id).hide();
                        //if(data=='fail'){
                        //alert(status);
                        if (status) {
                            //alert();
                            $('.default-login').prop('checked', false);
                            $('#default_login' + pa_id).prop('checked', true);

                        }
                        //}

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("error");
                    }
                });
            }
        </script>

        </body>

</html>
