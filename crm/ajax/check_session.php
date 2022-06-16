<?php 

session_start();

require_once '../classes/dbClass.php';
$db = new db_functions();
include '../classes/cryptojs-aes.php';

$main_key = $_POST['key'];

$data_secret = $db->select1DB("SELECT settings_value FROM exp_settings WHERE settings_code='data_secret' AND distributor='ADMIN'");
//$data_secret = mysql_fetch_assoc($data_secret);
$data_secret = $data_secret['settings_value'];

$request_data = cryptoJsAesDecrypt($data_secret, urldecode($main_key));

if(strlen($request_data)>0){}else{exit();}
parse_str($request_data,$request_data_array);

if($request_data_array['logout']=='true'){  

    unset($_SESSION['user_name']);
    unset($_SESSION['access_role']);
    unset($_SESSION['login']);
    unset($_SESSION['full_name']);
    unset($_SESSION['default_key']);
    unset($_SESSION['timeout']);
    unset($_SESSION['s_detail']);
    unset($_SESSION['s_token']);
    session_write_close();
	setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
    $status = "success";

}else{
    $status = "error";
}

echo json_encode(array('status' => $status ));

?>
