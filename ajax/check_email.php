<?php

session_start();
header("Cache-Control: no-cache, must-revalidate");
require_once '../classes/dbClass.php';
$db = new db_functions();
require_once '../classes/appClass.php';

$email = htmlentities( urldecode($_POST[email]), ENT_QUOTES, 'utf-8' );
$realm = htmlentities( urldecode($_POST[realm]), ENT_QUOTES, 'utf-8' );

	$chek_mail=$db->selectDB(sprintf("SELECT * FROM `mdu_vetenant` WHERE `email`='%s' AND property_id='%s'", $email,$realm));
	
	
	if($chek_mail['rowCount']==0){//mail

        $isAvailable = 'true';
	}else{

        $isAvailable = 'false';
		
	}


echo json_encode(array(
    'valid' => $isAvailable,
));

?>