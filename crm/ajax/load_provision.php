<?php

session_start();
header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
$db = new db_functions();
$optionResult = "<option value='0'>Select Client Account</option>";
if(isset($_POST['operatorId'])) {
    $operatorUersname = $db->getValueAsf("SELECT `user_name` as f FROM  admin_users WHERE `id`=".$_POST['operatorId']." AND is_enable=1");
    $userSql = "SELECT id,full_name FROM admin_users WHERE create_user='".$operatorUersname ."'";
    $userResults =$db->selectDB($userSql);
    // var_dump(empty($userResults['data']));
    if(empty($userResults['data'])) {
        $optionResult = " <option value='0'>Client Account not found</option>";
    } else {
        foreach($userResults['data'] as $client) {
            $optionResult .= "<option value='".$client['id']."'>".$client['full_name']."</option>";
        }
    }
} 

echo $optionResult;

?>