<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();
$operator_id = $_POST['operator_id'];

$response = $CommonFunctions->getCategories($operator_id);
if($response != false){
    echo json_encode($response);
} else {
    echo 'false';
}
?>
