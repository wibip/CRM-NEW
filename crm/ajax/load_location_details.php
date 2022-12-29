<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/dbClass.php';
require_once '../src/CRM/functions.php';
$db = new db_functions();

$api_id = $_POST['api_id'];
$system_package = $_POST['system_package'];
$business_id = $_POST['business_id'];
$location_id = $_POST['location_id'];


$crm = new crm($api_id, $system_package);
$response = $crm->getLocationDetails($business_id, $location_id);

if($response != false){
    echo json_encode($response);
} else {
    echo 'false';
}
?>
