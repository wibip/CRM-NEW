<?php ob_start();?>
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
$CommonFunctions = new CommonFunctions();
$page = "API profile";
?> 
<head>
<meta charset="utf-8">
<title>BI Api Profiles</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!--Alert message css--> 
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<!--    <link rel="stylesheet" href="css/bootstrapValidator.css"/> -->
<link rel="stylesheet" type="text/css" href="css/formValidation.css">
<link rel="stylesheet" href="css/tablesaw.css?v1.1">
<link rel="stylesheet" href="css/jquery-msgpopup.css" type="text/css" />
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="css/dataTables.bootstrap.css" />
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
	$tab1 = "set";
}
$ap_control_var = $db->setVal('ap_controller', 'ADMIN');


if(isset($_POST['create_ap_controller'])){
	if($_SESSION['FORM_SECRET']==$_POST['form_secret']) {//refresh validate
		$ap_con_name = trim($_POST['ap_con_name']);
		$brand = trim($_POST['brand']);
		$model = trim($_POST['model']);
		$desc = trim($_POST['desc']);
		$time_zone = trim($_POST['apc_time_zone']);
		$api_version = $_POST['version'];
		
		$api_profile = $_POST['api_profile'];
		$api_url = trim($_POST['api_server_url']);
		$api_url_se = trim($_POST['api_server_url']);
		$api_uname = $_POST['api_username'];
		$api_pass = $_POST['api_password'];
		$type = trim($_POST['type']);
		if($type=='FIREWALL CONTROLLER'){
			$api_profile = 'meraki1';
		}

		if($type=='DPSK'){
			$api_profile = 'CloudPath';
		}
		
		$api_key_se = trim($_POST['api_key_se']);
		$controller_description=array();
		$controller_description['api_key'] = $api_key_se;
		$controller_description_json= json_encode($controller_description);

		$api_test_url = $api_url.'/api/'.$api_version.'/token';
		$data = json_encode(['username'=>$api_uname, 'password'=>$api_pass]);
		$apiReturn = json_decode($CommonFunctions->httpPost($api_test_url,$data,true) , true);
		// var_dump($apiReturn);die;
		if($apiReturn['status'] == 'success'){
			$query0 = "INSERT INTO  `exp_locations_ap_controller` (`time_zone`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_name`, `brand`, `model`, `description`, `ip_address`, `create_date`, `create_user`, `type`,`controller_description`)
			VALUES ('$time_zone','$api_profile','$api_url','$api_url_se','$api_uname','$api_pass','$api_version', '$brand', '$model', '$desc', '$ip_address', NOW(), '$user_name', '$type', '$controller_description_json')";
			$ex0 = $db->execDB($query0);

			if ($ex0===true) {
				$idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
				$message_response = $message_functions->showMessage('ap_controller_create_success') ;
				$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Create API profile',$idContAutoInc,'3001',$message_response);
				// $create_log->save('',$message_functions->showMessage('ap_controller_create_success'),'');
				$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
			} else {
				$message_response = $message_functions->showMessage('ap_controller_create_failed', '2001');
				$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create API profile',0,'2001',$message_response);
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);		
				// $create_log->save('2001',$message_functions->showMessage('ap_controller_create_failed','2001'),'');
				$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
			}
		} else {
			$message_response = $apiReturn['data']['message'];
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create API profile',0,'2001',$message_response);
			$db->userErrorLog('2001', $user_name, 'script - ' . $script);		
			// $create_log->save('2001',$message_functions->showMessage('ap_controller_create_failed','2001'),'');
			$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		}
	}//key validation
	else{
		$message_response = $message_functions->showMessage('transection_fail', '2004');
		$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Create API profile',0,'2004',$message_response);
		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		// $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		
		$_SESSION['msg2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		header('Location: api_profile.php?t=2');
	}	
} else if(isset($_GET['remove_controller'])){
	if($_SESSION['FORM_SECRET']==$_GET['token2']) {//refresh validate
		$remove_controller = trim($_GET['remove_controller']);
	
		$arc_q="INSERT INTO `exp_locations_ap_controller_archive`
				(`controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`create_date`,`create_user`,`last_update`,`archive_by`,`status`)
				SELECT `controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`create_date`,`create_user`,`last_update`,'$user_name','Delete'
				FROM `exp_locations_ap_controller`
				WHERE `id`='$remove_controller'";
		
		$arc_q_exe=$db->execDB($arc_q);
		$query0 = "DELETE FROM `exp_locations_ap_controller` WHERE `id` = '$remove_controller'";
		$ex0 = $db->execDB($query0);
		if ($ex0===true) {	
			$message_response = $message_functions->showMessage('ap_controller_remove_success') ;
			$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Delete API profile',$remove_controller,'',$message_response);	
			// $create_log->save('',$message_functions->showMessage('ap_controller_remove_success'),'');
			$_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		} else {
			$message_response = $message_functions->showMessage('ap_controller_remove_failed','2001');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete API profile',$remove_controller,'2001',$message_response);
			$db->userErrorLog('2001', $user_name, 'script - ' . $script);	
			// $create_log->save('2001',$message_functions->showMessage('ap_controller_remove_failed','2001'),'');
			$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		}

	}//key validation
	else{
		$message_response = $message_functions->showMessage('transection_fail','2004');
		$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Delete API profile',$remove_controller,'2001',$message_response);
		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
			
		$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		header('Location: api_profile.php?t=1');
			
	}
} else if(isset($_GET['edit_controller'])){
	if($_SESSION['FORM_SECRET']==$_GET['token2']) {//refresh validate
		$edit_controller = trim($_GET['edit_controller']);
		$get_wag_q="SELECT	* FROM `exp_locations_ap_controller` WHERE `id` = '$edit_controller'";
		$get_wag=$db->selectDB($get_wag_q);
		foreach($get_wag['data'] AS $edit_wag_r){			
			$edit_ap_control_name = $edit_wag_r['controller_name'];	
			$edit_api_profile = $edit_wag_r['api_profile'];		
			$edit_wag_url=$edit_wag_r['api_url'];	
			$edit_wag_uname=$edit_wag_r['api_username'];
			$edit_wag_pass=$edit_wag_r['api_password'];
		}
		$edit_wag=2;
	}//key validation
	else{
		$message_response = $message_functions->showMessage('transection_fail','2004');
		$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify API profile',$edit_controller,'2001',$message_response);
		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		// $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
		header('Location: api_profile.php?t=1');

	}
}//

if(isset($_POST['api_profile_table_delete_raws'])){
	$arr = explode(",", $_POST['api_profile_table_delete_raws']);
	foreach($arr as $value){
		echo $value;
	}
}

if(isset($_POST['api_update'])){
		$tab1="set";
		$edit_wag=2;
		$wag_secret=$_POST['update_wag_secret'];
		if($wag_secret==$_SESSION['FORM_SECRET']){
			$profile_id = $_POST['profile_id'];
			$update_wag_version=$_POST['edit_api_version'];
			$edit_api_profile_name=$_POST['edit_api_profile'];
			$update_wag_url=trim($_POST['edit_api_url']);
			$update_wag_uname=$_POST['edit_api_uname'];
			$update_wag_pass=$_POST['edit_api_pass'];

			$api_url = $update_wag_url.'/api/'.$update_wag_version.'/token';
			$data = json_encode(['username'=>$update_wag_uname, 'password'=>$update_wag_pass]);
			$apiReturn = json_decode($CommonFunctions->httpPost($api_url,$data,true) , true);
			if($apiReturn['status'] == 'success'){

				$archive_q="INSERT INTO `exp_locations_ap_controller_archive`
							(`controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_description`,`create_date`,`create_user`,`last_update`,`archive_by`,`status`)
							SELECT `controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_description`,`create_date`,`create_user`,`last_update`,'$user_name','Update'
							FROM `exp_locations_ap_controller`
							WHERE `id`='$profile_id'";
				$archive_exe=$db->execDB($archive_q);
		
				
				$update_wag_q="UPDATE `exp_locations_ap_controller` SET 
																`api_profile`='$edit_api_profile_name',
																`api_url`='$update_wag_url',
																`api_username`='$update_wag_uname',
																`api_password`='$update_wag_pass',
																`controller_name` = '$update_wag_version' 
																WHERE `id`='$profile_id'";

				$update_wag=$db->execDB($update_wag_q);
				// $edit_ap_control_name = $update_wag_name;
				$edit_api_profile = $edit_api_profile_name;
				$edit_wag_url=$update_wag_url;
				$edit_wag_uname=$update_wag_uname;
				$edit_wag_pass=$update_wag_pass;

				// $edit_wag_type=$db->getValueAsf("SELECT `type` as f
				// FROM `exp_locations_ap_controller`
				// WHERE `controller_name`='$update_wag_name'");
				
				if($update_wag===true){
					$message_response = $message_functions->showMessage('ap_controller_update_success') ;
					$db->addLogs($user_name, 'SUCCESS',$user_type, $page, 'Modify API profile',$update_wag_name,'',$message_response);	
					// $create_log->save('3001',$message_functions->showMessage('ap_controller_update_success'),'');
					$_SESSION['msg1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
				}else{
					$message_response = $message_functions->showMessage('ap_controller_update_failed','2001');
					$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify API profile',$update_wag_name,'2001',$message_response);
					// $create_log->save('2001',$message_functions->showMessage('ap_controller_update_failed','2001'),'');
					$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
				}
			} else {
				$message_response = $apiReturn['data']['message'];
				$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify API profile',0,'2001',$message_response);
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);		
				// $create_log->save('2001',$message_functions->showMessage('ap_controller_create_failed','2001'),'');
				$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
			}
		}else{
			$message_response = $message_functions->showMessage('transection_fail','2004');
			$db->addLogs($user_name, 'ERROR',$user_type, $page, 'Modify API profile',$edit_controller,'2004',$message_response);
			$db->userErrorLog('2004', $user_name, 'script - '.$script);
			// $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
			$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_response."</strong></div>";
			header('Location: api_profile.php?t=1');
		}
	}
						
//Form Refreshing avoid secret key/////
$secret=md5(uniqid(rand(), true));
$_SESSION['FORM_SECRET'] = $secret;
?>

<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
							<div class="widget-header">
								<i class="icon-tags"></i>
								<h3>Manage API Profiles</h3>
							</div>
							<!-- /widget-header -->
							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs">
										<li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#viewap" data-toggle="tab">Manage BI APIs</a></li>
										<li <?php if(isset($tab2)){?>class="active" <?php }?>><a href="#addap" data-toggle="tab">Create BI APIs</a></li>	
									</ul>
									<div class="tab-content">
									<?php
											if(isset($_SESSION['msg17'])){
												echo $_SESSION['msg17'];
												unset($_SESSION['msg17']);

											}
											if(isset($_SESSION['msg1'])){
												echo $_SESSION['msg1']; 
												unset($_SESSION['msg1']);
											}
											if(isset($_SESSION['msg2'])){
												echo $_SESSION['msg2']; 
												unset($_SESSION['msg2']);	
											}
									?>
										<!-- create_product tab -->
										<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="viewap">      	      			
											<h1 class="head">Manage BI APIs</h1>		      
									<?php
										if($edit_wag==2){
									?>
										<form onkeyup="admin_updatefn();" onchange="admin_updatefn();" class="form-horizontal" method="post" action="?t=1">
											<input type="hidden" name="t" value="1">
											<input type="hidden" name="profile_id" id="profile_id" value="<?php echo $edit_controller;?>" />
											<?php
											echo '<input type="hidden" name="update_wag_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
											?>
											<fieldset>
												<div class="control-group">
													<label class="control-label" for="mg_product_code_1">API Profile<font color="#FF0000"></font></label>
													<div class="controls col-lg-5 form-group">
														<input class="span4 form-control" id="api_profile" name="edit_api_profile" type="text" value="<?php echo $edit_api_profile;?>" required="required">
													</div>
												</div>	
												<div class="control-group">
													<label class="control-label" for="mg_product_code_1">Version<font color="#FF0000"></font></label>
													<div class="controls col-lg-5 form-group">
															<select class="span4 form-control" name="edit_api_version" id="version" required="required">
																<option value="">Select Version</option>
																<option value="v1_0" <?=($edit_ap_control_name == "v1_0" ? "selected" : "")?>>API v1</option>
																<option value="v2_0" <?=($edit_ap_control_name == "v2_0" ? "selected" : "")?>>API v2</option>
															</select>
														</div>
												</div>
												
												<div class="control-group">
													<label class="control-label" for="approfile"> API Server URL<font color="#FF0000"></font></label>
													<div class="controls">
														<div class="input-prepend input-append ">
															<input type="text"  value="<?php echo $edit_wag_url;?>" name="edit_api_url" class="span4" required="required">
														</div>
													</div>
												</div>
												<div class="control-group ed_ap_sw ed_dpsk">
													<label class="control-label" for="approfile"> API Username<font color="#FF0000"></font></label>
													<div class="controls">
														<div class="input-prepend input-append ">
															<input type="text"  value="<?php echo $edit_wag_uname;?>" name="edit_api_uname" class="span4" required="required">
														</div>
													</div>
												</div>
												<div class="control-group ed_ap_sw ed_dpsk">
													<label class="control-label" for="approfile"> API Password<font color="#FF0000"></font></label>
													<div class="controls">
														<div class="input-prepend input-append ">
															<input type="text"  value="<?php echo $edit_wag_pass;?>" name="edit_api_pass" class="span4 password_f" required="required">
														</div>
													</div>
												</div>
											</fieldset>
											<div class="form-actions">
												<button disabled type="submit" name="api_update" id="admin_update" class="btn btn-primary">Update</button>
												<button type="button" class="btn btn-info inline-btn"  onclick="goto1();" class="btn btn-danger">Cancel</button> 
													<script>
														function admin_updatefn() {
															$("#admin_update").prop('disabled', false);
														}
														
														function goto1(url){              
															window.location = "?";              
														}	
													</script>
											</div>
										</form>
										<?php
										}
										?>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													<i class="icon-th-list"></i>
													<h3>Active Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response ">
													<div style="overflow-x:auto;" >
														<table id="api_profile_table" data-delete="true" data-create="?t=2" class="data-table table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<th scope="col" style="max-width: 20px;" class="no-sort" data-tablesaw-sortable-col data-tablesaw-priority="persist"><input type="checkbox" class="delete-all"></th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">API Version</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API URL</th>
																	<th scope="col" class="no-sort" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																	<th scope="col" class="no-sort" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$key_query="SELECT c.controller_name,c.description,c.brand,c.model,c.brand,c.description,c.create_date,c.ip_address,c.api_url,c.api_profile,c.id,count(d.id) as assign_count FROM `exp_locations_ap_controller` c LEFT JOIN exp_mno_distributor d ON c.controller_name=d.ap_controller
																				group by c.description,c.brand,c.model,c.brand,c.description,c.create_date,c.ip_address,c.api_url,c.api_profile,c.id";
																	$query_results=$db->selectDB($key_query);
																	// var_dump($query_results);	
																	foreach($query_results['data'] AS $row){
																			$controller_name = $row['controller_name'];
																			$description = $row['description'];
																			$brand = $row['brand'];
																			$model = $row['model'];
																			$create_date = $row['create_date'];
																			$ip_address = $row['ip_address'];
																			
																			$api_url = $row['api_url'];
																			$api_profile=$row['api_profile'];
																			
																			$id = $row['id'];
																			$assign_count = $row['assign_count'];
																			echo '<tr>
																			<td style="max-width: 20px;"> <input type="checkbox" class="delete" value="'.$id.'"></td>
																			<td> '.$api_profile.' </td>
																			<td> '.$controller_name.' </td>
																			<td> '.$api_url.' </td>';
																				echo '<td><a href="javascript:void();" id="AP_'.$id.'"  class="btn btn-small btn-info">
																					<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#AP_'.$id.'\').easyconfirm({locale: {
																							title: \'API Profile\',
																							text: \'Are you sure you want to edit this API Profile?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#AP_'.$id.'\').click(function() {
																							window.location = "?token2='.$secret.'&t=1&edit_controller='.$id.'"
																						});
																						});
																					</script></td>';
																			if($assign_count==0){																				
																				echo '<td><a href="javascript:void();" id="AP_R_'.$id.'"  class="btn btn-small btn-danger">
																				<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">
																					$(document).ready(function() {
																					$(\'#AP_R_'.$id.'\').easyconfirm({locale: {
																							title: \'API Profile\',
																							text: \'Are you sure you want to remove this API Profile?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																							button: [\'Cancel\',\' Confirm\'],
																							closeText: \'close\'
																							}});
																						$(\'#AP_R_'.$id.'\').click(function() {
																							window.location = "?token2='.$secret.'&t=1&remove_controller='.$id.'"
																						});
																						});
																					</script></td>';
																			
																			}
																			else{
																				echo '<td><a class="btn btn-small btn-warning" disabled ><i class="icon icon-lock"></i>&nbsp;Remove</a></td>';
																			}
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
										</div><!-- /over product tab -->

                                        <!-- assign_product tab -->
										<div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="addap">
										<h1 class="head">Create BI APIs</h1>		
										<form autocomplete="off" onkeyup="create_ap_controllerfn();" onchange="create_ap_controllerfn();"  id="create_ap_controller_form" name="create_ap_controller_form" method="post" class="form-horizontal" action="?t=2">
												<fieldset>
													<div id="response_d3"></div>
													<?php 
															echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
															echo '<input type="hidden" name="create_user" id="create_user" value="'.$user_distributor.'" />';
													?>	
													<div class="control-group">														
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">API Profile<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="api_profile" name="api_profile" type="text" required="required">
                                                        </div>
                                                    </div>
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Version<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                     							<select class="span4 form-control" name="version" id="version" required="required">
                                                                    <option value="">Select Version</option>
																	<option value="v1_0">API v1</option>
																	<option value="v2_0">API v2</option>
																</select>
                                                          </div>
                                                    </div>
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">API Server URL<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
															<div class="input-prepend input-append ">
																<input class="span4 form-control" id="api_server_url" name="api_server_url" type="text" required="required">
															</div>
                                                        </div>
                                                    </div>
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">API Username<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="api_username" name="api_username" type="text"required="required" >
                                                        </div>
                                                    </div>
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">API Password<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="api_password" name="api_password" type="text" required="required">
                                                        </div>
                                                    </div>													
													<div class="form-actions">
														<button disabled type="submit" name="create_ap_controller" id="create_ap_controller" class="btn btn-primary">Save</button>
														<a style="display: inline-block;margin-left: 20px" id="test_api" class="btn btn-primary wag_link inline-btn"><i class="btn-icon-only icon-refresh"></i> Test</a>																		
														<script>
															function create_ap_controllerfn() {
																$("#create_ap_controller").prop('disabled', false);
															}
															</script>													
	                                                </div>	
												</fieldset>
											</form>
										</div>
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
<?php
include 'footer.php';
?>
<script type="text/javascript" src="js/formValidation.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.js"></script>
<script type="text/javascript">
	
