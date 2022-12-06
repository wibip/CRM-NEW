<?php ob_start();
session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reset Password </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
<?php

/*classes & libraries*/
require_once 'classes/dbClass.php';
require_once 'classes/appClass.php';
require_once 'classes/systemPackageClass.php';
$package_functions=new package_functions();

require_once 'classes/messageClass.php';
$messageOb = new message_functions();

function check_string($string){
    $regex_icom = '/^[0-9]{12}$|^[a-zA-Z]{3}[0-9]{3,9}$/';
    $regex_email = '/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/';

    if (preg_match($regex_icom,$string))
    {
        return "ac_number";
    }
    elseif(preg_match($regex_email,$string)){
    //elseif(filter_var($string, FILTER_VALIDATE_EMAIL)){
        return "email";
    }
    else
    {
        return "username";
    }
}

$form_step = "step1";
$db = new db_functions(); 
$app = new app_functions();

$reset_method=$db->setVal("pass_reset_method",'ADMIN');
$global_base_url = trim($db->setVal('global_url','ADMIN'),"/");
$extension = trim($db->setVal('extentions','ADMIN'));



?>

   <link href="<?php echo $global_base_url; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $global_base_url; ?>/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo $global_base_url; ?>/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $global_base_url; ?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $global_base_url; ?>/css/pages/signin.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $global_base_url; ?>/css/passwordStrenthMeater.css" rel="stylesheet">
    <script src="<?php echo $global_base_url; ?>/js/jquery-1.7.2.min.js"></script>
    
    <style>
    
    #username_div input:not([type="radio"]) {
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
        margin: 3px 0 !important;
    }

    </style>
<?php 


include 'login_header.php';

$messageOb->setProduct($admin_system_package);

