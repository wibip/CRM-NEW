<?php

session_start();
header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
$db = new db_functions();
require_once '../classes/appClass.php';

$group_number=$_POST['group'];

$group_number = htmlentities( urldecode($group_number), ENT_QUOTES, 'utf-8' );

if($group_number!=''||$group_number!=NULL){


//$ap_q1=sprintf("SELECT validity_time FROM `mdu_organizations` WHERE `property_number`=%s LIMIT 1",$db->GetSQLValueString($group_number,'text'));
$ap_q1=sprintf("SELECT validity_time FROM `mdu_organizations` WHERE `property_number`='%s' LIMIT 1",$group_number);

$query_results1=$db->selectDB($ap_q1);
foreach ($query_results1 as $row) {
   
	$val_time = $row['validity_time'];
}

if($val_time==''||$val_time==NULL){
	
	$return_val=2;
	
}else{
	
	$return_val=1;
	
}


echo $return_val;

}


//echo $q1;
?>




