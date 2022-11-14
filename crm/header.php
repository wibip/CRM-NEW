<?php
//Log out Back
ob_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

$load_login_design = $_SESSION['logout_design'];
// echo '------>>>';die;
////////////////////////////

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
error_reporting(E_ALL);*/

////////////////////////////

$input = '../install';
$out = is_dir($input);
$file = 'g54Hpz.act';
$fileOut = file_exists($file);

if (!$fileOut || $out) {
	echo "<h2> This product is not activate or not correctly installed... </h2>";
	exit();
}

?>

<!-- <script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />-->
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

<!--[if gte IE 8]>
<style type="text/css">
	.mainnav > li:not(.no_arrow):not(.no_arrow1).active:after{
	 display: none !important
	}
</style>
<![endif]-->

<style>
	@media (max-width: 980px) {
		.navbar .nav.pull-right {
			margin-top: 0px !important;

		}
	}

	@media (max-width: 767px) {

		.input-prepend input[class*="span"],
		.input-append input[class*="span"] {
			width: 158px !important;
		}

		#passcode_submit {
			/*network.php*/
			width: 158px !important;
			padding-right: 8px !important;
			padding-left: 8px !important;
			margin-top: 10px;
		}


	}

	@media (max-width: 420px) {

		.input-prepend input[class*="span"],
		.input-append input[class*="span"] {
			width: 100% !important;
		}
	}

	@media (max-width: 420px) {

		input[class*="span"],
		select[class*="span"],
		textarea[class*="span"],
		/*network_pr.php*/
		meter[class*="span"],
		.uneditable-input {
			width: 100% !important;
		}

		.input-prepend {
			width: 100% !important;
		}

		.input-append {
			width: 100% !important;
		}

		#passcode_submit {
			/*network.php*/
			width: 100% !important;
		}
	}

	td>a {
		min-width: 70px;
	}

	@media screen and (max-width: 660px) and (min-width: 480px) {
		.multi_sele_parent {
			display: block !important;
		}

		.ms-container {
			width: 100% !important;
		}
	}

	@media (max-width: 455px) {
		.multi_sele_parent {
			display: block !important;
		}

		.ms-container {
			width: 100% !important;
		}
	}

	@media (min-width: 767px) {
		#passcode_submit {
			/*network.php*/
			margin-left: 10px;
		}
	}

	/*network_pr.php*/
	meter {
		display: block !important;
		width: 300px;
	}

	.topnav {
		list-style-type: none;
		margin: 0;
		padding: 0;
		overflow: hidden;
		text-transform: uppercase;
		/*background-color: #333;*/
	}

	.topnav > li {
		float: left;
	}

	.topnav > li a {
		display: block;
		/*color: white;*/
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}

	.topnav > li a:hover {
		/*background-color: #111;*/
	}
</style>

<?php
// GET PAGE SCRIPT
$script = basename($_SERVER['PHP_SELF'], ".php");
// classes
$db_class1 = new db_functions();
$extension = trim($db_class1->setVal('extentions', 'ADMIN'));
$global_base_url = trim($db_class1->setVal('global_url', 'ADMIN'), "/");
$camp_base_url = trim($db_class1->setVal('camp_base_url', 'ADMIN'), "/");

require_once 'classes/systemPackageClass.php';
require_once 'classes/appClass.php';
include_once 'classes/cryptojs-aes.php';
require_once 'classes/CommonFunctions.php';

$data_secret = $db_class1->setVal('data_secret', 'ADMIN');

$package_functions = new package_functions();
$app = new app_functions();

// TAB Organization
if (isset($_GET['t'])) {

	$variable_tab = 'tab' . $_GET['t'];
	$$variable_tab = 'set';
} else {
	//initially page loading///

	$tab1 = "set";
}


if ($_GET['s_token']) {

	$s_detail_encode = base64_encode($_SESSION['s_token'] . $_SESSION['s_detail']);

	if ($_GET['s_token'] == $s_detail_encode) {
	} else {

		session_destroy();
	}
}
$user_distributor = $db_class1->getValueAsf("SELECT  user_distributor AS f  FROM  admin_users WHERE user_name = '$s_uname' LIMIT 1");

if ($_GET['back_sup'] == 'true') {
	parse_str($_SESSION['s_detail']);
	//login from support user
	$_SESSION['user_name'] = $s_uname;
	$_SESSION['access_role'] = $s_arole;
	$_SESSION['full_name'] = $s_fname;


	unset($_SESSION['s_detail']);
	unset($_SESSION['s_token']);
	unset($_SESSION['full_name_old']);
	unset($_SESSION['remote']);
	unset($_SESSION['ori_user_uname']);

	unset($_SESSION['p_detail']);
	unset($_SESSION['p_token']);
	unset($_SESSION['wifi_text']);

	//$user_name = $_SESSION['user_name'];

	

	$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	$wifi_text = $package_functions->getMessageOptions('WIFI_TEXT', $system_package);
	$theme_text = $package_functions->getMessageOptions('THEME_TEXT', $system_package);

	if (empty($wifi_text) || $wifi_text == '') {
		$wifi_text = 'WiFi';
	}

	$_SESSION['wifi_text'] = $wifi_text;

	if (empty($theme_text) || $theme_text == '') {
		$theme_text = 'theme';
	}

	echo $_SESSION['theme_text'] = $theme_text;


	$db_class1->userLog($s_uname, $script, 'Back to Support', $s_uname);
	header("Location: support" . $extension);
	exit();
}

if ($_GET['back_sup_logout'] == 'true') {
	parse_str($_SESSION['s_detail']);
	//login from support user
	$_SESSION['user_name'] = $s_uname;
	$_SESSION['access_role'] = $s_arole;
	$_SESSION['full_name'] = $s_fname;

	$db_class1->userLog($user_name, $script, 'Support Logout', $s_uname);

	unset($_SESSION['s_detail']);
	unset($_SESSION['s_token']);
	unset($_SESSION['full_name_old']);
	unset($_SESSION['remote']);
	unset($_SESSION['ori_user_uname']);
	unset($_SESSION['p_detail']);
	unset($_SESSION['p_token']);

	$redirect_url = 'logout' . $extension . '?doLogout=true&product=' . $_COOKIE["system_package"] . '&login=' . $_COOKIE["load_login_design"];
	header("Location: " . $redirect_url);
	exit();
}

if ($_GET['back_master'] == 'true') {
	parse_str($_SESSION['p_detail']);
	//login from support user
	$_SESSION['user_name'] = $s_uname;
	$_SESSION['access_role'] = $s_arole;
	$_SESSION['full_name'] = $s_fname;
	$_SESSION['parent_to_location_auto_login'] = 'no';

	unset($_SESSION['p_detail']);
	unset($_SESSION['p_token']);
	unset($_SESSION['full_name_old']);
	if (!isset($_SESSION['s_token'])) {
		unset($_SESSION['remote']);
	}
	unset($_SESSION['ori_user_uname']);
	unset($_SESSION['wifi_text']);

	$db_class1->userLog($user_name, $script, 'Back to Properties', $s_uname);
	header("Location: properties" . $extension);
	exit();
}

if ($_GET['back_master_logout'] == 'true') {
	parse_str($_SESSION['p_detail']);
	//login from support user
	$_SESSION['user_name'] = $s_uname;
	$_SESSION['access_role'] = $s_arole;
	$_SESSION['full_name'] = $s_fname;
	$_SESSION['parent_to_location_auto_login'] = 'no';


	unset($_SESSION['p_detail']);
	unset($_SESSION['p_token']);
	unset($_SESSION['full_name_old']);
	unset($_SESSION['remote']);
	unset($_SESSION['ori_user_uname']);

	$db_class1->userLog($user_name, $script, 'Properties Logout', $s_uname);
	$redirect_url = 'logout' . $extension . '?doLogout=true&product=' . $_COOKIE["system_package"] . '&login=' . $_COOKIE["load_login_design"];
	header("Location: " . $redirect_url);
	exit();
}

if ($_GET['log_other'] == '1') {

	$secu_token = $_GET['security_token'];

	if ($secu_token == $_SESSION['security_token']) {
		$s_uname = $_SESSION['user_name'];
		$_SESSION['ori_user_uname'] = $s_uname;
		$s_arole = $_SESSION['access_role'];
		$s_fname = $_SESSION['full_name'];
		$_SESSION['full_name_old'] = $s_fname;

		$string_pass = $_GET['key'];
		$decrypt_text = $app->encrypt_decrypt('decrypt', $string_pass);
		parse_str($decrypt_text, $data_arr);
		$s_details = 's_uname=' . $s_uname . '&s_arole=' . $s_arole . '&s_fname=' . $s_fname;
		$_SESSION['s_token'] = md5(uniqid(rand(), true));
		$s_detail_encode = base64_encode($_SESSION['s_token'] . $s_details);
		$_SESSION['s_detail'] = $s_details;
		$_SESSION['remote'] = 'yes';

		//login from sub user
		$_SESSION['user_name'] = $data_arr[uname]; //$_GET['uname'];
		$_SESSION['access_role'] = $data_arr[urole]; //$_GET['urole'];
		$_SESSION['full_name'] = $data_arr[fname]; //$_GET['fname'];

		$user_name = $_SESSION['user_name'];
		$user_details = $db_class1->select1DB("SELECT  user_distributor ,user_type  FROM  admin_users WHERE user_name = '$user_name' LIMIT 1");
		$user_distributor = $user_details['user_distributor'];

		//Sync SSID,AP
		$exec_cmd = 'php -f' . __DIR__ . '/ajax/syncAP.php ' . $user_distributor . ' > /dev/null &';
		exec($exec_cmd);
		
		if ($user_details['user_type'] == 'MVNO_ADMIN') {

			$realm_query = "SELECT `system_package`,parent_id AS verification_number  FROM mno_distributor_parent WHERE `parent_id`='$user_distributor'";
		} else {
			$realm_query = "SELECT `system_package`,verification_number,wired  FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";
		}

		$realm_query_results = $db_class1->select1DB($realm_query);
		//while($row=mysql_fetch_array($realm_query_results)){
		$system_package = $realm_query_results['system_package'];
		$uname_realm = $realm_query_results['verification_number'];
		$property_wired = $realm_query_results['wired'];
		//}

		$wifi_text = $package_functions->getMessageOptions('WIFI_TEXT', $system_package);
		$theme_text = $package_functions->getMessageOptions('THEME_TEXT', $system_package);

		if (empty($wifi_text) || $wifi_text == '') {
			$wifi_text = 'WiFi';
		}
		if ($property_wired == '1') {
			$wifi_text = 'Network';
		}

		$_SESSION['wifi_text'] = $wifi_text;


		if (empty($theme_text) || $theme_text == '') {
			$theme_text = 'theme';
		}

		$_SESSION['theme_text'] = $theme_text;

		// exit();
		$db_class1->userLog($s_uname, $script, 'Support Auto Login', $uname_realm);
		header("Location:venue_support" . $extension . "?s_token=$s_detail_encode");
		exit();
	} else {
		header("Location:support" . $extension);
		exit();
	}
}