if(isset($_POST['reset'])){

    $form_step = "step1";
    //CHECK User is exsist
    if($reset_method=="icomms") {
        $icomms = trim($_POST['icomms']);
        $username_sel = trim($_POST['sel_username']);

        if(strlen($username_sel) > 0){
            $icomms = $username_sel;
        }

        $string_type = check_string($icomms);

        switch ($string_type){
            case 'ac_number':
            {
                $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`verification_number`='%s' AND u.user_type IN ('MVNO','MVNE')
                
                UNION
                SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.parent_id AS 'dis_bussiness_type',d.system_package AS 'user_system_package' 
                FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                WHERE u.`user_distributor`='%s' AND u.email='%s' AND u.user_type IN ('MVNO_ADMIN')
                                limit 1
                                ";


                $qcheck = sprintf($qcheck_string,$icomms,$icomms,$_POST['icomms']);
                $rcheck1 = $db->selectDB($qcheck);

                    if ($rcheck1['rowCount'] < 1) {

                        $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,d.bussiness_type  AS 'dis_bussiness_type',m.system_package,m.mno_id,d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE d.`property_id`='%s' AND u.user_type IN ('MVNO','MVNE') limit 1
                                        ";


                        $qcheck = sprintf($qcheck_string,$icomms);

                        $rcheck2 = $db->selectDB($qcheck);

                    if ($rcheck2['rowCount'] < 1) {

                        $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id ,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`user_name`='%s' AND u.user_type IN ('MVNO','MVNE')
                     UNION                                               
                    SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id ,d.parent_id AS 'dis_bussiness_type',d.system_package AS 'user_system_package' 
                    FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                                WHERE u.`user_name`='%s' AND u.user_type IN ('MVNO_ADMIN') limit 1";

                    $qcheck = sprintf($qcheck_string,$icomms,$icomms);

                      }  
                    }
                break;
            }

            case 'email':
            {

                $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`email`='%s' AND u.user_type IN ('MVNO','MVNE') AND u.`verification_number` = '%s'
                
                                            UNION
                SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.parent_id AS 'dis_bussiness_type',d.system_package AS 'user_system_package' 
                FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                                            WHERE u.`email`='%s' AND u.user_type IN ('MVNO_ADMIN') AND u.`user_distributor` = '%s'
                        limit 1                      
                ";


                $qcheck = sprintf($qcheck_string,$icomms,$username_sel,$icomms,$username_sel);
                break;
            }

            case 'username':
            {

                $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,d.bussiness_type AS 'dis_bussiness_type',m.mno_id ,d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`user_name`='%s' AND u.user_type IN ('MVNO','MVNE')
                 UNION                                               
                SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package ,d.parent_id AS 'dis_bussiness_type',m.mno_id,d.system_package AS 'user_system_package' 
                FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`user_name`='%s' AND u.user_type IN ('MVNO_ADMIN') limit 1";

                $qcheck = sprintf($qcheck_string,$icomms,$icomms);

                $rcheck1 = $db->selectDB($qcheck);

                if($rcheck1['rowCount'] < 1){

                    $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id ,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE d.`property_id`='%s' AND u.user_type IN ('MVNO','MVNE')";

                    $qcheck = sprintf($qcheck_string,$icomms);

                    $rcheck2 = $db->selectDB($qcheck);

                    if ($rcheck2['rowCount'] < 1) {
                        $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`verification_number`='%s' AND u.user_type IN ('MVNO','MVNE')
                
                        UNION
                        SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.parent_id AS 'dis_bussiness_type',d.system_package AS 'user_system_package' 
                        FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                        WHERE u.`verification_number`='%s' AND u.user_type IN ('MVNO_ADMIN')
                                        limit 1
                                        ";


                        $qcheck = sprintf($qcheck_string,$icomms,$icomms);
                        
                    }


                }

                break;
            }
        }
    }
    
    
    else{
        $username = trim($_POST['username']);

        $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.bussiness_type AS 'dis_bussiness_type',d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
                            WHERE u.`user_name`='%s'
        UNION 
SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.parent_id AS 'dis_bussiness_type',d.system_package AS 'user_system_package' 
FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
WHERE u.`user_name`='%s' limit 1";

        $qcheck = sprintf($qcheck_string,$username,$username);

        //$system_package=$db->getValueAsf("SELECT m.`system_package` AS f FROM `exp_mno` m WHERE m.`mno_id`='ADMIN'");
        //$admin_id='ADMIN';
    }
    $rcheck = $db->selectDB($qcheck);

    if($rcheck['rowCount'] > 0){
        $cunst_var = array(
            "template" => ""
        );

        
        foreach ($rcheck['data'] AS $row) {
			
		    $is_enable_account = $row['is_enable'];
			$user_system_package = $row['user_system_package'];
            $distributor = $row['user_distributor'];
            $dis_vertical = $row['dis_bussiness_type'];
            if ($dis_vertical == $distributor) {
                $dis_vertical = $db->getValueAsf("SELECT bussiness_type AS f FROM exp_mno_distributor WHERE parent_id='$distributor'");
            }
			if($is_enable_account=='1'){
			
            $email = $row['email'];
            $user_name = $row['user_name'];
            $_SESSION["reset_user"] = $user_name;
            $full_name = $row['full_name'];
            $system_package = $row['system_package'];
            
            $admin_id = $row['mno_id'];

            $messageOb->setProduct($system_package);

            $t = date("ymdhis", time());
            $string = $user_name . '|' . $t . '|' . $email;

            $encript_resetkey = $app->encrypt_decrypt('encrypt', $string);

            $unique_key=$db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");

            //echo $encript_resetkey;
            // display this if mail send
            $qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$user_name' AND status='pending'";
            $rr = $db->execDB($qq);
            if ($rr === true) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
                $r1 = $db->execDB($q1);
            }

            if ($r1 === true) {
                // ***************** send mail *****************//
                $to = $email;
                //$subject = 'AMF Admin Setup Verification';
                $from = strip_tags($db->setVal("email", $admin_id));
            	if(strlen($from)==0){
            		$from=strip_tags($db->setVal("email",'ADMIN'));
            	}
                
                
               $email_template = $db->getEmailTemplateVertical('PASSWORD_RESET_MAIL',$system_package,'MNO',$dis_vertical,$admin_id);
     
	           $subject = $email_template[0][title];
	           $mail_text  = $email_template[0][text_details];                
	                
                
                
    /*            
                $subject = $db->textTitle('PASSWORD_RESET_MAIL', $admin_id);
                if (strlen($subject) == 0) {
                    $subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
                }
                $title = $db->setVal("short_title", $dist);
 */

                //$link = '<a href="'.$db->setVal("camp_base_url",'ADMIN').'/reset_password.php?reset=pwd&reset_key='.$encript_resetkey.'">click here</a>';
                $link = $db->getSystemURL('reset_pwd',$login_design,$unique_key); //$global_base_url. '/reset_password'.$extension.'?reset=pwd&reset_key='.$unique_key.'&login='.$login_design;
                $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $user_system_package,$dis_vertical);

                $vars = array(
                    '{$user_ID}' => $user_name,
                    '{$user_full_name}' => $full_name,
                    '{$support_number}' => $support_number,
                    '{$link}' => $link
                );

/*                $mail_text = $db->textVal('PASSWORD_RESET_MAIL', $admin_id);
                if (strlen($mail_text) == 0) {
                    $mail_text = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
                }*/

                $message = strtr($mail_text, $vars);

                $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);

                if (strlen($email_send_method) == 0) {
                    $email_send_method = 'PHP_MAIL';
                }
                


                include_once 'src/email/' . $email_send_method . '/index.php';

                //$cunst_var['template']  = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);

                

                $cunst_var['system_package'] = $user_system_package;
                $cunst_var['mno_package'] = $system_package;
                $cunst_var['mno_id'] = $mno_id;
                $cunst_var['verticle'] = $dis_vertical;

                $mail_obj = new email($cunst_var);
                $mail_obj->mno_system_package = $system_package;
                
                $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message, '', $title);
                $mail_obj = null;
                unset($mail_obj);

                //******************************************************************//
                

                $form_step = "step3";
                $st = 'success';
                $details = $messageOb->showNameMessage('password_reset_notification', $email); // 'An e-mail has been sent to <b>'.$email.'</b> with further instruction.';
                $MMFailed = 2;
                $MMFailedMassage = $messageOb->showNameMessage('password_reset_notification', $email); //'An e-mail has been sent to <b>'.$email.'</b> with further instruction.';
            }

        //
			}elseif($is_enable_account=='8'){
                
                
                $MMFailed = 1;
                //$sup_mobile = $db->getValueAsf("SELECT sup_mobile AS f FROM exp_support_profile WHERE distributor='ADMIN'");
                $MMFailedMassage = $messageOb->showMessage('property_id_not_assigned').'</br>';

                }else{
				
				
				$MMFailed = 1;
				//$sup_mobile = $db->getValueAsf("SELECT sup_mobile AS f FROM exp_support_profile WHERE distributor='ADMIN'");
				$sup_mobile = $package_functions->getMessageOptions('SUPPORT_NUMBER',$user_system_package);


       			 $MMFailedMassage = $messageOb->showNameMessage('reset_pass_before_active',$sup_mobile).'</br>';
				}
		}
    }else{
        $MMFailed = 1;
        $MMFailedMassage = $messageOb->showMessage('reset_no_account').'</br>';
    }
}

