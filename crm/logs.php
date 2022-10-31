<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_WARNING);*/
include 'header_top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, must-revalidate");

$db_name = $db;
/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

require_once 'classes/systemPackageClass.php';
$package_functions = new package_functions();

require_once 'src/LOG/Logger.php';
$logger = Logger::getLogger();
?>

<head>
	<meta charset="utf-8">
	<title>Logs - Logs</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">

	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">

	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">

	<link href="css/style.css" rel="stylesheet">

	<!--Alert message css-->
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">

	<link rel="stylesheet" href="css/tablesaw.css">
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />


	<!-- Add jQuery library -->
	<!-- <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> -->

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

	<!-- tool tip css -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />


	<style>
		.ui-datepicker-calendar td>a {
			min-width: 0px !important;
		}
		.tooltipster-content p {

			width: 200px !important;
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

	$log_time_zone = $user_timezone;
	if (empty($log_time_zone) ||  $log_time_zone == '') {
		$log_time_zone = $db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'");
	}

	?>
	<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />

	<?php
	// TAB Organization
	if (isset($_GET['t'])) {
		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		//initially page loading///
		if ($user_type == 'MNO' || $user_type == 'MVNA' || $user_type == "SALES" || $user_type == "SUPPORT") {
			$tab36 = "set";
		} else if ($user_type == 'MVNE') {
			$tab2 = "set";
		} else if ($user_type == 'MVNO') {
			$tab2 = "set";
		} else {
			$tab36 = "set";
		}
	}
	$fearuresjson = $db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
	$mno_feature = json_decode($fearuresjson);

	//Admin loc archive parth
	$archive_path = $db->setVal('LOGS_FILE_DIR', 'ADMIN');

	if (isset($_POST['prepaid_lg'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			$userLog = $logger->getObjectProvider()->getObjectOther();
			if ($user_type != 'ADMIN') {
				$userLog->setUserDistributor($user_distributor);
			}
	
			if ($_POST['realm36'] != NULL) {
				$userLog->setRealm($_POST['realm36']);
			}

			if ($_POST['function36'] != NULL) {
				$userLog->setFunction($_POST['function36']);
			}
			if ($_POST['start_date36'] != NULL && $_POST['end_date36'] != NULL) {
				$mg_end3 = $_POST['end_date36'];
				$mg_start3 = $_POST['start_date36'];
				$end_date = DateTime::createFromFormat('m/d/Y', $mg_end3)->format('Y-m-d');
				$st_date = DateTime::createFromFormat('m/d/Y', $mg_start3)->format('Y-m-d');
				$mg_start_date3 = $st_date . ' 00:00:00';
				$mg_end_date3 = $end_date . ' 23:59:59';
				$d_start = new DateTime($mg_start_date3, new DateTimeZone($log_time_zone));
				$mg_start_date_tz = $d_start->getTimestamp();

				$d_end = new DateTime($mg_end_date3, new DateTimeZone($log_time_zone));
				$mg_end_date_tz = $d_end->getTimestamp();
				$userLog->from = $mg_start_date_tz;
				$userLog->to = $mg_end_date_tz;
			}

			if ($_POST['limit36'] != NULL) {
				$limit3 = $_POST['limit36'];
				$userLog->limit = $limit3;
			} else {
				$userLog->limit = 100;
			}

			var_dump($userLog);
			$query_results1_resel = $logger->GetLog($userLog);
		}
	}

	//activity_logs
	if (isset($_POST['activity_lg'])) {
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			$userLog = $logger->getObjectProvider()->getObjectUser();
			$userLog->setUserDistributor($user_distributor);
			$userLog->user_type = $user_type;

			if ($_POST['name'] != NULL) {
				$name = $_POST['name'];
				if ($name != -1) {
					$userLog->setUsername($name);
					//$key_query1.=" AND u.user_name='$name'";
				}
			}

			if ($_POST['start_date3'] != NULL && $_POST['end_date3'] != NULL) {
				$mg_end3 = $_POST['end_date3'];
				$mg_start3 = $_POST['start_date3'];

				$end_date = DateTime::createFromFormat('m/d/Y', $mg_end3)->format('Y-m-d');
				$st_date = DateTime::createFromFormat('m/d/Y', $mg_start3)->format('Y-m-d');

				$mg_start_date3 = $st_date . ' 00:00:00';
				$mg_end_date3 = $end_date . ' 23:59:59';

				$d_start = new DateTime($mg_start_date3, new DateTimeZone($log_time_zone));
				$mg_start_date_tz = $d_start->getTimestamp();

				$d_end = new DateTime($mg_end_date3, new DateTimeZone($log_time_zone));
				$mg_end_date_tz = $d_end->getTimestamp();

				$userLog->from = $mg_start_date_tz;
				$userLog->to = $mg_end_date_tz;
			}

			$key_query1 .= " ORDER BY l.id DESC";
			if ($_POST['limit3'] != NULL) {
				$limit3 = $_POST['limit3'];
				$userLog->limit = $limit3;

			} else {
				$userLog->limit = 100;
			}

			$query_results1_user = $logger->GetLog($userLog);
		}
	}

	//Form Refreshing avoid secret key/////
	$secret = md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;
	$logs_mid = 'layout/' . $camp_layout . '/views/logs_mid.php';

	if (($new_design == 'yes') && file_exists($logs_mid)) {

		include_once $logs_mid;
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
									<!-- <i class="icon-warning-sign"></i> -->
									<h3>Logs</h3>
								</div>
								<!-- /widget-header -->

								<div class="widget-content">

									<div class="tabbable">
										<ul class="nav nav-tabs newTabs">
											
												<?php 
												if ($package_features == "all" || in_array("OTHER_LOG", $features_array)) { ?>
													<li <?php if (isset($tab36)) { ?>class="active" <?php } ?>><a href="#prepaid_activity_logs" data-toggle="tab">API Logs</a></li>
												<?php } ?>
												<li <?php if (isset($tab3)) { ?>class="active" <?php } ?>><a href="#user_activity_logs" data-toggle="tab">User Activity Logs</a></li>
										
										</ul>
										<br>

									</div>


									<div class="tab-content">
										<!-- /* +++++++++++++++++++++++++++++++ Exp Error Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
										<?php if ($user_type == 'MVNE' || $user_type == 'MVNO') { ?>
											<div <?php if (isset($tab1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="error_logs">
												<br>
												<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=1">
													<fieldset>

														<div id="response_d3">
															<?php
															if (isset($_SESSION['msg1'])) {
																echo $_SESSION['msg1'];
																unset($_SESSION['msg1']);
															}
															?>
														</div>
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
														<input type="hidden" name="error_lg" id="error_lg" value="error_lg" />

														<div class="control-group">
															<label class="control-label" for="ssid">SSID</label>
															<div class="controls form-group">
																<?php echo '<input class="span2 form-control" id="ssid" name="ssid" value="' . $ssid . '" type="text">' ?>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="mac">MAC</label>
															<div class="controls form-group">
																<?php echo '<input class="span2 form-control" id="mac" name="mac" value="' . $mac . '" type="text">' ?>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="email">E-mail</label>
															<div class="controls form-group">
																<?php echo '<input class="span2 form-control" id="email" name="email" value="' . $email . '" type="text">' ?>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="limit">Limit</label>
															<div class="controls form-group">
																<?php echo '<input class="span2 form-control limit_log" id="limit" name="limit" value="' . $limit . '"  type="text">' ?>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="radiobtns">Period</label>

															<div class="controls form-group">


																<input class="span2 form-control" id="start_date" name="start_date" type="text" value="<?php if (isset($mg_start_date)) {
																																							echo $mg_start;
																																						} ?>" placeholder="mm/dd/yyyy">
																to
																<input class="span2 form-control" id="end_date" name="end_date" type="text" value="<?php if (isset($mg_end_date)) {
																																						echo $mg_end;
																																					} ?>" placeholder="mm/dd/yyyy">

																<input type="hidden" name="error_date" />

															</div>
															<!-- /controls -->
														</div>

														<div class="form-actions">
															<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
														</div>

													</fieldset>
												</form>

												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<?php
														//echo $query_error_lg;

														//$row_count = mysql_num_rows($result_error_lgs);
														$row_count = $result_error_lgs['rowCount'];

														if ($row_count > 0) {


														?>
															<h3>Error Logs - <small> <?php echo $row_count; ?> Result(s)</small></h3>
														<?php
														} else {
														?>
															<h3>Error Logs - <small> 0 Result(s)</small></h3>
														<?php
														}
														?>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered">
																<thead>
																	<tr>
																		<th>SSID</th>
																		<th>MAC</th>
																		<th>E-mail</th>
																		<th>Error Description</th>
																		<th>Error Comment</th>
																		<th>Error Time</th>
																	</tr>
																</thead>
																<tbody>
																	<?php

																	//while($row=mysql_fetch_array($result_error_lgs)){
																	foreach ($result_error_lgs['data'] as $row) {


																		$er_cr_date = $row['create_date'];
																		$dt2 = new DateTime($er_cr_date);
																		$er_cr_date = $dt2->format('m/d/Y h:i:s A');
																		echo "<tr>";
																		echo "<td>" . $row[ssid] . "</td>";
																		echo "<td>" . $row[mac] . "</td>";
																		echo "<td>" . $row[email] . "</td>";
																		echo "<td>" . $row[description] . "</td>";
																		echo "<td>" . $row[error_details] . "</td>";
																		echo "<td>" . $er_cr_date . "</td>";
																		echo "</tr>";
																	}
																	?>

																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>

										<!-- /* ++++++++++++++++++++++++++++++++++++++ Exp Access Logs +++++++++++++++++++++++++++++++++++++++ */ -->
										<div <?php if (isset($tab2)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="access_logs">
											<br>
											<form id="error_log2" name="error_log2" method="post" class="form-horizontal" action="?t=2">
												<fieldset>

													<div id="response_d3">
														<?php
														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}
														?>
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<input type="hidden" name="access_lg" id="access_lg" value="access_lg" />

													<div class="control-group">
														<label class="control-label" for="ssid2">SSID</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="ssid2" name="ssid2" value="' . $ssid2 . '" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="mac2">MAC</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="mac2" name="mac2" value="' . $mac2 . '" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="email_2">E-mail</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="email_2" name="email_2" value="' . $email_2 . '" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit2">Limit</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit2" name="limit2" value="' . $limit2 . '" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


															<input class="span2 form-control" id="start_date2" name="start_date2" type="text" value="<?php if (isset($mg_start_date2)) {
																																							echo $mg_start2;
																																						} ?>" placeholder="mm/dd/yyyy">
															to
															<input class="span2 form-control" id="end_date2" name="end_date2" type="text" value="<?php if (isset($mg_end_date2)) {
																																						echo $mg_end2;
																																					} ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="error_date2" />

														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
													</div>


												</fieldset>
											</form>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<?php
													//echo $query_2;
													//$row_count2 = mysql_num_rows($query_results2);
													$row_count2 = $query_results2['rowCount'] > 0;
													if ($row_count2 > 0) {
													?>
														<h3>Access Logs - <small> <?php echo $row_count2; ?> Result(s)</small></h3>
													<?php
													} else {
													?>
														<h3>Access Logs - <small> 0 Result(s)</small></h3>
													<?php
													}
													?>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;">
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th width="10px">#</th>
																	<th>SSID</th>
																	<th>MAC</th>
																	<th>E-mail</th>
																	<th>Description</th>
																	<th>Access Details</th>
																	<th>Date</th>


																</tr>
															</thead>
															<tbody>

																<?php


																$color_var = 1;
																$get_val = 0;
																$step = 0;
																//while($row=mysql_fetch_array($query_results2)){
																foreach ($query_results2['data'] as $row) {

																	$ssid = $row[ssid];
																	$mac = $row[mac];
																	$email = $row[email];
																	$description = $row[description];
																	$access_details = $row[access_details];
																	$create_date = $row[create_date];
																	$token_id = $row[token_id];


																	$dt2 = new DateTime($create_date);
																	$create_date = $dt2->format('m/d/Y h:i:s A');

																	if ($color_var == 1 && $get_val == 0) {
																		$temp = $token_id;
																		$get_val = $get_val + 1;
																	}

																	if ($temp != $token_id) {
																		$color_var = $color_var + 1;
																		$temp = $token_id;
																		$step = 0;
																	}

																	$step = $step + 1;

																	echo '<tr';
																	if ($color_var % 2 == 0) {
																		echo ' bgcolor="#e0eeee"';
																	} else {
																		echo ' bgcolor="#fffac9"';
																	}
																	echo '>';

																	echo '<td> ' . $step . ' </td>
														<td> ' . $ssid . ' </td>
														<td> ' . $mac . ' </td>
														<td> ' . $email . ' </td>
														<td> ' . $description . ' </td>
														<td> <input type="text" class="invisibletb" value="' . $access_details . '" readonly/> </td>
														<td> ' . $create_date . ' </td>';

																	//$token_id.'<br>'.$access_details

																}

																?>
																<style type="text/css">
																	.invisibletb {
																		border: none;
																		width: 100%;
																		height: 100%;
																		cursor: text !important;
																	}
																</style>


															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
										</div>


										<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->



										<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
										<div <?php if (isset($tab3)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="user_activity_logs">

											<div class="logs_head_visible" style="display:none;">
												<div class="header_hr"></div>
												<div class="header_f1" style="width: 100%">
													User Activity Logs</div>
												<br class="hide-sm"><br class="hide-sm">
												<div class="header_f2" style="width: fit-content;"> </div>
											</div>

											<!-- <br> -->
											<form id="activity_log1" name="activity_log" method="post" class="form-horizontal" action="?t=3">
												<fieldset>

													<div id="response_d3">
														<?php
														if (isset($_SESSION['msg2'])) {
															echo $_SESSION['msg2'];
															unset($_SESSION['msg2']);
														}
														?>
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />

													<div class="control-group ">
														<label class="control-label" for="name">User</label>
														<div class="controls form-group">

															<select class="span2 form-control" name="name" id="name" value=<?php echo $name ?>>
																<option value="-1"> All </option>
																<?php

																$user_select_qu = "SELECT user_name FROM `admin_users` WHERE `user_distributor` = '$user_distributor'";
																// $user_select_re = mysql_query($user_select_qu);
																// while($row_user = mysql_fetch_array($user_select_re)){

																$user_select_re = $db->selectDB($user_select_qu);

																foreach ($user_select_re['data'] as $row_user) {


																	if ($row_user[user_name] == $name) {
																		echo "<option value='" . $row_user[user_name] . "' selected> " . $row_user[user_name] . " </option>";
																	} else {
																		echo "<option value='" . $row_user[user_name] . "'> " . $row_user[user_name] . " </option>";
																	}
																}

																?>
															</select>


														</div>
													</div>

													<div class="control-group ">
														<label class="control-label" for="limit3">Limit</label>
														<?php

														if (!isset($limit3)) {
															$limit3 = 50;
														}

														?>

														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit3" name="limit3" value="' . $limit3 . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

															<script type="text/javascript">
																$(document).ready(function() {

																	$('#limit3').tooltip();


																});
															</script>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


															<input class="inline_error inline_error_1 span2 form-control" id="start_date3" name="start_date3" type="text" value="<?php if (isset($mg_start_date3)) {
																																														echo $mg_start3;
																																													} ?>" placeholder="mm/dd/yyyy">
															to
															<input class="inline_error inline_error_1 span2 form-control" id="end_date3" name="end_date3" type="text" value="<?php if (isset($mg_end_date3)) {
																																													echo $mg_end3;
																																												} ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="date3" />


														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions tbl_filter_overlap">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
													</div>

												</fieldset>
											</form>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<?php
													$row_count33 = count($query_results1_user);
													if ($row_count33 > 0) {
													?>
														<h3>User Activity Logs
														<?php
													} else {
														?>
															<h3>User Activity Logs
															<?php
														}
															?>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;">
														<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">User Name</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Module Name</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Task</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Reference</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


																</tr>
															</thead>
															<tbody>

																<?php


																foreach ($query_results1_user as $row) {
																	$user_name = $row->getUsername(user_name);
																	$module = $row->getModule();
																	$create_date = $row->getCreateDate();

																	$task = $row->getTask();
																	$reference = $row->getReference();
																	$ip = $row->getIp();

																	$unixtimestamp = (int) $row->getUnixtimestamp();

																	//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

																	//echo $admin_timezone;

																	$dt = new DateTime("@$unixtimestamp");
																	$dt->setTimezone(new DateTimeZone($log_time_zone));
																	//$dt->setTimestamp($unixtimestamp);
																	//date_default_timezone_set($admin_timezone);
																	//$dt->setTimeZone(new DateTimeZone($admin_timezone));
																	$unix_date = $dt->format('m/d/Y h:i:s A');

																	//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);
																	//echo date_default_timezone_get();

																	$dt2 = new DateTime($create_date);
																	$create_date = $dt2->format('m/d/Y h:i:s A');

																	echo '<tr>
														<td> ' . $user_name . ' </td>
														<td> ' . $module . ' </td>
														<td> ' . $task . ' </td>
														<td> ' . $reference . ' </td>
														<td> ' . $ip . ' </td>
														<td> ' . $unix_date . ' </td>';
																}

																?>





															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
										</div>
										<?php if (in_array("PREPAID_MODULE_N", $mno_feature) || $package_features == "all" || in_array('OTHER_LOG', $features_array)) { ?>
											<!-- /* +++++++++++++++++++++++++++++++++++++ Property Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
											<div <?php if (isset($tab36)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="prepaid_activity_logs">
												<br>
												<form id="prepaid_activity_logs_form" name="prepaid_activity_logs" method="post" class="form-horizontal" action="?t=36">
													<fieldset>
														<div id="response_d3">
															<?php
															if (isset($_SESSION['msg24'])) {
																echo $_SESSION['msg24'];
																unset($_SESSION['msg24']);
															}
															?>
														</div>
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
														<input type="hidden" name="prepaid_lg" id="prepaid_lg" value="prepaid_lg" />

														<div class="control-group ">
															<label class="control-label" for="name">Functions</label>
															<div class="controls form-group">

																<select class="span2 form-control" name="function36" id="function36">
																	<option value=""> All </option>
																	<option value="create_dpsks_pool"> Create DPSK Pool </option>
																	<option value="create_dpsks"> Create Dpsk </option>
																	<option value="create_device"> Create dpsk Device </option>
																	<option value="get_dpsks_pool"> Get DPSK Pool </option>
																	<option value="get_dpsks_pool_list"> Get DPSK Pool List </option>
																	<option value="get_dpsks"> Get Dpsk </option>
																	<option value="get_dpsks_list"> Get DPSK List </option>
																	<option value="get_device"> Get DPSK Device </option>
																	<option value="get_device_list"> Get DPSK Device List </option>
																	<option value="update_dpsks_pool"> Update Dpsk Pool </option>
																	<option value="update_dpsks"> Update Dpsk </option>
																	<option value="Delete_dpsks"> Delete Dpsk </option>
																	<option value="Delete_dpsk_pool"> Delete Dpsk pool </option>
																	<option value="Delete_device"> Delete Dpsk Device </option>
																	<option value="assign_policy"> Assign Policy </option>
																</select>
															</div>
														</div>

														<div class="control-group ">
															<label class="control-label" for="name">Realm</label>
															<div class="controls form-group">
																<input class="span2 form-control" name="realm36" id="realm36" value=<?php echo $realm36 ?>>
															</div>
														</div>

														<div class="control-group ">
															<label class="control-label" for="limit36">Limit</label>
															<?php

															if (!isset($limit36)) {
																$limit36 = 50;
															}

															?>

															<div class="controls form-group">
																<?php echo '<input class="span2 form-control limit_log" id="limit36" name="limit36" value="' . $limit36 . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

																<script type="text/javascript">
																	$(document).ready(function() {
																		$('#limit36').tooltip();
																	});
																</script>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="radiobtns">Period</label>
															<div class="controls form-group">
																<input class="inline_error inline_error_1 span2 form-control" id="start_date36" name="start_date36" type="text" value="<?php if (isset($mg_start_date36)) {
																																															echo $mg_start_36;
																																														} ?>" placeholder="mm/dd/yyyy">
																to
																<input class="inline_error inline_error_1 span2 form-control" id="end_date36" name="end_date36" type="text" value="<?php if (isset($mg_end_date36)) {
																																														echo $mg_end_36;
																																													} ?>" placeholder="mm/dd/yyyy">

																<input type="hidden" name="date36" />
															</div>
															<!-- /controls -->
														</div>

														<div class="form-actions">
															<button type="submit" name="prepaid_log_submit" id="prepaid_log_submit" class="btn btn-primary">GO</button>
														</div>

													</fieldset>
												</form>
												<?php
												$row_count36 = count($query_results1_resel);
												if ($row_count36 > 0) {
												}
												?>

												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>API Logs</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Function Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Realm</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">API Log</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Status Code</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


																	</tr>
																</thead>
																<tbody>
																	<?php
																	$activity_arr = array();
																	foreach ($query_results1_resel as $row) {
																		$function = $row->getfunction();
																		if (empty($function)) {
																			$function = "N/A";
																		}

																		$realm = $row->getRealm();
																		$status = $row->getStatus();
																		$unixtimestamp = (int) $row->getUnixtimestamp();

																		//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

																		//echo $admin_timezone;

																		$dt = new DateTime("@$unixtimestamp");
																		$dt->setTimezone(new DateTimeZone($log_time_zone));
																		//$dt->setTimestamp($unixtimestamp);
																		//date_default_timezone_set($admin_timezone);
																		//$dt->setTimeZone(new DateTimeZone($admin_timezone));
																		$unix_date = $dt->format('m/d/Y h:i:s A');

																		//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);
																		//echo date_default_timezone_get();

																		$dt2 = new DateTime($create_date);
																		$create_date = $dt2->format('m/d/Y h:i:s A');

																		echo '<tr>
														<td> ' . $function . ' </td>
														<td> ' . $realm . ' </td>';
																		echo "<td><a href=ajax/log_view.php?other_log_id=" . $row->getId() . " target='_blank'> View </a></td>";
																		echo '<td> ' . $status . ' </td>';
																		echo '<td> ' . $unix_date . ' </td>';
																	}

																	$_SESSION[$key] = json_encode($activity_arr);

																	?>





																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
											</div>
										<?php  }
										if (in_array('PROPERTY_LOG', $features_array) || $package_features == "all") { ?>
											<!-- /* +++++++++++++++++++++++++++++++++++++ Property Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
											<div <?php if (isset($tab24)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="property_activity_logs">
												<br>
												<form id="property_activity_logs_form" name="property_activity_logs" method="post" class="form-horizontal" action="?t=24">
													<fieldset>

														<div id="response_d3">
															<?php
															if (isset($_SESSION['msg24'])) {
																echo $_SESSION['msg24'];
																unset($_SESSION['msg24']);
															}
															?>
														</div>
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
														<input type="hidden" name="property_lg" id="property_lg" value="property_lg" />

														<div class="control-group ">
															<label class="control-label" for="name">Property</label>
															<div class="controls form-group">

																<select class="span2 form-control" name="property" id="name24" value=<?php echo $name ?>>
																	<option value=""> Select a property </option>
																	<?php

																	$user_select_qu = "SELECT DISTINCT parent_id AS property,parent_id,a.parent_id AS property_val FROM `mno_distributor_parent` a WHERE mno_id='$user_distributor'
UNION
SELECT DISTINCT CONCAT(a.parent_id,'-',a.property_id) AS property,parent_id, a.distributor_code AS property_val  FROM `exp_mno_distributor` a WHERE a.mno_id='$user_distributor' ORDER BY parent_id";
																	// $user_select_re = mysql_query($user_select_qu);
																	// while($row_user = mysql_fetch_array($user_select_re)){

																	$user_select_re = $db->selectDB($user_select_qu);

																	foreach ($user_select_re['data'] as $row_user) {

																		if ($row_user[property_val] == $get_property) {
																			echo "<option value='" . $row_user[property_val] . "' selected> " . $row_user[property] . " </option>";
																		} else {
																			echo "<option value='" . $row_user[property_val] . "'> " . $row_user[property] . " </option>";
																		}
																	}

																	?>
																</select>


															</div>
														</div>

														<div class="control-group ">
															<label class="control-label" for="limit3">Limit</label>
															<?php

															if (!isset($limit3)) {
																$limit3 = 50;
															}

															?>

															<div class="controls form-group">
																<?php echo '<input class="span2 form-control limit_log" id="limit24" name="limit24" value="' . $limit3 . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

																<script type="text/javascript">
																	$(document).ready(function() {
																		$('#limit24').tooltip();
																	});
																</script>
															</div>
														</div>

														<div class="control-group">
															<label class="control-label" for="radiobtns">Period</label>

															<div class="controls form-group">
																<? php // echo $mg_start_24."------".$mg_end_24 
																?>

																<input class="inline_error inline_error_1 span2 form-control" id="start_date24" name="start_date24" type="text" value="<?php if (isset($mg_start_date24)) {
																																															echo $mg_start_24;
																																														} ?>" placeholder="mm/dd/yyyy">
																to
																<input class="inline_error inline_error_1 span2 form-control" id="end_date24" name="end_date24" type="text" value="<?php if (isset($mg_end_date24)) {
																																														echo $mg_end_24;
																																													} ?>" placeholder="mm/dd/yyyy">

																<input type="hidden" name="date24" />


															</div>
															<!-- /controls -->
														</div>

														<div class="form-actions">
															<button type="submit" name="property_log_submit" id="property_log_submit" class="btn btn-primary">GO</button>
														</div>

													</fieldset>
												</form>
												<?php
												$row_count33 = count($query_results24);
												if ($row_count33 > 0) {
													$key = uniqid('property_log_search')
												?>
													<a href="ajax/export_report.php?property_activity_logs=<?php echo $key; ?>" class="btn btn-primary" style="text-decoration:none">
														<i class="btn-icon-only icon-download"></i> Download search Result
													</a>
												<?php
												}
												?>

												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>User Activity Logs</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto;">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">User Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Module Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Task</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Reference</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


																	</tr>
																</thead>
																<tbody>

																	<?php
																	$activity_arr = array();

																	//print_r($query_results24);

																	foreach ($query_results24 as $row) {

																		$one_arr = array();

																		$user_name = $row->user_name;
																		if (empty($user_name)) {
																			$user_name = "N/A";
																		}
																		$one_arr['User Name'] = $user_name;

																		$module = $row->module;
																		if (empty($module)) {
																			$module = "N/A";
																		}
																		$one_arr['Module Name'] = $module;

																		$create_date = $row->create_date;


																		$task = $row->task;
																		$one_arr['Task'] = $task;
																		$reference = $row->reference;

																		if (empty($reference)) {
																			$reference = "N/A";
																		}
																		$one_arr['Reference'] = $reference;
																		$ip = $row->ip;
																		$one_arr['IP'] = $ip;

																		$unixtimestamp = (int) $row->unixtimestamp;

																		//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

																		//echo $admin_timezone;

																		$dt = new DateTime("@$unixtimestamp");
																		$dt->setTimezone(new DateTimeZone($log_time_zone));
																		//$dt->setTimestamp($unixtimestamp);
																		//date_default_timezone_set($admin_timezone);
																		//$dt->setTimeZone(new DateTimeZone($admin_timezone));
																		$unix_date = $dt->format('m/d/Y h:i:s A');
																		$one_arr['Date'] = $unix_date;

																		//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);
																		//echo date_default_timezone_get();

																		$dt2 = new DateTime($create_date);
																		$create_date = $dt2->format('m/d/Y h:i:s A');

																		echo '<tr>
														<td> ' . $user_name . ' </td>
														<td> ' . $module . ' </td>
														<td> ' . $task . ' </td>
														<td> ' . $reference . ' </td>
														<td> ' . $ip . ' </td>
														<td> ' . $unix_date . ' </td>';

																		array_push($activity_arr, $one_arr);
																	}

																	$_SESSION[$key] = json_encode($activity_arr);

																	?>





																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
											</div>
										<?php } ?>


										<?php if (in_array('PROPERTY_LOG', $features_array) || $package_features == "all") { ?>
											<!-- /* +++++++++++++++++++++++++++++++++++++ Property Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
											<div <?php if (isset($tab25)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="property_activity_logs_download">
												<br>
												<form id="property_activity_logs_down" name="property_activity_logs_down" method="post" class="form-horizontal" action="?t=25">
													<fieldset>

														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
														<div class="control-group ">
															<label class="control-label" for="name">Month</label>
															<div class="controls form-group">

																<select class="span4 form-control" name="property_log_month" id="property_log_month" value=<?php echo $name ?>>
																	<option value=""> Select a month </option>
																	<!-- <option value="current_month"> Current month </option> -->
																	<?php
																	$dir = dirname(__FILE__) . '/export/BusinessID_activity_log/';
																	$files = scandir($dir, 1);
																	foreach ($files as $file) {
																		$file_name_ar = explode('_', $file);

																		if ($file_name_ar[0] == $user_distributor) {
																			$display = explode('.', $file_name_ar[1])[0];
																			echo '<option value="' . $file . '">' . $display . '</option>';
																		}
																	}

																	?>
																</select>


															</div>
														</div>
														<div class="form-actions">
															<button type="button" name="property_log_download" id="property_log_download" class="btn btn-primary">Download</button>
															<script type="application/javascript">
																$('#property_log_download').on('click', function() {
																	let selected_value = $("#property_log_month option:selected").val();
																	//alert(selected_value);
																	if (selected_value != '') {

																		/* if(selected_value=='current_month'){
                                                                		let file_path = 'ajax/export_report.php?property_activity_current_logs=set&mno_id=<?php echo $user_distributor; ?>';
                                                                    	window.location.href = file_path;
                                                                	}else{
                                                                		let file_path = 'export/BusinessID_activity_log/'+selected_value;
                                                                    	window.location.href = file_path;
                                                                	} */
																		let file_path = 'export/BusinessID_activity_log/' + selected_value + '?key=<?php echo uniqid(); ?>';
																		window.location.href = file_path;

																	} else {
																		alert('Please select month');
																	}

																});
															</script>
														</div>

													</fieldset>
												</form>
											</div>
										<?php } ?>


										<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
										<div <?php if (isset($tab11)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="auth_logs">
											<br>
											<form id="auth_log" name="auth_log" method="post" class="form-horizontal" action="?t=11">
												<fieldset>

													<div id="response_d3">
														<?php
														if (isset($_SESSION['msg11'])) {
															echo $_SESSION['msg11'];
															unset($_SESSION['msg11']);
														}
														?>
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<input type="hidden" name="auth_lg" id="auth_lg" value="auth_lg" />

													<div class="control-group ">
														<label class="control-label" for="name">Method</label>
														<div class="controls form-group">

															<select class="span2 form-control" name="name" id="name" value=<?php echo $name ?>>
																<option value="-1"> All </option>
																<option value="SSO"> SSO Login </option>
																<option value="SLO"> SSO Logout </option>
																<?php
																/* $user_select_qu = "SELECT user_name FROM `admin_users` WHERE `user_distributor` = '$user_distributor'";
																	$user_select_re = mysql_query($user_select_qu);
																	while($row_user = mysql_fetch_array($user_select_re)){
																		if ($row_user[user_name] == $name) {
																			echo "<option value='".$row_user[user_name]."' selected> ".$row_user[user_name]." </option>";
																		} else {
																			echo "<option value='".$row_user[user_name]."'> ".$row_user[user_name]." </option>";
																		}

																	} */
																?>
															</select>


														</div>
													</div>

													<div class="control-group ">
														<label class="control-label" for="limit3">Limit</label>
														<?php

														if (!isset($limit3)) {
															$limit3 = 50;
														}

														?>

														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit3" name="limit3" value="' . $limit3 . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

															<script type="text/javascript">
																$(document).ready(function() {

																	$('#limit3').tooltip();


																});
															</script>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


															<input class="inline_error inline_error_1 span2 form-control" id="start_date11" name="start_date11" type="text" value="<?php if (isset($mg_start_date11)) {
																																														echo $mg_start11;
																																													} ?>" placeholder="mm/dd/yyyy">
															to
															<input class="inline_error inline_error_1 span2 form-control" id="end_date11" name="end_date11" type="text" value="<?php if (isset($mg_end_date11)) {
																																													echo $mg_end11;
																																												} ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="date11" />


														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="auth_error_log_submit" id="auth_error_log_submit" class="btn btn-primary">GO</button>
													</div>

												</fieldset>
											</form>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<?php
													//$row_count311 = mysql_num_rows($query_results11);
													$row_count311 = $query_results11['rowCount'];
													if ($row_count311 > 0) {
													?>
														<h3>Auth Logs
														<?php
													} else {
														?>
															<h3>Auth Logs
															<?php
														}
															?>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;">
														<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Function</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function Name</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Method</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Status</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Details</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Date</th>


																</tr>
															</thead>
															<tbody>

																<?php


																//while($row11=mysql_fetch_array($query_results11)){
																foreach ($query_results11['data'] as $row11) {

																	$id = $row11[id];
																	$function = $row11['function'];
																	$function_name = $row11[function_name];
																	$api_method = $row11[api_method];
																	$api_status = $row11[api_status];
																	$api_description = $row11[api_description];
																	$create_date = $row11[create_date];

																	$unixtimestamp = (int) $row11[unixtimestamp];

																	//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

																	$dt = new DateTime("@$unixtimestamp");
																	$dt->setTimezone(new DateTimeZone($log_time_zone));
																	$unix_date = $dt->format('m/d/Y h:i:s A');
																	//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);

																	$dt11 = new DateTime($create_date);
																	$create_date = $dt11->format('m/d/Y h:i:s A');

																	echo '<tr>
														<td> ' . $function . ' </td>
														<td> ' . $function_name . ' </td>
														<td> ' . $api_method . ' </td>
														<td> ' . $api_status . ' </td>
														<td>';

																	echo '<a id="redirect_url_' . $id . '"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#redirect_url_' . $id . '\').tooltipster({
												                content: $(\'<p style= word-wrap:break-word>' . $api_description . '</p>\'),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script>';


																	echo '</td>

														<td> ' . $unix_date . ' </td>';
																}

																?>





															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
										</div>


										<!-- Api logs  -->


										<!-- /* +++++++++++++++++++++++++++++++++++++ User Redirection Logs +++++++++++++++++++++++++++++++++++++ */ -->
										<div <?php if (isset($tab4)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="redirection_log">
											<br>
											<form id="redirection_log_f" name="redirection_log_f" method="post" class="form-horizontal" action="?t=4">
												<fieldset>

													<div id="response_d3">
														<?php
														if (isset($_SESSION['msg4'])) {
															echo $_SESSION['msg4'];
															unset($_SESSION['msg4']);
														}
														?>
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<input type="hidden" name="redirection_lg" id="redirection_lg" value="redirection_lg" />


													<div class="control-group">
														<label class="control-label" for="mac_rd">MAC</label>
														<div class="controls form-group">
															<input class="span2 form-control" id="mac4" name="mac4" value="<?php echo $mac4; ?>" type="text">
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="realm_rd">Realm</label>
														<div class="controls form-group">
															<input class="span2 form-control" id="realm4" name="realm4" value="<?php echo $realm4; ?>" type="text">
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit4">Limit</label>
														<div class="controls form-group">
															<?php

															if (!isset($limit4)) {
																$limit4 = 50;
															}

															?>
															<?php echo '<input class="span2 form-control limit_log" id="limit4" name="limit4" value="' . $limit4 . '" type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

															<script type="text/javascript">
																$(document).ready(function() {

																	$('#limit4').tooltip();


																});
															</script>

														</div>
													</div>


													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


															<input class="span2 form-control" id="start_date4" name="start_date4" type="text" value="<?php if (isset($mg_start_date4)) {
																																							echo $mg_start_4;
																																						} ?>" placeholder="mm/dd/yyyy">
															to
															<input class="span2 form-control" id="end_date4" name="end_date4" type="text" value="<?php if (isset($mg_end_date4)) {
																																						echo $mg_end_4;
																																					} ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="date4" />

														</div>
														<!-- /controls -->
													</div>



													<div class="form-actions">
														<button type="submit" name="redirection_log_submit" id="redirection_log_submit" class="btn btn-primary">GO</button>
													</div>

												</fieldset>
											</form>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<?php
													//$row_count33 = mysql_num_rows($query_results4);
													$row_count33 = $query_results4['rowCount'];
													if ($row_count33 > 0) {
													?>
														<h3>Redirection Logs
														<?php
													} else {
														?>
															<h3>Redirection Logs
															<?php
														}
															?>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;">
														<table style="table-layout: fixed;" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Page</th> -->
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">REDIRECT URL</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Realm</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ORIGINATING URL</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Date</th>

																</tr>
															</thead>
															<tbody>

																<?php


																//while($row=mysql_fetch_array($query_results4)){
																foreach ($query_results4['data'] as $row) {

																	$mac = $row[mac];
																	$page = $row[page];
																	$request_uri = $row[request_uri];
																	$referer = $row[referer];
																	$create_date = $row[create_date];
																	$id = $row['id'];
																	$realm = $row[group_id];

																	echo '<tr>
														<td> ' . $mac . ' </td>
														<td>';
																	if (strlen($request_uri) > 0) {
																		echo '<a id="redirect_url_' . $id . '"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#redirect_url_' . $id . '\').tooltipster({
												                content: $("<p style= word-wrap:break-word>' . $request_uri . '</p>"),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script>';
																	}

																	echo '</td>
														<td> ' . $realm . ' </td>';
																	echo '<td>';
																	if (strlen($referer) > 0) {
																		echo '
														<a id="origination_url_' . $id . '"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#origination_url_' . $id . '\').tooltipster({
												                content: $("<p style= word-wrap:break-word>' . $referer . '</p>"),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script> ';
																	}

																	echo '</td>';
																	echo '
														<td> ' . date_format(date_create($create_date), 'd/m/Y h:i:s A') . ' </td>';
																}

																?>





															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
										</div>
									</div>
								</div>
								<!-- /widget-content -->

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
	<script type="text/javascript">
		$(document).ready(function() {

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth() + 1; //January is 0!
			var yyyy = today.getFullYear();

			if (dd < 10) {
				dd = '0' + dd
			}

			if (mm < 10) {
				mm = '0' + mm
			}

			today = mm + '/' + dd + '/' + yyyy;

			$('#activity_log1').formValidation({
				framework: 'bootstrap',
				fields: {

					date3: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date3"], input[name="end_date3"]', function(e) {
				var from = $('#activity_log1').find('[name="start_date3"]').val(),
					to = $('#activity_log1').find('[name="end_date3"]').val();

				// Set the dob field value
				$('#activity_log1').find('[name="date3"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#activity_log1').formValidation('revalidateField', 'date3');
			});

			$('#prepaid_activity_logs_form').formValidation({
				framework: 'bootstrap',
				fields: {

					start_date36: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					end_date36: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date36"], input[name="end_date36"]', function(e) {
				var from = $('#prepaid_activity_logs_form').find('[name="start_date36"]').val(),
					to = $('#prepaid_activity_logs_form').find('[name="end_date36"]').val();

				// Set the dob field value
				$('#prepaid_activity_logs_form').find('[name="date36"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#prepaid_activity_logs_form').formValidation('revalidateField', 'date3');
			});

			$('#property_activity_logs_form').formValidation({
				framework: 'bootstrap',
				fields: {

					property: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					date24: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date24"], input[name="end_date24"]', function(e) {
				var from = $('#property_activity_logs_form').find('[name="start_date24"]').val(),
					to = $('#property_activity_logs_form').find('[name="end_date24"]').val();

				// Set the dob field value
				$('#property_activity_logs_form').find('[name="date24"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#property_activity_logs_form').formValidation('revalidateField', 'date24');
			});


			$('#auth_log').formValidation({
				framework: 'bootstrap',
				fields: {

					date11: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date11"], input[name="end_date11"]', function(e) {
				var from = $('#auth_log').find('[name="start_date11"]').val(),
					to = $('#auth_log').find('[name="end_date11"]').val();

				// Set the dob field value
				$('#auth_log').find('[name="date11"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#auth_log').formValidation('revalidateField', 'date11');
			});



			$('#session_log').formValidation({
				framework: 'bootstrap',
				fields: {

					ses_date: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="ses_start_date"], input[name="ses_end_date"]', function(e) {
				var from = $('#session_log').find('[name="ses_start_date"]').val(),
					to = $('#session_log').find('[name="ses_end_date"]').val();

				// Set the dob field value
				$('#session_log').find('[name="ses_date"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#session_log').formValidation('revalidateField', 'ses_date');
			});


			$('#dsf_api_log').formValidation({
				framework: 'bootstrap',
				fields: {

					dsf_api_date: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="dsf_api_start_date"], input[name="dsf_api_end_date"]', function(e) {
				var from = $('#dsf_api_log').find('[name="dsf_api_start_date"]').val(),
					to = $('#dsf_api_log').find('[name="dsf_api_end_date"]').val();

				// Set the dob field value
				$('#dsf_api_log').find('[name="dsf_api_date"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#dsf_api_log').formValidation('revalidateField', 'dsf_api_date');
			});

			$('#aaa_log').formValidation({
				framework: 'bootstrap',
				fields: {

					aaa_log_date: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="aaa_start_date"], input[name="aaa_end_date"]', function(e) {
				var from = $('#aaa_log').find('[name="aaa_start_date"]').val(),
					to = $('#aaa_log').find('[name="aaa_end_date"]').val();

				// Set the dob field value
				$('#aaa_log').find('[name="aaa_log_date"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#aaa_log').formValidation('revalidateField', 'aaa_log_date');
			});

			$('#error_log').formValidation({
				framework: 'bootstrap',
				fields: {

					error_date: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date"], input[name="end_date"]', function(e) {
				var from = $('#error_log').find('[name="start_date"]').val(),
					to = $('#error_log').find('[name="end_date"]').val();

				// Set the dob field value
				$('#error_log').find('[name="error_date"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#error_log').formValidation('revalidateField', 'error_date');
			});

			$('#error_log2').formValidation({
				framework: 'bootstrap',
				fields: {

					error_date2: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date2"], input[name="end_date2"]', function(e) {
				var from = $('#error_log2').find('[name="start_date2"]').val(),
					to = $('#error_log2').find('[name="end_date2"]').val();

				// Set the dob field value
				$('#error_log2').find('[name="error_date2"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#error_log2').formValidation('revalidateField', 'error_date2');
			});

			$('#api_logs').formValidation({
				framework: 'bootstrap',
				fields: {

					api_date: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date_api"], input[name="end_date_api"]', function(e) {
				var from = $('#api_logs').find('[name="start_date_api"]').val(),
					to = $('#api_logs').find('[name="end_date_api"]').val();

				// Set the dob field value
				$('#api_logs').find('[name="api_date"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#api_logs').formValidation('revalidateField', 'api_date');
			});

			$('#redirection_log_f').formValidation({
				framework: 'bootstrap',
				fields: {

					date4: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date4"], input[name="end_date4"]', function(e) {
				var from = $('#redirection_log_f').find('[name="start_date4"]').val(),
					to = $('#redirection_log_f').find('[name="end_date4"]').val();

				// Set the dob field value
				$('#redirection_log_f').find('[name="date4"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#redirection_log_f').formValidation('revalidateField', 'date4');
			});


		});
	</script>


	<!--auth-->







	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			var from = $('#activity_log1').find('[name="start_date3"]').val();
			var to = $('#activity_log1').find('[name="end_date3"]').val();
			$('#activity_log1').find('[name="date3"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

			var from36 = $('#prepaid_activity_logs_form').find('[name="start_date36"]').val();
			var to36 = $('#prepaid_activity_logs_form').find('[name="end_date36"]').val();
			$('#prepaid_activity_logs_form').find('[name="date36"]').val(from36 === '' || to36 === '' ? '' : [from, to].join('.'));

			var from24 = $('#property_activity_logs_form').find('[name="start_date24"]').val();
			var to24 = $('#property_activity_logs_form').find('[name="end_date24"]').val();
			$('#property_activity_logs_form').find('[name="date24"]').val(from24 === '' || to24 === '' ? '' : [from24, to24].join('.'));

			var from1 = $('#dsf_api_log').find('[name="dsf_api_start_date"]').val();
			var to1 = $('#dsf_api_log').find('[name="dsf_api_end_date"]').val();
			$('#dsf_api_log').find('[name="dsf_api_date"]').val(from1 === '' || to1 === '' ? '' : [from1, to1].join('.'));

			var from1 = $('#session_log').find('[name="ses_start_date"]').val();
			var to1 = $('#session_log').find('[name="ses_end_date"]').val();
			$('#session_log').find('[name="ses_date"]').val(from1 === '' || to1 === '' ? '' : [from1, to1].join('.'));

			var from2 = $('#aaa_log').find('[name="aaa_start_date"]').val();
			var to2 = $('#aaa_log').find('[name="aaa_end_date"]').val();
			$('#aaa_log').find('[name="aaa_log_date"]').val(from2 === '' || to2 === '' ? '' : [from2, to2].join('.'));

			var from3 = $('#error_log').find('[name="start_date"]').val();
			var to3 = $('#error_log').find('[name="end_date"]').val();
			$('#error_log').find('[name="error_date"]').val(from3 === '' || to3 === '' ? '' : [from3, to3].join('.'));

			var from4 = $('#error_log2').find('[name="start_date2"]').val();
			var to4 = $('#error_log2').find('[name="end_date2"]').val();
			$('#error_log2').find('[name="error_date2"]').val(from4 === '' || to4 === '' ? '' : [from4, to4].join('.'));

			var from5 = $('#api_logs').find('[name="start_date_api"]').val();
			var to5 = $('#api_logs').find('[name="end_date_api"]').val();
			$('#api_logs').find('[name="api_date"]').val(from5 === '' || to5 === '' ? '' : [from5, to5].join('.'));

			var from6 = $('#redirection_log_f').find('[name="start_date4"]').val();
			var to6 = $('#redirection_log_f').find('[name="end_date4"]').val();
			$('#redirection_log_f').find('[name="date4"]').val(from6 === '' || to6 === '' ? '' : [from6, to6].join('.'));

			var from11 = $('#auth_log').find('[name="start_date11"]').val();
			var to11 = $('#auth_log').find('[name="end_date11"]').val();
			$('#auth_log').find('[name="date11"]').val(from11 === '' || to11 === '' ? '' : [from11, to11].join('.'));


			$("#create_product_submit").easyconfirm({
				locale: {
					title: 'Product Creation',
					text: 'Are you sure you want to save this Product?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#create_product_submit").click(function() {});



			$("#assign_product_submit").easyconfirm({
				locale: {
					title: 'Product Assign',
					text: 'Are you sure you want to assign this Product?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#assign_product_submit").click(function() {});
		});
	</script>

	<script>
		$(function() {
			$("#ses_start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#ses_start_date").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#ses_end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#ses_end_date").attr("autocomplete", "off");
	</script>
	<script>
		$(function() {
			$("#dsf_api_start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#dsf_api_start_date").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#dsf_api_end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#dsf_api_end_date").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#ses_start_date').on('change', function() {
			$(function() {
				$("#ses_end_date").datepicker("option", "minDate", $("#ses_start_date").datepicker("getDate"));
				$("#ses_start_date").datepicker("option", "maxDate", $("#ses_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'ses_date');

			});
		});

		$('#ses_end_date').on('change', function() {
			$(function() {
				$("#ses_end_date").datepicker("option", "minDate", $("#ses_start_date").datepicker("getDate"));
				$("#ses_start_date").datepicker("option", "maxDate", $("#ses_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'ses_date');

			});
		});
	</script>
	<script type="text/javascript">
		$('#ses_start_date').on('change', function() {
			$(function() {
				$("#ses_end_date").datepicker("option", "minDate", $("#ses_start_date").datepicker("getDate"));
				$("#ses_start_date").datepicker("option", "maxDate", $("#ses_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'ses_date');

			});
		});

		$('#ses_end_date').on('change', function() {
			$(function() {
				$("#ses_end_date").datepicker("option", "minDate", $("#ses_start_date").datepicker("getDate"));
				$("#ses_start_date").datepicker("option", "maxDate", $("#ses_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'ses_date');

			});
		});
	</script>
	<script type="text/javascript">
		$('#dsf_api_start_date').on('change', function() {
			$(function() {
				$("#dsf_api_end_date").datepicker("option", "minDate", $("#dsf_api_start_date").datepicker("getDate"));
				$("#dsf_api_start_date").datepicker("option", "maxDate", $("#dsf_api_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'dsf_api_date');

			});
		});

		$('#dsf_api_end_date').on('change', function() {
			$(function() {
				$("#dsf_api_end_date").datepicker("option", "minDate", $("#dsf_api_start_date").datepicker("getDate"));
				$("#dsf_api_start_date").datepicker("option", "maxDate", $("#dsf_api_end_date").datepicker("getDate"));
				$('#session_log').formValidation('revalidateField', 'dsf_api_date');

			});
		});
	</script>

	<script>
		$(function() {
			$("#aaa_start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#aaa_start_date").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#aaa_end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#aaa_end_date").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#aaa_start_date').on('change', function() {
			$(function() {
				$("#aaa_end_date").datepicker("option", "minDate", $("#aaa_start_date").datepicker("getDate"));
				$("#aaa_start_date").datepicker("option", "maxDate", $("#aaa_end_date").datepicker("getDate"));
				$('#aaa_log').formValidation('revalidateField', 'aaa_log_date');

			});
		});

		$('#aaa_end_date').on('change', function() {
			$(function() {
				$("#aaa_end_date").datepicker("option", "minDate", $("#aaa_start_date").datepicker("getDate"));
				$("#aaa_start_date").datepicker("option", "maxDate", $("#aaa_end_date").datepicker("getDate"));
				$('#aaa_log').formValidation('revalidateField', 'aaa_log_date');

			});
		});
	</script>


	<script>
		$(function() {
			$("#start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#start_date").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#end_date").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#start_date').on('change', function() {
			$(function() {
				$("#end_date").datepicker("option", "minDate", $("#start_date").datepicker("getDate"));
				$("#start_date").datepicker("option", "maxDate", $("#end_date").datepicker("getDate"));
				$('#error_log').formValidation('revalidateField', 'error_date');

			});
		});

		$('#end_date').on('change', function() {
			$(function() {
				$("#end_date").datepicker("option", "minDate", $("#start_date").datepicker("getDate"));
				$("#start_date").datepicker("option", "maxDate", $("#end_date").datepicker("getDate"));
				$('#error_log').formValidation('revalidateField', 'error_date');

			});
		});
	</script>


	<script>
		$(function() {
			$("#start_date2").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#start_date2").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date2").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#end_date2").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#start_date2').on('change', function() {
			$(function() {
				$("#end_date2").datepicker("option", "minDate", $("#start_date2").datepicker("getDate"));
				$("#start_date2").datepicker("option", "maxDate", $("#end_date2").datepicker("getDate"));
				$('#error_log2').formValidation('revalidateField', 'error_date2');

			});
		});

		$('#end_date2').on('change', function() {
			$(function() {
				$("#end_date2").datepicker("option", "minDate", $("#start_date2").datepicker("getDate"));
				$("#start_date2").datepicker("option", "maxDate", $("#end_date2").datepicker("getDate"));
				$('#error_log2').formValidation('revalidateField', 'error_date2');

			});
		});
	</script>

	<script type="text/javascript">
		$('#start_date3').on('change', function() {
			$(function() {
				$("#end_date3").datepicker("option", "minDate", $("#start_date3").datepicker("getDate"));
				$("#start_date3").datepicker("option", "maxDate", $("#end_date3").datepicker("getDate"));
				$('#activity_log1').formValidation('revalidateField', 'date3');

			});
		});

		$('#end_date3').on('change', function() {
			$(function() {
				$("#end_date3").datepicker("option", "minDate", $("#start_date3").datepicker("getDate"));
				$("#start_date3").datepicker("option", "maxDate", $("#end_date3").datepicker("getDate"));
				$('#activity_log1').formValidation('revalidateField', 'date3');

			});
		});

		$('#start_date36').on('change', function() {
			$(function() {
				$("#end_date36").datepicker("option", "minDate", $("#start_date36").datepicker("getDate"));
				$("#start_date36").datepicker("option", "maxDate", $("#end_date36").datepicker("getDate"));
				$('#prepaid_activity_logs_form').formValidation('revalidateField', 'date36');

			});
		});

		$('#end_date36').on('change', function() {
			$(function() {
				$("#end_date36").datepicker("option", "minDate", $("#start_date36").datepicker("getDate"));
				$("#start_date36").datepicker("option", "maxDate", $("#end_date36").datepicker("getDate"));
				$('#prepaid_activity_logs_form').formValidation('revalidateField', 'date36');

			});
		});

		$('#start_date24').on('change', function() {
			$(function() {
				$("#end_date24").datepicker("option", "minDate", $("#start_date24").datepicker("getDate"));
				$("#start_date24").datepicker("option", "maxDate", $("#end_date24").datepicker("getDate"));
				$('#property_activity_logs_form').formValidation('revalidateField', 'date24');

			});
		});

		$('#end_date24').on('change', function() {
			$(function() {
				$("#end_date24").datepicker("option", "minDate", $("#start_date24").datepicker("getDate"));
				$("#start_date24").datepicker("option", "maxDate", $("#end_date24").datepicker("getDate"));
				$('#property_activity_logs_form').formValidation('revalidateField', 'date24');

			});
		});
	</script>

	<script>
		$(function() {
			$("#start_date3").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
			$("#start_date36").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
			$("#start_date24").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#start_date3").attr("autocomplete", "off");
		$("#start_date36").attr("autocomplete", "off");
		$("#start_date24").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date3").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
			$("#end_date36").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
			$("#end_date24").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#end_date3").attr("autocomplete", "off");
		$("#end_date36").attr("autocomplete", "off");
		$("#end_date24").attr("autocomplete", "off");
	</script>



	<!--11-->

	<script type="text/javascript">
		$('#start_date11').on('change', function() {
			$(function() {
				$("#end_date11").datepicker("option", "minDate", $("#start_date11").datepicker("getDate"));
				$("#start_date11").datepicker("option", "maxDate", $("#end_date11").datepicker("getDate"));
				$('#activity_log11').formValidation('revalidateField', 'date11');

			});
		});

		$('#end_date11').on('change', function() {
			$(function() {
				$("#end_date11").datepicker("option", "minDate", $("#start_date11").datepicker("getDate"));
				$("#start_date11").datepicker("option", "maxDate", $("#end_date11").datepicker("getDate"));
				$('#activity_log11').formValidation('revalidateField', 'date11');

			});
		});
	</script>

	<script>
		$(function() {
			$("#start_date11").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#start_date11").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date11").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#end_date11").attr("autocomplete", "off");
	</script>

	<!-- 
<script>

$( function() {
    $( "#start_date3" ).datepicker({
        dateFormat: "mm/dd/yyyy",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ]
    });

     $("#start_date3").on('change', function(){
    	    var date = Date.parse($(this).val());

         if (date > Date.now()){
             alert('Please select another date');
             $(this).val('');
         }

          $('#activity_log1').formValidation('revalidateField', 'end_date3');
    });
} );
</script>

<script>

$( function() {
    $( "#end_date3" ).datepicker({
        dateFormat: "mm/dd/yyyy",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ]
    });

    $("#end_date3").on('change', function(){
    	    var date = Date.parse($(this).val());

         if (date > Date.now()){
             alert('Please select another date');
             $(this).val('');
         }

          $('#activity_log1').formValidation('revalidateField', 'end_date3');
    });
} );
</script> -->

	<script>
		$(function() {
			$("#start_date_api").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#start_date_api").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date_api").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#end_date_api").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#start_date_api').on('change', function() {
			$(function() {
				$("#end_date_api").datepicker("option", "minDate", $("#start_date_api").datepicker("getDate"));
				$("#start_date_api").datepicker("option", "maxDate", $("#end_date_api").datepicker("getDate"));
				$('#api_logs').formValidation('revalidateField', 'api_date');

			});
		});

		$('#end_date_api').on('change', function() {
			$(function() {
				$("#end_date_api").datepicker("option", "minDate", $("#start_date_api").datepicker("getDate"));
				$("#start_date_api").datepicker("option", "maxDate", $("#end_date_api").datepicker("getDate"));
				$('#api_logs').formValidation('revalidateField', 'api_date');

			});
		});
	</script>


	<script>
		$(function() {
			$("#start_date4").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#start_date4").attr("autocomplete", "off");
	</script>

	<script>
		$(function() {
			$("#end_date4").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#end_date4").attr("autocomplete", "off");
	</script>

	<script type="text/javascript">
		$('#start_date4').on('change', function() {
			$(function() {
				$("#end_date4").datepicker("option", "minDate", $("#start_date4").datepicker("getDate"));
				$("#start_date4").datepicker("option", "maxDate", $("#end_date4").datepicker("getDate"));
				$('#redirection_log_f').formValidation('revalidateField', 'date4');

			});
		});

		$('#end_date4').on('change', function() {
			$(function() {
				$("#end_date4").datepicker("option", "minDate", $("#start_date4").datepicker("getDate"));
				$("#start_date4").datepicker("option", "maxDate", $("#end_date4").datepicker("getDate"));
				$('#redirection_log_f').formValidation('revalidateField', 'date4');

			});
		});
	</script>



	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#product_code").chained("#category");

		});
	</script>

	<script type="text/javascript">
		$(".limit_log").keypress(function(event) {
			var ew = event.which;
			//  alert(ew);
			if (ew == 8 || ew == 0)
				return true;
			if (48 <= ew && ew <= 57)
				return true;
			return false;
		});


		$('.limit_log').bind("cut copy paste", function(e) {
			e.preventDefault();
		});
	</script>


	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>



	<?php
	include 'footer.php';
	?>





	</body>

</html>