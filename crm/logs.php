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

$pages = $db->getDataFromLogsField('page');
$userNames = $db->getDataFromLogsField('user_name');
$logTypes = $db->getDataFromLogsField('log_type');
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
			$tab3 = "set";
		} else if ($user_type == 'MVNE') {
			$tab2 = "set";
		} else if ($user_type == 'MVNO') {
			$tab2 = "set";
		} else {
			$tab3 = "set";
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
											<li <?php if (isset($tab3)) { ?>class="active" <?php } ?>><a href="#user_activity_logs" data-toggle="tab">User Activity Logs</a></li>
											<?php 
											// if ($package_features == "all" || in_array("OTHER_LOG", $features_array)) { ?>
												<!--<li < ?php if (isset($tab36)) { ?>class="active" < ?php } ?>><a href="#prepaid_activity_logs" data-toggle="tab">API Logs</a></li>-->
											<?php //} ?>
										</ul>
										<br>

									</div>


									<div class="tab-content">
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
																$user_select_qu = "SELECT user_name FROM `admin_users` ";
																$user_select_re = $db->selectDB($user_select_qu);
																foreach ($user_select_re['data'] as $row_user) {
																	if ($row_user['user_name'] == $name) {
																		echo "<option value='" . $row_user['user_name'] . "' selected> " . $row_user['user_name'] . " </option>";
																	} else {
																		echo "<option value='" . $row_user['user_name'] . "'> " . $row_user['user_name'] . " </option>";
																	}
																}
																?>
															</select>
														</div>
													</div>
													<div class="control-group ">
														<label class="control-label" for="name">Status</label>
														<div class="controls form-group">
															<select class="span2 form-control" name="log_type" id="log_type">
																<option value="-1"> All </option>
																<?php
																foreach($logTypes as $logType) {
																	if ($logType['log_type'] == $name) {
																		echo "<option value='" . $logType['log_type']. "' selected> " . $logType['log_type']. " </option>";
																	} else {
																		echo "<option value='" . $logType['log_type']. "'> " . $logType['log_type']. " </option>";
																	}
																} 
																?>
															</select>
														</div>
													</div>
													<div class="control-group ">
														<label class="control-label" for="name">Pages</label>
														<div class="controls form-group">
															<select class="span2 form-control" name="pages" id="pages">
																<option value="-1"> All </option>
																<?php
																foreach($pages as $page) {
																	if ($page['page'] == $name) {
																		echo "<option value='" . $page['page']. "' selected> " . $page['page']. " </option>";
																	} else {
																		echo "<option value='" . $page['page']. "'> " . $page['page']. " </option>";
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
																	$dt = new DateTime("@$unixtimestamp");
																	$dt->setTimezone(new DateTimeZone($log_time_zone));
																	$unix_date = $dt->format('m/d/Y h:i:s A');
																	$dt2 = new DateTime($create_date);
																	$create_date = $dt2->format('m/d/Y h:i:s A');

																	echo '<tr>
																			<td> ' . $user_name . ' </td>
																			<td> ' . $module . ' </td>
																			<td> ' . $task . ' </td>
																			<td> ' . $reference . ' </td>
																			<td> ' . $ip . ' </td>
																			<td> ' . $unix_date . ' </td>
																		<tr>';
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
		});
	</script>

	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var from = $('#activity_log1').find('[name="start_date3"]').val();
			var to = $('#activity_log1').find('[name="end_date3"]').val();
			$('#activity_log1').find('[name="date3"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

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
			$("#dsf_api_end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#dsf_api_end_date").attr("autocomplete", "off");
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