//http://localhost/campaign_portal/campaign_portal/reset_password.php?reset=pwd&reset_key=elVhbEV6NmRockV0REwzZjRHMTdVSnora1VFRzM3K1VzTjM1c05WaWRZdmJSRURmMmhCMkYxaHZRVVVVczd5QQ==
if(isset($_GET['reset']) && $_GET['reset']== 'pwd'){

    $form_step = "step2";
    $unique_key = trim($_GET['reset_key']);

    $get_rest_key_string = "SELECT `security_key` as f FROM `admin_reset_password` WHERE `unique_key`='%s'";

    $get_rest_key = sprintf($get_rest_key_string,$unique_key);

	$reset_key=$db->getValueAsf($get_rest_key);
    
	$reset_key = trim($reset_key,'==').'==';
	
    //CHECK User is exsist
    $decrypt_resetkey = $app->encrypt_decrypt('decrypt',$reset_key);

    $key_array = explode("|", $decrypt_resetkey);

    $uname = $key_array[0];
    
     $qcheck = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
    WHERE u.`user_name`='$uname' AND u.user_type IN ('MVNO','MVNE')
    UNION
    SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package'
    FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
    WHERE u.`user_name`='$uname'
    AND u.user_type IN ('MVNO_ADMIN') LIMIT 1
    ";
    
    $rcheck = $db->selectDB($qcheck);
    
    foreach ($rcheck['data'] AS $row) {
    		
    		$system_package = $row['system_package'];

    }

    if(strlen($system_package)==1 || !isset($system_package)){
        $system_package = $package_functions->getAdminPackage();
    }
    $messageOb->setProduct($system_package);

    $key = $key_array[2];

    $query_sh = "SELECT * FROM admin_reset_password WHERE user_name = '$uname' AND status = 'pending' AND DATE(create_date) > DATE_SUB(NOW(),INTERVAL 1 DAY)";
    $result_row = $db->select1DB($query_sh);
	
    if($result_row){

        //$result_row = mysql_fetch_array($result_sh);

        $row_key = $result_row['security_key'];

        if($row_key == $reset_key){
            $st = 'success';
            $details = $messageOb->showMessage('password_reset_completed'); //"successfully change password";
        }else{
		
		
		
		
		
		 $query_sh2 = "SELECT IF(DATE(create_date) > DATE_SUB(NOW(),INTERVAL 1 HOUR),'ok','no') as expire, status FROM admin_reset_password WHERE user_name = '$uname'";
		$result_row2 = $db->select1DB($query_sh2);
	    
		//$result_row2 = mysql_fetch_array($result_sh2);
       $expire_date = $result_row2['expire'];
	  $expire_status = $result_row2['status'];
		
			if($expire_status == 'complete'){
				$details = $messageOb->showMessage('password_reset_expired'); //'Password reset request is already completed';
			}
			else if($expire_date == 'no'){
				$details = $messageOb->showMessage('password_reset_expired'); //'Password reset request is expired';
			}
			else{
			$details = $messageOb->showMessage('password_reset_invalid'); //"Invalid Request";
			}
            $st = 'fail';           
            $form_step = "step3";
        }
    }else{
	


        $st = 'fail';
        $details = $messageOb->showMessage('password_reset_invalid');//"Invalid Request";
        $form_step = "step3";
    }

}




