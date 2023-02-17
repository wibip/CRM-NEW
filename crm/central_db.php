<?php
include 'header_new.php';

$wag_ap_name = $db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
//echo $wag_ap_name='NO_PROFILE';
if ($wag_ap_name != 'NO_PROFILE') {
	include 'src/AP/' . $wag_ap_name . '/index.php';
	// $test = new ap_wag();
}

?>
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
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<?php
	require_once 'classes/faqClass.php';

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
	// echo $config_mid;
	if (($new_design == 'yes') && file_exists($config_mid)) {
		include_once $config_mid;
	} else {
?>
		<div class="main">
			<div class="custom-tabs"></div>
			<div class="main-inner">
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="widget ">
								<!-- /widget-header -->
								<div class="widget-content">
									<div class="tabbable">
										<ul class="nav nav-tabs">
											<li class="nav-item" role="presentation">
												<button class="nav-link active" id="central_db" data-bs-toggle="tab" data-bs-target="#central_db-tab-pane" type="button" role="tab" aria-controls="central_db" aria-selected="true">Central DB</button>
											</li>
										</ul>
										<div class="tab-content">	
											<?php
											$tab1_field_ar = json_decode($package_functions->getOptions('CONFIG_GENARAL_FIELDS', $system_package), true);
											?>										
											<div div class="tab-pane fade show active" id="central_db-tab-pane" role="tabpanel" aria-labelledby="central_db" tabindex="0">
												<div class="border card">
													<div class="border-bottom card-header p-4">
														<div class="g-3 row">
															<span class="fs-5">Central DB Configuration</span>
														</div>
													</div>
													<form onkeyup="edit_central_db();" onchange="edit_central_db();" id="edit_profile_c" class="row g-3 p-4">
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>
														<div class="col-md-6" <?php

																					if (!array_key_exists('site_title', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>
															<label class="control-label" for="radiobtns">DB Name</label>
															<input class="span4 form-control" id="db_name" name="db_name" type="text" value="<?php echo $db->setVal("db_name", $user_distributor); ?>">
														</div>
														<div class="col-md-6" <?php
																					if (!array_key_exists('admin_email', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>
															<label class="control-label" for="radiobtns">Admin Email</label>
															<input class="span4 form-control" id="admin_email" name="admin_email" type="text" value="<?php echo $db->setVal("admin_email", $user_distributor); ?>">
														</div>
														<div class="col-md-6" <?php
																					if (!array_key_exists('time_zone', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?>>

															<label class="control-label" for="radiobtns">Time Zone</label>
															<select class="span4 form-control" id="db_time_zone" name="db_time_zone">
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
														<div class="col-md-6" <?php
																					if (!array_key_exists('db_url', $tab1_field_ar) && $system_package != 'N/A') {
																						echo ' style="display:none";';
																					}
																					?> style="margin-bottom: 0px !important;">

															<label class="control-label" for="radiobtns">DB URL</label>
															<input class="span4 form-control" id="db_url" name="db_url" type="text" value="<?php echo $db->setVal("db_url", $user_distributor); ?>">
														</div>
														<div class="col-md-12">
															<button disabled type="submit" id="central_db_submit" name="submit" class="btn btn-primary">Save</button>
															<img id="system_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
														</div>
														<script>
															function edit_profilefn() {
																$("#central_db_submit").prop('disabled', false);
															}
														</script>
													</form>
												</div>
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
			$("#central_db_submit").easyconfirm({
				locale: {
					title: 'Central DB Configuration',
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
					selector: '#central_db_submit',
					disabled: 'disabled'
				},
				fields: {
					db_name: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					master_email: {
						validators: {
							<?php echo $db->validateField('master_email1'); ?>
						}
					},
					db_url: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
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