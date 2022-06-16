<?php

session_start();

/*classes & libraries*/
require_once '../classes/dbClass.php';
require_once '../classes/CommonFunctions.php';
$db = new db_functions();
//require_once('../db/config.php');
header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/systemPackageClass.php';
$package_functions=new package_functions();



$email = $_POST['email'];
$login = $_GET['login'];


$email = htmlentities( urldecode($email), ENT_QUOTES, 'utf-8' );
$login = htmlentities( urldecode($login), ENT_QUOTES, 'utf-8' );

$list_of_packages = $package_functions->getOptions('LOGIN_RESTRICTION', $login);


$output="<label for=\"username\">Select Username</label><div class=\"controls\">";
$email_count=0;

/*
$sql="SELECT `user_name`,email,user_distributor FROM `admin_users` 
WHERE user_type='SUPPORT' OR user_type='ADMIN' OR user_type='MNO'";
*/

$sql = sprintf("SELECT u.`user_name`,u.`email`,u.`user_distributor`,m.`system_package` 
FROM `admin_users` u, `exp_mno` m
WHERE m.`mno_id` = u.`user_distributor` and u.`user_type` IN ('SUPPORT','ADMIN','MNO','TECH')
AND email ='%s'", $email);

	
$result = $db->selectDB($sql);

 

$row_count=0;
foreach($result['data'] AS $row){
	
	$sys_pcg = $row['system_package'];
	
	if(in_array($sys_pcg,explode(',',$list_of_packages))){
   // if(strtolower($email)==strtolower($row['email'])){
		
		
    $row_count++;

    //$output.='<option value="'.$row['user_name'].'">'.$row['user_name'].'</option>';
	if($row_count==1){
        $output.='<input checked type="radio" name="username" value="'.$row['user_name'].'"><label style="display: inline-block !important;" ></label> &nbsp;&nbsp;&nbsp;'.$row['user_name'].'</br>';
    }else{
        $output.='<input type="radio" name="username" value="'.$row['user_name'].'"><label style="display: inline-block !important;" ></label> &nbsp;&nbsp;&nbsp;'.$row['user_name'].'</br>';

    }

	$emailuser='<input type="hidden" name="username" value="'.$row['user_name'].'">';
	
	$email_count++;
	
}
		
}

if($email_count>1){
	
	echo $output.'</div>';
	
}else{
	
	echo $emailuser;
}


?>