if(isset($_POST['reset_password'])){

    $password = $_POST['password'];
    $re_password = $_POST['re_password'];
    $uname = $_POST['username'];

     $qcheck_string = "SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package' FROM `admin_users` u LEFT JOIN exp_mno_distributor d ON u.user_distributor = d.distributor_code LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
    WHERE u.`user_name`='%s' AND u.user_type IN ('MVNO','MVNE')
    UNION
    SELECT u.email,u.user_name,u.full_name,u.user_distributor,u.is_enable,m.system_package,m.mno_id,d.system_package AS 'user_system_package'
    FROM `admin_users` u LEFT JOIN `mno_distributor_parent` d ON u.user_distributor = d.parent_id LEFT JOIN exp_mno m ON d.mno_id=m.mno_id
    WHERE u.`user_name`='%s'
    AND u.user_type IN ('MVNO_ADMIN') LIMIT 1
    ";

    $qcheck = sprintf($qcheck_string,$uname,$uname);
    
    $rcheck = $db->selectDB($qcheck);
   
    foreach ($rcheck['data'] AS $row) {
    
    	$system_package = $row['system_package'];
    	$messageOb->setProduct($system_package);
    }
    
    
    if($password == $re_password){  
        //$st = 'success';
        $reset_pw_s = "UPDATE admin_users SET password = CONCAT('*', UPPER(SHA1(UNHEX(SHA1('%s'))))) WHERE user_name='%s'";
        $reset_pw_q = sprintf($reset_pw_s,$password,$uname);
        $reset_pw_r = $db->execDB($reset_pw_q);

        if($reset_pw_r === true){

            $qqs = "UPDATE admin_reset_password SET status = 'complete', reset_time = NOW() WHERE user_name='%s' AND status='pending'";
            $qq = sprintf($qqs,$uname);
            $rr = $db->execDB($qq);

            if($rr === true){
                $form_step = "step4";
                $complete_reset = '<font size="small" class="left-pad" color="#0679CA">'.
                		$messageOb->showMessage('password_reset_completed').'<p >Redirecting ...</p></font>';


                $qss = "SELECT access_role, full_name FROM admin_users WHERE user_name='%s'";
                $qs = sprintf($qss,$uname);
                $row = $db->select1DB($qs);

                //$row = mysql_fetch_array($rs);
                $access_role = $row[access_role];
                $full_name = $row[full_name];

                $MMFailed = '0';
                $MMFailedMassage = 'Success';
                $_SESSION['login'] = 'yes';
                $_SESSION['user_name'] = $uname;
                $_SESSION['access_role'] = $access_role;
                $_SESSION['full_name'] = $full_name;

                $redirect_url = $login_main_url;// $global_base_url."?login=".$login_design;//"index.php";
               // header( "Refresh:1; url=$redirect_url", true, 303);
                
                //header('location: '.$redirect_url);
                echo '<meta http-equiv="refresh" content="0;url='.$redirect_url.'" />';
            }
            /*$form_step = "step4";
            $complete_reset = '<div class="alert alert-success">	Your new password has been saved..<br>
                    Login URL :- <a href="'.$db->setVal("camp_base_url","ADMIN").'">'.$db->setVal("camp_base_url","ADMIN").'</a>
                    </div>';*/
        }else{
            $MMFailed = 1;
            $MMFailedMassage = $messageOb->showMessage('password_reset_failed'); // 'Something went a wrong. Please try again later';
            $form_step = "step2";
        }
        
    }else{
        $MMFailed = 1;
        $MMFailedMassage = $messageOb->showMessage('password_not_match'); //'The New Passwords you entered does not match. Please retry again';
        $form_step = "step2";
    }
}






