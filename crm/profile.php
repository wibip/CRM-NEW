<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
 <?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL&~E_WARNING&~E_NOTICE);

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

 require_once 'classes/systemPackageClass.php';
 $package_function=new package_functions();



 $login_user_name = $_SESSION['user_name'];
$user_type=$db->getValueAsf("SELECT `user_type` AS f FROM admin_users WHERE user_name = '$login_user_name'");
 if($user_type=="MVNO" or $user_type=="MVNO_ADMIN"){
	 // $package_function->getDistributorMONPackage($login_user_name);
	 $activation_method=$package_function->getSectionType("VERIFI_METHORD",$package_function->getDistributorMONPackage($login_user_name));
 }
/*  elseif($user_type=="MNO"){
	 $activation_method=$package_function->getSectionType("VERIFI_METHORD",$package_function->getPackage($login_user_name));
 } */

?>



<head>
<meta charset="utf-8">
<title>My Profile</title>

<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">

<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

<link href="css/font-awesome.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<!-- <link href="css/passwordStrenthMeater.css" rel="stylesheet"> -->
<link rel="stylesheet" href="css/bootstrapValidator.css"/>
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

    <!-- Add jQuery library -->

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>


<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<!-- <style type="text/css">
		@import url(css/face.css);
		meter {
			/* Reset the default appearance */
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;

			margin: 0 auto 1em;
			width: 100%;
			height: .5em;

			/* Applicable only to Firefox */
			background: none;
			background-color: rgba(0,0,0,0.1);
		}

		meter::-webkit-meter-bar {
			background: none;
			background-color: rgba(0,0,0,0.1);
		}

		meter[value="1"]::-webkit-meter-optimum-value { background: red; }
		meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
		meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
		meter[value="4"]::-webkit-meter-optimum-value { background: green; }

		meter[value="1"]::-moz-meter-bar { background: red; }
		meter[value="2"]::-moz-meter-bar { background: yellow; }
		meter[value="3"]::-moz-meter-bar { background: orange; }
		meter[value="4"]::-moz-meter-bar { background: green; }

		.feedback {
			color: #9ab;
			font-size: 90%;
			padding: 0 .25em;
			font-family: Courgette, cursive;
			margin-top: 1em;
		}
	</style> -->

	

<?php

include 'header.php';
// echo $user_distributor;


if(isset($_GET['t'])){

	$tab=$_GET['t'];

}
else{
	$tab = 1;
}

