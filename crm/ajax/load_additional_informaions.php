<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
$order_id = $_POST['order_id'];
$info_type = $_POST['info_type'];

$response = $CommonFunctions->getPropertyAdditionals($order_id,$info_type);
if($response != false){
    echo json_encode($response);
} else {
    echo 'false';
}
?>