if ($_GET['log_other'] == '2') {
	$secu_token = $_GET['security_token'];

	if ($secu_token == $_SESSION['security_token']) {
		//get token and encode master admin details
		$s_uname = $_SESSION['user_name'];
		$_SESSION['ori_user_uname'] = $s_uname;
		$s_arole = $_SESSION['access_role'];
		$s_fname = $_SESSION['full_name'];
		$_SESSION['full_name_old'] = $s_fname;

		// verify distributor belongs to parent
		$string_pass = $_GET['key'];
		$decrypt_text = $app->encrypt_decrypt('decrypt', $string_pass);
		parse_str($decrypt_text, $data_arr);
		$p_details = 's_uname=' . $s_uname . '&s_arole=' . $s_arole . '&s_fname=' . $s_fname;
		$_SESSION['p_token'] = md5(uniqid(rand(), true));
		$p_detail_encode = base64_encode($_SESSION['p_token'] . $p_details);
		$_SESSION['p_detail'] = $p_details;
		$_SESSION['remote'] = 'yes';

		//login from sub user
		$_SESSION['user_name'] = $data_arr['uname'];
		$_SESSION['access_role'] = $data_arr['urole'];
		$_SESSION['full_name'] = $s_fname;
		$user_name = $_SESSION['user_name'];

		$user_type = $db_class1->getValueAsf("SELECT  user_type AS f  FROM  admin_users WHERE user_name = '$user_name' LIMIT 1");

		$user_distributor = $db_class1->getValueAsf("SELECT  user_distributor AS f  FROM  admin_users WHERE user_name = '$user_name' LIMIT 1");

		//Sync SSID,AP
		$exec_cmd = 'php -f' . __DIR__ . '/ajax/syncAP.php ' . $user_distributor . ' > /dev/null &';
		exec($exec_cmd);
		
		if ($user_type == "SADMIN" || $user_type == "MNO" || $user_type == "ADMIN" || $user_type == "SUPPORT" || $user_type == "TECH" || $user_type == "SALES" || $user_type == "RESELLER_ADMIN") {
			$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
		} else if ($user_type == "MVNO_ADMIN") {
			$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$user_distributor'");
		} else if ($user_type == "MVNO" || $user_type == "MVNE" || $user_type == "MVNA") {
			$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
			$property_wired = $db_class1->getValueAsf("SELECT `wired` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
		}

		$new_design = $package_functions->getOptions('NEW_DESIGN', $system_package);

		if ($user_type == "TECH") {
			$new_design = 'yes';
		}

		$wifi_text = $package_functions->getMessageOptions('WIFI_TEXT', $system_package);
		$theme_text = $package_functions->getMessageOptions('THEME_TEXT', $system_package);

		if (empty($wifi_text) || $wifi_text == '') {
			$wifi_text = 'WiFi';
		}
		if ($property_wired == '1') {
			$wifi_text = 'Network';
		}

		$_SESSION['wifi_text'] = $wifi_text;

		if (empty($theme_text) || $theme_text == '') {
			$theme_text = 'theme';
		}

		$_SESSION['theme_text'] = $theme_text;
		$realm_query2 = "SELECT `network_type`,verification_number FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";

		$realm_query_results2 = $db_class1->select1DB($realm_query2);
		$network_type = $realm_query_results2['network_type'];
		$uname_realm2 = $realm_query_results2['verification_number'];
		$isDynamic = $package_functions->isDynamic($system_package);

		if ($new_design == 'yes' && ($network_type != 'VT' || $isDynamic)) {
			$db_class1->userLog($user_name, $script, 'Properties Auto Login', $uname_realm2);
			header("Location:intro" . $extension . "?p_token=$p_detail_encode");
			exit();
		} elseif ($network_type == 'VT') {
			$db_class1->userLog($user_name, $script, 'Properties Auto Login', $uname_realm2);
			header("Location:add_tenant" . $extension . "?p_token=$p_detail_encode");
			exit();
		} else {
			$db_class1->userLog($user_name, $script, 'Properties Auto Login', $uname_realm2);
			header("Location:home" . $extension . "?p_token=$p_detail_encode");
			exit();
		}
	}
}

/////// Login session failed ////
if ($_SESSION['login'] != 'yes' && $script != 'verification') {
	$db_class1->userLog($user_name, $script, 'LOGIN Failed', 'N/A');
	$redirect_url = 'logout' . $extension . '?doLogout=true&product=' . $_COOKIE["system_package"] . '&login=' . $_COOKIE["load_login_design"];

	///////////////////////////////////////////////////////////////////////////////////////////////////////

	if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
		//echo "Ex";
?>
		<meta http-equiv="refresh" content="0;URL='<?php echo $redirect_url; ?>'">
	<?php

	} else {
		//header_remove();
		header('location: ' . $redirect_url);
	?>
		<meta http-equiv="refresh" content="0;URL='<?php echo $redirect_url; ?>'">
	<?php
		//exit();
	}

	exit();
}

// Collect session valiables
$user_name = $_SESSION['user_name'];
$access_role = $_SESSION['access_role'];
$full_name = $_SESSION['full_name'];
$_SESSION['timeout'] = time();
$cookie_name = "timeout";
$cookie_value = time();
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

//server log class
require_once 'classes/logClass.php';
$create_log = new logs($script, $user_name);

// Get access role related information
if ($user_type == 'MVNO_ADMIN') {
	// Parent User
	$key_query = "SELECT  `access_role`, user_type, user_distributor,is_enable,full_name
	FROM  admin_users WHERE user_name = '$user_name' LIMIT 1";
	//$key_query = "SELECT  'admin', 'MVNO_ADMIN', $s_distri,1,$s_fname";
	//exit();
} else {
	$key_query = "SELECT  `access_role`, user_type, user_distributor,is_enable,full_name
	FROM  admin_users WHERE user_name = '$user_name' LIMIT 1";
	// general User
}


$query_results = $db_class1->select1DB($key_query);
//while($row=mysql_fetch_array($query_results)){
$access_role = $query_results[access_role];
$user_type = $query_results[user_type];
$user_distributor = $query_results[user_distributor];
if (strlen($full_name) == 0) {
	$full_name = $query_results[full_name];
}
$active_user = $query_results[is_enable];

if ($_SESSION['remote'] == 'yes') {
	if ($active_user == '8') {
		$no_profile = '1';
		if (isset($_SESSION['s_token'])) {
			$full_name = $db_class1->getValueAsf("SELECT  full_name AS f FROM admin_users u JOIN exp_mno_distributor d ON u.verification_number=d.parent_id WHERE d.distributor_code='$user_distributor'"); //'parent full name'; // Support Login - parent name Displayed

		} else {
			$full_name = $_SESSION['full_name_old']; // Master Admin Name is displayed
		}
	}

	$active_user = '1';
}

$_SESSION['user_distributor'] = $user_distributor;

if ($_SESSION['login'] == 'yes') {

	if (isset($_SESSION['s_token'])) {
		$sup_user = 1;
	}
	if (isset($_SESSION['p_token'])) {
		$pro_admin_user = 1;
	} else {
		if ($active_user != 1) {

			header('location: ' . 'logout' . $extension . '?doLogout=true&login=' . $login_design);
			exit();
		}
	}
}

//////// System Packages and features
if ($user_type == "SADMIN" || $user_type == "MNO" || $user_type == "ADMIN" || $user_type == "SUPPORT" || $user_type == "TECH" || $user_type == "SALES" || $user_type == "RESELLER_ADMIN" || $user_type == "PROVISIONING") {
	$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");
	if ($user_type == "MNO" || $user_type == "RESELLER_ADMIN" || $user_type == "SUPPORT") {
		$fearuresjson = $db_class1->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
		$mno_feature = json_decode($fearuresjson);
	}
} 
// else if ($user_type == "MVNO_ADMIN") {
// 	$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$user_distributor'");
// } else if ($user_type == "MVNO" || $user_type == "MVNE" || $user_type == "MVNA") {
// 	$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

// 	$advanced_features = $db_class1->getValueAsf("SELECT `advanced_features` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
// }

if ($system_package == "N/A" || $system_package == "") {
	$package_features = "all";
	$system_package = "N/A";
} else {
	$features_array = array();
	$features_tab = $package_functions->getOptions('ALLOWED_TAB', $system_package);
	$result1 = json_decode($features_tab, true);
	$features_array = array_merge($features_array, $result1); 
}

$advanced_features = json_decode($advanced_features, true);

if ($advanced_features['802.2x_authentication'] != '1') {
	foreach ($features_array as $key => $value) {
		if ($value == 'NET_AUTHENTICATION') {
			unset($features_array[$key]);
		}

		if ($value == 'NET_AAA_SET') {
			unset($features_array[$key]);
		}
	}
	array_push($features_array, 'NET_PRI_PASS');
}

//message class
require_once 'classes/messageClass.php';
$message_functions = new message_functions($system_package);

//////// End System Packages and features
$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
$camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $system_package);
$new_design = $package_functions->getOptions('NEW_DESIGN', $system_package);
$page_intro = $package_functions->getSectionType("INTRO_PAGE", $system_package);
$SUBMENU_VERTICALE = $package_functions->getSectionType("SUBMENU_VERTICALE", $system_package);

if (isset($_SESSION['s_token']) || isset($_SESSION['p_token'])) {
	$ori_user_uname = $_SESSION['ori_user_uname'];
	$ori_user_type = $db_class1->getValueAsf("SELECT  user_type AS f  FROM  admin_users WHERE user_name = '$ori_user_uname' LIMIT 1");
	$ori_user_distributor = $db_class1->getValueAsf("SELECT  user_distributor AS f  FROM  admin_users WHERE user_name = '$ori_user_uname' LIMIT 1");
	if ($ori_user_type == "MNO" || $ori_user_type == "ADMIN" || $ori_user_type == "SUPPORT" || $ori_user_type == "TECH") {
		$ori_system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$ori_user_distributor'");
	} else if ($ori_user_type == "MVNO_ADMIN") {
		$ori_system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `mno_distributor_parent` WHERE `parent_id`='$ori_user_distributor'");
	} else if ($ori_user_type == "MVNO" || $ori_user_type == "MVNE" || $ori_user_type == "MVNA") {
		$ori_system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$ori_user_distributor'");
	}

	$session_logout_btn_display = $package_functions->getOptions('SESSION_LOGOUT_BUTTON_DISPLAY', $ori_system_package);
	$logout_time = $package_functions->getOptions('SESSION_LOGOUT_TIME', $ori_system_package);
} else {
	$session_logout_btn_display = $package_functions->getOptions('SESSION_LOGOUT_BUTTON_DISPLAY', $system_package);
	$logout_time = $package_functions->getOptions('SESSION_LOGOUT_TIME', $system_package);
}

if (strlen($camp_layout) == "0") {
	$camp_layout = "DEFAULT_LAYOUT";
}

require_once 'layout/' . $camp_layout . '/index.php';
include_once 'layout/' . $camp_layout . '/define.php';
$layout_text_pages = 'layout/' . $camp_layout . '/views/' . $script . '_view.php';

try {
	include_once $layout_text_pages;
} catch (Exception $e) {
	include_once 'layout/DEFAULT_LAYOUT/views/' . $script . '_view.php';
}

//////// Get Main Valiables //////////

$top_menu = $package_functions->getOptions('TOP_MENU', $system_package);
$base_url = trim($db_class1->setVal('portal_base_url', 'ADMIN'), "/");
$base_folder = trim($db_class1->setVal('portal_base_folder', 'ADMIN'), "/");
$getSectionType = $package_functions->getSectionType("HADER_OPTIONS", $system_package, $user_type);

$main_menu_clickble = $package_functions->getSectionType('MAIN_MANU_CLICKBLE', $system_package);

if (strlen($top_menu) == "0" || $top_menu == '') {
	$top_menu = 'top';
}

if (strlen($main_menu_clickble) == "0" || $main_menu_clickble == '') {
	$main_menu_clickble = 'YES';
}

// New Access Functions
function isModuleAccess($access_role, $module, $db_function)
{
	$sql1 = "SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role` = '$access_role' AND `module_name` = '$module' LIMIT 1";
	// var_dump($sql1);
	$result = $db_function->selectDB($sql1);
	// print_r($result);
	//$row_count = mysql_num_rows($result);
	if ($result['rowCount'] > 0) {
		return true;
	} else {
		return false;
	}
}

