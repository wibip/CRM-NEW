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
$db = new db_functions();
require_once 'classes/CommonFunctions.php';
$common_functions = new CommonFunctions();
require_once dirname(__FILE__) . '/models/userMainModel.php';
$user_model = new userMainModel();
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');
$page = 'User';
?>

<head>
	<meta charset="utf-8">
	<title>Users - User Management</title>
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
		.fieldgroup{
			float: left;
			width: auto;
			margin-right: 3em;
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

$role_edit_id  = 0;
$role_array = [];
$other_array = [];
$account_array = [];
$role_name = "";

function userUpdateLog($user_id, $action_type, $action_by,$db)
{
		$update_query = "INSERT INTO `admin_users_update` (
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
															`admin_users`
															WHERE id='$user_id')";
		$ex_update_log = $db->execDB($update_query);
		return $ex_update_log;
	}


if ($system_package == 'N/A') {
	$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE `user_type` ='$user_type' AND `module_name`  NOT IN ('users','profile','change_portal') AND is_enable=1  ORDER BY module_name";
	$modules1 = $db->selectDB($q1);
	$modules = $modules1['data'];
} else {
	$q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE a.`user_type` ='$user_type' AND a.`module_name`  NOT IN ('users','profile','change_portal') AND a.is_enable=1 ORDER BY module_name";
	// echo $q11;
	$modules1 = $db->selectDB($q11);

	$modules = $modules1['data'];
}

	if (isset($_POST['submit_1'])) {
		$full_name = $_POST['full_name_1'];
		$br_q = "SHOW TABLE STATUS LIKE 'admin_users'";
		$result2=$db->selectDB($br_q);

		foreach($result2['data'] AS $rowe){
			$auto_inc = $rowe['Auto_increment'];
		}

		$new_user_name = str_replace(' ', '_', strtolower(substr($full_name, 0, 5) . 'u' . $auto_inc));
		$password  = CommonFunctions::randomPassword();

		$access_role = $_POST['access_role_1']; 
		$user_type = $common_functions->getUserTypeFromAccessType($access_role);
		// $user_type = ($access_role == "SADMIN001") ? "SADMIN" : $_POST['user_type'];
		$loation = $_POST['loation'];
		$email = $_POST['email_1'];
		$language = $_POST['language_1'];
		$timezone = $_POST['timezone_1'];
		$mobile = $_POST['mobile_1'];

		$user_distributor = $db->getValueAsf("SELECT u.distributor AS f FROM admin_access_roles u WHERE u.access_role='$access_role' LIMIT 1");

		$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$password\"))))) AS f";
		$updated_pw='';
		$pw_results=$db->selectDB($pw_query);
		foreach($pw_results['data'] AS $row){
			$updated_pw = strtoupper($row['f']);
		}

		$query = "INSERT INTO admin_users
				(user_name, `password`, access_role, user_type, user_distributor, full_name, email, `language`, `timezone`, mobile, is_enable, create_date,create_user)
				VALUES ('$new_user_name','$updated_pw','$access_role','$user_type','$user_distributor','$full_name','$email', '$language' ,'$timezone', '$mobile','1',now(),'$user_name')";
		// echo $query;
		$ex =$db->execDB($query);
		if ($ex ==true) {
			$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
			// if ($user_type == 'ADMIN') {
			// 	$dist = 'ADMIN';
			// } else if ($user_type == 'MNO') {
			// 	$dist = $user_distributor;
			// } else {
			// 	$kmno_query = "SELECT mno_id FROM exp_mno_distributor where distributor_code = '$user_distributor'";
			// 	$query_results=$db->selectDB($kmno_query);
			// 	foreach($query_results['data'] AS $row){
			// 		$dist = $row['mno_id'];
			// 	}
			// }

			// if ($access_role == 'ADMIN') {
			// 	$acc_type = 'Admin';
			// } else {
			// 	$acc_type = 'User';
			// }

			$message_response = $message_functions->showNameMessage('user_create_success', $new_user_name);
			$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create User',$idContAutoInc,'',$message_response);
			$_SESSION['msg2'] =  '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';

		} else {
			$message_response = $message_functions->showMessage('user_create_fail', '2001');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create User',0,'2001',$message_response);
			$db->userErrorLog('2001', $user_name, 'script - ' . $script);
			$_SESSION['msg2'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $message_response . '</strong></div>';
		}
	}
	//  to the form edit user
	elseif (isset($_GET['edit_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$edit_id = $_GET['edit_id'];
			$edit_user_data = $user_model->getUser($edit_id);
		} else {
			$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Load User',$_GET['edit_id'],'2004','Oops, It seems you have refreshed the page. Please try again');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
			//header('Location: location.php?t=3');
			$tab2 = "set";
			$tab5 = "not";
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
					$get_user_detail_q = "SELECT u.user_name, u.email, u.user_name FROM admin_users u WHERE u.id='$id' LIMIT 1";
					$user_details = $db->select1DB($get_user_detail_q);
					$edit_user_name = $user_details['user_name'];
					$old_email = $user_details['email'];
					$archive_q = "INSERT INTO `admin_users_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$edit_user_name',NOW(),last_update,'update'
								FROM `admin_users` WHERE id='$id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE `admin_users`
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
						$message_response = $message_functions->showNameMessage('role_edit_success', $edit_user_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify User',$id,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					} else {
						$message_response = $message_functions->showMessage('role_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_edit_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_edit_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				}
			} else {
				$message_response = $message_functions->showNameMessage('role_edit_success', $edit_user_name);
				$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'3001',$message_response);
				// $create_log->save('3001', $message_functions->showNameMessage('role_edit_success', $edit_user_name), '');
				$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
			}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify User',$id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	elseif (isset($_POST['edit-submita-pass'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { 
				$id = $_POST['id'];
				$passwd = $_POST['passwd'];
				$passwd_2 = $_POST['passwd_2'];
				if ($passwd == $passwd_2) {
					$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$id' LIMIT 1");
					//update log//
					$ex_log = userUpdateLog($id, 'RESET_PASSWORD', $user_name,$db);
					if ($ex_log===true) {
						$pw_query = "SELECT CONCAT('*', UPPER(SHA1(UNHEX(SHA1(\"$passwd\"))))) AS f";
						$updated_pw='';
						$pw_results=$db->selectDB($pw_query);

						foreach($pw_results['data'] AS $row){
							$updated_pw = strtoupper($row['f']);
						}

						$edit_query = "UPDATE `admin_users`
										SET `password` = '$updated_pw'
										WHERE `id` = '$id'";
						$edit_result = $db->execDB($edit_query);

						if ($edit_result===true) {
							$message_response = $message_functions->showNameMessage('role_password_edit_success', $user_full_name);
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'User Password Reset',$id,'3001',$message_response);
							// $create_log->save('3001', $message_functions->showNameMessage('role_password_edit_success', $user_full_name), '');
							$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						} else {
							$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2002',$message_response);
							$db->userErrorLog('2002', $user_name, 'script - ' . $script);
							// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
							$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					} else {
						$message_response = $message_functions->showMessage('role_password_edit_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_password_edit_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_password_edit_failed', '2006');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2006',$message_response);
					$db->userErrorLog('2006', $user_name, 'script - ' . $script);
					// $create_log->save('2006', $message_functions->showMessage('role_password_edit_failed', '2006'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					//Password confirmation failed
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User Password Reset',$id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//login status change////
	elseif (isset($_GET['status_change_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
				$status_change_id = $_GET['status_change_id'];
				$action_sts = $_GET['action_sts'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$status_change_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM admin_users u WHERE u.id='$status_change_id' LIMIT 1");

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
					$archive_q = "INSERT INTO `admin_users_archive` (user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,archive_by,archive_date,last_update,`status`)
								SELECT user_name,`password`,access_role,user_type,user_distributor,full_name,email,`language`,mobile,verification_number,is_enable,create_date,create_user,'$user_name',NOW(),last_update,'status_change'
								FROM `admin_users` WHERE id='$status_change_id'";
					$archive_result = $db->execDB($archive_q);

					$edit_query = "UPDATE  `admin_users` SET `is_enable` = '$action_sts' WHERE `id` = '$status_change_id'";
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$en_dis_msg = '';
						if ($set == 'enabled') {
							$message_response = $message_functions->showNameMessage('role_user_name_enable_success', $user_full_name);
							$en_dis_msg = 'Enable';
						} elseif ($set == 'disabled') {
							$message_response = $message_functions->showNameMessage('role_user_name_disable_success', $user_full_name);
							$en_dis_msg = 'Disable';
						}

						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'User status change',$status_change_id,'3001',$message_response);
						// $create_log->save('3001', $susmsg, '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . " </strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, $en_dis_msg . ' User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('role_user_name_enable_failed', '2001');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2001',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2001', $message_functions->showMessage('role_user_name_enable_failed', '2001'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2002','Something went wrong,please try again');
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong> [2002] Something went wrong,please try again</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'User status change',$status_change_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>�</button><strong>" . $message_response . "</strong></div>";
		}
	}
	//user remove////
	elseif (isset($_GET['user_rm_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
				$user_rm_id = $_GET['user_rm_id'];
				$user_full_name = $db->getValueAsf("SELECT u.full_name AS f FROM admin_users u WHERE u.id='$user_rm_id' LIMIT 1");
				$usr_name = $db->getValueAsf("SELECT u.user_name AS f FROM admin_users u WHERE u.id='$user_rm_id' LIMIT 1");

				$archive_record = "INSERT INTO `admin_users_archive` (
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
																		`admin_users`
																		WHERE id='$user_rm_id')";
				$archive_record = $db->execDB($archive_record);

                //print_r($archive_record);echo'--';
				if ($archive_record===true) {
					$edit_query = "DELETE FROM `admin_users`  WHERE `id` = '$user_rm_id'";
					//$edit_result = mysql_query($edit_query);
					$edit_result = $db->execDB($edit_query);

					if ($edit_result===true) {
						$message_response = $message_functions->showNameMessage('role_role_remove_success', $user_full_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Remove User',$user_rm_id,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_role_remove_success', $user_full_name), '');
						$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";

						//Activity log
						// $db->userLog($user_name, $script, 'Remove User', $usr_name);
					} else {
						$message_response = $message_functions->showMessage('role_role_remove_failed', '2002');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2002',$message_response);
						$db->userErrorLog('2002', $user_name, 'script - ' . $script);
						// $create_log->save('2002', $message_functions->showMessage('role_role_remove_failed', '2002'), '');
						$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
					}
				} else {
					$message_response = $message_functions->showMessage('role_role_remove_failed', '2002');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2002',$message_response);
					$db->userErrorLog('2002', $user_name, 'script - ' . $script);
					// $create_log->save('2002', $message_functions->showMessage('role_role_remove_failed', '2002'), '');
					$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
				}
		} else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Remove User',$user_rm_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//create and assign Roles
	elseif (isset($_POST['assign_roles_submita'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) { //refresh validate
			$access_role_id = isset($_POST['access_role_id']) ? $_POST['access_role_id'] : 0;
			$role_edit_id = isset($_POST['role_edit_id']) ? $_POST['role_edit_id'] : 0;
			$access_role_name = trim($_POST['access_role_name']);
			$role_type = $_POST['role_type'];

			if($role_edit_id == 0) {
				switch($role_type){
					case 'sadmin':
						$user_distributor = 'SADMIN';
					break;
					case 'salesmanager':
						$user_distributor = 'SMAN';
					break;
					case 'nadmin':
						$user_distributor = 'ADMIN';
					break;
					default:
						$user_distributor = 'ADMIN';
				}
				$access_role_id = time() . $role_type . $user_distributor;
				if (strtoupper($access_role_name) == "ADMIN") {
					$message_response = $message_functions->showMessage('user_admin_not_allow');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',0,'',$message_response);
					// $msg = $message_functions->showMessage('user_admin_not_allow');
					$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
				} else {
					$query0 = "INSERT INTO `admin_access_roles` (`access_role`,`description`,`distributor`,`role_type` ,`create_user`,`create_date`)
				 				VALUES ('$access_role_id', '$access_role_name', '$user_distributor', '$role_type', '$user_name',now())";
					$result0 =$db->execDB($query0);

					foreach ($_POST['my_select'] as $selectedOption) {
						$module_name = $selectedOption;
						$query1 = "REPLACE INTO `admin_access_roles_modules`
									(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
									VALUES ('$access_role_id', '$module_name', '$user_distributor', 'default', '$user_name', now())";
						$result1 = $db->execDB($query1);
					}

					if($role_type == 'salesmanager'){
						$query1 = "REPLACE INTO `admin_access_roles_modules`
									(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
									VALUES ('$access_role_id', 'sales_crm', '$user_distributor', 'default', '$user_name', now())";
						$result1 = $db->execDB($query1);
					}

					if($role_type == 'sadmin' || $role_type == 'salesmanager') {
						if($role_type == 'sadmin'){
							foreach ($_POST['other_modules'] as $selectedOption) {
								$other_name = $selectedOption;
								$queryOther = "REPLACE INTO `admin_access_roles_modules`
												(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
												VALUES ('$access_role_id', '$other_name', '$user_distributor', 'other', '$user_name', now())";
								// echo $queryOther."<br/>";
								$resultOther = $db->execDB($queryOther);
							}
						}
						
						foreach ($_POST['operations'] as $selectedOperation) {
							$operationId = $selectedOperation;
							$queryOperation = "REPLACE INTO `admin_access_account`
											(`access_role`, `operation_id`, `create_user`, `create_date`)
											VALUES ('$access_role_id', '$operationId', '$user_name', now())";
							// echo $queryOperation."<br/>";
							$resultOperation = $db->execDB($queryOperation);
						}
					}
					

					if ($result1===true) {
						$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
						
						$query12 = "INSERT INTO `admin_access_roles_modules`
									(`access_role`, `module_name`, `distributor` ,`module_type`, `create_user`, `create_date`)
									VALUES ('$access_role_id', 'profile', '$user_distributor', '$module_type', '$user_name', now())";
						$result12 =$db->execDB($query12);
					}

					if ($result0===true) {
						$message_response = $message_functions->showNameMessage('role_role_create_success', $access_role_name);
						$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create Access Role',$idContAutoInc,'3001',$message_response);
						// $create_log->save('3001', $message_functions->showNameMessage('role_role_create_success', $access_role_name), '');
						$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";

					} else {
						$message_response = $message_functions->showMessage('role_role_create_failed', '2001');
						$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$idContAutoInc,'2001',$message_response);
						$db->userErrorLog('2001', $user_name, 'script - ' . $script);
						// $create_log->save('2001', $message_functions->showMessage('role_role_create_failed', '2001'), '');
						$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
					}
				} 
			}else {
				$getModRol_q = "SELECT * FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id'";
				$getModRol_r=$db->selectDB($getModRol_q);

				foreach($getModRol_r['data'] AS $row){
					$qq1 = "INSERT INTO `admin_access_roles_modules_archive`
					(`access_role`, `module_name`, `distributor`, `create_user`, `archive_by`, `archive_date`)
					(SELECT  `access_role`, `module_name`, `distributor`, `create_user`, '$user_name', NOW()
					FROM `admin_access_roles_modules` WHERE `id`='".$row["id"]."' LIMIT 1)";
					$rr1=$db->execDB($qq1);

					$sqlRecordDelete = "DELETE FROM `admin_access_roles_modules` WHERE `id`='".$row["id"]."'";
					$resultRecordDelete=$db->execDB($sqlRecordDelete);
				}

				$sqlAccountDelete = "DELETE FROM `admin_access_account` WHERE `access_role`='".$access_role_id."'";
				$resultAccountDelete=$db->execDB($sqlAccountDelete);

				foreach ($_POST['my_select'] as $selectedOption) {
					$module_name = $selectedOption;
					$query1 = "REPLACE INTO `admin_access_roles_modules`
								(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
								VALUES ('$access_role_id', '$module_name', '$user_distributor', 'default', '$user_name', now())";
					$result1 = $db->execDB($query1);
				}

				if($role_type == 'sadmin') {
					foreach ($_POST['other_modules'] as $selectedOption) {
						$other_name = $selectedOption;
						$queryOther = "REPLACE INTO `admin_access_roles_modules`
										(`access_role`, `module_name`, `distributor` , `module_type`, `create_user`, `create_date`)
										VALUES ('$access_role_id', '$other_name', '$user_distributor', 'other', '$user_name', now())";
						$resultOther = $db->execDB($queryOther);
					}

					foreach ($_POST['operations'] as $selectedOperation) {
						$operationId = $selectedOperation;
						$queryOperation = "REPLACE INTO `admin_access_account`
										(`access_role`, `operation_id`, `create_user`, `create_date`)
										VALUES ('$access_role_id', '$operationId', '$user_name', now())";
						$resultOperation = $db->execDB($queryOperation);
					}
				}
			}
				
		} //key validation
		else {
			$message_response = $message_functions->showMessage('transection_fail', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',0,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//remove Roles
	elseif (isset($_GET['remove_id']) && isset($_GET['remove_access_role'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {
				$remove_id = $_GET['remove_id'];
				$remove_access_role = $_GET['remove_access_role'];
				$role_name = $_GET['description'];
				$cnt = "SELECT COUNT(*) AS f FROM `admin_users` WHERE `access_role` = '$remove_access_role' AND `user_distributor` = '$user_distributor'";
				$count_result = $db->getValueAsf($cnt);

				if ($count_result > 0) {
					$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> Access Role is already assigned</strong></div>";
				} else {
					$q_remove_archive = "INSERT INTO `admin_access_roles_archive`
										(`access_role`, `description`, `distributor`, `create_user`, `archive_by`, `archive_date`)
										(SELECT  `access_role`, `description`, `distributor`, `create_user`, '$user_name', NOW()
										FROM `admin_access_roles` WHERE `id`='$remove_id' LIMIT 1)";
					$result_remove_archive = $db->execDB($q_remove_archive);

					$getMod_q = "SELECT * FROM `admin_access_roles` WHERE `id`='$remove_id'";
					$getMod_r=$db->selectDB($getMod_q);
					
  					foreach($getMod_r['data'] AS $row){
						$access_role = $row['access_role'];
						$getModRol_q = "SELECT * FROM `admin_access_roles_modules` WHERE `access_role`='$access_role'";
						$getModRol_r=$db->selectDB($getModRol_q);
	
						foreach($getModRol_r['data'] AS $row){
							$qq1 = "INSERT INTO `admin_access_roles_modules_archive`
									(`access_role`, `module_name`, `distributor`, `create_user`, `archive_by`, `archive_date`)
									(SELECT  `access_role`, `module_name`, `distributor`, `create_user`, '$user_name', NOW()
									FROM `admin_access_roles_modules` WHERE `access_role`='$access_role' LIMIT 1)";
							//$rr1 = mysql_query($qq1);
							$rr1=$db->execDB($qq1);
						}
					}

					// var_dump($result_remove_archive);
					if ($result_remove_archive===true) {
						$q_remove_dis = "DELETE FROM `admin_access_roles` WHERE `id`='$remove_id'";
						$result_remove_dis = $db->execDB($q_remove_dis);

						$q_remove = "DELETE FROM `admin_access_roles_modules`
									WHERE `access_role`='$remove_access_role' AND `distributor` = '$user_distributor'";
						$result_remove = $db->execDB($q_remove);
						// $msg = $message_functions->showMessage('user_remove_success');
						if ($result_remove_dis) {
							$message_response = $message_functions->showMessage('user_remove_success');
							$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Remove Access Role',$remove_id,'3001',$message_response);
							$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
							//Activity log
							// $db->userLog($user_name, $script, 'Remove Access Role', $role_name);
						} else {
							$message_response = $message_functions->showMessage('user_remove_fail', '2003');
							$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$remove_id,'2003',$message_response);
							// $msg = $message_functions->showMessage('user_remove_fail', '2003');
							$db->userErrorLog('2003', $user_name, 'script - ' . $script);
							$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
						}
					}
				}
		} else {
			$message_response = $message_functions->showMessage('transection_is_failed', '2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create Access Role',$remove_id,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			// $msg = $message_functions->showMessage('transection_is_failed', '2004');
			$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
		}
	} 
	//Load edit role
	elseif (isset($_GET['role_ID'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['form_secreat']) {
			$role_edit_id = $_GET['role_edit_id'];
			$access_role_id = $_GET['role_ID'];
			$i = $a = $o = 0;

			//get role name and type
			$roleData = $db->selectDB("SELECT `description`,role_type FROM `admin_access_roles` WHERE `id`='$role_edit_id'");
			$role_name = $roleData['data'][0]['description'];
			$roleType = $roleData['data'][0]['role_type'];
			//check role type
			if($roleType == "sadmin"  || $roleType == 'salesmanager'){
				//get selected other modules
				$other_result = $db->selectDB("SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id' AND module_type='other'");
				foreach($other_result['data'] AS $otherRole){
					$other_array[$o] = $otherRole['module_name'];
					$o++;
				}

				//get selected operation accounts
				$account_result = $db->selectDB("SELECT `operation_id` FROM `admin_access_account` WHERE `access_role`='$access_role_id'");
				foreach($account_result['data'] AS $account){
					$account_array[$a] = $account['operation_id'];
					$a++;
				}
			}

			//get selected default modules
			$role_result = $db->selectDB("SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role`='$access_role_id' AND module_type='default'");
			foreach($role_result['data'] AS $role){
				$role_array[$i] = $role['module_name'];
				$i++;
			}
				$i = 0;
		} else {
			$_SESSION['msg3'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>Oops, It seems you have refreshed the page. Please try again</strong></div>";
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
									<h3>User Management</h3>
								</div>
								<!-- /widget-header -->
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs newTabs">
											<li <?php if (isset($tab1) || isset($tab5)) { ?>class="active" <?php } ?>><a href="#create_users" data-toggle="tab">Manage Users</a></li>
											<li <?php if (isset($tab3)) { ?>class="active" <?php } ?>><a href="#create_roles" data-toggle="tab">Manage Roles</a></li>
										</ul>
										<br>
										<div class="tab-content">
											<!-- +++++++++++++++++++++++++++++ create users ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_users">
												<h1 class="head">Users</h1>
												<div id="response_d3"></div>

												<?php
													if(isset($tab1)){
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
														<div class="control-group">
															<label class="control-label" for="access_role_1">Access Role<sup><font color="#FF0000"></font></sup></label>

															<div class="controls col-lg-5 form-group">
																<select class="span4 form-control" name="access_role_1" id="access_role_1">
																	<option value="">Select Access Role</option>
																	<?php
																	if ($user_type == 'SUPPORT') {
																		$key_query = "SELECT a.`access_role` ,a.description
																						FROM `admin_access_roles` a , `admin_access_roles_modules` b
																						WHERE a.`distributor` ='$user_distributor' AND a.`distributor`=b.`distributor` AND b.`module_name`='support' AND a.`access_role`=b.`access_role`
																						GROUP BY a.`access_role` ORDER BY description";
																	} else {
																		$key_query = "SELECT `access_role` ,description
																						FROM `admin_access_roles`
																						WHERE `create_user`='$user_name' ORDER BY description";
																	}
																	$query_results=$db->selectDB($key_query);
																		foreach($query_results['data'] AS $row){	
																		$access_role = $row['access_role'];
																		$description = $row['description'];
																		echo '<option value="' . $access_role . '">' . $description . '</option>';
																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
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
																			$language_code = $row['language_code'];
																			$language = $row['language'];
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

														<div class="form-actions">
															<button type="submit" name="submit_1" id="submit_1" class="btn btn-primary">Save</button>&nbsp; <strong>
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
																	require_once dirname(__FILE__) . '/DTO/User.php';
																	$data = new User();
																	$data->user_type = $user_type;
																	$data->user_distributor = $user_distributor;
																	$data->user_name = $user_name;
																	$query_results = $user_model->get_activeUseres($data);
																	foreach ($query_results as $row) {
																		$id = $row->id; //$row[id];
																		$user_name1 = $row->user_name; //$row[user_name];
																		$full_name = $row->full_name; //$row[full_name];
																		$access_role = $row->access_role; //$row[access_role];
																		$access_role_desc = $row->description; //$row['description'];
																		$user_type1 = $row->user_type; //$row[user_type];
																		$user_distributor1 = $row->user_distributor; //$row[user_distributor];
																		$email = $row->email; //$row[email];
																		$is_enable = $row->is_enable; //$row[is_enable];
																		$create_user = $row->create_user; //$row[create_user];
																		if ($user_type1 == 'TECH') {
																			$access_role_desc = 'Tech Admin';
																		} else if ($user_type1 == 'SUPPORT' && $access_role=='admin') {
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
																	?>
																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
												<!-- /widget -->
											</div>
											
											<!-- +++++++++++++++++++++++++++++ Edit users ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab5) && $tab5 == "set") { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="edit_users">
												<h1 class="head">
												Edit Profile
												</h1>
												<form autocomplete="off" id="edit-user-profile" action="?t=1" method="post" class="form-horizontal">
												<?php
													if(isset($tab5)){
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
														// $user_name =  $edit_user_data[0]->getUserName();
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
																	$key_query = "SELECT access_role,description FROM admin_access_roles 
																				WHERE `create_user`='$user_name' ORDER BY description";
																	// echo $key_query;
																	$query_results=$db->selectDB($key_query);
																	foreach($query_results['data'] AS $row){
																		$access_role = $row['access_role'];
																		if ($access_role == $access_role_set) {
																			$description = $row['description'];
																			echo '<option value="' . $access_role . '" selected>' . $description . '</option>';
																		} else {
																			$description = $row['description'];
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
																		$language_code = $row['language_code'];
																		$language = $row['language'];
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
														<div class="form-actions">
															<button type="submit" name="edit-submita" id="edit-submita" class="btn btn-primary" >Save</button>&nbsp; <strong>
																<font color="#FF0000"></font><small></small>
															</strong>
															<button type="button" onclick="goto('?t=1')" class="btn btn-danger">Cancel</button>&nbsp;
															<script type="text/javascript">
																function goto(url) {
																	window.location = url;
																}
																function footer_submitfn() {
																	//alert("fn");
																	$("#edit-user-profile").prop('disabled', false);
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
											<!-- +++++++++++++++++++++++++++++ create Roles ++++++++++++++++++++++++++++++++ -->
											<div <?php if (isset($tab3)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_roles">

												<h1 class="head">Manage Roles</h1>
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
													<form autocomplete="off" id="assign_roles_submit" name="assign_roles_submit" method="post" class="form-horizontal" action="?t=3">
														<fieldset>
															<div id="response_d3"></div>
															<?php
															echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'] .'" />';
															echo '<input type="hidden" name="role_edit_id" id="role_edit_id" value="'.$role_edit_id.'" />';
															echo '<input type="hidden" name="access_role_id" id="access_role_id" value="'.$access_role_id.'" />';
															if($role_edit_id != 0) {
																echo '<input type="hidden" name="role_type" id="role_type" value="'.$roleType.'" />';
															}
															
															?>
															<div class="control-group">
																<label class="control-label" for="role_type">Role Type</label>
																<div class="controls form-group col-lg-5">
																	<fieldset id="role_types">
																		<div class="fieldgroup">
																			<input type="radio" name="role_type" id="role_type" value="sadmin" <?=(($roleType == 'sadmin' || $role_edit_id == 0) ? 'checked' : '')?> <?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "sadmin">Super Admin</label>
																		</div>
																		<div class="fieldgroup">
																			<input type="radio" name="role_type" id="role_type" value="salesmanager" <?=($roleType == 'salesmanager' ? 'checked' : '')?> <?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "nadmin">Sales Manager</label>
																		</div>
																		<div class="fieldgroup">
																			<input type="radio" name="role_type" id="role_type" value="nadmin" <?=($roleType == 'nadmin' ? 'checked' : '')?> <?=($role_edit_id != 0 ? "disabled" : "")?>><label for= "nadmin">Admin</label>
																		</div>
																	</fieldset>	
																</div>
															</div>
															<div class="control-group">
																<label class="control-label" for="access_role_name">Access Role Name</label>
																<div class="controls form-group col-lg-5">
																	<input class="form-control span2" id="access_role_name" name="access_role_name" type="text" value="<?=$role_name?>" <?=($role_edit_id != 0 ? "disabled" : "")?>>
																</div>
															</div>
															<div class="control-group" id="admin_operations">
																<label class="control-label" for="my_select"><?=($_SESSION['SADMIN'] == true ? "Admin " : "")?>Modules</label>

																<div class="controls form-group col-lg-5">
																	<select class="form-control span4" multiple="multiple" id="my_select" name="my_select[]">
																		<option value="" disabled="disabled"> Choose Module(s)</option>
																		<?php
																		foreach ($modules as $key => $row) {
																			$module_name = $row['module_name'];
																			$module = $row['name_group'];
																			$selected = "";
																			if (in_array($module_name, $role_array)) {
																				$selected = "selected";
																			} 
																			echo "<option " . $selected . " value='" . $module_name . "'>" . $module . "</option>";
																		}
																		?>
																	</select>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group -->
															
															<div class="control-group" id="sadmin_operations">
																<label class="control-label" for="my_select">Operations</label>

																<div class="controls form-group col-lg-5">
																	<select class="form-control span4" multiple="multiple" id="operations" name="operations[]">
																		<option value="" disabled="disabled"> Choose Operation(s)</option>
																		<?php
																			$q12 = "SELECT id,full_name FROM admin_users WHERE user_type='MNO'";
																			$operations = $db->selectDB($q12);
																			foreach ($operations['data'] as $row) {
																				$operation_id = $row['id'];
																				$operation_name = $row['full_name'];
																				$selected = "";
																				if (in_array($operation_id, $account_array )) {
																					$selected = "selected";
																				} 
																				echo "<option " . $selected . " value='" . $operation_id . "'>" . $operation_name . "</option>";
																			}
																		?>
																	</select>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group -->

															<div class="control-group" id="sadmin-omodules">
																<label class="control-label" for="my_select">Other Modules</label>

																<div class="controls form-group col-lg-5">
																	<select class="form-control span4" multiple="multiple" id="other_modules" name="other_modules[]">
																		<option value="" disabled="disabled"> Choose Module(s)</option>
																		<?php
																			if ($system_package == 'N/A') {
																				$q1 = "SELECT `module_name` ,`name_group` FROM `admin_access_modules` WHERE (`user_type` = 'MNO' || `user_type` = 'PROVISIONING') AND `module_name`  NOT IN ('users','profile','change_portal') AND is_enable=1 ORDER BY module_name";

																				$modules1 = $db->selectDB($q1);
																				$modules = $modules1['data'];
																			} else {
																				$q11 = "SELECT a.`module_name` ,a.`name_group` FROM `admin_access_modules` a WHERE (a.`user_type` = 'MNO' || a.`user_type` = 'PROVISIONING') AND a.`module_name` NOT IN ('users','profile','change_portal') AND a.is_enable=1  ORDER BY module_name";
																				$modules1 = $db->selectDB($q11);
																				$q12 = "SELECT options FROM admin_product_controls WHERE product_code='$system_package' AND feature_code='ALLOWED_PAGE'";
																				$allow_pages = $package_functions->getOptions('ALLOWED_PAGE',$system_package);
																				$modules2 = json_decode($allow_pages);
																				foreach ($modules1['data'] as $key => $value) {
																					if (!in_array($value['module_name'], $modules2)) {
																						unset($modules1['data'][$key]);
																					}
																				}
																				$modules = $modules1['data'];
																			}
																		// }


																		foreach ($modules as $row) {
																			$module_name = $row['module_name'];
																			$module = $row['name_group'];
																			$selected = "";
																			if (in_array($module_name, $other_array)) {
																				$selected = "selected";
																			}
																			echo "<option " . $selected . " value='" . $module_name . "'>" . $module . "</option>";
																		}
																		?>
																	</select>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group -->

															<div class="form-actions">
																<button type="submit" name="assign_roles_submita" id="assign_roles_submita" class="btn btn-primary">Save</button>
															</div>
														</fieldset>
													</form>

													<script type="text/javascript">
														$(document).ready(function() {
															// document.getElementById("assign_roles_submita").disabled = true;
														});
													</script>


												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>Existing Admin Roles</h3>
													</div>

													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Access Role</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Modules Assigned</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Created Date</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Remove</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	if ($user_type == 'SUPPORT') {
																		$key_query = "SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,r.`create_date` 
																			FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
																			ON r.`access_role`=m.`access_role`,
																			`admin_access_modules` a
																			WHERE r.`distributor`='$user_distributor'
																			AND a.`module_name`=m.`module_name`
																			AND a.`user_type`='$user_type' AND m.`module_name`='support'
																			GROUP BY r.access_role
																			ORDER BY r.`access_role`";
																	} else {
																		// $key_query = "SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,DATE_FORMAT(r.`create_date`,'%m/%d/%Y %h:%i %p') AS create_date 
																		// 				FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
																		// 				ON r.`access_role`=m.`access_role`,
																		// 				`admin_access_modules` a
																		// 				WHERE r.`distributor`='$user_distributor'
																		// 				AND a.`module_name`=m.`module_name`
																		// 				AND a.`user_type`='$user_type'
																		// 				GROUP BY r.access_role
																		// 				ORDER BY r.`access_role`";
																		$key_query = "SELECT r.id, r.`access_role`,r.`description`, GROUP_CONCAT(CONCAT('<li>',a.`name_group`,'</li>') SEPARATOR '') AS m_list,m.`module_name`,DATE_FORMAT(r.`create_date`,'%m/%d/%Y %h:%i %p') AS create_date 
																						FROM `admin_access_roles_modules` m LEFT JOIN `admin_access_roles` r
																						ON r.`access_role`=m.`access_role`,
																						`admin_access_modules` a
																						WHERE r.`create_user`='$user_name'
																						AND a.`module_name`=m.`module_name`
																						GROUP BY r.access_role
																						ORDER BY r.`id` DESC";
																	}
																	$query_results=$db->selectDB($key_query);
																	foreach($query_results['data'] AS $row){
																		$access_role = $row['access_role'];
																		$description = $row['description'];
																		$create_date = $row['create_date'];
																		$id_access_role = $row['id'];
																		$m_list = $row['m_list'];

																		//check access Role use or not//
																		$check_role = $db->SelectDB("SELECT * FROM `admin_users` u WHERE u.`access_role`='$access_role'");

																		echo '<tr>
																				<td> ' . $description . ' </td>
																				<td >  <a class="btn" id="' . $access_role . '"> View </a> ';
																									echo '<script>
																					$(document).ready(function() {
																						$(\'#' . $access_role . '\').tooltipster({
																							content: $("' . $m_list . '"),
																							theme: \'tooltipster-shadow\',
																							animation: \'grow\',
																							onlyOne: true,
																							trigger: \'click\'
																						});
																					});
																				</script></td>' .
																			'<td> ' . $create_date . ' </td>';
																		/////////////////////////////////////////////
																		echo '<td>';
																		echo '<a href="javascript:void();" id="RE_' . $id_access_role . '"  class="btn btn-small btn-primary">
																				<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
																				$(document).ready(function() {
																				$(\'#RE_' . $id_access_role . '\').easyconfirm({locale: {
																						title: \'Role Edit\',
																						text: \'Are you sure you want to edit this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																						button: [\'Cancel\',\' Confirm\'],
																						closeText: \'close\'
																						}});
																					$(\'#RE_' . $id_access_role . '\').click(function() {
																						window.location = "?form_secreat=' . $secret . '&t=3&role_ID=' . $access_role . '&role_edit_id=' . $id_access_role . '"
																					});
																					});
																				</script>';
																		echo '</td>';
																		echo '<td>';
																		if ($check_role['rowCount'] == 0) {
																			echo '<a href="javascript:void();" id="AP_' . $id_access_role . '"  class="btn btn-small btn-primary">
																					<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#AP_' . $id_access_role . '\').easyconfirm({locale: {
																							title: \'Role Remove\',
																							text: \'Are you sure you want to remove this Role?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#AP_' . $id_access_role . '\').click(function() {
																							window.location = "?token2=' . $secret . '&t=3&remove_access_role=' . $access_role . '&description=' . $description . '&remove_id=' . $id_access_role . '"
																						});
																						});
																					</script>';
																		} else {
																			echo	'<a class="btn btn-small btn-primary" disabled>
																					<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a>';
																		}
																		echo '</td>';
																	}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
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
							<?php echo $db->validateField('email'); ?>
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
							<?php echo $db->validateField('email'); ?>
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

			$("#assign_roles_submita").easyconfirm({
				locale: {
					title: 'Role Creation',
					text: 'Are you sure you want to save this Role?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
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
			
			//sadmin_operations sadmin-omodules
			<?php if ($role_edit_id == 0 || ($role_edit_id != 0 && $roleType == 'sadmin')) { ?>
				$('#admin_operations').show();	
				$('#sadmin_operations').show();
				$('#sadmin-omodules').show();
			<?php } elseif($role_edit_id != 0 && $roleType == 'salesmanager') { ?>
				$('#admin_operations').hide();
				$('#sadmin_operations').show();
				$('#sadmin-omodules').hide();
			<?php
				} else {
			?>
				$('#admin_operations').show();
				$('#sadmin_operations').hide();
				$('#sadmin-omodules').hide();
			<?php
				}
			?>
			
			$('#my_select').multiSelect(); 
			$('#my_select_roles').multiSelect();
			$('#other_modules').multiSelect(); 
			$('#operations').multiSelect();

			$('input[type=radio][name=role_type]').change(function() {
				switch ($(this).val()) {
					case "sadmin":
						$('#admin_operations').show();
						$('#sadmin_operations').show();
						$('#sadmin-omodules').show();
					break;
					case "salesmanager":
						$('#admin_operations').hide();
						$('#sadmin_operations').show();
						$('#sadmin-omodules').hide();
					break;
					case "nadmin":
						$('#admin_operations').show();
						$('#sadmin_operations').hide();
						$('#sadmin-omodules').hide();
					break;
				}
			});
		});
	</script>

	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	</body>

</html>