if(isset($_POST['full_name'])){
	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret1']) {
		$full_name = $_POST['full_name'];
		$mobile = $_POST['mobile'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$_SESSION['full_name'] = $full_name;
		$old_email=$db->getValueAsf("SELECT email AS f FROM admin_users WHERE user_name='$username'");


		$sql = "UPDATE `admin_users` SET `mobile` = '$mobile', `full_name`= '$full_name',email='$email' WHERE `user_name` = '$username'";
		$result = $db->execDB($sql);
		//echo $result = $db->execDB($sql);

        $sqlnew = "UPDATE `exp_mno` SET `phone1` = '$mobile' WHERE `mno_id` = '$username'";
        //$result2 = mysql_query($sqlnew);
        $result2 = $db->execDB($sqlnew);

		if ($result === true) {
            /*$sql = "UPDATE `exp_mno` SET `phone1` = '$mobile', `full_name`= '$full_name',email='$email' WHERE `user_name` = '$username'";
        $result = mysql_query($sql);*/

            if($old_email != $email){
                $cunst_var = array(
                    "template" => ""
                );

                switch ($user_type){
                    case 'ADMIN' :{
                        $rcheck_q="SELECT u.user_name,u.email,u.mobile,u.full_name,u.user_distributor,m.system_package,m.system_package AS user_system_package,m.mno_id 
                                  FROM admin_users u LEFT JOIN exp_mno m ON u.user_distributor=m.mno_id WHERE u.user_name='$username'";
                        break;
                    }
                    case 'MNO' :{
                        $rcheck_q="SELECT u.user_name,u.email,u.mobile,u.full_name,u.user_distributor,m.system_package AS user_system_package,(SELECT system_package FROM exp_mno WHERE mno_id='ADMIN') AS system_package,'ADMIN' AS mno_id
                                  FROM admin_users u LEFT JOIN exp_mno m ON u.user_distributor=m.mno_id WHERE u.user_name='$username'";
                        break;
                    }
                    case 'SUPPORT' :{
                        $rcheck_q="SELECT u.user_name,u.email,u.mobile,u.full_name,u.user_distributor,m.system_package AS user_system_package,(SELECT system_package FROM exp_mno WHERE mno_id='ADMIN') AS system_package,'ADMIN' AS mno_id
                                  FROM admin_users u LEFT JOIN exp_mno m ON u.user_distributor=m.mno_id WHERE u.user_name='$username'";
                        break;
                    }
                    case 'MVNO_ADMIN':{
                        $rcheck_q="SELECT u.user_name,u.email,u.mobile,u.full_name,u.user_distributor,m.system_package,p.system_package AS user_system_package,p.mno_id
                                  FROM admin_users u LEFT JOIN mno_distributor_parent p ON u.verification_number=p.parent_id
                                  LEFT JOIN exp_mno m ON p.mno_id = m.mno_id WHERE u.user_name='$username'";
                        break;
                    }
                    case 'MVNO':{
                        $rcheck_q="SELECT u.user_name,u.email,u.mobile,u.full_name,u.user_distributor,m.system_package,d.system_package AS user_system_package,d.mno_id
                                  FROM admin_users u LEFT JOIN exp_mno_distributor d ON u.user_distributor=d.distributor_code
                                  LEFT JOIN exp_mno m ON d.mno_id = m.mno_id WHERE u.user_name='$username'";
                        break;
                    }
                    default: {
                        $rcheck_q = "";
                        break;
                    }
                }

//echo $rcheck_q;
                // $rcheck = mysql_query($rcheck_q);
                // while($row = mysql_fetch_assoc($rcheck)) {


					$queryResult=$db->selectDB($rcheck_q);
if ($queryResult['rowCount']>0) {
  foreach($queryResult['data'] AS $row){

	
                    //$is_enable_account = $row['is_enable'];
                    $user_system_package = $row['user_system_package'];


                        $email = $row['email'];
                        $mobile = $row['mobile']; 
                        $user_name = $row['user_name'];
                        $full_name = $row['full_name'];
                        $distributor = $row['user_distributor'];
                        $admin_system_package = $row['system_package'];
                        if ($user_type == 'MVNO') {
                            $dis_verticle=$db->getValueAsf("SELECT `bussiness_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code` ='$distributor'");
                        }
                        if ($user_type == 'MVNO_ADMIN') {
                            $dis_verticle=$db->getValueAsf("SELECT `bussiness_type` AS f FROM `exp_mno_distributor` WHERE `parent_id` ='$distributor'");
                        }

                        $admin_id = $row['mno_id'];

                        $t = date("ymdhis", time());
                        $string = $user_name . '|' . $t . '|' . $email;

                        $encript_resetkey = $app->encrypt_decrypt('encrypt', $string);

                        $unique_key=$db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");

                        //echo $encript_resetkey;
                        // display this if mail send
                        $qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$user_name' AND status='pending'";
						$rr =$db->execDB($qq);
						//$rr = mysql_query($qq); 
                        if ($rr === true) {
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
							//$r1 = mysql_query($q1);
							$r1 =$db->execDB($q1);
                        }

                        if ($r1 === true) {
                            // ***************** send mail *****************//
                            $to = $email;
                            //$subject = 'AMF Admin Setup Verification';
                            //$from = strip_tags($db->setVal("email", $admin_id));
                            /*$subject = $db->textTitle('PASSWORD_RESET_MAIL', $admin_id);
                            if (strlen($subject) == 0) {
                                $subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
                            }*/

                            $title = $db->setVal("short_title", $dist);
                            //$link = $db->setVal("global_url", 'ADMIN') . '/reset_password.php?reset=pwd&reset_key='.$unique_key;

                            $login_design = $package_functions->getSectionType("LOGIN_SIGN", $user_system_package);
                            $link = $db->getSystemURL('reset_pwd',$login_design).'?reset=pwd&reset_key='.$unique_key;

                            $support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER', $user_system_package,$dis_verticle);
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
                            if($user_type == 'ADMIN'){
								$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL',$user_system_package,'ADMIN');
								
							} else if($user_type == 'MNO' || $user_type == 'SUPPORT') {
                                $email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL',$user_system_package,'MNO',$user_distributor);
                                $MNO=$user_distributor;

                            }else{
								$mno_system_package = $package_function->getDistributorMONPackage($user_name);
                                $email_content = $db->getEmailTemplateVertical('PASSWORD_RESET_MAIL',$mno_system_package,'MNO',$dis_verticle,$mno_id);
                                $MNO=$db->getValueAsf("SELECT mno_id AS f FROM exp_mno WHERE system_package='$mno_system_package'");


							}
							
							
                            $from=strip_tags($db->setVal("email", $mno_id));
                                  if (empty($from)) {
                                    $from = strip_tags($db->setVal("email", $admin_id));
                                  }
                            

                            $mail_text = $email_content[0]['text_details'];
                            $subject = $email_content[0]['title'];

                            $message = strtr($mail_text, $vars);

                            $email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $admin_system_package);

                            if (strlen($email_send_method) == 0) {
                                $email_send_method = 'PHP_MAIL';
                            }

                            include_once 'src/email/' . $email_send_method . '/index.php';
							
                            $cunst_var['system_package'] = $user_system_package;
                            $cunst_var['mno_package'] = $user_system_package;
                            $cunst_var['mno_id'] = $MNO;
                            $cunst_var['verticle'] = $dis_verticle;
                            //$cunst_var['template']  = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);

                            $mail_obj = new email($cunst_var);

                            $mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message, '', $title);
                            $mail_obj = null;
                            unset($mail_obj);

                            //******************************************************************//
                        }
				}
				
			}



            }




            $message=$message_functions->showMessage('profile_update_success');
            $create_log->save('3002',$message,$sql);
			$_SESSION['msg1']="<div class='alert alert-success' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
			$red_page = 'profile'.$extension;
			header('Location:'.$red_page);
			exit();
		} else {
            $db->userErrorLog('2002', $user_name, 'script - '.$script);

            $message=$message_functions->showMessage('profile_update_failed','2002');
            $create_log->save('2002',$message,$sql);

			$_SESSION['msg1']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
		}

	}else{
    $db->userErrorLog('2004', $user_name, 'script - '.$script);
    $message = $message_functions->showMessage('transection_fail','2004');
    $create_log->save('2004',$message,'update profile');

    $_SESSION['msg1']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
    }

    $tab = 1;
}

