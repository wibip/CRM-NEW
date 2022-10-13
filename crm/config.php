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
//error_reporting(E_ALL & E_NOTICE & E_WARNING);
/*classes & libraries*/

require_once 'classes/dbClass.php';
require_once 'classes/systemPackageClass.php';
require_once 'classes/CommonFunctions.php';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

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

	<title>Configuration</title>



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

	<script type="text/javascript">
		$(document).ready(function() {


			$("#create_product_submit").easyconfirm({
				locale: {
					title: 'Private QoS Profile',
					text: 'Are you sure you want to create this profile?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#create_product_submit").click(function() {});

			$("#default_product_submit").easyconfirm({
				locale: {
					title: 'Update Default Products',
					text: 'Are you sure you want to Update this?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#default_product_submit").click(function() {});


			$("#duration_product_submit").easyconfirm({
				locale: {
					title: 'Duration Profile',
					text: 'Are you sure you want to create this profile?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#duration_product_submit").click(function() {});

			$("#duration_product_cancel").easyconfirm({
				locale: {
					title: 'Cancel Profile Edit',
					text: 'Are you sure you want to cancel this edit?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#duration_product_cancel").click(function() {
				window.location = "?t=2";
			});

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


	<script type="text/javascript">
		$(document).ready(function() {
			$("#create_product_submit_guest").easyconfirm({
				locale: {
					title: 'Guest QoS Profile',
					text: 'Are you sure you want to create this profile?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#create_product_submit_guest").click(function() {});

			$("#assign_product_submit_guest").easyconfirm({
				locale: {
					title: 'Product Assign',
					text: 'Are you sure you want to assign this Product?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#assign_product_submit_guest").click(function() {});

			$("#footer_submit").easyconfirm({
				locale: {
					title: 'FAQ',
					text: 'Are you sure you want to update FAQ URL?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#footer_submit").click(function() {});


			$("#server_link_submit").easyconfirm({
				locale: {
					title: 'Survey Link',
					text: 'Are you sure you want to update Survey Link URL?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#server_link_submit").click(function() {});

			$("#user_guide_submit").easyconfirm({
				locale: {
					title: 'User Guide',
					text: 'Are you sure you want to update User Guide URL?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#user_guide_submit").click(function() {});



		});
	</script>
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

	$camp_base_url = $db->setVal('camp_base_url', 'ADMIN');
	$post_data = array(
		'sync_type' => 'qos_new_sync',
		'user_distributor' => $user_distributor,
		'system_package'   => $system_package,
		'user_name'   => $user_name
	);

	$post_datanew = array(
		'sync_type' => 'product_ale5',
		'user_distributor' => $user_distributor,
		'system_package'   => $system_package,
		'user_name'   => $user_name
	);



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
		} elseif ($user_type == 'RESELLER_ADMIN') {

			$tab21 = "set";
		} elseif ($user_type == 'MVNO_ADMIN') {
			$tab0 = "set";
			unset($tab1);
		} else {
			if (($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE', $system_package) == "1") && ($user_type != 'MNO')) {
				$tab11 = "set";
			} else {
				if (!(in_array("CONFIG_PROFILE", $features_array)) && !(in_array("CONFIG_DURATION", $features_array))) {
					$tab0 = "set";
					unset($tab1);
				} else {

					$tab1 = "set";
				}
			}
		}
	}





	//echo $variable_tab;

	$base_portal_folder = trim($db->setVal('portal_base_folder', 'ADMIN'), "/");


	$base_url = trim($db->setVal('portal_base_url', 'ADMIN'), "/");

	$sf_apidata = json_decode($db->setVal('snapforce', $user_distributor), true);

	if (empty($sf_apidata)) {
		$sf_apidata = json_decode($db->setVal('snapforce', 'ADMIN'), true);
	}
	$sf_api_url = $sf_apidata['API_URL'];
	$sf_api_code = $sf_apidata['API_PRODUCT'];



	if (isset($_POST['sf_api_submit'])) {
		$sf_api_url = $db->escapeDB($_POST['sf_api_url']);
		$sf_api_code = $db->escapeDB($_POST['sf_api_code']);
		$serttingarr = array(
			'API_URL' => $sf_api_url,
			'API_PRODUCT' => $sf_api_code
		);
		$setting_val = json_encode($serttingarr);

		$query0 = "REPLACE INTO exp_settings (settings_name,description,category,settings_code,settings_value,distributor,create_date,create_user)
    values ('Snapforce Api Config','Snapforce Api Config','SYSTEM','snapforce','$setting_val','$user_distributor',now(),'$user_name')";

		$ex0 = $db->execDB($query0);
		if ($ex0 === true) {

			$create_log->save('3001', $message_functions->showMessage('config_bl_email_update_success'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_bl_email_update_success') . "</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - ' . $script);
			$create_log->save('2001', $message_functions->showMessage('config_bl_email_update_failed', '2001'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_bl_email_update_failed', '2001') . "</strong></div>";
		}
	}

	if (isset($_POST['blacklist_email_submit'])) {

		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			$blacklist_email = $db->escapeDB($_POST['blacklist_email']);
			$title = $db->escapeDB($_POST['black_head']);
			$dist = $user_distributor;
			$qry = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('BLACKLIST_CONTENT','$title','$blacklist_email','$dist',now(),'$user_name')";
			//$ex = mysql_query($qry);
			$ex = $db->execDB($qry);
			if ($ex === true) {

				$create_log->save('3001', $message_functions->showMessage('config_bl_email_update_success'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_bl_email_update_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$create_log->save('2001', $message_functions->showMessage('config_bl_email_update_failed', '2001'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_bl_email_update_failed', '2001') . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}




	if (isset($_POST['faq_submit'])) {
		if ($_POST['faq_submit_secret'] == $_SESSION['FORM_SECRET']) {

			$faq_title = $db->escapeDB($_POST['faq_title']);
			$faq_content = $db->escapeDB($_POST['faq_content']);
			$faq_order = $db->escapeDB($_POST['faq_order']);

			$faqClassFun = new faq_functions();
			$faqClassFun->setNewFaq($faq_title, $faq_content, $user_distributor, $faq_order, $user_name);
			if ($faqClassFun->createFaq()) {
				$msg30text = $message_functions->showMessage('faq_creation_success');
				$create_log->save('3001', $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			} else {
				$msg30text = $message_functions->showMessage('faq_creation_fail', '2001');
				$create_log->save('2001', $msg30text, $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			}
		} else {
			$msg30text = $message_functions->showMessage('transection_fail', '2004');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $msg30text, 'faq_submit');
			$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
		}
	}

	if (isset($_GET['edit_faq_code'])) {
		if ($_GET['faqsecret'] == $_SESSION['FORM_SECRET']) {
			$edit_faq_code = $_GET['edit_faq_code'];
			$faqEditFunc = new faq_functions();
			$edit_faq_details = $faqEditFunc->getFaqFromUniCode($edit_faq_code, $user_distributor);
			$edit_faq = 1;
		} else {
			$msg30text = $message_functions->showMessage('transection_fail', '2004');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $msg30text, 'faq_edit');
			$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
		}
	}

	if (isset($_POST['faq_update'])) {
		if ($_POST['faq_submit_secret'] == $_SESSION['FORM_SECRET']) {

			$faq_update_code = $db->escapeDB($_POST['faq_update_code']);
			$faq_title = $db->escapeDB($_POST['faq_title']);
			$faq_content = $db->escapeDB($_POST['faq_content']);
			$faq_order = $db->escapeDB($_POST['faq_order']);

			$faqUpdateFun = new faq_functions();
			//    ->faqUpdate($unique_id,$distributor,$title,$content,$order)
			$faq_update = $faqUpdateFun->faqUpdate($faq_update_code, $user_distributor, $faq_title, $faq_content, $faq_order);

			if ($faq_update) {
				$msg30text = $message_functions->showMessage('faq_update_success');
				$create_log->save('3001', $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			} else {
				$msg30text = $message_functions->showMessage('faq_update_fail', '2002');
				$create_log->save('2002', $msg30text, $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			}
		} else {
			$msg30text = $message_functions->showMessage('transection_fail', '2004');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $msg30text, 'faq_submit');
			$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
		}
	}


	if (isset($_GET['delete_faq_code'])) {
		if ($_GET['faqsecret'] == $_SESSION['FORM_SECRET']) {
			$delete_faq_code = $_GET['delete_faq_code'];
			$faqDeleteFunc = new faq_functions();
			$delete_faq = $faqDeleteFunc->deleteFaqFromUniCode($delete_faq_code, $user_distributor);

			if ($delete_faq) {
				$msg30text = $message_functions->showMessage('faq_delete_success');
				$create_log->save('3001', $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			} else {
				$msg30text = $message_functions->showMessage('faq_delete_fail', '2002');
				$create_log->save('2002', $msg30text, $msg30text, $faq_title . ',' . $faq_content . ',' . $user_distributor . ',' . $faq_order . ',' . $user_name);
				$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
			}
		} else {
			$msg30text = $message_functions->showMessage('transection_fail', '2004');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $msg30text, 'faq_edit');
			$_SESSION['msg30'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
		}
	}


	if ($package_functions->getSectionType('VERTICAL_BUSINESS_TYPES', $system_package) == 'ON') {

		$isdynamic = $package_functions->isDynamic($system_package);
		if ($isdynamic) {
			$opt_st = $package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package);
			$opt = explode(',', $opt_st);
		} else {
			$opt = json_decode($package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package));
		}
	}


	if (isset($_POST['property_update'])) {
		if ($_POST['property_secret'] == $_SESSION['FORM_SECRET']) {

			$queryString = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";
			$queryResult = $db->selectDB($queryString);
			if ($queryResult['rowCount'] > 0) {
				foreach ($queryResult['data'] as $row) {
					$settingArr = json_decode($row['setting'], true);
				}
			}

			$settingArr['headerImage'] = $_POST['headerImg'];
			$setting_val = [];
			$enable_verticle = array();
			if ($opt) {
				$set_i = 0;
				if ($isdynamic) {
					foreach ($opt as $set_val) {

						if ($_POST['sup_num_en_' . $set_val] == 'on') {
							array_push($enable_verticle, $set_val);
						}
						$setting_val[$set_val] = $_POST['sup_num_'][$set_i];

						$set_i++;
					}
				} else {
					foreach ($opt as $set_key => $set_val) {

						if ($_POST['sup_num_en_' . $set_key] == 'on') {
							array_push($enable_verticle, $set_key);
						}
						$setting_val[$set_key] = $_POST['sup_num_'][$set_i];

						$set_i++;
					}
				}
			}
			$settingArr['verticals'] = $enable_verticle;
			$setting_val_json = json_encode($setting_val);

			$setting = json_encode($settingArr);

			$q = "UPDATE `exp_mno` SET setting='$setting' WHERE mno_id='$user_distributor'";
			$q2 = "REPLACE INTO exp_settings (settings_name, description, category, settings_code, settings_value, distributor, create_date, create_user)
VALUES ('support number','MNO verticel support number','SYSTEM','VERTICAL_SUPPORT_NUM','$setting_val_json','$user_distributor',NOW(),'$user_name')";
			//$e = mysql_query($q);
			$e = $db->execDB($q);
			$e2 = $db->execDB($q2);

			if ($e === true && $e2 === true) {
				$show_msg = $message_functions->showMessage('config_operation_success');
				$create_log->save('3002', $show_msg, "");
				$_SESSION['system1_msg'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $show_msg . '</strong></div>';
			} else {
				$show_msg = $message_functions->showMessage('config_operation_failed', '2002');
				$create_log->save('2002', $show_msg, "");
				$_SESSION['system1_msg'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>' . $show_msg . '</strong></div>';
			}
		} else {
			$msg30text = $message_functions->showMessage('transection_fail', '2004');
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$create_log->save('2004', $msg30text, 'faq_edit');
			$_SESSION['msgy'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg30text . "</strong></div>";
		}
	}

	if ($opt) {
		$queryStringm = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";
		$settingarrnew = $db->selectDB($queryStringm);
		if ($settingarrnew['rowCount'] > 0) {
			foreach ($settingarrnew['data'] as $row) {
				$settingArrn = json_decode($row['setting'], true);
			}
		}
		$enable_verticlearr = $settingArrn['verticals'];
	}

	if (isset($_POST['default_product_submit'])) {

		$product_list = $_POST['default_product'];

		$q_result = $db->selectDB("SELECT `product_id` FROM `exp_products`  WHERE `mno_id`='$user_distributor' AND  `network_type`= 'GUEST' AND `default_product` = '1'");
		foreach ($q_result['data'] as $valuen) {
			$product_id = $valuen['product_id'];
			if (!in_array($product_id, $product_list)) {
				$query0 = "UPDATE
				`exp_products`
				SET
				`default_product` = '0'
				WHERE `product_id` = '$product_id'";
				$ex0 = $db->execDB($query0);
			}
		}
		foreach ($product_list as $value) {
			$query0 = "UPDATE
			`exp_products`
			SET
			`default_product` = '1'
			WHERE `product_id` = '$value'";
			$ex0 = $db->execDB($query0);
		}

		if ($ex0 === true) {
			$create_log->save('3001', $message_functions->showMessage('product_defualt_update_success'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_product_success') . "</strong></div>";
		} else {
			$create_log->save('2001', $message_functions->showMessage('product_defualt_update_success', '2001'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_product_failed', '2001') . "</strong></div>";
		}
	}


	if (isset($_POST['create_product_submit'])) {

		//$product_code = trim($_POST['product_code1']).','.trim($_POST['product_code2']).','.trim($_POST['product_code3']);

		//$product_code = trim($_POST['product_code1']);
		$description = trim($_POST['description']);
		$description_up = trim($_POST['description_up']);
		$product_name = trim($_POST['product_name']);
		$product_id = uniqid();

		$num1 = trim($_POST['sesson_du_select1']);
		$num2 = trim($_POST['sesson_du_select3']);
		$select1 = trim($_POST['sesson_du_select2']);
		$select2 = trim($_POST['sesson_du_select4']);

		$tm_gap = '';
		if ($num1 != 0 && $num2 != 0) {
			$tm_gap = 'P' . $num1 . $select1 . $num2 . $select2;
		} else if ($num1 == 0 && $num2 == 0) {
			$tm_gap = '';
		} else if ($num2 == 0) {
			$tm_gap = 'P' . $num1 . $select1;
		} else if ($num1 == 0) {
			$tm_gap = 'P' . $num2 . $select2;
		}
		$purg_time = $_POST['Purge_delay_time'];

		/////////////////


		if (isset($_POST['pvt_package_edit'])) {


			//archive
			$db->execDB("INSERT INTO `exp_products_archive`
				(`id`,
				`api_id`,
				`product_id`,
				`product_name`,
				`product_code`,
				`QOS`,
				`QOS_up_link`,
				`network_type`,
				`time_gap`,
				`max_session`,
				`session_alert`,
				`purge_time`,
				`mno_id`,
				`default_value`,
				`create_date`,
				`create_user`,
				`last_update`,
				`archive_by`,
				`archive_date`,
				`ar_status`
				)
				SELECT
				`id`,
				`api_id`,
				`product_id`,
				`product_name`,
				`product_code`,
				`QOS`,
				`QOS_up_link`,
				`network_type`,
				`time_gap`,
				`max_session`,
				`session_alert`,
				`purge_time`,
				`mno_id`,
				`default_value`,
				`create_date`,
				`create_user`,
				`last_update`,
				'$user_name',
				NOW(),
				'update'
				FROM `exp_products`
				WHERE `product_id` = '$_POST[pvt_package_edit]'");



			//update distributor products


			/*	echo"UPDATE
		 `exp_products_distributor`
			SET
			`time_gap` = '$tm_gap',
			`purge_time` = '$purg_time',
			`max_session` = '$max_sessions',
			`session_alert` = '$max_sessions_alert',
			`last_update` = NOW()
			WHERE `product_id` = '$_POST[guest_package_edit]'";  */

			$query0dis = $db->execDB("UPDATE
				`exp_products_distributor`
				SET
				`time_gap` = '$tm_gap',
				`purge_time` = '$purg_time',
				`last_update` = NOW()
				WHERE `product_id` = '$_POST[pvt_package_edit]'");
			if ($query0dis === true) {


				$query0 = "UPDATE
			`exp_products`
			SET
			`time_gap` = '$tm_gap',
			`purge_time` = '$purg_time',
			`last_update` = NOW()
			WHERE `product_id` = '$_POST[pvt_package_edit]'";

				$resq0 =	$db->execDB($query0);

				if ($resq0 === true) {

					$msg_41_text = $message_functions->showMessage('gu_prof_update_success');
					$create_log->save('3001', $msg_41_text, $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg_41_text . "</strong></div>";
				} else {
					$msg_41_text = $message_functions->showMessage('gu_prof_update_fail', '2001');
					$create_log->save('2001', $msg_41_text, $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg_41_text . "</strong></div>";
				}
			} else {

				$msg_41_text = $message_functions->showMessage('gu_prof_update_fail', '2001');
				$create_log->save('2001', $msg_41_text, $product_id);

				$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg_41_text . "</strong></div>";
			}
		} else {
			$exist_pac = $db->getValueAsf("SELECT p.product_id AS f FROM exp_products p WHERE p.product_name='$product_name' AND p.mno_id='$user_distributor' AND p.network_type='PRIVATE'");
			if (strlen($exist_pac) == 0) {
				$query0 = "INSERT INTO `exp_products` (`product_id`,`product_code`,`product_name`,`QOS`,`QOS_up_link`, `network_type`,`time_gap`,`purge_time`,`mno_id`,`create_date`,`create_user`)
		VALUES ('$product_id','$product_name','$product_name','$description', '$description_up', 'private','$tm_gap', '$purg_time' ,'$user_distributor', now(), '$user_name')";
				$ex0 = $db->execDB($query0);

				if ($ex0 === true) {
					//server log
					$create_log->save('3001', $message_functions->showMessage('gu_prof_creat_success'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('pr_prof_creat_success') . "</strong></div>";
				} else {
					//server log
					$create_log->save('2001', $message_functions->showMessage('gu_prof_creat_fail', '2001'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('pr_prof_creat_fail', '2001') . "</strong></div>";
				}
			} else {

				$msg41_text = $message_functions->showNameMessage('pr_prof_create_dupli', $product_name, '2010');
				$create_log->save('2001', $msg41_text, $product_id);

				$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg41_text . "</strong></div>";
			}
		}
		/////////////////



	}




	if (isset($_POST['duration_product_submit'])) {

		if ($user_type != "SALES") {
			//$product_code = trim($_POST['product_code1']).','.trim($_POST['product_code2']).','.trim($_POST['product_code3']);

			//$product_code = trim($_POST['product_code1']);
			$product_name = $db->escapeDB(trim($_POST['duration_product_name']));
			$product_type = trim($_POST['product_du_type']);
			$product_id = "pd_" . uniqid();

			$num1 = trim($_POST['du_select1']);
			$num2 = trim($_POST['du_select3']);
			$num3 = trim($_POST['du_select5']);
			$select1 = trim($_POST['du_select2']);
			$select2 = trim($_POST['du_select4']);
			$select3 = trim($_POST['du_select6']);

			$tm_gap = '';
			if ($num1 != 0 && $num2 != 0 && $num3 != 0) {
				$tm_gap = 'P' . $num1 . $select1 . 'T' . $num2 . $select2 . $num3 . $select3;
			} else if ($num1 == 0 && $num2 == 0 && $num3 == 0) {
				$tm_gap = '';
			} else if ($num2 == 0 && $num3 == 0) { // only 1
				$tm_gap = 'P' . $num1 . $select1;
			} else if ($num1 == 0 && $num3 == 0) { // only 2
				$tm_gap = 'PT' . $num2 . $select2;
			} else if ($num1 == 0 && $num2 == 0) { // only 3
				$tm_gap = 'PT' . $num3 . $select3;
			} else if ($num3 == 0) { // only 1,2
				$tm_gap = 'P' . $num1 . $select1 . 'T' . $num2 . $select2;
			} else if ($num2 == 0) { // only 1,3
				$tm_gap = 'P' . $num1 . $select1 . 'T' . $num3 . $select3;
			} else if ($num1 == 0) { // only 2,3
				$tm_gap = 'PT' . $num2 . $select2 . $num3 . $select3;
			}


			/////////////////

			$isdeflt = trim($_POST['is_default']);

			if ($isdeflt == 'on') {

				$isdef_val = '1';
			} else {

				$isdef_val = '0';
			}


			if (isset($_POST['duration_package_edit'])) {

				$edit_duration_id = $_POST[edit_duration_id];
				/*
		echo"INSERT INTO `exp_products_duration_archive` (
		  `id`,
		  `profile_code`,
		  `profile_name`,
		  `description`,
		  `distributor`,
		  `duration`,
		  `profile_type`,
		  `is_enable`,
		  `create_user`,
		  `create_date`,
		  `last_update`,
		  `archive_by`,
		  `archive_type`
		) 
		 
		SELECT 
		  `id`,
		  `profile_code`,
		  `profile_name`,
		  `description`,
		  `distributor`,
		  `duration`,
		  `profile_type`,
		  `is_enable`,
		  `create_user`,
		  `create_date`,
		  `last_update`,
		  '$user_name',
		  'update' 
		FROM
		  `exp_products_duration` 
		WHERE `profile_code`='$_POST[duration_package_edit]' LIMIT 1";
		*/
				//archive
				$db->execDB("INSERT INTO `exp_products_duration_archive` (
			  `id`,
			  `profile_code`,
			  `profile_name`,
			  `description`,
			  `distributor`,
			  `duration`,
			  `profile_type`,
			  `is_enable`,
			  `is_default`,
			  `create_user`,
			  `create_date`,
			  `last_update`,
			  `archive_by`,
			  `archive_type`
			) 
			 
			SELECT 
			  `id`,
			  `profile_code`,
			  `profile_name`,
			  `description`,
			  `distributor`,
			  `duration`,
			  `profile_type`,
			  `is_enable`,
			  `is_default`,
			  `create_user`,
			  `create_date`,
			  `last_update`,
			  '$user_name',
			  'update' 
			FROM
			  `exp_products_duration` 
			WHERE `profile_code`='$_POST[duration_package_edit]' LIMIT 1");

				$query0dis = $db->execDB("UPDATE
				`exp_products_distributor`
				SET
				`time_gap` = '$tm_gap',
				`last_update` = NOW()
				WHERE `duration_prof_code` = '$_POST[duration_package_edit]'");

				if ($query0dis === true) {
					$query0 = "UPDATE exp_products_duration SET 
				duration='$tm_gap',
				profile_type='$product_type',
				is_default='$isdef_val'
			WHERE id='$edit_duration_id'";

					$resq0 =	$db->execDB($query0);

					if ($resq0 === true) {
						$db->userLog($user_name, $script, 'Update Session Duration Profile', $product_name);

						$create_log->save('3001', $message_functions->showMessage('pr_prof_creat_success'), $product_id);

						$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_success') . "</strong></div>";
					} else {

						$create_log->save('2001', $message_functions->showMessage('pr_prof_creat_fail', '2001'), $product_id);

						$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_fail', '2001') . "</strong></div>";
					}
				} else {

					$create_log->save('2001', $message_functions->showMessage('pr_prof_creat_fail', '2001'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_fail', '2001') . "</strong></div>";
				}
			} else {



				$old_check_du = $db->getValueAsf("SELECT COUNT(`id`) AS f FROM `exp_products_duration` WHERE `profile_name`='$product_name' AND `distributor`='$user_distributor'");



				if ($old_check_du == 0) {

					$query0 = "INSERT INTO `exp_products_duration` (
  `profile_code`,
  `profile_name`,
  `description`,
  `distributor`,
  `duration`,
  `profile_type`,
  `is_enable`,
  `is_default`,
  `create_user`,
  `create_date`
) 
VALUES
  (
    '$product_id',
    '$product_name',
    '$product_name',
    '$user_distributor',
    '$tm_gap',
    '$product_type',
    '1',
    '$isdef_val',
    '$user_name',
    NOW()
  )";
					$ex0 = $db->execDB($query0);

					if ($ex0 === true) {
						//server log
						$db->userLog($user_name, $script, 'Create Session Duration Profile', $product_name);

						$create_log->save('3001', $message_functions->showMessage('pr_prof_creat_success'), $product_id);

						$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_success') . "</strong></div>";
					} else {
						//server log
						$create_log->save('2001', $message_functions->showMessage('pr_prof_creat_fail', '2001'), $product_id);

						$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_fail', '2001') . "</strong></div>";
					}
					//////////////
				} else {

					$create_log->save('2001', $message_functions->showMessage('pr_prof_creat_fail', '2001'), $product_id);

					$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_fail', '2001') . "</strong></div>";
				}
			}
			/////////////////
		} else {

			$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('duration_prof_creat_success') . "</strong></div>";
		}
	}



	if (isset($_POST['create_product_submit_guest'])) {

		if ($user_type != "SALES") {

			//$product_code = trim($_POST['product_code1']).','.trim($_POST['product_code2']).','.trim($_POST['product_code3']);

			//$product_code = trim($_POST['product_code1']);
			$description = trim($_POST['description1']);
			$description_up = trim($_POST['description1_up']);



			$product_name = trim($_POST['product_name']);

			$product_id = uniqid();
			$num1 = trim($_POST['sesson_du_select1']);
			$num2 = trim($_POST['sesson_du_select3']);
			$select1 = trim($_POST['sesson_du_select2']);
			$select2 = trim($_POST['sesson_du_select4']);

			if ($num1 != 0 && $num2 != 0) {
				$tm_gap = 'P' . $num1 . $select1 . 'T' . $num2 . $select2;
			} else if ($num1 == 0 && $num2 == 0) {
				$tm_gap = '';
			} else if ($num2 == 0) {
				$tm_gap = 'P' . $num1 . $select1;
			} else if ($num1 == 0) {
				$tm_gap = 'PT' . $num2 . $select2;
			}

			$purg_time = $_POST['Purge_delay_time'];

			$max_sessions = trim($_POST['max_sessions']);
			$max_sessions_alert = $db->escapeDB(trim($_POST['max_sessions_alert']));


			if (isset($_POST['guest_package_edit'])) {


				//archive
				$db->execDB("INSERT INTO `exp_products_archive`
            (`id`,
             `api_id`,
             `product_id`,
             `product_name`,
             `product_code`,
             `QOS`,
             `QOS_up_link`,
             `network_type`,
             `time_gap`,
             `max_session`,
             `session_alert`,
             `purge_time`,
             `mno_id`,
             `default_value`,
             `create_date`,
             `create_user`,
             `last_update`,
             `archive_by`,
             `archive_date`,
	     `ar_status`
             )
             SELECT
  `id`,
  `api_id`,
  `product_id`,
  `product_name`,
  `product_code`,
  `QOS`,
  `QOS_up_link`,
  `network_type`,
  `time_gap`,
  `max_session`,
  `session_alert`,
  `purge_time`,
  `mno_id`,
  `default_value`,
  `create_date`,
  `create_user`,
  `last_update`,
  '$user_name',
  NOW(),
  'update'
FROM `exp_products`
WHERE `product_id` = '$_POST[guest_package_edit]'");



				//update distributor products


				/*	echo"UPDATE
		  `exp_products_distributor`
		SET
		  `time_gap` = '$tm_gap',
		  `purge_time` = '$purg_time',
		  `max_session` = '$max_sessions',
		  `session_alert` = '$max_sessions_alert',
		  `last_update` = NOW()
		WHERE `product_id` = '$_POST[guest_package_edit]'";  */

				$query0dis = $db->execDB("UPDATE
		  `exp_products_distributor`
		SET
		  `time_gap` = '$tm_gap',
		  `purge_time` = '$purg_time',
		  `max_session` = '$max_sessions',
		  `session_alert` = '$max_sessions_alert',
		  `last_update` = NOW()
		WHERE `product_id` = '$_POST[guest_package_edit]'");
				if ($query0dis === true) {

					$query0 = "UPDATE
		  `exp_products`
		SET
		  `time_gap` = '$tm_gap',
		  `purge_time` = '$purg_time',
		  `max_session` = '$max_sessions',
		  `session_alert` = '$max_sessions_alert',
		  `last_update` = NOW()
		WHERE `product_id` = '$_POST[guest_package_edit]'";
				}
			} else {

				$exist_pac = $db->getValueAsf("SELECT p.product_id AS f FROM exp_products p WHERE p.product_name='$product_name' AND p.mno_id='$user_distributor' AND p.network_type='GUEST'");
				if (strlen($exist_pac) == 0) {

					$query0 = "INSERT INTO `exp_products` (`product_id`,`max_session`,`session_alert`,`time_gap`,`purge_time`,`product_name`,`product_code`,`QOS`,`QOS_up_link` , `network_type`,`mno_id`,`create_date`,`create_user`)
	        VALUES ('$product_id','$max_sessions','$max_sessions_alert','$tm_gap','$purg_time','$product_name','$product_name', '$description','$description_up', 'GUEST', '$user_distributor', now(), '$user_name')";
				} else {
					$query0 = '';
					$product_duplicate = 1;
				}
			}
			$ex0 = $db->execDB($query0);


			if ($ex0 === true) {
				if (isset($_POST['guest_package_edit'])) {
					//server log
					$db->userLog($user_name, $script, 'Update Guest QoS Profile', $product_name);

					$create_log->save('3002', $message_functions->showMessage('gu_prof_update_success', '3002'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_update_success') . "</strong></div>";
				} else {
					//server log
					$db->userLog($user_name, $script, 'Create Guest QoS Profile', $product_name);

					$create_log->save('3001', $message_functions->showMessage('gu_prof_creat_success', '3001'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_creat_success') . "</strong></div>";
				}
			} else {
				if (isset($_POST['guest_package_edit'])) {
					//server log
					$create_log->save('3002', $message_functions->showMessage('gu_prof_update_fail', '3002'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_update_fail', '3002') . "</strong></div>";
				} elseif ($product_duplicate == 1) {

					$msg41_text = $message_functions->showNameMessage('pr_prof_create_dupli', $product_name, '2010');
					$create_log->save('2001', $msg41_text, $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $msg41_text . "</strong></div>";
				} else {
					//server log
					$create_log->save('2002', $message_functions->showMessage('gu_prof_creat_fail', '2002'), $product_id);

					$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_creat_fail', '2002') . "</strong></div>";
				}
			}
		} else {

			if (isset($_POST['guest_package_edit'])) {
				//server log

				$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_update_success') . "</strong></div>";
			} else {
				//server log

				$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('gu_prof_creat_success') . "</strong></div>";
			}
		}
	}


	//remove product

	if (isset($_GET['remove_product_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {

			if ($user_type != "SALES") {

				$remove_p_id = $_GET['remove_product_id'];
				$idapi = $_GET['api_id'];

				//$remove_p_code = $_GET['remove_product_name'];
				$q_remove_archive = "INSERT INTO `exp_products_archive`
		(`product_code`, `QOS`, `time_gap`, `mno_id`, `default_value`, `create_user`,`last_update`, `archive_by`, `archive_date`)
		(SELECT  `product_code`, `QOS`, `time_gap`, `mno_id`, `default_value`, `create_user`,`last_update`, '$user_name', NOW()
		FROM `exp_products` WHERE `id`='$remove_p_id' LIMIT 1)";
				$result_remove_archive = $db->execDB($q_remove_archive);

				$rm_pro_id = $db->getValueAsf("SELECT product_id AS f FROM `exp_products` WHERE id='$remove_p_id'");

				$q1 = "SELECT * FROM exp_products_distributor WHERE `product_id`='$rm_pro_id'";
				//$r1 = mysql_query($q1);
				$r1 = $db->selectDB($q1);

				//while($row=mysql_fetch_array($r1)){
				foreach ($r1['data'] as $row) {
					$p_code = $row['product_code'];

					$query_assign_remove_archive = "INSERT INTO `exp_products_distributor_archive`
			(`product_code`, `distributor_code`, `time_gap`, `distributor_type`, `is_enable`, `archive_by`, `archive_date`)
			(SELECT  `product_code`, `distributor_code`, `time_gap`, `distributor_type`, `is_enable`, '$user_name', NOW()
			FROM `exp_products_distributor` WHERE `product_id`='$rm_pro_id'  LIMIT 1)";
					$result_assign_remove_archive = $db->execDB($query_assign_remove_archive);
				}



				if ($result_remove_archive === true) {
					$q_remove_dis = "DELETE FROM `exp_products_distributor` WHERE `product_id`='$rm_pro_id'";
					$result_remove_dis = $db->execDB($q_remove_dis);

					//////////////api delete/////
					//$rsk1=$test->deleteeutp($idapi);
					//////////////////////////////

					$q_remove = "DELETE FROM `exp_products` WHERE `id`='$remove_p_id'";
					$result_remove = $db->execDB($q_remove);

					if ($result_remove === true && $result_remove_dis === true) {
						$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('qos_remove_success') . "</strong></div>";
					} else {
						$db->userErrorLog('2003', $user_name, 'script - ' . $script);
						$_SESSION['msg41'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('qos_remove_fail', '2003') . "</strong></div>";
					}
				}
			} else {
				$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('qos_remove_success') . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg41'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}

	//remove duration product

	if (isset($_GET['remove_duration_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {

			if ($user_type != "SALES") {
				$remove_p_id = $_GET['remove_duration_id'];

				//$remove_p_code = $_GET['remove_duration_name'];
				$q_remove_archive = "INSERT INTO `exp_products_duration_archive` (
  `id`,
  `profile_code`,
  `profile_name`,
  `description`,
  `distributor`,
  `duration`,
  `profile_type`,
  `is_enable`,
  `create_user`,
  `create_date`,
  `last_update`,
  `archive_by`,
  `archive_type`
) 
 
SELECT 
  `id`,
  `profile_code`,
  `profile_name`,
  `description`,
  `distributor`,
  `duration`,
  `profile_type`,
  `is_enable`,
  `create_user`,
  `create_date`,
  `last_update`,
  '$user_name',
  'remove' 
FROM
  `exp_products_duration` 
WHERE `id`='$remove_p_id' LIMIT 1";
				$result_remove_archive = $db->execDB($q_remove_archive);

				if ($result_remove_archive === true) {

					$q_remove = "DELETE FROM `exp_products_duration` WHERE `id`='$remove_p_id'";
					$result_remove = $db->execDB($q_remove);

					if ($result_remove === true) {
						$show_msg = $message_functions->showMessage('duration_profile_remove_success');
						$create_log->save('3003', $show_msg, "");
						$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_msg . "</strong></div>";
					} else {
						$show_msg = $message_functions->showMessage('duration_profile_remove_failed', '2003');
						$create_log->save('2003', $show_msg, "");
						$db->userErrorLog('2003', $user_name, 'script - ' . $script);
						$_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_msg . "</strong></div>";
					}
				}
			} else {
				$show_msg = $message_functions->showMessage('duration_profile_remove_success');

				$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $show_msg . "</strong></div>";
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$show_msg = $message_functions->showMessage('transection_fail', '2004');
			$_SESSION[msg2] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $show_msg . "</strong></div>";
			$create_log->save('2004', $show_msg, '');
		}
	}

	////edit Product
	if (isset($_GET['edit_product_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {
			$edit_p_id = $_GET['edit_product_id'];

			//$edit_p_code = $_GET['edit_product_name'];

			$q1 = "SELECT * FROM exp_products WHERE id='$edit_p_id'";
			//$r1 = mysql_query($q1);
			$r1 = $db->selectDB($q1);

			//if(mysql_num_rows($r1)>0){
			if ($r1['rowCount'] > 0) {

				//while($row=mysql_fetch_array($r1)){
				foreach ($r1['data'] as $row) {
					$edit_p_code = $row['product_code'];
					$edit_p_id = $row['product_id'];
					$edit_p_name = $row['product_name'];
					$edit_p_QOS = $row['QOS'];
					$edit_p_QOS_up = $row['QOS_up_link'];

					$edit_p_timegap = $row['time_gap'];
					$edit_p_prug_time = $row['purge_time'];
					$edit_p_maxses = $row['max_session'];
					$edit_p_alert = $row['session_alert'];
				}
				$edit_guest_product = 1;
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION[msg41] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
			$create_log->save('2004', $fail_msg1, '');
		}
	}

	////edit Product durations
	if (isset($_GET['edit_dura_product_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {
			$edit_p_id = $_GET['edit_dura_product_id'];

			$q1 = "SELECT * FROM exp_products_duration WHERE id='$edit_p_id'";
			$r1 = $db->selectDB($q1);

			//if(mysql_num_rows($r1)>0){
			if ($r1['rowCount'] > 0) {

				//while($row=mysql_fetch_array($r1)){
				foreach ($r1['data'] as $row) {
					$edit_dura_code = $row['profile_code'];
					$edit_dura_id = $row['id'];
					$edit_dura_name = $row['profile_name'];
					$edit_dura_timegap = $row['duration'];
					$edit_dure_type = $row['profile_type'];

					$edit_is_def = $row['is_default'];
				}
				$edit_product_duration = 1;
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION[smsg2] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
			$create_log->save('2004', 'edit_product_name', '');
		}
	}


	//edit pvt product
	if (isset($_GET['edit_product_pvt_id'])) {
		if ($_SESSION['FORM_SECRET'] == $_GET['token2']) {
			$edit_p_id_pvt = $_GET['edit_product_pvt_id'];

			//$edit_p_code_pvt = $_GET['edit_product_name_pvt'];

			$q1 = "SELECT * FROM exp_products WHERE id='$edit_p_id_pvt'";
			$r1 = $db->selectDB($q1);
			//if(mysql_num_rows($r1)>0){
			if ($r1['rowCount'] > 0) {

				//while($row=mysql_fetch_array($r1)){
				foreach ($r1['data'] as $row) {
					$edit_p_code_pvt = $row['product_code'];
					$edit_p_id_pvt = $row['product_id'];
					$edit_p_name_pvt = $row['product_name'];
					$edit_p_QOS_pvt = $row['QOS'];
					$edit_p_QOS_up_pvt = $row['QOS_up_link'];

					$edit_p_timegap_pvt = $row['time_gap'];
					$edit_p_prug_time_pvt = $row['purge_time'];
					$edit_p_maxses_pvt = $row['max_session'];
					$edit_p_alert_pvt = $row['session_alert'];
				}
				$edit_product_pvt = 1;
			}
		} else {
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION[msg41] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> " . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
			$create_log->save('2004', 'edit_product_name', '');
		}
	}


	//active inactive
	if (isset($_GET['pro_default_id'])) {

		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {

			$id_new = $_GET['pro_default_id'];
			if (isset($_GET['mno_id'])) {

				$mno_id = $_GET['mno_id'];
				$t = $_GET['status'];
				if ($t == '1') {

					$query = "UPDATE `exp_products`	SET `default_value`='0'	WHERE `id`='$id_new'";
					$result = $db->execDB($query);
				} else {
					$query = "UPDATE `exp_products`	SET `default_value`='1'	WHERE `id`='$id_new'";
					$result = $db->execDB($query);
				}

				if ($result === true) {
					if ($t == '1') {
						$message_code = 'prof_disable_success';
					} else {
						$message_code = 'prof_enable_success';
					}
					//refresh page error
					//
					$db->userErrorLog('3002', $user_name, 'script - ' . $script);
					//server log
					$create_log->save('3002', $message_functions->showMessage($message_code, '3002'), '');

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage($message_code) . "</strong></div>";
				} else {
					if ($t == '1') {
						$message_code = 'prof_disable_fail';
					} else {
						$message_code = 'prof_enable_fail';
					}
					//refresh page error
					//
					$db->userErrorLog('3002', $user_name, 'script - ' . $script);
					//server log
					$create_log->save('3002', $message_functions->showMessage($message_code, '3002'), '');

					$_SESSION['msg41'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage($message_code) . "</strong></div>";
				}
			}
		} else {

			//refresh page error
			//
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			//server log
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

			$_SESSION['msg41'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //





	//active inactive
	if (isset($_GET['duration_pro_id'])) {

		if ($_SESSION['FORM_SECRET'] == $_GET['token']) {

			$id_new = $_GET['duration_pro_id'];

			$t = $_GET['status'];
			$query = "UPDATE `exp_products_duration` SET `is_enable`='$t' WHERE id='$id_new'";
			$result = $db->execDB($query);
			if ($result === true) {
				if ($t == '0') {
					$message_code = 'prof_disable_success';
				} else {
					$message_code = 'prof_enable_success';
				}
				//refresh page error
				//
				$db->userErrorLog('3002', $user_name, 'script - ' . $script);
				//server log
				$create_log->save('3002', $message_functions->showMessage($message_code, '3002'), '');

				$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage($message_code) . "</strong></div>";
			} else {
				if ($t == '0') {
					$message_code = 'prof_disable_fail';
				} else {
					$message_code = 'prof_enable_fail';
				}
				//refresh page error
				//
				$db->userErrorLog('3002', $user_name, 'script - ' . $script);
				//server log
				$create_log->save('3002', $message_functions->showMessage($message_code, '3002'), '');

				$_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage($message_code) . "</strong></div>";
			}
		} else {

			//refresh page error
			//
			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			//server log
			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

			$_SESSION['msg2'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //



	//Create Aps///



	if (isset($_POST['submit_f'])) { //10

		if ($_SESSION['FORM_SECRET'] == $_POST['secret']) {
			$aup = $db->escapeDB($_POST['aup1']);
			$title = $_POST['title'];
			$dist = $user_distributor;
			$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('AUP','$title','$aup','$dist',now(),'$user_name')";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {
				$_SESSION['msg'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>MVN(x) Sign-up AUP updated</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>[2001] Failed</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msg'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //10



	//agreement//

	if (isset($_POST['submit_arg'])) { //13



		if ($_SESSION['FORM_SECRET'] == $_POST['secret']) {



			$argeement = $db->escapeDB($_POST['argeement']);

			$title = $db->escapeDB($_POST['arg_title']);

			//$dist = $user_distributor;



			$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)

		values ('AGREEMENT','$title','$argeement','ADMIN',now(),'$user_name')";



			$ex0 = $db->execDB($query0);



			if ($ex0 === true) {

				$create_log->save('3001', $message_functions->showMessage('config_act_toc_update_success'), '');

				$_SESSION['msgy'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_toc_update_success') . "</strong></div>";
			} else {

				$create_log->save('2001', $message_functions->showMessage('config_act_toc_update_failed', '2001'), '');
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);

				$_SESSION['msgy'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_toc_update_failed', '2001') . "</strong></div>";
			}
		} else {



			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');

			$_SESSION['msgy'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //13



	if (isset($_POST['submit_arg1'])) { //13



		if ($_SESSION['FORM_SECRET'] == $_POST['secret']) {



			$argeement = $db->escapeDB($_POST['argeement1']);

			$title = $db->escapeDB($_POST['arg_title1']);

			//$dist = $user_distributor;



			$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)

		values ('AGREEMENT','$title','$argeement','$user_distributor',now(),'$user_name')";



			$ex0 = $db->execDB($query0);



			if ($ex0 === true) {

				$_SESSION['msgx'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('tc_update_success') . "</strong></div>";
			} else {

				$db->userErrorLog('2001', $user_name, 'script - ' . $script);

				$_SESSION['msgx'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('tc_update_fail', '2002') . "</strong></div>";
			}
		} else {



			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$_SESSION['msgx'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //13


	if (isset($_POST['submit_toc'])) { //11

		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			if ($user_type != "SALES") {
				/* echo "asd";
		exit(); */

				$vertical = $db->escapeDB($_POST['business_type']);
				$tc_code = $db->escapeDB($_POST['tc_code']);
				$dist = $db->escapeDB($_POST['tc_distributor']);


				if ($package_functions->getSectionType('CAPTIVE_TOC_TYPE', $system_package) == "checkbox") {

					$toc1 = $db->escapeDB($_POST['toc1']);
					$toc2 = $db->escapeDB($_POST['toc2']);
					$toc3 = $db->escapeDB($_POST['toc3']);
					$toc4 = $db->escapeDB($_POST['toc4']);
					$toc5 = $db->escapeDB($_POST['toc5']);
					$toc6 = $db->escapeDB($_POST['submit']);
					$toc7 = $db->escapeDB($_POST['cancel']);

					$arr = array('toc1' => $toc1, 'toc2' => $toc2, 'toc3' => $toc3, 'toc4' => $toc4, 'toc5' => $toc5, 'submit' => $toc6, 'cancel' => $toc7);
					$toc = json_encode($arr);
				} else {
					$toc = $db->escapeDB($_POST['toc1']);
				}


				//$title = $_POST['title'];

				/* $dist = $user_distributor;



		$query0 = "REPLACE INTO exp_texts (text_code,text_details,distributor,create_date,updated_by)



		values ('TOC','$toc','$dist',now(),'$user_name')";



		$ex0 = mysql_query($query0); */


				//$dist = $user_distributor;

				$ch_txt = $db->textVal_vertical($tc_code, $dist, $vertical);



				if (empty($ch_txt) || $ch_txt = '') {


					$query0 = "INSERT INTO exp_texts (text_code,text_details,vertical,distributor,create_date,updated_by)

		values ('$tc_code','$toc','$vertical','$dist',now(),'$user_name')";
				} else {



					$query0 = "UPDATE `exp_texts` SET `text_details` = '$toc' WHERE `text_code` = '$tc_code' AND `vertical`='$vertical' AND `distributor`='$dist'";
				}


				$ex0 = $db->execDB($query0);

				/*if (mysql_errno()) { 
  		$error = "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>";
  		echo $tc_code.'-'.$dist.'-'.$vertical.'<br>';
  		echo $error; die();

		}*/


				if ($ex0 === true) {
					$db->userLog($user_name, $script, 'Update Guest Terms and Conditions', 'N/A');

					$_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Terms and Condition have been updated</strong></div>";
				} else {

					$db->userErrorLog('2001', $user_name, 'script - ' . $script);

					$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> [2002] Terms and Conditions updating failed</strong></div>";
				}
			} else {
				$_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Terms and Condition have been updated</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //11



	if (isset($_POST['submit_sys_con'])) { //11



		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {



			$msg_max_ses = $db->escapeDB($_POST['msg_max_ses']);

			$max_ses_per_day = $db->escapeDB($_POST['max_ses_per_day']);

			//$title = $_POST['title'];

			$dist = $user_distributor;





			$query0 = "REPLACE INTO exp_settings (settings_name,description,category,settings_code,settings_value,distributor,create_date,create_user)

		values ('Max session per day','Max session per day','SYSTEM','max_sessions','$max_ses_per_day','$dist',now(),'$user_name'), ('Max session message','Max session message','SYSTEM','max_sessions_text','$msg_max_ses','$dist',now(),'$user_name')";

			$ex0 = $db->execDB($query0);



			if ($ex0 === true) {

				$_SESSION['msg112'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Session Limit Updated.</strong></div>";
			} else {

				$db->userErrorLog('2001', $user_name, 'script - ' . $script);

				$_SESSION['msg112'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> [2001] Transaction failed</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$_SESSION['msg112'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //11




	if (isset($_POST['email_form_update'])) { //10

		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {

			if ($user_type != "SALES") {


				$email2 = $db->escapeDB($_POST['email1']);
				$business_vertical = $db->escapeDB($_POST['business_vertical']);
				if (strlen($business_vertical)<1) {
					$business_vertical = 'All';
				}
				$title = $db->escapeDB($_POST['email_subject']);
				$email_code = $db->escapeDB($_POST['email_code']);
				$email_distributor = $db->escapeDB($_POST['email_distributor']);
				//$dist = $user_distributor;
				$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,vertical,create_date,updated_by)
		values ('$email_code','$title','$email2','$email_distributor','$business_vertical',now(),'$user_name')";
				$ex0 = $db->execDB($query0);
				if ($ex0 === true) {
					$db->userLog($user_name, $script, 'Update Email Templates', $email_code);

					$create_log->save('3001', $message_functions->showMessage('config_act_email_update_success'), '');
					$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_email_update_success') . "</strong></div>";
				} else {
					$db->userErrorLog('2001', $user_name, 'script - ' . $script);
					$create_log->save('2001', $message_functions->showMessage('config_act_email_update_failed', '2001'), '');
					$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_email_update_failed', '2001') . "</strong></div>";
				}
			} else {
				$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_email_update_success') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}



	if (isset($_POST['vttoc_form_update'])) { //10

		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			$email2 = $db->escapeDB($_POST['email1']);
			$title = $db->escapeDB($_POST['email_subject']);
			$email_code = $db->escapeDB($_POST['email_code']);
			$email_distributor = $db->escapeDB($_POST['email_distributor']);
			//$dist = $user_distributor;
			$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('$email_code','$title','$email2','$email_distributor',now(),'$user_name')";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {

				$create_log->save('3001', $message_functions->showMessage('config_act_email_update_success'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('vttoc_creation_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$create_log->save('2001', $message_functions->showMessage('config_act_email_update_failed', '2001'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('vttoc_creation_fail', '2001') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}


	if (isset($_POST['email_vt_noytification'])) { //10

		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
			$email2 = $db->escapeDB($_POST['email1']);
			$title = $db->escapeDB($_POST['email_subject']);
			$email_code = $db->escapeDB($_POST['email_code']);
			$email_distributor = $db->escapeDB($_POST['email_distributor']);
			$business_vertical = $db->escapeDB($_POST['business_vertical']);
			if (strlen($business_vertical)<1) {
					$business_vertical = 'All';
				}
			//$dist = $user_distributor;
			$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,vertical,create_date,updated_by)
		values ('$email_code','$title','$email2','$email_distributor','$business_vertical',now(),'$user_name')";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {

				$create_log->save('3001', $message_functions->showMessage('config_act_email_update_success'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_email_update_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$create_log->save('2001', $message_functions->showMessage('config_act_email_update_failed', '2001'), '');
				$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('config_act_email_update_failed', '2001') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);

			$create_log->save('2004', $message_functions->showMessage('transection_fail', '2004'), '');
			$_SESSION['msgy1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}


	/*if(isset($_POST['tech_form_update'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['email_tech']);
		$title = $_POST['email_subject'];
		$email_code = $_POST['email_code'];
		$email_distributor = $_POST['email_distributor'];
		//$dist = $user_distributor;
		$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('$email_code','$title','$email2','$email_distributor',now(),'$user_name')";
		 $ex0 = mysql_query($query0);
		if ($ex0) {
			
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."</strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);

		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

	}

}*/

	//10

	/*
if(isset($_POST['email_subject_passcode'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['email2']);
		$title = $_POST['email_subject_passcode'];
		$dist = $user_distributor;
		 $query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('PASSCODE_MAIL','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."</strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);

		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

	}

}//10




if(isset($_POST['email_pass_reset'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['email3']);
		$title = $_POST['email_subject_pass_reset'];
		$dist = $user_distributor;
		 $query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('PASSWORD_RESET_MAIL','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."/strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."/strong></div>";

	}

}//10





if(isset($_POST['email_activated_sub'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['email_activated']);
		$title = $_POST['email_subject_activated'];
		$dist = $user_distributor;
		 $query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('VENUE_ACTIVATED','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."/strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."/strong></div>";

	}

}//10




if(isset($_POST['new_location_activated_sub'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email = mysql_escape_string($_POST['new_location_activated_email']);
		$title = $_POST['new_location_activated'];
		$dist = $user_distributor;
		 $query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('NEW_LOCATION_MAIL','$title','$email','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."/strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."/strong></div>";

	}

}//10





if(isset($_POST['active_email_submit'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['email1']);
		$title = $_POST['email_subject_main'];
		$dist = $user_distributor;
		$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('MAIL','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."</strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

	}

}//10


if(isset($_POST['active_user_email_submit'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['active_user_email_submit_tarea']);
		$title = $_POST['email_user_subject_main'];
		$dist = $user_distributor;
		 $query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('USER_MAIL','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."</strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

	}

}//10


if(isset($_POST['active_sup_email_submit'])){//10

	if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {
		$email2 = mysql_escape_string($_POST['sup_email1']);
		$title = $_POST['email_subject_sup_main'];
		$dist = $user_distributor;
		$query0 = "REPLACE INTO exp_texts (text_code,title,text_details,distributor,create_date,updated_by)
		values ('SUPPORT_MAIL','$title','$email2','$dist',now(),'$user_name')";
		$ex0 = mysql_query($query0);
		if ($ex0) {
			
			$create_log->save('3001',$message_functions->showMessage('config_act_email_update_success'),'');
			$_SESSION['msgy1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_success')."</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - '.$script);
			$create_log->save('2001',$message_functions->showMessage('config_act_email_update_failed','2001'),'');
			$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('config_act_email_update_failed','2001')."</strong></div>";
		}


	} else {

		$db->userErrorLog('2004', $user_name, 'script - '.$script);
		
		$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
		$_SESSION['msgy1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

	}

}//10

*/
	if (isset($_POST['server_link_submit'])) {
		//10
		//echo $_SESSION['FORM_SECRET'].'-'.$_POST['form_secret'];
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {

			$ftype = $db->escapeDB($_POST['server_type']);
			$gtitle = $db->escapeDB($_POST['server_title']);
			$linktitle = $db->escapeDB($_POST['server_link_title']);
			$furl = $db->escapeDB($_POST['server_url']);


			$dist = $user_distributor;
			$query0 = "REPLACE INTO `exp_footer` (
					  `footer_type`,
					  `group_title`,
					  `link_title`,
					  `url`,
					  `distributor`,
					  `create_date`
					) 
					VALUES
					  (
					    '$ftype',
					    '$gtitle',
					    '$linktitle',
					    '$furl',
					    '$user_distributor',
					    NOW()
					  ) ;";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {
				$_SESSION['msgft'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_fail', '2001') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	}

	if (isset($_POST['footer_submit'])) { //10
		//echo $_SESSION['FORM_SECRET'].'-'.$_POST['form_secret'];
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {

			$ftype = $db->escapeDB($_POST['footer_type']);
			$gtitle = $db->escapeDB($_POST['group_title']);
			$linktitle = $db->escapeDB($_POST['link_title']);
			$furl = $db->escapeDB($_POST['footer_url']);


			$dist = $user_distributor;
			$query0 = "REPLACE INTO `exp_footer` (
					  `footer_type`,
					  `group_title`,
					  `link_title`,
					  `url`,
					  `distributor`,
					  `create_date`
					) 
					VALUES
					  (
					    '$ftype',
					    '$gtitle',
					    '$linktitle',
					    '$furl',
					    '$user_distributor',
					    NOW()
					  ) ;";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {
				$_SESSION['msgft'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_fail', '2001') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //10


	if (isset($_POST['user_guide_submit'])) { //10
		//echo $_SESSION['FORM_SECRET'].'-'.$_POST['form_secret'];
		if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {

			$ftype = $db->escapeDB($_POST['footer_type']);
			$gtitle = $db->escapeDB($_POST['group_title']);
			$linktitle = $db->escapeDB($_POST['link_title']);
			$furl = $db->escapeDB($_POST['user_guide_url']);


			$dist = $user_distributor;
			$query0 = "REPLACE INTO `exp_footer` (
					  `footer_type`,
					  `group_title`,
					  `link_title`,
					  `url`,
					  `distributor`,
					  `create_date`
					) 
					VALUES
					  (
					    '$ftype',
					    '$gtitle',
					    '$linktitle',
					    '$furl',
					    '$user_distributor',
					    NOW()
					  ) ;";
			$ex0 = $db->execDB($query0);
			if ($ex0 === true) {
				$_SESSION['msgft'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_success') . "</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_fail', '2001') . "</strong></div>";
			}
		} else {

			$db->userErrorLog('2004', $user_name, 'script - ' . $script);
			$_SESSION['msgft'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
		}
	} //10


	if (isset($_POST['fb_submit'])) {
		$subm_fb_app_id = $db->escapeDB($_POST['fb_app_id']);
		$subm_fb_app_version = $db->escapeDB($_POST['fb_app_version']);
		$subm_fb_fields = $db->escapeDB($_POST['fb_fields']);

		$subm_fb_fields_edit = implode(",", $subm_fb_fields);

		$soc_q = "replace into exp_social_profile (app_version,social_profile,social_media,app_id,fields,app_xfbml,app_cookie,distributor,create_date,last_update) 
                    values ('$subm_fb_app_version','$subm_fb_app_id','FACEBOOK','$subm_fb_app_id','$subm_fb_fields_edit','true','true','$user_distributor',now(),now())";
		$exsoc_q = $db->execDB($soc_q);
		if ($exsoc_q === true) {
			$_SESSION['msg22'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_success') . "</strong></div>";
		} else {
			$db->userErrorLog('2001', $user_name, 'script - ' . $script);
			$_SESSION['msg22'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('footer_update_fail', '2001') . "</strong></div>";
		}
	}

	if (isset($_GET['edit_id'])) {
		$id = $_GET['edit_id'];
		$key_query = "SELECT id,qos_id,qos_code,qos_name,`network_type`
                FROM exp_qos
                WHERE id='$id'";
		$query_results = $db->selectDB($key_query);
		foreach ($query_results['data'] as $row) {
			$id = $row[id];
			$qos_id = $row[qos_id];
			$qos_code = $row[qos_code];
			$qos_name = $row[qos_name];
			$edit_qos_id = "1";
			$network_type = $row[network_type];
		}
	}
	if (isset($_GET['edit_sf_id'])) {

		$id = $_GET['edit_sf_id'];
		$key_query = "SELECT *
                FROM exp_payment_products
                WHERE id='$id'";
		$query_results = $db->selectDB($key_query);
		foreach ($query_results['data'] as $row) {
			$sf_id = $row[id];
			$sf_code = $row[product_id];
			$sf_name = $row[product_name];
			$sf_description = $row[description];
			$active_time = $row[active_time];
			$sfaccess_code = $row[access_code];
			$sfis_enable = $row[is_enable];
			if ($sfis_enable == 1) {
				$sfis_enable = 'checked';
			}
			$sfis_premium = $row[is_premium];
			if ($sfis_premium == 1) {
				$sfis_premium = 'checked';
			}
			$edit_sf_idd = "1";
			$sf_amount = $row[amount];
		}
	}

	if (isset($_GET['sfenable_id'])) {

		$id = $_GET['sfenable_id'];
		$is_enable = $_GET['is_enable'];
		$edit_query = "UPDATE `exp_payment_products`
            SET
            `is_enable` = '$is_enable'
            WHERE `id` = '$id'";
		$query_pro = $db->execDB($edit_query);

		if ($query_pro === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_GET['qos_rm_id'])) {

		$id = $_GET['qos_rm_id'];

		$query_rm = "DELETE FROM `exp_qos` WHERE `id`='$id'";

		$remove_query = $db->execDB($query_rm);

		if ($remove_query === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_remove_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_remove_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_GET['rm_sf_id'])) {

		$id = $_GET['rm_sf_id'];

		$query_rm = "DELETE FROM `exp_payment_products` WHERE `id`='$id'";

		$remove_query = $db->execDB($query_rm);

		if ($remove_query === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_remove_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_remove_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_POST['qos_submit'])) {


		$qos_id = uniqid();
		$qos_profile = $_POST['qos_profile'];
		$qos_category = $_POST['qos_category'];
		$qos_description = $_POST['qos_description'];
		$max_sessions = "";
		$max_sessions_alert  = "";
		$tm_gap  = "";
		$purg_time  = "";
		$description  = "";
		$description_up  = "";

		$archive_path = $_POST['archive_log_path'];

		$query_pro0 = "INSERT INTO `exp_qos` (`qos_id`,`max_session`,`session_alert`,`time_gap`,`purge_time`,`qos_name`,`qos_code`, `network_type`,`mno_id`,`create_date`,`create_user`,`sync_status`)
                       VALUES ('$qos_id','$max_sessions','$max_sessions_alert','$tm_gap','$purg_time','$qos_description','$qos_profile', '$qos_category', '$user_distributor', now(), '$user_name','$sync_id')";

		$query_pro = $db->execDB($query_pro0);

		if ($query_pro === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_creat_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_creat_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_POST['qos_update'])) {

		$qos_profile = $_POST['qos_profile'];
		$qos_category = $_POST['qos_category'];
		$qos_description = $_POST['qos_description'];
		$qos_id = $_POST['qos_id'];

		$query_pro0 = "UPDATE
                  `exp_qos`
                SET
                  `qos_name` = '$qos_description',
                  `qos_code` = '$qos_profile',
                  `network_type` = '$qos_category'
                WHERE `qos_id` = '$qos_id' ";

		$query_pro = $db->execDB($query_pro0);

		if ($query_pro === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_POST['sf_submit'])) {


		$sf_id = uniqid();
		$sf_profile = $_POST['sf_profile'];
		$sf_description = $_POST['sf_description'];
		$sf_capacity = $_POST['sf_capacity'];
		$sf_time = $_POST['sf_time'];
		$sf_price = $_POST['sf_price'];
		$sf_code = $_POST['sf_code'];
		$is_enable = $_POST['sf_enable'];
		$is_premium = $_POST['sf_enable_premium'];
		$max_sessions_alert  = "";

		if ($is_enable == 'Yes') {
			$is_enable = 1;
		} else {
			$is_enable = 0;
		}
		if ($is_premium == 'Yes') {
			$is_premium = 1;
		} else {
			$is_premium = 0;
		}


		$query = "INSERT INTO exp_payment_products
        (id,product_id, `product_name`,description,  mno, currency, amount, `active_time`,`is_enable`,`access_code`,`is_premium`)
        VALUES ('$sf_id','$sf_profile','$sf_capacity','$sf_description','$user_distributor','SNAPFORC','$sf_price','$sf_time','$is_enable','$sf_code','$is_premium')";

		$query_pro = $db->execDB($query);

		if ($query_pro === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_creat_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_creat_fail', NULL) . "</strong></div>";
		}
	}

	if (isset($_POST['sf_update'])) {

		$sf_profile = $_POST['sf_profile'];
		$sf_description = $_POST['sf_description'];
		$sf_capacity = $_POST['sf_capacity'];
		$sf_time = $_POST['sf_time'];
		$sf_price = $_POST['sf_price'];
		$sf_code = $_POST['sf_code'];
		$sf_id = $_POST['sf_id'];
		$is_enable = $_POST['sf_enable'];
		$is_premium = $_POST['sf_enable_premium'];
		if ($is_enable == 'Yes') {
			$is_enable = 1;
		} else {
			$is_enable = 0;
		}
		if ($is_premium == 'Yes') {
			$is_premium = 1;
		} else {
			$is_premium = 0;
		}


		$edit_query = "UPDATE `exp_payment_products`
            SET `product_name` = '$sf_capacity',
            `description` ='$sf_description',
            `currency` = 'SNAPFORC',
            `amount` =  '$sf_price',
            `access_code` =  '$sf_code',
            `active_time` =  '$sf_time',
            `is_enable` = '$is_enable',
            `is_premium` = '$is_premium'
            WHERE `id` = '$sf_id'";

		$query_pro = $db->execDB($edit_query);

		if ($query_pro === true) {
			$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_success', NULL) . "</strong></div>";
		} else {

			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('vt_prof_update_fail', NULL) . "</strong></div>";
		}
	}

	$secret = md5(uniqid(rand(), true));

	$_SESSION['FORM_SECRET'] = $secret;



	$config_mid = 'layout/' . $camp_layout . '/views/config_mid.php';

	if (($new_design == 'yes') && file_exists($config_mid)) {

		include_once $config_mid;
	} else {


	?>

		<?php if ($user_type == 'MVNO_ADMIN') { ?>
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

										<!-- <i class="icon-wrench"></i> -->



										<h3>Configuration</h3>


									</div>


								<?php
								}


								//$archive_path=$db->setVal('LOGS_FILE_DIR','ADMIN');
								if (isset($_POST['purge_now'])) {



									$log_older_days = $_POST['log_older_days'];
									$archive_log_days = $_POST['archive_log_days'];

									$archive_path = $db->escapeDB($_POST['archive_log_path']);
									$archive_log_path_update = "UPDATE exp_settings SET `settings_value`='$archive_path' WHERE `settings_code`='LOGS_FILE_DIR' AND `distributor`='ADMIN'";
									$db->execDB($archive_log_path_update);



									$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('purge_now_update_failed', NULL) . "</strong></div>";

									$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$log_older_days' WHERE `type` = 'DB'";
									$query_log_remove_update_q1 = $db->execDB($query_log_remove_update1);

									$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$archive_log_days' WHERE `type` = 'archive_db'";
									$query_log_remove_update_q1 = $db->execDB($query_log_remove_update1);

									if ($query_log_remove_update_q1 === true) {
										$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('purge_now_update_success', NULL) . "</strong></div>";
									}
								}



								?>




								<!-- /widget-header -->



								<div class="widget-content">

									<div class="tabbable">

										<ul class="nav nav-tabs newTabs">

											<?php

											if ($user_type == 'MVNO' || $user_type == 'MVNE') {
												if ($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE', $system_package) == "1") {
											?>
													<li <?php if (isset($tab11)) { ?>class="active" <?php } ?>><a href="#toc" data-toggle="tab">Guest T&C</a></li>

												<?php
												} else {
												?>
													<li <?php if (isset($tab1)) { ?>class="active" <?php } ?>><a href="#live_camp2" data-toggle="tab">Admin</a></li>
													<?php if (in_array("CONFIG_REGISTER", $features_array)) { ?>
														<li <?php if (isset($tab22)) { ?>class="active" <?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
													<?php } ?>
													<li <?php if (isset($tab11)) { ?>class="active" <?php } ?>><a href="#toc" data-toggle="tab">T & C</a></li>

													<!--
										<li <?php //if(isset($tab12)){
											?>class="active" <?php //}
																?>><a href="#veryfi" data-toggle="tab">Verify Settings</a></li>
                                        -->
													<li <?php if (isset($tab112)) { ?>class="active" <?php } ?>><a href="#sys_controllers" data-toggle="tab">Session</a></li>
											<?php
												}
											}

											?>

											<?php

											if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {
												if ($user_type == 'ADMIN') {
											?>

													<li <?php if (isset($tab1)) { ?>class="active" <?php } ?>><a href="#live_camp" data-toggle="tab">General Config</a></li>

												<?php  } } ?>
												<!--< ?php
												if (in_array("CONFIG_REGISTER", $features_array)) { ?>
													<li><a href="#registration" data-toggle="tab">Registration</a></li>
												< ?php }
												if ($user_type == 'ADMIN') {
												?>
													<li < ?php if (isset($tab15)) { ?>class="active" < ?php } ?>><a href="#live_cam3" data-toggle="tab">Login Screen</a></li>
													<li < ?php if (isset($tab13)) { ?>class="active" < ?php } ?>><a href="#agreement" data-toggle="tab">Activation T&C</a></li>
												< ?php } ?>
												<li < ?php if (isset($tab21)) { ?>class="active" < ?php } ?>><a href="#email" data-toggle="tab">Activation Email</a></li>

												<!-- <li < ?php if (isset($tab7)) { ?>class="active" < ?php } ?>><a href="#purge_logs" data-toggle="tab">Purge Log Config</a></li> 
												< ?php if (in_array("PURGE_LOGS", $features_array) || $package_features == "all") { ?>
													<li < ?php if (isset($tab7)) { ?>class="active" < ?php } ?>><a href="#purge_logs" data-toggle="tab">Purge Log Config</a></li>
												< ?php } ?> < ?php
														}



														if ($user_type == 'MNO' || $user_type == 'SALES') {
															//print_r($features_array);	
															//echo  $tab11;

															?>

												<!-- <li class="active"><a href="#live_camp3" data-toggle="tab">System Configuration</a></li>
												< ?php if (in_array("CONFIG_PROFILE", $features_array)) { ?>
													<li < ?php if (isset($tab1)) { ?>class="active" < ?php } ?>><a href="#product_create" data-toggle="tab">Profile</a></li>
												< ?php }
															if (in_array("CONFIG_DURATION", $features_array)) { ?>
													<li < ?php if (isset($tab2)) { ?>class="active" < ?php } ?>><a href="#duration_create" data-toggle="tab">Duration</a></li>
												< ?php }
												?>


												<!-- <li><a href="#live_camp3" data-toggle="tab">Portal</a></li> 
												<li < ?php if (isset($tab0)) { ?>class="active" < ?php } ?>><a href="#live_camp3" data-toggle="tab">Portal</a></li>

												< ?php

															if (!in_array("CONFIG_DURATION", $features_array)) { ?>
													<li < ?php if (isset($tab18)) { ?>class="active" < ?php } ?>><a href="#ale5_create_product" data-toggle="tab">Default Product</a></li>
												< ?php }
															if (in_array("CONFIG_QOS", $features_array)) {

																//httpPost($camp_base_url . '/ajax/get_profile.php',$post_data);

																CommonFunctions::httpPost($camp_base_url . '/ajax/get_profile.php', $post_data);

												?>
													<li < ?php if (isset($tab42)) { ?>class="active" < ?php } ?>><a href="#qos_set" data-toggle="tab">QOS</a></li>
												< ?php }
															if (in_array("PREPAID_MODULE_N", $mno_feature)) {

																//httpPost($camp_base_url . '/ajax/get_profile.php',$post_data);

																CommonFunctions::httpPost($camp_base_url . '/ajax/get_profile.php', $post_datanew); ?>
													<li < ?php if (isset($tab36)) { ?>class="active" < ?php } ?>><a href="#sfproduct_set" data-toggle="tab">Prepaid</a></li>
												< ?php }
												?>


												<li < ?php if (isset($tab11)) { ?>class="active" < ?php } ?>><a href="#toc" data-toggle="tab">Guest T&C</a></li>


												< ?php if (in_array("VTENANT_TC", $features_array) && $package_functions->getSectionType('VTENANT_TYPE', $system_package) == '1') { ?>
													<li < ?php if (isset($tab32)) { ?>class="active" < ?php } ?>><a href="#vt_toc" data-toggle="tab">Vtenant T&C</a></li>
												< ?php } ?>

												< ?php if (in_array("CONFIG_GUEST_AUP", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab10)) { ?>class="active" < ?php } ?>><a href="#aup" data-toggle="tab">Guest AUP</a></li>
												< ?php } ?>

												<li < ?php if (isset($tab20)) { ?>class="active" < ?php } ?>><a href="#agreement2" data-toggle="tab">Activation T&C</a></li>
												< ?php if (in_array("CONFIG_REGISTER", $features_array)) { ?>
													<li < ?php if (isset($tab22)) { ?>class="active" < ?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
												< ?php } ?>
												<li < ?php if (isset($tab21)) { ?>class="active" < ?php } ?>><a href="#email" data-toggle="tab">Email Templates</a></li>

												< ?php if (in_array("CONFIG_PROPERTY_SETTINGS", $features_array)) { ?>
													<li < ?php if (isset($tab23)) { ?>class="active" < ?php } ?>><a href="#property_settings" data-toggle="tab">Property Settings</a></li>
												< ?php } ?>

												< ?php if (in_array("CONFIG_POWER", $features_array)) { ?>
													<li><a href="#power_shedule" data-toggle="tab">Power Schedule</a></li>
												< ?php }
															if (in_array("CONFIG_GUEST_FAQ", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab30)) { ?>class="active" < ?php } ?>><a href="#faq" data-toggle="tab">FAQ</a></li>
												< ?php }
															if (in_array("CONFIG_FOOTER", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab31)) { ?>class="active" < ?php } ?>><a href="#footer" data-toggle="tab">FAQ</a></li>
												< ?php }
															if (in_array("SERVER_LINK_CONFIG", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab39)) { ?>class="active" < ?php } ?>><a href="#server_link" data-toggle="tab">Survey Link</a></li>
												< ?php }
															if (in_array("CONFIG_USER_GUIDE", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab31)) { ?>class="active" < ?php } ?>><a href="#user_guide" data-toggle="tab">User Guide</a></li>
												< ?php }

															if (in_array("CONFIG_BLACKLIST", $features_array)) { ?>
													<li < ?php if (isset($tab34)) { ?>class="active" < ?php } ?>><a href="#blacklist" data-toggle="tab">Blacklist</a></li>
												< ?php
															}
															if (in_array("PREPAID_MODULE_N", $mno_feature)) { ?>
													<li < ?php if (isset($tab40)) { ?>class="active" < ?php } ?>><a href="#api_config" data-toggle="tab">API Config</a></li>
												< ?php
															}
														}
														if ($user_type == 'MVNO_ADMIN') {
												?>

												<li < ?php if (isset($tab0)) { ?>class="active" < ?php } ?>><a href="#live_camp3" data-toggle="tab">Portal</a></li>


												< ?php if (in_array("CONFIG_PROFILE", $features_array)) { ?>
													<li < ?php if (isset($tab1)) { ?>class="active" < ?php } ?>><a href="#product_create" data-toggle="tab">Profile</a></li>
												< ?php }
															if (in_array("CONFIG_DURATION", $features_array)) { ?>
													<li < ?php if (isset($tab2)) { ?>class="active" < ?php } ?>><a href="#duration_create" data-toggle="tab">Duration</a></li>
												< ?php } ?>

												< ?php
															if (in_array("CONFIG_QOS", $features_array)) {

																//httpPost($camp_base_url . '/ajax/get_profile.php',$post_data);

																CommonFunctions::httpPost($camp_base_url . '/ajax/get_profile.php', $post_data);

												?>
													<li < ?php if (isset($tab42)) { ?>class="active" < ?php } ?>><a href="#qos_set" data-toggle="tab">QOS</a></li>
												< ?php } ?>

												<li < ?php if (isset($tab11)) { ?>class="active" < ?php } ?>><a href="#toc" data-toggle="tab">Guest T&C</a></li>


												< ?php if (in_array("VTENANT_TC", $features_array) && $package_functions->getSectionType('VTENANT_TYPE', $system_package) == '1') { ?>
													<li < ?php if (isset($tab32)) { ?>class="active" < ?php } ?>><a href="#vt_toc" data-toggle="tab">Vtenant T&C</a></li>
												< ?php } ?>

												< ?php if (in_array("CONFIG_GUEST_AUP", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab10)) { ?>class="active" < ?php } ?>><a href="#aup" data-toggle="tab">Guest AUP</a></li>
												< ?php } ?>

												<li < ?php if (isset($tab20)) { ?>class="active" < ?php } ?>><a href="#agreement2" data-toggle="tab">Activation T&C</a></li>

												<li < ?php if (isset($tab21)) { ?>class="active" < ?php } ?>><a href="#email" data-toggle="tab">Email Templates</a></li>

												< ?php if (in_array("CONFIG_PROPERTY_SETTINGS", $features_array)) { ?>
													<li < ?php if (isset($tab23)) { ?>class="active" < ?php } ?>><a href="#property_settings" data-toggle="tab">Property Settings</a></li>
												< ?php } ?>

												< ?php if (in_array("CONFIG_POWER", $features_array)) { ?>
													<li><a href="#power_shedule" data-toggle="tab">Power Schedule</a></li>
												< ?php }
															if (in_array("CONFIG_GUEST_FAQ", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab30)) { ?>class="active" < ?php } ?>><a href="#faq" data-toggle="tab">FAQ</a></li>
												< ?php }
															if (in_array("CONFIG_FOOTER", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab31)) { ?>class="active" < ?php } ?>><a href="#footer" data-toggle="tab">FAQ</a></li>
												< ?php }
															if (in_array("SERVER_LINK_CONFIG", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab39)) { ?>class="active" < ?php } ?>><a href="#server_link" data-toggle="tab">Survey Link</a></li>
												< ?php }
															if (in_array("CONFIG_USER_GUIDE", $features_array) || $system_package == 'N/A') { ?>
													<li < ?php if (isset($tab31)) { ?>class="active" < ?php } ?>><a href="#user_guide" data-toggle="tab">User Guide</a></li>
												< ?php }

															if (in_array("CONFIG_BLACKLIST", $features_array)) { ?>
													<li < ?php if (isset($tab34)) { ?>class="active" < ?php } ?>><a href="#blacklist" data-toggle="tab">Blacklist</a></li>
												< ?php }
															if (in_array("CONFIG_REGISTER", $features_array)) { ?>
													<li < ?php if (isset($tab22)) { ?>class="active" < ?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
											< ?php }

															echo '<br>';
														}

											?>-->

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

											<div id="system1_response">



											</div>


											<div <?php if (isset($tab34) && $user_type == 'MNO') { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="blacklist">

												<div class="support_head_visible" style="display:none;">
													<div class="header_hr"></div>
													<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
														Blacklist</div>
													<br class="hide-sm"><br class="hide-sm">
													<div class="header_f2" style="width: 100%;"> </div>
												</div>

												<div id="email_response"></div>



												<div id="response_d3">



												</div>




												<form onkeyup="blacklist_email_submitfn();" onchange="blacklist_email_submitfn();" id="edit-profile" method="post" action="?t=34">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<fieldset>
														<legend>Blacklist Content</legend>
														<h6>TAG Description </h6>
														Support Phone Number : {$support_number}
														<br><br>


														<div class="control-group">
															<label class="control-label" for="">Blacklist Headline</label>
															<div class="controls ">

																<?php
																$black_val = $db->textTitle('BLACKLIST_CONTENT', $user_distributor);

																if (strlen($black_val) == 0) {

																	$black_val = $db->textTitle("BLACKLIST_CONTENT", $system_package);
																}


																?>

																<input type="text" name="black_head" value="<?php echo $black_val; ?>">

															</div>

														</div>

														<div class="control-group">
															<label class="control-label" for="">Blacklist Text</label>
															<div class="controls ">

																<textarea class="blacklist_email_submit_tarea" width="100%" id="blacklist_email" name="blacklist_email"><?php
																																										$mail_format = $db->textVal('BLACKLIST_CONTENT', $user_distributor);

																																										if (strlen($mail_format) == 0) {

																																											$mail_format = $db->textVal("BLACKLIST_CONTENT", $system_package);
																																										}
																																										echo $mail_format;


																																										?></textarea>

															</div>

														</div>

														<div class="form-actions pd-zero-form-action">

															<input type="submit" value="Save" name="blacklist_email_submit" id="blacklist_email_submit" class="btn btn-primary">


														</div>
														<script>
															function blacklist_email_submitfn() {

																$("#blacklist_email_submit").prop('disabled', false);

															}
														</script>


														<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														<!-- /form-actions -->

													</fieldset>

												</form>





											</div>
											<?php if (in_array("PREPAID_MODULE_N", $mno_feature)) { ?>
												<div <?php if (isset($tab40)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="api_config">




													<h1 class="head qos-head">API Config<img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></h1>


													<div id="response_d3">
													</div>

													<?php if ($edit_qos_id == "1") {
														$readonly = "readonly";
													}

													?>


													<form id="sf-api_submit" class="form-horizontal" method="post" action="?t=40">
														<div class="control-group">
															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Api Url</label>


																<input class="form-control span4" id="sf_api_url" name="sf_api_url" type="text" placeholder="" value="<?php echo $sf_api_url; ?>">


															</div>

														</div>


														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">API Product</label>


																<input class="form-control span4" id="sf_code" name="sf_api_code" type="text" placeholder="ReadyNet" value="<?php echo $sf_api_code; ?>">



															</div>

														</div>

														<div class="form-actions" style="border-top: 0px !important; ">

															<button type="submit" id="sf_api_submit" name="sf_api_submit" class="btn btn-primary">Save</button>


															<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														</div>

													</form>



												</div>
											<?php }

											if (in_array("PREPAID_MODULE_N", $mno_feature)) { ?>
												<div <?php if (isset($tab36)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="sfproduct_set">




													<h1 class="head qos-head">Prepaid Product<img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></h1>


													<div id="response_d3">
													</div>

													<?php if ($edit_qos_id == "1") {
														$readonly = "readonly";
													}

													?>


													<form id="sf-profile_submit" class="form-horizontal" method="post" action="?t=36">

														<div class="control-group">
															<div class="controls col-lg-5 form-group">
																<label class="" for="radiobtns">AAA Product</label>
																<?php if ($edit_qos_id == 1) {
																	echo '<div class="sele-disable span4" ></div>';
																} ?>
																<select name="sf_profile" class="form-control span4" id="sf_profile" <?php echo $readonly; ?>>

																	<option value="">Select available Products</option>

																	<?php

																	$q1_1 = "SELECT * FROM exp_products
                                                            WHERE network_type='GUEST' AND mno_id='$user_distributor'";

																	$query_results_1 = $db->selectDB($q1_1);
																	//while ($sub_row = mysql_fetch_array($query_results_1)) {
																	foreach ($query_results_1['data'] as $sub_row) {
																		$sub_select = "";
																		$sub_dis_code = $sub_row[product_id];
																		$sub_dis_g_id = $sub_row[product_code];
																		$sub_dis_name = $sub_row[product_name];
																		if ($sf_code == $sub_dis_g_id) {
																			$sub_select = "selected";
																		}

																		echo "<option " . $sub_select . " value='" . $sub_dis_g_id . "'>" . $sub_dis_g_id . "</option>";
																	}
																	?>

																</select>
															</div>
														</div>

														<?php $array_sf_type = array(
															'2000' => 'ReadyNet200MB2D',
															"2001" => 'ReadyNet500MB4D',
															"2002" => "ReadyNet1GB7D",
															"2003" => "ReadyNet2GB14D"
														);
														?>
														<input class="form-control span4" id="sf_id" name="sf_id" type="hidden" value="<?php echo $sf_id; ?>">

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Description</label>


																<input class="form-control span4" id="sf_description" name="sf_description" type="text" placeholder="ReadyNet1GB7D" value="<?php echo $sf_description; ?>">



															</div>

														</div>

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Capacity</label>


																<input class="form-control span4" id="sf_capacity" name="sf_capacity" type="text" placeholder="1 GB" value="<?php echo $sf_name; ?>">



															</div>

														</div>

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Time</label>


																<input class="form-control span4" id="sf_time" name="sf_time" type="text" placeholder="7 DAYS" value="<?php echo $active_time; ?>">



															</div>

														</div>


														<div class="control-group">



															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Price</label>


																<input class="form-control span4" id="sf_price" name="sf_price" type="text" placeholder="100" value="<?php echo $sf_amount; ?>">



															</div>

														</div>

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Code</label>


																<input class="form-control span4" id="sf_code" name="sf_code" type="text" placeholder="2000" value="<?php echo $sfaccess_code; ?>">



															</div>

														</div>

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Premium</label>


																<input class="form-control span4" id="sf_enable_premium" name="sf_enable_premium" value="Yes" type="checkbox" <?php echo $sfis_premium; ?>>



															</div>

														</div>

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Active</label>


																<input class="form-control span4" id="sf_enable" name="sf_enable" value="Yes" type="checkbox" <?php echo $sfis_enable; ?>>



															</div>

														</div>

														<div class="form-actions" style="border-top: 0px !important; ">


															<?php if ($edit_sf_idd == "1") { ?>
																<button type="submit" id="sf_update" name="sf_update" class="btn btn-primary">Update</button>

																<!-- <button type="reset" id="" name="" class="btn btn-primary">Cancel</button> -->

																<input type="button" value="Cancel" onclick="window.location='?t=36';" class="btn btn-primary" name="">
															<?php } else { ?>
																<button type="submit" id="sf_submit" name="sf_submit" class="btn btn-primary">Save</button>
															<?php } ?>

															<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														</div>

													</form>


													<div class="widget tablesaw-widget widget-table action-table">
														<div class="widget-header">
															<!-- <i class="icon-th-list"></i> -->
															<h3>Prepaid Product</h3>
														</div>
														<!-- /widget-header -->
														<div class="widget-content table_response">
															<div style="overflow-x:auto;">
																<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																	<thead>
																		<tr>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="uppercase">Product</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Time</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Status</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 16px;margin-bottom: 6px;cursor: pointer;"></th>


																		</tr>
																	</thead>
																	<tbody>

																		<?php


																		$key_query = "SELECT * FROM exp_payment_products q
                                                            WHERE q.`currency` = 'SNAPFORC' AND q.`mno`='$user_distributor'";

																		//echo $key_query;

																		$query_results = $db->selectDB($key_query);
																		foreach ($query_results['data'] as $row) {
																			$id = $row[id];
																			$qos_code = $row[active_time];
																			$qos_name = $row[product_name];
																			$qos_id = $row[access_code];
																			$is_enable = $row[is_enable];

																			$network_type = $row[network_type];
																			$qos = '';

																			/*$q_desc_get = "SELECT description FROM `admin_access_roles` WHERE access_role = '$access_role'";
                                                $query_results_a=mysql_query($q_desc_get);
                                                while($row1=mysql_fetch_array($query_results_a)){
                                                    $access_role_desc = $row1[description];

                                                }*/


																			echo '<tr>
                                                <td> ' . $qos_name . ' </td>
                                                <td> ' . $qos_code . ' </td>';
																			if ($is_enable == 1) {
																				echo   '<td><div class="toggle1"><input checked onchange="" href="javascript:void();" style="width:0px" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
                                        <a id="ST_' . $id . '" href="javascript:void();" ><span class="toggle1-off-dis">OFF</span></a></div><script type="text/javascript">
                                                $(document).ready(function() {
                                                $(\'#ST_' . $id . '\').easyconfirm({locale: {
                                                        title: \'Disable\',
                                                        text: \'Are you sure you want to Disable this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                        button: [\'Cancel\',\' Confirm\'],
                                                        closeText: \'close\'
                                                         }});
                                                    $(\'#ST_' . $id . '\').click(function() {
                                                        window.location = "?token=' . $secret . '&t=36&is_enable=0&sfenable_id=' . $id . '"
                                                    });
                                                    });
                                                </script></td>';
																			} else {
																				echo   '<td><div class="toggle1"><input onchange="" type="checkbox" style="width:0px" class="hide_checkbox">
                                                                    <a href="javascript:void();" id="CE_' . $id . '"><span class="toggle1-on-dis">ON</span></a>
                                                                    <span class="toggle1-off">OFF</span>
                                                                    </div><script type="text/javascript">
                                                $(document).ready(function() {
                                                $(\'#CE_' . $id . '\').easyconfirm({locale: {
                                                        title: \'Activate\',
                                                        text: \'Are you sure you want to Activate this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                        button: [\'Cancel\',\' Confirm\'],
                                                        closeText: \'close\'
                                                         }});
                                                    $(\'#CE_' . $id . '\').click(function() {
                                                        window.location = "?token=' . $secret . '&t=36&is_enable=1&sfenable_id=' . $id . '"
                                                    });
                                                    });
                                                </script></td>';
																			}
																			/////////////////////////////////////////////

																			echo '<td><a href="javascript:void();" id="SFE_' . $id . '"  class="btn btn-small btn-primary">
                                                <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
                                                $(document).ready(function() {
                                                $(\'#SFE_' . $id . '\').easyconfirm({locale: {
                                                        title: \'Edit Product\',
                                                        text: \'Are you sure you want to edit this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                        button: [\'Cancel\',\' Confirm\'],
                                                        closeText: \'close\'
                                                         }});
                                                    $(\'#SFE_' . $id . '\').click(function() {
                                                        window.location = "?token=' . $secret . '&t=36&edit_sf_id=' . $id . '"
                                                    });
                                                    });
                                                </script></td>';
																			if (strlen($qos) < 1) {
																				echo '<td><a href="javascript:void();" id="RSU_' . $id . '"  class="btn btn-small btn-danger">
                                                <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
                                                $(document).ready(function() {
                                                $(\'#RSU_' . $id . '\').easyconfirm({locale: {
                                                        title: \'Remove Product\',
                                                        text: \'Are you sure you want to remove Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                        button: [\'Cancel\',\' Confirm\'],
                                                        closeText: \'close\'
                                                         }});
                                                    $(\'#RSU_' . $id . '\').click(function() {
                                                        window.location = "?token=' . $secret . '&t=36&rm_sf_id=' . $id . '"
                                                    });
                                                    });
                                                </script>';
																			} else {
																				echo '<td><a disabled href="javascript:void();" id="RSU_' . $id . '"  class="btn btn-small btn-danger">
                                                        <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a>';
																			}
																			echo '</td>';


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
											<?php }
											if (in_array("CONFIG_QOS", $features_array) || $system_package == 'N/A') { ?>
												<div <?php if (isset($tab42)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="qos_set">



													<div class="header_hr"></div>
													<h1 class="head qos-head">Override QoS<img data-toggle="tooltip" title="When creating a new property a product is set as the default for all vTenants. The product has a QoS and a Duration.The “Override QoS” feature allows the property admin to temporarily override the default product QoS for an individual account. As an example, a probation profile could be used to temporarily slow down the QoS due to late payment of rent" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></h1>


													<div id="response_d3">









													</div>

													<?php if ($edit_qos_id == "1") {
														$readonly = "readonly";
													}

													?>


													<form id="qos-profile_submit" class="form-horizontal" method="post" action="?t=42">

														<div class="control-group">
															<div class="controls col-lg-5 form-group">
																<label class="" for="radiobtns">QoS Profile</label>
																<?php if ($edit_qos_id == 1) {
																	echo '<div class="sele-disable span4" ></div>';
																} ?>
																<select name="qos_profile" class="form-control span4" id="qos_profile" <?php echo $readonly; ?>>

																	<option value="">Select available QoS Profile</option>

																	<?php

																	$q1_1 = "SELECT qos_id,qos_code,qos_name
                                                            FROM exp_qos
                                                            WHERE network_type='VTENANT' AND mno_id='$user_distributor'";

																	$query_results_1 = $db->selectDB($q1_1);
																	//while ($sub_row = mysql_fetch_array($query_results_1)) {
																	foreach ($query_results_1['data'] as $sub_row) {
																		$sub_select = "";
																		$sub_dis_code = $sub_row[qos_id];
																		$sub_dis_g_id = $sub_row[qos_code];
																		$sub_dis_name = $sub_row[qos_name];

																		if ($qos_code == $sub_dis_g_id) {
																			$sub_select = "selected";
																		}

																		echo "<option " . $sub_select . " value='" . $sub_dis_g_id . "'>" . $sub_dis_g_id . "</option>";
																	}
																	?>

																</select>
															</div>
														</div>
														<div class="controls col-lg-5 form-group" style="margin-top: -25px; margin-bottom: 15px; display: none;">


															<?php

															$json_sync_fields = $package_functions->getOptions('SYNC_PRODUCTS_FROM_AAA', $system_package);
															$sync_array = json_decode($json_sync_fields, true);

															?>
															<style>
																@media (max-width: 520px) {
																	.qos-sync-button {
																		margin-bottom: 15px;
																		 !important;
																	}
																}

																@media (min-width: 520px) {
																	.qos-sync-button {
																		margin-top: 20px;
																		 !important;
																		float: right;
																		margin-right: 22%;
																	}
																}
															</style>

															<a <?php if ($sync_array['g_QOS_sync'] == 'display') {
																	echo 'style="display: inline-block;padding: 6px 20px !important;"';
																} else {
																	echo 'style="display:none"';
																} ?> onclick="gotoSync();" class="btn btn-primary qos-sync-button" style="align: left;"><i class="btn-icon-only icon-refresh"></i>
																Sync</a>
															<div style="display: inline-block" id="sync_loader"></div>


														</div>
														<script type="text/javascript">
															function gotoSync() {

																//var a = scrt_var.length;


																document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
																//window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

																$.ajax({
																	type: 'POST',
																	url: 'ajax/get_profile.php',
																	data: {
																		sync_type: "qos_new_sync",
																		user_distributor: "<?php echo $user_distributor; ?>",
																		system_package: "<?php echo $system_package; ?>",
																		user_name: "<?php echo $user_name; ?>"
																	},
																	success: function(data) {

																		//alert(data); 


																		$('#qos_profile').empty();
																		$("#qos_profile").append(data);


																		document.getElementById("sync_loader").innerHTML = "";

																	},
																	error: function() {
																		document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
																	}

																});





															}
														</script>
														<?php $array_qos_type = array(
															'VT-Probation' => 'Probation',
															"VT-Premium" => 'Premium'
														);
														?>
														<div class="control-group">
															<div class="controls col-lg-5 form-group">
																<label class="" for="radiobtns">QoS Category</label>
																<select name="qos_category" class="form-control span4" id="qos_category">

																	<option value="">Select Category</option>
																	<?php
																	foreach ($array_qos_type as $key => $value) {
																		if ($network_type == $key) {
																			$selected_qos = "selected";
																			echo "<option " . $selected_qos . " value=" . $key . ">" . $value . "</option>";
																		} else {
																			echo "<option value=" . $key . ">" . $value . "</option>";
																		}
																	}
																	?>


																</select>

															</div>

														</div>
														<input class="form-control span4" id="qos_id" name="qos_id" type="hidden" value="<?php echo $qos_id; ?>">

														<div class="control-group">


															<div class="controls col-lg-5 form-group">

																<label class="" for="radiobtns">Description</label>


																<input class="form-control span4" id="qos_description" name="qos_description" type="text" value="<?php echo $qos_name; ?>">



															</div>

														</div>

														<div class="form-actions" style="border-top: 0px !important; ">


															<?php if ($edit_qos_id == "1") { ?>
																<button type="submit" id="qos_update" name="qos_update" class="btn btn-primary">Update</button>

																<!-- <button type="reset" id="" name="" class="btn btn-primary">Cancel</button> -->

																<input type="button" value="Cancel" onclick="window.location='?t=1';" class="btn btn-primary" name="">
															<?php } else { ?>
																<button type="submit" id="qos_submit" name="qos_submit" class="btn btn-primary">Save</button>
															<?php } ?>

															<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														</div>

													</form>


													<div class="widget tablesaw-widget widget-table action-table">
														<div class="widget-header">
															<!-- <i class="icon-th-list"></i> -->
															<h3>Active QOS</h3>
														</div>
														<!-- /widget-header -->
														<div class="widget-content table_response">
															<div style="overflow-x:auto;">
																<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																	<thead>
																		<tr>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="uppercase">QoS PROFILE</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Description</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove <img data-toggle="tooltip" title="If a QoS has been assigned and is in use by a property it cannot be removed. Please deactivate the QoS to enable removal." src="layout/ATT/img/help.png" style="width: 16px;margin-bottom: 6px;cursor: pointer;"></th>


																		</tr>
																	</thead>
																	<tbody>

																		<?php


																		$key_query = "SELECT q.`id`,q.`qos_id`,q.`qos_code`,q.`qos_name`,`network_type` FROM exp_qos q
															WHERE q.`network_type` <> 'VTENANT' AND q.`mno_id`='$user_distributor'";

																		//echo $key_query;

																		$query_results = $db->selectDB($key_query);
																		foreach ($query_results['data'] as $row) {
																			$id = $row[id];
																			$qos_code = $row[qos_code];
																			$qos_name = $row[qos_name];
																			$qos_id = $row[qos_id];

																			$network_type = $row[network_type];
																			$qos = $db->getValueAsf("SELECT qos_id as f FROM exp_qos_distributor WHERE qos_id='$qos_id'");


																			/*$q_desc_get = "SELECT description FROM `admin_access_roles` WHERE access_role = '$access_role'";
												$query_results_a=mysql_query($q_desc_get);
												while($row1=mysql_fetch_array($query_results_a)){
													$access_role_desc = $row1[description];

												}*/


																			echo '<tr>
												<td> ' . $qos_code . ' </td>
												<td> ' . $qos_name . ' </td>';
																			/////////////////////////////////////////////

																			echo '<td><a href="javascript:void();" id="APE_' . $id . '"  class="btn btn-small btn-primary">
												<i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
												$(document).ready(function() {
												$(\'#APE_' . $id . '\').easyconfirm({locale: {
														title: \'Edit User\',
														text: \'Are you sure you want to edit this QoS?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
														button: [\'Cancel\',\' Confirm\'],
														closeText: \'close\'
													     }});
													$(\'#APE_' . $id . '\').click(function() {
														window.location = "?token=' . $secret . '&t=42&edit_id=' . $id . '"
													});
													});
												</script></td>';
																			if (strlen($qos) < 1) {
																				echo '<td><a href="javascript:void();" id="RU_' . $id . '"  class="btn btn-small btn-danger">
	                                            <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">
	                                            $(document).ready(function() {
	                                            $(\'#RU_' . $id . '\').easyconfirm({locale: {
	                                                    title: \'Remove User\',
	                                                    text: \'Are you sure you want to remove QoS?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
	                                                    button: [\'Cancel\',\' Confirm\'],
	                                                    closeText: \'close\'
	                                                     }});
	                                                $(\'#RU_' . $id . '\').click(function() {
	                                                    window.location = "?token=' . $secret . '&t=42&qos_rm_id=' . $id . '"
	                                                });
	                                                });
	                                            </script>';
																			} else {
																				echo '<td><a disabled href="javascript:void();" id="RU_' . $id . '"  class="btn btn-small btn-danger">
	                                            		<i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a>';
																			}
																			echo '</td>';


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
											<?php }
											if (in_array("SERVER_LINK_CONFIG", $features_array)) { ?>
												<div class="tab-pane <?php if (isset($tab39)) { ?>active <?php } ?>" id="server_link">


													<div id="response_d3">

														<?php




														$footerq = "SELECT * FROM `exp_footer` WHERE `distributor`='$user_distributor'";

														$footer_results1 = $db->selectDB($footerq);

														//while($rowf=mysql_fetch_array($footer_results1)){
														foreach ($footer_results1['data'] as $rowf) {

															$editftype = $rowf[footer_type];
															$editgtitle = $rowf[group_title];
															$editlinktitle = $rowf[link_title];
															$editfurl = $rowf[url];
														}


														?>

													</div>


													<form onkeyup="server_submitfn();" onchange="server_submitfn();" id="server_form" name="server_form" method="post" action="?t=39" class="">

														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>

														<fieldset>



															<input type="hidden" value="link" name="server_type">
															<input type="hidden" value="Need Help?" name="server_title">
															<input type="hidden" value="faq" name="server_link_title">



															<div class="control-group" id="server_url">
																<label class="control-label" for="gt_mvnx">URL</label>
																<div class="controls ">


																	<textarea style="width: 100%;" placeholder="http://www.google.com" id="server_url" name="server_url" required><?php echo $editfurl; ?></textarea>

																</div>
															</div>

															<div class="form-actions">

																<button disabled type="submit" name="server_link_submit" id="server_link_submit" class="btn btn-primary">Save</button>

															</div>

															<script>
																function server_submitfn() {
																	//alert("fn");
																	$("#server_link_submit").prop('disabled', false);
																}
															</script>

														</fieldset>
													</form>



												</div>
											<?php }
											if (in_array("CONFIG_FOOTER", $features_array)) { ?>
												<div class="tab-pane <?php if (isset($tab31)) { ?>active <?php } ?>" id="footer">


													<div id="response_d3">

														<?php




														$footerq = "SELECT * FROM `exp_footer` WHERE `distributor`='$user_distributor'";

														$footer_results1 = $db->selectDB($footerq);

														//while($rowf=mysql_fetch_array($footer_results1)){
														foreach ($footer_results1['data'] as $rowf) {

															$editftype = $rowf[footer_type];
															$editgtitle = $rowf[group_title];
															$editlinktitle = $rowf[link_title];
															$editfurl = $rowf[url];
														}


														?>

													</div>


													<form onkeyup="footer_submitfn();" onchange="footer_submitfn();" id="footer_form" name="footer_form" method="post" action="?t=31" class="">

														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>

														<fieldset>



															<input type="hidden" value="link" name="footer_type">
															<input type="hidden" value="Need Help?" name="group_title">
															<input type="hidden" value="faq" name="link_title">



															<div class="control-group" id="foot_ur">
																<label class="control-label" for="gt_mvnx">URL</label>
																<div class="controls ">


																	<textarea style="width: 100%;" placeholder="http://www.google.com" id="footer_url" name="footer_url" required><?php echo $editfurl; ?></textarea>

																</div>
															</div>

															<div class="form-actions">

																<button disabled id="footer_submit" type="submit" name="footer_submit" id="footer_submit" class="btn btn-primary">Save</button>

															</div>

															<script>
																function footer_submitfn() {
																	//alert("fn");
																	$("#footer_submit").prop('disabled', false);
																}
															</script>

														</fieldset>
													</form>



												</div>
											<?php } ?>


											<?php if (in_array("CONFIG_USER_GUIDE", $features_array)) { ?>
												<div class="tab-pane <?php if (isset($tab31)) { ?>active <?php } ?>" id="user_guide">


													<div id="response_d3">

														<?php




														$footerq = "SELECT * FROM `exp_footer` WHERE `distributor`='$user_distributor'";

														//$footer_results1=mysql_query($footerq);
														$footer_results1 = $db->selectDB($footerq);

														//while($rowf=mysql_fetch_array($footer_results1)){
														foreach ($footer_results1['data'] as $rowf) {

															$editftype = $rowf[footer_type];
															$editgtitle = $rowf[group_title];
															$editlinktitle = $rowf[link_title];
															$editfurl = $rowf[url];
														}


														?>

													</div>


													<form onkeyup="user_guide_submitfn();" onchange="user_guide_submitfn();" id="footer_form" name="footer_form" method="post" action="?t=31" class="form-horizontal">

														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>

														<fieldset>



															<input type="hidden" value="link" name="footer_type">
															<input type="hidden" value="Need Help?" name="group_title">
															<input type="hidden" value="faq" name="link_title">



															<div class="control-group" id="foot_ur">
																<label class="control-label" for="gt_mvnx">URL</label>
																<div class="controls ">


																	<textarea style="width: 100%;" placeholder="http://www.google.com" id="user_guide_url" name="user_guide_url" required><?php echo $editfurl; ?></textarea>

																</div>
															</div>

															<div class="form-actions">

																<button disabled id="user_guide_submit" type="submit" name="user_guide_submit" class="btn btn-primary">Save</button>

															</div>

															<script>
																function user_guide_submitfn() {
																	//alert("fn");
																	$("#user_guide_submit").prop('disabled', false);
																}
															</script>

														</fieldset>
													</form>



												</div>
											<?php } ?>



											<!--====================== FAQ ======================-->
											<?php if (in_array("CONFIG_GUEST_FAQ", $features_array)) { ?>
												<div class="tab-pane <?php if (isset($tab30)) { ?>active <?php } ?>" id="faq">


													<form id="faq_form1" name="faq_form1" method="post" action="?t=30" class="form-horizontal">
														<fieldset>
															<div class="control-group" id="">
																<label class="control-label" for="gt_mvnx">Title</label>
																<div class="controls ">
																	<input class="span6" style="" type="text" name="faq_title" required value="<?php if ($edit_faq == '1') {
																																					echo $edit_faq_details['text'];
																																				} ?>">

																</div>
															</div>
															<div class="control-group" id="">
																<label class="control-label" for="gt_mvnx">Description</label>
																<div class="controls ">
																	<textarea class="span6" style="height: 80px !important;" name="faq_content" required><?php if ($edit_faq == '1') {
																																								echo $edit_faq_details['content'];
																																							} ?></textarea>

																</div>
															</div>

															<input type="hidden" name="faq_submit_secret" value="<?php echo $_SESSION['FORM_SECRET'] ?>">
															<div class="form-actions">
																<?php
																if ($edit_faq == '1') {
																	echo '<button type="submit" name="faq_update" id="faq_update"  class="btn btn-primary">Update</button>';
																	echo '<input type="hidden" name="faq_update_code" value="' . $edit_faq_code . '"  class="btn btn-primary">';
																} else {
																	echo '<button type="submit" name="faq_submit" id="faq_submit"  class="btn btn-primary">Save</button>';
																}

																?>
															</div>

														</fieldset>
													</form>
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>FAQ</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">FAQ Title</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">View</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>

																	</tr>
																</thead>
																<tbody>
																	<?php

																	$faqClassFunInit = new faq_functions();

																	$faq_array = $faqClassFunInit->getMNOfaq($user_distributor);

																	//print_r($faq_array);
																	foreach ($faq_array as $faq_row) {
																		echo '<tr>';

																		echo '<td>' . $faq_row['text'] . '</td>';
																		echo '<td><a class="faq_content_fancy" href="#fancyid_' . $faq_row['unique_id'] . '" >View</a></td>';
																		echo '<div style="display: none" id="fancyid_' . $faq_row['unique_id'] . '"><p class="fancy-text">' . $faq_row['content'] . '</p><button class="fancy_close btn btn-primary" style="display: none">Close</button></div>';
																		echo '<td>
                                                            <a href="javascript:void();" id="faq_edit_' . $faq_row['unique_id'] . '"  class="btn btn-small btn-primary">Edit
															<i class="btn-icon-only icon-pencil"></i> </a>
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                             $(\'#faq_edit_' . $faq_row['unique_id'] . '\').easyconfirm({locale: {
																				title: \'Edit FAQ\',
																				text: \'Are you sure you want to edit this FAQ ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});

                                                                $(\'#faq_edit_' . $faq_row['unique_id'] . '\').click(function() {
                                                                  
                                                                    window.location = "?t=30&edit_faq_code=' . $faq_row['unique_id'] . '&faqsecret=' . $secret . '"
                                                                });
                                                                });
                                                            </script>
                                                                        </td>';

																		echo '<td>
                                                            <a href="javascript:void();" id="faq_remove_' . $faq_row['unique_id'] . '"  class="btn btn-small btn-danger">Remove
															<i class="btn-icon-only icon-circle"></i> </a>
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                             $(\'#faq_remove_' . $faq_row['unique_id'] . '\').easyconfirm({locale: {
																				title: \'Remove FAQ\',
																				text: \'Are you sure you want to remove this FAQ ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});

                                                                $(\'#faq_remove_' . $faq_row['unique_id'] . '\').click(function() {
                                                                  
                                                                    window.location = "?t=30&delete_faq_code=' . $faq_row['unique_id'] . '&faqsecret=' . $secret . '"
                                                                });
                                                                });
                                                            </script>
                                                                        </td>';



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
									<?php } ?>
									<!-- ============== FAQ ==================== -->



									<!-- /* +++++++++++++++++++++++++++++++++++++purge logs
....................................... User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if (isset($tab7)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="purge_logs">
										<br>
										<form id="activity_log" name="purgr_logs" method="post" class="form-horizontal" action="?t=7">
											<fieldset>

												<div id="response_d3">
													<?php
													/* if(isset($_SESSION['msg7'])){
													   echo $_SESSION['msg7'];
													   unset($_SESSION['msg7']);


													  }*/

													$archive_path = $db->setVal('LOGS_FILE_DIR', 'ADMIN');

													$query_purge11 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'DB' GROUP BY `type`,`last_run_days`";

													//$query_results11_mod=mysql_query($query_purge11);
													$query_results11_mod = $db->selectDB($query_purge11);

													// while($row1=mysql_fetch_array($query_results1_mod)){
													foreach ($query_results11_mod['data'] as $row1) {
														$last_run_days1 = $row1[last_run_days];
													}




													$query_purge2 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'archive_db' GROUP BY `type`,`last_run_days`";

													//$query_results2_mod=mysql_query($query_purge2);
													$query_results2_mod = $db->selectDB($query_purge2);


													//while($row2=mysql_fetch_array($query_results2_mod)){
													foreach ($query_results2_mod['data'] as $row2) {
														$last_run_days2 = $row2[last_run_days];
													}


													$log_older_days = $db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='DB'");
													$archive_log_days = $db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='archive_db'");


													?>
												</div>
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />


												<h3>Archive DB logs</h3><br>
												<div class="control-group">
													<label class="control-label" for="limit3">Logs Older Than</label>
													<div class="controls">
														<?php echo '<input class="span2" id="log_older_days" name="log_older_days" value="' . $log_older_days . '" type="number" min="3" max="365" required step="1" >' ?> Days
													</div>
												</div>

												<h3>Permanently remove archived logs</h3><br>
												<div class="control-group">
													<label class="control-label" for="limit3">Archive Logs Older Than</label>
													<div class="controls">
														<?php echo '<input class="span2" id="archive_log_days" name="archive_log_days" value="' . $archive_log_days . '" type="number" min="3" max="365" required step="1">' ?> Days
													</div>
												</div>


												<h3>Archive directory</h3><br>
												<div class="control-group">
													<label class="control-label">Directory Path</label>
													<div class="controls">
														<?php echo '<input class="span2" id="archive_log_path" name="archive_log_path" type="text" required value="' . $archive_path . '">'; ?>
														<small>
															<font color="red">Folder permission should be granted</font>
														</small>
													</div>
												</div>



												<div class="form-actions">
													<button type="submit" name="purge_now" id="purge_now" class="btn btn-primary">Save</button>
												</div>

											</fieldset>
										</form>



										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->

												<h3>Archive Information</h3>

											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;">
													<table class="table table-striped table-bordered">
														<thead>
															<tr>
																<th>Logs</th>
																<!-- <th>DB usage (Estimated)</th> -->
																<th>Last archived date</th>


															</tr>
														</thead>
														<tbody>

															<?php

															$base_purge_query = "SELECT * FROM `admin_purge_logs` WHERE is_enable=1";
															//$query_results0 = mysql_query($base_purge_query);
															$query_results0 = $db->selectDB($base_purge_query);

															$fsize = 0;
															//while($row=mysql_fetch_array($query_results0)){

															foreach ($query_results0['data'] as $row) {

																$log_name = $row[log_name];
																$last_run = $row[last_run];
																$dt2 = new DateTime($last_run);
																$last_run = $dt2->format('m/d/Y h:i:s A');
																$table_name = $row[system_table_name];
																$date_column = $row[date_column];
																$last_run_days = $row[last_run_days];


																$log_purge_q = "SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 2) `size`
														FROM information_schema.TABLES
														WHERE table_schema = '$db_name' AND table_name = '$table_name'";
																//$query_results111 = mysql_query($log_purge_q);

																$query_results111 = $db->selectDB($log_purge_q);

																//while($row2=mysql_fetch_array($query_results111)){
																foreach ($query_results111['data'] as $row2) {

																	$size = $row2[size];
																	$fsize = $fsize + $size;
																}

																echo '<tr>
														<td> ' . $log_name . ' </td>';
																//echo '<td> '.$size.' MB </td>';
																echo '<td> ' . $last_run . ' </td>
														</tr>';
															}





															?>





														</tbody>
													</table>
												</div>
											</div>
											<!-- /widget-content -->
										</div>
									</div>



									<?php

									//Form Refreshing avoid secret key/////
									//$secret=md5(uniqid(rand(), true));
									//$_SESSION['FORM_SECRET'] = $secret;


									?>
									<!--------------------------------------------------------------------------------------->


									<div class="tab-pane" id="create_camp">

										<div id="network_response"></div>

										<form id="edit-profile" class="form-horizontal">

											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

											?>

											<fieldset>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Network Profile</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<select name="network_name" id="network_name" required>



																<?php



																$network_name = $db->setVal("network_name", "ADMIN");

																//$get_2 = "SELECT `description` as f FROM exp_plugins WHERE plugin_code = '$network_name' AND `type` = 'NETWORK' LIMIT 1";

																echo '<option value="' . $network_name . '">' . $network_name . '</option>';

																$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `network_profile` <> '$network_name' AND `visible` = 1 ORDER by network_profile";



																//$query_results=mysql_query($key_query);
																$query_results = $db->selectDB($key_query);



																//while($row=mysql_fetch_array($query_results)){

																foreach ($query_results['data'] as $row) {

																	$network_profile = $row[network_profile];

																	//$description = $row[description];

																	echo '<option value="' . $network_profile . '">' . $network_profile . '</option>';
																}



																?>



															</select>



														</div>



														<button type="button" name="submit" onclick="getInfoBox('network','network_response');" class="btn btn-primary">Activate</button>



														<img id="network_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



													</div>



													<!-- /controls -->



												</div>







												<!-- /control-group -->



											</fieldset>



										</form>





										<hr>



										<!--  __________________________________________________________ -->



										<form class="form-horizontal">



											<fieldset>





												<div class="control-group">







													<label class="control-label" for="radiobtns">Network Profile</label>
													<div class="controls">

														<div class="input-prepend input-append">


															<select name="network_edit" id="network_edit" required>

																<?php
																$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `visible` = 1";

																//$query_results=mysql_query($key_query);

																$query_results = $db->selectDB($key_query);



																//while($row=mysql_fetch_array($query_results)){
																foreach ($query_results['data'] as $row) {



																	$network_profile = $row[network_profile];



																	//$description = $row[description];



																	echo '<option value="' . $network_profile . '">' . $network_profile . '</option>';
																}



																?>



															</select>



														</div>



														<button type="button" name="submit1" onclick="editNetPro();" class="btn btn-warning" id="edit">Edit</button>







														<img id="network_edit_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



													</div>



												</div>



											</fieldset>



										</form>



										<div id="editable"></div>



									</div>





									<!-- ==================== toc ========================= -->

									<div <?php if (isset($tab11)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="toc">


										<div class="support_head_visible" style="display:none;">
											<div class="header_hr"></div>
											<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
												Guest Terms and Conditions</div>
											<br class="hide-sm"><br class="hide-sm">
											<div class="header_f2" style="width: 100%;"> </div>
										</div>

										<div id="response_">

										</div>

										<form id="submit_toc" method="POST" action="?t=11">


											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
											$email_template = $db_class1->getEmailTemplate('TOC', $system_package, 'MNO', $user_distributor);
											$subject = $email_template[0][title];
											$mail_text  = $email_template[0][text_details];
											echo '<input id="tc_code" name="tc_code" type="hidden"  value="TOC">';
											echo '<input id="tc_distributor" name="tc_distributor" type="hidden"  value="' . $user_distributor . '">';


											?>

											<fieldset>



												<!-- <legend>Guest Terms and Conditions</legend> -->

												<?php

												if ($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE', $system_package) == "1") {

												?>

													<div class="control-group">
														<label class="control-label" for="location_name1">Business Vertical<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls col-lg-5 form-group">

															<select class="span4 form-control" id="business_type" name="business_type" onchange="select_vertical(this.value);">

																<option value="All">ALL PROPERTIES</option>
																<?php

																$business_vertical = $package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package);
																$business_verticalarr = json_decode($business_vertical,true);
																if (!empty($business_verticalarr)) {
																	foreach ($business_verticalarr as $key => $value) {
																		if ($edit_distributor_business_type == $key) {?>
																			<option selected value="<?php echo $key; ?>"><?php echo $key; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
																		<?php
																		}
																	}
																}
																else if (!empty($business_vertical)) {
																	$business_vertical_array = explode(',', $business_vertical);
																	$bvlength = count($business_vertical_array);
																	for ($b = 0; $b < $bvlength; $b++) {
																		if ($edit_distributor_business_type == $business_vertical_array[$b]) {
																?>
																			<option selected value="<?php echo $business_vertical_array[$b]; ?>"><?php echo $business_vertical_array[$b]; ?></option>
																		<?php
																		} else {
																		?>
																			<option value="<?php echo $business_vertical_array[$b]; ?>"><?php echo $business_vertical_array[$b]; ?></option>
																		<?php
																		}
																	}
																} else {

																	$get_businesses_q = "SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
																	//$get_businesses_r=mysql_query($get_businesses_q);
																	$get_businesses_r = $db->selectDB($get_businesses_q);

																	//while($get_businesses=mysql_fetch_assoc($get_businesses_r)){
																	foreach ($get_businesses_r['data'] as $get_businesses) {
																		$get_business = $get_businesses['business_type'];
																		if ($edit_distributor_business_type == $get_business) {
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
															<div style="display: inline-block" id="loader"></div>
														</div>

													</div>
													<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
													<script>
														function select_vertical(vertical) {

															if (vertical == 'All') {
																document.getElementById("submit_toc_btn").disabled = true;
															} else {
																submit_tocfn();
															}
															document.getElementById("loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
															$.ajax({
																type: 'POST',
																url: 'ajax/getTerms.php',
																dataType: 'html',
																data: {
																	vertical: vertical,
																	user_name: "<?php echo $user_name; ?>",
																	user_type: "<?php echo $user_type; ?>",
																	user_distributor: "<?php echo $user_distributor; ?>",
																	system_package: "<?php echo $system_package; ?>"
																},
																success: function(data) {


																	//tinymce.activeEditor.setContent('<span>some</span> html');


																	tinymce.remove();
																	//tinymce.init({selector: "textarea.submit_arg1ta"}); 
																	//eval(document.getElementById('tinymce_editors'));
																	initTinymces();
																	$('#vertical_terms').empty().append(data);
																	//eval(document.getElementById('ajax_load_tc'));
																	//tinymce.get('toc1').setContent("data");




																	document.getElementById("loader").innerHTML = "";

																}
																/* ,
																         error: function(){
																             document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
																         } */

															});

														}
													</script>

												<?php } else {
													echo '<input id="business_type" name="business_type" type="hidden"  value="All">';
												} ?>

												<div id="vertical_terms">



													<?php if ($package_functions->getSectionType('CAPTIVE_TOC_TYPE', $system_package) == "checkbox") {
														$text_arr = $db->textVal('TOC', $user_distributor);
														$text_arr1 = json_decode($text_arr, true);

													?>

														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">TOC 1</label>

															<div class="controls col-lg-5 ">
																<textarea width="100%" id="toc1" name="toc1" class="span6"><?php print_r($text_arr1['toc1']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">TOC 2</label>
															<div class="controls col-lg-5 ">
																<textarea width="100%" id="toc2" name="toc2" class="span6"><?php print_r($text_arr1['toc2']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">TOC 3</label>
															<div class="controls col-lg-5 ">
																<textarea width="100%" id="toc3" name="toc3" class="span6"><?php print_r($text_arr1['toc3']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">TOC 4</label>
															<div class="controls col-lg-5 ">
																<textarea width="100%" id="toc4" name="toc4" class="span6"><?php print_r($text_arr1['toc4']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">TOC 5</label>
															<div class="controls col-lg-5 ">
																<textarea width="100%" id="toc5" name="toc5" class="span6"><?php print_r($text_arr1['toc5']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">SUBMIT</label>
															<div class="controls col-lg-5 ">
																<textarea width="100%" id="submit" name="submit" class="span6"><?php print_r($text_arr1['submit']); ?></textarea>
															</div>
														</div>
														<div class="control-group" id="feild_gp_taddg_divt1">
															<label class="control-label" for="gt_mvnx">CANCEL</label>
															<div class="controls col-lg-5">
																<textarea width="100%" id="cancel" name="cancel" class="span6"><?php print_r($text_arr1['cancel']); ?></textarea>
															</div>
														</div>


													<?php } else {


														if ($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE', $system_package) == "0") {

															/* 	$toc_val = $db->textVal('TOC',$system_package);

												}else{ */
															//echo 'Ok';
															$toc_val = $db->textVal('TOC', $user_distributor);
															if (empty($toc_val)) {
																$toc_val = $db->textVal('TOC', $system_package);
															}
														} else {
															//$toc_val = $db->textVal('TOC',$user_distributor);
															$toc_val = $db->textVal_vertical('TOC', $user_distributor, 'All');
															if (empty($toc_val)) {
																$toc_val = $db->textVal_vertical('TOC', $system_package, 'All');
															}
														}

													?>

														<textarea width="100%" id="toc1" name="toc1" class="submit_tocta"><?php echo  $toc_val; ?></textarea>


													<?php } ?>

												</div>

												<div class="form-actions pd-zero-form-action">

													<button disabled type="submit" id="submit_toc_btn" name="submit_toc" class="btn btn-primary">Save</button>







													<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



												</div>
												<script>
													function submit_tocfn() {
														$("#submit_toc_btn").prop('disabled', false);
														<?php

														//if($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE',$system_package)=="1"){

														?>
														//	var bt=$("#business_type").val();

														/* if(bt == 'All'){
															$("#submit_toc_btn").prop('disabled', true);
														}else{
															$("#submit_toc_btn").prop('disabled', false);
														} */
														<?php //}else{ 
														?>
														/* $("#submit_toc_btn").prop('disabled', false); */

														<?php // } 
														?>
													}
												</script>











												<!-- /form-actions -->







											</fieldset>







										</form>



									</div>




									<!-- ==================== VT toc ========================= -->

									<div <?php if (isset($tab32)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="vt_toc">

										<div id="response_">

										</div>

										<form onkeyup="vt_submit_tocfn();" onchange="vt_submit_tocfn();" id="vt_submit_toc" method="POST" action="?t=32">


											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
											$email_template = $db->getEmailTemplate('VT_TOC', $system_package, 'MNO', $user_distributor);
											$subject = $email_template[0][title];
											$mail_text  = $email_template[0][text_details];
											echo '<input id="email_code" name="email_code" type="hidden"  value="VT_TOC">';
											echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';


											?>

											<fieldset>



												<legend>Vtenant Terms and Conditions</legend>





												<?php if ($package_functions->getSectionType('CAPTIVE_TOC_TYPE', $system_package) == "checkbox") {
													$text_arr = $db->textVal('VT_TOC', $user_distributor);
													$text_arr1 = json_decode($text_arr, true);

												?>

													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">TOC 1</label>

														<div class="controls col-lg-5 ">
															<textarea width="100%" id="toc1" name="toc1" class="span6"><?php print_r($text_arr1['toc1']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">TOC 2</label>
														<div class="controls col-lg-5 ">
															<textarea width="100%" id="toc2" name="toc2" class="span6"><?php print_r($text_arr1['toc2']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">TOC 3</label>
														<div class="controls col-lg-5 ">
															<textarea width="100%" id="toc3" name="toc3" class="span6"><?php print_r($text_arr1['toc3']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">TOC 4</label>
														<div class="controls col-lg-5 ">
															<textarea width="100%" id="toc4" name="toc4" class="span6"><?php print_r($text_arr1['toc4']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">TOC 5</label>
														<div class="controls col-lg-5 ">
															<textarea width="100%" id="toc5" name="toc5" class="span6"><?php print_r($text_arr1['toc5']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">SUBMIT</label>
														<div class="controls col-lg-5 ">
															<textarea width="100%" id="submit" name="submit" class="span6"><?php print_r($text_arr1['submit']); ?></textarea>
														</div>
													</div>
													<div class="control-group" id="feild_gp_taddg_divt1">
														<label class="control-label" for="gt_mvnx">CANCEL</label>
														<div class="controls col-lg-5">
															<textarea width="100%" id="cancel" name="cancel" class="span6"><?php print_r($text_arr1['cancel']); ?></textarea>
														</div>
													</div>


												<?php } else {
												?>

													<textarea width="100%" id="toc1" name="email1" class="submit_vttocta"><?php echo $mail_text; ?></textarea>











												<?php } ?>

												<div class="form-actions pd-zero-form-action">

													<button disabled type="submit" id="vttoc_form_update" name="vttoc_form_update" class="btn btn-primary">Save</button>







													<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



												</div>
												<script>
													function vt_submit_tocfn() {

														$("#vttoc_form_update").prop('disabled', false);
													}
												</script>











												<!-- /form-actions -->







											</fieldset>







										</form>



									</div>




									<!-- ==================== sys_controllers ========================= -->

									<div <?php if (isset($tab112)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="sys_controllers">

										<div id="response_">



										</div>



										<form id="sys_controllers_form" class="form-horizontal" method="POST" action="?t=112">



											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

											?>

											<div class="control-group">

												<label class="control-label" for="radiobtns">Max Sessions Per Day</label>

												<div class="controls col-lg-5">

													<div class="input-prepend input-append">

														<input class="span4" id="max_ses_per_day" name="max_ses_per_day" type="number" required value="<?php echo $db->setVal('max_sessions', $user_distributor); ?>">

													</div>

												</div>

											</div>



											<div class="control-group">

												<label class="control-label" for="radiobtns">Message</label>

												<div class="controls col-lg-5">

													<div class="input-prepend input-append">

														<textarea width="100%" id="msg_max_ses" name="msg_max_ses" class="jqte-test"><?php echo $db->setVal('max_sessions_text', $user_distributor); ?></textarea>



													</div>

												</div>

											</div>



											<div class="form-actions">

												<button type="submit" name="submit_sys_con" class="btn btn-primary">Save</button>

												<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

											</div>









										</form>



									</div>


									<!-- =================== aup ============================ -->

									<!-- <div class="tab-pane" id="aup"> -->
									<?php if (in_array("CONFIG_GUEST_AUP", $features_array) || $system_package == 'N/A') { ?>
										<div <?php if (isset($tab10)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="aup">







											<div id="response_d3">









											</div>



											<form id="edit-profile" class="form-horizontal" method="post" action="?t=10">











												<?php







												/*$secret=md5(uniqid(rand(), true));



										$_SESSION['FORM_SECRET2'] = $secret;*/







												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';







												?>







												<fieldset>




















													<div class="control-group">
														<label class="control-label" for="radiobtns">AUP Link Title<sup>
																<font color="#FF0000"></font>
															</sup></label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span5" id="title" name="title" type="text" value="<?php echo $db->textTitle('AUP', $user_distributor) ?>" required>

															</div>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->













													<legend>Guest AUP</legend>





													<input type="hidden" name="secret" value="<?php echo $secret; ?>">



													<textarea width="100%" id="aup1" name="aup1" class="jqte-test"><?php echo $db->textVal('AUP', $user_distributor); ?></textarea>











													<div class="form-actions">



														<button type="submit" name="submit_f" class="btn btn-primary">Save</button>



														<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

													</div>





													<!-- /form-actions -->



												</fieldset>



											</form>



										</div>
									<?php } ?>








									<!-- =================== agreement ============================ -->

									<!-- <div class="tab-pane" id="agreement"> -->

									<div <?php if (isset($tab20)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="agreement2">



										<div class="support_head_visible" style="display:none;">
											<div class="header_hr"></div>
											<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
												Activation Terms and Conditions</div>
											<br class="hide-sm"><br class="hide-sm">
											<div class="header_f2" style="width: 100%;"> </div>
										</div>


										<div id="response_d3">



										</div>
										<!-- onkeyup="submit_arg1fn();" onchange="submit_arg1fn();" -->
										<form id="edit_profile_b" method="POST" action="?t=20">



											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

											$email_template = $db->getEmailTemplate('AGREEMENT', $system_package, 'MNO', $user_distributor);
											$subject = $email_template[0][title];
											$mail_text  = $email_template[0][text_details];
											echo '<input id="email_code" name="email_code" type="hidden"  value="AGREEMENT">';
											echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

											?>

											<fieldset>





												<div class="control-group">
													<label class="control-label" for="radiobtns">Title<sup>
															<font color="#FF0000"></font>
														</sup></label>

													<div class="controls form-group">


														<input class="span5 form-control" id="arg_title1" name="email_subject" type="text" value="<?php echo $subject; ?>">


													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->




												<input type="hidden" name="secret" value="<?php echo $secret; ?>">



												<!-- <legend>Activation Terms and Conditions</legend> -->

												<textarea width="100%" id="argeement1" name="email1" class="submit_arg1ta"><?php echo $mail_text; ?></textarea>











												<div class="form-actions pd-zero-form-action">



													<button disabled type="submit" name="email_form_update" id="submit_arg1" class="btn btn-primary">Save</button>



													<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>

												<script>
													function submit_arg1fn() {

														$("#submit_arg1").prop('disabled', false);

													}
												</script>





												<!-- /form-actions -->



											</fieldset>



										</form>



									</div>





									<!-- =================== agreement ============================ -->

									<!-- <div class="tab-pane" id="agreement"> -->

									<div <?php if (isset($tab13)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="agreement">



										<div id="response_d3">



										</div>

										<form onkeyup="activation_admin1fn();" onchange="activation_admin1fn();" id="edit-profile" method="POST" action="?t=13">



											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
											$email_template = $db->getEmailTemplate('AGREEMENT', $system_package, 'ADMIN');
											$subject = $email_template[0][title];
											$mail_text  = $email_template[0][text_details];
											echo '<input id="email_code" name="email_code" type="hidden"  value="AGREEMENT">';
											echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $system_package . '">';
											?>

											<fieldset>





												<div class="control-group">
													<label class="control-label" for="radiobtns">Title<sup>
															<font color="#FF0000"></font>
														</sup></label>

													<div class="controls">
														<div class="input-prepend input-append">

															<input class="span8" id="arg_title" name="email_subject" type="text" value="<?php echo $subject; ?>" required>

														</div>
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group -->




												<input type="hidden" name="secret" value="<?php echo $secret; ?>">



												<legend>Operator Activation Terms and Conditions</legend>

												<textarea width="100%" id="argeement" name="email1" class="activation_adminta"><?php echo $mail_text; ?></textarea>











												<div class="form-actions pd-zero-form-action">



													<button disabled type="submit" id="activation_admin1" name="email_form_update" class="btn btn-primary">Save</button>



													<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
													<script>
														function activation_admin1fn() {

															$("#activation_admin1").prop('disabled', false);
														}
													</script>

												</div>





												<!-- /form-actions -->



											</fieldset>



										</form>



									</div>


									<div <?php if (isset($tab23)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="property_settings">
										<div class="support_head_visible" style="display:none;">
											<div class="header_hr"></div>
											<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
												Property Settings</div>
											<br class="hide-sm"><br class="hide-sm">
											<div class="header_f2" style="width: 100%;"> </div>
										</div>
										<form id="active_property_submitfn" method="post" action="?t=23" class="form-horizontal" autocomplete="on">


											<?php
											echo '<input type="hidden" name="property_secret" id="property_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
											$sup_num_enable = $package_functions->getMessageOptions('SUPPORT_NUMBER_ENABLE', $system_package);
											?>

											<div class="control-group">
												<label class="control-label" for="radiobtns">Header Image</label>
												<div class="controls form-group">
													<select <?php if ($opt && $sup_num_enable == 'yes') {
																echo 'style="margin-left: 45px"';
															} ?> id="headerImg" name="headerImg">

														<?php

														$queryString = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";

														$queryResult = $db->selectDB($queryString);
														if ($queryResult['rowCount'] > 0) {
															foreach ($queryResult['data'] as $row) {
																$settingArr = json_decode($row['setting'], true);
															}
														}

														?>

														<option value="">Select a type</option>
														<option <?php if ($settingArr['headerImage'] != 'NO') {
																	echo 'selected';
																} ?> value="YES">ON</option>
														<option <?php if ($settingArr['headerImage'] == 'NO') {
																	echo 'selected';
																} ?> value="NO">OFF</option>
													</select>
												</div>
											</div>

											<?php

											if ($opt) {

												$sup_nums = json_decode($db->setVal('VERTICAL_SUPPORT_NUM', $user_distributor));
												$sup_num = $package_functions->getMessageOptions('SUPPORT_NUMBER', $system_package);
												if ($isdynamic) {
													foreach ($opt as $val) {

														$value = $sup_nums->$val;

														$ischeck = 'checked';
														if (empty($value)) {
															//$ischeck = '';
															$value = $sup_num;
														}
														if (!in_array($val, $enable_verticlearr)) {
															$ischeck = '';
														}
											?>
														<div class="control-group">
															<label class="control-label" for="sup_num_<?php echo $val; ?>"><?php echo $val; ?> Support Number</label>
															<div class="controls form-group">
																<?php if ($sup_num_enable == 'yes') { ?>
																	<style type="text/css">
																		.newTabs {
																			line-height: 40px !important;
																		}
																	</style>


																	<input <?php echo $ischeck; ?> id="sup_enable_<?php echo $val; ?>" name="sup_num_en_<?php echo $val; ?>" type="checkbox" onclick="changebuttons()">
																<?php } else { ?>
																	<input value="on" id="sup_enable_<?php echo $val; ?>" name="sup_num_en_<?php echo $val; ?>" type="hidden">
																<?php } ?>

																<input autocomplete="off" value="<?php echo $value; ?>" class="support_number" placeholder="xxx-xxx-xxxx" pattern="^(1-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$" maxlength="14" id="sup_num_<?php echo $val; ?>" name="sup_num_[]" type="text" oninput="setCustomValidity('')">
															</div>
														</div>
														<script type="text/javascript">
															var key = "<?php echo $val; ?>";
															$("#sup_num_" + key).attr("required", "true");
															var enable = $('#sup_num_en_' + key).val();

															if (enable == 'on') {
																$("#sup_num_" + key).attr("required", "true");
															} else {
																$("#sup_num_" + key).attr("required", "false");
															}

															function changebuttons() {
																$("#property_update").removeClass("disabled");
																$("#property_update").prop('disabled', false);

															}
														</script>
													<?php
													}
												} else {
													foreach ($opt as $key => $value) {

														$value = $sup_nums->$key;

														$ischeck = 'checked';
														if (empty($value)) {
															//$ischeck = '';
															$value = $sup_num;
														}
														if (!in_array($key, $enable_verticlearr)) {
															$ischeck = '';
														}
													?>
														<div class="control-group">
															<label class="control-label" for="sup_num_<?php echo $key; ?>"><?php echo $key; ?> Support Number</label>
															<div class="controls form-group">
																<?php if ($sup_num_enable == 'yes') { ?>
																	<style type="text/css">
																		.newTabs {
																			line-height: 40px !important;
																		}
																	</style>


																	<input <?php echo $ischeck; ?> id="sup_enable_<?php echo $key; ?>" name="sup_num_en_<?php echo $key; ?>" type="checkbox" onclick="changebuttons()">
																<?php } else { ?>
																	<input value="on" id="sup_enable_<?php echo $key; ?>" name="sup_num_en_<?php echo $key; ?>" type="hidden">
																<?php } ?>

																<input autocomplete="off" value="<?php echo $value; ?>" class="support_number" placeholder="xxx-xxx-xxxx" pattern="^(1-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$" maxlength="14" id="sup_num_<?php echo $key; ?>" name="sup_num_[]" type="text" oninput="setCustomValidity('')">
															</div>
														</div>
														<script type="text/javascript">
															var key = "<?php echo $key; ?>";
															$("#sup_num_" + key).attr("required", "true");
															var enable = $('#sup_num_en_' + key).val();

															if (enable == 'on') {
																$("#sup_num_" + key).attr("required", "true");
															} else {
																$("#sup_num_" + key).attr("required", "false");
															}

															function changebuttons() {
																$("#property_update").removeClass("disabled");
																$("#property_update").prop('disabled', false);

															}
														</script>
												<?php
													}
												}
												?>
												<script>
													$(document).ready(function() {
														var firstnum;
														$(".support_number").keypress(function(event) {
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
														$(".support_number").keydown(function(e) {
															var mac = $(this).val();
															var len = mac.length + 1;
															if (len == 2) {
																firstnum = mac;
															}
															console.log(e.keyCode);
															//console.log(firstnum);
															console.log('len ' + len);

															if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4) || (e.keyCode == 8 && len == 2) || (e.keyCode == 8 && len == 6) || (e.keyCode == 8 && len == 10)) {
																mac1 = mac.replace(/[^0-9]/g, '');


																//var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

																//console.log(valu);
																//$('#phone_num_val').val(valu);

															} else {
																if (firstnum == '1') {
																	if (len == 2) {
																		$(this).val(function() {
																			return $(this).val().substr(0, 1) + '-' + $(this).val().substr(1, 3);
																			//console.log('mac1 ' + mac);

																		});
																	} else if (len == 6) {
																		$(this).val(function() {
																			return $(this).val().substr(0, 5) + '-' + $(this).val().substr(5, 3);
																			//console.log('mac2 ' + mac);

																		});
																	} else if (len == 10) {
																		$(this).val(function() {
																			return $(this).val().substr(0, 9) + '-' + $(this).val().substr(9, 4);
																			//console.log('mac2 ' + mac);

																		});
																	}

																} else {
																	if (len == 4) {
																		$(this).val(function() {
																			return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
																			//console.log('mac1 ' + mac);

																		});
																	} else if (len == 8) {
																		$(this).val(function() {
																			return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
																			//console.log('mac2 ' + mac);

																		});
																	}
																}
															}
														});
													});
												</script>
											<?php
											}
											?>

											<div class="form-actions">

												<button disabled type="submit" id="property_update" name="property_update" class="btn btn-primary">Save</button>

											</div>

										</form>
									</div>


									<!-- ================== e-mail ========================== -->

									<div <?php if (isset($tab21)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="email">

										<div class="support_head_visible" style="display:none;">
											<div class="header_hr"></div>
											<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
												Email Template</div>
											<br class="hide-sm"><br class="hide-sm">
											<div class="header_f2" style="width: 100%;"> </div>
										</div>

										<div id="email_response"></div>

										<div id="response_d3">
										</div>


										<?php
										// OPS ADMIN CREATION TEMPLATE
										if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {

										?>
											<!-- 	onkeyup="active_email_submitfn();" onchange="active_email_submitfn();" -->
											<form id="active_email_submitfn" method="post" action="?t=21">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Activation Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
													Password : {$password}&nbsp;&nbsp;|&nbsp;
													Activation Link : {$link}&nbsp;&nbsp;

													<br><br>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Email Subject<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls form-group">

															<?php

															$email_template = $db->getEmailTemplate('MAIL', $system_package, 'ADMIN');
															$subject = $email_template[0][title];
															$mail_text  = $email_template[0][text_details];
															echo '<input id="email_code" name="email_code" type="hidden"  value="MAIL">';
															echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $system_package . '">';

															?>
															<input class="span5 form-control" id="email_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
														</div>
													</div>

													<textarea class="active_email_submit_tarea" width="100%" id="email1" name="email1">
<?php echo $mail_text; ?>
</textarea>
													<div class="form-actions pd-zero-form-action">
														<input disabled type="submit" value="Save" name="email_form_update" id="active_email_submit" class="btn btn-primary">
													</div>
													<script>
														function active_email_submitfn() {
															$("#active_email_submit").prop('disabled', false);
														}
													</script>
													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
												</fieldset>

											</form>


										<?php }




										// PARENT INVITE Template
										if ($user_type == 'MNO') {

										?>
											<!-- 	onkeyup="active_email_submitfn();" onchange="active_email_submitfn();" -->
											<form id="active_email_submitfn" method="post" action="?t=21" class="email-1">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Business ID Activation Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													<?php if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package) == "ICOMMS NUMBER") { ?>
														Business ID: {$business_id}&nbsp;&nbsp;|&nbsp;
													<?php } else { ?>
														User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
														Password : {$password}&nbsp;&nbsp;|&nbsp;
													<?php } ?>
													Support Phone Number : {$support_number}&nbsp;|&nbsp;
													Activation Link : {$link}
													<br><br>
													<?php
													$email_template_by_email = $package_functions->getOptions('EMAIL_TEMPLATE_BY_EMAIL', $system_package);

													$email_template = $db->getEmailTemplateVertical('PARENT_INVITE_MAIL', $system_package, 'MNO', 'All', $user_distributor);
													//print_r($email_template)[0];

													$subject = $email_template[0]['title'];
													$mail_text  = $email_template[0]['text_details'];
													echo '<input id="email_code" name="email_code" type="hidden"  value="PARENT_INVITE_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<style>
														.inn {
															position: relative;
														}

														.inn .loading {
															position: absolute;
															width: 100%;
															z-index: 1;
															height: 100%;
															top: 0;
															background-color: rgb(255 255 255 / 82%);
															background-image: url(img/loading_ajax.gif);
															background-repeat: no-repeat;
															background-position: center;
														}
													</style>
													<script>
														function changeVertical(type, system_package, user_distributor, value, txtarea) {
															$('.' + txtarea + ' .inn').append('<div class="loading"></div>');
															var data = {
																"type": type,
																"system_package": system_package,
																"user_distributor": user_distributor,
																"vertical": value
															};
															$.ajax({
																type: "POST",
																url: "ajax/emailTemplateVertical.php",
																data: data,
																dataType: "json",
																success: function(response) {
																	$('.' + txtarea + ' .inn .loading').remove();
																	if (response.status == 'success') {
																		$('#' + txtarea).val(response.data.mail_text);
																		$('.' + txtarea + ' .subject').val(response.data.subject);
																		$('input.' + txtarea).attr("disabled", false);
																		tinymce.get(txtarea).setContent(response.data.mail_text);

																	} else {
																		alert(response.data);
																	}
																},
																error: function(xhr, ajaxOptions, thrownError) {
																	$('.' + txtarea + ' .inn .loading').remove();
																	alert(thrownError);
																}
															});
														}
													</script>

													<?php
													$business_vertical = $package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package);
													$business_vertical_array = array();
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
													}
													?>

													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>

														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('PARENT_INVITE_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-1');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->
													<?php } ?>
													<div class="inn">

														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control subject" id="email_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<textarea class="active_email_submit_tarea" width="100%" id="email-1" name="email1">
<?php echo $mail_text; ?>
</textarea>
													</div>
													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="active_email_submit" class="btn btn-primary email-1">

													</div>
													<script>
														function active_email_submitfn() {

															$("#active_email_submit").prop('disabled', false);
														}
													</script>


													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</fieldset>

											</form>

											<!-- 	Business peer admin invitation -->
											<form id="peer_active_email_submitfn" method="post" action="?t=21" class="email-2">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Business ID Admin Activation Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
													Password : {$password}&nbsp;&nbsp;|&nbsp;
													Support Phone Number : {$support_number}&nbsp;|&nbsp;
													Activation Link : {$link}
													<br><br>
													<?php
													$email_template = $db->getEmailTemplateVertical('VENUE_ADD_ADMIN_USER', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_ADD_ADMIN_USER">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('VENUE_ADD_ADMIN_USER','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-2');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control subject" id="peer_email_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->




														<textarea class="peer_active_email_submit_tarea" width="100%" id="email-2" name="email1">
<?php echo $mail_text; ?>
</textarea>
													</div>
													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="peer_active_email_submit" class="btn btn-primary email-2">

													</div>
													<script>
														function peer_active_email_submitfn() {

															$("#peer_active_email_submit").prop('disabled', false);
														}
													</script>


													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</fieldset>

											</form>


											<!-----Pending Activation-------->

											<form id="pending_active_email_submitfn" method="post" action="?t=21" class="email-3">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend> Business ID Activation Reminder Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													<?php if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package) == "ICOMMS NUMBER") { ?>
														Business ID: {$business_id}&nbsp;&nbsp;|&nbsp;
													<?php } else { ?>
														User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
														Password : {$password}&nbsp;&nbsp;|&nbsp;
													<?php } ?>
													Support Phone Number : {$support_number}&nbsp;|&nbsp;
													Activation Link : {$link}&nbsp;&nbsp;

													<br><br>
													<?php

													$email_template = $db->getEmailTemplate('PENDING_PARENT_INVITE_MAIL', $system_package, 'MNO', $user_distributor);
													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="PENDING_PARENT_INVITE_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control subject" id="email_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->




														<textarea class="pending_active_email_submit_tarea" width="100%" id="email-3" name="email1">
<?php echo $mail_text; ?>
</textarea>
													</div>
													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="pending_active_email_submit" class="btn btn-primary email-3">

													</div>
													<script>
														function pending_active_email_submitfn() {

															$("#pending_active_email_submit").prop('disabled', false);
														}
													</script>


													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</fieldset>

											</form>

										<?php } ?>






										<?php
										// User Activation Template
										//echo $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package);
										if ($user_type == 'MNO' && $package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {

										?>
											<form onkeyup="active_user_email_submitfn();" onchange="active_user_email_submitfn();" id="edit-profile" method="post" action="?t=21">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Activation Email(Master Admin)</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													Support Phone Number : {$support_number}&nbsp;|&nbsp;
													User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
													Password : {$password}&nbsp;&nbsp;|&nbsp;
													Activation Link : {$link}&nbsp;&nbsp;

													<br><br>
													<?php

													$email_template = $db->getEmailTemplate('USER_MAIL', $system_package, 'MNO', $user_distributor);
													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="USER_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Email Subject<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls form-group">

															<input class="span8 form-control" id="email_user_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->

													<textarea class="active_user_email_submit_tarea" width="100%" id="active_user_email_submit_tarea" name="email1">
<?php echo $mail_text; ?>
</textarea>
													<div class="form-actions pd-zero-form-action">
														<input disabled type="submit" value="Save" name="email_form_update" id="active_user_email_submit" class="btn btn-primary">
													</div>
													<script>
														function active_user_email_submitfn() {
															$("#active_user_email_submit").prop('disabled', false);
														}
													</script>

													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

													<!-- /form-actions -->

												</fieldset>
												<!--- //////////////////////////////////    Property Account                      ///////////////////////////////////////////// --->
											</form>
										<?php }
										?>

										<?php
										if ($user_type == 'MNO' && $package_functions->getSectionType('EMAIL_USER_TEMPLATE', $system_package) == "own") {

										?>
											<form onkeyup="active_property_submitfn();" onchange="active_property_submitfn();" id="edit-profile1" method="post" action="?t=21" class="email-4">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend> Property Admin Activation</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													<!--User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;-->
													Activation Link : {$link}&nbsp;&nbsp;|&nbsp;
													Property Id : {$property_id}&nbsp;&nbsp;|&nbsp;
													Support Phone Number : {$support_number}&nbsp;&nbsp;
													<br><br>
													<?php
													$email_template = $db->getEmailTemplateVertical('VENUE_ADD_ADMIN', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_ADD_ADMIN">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('VENUE_ADD_ADMIN','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-4');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span8 form-control subject" id="email_user_subject_main1" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->

														<textarea class="active_user_email_submit_tarea1" width="100%" id="email-4" name="email1">
<?php echo $mail_text; ?>
</textarea>
													</div>
													<div class="form-actions pd-zero-form-action">
														<input disabled type="submit" value="Save" name="email_form_update" id="active_property_submit" class="btn btn-primary email-4">
													</div>
													<script>
														function active_property_submitfn() {
															$("#active_property_submit").prop('disabled', false);
														}
													</script>

													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

													<!-- /form-actions -->

												</fieldset>

											</form>
										<?php }
										?>




										<?php
										// User Activation Template
										//echo $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package);
										if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {

										?>
											<form onkeyup="active_user_email_submitfn();" onchange="active_user_email_submitfn();" id="edit-profile" method="post" action="?t=21">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>User Activation Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
													Account Type : {$account_type}&nbsp;&nbsp;
													<br>
													User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
													Password : {$password}&nbsp;&nbsp;|&nbsp;
													Activation Link : {$link}&nbsp;&nbsp;
													Support Phone Number : {$support_number}&nbsp;|&nbsp;

													<br><br>
													<?php

													$email_template = $db->getEmailTemplate('USER_MAIL', $system_package, 'ADMIN');
													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="USER_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $system_package . '">';



													?>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Email Subject<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls form-group">

															<input class="span8 form-control" id="email_user_subject_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->

													<textarea class="active_user_email_submit_tarea" width="100%" id="active_user_email_submit_tarea" name="email1">
<?php echo $mail_text; ?>
</textarea>
													<div class="form-actions pd-zero-form-action">
														<input disabled type="submit" value="Save" name="email_form_update" id="active_user_email_submit" class="btn btn-primary">
													</div>
													<script>
														function active_user_email_submitfn() {
															$("#active_user_email_submit").prop('disabled', false);
														}
													</script>

													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

													<!-- /form-actions -->

												</fieldset>

											</form>
										<?php }
										?>





										<?php if ($user_type != 'ADMIN') { ?>

											<!-- onkeyup="venue_activated_emailfn();" onchange="venue_activated_emailfn();" -->
											<form id="venue_activated_email" method="post" action="?t=21" class="email-5">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Activation Confirmation Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Link : {$link}&nbsp;&nbsp;|&nbsp;Rest Link : {$reset_link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}&nbsp;&nbsp;|&nbsp;Support Phone Number : {$support_number}&nbsp;|&nbsp;Customer Account # : {$account_number}

													<br>
													<br>
													<?php
													$email_template = $db->getEmailTemplateVertical('VENUE_CONFIRM_MAIL', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_CONFIRM_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
													?>
													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('VENUE_CONFIRM_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-5');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control subject" id="email_subject_activated" name="email_subject" type="text" value="<?php echo $subject; ?>" />
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<textarea width="100%" id="email-5" name="email1" class="venue_activated_confirm">
                                                <?php echo $mail_text; ?></textarea>
													</div>

													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="email_activated_sub" class="btn btn-primary email-5">

													</div>
													<script>
														function venue_activated_emailfn() {

															$("#email_activated_sub").prop('disabled', false);

														}
													</script>


													<!-- /form-actions -->

												</fieldset>

											</form>
										<?php } ?>





										<?php if ($user_type != 'ADMIN') { ?>
											<!-- onkeyup="new_venue_activated_emailfn();" onchange="new_venue_activated_emailfn();" -->
											<form id="new_venue_activated_email" method="post" action="?t=21" class="email-6">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>

												<fieldset>
													<legend>New Location Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|
													&nbsp;Portal Link : {$link}&nbsp;&nbsp;|
													&nbsp; Support Phone Number : {$support_number}&nbsp;|&nbsp;Customer Account # : {$account_number}
													<br>
													<br>
													<?php
													$email_template = $db->getEmailTemplateVertical('VENUE_NEW_LOCATION', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_NEW_LOCATION">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>
													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('VENUE_NEW_LOCATION','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-6');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control subject" id="new_location_activated" name="email_subject" type="text" value="<?php echo $subject; ?>" />
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<textarea width="100%" id="email-6" name="email1" class="new_location_activated_email">
                                                <?php echo $mail_text; ?>
                                                    </textarea>
													</div>

													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="new_location_activated_sub" class="btn btn-primary email-6">

													</div>
													<script>
														function new_venue_activated_emailfn() {
															//alert();

															$("#new_location_activated_sub").prop('disabled', false);

														}
													</script>


													<!-- /form-actions -->

												</fieldset>

											</form>
										<?php } ?>





										<?php if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') { ?>
											<!-- onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" -->
											<form id="active_sup_email" method="post" action="?t=21">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>
												<fieldset>
													<legend>Activation Email (Support)</legend>
													<h6>TAG Description </h6>
													User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
													User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
													Password : {$password}&nbsp;&nbsp;|&nbsp;
													Activation Link : {$link}&nbsp;&nbsp;

													<?php

													$email_template = $db->getEmailTemplate('SUPPORT_MAIL', $system_package, 'ADMIN');
													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="SUPPORT_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $system_package . '">';
													?>
													<br><br>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Email Subject<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls form-group">

															<input class="span5 form-control" id="email_subject_sup_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
														</div>
														<!-- /controls -->
													</div>

													<textarea class="active_sup_email_submit_tarea" width="100%" id="sup_email1" name="email1">
<?php echo $mail_text; ?>
</textarea>
													<div class="form-actions pd-zero-form-action">
														<input disabled type="submit" value="Save" name="email_form_update" id="active_sup_email_submit" class="btn btn-primary">


													</div>
													<script>
														function active_sup_email_submitfn() {

															$("#active_sup_email_submit").prop('disabled', false);

														}
													</script>

													<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

													<!-- /form-actions -->

												</fieldset>

											</form>

										<?php }


										?>




										<?php if ($user_type == 'MNO') {
											if ($package_functions->getSectionType('EMAIL_SUPPORT_TEMPLATE', $system_package) == "own") {
										?>
												<!-- onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" -->
												<form onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" id="active_sup_email" method="post" action="?t=21">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>
													<fieldset>
														<legend>Activation Email (Support)</legend>
														<h6>TAG Description </h6>
														User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
														User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
														Password : {$password}&nbsp;&nbsp;|&nbsp;
														Activation Link : {$link}&nbsp;&nbsp;
														<br><br>
														<?php

														$email_template = $db->getEmailTemplate('SUPPORT_MAIL', $system_package, 'MNO', $user_distributor);
														$subject = $email_template[0][title];
														$mail_text  = $email_template[0][text_details];
														echo '<input id="email_code" name="email_code" type="hidden"  value="SUPPORT_MAIL">';
														echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
														?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span8 form-control" id="email_subject_sup_main" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->

														<textarea class="active_sup_email_submit_tarea" width="100%" id="sup_email1" name="email1">
<?php echo $mail_text; ?>
</textarea>
														<div class="form-actions pd-zero-form-action">

															<input disabled type="submit" value="Save" name="email_form_update" id="active_sup_email_submit" class="btn btn-primary">


														</div>
														<script>
															function active_sup_email_submitfn() {

																$("#active_sup_email_submit").prop('disabled', false);

															}
														</script>


														<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														<!-- /form-actions -->

													</fieldset>

												</form>

											<?php }
											?>



											<!-- onkeyup="email_subject_passcodeifn();" onchange="email_subject_passcodeifn();" -->
											<form id="passcode_email_form" method="post" action="?t=21" class="email-7">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>

												<fieldset>
													<legend>Passcode Email</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													<?php if ($package_functions->getOptions('VENUE_ACTIVATION_TYPE', $system_package) == "ICOMMS NUMBER") { ?>

														Customer Account: {$account_number}&nbsp;&nbsp;|&nbsp;
														Business Name : {$business_name}&nbsp;&nbsp;|&nbsp;
														<br>
														Passcode : {$passcode}&nbsp;&nbsp;|&nbsp;
														Valid from : {$valid_from}&nbsp;&nbsp;|&nbsp;
														Valid to : {$valid_to}&nbsp;&nbsp;|&nbsp;
													<?php } else { ?>
														User Name : {$user_name}&nbsp;&nbsp;|&nbsp;

													<?php } ?>

													Portal Link : {$link}&nbsp;&nbsp;|&nbsp;Support Phone Number : {$support_number}&nbsp;&nbsp;<br><br>

													<?php
													$email_template = $db->getEmailTemplateVertical('PASSCODE_MAIL', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="PASSCODE_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';

													?>

													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('PASSCODE_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-7');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">
																<input class="span5 form-control subject" id="email_subject_passcode" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->

														<textarea class="passcode_email_formta" width="100%" id="email-7" name="email1">
<?php echo $mail_text; ?>
</textarea>
													</div>

													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_form_update" id="email_subject_passcodei" class="btn btn-primary email-7">

													</div>

													<script>
														function email_subject_passcodeifn() {

															$("#email_subject_passcodei").prop('disabled', false);

														}
													</script>



													<!-- /form-actions -->

												</fieldset>

											</form>

											<!-- onkeyup="tech_emailfn();" onchange="tech_emailfn();" -->
											<?php
											$isTechAdmin = $package_functions->getOptions('MASTER_TECH_ADMIN', $system_package);
											?>

											<?php if ($isTechAdmin == 'NO') { ?>

												<!-- No need to display Master tech admin-->

											<?php } else { ?>


												<form id="tech_activation__email" method="post" action="?t=21">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>

													<fieldset>
														<legend>Activation Email (Tech)</legend>
														<h6>TAG Description </h6>
														User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
														Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}<br>
														<br>
														<?php

														$email_template = $db->getEmailTemplate('TECH_INVITE_MAIL', $system_package, 'MNO', $user_distributor);
														$subject = $email_template[0][title];
														$mail_text  = $email_template[0][text_details];
														echo '<input id="email_code" name="email_code" type="hidden"  value="TECH_INVITE_MAIL">';
														echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
														?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span5 form-control" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<textarea width="100%" id="email4" name="email1" class="email_tech">
<?php echo $mail_text;
?></textarea>

														<div class="form-actions pd-zero-form-action">

															<input disabled type="submit" value="Save" name="email_form_update" id="tech_form_update" class="btn btn-primary">

														</div>
														<script>
															function tech_emailfn() {

																$("#tech_form_update").prop('disabled', false);

															}
														</script>


														<!-- /form-actions -->

													</fieldset>

												</form>




												<!-- onkeyup="hardware_emailfn();" onchange="hardware_emailfn();" -->
												<form id="hardware_info_email" method="post" action="?t=21" class="email-8">
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>

													<fieldset>
														<legend>Hardware Details Email</legend>
														<h6>TAG Description </h6>
														Business ID : {$business_id}&nbsp;&nbsp;|&nbsp;
														Location ID : {$account_number}&nbsp;&nbsp;|&nbsp;
														Hardware Details : {$hardware_table}&nbsp;&nbsp;|&nbsp;
														User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
														Portal Link : {$link}
														<br>
														<br>
														<?php
														$email_template = $db->getEmailTemplateVertical('HARDWARE_DETAIL_MAIL', $system_package, 'MNO', 'All', $user_distributor);

														$subject = $email_template[0][title];
														$mail_text  = $email_template[0][text_details];
														echo '<input id="email_code" name="email_code" type="hidden"  value="HARDWARE_DETAIL_MAIL">';
														echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
														?>
														<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
															<div class="control-group">
																<label class="control-label" for="radiobtns">Vertical</label>
																<div class="controls form-group">
																	<select class="span4 form-control" name="business_vertical" onchange="changeVertical('HARDWARE_DETAIL_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-8');">
																		<option value="All">All</option>
																		<?php

																		foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																		?>
																			<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																		<?php

																		}
																		?>
																	</select>
																</div>
															</div>
														<?php } ?>
														<div class="inn">
															<div class="control-group">
																<label class="control-label" for="radiobtns">Email Subject<sup>
																		<font color="#FF0000"></font>
																	</sup></label>
																<div class="controls form-group">

																	<input class="span5 form-control subject" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group -->


															<textarea width="100%" id="email-8" name="email1" class="email_hardware">
<?php echo $mail_text;
?></textarea>
														</div>

														<div class="form-actions pd-zero-form-action">

															<input disabled type="submit" value="Save" name="email_form_update" id="hardware_email_update" class="btn btn-primary email-8">

														</div>
														<script>
															function hardware_emailfn() {

																$("#hardware_email_update").prop('disabled', false);

															}
														</script>


														<!-- /form-actions -->

													</fieldset>

												</form>

											<?php } ?>

										<?php }
										?>




										<!-- onkeyup="password_reset_emailfn();" onchange="password_reset_emailfn();" -->
										<form id="password_reset_email" method="post" action="?t=21" class="email-9">
											<?php
											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
											?>

											<fieldset>
												<legend>Password Reset Email</legend>
												<h6>TAG Description </h6>
												User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
												Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}&nbsp;&nbsp;|&nbsp; Support Phone Number : {$support_number}<br>
												<br>
												<?php
												$email_template = $db->getEmailTemplateVertical('PASSWORD_RESET_MAIL', $system_package, 'MNO', 'All', $user_distributor);

												$subject = $email_template[0][title];
												$mail_text  = $email_template[0][text_details];
												echo '<input id="email_code" name="email_code" type="hidden"  value="PASSWORD_RESET_MAIL">';
												echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
												?>
												<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Vertical</label>
														<div class="controls form-group">
															<select class="span4 form-control" name="business_vertical" onchange="changeVertical('PASSWORD_RESET_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-9');">
																<option value="All">All</option>
																<?php

																foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																?>
																	<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																<?php

																}
																?>
															</select>
														</div>
													</div>
												<?php } ?>
												<div class="inn">
													<div class="control-group">
														<label class="control-label" for="radiobtns">Email Subject<sup>
																<font color="#FF0000"></font>
															</sup></label>
														<div class="controls form-group">

															<input class="span5 form-control subject" id="email_subject_pass_reset" name="email_subject" type="text" value="<?php echo $subject; ?>">
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->


													<textarea width="100%" id="email-9" name="email1" class="password_reset_emailta">
<?php echo $mail_text;
?></textarea>
												</div>

												<div class="form-actions pd-zero-form-action">

													<input disabled type="submit" value="Save" name="email_form_update" id="email_pass_reset" class="btn btn-primary email-9">

												</div>
												<script>
													function password_reset_emailfn() {

														$("#email_pass_reset").prop('disabled', false);

													}
												</script>


												<!-- /form-actions -->

											</fieldset>



											<!--tech-->

										</form>

										<?php

										//echo  $package_functions->getOptions('VTENANT_MODULE',$system_package) ;

										if ($package_functions->getOptions('VTENANT_MODULE', $system_package) == "Vtenant") { ?>

											<form onkeyup="vt_noytification_emailfn();" onchange="vt_noytification_emailfn();" id="vt_noytification_email" method="post" action="?t=21" class="email-10">
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
												?>

												<fieldset>
													<legend>VTenant Portal Email Notification</legend>
													<h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;Property Name : {$Property_Name}&nbsp;&nbsp;|&nbsp;
													Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}&nbsp;&nbsp;|&nbsp; Support Phone Number : {$support_number}<br>
													<br>
													<?php
													$email_template = $db->getEmailTemplateVertical('CUSTOMER_MAIL', $system_package, 'MNO', 'All', $user_distributor);

													$subject = $email_template[0][title];
													$mail_text  = $email_template[0][text_details];
													echo '<input id="email_code" name="email_code" type="hidden"  value="CUSTOMER_MAIL">';
													echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="' . $user_distributor . '">';
													?>
													<?php if ($email_template_by_email == "ENABLED" && !empty($business_vertical_array)) { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Vertical</label>
															<div class="controls form-group">
																<select class="span4 form-control" name="business_vertical" onchange="changeVertical('CUSTOMER_MAIL','<?php echo $system_package; ?>','<?php echo $user_distributor; ?>',value,'email-10');">
																	<option value="All">All</option>
																	<?php

																	foreach ($business_vertical_array as $bVertical => $bVertDetails) {
																	?>
																		<option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
																	<?php

																	}
																	?>
																</select>
															</div>
														</div>
													<?php } ?>
													<div class="inn">
														<div class="control-group">
															<label class="control-label" for="radiobtns">Email Subject<sup>
																	<font color="#FF0000"></font>
																</sup></label>
															<div class="controls form-group">

																<input class="span8 form-control subject" id="email_subject_vt_noytification" name="email_subject" type="text" value="<?php echo $subject; ?>">
															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<textarea width="100%" id="email-10" name="email1" class="vt_notification">
<?php echo $mail_text;
?></textarea>
													</div>

													<div class="form-actions pd-zero-form-action">

														<input disabled type="submit" value="Save" name="email_vt_noytification" id="email_vt_noytification" class="btn btn-primary email-10">

													</div>
													<script>
														function vt_noytification_emailfn() {

															$("#email_vt_noytification").prop('disabled', false);

														}
													</script>


													<!-- /form-actions -->

												</fieldset>



												<!--tech-->

											</form>

										<?php } ?>


									</div>


									<!-- ////////////////////////////////product create //////////////////// -->



									<?php if (in_array("CONFIG_PROFILE", $features_array)) { ?>
										<div <?php if ((isset($tab1) && $user_type == 'MNO') || (isset($tab1) && $user_type == 'SALES')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="product_create">

											<div id="response_">



											</div>

											<!-- ///////////////////////////////////////////////////////////// -->


											<script>
												$(document).ready(function() {
													$("#description").keydown(function(e) {
														// Allow: backspace, delete, tab, escape, enter and .

														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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


											<script>
												$(document).ready(function() {
													$("#description_up").keydown(function(e) {
														// Allow: backspace, delete, tab, escape, enter and .
														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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



											<script>
												$(document).ready(function() {
													$("#description1").keydown(function(e) {
														// Allow: backspace, delete, tab, escape, enter and .
														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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


											<script>
												$(document).ready(function() {
													$("#description1_up").keydown(function(e) {
														// Allow: backspace, delete, tab, escape, enter and .
														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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
											<script>
												$(document).ready(function() {

													$("#Purge_delay_time").keydown(function(e) {

														// Allow: backspace, delete, tab, escape, enter and .
														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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

											<script>
												$(document).ready(function() {
													$("#Purge_delay_time2").keydown(function(e) {
														// Allow: backspace, delete, tab, escape, enter and .
														if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
															// Allow: Ctrl+A, Command+A
															(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
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
											<!-- <script>

													$(document).ready(function() {
													    $("#max_sessions_alert").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script> -->


											<style></style>
											<script></script>


											<?php $network_opt = $package_functions->getOptions('NETWORK_AVAILABLE', $system_package);

											if ($network_opt == 'privat' || $network_opt == 'both') {

											?>


												<h3>Create Private QoS Profile(s)</h3>
												<br>
												<form id="create_product_form" name="create_product_form" method="post" class="form-horizontal" action="?t=1" autocomplete="off">
													<fieldset>

														<div id="response_d3">

														</div>
														<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
														?>



														<?php //echo $edit_product_pvt; 
														?>


														<div class="control-group" style="margin-bottom: 0px !important">
															<label class="control-label" for="product_name">Name<strong>
																	<font color="#FF0000"></font>
																</strong></label>
															<div class="controls col-lg-5 form-group">
																<input required class="span4 form-control" id="product_name" name="product_name" type="text" value="<?php if ($edit_product_pvt == 1) {
																																										echo $edit_p_name_pvt;
																																									} ?>" <?php if ($edit_product_pvt == 1) {
																																												echo 'readonly';
																																											} ?>>

															</div>

														</div>
														<font class="controls" style="font-size: small">Format: QoS-Profile-10M</font>


														<div class="control-group" style="margin-top: 10px;">
															<label class="control-label" for="description">QoS<strong>
																	<font color="#FF0000"></font>
																</strong></label>
															<div class="controls col-lg-5 form-group">
																<input class="form-control span2" id="description" name="description" placeholder="Downlink" type="text" value="<?php if ($edit_product_pvt == 1) {
																																													echo $edit_p_QOS_pvt;
																																												} ?>" <?php echo 'readonly'; ?>>&nbsp;
																<input class="form-control span2" id="description_up" name="description_up" placeholder="Uplink" type="text" value="<?php if ($edit_product_pvt == 1) {
																																														echo $edit_p_QOS_up_pvt;
																																													} ?>" <?php echo 'readonly'; ?>>&nbsp;Mbps

																<input type="hidden" name="dob1" />
															</div>
														</div>
														<script>
															$('#description').bind("cut copy paste", function(e) {
																e.preventDefault();
															});

															$('#description_up').bind("cut copy paste", function(e) {
																e.preventDefault();
															});
														</script>


														<div class="control-group">
															<label class="control-label" for="product_code">Purge Delay Time</label>
															<div class="controls col-lg-5">
																<input type="text" class="span4" id="Purge_delay_time" name="Purge_delay_time" value="<?php if ($edit_product_pvt == 1) {
																																							echo $edit_p_prug_time_pvt;
																																						} ?>">&nbsp;Sec
															</div>
														</div>

														<?php if ($edit_product_pvt == 1) { ?>
															<input type="hidden" name="pvt_package_edit" value="<?php echo $edit_p_id_pvt; ?>">
															<input type="hidden" name="edit_pvt_id" value="<?php echo $edit_p_id_pvt; ?>">
														<?php }
														?>

														<div class="form-actions">
															<button type="submit" name="create_product_submit" id="create_product_submit" class="btn btn-primary">Save</button>

														</div>
													</fieldset>
												</form>

												<script type="text/javascript">
													$(document).ready(function() {

														$('#product_name, #description, #description_up, #Purge_delay_time').keyup(function(e) {

															ck_pvtval();

														});

														var edit_product_pvt = '<?php echo $edit_product_pvt; ?>';
														document.getElementById("create_product_submit").disabled = true;
														if (edit_product_pvt != 1) {
															document.getElementById("description").readOnly = false;
															document.getElementById("description_up").readOnly = false;
														}


													});


													function ck_pvtval() {

														var name = document.getElementById('product_name').value;
														var qos1 = document.getElementById('description').value;
														var qos2 = document.getElementById('description_up').value;
														var pdtime = document.getElementById('Purge_delay_time').value;


														if (name == '' || qos1 == '' || qos2 == '' || pdtime == '') {
															document.getElementById("create_product_submit").disabled = true;

														} else {
															document.getElementById("create_product_submit").disabled = false;

														}



													}
												</script>


												<div class="widget widget-table action-table">
													<div class="widget-header">
														<!-- <i class="icon-th-list"></i> -->
														<h3>Private Profiles</h3>
													</div>
													<!-- /widget-header -->
													<div class="widget-content table_response">
														<div style="overflow-x:auto">
															<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>



																<thead>
																	<tr>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile Name</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DL</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">UL</th>

																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Purge time</th>

																		<!-- <th style="min-width: 100px;">Status</th> -->
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
																		<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

																	</tr>
																</thead>
																<tbody>
																	<?php
																	$key_q1 = "SELECT p.id,p.product_code,p.QOS,p.QOS_up_link,p.time_gap,p.create_date,p.default_value , IF(d.product_id IS NULL,0,IF(group_concat(d.distributor_code) ='' ,0,1))  AS assign, p.`max_session`,p.`purge_time`
																				FROM exp_products p LEFT JOIN exp_products_distributor d
																				ON p.`product_id`=d.`product_id`
																				WHERE p.mno_id = '$user_distributor' AND p.network_type='PRIVATE'
																				GROUP BY p.`id`,p.`product_code`,p.`QOS`,p.`QOS_up_link`,p.`time_gap`,p.`create_date`,p.`default_value` , 'assign',p.`max_session`,p.`purge_time`
																				ORDER BY p.`QOS`";

																	//$query_results1=mysql_query($key_q1);
																	$query_results1 = $db->selectDB($key_q1);

																	//while($row=mysql_fetch_array($query_results1)){
																	foreach ($query_results1['data'] as $row) {
																		$product_code = $row[product_code];
																		$description = $row[QOS];
																		$description_up = $row[QOS_up_link];


																		$create_date = $row[create_date];
																		$default_value = $row[default_value];
																		$product_id = $row[id];
																		$assign = $row[assign];
																		$purge_time = $row[purge_time];

																		$timegap = $row[time_gap];
																		$gap = "";
																		if ($timegap != '') {

																			$interval = new DateInterval($timegap);

																			if ($interval->y != 0) {
																				$gap .= $interval->y . ' Years ';
																			}
																			if ($interval->m != 0) {
																				$gap .= $interval->m . ' Months ';
																			}
																			if ($interval->d != 0) {
																				$gap .= $interval->d . ' Days ';
																			}
																			if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0)) {
																				$gap .= ' And ';
																			}
																			if ($interval->i != 0) {
																				$gap .= $interval->i . ' Minutes ';
																			}
																			if ($interval->h != 0) {
																				$gap .= $interval->h . ' Hours ';
																			}
																		}



																		echo '<tr>
																		<td> ' . $product_code . ' </td>
																		<td> ' . $description . ' Mbps </td>
																		<td> ' . $description_up . ' Mbps </td>
																		
																		<td> ' . $purge_time . '</td>';



																		///////////////////////////////////////////																	

																		echo '<td>';
																		echo '
                                                                        <a href="javascript:void();" id="EDIT_AP_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_AP_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_AP_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&edit_product_pvt_id=' . $product_id . '"
                                                                            });
                                                                            });
                                                                        </script></td>';

																		//////////////////////////////////////////																	
																		echo '<td>';
																		if ($assign == 0) {
																			echo '<a href="javascript:void();" id="AP_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#AP_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});


                                                                            $(\'#AP_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&remove_product_id=' . $product_id . '&api_id=' . $api_id . '"
                                                                            });
                                                                            });
                                                                        </script>';
																		} else {


																			echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-trash"></i>&nbsp;Remove</a></center>';
																		}
																		echo '</td>';
																	}
																	?>


																</tbody>
															</table>
														</div>
													</div>
													<!-- /widget-content -->
												</div>
												<!-- /widget -->





												<!-- /////////////////////////////////////////////////////// -->
												<hr>
											<?php } ?>

											<h3 id="create_guest_prof_h3">Create Guest QoS Profile(s)</h3>
											<br>
											<form id="create_guest_form" name="create_product_form" method="post" class="form-horizontal" action="?t=1" autocomplete="off">
												<fieldset>

													<div id="response_d3">

													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>

													<div class="control-group" style="margin-bottom: 0px !important">
														<label class="control-label" for="product_name">Name<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5 form-group">
															<input required class="form-control span4" id="product_name2" name="product_name" type="text" value="<?php echo $edit_p_name; ?>" <?php if ($edit_guest_product == 1) {
																																																	echo 'readonly';
																																																} ?>>


														</div>

													</div>
													<font class="controls" style="font-size: small">Format : QoS-Profile-10M</font>


													<div class="control-group" style="margin-top: 10px;">
														<label class="control-label" for="description1">QoS<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5 form-group">
															<input class="form-control span2" id="description1" name="description1" placeholder="Downlink" type="text" value="<?php echo $edit_p_QOS; ?>" <?php echo 'readonly'; ?>>&nbsp;
															<input class="form-control span2" id="description1_up" name="description1_up" placeholder="Uplink" type="text" value="<?php echo $edit_p_QOS_up; ?>" <?php echo 'readonly'; ?>>&nbsp;Mbps

															<input type="hidden" name="dob2" />
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="product_code">Purge Delay Time</label>
														<div class="controls col-lg-5">
															<input type="text" class="span4" id="Purge_delay_time2" name="Purge_delay_time" value="<?php echo $edit_p_prug_time; ?>">&nbsp;Sec
														</div>
													</div>

													<script type="text/javascript">
														function seshrselect(v) {

															var x = $("#sesson_du_select3").val();

															$('#max_sessions').empty();




															$("#max_sessions").append('<option value="1">1</option>');
															$("#max_sessions").append('<option value="2">2</option>');
															$("#max_sessions").append('<option value="3">3</option>');
															$("#max_sessions").append('<option value="4">4</option>');
															$("#max_sessions").append('<option value="5">5</option>');
															$("#max_sessions").append('<option value="6">6</option>');
															$("#max_sessions").append('<option value="7">7</option>');
															$("#max_sessions").append('<option value="8">8</option>');
															$("#max_sessions").append('<option value="9">9</option>');
															$("#max_sessions").append('<option value="10">10</option>');
															$("#max_sessions").append('<option value="11">11</option>');
															$("#max_sessions").append('<option value="12">12</option>');
															$("#max_sessions").append('<option value="13">13</option>');
															$("#max_sessions").append('<option value="14">14</option>');
															$("#max_sessions").append('<option value="15">15</option>');
															$("#max_sessions").append('<option value="16">16</option>');
															$("#max_sessions").append('<option value="17">17</option>');
															$("#max_sessions").append('<option value="18">18</option>');
															$("#max_sessions").append('<option value="19">19</option>');
															$("#max_sessions").append('<option value="20">20</option>');
															$("#max_sessions").append('<option value="21">21</option>');
															$("#max_sessions").append('<option value="22">22</option>');
															$("#max_sessions").append('<option value="23">23</option>');
															$("#max_sessions").append('<option value="24">24</option>');



														}
													</script>

													<div class="control-group">
														<label class="control-label" for="max_sessions">Max Sessions/24 Hours<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5">
															<select id="max_sessions" name="max_sessions" class="span2">

																<?php
																for ($i = 1; $i <= 24; $i++) {
																?>

																	<option <?php if ($edit_p_maxses == $i) {
																				echo ' selected ';
																			} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>

																<?php
																}
																?>
															</select>


														</div>
													</div>



													<div class="control-group">
														<label class="control-label" for="max_sessions_alert">Max Session Alert<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5 form-group">
															<input required class="span4 form-control" id="max_sessions_alert" name="max_sessions_alert" type="text" value="<?php echo $edit_p_alert; ?>">


														</div>
														<font class="controls" style="font-size: small">(Hint: You reached the maximum number of sessions per day. Please come back.)</font>
													</div>


													<!--  	<div class="control-group">
														<label class="control-label" for="product_code">Profile Values</label>
														<div class="controls col-lg-5">
															<input class="span4" id="product_code1" name="product_code1" type="text" required>
													-->

													<!-- &nbsp;, -->

													<!--<input class="span2" id="product_code2" name="product_code2" type="text" required>&nbsp;,
															<input class="span2" id="product_code3" name="product_code3" type="text" required>  -->
													<!--
														</div>
													</div> -->




													<?php if ($edit_guest_product == 1) { ?>
														<input type="hidden" name="guest_package_edit" value="<?php echo $edit_p_id; ?>">
														<input type="hidden" name="edit_guest_id" value="<?php echo $edit_p_id; ?>">
													<?php }
													?>

													<div class="form-actions">
														<button type="submit" name="create_product_submit_guest" id="create_product_submit_guest" class="btn btn-primary">Save</button>

													</div>
												</fieldset>
											</form>


											<script type="text/javascript">
												$(document).ready(function() {


													$('#product_name2, #description1, #description1_up, #Purge_delay_time2, #max_sessions_alert').keyup(function(e) {

														ck_gstval();

													});

													<?php if (!isset($edit_p_id)) { ?>
														document.getElementById("create_product_submit_guest").disabled = true;

													<?php } ?>
													var edit_product_gst = '<?php echo $edit_guest_product; ?>';
													if (edit_product_gst != 1) {
														document.getElementById("description1").readOnly = false;
														document.getElementById("description1_up").readOnly = false;
													}

												});


												function ck_gstval() {

													var name = document.getElementById('product_name2').value;
													var qos1 = document.getElementById('description1').value;
													var qos2 = document.getElementById('description1_up').value;
													var pdtime = document.getElementById('Purge_delay_time2').value;
													var maxses = document.getElementById('max_sessions_alert').value;


													var format = /^[^\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\[|\{|\]|\}|\||\\|\'|\<|\,|\.|\>|\?|\/|\""|\;|\:]+$/i;

													if (name.match(format)) {
														name = 'set';
													} else {
														name = '';
													}


													if (name == '' || qos1 == '' || qos2 == '' || pdtime == '' || maxses == '') {
														document.getElementById("create_product_submit_guest").disabled = true;

													} else {
														document.getElementById("create_product_submit_guest").disabled = false;

													}



												}
											</script>


											<div id="view_guest_pof_div" class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3> Guest Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto">
														<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
															<thead>
																<tr>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile Name</th>

																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DL</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">UL</th>

																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Max Sessions</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Purge time</th>

																	<!-- <th style="min-width: 100px;">Status</th> -->
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Remove</th>

																</tr>
															</thead>
															<tbody>

																<?php
																$key_q1 = "SELECT p.id,p.product_code,p.QOS,p.QOS_up_link,p.time_gap,p.create_date,p.default_value , IF(d.product_id IS NULL,0,IF(group_concat(d.distributor_code) ='' ,0,1))  AS assign, p.`max_session`,p.`purge_time`
																			FROM exp_products p LEFT JOIN exp_products_distributor d
																			ON p.`product_id`=d.`product_id`
																			WHERE p.mno_id = '$user_distributor' AND p.network_type='GUEST'
																			GROUP BY p.id,p.product_code,p.QOS,p.QOS_up_link,p.time_gap,p.create_date,p.default_value ,'assign',p.`max_session`,p.`purge_time`
																			ORDER BY p.`QOS`";

																//$query_results1=mysql_query($key_q1);
																$query_results1 = $db->SelectDB($key_q1);

																//while($row=mysql_fetch_array($query_results1)){
																foreach ($query_results1['data'] as $row) {
																	$product_code = $row['product_code'];
																	$description = $row['QOS'];
																	$description_up = $row['QOS_up_link'];


																	$create_date = $row['create_date'];
																	$default_value = $row['default_value'];
																	$product_id = $row['id'];
																	$assign = $row['assign'];
																	$max_ses = $row['max_session'];
																	$purge_time = $row['purge_time'];

																	// $timegap = $row['time_gap'];
																	// $gap = "";
																	// if($timegap != ''){

																	//     try{
																	//         $interval = new DateInterval($timegap);
																	//     }catch (Exception $e){
																	//         echo $e->getMessage();
																	//     }

																	// 	if($interval->y != 0){
																	// 		$gap .= $interval->y.' Years';
																	// 	}
																	// 	if($interval->m != 0){
																	// 		$gap .= $interval->m.' Months';
																	// 	}
																	// 	if($interval->d != 0){
																	// 		$gap .= $interval->d.' Days';
																	// 	}
																	// 	if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
																	// 		$gap .= ' And ';
																	// 	}
																	// 	if($interval->i != 0){
																	// 		$gap .= $interval->i.' Minutes';
																	// 	}
																	// 	if($interval->h != 0){
																	// 		$gap .= $interval->h.' Hours';
																	// 	}

																	// }



																	echo '<tr>
																		<td> ' . $product_code . ' </td>
																		
																		<td> ' . $description . ' Mbps </td>
	     																<td> ' . $description_up . ' Mbps </td>

																		<td> ' . $max_ses . '</td>
																		<td> ' . $purge_time . '</td>';

																	if ($default_value == 1) {

																		/*
																		echo '<td><a href="javascript:void();" id="CD1_'.$product_id.'"  class="btn btn-small btn-success">
															Active<i class="btn-icon-only icon-thumbs-up">   </i> </a>&nbsp;<img id="campcreate_loader_'.$product_id.'" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#CD1_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Inactive Profile\',
																				text: \'Are you sure you want to inactive this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                $(\'#CD1_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&status=1&mno_id='.$user_distributor.'&pro_default_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script></td>';
																				*/
																		//echo '</td>';

																	} else {
																		/*      echo '<td>';

                                                                            echo '<a href="javascript:void();" id="CD1_'.$product_id.'"  class="btn btn-small btn-warning">
															Inactive<i class="btn-icon-only icon-thumbs-down"> </i> </a>&nbsp;
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            		$(\'#CD1_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Active Profile\',
																				text: \'Are you sure you want to active this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                $(\'#CD1_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&status=0&mno_id='.$user_distributor.'&pro_default_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script>

                                                            </td>'; */
																		/*
																		 * $("#create_product_submit").easyconfirm({locale: {
																				title: 'Product Creation',
																				text: 'Are you sure you want to save this informations ?',
																				button: ['Cancel',' Confirm'],
																				closeText: 'close'
																				 }
																			});
																			$("#create_product_submit").click(function() {
																			});
																		 * */
																	}

																	echo '<td>';
																	echo '
                                                                        <a href="javascript:void();" id="EDIT_AP1_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_AP1_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_AP1_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&edit_product_id=' . $product_id . '#create_guest_prof_h3"
                                                                            });
                                                                            });
                                                                        </script></td>';
																	echo '<td>';
																	if ($assign == 0) {
																		echo '<a href="javascript:void();" id="AP1_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a>&nbsp;<img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																		$(\'#AP1_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#AP1_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&remove_product_id=' . $product_id . '&api_id=' . $api_id . '"
                                                                            });
                                                                            });
                                                                        </script>';
																	} else {

																		echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-trash"></i>&nbsp;Remove</a></center>';
																	}
																	echo '</td>';
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>


											<!-- /////////////////////////////////////////////////////////////// -->

										</div>

									<?php } ?>

									<!-- ////////////////////////////////////// -->
									<!-- ////////////////////////////////product create //////////////////// -->



									<?php if (in_array("CONFIG_DURATION", $features_array)) { ?>
										<div <?php if ((isset($tab2) && $user_type == 'MNO') || (isset($tab2) && $user_type == 'SALES')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="duration_create">

											<div id="response_">



											</div>

											<!-- ///////////////////////////////////////////////////////////// -->



											<h3>Create Session Duration Profile(s)</h3>
											<br>
											<form onkeyup="dura_ck();" onchange="dura_ck();" id="create_duration_form" name="create_duration_form" method="post" class="form-horizontal" action="?t=2" autocomplete="off">
												<fieldset>

													<div id="response_d3">
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>






													<div class="control-group">
														<label class="control-label" for="product_name">Name<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5 form-group">
															<input class="span4" id="duration_product_name" name="duration_product_name" type="text" value="<?php if ($edit_product_duration == 1) {
																																								echo $edit_dura_name;
																																							} ?>" <?php if ($edit_product_duration == 1) {
																																										echo 'readonly';
																																									} ?>>

														</div>

													</div>

													<?php
													if ($edit_product_duration == 1) {
														$timegap1 = $edit_dura_timegap;
														if ($timegap1 != '') {

															$interval1 = new DateInterval($timegap1);

															if ($interval1->y != 0) {
																$gap_year1 = $interval1->y;
															}
															if ($interval1->m != 0) {
																$gap_month1 = $interval1->m;
															}
															if ($interval1->d != 0) {
																$gap_day1 = $interval1->d;
															}
															if ($interval1->i != 0) {
																$gap_min1 = $interval1->i;
															}
															if ($interval1->h != 0) {
																$gap_hour1 = $interval1->h;
															}
														}
													}
													?>


													<div class="control-group">
														<label class="control-label" for="product_code">Session Duration<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5">


															<select id="du_select1" name="du_select1" class="span0">
																<option selected value="0">0</option>
																<?php for ($i = 1; $i <= 12; $i++) {

																	if ($gap_month1 == $i || $gap_day1 == $i) {
																		echo '<option selected value="' . $i . '">' . $i . '</option>';
																	} else {
																		echo '<option value="' . $i . '">' . $i . '</option>';
																	}
																}
																?>
																<script type="text/javascript">
																	$(document).ready(function() {
																		$("#du_select2").change(function() {
																			var parent = $(this).val();
																			switch (parent) {
																				case 'M':
																					$("#du_select1").html("");
																					var i;
																					for (i = 0; i <= 12; i++) {

																						$("#du_select1").append('<option value="' + i + '">' + i + '</option>');

																					}
																					break;
																					//break;
																				case 'D':
																					$("#du_select1").html("");
																					var i;
																					for (i = 0; i <= 30; i++) {

																						$("#du_select1").append('<option value="' + i + '">' + i + '</option>');
																					}
																					break;

																			}
																		})
																	});
																	//function to populate child select box
																</script>
															</select>


															<select id="du_select2" name="du_select2" class="span0">
																<option <?php if (isset($gap_month1)) {
																			echo 'selected';
																		} ?> value="M">Months</option>
																<option <?php if (isset($gap_day1)) {
																			echo 'selected';
																		} ?> value="D">Days</option>
															</select>
														</div>
														<div class="controls col-lg-5">
															<!-- <td><b> +</p> </b></td> -->

															<select id="du_select3" name="du_select3" class="span0">
																<option value="0">0</option>
																<?php

																for ($i = 1; $i < 25; $i++) {
																?>
																	<option <?php if ($gap_hour1 == $i) {
																				echo 'selected';
																			} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>

																<?php } ?>

															</select>

															<select id="du_select4" name="du_select4" class="span0">

																<option <?php if (isset($gap_hour1)) {
																			echo 'selected';
																		} ?> value="H">Hours</option>

															</select>
														</div>
														<style type="text/css">
															@media (max-width: 979px) and (min-width: 768px) {

																#du_select1,
																#du_select2,
																#du_select3,
																#du_select4,
																#du_select5,
																#du_select6 {
																	width: 112px !important;
																}

															}

															@media (min-width: 980px) {

																#du_select1,
																#du_select2,
																#du_select3,
																#du_select4,
																#du_select5,
																#du_select6 {
																	width: 148px !important;
																}
															}

															@media (max-width: 768px) and (min-width: 480px) {

																#du_select1,
																#du_select3,
																#du_select5 {
																	width: 62px !important;
																	display: inline-block !important;
																}

																#du_select2,
																#du_select4,
																#du_select6 {
																	width: 92px !important;
																	display: inline-block !important;
																}

															}

															@media (max-width: 480px) and (min-width: 392px) {

																#du_select1,
																#du_select3,
																#du_select5,
																#du_select2,
																#du_select4,
																#du_select6 {
																	display: inline-block !important;
																	width: 124px !important;
																}


															}

															@media (max-width: 392px) {

																#du_select1,
																#du_select3,
																#du_select5,
																#du_select2,
																#du_select4,
																#du_select6 {
																	display: inline-block !important;
																	width: 49.2% !important;
																}


															}

															@media (min-width: 1200px) {

																#du_select1,
																#du_select3,
																#du_select5,
																#du_select2,
																#du_select4,
																#du_select6 {
																	width: 183px !important;
																}
															}
														</style>
														<!-- <td><b> +</p> </b></td> -->


														<div class="controls col-lg-5">
															<select id="du_select5" name="du_select5" class="span0">
																<option value="0">0</option>
																<?php

																for ($i = 1; $i < 61; $i++) {
																?>
																	<option <?php if ($gap_min1 == $i) {
																				echo 'selected';
																			} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>

																<?php } ?>

															</select>

															<select id="du_select6" name="du_select6" class="span0">

																<option <?php if (isset($gap_min1)) {
																			echo 'selected';
																		} ?> value="M">Minutes</option>

															</select>

														</div>

													</div>
													<div style=" margin-top: -22px; " class="control-group">
														<div class="controls col-lg-5 form-group">
															<input type="hidden" name="duration" id="duration">
														</div>

													</div>

													<div class="control-group">
														<label class="control-label" for="product_code">Profile Type<strong>
																<font color="#FF0000"></font>
															</strong></label>
														<div class="controls col-lg-5 form-group">
															<select onchange="isdef()" id="product_du_type" name="product_du_type" class="span4">
																<option <?php echo $edit_dure_type == '1' ? 'selected' : ''; ?> value="1">Guest Only</option>
																<?php if ($network_opt == 'privat' || $network_opt == 'both') { ?> <option <?php echo $edit_dure_type == '2' ? 'selected' : ''; ?> value="2">Private Only</option> <?php } ?>

															</select>
														</div>
													</div>

													<div id="default_ckeck" class="control-group">
														<label class="control-label" for="radiobtns">Is Default</label>
														<div class="controls">
															<div class="">
																<input id="is_default" <?php if ($edit_is_def == '1') {
																							echo 'checked';
																						} ?> name="is_default" type="checkbox">
															</div>
														</div>
													</div>


													<script type="text/javascript">
														function isdef() {
															var type = $("#product_du_type").val();

															if (type == '1') {

																$("#default_ckeck").show();
															} else {

																$("#default_ckeck").hide();
															}

														}


														$(document).ready(function() {
															isdef();
														});
													</script>


													<?php if ($edit_product_duration == 1) { ?>
														<input type="hidden" name="edit_duration_id" value="<?php echo $edit_dura_id; ?>">
														<input type="hidden" name="duration_package_edit" value="<?php echo $edit_dura_code; ?>">
													<?php }
													?>

													<div class="form-actions">
														<?php if ($edit_product_duration == 1) { ?>
															<button type="submit" name="duration_product_cancel" id="duration_product_cancel" class="btn btn-primary">Cancel</button>
														<?php }
														?>
														<button type="submit" name="duration_product_submit" id="duration_product_submit" class="btn btn-primary" disabled="disabled">Save</button>


													</div>
												</fieldset>
											</form>

											<script type="text/javascript">
												function dura_ck() {


													document.getElementById("duration_product_submit").disabled = false;



												}
											</script>


											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3> Duration Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto">
														<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>



															<thead>
																<tr>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile Name</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Session Duration</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Type</th>

																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>

																</tr>
															</thead>
															<tbody>
																<?php
																$key_q1 = "SELECT	p.`id`,p.`profile_name`,p.`duration`,p.`profile_type`,p.`is_enable`,p.`is_default`,if(ISNULL(d.duration_prof_code),'0','1') AS riserv
FROM `exp_products_duration` p  LEFT JOIN exp_products_distributor d ON p.profile_code=d.duration_prof_code
WHERE `distributor`='$user_distributor' GROUP BY id,p.`profile_name`,p.`duration`,p.`profile_type`,p.`is_enable`,p.`is_default`,'riserv' ORDER BY is_default DESC";

																//$query_results1=mysql_query($key_q1);
																$query_results1 = $db->selectDB($key_q1);

																//while($row=mysql_fetch_array($query_results1)){
																foreach ($query_results1['data'] as $row) {
																	$product_id = $row['id'];
																	$product_name = $row['profile_name'];
																	$product_duration = $row['duration'];
																	$product_type = $row['profile_type'];
																	$assign = $row['riserv'];

																	$duration_isdef = $row['is_default'];

																	if ($duration_isdef == '1') {

																		$isdef_tableval = ' (Default)';
																	} else {
																		$isdef_tableval = '';
																	}


																	switch ($product_type) {
																		case '1': {
																				$product_type = 'Guest';
																				break;
																			}
																		case '2': {
																				$product_type = 'Private';
																				break;
																			}
																		case '3': {
																				$product_type = 'Guest & Private';
																				break;
																			}
																	}
																	$product_status = $row['is_enable'];

																	$gap = "";
																	if ($product_duration != '') {

																		$interval = new DateInterval($product_duration);

																		if ($interval->y != 0) {
																			$gap .= $interval->y . ' Year(s) ';
																		}
																		if ($interval->m != 0) {
																			$gap .= $interval->m . ' Month(s) ';
																		}
																		if ($interval->d != 0) {
																			$gap .= $interval->d . ' Day(s) ';
																		}
																		if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0)) {
																			$gap .= ' And ';
																		}
																		if ($interval->h != 0) {
																			$gap .= $interval->h . ' Hour(s) ';
																		}
																		if ($interval->i != 0) {
																			$gap .= $interval->i . ' Minute(s) ';
																		}
																	}


																	if (($network_opt == 'guest' && $product_type != 'Private') || $network_opt != 'guest') {
																		echo '<tr>
																		<td> ' . $product_name . ' </td>
																		<td> ' . $gap . '</td>
																		<td> ' . $product_type . $isdef_tableval . '</td>';



																		///////////////////////////////////////////

																		echo '<td>';
																		echo '
                                                                        <a href="javascript:void();" id="EDIT_dura_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><img id="ap_loader2_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_dura_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_dura_' . $product_id . '\').click(function() {
                                                                                window.location = "?token=' . $secret . '&t=2&edit_dura_product_id=' . $product_id . '"
                                                                            });
                                                                            });
                                                                        </script></td>';

																		//////////////////////////////////////////
																		echo '<td>';
																		if ($assign == 0) {
																			echo '<a href="javascript:void();" id="rm_dura_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="icon icon-trash"></i>&nbsp;Remove</a>&nbsp;<img id="rm_dura_' . $product_id . '" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#rm_dura_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});


                                                                            $(\'#rm_dura_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=2&remove_duration_id=' . $product_id . '"
                                                                            });
                                                                            });
                                                                        </script>';
																		} else {


																			echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-trash"></i>&nbsp;Remove</a></center>';
																		}
																		echo '</td>';
																	}
																}
																?>


															</tbody>
														</table>
													</div>
												</div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->


											<!-- /////////////////////////////////////////////////////////////// -->

										</div>
									<?php }
									if (!in_array("CONFIG_DURATION", $features_array)) { ?>
										<div <?php if ((isset($tab18) && $user_type == 'MNO') || (isset($tab18) && $user_type == 'SALES')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="ale5_create_product">

											<div id="response_">



											</div>

											<!-- ///////////////////////////////////////////////////////////// -->


											<h3>Set Default Products(s)</h3>
											<br>
											<form onkeyup="product_ck();" onchange="product_ck();" id="create_product_default_form" name="create_product_default_form" method="post" class="form-horizontal" action="?t=18" autocomplete="off">
												<fieldset>

													<div id="response_d3">
													</div>
													<?php
													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';
													?>


													<div class="control-group">
														<div class="controls col-lg-5 form-group" style="margin-left: 125px;">
															<label for="mno_features">Enable Default Product</label>
															<select class="form-control span4" multiple="multiple" id="default_product" name="default_product[]">
																<option value="" disabled="disabled"> Choose Product(s)</option>

																<?php

																$query = "SELECT `product_id`,`product_code`,`default_product` FROM `exp_products`  WHERE `mno_id`='$user_distributor' AND  `network_type`= 'GUEST'";

																$query_result_product = $db->selectDB($query);
																foreach ($query_result_product['data'] as $row) {

																	$product_id = $row[product_id];
																	$default_product = $row[default_product];
																	$product_code = $row[product_code];

																	if ($default_product == 1) {
																		echo "<option selected value='" . $product_id . "'>" .  $product_code . "</option>";
																	} else {
																		echo "<option value='" . $product_id . "'>" .  $product_code . "</option>";
																	}
																}

																?>


															</select>
														</div>

													</div>
													<div class="control-group">
														<div class="controls col-lg-5 form-group" style="margin-left: 125px;">
															<button type="submit" name="default_product_submit" id="default_product_submit" class="btn btn-primary" disabled="disabled">Save</button>
														</div>

													</div>


												</fieldset>
											</form>

											<script type="text/javascript">
												function product_ck() {


													document.getElementById("default_product_submit").disabled = false;



												}
											</script>



											<!-- /widget -->


											<!-- /////////////////////////////////////////////////////////////// -->

										</div>
									<?php }
									?>



									<!-- ////////////////////////////////////// -->




									<!-- ==================== registration ==================== -->
									<?php if (in_array("CONFIG_REGISTER", $features_array)) { ?>
										<div class="tab-pane <?php if (isset($tab22)) { ?>active <?php } ?>" id="registration">

											<div class="support_head_visible" style="display:none;">
												<div class="header_hr"></div>
												<div class="header_f1" style="width: 100%;margin-bottom: 40px;">
													Registration</div>
												<br class="hide-sm"><br class="hide-sm">
												<div class="header_f2" style="width: 100%;"> </div>
											</div>

											<?php if ($user_type != 'MVNO_ADMIN') { ?>
												<form id="fb_form" method="post" action="?t=22" name="fb_form" class="form-horizontal" style="display: none;">

													<!--    <legend>Facebook</legend> -->

													<div id="fb_response"></div>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Facebook App ID</label>
														<div class="controls">
															<div class="input-prepend input-append">
																<input class="span4" id="fb_app_id" name="fb_app_id" type="text" value="<?php echo $db->setSocialVal("FACEBOOK", "app_id", $user_distributor); ?>" required>
															</div>
														</div>
														<!-- /controls -->
													</div>

													<!-- /control-group -->
													<?php
													$br = $db->selectDB("SHOW TABLE STATUS LIKE 'exp_social_profile'");
													//$rowe = mysql_fetch_array($br);
													foreach ($br['data'] as $rowbr) {
														$auto_increment = $rowbr['Auto_increment'];
													}
													//$auto_increment = $br['data']['Auto_increment'];
													$social_profile = 'social_' . $auto_increment;
													?>

													<input class="span4" id="social_profile" name="social_profile" type="hidden" value="<?php echo $social_profile; ?>">
													<input class="span4" id="app_xfbml" name="app_xfbml" type="hidden" value="true">
													<input class="span4" id="app_cookie" name="app_cookie" type="hidden" value="true">
													<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>">
													<div class="control-group">
														<label class="control-label" for="radiobtns">Facebook App Version</label>
														<div class="controls">
															<div class="input-prepend input-append">
																<input class="span4" id="fb_app_version" name="fb_app_version" type="text" value="<?php echo $db->setSocialVal("FACEBOOK", "app_version", $user_distributor); ?>" required>
															</div>
														</div>
													</div>
													<?php
													$q1 = "SELECT `config_file` FROM `exp_plugins` WHERE `plugin_code` = 'FACEBOOK'";
													//$r1 = mysql_query($q1);
													$r1 = $db->selectDB($q1);
													//while ($row = mysql_fetch_array($r1)) {
													foreach ($r1['data'] as $row) {
														$additionalFields = strlen($row[config_file]) > 0 ? '1' : '0';

														$array_plugin =  explode(',', $row[config_file]);
													}

													if ($additionalFields == '1') { ?>
														<div class="control-group">
															<label class="control-label" for="radiobtns">Facebook Additional Fields</label>

														<?php


														$q11 = "SELECT `fields` FROM `exp_social_profile` WHERE `social_media` = 'FACEBOOK' AND `distributor` = '$user_distributor'";
														//$r11 = mysql_query($q11);
														$r11 = $db->selectDB($q11);
														//while ($row1 = mysql_fetch_array($r11)) {
														foreach ($r11['data'] as $row1) {
															$array_db_field =  explode(',', $row1[fields]);
														}


														foreach ($array_plugin as $arr) {

															echo '<div class="controls">
														<div class="input-prepend input-append">';

															if (in_array($arr, $array_db_field)) {
																echo '<input name="fb_fields[]" id="fb_fields" type="checkbox" value="' . $arr . '" checked> ' . $arr . ' <br>';
															} else {

																echo '<input name="fb_fields[]" id="fb_fields" type="checkbox" value="' . $arr . '"> ' . $arr . ' <br>';
															}
															echo '</div>
												</div>
												</div>';
														}
													}

														?>


														<div class="form-actions">

															<button name="fb_submit" type="submit" class="btn btn-primary">Save</button>

															<img id="fb_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

														</div>

														<!-- /form-actions -->

														</fieldset>

												</form>

											<?php } ?>



											<form id="manual_reg" class="form-horizontal" action="" method="POST" name="manual_reg">


												<?php


												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';



												?>


												<fieldset>

													<legend>Manual Registration</legend>


													<div id="manual_response"></div>

													<div class="col-sm-6">


														<div class="control-group">

															<label class="control-label" for="radiobtns">First Name</label>

															<div class="controls">

																<div class="input-prepend input-append">



																	<?php

																	//$mno = $parent;

																	$r = $db->getManualReg('first_name', $mno_id, $user_distributor);

																	if ($r == 1) {

																		echo '<input id="m_first_name" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {

																		echo '<input id="m_first_name" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}

																	?>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->





														<div class="control-group">

															<label class="control-label" for="radiobtns">Last Name</label>



															<div class="controls">

																<div class="input-prepend input-append">

																	<?php

																	$r = $db->getManualReg('last_name', $mno_id, $user_distributor);

																	if ($r == 1) {

																		echo '<input id="m_last_name" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {

																		echo '<input id="m_last_name" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}

																	?>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->


														<div class="control-group">

															<label class="control-label" for="radiobtns">E-mail</label>

															<div class="controls">

																<div class="input-prepend input-append">


																	<?php



																	$r = $db->getManualReg('email', $mno_id, $user_distributor);

																	if ($r == 1) {


																		echo '<input id="m_email" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {


																		echo '<input id="m_email" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}


																	?>


																</div>


															</div>

															<!-- /controls -->

														</div>


														<!-- /control-group -->


														<?php

														$br = $db->selectDB("SHOW TABLE STATUS LIKE 'exp_manual_reg_profile'");

														//$rowe = mysql_fetch_array($br);

														foreach ($br['data'] as $rowbr) {
															$auto_increment = $rowbr['Auto_increment'];
														}

														$manual_profile = 'manual_' . $auto_increment;

														?>

														<input class="span4" id="manual_profile" name="manual_profile" type="hidden" value="<?php echo $manual_profile; ?>">


														<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>">

													</div>



													<div class="col-sm-6">

														<div class="control-group">

															<label class="control-label" for="radiobtns">Gender</label>



															<div class="controls">

																<div class="input-prepend input-append">


																	<?php


																	$r = $db->getManualReg('gender', $mno_id, $user_distributor);
																	if ($r == 1) {

																		echo '<input id="m_gender" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {

																		echo '<input id="m_gender" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}

																	?>


																</div>







															</div>







														</div>


														<div class="control-group">

															<label class="control-label" for="radiobtns">Age Group</label>

															<div class="controls">







																<div class="input-prepend input-append">

																	<?php


																	$r = $db->getManualReg('age_group', $mno_id, $user_distributor);
																	if ($r == 1) {

																		echo '<input id="m_age_group" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {

																		echo '<input id="m_age_group" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}


																	?>

																</div>

															</div>

														</div>


														<div class="control-group">

															<label class="control-label" for="radiobtns">Mobile Number</label>



															<div class="controls">

																<div class="input-prepend input-append">

																	<?php

																	$r = $db->getManualReg('mobile_number', $mno_id, $user_distributor);

																	if ($r == 1) {

																		echo '<input id="m_mobile_num" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	} else {

																		echo '<input id="m_mobile_num" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
																	}

																	?>

																</div>

															</div>

															<!-- /controls -->

														</div>

														<!-- /control-group -->




													</div>


													<div class="form-actions">

														<button type="button" name="manual_reg" onclick="getInfoBox('manual','manual_response')" class="btn btn-primary">Save</button>
														<img id="manual_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



													</div>


													<!-- /form-actions -->

												</fieldset>

											</form>


											<form id="edit_profile" class="form-horizontal" action="stock.php" method="POST" name="edit_profile">


												<?php


												echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';


												?>



												<fieldset>


													<!-- <fieldset>







												<legend>Twitter</legend>







												<div id="twitter_response"></div>







												<div class="control-group">







													<label class="control-label" for="radiobtns">Twitter Sign IN option</label>















													<div class="controls">







														<div class="input-prepend input-append">







														<input type="checkbox" name="twitter_status" > Enable















														</div>







													</div>







												</div>















												<div class="control-group">







													<label class="control-label" for="radiobtns">Twitter App ID</label>















													<div class="controls">







														<div class="input-prepend input-append">















														<input class="span4" id="twitter_ap_id" name="twitter_ap_id" type="text" value=" " required="required">















														</div>







													</div>







												</div>















												<div class="form-actions">







													<button type="button" name="submit"







														class="btn btn-primary">Save</button>







														<img id="twitter_loader" src="img/loading_ajax.gif" style="visibility: hidden;">















												</div>







											</fieldset>	 -->







											</form>



										</div>
									<?php } ?>






									<!-- ======================= live_camp =============================== -->

									<div <?php if (isset($tab1) && ($user_type == 'ADMIN')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="live_camp">

										<?php

										//echo $package_functions->getOptions('CONFIG_GENARAL_FIELDS',$system_package);
										$tab1_field_ar = json_decode($package_functions->getOptions('CONFIG_GENARAL_FIELDS', $system_package), true);
										//print_r($tab1_field_ar);
										?>

										<div id="system_response"></div>



										<!--<h3>ADMIN - Portal Image </h3>

										<p>Recommend Size (160 x 30 px)</p>

										<div>

											< ?php


											$url = '?type=admin_tlogo&id=ADMIN'; ?>

											<form onkeyup="edit_profilefn();" onchange="edit_profilefn();" id="imageform5" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

												<label class="btn btn-primary">
													Browse Image
													<span> <input type="file" name="photoimg5" id="photoimg5" /></span>
												</label>

											</form>



											<?php

											$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'site_logo' LIMIT 1";

											$query_results = $db->selectDB($key_query);

											//while($row=mysql_fetch_array($query_results)){
											foreach ($query_results['data'] as $row) {

												$settings_value = $row[settings_value];
											}

											?>

											<div id='img_preview5'>

												<?php

												if (strlen($settings_value)) { ?>

													<img src="image_upload/logo/<?php echo $settings_value; ?>" border="0" style="background-color:#ddd;width: 100%; max-width: 200px;" />

												<?php } else {

													echo 'No Image';
												} ?>

											</div>

										</div>





										<br><br>-->











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

												<!--<div class="control-group" < ?php

																			if (!array_key_exists('login_title', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?>>

													<label class="control-label" for="radiobtns">Login Title</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="login_title" name="login_title" type="text" value="< ?php echo $db->setVal("login_title", $user_distributor); ?>">



													</div>

												</div>-->




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

												<!--<div class="control-group" < ?php
																			if (!array_key_exists('noc_email', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?>>

													<label class="control-label" for="radiobtns">NOC Email</label>

													<div class="controls form-group">
														<input class="span4 form-control" id="noc_email" name="noc_email" type="text" value="< ?php echo $package_functions->getOptions("TECH_BCC_EMAIL", $system_package); ?>">
													</div>

												</div>-->

												<?php // echo $system_package; 
												?>

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

																$get_tz = "SELECT timezones FROM exp_mno

																WHERE mno_id = '$user_distributor' LIMIT 1";

																$reslts = $db->selectDB($get_tz);

																$timezones = '';
																//while($r=mysql_fetch_array($reslts)){
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

												<!--<div class="control-group" < ?php
																			if (!array_key_exists('captive_url', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">Captive Portal Internal URL</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="base_url" name="base_url" type="text" value="< ?php echo $db->setVal("portal_base_url", $user_distributor); ?>">




													</div>


												</div>
												<div class="control-group">
													<div class="controls form-group">
														<font size="1">Ex: http://10.1.1.1/Ex-portal</font>
													</div>
												</div>-->

												<div class="control-group" <?php
																			if (!array_key_exists('captive_url', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">CRM URL</label>

													<div class="controls form-group">
														<input class="span4 form-control" id="camp_url" name="camp_url" type="text" value="<?php echo $db->setVal("camp_base_url", $user_distributor); ?>">
													</div>

													<!--<div class="control-group">
														<div class="controls form-group">
															<font size="1">Ex: http://10.1.1.1/campaign_portal</font>
														</div>
													</div>-->

												</div>




												<!--<div class="control-group" < ?php
																			if (!array_key_exists('global_url', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">Campaign Portal Global URL</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="global_url" name="global_url" type="text" value="< ?php echo $db->setVal("global_url", $user_distributor); ?>">




													</div>


													<div class="control-group">
														<div class="controls form-group">
															<font size="1">Ex: http://yourcompany.com/campaign_portal</font>
														</div>
													</div>


												</div>

												<div class="control-group" < ?php
																			if (!array_key_exists('reCapture', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none"';
																			}
																			?>>
													<h5><label>Google reCAPTURA</label></h5>

													<label class="control-label" for="radiobtns">Secret Key</label>

													<div class="controls form-group">

														<input type="texy" class="span4 form-control" id="g-reCAPTCHA" name="g-reCAPTCHA" value="< ?php echo $db->setVal("g-reCAPTCHA", 'ADMIN'); ?>">

													</div>
													<br>

													<label class="control-label" for="radiobtns">Site Key</label>

													<div class="controls form-group">

														<input type="text" class="span4 form-control" id="g-reCAPTCHA-site-key" name="g-reCAPTCHA-site-key" value="< ?php echo $db->setVal("g-reCAPTCHA-site-key", 'ADMIN'); ?>">

													</div>
													<br>
												</div>
												<div class="control-group" < ?php
																			if (!array_key_exists('dbr_key', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none"';
																			}
																			?>>
													<label class="control-label" for="radiobtns">Techtool Barcode Reader</label>

													<div class="controls form-group">
														<select name="tech_barcode_reader_status" id="tech_barcode_reader_status">
                                                            < ?php
                                                            $tech_BR_status=explode(',',$db->setVal("tech_barcode_reader_status", 'ADMIN'));
                                                            $tech_BR_status_1 = $tech_BR_status[0];
                                                            $tech_BR_status_2 = $tech_BR_status[1];
                                                            ?>
															<option value="1,< ?php echo $tech_BR_status_2;?>" < ?php echo $tech_BR_status_1 == '1' ? 'selected' : ''; ?>>ON</option>
															<option value="0,< ?php echo $tech_BR_status_2;?>" < ?php echo $tech_BR_status_1 == '0' ? 'selected' : ''; ?>>OFF</option>
														</select>
														<script>
															$(function() {
																$('#tech_barcode_reader_status').on('change', function() {
																	//alert(document.getElementById('tech_barcode_reader_status').val)
																	if (document.getElementById("tech_barcode_reader_status").value == '1,1' || document.getElementById("tech_barcode_reader_status").value == '1,2') {
																		$('#dbr_key_div').show();
																	} else {
																		$('#dbr_key_div').hide();
																	}
																});
															});
														</script>
													</div>
													<div style="display: < ?php echo $tech_BR_status_1 == '1' ? 'block' : 'none'; ?>; " id="dbr_key_div">
														<label class="control-label" for="radiobtns">Dynamsoft < ?php echo $tech_BR_status_2==1?'BR Key':'Organization ID';?></label>

														<div class="controls form-group">

															<input type="text" class="span4 form-control" id="dbr_key" name="dbr_key" value="< ?php echo $db->setVal("dbr_key", 'ADMIN'); ?>">

														</div>
													</div>



												</div>


												<div class="control-group" < ?php
																			if (!array_key_exists('mdu_camp_base_url', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">Tenant Portal URL</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="tenant_url" name="tenant_url" type="text" value="< ?php echo $db->setVal("mdu_portal_base_url", $user_distributor); ?>">




													</div>

													<div class="control-group">
														<div class="controls form-group">
															<font size="1">Ex: http://yourcompany.com/tenant</font>
														</div>
													</div>


												</div>


												<div class="control-group" < ?php
																			if (!array_key_exists('mdu_camp_base_url', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">Tenant Portal Internal URL</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="tenant_internal_url" name="tenant_internal_url" type="text" value="< ?php echo $db->setVal("mdu_camp_base_url", $user_distributor); ?>">




													</div>

													<div class="control-group">
														<div class="controls form-group">
															<font size="1">Ex: http://10.1.1.1/tenant</font>
														</div>
													</div>


												</div>

												<div class="control-group" < ?php
																			if (!array_key_exists('captive_theme_up_tmp', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?> style="margin-bottom: 0px !important;">

													<label class="control-label" for="radiobtns">Template Upload Temporary path</label>

													<div class="controls form-group">



														<input class="span4 form-control" id="captive_theme_up_tmp" name="captive_theme_up_tmp" type="text" value="< ?php echo $db->setVal("captive_theme_up_tmp", $user_distributor); ?>">




													</div>

													<div class="control-group">
														<div class="controls form-group">
															<font size="1">Ex: /var/www/bi/upload/template/</font>
														</div>
													</div>


												</div>





												<div class="control-group" < ?php
																			if (!array_key_exists('menu_option', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none"';
																			}
																			?>>

													<label class="control-label" for="radiobtns">Menu Option</label>

													<div class="controls form-group">



														<select class="span4 form-control" id="menu_type" name="menu_type">

															< ?php $menu_type = $db->setVal("menu_type", 'ADMIN'); ?>

															<option value="SUB_MENU">Sub menu</option>

															<option value="MAIN_MENU">Main menu</option>

														</select>



													</div>

												</div>









												<div id="st_type" class="control-group" < ?php
																						if (!array_key_exists('style_type', $tab1_field_ar) && $system_package != 'N/A') {
																							echo ' style="display:none";';
																						}
																						?>>

													<label class="control-label" for="radiobtns">Style Type</label>





													<div class="controls form-group">



														<select class="span4 form-control" id="style_type" name="style_type">

															<option value="dark" < ?php if ($style_type == 'dark') {
																						echo 'selected';
																					} ?>> Dark Style </option>

															<option value="light" < ?php if ($style_type == 'light') {
																						echo 'selected';
																					} ?>> Light Style </option>

														</select>



													</div>



												</div>



												<!-- https 

												<div class="control-group" < ?php
																			if (!array_key_exists('style_type', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			?>>

													<label class="control-label" for="radiobtns">HTTPS</label>



													< ?php $edit_ssl_on = $db->setVal("SSL_ON", $user_distributor); ?>

													<div class="controls form-group">



														<select class="span4 form-control" id="ssl_on" name="ssl_on">

															<option value="1" < ?php if ($edit_ssl_on == '1') {
																					echo 'selected';
																				} ?>> ON </option>

															<option value="0" < ?php if ($edit_ssl_on == '0') {
																					echo 'selected';
																				} ?>> OFF </option>

														</select>



													</div>



												</div>


												<div class="control-group" < ?php
																			if (!array_key_exists('platform', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			//if(true){echo' style="display:none";';}
																			?>>

													<label class="control-label" for="radiobtns">Admin Profile</label>

													< ?php if ($system_package != 'N/A') { ?>

														<script type="text/javascript">
															//N/A

															$(document).ready(function() {

																$('#st_type').hide();


															});
														</script>
													< ?php } ?>

													<div class="controls form-group">



														<select class="span4 form-control" id="platform" name="platform">
															< ?php
															//echo"SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN'";
															$flatforms_q = $db->selectDB("SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN' AND is_enable=1");

															//while($flatforms=mysql_fetch_assoc($flatforms_q)){
															foreach ($flatforms_q['data'] as $flatforms) {

																if ($system_package == $flatforms['product_code']) {
																	echo '<option selected value=' . $flatforms['product_code'] . ' > ' . $flatforms['discription'] . ' </option>';
																} else {
																	echo '<option value=' . $flatforms['product_code'] . ' > ' . $flatforms['discription'] . ' </option>';
																}
															}
															?>

														</select>



													</div>



												</div>

												<div class="control-group" < ?php
																			if (!array_key_exists('platform', $tab1_field_ar) && $system_package != 'N/A') {
																				echo ' style="display:none";';
																			}
																			//if(true){echo' style="display:none";';}
																			?>>

													<label class="control-label" for="radiobtns">Login Profile</label>
													<div class="controls form-group">
														< ?php

														$login_profiles = json_decode($db->setVal('ALLOWED_LOGIN_PROFILES', 'ADMIN'), true);

														//print_r($login_profiles); die();

														foreach ($login_profiles as $key => $value) {
															$checked = $value == '1' ? 'checked' : '';
															echo '<input ' . $checked . ' type="checkbox" value="' . $key . '" name"login_profiles" class="login_profiles"/>&nbsp&nbsp&nbsp' . $key . '<br>';
														}

														?>
													</div>

													<div class="controls form-group">

													</div>



												</div>

												<script type="text/javascript">
													$('#platform').on('change', function() {

														if ($('#platform').val() != 'N/A') {

															var platform = $('#platform').val();
															var formData = {
																"action": "admin_header_color_bar",
																"platform": platform
															};
															$.ajax({
																url: "ajax/getData.php",
																type: "POST",
																data: formData,
																success: function(data) {
																	var obj = data.split('/');



																	if (obj.indexOf("theme_color") > 0) {
																		$('#theme_color_div').show();
																	} else {
																		$('#theme_color_div').hide();
																	}
																	if (obj.indexOf("light_color") > 0) {
																		$('#light_color_div').show();
																	} else {
																		$('#light_color_div').hide();
																	}
																	if (obj.indexOf("top_line_color") > 0) {
																		$('#top_line_color_div').show();
																	} else {
																		$('#top_line_color_div').hide();
																	}
																	$('#st_type').hide();

																},
																error: function(jqXHR, textStatus, errorThrown) {
																	//alert("error");
																}
															});
														} else {
															$('#top_line_color_div').show();
															$('#theme_color_div').show();
															$('#light_color_div').show();
															$('#st_type').show();
														}
													});
												</script>


												< ?php

												$get_l = "SELECT * FROM exp_mno

WHERE mno_id = '$user_distributor' LIMIT 1";

												//$query_results=mysql_query($get_l);
												$query_results = $db->selectDB($get_l);

												//while($row=mysql_fetch_array($query_results)){
												foreach ($query_results['data'] as $row) {

													$camp_theme_color = $row[theme_color];
												}


												//echo $camp_theme_color;
												?>






												<div id="theme_color_div" class="control-group" < ?php
																								if (!array_key_exists('theme_color', $tab1_field_ar) && $system_package != 'N/A') {
																									echo ' style="display:none";';
																								}
																								?>>

													<label class="control-label" for="radiobtns"> Accent Color </label>

													<div class="controls form-group">



														<input class="span4 form-control jscolor {hash:true}" id="header_color" name="header_color" type="color" value="< ?php echo strlen($camp_theme_color) < 7 ? '#ffffff' : $camp_theme_color ?>">



													</div>

												</div>



												<div id="light_color_div" class="control-group" < ?php
																								if (!array_key_exists('light_color', $tab1_field_ar) && $system_package != 'N/A') {
																									echo ' style="display:none";';
																								}
																								?>>

													<label class="control-label" for="radiobtns"> Light Color </label>

													<div class="controls form-group">



														< ?php
														$light_color = strlen($light_color) < 7 ? '#000000' : $light_color;
														if ($style_type == 'light') {

															echo '<input class="span4 form-control jscolor {hash:true}" id="light_color" name="light_color" type="color" value="' . $light_color . '" >';
														} else {

															echo '<input class="span4 form-control jscolor {hash:true}" id="light_color" name="light_color" type="color" value="' . $light_color . '" disabled>';
														}

														?>





													</div>

												</div>





												<div id="top_line_color_div" class="control-group" < ?php
																									if (!array_key_exists('top_line_color', $tab1_field_ar) && $system_package != 'N/A') {
																										echo ' style="display:none";';
																									}
																									?>>

													<label class="control-label" for="radiobtns"> Top Line Color </label>

													<div class="controls form-group">



														< ?php



														if (strlen($top_line_color) <= 0) {

														?>

															<input class="span4 form-control jscolor {hash:true}" id="top_line_color" name="top_line_color" type="color" value="< ?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>" disabled>

															<br>

															<input type="checkbox" id="top_che"> Enable top line bar



														< ?php

														} else {



														?>

															<input class="span4 form-control jscolor {hash:true}" id="top_line_color" name="top_line_color" type="color" value="< ?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>">

															<br>

															<input type="checkbox" id="top_che" checked> Enable top line bar



														< ?php

														}

														?>







													</div>

												</div>
-->


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








										<!--    <div id="style_img_div" style="box-shadow: 10px 10px 5px #888888;">

                                                        <?php

														if ($style_type == 'dark') {

															echo '<img src="img/dark.png" width="290" height="190">';
														} else {

															echo '<img src="img/light.png" width="290" height="190">';
														}

														?>



                                                    </div> -->









									</div>





									<!-- ====================== live_camp3 ====================== -->

									<div <?php if ((isset($tab0) && $user_type == 'MNO') || (isset($tab0) && $user_type == 'MVNO_ADMIN') || (isset($tab0) && $user_type == 'SALES')) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="live_camp3">



										<!-- <h3>Admin Portal</h3> -->


										<div class="support_head_visible" style="display:none;">
											<div class="header_hr"></div>
											<div class="header_f1" style="width: 100%;">
												Admin Portal</div>
											<br class="hide-sm"><br class="hide-sm">
											<div class="header_f2" style="width: 100%;"> </div>
										</div>


										<div class="img_logo">

											<p>Max Size (160 x 30 px)</p>

											<div>





												<?php $url = '?type=mno_tlogo&id=' . $user_distributor; ?>

												<form onkeyup="edit_profile_afn();" onchange="edit_profile_afn();" id="imageform" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

													<label class="btn btn-primary">
														Browse Image
														<span><input type="file" name="photoimg" class="span4" id="photoimg" />
														</span></label>

												</form>



												<?php

												$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

												//$query_results=mysql_query($key_query);
												$query_results = $db->selectDB($key_query);

												//while($row=mysql_fetch_array($query_results)){
												foreach ($query_results['data'] as $row) {

													$logo = $row[theme_logo];
												}

												?>

												<div id='img_preview'>

													<?php

													if (strlen($logo)) { ?>

														<img src="image_upload/logo/<?php echo $logo; ?>" border="0" style="background-color:#ddd;width: 100%; max-width: 200px;" />

													<?php } else {

														echo 'No Images';
													} ?>

												</div>

											</div>

										</div>



										<!-- <br><br> -->








										<form id="edit_profile_a" class="form-horizontal" method="post">

											<?php



											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

											?>


											<div id="edit_profile_a_hidden_input">
												<input type="hidden" name="header_logo_img" id="header_logo_img" value="<?php echo $logo; ?>">
											</div>
											<fieldset>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Portal Title</label>

													<div class="controls col-lg-5 form-group">
														<input class="form-control span4" id="main_title1" name="main_title1" type="text" value="<?php echo ($user_type == 'MVNO_ADMIN' ? $db->getValueAsf("SELECT  account_name AS f FROM mno_distributor_parent WHERE parent_id='$user_distributor'") : $db->getValueAsf("SELECT  theme_site_title AS f FROM exp_mno WHERE mno_id='$user_distributor'")) ?>">

													</div>
												</div>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Short Title</label>

													<div class="controls col-lg-5 form-group">
														<input class="form-control span4" id="short_title1" name="short_title1" type="text" value="<?php echo $db->setVal("short_title", $user_distributor); ?>">
													</div>

												</div>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Master Email</label>

													<div class="controls col-lg-5 form-group">
														<input class="form-control span4" id="master_email1" name="master_email1" type="text" value="<?php echo $db->setVal("email", $user_distributor); ?>">
													</div>

												</div>
												<div class="control-group">

													<label class="control-label" for="radiobtns">NOC Email</label>

													<div class="controls col-lg-5 form-group">
														<input class="form-control span4" id="noc_email1" name="noc_email1" type="text" value="<?php echo $package_functions->getOptions("TECH_BCC_EMAIL", $system_package); ?>">
													</div>

												</div>

												<?php
												if (false) {
													$tech_config_data = $db->setVal("mno_tech_configuration", $user_distributor);
													$tech_config_ar = json_decode($tech_config_data, true); ?>
													<div class="control-group">

														<label class="control-label" for="radiobtns">Techtool APs</label>

														<div class="controls col-lg-5 form-group">
															<select id="tech_aps" name="tech_aps">

																<?php for ($ap_n = 1; $ap_n <= 12; $ap_n++) {
																	echo "<option value='" . $ap_n . "' " . ($tech_config_ar['tech_ap'] == $ap_n ? 'selected' : '') . ">" . $ap_n . "</option>";
																} ?>
															</select>

														</div>

													</div>

													<div class="control-group">

														<label class="control-label" for="radiobtns">Techtool Switches</label>

														<div class="controls col-lg-5 form-group">

															<select id="tech_switch" name="tech_switch">
																<?php for ($sap_n = 1; $sap_n <= 4; $sap_n++) {
																	echo "<option value='" . $sap_n . "' " . ($tech_config_ar['tech_switch'] == $sap_n ? 'selected' : '') . " >" . $sap_n . "</option>";
																} ?>
															</select>

														</div>

													</div>

												<?php
												} ?>
												<!--	<div class="control-group">

													<label class="control-label" for="radiobtns">Ex Deny Redirect URL</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="deni_url1" name="deni_url1" type="text" value="<?php //echo $db->setVal("deni_url",$user_distributor); 
																																	?>" required="required">

														</div>

													</div>

												</div>  -->











												<!--<div class="control-group">

													<label class="control-label" for="radiobtns">Campaign Portal Theme Color</label>

													<div class="controls">

														<div class="input-prepend input-append">

														<input class="span6" id="mno_header_color" name="mno_header_color" type="color" value="<?php /*echo $db->setVal("mno_color",$user_distributor); */ ?>" required="required">

														</div>

													</div>

												</div>

-->

												<!-- <?php $platformfh = $db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='ADMIN'"); ?>

<?php //if($platformfh!='N/A'){ 
?>


<script type="text/javascript">

$(document).ready(function() {

	$('#dble_fo_na').hide();


    });


</script>



<? php // } 
?> -->

												<div id="dble_fo_na" <?php if ($platformfh != 'N/A') {
																			echo 'style="display: none;"';
																		} ?>>


													<div class="control-group">

														<label class="control-label" for="radiobtns">Style Type</label>





														<div class="controls form-group">



															<select class="span4" id="style_type1" name="style_type">

																<option value="dark" <?php if ($style_type == 'dark') {
																							echo 'selected';
																						} ?>> Dark Style </option>

																<option value="light" <?php if ($style_type == 'light') {
																							echo 'selected';
																						} ?>> Light Style </option>

															</select>



														</div>



													</div>

















													<div class="control-group">

														<label class="control-label" for="radiobtns"> Theme Color </label>

														<div class="controls form-group">



															<input class="span4 jscolor {hash:true}" id="mno_header_color" name="mno_header_color1" type="color" value="<?php echo strlen($camp_theme_color) < 7 ? '#000000' : $camp_theme_color; ?>">



														</div>

													</div>



													<div class="control-group">

														<label class="control-label" for="radiobtns"> Light Color </label>

														<div class="controls form-group">



															<?php
															$light_color = strlen($light_color) < 7 ? '#000000' : $light_color;
															if ($style_type == 'light') {

																echo '<input class="span4 jscolor {hash:true}" id="light_color1" name="light_color" type="color" value="' . $light_color . '" >';
															} else {

																echo '<input class="span4 jscolor {hash:true}" id="light_color1" name="light_color" type="color" value="' . $light_color . '" disabled>';
															}

															?>





														</div>

													</div>





													<div class="control-group">

														<label class="control-label" for="radiobtns"> Top Line Color </label>

														<div class="controls form-group">



															<?php



															if (strlen($top_line_color) <= 0) {

															?>

																<input class="span4 jscolor {hash:true}" id="top_line_color1" name="top_line_color1" type="color" value="<?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>" disabled>

																<br>

																<input type="checkbox" id="top_che1"> Enable top line bar



															<?php

															} else {



															?>

																<input class="span4 jscolor {hash:true}" id="top_line_color1" name="top_line_color1" type="color" value="<?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>">

																<br>

																<input type="checkbox" id="top_che1" checked> Enable top line bar



															<?php

															}

															?>







														</div>

													</div>

												</div>



												<script>
													$('#style_type1').on('change', function() {

														var st = $('#style_type1').val();

														if (st == 'light') {

															$('#light_color1').prop('disabled', false);

															$('#style_img_div1').html('<img src="img/light.png" width="290" height="190">')

														} else {

															$('#light_color1').prop('disabled', true);

															$('#style_img_div1').html('<img src="img/dark.png" width="290" height="190">')

														}

													});



													$('#top_che1').on('change', function() {

														var va = $(this).is(':checked');

														if (va) {

															$('#top_line_color1').prop('disabled', false);

														} else {

															$('#top_line_color1').prop('disabled', true);

															$('#top_line_color1').val("");

														}

													});
												</script>


												<div class="form-actions">

													<button disabled type="submit" id="portal_submit" name="portal_submit" class="btn btn-primary">Save</button>

													<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>
												<script>
													function edit_profile_afn() {

														$("#portal_submit").prop('disabled', false);
													}
												</script>




											</fieldset>







										</form>













									</div>





									<!-- ====================== live_camp2 ============================ -->

									<div <?php if ((isset($tab1) && $user_type != 'ADMIN' && $user_type != 'RESELLER_ADMIN' && $user_type != 'MNO' && $user_type != "SALES" && $user_type != "MVNO_ADMIN" && ($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE', $system_package) != "1"))) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="live_camp2">





										<div id="loc_response"></div>

										<h3>Admin Portal Image </h3>

										<div class="img_logo">
											<p>Max Size (160 x 30)</p>

											<div>



												<?php $url = '?type=mvnx_tlogo&id=' . $user_distributor; ?>

												<form id="imageform2" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>



													<label class="btn btn-primary">
														Browse Image
														<span><input type="file" name="photoimg2" id="photoimg2" /></span></label>



												</form>





												<?php

												$key_query = "SELECT theme_logo FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'";

												//$query_results=mysql_query($key_query);
												$query_results = $db->selectDB($key_query);

												//while($row=mysql_fetch_array($query_results)){
												foreach ($query_results['data'] as $row) {

													$logo2 = $row[theme_logo];
												}

												?>



												<div id='img_preview2'>

													<?php

													if (strlen($logo2)) { ?>

														<img src="image_upload/logo/<?php echo $logo2; ?>" border="0" style="background-color:#ddd;width: 100%; max-width: 200px;" />

													<?php } else {

														echo 'No Images';
													} ?>

												</div>

											</div>
										</div>

										<br><br>





										<table>

											<tr>

												<td>





													<form id="edit-profile" class="form-horizontal">

														<?php

														echo '<input type="hidden" name="distributor_code0" id="distributor_code0" value="' . $user_distributor . '" />';

														?>

														<fieldset>



															<div class="control-group">

																<label class="control-label" for="radiobtns">Site Title</label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<?php

																		$get_l = "SELECT site_title,camp_theme_color FROM exp_mno_distributor

															WHERE distributor_code = '$user_distributor' LIMIT 1";

																		//$query_results=mysql_query($get_l);
																		$query_results = $db->selectDB($get_l);

																		//while($row=mysql_fetch_array($query_results)){
																		foreach ($query_results['data'] as $row) {

																			$site_title = $row[site_title];

																			$camp_theme_color = $row[camp_theme_color];
																		}



																		?>

																		<input class="span4" id="site_title0" name="site_title0" type="text" value="<?php echo $site_title; ?>" required>



																	</div>

																</div>

															</div>







															<div class="control-group">

																<label class="control-label" for="radiobtns">Default Time Zone</label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<?php





																		$utc = new DateTimeZone('UTC');

																		$dt = new DateTime('now', $utc);

																		$get_l = "SELECT time_zone FROM exp_mno_distributor

															WHERE distributor_code = '$user_distributor' LIMIT 1";

																		//$query_results=mysql_query($get_l);
																		$query_results = $db->selectDB($get_l);


																		//while($row=mysql_fetch_array($query_results)){
																		foreach ($query_results['data'] as $row) {

																			$time_zone = $row[time_zone];
																		}



																		echo '<select class="span4" name="php_time_zone0" id="php_time_zone0">';

																		echo '<option value="' . $time_zone . '">' . $time_zone . '</option>';

																		foreach (DateTimeZone::listIdentifiers() as $tz) {

																			$current_tz = new DateTimeZone($tz);

																			$offset =  $current_tz->getOffset($dt);

																			$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());

																			$abbr = $transition[0]['abbr'];

																			echo '<option value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
																		}



																		echo '</select>';

																		?>

																	</div>



																</div>

															</div>







															<div class="control-group">

																<label class="control-label" for="radiobtns">Ex Portal Language</label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<select name="language0" id="language0" required>

																			<?php

																			$get_l = "SELECT language_code,l.language  FROM system_languages l, exp_mno_distributor d

															 WHERE l.language_code = d.language AND d.distributor_code = '$user_distributor' LIMIT 1";

																			//$query_results=mysql_query($get_l);
																			$query_results = $db->selectDB($get_l);

																			//while($row=mysql_fetch_array($query_results)){
																			foreach ($query_results['data'] as $row) {

																				$language_code = $row[language_code];

																				$language = $row[language];
																			}

																			echo '<option value="' . $language_code . '">' . $language . '</option>';

																			$key_query = "SELECT language_code, `language` FROM system_languages WHERE language_code <> '$lang' AND ex_portal_status = 1 ORDER BY `language`";

																			//$query_results=mysql_query($key_query);
																			$query_results = $db->selectDB($key_query);

																			//while($row=mysql_fetch_array($query_results)){
																			foreach ($query_results['data'] as $row) {

																				$language_code = $row[language_code];

																				$language = $row[language];

																				echo '<option value="' . $language_code . '">' . $language . '</option>';
																			}

																			?>





																		</select>

																	</div>

																</div>

															</div>













															<div class="control-group">

																<label class="control-label" for="radiobtns">Style Type</label>





																<div class="controls">

																	<div class="input-prepend input-append">

																		<select class="span4" id="style_type0" name="style_type0">

																			<option value="dark" <?php if ($style_type == 'dark') {
																										echo 'selected';
																									} ?>> Dark Style </option>

																			<option value="light" <?php if ($style_type == 'light') {
																										echo 'selected';
																									} ?>> Light Style </option>

																		</select>

																	</div>

																</div>



															</div>

















															<div class="control-group">

																<label class="control-label" for="radiobtns"> Theme Color </label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<input class="span4 jscolor {hash:true}" id="header_color0" name="header_color0" type="color" value="<?php echo strlen($camp_theme_color) < 7 ? '#ffffff' : $camp_theme_color ?>" required>

																	</div>

																</div>

															</div>



															<div class="control-group">

																<label class="control-label" for="radiobtns"> Light Color </label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<?php

																		$light_color = strlen($light_color) < 7 ? '#000000' : $light_color;
																		if ($style_type == 'light') {

																			echo '<input class="span4 jscolor {hash:true}" id="light_color0" name="light_color0" type="color" value="' . $light_color . '" >';
																		} else {

																			echo '<input class="span4 jscolor {hash:true}" id="light_color0" name="light_color0" type="color" value="' . $light_color . '" disabled>';
																		}

																		?>



																	</div>

																</div>

															</div>





															<div class="control-group">

																<label class="control-label" for="radiobtns"> Top Line Color </label>

																<div class="controls">

																	<div class="input-prepend input-append">

																		<?php

																		if (strlen($top_line_color) <= 0) {

																		?>

																			<input class="span4 jscolor {hash:true}" id="top_line_color0" name="top_line_color0" type="color" value="<?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>" disabled>

																			<br>

																			<input type="checkbox" id="top_che0"> Enable top line bar



																		<?php

																		} else {

																		?>

																			<input class="span4 jscolor {hash:true}" id="top_line_color0" name="top_line_color0" type="color" value="<?php echo strlen($top_line_color) < 7 ? '#ffffff' : $top_line_color ?>">

																			<br>

																			<input type="checkbox" chacked id="top_che0" checked> Enable top line bar



																		<?php

																		}

																		?>





																	</div>

																</div>

															</div>





															<script>
																$('#style_type0').on('change', function() {

																	var st = $('#style_type0').val();

																	if (st == 'light') {

																		$('#light_color0').prop('disabled', false);

																		$('#style_img_div0').html('<img src="img/light.png" width="290" height="190">')

																	} else {

																		$('#light_color0').prop('disabled', true);

																		$('#style_img_div0').html('<img src="img/dark.png" width="290" height="190">')

																	}

																});



																$('#top_che0').on('change', function() {

																	var va = $(this).is(':checked');

																	if (va) {

																		$('#top_line_color0').prop('disabled', false);

																	} else {

																		$('#top_line_color0').prop('disabled', true);

																		$('#top_line_color0').val("");

																	}

																});
															</script>









															<div class="form-actions">

																<button type="button" onclick="getInfoBox('loc','loc_response');" name="submit" class="btn btn-primary">Save</button>

																<img id="loc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

															</div>

															<!-- /form-actions -->

														</fieldset>

													</form>



												</td>
												<td valign="top">



													<div id="style_img_div0" style="box-shadow: 10px 10px 5px #888888;">

														<?php

														if ($style_type == 'dark') {

															echo '<img src="img/dark.png" width="290" height="190">';
														} else {

															echo '<img src="img/light.png" width="290" height="190">';
														}

														?>



													</div>

												</td>

											</tr>

										</table>

									</div>





									<!-- ==================== verify ========================= -->

									<!--<div <?php if (isset($tab12)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="veryfi">

										<div id="response_">



										</div>



										<form id="submit_veryfi_settings" class="form-horizontal" method="POST" action="?t=12">

											<?php

											/*$secret=md5(uniqid(rand(), true));



											$_SESSION['FORM_SECRET'] = $secret;*/

											/*echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';*/

											?>

											<fieldset>





                                                <div>

                                                    <?php

													/*$qq = "SELECT * FROM exp_locations_ssid WHERE `current_theme` IS NULL AND distributor = '$user_distributor'";

                                                    $rr = mysql_query($qq);

                                                    $cnt_theme = mysql_num_rows($rr);

                                                    if($cnt_theme != 0){

                                                        $isalert = 1;

                                                        echo '<legend>Theme</legend>';

                                                        $warning_text = '<div class="alert alert-warning" role="alert"><h3><small>';

                                                        $warning_text .= 'Themes are not assigned to below SSIDs';

                                                        $warning_text .= '</small></h3><ul>';



                                                        while($row11 = mysql_fetch_array($rr)){

                                                            $ssid_q = $row11[ssid];

                                                            //$theme_name = $row[theme_name];



                                                            $warning_text .= '<li>'.$ssid_q.'</option>';

                                                        }



                                                        $warning_text .= '</ul><a href="theme'.$extension.'?active_tab=create_theme" class="alert-link">Click here to create themes</a></div>';

                                                        echo $warning_text;

                                                    }*/

													?>

                                                </div>





                                                <div>

                                                    <?php



													/* // warning

                                                    $query_warning00 = "SELECT ssid as wssid FROM `exp_locations_ssid` s LEFT JOIN `exp_locations_ap_ssid` a

	                                                    ON s.`ssid` = a.`location_ssid` WHERE a.`ap_id` IS NULL AND s.`distributor` = '$user_distributor'";

                                                    $query_results00=mysql_query($query_warning00);

                                                    $cnt_location = mysql_num_rows($query_results00);



                                                    if($cnt_location > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Locations</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    APs are not assigned to below SSIDs</small></h3><ul>';



                                                        while($row0=mysql_fetch_array($query_results00)){

                                                            echo '<li>'.$row0[wssid].'</li>';

                                                        }

                                                        echo '</ul>

		                                                    <a href="location'.$extension.'?t=4" class="alert-link">Click here to Assign APs</a></small></div>';

                                                    }*/

													?>

                                                </div>







                                                <div>

                                                    <?php



													// warning

													/*$query_warning00 = "SELECT m.`description`, m.`tag_name`, m.`distributor`, t.`ad_id`

                                                                FROM `exp_mno_distributor_group_tag` m

                                                                LEFT OUTER JOIN `exp_camphaign_ad_live` t

                                                                ON t.`group_tag` = m.`tag_name`

                                                                WHERE m.`distributor` = '$user_distributor'

                                                                AND t.`ad_id` IS NULL

                                                                GROUP BY m.`tag_name` ";

                                                    $query_results00=mysql_query($query_warning00);

                                                    $cnt_campaign = mysql_num_rows($query_results00);



                                                    if($cnt_campaign > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Campaign</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No live campaigns are assigned to below group tags</small></h3><ul>';



                                                        while($row0=mysql_fetch_array($query_results00)){

                                                            echo '<li>'.$row0[description].'</li>';

                                                        }

                                                        echo '</ul>

		                                                    <a href="campaign'.$extension.'" class="alert-link">Click here to manage campaigns</a></small></div>';

                                                    }*/

													?>

                                                </div>





                                                <div>

                                                    <?php



													// warning

													/* $key_query = "SELECT * FROM exp_locations_ssid WHERE distributor = '$user_distributor'";

                                                    $query_results=mysql_query($key_query);

                                                    $cnt_ssid = mysql_num_rows($query_results);



                                                    if($cnt_ssid == 0){

                                                        $isalert = 1;

                                                        echo '<legend>SSID</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No SSIDs are created</small></h3>';

                                                        echo '<a href="location'.$extension.'?t=3" class="alert-link">Click here to create a SSID</a></div>';

                                                    }*/

													?>

                                                </div>



                                                <div>

                                                    <?php



													// warning

													/* $key_query = "SELECT * FROM `exp_mno_distributor_aps` WHERE `distributor_code` = '$user_distributor'";

                                                    $query_results=mysql_query($key_query);

                                                    $cnt_ap = mysql_num_rows($query_results);



                                                    if($cnt_ap == 0){

                                                        $isalert = 1;

                                                        echo '<legend>Aps</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No Aps are created</small></h3>';

                                                        echo '</div>';

                                                    }*/

													?>

                                                </div>



                                                <div>

                                                    <?php





													/*if($isalert == 0){





                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    There are no verification alerts</small></h3>';

                                                        echo '</div>';

                                                    }*/

													?>

                                                </div>





											</fieldset>

										</form>

									</div> -->









									<!-- ====================== login screen config ============================ -->

									<div <?php if (isset($tab15)) { ?>class="tab-pane in active" <?php } else { ?> class="tab-pane " <?php } ?> id="live_cam3">





										<div id="loc_thm_response"></div>

										<h3>Login Screen Image </h3>

										<p>Max Size (160 x 30 px)</p>

										<div>



											<?php

											if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {

												$url = '?type=login_screen&id=ADMIN&user_type=' . $user_type;
											}

											?>

											<form onkeyup="imageform23fn();" onchange="imageform23fn();" id="imageform23" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

												<label class="btn btn-primary">
													Browse Image
													<span><input type="file" name="photoimg23" id="photoimg23" /></span></label>

											</form>


											<?php



											if ($user_type == 'ADMIN' || $user_type == 'RESELLER_ADMIN') {

												$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_LOGO'";
											}


											//$query_results=mysql_query($key_query);
											$query_results = $db->selectDB($key_query);

											//while($row=mysql_fetch_array($query_results)){
											foreach ($query_results['data'] as $row) {

												$logo2 = $row[settings_value];
											}



											?>


											<div id='img_preview23'>

												<?php

												if (strlen($logo2)) { ?>

													<img style="background-color:#ddd;width: 100%; max-width: 200px;" src="image_upload/welcome/<?php echo $logo2; ?>" border="0" />

												<?php } else {

													echo 'No Images';
												} ?>

											</div>

										</div>

										<br><br>



										<form onkeyup="imageform23fn();" onchange="imageform23fn();" id="edit-profile">

											<?php

											echo '<input type="hidden" name="distributor_code" id="distributor_code" value="' . $user_distributor . '" />';

											echo '<input type="hidden" name="user_type" id="user_type" value="' . $user_type . '" />';

											echo '<input type="hidden" name="header_logo_img23" id="header_logo_img23" value="' . $logo2 . '" />';

											?>



											<fieldset>

												<?php



												$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'";

												//$key_result = mysql_query($key_query);
												$key_result = $db->selectDB($key_query);

												//while($row=mysql_fetch_array($key_result)){
												foreach ($key_result['data'] as $row) {

													$login_color = $row[settings_value];
												}




												if ($package_functions->getAdminPackage() != 'COX_ADMIN_001') {
												?>



													<div class="control-group">

														<label class="control-label" for="radiobtns">Login Accent Color</label>

														<div class="controls">

															<div class="input-prepend input-append">

																<input class="span6 jscolor {hash:true}" id="header_color_log" name="header_color_log" type="color" value="<?php echo strlen($login_color) < 7 ? '#ffffff' : $login_color ?>" required>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



												<?php
												} else {
												?>
													<input class="span6 jscolor {hash:true}" id="header_color_log" name="header_color_log" type="hidden" value="<?php echo strlen($login_color) < 7 ? '#ffffff' : $login_color ?>" required>


												<?php
												}
												?>






												<div class="form-actions">

													<button disabled type="button" id="login_screen_config" name="submit" class="btn btn-primary">Save</button>

													<img id="loc_thm_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>


												<script>
													function imageform23fn() {

														$("#login_screen_config").prop('disabled', false);
													}
												</script>

												<!-- /form-actions -->

											</fieldset>

										</form>

									</div>




									<!-- ======================= live_camp =============================== -->

									<div <?php if (isset($tab15)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="footer_config">





										<div id="system_response"></div>

										<form id="edit-profile" class="form-horizontal">

											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

											?>



											<fieldset>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Site Title</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="main_title" name="main_title" type="text" value="<?php echo $db->setVal("site_title", $user_distributor); ?>">

														</div>

													</div>

												</div>


												<div class="control-group">

													<label class="control-label" for="radiobtns">Admin Email</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="master_email" name="master_email" type="text" value="<?php echo $db->setVal("email", $user_distributor); ?>" required>

														</div>

													</div>

												</div>


												<div class="control-group">

													<label class="control-label" for="radiobtns">Ex Portal base URL</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="base_url" name="base_url" type="text" value="<?php echo $db->setVal("portal_base_url", $user_distributor); ?>" required>
															<br>
															<font size="1">Ex: http://10.1.1.1/Ex-portal</font>

														</div>

													</div>

												</div>


												<div class="control-group">

													<label class="control-label" for="radiobtns">Campaign Portal Internal URL</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="camp_url" name="camp_url" type="text" value="<?php echo $db->setVal("camp_base_url", $user_distributor); ?>" required>
															<br>
															<font size="1">Ex: http://10.1.1.1/campaign_portal</font>

														</div>

													</div>

												</div>


												<div class="form-actions">

													<button type="button" onclick="getInfoBox('system','system_response');" name="submit" class="btn btn-primary">Save</button>

													<img id="system_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

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

	<?php } ?>

	<!-- /main -->


	<?php

	include 'footer.php';

	?>


	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {

			$("#product_code").chained("#category");

			$("#portal_submit").easyconfirm({
				locale: {
					title: 'Admin Portal',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#portal_submit").click(function() {

			});

			$("#submit_toc_btn").easyconfirm({
				locale: {
					title: 'Guest T&C',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#submit_toc_btn").click(function() {

			});

			$("#submit_arg1").easyconfirm({
				locale: {
					title: 'Activation T&C',
					text: 'Are you sure you want to update the terms and conditions?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#purge_now").easyconfirm({
				locale: {
					title: 'Purge log settings',
					text: 'Are you sure you, want to change the settings?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#purge_now").click(function() {});
			$("#submit_arg1").click(function() {

			});

			$("#active_email_submit").easyconfirm({
				locale: {
					title: 'Activation Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#active_email_submit").click(function() {
				//getInfoBox('email','email_response');
			});

			$("#active_sup_email_submit").easyconfirm({
				locale: {
					title: 'Activation Email (Support)',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});

			$("#new_location_activated_sub").easyconfirm({
				locale: {
					title: 'New Location Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});


			$("#email_activated_sub").easyconfirm({
				locale: {
					title: 'Activation Confirmation Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});

			$("#active_user_email_submit").easyconfirm({
				locale: {
					title: 'User Activation Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});

			$("#active_property_submit").easyconfirm({
				locale: {
					title: 'Property Admin Activation',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});

			$("#active_sup_email_submit").click(function() {
				//getInfoBox('email','email_response');
			});

			$("#email_subject_passcodei").easyconfirm({
				locale: {
					title: 'Passcode Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#email_subject_passcodei").click(function() {
				//getInfoBox('email','email_response');
			});

			$("#email_pass_reset").easyconfirm({
				locale: {
					title: 'Password Reset Email',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#email_pass_reset").click(function() {
				//getInfoBox('email','email_response');
			});


			$("#system_info").easyconfirm({
				locale: {
					title: 'General Config',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#system_info").click(function() {

			});

			$("#login_screen_config").easyconfirm({
				locale: {
					title: 'Login Screen Config',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#login_screen_config").click(function() {
				getInfoBoxLogin('loc_thm', 'loc_thm_response');
			});

			$("#activation_admin1").easyconfirm({
				locale: {
					title: 'Activation T & C',
					text: 'Are you sure you want to update this information?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#activation_admin1").click(function() {

			});

			$("#faq_submit").easyconfirm({
				locale: {
					title: 'Submit FAQ ',
					text: 'Are you sure you want to save this FAQ?',
					button: ['Cancel', ' Confirm'],
					closeText: 'close'
				}
			});
			$("#faq_submit").click(function() {

			});
			<?php if ($edit_faq == '1') { ?>
				$("#faq_update").easyconfirm({
					locale: {
						title: 'Submit FAQ ',
						text: 'Are you sure you want to update this FAQ?',
						button: ['Cancel', ' Confirm'],
						closeText: 'close'
					}
				});
				$("#faq_update").click(function() {

				});
			<?php } ?>
		});
	</script>



	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

	<script type="text/javascript" id="tinymce_editors">
		tinymce.init({

			selector: "textarea.blacklist_email_submit_tarea",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					blacklist_email_submitfn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.active_user_email_submit_tarea",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					active_user_email_submitfn();
				});
			}


		});
		/////////////////
		tinymce.init({

			selector: "#email-4",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					active_property_submitfn();
				});
			}


		});

		tinymce.init({

			selector: "#email-6",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					new_venue_activated_emailfn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.activation_adminta",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					activation_admin1fn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.submit_tocta",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					submit_tocfn();
				});
			}

		});

		tinymce.init({

			selector: "textarea.submit_vttocta",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					vt_submit_tocfn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.submit_arg1ta",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					submit_arg1fn();
				});
			}

		});


		tinymce.init({

			selector: "#email-9",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					password_reset_emailfn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.email_tech",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					tech_emailfn();
				});
			}

		});


		tinymce.init({

			selector: "textarea.email_hardware",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					hardware_emailfn();
				});
			}

		});


		tinymce.init({

			selector: "#email-5",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					venue_activated_emailfn();
				});
			}

		});


		tinymce.init({

			selector: "#email-7",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					email_subject_passcodeifn();
				});
			}

		});


		tinymce.init({

			selector: "#email-1",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					active_email_submitfn();
				});
			}

		});


		tinymce.init({

			selector: "#email-2",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					peer_active_email_submitfn();
				});
			}

		});


		tinymce.init({

			selector: "#email-3",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					pending_active_email_submitfn();
				});
			}

		});

		tinymce.init({

			selector: "textarea.active_sup_email_submit_tarea",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					active_sup_email_submitfn();
				});
			}

		});




		tinymce.init({

			selector: "#email-10",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats",


			init_instance_callback: function(editor) {
				editor.on('change', function(e) {
					vt_noytification_emailfn();
				});
			}

		});
	</script>





	<script type="text/javascript">
		tinymce.init({

			selector: "textarea.jqte-test",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 250,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],



			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats"

		});
	</script>

	<script type="text/javascript">
		tinymce.init({

			selector: "textarea.jqte-test-m",

			theme: "modern",

			removed_menuitems: 'visualaid',

			height: 20,

			plugins: [

				"lists charmap",

				"searchreplace wordcount code nonbreaking",

				"contextmenu directionality paste textcolor"

			],


			toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

			fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

			font_formats: "Andale Mono=andale mono,times;" +

				"Arial=arial,helvetica,sans-serif;" +

				"Arial Black=arial black,avant garde;" +

				"Book Antiqua=book antiqua,palatino;" +

				"Comic Sans MS=comic sans ms,sans-serif;" +

				"Courier New=courier new,courier;" +

				"Georgia=georgia,palatino;" +

				"Helvetica=helvetica;" +

				"Impact=impact,chicago;" +

				"Symbol=symbol;" +

				"Tahoma=tahoma,arial,helvetica,sans-serif;" +

				"Terminal=terminal,monaco;" +

				"Times New Roman=times new roman,times;" +

				"Trebuchet MS=trebuchet ms,geneva;" +

				"Verdana=verdana,geneva;" +

				"Webdings=webdings;" +

				"Wingdings=wingdings,zapf dingbats"

		});
	</script>


	<script type="text/javascript">
		//Initialize tinymces using function

		function initTinymces() {

			tinymce.init({

				selector: "textarea.blacklist_email_submit_tarea",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						blacklist_email_submitfn();
					});
				}

			});
			tinymce.init({

				selector: "textarea.active_user_email_submit_tarea",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						active_user_email_submitfn();
					});
				}


			});

			tinymce.init({

				selector: "#email-4",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						active_property_submitfn();
					});
				}


			});

			tinymce.init({

				selector: "#email-6",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						new_venue_activated_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.activation_adminta",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						activation_admin1fn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.submit_vttocta",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						vt_submit_tocfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.submit_arg1ta",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						submit_arg1fn();
					});
				}

			});

			tinymce.init({

				selector: "#email-9",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						password_reset_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.email_tech",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						tech_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.email_hardware",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						hardware_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "#email-5",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						venue_activated_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "#email-7",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						email_subject_passcodeifn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.active_email_submit_tarea",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						active_email_submitfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.active_sup_email_submit_tarea",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						active_sup_email_submitfn();
					});
				}

			});

			tinymce.init({

				selector: "#email-10",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats",


				init_instance_callback: function(editor) {
					editor.on('change', function(e) {
						vt_noytification_emailfn();
					});
				}

			});

			tinymce.init({

				selector: "textarea.jqte-test",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 250,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],



				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats"

			});

			tinymce.init({

				selector: "textarea.jqte-test-m",

				theme: "modern",

				removed_menuitems: 'visualaid',

				height: 20,

				plugins: [

					"lists charmap",

					"searchreplace wordcount code nonbreaking",

					"contextmenu directionality paste textcolor"

				],


				toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

				fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

				font_formats: "Andale Mono=andale mono,times;" +

					"Arial=arial,helvetica,sans-serif;" +

					"Arial Black=arial black,avant garde;" +

					"Book Antiqua=book antiqua,palatino;" +

					"Comic Sans MS=comic sans ms,sans-serif;" +

					"Courier New=courier new,courier;" +

					"Georgia=georgia,palatino;" +

					"Helvetica=helvetica;" +

					"Impact=impact,chicago;" +

					"Symbol=symbol;" +

					"Tahoma=tahoma,arial,helvetica,sans-serif;" +

					"Terminal=terminal,monaco;" +

					"Times New Roman=times new roman,times;" +

					"Trebuchet MS=trebuchet ms,geneva;" +

					"Verdana=verdana,geneva;" +

					"Webdings=webdings;" +

					"Wingdings=wingdings,zapf dingbats"

			});
		}
	</script>



	<!-- on-off switch js -->







	<script src="js/bootstrap-toggle.min.js"></script>





	<script type="text/javascript">
		var xmlHttp3;

		function getInfoBox(type, response) {



			//alert('OK');

			xmlHttp3 = GetXmlHttpObject();

			if (xmlHttp3 == null)

			{



				alert("Browser does not support HTTP Request");

				return;

			}


			var loader = type + "_loader";

			document.getElementById(loader).style.visibility = 'visible';

			var url = "ajax/updateConfig.php";


			url = url + "?type=" + type;
			//alert(type);


			switch (type) {

				case 'system':



					var base_url = document.getElementById("base_url").value;

					var noc_email = document.getElementById("noc_email").value;

					var camp_url = document.getElementById("camp_url").value;

					var captive_portal_url = '';

					var menu_type = document.getElementById("menu_type").value;

					var main_title = document.getElementById("main_title").value;

					var master_email = document.getElementById("master_email").value;

					var ssl_on = document.getElementById("ssl_on").value;

					var global_url = document.getElementById("global_url").value;

					var tenant_url = document.getElementById("tenant_url").value;

					var tenant_internal_url = document.getElementById("tenant_internal_url").value;

					var header_color = document.getElementById("header_color").value;

					var style_type = document.getElementById("style_type").value;

					var light_color = document.getElementById("light_color").value;

					var flatform = document.getElementById("platform").value;

					var time_zone = document.getElementById("time_zone").value;

					var login_title = document.getElementById("login_title").value;
					var header_logo_img5 = document.getElementById("header_logo_img5").value;

					var gRecapture_key = document.getElementById("g-reCAPTCHA").value;
					var gRecapture_site_key = document.getElementById("g-reCAPTCHA-site-key").value;
					var dbr_key = document.getElementById("dbr_key").value;
					var tech_barcode_reader_status = document.getElementById("tech_barcode_reader_status").value;
					var captive_theme_up_tmp = document.getElementById("captive_theme_up_tmp").value;




					var va = $('#top_che').is(':checked');

					if (va) {

						var top_line_color = document.getElementById("top_line_color").value;

					} else {

						var top_line_color = "";

					}

					var login_profile_array = {};
					$(".login_profiles").each(function() {
						if (this.checked) {
							login_profile_array[$(this).val()] = '1';
						} else {
							login_profile_array[$(this).val()] = '0';
						}
					});


					var login_profile_JsonString = JSON.stringify(login_profile_array);

					url = url +
						"&noc_email=" + encodeURIComponent(noc_email) +
						"&login_profile=" + encodeURIComponent(login_profile_JsonString) +
						"&header_logo_img5=" + encodeURIComponent(header_logo_img5) +
						"&global_url=" + encodeURIComponent(global_url) +
						"&tenant_url=" + encodeURIComponent(tenant_url) +
						"&tenant_internal_url=" + encodeURIComponent(tenant_internal_url) +
						"&login_title=" + encodeURIComponent(login_title) +
						"&menu_type=" + encodeURIComponent(menu_type) +
						"&header_color=" + encodeURIComponent(header_color) +
						"&captive_portal_url=" + encodeURIComponent(captive_portal_url) +
						"&base_url=" + encodeURIComponent(base_url) +
						"&camp_url=" + encodeURIComponent(camp_url) +
						"&main_title=" + encodeURIComponent(main_title) +
						"&master_email=" + encodeURIComponent(master_email) +
						"&style_type=" + encodeURIComponent(style_type) +
						"&light_color=" + encodeURIComponent(light_color) +
						"&top_line_color=" + encodeURIComponent(top_line_color) +
						"&ssl_on=" + ssl_on + "&flatform=" + encodeURIComponent(flatform) +
						"&time_zone=" + encodeURIComponent(time_zone) +
						"&g-recap-key=" + encodeURIComponent(gRecapture_key) +
						"&g-recap-site=" + encodeURIComponent(gRecapture_site_key) +
						"&captive_theme_up_tmp=" + encodeURIComponent(captive_theme_up_tmp) +
						"&dbr_key=" + encodeURIComponent(dbr_key) +
						"&tech_barcode_reader_status=" + encodeURIComponent(tech_barcode_reader_status);

					break;



				case 'system1':



					var noc_email1 = document.getElementById("noc_email1").value;

					var main_title1 = document.getElementById("main_title1").value;

					var short_title1 = document.getElementById("short_title1").value;

					var master_email1 = document.getElementById("master_email1").value;

					var mno_header_color = document.getElementById("mno_header_color").value;

					var style_type = document.getElementById("style_type1").value;

					var light_color = document.getElementById("light_color1").value;

					var header_logo_img = document.getElementById("header_logo_img").value;

					try {
						var tech_aps = document.getElementById("tech_aps").value;
					} catch (err) {}

					try {
						var tech_switch = document.getElementById("tech_switch").value;
					} catch (err) {}

					var va = $('#top_che1').is(':checked');

					if (va) {

						var top_line_color = document.getElementById("top_line_color1").value;

					} else {

						var top_line_color = "";

					}


					<?php if ($user_type != 'SALES') {


					?>
						url = url +
							"&noc_email1=" + encodeURIComponent(noc_email1) +
							"&header_logo_img=" + encodeURIComponent(header_logo_img) +
							"&mno_header_color=" + encodeURIComponent(mno_header_color) +
							"&main_title=" + encodeURIComponent(main_title1) +
							"&short_title=" + encodeURIComponent(short_title1) +
							"&master_email=" + encodeURIComponent(master_email1) +
							"&dist=" + encodeURIComponent('<?php echo $user_distributor; ?>') +
							"&user_type=" + encodeURIComponent('<?php echo $user_type; ?>') +
							"&style_type=" + encodeURIComponent(style_type) +
							"&light_color=" + encodeURIComponent(light_color) +
							"&tech_aps=" + encodeURIComponent(tech_aps) +
							"&tech_switch=" + encodeURIComponent(tech_switch) +
							"&top_line_color=" + encodeURIComponent(top_line_color);
					<?php
						//$db->userLog($user_name,$script,'Update Portal Configuration','N/A');
					} else {
						//$_SESSION['system1_1msg']='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';

					}

					?>
					break;



				case 'loc':



					var site_title = document.getElementById("site_title0").value;

					var php_time_zone = document.getElementById("php_time_zone0").value;

					var portal_lang = document.getElementById("language0").value;

					var distributor_code = document.getElementById("distributor_code0").value;

					var header_color = document.getElementById("header_color0").value;



					var style_type = document.getElementById("style_type0").value;

					var light_color = document.getElementById("light_color0").value;



					var va = $('#top_che0').is(':checked');

					if (va) {

						var top_line_color = document.getElementById("top_line_color0").value;

					} else {

						var top_line_color = "";

					}



					url = url + "&header_color=" + encodeURIComponent(header_color) + "&distributor_code=" + encodeURIComponent(distributor_code) + "&title=" + encodeURIComponent(site_title) + "&php_time_zone=" + encodeURIComponent(php_time_zone) + "&portal_language=" + encodeURIComponent(portal_lang) + "&style_type=" + encodeURIComponent(style_type) + "&light_color=" + encodeURIComponent(light_color) + "&top_line_color=" + encodeURIComponent(top_line_color);

					//console.log(url);

					break;



				case 'network':

					var network_name = document.getElementById("network_name").value;



					url = url + "&network_name=" + encodeURIComponent(network_name);

					break;



				case 'caphaign':

					var default_ad_waiting = document.getElementById("default_ad_waiting").value;

					var default_ad_welcome = document.getElementById("default_ad_welcome").value;



					url = url + "&default_ad_waiting=" + encodeURIComponent(default_ad_waiting) + "&default_ad_welcome=" + encodeURIComponent(default_ad_welcome) + "&dist=" + encodeURIComponent('<?php echo $user_distributor; ?>');

					break;



				case 'toc':



					var toc1 = document.getElementById("toc1").value;



					url = url + "&toc=" + encodeURIComponent(toc1) + "&dist=" + encodeURIComponent('<?php echo $user_distributor; ?>');

					break;



				case 'aup':



					var aup = document.getElementById("aup1").value;



					url = url + "&aup=" + encodeURIComponent(aup) + "&dist=" + encodeURIComponent('<?php echo $user_distributor; ?>');

					break;



				case 'email':

					/* var email1= document.getElementById("email1").value; */
					var email1 = $('#email1_ifr').contents().find('#tinymce').html();
					/* alert(email1); */

					url = url + "&email=" + encodeURIComponent(email1) + "&dist=" + encodeURIComponent('<?php echo $user_distributor; ?>');

					break;





				case 'fb':

					var fb_app_id = document.getElementById("fb_app_id").value;

					var fb_app_version = document.getElementById("fb_app_version").value;

					var app_cookie = document.getElementById("app_cookie").value;

					var app_xfbml = document.getElementById("app_xfbml").value;

					var distributor = document.getElementById("distributor").value;

					var social_profile = document.getElementById("social_profile").value;





					var fb_additional_fields = '';

					var fb_fields = document.edit_profile.fb_fields;



					for (var i = 0; i < fb_fields.length; i++) {

						if (fb_fields[i].checked == true) {



							fb_additional_fields += fb_fields[i].value + ',';

						};

					}

					//console.log(fb_additional_fields);

					url = url + "&fb_app_id=" + encodeURIComponent(fb_app_id) + "&fb_app_version=" + encodeURIComponent(fb_app_version) + "&app_xfbml=" + encodeURIComponent(app_xfbml) + "&app_cookie=" + encodeURIComponent(app_cookie) + "&distributor=" + encodeURIComponent(distributor) + "&social_profile=" + encodeURIComponent(social_profile) + "&fb_additional_fields=" + encodeURIComponent(fb_additional_fields);

					break;



				case 'manual':

					var first_name = document.getElementById("m_first_name").checked;

					var last_name = document.getElementById("m_last_name").checked;

					var email = document.getElementById("m_email").checked;

					var age_group = document.getElementById("m_age_group").checked;

					var gender = document.getElementById("m_gender").checked;

					var mobile = document.getElementById("m_mobile_num").checked;

					//var social_profile = document.getElementById("social_profile").value;

					var distributor = document.getElementById("distributor").value;

					var manual_profile = document.getElementById("manual_profile").value;

					//console.log(last_name);

					url = url + "&first_name=" + encodeURIComponent(first_name) + "&last_name=" + encodeURIComponent(last_name) + "&email=" + encodeURIComponent(email) + "&age_group=" + encodeURIComponent(age_group) + "&distributor=" + encodeURIComponent(distributor) + "&gender=" + encodeURIComponent(gender) + "&manual_profile=" + encodeURIComponent(manual_profile) + "&mobile_number=" + encodeURIComponent(mobile);

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















	<script type="text/javascript">
		var xmlHttp5 = null;
		var xmlHttp6 = null;

		function editNetPro() {

			var network_profile = $("#network_edit").val(); //console.log(network_profile);
			xmlHttp5 = GetXmlHttpObject();
			if (xmlHttp5 == null)

			{
				alert("Browser does not support HTTP Request");
				return;
			}

			document.getElementById('network_edit_loader').style.visibility = 'visible';
			var url = "ajax/updateConfigNetEdit.php";
			url = url + "?network_profile=" + network_profile;
			xmlHttp5.onreadystatechange = stateChanged;
			xmlHttp5.open("GET", url, true);
			xmlHttp5.send(null);

			function stateChanged() {
				if (xmlHttp5.readyState == 4 || xmlHttp5.readyState == "complete") {
					document.getElementById('editable').innerHTML = xmlHttp5.responseText;
					document.getElementById('save_as_net_pro').value = network_profile;
					document.getElementById('network_edit_loader').style.visibility = 'hidden';
					document.getElementById("network_edit").disabled = true;
					document.getElementById("cancel").style.visibility = "visible";
					document.getElementById("edit").style.visibility = "hidden";
				}
			}
		}















		function cancelNetPro() {

			//console.log('dfsf');

			document.getElementById('network_save_loader').style.visibility = 'visible';

			document.getElementById("cancel").style.visibility = "hidden";

			document.getElementById("edit").style.visibility = "visible";

			document.getElementById("network_edit").disabled = false;

			document.getElementById('editable').innerHTML = "";

			document.getElementById('network_save_loader').style.visibility = 'hidden';

		}






		function activeSaveAs() {

			if (document.getElementById("save_as").checked) {

				document.getElementById("save_as_net_pro").disabled = false;

				document.getElementById("save_as_net_pro").focus();

			} else {

				document.getElementById("save_as_net_pro").disabled = true;

			};

		}
	</script>
	<script src="js/jquery.multi-select.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#default_product').multiSelect({
				cssClass: "mini"
			});
		});
	</script>


	<script type="text/javascript" src="js/formValidation.js"></script>
	<script type="text/javascript" src="js/bootstrap_form.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			//duration from
			$('#create_duration_form').formValidation({
				framework: 'bootstrap',
				excluded: ':disabled',
				fields: {
					duration_product_name: {
						validators: {
							<?php echo $db->validateField('special_character'); ?>
						}
					},
					product_du_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					duration: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}

				}
			}).on('change', function(e) {

				if ($('#du_select1').val() == '0' && $('#du_select3').val() == '0' && $('#du_select5').val() == '0') {

					$('#duration').val('');
				} else {
					$('#duration').val('set');
				}

				$('#create_duration_form').formValidation('revalidateField', 'duration');

			});

			$('#create_product_form').formValidation({
				framework: 'bootstrap',
				fields: {
					description: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					description_up: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					product_name: {
						validators: {
							<?php echo $db->validateField('special_character'); ?>
						}
					},
					Purge_delay_time: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					Purge_delay_time: {
						validators: {
							<?php echo $db->validateField('number'); ?>
						}
					},

					dob1: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}
				}
			}).on('change', 'input[name="description"], input[name="description_up"]', function(e) {
				var from = $('#create_product_form').find('[name="description"]').val(),
					to = $('#create_product_form').find('[name="description_up"]').val();

				// Set the dob field value
				$('#create_product_form').find('[name="dob1"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#create_product_form').formValidation('revalidateField', 'dob1');
			});

			$('#create_product_submit').on('click', function(e) {
				var from = $('#create_product_form').find('[name="description"]').val(),
					to = $('#create_product_form').find('[name="description_up"]').val();

				// Set the dob field value
				$('#create_product_form').find('[name="dob1"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#create_product_form').formValidation('revalidateField', 'dob1');
				$('#create_product_form').formValidation('revalidateField', 'product_name');
			});

			$('#default_product_submit').on('click', function(e) {


			});


			$('#create_guest_form').formValidation({
				framework: 'bootstrap',
				fields: {

					product_name: {
						validators: {
							<?php echo $db->validateField('special_character'); ?>
						}
					},
					dob2: {
						excluded: false,
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					Purge_delay_time: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					max_sessions_alert: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}

				}
			}).on('change', 'input[name="description1"], input[name="description1_up"]', function(e) {
				var from = $('#create_guest_form').find('[name="description1"]').val(),
					to = $('#create_guest_form').find('[name="description1_up"]').val();

				// Set the dob field value
				$('#create_guest_form').find('[name="dob2"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#create_guest_form').formValidation('revalidateField', 'dob2');
			});

			$('#create_product_submit_guest').on('click', function(e) {
				var from = $('#create_guest_form').find('[name="description1"]').val(),
					to = $('#create_guest_form').find('[name="description1_up"]').val();

				// Set the dob field value
				$('#create_guest_form').find('[name="dob2"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

				// Revalidate it
				$('#create_guest_form').formValidation('revalidateField', 'dob2');
				$('#create_guest_form').formValidation('revalidateField', 'product_name');
				$('#create_guest_form').formValidation('revalidateField', 'max_sessions_alert');
			});

			$('#edit_profile_a').formValidation({
				framework: 'bootstrap',
				button: {
					selector: '#portal_submit',
					disabled: 'disabled'
				},
				fields: {

					short_title1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					main_title1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					master_email1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('email'); 
							?>
							<?php //echo $db->validateField('master_email1'); 
							?>
						}
					},
					noc_email1: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					tech_aps: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					tech_switch: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					}

				}

			}).on('success.form.fv', function(e) {
				e.preventDefault();
				getInfoBox('system1', 'system1_response');
			});

			$('#edit_profile_b').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							/*<?php // echo $db->validateField('not_require_special_character'); 
								?>*/
						}
					}

				}
			});


			$('#active_email_submitfn').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#peer_active_email_submitfn').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#qos-profile_submit').formValidation({
				framework: 'bootstrap',
				fields: {

					qos_profile: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					},
					qos_category: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					},
					qos_description: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});


			$('#pending_active_email_submitfn').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php // echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});

			$('#active_sup_email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject_sup_main: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#venue_activated_email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#new_venue_activated_email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#passcode_email_form').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#tech_activation__email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#hardware_info_email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});
			$('#password_reset_email').formValidation({
				framework: 'bootstrap',
				fields: {

					email_subject: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>,
							<?php //echo $db->validateField('not_require_special_character'); 
							?>
						}
					}

				}
			});

			$('#active_property_submitfn').formValidation({
				framework: 'bootstrap',
				fields: {

					propertyName: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					headerImg: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					<?php
					if ($opt) {
						foreach ($opt as $key => $value) {
					?>
							sup_num_<?php echo $key; ?>: {
								validators: {
									<?php echo $db->validateField('mobile_new'); ?>
								}
							},
					<?php
						}
					}
					?>
				}
			});








			$('#edit_profile_c').formValidation({
				framework: 'bootstrap',
				button: {
					selector: '#system_info',
					disabled: 'disabled'
				},
				fields: {

					base_url: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					menu_type: {
						validators: {
							<?php echo $db->validateField('notEmpty'); ?>
						}
					},
					camp_url: {
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
	</script>



	<script type="text/javascript">
		/* 
 $(document).ready(function() {

            $('#photoimg').on('change', function(){

			           $("#preview").html('');

			    $("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');

			$("#imageform").ajaxForm({

						target: '#preview'

		}).submit();

			});

        }); */
	</script>





	<script type="text/javascript">
		function GetXmlHttpObject()

		{

			var xmlHttp = null;

			try

			{

				// Firefox, Opera 8.0+, Safari

				xmlHttp = new XMLHttpRequest();

			} catch (e)

			{

				//Internet Explorer

				try

				{

					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");

				} catch (e)

				{
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

				}

			}

			return xmlHttp;

		}
	</script>



	<script type="text/javascript" src="js/jquery.form.js"></script>


	<script type="text/javascript">
		$(document).ready(function() {

			$('#photoimg5').on('change', function() {

				$("#img_preview5").html('');

				$("#img_preview5").html('<img src="img/loader.gif" alt="Uploading...."/>');

				$("#imageform5").ajaxForm({

					//target: '#img_preview5'

					success: function(response) {
						// this happens after the ajax request
						var res_array = response.split(',');
						$('#img_preview5').html(res_array[0]);
						$('#header_logo_img5').val(res_array[1]);
					}

				}).submit();

			});

		});
	</script>









	<script type="text/javascript">
		$(document).ready(function() {

			$('#photoimg').on('change', function() {

				//$("#img_preview").html('');

				$("#img_preview").html('<img src="img/loader.gif" alt="Uploading...."/>');

				$("#imageform").ajaxForm({
					//target: '#img_preview'
					success: function(response) {
						// this happens after the ajax request
						var res_array = response.split(',');
						$('#img_preview').html(res_array[0]);
						$('#header_logo_img').val(res_array[1]);
					}

				}).submit();

			});

		});
	</script>




	<script type="text/javascript">
		$(document).ready(function() {

			$('#photoimg2').on('change', function() {

				$("#img_preview2").html('');

				$("#img_preview2").html('<img src="img/loader.gif" alt="Uploading...."/>');

				$("#imageform2").ajaxForm({

					target: '#img_preview2'

				}).submit();

			});

		});
	</script>


	<script type="text/javascript">
		$(document).ready(function() {

			$("#cancel").on('change', function() {



				$("#editable").html("");

			});

		});
	</script>

	<script>
		function setTimeGapEditDis() {

			mg_dis_num1_1 = document.getElementById("mg_dis_num1_1").value;

			mg_dis_num2_2 = document.getElementById("mg_dis_num2_2").value;

			mg_dis_select1_1 = document.getElementById("mg_dis_select1_1").value;

			mg_dis_select2_2 = document.getElementById("mg_dis_select2_2").value;


			if (mg_dis_num1_1 != 0 && mg_dis_num2_2 != 0) {

				assign_timegap_edit = 'P' + mg_dis_num1_1 + mg_dis_select1_1 + 'T' + mg_dis_num2_2 + mg_dis_select2_2;

			} else if (mg_dis_num1_1 == 0 && mg_dis_num2_2 == 0) {

				assign_timegap_edit = '';

			} else if (mg_dis_num2_2 == 0) {

				assign_timegap_edit = 'P' + mg_dis_num1_1 + mg_dis_select1_1;

			} else if (mg_dis_num1_1 == 0) {

				assign_timegap_edit = 'PT' + mg_dis_num2_2 + mg_dis_select2_2;

			}

			document.getElementById("temp_account_timegap").value = assign_timegap_edit;

		}


		function setTimeGapEditDis12() {

			mg_dis_num1_12 = document.getElementById("mg_dis_num1_12").value;

			mg_dis_num2_22 = document.getElementById("mg_dis_num2_22").value;

			mg_dis_select1_12 = document.getElementById("mg_dis_select1_12").value;

			mg_dis_select2_22 = document.getElementById("mg_dis_select2_22").value;


			if (mg_dis_num1_12 != 0 && mg_dis_num2_22 != 0) {

				assign_timegap_edit2 = 'P' + mg_dis_num1_12 + mg_dis_select1_12 + 'T' + mg_dis_num2_22 + mg_dis_select2_22;

			} else if (mg_dis_num1_12 == 0 && mg_dis_num2_22 == 0) {

				assign_timegap_edit22 = '';

			} else if (mg_dis_num2_22 == 0) {

				assign_timegap_edit22 = 'P' + mg_dis_num1_12 + mg_dis_select1_12;

			} else if (mg_dis_num1_12 == 0) {

				assign_timegap_edit2 = 'PT' + mg_dis_num2_22 + mg_dis_select2_22;

			}



			document.getElementById("api_mater_timegap").value = assign_timegap_edit2;

			//console.log(assign_timegap_edit);

		}



		function setTimeGapEditDis123() {

			mg_dis_num1_123 = document.getElementById("mg_dis_num1_123").value;

			mg_dis_num2_223 = document.getElementById("mg_dis_num2_223").value;

			mg_dis_select1_123 = document.getElementById("mg_dis_select1_123").value;

			mg_dis_select2_223 = document.getElementById("mg_dis_select2_223").value;



			//console.log(num1+'/'+num2+'/'+select1+'/'+select2+'/')

			if (mg_dis_num1_123 != 0 && mg_dis_num2_223 != 0) {

				assign_timegap_edit23 = 'P' + mg_dis_num1_123 + mg_dis_select1_123 + 'T' + mg_dis_num2_223 + mg_dis_select2_223;

			} else if (mg_dis_num1_123 == 0 && mg_dis_num2_223 == 0) {

				assign_timegap_edit223 = '';

			} else if (mg_dis_num2_223 == 0) {

				assign_timegap_edit223 = 'P' + mg_dis_num1_123 + mg_dis_select1_123;

			} else if (mg_dis_num1_123 == 0) {

				assign_timegap_edit23 = 'PT' + mg_dis_num2_223 + mg_dis_select2_223;

			}



			document.getElementById("api_sub_timegap").value = assign_timegap_edit23;

			//console.log(assign_timegap_edit);

		}
	</script>



	<script>
		$(document).ready(function() {

			$('#photoimg23').on('change', function() {

				$("#img_preview23").html('');

				$("#img_preview23").html('<img src="img/loader.gif" alt="Uploading...."/>');

				$("#imageform23").ajaxForm({

					//target: '#img_preview23'
					success: function(response) {
						// this happens after the ajax request
						var res_array = response.split(',');
						$('#img_preview23').html(res_array[0]);
						$('#header_logo_img23').val(res_array[1]);
					}

				}).submit();

			});

		});





		var xmlHttp4;

		function getInfoBoxLogin(type, response) {



			//alert('OK');

			xmlHttp4 = GetXmlHttpObject();

			if (xmlHttp4 == null)

			{



				alert("Browser does not support HTTP Request");

				return;

			}


			var loader = type + "_loader";

			document.getElementById(loader).style.visibility = 'visible';

			var url = "ajax/updateConfig.php";

			url = url + "?type=" + type;

			var header_color = document.getElementById("header_color_log").value;

			var header_logo_img23 = document.getElementById("header_logo_img23").value;



			url = url + "&header_color=" + encodeURIComponent(header_color) + "&header_logo_img23=" + encodeURIComponent(header_logo_img23);
			console.log(url);
			xmlHttp4.onreadystatechange = stateChanged;
			xmlHttp4.open("GET", url, true);
			xmlHttp4.send(null);

			function stateChanged() {

				if (xmlHttp4.readyState == 4 || xmlHttp4.readyState == "complete") {
					document.getElementById(response).innerHTML = xmlHttp4.responseText;
					document.getElementById(loader).style.visibility = 'hidden';
				}
			}
		}
	</script>





	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
	<script src="js/jscolor.js"></script>

	<script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>

	<script type="text/javascript">
		$(document).ready(function() {

			$(".faq_content_fancy").fancybox({
				'transitionIn': 'elastic',
				'transitionOut': 'elastic',
				'speedIn': 600,
				'speedOut': 200,
				'overlayShow': false,
				'width': "50%",
				'height': "50%"
			});

			$('.fancy_close').click(function(event) {
				$.fancybox.close();
			});



			$("#business_type").on("change", function() {

				var bt = $("#business_type").val();

				if (bt == 'All') {
					$("#submit_toc_btn").prop('disabled', true);
				} else {
					$("#submit_toc_btn").prop('disabled', false);
				}
			});

		});
	</script>
	</body>

</html>