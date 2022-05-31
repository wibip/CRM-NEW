<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL&~E_WARNING&~E_NOTICE);*/
/// Create Account  or Edit Account/////

if (isset($_POST['provisioning_update'])) {
    if ($_SESSION['FORM_SECRET'] == $_POST['provisioning_form_secret']) {
        $service_type = $_POST['service_type'];
        $edit_service_id = $_POST['edit_service_id'];

        $parent_package = $_POST['parent_package_type'];
        $mvno_package = $_POST['customer_type'];

        $ap_conroller = $_POST['ap_conroller'];
        $sw_conroller = $_POST['sw_conroller'];


        $gateway_type = $_POST['gateway_type'];
        $pr_gateway_type = $_POST['pr_gateway_type'];
        $business_type = $_POST['business_type'];

        $network_type = $_POST['network_type'];

        $admin_features = $_POST['admin_features'];
        $advanced_features = $_POST['advanced_features'];

        $cld_conroller = $_POST['dpsk_conroller'];
        $cld_policies = $_POST['dpsk_policies'];

        $voucher_type = $_POST['dpsk_voucher'];

        $payment_operator = $_POST['payment_operator_new'];

        $ad_operator = $_POST['ad_operator_new'];
        $wag_profile = $_POST['wag_profile'];
        $dns_profile = $_POST['dns_profile'];

        $setting = array();


        //Generate admin features array

        $admin_features_ar = array();

        foreach ($admin_features as $features) {

            switch ($features) {
                case "CLOUD_PATH_DPSK":
                    $cloudpath_array = array();
                    $cloudpath_array['controller'] = $cld_conroller;
                    $cloudpath_array['policie'] = $cld_policies;
                    $admin_features_ar[$features] = $cloudpath_array;

                    break;
                case "VOUCHER":
                    $voucher_array = array();
                    $voucher_array['value'] = $voucher_type;
                    $admin_features_ar[$features] = $voucher_array;

                    break;
                case "PAYMENT_GATEWAY_NEW":
                    $payment_getway = array();
                    $payment_getway['value'] = $payment_operator;
                    $admin_features_ar[$features] = $payment_getway;

                    break;
                case "AD_PROFILE":
                    $ad_profile = array();
                    $ad_profile['value'] = $ad_operator;
                    $admin_features_ar[$features] = $ad_profile;

                    break;
                default:
                    $admin_features_ar[$features] = '1';
            }
        }

        //Generate advanced features array
        $advanced_features_ar = array();

        foreach ($advanced_features as $value) {
            $advanced_features_ar[$value] = '1';
        }

        //Generate Package Type 
        if (in_array('GUEST', $network_type) && in_array('PRIVATE', $network_type) && in_array('VT', $network_type)) {
            $package_type = 'VT-BOTH';
        } elseif (in_array('GUEST', $network_type) && in_array('PRIVATE', $network_type)) {
            $package_type = 'BOTH';
        } elseif (in_array('GUEST', $network_type) && in_array('VT', $network_type)) {
            $package_type = 'VT-GUEST';
        } elseif (in_array('VT', $network_type) && in_array('PRIVATE', $network_type)) {
            $package_type = 'VT-PRIVATE';
        } elseif (in_array('GUEST', $network_type)) {
            $package_type = 'GUEST';
        } elseif (in_array('PRIVATE', $network_type)) {
            $package_type = 'PRIVATE';
        } elseif (in_array('VT', $network_type)) {
            $package_type = 'VT';
        }

        //Generate final array
        $setting['parent_package'] = $parent_package;
        $setting['mvno_package'] = $mvno_package;
        $setting['ap_controller'] = $ap_conroller;
        $setting['sw_controller'] = $sw_conroller;
        $setting['guest_gateway_type'] = $gateway_type;
        $setting['private_gateway_type'] = $pr_gateway_type;
        $setting['business_vertical'] = $business_type;
        $setting['package_type'] = $package_type;
        $setting['admin_features'] = $admin_features_ar;
        $setting['advanced_features'] = $advanced_features_ar;
        $setting['wag_profile'] = $wag_profile;
        $setting['dns_profile'] = $dns_profile;

        // Insert DB

        $data_bulk = array();

        $data_bulk['service_type'] = $service_type;
        $data_bulk['edit_service_id'] = $edit_service_id;
        $data_bulk['setting'] = json_encode($setting);
        $data_bulk['mno_id'] = $mno_id;
        $data_bulk['user_name'] =  $user_name;

        $result = $provisioning->update($data_bulk);

        if ($result) {
            $_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('service_type_update_success', '2001') . "</strong></div>";
        } else {
            $_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_functions->showMessage('service_type_update_fail', '2001') . "</strong></div>";
        }
    }
}