if(isset($_POST['new_password'])){
	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret2']) {

		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		$current_password = $_POST['current_password'];

		$pw="SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$current_password'))))) as f";
		// $pw=mysql_query($pw);
		// while($row=mysql_fetch_array($pw)){

		$queryResult_pw=$db->selectDB($pw);
		if ($queryResult_pw['rowCount']>0) {
  		foreach($queryResult_pw['data'] AS $row){

			$password_local = strtoupper($row[f]);

		}
		}
		//echo $password_local.'</br>'; 

		$query2 = "SELECT * FROM `admin_users` WHERE `user_name` = '$login_user_name' ";
		//$ = mysql_query($query2);

		$result2=$db->selectDB($query2);
	
  		foreach($result2['data'] AS $row){
		//while ($row=mysql_fetch_array($result2)) {

			if ($password_local == strtoupper($row[password])) {
                //echo "string";
				if ($new_password == $confirm_password) {
					$qqq = "UPDATE `admin_users` SET `password` = CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$new_password'))))) WHERE `user_name` = '$login_user_name'";
					$rrr = $db->execDB($qqq);
					//$rrr =$db->execDB($qqq);
					if ($rrr === true) {
                        $message=$message_functions->showMessage('password_update_success');
                        $create_log->save('3002',$message,$qqq);
						$_SESSION['msg2']="<div class='alert alert-success' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
					} else {
                        $db->userErrorLog('2002', $user_name, 'script - '.$script);

                        $message=$message_functions->showMessage('password_update_failed','2002');
                        $create_log->save('2002',$message,$qqq);
						$_SESSION['msg2']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
					}

				} else {
                    $db->userErrorLog('2006', $user_name, 'script - '.$script);
                    $message=$message_functions->showMessage('password_not_match','2006');
                    $create_log->save('2006',$message,$qqq);

					$_SESSION['msg2']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
				}

			} else {
				$db->userErrorLog('2006', $user_name, 'script - '.$script);
				
				
				
                if($user_type=='ADMIN' || $user_type=='MNO'){
					$reset_admin_main_url = $db->getSystemURL('reset_admin',$login_design);
                    $message=$message_functions->showNameMessage('incorrect_password',$reset_admin_main_url,'2006');
                }else {
					$reset_main_url = $db->getSystemURL('reset_pwd',$login_design);
                    $message = $message_functions->showNameMessage('incorrect_password', $reset_main_url,'2006');
                }
                $create_log->save('2006',$message,$qqq);
				$_SESSION['msg2']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
			}





		}
    }else{
        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $message = $message_functions->showMessage('transection_fail','2004');
        $create_log->save('2004',$message,'change password in profile');

        $_SESSION['msg2']="<div class='alert alert-danger' style='position: inherit !important;'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message."</strong></div>";
    }

    $tab = 2;
}

