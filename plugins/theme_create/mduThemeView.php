<?php 

session_start();
//require_once('../../db/config.php');
header("Cache-Control: no-cache, must-revalidate");

require_once '../../classes/dbClass.php';
$db = new db_functions();
include_once '../../classes/systemPackageClass.php';
$package_functions = new package_functions();
$system_package = $package_functions->getPackage($_SESSION['user_name']);

$camp_layout = $package_functions->getSectionType("CAMP_LAYOUT", $system_package);
$title = $_GET['title'];
if(!isset($title)){
    $title = "Theme Create";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <script src="../../js/jquery.min.js"></script>
    <script src="js/theme-create.js?v=8"></script>
    <link rel="stylesheet" href="css/theme-create.css?v=26">
</head>
<body>
    
    <?php

   

    $module_array = array('terms');

    if(!$package_functions->ajaxAccess($module_array,$system_package)){
        http_response_code(401);
        return false;
    }

    $template_name = $_GET['template_name'];
    $reg_type = $_GET['reg_type'];
    $theme_id = $_GET['theme_id'];
    $page = $_GET['page'];
    $enc = $_GET['enc'];
    $action = $_GET['action'];
    $modify_st = $_GET['modify_st'];
    $theme_id_ori = $_GET['theme_id_ori'];
    $chatbot = $_GET['chatbot'];
    $from_theme_upload = 'false';
    $property = $_GET['property'];
    if(isset($_GET['from_theme_upload'])){
        $from_theme_upload = 'true';
    }
    $str = '';
    if($from_theme_upload == 'true'){
   $mno_package = $_GET['mno_package']; 
   $system_package = $_GET['mvno_package'];
   

   $str ="&from_theme_upload=".$from_theme_upload."&mno_package=".$mno_package."&mvno_package=".$system_package;
}
    $user_distributor = $_GET['dist'];
    if(strlen($page) < 1){
        $page = 'terms';
    }
    $src = "mduThemeCreate.php?reg_type=".$reg_type."&page=".$page."&template_name=".$template_name."&property=".$property."&theme_id=".$theme_id."&enc=".$enc."&action=".$action."&modify_st=".$modify_st."&theme_id_ori=".$theme_id_ori."&chatbot=".$chatbot."&dist=".$user_distributor.$str;
  
    if($action=='view'){
        //$html = '<button onclick="parent.jQuery.fancybox.close();" class="btn btn-secondary close">Close</button>'; fancybox method
        // $html = '<a href="../../'.$page.'" class="close"></a>';
    }
  
  ?>



<div class="create-panel"><span class="preview view" data-tooltip="Preview" alt="preview"></span><span class="desktop device view" data-tooltip="Desktop preview" data-dev="desktop"></span><span class="ipad device view" data-tooltip="Tab preview" data-dev="ipad"></span><span class="iphone device view" data-tooltip="Mobile preview" data-dev="iphone"></span><?php echo $html; ?></div>
<div class="iframe-parent">
<div class="iframe-parent-in">
<iframe src="<?php echo $src; ?>">
</iframe>
</div>
</div>
<style type="text/css">
@media only screen and (max-width: 414px) {
#servicear-check-div{
    margin-left: -207px !important;
}
}
@media only screen and (max-width: 375px) {
    #servicear-check-div{
        margin-left: -188px !important;
    }
}
@media only screen and (max-width: 320px) {
    #servicear-check-div{
        margin-left: -160px !important;
    }
}
</style>
</body>
</html>