?>





<style>

    <?php
        $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'";
        $key_result = $db->selectDB($key_query);
        
        foreach ($key_result['data'] AS $row) {
            $camp_theme_color = $row['settings_value'];
        }
        ?>
  

</style>

<?php //echo $camp_theme_color = '#295176';	?>


<?php
$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_LOGO'";
$key_result = $db->selectDB($key_query);

foreach ($key_result['data'] AS $row) {
    $logo2 = $row['settings_value'];
}



if($login_title_position=="body_top_center"){
	?>

        	 <br>
         

        	<?php }else{

        	if(isset($logo2) && $logo2 != "") {
            ?>
            <br>
            <center>
<?php if(file_exists("image_upload/welcome/".$logo2)){  ?>
                <img class="logo-center" src="<?php echo $global_base_url; ?>/image_upload/welcome/<?php echo $logo2; ?>" border="0" style="max-height:65px;" />

<?php } ?>
            </center>

        <?php
        } }
        
        

//echo $complete_reset;
?>




 <center>
 <h2 class="hideH">Reset Password</h2></center>
<div class="account-container reset_pwd">

    <span class="logo-top-img"></span>
    
       <div class="content clearfix">
       <?php if($form_step == "step4"){
           echo $complete_reset;
       }
       elseif($form_step == "step1"){ ?>

               <form action="<?php echo $reset_main_url; ?>" method="post" id="reset_form">


                   <div class="login-fields">

                    <h2 style="display: none " class="sign-in hideH">Reset Password</h2>
                    <hr style="display: none " >

                       <?php if($reset_method=="icomms"){ ?>

                       <div class="field form-group">
                           <label for="username">Customer Email</label>
                           <input type="text" id="icomms" name="icomms" value="" autocomplete="off" placeholder="Customer Email"
                                  class="login username-field form-controls"/>

                           <script type="text/javascript">

                               var getuserTimer=null;
                               /*$("#icomms").keyup(function(){
                                   var email = $("#icomms").val();
                                   //alert(email);
                                   getuserTimer=setTimeout(getUserNames(email), 3000);
                               });*/

                               


                                $("#icomms").on('input', function() { 
                                   
                                   var email = $(this).val();
                                   //alert(email);
                                   getuserTimer=setTimeout(getUserNames(email), 3000);
                                 
                                });

                               /*$("#icomms").on('past',function(){
                                   var email = $("#icomms").val();
                                   //alert(email);
                                   getUserNames(email);
                               });*/


                               $("#icomms").keydown(function(){
                                   clearTimeout(getuserTimer);
                               });

                               /*$('#icomms').bind('input', function() {
                                   var email = $("#icomms").val();
                                   getUserNames(email);
                               });*/

                               function getUserNames(email) {
                                   $('#reset').attr('disabled', true);

                                   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                   //var str = email;
                                   //alert(re.test(email));

                                   if (re.test(email)) {
                                       /*  alert(ssid);    */
									   
                                       //var emai=ssid;
                                       var formData = {email: email,MVNOemail:'',login:'<?php echo $login_design; ?>'};
                                       $.ajax({
                                           url: "<?php echo $global_base_url; ?>/ajax/getUsernames.php",
                                           type: "GET",
                                           data: formData,
                                           success: function (data) {
                                               console.log(data);
                                               var data_ar = data.split(',');
                                               if(data_ar.length>1){

                                                   var result = '<label for="username">Select Business ID/Account ID</label><div class="controls">';
                                                   for (var i=0;i<data_ar.length;i++){
                                                       if(i==0){

                                                           result+='<input checked type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i]+'</br>';
                                                       }else if(i<(data_ar.length-1)){
                                                           result+='<input type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i]+'</br>';
                                                       }else{
                                                           result+='<input type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i];

                                                       }
                                                   }

                                                   result+='</div>';
                                                   document.getElementById("username_div").innerHTML = result;

                                               }else{
                                                   document.getElementById("username_div").innerHTML ='<input type="hidden" name="sel_username" value="'+data_ar[0]+'">';
                                               }
                                           },
                                           error: function (jqXHR, textStatus, errorThrown) {
                                               document.getElementById("username_div").innerHTML ='';
                                           }
                                       });
                                   }
                                   else{
                                    //alert('test2');
                                       var formData = {email: email,login:'<?php echo $login_design; ?>',type:'property'};
                                       $.ajax({
                                           url: "<?php echo $global_base_url; ?>/ajax/getUsernames.php",
                                           type: "GET",
                                           data: formData,
                                           success: function (data) {
                                               var data_ar = data.split(',');
                                               if(data_ar.length>1){

                                                   var result = '<label for="username">Select User</label><div class="controls">';
                                                   for (var i=0;i<data_ar.length;i++){
                                                       if(i==0){

                                                           result+='<input checked type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i]+'</br>';
                                                       }else if(i<(data_ar.length-1)){
                                                           result+='<input type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i]+'</br>';
                                                       }else{
                                                           result+='<input type="radio" name="sel_username" value="'+data_ar[i]+'">'+'<label style="display: inline-block !important;" ></label>&nbsp;&nbsp;&nbsp;'+data_ar[i];

                                                       }
                                                   }

                                                   result+='</div>';
                                                   document.getElementById("username_div").innerHTML = result;

                                               }else{
                                                   document.getElementById("username_div").innerHTML ='<input type="hidden" name="sel_username" value="'+data_ar[0]+'">';
                                               }
                                           },
                                           error: function (jqXHR, textStatus, errorThrown) {
                                               document.getElementById("username_div").innerHTML ='';
                                           }
                                       });
                                   }

                                   $('#reset').attr('disabled', false);
                               }
                           </script>
                       </div>

                       <div class="field form-group" id="username_div">

                       </div>
                       <!-- /field -->
                        <?php }else{ ?>
                           <p>Enter your user name to reset your password.</p>
                           <div class="field form-group">
                               <label for="username">Username</label>
                               <input type="text" id="username" name="username" value="" placeholder="Username"
                                      class="login username-field form-controls"/>
                           </div>
                           <!-- /field -->
                       <?php } ?>


                   </div>
                   <!-- /login-fields -->

                       <?php
                        //    if ($MMFailed == '1') {
                        //        echo '<div style="display: inline-block;" class="error-wrapper left-pad bubble-pointer mbubble-pointer submit-error"><p>' . $MMFailedMassage . '</p></div>';
                        //    }
                       ?>
                       <?php
                        //    if ($MMFailed == '2') {
                        //        echo '<font size="small" class="left-pad" color="#0679CA">' . $MMFailedMassage . '</font>';
                        //    }
                       ?>

                       <div class="login-actions">
                           <button type="submit" disabled name="reset"  id="reset" class="button btn btn-primary btn-large">Reset</button>
                       </div>
                       <!-- .actions -->
<br>
<font class="left-pad" style="color:#2757a7!important;"><b>You will be sent instructions on how to reset your password to your email address on file.</b></font>

               </form>

          <?php }elseif($form_step == "step2"){ ?>

              <form action="<?php echo $reset_main_url; ?>" method="post" id="reset_form1">

                  <div class="login-fields">

                    <h2 style="display: none " class="sign-in hideH">Reset Password</h2>
                    <hr style="display: none " >

                      <input type="hidden" id="username" name="username" value="<?php echo $uname; ?>">

                      <div class="field">
                          <div class="controls form-group">

                              <label for="password">New Password</label>
                              <input type="password" id="password" name="password" value="" placeholder="New Password" class="login password-field form-control"  />
                              <!-- <meter max="4" id="password-strength-meter"></meter>
                              <div id="password-strength-text"></div> -->
                              <script>
                                 /*  var strength = {
                                      0: "Worst ",
                                      1: "Bad ",
                                      2: "Weak ",
                                      3: "Good ",
                                      4: "Strong "
                                  }

                                  var password = document.getElementById('password');
                                  var meter = document.getElementById('password-strength-meter');
                                  var text = document.getElementById('password-strength-text');

                                  password.addEventListener('input', function()
                                  {
                                      var val = password.value;
                                      var result = zxcvbn(val);

                                      // Update the password strength meter
                                      meter.value = result.score;

                                      // Update the text indicator
                                      if(val !== "") {
                                          text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>";
                                      }
                                      else {
                                          text.innerHTML = "";
                                      }


                                  }); */
                              </script>
                              	
                          </div>
                                  
                          <!-- password-strength -->
													<div class="controls form-group pass_str">
										
										<p > <span id="pass_type">This password is indicator</span></p>
										
									   

										<div id="meter_wrapper" class="password-strength-main">
<div id="meter" style="height: 7px;"></div>
</div>

									<script>
									$(document).ready(function(){
														 $("#password").keyup(function(){
													  check_pass();
													 });
													});
									</script>

										

										</div>
                      </div>

                      <script>
												


														

												function check_pass()
												{ 
												 var val=document.getElementById("password").value;
												 var meter=document.getElementById("meter");
												 var no=0;
												 if(val!="")
												 {
												  // If the password length is less than or equal to 6
												  if(val.length<=6)no=1;
												
												  // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
												  if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;
												
												  // If the password length is greater than 6 and contain alphabet,number,special character respectively
												  if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;
												
												  // If the password length is greater than 6 and must contain alphabets,numbers and special characters
												  if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;
												
												  if(no==1)
												  {
												   $("#meter").animate({width:'25%'},300);
												   meter.style.backgroundColor="red";
												   document.getElementById("pass_type").innerHTML="This password is very weak";
												  }
												
												  if(no==2)
												  {
												   $("#meter").animate({width:'50%'},300);
												   meter.style.backgroundColor="yellow";
												   document.getElementById("pass_type").innerHTML="This password is weak";
												  }
												
												  if(no==3)
												  {
												   $("#meter").animate({width:'75%'},300);
												   meter.style.backgroundColor="orange";
												   document.getElementById("pass_type").innerHTML="This password is medium";
												  }
												
												  if(no==4)
												  {
													$("#meter").animate({width:'100%'},300); 
												   meter.style.backgroundColor="green";
												   document.getElementById("pass_type").innerHTML="This password is strong";
												  }
												 }
												
												 else
												 {
													$("#meter").animate({width:'100%'},300); 
												   meter.style.backgroundColor="rgba(0, 0, 0, 0.1)";
												  document.getElementById("pass_type").innerHTML="This password is indicator"; 
												 }
												}
												
												
												
																									
												
												
																									</script>


                      <div class="field ">
                          <label for="re_password">Retype Password</label>
                          <div class="controls form-group">

                          <input type="password" id="re_password" name="re_password" value="" placeholder="Retype Password" class="login password-field form-control"  />

                          </div>
                      </div>
                      <!-- /field -->


                  </div>
                  <!-- /login-fields -->

                  <?php
                  if ($MMFailed == '1') {
                  	echo '<div style="display: block;" class="error-wrapper left-pad bubble-pointer mbubble-pointer submit-error"><p>' . $MMFailedMassage . '</p></div>';

                      //echo '<font size="small" color="red">' . $MMFailedMassage . '</font>';
                  }
                  ?>
                  <?php
                  if ($MMFailed == '2') {
                      echo '<font size="small" class="left-pad" color="#0679CA">' . $MMFailedMassage . '</font>';
                  }
                  ?>

                  <div class="login-actions">
                      <button type="submit" disabled name="reset_password" class="button btn btn-primary btn-large">Reset</button>
                  </div>
                  <!-- .actions -->


              </form>

          <?php } elseif($form_step == "step3"){?>

              <form action="<?php echo $reset_main_url; ?>" method="post" id="reset_form">
                  <h1 class="hideH">Reset Password</h1>

                  <div class="login-fields">
                    <h2 style="display: none " class="sign-in">Reset Password</h2>
                    <hr style="display: none " >
                  </div>
                  <!-- /login-fields -->

                  <?php
                  if ($st == 'fail') {

                  	echo '<div style="display: block;" class="error-wrapper left-pad bubble-pointer mbubble-pointer submit-error"><p>' . $details . '</p></div>';

                   //   echo '<font size="small" color="red">' . $details . '</font>';
                  }
                  ?>
                  <?php
                  if ($st == 'success') {
                      echo '<font size="small" class="left-pad" color="#0679CA">' . $details . '</font>';
                  }
                  ?>




              </form>

          <?php } ?>


       </div>
       <!-- /content -->
   </div> <!-- /account-container -->

