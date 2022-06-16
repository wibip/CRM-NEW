<?php

header("Cache-Control: no-cache, must-revalidate");
session_start();



/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();
    if(isset($_POST['uname'])) {
        //if($_POST['uname']) {
        
        

            $newun=$_POST['mno_account_name'];
            $new = trim($newun);
            $new = htmlentities( urldecode($new), ENT_QUOTES, 'utf-8' );
        
            $uname1 = $_POST[uname];

            $getUname_q = sprintf("SELECT `user_name` FROM `admin_users` WHERE `user_name`='%s' AND `user_name`<>'%s'", $new,$uname1);
            $getUname_r = $db->selectDB($getUname_q);
            if ($getUname_r['rowCount'] > 0) {
                $isAvailable = false;
            } else {
                $isAvailable = true;
            }

            echo json_encode(array(
                'valid' => $isAvailable,
            ));
        //}
    }
?>
