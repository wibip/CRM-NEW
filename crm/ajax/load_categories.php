<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/hierarchyClass.php';
$hierarchy = new Hierarchy();
$operator_id = $_POST['operator_id'];

$response = $hierarchy->getCategories($operator_id);
if($response != false){
    echo json_encode($response);
} else {
    echo 'false';
}
?>