<br><br>
<center>
        <?php echo $db->setVal('footer_copy','ADMIN'); ?>
        </center>
    <?php

            if($camp_layout=="COX"){
         ?>
         <style>

         btn[disabled], .btn:disabled {
            background-color: #dadadc !important;
            color: #979798 !important;
            font-size: 16px !important;
        }
/*
         button[class*="close"]:not(.fancy_close) {
             display: none !important;
         }

         .alert strong {
             font-weight: normal !important;
         }

         .alert-success strong {
             background: url(layout/COX/img/success.png) 0 0 no-repeat;
             padding: 0 5px 0 31px;
         }

         .alert-success {
             background-color: #E5F3EA !important;
             border-color: #00892D !important;
             color: #0c0c0c !important;
             border-style: solid !important;
             border-width: 1px 0 !important;
             -webkit-border-radius: 0px !important;
             border-radius: 0px !important;
         }


         .alert {
             padding: 8px 10px 8px 20px !important;
         }
  */


         </style>
         <script>

            $(document).ready(function() {
        
                $('#password-strength-meter').hide();

            });

          

            $('input').keyup(function (e) { 
                $('.submit-error').hide();
            });

            $('button[type="submit"]').click(function (e) { 
                $('.submit-error').hide();
            });

         </script>
          <?php } ?>


