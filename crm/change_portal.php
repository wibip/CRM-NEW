<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(E_WARNING);
include 'header_top.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, must-revalidate");
/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

$users = [];
$_SESSION['section'] = $_GET['section'];
if (isset($_GET['section']) && $_GET['section'] != 'ADMIN') {
	$userSql = "SELECT id,full_name FROM admin_users WHERE user_type='MNO' AND is_enable=1";
	$userResults = $db->selectDB($userSql);
	$users = $userResults['data'];
}

if (isset($_POST['select_profile']) || $_GET['section'] == 'ADMIN') {
	if ($_GET['section'] == 'ADMIN') {
		$userId = 1;
	} else {
		$userId = $_POST['user_id'];
	}
	$_SESSION['previous_profile'] = isset($_SESSION['current_profile']) ? $_SESSION['current_profile'] : null;
	header("Location: ./generic/login?auto_login&user_id=" . $userId);
	exit();
}

?>

<head>
	<meta charset="utf-8">
	<title>Changing Portal</title>
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

	?>
	<div class="main">
		<div class="custom-tabs"></div>
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget">
							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs newTabs">
										<li class="active"><a href="#show_clients" data-toggle="tab">Switch Accounts</a></li>
									</ul>
									<br>
									<div class="tab-content">
										<!-- +++++++++++++++++++++++++++++ client list ++++++++++++++++++++++++++++++++ -->
										<div class="tab-pane fade in active" id="show_clients">
											<h1 class="head">Switch Accounts</h1>
											<?php if (isset($_GET['section']) && $_GET['section'] != 'ADMIN') { ?>
												<form autocomplete="off" id="assign_roles_submit" name="assign_roles_submit" method="post" class="form-horizontal">
													<div class="control-group">
														<label class="control-label">Operation Account</label>
														<select class="span3" id="<?= ($_GET['section'] == 'MNO' ? "user_id" : "operator_id") ?>" name="<?= ($_GET['section'] == 'MNO' ? "user_id" : "operator_id") ?>">
															<option value='0'>Select Operation Account</option>
															<?php
															if (!empty($users)) {
																foreach ($users as $user) {
															?>
																	<option value='<?= $user['id'] ?>'><?= $user['full_name'] ?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
													<?php if ($_GET['section'] == 'PROVISIONING') { ?>
														<div class="control-group">
															<label class="control-label">Client Account</label>
															<select class="span3" id="user_id" name="user_id">
																<option value='0'></option>
															</select>
														</div>
													<?php } ?>
													<div class="form-actions">
														<button disabled type="submit" name="select_profile" id="select_profile" class="btn btn-primary">Select Profile</button>
													</div>
												</form>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
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
		<script type="text/javascript">
			$(document).ready(function() {
				/*select user*/
				$('#user_id').on('change', function() {
					var userId = $(this).val();
					if (userId != 0) {
						$('#select_profile').prop("disabled", false);
					} else {
						alert('Please select proper account');
						$('#select_profile').prop("disabled", true);
					}
				});

				/*Load clients*/
				$('#operator_id').on('change', function() {
					var operatorId = $(this).val();
					if (operatorId != 0) {
						$.post('ajax/load_provision.php', {
							operatorId: operatorId
						}, function(response) {
							console.log(response);
							// alert("success");
							// $("#mypar").html(response.amount);
							if (response != '') {
								$('#user_id').html(response);
							}
						});
					} else {
						alert('Please select operation account');
					}
				});
			});
		</script>
		<?php
		include 'footer.php';
		?>
		</body>

</html>