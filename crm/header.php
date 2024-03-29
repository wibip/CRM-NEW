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

<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>

<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">



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

require_once 'classes/AccessController.php';
require_once 'classes/AccessUser.php';
$acccessController = new AccessController($db,unserialize($_SESSION['access_user']));

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


$user_distributor = $db_class1->getValueAsf("SELECT  user_distributor AS f  FROM  admin_users WHERE user_name = '$s_uname' LIMIT 1");


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
$key_query = "SELECT  `access_role`, user_type, user_distributor,is_enable,full_name
	FROM  admin_users WHERE user_name = '$user_name' LIMIT 1";



$query_results = $db_class1->select1DB($key_query);
//while($row=mysql_fetch_array($query_results)){
$access_role = $query_results['access_role'];
$user_type = $query_results['user_type'];
$user_distributor = $query_results['user_distributor'];
if (strlen($full_name) == 0) {
	$full_name = $query_results['full_name'];
}
$active_user = $query_results['is_enable'];


// echo '-----------------<<<<<<<'.$_REQUEST['show'];
// echo '-----------------<<<<<<<'.$_REQUEST['ud'];
/* change user_distributor if conditions applied */
if($_SESSION['SADMIN'] && isset($_REQUEST['show']) && $_REQUEST['show'] == 'clients'){
	$user_distributor = $_REQUEST['ud'];
	$_SESSION['ud'] = $_REQUEST['ud'];
	$user_type = $_REQUEST['ut'];
	$_SESSION['ut'] = $_REQUEST['ut'];
}

$_SESSION['user_distributor'] = $user_distributor;

if ($_SESSION['login'] == 'yes') {

	if ($active_user != 1) {

		header('location: ' . 'logout' . $extension . '?doLogout=true&login=' . $login_design);
		exit();
	}
	
}

//////// System Packages and features
$system_package = $db_class1->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

//message class
require_once 'classes/messageClass.php';
$message_functions = new message_functions($system_package);

//////// End System Packages and features
$login_design = $package_functions->getSectionType("LOGIN_SIGN", $system_package);
$camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $system_package);


$session_logout_btn_display = $package_functions->getOptions('SESSION_LOGOUT_BUTTON_DISPLAY', $system_package);
$logout_time = $package_functions->getOptions('SESSION_LOGOUT_TIME', $system_package);


if (strlen($camp_layout) == "0") {
	$camp_layout = "DEFAULT_LAYOUT";
}

require_once 'layout/' . $camp_layout . '/index.php';
include_once 'layout/' . $camp_layout . '/define.php';


//////// Get Main Valiables //////////

$base_url = trim($db_class1->setVal('portal_base_url', 'ADMIN'), "/");
$base_folder = trim($db_class1->setVal('portal_base_folder', 'ADMIN'), "/");
$getSectionType = $package_functions->getSectionType("HADER_OPTIONS", $system_package, $user_type);




// New Access Functions
// function isModuleAccess($access_role, $module, $db_function)
// {
// 	$sql1 = "SELECT `module_name` FROM `admin_access_roles_modules` WHERE `access_role` = '$access_role' AND `module_name` = '$module' LIMIT 1";
// 	// var_dump($sql1);
// 	$result = $db_function->selectDB($sql1);
// 	// print_r($result);
// 	//$row_count = mysql_num_rows($result);
// 	if ($result['rowCount'] > 0) {
// 		return true;
// 	} else {
// 		return false;
// 	}
// }

// Menu Design
$originalUserType = $user_type;
$originalAccessRole = $access_role;
$originalSystemPackage = $system_package;

// $user_type = ($user_type == 'SADMIN') ? 'ADMIN' : $user_type;
// $access_role = ($user_type == 'SADMIN') ? 'ADMIN' : $access_role;
// $system_package = ($user_type == 'SADMIN') ? 'GENERIC_ADMIN_001' : $system_package;
$dropdown_query1 = "SELECT DISTINCT module_name,menu_item FROM `admin_access_modules`";// WHERE user_type = '$user_type'";
// echo $dropdown_query1;
$query_results_drop1 = $db_class1->selectDB($dropdown_query1);
// var_dump($query_results_drop1);
foreach ($query_results_drop1['data'] as $row) {
	if ($row['menu_item'] == 3) {
		$x_non_admin[] = $row['module_name']; // Non Admin Roles
	} else {
		$x[] = $row['module_name']; // Retuns base access
	}
}
// echo '------------<br/>';
// var_dump($x);
// echo '------------<br/>';

