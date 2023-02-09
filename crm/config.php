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

header("Cache-Control: no-cache, must-revalidate");
/*classes & libraries*/

require_once 'classes/dbClass.php';
require_once 'classes/systemPackageClass.php';
require_once 'classes/CommonFunctions.php';
$package_functions = new package_functions();
$db = new db_functions();

$wag_ap_name = $db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
//echo $wag_ap_name='NO_PROFILE';
if ($wag_ap_name != 'NO_PROFILE') {
	include 'src/AP/' . $wag_ap_name . '/index.php';
	// $test = new ap_wag();
}

?>

<head>
	<meta charset="utf-8">
	<title>General Config</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
	<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<style>
		td>.span2 {
			width: 100% !important;
		}

		label span input {
			z-index: 999;
			line-height: 0;
			font-size: 50px;
			position: absolute;
			/* top: -2px; */
			left: -700px;
			opacity: 0;
			filter: alpha(opacity=0);
			-ms-filter: "alpha(opacity=0)";
			cursor: pointer;
			_cursor: hand;
			margin: 0;
			padding: 0;
		}

		.mini {
			width: 85% !important;
		}
	</style>
	<!-- tool tip css -->
	<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
	<script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
	<!-- on-off switch -->
	<link href="css/bootstrap-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/tablesaw.css">
	<!--[if lt IE 9]>

      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->
	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>

	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<?php
	require_once 'classes/faqClass.php';
	include 'header.php';

	$global_url = $db->setVal('global_url', 'ADMIN');

	////////////Tab open////
	if ($user_type == 'MNO') {
		$fearuresjson = $db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
		$mno_feature = json_decode($fearuresjson);
	}

	if (isset($_GET['t'])) {
		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		$tab1 = "set";
		//initially page loading///
		if ($user_type == 'ADMIN') {
			$tab1 = "set";
		} 
	}

		$priority_zone_array = array(
									"America/New_York",
									"America/Chicago",
									"America/Denver",
									"America/Los_Angeles",
									"America/Anchorage",
									"Pacific/Honolulu",
								);

	$base_portal_folder = trim($db->setVal('portal_base_folder', 'ADMIN'), "/");
	$base_url = trim($db->setVal('portal_base_url', 'ADMIN'), "/");
	$sf_apidata = json_decode($db->setVal('snapforce', $user_distributor), true);

	$secret = md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;
	$config_mid = 'layout/' . $camp_layout . '/views/config_mid.php';

	if (($new_design == 'yes') && file_exists($config_mid)) {
		include_once $config_mid;
	} else {
		 if ($user_type == 'MVNO_ADMIN') { 
	?>
			<style type="text/css">
				.nav-tabs>li>a {
					padding-top: 3px !important;
					padding-bottom: 3px !important;
					color: #fff !important;
					border-radius: 0px 0px 0 0 !important;
				}

				.nav-tabs>li>a {
					background: none !important;
					border: none !important;
					border-right: 1px solid white !important;
				}
			</style>
		<?php } ?>
		<div class="main">
			<div class="custom-tabs"></div>
			<div class="main-inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="widget ">
								<?php if ($user_type != 'MVNO_ADMIN') { ?>
									<div class="widget-header">
										<h3>Configuration</h3>
									</div>
								<?php
								}
								
								?>
								<!-- /widget-header -->
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs newTabs">
											<?php
												if ($user_type == 'ADMIN' || $user_type == 'SADMIN' || $user_type == 'RESELLER_ADMIN') {
													if ($user_type == 'ADMIN' || $user_type == 'SADMIN') {
											?>
													<li <?php if (isset($tab1)) { ?>class="active" <?php } ?>><a href="#live_camp" data-toggle="tab">General Config</a></li>
											<?php  } } ?>
										</ul><br>
										<div class="tab-content">
											<?php
											if (isset($_SESSION['msg7'])) {
												echo $_SESSION['msg7'];
												unset($_SESSION['msg7']);
											}

											if (isset($_SESSION['msgft'])) {
												echo $_SESSION['msgft'];
												unset($_SESSION['msgft']);
											}

											if (isset($_SESSION['msg30'])) {
												echo $_SESSION['msg30'];
												unset($_SESSION['msg30']);
											}

											if (isset($_SESSION['msg1'])) {
												echo $_SESSION['msg1'];
												unset($_SESSION['msg1']);
												$isalert = 0;
											}

											if (isset($_SESSION['msg112'])) {
												echo $_SESSION['msg112'];
												unset($_SESSION['msg112']);
											}

											if (isset($_SESSION['msg'])) {
												echo $_SESSION['msg'];
												unset($_SESSION['msg']);
											}

											if (isset($_SESSION['msgx'])) {
												echo $_SESSION['msgx'];
												unset($_SESSION['msgx']);
											}

											if (isset($_SESSION['msgy'])) {
												echo $_SESSION['msgy'];
												unset($_SESSION['msgy']);
											}

											if (isset($_SESSION['msgy1'])) {
												echo $_SESSION['msgy1'];
												unset($_SESSION['msgy1']);
											}

											if (isset($_SESSION['msg41'])) {
												echo $_SESSION['msg41'];
												unset($_SESSION['msg41']);
											}

											if (isset($_SESSION['msg2'])) {
												echo $_SESSION['msg2'];
												unset($_SESSION['msg2']);
											}

											if (isset($_SESSION['msg17'])) {
												echo $_SESSION['msg17'];
												unset($_SESSION['msg17']);
											}

											if (isset($_SESSION['msg18'])) {
												echo $_SESSION['msg18'];
												unset($_SESSION['msg18']);
											}

											if (isset($_SESSION['msg22'])) {
												echo $_SESSION['msg22'];
												unset($_SESSION['msg22']);
											}
											if (isset($_SESSION['system1_msg'])) {
												echo $_SESSION['system1_msg'];
												unset($_SESSION['system1_msg']);
											}

											?>

											<div id="system1_response"></div>
											<!-- ======================= Configurations =============================== -->
											<div <?php if (isset($tab1) && ($user_type == 'ADMIN' || $user_type == 'SADMIN')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="live_camp">
												<?php
												$tab1_field_ar = json_decode($package_functions->getOptions('CONFIG_GENARAL_FIELDS', $system_package), true);
												?>
												<div id="system_response"></div>
												<h1 class="head">General Config</h1>
												<form onkeyup="edit_profilefn();" onchange="edit_profilefn();" id="edit_profile_c" class="form-horizontal">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													echo '<input type="hidden" name="header_logo_img5" id="header_logo_img5" value="' . $settings_value . '" />';
													?>
													<fieldset>
														<div class="control-group" <?php

																					if (!array_key_exists('site_title', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>
															<label class="control-label" for="radiobtns">Site Title</label>
															<div class="controls form-group">
																<input class="span4 form-control" id="main_title" name="main_title" type="text" value="<?php echo $db->setVal("site_title", $user_distributor); ?>">
															</div>
														</div>
														<div class="control-group" <?php
																					if (!array_key_exists('admin_email', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>
															<label class="control-label" for="radiobtns">Admin Email</label>
															<div class="controls form-group">
																<input class="span4 form-control" id="master_email" name="master_email" type="text" value="<?php echo $db->setVal("email", $user_distributor); ?>">
															</div>
														</div>
														<div class="control-group" <?php
																					if (!array_key_exists('time_zone', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>

															<label class="control-label" for="radiobtns">Time Zone</label>
															<div class="controls form-group">
																<div class="input-prepend input-append">
																	<select class="span4 form-control" id="time_zone" name="time_zone">
																		<option value="">- Select Time-zone -</option>
																		<?php
																		$get_tz = "SELECT timezones FROM exp_mno WHERE mno_id = '$user_distributor' LIMIT 1";
																		$reslts = $db->selectDB($get_tz);
																		$timezones = '';
																		foreach ($reslts['data'] as $r) {
																			$timezones = $r['timezones'];
																		}
																		$utc = new DateTimeZone('UTC');
																		$dt = new DateTime('now', $utc);
																		$select = "";
																		foreach (DateTimeZone::listIdentifiers() as $tz) {
																			$current_tz = new DateTimeZone($tz);
																			$offset =  $current_tz->getOffset($dt);
																			$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																			$abbr = $transition[0]['abbr'];
																			if ($timezones === $tz) {
																				$select = "selected";
																				//echo $timezones.'=='.$tz;
																			} else {
																				$select = "";
																			}
																			echo '<option ' . $select . ' value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
																		}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<div class="control-group" <?php
																					if (!array_key_exists('global_url', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?> style="margin-bottom: 0px !important;">

															<label class="control-label" for="radiobtns">CRM URL</label>
															<div class="controls form-group">
																<input class="span4 form-control" id="global_url" name="global_url" type="text" value="<?php echo $db->setVal("global_url", $user_distributor); ?>">
															</div>
														</div>
														<div class="form-actions ">
															<button disabled type="submit" id="system_info" name="submit" class="btn btn-primary">Save</button>
															<img id="system_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
														</div>
														<script>
															function edit_profilefn() {
																$("#system_info").prop('disabled', false);
															}
														</script>
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

	<?php } ?>

	<!-- /main -->
	<?php
	include 'footer.php';
	?>
	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$("#system_info").easyconfirm({
				locale: {
					title: 'General Config',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
		});
	</script>
	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	<script src="js/bootstrap-toggle.min.js"></script>
	<script src="js/jquery.multi-select.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#cancel").on('change', function() {
				$("#editable").html("");
			});

			$('#edit_profile_c').formValidation({
				framework: 'bootstrap',
				button: {
					selector: '#system_info',
					disabled: 'disabled'
				},
				fields: {
					main_title: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					global_url: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					master_email: {
						validators: {
							<?php echo $db->validateField('master_email1'); ?>
						}
					}
				}
			}).on('success.form.fv', function(e) {
				e.preventDefault();
				getInfoBox('system', 'system_response');
			});
		});

		function GetXmlHttpObject(){
			var xmlHttp = null;
			try {
				// Firefox, Opera 8.0+, Safari
				xmlHttp = new XMLHttpRequest();
			} catch (e) {   
				//Internet Explorer
				try{
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
			}
			return xmlHttp;
		}

		var xmlHttp3;

		function getInfoBox(type, response) {
			xmlHttp3 = GetXmlHttpObject();
			if (xmlHttp3 == null) {
				alert("Browser does not support HTTP Request");
				return;
			}

			var loader = type + "_loader";
			document.getElementById(loader).style.visibility = 'visible';
			var url = "ajax/updateConfig.php";
			url = url + "?type=" + type;

			switch (type) {
				case 'system':
					var global_url = document.getElementById("global_url").value;
					var main_title = document.getElementById("main_title").value;
					var master_email = document.getElementById("master_email").value;
					var time_zone = document.getElementById("time_zone").value;
					var top_line_color = "";

					url = url +
						"&global_url=" + encodeURIComponent(global_url) +
						"&main_title=" + encodeURIComponent(main_title) +
						"&master_email=" + encodeURIComponent(master_email) +
						"&time_zone=" + encodeURIComponent(time_zone);
				break;
			}

			xmlHttp3.onreadystatechange = stateChanged;
			xmlHttp3.open("GET", url, true);
			xmlHttp3.send(null);

			
			function stateChanged() {
				if (xmlHttp3.readyState == 4 || xmlHttp3.readyState == "complete") {
					if (type == 'manual') {
						window.location = "?t=22";
					} else {
						window.location = "?t=<?php echo $user_type == 'MNO' || $user_type == 'SALES' || $user_type == 'MVNO_ADMIN' ? '0' : '1' ?>";
					}
					document.getElementById(loader).style.visibility = 'hidden';
				}
			}
		}

	</script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script src="js/jscolor.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
	</body>

</html>