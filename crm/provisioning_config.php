<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<?php
session_start();

include 'header_top.php';

/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_WARNING);

/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

require_once 'classes/systemPackageClass.php';
$package_function = new package_functions();

require_once 'classes/CommonFunctions.php';
$url_mod_override = $db->setVal('url_mod_override', 'ADMIN');

require_once 'includes/provisioning/provisioning.php';
$provisioning = new provisioning();
?>



<head>
	<meta charset="utf-8">
	<title>Provisioning Configuration</title>

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


	<script src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<!-- tool tip js -->
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>




	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesawNew.js"></script>
	<!-- <script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script> -->



	<?php

	include 'header.php';
	// TAB Organization
	if (isset($_GET['t'])) {

		$variable_tab = 'tab' . $_GET['t'];
		$$variable_tab = 'set';
	} else {
		$tab1 = "set";
	}
	$base_url = $db->setVal('global_url', 'ADMIN');
	$internal_url = $db->setVal('camp_base_url', 'ADMIN');
	if ($user_type == 'MNO') {
		$mno_id = $user_distributor;
		$mno_package = $system_package;
	} else if ($user_type == 'MVNO_ADMIN') {
		$sql = "SELECT mno_id FROM `mno_distributor_parent` WHERE `parent_id` = '$user_distributor'";
		$c = $db->select1DB($sql);
		//$c = mysql_fetch_array($cntR);
		$mno_id = $c['mno_id'];

		//$mno_id=$mno_id;
		$mno_package = $package_function->getDistributorMONPackage($user_name);
	} else {
		$mno_id = $mno_id;
		$mno_package = $package_function->getDistributorMONPackage($user_name);
	}



	include 'includes/provisioning/submit.php';
	include 'includes/provisioning/edit.php';
	include 'includes/provisioning/update.php';
	include 'includes/provisioning/delete.php';


	//Form Refreshing avoid secret key/////
	$secret = md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;




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
								<h3>Payment Gateway</h3>
							</div>
							<!-- /widget-header -->

							<div class="widget-content">



								<div class="tabbable">
									<ul class="nav nav-tabs newTabs">

										<li <?php if (isset($tab1)) { ?>class="active" <?php } ?>><a href="#provisioning_config" data-toggle="tab">Provisioning Config</a></li>



									</ul>

									<br>

									<div class="tab-content">

										<?php
										if (isset($_SESSION['msg1'])) {
											echo $_SESSION['msg1'];
											unset($_SESSION['msg1']);
										}

										?>

										<!-- /* +++++++++++++++++++++++++++++++++++++ Payment Activity +++++++++++++++++++++++++++++++++++++ */ -->
										<div <?php if (isset($tab1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="provisioning_config">
											<div class="support_head_visible" style="display:none;">
												<div class="header_hr"></div>
												<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
													Provisioning Config</div>
												<br class="hide-sm"><br class="hide-sm">
												<div class="header_f2" style="width: 100%;"> </div>
											</div>

											<br>
											<form id="provisioning_config_form" name="provisioning_config_form" method="post" class="form-horizontal bv-form" action="?t=1" novalidate="novalidate">
												<fieldset>


													<?php
													echo '<input type="hidden" name="provisioning_form_secret" id="provisioning_form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>



													<div class="control-group">
														<label class="control-label" for="service_type">Service Type</label>
														<div class="controls form-group">
															<input class="span4 form-control" id="service_type" name="service_type" value="<?php echo $edit_service_type; ?>" type="text">
														</div>
													</div>


													<?php
													$parent_package = $package_functions->getOptions('MVNO_ADMIN_PRODUCT', $system_package);
													$parent_package_array = explode(',', $parent_package);
													$js_array = array();


													foreach ($parent_package_array as $value) {


														$location_package_ar = explode(',', $package_functions->getOptions('LOCATION_PACKAGE', $value));
														$produts = "'" . implode("','", $location_package_ar) . "'";
														$get_types_q = "SELECT p.`product_name`,p.`product_code`,c.options FROM `admin_product` p LEFT JOIN admin_product_controls c
                                        ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                    WHERE `is_enable`='1' AND p.user_type='VENUE' AND p.product_code IN( $produts)";
														//"SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
														$get_types_r = $db->selectDB($get_types_q);

														$location_detail_ar = array();
														foreach ($get_types_r['data'] as $get_types) {
															array_push($location_detail_ar, array("code" => $get_types['product_code'], "name" => $get_types['product_name'], "vt" => $get_types['options']));
														}

														$js_array[$value] = $location_detail_ar;
													}


													if (count($parent_package_array) > 1) {

													?>

														<div class="control-group">
															<div class="controls col-lg-5 form-group">
																<label for="parent_package_type">Admin Type</label>

																<?php
																echo '<select class="span4 form-control" id="parent_package_type" name="parent_package_type">';
																echo '<option value="">Select Business ID type</option>';

																foreach ($parent_package_array as $value) {
																	$parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
																	if ($edit_parent_package == $value) {
																		echo '<option selected value="' . $value . '">' . $parent_package_name . '</option>';
																	} else {
																		echo '<option value="' . $value . '">' . $parent_package_name . '</option>';
																	}
																}
																echo '</select>';
																?>
															</div>
														</div>

													<?php } else {

														echo '<div class="control-group" style="display: none">
																			<div class="controls col-lg-5 form-group">
																		<input class="span4 form-control"  id="parent_package_type" name="parent_package_type" type="hidden" value="' . $parent_package_array[0] . '">
																		</div>
																		 </div>
																		';
													}

													?>

													<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label for="customer_type">Account Type</label>
															<select name="customer_type" id="customer_type" class="span4 form-control">
																<option value="">Select Type</option>
																<?php

																if (isset($edit_parent_package) && !empty($js_array[$edit_parent_package])) {
																	$produts = $js_array[$edit_parent_package];
																	foreach ($produts as $value) {

																		if ($edit_distributor_system_package == $value['code']) {
																?>
																			<option selected value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
																		<?php
																		}
																	}
																} elseif (count($js_array) == 1) {
																	foreach ($js_array as $adminValue) {

																		foreach ($adminValue as $value) {
																		?>
																			<option value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
																<?php
																		}
																	}
																}

																?>
															</select>

														</div>
													</div>

													<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label for="ap_conroller">AP Controller</label>
															<select name="ap_conroller" id="ap_conroller" class="span4 form-control con_c" required>
																<option value="">Select AP Controller</option>
																<?php
																$q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='AP'";

																$query_results = $db->selectDB($q1);

																foreach ($query_results['data'] as $row) {

																	//$mnoid=$row[mno_id];
																	$apc = $row['ap_controller'];

																	$ap_controller = preg_replace('/\s+/', '', $apc);
																	if ($edit_ap_controller == $apc) {
																		$controller_sel = 'selected';
																	} else {
																		$controller_sel = '';
																	}

																	echo "<option   " . $controller_sel . "  class='" . $ap_controller . "' value='" . $apc . "'>" . $apc . "</option>";
																}
																?>
															</select>

														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->


													<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label for="sw_conroller">SW Controller</label>
															<select name="sw_conroller" id="sw_conroller" class="span4 form-control">
																<option value="">Select SW Controller</option>
																<?php
																$q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='SW'";

																$query_results = $db->selectDB($q1);

																foreach ($query_results['data'] as $row) {

																	//$mnoid=$row[mno_id];
																	$apc = $row['ap_controller'];

																	$ap_controller = preg_replace('/\s+/', '', $apc);
																	if ($edit_sw_controller == $apc) {
																		$controller_sel = 'selected';
																	} else {
																		$controller_sel = '';
																	}

																	echo "<option   " . $controller_sel . "  class='" . $ap_controller . "' value='" . $apc . "'>" . $apc . "</option>";
																}
																?>
															</select>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->



													<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label for="location_name1">Business Vertical</label>
															<?php
															$business_vertical = json_decode($package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package), true); ?>
															<select class="span4 form-control" id="business_type" name="business_type">
																<option value="">Select Business Type</option>
																<?php
																$business_vertical = $package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package);

																if (!empty($business_vertical)) {
																	$vertical_product = true;
																	$business_vertical_array = json_decode($business_vertical, true);

																	$business_vertical_settings = $db->getValueAsf("SELECT setting as f FROM `exp_mno` WHERE mno_id='$user_distributor'");

																	$business_vertical_mno = json_decode($business_vertical_settings, true)['verticals'];

																	if ($business_vertical_array == 0) {

																		$vertical_product = false;
																		$business_vertical_array = explode(',', $business_vertical);

																		if (!empty($business_vertical_mno)) {
																			$business_vertical_array = $business_vertical_mno;
																		}
																	}

																	if (!empty($business_vertical_mno)) {
																		$business_vertical_array_new = array();
																		foreach ($business_vertical_array as $key => $value) {
																			if (in_array($key, $business_vertical_mno)) {
																				$business_vertical_array_new[$key] = $value;
																			}
																		}

																		$business_vertical_array = $business_vertical_array_new;
																	}

																	//set Product names
																	if ($vertical_product) {
																		foreach ($business_vertical_array as $productKey => $productValue) {
																			foreach ($productValue as $productValueKey => $productValueValue) {
																				$name = getProductName($productValueValue, $db);
																				$business_vertical_array[$productKey][$productValueKey] = ["code" => $productValueValue, "name" => $name];
																			}
																		}
																		$business_vertical = json_encode($business_vertical_array);
																	}

																	$bvlength = count($business_vertical_array);
																	$tmpFirstVert = "";
																	$tmpSelected = false;
																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																		if (empty($tmpFirstVert)) {
																			$tmpFirstVert = $bVertical;
																		}
																		if (!$vertical_product) {
																			$bVertical = $bVertDetails;
																		}
																		if ($edit_business_type == $bVertical) {
																			$tmpSelected = true;
																?>
																			<option selected value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																		<?php
																		}
																	}
																	if (!$tmpSelected) {
																		$edit_business_type = $tmpFirstVert;
																	}
																} else {
																	$vertical_product = false;
																	if (empty($edit_business_type)) {
																		$edit_business_type = "Retail";
																	}

																	$get_businesses_q = "SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
																	$get_businesses_r = $db->selectDB($get_businesses_q);

																	foreach ($get_businesses_r['data'] as $get_businesses) {
																		$get_business = $get_businesses['business_type'];
																		if ($edit_business_type == $get_business) {
																		?>
																			<option selected value="<?php echo $get_business; ?>"><?php echo $get_businesses['discription']; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $get_business; ?>"><?php echo $get_businesses['discription']; ?></option>
																<?php
																		}
																	}
																}
																?>
															</select>

														</div>
													</div>

													<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label for="location_name1">Package Type</label>
															<select class="form-control span4" multiple="multiple" id="network_type" name="network_type[]">
																<option value="" disabled="disabled"> Choose Package(s)</option>

																<?php
																$operator_vt_option = $package_functions->getOptions('VTENANT_MODULE', $system_package);
																if ($operator_vt_option == 'Vtenant') {
																?>
																	<option name="network_vtenant_name" <?php if (($edit_network_type == 'VT') || ($edit_network_type == 'VT-BOTH') || ($edit_network_type == 'VT-PRIVATE') || ($edit_network_type == 'VT-GUEST')) {
																											echo 'selected';
																										} else {
																											echo '';
																										} ?> value="VT">vTenant</option>
																<?php } ?>
																<option <?php if (($edit_network_type == 'GUEST') || ($edit_network_type == 'VT-BOTH') || ($edit_network_type == 'BOTH') || ($edit_network_type == 'VT-GUEST')) {
																			echo 'selected';
																		} else {
																			echo '';
																		} ?> value="GUEST">Guest</option>
																<option <?php if (($edit_network_type == 'PRIVATE') || ($edit_network_type == 'VT-BOTH') || ($edit_network_type == 'BOTH') || ($edit_network_type == 'VT-PRIVATE')) {
																			echo 'selected';
																		} else {
																			echo '';
																		} ?> value="PRIVATE">Private</option>
															</select>


														</div>
													</div>


													<div class="control-group">
														<label class="control-label" for="admin_features">Admin Features</label>
														<div class="controls form-group">
															<select onchange="feature_config();" class="form-control span4" multiple="multiple" id="admin_features" name="admin_features[]">
																<option value="" disabled="disabled"> Choose Feature(s)</option>

																<?php

																$fearuresjson = $db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
																$mno_feature = json_decode($fearuresjson);

																$qf = "SELECT `service_id`,`service_name`,`mno_feature`,`feature_json` FROM `exp_service_activation_features`  WHERE `service_type`='MVNO_ADMIN_FEATURES'
                           ORDER BY `service_id`";

																$featureaccess = array();
																$query_resultsf = $db->selectDB($qf);
																foreach ($query_resultsf['data'] as $row) {

																	$feature_code = $row['service_id'];
																	$feature_name = $row['service_name'];
																	$m_features = $row['mno_feature'];
																	$feature_json = $row['feature_json'];

																	if (in_array($m_features, $mno_feature) || (strlen($m_features) < 1)) {
																		$fearurearr = array();
																		$fearurear = json_decode($feature_json, true);
																		$fearurearr[$feature_code] = $fearurear;
																		if ((!$isDynamic && $feature_code != "CAMPAIGN_MODULE") || ($isDynamic)) {
																			if (array_key_exists($feature_code, $edit_admin_features)) {
																				echo "<option selected value='" . $feature_code . "'>" .  $feature_name . "</option>";
																			} else {
																				echo "<option value='" . $feature_code . "'>" .  $feature_name . "</option>";
																			}
																			if (!empty($fearurear)) {
																				array_push($featureaccess, $fearurearr);
																			}
																		}
																	}
																}
																$featureaccess = json_encode($featureaccess);
																?>


															</select>
														</div>
													</div>


													<div id="fearure_dpsk" style="display: none;">
														<div class="control-group">

															<div class="controls col-lg-5 form-group">
																<label for="cld_conroller">CloudPath Controller</label>
																<select name="dpsk_conroller" id="dpsk_conroller" class="span4 form-control" onchange="getdpsk_policies('get_policies')">
																	<option value="">CloudPath Controller</option>
																	<?php
																	$q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='DPSK'";

																	$query_results = $db->selectDB($q1);

																	foreach ($query_results['data'] as $row) {

																		//$mnoid=$row[mno_id];
																		$apc = $row['ap_controller'];

																		$ap_controller = preg_replace('/\s+/', '', $apc);
																		$apc_select = '';
																		if ($apc == $edit_dpsk_controller) {
																			$apc_select = 'selected';
																		}

																		echo "<option  class='" . $ap_controller . "' value='" . $apc . "' " . $apc_select . ">" . $apc . "</option>";
																	}
																	?>
																</select>
															</div>
														</div>

														<div class="control-group">

															<div class="controls col-lg-5 form-group">
																<label for="dpsk_policies">CloudPath Policies</label>
																<select name="dpsk_policies" id="dpsk_policies" class="span4 form-control">
																	<option value="">CloudPath Policies</option>
																	<?php
																	$q1 = "SELECT * FROM `mdu_dpsk_policies` WHERE `controller`= '$edit_dpsk_controller'";

																	$query_results = $db->selectDB($q1);

																	foreach ($query_results['data'] as $row_s) {

																		$dpsk_policies_id = $row_s['dpsk_policies_id'];
																		$dpsk_policiesName = $row_s['dpsk_policiesName'];

																		//echo $edit_dpsk_policies."==".$dpsk_policies_id;
																		if ($edit_dpsk_policies == $dpsk_policies_id) {
																			$controller_sel = 'selected';
																		} else {
																			$controller_sel = '';
																		}

																		echo "<option  " . $controller_sel . " value='" . $dpsk_policies_id . "'>" . $dpsk_policiesName . "</option>";
																	}
																	?>
																</select>
																<a style="display: inline-block; padding: 6px 20px !important;" onclick="getdpsk_policies('sync')" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
																<div style="display: inline-block" id="cloud_policies_loader"></div>

															</div>

															<script type="text/javascript">
																function getdpsk_policies(get_type) {

																	ctrl_name = document.getElementById("dpsk_conroller").value;

																	var a = ctrl_name.length;

																	if (a == 0) {

																		alert('Please select a DPSK controller before refresh!');

																	} else {
																		document.getElementById("cloud_policies_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
																		$.ajax({
																			type: 'POST',
																			url: 'ajax/getdpsk_policies.php',
																			data: {
																				ctrl_name: ctrl_name,
																				get_type: get_type,
																				mno: "<?php echo $user_distributor; ?>"
																			},
																			success: function(data) {



																				$("#dpsk_policies").empty(data);
																				$("#dpsk_policies").append(data);



																				document.getElementById("cloud_policies_loader").innerHTML = "";

																			},
																			error: function() {
																				document.getElementById("cloud_policies_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
																			}

																		});

																	}

																}
															</script>

														</div>
													</div>

													<div id="vt_voucher_div"></div>
													<br>
													<div id="fearure_ar"></div>


													<div class="control-group ">
														<label class="control-label" for="location_name1">Advanced Features</label>
														<div class="controls col-lg-5 form-group">

															<select class="form-control span4" multiple="multiple" id="advanced_features" name="advanced_features[]">
																<option value="" disabled="disabled"> Choose Feature(s)</option>

																<?php
																?>
																<option <?php if ($edit_advanced_features['802.2x_authentication'] == '1') {
																			echo 'selected';
																		} else {
																			echo '';
																		} ?> value="802.2x_authentication">802.1X Authentication</option>

																<?php
																$extra = json_decode($package_functions->getOptions('EXTRA_ADVANCED_FEATURES', $system_package), true);
																foreach ($extra as $extra_key => $extra_val) {
																	$selected = $edit_advanced_features[$extra_key] == '1' ? 'selected' : '';
																	echo '<option value="' . $extra_key . '" ' . $selected . ' >' . $extra_val . '</option>';
																}
																?>
															</select>


														</div>
													</div>


													<div class="control-group" id="gu_geteway_div" style="display: none;">
														<div class="controls col-lg-5 form-group">
															<label for="gateway_type">Guest Gateway Type</label>

															<select class="span4 form-control" id="gateway_type" name="gateway_type" onchange="guest_gateway_type(this.value);">

																<option value="">Select Gateway Type</option>
																<?php


																$get_gatw_type_q = "select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
																$get_gatw_type_r = $db->selectDB($get_gatw_type_q);

																foreach ($get_gatw_type_r['data'] as $gatw_row) {
																	$gatw_row_gtw = $gatw_row['gateway_name'];
																	$gatw_row_dis = $gatw_row['description'];
																?>
																	<option <?php $edit_gateway_type == $gatw_row_gtw ? print(" selected ") : print(""); ?> value="<?php echo $gatw_row_gtw; ?>"> <?php echo $gatw_row_dis; ?> </option>;

																<?php } ?>
															</select>


														</div>
													</div>

													<div class="control-group" id="pr_geteway_div" style="display: none;">
														<div class="controls col-lg-5 form-group">
															<label for="pr_gateway_type">Private Gateway Type</label>

															<select class="span4 form-control" id="pr_gateway_type" name="pr_gateway_type">

																<option value="">Select Gateway Type</option>
																<?php
																if (empty($edit_distributor_pr_gateway_type)) {
																	$edit_distributor_pr_gateway_type = "VSZ";
																}

																$get_gatw_type_q = "select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
																$get_gatw_type_r = $db->selectDB($get_gatw_type_q);

																foreach ($get_gatw_type_r['data'] as $gatw_row) {
																	$gatw_row_gtw = $gatw_row['gateway_name'];
																	$gatw_row_dis = $gatw_row['description'];
																?>
																	<option <?php $edit_pr_gateway_type == $gatw_row_gtw ? print(" selected ") : print(""); ?> value="<?php echo $gatw_row_gtw ?>"><?php echo $gatw_row_dis ?></option>
																<?php  }

																?>

															</select>


														</div>
													</div>

													<div class="control-group" id="gateway_div">
														<label class="control-label" for="wag_profile">WAG</label>
														<div class="controls col-lg-5 form-group">
															<select class="span4 form-control" id="wag_profile" name="wag_profile" style="display: inline-block">
																<?php echo '<option value="">Select Option</option>';

																if ($edit_wag_profile) {

																	$sel_ap = "AND  w.`ap_controller`='$edit_ap_controller'";
																} else {

																	$sel_ap = '';
																}

																$get_wags_per_controller = "SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                                                      WHERE w.`ap_controller`=c.`ap_controller` " . $sel_ap . " AND c.`mno_id`='$user_distributor' GROUP BY w.`wag_code`";

																$get_wags_per_controller_r = $db->selectDB($get_wags_per_controller);

																foreach ($get_wags_per_controller_r['data'] as $get_wags_per_controller_d) {
																	if ($edit_wag_profile == $get_wags_per_controller_d['wag_code']) {
																		$wag_select = "selected";
																	} else {
																		$wag_select = '';
																	}
																	echo '<option ' . $wag_select . ' value="' . $get_wags_per_controller_d['wag_code'] . '">' . $get_wags_per_controller_d['wag_name'] . '</option>';
																}
																?>
															</select>
														</div>
													</div>



													<div class="control-group" id="content_filter_div">
														<label class="control-label" for="optona feature content filtering">Content Filtering</label>
														<div class="controls col-lg-5 form-group">
															<select name="dns_profile" id="dns_profile" class="span4 form-control">
																<?php echo '<option value="">Select Option</option>';

																if ($edit_dns_profile) {
																	$sel_ap = "AND  w.`controller`='$edit_ap_controller'";
																} else {
																	$sel_ap = '';
																}

																$get_wags_per_controller = "SELECT w.`profile_code`,w.`name` FROM `exp_controller_dns` w , `exp_mno_ap_controller` c
                                                                                                                    WHERE w.`controller`=c.`ap_controller` " . $sel_ap . " AND c.`mno_id`='$user_distributor' GROUP BY w.`profile_code`";

																$get_wags_per_controller_r = $db->selectDB($get_wags_per_controller);

																foreach ($get_wags_per_controller_r['data'] as $get_wags_per_controller_d) {
																	if ($edit_dns_profile == $get_wags_per_controller_d['profile_code']) {
																		$wag_select = "selected";
																	} else {
																		$wag_select = '';
																	}
																	echo '<option ' . $wag_select . ' value="' . $get_wags_per_controller_d['profile_code'] . '">' . $get_wags_per_controller_d['name'] . '</option>';
																}
																?>
															</select>


														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->

													<div class="form-actions" style="margin: 0;">
														<?php if ($edid_service) {

															echo '<input type="hidden" name="edit_service_id" id="edit_service_id" value="' . $edit_service_id . '" />';

														?>
															<button type="submit" name="provisioning_update" id="provisioning_update" class="btn btn-primary">Save</button>

														<?php } else { ?>

															<button type="submit" name="provisioning_submit" id="provisioning_submit" class="btn btn-primary">Save</button>
														<?php } ?>
														<button type="button" class="btn btn-info inline-btn" onclick="gopto();" style="display: inline-block !important;margin-top: 0 !important;">Cancel</button>
													</div>

												</fieldset>
											</form>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3>Provisioning Activity</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;">
														<table id="provisioning_search_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Service Type</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Delete</th>
																</tr>
															</thead>
															<tbody>

																<?php

																?>





															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
										</div>

										<script type="text/javascript">
											$(document).ready(function() {
												$('#provisioning_search_table').DataTable({
													data: <?php echo json_encode($provisioning->getTable($secret, $mno_id));
															?>
												});


											});
										</script>


										<!-- /* +++++++++++++++++++++++++++++++++++++ end tab body +++++++++++++++++++++++++++++++++++++ */ -->



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


	<!-- datatables js -->

	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>

	<script type="text/javascript" src="js/bootstrapValidator.js"></script>
	<script type="text/javascript" src="js/bootstrapValidator_new.js?v=1"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			//create Product form validation



			$('#provisioning_config_form').bootstrapValidator({
				framework: 'bootstrap',
				excluded: ':disabled',
				feedbackIcons: {
					valid: 'glyphicon glyphicon-ok',
					invalid: 'glyphicon glyphicon-remove',
					validating: 'glyphicon glyphicon-refresh'
				},
				fields: {
					service_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php echo $db->validateField('not_require_special_character'); ?>
						}
					},
					parent_package_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					customer_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					ap_conroller: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},

					// gateway_type: {
					// 	validators: {
					// 		<?php //echo $db->validateField('notEmpty'); 
								?>
					// 	}
					// },
					// pr_gateway_type: {
					// 	validators: {
					// 		<?php //echo $db->validateField('notEmpty'); 
								?>
					// 	}
					// },

					business_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			});


		});
	</script>


	<?php
	include 'footer.php';
	?>

	<script src="js/base.js"></script>

	<!-- Alert messages js-->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>


	<script type="text/javascript">
		function guest_gateway_type(type) {

			if (type == 'VSZ') {
				$("#gateway_div").hide();
				$("#content_filter_div").show();
			} else if (type == 'WAG') {
				$("#gateway_div").show();
				$("#content_filter_div").hide();
			} else {
				$("#gateway_div").hide();
				$("#content_filter_div").hide();
			}
		}

		function feature_config() {


			var admin_features_val = $('#admin_features').val();
			var edit_admin_features = '<?php echo json_encode($edit_admin_features) ?>';
			var features_arr = '<?php echo $featureaccess ?>';
			var array_new = JSON.parse(features_arr);
			var edit_admin_feature = JSON.parse(edit_admin_features);
			var result = '';
			var resultnew = '';
			var dpsk = 'DPSK';

			//console.log(array_new);

			//console.log(admin_features_val);
			//$('#vt_voucher_div').html('');
			$('#vt_voucher_div').empty();
			$("#fearure_dpsk").css("display", "none");

			for (var key in admin_features_val) {

				if (admin_features_val[key] == 'VOUCHER') {

					$singaleCleick = "";
					$sharedCleick = "checked";

					if (edit_admin_feature) {
						edit_vouche_type = edit_admin_feature['VOUCHER']['value'];
						if (edit_vouche_type == 'SINGLEUSE') {
							$singaleCleick = "checked";
							$sharedCleick = "";
						}
					}

					resultnew = '<div class="controls col-lg-5 form-group"><label for="dpsk_voucher">Resident Account Creation Voucher <i  title="All tenants will need a voucher to enable them to create an account. depending on level of security you can select from two options: <br> 1.Shared voucher means all tenant use the same voucher code for account creation  <br>                    2.Single-use voucher means each tenant gets a unique one time voucher for account creation " class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" ' + $sharedCleick + ' name="dpsk_voucher" value="SHARED"><label style="display :inline-block;min-width: 20%; max-width: 100%;">Shared</label><input type="radio" ' + $singaleCleick + ' name="dpsk_voucher" value="SINGLEUSE"><label style="display :inline-block;">Single Use</label></div>';


					$('#vt_voucher_div').html(resultnew);
					$('.tooltips').tooltipster({
						contentAsHTML: true,
						maxWidth: 350

					});
				}
				if (admin_features_val[key] == 'CLOUD_PATH_DPSK') {
					$("#fearure_dpsk").css("display", "block");
				}
			}

			for (var i = 0; i < array_new.length; i++) {
				//array_new[i];
				//console.log(admin_features_val);

				for (var key in array_new[i]) {
					if (admin_features_val) {
						var a = admin_features_val.indexOf(key);
					}
					//console.log(a);

					if (edit_admin_feature) {
						//console.log("a");
						try {
							var b = edit_admin_feature[key]['value'];
						} catch (error) {

						}
					}
					// console.log(edit_admin_feature[key]);
					// console.log(edit_admin_feature[key]['value']);
					if (a > -1) {

						var value = array_new[i][key];
						var type = value['type'];
						var name = value['id'];
						var label = value['label'];
						var check1 = value['value']['operator'];
						var check2 = value['value']['parent'];

						var checked = check1['selected'];
						var label_n = check1['label'];
						var enable = check1['enable'];
						var checkedp = check2['selected'];
						var label_np = check2['label'];
						var enablep = check2['enable'];

						//	result += '<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">' + label + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checked + ' value="' + enable + '"><label for="cr_feature_' + type + '" style="display :inline-block;min-width: 20%; max-width: 100%;">' + label_n + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checkedp + ' value="' + enablep + '"><label style="display :inline-block;">' + label_np + '</label></div></div>';
						if (b == 2) {
							result += '<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">' + label + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checkedp + ' value="' + enable + '"><label for="ed_pr_fe_' + type + '" style="display :inline-block; min-width: 20%; max-width: 100%;">' + label_n + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checked + ' value="' + enablep + '"><label style="display :inline-block;">' + label_np + '</label></div></div>';
						} else {
							result += '<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">' + label + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checked + ' value="' + enable + '"><label for="ed_pr_fe_' + type + '" style="display :inline-block; min-width: 20%; max-width: 100%;">' + label_n + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checkedp + ' value="' + enablep + '"><label style="display :inline-block;">' + label_np + '</label></div></div>';
						}


					}
				}


			}
			$('#fearure_ar').empty();

			$('#fearure_ar').html(result);
			// $('#device_arr').html(resultsn);
		}

		function getway_ctr() {
			try {
				$("#pr_geteway_div").css("display", "none");
				$("#gu_geteway_div").css("display", "none");

				var values = $('#network_type').val()

				if (values.includes("GUEST")) {
					$("#gu_geteway_div").css("display", "block");
				}
				if (values.includes("PRIVATE")) {
					$("#pr_geteway_div").css("display", "block");
				}

			} catch (error) {

			}

		}

		$("#network_type").change(function() {
			getway_ctr();
		});
	</script>

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


	<script type="text/javascript" src="js/dataTables.buttons.min.js"></script>

	<script src="js/jquery.multi-select.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>


	<script id="tootip_script">
		$(document).ready(function() {

			<?php
			if ($edid_service) { ?>
				feature_config();
				guest_gateway_type('<?php echo $edit_gateway_type; ?>');
				getway_ctr();
			<?php	} else {
			?>
				guest_gateway_type('hide');
			<?php
			}
			?>


			$("#provisioning_submit").easyconfirm({
				locale: {
					title: 'New Service Type',
					text: 'Are you sure you want to Create this Service Type?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#provisioning_submit").click(function() {});

			$("#provisioning_update").easyconfirm({
				locale: {
					title: 'Update Service Type',
					text: 'Are you sure you want to update this Service Type?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#provisioning_update").click(function() {});

			$('[data-toggle="tooltip"]').tooltip();
		});


		$('#admin_features').multiSelect({
			cssClass: "mini"
		});
		$('#network_type').multiSelect({
			cssClass: "mini"
		});
		$('#advanced_features').multiSelect({
			cssClass: "mini"
		});

		function gopto(url) {
			window.location = "?";
		}
	</script>

	</body>

</html>