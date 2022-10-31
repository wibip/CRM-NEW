<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
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
require_once 'classes/CommonFunctions.php';
$db = new db_functions();
require_once dirname(__FILE__) . '/models/userMainModel.php';
$user_model = new userMainModel();
require_once dirname(__FILE__) . '/models/clientUserModel.php';
$client_model = new clientUserModel();
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');

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
?>

<head>
	<meta charset="utf-8">
	<title>Users - Clients Management</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">
	<!--Alert message css-->
	<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
	<!-- tool tip css -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
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
	</style>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>

	<?php
	include 'header.php';
	// TAB Organization
	if (isset($_GET['t'])) {
		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		//initially page loading///
		$tab1 = "set";
	}

	$priority_zone_array = array(
    "America/New_York",
    "America/Chicago",
    "America/Denver",
    "America/Los_Angeles",
    "America/Anchorage",
    "Pacific/Honolulu",
);

function userUpdateLog($user_id, $action_type, $action_by,$db)
{
		$update_query = "INSERT INTO `crm_clients_update` (
															`user_name`,
															`password`,
															`access_role`,
															`user_type`,
															`user_distributor`,
															`full_name`,
															`email`,
															`language`,
															`mobile`,
															`is_enable`,
															`create_date`,
															`create_user`,
															`update_type`,
															`update_by`,
															`update_date`
															)(SELECT
															`user_name`,
															`password`,
															`access_role`,
															`user_type`,
															`user_distributor`,
															`full_name`,
															`email`,
															`language`,
															`mobile`,
															`is_enable`,
															`create_date`,
															`create_user`,
															'$action_type',
															'$action_by',
															NOW()
															FROM
															`crm_clients`
															WHERE id='$user_id')";
		$ex_update_log = $db->execDB($update_query);
		return $ex_update_log;
	}

	if (isset($_POST['submit_1'])) {
		if ($user_type != "SALES") {
			$full_name = $_POST['full_name_1'];
			$br_q = "SHOW TABLE STATUS LIKE 'crm_clients'";
			$result2=$db->selectDB($br_q);
	
			foreach($result2['data'] AS $rowe){
				$auto_inc = $rowe['Auto_increment'];
			}

			$new_user_name = str_replace(' ', '_', strtolower(substr($full_name, 0, 5) . 'u' . $auto_inc));
			$password  = CommonFunctions::randomPassword();

			if ($user_type == 'SALES') {
				$msg = $message_functions->showNameMessage('user_create_success', $new_user_name);

				$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $msg . '</strong></div>';
			} else {
				$access_role = $_POST['access_role_1'];
				$user_type = $_POST['user_type'];
				$loation = $_POST['loation'];
				$email = $_POST['email_1'];
				$language = $_POST['language_1'];
				$timezone = $_POST['timezone_1'];
				$mobile = $_POST['mobile_1'];

				$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$password\"))))) AS f";
				$updated_pw='';
				$pw_results=$db->selectDB($pw_query);
  				foreach($pw_results['data'] AS $row){
					$updated_pw = strtoupper($row['f']);
				}

				$query = "INSERT INTO crm_clients
						(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, `timezone`, mobile, is_enable, create_date,create_user)
						VALUES ('$new_user_name','$updated_pw','$access_role','$user_type','$loation','$full_name','$email', '$language' ,'$timezone', '$mobile','2',now(),'$user_name')";
				$ex =$db->execDB($query);

				if ($ex===true) {
					if ($user_type == 'ADMIN') {
						$dist = 'ADMIN';
					} else if ($user_type == 'MNO') {
						$dist = $user_distributor;
					} else {
						$kmno_query = "SELECT mno_id FROM exp_mno_distributor where distributor_code = '$user_distributor'";
						$query_results=$db->selectDB($kmno_query);
						foreach($query_results['data'] AS $row){
							$dist = $row['mno_id'];
						}
					}

					if ($access_role == 'ADMIN') {
						$acc_type = 'Admin';
					} else {
						$acc_type = 'User';
					}

					$to = $email;

					if ($package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {
						$email_content = $db->getEmailTemplate('USER_MAIL', $system_package, 'MNO', $user_distributor);
						$a = $email_content[0]['text_details'];
						$subject = $email_content[0]['title'];

						if (strlen($subject) == '0') {
							$email_content = $db->getEmailTemplate('USER_MAIL', $package_functions->getAdminPackage(), 'ADMIN');
							$a = $email_content[0]['text_details'];
							$subject = $email_content[0]['title'];
						}
					} else {
						$a = $db->textVal('MAIL', 'ADMIN');
						$subject = $db->textTitle('MAIL', 'ADMIN');
					}

					$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type);
					$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
					$link = $db->getSystemURL('login', $login_design);

					$vars = array(
						'{$user_full_name}' => $full_name,
						'{$short_name}'        => $db->setVal("short_title", $user_distributor),
						'{$account_type}' => $user_type,
						'{$user_name}' => $new_user_name,
						'{$password}' => $password,
						'{$support_number}' => $support_number,
						'{$link}' => $link

					);

					$message_full = strtr($a, $vars);
					$message = $message_full;
					$from = strip_tags($db->setVal("email", $mno_id));
					if (empty($from)) {
						$from = strip_tags($db->setVal("email", $user_distributor));
						if (empty($from)) {
							$from = strip_tags($db->setVal("email", "ADMIN"));
						}
					}

					$title = $db->setVal("short_title", $user_distributor);

					$email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
					include_once 'src/email/' . $email_send_method . '/index.php';
					$cunst_var = array();
					//$cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
					$cunst_var['system_package'] = $system_package;
					$cunst_var['mno_package'] = $system_package;
                    $cunst_var['mno_id'] = $mno_id;
                    $cunst_var['verticle'] = $property_business_type;
					$mail_obj = new email($cunst_var);

					$mail_obj->mno_system_package = $system_package;
					$mail_sent = $mail_obj->sendEmail($from, $to, $subject, $message_full, '', $title);
					$msg = $message_functions->showNameMessage('user_create_success', $new_user_name);

					$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $msg . '</strong></div>';

					//Activity log
					$db->userLog($user_name, $script, 'Create User', $new_user_name);
				} else {
					$msg = $message_functions->showMessage('user_create_fail', '2001');
					$db->userErrorLog('2001', $user_name, 'script - ' . $script);
					$_SESSION['msg2'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $msg . '</strong></div>';
				}
			}
		} else {
			$msg = $message_functions->showNameMessage('user_create_success', $new_user_name);

			$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $msg . '</strong></div>';
		}
	}
	//assign Roles removes
	elseif (isset($_GET['remove_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {
			$remove_id = $_GET['remove_id'];
			$qq1 = "INSERT INTO `admin_access_roles_modules_archive`
				(`access_role`, `module_name`, `distributor`, `create_user`, `archive_by`, `archive_date`)
				(SELECT  `access_role`, `module_name`, `distributor`, `create_user`, '$user_name', NOW()
				FROM `admin_access_roles_modules` WHERE `id`='$remove_id' LIMIT 1)";
			//$rr1 = mysql_query($qq1);
			$rr1 = $db->execDB($qq1);

			$qq2 = "DELETE FROM `admin_access_roles_modules` WHERE `id`='$remove_id'";
			$rr2 = $db->execDB($qq2);

			if ($rr1===true && $rr2===true) {
				$msg = $message_functions->showMessage('module_assign_remove_success');
				$_SESSION['msg3'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg . "</strong></div>";
			} else {
				$msg = $message_functions->showMessage('module_assign_remove_fail', '2003');
				$db->userErrorLog('2003', $user_name, 'script - ' . $script);
				$_SESSION['msg3'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$msg = $message_functions->showMessage('transection_fail', '2004');
			$_SESSION['msg3'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg . "</strong></div>";
		}
	}

	//  to the form edit user
	elseif (isset($_GET['edit_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$edit_id = $_GET['edit_id'];
			$edit_user_data = $user_model->getUser($edit_id);
		} else {
			// var_dump('test');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
			//header('Location: location.php?t=3');
			$tab2 = "set";
			$tab3 = "not";
		}
	}
	//edit user
	elseif (isset($_POST['edit-submita'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { //refresh validate
			if ($user_type != "SALES") {
				$id = $_POST['id'];
				$access_role = $_POST['access_role_2'];
				//$user_type = $_POST['user_type'];
				//$loation = $_POST['loation'];
				$full_name = $_POST['full_name_2'];
				$email = $_POST['email_2'];
				$language = $_POST['language_2'];
				$timezone = $_POST['timezone_2'];
				$mobile = $_POST['mobile_2'];
				// $sub_user_type = ($access_role=='Master Support Admin')?'SUPPORT':'MNO';
				$access_role = ($access_role=='Master Support Admin'|| $access_role=='Master Admin Peer')?'admin':$access_role;			
				//update log//
				$ex_log = userUpdateLog($id, 'EDIT_PROFILE', $user_name,$db);

				if ($ex_log===true) {
					$get_user_detail_q = "SELECT u.user_name, u.email, u.user_name FROM crm_clients u WHERE u.id='$id' LIMIT 1";
					$user_details = $db->select1DB($get_user_detail_q);
					$edit_user_name = $user_details['user_name'];
					$old_email = $user_details['email'];
					$archive_q = "INSERT INTO `crm_clients_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$edit_user_name',NOW(),last_update,'update'
								FROM `crm_clients` WHERE id='$id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE `crm_clients`
									SET `access_role` = '$access_role',
									`full_name` ='$full_name',
									`email` = '$email',
									`language` = '$language',
									`timezone` = '$timezone',
									`mobile` =  '$mobile'
									WHERE `id` = '$id'";
					$edit_result = $db->execDB($edit_query);

					if ($email != $old_email && $edit_result===true) {
						$t = date("ymdhis", time());
						$string = $edit_user_name . '|' . $t . '|' . $email;
						$encript_resetkey = $app->encrypt_decrypt('encrypt', $string);
						$unique_key = $db->getValueAsf("SELECT REPLACE(UUID(),'-','') as f");
						$qq = "UPDATE admin_reset_password SET status = 'cancel' WHERE user_name='$edit_user_name' AND status='pending'";
						$rr = $db->execDB($qq);

						if ($rr===true) {
							$ip = $_SERVER['REMOTE_ADDR'];
							$q1 = "INSERT INTO admin_reset_password (user_name, status, security_key,unique_key, ip, create_date) VALUES('$edit_user_name', 'pending', '$encript_resetkey','$unique_key', '$ip', NOW())";
							//$r1 = mysql_query($q1);
							$r1 = $db->execDB($q1);
						}
						$support_number = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type);

						if ($r1===true) {
							if ($package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {
								$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $system_package, 'MNO', $user_distributor);
								$a = $email_content[0]['text_details'];
								$subject = $email_content[0]['title'];

								if (strlen($subject) == '0') {
									$email_content = $db->getEmailTemplate('PASSWORD_RESET_MAIL', $package_functions->getAdminPackage(), 'ADMIN');
									$a = $email_content[0]['text_details'];
									$subject = $email_content[0]['title'];
								}
							} else {
								$a = $db->textVal('PASSWORD_RESET_MAIL', 'ADMIN');
								$subject = $db->textTitle('PASSWORD_RESET_MAIL', 'ADMIN');
							}

							$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
							$link = $db->getSystemURL('reset_pwd', $login_design, $unique_key);
							$vars = array(
								'{$user_full_name}' => $full_name,
								'{$short_name}' => $db->setVal("short_title", $user_distributor),
								'{$account_type}' => $user_type,
								'{$link}' => $link,
								'{$support_number}' => $support_number,
								'{$user_ID}' => $edit_user_name

							);

							$message_full = strtr($a, $vars);
							$message = $message_full;

							$from = strip_tags($db->setVal("email", $user_distributor));
							if (empty($from)) {
								$from = strip_tags($db->setVal("email", "ADMIN"));
							}

							$title = $db->setVal("short_title", $user_distributor);

							$email_send_method = $package_functions->getSectionType("EMAIL_SYSTEM", $system_package);
							include_once 'src/email/' . $email_send_method . '/index.php';
							$cunst_var = array();
							//$cunst_var['template'] = $package_functions->getOptions('EMAIL_TEMPLATE', $system_package);
							$cunst_var['system_package'] = $system_package;
			                $cunst_var['mno_package'] = $system_package;
			                $cunst_var['mno_id'] = $mno_id;
			                $cunst_var['verticle'] = $property_business_type;
							$mail_obj = new email($cunst_var);
							$mail_obj->mno_system_package = $system_package;
							$mail_sent = $mail_obj->sendEmail($from, $email, $subject, $message_full, '', $title);
						}
					}

					if ($edit_result) {
						$create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('role_edit_success', $edit_user_name) . "</strong></div>";

						//Activity log
						$db->userLog($user_name, $script, 'Modify User', $edit_user_name);
					} else {
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('role_edit_failed', '2002') . "</strong></div>";
					}
				} else {
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('role_edit_failed', '2002') . "</strong></div>";
				}
			} else {
				$create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
				$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('role_edit_success', $edit_user_name) . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} elseif (isset($_POST['edit-submita-pass'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { //refresh validate
			if ($user_type != "SALES") {
				$id = $_POST['id'];
				$passwd = $_POST['passwd'];
				$passwd_2 = $_POST['passwd_2'];
				if ($passwd == $passwd_2) {
					$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$id' LIMIT 1");
					//update log//
					$ex_log = userUpdateLog($id, 'RESET_PASSWORD', $user_name,$db);
					if ($ex_log===true) {
						$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$passwd\"))))) AS f";
						$updated_pw='';
						$pw_results=$db->selectDB($pw_query);

						foreach($pw_results['data'] AS $row){
							$updated_pw = strtoupper($row['f']);
						}

						$edit_query = "UPDATE `crm_clients`
										SET `password` = '$updated_pw'
										WHERE `id` = '$id'";
						$edit_result = $db->execDB($edit_query);

						if ($edit_result===true) {
							$create_log->save('3001', $message_functions->showNameMessage('role_password_edit_success', $user_full_name), '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('role_password_edit_success', $user_full_name) . "</strong></div>";

							//Activity log
							$db->userLog($user_name, $script, 'Reset Password', $user_full_name);
						} else {
							$db->userErrorLog('2002', $user_name, 'script - ' . $script);
							$create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('role_password_edit_failed', '2002') . "</strong></div>";
						}
					} else {
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('role_password_edit_failed', '2002') . "</strong></div>";
					}
				} else {
					$db->userErrorLog('2006', $user_name, 'script - ' . $script);
					$create_log->save('2006', $message_functions->showMessage('role_password_edit_failed', '2006'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('role_password_edit_failed', '2006') . "</strong></div>";
					//Password confirmation failed
				}
			} else {
				$create_log->save('3001', $message_functions->showNameMessage('role_password_edit_success', $user_full_name), '');
				$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showNameMessage('role_password_edit_success', $user_full_name) . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}
	//login status change////
	elseif (isset($_GET['status_change_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) { //refresh validate
			if ($user_type != "SALES") {
				$status_change_id = $_GET['status_change_id'];
				$action_sts = $_GET['action_sts'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$status_change_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM crm_clients u WHERE u.id='$status_change_id' LIMIT 1");

				if ($action_sts == '1') {
					$action_type = "ACCOUNT_ENABLE";
					$set = 'enabled';
				} else {
					$action_type = "ACCOUNT_DISABLE";
					$set = 'disabled';
				}
				//update log//
				$ex_log = userUpdateLog($status_change_id, $action_type, $user_name,$db);

				if ($ex_log===true) {
					$archive_q = "INSERT INTO `crm_clients_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$user_name',NOW(),last_update,'status_change'
								FROM `crm_clients` WHERE id='$status_change_id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE  `crm_clients` SET `is_enable` = '$action_sts' WHERE `id` = '$status_change_id'";
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$en_dis_msg = '';
						if ($set == 'enabled') {
							$susmsg = $message_functions->showNameMessage('role_user_name_enable_success', $user_full_name);
							$en_dis_msg = 'Enable';
						} elseif ($set == 'disabled') {
							$susmsg = $message_functions->showNameMessage('role_user_name_disable_success', $user_full_name);
							$en_dis_msg = 'Disable';
						}

						$create_log->save('3001', $susmsg, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $susmsg . " </strong></div>";

						//Activity log
						$db->userLog($user_name, $script, $en_dis_msg . ' User', $usr_name);
					} else {
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2001', $message_functions->showMessage('role_user_name_enable_failed', '2001'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('role_user_name_enable_failed', '2001') . "</strong></div>";
					}
				} else {
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2002] Something went wrong,please try again</strong></div>";
				}
			} else {
				$action_sts = $_GET['action_sts'];
				if ($action_sts == '1') {
					$action_type = "ACCOUNT_ENABLE";
					$set = 'enabled';
				} else {
					$action_type = "ACCOUNT_DISABLE";
					$set = 'disabled';
				}

				if ($set == 'enabled') {
					$susmsg = $message_functions->showNameMessage('role_user_name_enable_success', $user_full_name);
					$en_dis_msg = 'Enable';
				} elseif ($set == 'disabled') {
					$susmsg = $message_functions->showNameMessage('role_user_name_disable_success', $user_full_name);
					$en_dis_msg = 'Disable';
				}

				$create_log->save('3001', $susmsg, '');
				$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $susmsg . " </strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>�</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}
	//user remove////
	elseif (isset($_GET['user_rm_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) { //refresh validate
			if ($user_type != "SALES") {
				$user_rm_id = $_GET['user_rm_id'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM crm_clients u WHERE u.id='$user_rm_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM crm_clients u WHERE u.id='$user_rm_id' LIMIT 1");

				$archive_record = "INSERT INTO `crm_clients_archive` (
																		`id`,
																		`user_name`,
																		`password`,
																		`access_role`,
																		`user_type`,
																		`full_name`,
																		`email`,
																		`language`,
																		`mobile`,
																		`is_enable`,
																		`create_date`,
																		`create_user`,
																		`archive_by`,
																		`archive_date`
																		) (SELECT id,
																		`user_name`,
																		`password`,
																		`access_role`,
																		`user_type`,
																		`full_name`,
																		`email`,
																		`language`,
																		`mobile`,
																		`is_enable`,
																		`create_date`,
																		`create_user`,
																		'$user_name',
																		NOW()
																		FROM
																		`crm_clients`
																		WHERE id='$user_rm_id')";
				$archive_record = $db->execDB($archive_record);

                //print_r($archive_record);echo'--';
				if ($archive_record===true) {
					$edit_query = "DELETE FROM `crm_clients`  WHERE `id` = '$user_rm_id'";
					//$edit_result = mysql_query($edit_query);
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$create_log->save('3001', $message_functions->showNameMessage('role_role_remove_success', $user_full_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('role_role_remove_success', $user_full_name) . "</strong></div>";

						//Activity log
						$db->userLog($user_name, $script, 'Remove User', $usr_name);
					} else {
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						$create_log->save('2002', $message_functions->showMessage('role_role_remove_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('role_role_remove_failed', '2002') . "</strong></div>";
					}
				} else {
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$create_log->save('2002', $message_functions->showMessage('role_role_remove_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('role_role_remove_failed', '2002') . "</strong></div>";
				}
			} else {
				$create_log->save('3001', $message_functions->showNameMessage('role_role_remove_success', $user_full_name), '');
				$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('role_role_remove_success', $user_full_name) . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} 
	//Form Refreshing avoid secret key/////
	$secret = md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;
	$users_mid = 'layout/' . $camp_layout . '/views/users_mid.php';
	if (($new_design == 'yes') && file_exists($users_mid)) {
		include_once $users_mid;
	} else {
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
									<h3>Client Management</h3>
								</div>
								<!-- /widget-header -->
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs newTabs">
											<li <?php if (isset($tab1) ) { ?>class="active" <?php } ?>><a href="#show_clients" data-toggle="tab">Active Clients</a></li>
											<li <?php if (isset($tab2) || isset($tab3)) { ?>class="active" <?php } ?>><a href="#create_clients" data-toggle="tab"> <?=(isset($tab3) ? "Update" : "Create")?> Clients</a></li>
										</ul>
										<br>
										<div class="tab-content">
											<!-- +++++++++++++++++++++++++++++ client list ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="show_clients">
												<div id="response_d3"></div>
												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>Active Users</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Username</th>																		
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Access Role</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Full Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Created By</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Disable</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$query_results = $client_model->get_activeClients();
																	if(isset($query_results['rowCount']) && $query_results['rowCount'] > 0) {
																		foreach ($query_results as $row) {
																			$id = $row[id];
																			$user_name1 = $row[user_name];
																			$full_name = $row[full_name];
																			$access_role = $row[access_role];
																			$access_role_desc = $row['description'];
																			$user_distributor1 = $row[user_distributor];
																			$email = $row[email];
																			$is_enable = $row[is_enable];
																			$create_user = $row[create_user];

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
																					<td> ' . $access_role_desc . ' </td>
																					<td> ' . $full_name . ' </td>
																					<td> ' . $email . ' </td>
																					<td> ' . $create_user . ' </td>';

																			echo '<td><a href="javascript:void();" id="APE_' . $id . '"  class="btn btn-small btn-primary">
																					<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#APE_' . $id . '\').easyconfirm({locale: {
																							title: \'Edit User\',
																							text: \'Are you sure you want to edit this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#APE_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=5&edit_id=' . $id . '"
																						});
																						});
																					</script></td><td><a href="javascript:void();" id="LS_' . $id . '"  class="btn btn-small btn-' . $btn_color . '">
																					<i class="btn-icon-only icon-' . $btn_icon . '"></i>&nbsp;' . ucfirst($btn_title) . '</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#LS_' . $id . '\').easyconfirm({locale: {
																							title: \'' . ucfirst($btn_title) . ' User\',
																							text: \'Are you sure you want to ' . $btn_title . ' this user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#LS_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=1&status_change_id=' . $id . '&action_sts=' . $action_status . '"
																						});
																						});
																					</script></td><td><a href="javascript:void();" id="RU_' . $id . '"  class="btn btn-small btn-danger">
																					<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#RU_' . $id . '\').easyconfirm({locale: {
																							title: \'Remove User\',
																							text: \'Are you sure you want to remove [' . $user_name1 . '] user?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#RU_' . $id . '\').click(function() {
																							window.location = "?token=' . $secret . '&t=1&user_rm_id=' . $id . '"
																						});
																						});
																					</script></td>';		
																			echo '</tr>';
																		}
																	} else {
																		echo '<tr><td colspan="6" style="text-align: center;">Results not found</td></tr>';
																	}
																	
																	?>
																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
												<!-- /widget -->
											</div>

											<!-- +++++++++++++++++++++++++++++ create clients ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab2)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_clients">
												<div class="users_head_visible" style="display:none;"><div class="header_hr"></div><div class="header_f1" style="width: 100%">Users</div>
												<br class="hide-sm"><br class="hide-sm"><div class="header_f2" style="width: fit-content;"> </div></div>
												<div id="response_d3"></div>

												<?php
													if(isset($tab2)){
														if (isset($_SESSION['msg5'])) {
															echo $_SESSION['msg5'];
															unset($_SESSION['msg5']);
														}

														if (isset($_SESSION['msg1'])) {
															echo $_SESSION['msg1'];
															unset($_SESSION['msg1']);
														}


														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}

														if (isset($_SESSION['msg3'])) {
															echo $_SESSION['msg3'];
															unset($_SESSION['msg3']);
														}

														if (isset($_SESSION['msg6'])) {
															echo $_SESSION['msg6'];
															unset($_SESSION['msg6']);
														}
													}
												?>
												<!-- action="controller/User_Controller.php" -->
												<form autocomplete="off" id="edit_profile" action="users.php" method="post" class="form-horizontal">
													<fieldset>
														<?php
														echo '<input type="hidden" name="user_type" id="user_type1" value="' . $user_type . '">';
														echo '<input type="hidden" name="loation" id="loation1" value="' . $user_distributor . '">';
														?>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="full_name_1">Full Name<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5 form-group">
																<input class="form-control span4" id="full_name_1" name="full_name_1" maxlength="25" type="text">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
												
														<div class="control-group">
															<label class="control-label" for="email_1">Email<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="email_1" name="email_1" placeholder="name@mycompany.com">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->

														<div class="control-group">
															<label class="control-label" for="language_1">Language</label>
															<div class="controls form-group col-lg-5">
																<select class="form-control span4" name="language_1" id="language_1">
																	<?php
																	$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";
																		$query_results=$db->selectDB($key_query);
																		foreach($query_results['data'] AS $row){
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
														<?php if ($user_type=='ADMIN') { ?>
														<div class="control-group">
                                                             <label class="control-label" for="timezone_1">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                             <div class="controls col-lg-5 form-group">
                                                                 <select class="span4 form-control" id="timezone_1" name="timezone_1" autocomplete="off">
                                                                     <option value="">Select Time Zone</option>
                                                                     <?php
                                                                     $utc = new DateTimeZone('UTC');
                                                                     $dt = new DateTime('now', $utc);
                                                                     foreach ($priority_zone_array as $tz){
                                                                         $current_tz = new DateTimeZone($tz);
                                                                         $offset =  $current_tz->getOffset($dt);
                                                                         $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                         $abbr = $transition[0]['abbr'];
                                                                         if($timezone_set==$tz){
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
                                                                        
                                                                        if($timezone_set==$tz){
                                                                           $select="selected";
                                                                        }else{
                                                                            $select="";
                                                                        }
                                                                        echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                    }
                                                                     ?>
                                                                 </select>
                                                             </div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<?php } ?>
														<div class="control-group">
															<label class="control-label" for="mobile_1">Phone Number<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="mobile_1" name="mobile_1" type="text" placeholder="xxx-xxx-xxxx" maxlength="12">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<script type="text/javascript">
															$(document).ready(function() {
																$("#mobile_1").keypress(function(event) {
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

																$('#mobile_1').focus(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});

																$('#mobile_1').keyup(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});

																$("#mobile_1").keydown(function(e) {
																	var mac = $('#mobile_1').val();
																	var len = mac.length + 1;
																	if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
																		mac1 = mac.replace(/[^0-9]/g, '');
																	} else {
																		if (len == 4) {
																			$('#mobile_1').val(function() {
																				return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
																			});
																		} else if (len == 8) {
																			$('#mobile_1').val(function() {
																				return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
																				//console.log('mac2 ' + mac);

																			});
																		}
																	}
																	$('#edit_profile').data('bootstrapValidator').updateStatus('mobile_1', 'NOT_VALIDATED').validateField('mobile_1');
																});
															});
														</script>
														<div class="control-group">
                                                        <label class="control-label" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                                                                <option value="">Select Country</option>
                                                                <?php
                                                                
                                                                foreach ($country_result['data'] as $row) {
                                                                    $select="";
                                                                    if($row[a]==$get_edit_mno_country){
                                                                        $select="selected";
                                                                    }
                                                                    echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <script language="javascript">
                                                       populateCountries("mno_country", "mno_state");
                                                    </script>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                        <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                            <?php
                                                                echo '<option value="">Select State</option>';
                                                                // var_dump($get_regions['data']);
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
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                    $(document).ready(function() {
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
                                                    });
                                                    </script>

														<div class="form-actions">
															<button type="submit" name="submit_1" id="submit_1" class="btn btn-primary">Create Account</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
														</div>
														<!-- /form-actions -->
													</fieldset>
												</form>
												<script type="text/javascript">
													$(document).ready(function() {
														document.getElementById("submit_1").disabled = true;
													});

													function newus_ck() {
														var name = document.getElementById('full_name_1').value;
														var email = document.getElementById('email_1').value;
														var numb = document.getElementById('mobile_1').value;
														if (name == '' || email == '' || numb == '') {
															document.getElementById("submit_1").disabled = true;
														} else {
															document.getElementById("submit_1").disabled = false;
														}
													}
												</script>
												
											</div>
	
											<!-- +++++++++++++++++++++++++++++ Edit clients ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab3) && $tab3 == "set") { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_clients">
												<div class="support_head_visible" style="display:none;">
													<div class="header_hr"></div>
													<div class="header_f1" style="width: 100%;">Edit Profile</div>
													<br class="hide-sm"><br class="hide-sm">
													<div class="header_f2" style="width: 100%;"></div>
												</div>
												<form autocomplete="off" id="edit-user-profile" action="?t=1" method="post" class="form-horizontal">
												<?php
													if(isset($tab3)){
														if (isset($_SESSION['msg5'])) {
															echo $_SESSION['msg5'];
															unset($_SESSION['msg5']);
														}

														if (isset($_SESSION['msg1'])) {
															echo $_SESSION['msg1'];
															unset($_SESSION['msg1']);
														}


														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}

														if (isset($_SESSION['msg3'])) {
															echo $_SESSION['msg3'];
															unset($_SESSION['msg3']);
														}

														if (isset($_SESSION['msg6'])) {
															echo $_SESSION['msg6'];
															unset($_SESSION['msg6']);
														}
													}
												?>
												<?php
													if($_GET['edit_id']){
														$id = $edit_user_data[0]->getId();
														$user_name =  $edit_user_data[0]->getUserName();
														$access_role_set = $edit_user_data[0]->getAccessRole();
														$full_name = $edit_user_data[0]->getFullName();
														$email = $edit_user_data[0]->getEmail();
														$language_set = $edit_user_data[0]->getLanguage();
														$user_type_set = $edit_user_data[0]->getUserType();
														$timezone_set = $edit_user_data[0]->getTimezones();
														$mobile = $edit_user_data[0]->getMobile(); 

														if ($access_role_set=='admin' && $user_type_set =='SUPPORT') {
															$access_role_s="Master Support Admin";
														}
														elseif ($access_role_set=='admin' && $user_type_set =='TECH') {
															$access_role_s='Master Tech Admin';
														}
														elseif ($access_role_set=='admin') {
															$access_role_s='Master Admin Peer';
														}
														else{
															$access_role_s='Admin';
														}
													}

													echo '<input type="hidden" name="form_secret" id="form_secret1" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
													<fieldset>
														<?php
														echo '<input type="hidden" name="user_type" id="user_type2" value="' . $user_type . '">';
														echo '<input type="hidden" name="loation" id="loation2" value="' . $user_distributor . '">';
														echo '<input type="hidden" name="id" id="id" value="' . $id . '">';
														?>
														<div class="control-group">
															<label class="control-label" for="access_role_2">Access Role<sup><font color="#FF0000"></font></sup></label>

															<div class="controls form-group col-lg-5" readonly>
																<select onchange="access_timezone()" class="form-control span4" name="access_role_2" id="access_role_2" value=<?php echo $access_role_set; ?> >
																	<option value="">Select Access Role</option>
																	<?php
																	if($access_role_set=='admin'){
																		$a_selected = ($access_role_s=='Master Admin Peer')?'selected':'';
																		$b_selected = ($access_role_s=='Master Support Admin')?'selected':'';
																		echo '<option value="Master Admin Peer" '.$a_selected.'>Master Admin Peer</option>
																		<option value="Master Support Admin" '.$b_selected.'>Master Support Admin</option>';
																	}
																	$key_query = "SELECT access_role,description FROM admin_access_roles WHERE distributor = '$user_distributor' ORDER BY description";
																	$query_results=$db->selectDB($key_query);
																	foreach($query_results['data'] AS $row){
																		$access_role = $row[access_role];
																		if ($access_role == $access_role_set) {
																			$description = $row[description];
																			echo '<option value="' . $access_role . '" selected>' . $description . '</option>';
																		} else {
																			$description = $row[description];
																			echo '<option value="' . $access_role . '">' . $description . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<script type="text/javascript">
															function access_timezone() {
																var role=$('#access_role_2').val();
																<?php if ($user_type!='ADMIN') { ?>
																if (role=='Master Admin Peer') {
																	$('.timezone_2n').show();
																}
																else{
																	$('.timezone_2n').hide();
																}
																<?php }?>                          
                                                            }
														</script>
														<div class="control-group">
															<label class="control-label" for="full_name_2" _1>Full Name<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="full_name_2" name="full_name_2" maxlength="25" type="text" value="<?php echo $full_name ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="email_2">Email<sup><font color="#FF0000"></font></sup></label>
															<div class="controls form-group col-lg-5">
																<input class="form-control span4" id="email_2" name="email_2" type="text" value="<?php echo $email ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="language_2">Language</label>
															<div class="controls form-group col-lg-5">
																<select class="form-control span4" name="language_2" id="language_2">
																	<?php
																	$key_query = "SELECT language_code, `language` FROM system_languages WHERE  admin_status = 1 ORDER BY `language`";
																	$query_results=$db->selectDB($key_query);
																	foreach($query_results['data'] AS $row){
																		$language_code = $row[language_code];
																		$language = $row[language];
																		if ($language_code == $language_set) {
																			echo '<option value="' . $language_code . '" selected>' . $language . '</option>';
																		} else {
																			echo '<option value="' . $language_code . '">' . $language . '</option>';
																		}
																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<?php if ($access_role_set=='admin' || $user_type=='ADMIN') {?>
														<div class="control-group timezone_2n" <?php if($user_type_set=='SUPPORT'){ echo 'style="display:none"'; } ?> >
                                                             <label class="control-label" for="timezone_2">Time Zone<sup><font color="#FF0000"></font></sup></label>
                                                             <div class="controls col-lg-5 form-group">
                                                                 <select class="span4 form-control" id="timezone_2" name="timezone_2" autocomplete="off">
                                                                     <option value="">Select Time Zone</option>
                                                                     <?php
                                                                     $utc = new DateTimeZone('UTC');
                                                                     $dt = new DateTime('now', $utc);
                                                                     foreach ($priority_zone_array as $tz){
                                                                         $current_tz = new DateTimeZone($tz);
                                                                         $offset =  $current_tz->getOffset($dt);
                                                                         $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                                         $abbr = $transition[0]['abbr'];
                                                                         if($timezone_set==$tz){
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
                                                                        
                                                                        if($timezone_set==$tz){
                                                                           $select="selected";
                                                                        }else{
                                                                            $select="";
                                                                        }
                                                                        echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                                                    }
                                                                     ?>
                                                                 </select>
                                                             </div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
													<?php } ?>
														<div class="control-group">
															<label class="control-label" for="mobile_2">Phone Number<sup><font color="#FF0000"></font></sup></label>
															<div class="form-group controls col-lg-5">
																<input class="form-control span4" id="mobile_2" name="mobile_2" type="text" maxlength="12" value="<?php echo $mobile ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<script type="text/javascript">
															$(document).ready(function() {
																$('#mobile_2').focus(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
																});

																$('#mobile_2').keyup(function() {
																	$(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
																	$('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
																});

																$("#mobile_2").keydown(function(e) {
																	var mac = $('#mobile_2').val();
																	var len = mac.length + 1;
																	if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
																		mac1 = mac.replace(/[^0-9]/g, '');
																	} else {
																		if (len == 4) {
																			$('#mobile_2').val(function() {
																				return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
																			});
																		} else if (len == 8) {
																			$('#mobile_2').val(function() {
																				return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
																			});
																		}
																	}

																	$("#mobile_2").keypress(function(event) {
																		var ew = event.which;
																		//alert(ew);
																		//if(ew == 8||ew == 0||ew == 46||ew == 45)
																		if (ew == 8 || ew == 0)
																			return true;
																		if (48 <= ew && ew <= 57)
																			return true;
																		return false;
																	});

																	$('#edit-user-profile').data('bootstrapValidator').updateStatus('mobile_2', 'NOT_VALIDATED').validateField('mobile_2');
																});
															});
														</script>
														<div class="control-group">
                                                        <label class="control-label" for="mno_address_1">Address<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo$get_edit_mno_ad1;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_address_2">City<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $get_edit_mno_ad2;?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_country" >Country<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select name="mno_country" id="mno_country" class="span4 form-control" autocomplete="off">
                                                                <option value="">Select Country</option>
                                                                <?php
                                                                
                                                                foreach ($country_result['data'] as $row) {
                                                                    $select="";
                                                                    if($row[a]==$get_edit_mno_country){
                                                                        $select="selected";
                                                                    }
                                                                    echo '<option value="'.$row[a].'" '.$select.'>'.$row[b].'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <script language="javascript">
                                                       populateCountries("mno_country", "mno_state");
                                                    </script>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_state">State/Region<font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                        <select <?php if($field_array['region']=="mandatory" || $package_features=="all"){ ?>required<?php } ?> class="span4 form-control" id="mno_state" placeholder="State or Region" name="mno_state" required autocomplete="off">
                                                            <?php
                                                                echo '<option value="">Select State</option>';
                                                                // var_dump($get_regions['data']);
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
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label" for="mno_region">ZIP Code<sup><font color="#FF0000"></font></sup></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $get_edit_mno_zip?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                    $(document).ready(function() {
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
                                                    });
                                                    </script>
														<div class="form-actions">
															<button type="submit" name="edit-submita" id="edit-submita" class="btn btn-primary" disabled="disabled">Update Account</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
															<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;
															<script type="text/javascript">
																function goto(url) {
																	window.location = url;
																}
																function footer_submitfn() {
																	//alert("fn");
																	$("#edit-submita").prop('disabled', false);
																}
															</script>
														</div>
														<!-- /form-actions -->
													</fieldset>
												</form>

												<form onkeyup="footer_submitfn1();" onchange="footer_submitfn1();" autocomplete="off" id="edit-user-password" action="?t=1" method="post" class="form-horizontal">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret2" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<fieldset>
														<legend>Reset Password</legend>
														<?php
														echo '<input type="hidden" name="user_type" id="user_type3" value="' . $user_type . '">';
														echo '<input type="hidden" name="loation" id="loation3" value="' . $user_distributor . '">';
														echo '<input type="hidden" name="id" id="id1" value="' . $id . '">';
														?>
														<div class="control-group">
															<label class="control-label" for="full_name_2" _1>Password<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5">
																<input class="span4" id="passwd" name="passwd" type="password" required>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="control-group">
															<label class="control-label" for="email_2">Confirm Password<sup><font color="#FF0000"></font></sup></label>
															<div class="controls col-lg-5">
																<input class="span4" id="passwd_2" name="passwd_2" type="password" required="required">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
														<div class="form-actions">
															<button type="submit" name="edit-submita-pass" id="edit-submita-pass" class="btn btn-primary" disabled="disabled">Save</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
															<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;
														</div>
														<!-- /form-actions -->
													</fieldset>
												</form>

												<script>
													function footer_submitfn1() {
														$("#edit-submita-pass").prop('disabled', false);
													}
												</script>
											</div>
											<!-- +++++++++++++++++++++++++++++ Edit users ++++++++++++++++++++++++++++++++ -->	
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
	<?php } ?>
	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>
	<script type="text/javascript" src="js/bootstrapValidator_new.js?v=14"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			//create user form validation
			$('#edit_profile').bootstrapValidator({
				framework: 'bootstrap',
				xcluded: [':disabled', '[readonly]',':hidden', ':not(:visible)'],
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					full_name_1: {
						validators: {
							<?php echo $db->validateField('person_full_name'); ?>,
							<?php echo $db->validateField('not_require_special_character'); ?>
						}
					},
					email_1: {
						validators: {
							<?php echo $db->validateField('email_cant_upper'); ?>
						}
					},
					timezone_1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					mobile_1: {
						validators: {
							<?php echo $db->validateField('mobile'); ?>
						}
					}
				}
			}).on('status.field.bv', function(e, data) {
				if ($('#edit_profile').data('bootstrapValidator').isValid()) {
					data.bv.disableSubmitButtons(false);
				} else {
					data.bv.disableSubmitButtons(true);
				}
			});
			$('#edit-user-profile').bootstrapValidator({
				framework: 'bootstrap',
				xcluded: [':disabled', '[readonly]',':hidden', ':not(:visible)'],
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					access_role_2: {
						validators: {
							<?php echo $db -> validateField('dropdown'); ?>
						}
					},
					full_name_2: {
						validators: {
							<?php echo $db -> validateField('person_full_name'); ?> ,
							<?php echo $db -> validateField('not_require_special_character'); ?>
						}
					},
					email_2: {
						validators: {
							<?php echo $db -> validateField('email_cant_upper'); ?>
						}
					},
					timezone_2: {
						validators: {
							<?php echo $db -> validateField('notEmpty'); ?>
						}
					},
					mobile_2: {
						validators: {
							<?php echo $db -> validateField('mobile'); ?>
						}
					}
				}
			}).bootstrapValidator('validate').on('status.field.bv', function(e, data) {
				if ($('#edit-user-profile').data('bootstrapValidator').isValid()) {
					data.bv.disableSubmitButtons(false);
				} else {
					data.bv.disableSubmitButtons(true);
				}
			});

		});
	</script>

	<?php
	include 'footer.php';
	?>

	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#loation").chained("#user_type");

		});
	</script>
	<script type="text/javascript">
  // Countries
    var country_arr = new Array( "United States of America","Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

    // States
    var s_a = new Array();
    var s_a_val = new Array();
    s_a[0] = "";
    s_a_val[0] = "";
    <?php
    $s_a = rtrim($s_a,"|");
    $s_a_val = rtrim($s_a_val,"|");

    ?>
    s_a[1] = "<?php echo $s_a; ?>";
    s_a_val[1] = "<?php echo $s_a_val; ?>";
    s_a[2] = "Others";
    s_a[3] = "Others";
    s_a[4] = "Others";
    s_a[5] = "Others";
    s_a[6] = "Others";
    s_a[7] = "Others";
    s_a[8] = "Others";
    s_a[9] = "Others";
    s_a[10] = "Others";
    s_a[11] = "Others";
    s_a[12] = "Others";
    s_a[13] = "Others";
    s_a[14] = "Others";
    s_a[15] = "Others";
    s_a[16] = "Others";
    s_a[17] = "Others";
    s_a[18] = "Others";
    s_a[19] = "Others";
    s_a[20] = "Others";
    s_a[21] = "Others";
    s_a[22] = "Others";
    s_a[23] = "Others";
    s_a[24] = "Others";
    s_a[25] = "Others";
    s_a[26] = "Others";
    s_a[27] = "Others";
    s_a[28] = "Others";
    s_a[29] = "Others";
    s_a[30] = "Others";
    s_a[31] = "Others";
    s_a[32] = "Others";
    s_a[33] = "Others";
    s_a[34] = "Others";
    s_a[35] = "Others";
    s_a[36] = "Others";
    s_a[37] = "Others";
    s_a[38] = "Others";
    s_a[39] = "Others";
    s_a[40] = "Others";
    s_a[41] = "Others";
    s_a[42] = "Others";
    s_a[43] = "Others";
    s_a[44] = "Others";
    s_a[45] = "Others";
    s_a[46] = "Others";
    s_a[47] = "Others";
    s_a[48] = "Others";
    // <!-- -->
    s_a[49] = "Others";
    s_a[50] = "Others";
    s_a[51] = "Others";
    s_a[52] = "Others";
    s_a[53] = "Others";
    s_a[54] = "Others";
    s_a[55] = "Others";
    s_a[56] = "Others";
    s_a[57] = "Others";
    s_a[58] = "Others";
    s_a[59] = "Others";
    s_a[60] = "Others";
    s_a[61] = "Others";
    s_a[62] = "Others";
    // <!-- -->
    s_a[63] = "Others";
    s_a[64] = "Others";
    s_a[65] = "Others";
    s_a[66] = "Others";
    s_a[67] = "Others";
    s_a[68] = "Others";
    s_a[69] = "Others";
    s_a[70] = "Others";
    s_a[71] = "Others";
    s_a[72] = "Others";
    s_a[73] = "Others";
    s_a[74] = "Others";
    s_a[75] = "Others";
    s_a[76] = "Others";
    s_a[77] = "Others";
    s_a[78] = "Others";
    s_a[79] = "Others";
    s_a[80] = "Others";
    s_a[81] = "Others";
    s_a[82] = "Others";
    s_a[83] = "Others";
    s_a[84] = "Others";
    s_a[85] = "Others";
    s_a[86] = "Others";
    s_a[87] = "Others";
    s_a[88] = "Others";
    s_a[89] = "Others";
    s_a[90] = "Others";
    s_a[91] = "Others";
    s_a[92] = "Others";
    s_a[93] = "Others";
    s_a[94] = "Others";
    s_a[95] = "Others";
    s_a[96] = "Others";
    s_a[97] = "Others";
    s_a[98] = "Others";
    s_a[99] = "Others";
    s_a[100] = "Others";
    s_a[101] = "Others";
    s_a[102] = "Others";
    s_a[103] = "Others";
    s_a[104] = "Others";
    s_a[105] = "Others";
    s_a[106] = "Others";
    s_a[107] = "Others";
    s_a[108] = "Others";
    s_a[109] = "Others";
    s_a[110] = "Others";
    s_a[111] = "Others";
    s_a[112] = "Others";
    s_a[113] = "Others";
    s_a[114] = "Others";
    s_a[115] = "Others";
    s_a[116] = "Others";
    s_a[117] = "Others";
    s_a[118] = "Others";
    s_a[119] = "Others";
    s_a[120] = "Others";
    s_a[121] = "Others";
    s_a[122] = "Others";
    s_a[123] = "Others";
    s_a[124] = "Others";
    s_a[125] = "Others";
    s_a[126] = "Others";
    s_a[127] = "Others";
    s_a[128] = "Others";
    s_a[129] = "Others";
    s_a[130] = "Others";
    s_a[131] = "Others";
    s_a[132] = "Others";
    s_a[133] = "Others";
    s_a[134] = "Others";
    s_a[135] = "Others";
    s_a[136] = "Others";
    s_a[137] = "Others";
    s_a[138] = "Others";
    s_a[139] = "Others";
    s_a[140] = "Others";
    s_a[141] = "Others";
    s_a[142] = "Others";
    s_a[143] = "Others";
    s_a[144] = "Others";
    s_a[145] = "Others";
    s_a[146] = "Others";
    s_a[147] = "Others";
    s_a[148] = "Others";
    s_a[149] = "Others";
    s_a[150] = "Others";
    s_a[151] = "Others";
    s_a[152] = "Others";
    s_a[153] = "Others";
    s_a[154] = "Others";
    s_a[155] = "Others";
    s_a[156] = "Others";
    s_a[157] = "Others";
    s_a[158] = "Others";
    s_a[159] = "Others";
    s_a[160] = "Others";
    s_a[161] = "Others";
    s_a[162] = "Others";
    s_a[163] = "Others";
    s_a[164] = "Others";
    s_a[165] = "Others";
    s_a[166] = "Others";
    s_a[167] = "Others";
    s_a[168] = "Others";
    s_a[169] = "Others";
    s_a[170] = "Others";
    s_a[171] = "Others";
    s_a[172] = "Others";
    s_a[173] = "Others";
    s_a[174] = "Others";
    s_a[175] = "Others";
    s_a[176] = "Others";
    s_a[177] = "Others";
    s_a[178] = "Others";
    s_a[179] = "Others";
    s_a[180] = "Others";
    s_a[181] = "Others";
    s_a[182] = "Others";
    s_a[183] = "Others";
    s_a[184] = "Others";
    s_a[185] = "Others";
    s_a[186] = "Others";
    s_a[187] = "Others";
    s_a[188] = "Others";
    s_a[189] = "Others";
    s_a[190] = "Others";
    s_a[191] = "Others";
    s_a[192] = "Others";
    s_a[193] = "Others";
    s_a[194] = "Others";
    s_a[195] = "Others";
    s_a[196] = "Others";
    s_a[197] = "Others";
    s_a[198] = "Others";
    s_a[199] = "Others";
    s_a[200] = "Others";
    s_a[201] = "Others";
    s_a[202] = "Others";
    s_a[203] = "Others";
    s_a[204] = "Others";
    s_a[205] = "Others";
    s_a[206] = "Others";
    s_a[207] = "Others";
    s_a[208] = "Others";
    s_a[209] = "Others";
    s_a[210] = "Others";
    s_a[211] = "Others";
    s_a[212] = "Others";
    s_a[213] = "Others";
    s_a[214] = "Others";
    s_a[215] = "Others";
    s_a[216] = "Others";
    s_a[217] = "Others";
    s_a[218] = "Others";
    s_a[219] = "Others";
    s_a[220] = "Others";
    s_a[221] = "Others";
    s_a[222] = "Others";
    s_a[223] = "Others";
    s_a[224] = "Others";
    s_a[225] = "Others";
    s_a[226] = "Others";
    s_a[227] = "Others";
    s_a[228] = "Others";
    s_a[229] = "Others";
    s_a[230] = "Others";
    s_a[231] = "Others";
    s_a[232] = "Others";
    s_a[233] = "Others";
    s_a[234] = "Others";
    s_a[235] = "Others";
    s_a[236] = "Others";
    s_a[237] = "Others";
    s_a[238] = "Others";
    s_a[239] = "Others";
    s_a[240] = "Others";
    s_a[241] = "Others";
    s_a[242] = "Others";
    s_a[243] = "Others";
    s_a[244] = "Others";
    s_a[245] = "Others";
    s_a[246] = "Others";
    s_a[247] = "Others";
    s_a[248] = "Others";
    s_a[249] = "Others";
    s_a[250] = "Others";
    s_a[251] = "Others";
    s_a[252] = "Others";
    
    s_a_val[2] = "N/A";
    s_a_val[3] = "N/A";
    s_a_val[4] = "N/A";
    s_a_val[5] = "N/A";
    s_a_val[6] = "N/A";
    s_a_val[7] = "N/A";
    s_a_val[8] = "N/A";
    s_a_val[9] = "N/A";
    s_a_val[10] = "N/A";
    s_a_val[11] = "N/A";
    s_a_val[12] = "N/A";
    s_a_val[13] = "N/A";
    s_a_val[14] = "N/A";
    s_a_val[15] = "N/A";
    s_a_val[16] = "N/A";
    s_a_val[17] = "N/A";
    s_a_val[18] = "N/A";
    s_a_val[19] = "N/A";
    s_a_val[20] = "N/A";
    s_a_val[21] = "N/A";
    s_a_val[22] = "N/A";
    s_a_val[23] = "N/A";
    s_a_val[24] = "N/A";
    s_a_val[25] = "N/A";
    s_a_val[26] = "N/A";
    s_a_val[27] = "N/A";
    s_a_val[28] = "N/A";
    s_a_val[29] = "N/A";
    s_a_val[30] = "N/A";
    s_a_val[31] = "N/A";
    s_a_val[32] = "N/A";
    s_a_val[33] = "N/A";
    s_a_val[34] = "N/A";
    s_a_val[35] = "N/A";
    s_a_val[36] = "N/A";
    s_a_val[37] = "N/A";
    s_a_val[38] = "N/A";
    s_a_val[39] = "N/A";
    s_a_val[40] = "N/A";
    s_a_val[41] = "N/A";
    s_a_val[42] = "N/A";
    s_a_val[43] = "N/A";
    s_a_val[44] = "N/A";
    s_a_val[45] = "N/A";
    s_a_val[46] = "N/A";
    s_a_val[47] = "N/A";
    s_a_val[48] = "N/A";
    // <!-- -->
    s_a_val[49] = "N/A";
    s_a_val[50] = "N/A";
    s_a_val[51] = "N/A";
    s_a_val[52] = "N/A";
    s_a_val[53] = "N/A";
    s_a_val[54] = "N/A";
    s_a_val[55] = "N/A";
    s_a_val[56] = "N/A";
    s_a_val[57] = "N/A";
    s_a_val[58] = "N/A";
    s_a_val[59] = "N/A";
    s_a_val[60] = "N/A";
    s_a_val[61] = "N/A";
    s_a_val[62] = "N/A";
    // <!-- -->
    s_a_val[63] = "N/A";
    s_a_val[64] = "N/A";
    s_a_val[65] = "N/A";
    s_a_val[66] = "N/A";
    s_a_val[67] = "N/A";
    s_a_val[68] = "N/A";
    s_a_val[69] = "N/A";
    s_a_val[70] = "N/A";
    s_a_val[71] = "N/A";
    s_a_val[72] = "N/A";
    s_a_val[73] = "N/A";
    s_a_val[74] = "N/A";
    s_a_val[75] = "N/A";
    s_a_val[76] = "N/A";
    s_a_val[77] = "N/A";
    s_a_val[78] = "N/A";
    s_a_val[79] = "N/A";
    s_a_val[80] = "N/A";
    s_a_val[81] = "N/A";
    s_a_val[82] = "N/A";
    s_a_val[83] = "N/A";
    s_a_val[84] = "N/A";
    s_a_val[85] = "N/A";
    s_a_val[86] = "N/A";
    s_a_val[87] = "N/A";
    s_a_val[88] = "N/A";
    s_a_val[89] = "N/A";
    s_a_val[90] = "N/A";
    s_a_val[91] = "N/A";
    s_a_val[92] = "N/A";
    s_a_val[93] = "N/A";
    s_a_val[94] = "N/A";
    s_a_val[95] = "N/A";
    s_a_val[96] = "N/A";
    s_a_val[97] = "N/A";
    s_a_val[98] = "N/A";
    s_a_val[99] = "N/A";
    s_a_val[100] = "N/A";
    s_a_val[101] = "N/A";
    s_a_val[102] = "N/A";
    s_a_val[103] = "N/A";
    s_a_val[104] = "N/A";
    s_a_val[105] = "N/A";
    s_a_val[106] = "N/A";
    s_a_val[107] = "N/A";
    s_a_val[108] = "N/A";
    s_a_val[109] = "N/A";
    s_a_val[110] = "N/A";
    s_a_val[111] = "N/A";
    s_a_val[112] = "N/A";
    s_a_val[113] = "N/A";
    s_a_val[114] = "N/A";
    s_a_val[115] = "N/A";
    s_a_val[116] = "N/A";
    s_a_val[117] = "N/A";
    s_a_val[118] = "N/A";
    s_a_val[119] = "N/A";
    s_a_val[120] = "N/A";
    s_a_val[121] = "N/A";
    s_a_val[122] = "N/A";
    s_a_val[123] = "N/A";
    s_a_val[124] = "N/A";
    s_a_val[125] = "N/A";
    s_a_val[126] = "N/A";
    s_a_val[127] = "N/A";
    s_a_val[128] = "N/A";
    s_a_val[129] = "N/A";
    s_a_val[130] = "N/A";
    s_a_val[131] = "N/A";
    s_a_val[132] = "N/A";
    s_a_val[133] = "N/A";
    s_a_val[134] = "N/A";
    s_a_val[135] = "N/A";
    s_a_val[136] = "N/A";
    s_a_val[137] = "N/A";
    s_a_val[138] = "N/A";
    s_a_val[139] = "N/A";
    s_a_val[140] = "N/A";
    s_a_val[141] = "N/A";
    s_a_val[142] = "N/A";
    s_a_val[143] = "N/A";
    s_a_val[144] = "N/A";
    s_a_val[145] = "N/A";
    s_a_val[146] = "N/A";
    s_a_val[147] = "N/A";
    s_a_val[148] = "N/A";
    s_a_val[149] = "N/A";
    s_a_val[150] = "N/A";
    s_a_val[151] = "N/A";
    s_a_val[152] = "N/A";
    s_a_val[153] = "N/A";
    s_a_val[154] = "N/A";
    s_a_val[155] = "N/A";
    s_a_val[156] = "N/A";
    s_a_val[157] = "N/A";
    s_a_val[158] = "N/A";
    s_a_val[159] = "N/A";
    s_a_val[160] = "N/A";
    s_a_val[161] = "N/A";
    s_a_val[162] = "N/A";
    s_a_val[163] = "N/A";
    s_a_val[164] = "N/A";
    s_a_val[165] = "N/A";
    s_a_val[166] = "N/A";
    s_a_val[167] = "N/A";
    s_a_val[168] = "N/A";
    s_a_val[169] = "N/A";
    s_a_val[170] = "N/A";
    s_a_val[171] = "N/A";
    s_a_val[172] = "N/A";
    s_a_val[173] = "N/A";
    s_a_val[174] = "N/A";
    s_a_val[175] = "N/A";
    s_a_val[176] = "N/A";
    s_a_val[177] = "N/A";
    s_a_val[178] = "N/A";
    s_a_val[179] = "N/A";
    s_a_val[180] = "N/A";
    s_a_val[181] = "N/A";
    s_a_val[182] = "N/A";
    s_a_val[183] = "N/A";
    s_a_val[184] = "N/A";
    s_a_val[185] = "N/A";
    s_a_val[186] = "N/A";
    s_a_val[187] = "N/A";
    s_a_val[188] = "N/A";
    s_a_val[189] = "N/A";
    s_a_val[190] = "N/A";
    s_a_val[191] = "N/A";
    s_a_val[192] = "N/A";
    s_a_val[193] = "N/A";
    s_a_val[194] = "N/A";
    s_a_val[195] = "N/A";
    s_a_val[196] = "N/A";
    s_a_val[197] = "N/A";
    s_a_val[198] = "N/A";
    s_a_val[199] = "N/A";
    s_a_val[200] = "N/A";
    s_a_val[201] = "N/A";
    s_a_val[202] = "N/A";
    s_a_val[203] = "N/A";
    s_a_val[204] = "N/A";
    s_a_val[205] = "N/A";
    s_a_val[206] = "N/A";
    s_a_val[207] = "N/A";
    s_a_val[208] = "N/A";
    s_a_val[209] = "N/A";
    s_a_val[210] = "N/A";
    s_a_val[211] = "N/A";
    s_a_val[212] = "N/A";
    s_a_val[213] = "N/A";
    s_a_val[214] = "N/A";
    s_a_val[215] = "N/A";
    s_a_val[216] = "N/A";
    s_a_val[217] = "N/A";
    s_a_val[218] = "N/A";
    s_a_val[219] = "N/A";
    s_a_val[220] = "N/A";
    s_a_val[221] = "N/A";
    s_a_val[222] = "N/A";
    s_a_val[223] = "N/A";
    s_a_val[224] = "N/A";
    s_a_val[225] = "N/A";
    s_a_val[226] = "N/A";
    s_a_val[227] = "N/A";
    s_a_val[228] = "N/A";
    s_a_val[229] = "N/A";
    s_a_val[230] = "N/A";
    s_a_val[231] = "N/A";
    s_a_val[232] = "N/A";
    s_a_val[233] = "N/A";
    s_a_val[234] = "N/A";
    s_a_val[235] = "N/A";
    s_a_val[236] = "N/A";
    s_a_val[237] = "N/A";
    s_a_val[238] = "N/A";
    s_a_val[239] = "N/A";
    s_a_val[240] = "N/A";
    s_a_val[241] = "N/A";
    s_a_val[242] = "N/A";
    s_a_val[243] = "N/A";
    s_a_val[244] = "N/A";
    s_a_val[245] = "N/A";
    s_a_val[246] = "N/A";
    s_a_val[247] = "N/A";
    s_a_val[248] = "N/A";
    s_a_val[249] = "N/A";
    s_a_val[250] = "N/A";
    s_a_val[251] = "N/A";
    s_a_val[252] = "N/A";

    function populateStates(countryElementId, stateElementId) {

        var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


        var stateElement = document.getElementById(stateElementId);

        stateElement.length = 0; // Fixed by Julian Woods
        stateElement.options[0] = new Option('Select State', '');
        stateElement.selectedIndex = 0;

        var state_arr = s_a[selectedCountryIndex].split("|");
        var state_arr_val = s_a_val[selectedCountryIndex].split("|");

        if(selectedCountryIndex != 0){
        for (var i = 0; i < state_arr.length; i++) {
            stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
        }
        }

    }

    function populateCountries(countryElementId, stateElementId) {

        var countryElement = document.getElementById(countryElementId);

        if (stateElementId) {
            countryElement.onchange = function () {
                populateStates(countryElementId, stateElementId);
            };
        }
    }
    </script>

	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$("#submit_1").easyconfirm({
				locale: {
					title: 'New Admin Account',
					text: 'Are you sure you want to save this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#submit_1").click(function() {});

			$("#edit-submita").easyconfirm({
				locale: {
					title: 'Edit User',
					text: 'Are you sure you want to update this profile?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#edit-submita").click(function() {});

			$("#edit-submita-pass").easyconfirm({
				locale: {
					title: 'Password Reset',
					text: 'Are you sure you want to update this password?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#edit-submita-pass").click(function() {});
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
			} catch (e) {
				//Internet Explorer
				try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
			}
			return xmlHttp;
		}
	</script>

	<script src="js/jquery.multi-select.js" type="text/javascript"></script>
	<script>
		$(document).ready(function() {
			checkModules();
		});

		function checkModules() {
		}
	</script>

	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</body>

</html>