?>

<style>
#password-strength-meter {
  display: none;
} 
</style>

<style>
.password-strength-main {
    width: 50%  ;
	
	}
@media (max-width: 768px) {
   .password-strength-main{
	width: 45% ;
	
	}
}
</style>


<div class="main">
<div class="custom-tabs"></div>
	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

                        <div class="widget-header">
                            <i class="icon-book"></i>
                            <h3>Update My Profile</h3>
                        </div>
                            <!-- /widget-header -->

                        <div class="widget-content">

                            <div class="tabbable">
                                
								<ul class="nav nav-tabs">

									<li class="active"><a href="#live_camp" data-toggle="tab"><?php if($new_design=='yes'){ ?>My Profile | Change Password <?php }else{ ?> My Profile  <?php } ?></a></li>

								</ul>


								<div class="tab-content">

										<?php

										$secret=md5(uniqid(rand(), true));
										$_SESSION['FORM_SECRET'] = $secret;



										?>

									<div class="tab-pane active" id="live_camp">
									<h1 class="head">My Profile</h1>
									
										<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg1'])){
													   echo $_SESSION['msg1'];
													   unset($_SESSION['msg1']);


													  }
													  
													  if(isset($_SESSION['msg2'])){
													  	echo $_SESSION['msg2'];
													  	unset($_SESSION['msg2']);
													  
													  
													  }
											      ?>
											  	</div>
									
									
										<form  class="form-horizontal"	action="profile.php?" method="POST" id="profile_form">

										
										
											  	
										
										

											<fieldset>

												<legend>Update My Profile</legend>
											
											  	<?php echo '<input type="hidden" name="form_secret1" id="form_secret1" value="'.$_SESSION['FORM_SECRET'].'" />'; ?>

												<div id="fb_response"></div>
												<?php if($activation_method=="number"){?>
												<div class="control-group">
													<label class="control-label" for="radiobtns">Customer Account Number</label>

													<div class="controls form-group">
														

														<?php
														$query_a = "SELECT `verification_number` AS f FROM admin_users WHERE user_distributor = '$user_distributor' AND `verification_number` IS NOT NULL";

														?>

														<input class="span4 form-controls" id="verification_number" name="verification_number" type="text" value="<?php echo $db->getValueAsf($query_a); ?>" readonly >

														
													</div>
												</div>
												<?php } ?>
												<div class="control-group">
													<label class="control-label" for="radiobtns">User Name</label>

													<div class="controls form-group">
														

														<?php
														$query_a = "SELECT user_name AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="username" name="username" type="text" value="<?php echo $db->getValueAsf($query_a); ?>" readonly>

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Profile Name</label>

													<div class="controls form-group">
														
														<?php
														$query_b = "SELECT full_name AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="full_name" name="full_name" value="<?php echo $db->getValueAsf($query_b); ?>" type="text" maxlength="23">

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Email Address</label>

													<div class="controls form-group">
														
														<?php
														$query_c = "SELECT email AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="email" name="email" value="<?php echo $db->getValueAsf($query_c); ?>" type="text">

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Phone Number </label>

													<div class="controls form-group">
														
														<?php
														$query_d = "SELECT mobile AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="mobile" name="mobile" type="text" placeholder="xxx-xxx-xxxx" maxlength="12" value="<?php echo $db->getValueAsf($query_d); ?>">

														
													</div>
												</div>
												
												                                    <script type="text/javascript">

                                        $(document).ready(function() {

                                            $('#mobile').focus(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });

                                            $('#mobile').keyup(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });

                                            $("#mobile").keydown(function (e) {


                                                var mac = $('#mobile').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{

                                                    if(len == 4){
                                                        $('#mobile').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                            //console.log('mac1 ' + mac);

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#mobile').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                            //console.log('mac2 ' + mac);

                                                        });
                                                    }
                                                }

											//	alert(e.keyCode);
                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                               /*  if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
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

                                                } */

												$("#mobile").keypress(function(event){
     var ew = event.which;
     //alert(ew);
     //if(ew == 8||ew == 0||ew == 46||ew == 45)
    if(ew == 8||ew == 0)
      return true;
     if(48 <= ew && ew <= 57)
      return true;
     return false;
    });

                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });



											$('#full_name').keyup(function(e){

												ck_topval1();

											});

											$('#email').keyup(function(e){

												ck_topval1();

											});

											$('#mobile').keyup(function(e){

												ck_topval1();

											});


                                            
											document.getElementById("submit1").disabled = true;

                                        });



										function ck_topval1(){

											var pname=document.getElementById('full_name').value;
											var pemail=document.getElementById('email').value;
											var pemob=document.getElementById('mobile').value;


											if(pname==''||pemail==''||pemob==''){
												document.getElementById("submit1").disabled = true;

												}else{
													document.getElementById("submit1").disabled = false;

													}



											}

                                        

                                        </script>
												
												

												<div class="form-actions">
													<input type="submit" name="submit1" id="submit1" class="btn btn-primary" value="Update">
												</div>
											</fieldset>

										</form>

										<form id="edit-profile" class="form-horizontal"	action="profile.php" method="POST" onsubmit="return sendform()">



											<fieldset>
		 										<legend>Change My Password</legend>
		 										

												<?php echo '<input type="hidden" name="form_secret2" id="form_secret2" value="'.$_SESSION['FORM_SECRET'].'" />'; ?>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Current Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="current_password" name="current_password" type="password"  required="required">

														</div>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">New Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="new_password" name="new_password" type="password"  required>
															<!-- <meter max="4" id="password-strength-meter"></meter>
															<p id="password-strength-text"></p> -->
															<script>