// Menu Design
$originalUserType = $user_type;
$originalAccessRole = $access_role;
$originalSystemPackage = $system_package;

$user_type = ($user_type == 'SADMIN') ? 'ADMIN' : $user_type;
$access_role = ($user_type == 'SADMIN') ? 'ADMIN' : $access_role;
$system_package = ($user_type == 'SADMIN') ? 'GENERIC_ADMIN_001' : $system_package;
$dropdown_query1 = "SELECT module_name,menu_item FROM `admin_access_modules` WHERE user_type = '$user_type'";

$query_results_drop1 = $db_class1->selectDB($dropdown_query1);
// var_dump($query_results_drop1);
foreach ($query_results_drop1['data'] as $row) {
	if ($row[menu_item] == 3) {
		$x_non_admin[] = $row[module_name]; // Non Admin Roles
	} else {
		$x[] = $row[module_name]; // Retuns base access
	}
}

// echo '------------<br/>';
// var_dump($x);
foreach ($x as $keyX => $valueX) {
	if (strtoupper($access_role) != 'ADMIN' && strlen($access_role) > '0') {
		if (!(isModuleAccess($access_role, $valueX, $db_class1))) {
			try {
				unset($x[$keyX]);
			} catch (Exception $e) {
			}
		}
	}
	if ($package_functions->getPageFeature($valueX, $system_package) == '0') {
		try {
			unset($x[$keyX]);
		} catch (Exception $e) {
		}	
	}
	// var_dump($x);
}
// echo '------------<br/>';

array_push($x,"change_portal");
// var_dump($x);
/// Non Admin Modules
foreach ($x_non_admin as $keyXn => $valueXn) {
	if (strtoupper($access_role) != 'ADMIN' && strlen($access_role) > '0') {
		if (isModuleAccess($access_role, $valueXn, $db_class1)) {
			if ($package_functions->getPageFeature($valueXn, $system_package) == '1') {
				$x[] = $valueXn;
			}
		}
	}
}
// echo '------------<br/>';
// var_dump($x);
$allowed_pages = $x;

$module_ids = join('", "', $x);
$suspended = false;
if ($user_type == 'MVNO') {
	//Pages allowed to wired properties
	$wired_pages = ['add_tenant', 'manage_tenant', 'communicate', 'home', 'user_guide', 'venue_support'];
	$dist_details = $db_class1->select1DB("SELECT d.wired,d.gateway_type,d.private_gateway_type,d.bussiness_type,d.network_type,d.other_settings,d.is_enable,m.system_package as mno_sys FROM exp_mno_distributor d JOIN exp_mno m ON d.mno_id=m.mno_id WHERE distributor_code='" . $user_distributor . "'");
	$property_getaway_type = $dist_details['gateway_type'];
	$property_business_type = $dist_details['bussiness_type'];
	$property_wired = $dist_details['wired'];
	/* start suspend location logout */
	$is_enable = $dist_details['is_enable'];
	$ale4_prod = ['LP_MNO_002', 'LP_MNO_003_LP', 'LP_MNO_004_SL'];
	if (in_array($dist_details['mno_sys'], $ale4_prod)) {
		$GLOBALS['qos_ale_version'] = 'ale4';
	}
	if ($is_enable == 3 && !isset($_SESSION['s_token'])) {
		$suspended = true;
	}
	/* end suspend location logout */
	$network_type = $dist_details['network_type'];
	$other_multi_area = json_decode($dist_details['other_settings'])->other_multi_area;
	$private_gateway = $dist_details['private_gateway_type'];
}
$wysywyg_editor = false;
$edit_location_old = false;
if ($_GET['location_parent_id']) {
	$parent_id_new = $_GET['location_parent_id'];
	$flow_type = $db_class1->getValueAsf("SELECT flow_type as f FROM mno_distributor_parent WHERE parent_id='" . $parent_id_new . "'");
	if ($flow_type != 'new') {
		$edit_location_old = true;
	}
}
// var_dump($camp_layout);
require_once 'layout/' . $camp_layout . '/config.php';

