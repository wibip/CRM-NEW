<?php
session_start();



header("Cache-Control: no-cache, must-revalidate");

require_once '../../classes/dbClass.php';
$db = new db_functions();

require_once '../../classes/systemPackageClass.php';
$package_functions = new package_functions();


require_once '../../models/vtenantModel.php';
$vtenant_model = new vtenantModel();


if (isset($_POST['csv_mid'])) {
    $mno_id = $_POST['csv_mid'];
} else {
    $mno_id = $_GET['csv_mid'];
}

if (isset($_POST['csv_mvid'])) {
    $user_distributor = $_POST['csv_mvid'];
} else {
    $user_distributor = $_GET['csv_mvid'];
}

if (isset($_POST['csv_type'])) {
    $csv_type = $_POST['csv_type'];
} else {
    $csv_type = $_GET['csv_type'];
}




$system_package = $db->getValueAsf("SELECT m.system_package AS f FROM `exp_mno` m  WHERE m.mno_id = '$mno_id '  LIMIT 1 ");

//message class
require_once '../../classes/messageClass.php';
$message_functions = new message_functions($system_package);

$user_name = $_SESSION['user_name'];



$user_distributor_name = $db->getValueAsF("SELECT distributor_name AS f FROM exp_mno_distributor WHERE distributor_code='$user_distributor' ");
$system_package_de = $db->getValueAsF("SELECT system_package AS f FROM exp_mno_distributor WHERE distributor_code='$user_distributor' ");
$verticle_type_q = "SELECT `bussiness_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code` ='$user_distributor'";
$user_verticle = $db->getValueAsf($verticle_type_q);


if ($csv_type == 'send_email') {


    $voucher_id = $_POST['voucher_id'];
    $to = $_POST['email'];
    $name = $_POST['name'];
    $onboarding_SSID = $_POST['onboarding_SSID'];
    $captive_portal = $_POST['captive_portal'];

    $voucher = $db->getValueAsf("SELECT `voucher_code` AS f FROM `mdu_customer_voucher` WHERE `id` = '$voucher_id'");

    $from = strip_tags($db->setVal("email", $mno_id));
    if (empty($from)) {
        $from = strip_tags($db->setVal("email", "ADMIN"));
    }



    // $email_content = $db->getEmailTemplate('VOUCHER_MAIL','','',$user_distributor);


    $email_content = $db->getEmailTemplate('VOUCHER_MAIL', $system_package, $mno_id, $user_distributor);





    $a = $email_content[0]['text_details'];
    $subject = $email_content[0]['title'];



    $vars = array(
        '{$voucher}' => $voucher,
        '{$user_full_name}' => $name,
        '{$onboarding_SSID}' => $onboarding_SSID,
        '{$captive_portal}' => $captive_portal,
    );


    $message_full = strtr($a, $vars);
    $message = $message_full;

    //echo $message;
    $emailSystem = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);


    if (strlen($emailSystem) > 0) {

        include_once '../../src/email/' . $emailSystem . '/index.php';
        $cunst_var = array();
        $cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
        $cunst_var['system_package'] = $system_package_de;
        $cunst_var['mno_package'] = $system_package;
        $cunst_var['mno_id'] = $mno_id;
        $cunst_var['verticle'] = $user_verticle;


        $emailSystemOb = new email($cunst_var);

        $mail_sent = $emailSystemOb->sendEmail($from, $to, $subject, $message_full, '', $title);

        $message_full;
    } else {
        $mail_sent = @mail($to, $subject, $message, $headers);
    }

    $q0 = "UPDATE `mdu_customer_voucher` SET `email`='$to',`name`='$name',`isses_date` = NOW(),`send_email` = 1 WHERE `id` = '$voucher_id'";

    $q_result0 = $db->execDB($q0);

    if ($q_result0) {
        $_SESSION['msg'] = '<div class="alert alert-success">' . $message_functions->showMessage('voucher_email_sent_success') . '</div>';
        echo "success";
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger">' . $message_functions->showMessage('voucher_email_sent_failed') . '</div>';
        echo "failed";
    }
} else if ($csv_type == 'remaining') {

    $voucher_q = "SELECT * FROM `mdu_customer_voucher` WHERE `voucher_type` = 'SINGLEUSE' AND `status` = 1 AND `send_email` <> 1 AND `distributor`='$user_distributor'";

    $voucher_re = $db->selectDB($voucher_q);
    $filename = 'Voucher_Export_' . str_replace(" ", "", $user_distributor_name) . '_' . date(ymdHis) . '';

    $keys = '';
    foreach ($voucher_re['data'] as $row_s) {
        $keys .= trim($row_s['voucher_code']) . "\n";
    }
    $keys = trim($keys);

    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$keys";
} else {
    $generate_count = $_GET['generate'];

    $voucher_patten_data = $vtenant_model->getVouchers($mno_id, 'VOUCHER');

    if (empty($voucher_patten_data->min_length)) {
        $voucher_patten_data = $vtenant_model->getVouchers('ADMIN', 'VOUCHER');
    }

    $seperator = $voucher_patten_data->seperator;
    $pass_min_length = $voucher_patten_data->min_length;
    $pass_max_length =  $voucher_patten_data->max_length;
    $word_count = $voucher_patten_data->word_count;


    $need_words_count = $word_count * $generate_count;


    // $file = fopen("contacts.csv","r");
    // print_r(fgetcsv($file));
    // fclose($file);
    $filename = 'Voucher_Export_' . str_replace(" ", "", $user_distributor_name) . '_' . date(ymdHis) . '';

    $key_bulk = array();

    $key_array = file("key_txt.txt");

    //echo count($key_bulk) ."-----". $need_words_count;

    while (count($key_bulk) < $need_words_count) {
        $rand_key = array_rand($key_array);
        $rand_keys_val = trim(strtoupper($key_array[$rand_key]));

        if (strlen($rand_keys_val) == $pass_min_length || strlen($rand_keys_val) == $pass_max_length) {
            $key_bulk[] = $rand_keys_val;
        }
    }


    //print_r($key_bulk);

    $keys;
   

    for ($i = 0; $i < $generate_count; $i++) {

        $keys_set = 0;
        $voucher = "";

        for($w=0; $w < $word_count; $w++){

            //if ($keys_set < $word_count) {
                $keys_set++;

                //$keys .= $key_bulk[$i];
                $voucher .= $key_bulk[array_rand($key_bulk, 1)];

                //if ($keys_set != $word_count) {
                    //$keys .= $seperator;
                    $voucher .= $seperator;
                //}
            //}
        }
        
        if ($keys_set == $word_count) {
            $voucher=trim($voucher, $seperator);


            //$keys_set = 0;



            $data_bulk = array();

            $data_bulk['voucher'] = $voucher;
            $data_bulk['voucher_type'] = 'SINGLEUSE';
            $data_bulk['user_distributor'] = $user_distributor;
            $data_bulk['user_name'] =  $user_name;
            $data_bulk['download_key'] =  $filename;


            $add_voucher = $vtenant_model->add_voucherBULK($data_bulk);


            if ($add_voucher) {
                $keys .= $voucher . "\n";
            } else {
                $i--;
            }
            //$voucher = "";
        }else{
            $i--;
        }
    }

    //echo $keys;

    //$filename = 'Voucher_Export_'.date(ymdHis).'';

    //----------csv------------

    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=$filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$keys";
}
