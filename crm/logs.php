<?php 
include 'header_new.php'; 
require_once 'src/LOG/Logger.php';

$pages = $db->getDataFromLogsField('page');
$logTypes = $db->getDataFromLogsField('log_type');
$sections = $db->getDataFromApiLogsField('section','section');
// var_dump($sections);

$today = date('m/d/Y');
$day_before_week = date('m/d/Y', strtotime('-7 days'));

$en_date = DateTime::createFromFormat('m/d/Y', $today)->format('Y-m-d');
$st_date = DateTime::createFromFormat('m/d/Y', $day_before_week)->format('Y-m-d');

$start_date = $st_date . ' 00:00:00';
$end_date = $en_date . ' 23:59:59';

$query_results1_user = $db->getLogsByFilters($start_date,$end_date);

$api_log_results = $db->getApiLogsByFilters($start_date,$end_date);

//activity_logs
if (isset($_POST['activity_lg'])) {
	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$userName = (isset($_POST['name']) && $_POST['name'] != '-1') ? $_POST['name'] : null;
		$limit = isset($_POST['limit'])  ? $_POST['limit'] : null;
		$logType = (isset($_POST['log_type']) && $_POST['log_type'] != '-1') ? $_POST['log_type'] : null;
		$page = (isset($_POST['pages']) && $_POST['pages'] != '-1') ? $_POST['pages'] : null;

		if ($_POST['start_date'] != NULL && $_POST['end_date'] != NULL) {
			$mg_end = $_POST['end_date'];
			$mg_start = $_POST['start_date'];

			$en_date = DateTime::createFromFormat('m/d/Y', $mg_end)->format('Y-m-d');
			$st_date = DateTime::createFromFormat('m/d/Y', $mg_start)->format('Y-m-d');

			$start_date = $st_date . ' 00:00:00';
			$end_date = $en_date . ' 23:59:59';
		}

		$query_results1_user = $db->getLogsByFilters($start_date,$end_date,$limit,$userName,$logType,$page);
	}
}


if (isset($_POST['api_lg'])) {
	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$name = (isset($_POST['name']) && $_POST['name'] != '-1') ? $_POST['name'] : null;
		$limit = isset($_POST['api_limit'])  ? $_POST['api_limit'] : null;
		$logType = (isset($_POST['api_log_type']) && $_POST['api_log_type'] != '-1') ? $_POST['api_log_type'] : null;
		$section = (isset($_POST['section']) && $_POST['section'] != '-1') ? $_POST['section'] : null;
		$start_date = '';
		$end_date = '';

		if ($_POST['start_date_api'] != NULL && $_POST['end_date_api'] != NULL) {
			$mg_end = $_POST['end_date_api'];
			$mg_start = $_POST['start_date_api'];

			$en_date = DateTime::createFromFormat('m/d/Y', $mg_end)->format('Y-m-d');
			$st_date = DateTime::createFromFormat('m/d/Y', $mg_start)->format('Y-m-d');

			$start_date = $st_date . ' 00:00:00';
			$end_date = $en_date . ' 23:59:59';
		}

		$api_log_results = $db->getApiLogsByFilters($start_date,$end_date,$limit,$userName,$logType,$section);
	}
}

