<?php

session_start();

header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
require_once '../classes/systemPackageClass.php';

$package_functions=new package_functions();
$db = new db_functions();

$type = $_POST['type'];
$system_package = $_POST['system_package'];
$user_distributor = $_POST['user_distributor'];
$vertical = $_POST['vertical'];

$email_template = $db->getEmailTemplateVertical($type, $system_package, 'MNO',$vertical ,$user_distributor);
$subject = $email_template[0]['title'];
$mail_text  = $email_template[0]['text_details'];

echo json_encode(array('status' => 'success', 'data' => array('subject'=>$subject,'mail_text'=>$mail_text)));
?>