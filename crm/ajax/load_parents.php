<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/hierarchyClass.php';
$hierarchy = new Hierarchy();
$operator_id = $_POST['operator_id'];
$category_id = $_POST['category_id'];
$group_value = $_POST['group_value'];

$response = $hierarchy->getParents($operator_id,$category_id,$group_value);
if($response != false){
    echo json_encode($response);
} else {
    echo 'false';
}
?>
