<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reset Password </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once 'classes/dbClass.php';
require_once 'classes/appClass.php';
require_once 'classes/systemPackageClass.php';
$page = 'Password Reset';
$package_functions=new package_functions();
require_once 'classes/messageClass.php';
$messageOb = new message_functions();
$MMFailed = 0;
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
    
<?php 
include 'login_header.php'; 
$messageOb->setProduct($admin_system_package);

if(isset($_POST['reset'])){
     $amin_email=$db->getValueAsf("SELECT `email` as f FROM `admin_users` WHERE `user_name`='admin'");
    
    //CHECK User is exsist
	$reset_name=$_POST['username'];
	$reset_email=$_POST['email'];

    $system_package=$db->getValueAsf("SELECT m.`system_package` AS f FROM `exp_mno` m WHERE m.`mno_id`='ADMIN'");

    $qcheck_string="SELECT u.*,m.system_package FROM `admin_users` u , `exp_mno` m 
    WHERE u.user_distributor=m.mno_id  AND `user_name`='%s' AND email='%s'";

    $qcheck = sprintf($qcheck_string,$reset_name,$reset_email);

    $rcheck = $db->selectDB($qcheck);

    if($rcheck['rowCount'] > 0){
        foreach ($rcheck['data'] AS $row) {
            $id = $row['id'];
            $email = $row['email'];
            $user_name = $row['user_name'];
            $full_name = $row['full_name'];
            $distributor = $row['user_distributor'];
            $user_group = $row['group'];
            $user_system_package = $row['system_package'];
			$is_enable_account = $row['is_enable'];
			$messageOb->setProduct($system_package);
        }

// var_dump($is_enable_account);
        if($is_enable_account=='1'){
                $t = date("ymdhis",time());
                $string = $user_name.'|'.$t.'|'.$email;

                $encript_resetkey = $app->encrypt_decrypt('encrypt',$string);

                $unique_key=$db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");
            
                //echo $encript_resetkey;
                // display this if mail send
                $qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$user_name' AND status='pending'";
                $rr = $db->execDB($qq);
                if($rr === true){
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$user_name', 'pending', '$encript_resetkey','$unique_key' ,'$ip', NOW())";
                    $r1 = $db->execDB($q1);
                }
                
                if($r1 === true) {
                    // ***************** send mail *****************//
                    $to = $email;
                    if($user_group == 'admin'){
                        $from=strip_tags($db->setVal("email",'ADMIN'));
                        $email_template = $db->getEmailTemplate('PASSWORD_RESET_MAIL',$user_system_package,'ADMIN');
                    } else{
                        $from=strip_tags($db->setVal("email",$distributor));
                        $email_template = $db->getEmailTemplate('PASSWORD_RESET_MAIL',$user_system_package,'MNO',$distributor);
                        if(strlen($from)==0){
                            $from=strip_tags($db->setVal("email",'ADMIN'));
                        }
                    }
                    

                //   var_dump($email_template);die;  
                    $subject = $email_template[0]['title'];
                    $mail_text  = $email_template[0]['text_details'];   

                    $link = $db->getSystemURL('reset_admin',$login_design,$unique_key); //$global_base_url.'/reset_password_admin'.$extension.'?reset=pwd&reset_key='.$unique_key.'&login='.$login_design;

                    $vars = array(
                        '{$user_full_name}' => $full_name,
                        '{$user_ID}' => $reset_name,
                        '{$link}' => $link
                    );
// var_dump($vars);
                    $message= strtr($mail_text, $vars);

                    $email_send_method=$package_functions->getSectionType("EMAIL_SYSTEM", $system_package);

                    if (strlen($email_send_method) == 0) {
                            $email_send_method = 'PHP_MAIL';
                    }

                    include_once 'src/email/'.$email_send_method.'/index.php';
                    //$cunst_var=NULL;
                    $cunst_var['template']  = $package_functions->getOptions('EMAIL_TEMPLATE', $user_system_package);
                    $cunst_var['system_package'] = $user_system_package;
                    $cunst_var['mno_package'] = $user_system_package;
                    $cunst_var['mno_id'] = $distributor;
                    $mail_obj=new email($cunst_var);


                    $mail_sent=$mail_obj->sendEmail($from,$to,$subject,$message,'',$title);
                    if($mail_sent) {
                        echo "E-mail sent";
                    }
// var_dump($mail_sent);
                    //******************************************************************//

                    $form_step = "step3";
                    $st = 'success';
                    $details = $messageOb->showNameMessage('password_reset_notification', $email);//'An e-mail has been sent to <b>'.$email.'</b> with further instructions.';
                    $MMFailed = 2;
                    $MMFailedMassage = $messageOb->showNameMessage('password_reset_notification', $email); //'An e-mail has been sent to <b>'.$email.'</b> with further instructions.<br>';
    
				    $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Reset login password',$id,'0',$details);
                }

        }else{
            $MMFailed = 1;
            //$sup_mobile = $db->getValueAsf("SELECT sup_mobile AS f FROM exp_support_profile WHERE distributor='ADMIN'");
            $sup_mobile = $package_functions->getMessageOptions('SUPPORT_NUMBER',$user_system_package);
            $MMFailedMassage = $messageOb->showNameMessage('reset_pass_before_active',$sup_mobile).'</br>';
            $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Reset login password',$id,'0',$MMFailedMassage);
        }
    }else{
        $MMFailed = 1;
        $MMFailedMassage = 'Incorrect email address<br>';
        $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Reset login password',0,'0',$MMFailedMassage);
    }
}