foreach ($x as $keyX => $valueX) {
	/* if (strtoupper($access_role) != 'ADMIN' && strlen($access_role) > '0') {
		
		if (!(isModuleAccess($access_role, $valueX, $db_class1))) {
			try {
				// echo '>>>>>>>>>>>>>>>>>'.$access_role.'>>>>>>';
				// echo $valueX;
				// echo '------------<br/>';
				// var_dump($x[$keyX]);
				// unset($x[$keyX]);
				// echo '++++++++++++<br/>';
			} catch (Exception $e) {
			}
		}
	} */
	
}

// echo '------------<br/>';
// var_dump($x);

// if($_SESSION['SADMIN'] == true) {
// 	array_push($x,"operation_list");
// 	array_push($x,"change_portal");
// }


/// Non Admin Modules
foreach ($x_non_admin as $keyXn => $valueXn) {
	if (strtoupper($access_role) != 'ADMIN' && strlen($access_role) > '0') {
		if ($acccessController->moduleAccess($module)) {
			// if ($package_functions->getPageFeature($valueXn, $system_package) == '1') {
				$x[] = $valueXn;
			// }
		}
	}
}
// echo '------------<br/>';
// var_dump($x);
// echo "<<<<<<  Step 06 >>>>>";
// die;
$allowed_pages = $x;

$module_ids = join('", "', $x);
$suspended = false;

require_once 'layout/' . $camp_layout . '/config.php';

$query_modules = "SELECT * FROM `admin_access_modules` group by `module_name`";
// echo $query_modules;
// var_dump($module_ids);
// var_dump($user_type);
$query_results_mod = $db_class1->selectDB($query_modules);
// var_dump($query_results_mod);
// die;
//$network_type=$db_class1->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

// $restricted_pages = $package_functions->getOptions("RESTRICTED_PAGES", $system_package);

