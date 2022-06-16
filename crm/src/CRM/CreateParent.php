<?php 
require_once dirname(__FILE__).'/../../classes/dbClass.php';
require_once dirname(__FILE__).'/../../classes/systemPackageClass.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$db = new db_functions();
$id=$argv[1];
if (strlen($id)<1) {
	$id = $_GET[id];
}
$result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$id'");

$mno_id = $result['mno_id'];
$data = array('name'	 => $result['business_name'],
			 'contact'   => array('name' => $result['contact_name'], 
								'email' => $result['contact_email'], 
							    'voice' => $result['contact_number']),
			 'locations' => array(array('id' => $result['property_id'], 
								  'name' => $result['contact_name'],
								  'address' => array('street' => $result['street'],
								  					 'city' => $result['city'],
								  					 'state' => $result['state'],
								  					 'zip' => $result['zip'] )
								)
				)
			  );
$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Processing' WHERE id = '$id'");
require_once 'functions.php';
$jsondata = json_encode($data);
$crm = new crm($crm_profile, $system_package);
$response = $crm->createParent($jsondata);
if ($response['status'] == 'success') {
	$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Completed' WHERE id = '$id'");
}else{
	$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Failed' WHERE id = '$id'");
}

?>