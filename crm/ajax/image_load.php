<?php
session_start();
include_once '../classes/systemPackageClass.php';
header("Cache-Control: no-cache, must-revalidate");

require_once '../classes/dbClass.php';
require_once '../classes/appClass.php';
$db = new db_functions();
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$module_array = array('theme_s','theme');

if(!$package_functions->ajaxAccess($module_array,$system_package)){
    http_response_code(401);
    return false;
}

$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");
$portal_base_url = trim($db->setVal('portal_base_url','ADMIN'),"/");

$template_name = $_POST['template_name'];
$img = explode(',',$_POST['img']);
$background = explode(',',$_POST['background']);
$imageArr1 = array();
$imageArr2 = array();

foreach ($img as $value) {
    $dirname = "../".$base_portal_folder."/template/$template_name/gallery/".$value."/image_*";
    $images = glob($dirname."*.{jpg,png,gif}", GLOB_BRACE);
    $valArr = array();
    foreach($images as $image) {
        $str2 = substr($image, 3);
        $imgnames1 =explode("/",$image);
        $length1=count($imgnames1);
        $imagename1=$imgnames1[$length1-1];
        $imageUrl = $portal_base_url."/template/$template_name/gallery/".$value."/".$imagename1;
        array_push($valArr,$imageUrl);
    }
    $imageArr1[$value] = $valArr;
}

foreach ($background as $value) {
    $dirname = "../".$base_portal_folder."/template/$template_name/gallery/".$value."/image_*";
    $images = glob($dirname."*.{jpg,png,gif}", GLOB_BRACE);
    $valArr = array();
    foreach($images as $image) {
        $str2 = substr($image, 3);
        $imgnames1 =explode("/",$image);
        $length1=count($imgnames1);
        $imagename1=$imgnames1[$length1-1];
        $imageUrl = $portal_base_url."/template/$template_name/gallery/".$value."/".$imagename1;
        array_push($valArr,$imageUrl);
    }
    $imageArr2[$value] = $valArr;
}

echo json_encode(array("img"=>$imageArr1,"background"=>$imageArr2));
?>