// var_dump($api_log_results);
//Form Refreshing avoid secret key/////
$secret = md5(uniqid(rand(), true));
$_SESSION['FORM_SECRET'] = $secret;
?>
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget ">
						<div class="widget-content">
							<div class="tabbable">
								<ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="user_activity_logs" data-bs-toggle="tab" data-bs-target="#user_activity_logs-tab-pane" type="button" role="tab" aria-controls="user_activity_logs" aria-selected="true">User Activity Logs</button>
                                    </li>
									<li class="nav-item">
                                        <button class="nav-link" id="api_logs" data-bs-toggle="tab" data-bs-target="#api_logs-tab-pane" type="button" role="tab" aria-controls="api_logs" aria-selected="true">API Logs</button>
                                    </li>
                                </ul>
							</div>
							<div class="tab-content">
								<?php
									if (isset($_SESSION['msg2'])) {
										echo $_SESSION['msg2'];
										unset($_SESSION['msg2']);
									}
								?>
								<div div class="tab-pane fade show active" id="user_activity_logs-tab-pane" role="tabpanel" aria-labelledby="user_activity_logs" tabindex="0">
                                    <h1 class="head">User Activity Logs</h1>
									<div class="border card my-4">
										<div class="border-bottom card-header p-4">
											<div class="g-3 row">
												<span class="fs-5">User Logs Filters</span>
											</div>
										</div>
										<form id="activity_log1" name="activity_log" method="post" class="row g-3 p-4">
											<input type="hidden" name="form_secret" id="form_secret" value="<?=$_SESSION['FORM_SECRET']?>" />
											<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />
											<div class="col-md-4">
												<label class="control-label" for="name">User</label>
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
											<div class="col-md-4">
												<label class="control-label" for="name">Status</label>
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
											<div class="col-md-4">
												<label class="control-label" for="name">Pages</label>
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
											<div class="col-md-4">
												<label class="control-label" for="limit">Limit</label>
												<?php
												if (!isset($limit)) {
													$limit = 50;
												}
												?>
												<?php echo '<input class="span2 form-control limit_log" id="limit" name="limit" value="' . $limit . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
												<script type="text/javascript">
													$(document).ready(function() {
														$('#limit').tooltip();
													});
												</script>
											</div>
											<div class="col-md-4">
												<label class="control-label" for="radiobtns">Period</label>
												<input class="inline_error inline_error_1 span2 form-control" id="start_date" name="start_date" type="text" value="<?php if (isset($mg_start_date)) {
																																											echo $mg_start;
																																										} ?>" placeholder="mm/dd/yyyy">
												to
												<input class="inline_error inline_error_1 span2 form-control" id="end_date" name="end_date" type="text" value="<?php if (isset($mg_end_date)) {
																																										echo $mg_end;
																																									} ?>" placeholder="mm/dd/yyyy">

												<input type="hidden" name="date3" />
												<!-- /controls -->
											</div>
											<div class="col-md-12">
												<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
											</div>
										</form>
									</div>
									<br/>
									<table class="table table-striped" style="width:100%" id="user_activity_logs-table">
										<thead>
											<tr>
												<th>Username</th>
												<th>Log Type</th>
												<th>Page</th>
												<th>Details</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($query_results1_user as $row) {
												$user_name = $row['user_name'];
												$log_type = $row['log_type'];
												// $create_date = $row['create_date'];
												$page = $row['page'];
												$log_details = $row['log_details'];
												$create_date = date("m/d/Y h:i:s A", strtotime($row['create_date']));

												echo '<tr>
														<td> ' . $user_name . ' </td>
														<td> ' . $log_type . ' </td>
														<td> ' . $page . ' </td>
														<td> ' . $log_details . ' </td>
														<td> ' . $create_date . ' </td>
													<tr>';
											}

											?>
										</tbody>
									</table>
								</div>

								<div div class="tab-pane fade" id="api_logs-tab-pane" role="tabpanel" aria-labelledby="api_logs" tabindex="0">
                                    <h1 class="head">API Logs</h1>
									<div class="border card my-4">
										<div class="border-bottom card-header p-4">
											<div class="g-3 row">
												<span class="fs-5">API Logs Filters</span>
											</div>
										</div>
										<form id="activity_log1" name="activity_log" method="post" class="row g-3 p-4">
											<input type="hidden" name="form_secret" id="form_secret" value="<?=$_SESSION['FORM_SECRET']?>" />
											<input type="hidden" name="api_lg" id="api_lg" value="api_lg" />
											<div class="col-md-4">
												<label class="control-label" for="name">User</label>
												<select class="span2 form-control" name="name" id="name" value=<?php echo $userName ?>>
													<option value="-1"> All </option>
													<?php
													$user_select_qu = "SELECT id,user_name FROM `admin_users` ";
													$user_select_re = $db->selectDB($user_select_qu);
													foreach ($user_select_re['data'] as $row_user) {
														if ($row_user['id'] == $userName) {
															echo "<option value='" . $row_user['id'] . "' selected> " . $row_user['user_name'] . " </option>";
														} else {
															echo "<option value='" . $row_user['id'] . "'> " . $row_user['user_name'] . " </option>";
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<label class="control-label" for="name">Status</label>
												<select class="span2 form-control" name="api_log_type" id="api_log_type">
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
											<div class="col-md-4">
												<label class="control-label" for="name">Section</label>
												<select class="span2 form-control" name="section" id="section">
													<option value="-1"> All </option>
													<?php
													foreach($sections as $section) {
														if ($section['section'] == $section) {
															echo "<option value='" . $section['section']. "' selected> " . $section['section']. " </option>";
														} else {
															echo "<option value='" . $section['section']. "'> " . $section['section']. " </option>";
														}
													} 
													?>
												</select>
											</div>
											<div class="col-md-4">
												<label class="control-label" for="api_limit">Limit</label>
												<?php
												if (!isset($limit)) {
													$limit = 50;
												}
												?>
												<?php echo '<input class="span2 form-control limit_log" id="api_limit" name="api_limit" value="' . $limit . '" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
												<script type="text/javascript">
													$(document).ready(function() {
														$('#api_limit').tooltip();
													});
												</script>
											</div>
											<div class="col-md-4">
												<label class="control-label" for="radiobtns">Period</label>
												<input class="inline_error inline_error_1 span2 form-control" id="start_date_api" name="start_date_api" type="text" value="<?php if (isset($mg_start_date)) {
																																											echo $mg_start;
																																										} ?>" placeholder="mm/dd/yyyy">
												to
												<input class="inline_error inline_error_1 span2 form-control" id="end_date_api" name="end_date_api" type="text" value="<?php if (isset($mg_end_date)) {
																																										echo $mg_end;
																																									} ?>" placeholder="mm/dd/yyyy">

												<input type="hidden" name="date3" />
												<!-- /controls -->
											</div>
											<div class="col-md-12">
												<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
											</div>
										</form>
									</div>
									<br/>
									<table class="table table-striped" style="width:100%" id="user_activity_logs-table">
										<thead>
											<tr>
												<th>Name</th>
												<th>Log Type</th>
												<th>Section</th>
												<th>Description</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($api_log_results as $row) {
												$name = $row['name'];
												$log_type = $row['log_type'];
												// $create_date = $row['create_date'];
												$section = $row['section'];
												$description = $row['description'];
												$create_date = date("m/d/Y h:i:s A", strtotime($row['create_date']));

												echo '<tr>
														<td> ' . $name . ' </td>
														<td> ' . $log_type . ' </td>
														<td> ' . $section . ' </td>
														<td> ' . $description . ' </td>
														<td> ' . $create_date . ' </td>
													<tr>';
											}

											?>
										</tbody>
									</table>
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


	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>
	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			$('#user_activity_logs-table').dataTable();

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
			}).on('change', 'input[name="start_date"], input[name="end_date"]', function(e) {
				var from = $('#activity_log1').find('[name="start_date"]').val(),
					to = $('#activity_log1').find('[name="end_date"]').val();

				// Set the dob field value
				$('#activity_log1').find('[name="date3"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#activity_log1').formValidation('revalidateField', 'date3');
			});

			var from = $('#activity_log1').find('[name="start_date"]').val();
			var to = $('#activity_log1').find('[name="end_date"]').val();
			$('#activity_log1').find('[name="date3"]').val(from === '' || to === '' ? '' : [from, to].join('.'));


			$('#api_lg').formValidation({
				framework: 'bootstrap',
				fields: {
					date3: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="start_date_api"], input[name="end_date_api"]', function(e) {
				var api_from = $('#api_lg').find('[name="start_date_api"]').val(),
					api_to = $('#api_lg').find('[name="end_date_api"]').val();

				// Set the dob field value
				$('#api_lg').find('[name="date3"]').val(api_from === '' || api_to === '' ? '' : [api_from, api_to].join('.'));

				// Revalidate it
				$('#api_lg').formValidation('revalidateField', 'date3');
			});

			var api_from = $('#api_lg').find('[name="start_date_api"]').val();
			var api_to = $('#api_lg').find('[name="end_date_api"]').val();
			$('#api_lg').find('[name="date3"]').val(api_from === '' || api_to === '' ? '' : [api_from, api_to].join('.'));

		});
	
		$(function() {
			$("#start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#start_date").attr("autocomplete", "off");

		$(function() {
			$("#end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#end_date").attr("autocomplete", "off");

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

		$(function() {
			$("#start_date_api").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#start_date_api").attr("autocomplete", "off");

		$(function() {
			$("#end_date_api").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0',
				minDate: new Date(1990, 1 - 1, 1)
			});
		});
		$("#end_date_api").attr("autocomplete", "off");

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

