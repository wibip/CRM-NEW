<?php

session_start();
/* No cache*/
header("Cache-Control: no-cache, must-revalidate");

/*classes & libraries*/
require_once '../classes/dbClass.php';

$db = new db_functions();

$valid = true;

$user_name = $_SESSION['user_name'];
$key_query = "SELECT  user_distributor FROM  admin_users WHERE user_name = '$user_name' LIMIT 1";
$query_results=$db->selectDB($key_query);
foreach($query_results['data'] as$row){
    $user_distributor = $row[user_distributor];
}


if(isset($_POST['table']) && isset($_POST['field'])) {//1

    if (isset($_POST['distributor']) && $_POST['distributor'] == 'true') {
        $table = $_POST['table'];
        $field = $_POST['field'];
        $value = $_POST['value'];
        $v = $_POST[$value];

        $q1 = "SELECT * FROM $table WHERE $field='$v' AND distributor='$user_distributor'";
        $r = $db->selectDB($q1);

        if ($r['rowCount'] > 0) {
            
            $valid = false;
        }

    } elseif(isset($_POST['mno_id']) && $_POST['mno_id'] == 'true'){
        $table = $_POST['table'];
        $field = $_POST['field'];
        $value = $_POST['value'];
        $v = $_POST[$value];

        $q1 = "SELECT * FROM $table WHERE $field='$v' AND mno_id='$user_distributor'";
        $r = $db->selectDB($q1);

        if ($r['rowCount'] > 0) {
            $valid = false;
        }
    } else{
        $table = $_POST['table'];
        $field = $_POST['field'];
        $value = $_POST['value'];
        $v = $_POST[$value];

        $q1 = "SELECT * FROM $table WHERE $field='$v'";
        $r = $db->selectDB($q1);

        if ($r['rowCount'] > 0) {
            $valid = false;
        }
    }

}

//echo 'sffsf';


?>









<?php
/////////////Return results//////////////////////////////////////////

echo json_encode(array(
    'valid' => $valid,
));

/////////////////////////////////////////////////////////////////
?>