// if(isset($_GET['reset']) && $_GET['reset']== 'pwd'){
//     $form_step = "step2";
//     $unique_key = trim($_GET['reset_key']);
//     //CHECK User is exsist

//     $get_rest_key_s = "SELECT `security_key` as f FROM `admin_reset_password` WHERE `unique_key`='%s'";

//     $get_rest_key = sprintf($get_rest_key_s,$unique_key);

//     $reset_key=$db->getValueAsf($get_rest_key);
    
//     $decrypt_resetkey = $app->encrypt_decrypt('decrypt',$reset_key);

//     $key_array = explode("|", $decrypt_resetkey);

//     $uname = $key_array[0];
//     $key = $key_array[2];
    
//     $system_package=$db->getValueAsf("SELECT m.`system_package` AS f FROM `exp_mno` m WHERE m.`mno_id`='ADMIN'");
    
//     $messageOb->setProduct($system_package);

//     $query_sh = "SELECT * FROM admin_reset_password WHERE user_name = '$uname' AND status = 'pending' AND DATE(create_date) > DATE_SUB(NOW(),INTERVAL 1 DAY)";
//     $result_row = $db->select1DB($query_sh);

//     if($result_row){

//         //$result_row = mysql_fetch_array($result_sh);

//         $row_key = $result_row['security_key'];

//         if($row_key == $reset_key){
//             $st = 'success';
//             $details = $messageOb->showMessage('password_reset_completed');//"successfully change password";
//         }else{
//             $st = 'fail';
//             $details = $messageOb->showMessage('password_reset_expired');//"Invalid Request";
//             $form_step = "step3";
//         }
//     }else{
//         $st = 'fail';
//         $details = $messageOb->showMessage('password_reset_invalid');//"Invalid Request";
//         $form_step = "step3";
//     }

// }

// if(isset($_POST['reset_password'])){
// 	$system_package=$db->getValueAsf("SELECT m.`system_package` AS f FROM `exp_mno` m WHERE m.`mno_id`='ADMIN'");
// 	$messageOb->setProduct($system_package);
//     $password = $_POST['password'];
//     $re_password = $_POST['re_password'];
//     $uname = trim($_POST['username']);

//     if($password == $re_password){
//         //$st = 'success'; 
//         $reset_pw_s = "UPDATE admin_users SET password = CONCAT('*', UPPER(SHA1(UNHEX(SHA1('%s'))))) WHERE user_name='%s'";
//         $reset_pw_q = sprintf($reset_pw_s,$password,$uname);
//         $reset_pw_r =  $db->execDB($reset_pw_q);

//         if($reset_pw_r === true){

//             $qqs = "UPDATE admin_reset_password SET status = 'complete', reset_time = NOW() WHERE user_name='%s' AND status='pending'";
//             $qq = sprintf($qqs,$uname);
//             $rr = $db->execDB($qq);

//             if($rr === true){
//                 $form_step = "step4";
//                 $complete_reset = '<font size="small" class="left-pad" color="#0679CA">'.$messageOb->showMessage('password_reset_completed').'<br>
//                     <p align="center">Redirecting ...</p>
//                     </font>';


//                 $qss = "SELECT * FROM admin_users WHERE user_name='%s'";
//                 $qs = sprintf($qss,$uname);
//                 $row = $db->select1DB($qs);

