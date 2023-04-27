<?php
header("Cache-Control: no-cache, must-revalidate");
session_start();
/*classes & libraries*/
require_once '../classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once '../classes/OperatorClass.php';
$OperatorClass = new OperatorClass();

$result = $adminConfig->saveIpScope($_POST); 
if($result != false){
    echo json_encode($result);
} else {
    echo 'false';
}
?>