$tmp_0 = '';
$main_mod_array = array();
foreach ($query_results_mod['data'] as $row1) {
	
	$menu_item_row = $row1['menu_item']; // Retuns base access.
	$main_module_order = $row1['main_module_order'];
	$main_module = $row1['main_module'];
	$module_name = $row1['module_name'];
	$order = $row1['order'];
	$name_group = $row1['name_group'];
	$is_enable = $row1['is_enable'];

	if (!$acccessController->moduleAccess($module_name)){ continue; }


	/*

	menu item = 1 => Menu
	menu item = 0 => Non Menu
	menu item = 2 => Support
	menu item = 3 => Non Admin Items // On Role
	menu item = 4 => FAQ Support
	menu item = 5 => FAQ Property owner with non Support login
	menu item = 6 => User Guide

	*/
	// echo 'Before: ';
	// var_dump($main_mod_array);
	// echo '<br/>menuItem';
	// var_dump($menu_item_row);
	// echo '<br/>';
	// echo '<br/>';
	if ($is_enable == 1) {
		if ($menu_item_row == '1') {
			$access_modules_list[] = $module_name;
			$main_mod_array[$main_module_order]['name'] = $main_module;
			if ($script == $module_name) {
				$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
			}
			$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
			$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
			$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;


		} else if ($menu_item_row == '2') {

			$access_modules_list[] = $module_name;
			$main_mod_array[$main_module_order]['name'] = $main_module;
			if ($script == $module_name) {
				$main_mod_array[$main_module_order]['active'] = $module_name; // Return Active Module
			}
			$main_mod_array[$main_module_order]['module'][$order]['link'] = $module_name;
			$main_mod_array[$main_module_order]['module'][$order]['name'] = $name_group;
			$main_mod_array[$main_module_order]['module'][$order]['menu_item'] = $menu_item_row;
			
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
			
		} else if ($menu_item_row == '5') {
			//echo "<br>".$main_module." "."5";

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
		}  else if ($menu_item_row == '8') {

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
			
		} else if ($menu_item_row == '9') {

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
ksort($main_mod_array);
// echo 'After: ';
	// print_r($main_mod_array);
// 	echo '<br/>';
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
	
	
}
/////////////////////////////////////////////////////////
// End SECURITY POINT -- Verify the customer is correct
//////////////////////////////////////////////////////////




////////////////////
////// Coloring/////

$camp_theme_color = '#00ba8b'; // Default Color

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


$user_timezone = $db_class1->getValueAsf("SELECT `timezone` AS f FROM `admin_users` WHERE `user_name`='$user_name'");
if (strlen($user_timezone) < 1) {
	if ($user_type == 'ADMIN') {
		$user_timezone = $db_class1->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='ADMIN'");
	} else {
		if ($user_type == 'MNO' || $user_type == 'SUPPORT' || $user_type == 'ordering_agent') {
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
$favicon_image = $row['favicon_image'];


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

	.ring {
		position:absolute;
		top:50%;
		left:50%;
		transform:translate(-50%,-50%);
		width:150px;
		height:150px;
		background:transparent;
		border:3px solid #3c3c3c;
		border-radius:50%;
		text-align:center;
		line-height:150px;
		font-family:sans-serif;
		font-size:15px;
		color:#fff000;
		letter-spacing:4px;
		text-transform:uppercase;
		text-shadow:0 0 10px #fff000;
		box-shadow:0 0 20px rgba(0,0,0,.5);
		z-index: 150;
	}
	.ring:before {
		content:'';
		position:absolute;
		top:-3px;
		left:-3px;
		width:100%;
		height:100%;
		border:3px solid transparent;
		border-top:3px solid #fff000;
		border-right:3px solid #fff000;
		border-radius:50%;
		animation:animateC 2s linear infinite;
	}
	.ring > span{
		display:block;
		position:absolute;
		top:calc(50% - 2px);
		left:50%;
		width:50%;
		height:4px;
		background:transparent;
		transform-origin:left;
		animation:animate 2s linear infinite;
	}
	.ring > span:before{
		content:'';
		position:absolute;
		width:16px;
		height:16px;
		border-radius:50%;
		background:#fff000;
		top:-6px;
		right:-8px;
		box-shadow:0 0 20px #fff000;
	}
	@keyframes animateC{
		0%
		{
			transform:rotate(0deg);
		}
		100%
		{
			transform:rotate(360deg);
		}
	}
	@keyframes animate{
		0%
		{
			transform:rotate(45deg);
		}
		100%
		{
			transform:rotate(405deg);
		}
	}

	#overlay {
		position: fixed; /* Sit on top of the page content */
		display: none; /* Hidden by default */
		width: 100%; /* Full width (cover the whole page) */
		height: 100%; /* Full height (cover the whole page) */
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0,0,0,0.5); /* Black background with opacity */
		z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
		cursor: pointer; /* Add a pointer on hover */
		z-index: 150;
	}
  
</style>

<title><?php
		$title_difiner = '_' . $script . '_PAGE_TITLE_';
		echo defined($title_difiner) ? constant($title_difiner) : constant('_page_title_') ?></title>

<script type="text/javascript">
	$(document).ready(function() {
		$('#overlay').css('display','none');
	});
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
	<div id="overlay">
		<div class="ring">Processing
			<span></span>
		</div>
	</div>

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
		$logo_top = $row["theme_logo"];
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
	} elseif ($user_type == 'SUPPORT' || $user_type == 'ordering_agent') {

		$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

		$row = $db_class1->select1DB($key_query);
		//while($row=mysql_fetch_array($query_results)){
		$logo_top = $row["theme_logo"];
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
		$logo_top = $row["theme_logo"];
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

	
$loggedMessage = 'You are logged in as ';

switch($user_type){
	case 'ADMIN':
		$loggedMessage .= 'Admin';
	break;
	case 'MNO':
		$loggedMessage .= 'Operation Admin';
	break;
	case 'ordering_agent':
		$loggedMessage .= 'Client';
	break;
	case 'SMAN':
		$loggedMessage .= 'Sales Manager';
	break;
	case 'SADMIN':
		$loggedMessage .= 'Super Admin';
	break;
}


	$navbar = 'layout/ARRIS/views/header_navbar.php';

	if (file_exists($navbar)) {
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

					
					// if($_SESSION['SADMIN'] == true) {
					?>
					<!-- <div>
						<ul class="topnav">
							<li class=< ?=((isset($_SESSION['section']) && $_SESSION['section']== "ADMIN") ? "active" : "")?>><a href="./change_portal?section=ADMIN">Admin</a></li>
							<li class=< ?=((isset($_SESSION['section']) && $_SESSION['section']== "MNO") ? "active" : "")?>><a href="./operation_list">Operations</a></li>
							<li class=< ?=((isset($_SESSION['section']) && $_SESSION['section']== "ordering_agent") ? "active" : "")?>><a href="./change_portal?section=ordering_agent">ordering_agent</a></li>
						</ul>
					</div> -->
					<?php //} ?>
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


									// foreach($valuem['module'] as $key=>$checkVal){
									// 	if(in_array( "Switch Accounts" ,$checkVal)){
									// 		unset($valuem['module'][$key]);
									// 	}
									// }

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
													if($sub_menu_name != 'Switch Accounts'){
														echo '<li id="li' . $keyY . '" style="float: left;margin-top:8px">
            												<a href="' . $sub_menu_link . $extension . '" class="new" style="padding:5px;">' . $sub_menu_name . '</a></li>';
													}
													
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

<?php


$acccessController->loadModule($script);
?>