//                 //$row = mysql_fetch_array($rs);
//                 //print_r($row);
//                 $access_role = $row[access_role];
//                 $full_name = $row[full_name];

//                 $MMFailed = '0';
//                 $MMFailedMassage = 'Success';
//                 $_SESSION['login'] = 'yes';
//                 $_SESSION['user_name'] = $uname;
//                 $_SESSION['access_role'] = $access_role;
//                 $_SESSION['full_name'] = $full_name;

//                  $redirect_url = $login_main_url; 
//                 echo '<meta http-equiv="refresh" content="0;url='.$redirect_url.'" />';
//             }
//         }else{
//             $MMFailed = 1;
//             $MMFailedMassage = $messageOb->showMessage('password_reset_failed');//'Something went a wrong. Please try again later';
//             $form_step = "step2";
//         }

//     }else{
//         $MMFailed = 1;
//         $MMFailedMassage = $messageOb->showMessage('password_not_match');//'Password does not matched';
//         $form_step = "step2";
//     }
// }

?>
<style>
    <?php
        $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'";
        $key_result = $db->selectDB($key_query);
        
        foreach ($key_result['data'] AS $row) {
            $camp_theme_color = $row['settings_value'];
        }
        ?>
    <?php //echo $camp_theme_color = '#295176';	?>

</style>

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
    } 
}
?>
 <center>
 <h2 class="hideH">Reset Password</h2></center>
    <div class="account-container reset_pwd_admin">
    <span class="logo-top-img"></span>
       <div class="content clearfix">
          <?php if($form_step == "step1"){ ?>
               <form action="<?php echo $reset_admin_main_url; ?>" method="post" id="reset_form">
                   <div class="login-fields">
                    <h2 style="display: none " class="sign-in">Reset Password</h2>
                    <hr style="display: none " >
                       <div class="field form-group">
                           <label for="username">Email</label>
                           <input autocomplete="off" type="text" onkeyup="checkem();" id="email" name="email" value="" placeholder="Email" class="login username-field form-controls"/>
                       </div>
                       <!-- /field -->
                   </div>
                   <!-- /login-fields -->
                    <div class="field form-group" id="uname"></div>
                   <!-- /login-fields -->
                   <script>
					function checkem(){
                        $('.submit-error').hide();
						$('#reset').attr('disabled', true);
						var email=document.getElementById("email").value;
				          $.ajax({
				                type: 'POST',
				                url: '<?php echo $global_base_url; ?>/ajax/admin_email_pw_reset.php?login=<?php echo $login_design; ?>',
				                data: "email="+email,
				                success: function(data) {
				                	document.getElementById("uname").innerHTML = data;
                                    $('#reset').attr('disabled', false);
				                }
				            });
						}
                    $('#email').bind('input', function() {
                        checkem();
                    });
                   </script>
                    <?php
                        if ($MMFailed == '1') {
                            echo '<div style="display: block;" class="error-wrapper left-pad bubble-pointer mbubble-pointer submit-error"><p>' . $MMFailedMassage . '</p></div>';
                        }
                        if ($MMFailed == '2') {
                            echo '<font size="small" class="left-pad" color="#0679CA">' . $MMFailedMassage . '</font>';
                        }
                    ?>

                        <div class="login-actions">
                            <button type="submit" disabled name="reset" id="reset" class="button btn btn-primary btn-large">Reset</button>
                        </div>
                        <!-- .actions -->
                        <font class="left-pad" style="color:#2757a7!important;"><b>Submit your registered email. You will be sent instructions on how to reset your password to your email address on file.</b></font>
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
    <script>
        $(document).ready(function() {
            $( "input" ).attr( "oninvalid", "validate_func(this)" );

            $("*").on("invalid", function(event) {
                    event.preventDefault();
                });

            $('#password-strength-meter').hide();
        });

        function validate_func(this_is){

            $(this_is).nextAll('div.error-wrapper').first().remove();
            $( this_is ).after( "<div style='display: inline-block;' class='error-wrapper bubble-pointer mbubble-pointer'><p>This field is required.</p></div>" );
            $(this_is).addClass("error");
        }
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
                
                email: {
                    validators: {
                        <?php echo $db->validateField('email'); ?>
                    }
                }
            }
        }).on('success.form.fv', function(e) {});

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
        });
    }).on('success.form.fv', function(e) {});
</script>
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
</body>
</html>