$query_modules = "SELECT * FROM `admin_access_modules`
WHERE `module_name` IN (\"$module_ids\")
AND `user_type` = '$user_type'";
// echo $query_modules;
// var_dump($module_ids);
// var_dump($user_type);
$query_results_mod = $db_class1->selectDB($query_modules);

//$network_type=$db_class1->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

$restricted_pages = $package_functions->getOptions("RESTRICTED_PAGES", $system_package);

$tmp_0 = '';
$main_mod_array = array();
foreach ($query_results_mod['data'] as $row1) {
	$menu_item_row = $row1[menu_item]; // Retuns base access.
	$main_module_order = $row1[main_module_order];
	$main_module = $row1[main_module];
	$module_name = $row1[module_name];
	$order = $row1[order];
	$name_group = $row1[name_group];
	$is_enable = $row1[is_enable];
	//===========Remove Content Filter
	if ($module_name == 'content_filter') {

		if (($property_getaway_type == 'AC' || $property_business_type == 'ENT') && in_array('CONTENT_FILTER_QOS', $result1)) {

			$main_cf_key = array_search('CONTENT_FILTER_MAIN', $result1);
			$main_cf_key2 = array_search('CONTENT_FILTER_MAIN', $features_array);
			//print_r($features_array);
			if ($main_cf_key) {
				unset($result1[$main_cf_key]);
			}
			if ($main_cf_key2) {
				unset($features_array[$main_cf_key2]);
			}

			if ($tmp_0 == 'content_filter?t=12') {
				continue;
			} else {
				$tmp_0 = $module_name;
			}
		} else if ($property_getaway_type == 'AC' || $property_business_type == 'ENT') {
			continue;
		}
	}

	if ($module_name == 'content_filter?t=12') {
		if ($tmp_0 == 'content_filter') {
			foreach ($main_mod_array as $tmp_key1 => $tmp_val1) {
				if (is_array($tmp_val1)) {
					foreach ($tmp_val1 as $tmp_key2 => $tmp_val2) {
						if ($tmp_key2 == 'module') {
							if (is_array($tmp_val2)) {
								foreach ($tmp_val2 as $tmp_key3 => $tmp_val3) {
									if ($tmp_val3['link'] == 'content_filter') {
										//echo $tmp_key3;
										unset($main_mod_array[$tmp_key1][$tmp_key2][$tmp_key3]);
									}
								}
							}
						}
					}
				}
			}
		} else {
			$tmp_0 = $module_name;
		}
	}
	//=======================


	//wired property filter
	if ($property_wired == '1') {
		if (!in_array($module_name, $wired_pages))
			continue;
	}

	//Hospitality Guest WIFI
	if ($main_module == 'Guest WiFi' && $hospitality_feature) {
		$main_module = 'Guest ' . $_SESSION['wifi_text'];
	}

	//Filter service area , Only allowed to multi service area.
	if ($module_name == 'service_area' && !$hospitality_feature) {
		continue;
	}


	//===================================
	//Distributor Network type - Private or guest
	//==================================
	if ($user_type == "MVNO" || $user_type == "MVNE" || $user_type == "MVNA") {

		//echo "SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'";
		//echo $system_package;

		//print_r($restricted_pages);

		if (strlen($restricted_pages) == 0 || $restricted_pages == "") {

			$restricted_pages = '{"PRIVATE":["network","campaign","theme","add_tenant","manage_tenant","communicate","network_tenant","theme_s","customer","reports"],"GUEST":["service_area","network_pr","add_tenant","manage_tenant","communicate","network_tenant"],"BOTH":["add_tenant","manage_tenant","communicate","network_tenant"],"VT-PRIVATE":["theme","campaign","network","theme_s","customer","reports"],"VT-GUEST":["service_area","network_pr"],"VT":["service_area","network_pr","theme","campaign","network","theme_s","customer","reports"]}';
		}

		$restricted_page = json_decode($restricted_pages, true);



		//print_r($restricted_page);
		$page_access_array = $restricted_page[$network_type];
		if (in_array($module_name, $page_access_array)) {

			continue;
		}
		// for ($i=0; $i < strlen($page_access); $i++) { 
		// 	echo $module_name=$page_access[$i];
		// }


		//}

		/*$network_type=$db_class1->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

		if(($network_type=='PRIVATE' && $module_name=='network') || ($network_type=='PRIVATE' && $module_name=='campaign') || ($network_type=='PRIVATE' && $module_name=='theme') || ($network_type=='PRIVATE' && $module_name=='add_tenant') || ($network_type=='PRIVATE' && $module_name=='manage_tenant') || ($network_type=='PRIVATE' && $module_name=='communicate') ){
			continue;
		}elseif (($network_type=='GUEST' && $module_name=='network_pr') || ($network_type=='GUEST' && $module_name=='add_tenant') || ($network_type=='GUEST' && $module_name=='manage_tenant') || ($network_type=='GUEST' && $module_name=='communicate') ){
			continue;
		}elseif(($network_type=='VT-PRIVATE' && $module_name=='network') || ($network_type=='VT-PRIVATE' && $module_name=='campaign') || ($network_type=='VT-PRIVATE' && $module_name=='theme') ){
				continue;
		}elseif ($network_type=='VT-GUEST' && $module_name=='network_pr'){
				continue;
		}elseif(($network_type=='VT' && $module_name=='home') || ($network_type=='VT' && $module_name=='network_pr') || ($network_type=='VT' && $module_name=='network') || ($network_type=='VT' && $module_name=='campaign') || ($network_type=='VT' && $module_name=='theme') || ($network_type=='VT' && $module_name=='intro') ){
				continue;
		}elseif(($network_type=='BOTH' && $module_name=='add_tenant') || ($network_type=='BOTH' && $module_name=='manage_tenant') || ($network_type=='BOTH' && $module_name=='communicate')  ){
				continue;
		}*/
	}
	/* elseif(($network_type=='BOTH' && $module_name=='add_tenant') || ($network_type=='BOTH' && $module_name=='manage_tenant') || ($network_type=='BOTH' && $module_name=='communicate')  ){
				continue;
			} */

	/*

	menu item = 1 => Menu
	menu item = 0 => Non Menu
	menu item = 2 => Support
	menu item = 3 => Non Admin Items // On Role
	menu item = 4 => FAQ Support
	menu item = 5 => FAQ Property owner with non Support login
	menu item = 6 => User Guide

	*/

	//if($_SESSION['s_token']){

	if ($is_enable == 1) {
		if ($menu_item_row == '1') {
			//	echo "<br>".$main_module." "."1";
			//	echo " <br>". $menu_item_row."-".$name_group."-".$module_name."--$main_module";
			$access_modules_list[] = $module_name;
			$main_mod_array[$main_module_order]['name'] = $main_module;
			if ($script == $module_name) {
				$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
			}
			$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
			$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
			$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
			//	print_r($main_mod_array);
		} else if ($menu_item_row == '2') {

			//echo "<br>".$main_module." "."2";
			$tool_enable = $package_functions->getSectionType("BUSINESS_ID_TOOL_PAGE_ENABLE", $system_package);
			if ($_SESSION['s_token'] || $property_business_type == 'ENT' || $tool_enable == 'YES') {
				if (!$_SESSION['s_token']) {
					$main_module = 'Tools';
					$name_group = 'Tools';
				}

				$access_modules_list[] = $module_name;
				$main_mod_array[$main_module_order]['name'] = $main_module;
				if ($script == $module_name) {
					$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
				}
				$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
				$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
				$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
			}
		} else if ($menu_item_row == '3') {

			//echo "<br>".$main_module." "."3";

			$access_modules_list[] = $module_name;
			$main_mod_array[$main_module_order]['name'] = $main_module;
			if ($script == $module_name) {
				$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
			}
			$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
			$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
			$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
		} else if ($menu_item_row == '4') {

			//echo "<br>".$main_module." "."4";
			if ($_SESSION['s_token']) {

				$access_modules_list[] = $module_name;
				$main_mod_array[$main_module_order]['name'] = $main_module;
				if ($script == $module_name) {
					$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
				}

				$red_link = "SELECT f.`url` AS f FROM exp_footer f,exp_mno_distributor d  WHERE f.`distributor`= d.`mno_id` AND d.`distributor_code`='$user_distributor'";
				$module_name = $db_class1->getValueAsf($red_link);
				$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
				$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
				$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
				$main_mod_array[$main_module_order]['module'][$order]['nw_link'] = '1';
			}
		} else if ($menu_item_row == '5') {
			//echo "<br>".$main_module." "."5";

			if (!$_SESSION['s_token']) {

				$access_modules_list[] = $module_name;
				$main_mod_array[$main_module_order]['name'] = $main_module;
				if ($script == $module_name) {
					$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
				}

				//$support_faq_link=$package_functions->getOptions('SUPPORT_FAQ_LINK',$system_package);

				$red_link = "SELECT f.`url` AS f FROM exp_footer f,exp_mno_distributor d  WHERE f.`distributor`= d.`mno_id` AND d.`distributor_code`='$user_distributor'";
				$support_faq_link = $db_class1->getValueAsf($red_link);
				$main_mod_array[$main_module_order]['module'][$order]['link'] = $support_faq_link;
				$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
				$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
				$main_mod_array[$main_module_order]['module'][$order]['nw_link'] = '1';
			}
		} else if ($menu_item_row == '6') {
			//echo "<br>".$main_module." "."5";



			$access_modules_list[] = $module_name;
			$main_mod_array[$main_module_order]['name'] = $main_module;
			if ($script == $module_name) {
				$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
			}

			$user_guide_namejson = $package_functions->getOptions('USER_GUIDE', $system_package);
			$isJson = CommonFunctions::isJson($user_guide_namejson);
			if ($isJson) {
				$property_business_type;
				$user_guide_name = json_decode($user_guide_namejson, true)[$property_business_type];
				if (strlen($user_guide_name) < 1) {
					$user_guide_name = json_decode($user_guide_namejson, true)['Default'];
				}
			} else {
				$user_guide_name = $user_guide_namejson;
			}
			//$red_link="SELECT f.`url` AS f FROM exp_footer f,exp_mno_distributor d  WHERE f.`distributor`= d.`mno_id` AND d.`distributor_code`='$user_distributor'";
			$user_guide_link = "resources/module/" . $user_guide_name;
			//$support_faq_link=$db_class1->getValueAsf($red_link);
			$main_mod_array[$main_module_order]['module'][$order]['link'] = $user_guide_link;
			$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
			$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
			$main_mod_array[$main_module_order]['module'][$order]['nw_link'] = '1';
		} else if ($menu_item_row == '0') {
			//echo "<br>".$main_module." "."0";
			$access_modules_list[] = $module_name;
		} else if ($menu_item_row == '7') {
			//	echo "<br>".$main_module." "."1";
			//echo $user_type;
			$newfeature = array();
			if ($user_type == 'MNO' || $user_type == 'PROVISIONING') {
				$dist_namenew = $user_distributor;
				$featuressql = "SELECT `features` AS f FROM exp_mno  WHERE `mno_id`='$dist_namenew'";
				$featuresjson = $db_class1->getValueAsf($featuressql);
				$features = json_decode($featuresjson, true);

				$featuresall = "SELECT `service_id`,`reference` FROM exp_service_activation_features WHERE `service_type`='MNO_FEATURES'";
				$query_results = $db_class1->selectDB($featuresall);
				if ($query_results['rowCount'] > 0) {
					foreach ($query_results['data'] as $row) {
						$feature_name = $row['service_id'];
						$module_nam = $row['reference'];
						if (in_array($feature_name, $features)) {
							array_push($newfeature, $module_nam);
						}
					}
				}
				$defaultfeature = "SELECT `reference` FROM exp_other_profile WHERE `distributor`='$system_package'";
				$query_resultsn = $db_class1->selectDB($defaultfeature);
				if ($query_resultsn['rowCount'] > 0) {
					foreach ($query_resultsn['data'] as $row) {
						$module_nam = $row['reference'];
						if (strlen($module_nam) > 0) {
							array_push($newfeature, $module_nam);
						}
					}
				}
			} else {
				$featuressql = "SELECT `features` AS f FROM mno_distributor_parent  WHERE `parent_id`='$user_distributor'";
				$featuresjson = $db_class1->getValueAsf($featuressql);
				$features = json_decode($featuresjson, true);
				$optfeatures = $db_class1->getValueAsf("SELECT m.`features` AS f FROM `exp_mno` m JOIN mno_distributor_parent p ON m.`mno_id`=p.`mno_id` WHERE p.`parent_id`='$user_distributor' LIMIT 1");
				$featuresopt = json_decode($optfeatures, true);

				$featuresal = "SELECT `service_id`,`reference`,`mno_feature` FROM exp_service_activation_features WHERE `service_type`='MVNO_ADMIN_FEATURES'";
				$query_resultsn = $db_class1->selectDB($featuresal);
				if ($query_resultsn['rowCount'] > 0) {
					foreach ($query_resultsn as $row) {
						$feature_name = $row['service_id'];
						$module_nam = $row['reference'];
						$mno_feature = $row['mno_feature'];
						if (array_key_exists($feature_name, $features) && in_array($mno_feature, $featuresopt)) {
							if ($features[$feature_name] == 2) {
								array_push($newfeature, $module_nam);
							}
						}
					}
				}
			}

			foreach ($newfeature as $value) {
				if ($value == $module_name) {
					$access_modules_list[] = $module_name;
					$main_mod_array[$main_module_order]['name'] = $main_module;
					if ($script == $module_name) {
						$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
					}
					$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
					$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
					$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
				}
			}



			//print_r($main_mod_array);
		} else if ($menu_item_row == '8') {

			//echo "<br>".$main_module." "."2";
			if (!$_SESSION['s_token']) {

				$access_modules_list[] = $module_name;
				$main_mod_array[$main_module_order]['name'] = $main_module;
				if ($script == $module_name) {
					$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
				}

				//$support_faq_link=$package_functions->getOptions('SUPPORT_FAQ_LINK',$system_package);

				$red_link = "SELECT f.`url` AS f FROM exp_footer f,exp_mno_distributor d  WHERE f.`distributor`= d.`mno_id` AND d.`distributor_code`='$user_distributor'";
				$support_faq_link = CommonFunctions::setUrlHttps($db_class1->getValueAsf($red_link));
				$main_mod_array[$main_module_order]['module'][$order]['link'] = $support_faq_link;
				$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
				$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
				$main_mod_array[$main_module_order]['module'][$order]['nw_link'] = '1';
			}
		} else if ($menu_item_row == '9') {

			//echo "<br>".$main_module." "."2";
			if ($_SESSION['s_token']) {

				$access_modules_list[] = $module_name;
				$main_mod_array[$main_module_order]['name'] = $main_module;
				if ($script == $module_name) {
					$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
				}
				$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
				$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
				$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
			}
		}
	}
}

ksort($main_mod_array);

//print_r(json_encode($main_mod_array));
// var_dump($access_modules_list);
// die;



/////////////////////////////////////////////////////////
// SECURITY POINT -- Verify the customer is correct
//////////////////////////////////////////////////////////

if ($suspended) {
	$main_mod_array = array();
	$access_modules_list = array("suspend");
	$no_profile = '1';
	if ($script != "suspend") {
		$redirect_url = $global_base_url . '/suspend' . $extension;
		header('Location: ' . $redirect_url);
		exit();
	}
} else {
	if (in_array($script, $access_modules_list) || $script == 'verification') {
		// Access LOG

		//if(isset($_SESSION['p_token'])){
		//	$ori_user_uname = $_SESSION['ori_user_uname'];
		//	 $log_query = "INSERT INTO admin_user_logs (`user_name`,`module`,`create_date`, `unixtimestamp`)
		//	(SELECT '$ori_user_uname',`module`,now(),UNIX_TIMESTAMP() FROM `admin_main_modules` WHERE `module_name` = '$script')";
		//}
		//else{
		//echo $script;
		$db_class1->userLog($user_name, $script, 'Browse', 'N/A');
		
		$message_response = $message_functions->showMessage('ap_controller_create_failed', '2001');
		// $db->addLogs($user_name, 'ERROR',$user_type, 'login', 'Browse',0,'2001','');
		// $log_query = "INSERT INTO admin_user_logs (`user_name`,`module`,`create_date`,`unixtimestamp`)
		//(SELECT '$user_name',`module`,now(),UNIX_TIMESTAMP() FROM `admin_main_modules` WHERE `module_name` = '$script')";
		//}
		//$query_ex_log=mysql_query($log_query);

	} else {
		var_dump($system_package); die;
		$redirect_url = $global_base_url; //index".$extension;$message_response = $message_functions->showMessage('ap_controller_create_failed', '2001');
		// $db->addLogs($user_name, 'ERROR',$user_type,'login', 'Browse',0,'2000',$redirect_url);
		$db_class1->userErrorLog('2000', $user_name, 'script - ' . $script);

		header('Location: ' . $redirect_url);
	?>
		<meta http-equiv="refresh" content="0;URL='<?php echo $redirect_url; ?>'">
<?php
		exit();
	}
	
}
/////////////////////////////////////////////////////////
// End SECURITY POINT -- Verify the customer is correct
//////////////////////////////////////////////////////////




////////////////////
////// Coloring/////

$camp_theme_color = '#00ba8b'; // Default Color

if ($user_type == 'ADMIN' || $user_type == 'SADMIN') {
	// $dist_name = 'ADMIN';
	$dist_name = $user_type;
	$camp_theme_color = '#00ba8b';

	$abc_q = "SELECT * FROM `exp_mno` WHERE `mno_id` = '".$dist_name."'";
	$row = $db_class1->select1DB($abc_q);
	//while($row = mysql_fetch_array($def_r)){

	$camp_theme_color = $row['theme_color'];
	$camp_theme_logo = $row['theme_logo'];
	$site_title = $row['theme_site_title'];

	$top_line_color = $row['theme_top_line_color'];
	$style_type = $row['theme_style_type']; //light/dark
	$light_color = $row['theme_light_color'];
	//}
} else if ($user_type == 'MNO' || $user_type == 'SUPPORT' || $user_type == 'PROVISIONING') {
	$dist_name = $user_distributor;
	//$camp_theme_color = $db_class1->setVal("mno_color",$dist_name);
	$mni_favicon_id = $dist_name;
	$abc_q = "SELECT * FROM `exp_mno` WHERE `mno_id` = '$user_distributor'";
	$row = $db_class1->select1DB($abc_q);
	//while($row = mysql_fetch_array($def_r)){

	$camp_theme_color = $row['theme_color'];
	$camp_theme_logo = $row['theme_logo'];
	//$camp_text = $row['theme_site_title'];
	$site_title = $row['theme_site_title'];
	if (strlen($site_title) == 0) {
		$site_title = $db_class1->getValueAsf("SELECT flow_name AS f FROM exp_mno_flow WHERE flow_type='MNO'");
	}

	$top_line_color = $row['theme_top_line_color'];
	$style_type = $row['theme_style_type']; //light/dark
	$light_color = $row['theme_light_color'];
	$setting = json_decode($row['setting'], true);

	if (!empty($setting)) {
		if (strlen($setting['headerImage']) > 0) {
			$introMnoPage = $setting['headerImage'];
		}
	}
	//}
} else {

	// Self coloring
	if ($getSectionType == "OWN" || $package_features == "all") {
		$kmno_query = "SELECT * FROM exp_mno_distributor where distributor_code = '$user_distributor'";

		$row = $db_class1->select1DB($kmno_query);
		//print_r(mysql_fetch_array($query_results));
		//foreach ($query_results as $row) {
		$mno_id = $row[mno_id];
		$network_type = $row[network_type];
		$distributor_name_get = str_replace('\\', '', $row[distributor_name]);
		$site_title = str_replace('\\', '', $row[site_title]);
		$camp_theme_color = $row[camp_theme_color];
		$camp_theme_logo = $row[theme_logo];
		$mni_favicon_id = $mno_id;

		$top_line_color = $row['theme_top_line_color'];
		$style_type = $row['theme_style_type']; //light/dark
		$light_color = $row['theme_light_color'];


		//}
	}

	// Parent Based Coloring

	if ($getSectionType == "PARENT") {


		if ($user_type == 'MVNO_ADMIN') {

			$kmno_query = "SELECT * FROM mno_distributor_parent where parent_id = '$user_distributor'";

			$row = $db_class1->select1DB($kmno_query);
			//print_r(mysql_fetch_array($query_results));
			//while ($row = mysql_fetch_array($query_results)) {
			$mno_id = $row[mno_id];
			$mni_favicon_id = $mno_id;

			//}

		} else {
			$kmno_query = "SELECT * FROM exp_mno_distributor where distributor_code = '$user_distributor'";

			$row = $db_class1->select1DB($kmno_query);
			//print_r(mysql_fetch_array($query_results));
			//while ($row = mysql_fetch_array($query_results)) {
			$mno_id = $row[mno_id];
			$network_type = $row[network_type];
			$distributor_name_get = str_replace('\\', '', $row[distributor_name]);
			$site_title = str_replace('\\', '', $row[site_title]);
			$mni_favicon_id = $mno_id;

			//}

		}
		/////////////////////////////////////////////////////////////////////////////


	}

	$abc_q = "SELECT * FROM `exp_mno` WHERE `mno_id` = '$mno_id'";
	$row = $db_class1->select1DB($abc_q);
	//while($row = mysql_fetch_array($def_r)){

	$camp_theme_color = $row['theme_color'];
	$camp_theme_logo = $row['theme_logo'];
	//$camp_text = $row['theme_site_title'];
	$site_title = $row['theme_site_title'];

	$top_line_color = $row['theme_top_line_color'];
	$style_type = $row['theme_style_type']; //light/dark
	$light_color = $row['theme_light_color'];
	$setting = json_decode($row['setting'], true);;

	if (!empty($setting)) {
		if (strlen($setting['headerImage']) > 0) {
			$introMnoPage = $setting['headerImage'];
		}
	}

	//}
}

$user_timezone = $db_class1->getValueAsf("SELECT `timezone` AS f FROM `admin_users` WHERE `user_name`='$user_name'");
if (strlen($user_timezone) < 1) {
	if ($user_type == 'ADMIN') {
		$user_timezone = $db_class1->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'");
	} else {
		if ($user_type == 'MNO' || $user_type == 'SUPPORT' || $user_type == 'PROVISIONING') {
			$mno_id = $user_distributor;
		}
		$user_timezone = $db_class1->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");
	}
}
//echo $user_type;
//echo $user_timezone;

// Favicon

$mno_query2 = "SELECT * FROM `exp_mno` WHERE `mno_id` = '$mni_favicon_id'";
$row = $db_class1->select1DB($mno_query2);
$favicon_image = $row[favicon_image];


/*if(strlen($favicon_image)){
	echo '<link rel="shortcut icon" href="'.$base_folder.'/image_upload/favicon/'.$favicon_image.'">';
}
else{
	echo '<link rel="shortcut icon" href="'.$base_folder.'/image_upload/favicon/favicon.ico">';
}*/
// End Favicon
?>



<style>
	<?php if ($style_type == 'light') { ?>.navbar .nav .dropdown-toggle .caret,
	.navbar .nav .open.dropdown .caret {
		border-top-color: <?php echo $camp_theme_color; ?>;

	}

	<?php } else { ?>.dropdown-menu li>a:hover,
	.dropdown-menu .active>a,
	.dropdown-menu .active>a:hover {
		background: <?php echo $camp_theme_color; ?>;
	}

	<?php } ?>.navbar-inner {
		padding: 7px 0;

		background: <?php if ($style_type == 'light') {
						echo '#fff';
					} else {
						echo $camp_theme_color;
					} ?>;

		-moz-border-radius: 0;
		-webkit-border-radius: 0;
		border-radius: 0;


		<?php if (strlen($top_line_color) > 0) { ?>border-top: 10px solid <?php echo $top_line_color; ?>;
		<?php } ?>
	}



	.navbar .nav>li>a {
		<?php if ($style_type == 'light') { ?>color: rgb(1, 15, 29) text-shadow: 0 0px 0 rgba(0, 0, 0, .25);
		<?php } else { ?>color: #fff <?php } ?>
	}



	.dropdown-menu .active>a:hover,
	.dropdown-menu li>a:hover {
		background:
			<?php if ($style_type == 'light') echo $camp_theme_color;
			else echo $camp_theme_color; ?>
	}


	/*--------------------------------------------------------------------------------*/


	.subnavbar .container>ul>li {
		float: left;
		min-width: 90px;
		height: 60px;
		padding: 0;
		margin: 0;
		text-align: center;
		list-style: none;
		border-left: 1px solid #d9d9d9;
		border-bottom: 1px solid #d9d9d9;
		background-color: <?php if ($style_type == 'light') echo $camp_theme_color;
							else echo '#fff'; ?>;
		/*background-color: #284F73;*/
		margin-bottom: <?php if ($style_type == 'light') echo '1px';
						else echo '4px'; ?>;
		/*margin-top: -5px;*/
	}

	/*--------------------------------------------------------------------------------*/


	.subnavbar-inner {
		height: 60px;
		background: <?php if ($style_type == 'light') echo $camp_theme_color;
					else echo '#fff'; ?>;
		border-bottom: 1px solid #d6d6d6
	}



	.subnavbar .container>ul>li>a {
		display: block;
		height: 100%;
		padding: 0 15px;
		font-size: 12px;
		font-weight: 700;
		color: <?php if ($style_type == 'light') echo '#FFFFFF';
				else echo '#b2afaa'; ?>;
	}

	.subnavbar .container>ul>li>a:hover {
		color: #888;
		text-decoration: none
	}

	.subnavbar .container>ul>li>a>i {
		display: inline-block;
		width: 24px;
		height: 24px;
		margin-top: 11px;
		margin-bottom: -3px;
		font-size: 20px
	}

	.subnavbar .container>ul>li>a>span {
		display: block
	}

	.subnavbar .container>ul>li.active>a {
		<?php if ($style_type == 'light') { ?>border-bottom: 0px solid <?php echo $camp_theme_color; ?>;
		color: <?php echo $light_color; ?>;
		<?php } else { ?>border-bottom: 3px solid #ff7f74;
		color: #383838;
		<?php } ?>
	}

	.new {


		color: <?php if ($style_type == 'light') echo '#FFFFFF';
				else echo '#b2afaa'; ?>;
	}

	.new:hover {
		color: #888;
		text-decoration: none
	}


	.btn-primary {
		background-color: <?php echo $camp_theme_color; ?>;
	}

	.alert .close {
		top: -7px !important;
	}

	.btn-primary:hover {
		background-color: <?php echo $camp_theme_color; ?>;
	}

	#list {
		position: relative;
		width: 100%;
		display: block;
	}

	@media screen and (min-width: 410px) {
		.rwd-break {
			display: none;
		}
	}

	@media screen and (min-width: 600px) {
		.rwd-break1 {
			display: none;
		}
	}

	@media screen and (min-width: 350px) {
		.rwd-break2 {
			display: none;
		}
	}

	@media screen and (min-width: 480px) {
		.rwd-break3 {
			display: none;
		}
	}

	@media screen and (min-width: 321px) {
		.rwd-break4 {
			display: none;
		}
	}

	@media screen and (min-width: 365px) {
		.rwd-break4 {
			display: none;
		}
	}

	@media (max-width:480px) {
		.subnavbar .container>ul>li:last-child {
			overflow: hidden;
			float: none;
			white-space: nowrap;
		}
	}

	@media (max-width:480px) {
		.subnavbar .container>ul>li {
			float: left;
			white-space: nowrap;
		}
	}

	@media (max-width:480px) {
		.subnavbar .container>ul>li:nth-last-child(2) {}
	}

	@media (max-width:415px) {
		.subnavbar .container>ul>li:last-child {
			overflow: hidden;
			float: none;
			white-space: nowrap;
		}
	}

	@media (max-width:415px) {
		.subnavbar .container>ul>li {
			float: left;
			white-space: nowrap;
		}
	}

	@media (max-width:415px) {
		.subnavbar .container>ul>li:nth-last-child(2) {
			overflow: hidden;
			float: none;
			white-space: nowrap;
		}
	}

	@media (max-width:380px) {
		.subnavbar .container>ul>li:last-child {
			overflow: hidden;
			float: none;
			white-space: nowrap;
		}
	}

	@media (max-width:380px) {
		.subnavbar .container>ul>li {
			float: left;
			white-space: nowrap;
			min-width: 20%;
		}
	}

	@media (max-width:380px) {
		.subnavbar .container>ul>li:last-child {}
	}

	@media (max-width:380px) {
		.subnavbar .container>ul>li {
			max-wdth: 30%;
		}
	}

	@media (max-width:365px) {
		.subnavbar .container>ul>li {
			max-height: 43px;
		}
	}

	@media (max-width:365px) {
		.subnavbar .container>ul>li:nth-last-child(4) {
			overflow: hidden;
			float: none;
			white-space: nowrap;
		}
	}

	@media (max-width:330px) {
		.subnavbar .container>ul>li {
			max-height: 60px;
		}
	}

	@media (max-width:330px) and (min-width:365px) {
		.rwd-break5 {
			display: none;
		}
	}

	.navbar .nav.pull-right {

		margin-top: -20px;
	}

	.navbar .brand {
		margin-left: 0px !important;
		margin-top: 4px;
	}

	@media screen and (max-width: 980px) {
		#container_id>img {
			margin-left: 10px;
			margin-bottom: -4px;
		}
	}

	.navbar .btn,
	.navbar .btn-group {
		margin-top: 0px !important;
	}