/* 
														function strbar(){

															var strength = {
																	0: "Worst ",
																	1: "Bad ",
																	2: "Weak ",
																	3: "Good ",
																	4: "Strong "
																}

															var password = document.getElementById('new_password');
															var meter = document.getElementById('password-strength-meter');
															var text = document.getElementById('password-strength-text');

															var val = document.getElementById('new_password').value;
															var result = zxcvbn(val);

															// Update the password strength meter
															//meter.value = result.score;

															//document.getElementById("password-strength-meter").value = result.score;

															document.getElementById("password-strength-meter").setAttribute("value", result.score);

															// Update the text indicator
															if(val !== "") {
																text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>";
															}
															else {
																text.innerHTML = "";
															}

															
															
															} */

																
															</script>
														</div>
													</div>
														<!-- password-strength -->
														<div class="controls form-group pass_str">
										
										<p > <span id="pass_type">This password is indicator</span></p>
										
									   

										<div id="meter_wrapper" class="password-strength-main">
<div id="meter" style="height: 7px;"></div>
</div>

									<script>
									$(document).ready(function(){
														 $("#new_password").keyup(function(){
													  check_pass();
													 });
													});
									</script>

												</div>
												</div>

												<script>
												


														

												function check_pass()
												{
												 var val=document.getElementById("new_password").value;
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

												<div class="control-group">
													<label class="control-label" for="radiobtns">Confirm New Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="confirm_password" name="confirm_password" type="password"  required="required">

														</div>
													</div>
												</div>

<script>
function test(){

        $('div.error-wrapper').remove();
        $('input,select').removeClass("error");

}

$(document).ready(function() {


	$('#current_password, #new_password, #confirm_password').keyup(function(e){

		ck_topval2();

	});

    
	document.getElementById("pwsubmit").disabled = true;


	
});


function ck_topval2(){

	var opw=document.getElementById('current_password').value;
	var npw=document.getElementById('new_password').value;
	var cnpw=document.getElementById('confirm_password').value;


	if(opw==''||npw==''||cnpw==''){
		document.getElementById("pwsubmit").disabled = true;

		}else{
			document.getElementById("pwsubmit").disabled = false;

			}



	}

</script>


												<div class="form-actions">
													<input type="submit" id="pwsubmit" name="submit" onclick="test()" class="btn btn-primary" value="Change">
												</div>
											</fieldset>

										</form>

									</div>
								</div>
							
</div>
                        </div>
							
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



<?php
include 'footer.php';
?>



<script src="js/jquery-1.7.2.min.js"></script>


<!-- 	<script src="js/base.js"></script> -->
	<script src="js/jquery.chained.js"></script>
<!-- 	<script src="js/zxcvbn.js"></script> -->


	<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script>

$(document).ready(function() {
        $('#profile_form').bootstrapValidator({
            framework: 'bootstrap',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                
                email: {
                    validators: {
                        <?php echo $db->validateField('email'); ?>
                    }
                },
				full_name: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>,
						<?php echo $db->validateField('not_require_special_character'); ?>
                    }
                }, 
				mobile: {
                    validators: {
                        <?php echo $db->validateField('mobile'); ?>
                    }
                } 
            }
        });

		$("#product_code").chained("#category");

    });
