<?php
session_start();

include_once '../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('theme');

header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
require_once '../classes/appClass.php';
$db = new db_functions();
$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}
$template_name = $_POST['template_name'];
$template_name1 = $_POST['template_name1'];
$reg_type = $_POST['reg_type'];
$image = $_POST['image'];
$realm= $_POST['rm'];

$template_name = htmlentities( urldecode($template_name), ENT_QUOTES, 'utf-8' );
$template_name1 = htmlentities( urldecode($template_name1), ENT_QUOTES, 'utf-8' );
$reg_type = htmlentities( urldecode($reg_type), ENT_QUOTES, 'utf-8' );
$image = htmlentities( urldecode($image), ENT_QUOTES, 'utf-8' );
$realm = htmlentities( urldecode($realm), ENT_QUOTES, 'utf-8' );

if ($image != $reg_type) {
	$preview_image=$image;
}else{
$preview_image=$db->getValueAsf("SELECT `preview_image` AS f FROM `exp_theme_manager` p WHERE `theme_code`='$reg_type' LIMIT 1");
if (strlen($preview_image)<1) {
	$preview_image=$reg_type;
}
}
$filename = '../'.$base_portal_folder.'/template/'.$template_name.'/img/'.$preview_image.'.jpg';
if (file_exists($filename)) {

    echo '<img id="preview_img" src="'.$base_portal_folder.'/template/'.$template_name.'/img/'.$preview_image.'.jpg?v=24" data-zoom-image="'.$base_portal_folder.'/template/'.$template_name.'/img/'.$preview_image.'.jpg?v=23" style="max-height:200px;width:60%;max-width: 100%;"><p><a id="pre_id" class="fancybox fancybox.iframe" href="'.$base_portal_folder.'/checkpoint.php?client_mac=DEMO_MAC&theme='.$template_name1.'&realm='.$realm.'">Preview Template Layout</a>';
    echo ":||:";
	 echo '<input type="hidden" value="done" id="checking">';
} else {
	echo "string";
	echo ":||:";
    echo '<input type="hidden" value="error" id="checking">';
}




?>