<script src="<?php echo $global_base_url; ?>/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $global_base_url; ?>/js/bootstrap.js"></script>

<script src="<?php echo $global_base_url; ?>/js/signin.js"></script>
<script src="<?php echo $global_base_url; ?>/js/zxcvbn.js"></script>

<script type="text/javascript" src="<?php echo $global_base_url; ?>/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $global_base_url; ?>/js/bootstrapValidator.js"></script>

<script>

$(document).ready(function() {
        $('#reset_form').bootstrapValidator({
            framework: 'bootstrap',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                
                icomms: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>,
                        regexp: {
                            regexp: '^[a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,15})$|^[0-9]{12}$|^[a-zA-Z0-9_-]{1,30}$|^[a-zA-Z]{3}[0-9]{7}$',
                            message: '<p>Incorrect Email</p>'
                        }
                    }
                },
                username: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                password: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        }).on('success.form.fv', function(e) {
        });

    $('#reset_form1').bootstrapValidator({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            password: {
            validators: {
                <?php echo $db->validateField('notEmpty'); ?>
            }
            },
            re_password: {
                validators: {
                    identical: {
                        field: 'password',
                        message: '<p>The new passwords you entered do not match. Please try again</p>'
                    },
                    <?php echo $db->validateField('notEmpty'); ?>
                }
            }
        }
    }).on('success.form.fv', function(e) {
    });
});
</script>

</body>

</html>
