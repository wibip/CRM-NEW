<?php

session_start();
$session_id = session_id();
header("Cache-Control: no-cache, must-revalidate");

/*classes & libraries*/
require_once '../classes/dbClass.php';
$db = new db_functions();
$property_number = $_POST['prop_realm'];
$relm=$_GET['crelm'];
$property_number_apend = $property_number.'R1';

$property_number = htmlentities( urldecode($property_number), ENT_QUOTES, 'utf-8' );
$relm = htmlentities( urldecode($relm), ENT_QUOTES, 'utf-8' );

$s_id = sprintf("SELECT
  `property_number`
FROM
  `mdu_organizations` 
WHERE (property_number = '%s' OR property_number = '%s') and property_id <> '%s'",$property_number,$property_number_apend,$relm);

		$query_resultss=$db->selectDB($s_id);

		if($query_resultss['rowCount']==0){
	
			
			echo json_encode(array(
			    'valid' => 'true',
			));

		}
		else{
			
			
			echo json_encode(array(
			    'valid' => 'false',
			));
			
		}




 ?>