<?php
header("Cache-Control: no-cache, must-revalidate");


session_start();


/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();

$base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");


$template = $_GET['template_name'];
$image_dir = $_GET['img_dir'];
$file_id = $_GET['file_id'];


//$distributor =

//File match with distributor

$user_name = $_SESSION['user_name'];

$key_query = "SELECT  `access_role`, user_type, user_distributor FROM  admin_users WHERE user_name = '$user_name' LIMIT 1";
$query_results=$db->selectDB($key_query);
foreach ($query_results['data'] as $row) {
	$access_role = $row['access_role'];
	$user_type = $row['user_type'];
	$user_distributor = $row['user_distributor'].'_';
}



// remove page

if (strpos($file_id, $user_distributor) !== false) {
	
	
	
	 $filename = '../'.$base_portal_folder.'/template/'.$template.'/gallery/'.$image_dir.'/'.$file_id;
	
	if (file_exists($filename)) {
		unlink($filename);
		echo 'SUCCESS';
	} else {
		echo 'FAILED';
	}
	

}
else {
	echo 'FAILED';
}



?>