</script>
	<!-- <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
    $("#product_code").chained("#category");

  });
  </script> -->


<script type="text/javascript">


$(document).ready(function() {


	/* $("#pwsubmit").easyconfirm({locale: {
		title: 'Change Password',
		text: 'Are you sure you want to change password?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#pwsubmit").click(function() {
	}); */


	//ConfirmDialog('Are you sure');

	

	$("#d-edit-profile").submit(function(e){

		var cpass = document.getElementById("current_password").value;
		var npass = document.getElementById("new_password").value;

if(cpass==npass){
	ConfirmDialog('Your new password must be different from your previous password.','','confirm');
}else{
	ConfirmDialog('Are you sure you want to change password?','Change Password','both');
}
		
		return false;
				
            });

function ConfirmDialog(message,title,button_d){
	if(button_d == 'confirm'){

    $('<div></div>').appendTo('body')
                    .html('<div style="display: block; width: auto; min-height: 0px; max-height: 11px; height: auto;">'+message+'</div>')
                    .dialog({
                        modal: true, title: title, zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Confirm: function () {
                                
                                $(this).dialog("close");
								
                            }
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });

				}else{

					 $('<div></div>').appendTo('body')
                    .html('<div style="display: block; width: auto; min-height: 0px; max-height: 11px; height: auto;">'+message+'</div>')
                    .dialog({
                        modal: true, title: title, zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Cancel: function () {


                                $(this).dialog("close");
                            },
                            Confirm: function () {
                                // $(obj).removeAttr('onclick');                                
                                // $(obj).parents('.Parent').remove();
																
                               
                               
								//document.getElementById("edit-profile").submit();
								$( "#submit_hi" ).click();
                                $(this).dialog("close");
								
                            }

                        },
                        close: function (event, ui) {
                            $(this).remove();
                        }
                    });


				}

    }

	});

	</script>




<script type="text/javascript">

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}

</script>

</body>

</html>