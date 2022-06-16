<?php

$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'camp_base_url'";

$query_results = $db->selectDB($key_query);
foreach ($query_results['data'] as $row) {

    $settings_value = $row[settings_value];
    $base_url = trim($settings_value, "/");
}

if (isset($_POST['create_location_submit'])) {
$update_id = $_POST['update_id'];
$provisioning_data = json_decode($db->getValueAsf("SELECT property_details as f FROM exp_provisioning_properties WHERE id='$update_id'"),true);
$i=0;
$account_info = $provisioning_data['account_info'];
$business_id = $account_info['business_id'];
$business_name = $account_info['business_name'];
$first_name = $account_info['first_name'];
$last_name = $account_info['last_name'];
$email = $account_info['email'];

$prov_loc_url = $base_url . '/modules/create_property/submit-property.php';
//echo $url = $_SERVER['REQUEST_URI']; exit();
//$data['account_info'] = $account_info;
$data['update_id'] = $update_id;
$data['user_type'] = $user_type;
$data['form_secret'] = $_POST['form_secret5'];

$data['business_id'] = $business_id;
$data['business_name'] = $business_name;
$data['admin_f_name'] = $first_name;
$data['admin_l_name'] = $last_name;
$data['admin_email'] = $email;
$data['system_package'] = $system_package;
$data['mno_id'] = $user_distributor;
$data['user_name'] = $_SESSION['user_name'];

$error = 0;
$error_l = 0;
foreach ($provisioning_data['property'] as $value) {
	$location_info = $value['location_info'];
	$network_info = $value['network_info'];
	if ($i==0) {
		$data['property_admin'] = 1;
	}else{
		$data['property_admin'] = 0;
	}

	$data['location_id'] = $location_info[0]['location_id'];
	$data['service_type'] = $location_info[0]['service_type'];
	$data['vt_location_id'] = $location_info[0]['vt_location_id'];
	$data['location_name'] = $location_info[0]['location_name'];
	$data['phone_number'] = $location_info[0]['phone_number'];
	$data['address'] = $location_info[0]['address'];
	$data['city'] = $location_info[0]['city'];
	$data['country'] = $location_info[0]['country'];
	$data['state'] = $location_info[0]['state'];
	$data['time_zone'] = $location_info[0]['time_zone'];
	$data['zip_code'] = $location_info[0]['zip_code'];

	$data['network_info'] =json_encode($network_info);
	$data['no_of_guest_ssid'] = $network_info['Guest']['count'];
	$data['no_of_pvt_ssid'] = $network_info['Private']['count'];
	$data['vt_wlan_count'] = $network_info['VTenant']['count'];
	/*$data['location_info'] = $location_info['0'];
	$data['network_info'] = $network_info;*/
	//$data_json = json_encode($data);

	$guest_wlan_count = $network_info['Guest']['count'];
	$pvt_wlan_count = $network_info['Private']['count'];
	$vt_wlan_count = $network_info['VTenant']['count'];
	$result = CommonFunctions::httpPost($prov_loc_url,$data);
	if ($result != true) {
	if ($i == 1) {
		$error = 1;
    } else {
    	$error_l = 1;
        
    }
	}
	$i++;
}
if ($error == 1) {
	$success_msg = $message_functions->showNameMessage('venue_create_failed', $business_id, '2009');
	$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
}elseif ($error_l == 1) {
	$success_msg = $message_functions->showNameMessage('venue_add_failed', $business_id, '2009');
	$_SESSION['msg5'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
}else{
	$db->userLog($user_name, $script, 'Location Create', $business_id);
    $success_msg = $message_functions->showNameMessage('venue_create_success', $business_id);
	$_SESSION['msg5'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
}
}
?>