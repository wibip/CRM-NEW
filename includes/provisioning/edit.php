<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/
/// Create Account  or Edit Account/////
$edid_service = false;

if (isset($_GET['edid_service'])) {

    if ($_SESSION['FORM_SECRET'] == $_GET['token']) {

        $edid_service = true;

        $edit_provisioning = $provisioning->getProvisiong_uniq($_GET['service_id']);

        $edit_service_type = $edit_provisioning['service_type'];
        $edit_service_id = $edit_provisioning['id'];

        $edit_setting = json_decode($edit_provisioning['setting'], true);
        $edit_admin_features = $edit_setting['admin_features'];
        $edit_advanced_features = $edit_setting['advanced_features'];

        $edit_parent_package = $edit_setting['parent_package'];
        $edit_distributor_system_package = $edit_setting['mvno_package'];


        $edit_ap_controller = $edit_setting['ap_controller'];
        $edit_sw_controller = $edit_setting['sw_controller'];
        $edit_network_type = $edit_setting['package_type'];

        $edit_gateway_type = $edit_setting['guest_gateway_type'];
        $edit_pr_gateway_type = $edit_setting['private_gateway_type'];
        $edit_business_type = $edit_setting['business_vertical'];

        $edit_wag_profile = $edit_setting['wag_profile'];
        $edit_dns_profile = $edit_setting['dns_profile'];

        $edit_dpsk_controller = $edit_admin_features['CLOUD_PATH_DPSK']['controller'];
        $edit_dpsk_policies = $edit_admin_features['CLOUD_PATH_DPSK']['policie'];

        // echo $edit_admin_features['CLOUD_PATH_DPSK']['controller'];
    }
}