</style>

<title><?php
		$title_difiner = '_' . $script . '_PAGE_TITLE_';
		echo defined($title_difiner) ? constant($title_difiner) : constant('_page_title_') ?></title>

<script type="text/javascript">
	function setCookie() {
		let cname = "timeout";
		let cvalue = Math.floor(Date.now() / 1000);
		let d = new Date();
		d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
		let expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	$(function() {
		$('a[data-toggle="tab"]').click(function() {
			setCookie();
		});
	});
</script>
</head>


<body>


	<style>
		.toggle-on {
			margin-bottom: 0px !important;
		}
	</style>

	<script>
		function dropdown() {
			var w = window.innerWidth;
			if (w < 980) {
				try {

					$(".navbar-fixed-top").css({
						"position": "fixed",
						"margin-left": "0px",
						"margin-right": "0px"
					});

					document.getElementById("sysmenu1").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu2").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu3").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu4").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu5").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu6").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu7").style.display = '';
				} catch (e) {}
				try {
					document.getElementById("sysmenu8").style.display = '';
				} catch (e) {}



			} else {

				try {

					$(".navbar-fixed-top").css({
						"position": "static",
						"margin-left": "",
						"margin-right": ""
					});

					document.getElementById("sysmenu1").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu2").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu3").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu4").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu5").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu6").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu7").style.display = 'none';
				} catch (e) {}
				try {
					document.getElementById("sysmenu8").style.display = 'none';
				} catch (e) {}

			}
		}
	</script>






	<?php

	if ($user_type == 'MNO') {

		$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

		$row = $db_class1->select1DB($key_query);
		//while($row=mysql_fetch_array($query_results)){
		$logo_top = $row[theme_logo];
		//}

		$logo_top = 'top_logo.png';
			if (file_exists("layout/" . $camp_layout . "/img/" . $logo_top)) {
				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="layout/' . $camp_layout . '/img/' . $logo_top . '?v=3" border="0" />&nbsp;';
			}

		//echo $db_class1->setVal("site_title",$dist_name);
		$logo_title = "<a class='brand' href='javascript:void(0);' style='text-decoration:none !important'>";
		if ($style_type == 'light') {
			$logo_title .= '<font color="' . $camp_theme_color . '">' . $site_title . '</font>';
		} else {
			$logo_title .= $site_title;
		}
		$logo_title .= "</a>";
	} elseif ($user_type == 'SUPPORT' || $user_type == 'PROVISIONING') {

		$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

		$row = $db_class1->select1DB($key_query);
		//while($row=mysql_fetch_array($query_results)){
		$logo_top = $row[theme_logo];
		//}

		if (strlen($logo_top)) {
			if (file_exists("image_upload/logo/" . $logo_top)) {
				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="image_upload/logo/' . $logo_top . '?v=3" border="0" />&nbsp;';
			}
		} else {
			$logo_top = 'top_logo.png';
			if (file_exists("layout/" . $camp_layout . "/img/" . $logo_top)) {
				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="layout/' . $camp_layout . '/img/' . $logo_top . '?v=3" border="0" />&nbsp;';
			}
		}

		//echo $db_class1->setVal("site_title",$dist_name);
		$logo_title = "<a class='brand' href='javascript:void(0);' style='text-decoration:none !important'>";
		if ($style_type == 'light') {
			$logo_title .= '<font color="' . $camp_theme_color . '">' . $site_title . '</font>';
		} else {
			$logo_title .= $site_title;
		}
		$logo_title .= "</a>";
	} elseif ($user_type == 'SALES') {

		$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

		$row = $db_class1->select1DB($key_query);
		//while($row=mysql_fetch_array($query_results)){
		$logo_top = $row[theme_logo];
		//}

		if (strlen($logo_top)) {
			if (file_exists("image_upload/logo/" . $logo_top)) {
				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="image_upload/logo/' . $logo_top . '?v=3" border="0" />&nbsp;';
			}
		} else {
			$logo_top = 'top_logo.png';
			if (file_exists("layout/" . $camp_layout . "/img/" . $logo_top)) {
				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="layout/' . $camp_layout . '/img/' . $logo_top . '?v=3" border="0" />&nbsp;';
			}
		}

		//echo $db_class1->setVal("site_title",$dist_name);
		$logo_title = "<a class='brand' href='javascript:void(0);' style='text-decoration:none !important'>";
		if ($style_type == 'light') {
			$logo_title .= '<font color="' . $camp_theme_color . '">' . $site_title . '</font>';
		} else {
			$logo_title .= $site_title;
		}
		$logo_title .= "</a>";
	} else if ($user_type == 'ADMIN') {
		$camp_theme_logo = $db_class1->setVal("site_logo", "ADMIN");
		if (strlen($camp_theme_logo)) {

			if (file_exists("image_upload/logo/" . $camp_theme_logo)) {

				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="image_upload/logo/' . $camp_theme_logo . '" border="0" />&nbsp;';
			}
		}
		//echo $db_class1->setVal("site_title","ADMIN");
		$logo_title = "<a class='brand' href='javascript:void(0);' style='text-decoration:none !important'>";
		if ($style_type == 'light') {
			$logo_title .= '<font color="' . $camp_theme_color . '">' . $site_title . '</font>';
		} else {
			$logo_title .= $site_title;
		}
		$logo_title .= "</a>";
	} else {
		if (strlen($camp_theme_logo)) {

			if (file_exists("image_upload/logo/" . $camp_theme_logo)) {

				$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="image_upload/logo/' . $camp_theme_logo . '" border="0" />&nbsp;';
			}
		} else {

			$vert = $property_business_type;

			if($user_type=="MVNO_ADMIN"){
				$dis_Q = "SELECT d.wired,d.gateway_type,d.private_gateway_type,d.bussiness_type,d.network_type,d.other_settings,d.is_enable,m.system_package as mno_sys FROM exp_mno_distributor d JOIN exp_mno m ON d.mno_id=m.mno_id WHERE d.parent_id='" . $user_distributor . "'";
				$dist_details = $db_class1->selectDB($dis_Q);
				$vert = $dist_details['data'][0]['bussiness_type'];
			}
			$logo_top = 'top_logo.png';
			$business_logo = "logo_" . strtolower($vert).".png";
			if(file_exists("layout/" . $camp_layout . "/img/".$business_logo)){
				$logo_top = $business_logo;
			}
				
				if (file_exists("layout/" . $camp_layout . "/img/" . $logo_top)) {
					$log_img = '<img class="logo_img" style="max-height: 32px;float: left;" src="layout/' . $camp_layout . '/img/' . $logo_top . '?v=3" border="0" />&nbsp;';
				}
			
		}

		//echo $site_title;
		$logo_title = "<a class='brand' href='javascript:void(0);' style='text-decoration:none !important'>";
		if ($style_type == 'light') {
			$logo_title .= '<font color="' . $camp_theme_color . '">' . $site_title . '</font>';
		} else {
			$logo_title .= $site_title;
		}
		$logo_title .= "</a>";
	}

	?>

	<?php

	$page_names = $package_functions->getOptions('HEADER_PAGE_NAMES', $system_package);

	if ($property_wired == 1) {
		$wifi_text = 'Network';
	} else {
		$wifi_text = __WIFI_TEXT__;
	}
	$txt_replace = array(

		'{$wifi_txt}' => __WIFI_TEXT__,
		'{$theme}' =>  ucwords(__THEME_TEXT__)
	);

	$page_names = strtr($page_names, $txt_replace);

	$page_names_arr = json_decode($page_names, true);

	if ($property_wired == 1) {
		$page_names_arr['WiFi Network Information'] = "Network Information";
	}

	if ($user_type == "TECH") {
		$new_design = 'yes';
		$top_menu = 'bottom';
		$page_intro = 'YES';
	}

	$navbar = 'layout/' . $camp_layout . '/views/header_navbar.php';

	if (($new_design == 'yes' || $SUBMENU_VERTICALE == 'yes') && file_exists($navbar)) {
		include_once $navbar;
	} else {
	?>

		<div class="navbar navbar-fixed-top" <?php if ($top_menu == 'bottom') { ?> style="display: none;" <?php } ?>>
			<div class="navbar-inner">
				<div id="container_id" class="container">

					<?php

					if ($top_menu == 'bottom') {
						echo $log_img;
					}
					?>
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar show"></span>
						<span class="icon-bar show"></span>
						<span class="icon-bar show"></span>
					</a>
					<?php
					if ($top_menu != "bottom") {

						echo $log_img;
						echo $logo_title;
					}

					
					if($_SESSION['SADMIN'] == 'SADMIN') {
						//./change_portal
					?>
					<div>
						<ul class="topnav">
							<li><a href="./change_portal?section=ADMIN">Admin</a></li>
							<li><a href="./change_portal?section=MNO">Operations</a></li>
							<li><a href="./change_portal?section=PROVISIONING">Provisioning</a></li>
						</ul>
					</div>
					<?php } ?>
					<div class="nav-collapse">
						<ul class="nav pull-right">
							<?php
							$menutype = $db_class1->setVal('menu_type', 'ADMIN'); //echo NOW ONLY HAVE SUB MENU ;
						
							if ($menutype == "SUB_MENU") {
								foreach ($main_mod_array as $keym => $valuem) {
									if ($main_menu_clickble == "NO") {

										$main_menu_name2 = $valuem['name'];
										$modarray = $valuem['module'];
										ksort($modarray);
										foreach ($modarray as $keyZ => $valueZ) {

											if (strlen($link_main_m_multy) == 0)
												$link_main_m_multy =  $valueZ['link'];
											$sub_menu_new_link =  $valueZ['nw_link'];
										}

										if (strlen($page_names_arr[$main_menu_name2]) > 0) {
											$main_menu_name2 = $page_names_arr[$main_menu_name2];
										}

										if ($sub_menu_new_link == 1) {
											echo '<li id="sysmenu' . $keym . '" class="dropdown sysmenu1" style="display: none;">
            								<a href="' . $link_main_m_multy . '" class="dropdown-toggle" data-toggle="dropdown"> ' . $main_menu_name2 . '<b class="caret"></b></a>';
										} else {
											echo '<li id="sysmenu' . $keym . '" class="dropdown sysmenu1" style="display: none;">
											<a href="' . $link_main_m_multy . $extension . '" class="dropdown-toggle" data-toggle="dropdown"> ' . $main_menu_name2 . '<b class="caret"></b></a>';
										}

										echo '<ul class="dropdown-menu">';

										$link_main_m_multy = '';

										foreach ($modarray as $keyY => $valueY) {
											$sub_menu_link = $valueY['link'];
											$sub_menu_name = $valueY['name'];
											$sub_menu_new_link =  $valueY['nw_link'];

											if (strlen($page_names_arr[$sub_menu_name]) > 0) {
												$sub_menu_name = $page_names_arr[$sub_menu_name];
											}

											if ($sub_menu_new_link == 1) {
												echo '<li><a href="' . $sub_menu_link . '"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
											} else {
												echo '<li><a href="' . $sub_menu_link . $extension . '"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
											}
										}
										echo '</ul>';

										echo '<li>';
									} else {

										/// Single Item

										if (sizeof($valuem['module']) == 1) {
											foreach ($valuem['module'] as $keyY => $valueY) {
												$link_main_m =  $valueY['link'];
												$menu_item_row_id = $valueY['menu_item'];
											}
											$main_menu_name = $valuem['name'];

											if (strlen($page_names_arr[$main_menu_name]) > 0) {
												$main_menu_name = $page_names_arr[$main_menu_name];
											}

											echo '<li id="sysmenu' . $keym . '" class="dropdown sysmenu1" style="display: none;">
          									<a href="' . $link_main_m . $extension . '" class="dropdown-toggle" > ' . $main_menu_name . '</a></li>';
										}

										/// Multy Item


										else {
											$main_menu_name2 = $valuem['name'];
											$modarray = $valuem['module'];

											ksort($modarray);


											foreach ($modarray as $keyZ => $valueZ) {

												if (strlen($link_main_m_multy) == 0)
													$link_main_m_multy =  $valueZ['link'];
											}

											if (strlen($page_names_arr[$main_menu_name2]) > 0) {
												$main_menu_name2 = $page_names_arr[$main_menu_name2];
											}


											echo '<li id="sysmenu' . $keym . '" class="dropdown sysmenu1" style="display: none;">
            								<a href="' . $link_main_m_multy . $extension . '" class="dropdown-toggle" data-toggle="dropdown"> ' . $main_menu_name2 . '<b class="caret"></b></a>';


											echo '<ul class="dropdown-menu">';

											$link_main_m_multy = '';

											foreach ($modarray as $keyY => $valueY) {
												$sub_menu_link = $valueY['link'];
												$sub_menu_name = $valueY['name'];
												$sub_menu_new_link =  $valueY['nw_link'];

												if (strlen($page_names_arr[$sub_menu_name]) > 0) {
													$sub_menu_name = $page_names_arr[$sub_menu_name];
												}

												if ($sub_menu_new_link == 1) {
													echo '<li><a href="' . $sub_menu_link . '"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
												} else {
													echo '<li><a href="' . $sub_menu_link . $extension . '"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
												}
											}
											echo '</ul>';

											echo '<li>';
										}
									}
								}
							}

							?>

							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-user"></i> <?php echo $full_name; ?> <b class="caret"></b></a>

								<ul class="dropdown-menu">
									<?php

									if ($script != 'verification') {
										if (!(isset($_SESSION['p_token']))) {
											if ($no_profile != '1') {
									?>
												<li><a href="profile<?php echo $extension; ?>">My Profile</a></li>
									<?php }
										}
									} ?>

									<?php if ($session_logout_btn_display != 'none') { ?>

										<li><a href="#" id="logout_1">Logout </a></li>

									<?php } ?>
									<script type="text/javascript">
										$(document).ready(function() {
											$("#logout_1").click(function(event) {
												$('#logout-check-div').show();
												$('#sess-front-div').show();
												//clearInterval(intrval_func);
												//window.location = 'logout.php?doLogout=true';
											});
										});
									</script>

									<?php if ($_SESSION['s_token']) { ?>

										<li>
											<a href="support<?php echo $extension; ?>?back_sup=true"><?php if ($ori_user_type == 'SALES') {
																											echo "Back to Sales";
																										} else {
																											echo "Back to Support";
																										} ?></a>
										</li>

									<?php } ?>

									<?php

									if (isset($_SESSION['p_token'])) { ?>

										<li>
											<a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a>
										</li>

									<?php } ?>

								</ul>


							</li>
						</ul>

					</div>
					<!--/.nav-collapse -->
				</div>
				<!-- /container -->
			</div>
			<!-- /navbar-inner -->
		</div>







		<?php // SECOND MENU START
		//if verification
		// && !isset($_GET['section'])

		if ($script != 'verification') {

		?>
			<!-- /navbar -->
			<div class="subnavbar" id="subnavbar_id">
				<div class="subnavbar-inner">
					<div class="container">
						<ul class="mainnav">

							<?php

							if ($menutype == "SUB_MENU") {

								if ($top_menu == "bottom") {
									echo '<li class="no_arrow" style="line-height:60px; margin-right: 10px">' . $log_img . '</li>';
									echo '<style> .logo_img{ max-height: 40px !important; float: none !important; } </style>';
								} else {
									echo '<style> .logo_img{ margin-top: 8px } </style>';
								}

								$mod_size_arr = sizeof($main_mod_array);

								if ($top_menu == "bottom") {
									$mod_size_arr = $mod_size_arr + 2;
								}
								if ($mod_size_arr < 5) {
									$mod_size_arr = 5;
								}
								if ($mod_size_arr > 6) {
									$mod_size_arr = 6;
								}
								$width_li = intval(99) / $mod_size_arr . '%';
								//$width_li = intval(99)/intval(sizeof($main_mod_array));

								/* 	if($user_type=="MNO" || $user_type=="ADMIN"){
										$width_li = "19.8%";
									}
									else{
										$width_li = "16.5%";
									} */


								if ($style_type != 'light')
									$camp_theme_color = '#fff';

								$numItems = count($main_mod_array);
								$i = 0;
								foreach ($main_mod_array as $keym => $valuem) {
									if (++$i === $numItems) {
										//$css_right = 'border-right: 1px solid #d9d9d9;';
										$css_right = '';
									}
									if (strlen($valuem['active'])) {
										$scrpt_active_status = ' class="active"';
									} else {
										$scrpt_active_status = '';
									}


									if ($main_menu_clickble == "NO") {

										$main_menu_name2 = $valuem['name'];
										$modarray = $valuem['module'];
										ksort($modarray);
										foreach ($modarray as $keyZ => $valueZ) {

											if (strlen($link_main_m_multy) == 0)
												$link_main_m_multy =  $valueZ['link'];
										}

										if (strlen($page_names_arr[$main_menu_name2]) > 0) {
											$main_menu_name2 = $page_names_arr[$main_menu_name2];
										}

										echo '<li id="sami_' . $keym . '" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: ' . $width_li . ';' . $css_right . '" ' . $scrpt_active_status . '>
											<a id="hot_a" style="cursor: default">
											<span style="font-size: 16px;max-width: 126px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">' . $main_menu_name2 . '</span> </a>';

										if (sizeof($valuem['module']) == 1) {
											$style_tag1 = "min-width: 100%;width: auto";
											$style_tag2 = 'white-space: nowrap';
											$add_class = "single";
										} else {
											$style_tag1 = "";
											$add_class = "multi";
										}
										echo '<ul id="sami_' . $keym . 'a" style="display: none;list-style-type: none;position: absolute; background-color: ' . $camp_theme_color . ';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);' . $style_tag1 . '">';
										$link_main_m_multy = '';

										foreach ($modarray as $keyY => $valueY) {
											$sub_menu_link = $valueY['link'];
											$sub_menu_new_link = $valueY['nw_link'];
											$sub_menu_name = $valueY['name'];


											if (strlen($page_names_arr[$sub_menu_name]) > 0) {
												$sub_menu_name = $page_names_arr[$sub_menu_name];
											}

											if ($sub_menu_new_link == 1) {
												echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;' . $style_tag1 . '">
            									<a href="' . $sub_menu_link . '"  target="_blank"  class="new ' . $add_class . '" style="padding:5px;' . $style_tag2 . '">' . $sub_menu_name . '</a></li>';
											} else {
												echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px;' . $style_tag1 . '">
            								<a href="' . $sub_menu_link . $extension . '" class="new ' . $add_class . '" style="padding:5px;' . $style_tag2 . '">' . $sub_menu_name . '</a></li>';
											}
										}

										echo '</ul> </li>';
									} else {
										/// Single Item

										if (sizeof($valuem['module']) == 1) {
											//print_r($valuem['module']);
											foreach ($valuem['module'] as $keyY => $valueY) {
												$link_main_m =  $valueY['link'];
												$menu_item_row_id = $valueY['menu_item'];
											}
											$main_menu_name = $valuem['name'];

											$main_menu_name = $package_functions->getPageName($link_main_m, $system_package, $main_menu_name);

											if ($scrpt_active_status == '') {
												$scrpt_active_status = ' class="no_arrow"';
											} else {
												$scrpt_active_status = ' class="active no_arrow"';
											}

											if (strlen($page_names_arr[$main_menu_name]) > 0) {
												$main_menu_name = $page_names_arr[$main_menu_name];
											}

											echo '<li style="width: ' . $width_li . ';' . $css_right . '" ' . $scrpt_active_status . '>
											<a id="dash_' . $keym . '" href="' . $link_main_m . $extension . '">
											<span style="font-size: 16px;max-width: 120px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">' . $main_menu_name . '</span> </a></li>';
										}

										/// Multy Item
										else {
											$main_menu_name2 = $valuem['name'];
											$modarray = $valuem['module'];
											ksort($modarray);
											foreach ($modarray as $keyZ => $valueZ) {

												if (strlen($link_main_m_multy) == 0)
													$link_main_m_multy =  $valueZ['link'];
											}

											$main_menu_name2 = $package_functions->getPageName($link_main_m_multy, $system_package, $main_menu_name2);

											if (strlen($page_names_arr[$main_menu_name2]) > 0) {
												$main_menu_name2 = $page_names_arr[$main_menu_name2];
											}


											echo '<li id="sami_' . $keym . '" onmouseover="mOver(this)" onmouseout="mOut(this)" style="width: ' . $width_li . ';' . $css_right . '" ' . $scrpt_active_status . '>
												<a id="hot_a" href="' . $link_main_m_multy . $extension . '">
												<span style="font-size: 16px;max-width: 126px;display: -ms-inline-flexbox;display: inline-flex;-ms-flex-align: center;height: 100%;align-items: center;line-height: 24px;">' . $main_menu_name2 . '</span> </a>';


											echo '<ul id="sami_' . $keym . 'a" style="display: none;list-style-type: none;position: absolute; background-color: ' . $camp_theme_color . ';height: 30px; margin-left: -1.5px;border-width: 1px; border-style: solid; border-color: rgb(217, 217, 217);">';
											$link_main_m_multy = '';

											foreach ($modarray as $keyY => $valueY) {
												$sub_menu_link = $valueY['link'];
												$sub_menu_new_link = $valueY['nw_link'];
												$sub_menu_name = $valueY['name'];


												if (strlen($page_names_arr[$sub_menu_name]) > 0) {
													$sub_menu_name = $page_names_arr[$sub_menu_name];
												}

												if ($sub_menu_new_link == 1) {
													echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            									<a href="' . $sub_menu_link . '"  target="_blank"  class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
												} else {
													echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            									<a href="' . $sub_menu_link . $extension . '" class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
												}
											}

											echo '</ul> </li>';
										}
									}
								}
							}

							if ($top_menu == 'bottom') {

								$full_name = trim($full_name);

								if (strlen($full_name) > 15) {

									//$full_name1 = str_replace(" ","<br>",$full_name);
									$full_name1_arr = explode(" ", $full_name);

									if (sizeof($full_name1_arr) == 2) {

										$full_name1 = $full_name1_arr[0] . '<br>' . $full_name1_arr[1];
									} else {

										$full_name1 = substr_replace($full_name, "<br>", 13, 0);
									}
									$li_style = "float: right; ";
									$a_style = "text-align: left;padding-right: 0px !important;margin-top: 10px";
									$b_style = "margin-top: -2px;margin-left: 8px;";
								} else {
									$full_name1 = $full_name;
									$li_style = "float: right; line-height: 60px;";
									$a_style = "text-align: left;padding-right: 0px !important";
									$b_style = "margin-top: 28px;margin-left: 8px;";
								}
							?>
								<li class="dropdown" style="<?php echo $li_style; ?>"><a style="<?php echo $a_style; ?>" href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="icon-user"></i> <?php echo $full_name1; ?> <b style="<?php echo $b_style; ?>" class="caret"></b></a>
									<ul class="dropdown-menu" style="left: -70px">
										<?php

										if ($script != 'verification') {

											if (!(isset($_SESSION['p_token']))) {
												if ($no_profile != '1') {
										?>
													<li><a href="profile<?php echo $extension; ?>">My Profile</a></li>
										<?php }
											}
										}
										?>


										<?php if ($session_logout_btn_display != 'none') { ?>

											<li><a href="#" id="logout_2">Logout</a></li>

										<?php } ?>
										<!-- <li><a href="javascript:void(0);" id="logout_1">Logout</a></li> -->
										<script type="text/javascript">
											$(document).ready(function() {
												$("#logout_2").click(function(event) {
													$('#logout-check-div').show();
													$('#sess-front-div').show();

													//window.location = 'logout.php?doLogout=true';
												});
											});
										</script>

										<?php if ($_SESSION['s_token']) { ?>

											<li>
												<a href="support<?php echo $extension; ?>?back_sup=true"><?php if ($ori_user_type == 'SALES') {
																												echo "Back to Sales";
																											} else {
																												echo "Back to Support";
																											} ?></a>
											</li>


										<?php } ?>

										<?php if ($_SESSION['p_token']) { ?>

											<li>
												<a href="properties<?php echo $extension; ?>?back_master=true">Back to Properties Page</a>
											</li>


										<?php } ?>
									</ul>


								</li>

							<?php } ?>

						</ul>




					</div>
				</div>

			</div>

			
	<?php }
	}



	if ($_SESSION['s_token']) {
		echo '<input type="hidden" value="s_token" id="logout_type">';
	}
	if ($_SESSION['p_token']) {
		echo '<input type="hidden" value="p_token" id="logout_type">';
	}


	if ($new_design == 'yes') {

		if ($page_intro == "YES" && ($introMnoPage != 'NO')) {

			$page_intro_url = 'layout/' . $camp_layout . '/views/intro_page.php';

			if (file_exists($page_intro_url)) {
				include_once 'layout/' . $camp_layout . '/views/intro_page.php';
			}
		}
	}

	//print_r($page_names);

	?>



	<script type="text/javascript">
		$(window).on("load resize", function() {
			dropdown();
		});

		$(window).on("load", function() {
			try {

				<?php if ($new_design != 'yes' && $SUBMENU_VERTICALE != 'yes') { ?>

					document.getElementById($(".mainnav li.active ul").attr('id')).style.display = "block";

				<?php } ?>

			} catch (err) {}
		});
	</script>



	<script>
		var x = window.innerWidth;

		function mOver(obj) {
			if (x > 600) {

				try {


					$(".mainnav li.active ul").hide();
					$(".mainnav li.active").removeClass('no_arrow1');

					<?php if ($new_design != 'yes') { ?>

						if (obj.id + "a" != $(".mainnav li.active ul").attr('id')) {
							$(".mainnav li.active").addClass('no_arrow1');
						}

					<?php } else {
						echo '$(".mainnav li.active").addClass("no_arrow1");';
					} ?>

					document.getElementById(obj.id + "a").style.display = "block";

				} catch (err) {}

			}

		}

		function mOut(obj) {

			if (x > 600) {


				try {

					<?php if ($new_design != 'yes' && $SUBMENU_VERTICALE != 'yes') { ?>

						document.getElementById($(".mainnav li.active ul").attr('id')).style.display = "block";
						$(".mainnav li.active").removeClass('no_arrow1');
						if (obj.id + "a" != $(".mainnav li.active ul").attr('id')) {
							document.getElementById(obj.id + "a").style.display = "none";

						}

					<?php } else { ?>

						$(".mainnav li.active").removeClass('no_arrow1');
						document.getElementById(obj.id + "a").style.display = "none";

					<?php } ?>



				} catch (err) {

					document.getElementById(obj.id + "a").style.display = "none";

				}
			}

		}
	</script>

	<br class="rwd-break4">

	</div>


	<div id="sess-front-div" class="ui-widget-overlay ui-front" style="display: none; z-index: 100;"></div>
	<style type="text/css">
		@media only screen and (max-width: 520px) {
			#sess-check-div {
				width: auto !important;
			}
		}

		/* @media only screen and (max-width: 414px) {
	#sess-check-div{
		margin-left: -207px !important;
	}
}
@media only screen and (max-width: 375px) {
	#sess-check-div{
		margin-left: -188px !important;
	}
}
@media only screen and (max-width: 320px) {
	#sess-check-div{
		margin-left: -160px !important;
	}
} */

		@media only screen and (max-width: 414px) {
			#servicearr-check-div {
				margin-left: -207px !important;
			}
		}

		@media only screen and (max-width: 375px) {
			#servicearr-check-div {
				margin-left: -188px !important;
			}
		}

		@media only screen and (max-width: 320px) {
			#servicearr-check-div {
				margin-left: -160px !important;
			}
		}
	</style>

	<?php
	/*$session_logout_btn_display = $package_functions->getOptions('SESSION_LOGOUT_BUTTON_DISPLAY',$system_package);*/

	if ($session_logout_btn_display != 'none') {
		$session_logout_btn_display = 'inline-block';
		$msg = '<label id="extend-time"><label> ';
		$style = 'margin-left: -250px;';
	} else {
		$msg = 'Your managed Wi-Fi session has expired. Please refresh the page.';
		$style = 'margin-left: -300px;';
	}

	?>

	<div id="sess-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="z-index: 9999999999999999999999;height: auto; width: 450px; top: 55px; left: 50%; display: none;top: 30%; position: fixed; <?php echo $style; ?>">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span id="ui-id-4" class="ui-dialog-title"></span>

		</div>
		<div class="dialog confirm ui-dialog-content ui-widget-content" id="ui-id-3" style="display: block; width: auto; min-height: 67px; max-height: 0px; height: auto;">
			<?php echo $msg; ?>
		</div>
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
			<div class="ui-dialog-buttonset">
				<button style="display: <?php echo $session_logout_btn_display ?>" id="sess-extend-submit" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text"> EXTEND</span>
				</button>
				<button style="display: <?php echo $session_logout_btn_display ?>" id="sess-check-submit" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text"> LOG OUT</span>
				</button>
			</div>
		</div>
	</div>

	<div id="servicearr-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="z-index: 9999999999999999999999;height: auto; width: auto; top: 55px; left: 50%; display: none;top: 30%; position: fixed;  max-width:35%; <?php echo $style; ?>">
		<div id="header_msg" class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span id="ui-id-4" class="ui-dialog-title"></span>

		</div>
		<div class="dialog confirm ui-dialog-content ui-widget-content" id="ap_id" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto; text-align: center;">
		</div>
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
			<div class="ui-dialog-buttonset">
				<button style="display: none" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text"></span>
				</button>
				<button style="display: block;" id="servicearr-check-submit" onclick="hidediv();" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text"> OK</span>
				</button>
			</div>
		</div>
	</div>


	<!-- log_out -->

	<div id="logout-check-div" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons ui-draggable" tabindex="-1" role="dialog" aria-describedby="ui-id-3" aria-labelledby="ui-id-4" style="height: auto; width: auto; top: 55px; left: 50%; display: none;top: 30%; position: fixed; margin-left: -260px; z-index: 9999999999999999999999; ">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
			<span id="ui-id-2" class="ui-dialog-title">Logout</span>
			<button type="button" id="log_close" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" aria-disabled="false" title="close">
				<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">close</span></button>
		</div>
		<div class="dialog confirm ui-dialog-content ui-widget-content" id="ui-id-3" style="display: block; width: auto; min-height: 0px; max-height: 0px; height: auto;">
			Are you sure you want to Logout?
		</div>
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
			<div class="ui-dialog-buttonset">
				<button type="button" id="log_no" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text">Cancel</span></button>
				</button>
				<button id="log_yes" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text">Confirm</span>
				</button>
			</div>
		</div>
	</div>

	<?php


	//setcookie("system_package", $system_package, time() + (86400 * 30), "/");
	//setcookie("load_login_design", $load_login_design, time() + (86400 * 30), "/");

	?>

	<style>
		@media (max-width: 520px) {
			#logout-check-div {
				left: auto !important;
				margin: 10px !important;
			}
		}
	</style>


	<script>
		$(document).ready(function() {



			$("#log_no").click(function(event) {
				$('#logout-check-div').hide();
				$('#sess-front-div').hide();


				//clearInterval(intrval_func);
				//window.location = 'logout<?php echo $extension; ?>?doLogout=true';
			});

			$("#log_close").click(function(event) {
				$('#logout-check-div').hide();
				$('#sess-front-div').hide();
				//clearInterval(intrval_func);
				//window.location = 'logout<?php echo $extension; ?>?doLogout=true&login=<?php echo $load_login_design; ?>';
			});

			$("#log_yes").click(function(event) {

				var logout_type = $('#logout_type').val(); //p_token or s_token

				if (logout_type == 'p_token') {
					window.location = 'properties<?php echo $extension; ?>?back_master_logout=true';
				} else if (logout_type == 's_token') {
					window.location = 'support<?php echo $extension; ?>?back_sup_logout=true';
				} else {
					window.location = 'logout<?php echo $extension; ?>?doLogout=true&product=<?php echo $system_package; ?>&login=<?php echo $load_login_design; ?>';
				}

			});
		});
	</script>
	<?php if ($script != 'tech') {

		$logout_time_key_string = "logout=true";
		$ses_down_key =  cryptoJsAesEncrypt($data_secret, $logout_time_key_string);
		$ses_down_key =  urlencode($ses_down_key);
		if (strlen($logout_time) < 1) {
			$logout_time = trim($db_class1->setVal('session_logout_time', 'ADMIN'));
		}
	?>
		<script>
			function hidediv() {
				$('#servicearr-check-div').hide();
				$('#sess-front-div').hide();
			}

			function getCookie(cname) {
				var name = cname + "=";
				var decodedCookie = decodeURIComponent(document.cookie);
				var ca = decodedCookie.split(';');
				for (var i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) == ' ') {
						c = c.substring(1);
					}
					if (c.indexOf(name) == 0) {
						return c.substring(name.length, c.length);
					}
				}
				return "";
			}

			function Logout(logOutTime) {

				var url;
				var intrval_func = setInterval(function() {
					var timeoutCookie = getCookie('timeout');
					if (timeoutCookie.length < 1) {
						timeoutCookie = 0;
					}
					var timeout = parseInt(timeoutCookie) * 1000;
					var now = Date.now();
					var sessionLife = now - timeout;
					if (sessionLife > logOutTime) {

						url = "ajax/check_session.php";

						$.post(url, {
							'key': '<?php echo $ses_down_key; ?>'
						}, function(data) {
							data = JSON.parse(data);
							if (data.status == 'success') {
								$('#sess-check-div').show();
								$('#sess-front-div').show();
								clearInterval(intrval_func);
							}

						});
					}
				}, 1000);

			}

			function extendTime(logOutTime) {
				var extend = 15;
				var z = extend;
				var url;
				logOutTime = logOutTime - 15 * 1000;
				var intrval_func_extend = setInterval(function() {

					var timeoutCookie = getCookie('timeout');
					if (timeoutCookie.length < 1) {
						timeoutCookie = 0;
					}
					var timeout = parseInt(timeoutCookie) * 1000;
					var now = Date.now();
					var sessionLife = now - timeout;
					if (sessionLife > logOutTime) {
						$('#extend-time').html('Your session is about to expire<br><br><label style="font-size: 14px !important;color: #ababab;">You will be automatically logged out in ' + z + ' seconds</label>');
						$('#sess-check-div').show();
						$('#sess-front-div').show();
						if (z == 5) {
							$('#sess-extend-submit').hide();
						}
						if (z == 0) {
							url = "ajax/check_session.php";

							$.post(url, {
								'key': '<?php echo $ses_down_key; ?>'
							}, function(data) {
								data = JSON.parse(data);
								if (data.status == 'success') {
									$('#sess-extend-submit').hide();
									$('#extend-time').html('Your session has expired. Please click OK to log in again<br><br>');
									$('#sess-check-submit').html('<span class="ui-button-text"> OK</span>');
									clearInterval(intrval_func_extend);
								}

							});
						}
						z--;

					}
				}, 1000);
			}

			$(document).ready(function() {
				var logOutTime = <?php echo $logout_time; ?>;
				logOutTime = logOutTime * 60 * 1000;

				setTimeout(function() {
					extendTime(logOutTime);
				}, 1000);

				$("#sess-extend-submit").click(function(event) {
					setCookie();
					$('#sess-check-div').hide();
					$('#sess-front-div').hide();
				});
				$("#sess-check-submit").click(function(event) {

					var logout_type = $('#logout_type').val(); //p_token or s_token

					if (logout_type == 'p_token') {
						window.location = 'properties<?php echo $extension; ?>?back_master_logout=true';
					} else if (logout_type == 's_token') {
						window.location = 'support<?php echo $extension; ?>?back_sup_logout=true';
					} else {
						window.location = 'logout<?php echo $extension; ?>?doLogout=true&product=<?php echo $system_package; ?>&login=<?php echo $load_login_design; ?>';
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(function() {
				$(".one_tab").find("a").addClass('one_tab')
			});
		</script>
	<?php

	}


	/* require_once dirname(__FILE__).'/DTO/User.php';
require_once dirname(__FILE__).'/models/userMainModel.php';
$User = new User();
$user_model = new userMainModel();
$un =$_SESSION['user_name'];
$_SESSION['login_user'] = serialize($user_model->loginUser_Data($un)); */
	?>

	<script type="text/javascript">
		$(document).ready(function() {
			$('a[data-toggle="tab"]').on('click', function(e) {
				$("div").not(".all_na").remove('.alert');

			});
		});
	</script>