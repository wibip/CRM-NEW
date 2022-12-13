<?php 

require_once dirname(__FILE__).'/../../classes/dbClass.php';
require_once dirname(__FILE__).'/../../classes/systemPackageClass.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

$db = new db_functions();
$id=$argv[1];
if (strlen($id)<1) {
	$id = $_GET['id'];
}
$api_id=$argv[2];
if (strlen($api_id)<1) {
	$api_id = $_GET['api_id'];
}
$method=$argv[3];
if (strlen($method)<1) {
	$method = 'all';
}
$result = $db->select1DB("SELECT * FROM exp_crm WHERE id = '$id'");

$mno_id = $result['mno_id'];
if($method=='simple'){
	$data = [
		'name' => $result['business_name'],
		'contact' => [
			'name' => $result['contact_name'], 
			'email' => $result['contact_email'], 
			'voice' => $result['contact_number']
		],
		'locations' => [
			[
				'id' => $result['property_id'], 
				'name' => $result['contact_name'],
				'address' => [
					'street' => $result['street'],
					'city' => $result['city'],
					'state' => $result['state'],
					'zip' => $result['zip'] 
				]
			]
		]
	];
}else{
$data = [
	'name' => $result['business_name'],
	'contact' => [
		'name' => $result['contact_name'], 
		'email' => $result['contact_email'], 
		'voice' => $result['contact_number']
	],
	'locations' => [
		[
			'id' => $result['property_id'], 
			'name' => $result['contact_name'],
			'address' => [
				'street' => $result['street'],
				'city' => $result['city'],
				'state' => $result['state'],
				'zip' => $result['zip'] 
			]
		]
	],
	"operator-code"=>"FRT",
	"sub-operator"=>"",
	"service-type"=>$result['service_type'],
	"env"=>"hosted"
];
}
$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Processing' WHERE id = '$id'");

require_once 'functions.php';
$jsondata = json_encode($data);

// $crm_profile = 'CRM_HOSTED';
$crm = new crm($api_id, $system_package);

$response = $crm->createParent($jsondata);

if ($response['status'] == 'success') {
	$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Completed' WHERE id = '$id'");
}else{
	$ex = $db->execDB("UPDATE exp_crm SET `status` = 'Failed' WHERE id = '$id'");
}


echo json_encode($response);
?>