</script>
<!-- Alert messages js-->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
<script type="text/javascript" src="js/jquery-msgpopup.js"></script>


<!-- 	<script src="js/bootstrap.js"></script>  -->
	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
 $(document).ready(function() { 
    $("#product_code").chained("#category");

    $("#create_ap_controller").easyconfirm({locale: {
		title: 'API Profile',
		text: 'Are you sure you want to create this API Profile?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#create_ap_controller").click(function() {
	});

	$('#test_api').on('click', function(){
		var url = $('#api_server_url').val();
		var username = $('#api_username').val();
		var password = $('#api_password').val();
		var varsion = $('#version').val();
		
		if(url != '' && username != '' && password != '' && varsion != ''){
			var api_test_url = url+'/api/'+varsion+'/token';
			$.post('ajax/crm_test_post_api.php', {url:api_test_url,username:username,password:password}, function(response){ 
				console.log(response);
				if(response == 'true') {
					$().msgpopup({
						text: 'Api has been successfully connected!',
						type: 'success', // or success, error, alert and normal
						time: 10000, // or false
						x: true, // or false
					});
				} else if(response == 'empty') {
					$().msgpopup({
						text: 'Please fill all API details',
						type: 'alert', // or success, error, alert and normal
						time: 10000, // or false
						x: true, // or false
					});
				} else {
					$().msgpopup({
						text: response,
						type: 'error', // or success, error, alert and normal
						time: 15000, // or false
						x: true, // or false
					});
				}  
			});
		} else {
			$().msgpopup({
				text: 'One or more parameter is empty!',
				type: 'alert', // or success, error, alert and normal
				time: 5000, // or false
				x: true, // or false
			});
		}
	})
  
  });

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
<script src="js/jquery.multi-select.js" type="text/javascript"></script>

</body>
</html>
