<?php

//$new_flow_account = 'old';
if (!$edit_location_old) {
    //$new_flow_account = 'new';
}
$auto_account_type = 'new';
function getProductName($value, $db)
{
    //foreach($parent_package_array as $value){
    return $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");

    //}
}
if ($edit_account == 1) {
    //echo $edit_phone1;
    $edit_phone1 = phonenumberformat($edit_phone1);
    $edit_phone2 = phonenumberformat($edit_phone2);
    $edit_phone3 = phonenumberformat($edit_phone3);
}
function phonenumberformat($number)
{
    if (preg_match('/^(\d{3})(\d{3})(\d{4})$/', $number,  $matches)) {
        $result = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        return $result;
    } else {
        return $number;
    }
}
$no_mdu = $package_functions->getSectionType('MDU_DISPLAY_HIDE', $system_package);
$operator_matchentry = $package_functions->getSectionType('NETWORK_AUTOMATION', $system_package);
if ($edit_account  == '1') {
    $dis_zone_id = $db->getValueAsf("SELECT `zoneid` AS f FROM exp_distributor_zones WHERE `ap_controller` = '$edit_distributor_ap_controller' AND `name` = '$edit_distributor_verification_number'");
}
//require_once("submit-property.php");
$dummy_values = json_decode($package_functions->getOptions('API_DUMMY_VAL_JSON', $system_package), true);
//print_r($dummy_values);
$private_encryption = $dummy_values['privte_ssid']['encryption']['method'] . '/' . $dummy_values['privte_ssid']['encryption']['algorithm'];
$isDynamic = $package_functions->isDynamic($system_package);
if ($isDynamic) {
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='DYNAMIC_MNO_001' AND `config_type`='api'");
} else {
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package'  AND config_type = 'api'");
}
$configFileArr = json_decode($getJson, true);
//print_r($configFileArr);
$dhcp_pool = $configFileArr['guest_DHCP_pool-vlan_id'];
$primary_dns = $configFileArr['guest_DHCP_pool-primary_reg-DNS'];
$subnet = $configFileArr['guest_DHCP_pool-subnet'];
$secondary_dns = $configFileArr['guest_DHCP_pool-secondary_reg-DNS'];
$subnetMask = $configFileArr['guest_DHCP_pool-subnet_mask'];
$primary_dns_filter = $configFileArr['guest_DHCP_pool-primary_filter-DNS'];
$guest_subnet_start = $configFileArr['guest_DHCP_pool-pool_start_address'];
$secondary_dns_filter = $configFileArr['guest_DHCP_pool-secondary_filter-DNS'];
$guest_subnet_end = $configFileArr['guest_DHCP_pool-pool_end_address'];
$dhcp_lease_time = $configFileArr['guest_DHCP_pool-leaseTimeMinutes'];
$g_encryption = $configFileArr['Guest_SSID_type'];
$g_vlan = $configFileArr['Guest_vlan_id'];
$dhcp_lease_hour = $configFileArr['guest_DHCP_pool-leaseTimeHours'];
$pvt_vlan = $configFileArr['Private_vlan_id'];
$vt_vlan = $configFileArr['vTenant_vlan_id'];

$template_zone = $dummy_values['template_zone'];
$template_group = $dummy_values['template_group'];
$zone_description = $dummy_values['zone_description'];
$group_description = $dummy_values['group_description'];
//$pvt_vlan = $dummy_values['privte_ssid']['vlan']['accessVlan'];
//$vt_vlan = $dummy_values['vtenant_ssid']['vlan']['accessVlan'];
$isDynamic = package_functions::isDynamic($system_package);
$qfn = "SELECT `service_id`,`service_name` FROM `exp_service_activation_features`  WHERE `service_type`='MNO_FEATURES' AND `service_id`='CAMPAIGN_MODULE'";

$campaign_feature = $db->select1DB($qfn);
if ($isDynamic) {
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='DYNAMIC_MNO_001'");
} else {
    $getJson = $db->getValueAsf("SELECT `options` AS f FROM `exp_mno_api_configaration` WHERE product_code='$system_package'");
}

$configFileArr = json_decode($getJson, true);

require_once 'models/vtenantModel.php';
$vtenant_model = new vtenantModel();

$vt_realm_ar = array();
if ($edit_account == '1') {
    if (($edit_distributor_network_type == 'VT') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'VT-PRIVATE') || ($edit_distributor_network_type == 'VT-GUEST')) {
        $vt_select = "Selected";
    } else {
        $vt_select = "";
    }
    $edit_acc_realm = $vtenant_model->getDistributorVtenant($edit_distributor_code);
    //var_dump($edit_acc_realm);
    if ($edit_acc_realm !== false) {
        $vt_type_new = $edit_acc_realm->getType();
        $vt_type = $vt_type_new == 'VTENANT' ? '(VT)' : '(MDU)';
        $vt_name = $edit_acc_realm->getRealm();
        $vt_name_f  = $edit_acc_realm->getRealm() . $vt_type;
        $vt_arr = array(
            'vt_type' => $vt_type_new,
            'vt_name' => $vt_name,
            'vt_name_f' => $vt_name_f,
            'select' => 'selected'
        );
        array_push($vt_realm_ar, $vt_arr);
    }
} else {
    $vt_select = "";
}

$mno_vtenants = $vtenant_model->getUnusedMNOVtenants($user_distributor);
foreach ($mno_vtenants as $vtenant) {
    $vt_type_new = $vtenant->getType();
    $vt_type = $vt_type_new == 'VTENANT' ? '(VT)' : '(MDU)';
    $vt_name = $vtenant->getRealm();
    $vt_name_f  = $vtenant->getRealm() . $vt_type;
    $vt_arr = array(
        'vt_type' => $vt_type_new,
        'vt_name' => $vt_name,
        'vt_name_f' => $vt_name_f,
        'select' => ''
    );
    array_push($vt_realm_ar, $vt_arr);
}
$vt_realm_ar_json = json_encode($vt_realm_ar);

//print_r($vt_realm_ar);
?>
<style type="text/css">
    .desable-se {
        position: relative !important;
    }

    @media (min-width: 1200px) {
        div[class*=span4_new] {
            width: 100% !important;
        }

        div[class*=zone_c] {
            width: 100% !important;
        }

        div[class*=group_c] {
            width: 100% !important;
        }
    }
</style>
</style>
<div <?php if (isset($tab_create_property)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="create_property">

    <div id="msg27"></div>

    <form onkeyup="location_formfn();" onchange="location_formfn();" autocomplete="off" id="location_form" name="location_form" method="post" class="form-horizontal" action="<?php if ($_POST['p_update_button_action'] == 'add_location' || isset($_GET['location_parent_id'])) {
                                                                                                                                                                                    echo '?token7=' . $secret . '&t=edit_parent&edit_parent_id=' . $edit_parent_id;
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo '?t=active_properties';
                                                                                                                                                                                } ?>">

        <?php
        echo '<input type="hidden" name="form_secret5" id="form_secret5" value="' . $_SESSION['FORM_SECRET'] . '" />';
        ?>

        <div>




            <?php
            //***************Field Filtor******************
            //echo $system_package;
            $json_fields = $package_functions->getOptions('VENUE_ACC_CREAT_FIELDS', $system_package);
            $field_array = json_decode($json_fields, true);
            //  print_r($field_array);
            ?>
            <div class="content clearfix">
                <fieldset id="parent_details" data-name="Account Info">
                    <h3>Account Info</h3>

                    <div class="flex">
                        <div class="create_le">

                            <?php
                            if (array_key_exists('parent_id', $field_array) || $package_features == "all") {
                            ?>


                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="customer_type">Business ID<?php if ($field_array['parent_id'] == "mandatory") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="1" <?php if (isset($edit_parent_id)) { ?>readonly<?php } ?> maxlength="12" type='text' class="span4 form-control" placeholder="SAN123456789" name='parent_id' id='parent_id' value="<?php echo $edit_parent_id; ?>" data-toggle="tooltip" title="The Business ID format: 3 alpha characters followed by 3-9 numeric characters. EX. SAN123 or SAN123456789">
                                        <input type="hidden" name="flow_type" value="<?php echo $new_flow_account; ?>">
                                    </div>
                                    <script type="text/javascript">
                                        $("#parent_id").keypress(function(event) {
                                            var ew = event.which;
                                            //alert(ew);
                                            // if(ew == 32)
                                            //   return true;
                                            if (48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122 || ew == 0 || ew == 8 || ew == 189)
                                                return true;
                                            return false;
                                        });
                                    </script>
                                </div>
                            <?php }


                            if (array_key_exists('f_name', $field_array) || $package_features == "all") {
                            ?>

                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_first_name">Admin First Name<?php if ($field_array['f_name'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="3" <?php if (isset($edit_first_name)) { ?>readonly<?php } ?> class="span4 form-control" id="mno_first_name" placeholder="First Name" name="mno_first_name" type="text" maxlength="30" value="<?php echo $edit_first_name; ?>">
                                    </div>
                                </div>
                            <?php }



                            if (array_key_exists('email', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_email">Admin Email<?php if ($field_array['email'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="5" <?php if (isset($edit_email)) { ?>readonly<?php } ?> class="span4 form-control" id="mno_email" name="mno_email" type="text" placeholder="wifi@company.com" value="<?php echo $edit_email; ?>">
                                    </div>
                                </div>
                            <?php }
                            //print_r($field_array);
                            if ((array_key_exists('new_features', $field_array) || $package_features == "all")) {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_features">Admin Features<?php if ($field_array['new_features'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <select tabindex="7" onchange="feature_config();" class="form-control span4" multiple="multiple" id="admin_features" name="admin_features[]">
                                            <option value="" disabled="disabled"> Choose Feature(s)</option>

                                            <?php
                                            if ($edit_account == 1) {
                                                $edit_admin_featuresjson = json_encode($edit_parent_features);
                                                $fearuresjson = $db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
                                                $mno_feature = json_decode($fearuresjson);

                                                $qf = "SELECT `service_id`,`service_name`,`mno_feature`,`feature_json` FROM `exp_service_activation_features`  WHERE `service_type`='MVNO_ADMIN_FEATURES'
                                                                   ORDER BY `service_id`";

                                                $featureaccess = array();
                                                $query_resultsf = $db->selectDB($qf);
                                                $featurearr = $query_resultsf['data'];
                                                $featurearrjson = json_encode($featurearr);
                                                foreach ($query_resultsf['data'] as $row) {

                                                    $feature_code = $row[service_id];
                                                    $feature_name = $row[service_name];
                                                    $m_features = $row[mno_feature];
                                                    $feature_json = $row[feature_json];

                                                    if (in_array($m_features, $mno_feature) || (strlen($m_features) < 1)) {
                                                        $fearurearr = array();
                                                        $fearurear = json_decode($feature_json, true);
                                                        $fearurearr[$feature_code] = $fearurear;
                                                        if ((!$isDynamic && $feature_code != "CAMPAIGN_MODULE") || ($isDynamic)) {
                                                            if (array_key_exists($feature_code, $edit_parent_features)) {
                                                                echo "<option selected value='" . $feature_code . "'>" .  $feature_name . "</option>";
                                                            } else {
                                                                echo "<option value='" . $feature_code . "'>" .  $feature_name . "</option>";
                                                            }
                                                            if (!empty($fearurear)) {
                                                                array_push($featureaccess, $fearurearr);
                                                            }
                                                        }
                                                    }
                                                    //

                                                }
                                                $featureaccess = json_encode($featureaccess);
                                            } else {
                                                $fearuresjson = $db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
                                                $mno_feature = json_decode($fearuresjson);
                                                $edit_admin_featuresjson = json_encode($edit_parent_features);

                                                $qf = "SELECT `service_id`,`service_name`,`mno_feature`,`feature_json` FROM `exp_service_activation_features`  WHERE `service_type`='MVNO_ADMIN_FEATURES'
                           ORDER BY `service_id`";

                                                $featureaccess = array();
                                                $query_resultsf = $db->selectDB($qf);
                                                $featurearr = $query_resultsf['data'];
                                                $featurearrjson = json_encode($featurearr);
                                                foreach ($query_resultsf['data'] as $row) {

                                                    $feature_code = $row[service_id];
                                                    $feature_name = $row[service_name];
                                                    $m_features = $row[mno_feature];
                                                    $feature_json = $row[feature_json];

                                                    if (in_array($m_features, $mno_feature) || (strlen($m_features) < 1)) {
                                                        $fearurearr = array();
                                                        $fearurear = json_decode($feature_json, true);
                                                        $fearurearr[$feature_code] = $fearurear;
                                                        if ((!$isDynamic && $feature_code != "CAMPAIGN_MODULE") || ($isDynamic)) {
                                                            if (array_key_exists($feature_code, $edit_parent_features)) {
                                                                echo "<option selected value='" . $feature_code . "'>" .  $feature_name . "</option>";
                                                            } else {
                                                                echo "<option value='" . $feature_code . "'>" .  $feature_name . "</option>";
                                                            }
                                                            if (!empty($fearurear)) {
                                                                array_push($featureaccess, $fearurearr);
                                                            }
                                                        }
                                                    }
                                                }
                                                $featureaccess = json_encode($featureaccess);
                                            }
                                            ?>


                                        </select>
                                    </div>

                                </div>






                                <div id="fearure_ar"></div>
                                <script type="text/javascript">
                                    function adminFeatures(vertical, val) {

                                        var aaa;
                                        let edit_account = '<?php echo $edit_account; ?>';

                                        let featureall = <?php echo trim($featurearrjson);  ?>;
                                        let mno_feature = <?php echo trim($fearuresjson);  ?>;
                                        let edit_features = <?php echo trim($edit_admin_featuresjson); ?>;

                                        $('#admin_features').find('option').remove();
                                        featureall.forEach(function(element) {
                                            //var a =mno_feature.indexOf(element['mno_feature']);
                                            if ($.inArray(element['mno_feature'], mno_feature) !== -1) {
                                                let selected = "";
                                                if (vertical == "VTenant" || vertical == "MDU") {
                                                    $('#vt_voucher_div').show();
                                                    //$('#vt_additinal_feature').show();
                                                    var edit = element['service_id'];
                                                    if (edit_account == '1' && edit_features != null) {
                                                        var aaa = edit_features[edit];
                                                        if (aaa == 1 || aaa == 0) {
                                                            selected = 'selected="selected"';
                                                            if (edit == "DPSK") {

                                                            }
                                                        }
                                                    }

                                                    $("#admin_features").append('<option ' + selected + ' value="' + element['service_id'] + '">' + element['service_name'] + '</option>');

                                                } else {
                                                    $('#vt_voucher_div').hide();
                                                    //$('#vt_additinal_feature').hide();
                                                    var edit = element['service_id'];
                                                    console.log(edit_features);
                                                    if (edit_account == '1' && edit_features != null) {
                                                        var aaa = edit_features[edit];
                                                        if (aaa == 1 || aaa == 0) {
                                                            selected = 'selected="selected"';
                                                        }
                                                    }
                                                    if (edit == "DPSK" || edit == "CLOUD_PATH_DPSK" || edit == 'VOUCHER') {} else {
                                                        $("#admin_features").append('<option ' + selected + ' value="' + element['service_id'] + '">' + element['service_name'] + '</option>');

                                                    }
                                                }

                                            }


                                        });
                                        if (val == 1) {
                                            $('#admin_features').multiSelect('refresh');
                                        }
                                    }

                                    function feature_config() {


                                        var admin_features_val = $('#admin_features').val();
                                        var features_arr = '<?php echo $featureaccess ?>';
                                        var array_new = JSON.parse(features_arr);
                                        var result = '';
                                        var resultnew = '';
                                        var dpsk = 'DPSK';
                                        //console.log(admin_features_val);
                                        $('#vt_voucher_div').empty();
                                        $("#fearure_dpsk").css("display", "none");

                                        for (var key in admin_features_val) {

                                            if (admin_features_val[key] == 'VOUCHER') {
                                                resultnew = '<div class="controls col-lg-5 form-group"><label for="dpsk_voucher">Resident Account Creation Voucher <i  title="All tenants will need a voucher to enable them to create an account. depending on level of security you can select from two options: <br> 1.Shared voucher means all tenant use the same voucher code for account creation  <br>                    2.Single-use voucher means each tenant gets a unique one time voucher for account creation " class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" checked name="dpsk_voucher" value="SHARED"><label style="display :inline-block;min-width: 29%; max-width: 100%;">Shared</label><input type="radio" name="dpsk_voucher" value="SINGLEUSE"><label style="display :inline-block;">Single Use</label></div>';
                                                //$('#vt_voucher_div').empty();




                                                $('#vt_voucher_div').html(resultnew);
                                                $('.tooltips').tooltipster({
                                                    contentAsHTML: true,
                                                    maxWidth: 350

                                                });
                                            }
                                            if (admin_features_val[key] == 'CLOUD_PATH_DPSK') {
                                                $("#fearure_dpsk").css("display", "block");
                                            }
                                        }

                                        for (var i = 0; i < array_new.length; i++) {
                                            //array_new[i];
                                            //console.log(admin_features_val);

                                            for (var key in array_new[i]) {
                                                if (admin_features_val) {
                                                    var a = admin_features_val.indexOf(key);
                                                }
                                                //console.log(a);
                                                if (a > -1) {

                                                    var value = array_new[i][key];
                                                    var type = value['type'];
                                                    var name = value['id'];
                                                    var label = value['label'];
                                                    var check1 = value['value']['operator'];
                                                    var check2 = value['value']['parent'];

                                                    var checked = check1['selected'];
                                                    var label_n = check1['label'];
                                                    var enable = check1['enable'];
                                                    var checkedp = check2['selected'];
                                                    var label_np = check2['label'];
                                                    var enablep = check2['enable'];

                                                    result += '<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">' + label + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checked + ' value="' + enable + '"><label style="display :inline-block;min-width: 29%; max-width: 100%;">' + label_n + '</label><input type="' + type + '" name="' + name + '" id="' + name + '" ' + checkedp + ' value="' + enablep + '"><label style="display :inline-block;">' + label_np + '</label></div></div>';



                                                }
                                            }


                                        }
                                        $('#fearure_ar').empty();

                                        $('#fearure_ar').html(result);
                                        // $('#device_arr').html(resultsn);
                                    }
                                </script>
                                <?php
                                if ($edit_account == 1) { ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var admin_features_val = $('#admin_features').val();
                                            var features_arr = '<?php echo $featureaccess ?>';
                                            var array_new = JSON.parse(features_arr);
                                            var result = '';
                                            var resultnew = '';
                                            var dpsk = 'DPSK';
                                            //console.log(admin_features_val);

                                            $("#fearure_dpsk").css("display", "none");

                                            for (var key in admin_features_val) {


                                                if (admin_features_val[key] == 'CLOUD_PATH_DPSK') {
                                                    $("#fearure_dpsk").css("display", "block");
                                                }
                                            }

                                        });
                                    </script>
                                <?php }
                                ?>
                            <?php } else {
                                $parent_package = $package_functions->getOptions('MVNO_ADMIN_PRODUCT', $system_package);
                                $parent_package_array = explode(',', $parent_package);
                            ?>


                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="parent_package_type">Admin Type</label>

                                        <?php
                                        echo '<select tabindex="8" class="span4 form-control" id="parent_package1" name="parent_package_type">';
                                        echo '<option value="">Select Business ID type</option>';
                                        foreach ($parent_package_array as $value) {
                                            $parent_package_name = getProductName($value, $db); //$db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                            if ($edit_parent_package == $value) {
                                                echo '<option selected value="' . $value . '">' . $parent_package_name . '</option>';
                                            } else {
                                                echo '<option name="admin_type_val" value="' . $value . '">' . $parent_package_name . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        ?>
                                    </div>
                                </div>


                            <?php
                            }



                            ?>

                            <?php

                            if (array_key_exists('advanced_features', $field_array)) { ?>

                                <div class="control-group advFea">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="advanced_features">Advanced Features<?php if ($field_array['advanced_features'] == "mandatory") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>


                                        <select class="form-control span4" multiple="multiple" id="my_select7" name="advanced_features[]">
                                            <option value="" disabled="disabled"> Choose Feature(s)</option>

                                            <?php
                                            ?>
                                            <option <?php if ($edit_advanced_features['802.2x_authentication'] == '1') {
                                                        echo 'selected';
                                                    } else {
                                                        echo '';
                                                    } ?> value="802.2x_authentication">802.1X Authentication</option>



                                        </select>
                                        <style type="text/css">
                                            div[id*="my_select7"] ul {
                                                height: 150px !important;
                                            }

                                            .help-block {
                                                z-index: 333333;
                                            }

                                            #big_properties {}

                                            input[type="checkbox"]+label {
                                                margin-right: 0px !important;
                                            }

                                            #parent_details .create_r {
                                                margin-bottom: 331px !important;
                                            }
                                        </style>

                                    </div>
                                </div>

                            <?php } ?>
                            <!-- /create left -->
                        </div>

                        <div class="create_re">

                            <?php
                            if (array_key_exists('parent_ac_name', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="customer_type">Business Account Name<?php if ($field_array['parent_ac_name'] == "mandatory") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="2" <?php if (isset($edit_parent_ac_name)) { ?>readonly<?php } ?> type='text' class="span4 form-control" placeholder="joey's pizza" name='parent_ac_name' id='parent_ac_name' value="<?php echo str_replace("\\", '', $edit_parent_ac_name); ?>">
                                    </div>
                                </div>
                            <?php }
                            if (array_key_exists('l_name', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_last_name">Admin Last Name<?php if ($field_array['l_name'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="4" <?php if (isset($edit_last_name)) { ?>readonly<?php } ?> class="span4 form-control" id="mno_last_name" placeholder="Last Name" name="mno_last_name" maxlength="30" type="text" value="<?php echo $edit_last_name; ?>">
                                    </div>
                                </div>
                            <?php }
                            if (array_key_exists('business_type', $field_array)) {
                            ?>

                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="location_name1">Business Vertical<?php if ($field_array['business_type'] == "mandatory") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>

                                        <select tabindex="6" <?php if ($field_array['business_type'] == "mandatory") { ?>required<?php } ?> class="span4 form-control" id="business_type" name="business_type">
                                            <option value="">Select Business Type</option>
                                            <?php
                                            $business_vertical = $package_functions->getOptions('VERTICAL_BUSINESS_TYPES', $system_package);

                                            if (!empty($business_vertical)) {
                                                $vertical_product = true;
                                                $business_vertical_array = json_decode($business_vertical, true);

                                                $business_vertical_settings = $db->getValueAsf("SELECT setting as f FROM `exp_mno` WHERE mno_id='$user_distributor'");

                                                $business_vertical_mno = json_decode($business_vertical_settings, true)['verticals'];

                                                if ($business_vertical_array == 0) {

                                                    $vertical_product = false;
                                                    $business_vertical_array = explode(',', $business_vertical);

                                                    if (!empty($business_vertical_mno)) {
                                                        $business_vertical_array = $business_vertical_mno;
                                                    }
                                                }

                                                if (!empty($business_vertical_mno)) {
                                                    $business_vertical_array_new = array();
                                                    foreach ($business_vertical_array as $key => $value) {
                                                        if (in_array($key, $business_vertical_mno)) {
                                                            $business_vertical_array_new[$key] = $value;
                                                        }
                                                    }

                                                    $business_vertical_array = $business_vertical_array_new;
                                                }

                                                //set Product names
                                                if ($vertical_product) {
                                                    foreach ($business_vertical_array as $productKey => $productValue) {
                                                        foreach ($productValue as $productValueKey => $productValueValue) {
                                                            $name = getProductName($productValueValue, $db);
                                                            $business_vertical_array[$productKey][$productValueKey] = ["code" => $productValueValue, "name" => $name];
                                                        }
                                                    }
                                                    $business_vertical = json_encode($business_vertical_array);
                                                }

                                                $bvlength = count($business_vertical_array);
                                                $tmpFirstVert = "";
                                                $tmpSelected = false;
                                                foreach ($business_vertical_array as $bVertical => $bVertDetails) {
                                                    if (empty($tmpFirstVert)) {
                                                        $tmpFirstVert = $bVertical;
                                                    }
                                                    if (!$vertical_product) {
                                                        $bVertical = $bVertDetails;
                                                    }
                                                    if ($edit_distributor_business_type == $bVertical) {
                                                        $tmpSelected = true;
                                            ?>
                                                        <option selected value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $bVertical; ?>"><?php echo $bVertical; ?></option>
                                                    <?php
                                                    }
                                                }
                                                if (!$tmpSelected) {
                                                    $edit_distributor_business_type = $tmpFirstVert;
                                                }
                                            } else {
                                                $vertical_product = false;
                                                if (empty($edit_distributor_business_type)) {
                                                    $edit_distributor_business_type = "Retail";
                                                }

                                                $get_businesses_q = "SELECT `business_type`,`discription` FROM `exp_business_types` WHERE `is_enable`='1'";
                                                $get_businesses_r = $db->selectDB($get_businesses_q);

                                                foreach ($get_businesses_r['data'] as $get_businesses) {
                                                    $get_business = $get_businesses['business_type'];
                                                    if ($edit_distributor_business_type == $get_business) {
                                                    ?>
                                                        <option selected value="<?php echo $get_business; ?>"><?php echo $get_businesses['discription']; ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?php echo $get_business; ?>"><?php echo $get_businesses['discription']; ?></option>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                        <?php if ($vertical_product) { ?>

                                            <script type="text/javascript">
                                                
                                                $(function() {
                                                    let no_mdu = '<?php echo trim($no_mdu);  ?>';
                                                    const changeBusinessType = (val) => {
                                                        let verticals = <?php echo trim($business_vertical);  ?>;
                                                        let mno_vtenants = <?php echo trim($vt_realm_ar_json);  ?>;
                                                        let vertical = $('#business_type').val();
                                                        let selectedProduct = '<?php echo trim($edit_parent_package); ?>';
                                                        $('#parent_package1').children('option:not(:first)').remove();

                                                        if (vertical.length > 0) {
                                                            let parentProducts = verticals[vertical];
                                                            console.log(parentProducts);
                                                            parentProducts.forEach(function(element) {
                                                                //console.log(element['code']);
                                                                let selected = "";
                                                                if (selectedProduct == element['code'] && val ==0) {
                                                                    selected = 'selected="selected"';
                                                                }
                                                                //console.log(element['name']);
                                                                var aaa = false;
                                                                if (element['name'] !== null){
                                                                    aaa = element['name'].includes('MDU')
                                                                }
                                                                
                                                                    if (aaa) {
                                                                    if (vertical == 'VTenant') {
                                                                        element['name'] = element['name'].replace("MDU", "VT");
                                                                    }
                                                                    }

                                                                $("#parent_package1").append('<option ' + selected + ' value="' + element['code'] + '">' + element['name'] + '</option>');

                                                            });
                                                            if (val == 1) {
                                                            // var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                                                            // bootstrapValidator.enableFieldValidators('parent_package_type', true);
                                                            $('#location_form').bootstrapValidator('revalidateField', 'parent_package_type');
                                                            }
                                                        }
                                                        if (vertical.length > 0) {
                                                            if (typeof adminFeatures == 'function') {
                                                                adminFeatures(vertical, val);
                                                            }

                                                        }
                                                        
                                                        if (mno_vtenants.length > 0) {
                                                            var oldvt;
                                                            //alert();
                                                            $("#vt_icomme").empty();
                                                            $("#vt_icomme").append('<option value="">Select Option</option>');
                                                            mno_vtenants.forEach(function(element) {
                                                                //console.log(element)
                                                                let selected = "";
                                                                if (vertical == 'MDU') {
                                                                    //$( "#network_vtenant_name" ).val('ATTA');
                                                                    if (element['vt_type'] == vertical) {
                                                                        if (element['select'].length > 0) {
                                                                            oldvt = 1;
                                                                            selected = element['select'] + ' = "' + element['select'] + '"';
                                                                        }
                                                                        $("#vt_icomme").append('<option ' + selected + ' value="' + element['vt_name'] + '">' + element['vt_name_f'] + '</option>');
                                                                    }
                                                                } else {
                                                                    if (element['vt_type'] != 'MDU') {
                                                                        if (element['select'].length > 0) {
                                                                            oldvt = 1;
                                                                            selected = element['select'] + ' = "' + element['select'] + '"';
                                                                        }
                                                                        $("#vt_icomme").append('<option ' + selected + ' value="' + element['vt_name'] + '">' + element['vt_name_f'] + '</option>');
                                                                    }

                                                                }


                                                            });
                                                            //alert(oldvt);
                                                            if (oldvt != 1) {
                                                                $("div").removeClass("sele-disable");
                                                            }
                                                        }
                                                    //}

                                                    }
                                                    
                                                    let vt_select = '<?php echo trim($vt_select);  ?>';
                                                    changevtName(0, vt_select, no_mdu);
                                                    changeBusinessType(0);
                                                    

                                                    $('#business_type').change(function() {
                                                        $("#fearure_dpsk").css("display", "none");
                                                        $('#fearure_ar').empty();
                                                        changevtName(1, vt_select, no_mdu);
                                                        changeBusinessType(1);
                                                    })
                                                });
                                            </script>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php }
                            $parent_package = $package_functions->getOptions('MVNO_ADMIN_PRODUCT', $system_package);
                            $parent_package_array = explode(',', $parent_package);
                            if (count($parent_package_array) > 1) {
                                if ((array_key_exists('new_features', $field_array) || $package_features == "all")) {
                                ?>


                                    <div class="control-group">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="parent_package_type">Admin Type</label>

                                            <?php
                                            echo '<select tabindex="8" class="span4 form-control" id="parent_package1" name="parent_package_type">';
                                            echo '<option value="">Select Business ID type</option>';
                                            foreach ($parent_package_array as $value) {
                                                $parent_package_name = getProductName($value, $db); //$db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                                                if ($edit_parent_package == $value) {
                                                    echo '<option selected value="' . $value . '">' . $parent_package_name . '</option>';
                                                } else {
                                                    echo '<option value="' . $value . '">' . $parent_package_name . '</option>';
                                                }
                                            }
                                            echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                            <?php }
                            } else {

                                echo '<div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control"  id="parent_package1" name="parent_package_type" type="hidden" value="' . $parent_package_array[0] . '">
                                </div>
                                 </div>
                                ';
                            } ?>


                            <div id="fearure_dpsk" style="margin-bottom: -30px; display: none;">

                                <div class="control-group">

                                    <div class="controls col-lg-5 form-group">

                                        <label for="cld_conroller">CloudPath Controller<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <?php if (!empty($edit_dpsk_controller)) { ?>
                                            <input readonly="" class="span4 form-control" id="dpsk_conroller" placeholder="" name="dpsk_conroller" type="text" value="<?php echo $edit_dpsk_controller; ?>">
                                        <?php } else { ?>
                                            <select name="dpsk_conroller" id="dpsk_conroller" class="span4 form-control">
                                                <option value="">CloudPath Controller</option>
                                                <?php
                                                $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='DPSK'";

                                                $query_results = $db->selectDB($q1);

                                                foreach ($query_results['data'] as $row) {

                                                    //$mnoid=$row[mno_id];
                                                    $apc = $row['ap_controller'];

                                                    $ap_controller = preg_replace('/\s+/', '', $apc);


                                                    echo "<option  class='" . $ap_controller . "' value='" . $apc . "'>" . $apc . "</option>";
                                                }
                                                ?>
                                            </select>
                                        <?php } ?>
                                    </div>

                                </div>


                                <!-- Cloudpath Policies -->

                                <div class="control-group">

                                    <div class="controls col-lg-5 form-group">
                                        <label for="dpsk_policies">CloudPath Policies<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <select name="dpsk_policies" id="dpsk_policies" class="span4 form-control">
                                            <option value="">CloudPath Policies</option>

                                            <?php
                                            $q1 = "SELECT * FROM `mdu_dpsk_policies` WHERE `controller`= '$edit_dpsk_controller'";

                                            $query_results = $db->selectDB($q1);

                                            foreach ($query_results['data'] as $row_s) {

                                                $dpsk_policies_id = $row_s['dpsk_policies_id'];
                                                $dpsk_policiesName = $row_s['dpsk_policiesName'];

                                                //echo $edit_dpsk_policies."==".$dpsk_policies_id;
                                                if ($edit_dpsk_policies == $dpsk_policies_id) {
                                                    $controller_sel = 'selected';
                                                } else {
                                                    $controller_sel = '';
                                                }

                                                echo "<option  " . $controller_sel . " value='" . $dpsk_policies_id . "'>" . $dpsk_policiesName . "</option>";
                                            }
                                            ?>


                                        </select>
                                        <a style="margin-top: 10px; padding: 6px 20px !important;" onclick="getdpsk_policies('sync')" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                        <div style="display: inline-block" id="cloud_policies_loader"></div>

                                    </div>

                                    <script type="text/javascript">
                                        function getdpsk_policies(get_type) {

                                            ctrl_name = document.getElementById("dpsk_conroller").value;

                                            var a = ctrl_name.length;

                                            if (a == 0) {

                                                alert('Please Select DPSKController before Refresh!');

                                            } else {
                                                document.getElementById("cloud_policies_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                $.ajax({
                                                    type: 'POST',
                                                    url: 'ajax/getdpsk_policies.php',
                                                    data: {
                                                        ctrl_name: ctrl_name,
                                                        get_type: get_type,
                                                        mno: "<?php echo $user_distributor; ?>"
                                                    },
                                                    success: function(data) {



                                                        $("#dpsk_policies").empty(data);
                                                        $("#dpsk_policies").append(data);



                                                        document.getElementById("cloud_policies_loader").innerHTML = "";

                                                    },
                                                    error: function() {
                                                        document.getElementById("cloud_policies_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                    }

                                                });

                                            }

                                        }
                                    </script>

                                </div>
                            </div>

                            <!-- Cloudpath Policies -->




                        </div>

                    </div>

                    <!-- /parent details -->

                    <!-- <hr> -->
                    <h3>Location Address</h3>

                    <div class="flex">
                        <div class="create_le">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="customer_type">Account Type<?php if ($field_array['account_type'] == "mandatory") { ?><sup>
                                            <font color="#FF0000"></font>
                                        </sup><?php } ?></label>
                                    <select tabindex="18" name="customer_type" id="customer_type" class="span4 form-control" <?php if ($field_array['account_type'] == "mandatory") { ?>required<?php } ?>>
                                        <option value="">Select Type</option>
                                        <?php

                                        if (array_key_exists('account_type', $field_array)) {

                                            $js_array = array();


                                            foreach ($parent_package_array as $value) {

                                                //$package_functions->getOptions('LOCATION_PACKAGE',$value);

                                                $location_package_ar = explode(',', $package_functions->getOptions('LOCATION_PACKAGE', $value));
                                                $produts = "'" . implode("','", $location_package_ar) . "'";
                                                $get_types_q = "SELECT p.`product_name`,p.`product_code`,c.options FROM `admin_product` p LEFT JOIN admin_product_controls c
                                       ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                                   WHERE `is_enable`='1' AND p.user_type='VENUE' AND p.product_code IN( $produts)";
                                                //"SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                                $get_types_r = $db->selectDB($get_types_q);

                                                $location_detail_ar = array();
                                                foreach ($get_types_r['data'] as $get_types) {
                                                    array_push($location_detail_ar, array("code" => $get_types[product_code], "name" => $get_types[product_name], "vt" => $get_types[options]));
                                                }

                                                $js_array[$value] = $location_detail_ar;
                                            }
                                        }
                                        //echo'**'. $edit_parent_package.'**';
                                        //print_r($js_array[$edit_parent_package]);
                                        if (isset($edit_parent_package)) {
                                            $produts = $js_array[$edit_parent_package];
                                            foreach ($produts as $value) {
                                                if ($edit_distributor_business_type == 'VTenant') {
                                                    $value['name'] = str_replace('MDU', 'VT', $value['name']);
                                                }
                                                

                                                if ($edit_distributor_system_package == $value['code']) {
                                        ?>
                                                    <option selected value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                            }
                                        } elseif (count($js_array) == 1) {
                                            foreach ($js_array as $adminValue) {

                                                foreach ($adminValue as $value) {
                                                ?>
                                                    <option value="<?php echo $value['code']; ?>" data-vt="<?php echo $value['vt']; ?>"><?php echo $value['name']; ?></option>
                                        <?php
                                                }
                                            }
                                        }
                                        //$get_types_q="SELECT `product_name`,`product_code` FROM `admin_product` WHERE `is_enable`='1' AND user_type='VENUE' AND product_code IN( $produts)";
                                        //$get_types_r=mysql_query($get_types_q);
                                        //while($get_types=mysql_fetch_assoc($get_types_r)){

                                        ?>
                                    </select>

                                </div>
                            </div>
                            <?php
                            if (array_key_exists('add1', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_address_1">Address<?php if ($field_array['add1'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="110" <?php if ($field_array['add1'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="mno_address_1" placeholder="Address" name="mno_address_1" type="text" value="<?php echo $edit_bussiness_address1; ?>">
                                    </div>
                                </div>
                            <?php }

                            if (array_key_exists('add3', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_address_3">Address 3<?php if ($field_array['add3'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input <?php if ($field_array['add3'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="mno_address_3" placeholder="Address Line 3" name="mno_address_3" type="text" value="<?php echo $edit_bussiness_address3; ?>">
                                    </div>
                                </div>
                            <?php }

                            if (array_key_exists('region', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_state">State/Region<?php if ($field_array['region'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <select tabindex="113" <?php if ($field_array['region'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="state" placeholder="State or Region" name="mno_state">
                                            <option value="">Select State</option>
                                            <?php
                                            $get_regions = $db->selectDB("SELECT
                              `states_code`,
                              `description`
                            FROM
                            `exp_country_states` ORDER BY description ASC");


                                            foreach ($get_regions['data'] as $state) {
                                                if ($edit_state_region == $state['states_code']) {
                                                    echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                } else {

                                                    echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                                                }
                                            }
                                            //echo '<option value="other">Other</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            <?php }

                            if (array_key_exists('country', $field_array) || $package_features == "all") {

                            ?>
                                <div class="control-group">

                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_country">Country<?php if ($field_array['country'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>

                                        <select tabindex="112" <?php if ($field_array['country'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> name="mno_country" id="country" class="span4 form-control">
                                            <option value="">Select Country</option>
                                            <?php

                                            // if(isset($edit_country_code)){
                                            //  echo '<option value="'.$edit_country_code.'">'.$edit_country_name.'</option>';
                                            //  }

                                            $count_results = $db->selectDB("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
UNION ALL
SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");

                                            foreach ($count_results['data'] as $row) {

                                                if ($row[a] == $edit_country_code || $row[a] == "US") {
                                                    $select = "selected";
                                                } else {
                                                    $select = "";
                                                }
                                                echo '<option value="' . $row[a] . '" ' . $select . '>' . $row[b] . '</option>';
                                            }
                                            ?>


                                        </select>


                                    </div>
                                </div>

                                <script type="text/javascript">
                                    // Countries
                                    var country_arr = new Array("United States of America", "Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

                                    // States
                                    var s_a = new Array();
                                    var s_a_val = new Array();
                                    s_a[0] = "";
                                    s_a_val[0] = "";
                                    <?php

                                    $get_regions = $db->selectDB("SELECT
                              `states_code`,
                              `description`
                            FROM 
                            `exp_country_states` ORDER BY description");

                                    $s_a = '';
                                    $s_a_val = '';


                                    foreach ($get_regions['data'] as $state) {
                                        $s_a .= $state['description'] . '|';
                                        $s_a_val .= $state['states_code'] . '|';
                                    }

                                    $s_a = rtrim($s_a, "|");
                                    $s_a_val = rtrim($s_a_val, "|");

                                    ?>
                                    s_a[1] = "<?php echo $s_a; ?>";
                                    s_a_val[1] = "<?php echo $s_a_val; ?>";
                                    s_a[2] = "Others";
                                    s_a[3] = "Others";
                                    s_a[4] = "Others";
                                    s_a[5] = "Others";
                                    s_a[6] = "Others";
                                    s_a[7] = "Others";
                                    s_a[8] = "Others";
                                    s_a[9] = "Others";
                                    s_a[10] = "Others";
                                    s_a[11] = "Others";
                                    s_a[12] = "Others";
                                    s_a[13] = "Others";
                                    s_a[14] = "Others";
                                    s_a[15] = "Others";
                                    s_a[16] = "Others";
                                    s_a[17] = "Others";
                                    s_a[18] = "Others";
                                    s_a[19] = "Others";
                                    s_a[20] = "Others";
                                    s_a[21] = "Others";
                                    s_a[22] = "Others";
                                    s_a[23] = "Others";
                                    s_a[24] = "Others";
                                    s_a[25] = "Others";
                                    s_a[26] = "Others";
                                    s_a[27] = "Others";
                                    s_a[28] = "Others";
                                    s_a[29] = "Others";
                                    s_a[30] = "Others";
                                    s_a[31] = "Others";
                                    s_a[32] = "Others";
                                    s_a[33] = "Others";
                                    s_a[34] = "Others";
                                    s_a[35] = "Others";
                                    s_a[36] = "Others";
                                    s_a[37] = "Others";
                                    s_a[38] = "Others";
                                    s_a[39] = "Others";
                                    s_a[40] = "Others";
                                    s_a[41] = "Others";
                                    s_a[42] = "Others";
                                    s_a[43] = "Others";
                                    s_a[44] = "Others";
                                    s_a[45] = "Others";
                                    s_a[46] = "Others";
                                    s_a[47] = "Others";
                                    s_a[48] = "Others";
                                    // <!-- -->
                                    s_a[49] = "Others";
                                    s_a[50] = "Others";
                                    s_a[51] = "Others";
                                    s_a[52] = "Others";
                                    s_a[53] = "Others";
                                    s_a[54] = "Others";
                                    s_a[55] = "Others";
                                    s_a[56] = "Others";
                                    s_a[57] = "Others";
                                    s_a[58] = "Others";
                                    s_a[59] = "Others";
                                    s_a[60] = "Others";
                                    s_a[61] = "Others";
                                    s_a[62] = "Others";
                                    // <!-- -->
                                    s_a[63] = "Others";
                                    s_a[64] = "Others";
                                    s_a[65] = "Others";
                                    s_a[66] = "Others";
                                    s_a[67] = "Others";
                                    s_a[68] = "Others";
                                    s_a[69] = "Others";
                                    s_a[70] = "Others";
                                    s_a[71] = "Others";
                                    s_a[72] = "Others";
                                    s_a[73] = "Others";
                                    s_a[74] = "Others";
                                    s_a[75] = "Others";
                                    s_a[76] = "Others";
                                    s_a[77] = "Others";
                                    s_a[78] = "Others";
                                    s_a[79] = "Others";
                                    s_a[80] = "Others";
                                    s_a[81] = "Others";
                                    s_a[82] = "Others";
                                    s_a[83] = "Others";
                                    s_a[84] = "Others";
                                    s_a[85] = "Others";
                                    s_a[86] = "Others";
                                    s_a[87] = "Others";
                                    s_a[88] = "Others";
                                    s_a[89] = "Others";
                                    s_a[90] = "Others";
                                    s_a[91] = "Others";
                                    s_a[92] = "Others";
                                    s_a[93] = "Others";
                                    s_a[94] = "Others";
                                    s_a[95] = "Others";
                                    s_a[96] = "Others";
                                    s_a[97] = "Others";
                                    s_a[98] = "Others";
                                    s_a[99] = "Others";
                                    s_a[100] = "Others";
                                    s_a[101] = "Others";
                                    s_a[102] = "Others";
                                    s_a[103] = "Others";
                                    s_a[104] = "Others";
                                    s_a[105] = "Others";
                                    s_a[106] = "Others";
                                    s_a[107] = "Others";
                                    s_a[108] = "Others";
                                    s_a[109] = "Others";
                                    s_a[110] = "Others";
                                    s_a[111] = "Others";
                                    s_a[112] = "Others";
                                    s_a[113] = "Others";
                                    s_a[114] = "Others";
                                    s_a[115] = "Others";
                                    s_a[116] = "Others";
                                    s_a[117] = "Others";
                                    s_a[118] = "Others";
                                    s_a[119] = "Others";
                                    s_a[120] = "Others";
                                    s_a[121] = "Others";
                                    s_a[122] = "Others";
                                    s_a[123] = "Others";
                                    s_a[124] = "Others";
                                    s_a[125] = "Others";
                                    s_a[126] = "Others";
                                    s_a[127] = "Others";
                                    s_a[128] = "Others";
                                    s_a[129] = "Others";
                                    s_a[130] = "Others";
                                    s_a[131] = "Others";
                                    s_a[132] = "Others";
                                    s_a[133] = "Others";
                                    s_a[134] = "Others";
                                    s_a[135] = "Others";
                                    s_a[136] = "Others";
                                    s_a[137] = "Others";
                                    s_a[138] = "Others";
                                    s_a[139] = "Others";
                                    s_a[140] = "Others";
                                    s_a[141] = "Others";
                                    s_a[142] = "Others";
                                    s_a[143] = "Others";
                                    s_a[144] = "Others";
                                    s_a[145] = "Others";
                                    s_a[146] = "Others";
                                    s_a[147] = "Others";
                                    s_a[148] = "Others";
                                    s_a[149] = "Others";
                                    s_a[150] = "Others";
                                    s_a[151] = "Others";
                                    s_a[152] = "Others";
                                    s_a[153] = "Others";
                                    s_a[154] = "Others";
                                    s_a[155] = "Others";
                                    s_a[156] = "Others";
                                    s_a[157] = "Others";
                                    s_a[158] = "Others";
                                    s_a[159] = "Others";
                                    s_a[160] = "Others";
                                    s_a[161] = "Others";
                                    s_a[162] = "Others";
                                    s_a[163] = "Others";
                                    s_a[164] = "Others";
                                    s_a[165] = "Others";
                                    s_a[166] = "Others";
                                    s_a[167] = "Others";
                                    s_a[168] = "Others";
                                    s_a[169] = "Others";
                                    s_a[170] = "Others";
                                    s_a[171] = "Others";
                                    s_a[172] = "Others";
                                    s_a[173] = "Others";
                                    s_a[174] = "Others";
                                    s_a[175] = "Others";
                                    s_a[176] = "Others";
                                    s_a[177] = "Others";
                                    s_a[178] = "Others";
                                    s_a[179] = "Others";
                                    s_a[180] = "Others";
                                    s_a[181] = "Others";
                                    s_a[182] = "Others";
                                    s_a[183] = "Others";
                                    s_a[184] = "Others";
                                    s_a[185] = "Others";
                                    s_a[186] = "Others";
                                    s_a[187] = "Others";
                                    s_a[188] = "Others";
                                    s_a[189] = "Others";
                                    s_a[190] = "Others";
                                    s_a[191] = "Others";
                                    s_a[192] = "Others";
                                    s_a[193] = "Others";
                                    s_a[194] = "Others";
                                    s_a[195] = "Others";
                                    s_a[196] = "Others";
                                    s_a[197] = "Others";
                                    s_a[198] = "Others";
                                    s_a[199] = "Others";
                                    s_a[200] = "Others";
                                    s_a[201] = "Others";
                                    s_a[202] = "Others";
                                    s_a[203] = "Others";
                                    s_a[204] = "Others";
                                    s_a[205] = "Others";
                                    s_a[206] = "Others";
                                    s_a[207] = "Others";
                                    s_a[208] = "Others";
                                    s_a[209] = "Others";
                                    s_a[210] = "Others";
                                    s_a[211] = "Others";
                                    s_a[212] = "Others";
                                    s_a[213] = "Others";
                                    s_a[214] = "Others";
                                    s_a[215] = "Others";
                                    s_a[216] = "Others";
                                    s_a[217] = "Others";
                                    s_a[218] = "Others";
                                    s_a[219] = "Others";
                                    s_a[220] = "Others";
                                    s_a[221] = "Others";
                                    s_a[222] = "Others";
                                    s_a[223] = "Others";
                                    s_a[224] = "Others";
                                    s_a[225] = "Others";
                                    s_a[226] = "Others";
                                    s_a[227] = "Others";
                                    s_a[228] = "Others";
                                    s_a[229] = "Others";
                                    s_a[230] = "Others";
                                    s_a[231] = "Others";
                                    s_a[232] = "Others";
                                    s_a[233] = "Others";
                                    s_a[234] = "Others";
                                    s_a[235] = "Others";
                                    s_a[236] = "Others";
                                    s_a[237] = "Others";
                                    s_a[238] = "Others";
                                    s_a[239] = "Others";
                                    s_a[240] = "Others";
                                    s_a[241] = "Others";
                                    s_a[242] = "Others";
                                    s_a[243] = "Others";
                                    s_a[244] = "Others";
                                    s_a[245] = "Others";
                                    s_a[246] = "Others";
                                    s_a[247] = "Others";
                                    s_a[248] = "Others";
                                    s_a[249] = "Others";
                                    s_a[250] = "Others";
                                    s_a[251] = "Others";
                                    s_a[252] = "Others";


                                    s_a_val[2] = "N/A";
                                    s_a_val[3] = "N/A";
                                    s_a_val[4] = "N/A";
                                    s_a_val[5] = "N/A";
                                    s_a_val[6] = "N/A";
                                    s_a_val[7] = "N/A";
                                    s_a_val[8] = "N/A";
                                    s_a_val[9] = "N/A";
                                    s_a_val[10] = "N/A";
                                    s_a_val[11] = "N/A";
                                    s_a_val[12] = "N/A";
                                    s_a_val[13] = "N/A";
                                    s_a_val[14] = "N/A";
                                    s_a_val[15] = "N/A";
                                    s_a_val[16] = "N/A";
                                    s_a_val[17] = "N/A";
                                    s_a_val[18] = "N/A";
                                    s_a_val[19] = "N/A";
                                    s_a_val[20] = "N/A";
                                    s_a_val[21] = "N/A";
                                    s_a_val[22] = "N/A";
                                    s_a_val[23] = "N/A";
                                    s_a_val[24] = "N/A";
                                    s_a_val[25] = "N/A";
                                    s_a_val[26] = "N/A";
                                    s_a_val[27] = "N/A";
                                    s_a_val[28] = "N/A";
                                    s_a_val[29] = "N/A";
                                    s_a_val[30] = "N/A";
                                    s_a_val[31] = "N/A";
                                    s_a_val[32] = "N/A";
                                    s_a_val[33] = "N/A";
                                    s_a_val[34] = "N/A";
                                    s_a_val[35] = "N/A";
                                    s_a_val[36] = "N/A";
                                    s_a_val[37] = "N/A";
                                    s_a_val[38] = "N/A";
                                    s_a_val[39] = "N/A";
                                    s_a_val[40] = "N/A";
                                    s_a_val[41] = "N/A";
                                    s_a_val[42] = "N/A";
                                    s_a_val[43] = "N/A";
                                    s_a_val[44] = "N/A";
                                    s_a_val[45] = "N/A";
                                    s_a_val[46] = "N/A";
                                    s_a_val[47] = "N/A";
                                    s_a_val[48] = "N/A";
                                    // <!-- -->
                                    s_a_val[49] = "N/A";
                                    s_a_val[50] = "N/A";
                                    s_a_val[51] = "N/A";
                                    s_a_val[52] = "N/A";
                                    s_a_val[53] = "N/A";
                                    s_a_val[54] = "N/A";
                                    s_a_val[55] = "N/A";
                                    s_a_val[56] = "N/A";
                                    s_a_val[57] = "N/A";
                                    s_a_val[58] = "N/A";
                                    s_a_val[59] = "N/A";
                                    s_a_val[60] = "N/A";
                                    s_a_val[61] = "N/A";
                                    s_a_val[62] = "N/A";
                                    // <!-- -->
                                    s_a_val[63] = "N/A";
                                    s_a_val[64] = "N/A";
                                    s_a_val[65] = "N/A";
                                    s_a_val[66] = "N/A";
                                    s_a_val[67] = "N/A";
                                    s_a_val[68] = "N/A";
                                    s_a_val[69] = "N/A";
                                    s_a_val[70] = "N/A";
                                    s_a_val[71] = "N/A";
                                    s_a_val[72] = "N/A";
                                    s_a_val[73] = "N/A";
                                    s_a_val[74] = "N/A";
                                    s_a_val[75] = "N/A";
                                    s_a_val[76] = "N/A";
                                    s_a_val[77] = "N/A";
                                    s_a_val[78] = "N/A";
                                    s_a_val[79] = "N/A";
                                    s_a_val[80] = "N/A";
                                    s_a_val[81] = "N/A";
                                    s_a_val[82] = "N/A";
                                    s_a_val[83] = "N/A";
                                    s_a_val[84] = "N/A";
                                    s_a_val[85] = "N/A";
                                    s_a_val[86] = "N/A";
                                    s_a_val[87] = "N/A";
                                    s_a_val[88] = "N/A";
                                    s_a_val[89] = "N/A";
                                    s_a_val[90] = "N/A";
                                    s_a_val[91] = "N/A";
                                    s_a_val[92] = "N/A";
                                    s_a_val[93] = "N/A";
                                    s_a_val[94] = "N/A";
                                    s_a_val[95] = "N/A";
                                    s_a_val[96] = "N/A";
                                    s_a_val[97] = "N/A";
                                    s_a_val[98] = "N/A";
                                    s_a_val[99] = "N/A";
                                    s_a_val[100] = "N/A";
                                    s_a_val[101] = "N/A";
                                    s_a_val[102] = "N/A";
                                    s_a_val[103] = "N/A";
                                    s_a_val[104] = "N/A";
                                    s_a_val[105] = "N/A";
                                    s_a_val[106] = "N/A";
                                    s_a_val[107] = "N/A";
                                    s_a_val[108] = "N/A";
                                    s_a_val[109] = "N/A";
                                    s_a_val[110] = "N/A";
                                    s_a_val[111] = "N/A";
                                    s_a_val[112] = "N/A";
                                    s_a_val[113] = "N/A";
                                    s_a_val[114] = "N/A";
                                    s_a_val[115] = "N/A";
                                    s_a_val[116] = "N/A";
                                    s_a_val[117] = "N/A";
                                    s_a_val[118] = "N/A";
                                    s_a_val[119] = "N/A";
                                    s_a_val[120] = "N/A";
                                    s_a_val[121] = "N/A";
                                    s_a_val[122] = "N/A";
                                    s_a_val[123] = "N/A";
                                    s_a_val[124] = "N/A";
                                    s_a_val[125] = "N/A";
                                    s_a_val[126] = "N/A";
                                    s_a_val[127] = "N/A";
                                    s_a_val[128] = "N/A";
                                    s_a_val[129] = "N/A";
                                    s_a_val[130] = "N/A";
                                    s_a_val[131] = "N/A";
                                    s_a_val[132] = "N/A";
                                    s_a_val[133] = "N/A";
                                    s_a_val[134] = "N/A";
                                    s_a_val[135] = "N/A";
                                    s_a_val[136] = "N/A";
                                    s_a_val[137] = "N/A";
                                    s_a_val[138] = "N/A";
                                    s_a_val[139] = "N/A";
                                    s_a_val[140] = "N/A";
                                    s_a_val[141] = "N/A";
                                    s_a_val[142] = "N/A";
                                    s_a_val[143] = "N/A";
                                    s_a_val[144] = "N/A";
                                    s_a_val[145] = "N/A";
                                    s_a_val[146] = "N/A";
                                    s_a_val[147] = "N/A";
                                    s_a_val[148] = "N/A";
                                    s_a_val[149] = "N/A";
                                    s_a_val[150] = "N/A";
                                    s_a_val[151] = "N/A";
                                    s_a_val[152] = "N/A";
                                    s_a_val[153] = "N/A";
                                    s_a_val[154] = "N/A";
                                    s_a_val[155] = "N/A";
                                    s_a_val[156] = "N/A";
                                    s_a_val[157] = "N/A";
                                    s_a_val[158] = "N/A";
                                    s_a_val[159] = "N/A";
                                    s_a_val[160] = "N/A";
                                    s_a_val[161] = "N/A";
                                    s_a_val[162] = "N/A";
                                    s_a_val[163] = "N/A";
                                    s_a_val[164] = "N/A";
                                    s_a_val[165] = "N/A";
                                    s_a_val[166] = "N/A";
                                    s_a_val[167] = "N/A";
                                    s_a_val[168] = "N/A";
                                    s_a_val[169] = "N/A";
                                    s_a_val[170] = "N/A";
                                    s_a_val[171] = "N/A";
                                    s_a_val[172] = "N/A";
                                    s_a_val[173] = "N/A";
                                    s_a_val[174] = "N/A";
                                    s_a_val[175] = "N/A";
                                    s_a_val[176] = "N/A";
                                    s_a_val[177] = "N/A";
                                    s_a_val[178] = "N/A";
                                    s_a_val[179] = "N/A";
                                    s_a_val[180] = "N/A";
                                    s_a_val[181] = "N/A";
                                    s_a_val[182] = "N/A";
                                    s_a_val[183] = "N/A";
                                    s_a_val[184] = "N/A";
                                    s_a_val[185] = "N/A";
                                    s_a_val[186] = "N/A";
                                    s_a_val[187] = "N/A";
                                    s_a_val[188] = "N/A";
                                    s_a_val[189] = "N/A";
                                    s_a_val[190] = "N/A";
                                    s_a_val[191] = "N/A";
                                    s_a_val[192] = "N/A";
                                    s_a_val[193] = "N/A";
                                    s_a_val[194] = "N/A";
                                    s_a_val[195] = "N/A";
                                    s_a_val[196] = "N/A";
                                    s_a_val[197] = "N/A";
                                    s_a_val[198] = "N/A";
                                    s_a_val[199] = "N/A";
                                    s_a_val[200] = "N/A";
                                    s_a_val[201] = "N/A";
                                    s_a_val[202] = "N/A";
                                    s_a_val[203] = "N/A";
                                    s_a_val[204] = "N/A";
                                    s_a_val[205] = "N/A";
                                    s_a_val[206] = "N/A";
                                    s_a_val[207] = "N/A";
                                    s_a_val[208] = "N/A";
                                    s_a_val[209] = "N/A";
                                    s_a_val[210] = "N/A";
                                    s_a_val[211] = "N/A";
                                    s_a_val[212] = "N/A";
                                    s_a_val[213] = "N/A";
                                    s_a_val[214] = "N/A";
                                    s_a_val[215] = "N/A";
                                    s_a_val[216] = "N/A";
                                    s_a_val[217] = "N/A";
                                    s_a_val[218] = "N/A";
                                    s_a_val[219] = "N/A";
                                    s_a_val[220] = "N/A";
                                    s_a_val[221] = "N/A";
                                    s_a_val[222] = "N/A";
                                    s_a_val[223] = "N/A";
                                    s_a_val[224] = "N/A";
                                    s_a_val[225] = "N/A";
                                    s_a_val[226] = "N/A";
                                    s_a_val[227] = "N/A";
                                    s_a_val[228] = "N/A";
                                    s_a_val[229] = "N/A";
                                    s_a_val[230] = "N/A";
                                    s_a_val[231] = "N/A";
                                    s_a_val[232] = "N/A";
                                    s_a_val[233] = "N/A";
                                    s_a_val[234] = "N/A";
                                    s_a_val[235] = "N/A";
                                    s_a_val[236] = "N/A";
                                    s_a_val[237] = "N/A";
                                    s_a_val[238] = "N/A";
                                    s_a_val[239] = "N/A";
                                    s_a_val[240] = "N/A";
                                    s_a_val[241] = "N/A";
                                    s_a_val[242] = "N/A";
                                    s_a_val[243] = "N/A";
                                    s_a_val[244] = "N/A";
                                    s_a_val[245] = "N/A";
                                    s_a_val[246] = "N/A";
                                    s_a_val[247] = "N/A";
                                    s_a_val[248] = "N/A";
                                    s_a_val[249] = "N/A";
                                    s_a_val[250] = "N/A";
                                    s_a_val[251] = "N/A";
                                    s_a_val[252] = "N/A";

                                    function populateStates(countryElementId, stateElementId) {

                                        var selectedCountryIndex = document.getElementById(countryElementId).selectedIndex;


                                        var stateElement = document.getElementById(stateElementId);

                                        stateElement.length = 0; // Fixed by Julian Woods
                                        stateElement.options[0] = new Option('Select State', '');
                                        stateElement.selectedIndex = 0;

                                        var state_arr = s_a[selectedCountryIndex].split("|");
                                        var state_arr_val = s_a_val[selectedCountryIndex].split("|");

                                        if (selectedCountryIndex != 0) {
                                            for (var i = 0; i < state_arr.length; i++) {
                                                stateElement.options[stateElement.length] = new Option(state_arr[i], state_arr_val[i]);
                                            }
                                        }

                                    }

                                    function populateCountries(countryElementId, stateElementId) {

                                        var countryElement = document.getElementById(countryElementId);

                                        if (stateElementId) {
                                            countryElement.onchange = function() {
                                                populateStates(countryElementId, stateElementId);
                                            };
                                        }
                                    }
                                </script>

                                <script language="javascript">
                                    populateCountries("country", "state");
                                    // populateCountries("country");
                                </script>
                                <!-- /controls -->
                            <?php
                            }
                            if (array_key_exists('phone2', $field_array) || $package_features == "all") {
                                ?>
                                    <div class="control-group">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="mno_mobile">Phone Number 2<?php if ($field_array['phone3'] == "mandatory") { ?><sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?></label>
                                            <input tabindex="115" <?php if ($field_array['phone3'] == "mandatory") { ?>required<?php } ?> class="span4 form-control mobile3_vali" id="mno_mobile_3" name="mno_mobile_3" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo $edit_phone3; ?>">
                                        </div>
                                    </div>
    
                                    <script type="text/javascript">
                                        $(document).ready(function() {
    
                                            $('.mobile3_vali').focus(function() {
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                                $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                            });
    
                                            $('.mobile3_vali').keyup(function() {
                                              var phone_1 = $(this).val().replace(/[^\d]/g, "");
                                              if (phone_1.length > 9) {
                                                //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                                                var phone2 = phone_1.length;
                                                if (phone_1.length > 10) {
                                                  var phone2 = phone_1.length;
                                                  $('#location_form')
                                                            .bootstrapValidator('enableFieldValidators', 'mno_mobile_3', false);
                                                  var phone_1 = phone_1.slice(0,10);
                                                            
                                                            }
                                                          $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                                          //console.log(phone_1+'sss');
                                                          if (phone2 == 10) {
                                                              $('#location_form')
                                                            .bootstrapValidator('enableFieldValidators', 'mno_mobile_3', true);
                                                        }

                                                          }
                                                          else{
                                              $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                              $('#location_form')
                                                            .bootstrapValidator('enableFieldValidators', 'mno_mobile_3', true)
                                              }
                                              
                                            $('#location_form').bootstrapValidator('revalidateField', 'mno_mobile_3');
                                          });
    
                                            //$('#mno_mobile_3').val($('#mno_mobile_3').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
    
    
                                            $(".mobile3_vali").keydown(function(e) {
    
    
                                                var mac = $('.mobile3_vali').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);
    
                                                if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                                                    mac1 = mac.replace(/[^0-9]/g, '');
    
    
                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);
    
                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);
    
                                                } else {
    
                                                    if (len == 4) {
                                                        $('.mobile3_vali').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                            //console.log('mac1 ' + mac);
    
                                                        });
                                                    } else if (len == 8) {
                                                        $('.mobile3_vali').val(function() {
                                                            return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                                            //console.log('mac2 ' + mac);
    
                                                        });
                                                    }
                                                }
    
    
                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                                                    // Allow: Ctrl+A, Command+A
                                                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                    // Allow: Ctrl+C, Command+C
                                                    (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                    // Allow: Ctrl+x, Command+x
                                                    (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                    // Allow: Ctrl+V, Command+V
                                                    (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                                                    // Allow: home, end, left, right, down, up
                                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();
    
                                                }
                                                $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_3', 'NOT_VALIDATED').validateField('mno_mobile_3');
                                            });
    
    
                                        });
                                    </script>
    
                                <?php }

                            if (array_key_exists('time_zone', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_timezone">Time Zone <?php if ($field_array['time_zone'] == "mandatory" || $package_features == "all") { ?><sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?></label>
                                        <select tabindex="118" <?php if ($field_array['time_zone'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="mno_time_zone" name="mno_time_zone">
                                            <option value="">Select Time Zone</option>
                                            <?php

                                            $utc = new DateTimeZone('UTC');
                                            $dt = new DateTime('now', $utc);
                                            foreach ($priority_zone_array as $tz) {
                                                $current_tz = new DateTimeZone($tz);
                                                $offset =  $current_tz->getOffset($dt);
                                                $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                $abbr = $transition[0]['abbr'];
                                                if ($edit_timezone == $tz) {
                                                    $select = "selected";
                                                } else {
                                                    $select = "";
                                                }
                                                echo '<option ' . $select . ' value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
                                            }

                                            foreach (DateTimeZone::listIdentifiers() as $tz) {
                                                //Skip
                                                if (in_array($tz, $priority_zone_array))
                                                    continue;

                                                $current_tz = new DateTimeZone($tz);
                                                $offset =  $current_tz->getOffset($dt);
                                                $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                $abbr = $transition[0]['abbr'];
                                                if ($edit_timezone == $tz) {
                                                    $select = "selected";
                                                }
                                                echo '<option ' . $select . ' value="' . $tz . '">' . $tz . ' [' . $abbr . ' ' . CommonFunctions::formatOffset($offset) . ']</option>';
                                                $select = "";
                                            }

                                            /*

                                         foreach(DateTimeZone::listIdentifiers() as $tz) {
                                             $current_tz = new DateTimeZone($tz);
                                             $offset =  $current_tz->getOffset($dt);
                                             $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                             $abbr = $transition[0]['abbr'];
                                             if($abbr!="EST" || $abbr!="CT" || $abbr!="MT" || $abbr!="PST" || $abbr!="AKST" || $abbr!="HST" || $abbr!="EDT"){
                                             if($edit_timezone==$tz){
                                                 $select="selected";
                                             }
                                             echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
                                                $select="";

                                            }
                                         }*/

                                            ?>
                                        </select>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>

                        <div class="create_re">
                            <?php if (array_key_exists('account_name', $field_array) || $package_features == "all") {
                            ?>
                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="location_name1">Account Name<?php if ($field_array['account_name'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>

                                        <input tabindex="19" <?php if ($field_array['account_name'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="location_name1" placeholder="ABC Shopping Mall" name="location_name1" type="text" value="<?php echo str_replace("\\", '', $edit_distributor_name); ?>" />
                                        <input <?php if ($field_array['account_name'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> id="location_name_old" name="location_name_old" type="hidden" value="<?php echo str_replace("\\", '', $edit_distributor_name); ?>" />

                                    </div>
                                </div>
                            <?php }
                            if (array_key_exists('add2', $field_array) || $package_features == "all") {
                            ?>

                                <div class="control-group">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="mno_address_2">City<?php if ($field_array['add2'] == "mandatory" || $package_features == "all") { ?><sup>
                                                <font color="#FF0000"></font>
                                            </sup><?php } ?></label>
                                        <input tabindex="111" <?php if ($field_array['add2'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control" id="mno_address_2" placeholder="City" name="mno_address_2" type="text" value="<?php echo $edit_bussiness_address2; ?>">
                                    </div>
                                </div>
                            <?php }

if (array_key_exists('zip_code', $field_array) || $package_features == "all") {

    ?>

        <div class="control-group">
            <div class="controls col-lg-5 form-group">
                <label for="mno_region">ZIP Code<?php if ($field_array['zip_code'] == "mandatory" || $package_features == "all") { ?><sup>
                        <font color="#FF0000"></font>
                    </sup><?php } ?></label>
                <input tabindex="117" <?php if ($field_array['zip_code'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control zip_vali" id="mno_zip_code" maxlength="5" placeholder="XXXXX" name="mno_zip_code" type="text" value="<?php echo $edit_zip; ?>">
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {



                $(".zip_vali").keydown(function(e) {


                    var mac = $('.zip_vali').val();
                    var len = mac.length + 1;
                    //console.log(e.keyCode);
                    //console.log('len '+ len);


                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+C, Command+C
                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+x, Command+x
                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+V, Command+V
                        (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();

                    }
                });


            });
        </script>

    <?php
    }

    if (array_key_exists('phone1', $field_array) || $package_features == "all") {
        ?>
            <div class="control-group">
                <div class="controls col-lg-5 form-group">
                    <label for="mno_mobile">Phone Number 1<?php if ($field_array['phone1'] == "mandatory" || $package_features == "all") { ?><sup>
                            <font color="#FF0000"></font>
                        </sup><?php } ?></label>
                    <input tabindex="114" <?php if ($field_array['phone1'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> class="span4 form-control mobile1_vali" id="mno_mobile_1" name="mno_mobile_1" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo $edit_phone1; ?>">
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {

                    $('.mobile1_vali').focus(function() {
                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                        $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                    });

                    $('.mobile1_vali').keyup(function() {
                  var phone_1 = $(this).val().replace(/[^\d]/g, "");
                  if (phone_1.length > 9) {
                    //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                    var phone2 = phone_1.length;
                    if (phone_1.length > 10) {
                      var phone2 = phone_1.length;
                      $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_1', false);
                      var phone_1 = phone_1.slice(0,10);
                                
                                }
                              $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                              //console.log(phone_1+'sss');
                              if (phone2 == 10) {
                                  $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_1', true);
                            }

                              }
                              else{
                  $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                  $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_1', true)
                  }
                  
                $('#location_form').bootstrapValidator('revalidateField', 'mno_mobile_1');
              });
                    //$('#mno_mobile_1').val($('#mno_mobile_1').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));

                    $(".mobile1_vali").keydown(function(e) {


                        var mac = $('.mobile1_vali').val();
                        var len = mac.length + 1;
                        //console.log(e.keyCode);
                        //console.log('len '+ len);

                        if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                            mac1 = mac.replace(/[^0-9]/g, '');


                            //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                            //console.log(valu);
                            //$('#phone_num_val').val(valu);

                        } else {

                            if (len == 4) {
                                $('.mobile1_vali').val(function() {
                                    return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                    //console.log('mac1 ' + mac);

                                });
                            } else if (len == 8) {
                                $('.mobile1_vali').val(function() {
                                    return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                    //console.log('mac2 ' + mac);

                                });
                            }
                        }


                        // Allow: backspace, delete, tab, escape, enter, '-' and .
                        if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                            // Allow: Ctrl+A, Command+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: Ctrl+C, Command+C
                            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: Ctrl+x, Command+x
                            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: Ctrl+V, Command+V
                            (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                            (e.keyCode >= 35 && e.keyCode <= 40)) {
                            // let it happen, don't do anything
                            return;
                        }
                        // Ensure that it is a number and stop the keypress
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();

                        }

                        $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_1', 'NOT_VALIDATED').validateField('mno_mobile_1');

                    });


                });
            </script>

        <?php }

if (array_key_exists('phone3', $field_array) || $package_features == "all") {
    ?>

        <div class="control-group">
            <div class="controls col-lg-5 form-group">
                <label for="mno_mobile">Phone Number 3<?php if ($field_array['phone2'] == "mandatory") { ?><sup>
                        <font color="#FF0000"></font>
                    </sup><?php } ?></label>
                <input tabindex="116" <?php if ($field_array['phone2'] == "mandatory") { ?>required<?php } ?> class="span4 form-control mobile2_vali" id="mno_mobile_2" name="mno_mobile_2" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo $edit_phone2; ?>">
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {

                $('.mobile2_vali').focus(function() {
                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');

                });

                $('.mobile2_vali').keyup(function() {
                  var phone_1 = $(this).val().replace(/[^\d]/g, "");
                  if (phone_1.length > 9) {
                    //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                    var phone2 = phone_1.length;
                    if (phone_1.length > 10) {
                      var phone2 = phone_1.length;
                      $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_2', false);
                      var phone_1 = phone_1.slice(0,10);
                                
                                }
                              $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                              //console.log(phone_1+'sss');
                              if (phone2 == 10) {
                                  $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_2', true);
                            }

                              }
                              else{
                  $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                  $('#location_form')
                                .bootstrapValidator('enableFieldValidators', 'mno_mobile_2', true)
                  }
                  
                $('#location_form').bootstrapValidator('revalidateField', 'mno_mobile_2');
              });

                //$('#mno_mobile_2').val($('#mno_mobile_2').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


                $(".mobile2_vali").keydown(function(e) {


                    var mac = $('.mobile2_vali').val();
                    var len = mac.length + 1;
                    //console.log(e.keyCode);
                    //console.log('len '+ len);

                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)) {
                        mac1 = mac.replace(/[^0-9]/g, '');


                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                        //console.log(valu);
                        //$('#phone_num_val').val(valu);

                    } else {

                        if (len == 4) {
                            $('.mobile2_vali').val(function() {
                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                //console.log('mac1 ' + mac);

                            });
                        } else if (len == 8) {
                            $('.mobile2_vali').val(function() {
                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                //console.log('mac2 ' + mac);

                            });
                        }
                    }


                    // Allow: backspace, delete, tab, escape, enter, '-' and .
                    if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+C, Command+C
                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+x, Command+x
                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl+V, Command+V
                        (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();

                    }
                    $('#location_form').data('bootstrapValidator').updateStatus('mno_mobile_2', 'NOT_VALIDATED').validateField('mno_mobile_2');
                });


            });
        </script>

    <?php }
                        
                            if (array_key_exists('time_zone', $field_array) || $package_features == "all") {
                            }
                            ?>
                        </div>
                    </div>


                </fieldset>

                <fieldset id="network_control" data-name="Controller Info">
                    <h3 class="wired_div">Controller Info</h3>

                    <?php

                    if ($edit_wired_enable == 1) {
                        echo '<script type="text/javascript">
    window.onload = function () { 

        ed_wired_control(' . $edit_wired_enable . ');
       
    }
</script>';
                    }
                    $support_user = true;
                    if (!in_array('support', $access_modules_list) || $edit_wired_enable == 1) {
                        $support_user = false; ?>



                        <div class="control-group">
                            <div class="col-lg-5 form-group">
                                <label>Wired Property
                                </label>
                                <input id="wired_property" name="wired_property" onchange="wired_control()" type="checkbox" value="1" data-size="mini" <?php if ($edit_wired_enable == 1) { ?> checked="checked" <?php } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">


                                <div id="automation_div" class="wired_div">
                                    <label>Automation
                                    </label>
                                    <input id="automation_property" name="automation_property" onchange="automation_control()" type="checkbox" data-size="mini" <?php if ($edit_automation_enable == 1) { ?> checked="checked" <?php } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">

                                </div>
                            </div>
                        </div>
                        <div class="create_l">
                            <div class="control-group wired_div">
                                <div class="controls col-lg-5 form-group">
                                    <input type="hidden" name="old_conroller" id="old_conroller" value="<?php echo $edit_distributor_ap_controller; ?>">
                                    <label for="conroller">AP Controller<sup></sup></label>
                                    <select onchange="updatevariable(); selwags(this.value);gotoNode(this.value);seldns(this.value);controllerdiv(1,this.value);" name="conroller" id="conroller" class="span4 form-control con_c" required>
                                        <option value="">Select AP Controller</option>
                                        <?php
                                        $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                      FROM exp_mno_ap_controller
                                      LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='AP'";

                                        $query_results = $db->selectDB($q1);

                                        foreach ($query_results['data'] as $row) {

                                            //$mnoid=$row[mno_id];
                                            $apc = $row[ap_controller];

                                            $ap_controller = preg_replace('/\s+/', '', $apc);
                                            if ($edit_distributor_ap_controller == $apc) {
                                                $controller_sel = 'selected';
                                            } else {
                                                $controller_sel = '';
                                            }

                                            echo "<option   " . $controller_sel . "  class='" . $ap_controller . "' value='" . $apc . "'>" . $apc . "</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <!-- /controls -->
                            </div>
                            <!-- /control-group -->
                            <?php
                            if (isset($edit_distributor_ap_controller)) {
                            ?>

                                <script>
                                    $(document).ready(function() {
                                        gotoNode_edit('<?php echo $edit_distributor_ap_controller; ?>', '<?php echo $edit_distributor_zone_id; ?>');
                                    });

                                    function gotoNode_edit(scrt_var, edit_zone) {
                                        var a = scrt_var.length;

                                        if (a == 0) {
                                            <?php if ($edit_wired_enable != 1) {  ?>
                                                alert('Please Select Controller before Refresh!');
                                            <?php } ?>
                                        } else {
                                            document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                            //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                            $.ajax({
                                                type: 'POST',
                                                url: 'ajax/get_zones.php',
                                                data: {
                                                    wag_ap_name: "<?php echo $wag_ap_name; ?>",
                                                    ap_control_var: "<?php echo $ap_control_var; ?>",
                                                    ackey: scrt_var,
                                                    mno: "<?php echo $user_distributor; ?>",
                                                    mvno: "<?php echo $edit_distributor_code; ?>",
                                                    edit_zone: edit_zone
                                                },
                                                success: function(data) {

                                                    /* alert(data); */
                                                    $('#zone').empty();

                                                    $("#zone").append(data);


                                                    document.getElementById("zones_loader").innerHTML = "";

                                                },
                                                error: function() {
                                                    document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                }

                                            });
                                        }

                                    }
                                </script>
                            <?php
                            }
                            ?>
                            <script type="text/javascript">
                                var value = "test";

                                function updatevariable() {
                                    var conceptName = $("#conroller").val();
                                    value = conceptName;
                                    scrt_var = conceptName;

                                    $("#zone").select2();

                                }

                                $(document).ready(function() {
                                    updatevariable();
                                });

                                function gotoNode(scrt_var) {


                                    var a = scrt_var.length;

                                    if (a == 0) {

                                        alert('Please Select Controller before Refresh!');

                                    } else {
                                        document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajax/get_zones.php',
                                            data: {
                                                wag_ap_name: "<?php echo $wag_ap_name; ?>",
                                                ap_control_var: "<?php echo $ap_control_var; ?>",
                                                ackey: scrt_var,
                                                mno: "<?php echo $user_distributor; ?>",
                                                mvno: "<?php echo $edit_distributor_code; ?>"
                                            },
                                            success: function(data) {

                                                /* alert(data); */
                                                $('#zone').empty();

                                                $("#zone").append(data);


                                                document.getElementById("zones_loader").innerHTML = "";

                                            },
                                            error: function() {
                                                document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                            }

                                        });
                                    }

                                }
                            </script>


                            <script src="js/select2-3.5.2/select2.min.js"></script>
                            <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
                            <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $("#zone").select2();
                                });
                            </script>

                            <div id="zone_div" style="display: none;height: 157px;">

                                <div class="control-group" style=" margin-bottom: 3px !important;">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="zone">Zones<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <select name="zone" id="zone" class="span4 form-control zone_c">
                                            <option value="">Select Zone</option>
                                            <?php
                                            $q1 = "SELECT t1. zname AS name, t1.zid AS zoneid , t1.controller AS ap_controller,t1.`bzname` FROM
                                      (SELECT IFNULL(bz.name,'1') AS bzname, z.`name` AS zname, z.zoneid AS zid, z.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
                                      FROM `exp_mno_ap_controller` c,
                                      exp_distributor_zones z LEFT JOIN  `exp_mno_distributor` d ON z.`zoneid`=d.`zone_id`
                                      LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=z.`name`
                                      WHERE z.`ap_controller` = c.`ap_controller`
                                      AND c.`mno_id` = '$user_distributor') t1
                                      WHERE t1.bzname='1' AND t1.ok"; //='1'";
                                            if (isset($edit_distributor_zone_id)) {
                                                $q1 .= " IN('1','$edit_distributor_code')";
                                            } else {
                                                $q1 .= " ='1'";
                                            }


                                            $query_results = $db->selectDB($q1);

                                            foreach ($query_results['data'] as $row) {
                                                $zonename = $row[name];
                                                $zoneid = $row[zoneid];
                                                $ap_controller = $row[ap_controller];

                                                $ap_controller = str_replace(' ', '', $ap_controller);

                                                if ($edit_distributor_zone_id == $zoneid) {
                                                    $select = "selected";
                                                    $edit_distributor_zone_name = $zonename;
                                                } else {
                                                    $select = "";
                                                    continue;
                                                }

                                                echo "<option " . $select . " class='selectors " . $ap_controller . "' value='" . $zoneid . "'>" . $zonename . "</option>";
                                            }
                                            //echo $q1;
                                            ?>
                                        </select>

                                        <a style="display: inline-block; padding: 6px 20px !important;margin-bottom: 10px !important;" onclick="updatevariable();gotoNode(''+ scrt_var +'');" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                        <div style="display: inline-block" id="zones_loader"></div>


                                        <style>
                                            .select2-container {
                                                margin-right: 20px !important;
                                                margin-bottom: 15px !important;
                                            }

                                            .new_service {
                                                width: 51% !important;
                                                text-align: left !important;
                                                margin-top: 5px !important;
                                            }

                                            #service-area-name {
                                                width: 50% !important;
                                            }
                                        </style>



                                    </div>

                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                                <?php if (isset($edit_distributor_zone_id) && $edit_wired_enable != 1) { ?>
                                    <div style="margin-top: -3px;" class="control-group" <?php if ($field_array['network_config'] == 'display_none') {
                                                                                                echo 'style="display:none"';
                                                                                            } ?>>
                                        <div style="margin-top: 0px;" class="controls col-lg-5 form-group stepnew">

                                            <small>Current Zone : <b><?php
                                                                        echo empty($edit_distributor_zone_name) ?
                                                                            '<font color="red">Zone does not exists</font>'
                                                                            : $edit_distributor_zone_name;
                                                                        ?></b></small>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div  class="control-group" <?php if ($field_array['network_config'] == 'display_none') {
                                                            echo 'style="display:none"';
                                                        }  ?>>
                                <div class="controls col-lg-5 form-group">
                                    <label for="zone_name">Unique Property ID<sup>
                                            <font color="#FF0000"></font></label>
                                    <input <?php 
                                    if (in_array('support', $access_modules_list)) {
                                                            echo 'readonly';
                                                        } ?> 
                                        class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" value="<?php echo $edit_distributor_property_id; ?>">
                                </div>
                            </div>
                            <?php
                            $fq1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                      FROM exp_mno_ap_controller
                                      LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='FIREWALL CONTROLLER'";

                            $query_results = $db->selectDB($fq1);
                            $firewall_count = $query_results['rowCount'];
                            if ($firewall_count > 0) {
                            ?>


                                <div class="control-group wired_div">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="firewall_conroller">Firewall Controller<sup></sup></label>
                                        <select onchange="" name="firewall_conroller" id="firewall_conroller" class="span4 form-control ">
                                            <option value="">Select Firewall Controller</option>
                                            <?php

                                            foreach ($query_results['data'] as $row) {

                                                //$mnoid=$row[mno_id];
                                                $fapc = $row['ap_controller'];

                                                $firwall_controller = preg_replace('/\s+/', '', $fapc);
                                                if ($edit_firewall_controller == $fapc) {
                                                    $firwall_sel = 'selected';
                                                } else {
                                                    $firwall_sel = '';
                                                }

                                                echo "<option   " . $firwall_sel . "  class='" . $firwall_controller . "' value='" . $fapc . "'>" . $fapc . "</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <!-- /controls -->
                                </div>

                                <script>
                                    $('#firewall_conroller').on('change', function() {

                                        $('#organization_loader').show(); //organization_loader
                                        $('#firewall_organizations').attr("disabled", true);
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajax/getOrganizations.php',
                                            data: {
                                                firwall_ctr: this.value,
                                                mno: "<?php echo $user_distributor; ?>",
                                                user_type: "<?php echo $user_type; ?>"
                                            },
                                            success: function(data) {

                                                /* alert(data); */
                                                $('#firewall_organizations').empty();

                                                $("#firewall_organizations").append(data);

                                                $('#organization_loader').hide();
                                                $('#firewall_organizations').attr("disabled", false);
                                            },
                                            error: function() {
                                                $('#organization_loader').hide();
                                                $('#firewall_organizations').attr("disabled", false);
                                            }

                                        });
                                    });
                                </script>

                            <?php } ?>

                            <div class="control-group" <?php if ($field_array['network_config_des'] == 'display_none') {
                                                            echo 'style="display:none"';
                                                        } ?>>
                                <div class="controls col-lg-5 form-group">
                                    <label for="zone_dec">Description<sup>
                                            <font color="#FF0000"></font></label>
                                    <input class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo $edit_distributor_group_description; ?>">
                                </div>
                            </div>

                        </div>
                        <div class="create_r">

                            <div class="control-group wired_div">
                                <div class="controls col-lg-5 form-group">
                                    <label for="sw_conroller">SW Controller<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select onchange="updateSWvariable();gotoSWNode(this.value,false,true);controllerdiv(2,this.value);" name="sw_conroller" id="sw_conroller" class="span4 form-control sw_con_c">
                                        <option value="">Select SW Controller</option>
                                        <?php
                                        $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                    FROM exp_mno_ap_controller
                                    LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='SW'";

                                        $query_results = $db->selectDB($q1);

                                        foreach ($query_results['data'] as $row) {

                                            //$mnoid=$row[mno_id];
                                            $apc = $row[ap_controller];

                                            $ap_controller = preg_replace('/\s+/', '', $apc);
                                            if ($edit_distributor_sw_controller == $apc) {
                                                $controller_sel = 'selected';
                                            } else {
                                                $controller_sel = '';
                                            }

                                            echo "<option   " . $controller_sel . "  class='" . $ap_controller . "' value='" . $apc . "'>" . $apc . "</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <!-- /controls -->
                            </div>
                            <!-- /control-group -->

                            <script type="text/javascript">
                                var value = "test";

                                function updateSWvariable() {
                                    var sw_data = $("#sw_conroller").val();
                                    sw_value = sw_data;
                                    sw_scrt_var = sw_data;
                                    $("#groups").select2();

                                }

                                $(document).ready(function() {
                                    updateSWvariable();
                                });






                                function gotoSWNode(sw_scrt_var, sync, system) {


                                    var a = sw_scrt_var.length;
                                    document.getElementById("groups1").style.display = "none";
                                    document.getElementById("groups1_div").style.display = "none";
                                    document.getElementById("groups2").style.display = "none";
                                    document.getElementById("groups2_div").style.display = "none";
                                    document.getElementById("groups3").style.display = "none";
                                    document.getElementById("groups3_div").style.display = "none";
                                    var bootstrapValidator = $('#location_form').data('bootstrapValidator');

                                    if (a == 0) {
                                        bootstrapValidator.enableFieldValidators('groups', false);
                                        $('#groups').empty();

                                        $("#groups").append('Select Group/Domain');

                                        alert('Please Select SW Controller before Refresh!');

                                    } else {
                                        bootstrapValidator.enableFieldValidators('groups', true);
                                        document.getElementById("group_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajax/get_swGroups.php',
                                            data: {
                                                wag_ap_name: "<?php echo $wag_ap_name; ?>",
                                                ap_control_var: "<?php echo $ap_control_var; ?>",
                                                ackey: sw_scrt_var,
                                                mno: "<?php echo $user_distributor; ?>",
                                                mvno: "<?php echo $edit_distributor_code; ?>",
                                                sync: sync,
                                                main: system
                                            },
                                            success: function(data) {

                                                /* alert(data); */
                                                $('#groups').empty();

                                                $("#groups").append(data);


                                                document.getElementById("group_loader").innerHTML = "";

                                            },
                                            error: function() {
                                                document.getElementById("group_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                            }

                                        });



                                    }

                                }
                            </script>

                            <script type="text/javascript">
                                function syncgroups() {

                                    document.getElementById("groups").disabled = false;
                                    $('#groups').empty();
                                    document.getElementById("groups3").style.display = "edit_group";
                                    $("#refreshgroup").show();
                                    $("#groupsync").hide();

                                }
                                $(document).ready(function() {
                                    $("#groups").select2();
                                });
                            </script>


                            <div id="group_div" style="display: none;margin-bottom: 5px !important;min-height: 230px;">
                                <div class="control-group syncgroups">
                                    <?php
                                    if (!empty($edit_distributor_sw_group_id)) {
                                        $select = "disabled";
                                    }
                                    ?>
                                    <div class="controls col-lg-5 form-group">
                                        <label for="sw_conroller">Groups<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <select <?php echo $select; ?> onchange="domainschange(sw_scrt_var,1);" name="groups" id="groups" class="span4 form-control group_c">
                                            <option value="">Select Group/Domain</option>
                                            <?php

                                            if (!empty($edit_distributor_sw_group_id)) {
                                                include_once 'classes/ICXSwitch.php';
                                                $sync_obj = Sync_sw_group::withVerificationNumber($edit_distributor_verification_number);

                                                try {
                                                    $sync_obj->syncGroupById($edit_distributor_sw_group_id);
                                                } catch (Exception $e) {
                                                }
                                            }


                                            $q1 = "SELECT DISTINCT t1.zid AS zoneid , t1. zname AS name,  t1.controller AS ap_controller,t1.`bzname` FROM
  (SELECT IFNULL(bz.name,'1') AS bzname, g.`name` AS zname, g.groupid AS zid, g.ap_controller AS controller, IFNULL(d.`distributor_code`,'1') AS ok
   FROM `exp_mno_ap_controller` c,
     exp_distributor_switch_groups g LEFT JOIN  `exp_mno_distributor` d ON g.`groupid`=d.switch_group_id
     LEFT JOIN `exp_distributor_block_zones` bz ON bz.`name`=g.`name`
   WHERE g.`ap_controller` = c.`ap_controller`
         AND c.`mno_id` = '$user_distributor') t1
WHERE t1.bzname='1' AND t1.ok";
                                            if (isset($edit_distributor_sw_group_id)) {
                                                $q1 .= " IN('1','$edit_distributor_code') AND t1.controller='" . $edit_distributor_sw_controller . "'";
                                                $query_results = $db->selectDB($q1);
                                            } else {
                                                $q1 .= " ='1'";
                                            }

                                            foreach ($query_results['data'] as $row) {
                                                $zonename = $row[name];
                                                $zoneid = $row[zoneid];
                                                $ap_controller = $row[ap_controller];

                                                $ap_controller = str_replace(' ', '', $ap_controller);

                                                if ($edit_distributor_sw_group_id == $zoneid) {
                                                    $select = "selected";
                                                    $edit_distributor_groups_name = $zonename;
                                                } else {
                                                    $select = "";
                                                }

                                                echo "<option " . $select . " class='selectors " . $ap_controller . "' value='" . $zoneid . "'>" . $zonename . "</option>";
                                            }
                                            //echo $q1;
                                            ?>
                                        </select>



                                        <?php if (isset($edit_distributor_sw_group_id)) { ?>

                                            <a id="groupsync" onclick="syncgroups(); gotoSWNode(sw_scrt_var,true,true);" class="btn btn-primary" style="align: left;">Edit <i class="btn-icon-only icon-refresh"></i> </a>


                                        <?php } else {  ?>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $("#refreshgroup").show();
                                                });
                                            </script>

                                        <?php } ?>
                                        <a id="refreshgroup" style="display: none; padding: 6px 20px !important; " onclick="updateSWvariable();gotoSWNode(sw_scrt_var,true,true);" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                        <style>
                                            .select2-container {
                                                margin-right: 20px !important;
                                                margin-bottom: 15px !important;
                                            }
                                        </style>
                                        <div style="display: inline-block" id="group_loader"></div>


                                        <div style="display: inline-block" id="group_loader1"></div>
                                    </div> <!-- /controls -->
                                </div>

                                <div class="control-group syncgroups" id="groups1_div">
                                    <div class="select2-container controls col-lg-5 form-group syncgroups">
                                        <select onchange="domainschange(sw_scrt_var,2);" style="display:none;" name="groups1" id="groups1" class="span4 form-control group_c">
                                            <option value="">Select Group/Domain</option>

                                        </select>
                                        <div style="display: inline-block" id="group_loader2"></div>

                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                                <div class="control-group syncgroups" id="groups2_div">
                                    <div class="select2-container controls col-lg-5 form-group syncgroups">
                                        <select onchange="domainschange(sw_scrt_var,3);" style="display:none;" name="groups2" id="groups2" class="span4 form-control group_c">
                                            <option value="">Select Group/Domain</option>

                                        </select>
                                        <div style="display: inline-block" id="group_loader3"></div>
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->
                                <div class="control-group syncgroups" id="groups3_div">
                                    <div class="select2-container controls col-lg-5 form-group syncgroups">
                                        <select style="display:none;" name="groups3" id="groups3" class="span4 form-control group_c">
                                            <option value="">Select Group</option>

                                        </select>

                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->
                            </div>
                            <script>
                                function selwags(scrt_var) {


                                    var a = scrt_var.length;


                                    // document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

                                    //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                                    $.ajax({
                                        type: 'POST',
                                        url: 'ajax/refreshGREProfiles.php',
                                        data: {
                                            loc_GRE: "yes",
                                            ap_control_var: scrt_var,
                                            user: '<?php echo $user_distributor; ?>'
                                        },
                                        success: function(data) {

                                            //alert(data);
                                            $('#wag_name').empty();

                                            $("#wag_name").append(data);


                                            // document.getElementById("zones_loader").innerHTML = "";

                                        },
                                        error: function() {
                                            // document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                        }

                                    });



                                }

                                function domainschange(sw_scrt_var, type) {

                                    if (type == 1) {
                                        document.getElementById("groups2").style.display = "none";
                                        document.getElementById("groups2_div").style.display = "none";
                                        document.getElementById("groups3").style.display = "none";
                                        document.getElementById("groups3_div").style.display = "none";
                                        var groups = $("#groups").val();
                                        var x = $('#groups').find(':selected').attr('data-feature');
                                        if (x == 'DOMAIN') {
                                            $("#groups1").empty();
                                            $('#location_form').bootstrapValidator('revalidateField', 'groups1');
                                            //document.getElementById("groups1").style.display = "inline-block";
                                            document.getElementById("group_loader1").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        } else {
                                            document.getElementById("groups1").style.display = "none";
                                            document.getElementById("groups1_div").style.display = "none";
                                        }
                                    } else if (type == 2) {
                                        document.getElementById("groups3").style.display = "none";
                                        document.getElementById("groups3_div").style.display = "none";
                                        var groups = $("#groups1").val();
                                        var x = $('#groups1').find(':selected').attr('data-feature');
                                        if (x == 'DOMAIN') {
                                            $("#groups2").empty();
                                            $('#location_form').bootstrapValidator('revalidateField', 'groups2');
                                            //document.getElementById("groups2").style.display = "inline-block";
                                            document.getElementById("group_loader2").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        } else {
                                            document.getElementById("groups2").style.display = "none";
                                            document.getElementById("groups2_div").style.display = "none";
                                        }
                                    } else if (type == 3) {
                                        var groups = $("#groups2").val();
                                        var x = $('#groups2').find(':selected').attr('data-feature');
                                        var a = groups.length;
                                        if (x == 'DOMAIN') {
                                            $("#groups3").empty();
                                            $('#location_form').bootstrapValidator('revalidateField', 'groups3');
                                            //document.getElementById("groups3").style.display = "inline-block";
                                            document.getElementById("group_loader3").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        } else {
                                            document.getElementById("groups3").style.display = "none";
                                            document.getElementById("groups3_div").style.display = "none";
                                        }
                                    }



                                    if (x == 'DOMAIN') {
                                        //document.getElementById("groups1").style.display = "inline-block";
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajax/get_swGroups.php',
                                            data: {
                                                wag_ap_name: "<?php echo $wag_ap_name; ?>",
                                                ap_control_var: "<?php echo $ap_control_var; ?>",
                                                ackey: sw_scrt_var,
                                                mno: "<?php echo $user_distributor; ?>",
                                                mvno: "<?php echo $edit_distributor_code; ?>",
                                                groups: groups
                                            },
                                            success: function(data) {

                                                /* alert(data); */
                                                if (type == 1) {
                                                    $('#groups1').empty();
                                                    document.getElementById("groups1").style.display = "inline-block";
                                                    document.getElementById("groups1_div").style.display = "inline-block";

                                                    $("#groups1").append(data);
                                                    document.getElementById("group_loader1").innerHTML = "";
                                                }
                                                if (type == 2) {
                                                    $('#groups2').empty();
                                                    document.getElementById("groups2").style.display = "inline-block";
                                                    document.getElementById("groups2_div").style.display = "inline-block";


                                                    $("#groups2").append(data);
                                                    document.getElementById("group_loader2").innerHTML = "";
                                                }
                                                if (type == 3) {
                                                    $('#groups3').empty();
                                                    document.getElementById("groups3").style.display = "inline-block";
                                                    document.getElementById("groups3_div").style.display = "inline-block";

                                                    $("#groups3").append(data);
                                                    document.getElementById("group_loader3").innerHTML = "";
                                                }





                                            },
                                            error: function() {
                                                document.getElementById("group_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                            }

                                        });

                                    } else {

                                    }
                                }
                            </script>


                            <style>
                                .syncgroups {
                                    margin-bottom: 7px !important;
                                    width: 100% !important;
                                }

                                .syncgroupsn {
                                    margin-bottom: 7px !important;
                                }

                                #wag_name,
                                #AP_contrl_guest {
                                    margin-right: 0px !important;
                                    margin-bottom: 0px !important;
                                }



                                div.toggle {
                                    margin-bottom: 15px !important;
                                }
                            </style>

                            <?php if ($firewall_count > 0) { ?>
                                <div class="control-group wired_div">
                                    <div class="controls col-lg-5 form-group">
                                        <input type="hidden" name="old_firewall_organizations" id="old_firewall_organizations" value="<?php echo $edit_organizations_id; ?>">
                                        <label for="firewall_organizations">Organizations<sup><img src="img/loading_ajax.gif" id="organization_loader" style="margin-bottom: -10px;margin-left: 5px;display: none"></sup></label>
                                        <select name="firewall_organizations" id="firewall_organizations" class="span4 form-control ">
                                            <option value="">Select Organizations</option>

                                            <?php

                                            if (!empty($edit_distributor_code)) {
                                                $foq1 = "SELECT * FROM `exp_organizations` WHERE  `firewall_controller` = '$edit_firewall_controller'";

                                                $query_results_or = $db->selectDB($foq1);

                                                foreach ($query_results_or['data'] as $row) {

                                                    //$mnoid=$row[mno_id];

                                                    $organizationsid = $row['organizations_id'];
                                                    $name = $row['organizations_name'];


                                                    if ($edit_organizations_id == $organizationsid) {
                                                        $firwall_sel = 'selected';
                                                    } else {
                                                        $firwall_sel = '';
                                                    }

                                                    echo "<option " . $firwall_sel . " value='" . $organizationsid . "'>" . $name . "</option>";
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                            <?php } ?>


                            <div class="control-group" <?php if ($field_array['network_config_realm'] == 'display_none') {
                                                            echo 'style="display:none"';
                                                        } ?>>
                                <div class="controls col-lg-5 form-group">
                                    <label for="zone_dec">Realm<sup>
                                            <font color="#FF0000"></font></label>
                                    <input required style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789" onblur="vali_realm(this)" value="<?php echo $edit_distributor_realm; ?>" <?php if (array_key_exists('icomms_number', $field_array)) {
                                                                                                                                                                                                                                                        if ($edit_account == 1) echo "readonly";
                                                                                                                                                                                                                                                    } ?>>
                                    <div style="display: inline-block" id="img"></div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $("#zone_name").keypress(function(event) {

                                var ew = event.which;
                                // alert(ew);
                                if (ew == 45 || ew == 95 || ew == 189)
                                    return true;
                                if (ew == 32)
                                    return true;
                                if (ew == 47)
                                    return true;
                                if (48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 96 <= ew && ew <= 122 || ew == 0 || ew == 8 || ew == 189)
                                    return true;
                                return false;
                            });
                        </script>




                        <script>
                            $(document).ready(function() {
                                $("#zone_uid_nouse").keydown(function(e) {
                                    // Allow: backspace, delete, tab, escape, enter and .
                                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                        // Allow: Ctrl+A, Command+A
                                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                        // Allow: home, end, left, right, down, up
                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                        // let it happen, don't do anything
                                        return;
                                    }
                                    // Ensure that it is a number and stop the keypress
                                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                        e.preventDefault();
                                    }
                                });
                            });

                            function controllerdiv(id, value) {
                                if (id == 1) {
                                    $('#selected_controller').empty();
                                    $("#selected_controller").append(value);
                                } else {
                                    $('#selected_sw_controller').empty();
                                    $("#selected_sw_controller").append(value);
                                }

                            }
                        </script>

                        <?php if ($edit_account != 1) {   ?>
                            <script>
                                function vali_realm(rlm) {
                                    var val = rlm.value;
                                    var val = val.trim();



                                    if (val != "") {
                                        document.getElementById("img").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                        var formData = {
                                            realm: val
                                        };
                                        $.ajax({
                                            url: "ajax/validateRealm.php",
                                            type: "POST",
                                            data: formData,
                                            success: function(data) {
                                                /*  if:new ok->1
                                                 * if:new exist->2 */
                                                /* alert(data);*/

                                                if (data == '1') {
                                                    /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                    document.getElementById("img").innerHTML = "";

                                                } else if (data == '2') {

                                                    document.getElementById("img").innerHTML = "<p style=\"display: inline-block; color:red\">" + val + " - Realm is already exists.</p>";
                                                    document.getElementById('realm').value = "";
                                                    /* $('#mno_account_name').removeAttr('value'); */
                                                    document.getElementById('realm').placeholder = "Please enter new realm";
                                                }
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                //alert("error");
                                                document.getElementById('realm').value = "";
                                            }
                                        });
                                    }
                                }
                            </script>
                        <?php } ?>



                        <div class="details-view-block grid automation">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">AP</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div id="selected_controller" class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $edit_distributor_ap_controller; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Zone Template</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $template_zone; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Name</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $zone_description; ?></div>
                                    </div>

                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">SW</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div id="selected_sw_controller" class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $edit_distributor_sw_controller; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Group Template</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $template_group; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Name</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $group_description; ?></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php
                    } else {

                    ?>
                        <div class="create_l">
                            <div class="row">

                                <div class="control-group" style="display: none;">
                                    <div class="controls col-lg-5 form-group">
                                        <input id="wired_property" name="wired_property" onchange="wired_control()" type="checkbox" value="1" data-size="mini" <?php if ($edit_wired_enable == 1) { ?> checked="checked" <?php } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                                <div class="control-group wired_div">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="conroller">Controller<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <input readonly value="<?php echo $edit_distributor_ap_controller; ?>" name="conroller" id="conroller" class="span4 form-control " required>
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                                <div class="control-group wired_div">
                                    <div class="controls col-lg-5 form-group">
                                        <label for="zone">Zones<sup>
                                                <font color="#FF0000"></font>
                                            </sup></label>
                                        <input type="text" readonly value="<?php echo $db->getValueAsf("SELECT `name` AS f FROM `exp_distributor_zones` WHERE `zoneid`='$edit_distributor_zone_id'"); ?>" class="span4 form-control">
                                        <input type="hidden" readonly value="<?php echo $edit_distributor_zone_id; ?>" name="zone" id="zone">
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->
                                <?php
                                $fq1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                      FROM exp_mno_ap_controller
                                      LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='FIREWALL CONTROLLER'";

                                $query_results = $db->selectDB($fq1);
                                $firewall_count = $query_results['rowCount'];
                                if ($firewall_count > 0 && strlen($edit_firewall_controller) > 0) {
                                ?>
                                    <div class="control-group wired_div">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="firewall_conroller">Firewall Controller<sup>
                                                    <font color="#FF0000"></font>
                                                </sup></label>
                                            <input type="text" readonly value="<?php echo $edit_firewall_controller; ?>" class="span4 form-control">

                                        </div>
                                        <!-- /controls -->
                                    </div>
                                    <!-- /control-group -->

                                <?php } ?>


                            </div>
                        </div>
                        <div class="create_r">
                            <div class="row">
                                <div class="control-group" <?php if ($field_array['network_config'] == 'display_none') {
                                                                echo 'style="display:none"';
                                                            } ?>>
                                    <div class="controls col-lg-5 form-group">
                                        <label for="zone_name">Unique Property ID<sup>
                                                <font color="#FF0000"></font></label>
                                        <input readonly class="span4 form-control" id="zone_name" name="zone_name" type="text" placeholder="Circuit ID#" value="<?php echo $edit_distributor_property_id; ?>">
                                    </div>
                                    <div class="control-group" <?php if ($field_array['network_config_des'] == 'display_none') {
                                                                    echo 'style="display:none"';
                                                                } ?>>
                                        <div class="controls col-lg-5 form-group">
                                            <label for="zone_dec">Description<font color="#FF0000"></font></label>
                                            <input readonly class="span4 form-control" id="zone_dec" name="zone_dec" type="text" placeholder="Coffeeshop chain" value="<?php echo $edit_distributor_group_description; ?>">
                                        </div>
                                    </div>

                                    <div <?php if ($firewall_count < 1 || strlen($edit_firewall_controller) < 1) {
                                                echo 'style="display:none" class="control-group"';
                                            } else {
                                                echo 'style="margin-top: 97px" class="control-group wired_div"';
                                            } ?>>
                                        <div class="controls col-lg-5 form-group">
                                            <label for="zone_name">Organizations<sup>
                                                    <font color="#FF0000"></font></label>

                                            <input readonly class="span4 form-control" type="text" value="<?php echo $db->getValueAsf("SELECT `organizations_name` AS f FROM `exp_organizations` WHERE  `firewall_controller` = '$edit_firewall_controller' AND `organizations_id`='$edit_organizations_id'"); ?>">
                                        </div>
                                    </div>


                                    <div class="control-group" <?php if ($field_array['network_config_realm'] == 'display_none') {
                                                                    echo 'style="display:none"';
                                                                } ?>>
                                        <div class="controls col-lg-5 form-group">
                                            <label for="zone_dec">Realm<font color="#FF0000"></font></label>
                                            <input required style="display: inline-block" class="span4 form-control" id="realm" name="realm" type="text" placeholder="123456789" value="<?php echo $edit_distributor_realm; ?>" <?php if (array_key_exists('icomms_number', $field_array)) {
                                                                                                                                                                                                                                    if ($edit_account == 1) echo "readonly";
                                                                                                                                                                                                                                } ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                        ?>


                </fieldset>

                <fieldset id="network_info" data-name="Network Info">
                    <h3>Network Info</h3>

                    <?php
                    if (array_key_exists('network_type', $field_array)) { ?>
                        <input type="hidden" id="old_network_type" name="old_network_type" value="<?php echo $edit_distributor_network_type; ?>">

                        <div class="control-group wired_div">
                            <div class="controls col-lg-5 form-group">
                                <label for="location_name1">Package Type<?php if ($field_array['network_type'] == "mandatory") { ?><sup>
                                        <font color="#FF0000"></font>
                                    </sup><?php } ?></label>
                                <?php
                                // include_once __DIR__.'/'.$multi_service_area->POS_0;
                                ?>
                                <select class="form-control span4" multiple="multiple" id="network_type" name="network_type[]">
                                    <option value="" disabled="disabled"> Choose Package(s)</option>

                                    <?php
                                    $operator_vt_option = $package_functions->getOptions('VTENANT_MODULE', $system_package);
                                    if ($operator_vt_option == 'Vtenant') {
                                    ?>
                                        <option name="network_vtenant_name" <?php if (($edit_distributor_network_type == 'VT') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'VT-PRIVATE') || ($edit_distributor_network_type == 'VT-GUEST')) {
                                                                                echo 'selected';
                                                                            } else {
                                                                                echo '';
                                                                            } ?> value="VT"><span id="vtenants">vTenant</span></option>
                                    <?php } ?>
                                    <option <?php if (($edit_distributor_network_type == 'GUEST') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'BOTH') || ($edit_distributor_network_type == 'VT-GUEST')) {
                                                echo 'selected';
                                            } else {
                                                echo '';
                                            } ?> value="GUEST">Guest</option>
                                    <option <?php if (($edit_distributor_network_type == 'PRIVATE') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'BOTH') || ($edit_distributor_network_type == 'VT-PRIVATE')) {
                                                echo 'selected';
                                            } else {
                                                echo '';
                                            } ?> value="PRIVATE">Private</option>
                                </select>


                            </div>
                        </div>
                    <?php } ?>
                    <?php
                    //include_once __DIR__.'/'.$multi_service_area->POS_1;
                    ?>
                    <div class="wired_div">
                        <div id="guest_div" style="width: 100%; display: inline-block;">
                            <h4>Guest Network </h4>

                            <div class="create_l">

                                <?php
                                if (array_key_exists('icomms_number', $field_array)) { ?>
                                    <div class="control-group guest_icomme" id="icomme_div">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="customer_type">Customer Account Number<?php if ($field_array['icomms_number'] == "mandatory") { ?><font color="#FF0000"></font><?php } ?></label>
                                            <input type="text" class="span4 form-control" id="icomme" name="icomme" onblur="check_icom(this,1)" value="<?php echo $edit_distributor_verification_number; ?>" <?php if ($edit_account == 1 && $edit_distributor_network_type != 'VT') { ?>readonly<?php } ?>>
                                            <div style="display: none" id="img_icom"><img src="img/loading_ajax.gif"></div>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function() {



                                                $("#icomme").keypress(function(e) {

                                                    var ew = event.which;

                                                    //alert(ew);
                                                    // if(ew == 32)
                                                    //   return true;

                                                    if (ew == 45 || ew == 95) {
                                                        /*allow - and _ characters */
                                                        return true;
                                                    }

                                                    if (48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0 || ew == 8 || ew == 189) {
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }



                                                });


                                            });
                                        </script>
                                    </div>
                                <?php    }
                                if (array_key_exists('location_type', $field_array) || $package_features == "all") {
                                ?>

                                    <div class="control-group" <?php if (array_key_exists('network_type', $field_array)) {
                                                                    echo 'style="display:none"';
                                                                } ?>>
                                        <div class="controls col-lg-5 form-group">
                                            <label for="user_type">Property Type<?php if ($field_array['location_type'] == "mandatory" || $package_features == "all") { ?><sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?></label>

                                            <select <?php if ($field_array['location_type'] == "mandatory" || $package_features == "all") { ?>required<?php } ?> name="user_type" id="user_type" class="span4 form-control" <?php if (isset($edit_distributor_type)) {
                                                                                                                                                                                                                            echo 'disabled';
                                                                                                                                                                                                                        } ?>>

                                                <option value=''>Select Account Type</option>
                                                <?php // } 
                                                ?>




                                                <?php

                                                if ($user_type == 'MNO') {

                                                    if (array_key_exists('network_type', $field_array)) {
                                                        $edit_distributor_type = 'MVNO';
                                                    }
                                                    $mno_flow_q = "SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                    $mno_flow = $db->selectDB($mno_flow_q);

                                                    foreach ($mno_flow['data'] as $mno_flow_row) {
                                                        if ($edit_distributor_type == $mno_flow_row[flow_type]) {
                                                            $select = "selected";
                                                        } else {
                                                            $select = "";
                                                        }
                                                        echo '<option ' . $select . ' value=' . $mno_flow_row[flow_type] . '>' . $mno_flow_row[flow_name] . '-' . $mno_flow_row[description] . '</option>';
                                                    }


                                                    /*echo '
                                        <option value="MVNA">MVNA - Re Seller</option>
                                        <option value="MVNE">MVNE - Hoster</option>
                                        <option value="MVNO">MVNO - Service Provider</option>';*/
                                                } else if ($user_type == 'MVNA') {

                                                    $mno_flow_q = "SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=3 AND `is_enable`=1";
                                                    $mno_flow = $db->selectDB($mno_flow_q);

                                                    foreach ($mno_flow['data'] as $mno_flow_row) {
                                                        if ($edit_distributor_type == $mno_flow_row[flow_type]) {
                                                            $select = "selected";
                                                        } else {
                                                            $select = "";
                                                        }
                                                        echo '<option ' . $select . ' value=' . $mno_flow_row[flow_type] . '>' . $mno_flow_row[flow_name] . '-' . $mno_flow_row[description] . '</option>';
                                                    }

                                                    //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                } else if ($user_type == 'MVNE') {

                                                    $mno_flow_q = "SELECT `flow_type`,`flow_name`,`description` FROM `exp_mno_flow` WHERE `leve1`=2 AND `is_enable`=1";
                                                    $mno_flow = $db->selectDB($mno_flow_q);

                                                    foreach ($mno_flow['data'] as $mno_flow_row) {
                                                        if ($edit_distributor_type == $mno_flow_row[flow_type]) {
                                                            $select = "selected";
                                                        } else {
                                                            $select = "";
                                                        }
                                                        echo '<option ' . $select . ' value=' . $mno_flow_row[flow_type] . '>' . $mno_flow_row[flow_name] . '-' . $mno_flow_row[description] . '</option>';
                                                    }


                                                    //echo '<option value="MVNO">MVNO - Service Provider</option>';
                                                }
                                                ?>

                                            </select>

                                        </div>
                                    </div>
                                <?php }
                                if (array_key_exists('p_QOS', $field_array) || array_key_exists('g_QOS', $field_array) || ($package_functions->getOptions('VTENANT_MODULE', $system_package) == 'Vtenant') ||  $package_features == "all") {
                                    $json_sync_fields = $package_functions->getOptions('SYNC_PRODUCTS_FROM_AAA', $system_package);
                                    $sync_array = json_decode($json_sync_fields, true);
                                    $aaa_type = $package_functions->getOptionsAaa('AAA_TYPE', $system_package);
                                    if ($aaa_type == 'ALE53') {
                                        $p_type = "product_ale5";
                                    } elseif ($aaa_type == 'Not Allowed') {
                                        $aaa_type = 'ALE53';
                                        $p_type = "product_ale5";
                                    } else {
                                        $p_type = "";
                                    }
                                ?>


                                    <script type="text/javascript">
                                        var vt_default_product;
                                        var vt_group_product;
                                        var group_product = false;
                                        function gotoSync(type) {

                                            //var a = scrt_var.length;
                                            var old_product;

                                            if (type == 1) {
                                                document.getElementById("sync_loader_VT").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                old_product=$('#vt_guest_def_id').find(":selected").val();

                                            } else if (type == 2) {
                                                document.getElementById("sync_loader_pvt").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                document.getElementById("sync_loader_pt").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                old_product=$('#product_pvt').find(":selected").val();
                                            } else {
                                                document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                old_product=$('#AP_contrl_guest').find(":selected").val();
                                                //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;
                                            }



                                            $.ajax({
                                                type: 'POST',
                                                dataType: 'JSON',
                                                <?php if ($aaa_type == 'ALE53') { ?>
                                                    
                                                <?php } ?>
                                                url: 'ajax/get_profile.php',
                                                data: {
                                                    user_distributor: "<?php echo $user_distributor; ?>",
                                                    sync_type: "<?php echo $p_type; ?>",
                                                    system_package: "<?php echo $system_package; ?>",
                                                    user_name: "<?php echo $user_name; ?>",
                                                    old_product:old_product,
                                                    type:type
                                                },
                                                success: function(data) {
                                                    group_product = true;
                                                    //parse.json(data);
                                                    //console.log(data.guest_data);
                                                    //alert(data); 
                                                    <?php if ($aaa_type == 'ALE53') { ?>
                                                        vt_default_product =  data.vtenant_data;
                                                        vt_group_product =  data.group;

                                                        //var group_vt = $('input[type=radio][name=vt_product_type]').val();
                                                        var group_vt = $('input[name=vt_product_type]:checked', '#location_form').val();
                                                      //alert(group_vt);

                                                        if (type == 1) {
                                                            if (group_vt == 'Group') {
                                                                $('#vt_guest_def_id').empty();
                                                                $("#vt_guest_def_id").append(data.group);
                                                              }else{
                                                                $('#vt_guest_def_id').empty();
                                                                $("#vt_guest_def_id").append(data.vtenant_data);
                                                              }
                                                            document.getElementById("sync_loader_VT").innerHTML = "";
                                                        } else if (type == 2) {
                                                            $('#product_pvt').empty();
                                                            $("#product_pvt").append(data.private_data);

                                                            $('#product_pt').empty();
                                                            $("#product_pt").append(data.private_data);
                                                            document.getElementById("sync_loader_pt").innerHTML = "";
                                                            document.getElementById("sync_loader_pvt").innerHTML = "";
                                                        } else {
                                                            $('#AP_contrl_guest').empty();
                                                            $("#AP_contrl_guest").append(data.guest_data);

                                                            $('#vt_guest_pri_id').empty();
                                                            $("#vt_guest_pri_id").append(data.guest_data);
                                                            document.getElementById("sync_loader").innerHTML = "";
                                                        }

                                                    <?php } else { ?>
                                                        vt_default_product =  data.default;
                                                        vt_group_product =  data.group;
                                                        $('#AP_contrl_guest').empty();
                                                        $("#AP_contrl_guest").append(data.default);

                                                        $('#vt_guest_pri_id').empty();
                                                        $("#vt_guest_pri_id").append(data.default);

                                                        var group_vt = $('input[type=radio][name=vt_product_type]').val();
                                                          //alert(group_vt);
                                                          if (group_vt == 'Group') {
                                                            $('#vt_guest_def_id').empty();
                                                            $("#vt_guest_def_id").append(data.group);
                                                          }else{
                                                            $('#vt_guest_def_id').empty();
                                                            $("#vt_guest_def_id").append(data.default);
                                                          }

                                                        $('#vt_guest_pro_id').empty();
                                                        $("#vt_guest_pro_id").append(data.default);
                                                        document.getElementById("sync_loader").innerHTML = "";
                                                    <?php } ?>
                                                    

                                                },
                                                error: function() {
                                                    if (type == 1) {
                                                        document.getElementById("sync_loader_VT").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                    } else {
                                                        document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                                                    }
                                                }

                                            });





                                        }
                                    </script>
                                <?php  }
                                if (array_key_exists('g_QOS', $field_array) || $package_features == "all") {


                                ?>

                                    <div class="control-group" id="g_prof2" style="margin-bottom: auto;">

                                        <div class="controls col-lg-5 form-group">

                                            <label for="AP_contrl_guest">Guest Product
                                                <?php if ($field_array['g_QOS'] == "mandatory") { ?>
                                                    <font color="#FF0000"></font><?php } ?>
                                                <a <?php if ($sync_array['g_QOS_sync'] == 'display') {
                                                        echo 'style="margin-left:5px"';
                                                    } else {
                                                        echo 'style="display:none"';
                                                    } ?> onclick="gotoSync(0);" class="" style="align: left;"><i class="btn-icon-only icon-refresh"></i>
                                                    [Sync Products]</a>
                                                <div style="display: inline-block" id="sync_loader"></div>
                                            </label>

                                            <select <?php if ($field_array['g_QOS'] == "mandatory") { ?>required<?php } ?> name="AP_contrl_guest" id="AP_contrl_guest" class="span4 form-control" style="margin-right: 16px !important; margin-bottom: 0px !important;">
                                                <option value="">Select Guest
                                                    Profile
                                                </option>
                                                <?php
                                                if ($aaa_type == 'ALE53') {
                                                    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                                    $query_results = $db->selectDB($q1);
                                                    $arraym = array();
                                                    $arrayk = array();
                                                    $arrayo = array();
                                                    foreach ($query_results['data'] as $row) {

                                                        $dis_code = $row[product_code];
                                                        $QOS = $row[QOS];
                                                        $QOSLast = strtolower(substr($QOS, -1));
                                                        $product_name_new = str_replace('_', '-', $row[product_code]);
                                                        $name_ar = explode('-', $product_name_new);
                                                        $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                                        $duration_val = $duration[0];
                                                        $qosvalarr = explode('*', $name_ar[2]);
                                                        $ab = substr($name_ar[2], 0, 2);
                                                        if (!is_numeric($ab)) {
                                                            $ab = substr($name_ar[2], 0, 1);
                                                        }
                                                        $bb = substr($name_ar[2], -2);
                                                        if (!is_numeric($bb)) {
                                                            $bb = substr($name_ar[2], -1);
                                                        }
                                                        $row['duration'] = $duration_val;
                                                        $row['qosval'] = $ab;
                                                        $row['qosval2'] = $bb;
                                                        if ($QOSLast == 'k') {
                                                            array_push($arrayk, $row);
                                                        } else if ($QOSLast == 'm') {
                                                            array_push($arraym, $row);
                                                        } else {
                                                            array_push($arrayo, $row);
                                                        }
                                                    }

                                                    CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                                    CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                                    CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                                    $arrayfinal = array();
                                                    if (empty($arrayk)) {
                                                        $arrayfinal = $arraym;
                                                    } else {
                                                        if (empty($arraym)) {
                                                            $arrayfinal = $arrayk;
                                                        } else {
                                                            $arrayfinal = array_merge($arrayk, $arraym);
                                                        }
                                                    }
                                                    if (!empty($arrayo)) {
                                                        $arrayfinal = array_merge($arrayfinal,$arrayo);
                                                    }
                                                    $exists_in_list=false;
                                                    foreach ($arrayfinal as $row) {
                                                        $select = "";
                                                        $dis_code = $row[product_code];
                                                        $dis_g_id = $row[product_id];
                                                        $dis_name = $row[product_name];
                                                        $dis_QOS = $row[QOS];

                                                        if ($edit_distributor_product_id_g == $dis_g_id) {
                                                            $select = "selected";
                                                            $exists_in_lis = true;
                                                        }

                                                        echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                    }
                                                    if(!$exists_in_lis && $edit_account=='1' && !empty($edit_distributor_product_id_g)){
                                                        $product_52 = $db->select1DB("SELECT product_code,QOS FROM exp_products WHERE product_id='$edit_distributor_product_id_g'");
                                                        echo "<option selected value='$edit_distributor_product_id_g'>" . $product_52['product_code'] . " [" . $product_52['QOS'] . "]</option>";
                                                    }
                                                } else {
                                                    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'  AND (default_value='0' || default_value IS NULL)";

                                                    $query_results = $db->selectDB($q1);

                                                    foreach ($query_results['data'] as $row) {
                                                        $select = "";
                                                        $dis_code = $row[product_code];
                                                        $dis_g_id = $row[product_id];
                                                        $dis_name = $row[product_name];
                                                        $dis_QOS = $row[QOS];

                                                        if ($edit_distributor_product_id_g == $dis_g_id) {
                                                            $select = "selected";
                                                            $exists_in_lis = true;
                                                        }

                                                        echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <!-- /controls -->
                                    </div>
                                    <!-- /control-group -->


                                    <?php if ($field_array['g_QOS_du'] == 'display_none') { ?>
                                        <style>
                                            #gd_prof {
                                                display: none !important;

                                            }
                                        </style>

                                    <?php } ?>

                                    <div class="control-group" id="gd_prof">

                                        <div class="controls col-lg-5 form-group">

                                            <label for="AP_contrl">Duration
                                                Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                                <font color="#FF0000"></font><?php } ?>
                                            </label>

                                            <select <?php if ($field_array['g_QOS'] == "mandatory" && $field_array['g_QOS_du'] != 'display_none') { ?>required<?php } ?> name="AP_contrl_guest_time" id="AP_contrl_guest_time" class="span4 form-control">
                                                <option value="">Select
                                                    Profile
                                                </option>
                                                <?php
                                                $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                        FROM exp_products_duration
                                                        WHERE profile_type IN('1','3') AND distributor='$user_distributor'";

                                                $query_results = $db->selectDB($q1);

                                                foreach ($query_results['data'] as $row) {
                                                    $select = "";
                                                    $dis_id = $row[id];
                                                    $dis_code = $row[profile_code];
                                                    $dis_name = $row[profile_name];
                                                    $timegap = $row[duration];
                                                    $gap = "";
                                                    if ($timegap != '') {

                                                        $interval = new DateInterval($timegap);

                                                        if ($interval->y != 0) {
                                                            $gap .= $interval->y . ' Years ';
                                                        }
                                                        if ($interval->m != 0) {
                                                            $gap .= $interval->m . ' Months ';
                                                        }
                                                        if ($interval->d != 0) {
                                                            $gap .= $interval->d . ' Days ';
                                                        }
                                                        if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                                            $gap .= ' And ';
                                                        }
                                                        if ($interval->h != 0) {
                                                            $gap .= $interval->h . ' Hours ';
                                                        }
                                                        if ($interval->i != 0) {
                                                            $gap .= $interval->i . ' Minutes';
                                                        }
                                                    }
                                                    if ($edit_distributor_product_id_g_time == $dis_code) {
                                                        $select = "selected";
                                                    }
                                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- /controls -->
                                    </div>
                                    <!-- /control-group -->

                                <?php
                                }
                                ?>
                            </div>


                            <div class="create_r">
                                <div class="control-group">
                                    <div class="controls form-group desable-se">
                                        <label for="g_nu_of_network">Number Of Networks <img data-toggle="tooltip" title="To edit, delete or create additional WLANs please utilize the Match Table Parameter section below." src="layout/OPTIMUM/img/help.png" style="width: 18px; cursor: pointer;"></label>
                                        <?php if ($edit_account == 1 && (($edit_distributor_network_type == 'GUEST') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'BOTH') || ($edit_distributor_network_type == 'VT-GUEST'))) {
                                            echo '<div class="sele-disable-new span4_new" ></div>';
                                        } ?>
                                        <select required="" class="span4 form-control" id="g_nu_of_network" name="g_nu_of_network">
                                            <!-- <option value="">Select Number Of Network</option> -->
                                            <?php
                                            for ($i = 1; $i < 7; $i++) {
                                                if ($edit_wlan_count_arr['guest'] == $i) {
                                                    echo '<option value="' . $i . '" selected> ' . $i . ' </option>';
                                                } else {
                                                    echo '<option value="' . $i . '"> ' . $i . ' </option>';
                                                }
                                            }
                                            ?>




                                        </select>
                                    </div>
                                </div>
                                <?php if (array_key_exists('gateway_type', $field_array)) {
                                ?>
                                    <div class="control-group" id="gu_geteway_div">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="gateway_type">Guest Gateway Type<?php if ($field_array['gateway_type'] == "mandatory") { ?><sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?> &nbsp; <img data-toggle="tooltip" title="Automation is only applicable for VSZ gateway type" src="layout/OPTIMUM/img/help.png" style="width: 18px;cursor: pointer;"></label>

                                            <select onchange="gatewaytype()" <?php if ($field_array['gateway_type'] == "mandatory") { ?>required<?php } ?> class="span4 form-control" id="gateway_type" name="gateway_type">

                                                <option value="">Select Gateway Type</option>
                                                <?php

                                                if (empty($edit_distributor_gateway_type)) {
                                                    $edit_distributor_gateway_type = "VSZ";
                                                }

                                                $get_gatw_type_q = "select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                                $get_gatw_type_r = $db->selectDB($get_gatw_type_q);

                                                foreach ($get_gatw_type_r['data'] as $gatw_row) {
                                                    $gatw_row_gtw = $gatw_row['gateway_name'];
                                                    $gatw_row_dis = $gatw_row['description'];

                                                    if ($gatw_row_gtw == 'VSZ' || $edit_automation_enable != 1) {
                                                ?>
                                                        <option <?php $edit_distributor_gateway_type == $gatw_row_gtw ? print(" selected ") : print(""); ?> value="<?php echo $gatw_row_gtw; ?>"> <?php echo $gatw_row_dis; ?> </option>;
                                                    <?php } else { ?>
                                                        <option disabled="" <?php $edit_distributor_gateway_type == $gatw_row_gtw ? print(" selected ") : print(""); ?> value="<?php echo $gatw_row_gtw; ?>"> <?php echo $gatw_row_dis; ?> </option>;
                                                <?php }
                                                } ?>
                                            </select>


                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div id="wag_profile_div" <?php if ($edit_distributor_gateway_type == 'ac' || $field_array['ne_WAG'] == 'display_none') {
                                                            echo 'style="display: none; margin-bottom: 3px !important;"';
                                                        } else {
                                                            echo 'style="width: 100%;"';
                                                        } ?>>
                                <div class="create_l">
                                    <div class="control-group" <?php if ($edit_distributor_gateway_type == 'ac' || $field_array['ne_WAG'] == 'display_none') {
                                                                    echo 'style="display: none;"';
                                                                } else {
                                                                } ?>>
                                        <div class="controls col-lg-5 form-group">
                                            <label for="zone_name">Content Filtering<sup>
                                                    <font color="#FF0000"></font></label>
                                            <select class="span4 form-control" id="wag_name" name="wag_name" style="display: inline-block">
                                                <?php echo '<option value="">Select WAG Option</option>';

                                                if ($edit_distributor_wag_profile) {

                                                    $sel_ap = "AND  w.`ap_controller`='$edit_distributor_ap_controller'";
                                                } else {

                                                    $sel_ap = '';
                                                }

                                                $get_wags_per_controller = "SELECT w.`wag_code`,w.`wag_name` FROM `exp_wag_profile` w , `exp_mno_ap_controller` c
                                                WHERE w.`ap_controller`=c.`ap_controller` " . $sel_ap . " AND c.`mno_id`='$user_distributor' GROUP BY w.`wag_code`";

                                                $get_wags_per_controller_r = $db->selectDB($get_wags_per_controller);

                                                foreach ($get_wags_per_controller_r['data'] as $get_wags_per_controller_d) {
                                                    if ($edit_distributor_wag_profile == $get_wags_per_controller_d[wag_code]) {
                                                        $wag_select = "selected";
                                                    } else {
                                                        $wag_select = '';
                                                    }
                                                    echo '<option ' . $wag_select . ' value="' . $get_wags_per_controller_d[wag_code] . '">' . $get_wags_per_controller_d[wag_name] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="create_r">
                                    <div class="control-group">
                                        <div class="controls col-lg-5 form-group">
                                            <input id="content_filter" name="content_filter" value="on" type="checkbox" data-size="mini" <?php if ($edit_distributor_wag_profile_enable == '1' || $edit_distributor_wag_profile_enable == 'on') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning"> &nbsp; <img data-toggle="tooltip" title="Turn the switch to ON will activate content filtering. Once the switch is set to ON, the property admin can turn on/off the content filtering. Once the switch is set to OFF, the content is no longer filtered and the property admin no longer have access to change it." src="layout/OPTIMUM/img/help.png" style="width: 25px;margin-bottom: -8px;cursor: pointer;">
                                            <div style="display: inline-block;">
                                                <?php
                                                include __DIR__ . '/' . $multi_service_area->POS_0;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="ac_profile_div" <?php if ($edit_distributor_gateway_type != 'ac') {
                                                            echo 'style="display: none; margin-bottom: 3px !important;"';
                                                        } else {
                                                            echo 'style="width: 100%;"';
                                                        } ?>>
                                <div class="create_l">
                                    <div class="control-group" style="margin-top: 15px;">
                                        <div class="controls col-lg-5 form-group" style="width: 240px;">
                                            <div style="display: inline-block;">
                                                <?php
                                                include __DIR__ . '/' . $multi_service_area->POS_0;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="create_r">

                                </div>
                            </div>

                            <?php if (array_key_exists('content_filter_dns', $field_array) ||  $package_features == "all") {

                            ?>
                                <div class="wired_div">

                                    <div id="content_filter_div" style="width: 100%; display: inherit;">
                                        <div class="create_l">
                                            <div class="control-group">

                                                <div class="controls col-lg-5 form-group">

                                                    <label for="optonal feature content filtering">Content Filtering<?php if ($field_array['g_QOS'] == "mandatory") { ?><sup>
                                                            <font color="#FF0000"></font>
                                                        </sup><?php } ?></label>

                                                    <select <?php if ($field_array['content_filter_dns'] == "mandatory") { ?>required<?php } ?> name="DNS_profile" id="DNS_profile" class="span4 form-control" style="margin-right:16px">
                                                        <?php echo '<option value="">Select Option</option>';

                                                        if ($edit_distributor_dns_profile) {
                                                            $sel_ap = "AND  w.`controller`='$edit_distributor_ap_controller'";
                                                        } else {
                                                            $sel_ap = '';
                                                        }

                                                        $get_wags_per_controller = "SELECT w.`profile_code`,w.`name` FROM `exp_controller_dns` w , `exp_mno_ap_controller` c
                                                            WHERE w.`controller`=c.`ap_controller` " . $sel_ap . " AND c.`mno_id`='$user_distributor' GROUP BY w.`profile_code`";

                                                        $get_wags_per_controller_r = $db->selectDB($get_wags_per_controller);

                                                        foreach ($get_wags_per_controller_r['data'] as $get_wags_per_controller_d) {
                                                            if ($edit_distributor_dns_profile == $get_wags_per_controller_d[profile_code]) {
                                                                $wag_select = "selected";
                                                            } else {
                                                                $wag_select = '';
                                                            }
                                                            echo '<option ' . $wag_select . ' value="' . $get_wags_per_controller_d[profile_code] . '">' . $get_wags_per_controller_d[name] . '</option>';
                                                        }
                                                        ?>
                                                    </select>

                                                    <script>
                                                        function seldns(scrt_var) {
                                                            var a = scrt_var.length;
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: 'ajax/refreshDNSProfiles.php',
                                                                data: {
                                                                    loc_GRE: "yes",
                                                                    ap_control_var: scrt_var,
                                                                    user: '<?php echo $user_distributor; ?>'
                                                                },
                                                                success: function(data) {

                                                                    //alert(data);
                                                                    $('#DNS_profile').empty();

                                                                    $("#DNS_profile").append(data);


                                                                    // document.getElementById("zones_loader").innerHTML = "";

                                                                }

                                                            });
                                                        }
                                                    </script>

                                                </div>

                                                <!-- /controls -->
                                            </div>
                                            <!-- /control-group -->


                                        </div>
                                        <div class="create_r" style="position: relative;">
                                            <div class="control-group" <?php if ($edit_distributor_gateway_type == 'ac' || $field_array['ne_WAG'] == 'display_none') {
                                                                            echo 'style="display: none; margin-bottom: 3px !important;"';
                                                                        } else {
                                                                            echo 'style="margin-bottom: 3px !important;"';
                                                                        } ?>>
                                                <div class="controls col-lg-5 form-group">
                                                    <input id="DNS_profile_control" name="DNS_profile_control" value="on" onchange="dns_control()" type="checkbox" data-size="mini" <?php if ($edit_distributor_dns_profile_enable == 1) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?> data-toggle="toggle" data-onstyle="success" data-offstyle="warning"> &nbsp; <img data-toggle="tooltip" title="Turn the switch to ON will activate content filtering. Once the switch is set to ON, the property admin can turn on/off the content filtering. Once the switch is set to OFF, the content is no longer filtered and the property admin no longer have access to change it." src="layout/OPTIMUM/img/help.png" style="width: 25px;margin-bottom: -8px;cursor: pointer;">

                                                    <script>
                                                        function dns_control() {
                                                            /*   var add_ap_form_validator = $('#location_form').data('bootstrapValidator');
                                                 var dnscheckBox = document.getElementById("DNS_profile_control");
                                                    alert(dnscheckBox);
                                              if (dnscheckBox.checked == true){
                                                 add_ap_form_validator.enableFieldValidators('DNS_profile', true);
                                              } else {
                                                 add_ap_form_validator.enableFieldValidators('DNS_profile', false);
                                                           }  */

                                                        }
                                                    </script>

                                                    <div style="display: inline-block;">
                                                        <?php
                                                        include __DIR__ . '/' . $multi_service_area->POS_0;
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <?php
                                if (!in_array('support', $access_modules_list) || $user_type == "SALES") {
                                    include_once __DIR__ . '/' . $multi_service_area->POS_1;
                                } else {
                                    include_once __DIR__ . '/' . $multi_service_area->POS_2;
                                }
                                ?>

                            <?php
                            } ?>

                            <div class="details-view-block grid automation">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">DHCP Pool VLAN</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $dhcp_pool; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Subset</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $subnet; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Subnet Mask</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $subnetMask; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Subnet Strat</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $guest_subnet_start; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Subnet End</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $guest_subnet_end; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Encryption</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $g_encryption; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Primary DNS</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $primary_dns; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Secondary DNS</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $secondary_dns; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Primary Filter DNS</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $primary_dns_filter; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Secondary Filter DNS</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $secondary_dns_filter; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">DHCP Lease Time</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $dhcp_lease_time; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">VLAN Start</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $g_vlan; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <br>

                    <div class="wired_div">
                        <div id="private_div" style="width: 100%; display: inline-block;">
                            <h4>Private Network </h4>
                            <div class="create_l">
                                <?php
                                if (array_key_exists('icomms_number', $field_array)) { ?>
                                    <div class="control-group pvt_icomme" id="icomme_div_p">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="customer_type">Customer Account Number<?php if ($field_array['icomms_number'] == "mandatory") { ?><font color="#FF0000"></font><?php } ?></label>
                                            <input type="text" class="span4 form-control" id="icomme_pvt" name="icomme_pvt" onblur="check_icom(this,0)" value="<?php echo $edit_distributor_verification_number; ?>" <?php if ($edit_account == 1 && $edit_distributor_network_type != 'VT') { ?>readonly<?php } ?>>
                                            <div style="display: none" id="img_icom_pvt"><img src="img/loading_ajax.gif"></div>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function() {



                                                $("#icomme_pvt").keypress(function(e) {

                                                    var ew = event.which;

                                                    //alert(ew);
                                                    // if(ew == 32)
                                                    //   return true;

                                                    if (ew == 45 || ew == 95) {
                                                        /*allow - and _ characters */
                                                        return true;
                                                    }

                                                    if (48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0 || ew == 8 || ew == 189) {
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }



                                                });


                                            });
                                        </script>
                                    </div>
                                <?php    }
                                if (array_key_exists('pr_gateway_type', $field_array)) { ?>
                                    <div class="control-group" id="pr_geteway_div">
                                        <div class="controls col-lg-5 form-group">
                                            <label for="pr_gateway_type">Private Gateway Type<?php if ($field_array['pr_gateway_type'] == "mandatory") { ?><sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?></label>

                                            <select onchange="pvtgatewaytype()" class="span4 form-control" id="pr_gateway_type" name="pr_gateway_type">

                                                <option value="">Select Gateway Type</option>
                                                <?php
                                                if (empty($edit_distributor_pr_gateway_type)) {
                                                    $edit_distributor_pr_gateway_type = "VSZ";
                                                }

                                                $get_gatw_type_q = "select gs.gateway_name ,gs.description from exp_gateways gs where `is_enable` ='1'";
                                                $get_gatw_type_r = $db->selectDB($get_gatw_type_q);

                                                foreach ($get_gatw_type_r['data'] as $gatw_row) {
                                                    $gatw_row_gtw = $gatw_row['gateway_name'];
                                                    $gatw_row_dis = $gatw_row['description'];
                                                ?>
                                                    <option <?php $edit_distributor_pr_gateway_type == $gatw_row_gtw ? print(" selected ") : print(""); ?> value="<?php echo $gatw_row_gtw; ?>"> <?php echo $gatw_row_dis; ?> </option>;

                                                <?php } ?>

                                            </select>


                                        </div>
                                    </div>
                                <?php  }
                                if (array_key_exists('p_QOS', $field_array) || $package_features == "all") {

                                ?>

                                    <div class="control-group" id="p_prof2" <?php if ($field_array['p_QOS'] == 'display_none') {
                                                                                echo 'style="display:none"';
                                                                            } ?>>

                                        <div class="controls col-lg-5 form-group">

                                            <label for="AP_contrl">Private QoS
                                                Profile<?php if ($field_array['p_QOS'] == "mandatory") { ?>
                                                <sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?>
                                            </label>

                                            <select <?php if ($field_array['p_QOS'] == "mandatory") { ?>required<?php } ?> name="AP_contrl" id="AP_contrl" class="span4 form-control">
                                                <option value="">Select
                                                    Profile
                                                </option>
                                                <?php
                                                $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='private' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                                $query_results = $db->selectDB($q1);
                                                $arraym = array();
                                                $arrayk = array();
                                                $arrayo = array();

                                                foreach ($query_results['data'] as $row) {
                                                    $dis_code = $row[product_code];
                                                    $QOS = $row[QOS];
                                                    $QOSLast = strtolower(substr($QOS, -1));
                                                    $product_name_new = str_replace('_', '-', $row[product_code]);
                                                    $name_ar = explode('-', $product_name_new);
                                                    $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                                    $duration_val = $duration[0];
                                                    $qosvalarr = explode('*', $name_ar[2]);
                                                    $ab = substr($name_ar[2], 0, 2);
                                                    if (!is_numeric($ab)) {
                                                        $ab = substr($name_ar[2], 0, 1);
                                                    }
                                                    $bb = substr($name_ar[2], -2);
                                                    if (!is_numeric($bb)) {
                                                        $bb = substr($name_ar[2], -1);
                                                    }
                                                    $row['duration'] = $duration_val;
                                                    $row['qosval'] = $ab;
                                                    $row['qosval2'] = $bb;
                                                    if ($QOSLast == 'k') {
                                                        array_push($arrayk, $row);
                                                    } else if ($QOSLast == 'm') {
                                                        array_push($arraym, $row);
                                                    } else {
                                                        array_push($arrayo, $row);
                                                    }
                                                }

                                                CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                                CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                                CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                                $arrayfinal = array();
                                                if (empty($arrayk)) {
                                                    $arrayfinal = $arraym;
                                                } else {
                                                    if (empty($arraym)) {
                                                        $arrayfinal = $arrayk;
                                                    } else {
                                                        $arrayfinal = array_merge($arrayk, $arraym);
                                                    }
                                                }
                                                if (!empty($arrayo)) {
                                                    $arrayfinal = array_merge($arrayfinal,$arrayo);
                                                }

                                                foreach ($arrayfinal as $row) {
                                                    $dis_code = $row[product_code];
                                                    $dis_id = $row[product_id];
                                                    $dis_name = $row[product_name];
                                                    $dis_QOS = $row[QOS];

                                                    if ($edit_distributor_product_id_p == $dis_id) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }

                                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_code . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- /controls -->
                                    </div>
                                    <!-- /control-group -->


                                    <div class="control-group" id="pd_prof" <?php if ($field_array['pd_QOS'] == 'display_none') {
                                                                                echo 'style="display:none"';
                                                                            } ?>>

                                        <div class="controls col-lg-5 form-group">

                                            <label for="AP_contrl">Duration
                                                Profile<?php if ($field_array['pd_QOS'] == "mandatory") { ?>
                                                <sup>
                                                    <font color="#FF0000"></font>
                                                </sup><?php } ?>
                                            </label>

                                            <select <?php if ($field_array['pd_QOS'] == "mandatory") { ?>required<?php } ?> name="AP_contrl_time" id="AP_contrl_time" class="span4 form-control">
                                                <option value="">Select
                                                    Profile
                                                </option>
                                                <?php
                                                $q1 = "SELECT id,profile_code,profile_name,duration,profile_type
                                                        FROM exp_products_duration
                                                        WHERE profile_type IN('2','3') AND distributor='$user_distributor'";

                                                $query_results = $db->selectDB($q1);

                                                foreach ($query_results['data'] as $row) {
                                                    $select = "";
                                                    $dis_id = $row[id];
                                                    $dis_code = $row[profile_code];
                                                    $dis_name = $row[profile_name];
                                                    $timegap = $row[duration];
                                                    $gap = "";
                                                    if ($timegap != '') {

                                                        $interval = new DateInterval($timegap);

                                                        if ($interval->y != 0) {
                                                            $gap .= $interval->y . ' Years';
                                                        }
                                                        if ($interval->m != 0) {
                                                            $gap .= $interval->m . ' Months';
                                                        }
                                                        if ($interval->d != 0) {
                                                            $gap .= $interval->d . ' Days';
                                                        }
                                                        if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                                            $gap .= ' And ';
                                                        }
                                                        if ($interval->i != 0) {
                                                            $gap .= $interval->i . ' Minutes';
                                                        }
                                                        if ($interval->h != 0) {
                                                            $gap .= $interval->h . ' Hours';
                                                        }
                                                    }
                                                    if ($edit_distributor_product_id_p_time == $dis_code) {
                                                        $select = "selected";
                                                    }

                                                    echo "<option " . $select . " value='" . $dis_id . "'>" . $dis_name . " (" . $gap . ")" . "</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                        <!-- /controls -->
                                    </div>
                                    <!-- /control-group -->

                                <?php
                                } ?>

                            </div>
                            <div class="create_r">
                                <div class="control-group">
                                    <div class="controls form-group desable-se">
                                        <label for="pr_nu_of_network">Number Of Networks <img data-toggle="tooltip" title="To edit, delete or create additional WLANs please utilize the Match Table Parameter section below." src="layout/OPTIMUM/img/help.png" style="width: 18px; cursor: pointer;"></label>
                                        <?php if ($edit_account == 1 && (($edit_distributor_network_type == 'PRIVATE') || ($edit_distributor_network_type == 'VT-BOTH') || ($edit_distributor_network_type == 'BOTH') || ($edit_distributor_network_type == 'VT-PRIVATE'))) {
                                            echo '<div class="sele-disable-new span4_new" ></div>';
                                        } ?>
                                        <select required="" class="span4 form-control" id="pr_nu_of_network" name="pr_nu_of_network">
                                            <!-- <option value="">Select Number Of Network</option> -->
                                            <?php
                                            for ($i = 1; $i < 7; $i++) {
                                                if ($edit_wlan_count_arr['private'] == $i) {
                                                    echo '<option value="' . $i . '" selected> ' . $i . ' </option>';
                                                } else {
                                                    echo '<option value="' . $i . '"> ' . $i . ' </option>';
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="details-view-block grid automation">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Encryption</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $private_encryption; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">VLAN Start</div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                            <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $pvt_vlan; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <br>

                    <div id="vTenant_div" style="width: 100%; display: inline-block;">
                        <h4><span class="vt_name_new">vTenant</span> Network </h4>
                        <div class="create_l">
                            <div class="control-group" id="vt_group_div" style="position: relative;">
                                  <?php
                                        if ($vt_product_group == 1) {
                                            $selectsn = 'checked';
                                        } else {
                                            $selectsh = 'checked';
                                        } ?>
                              <div class="controls col-lg-5 form-group"><label for="dpsk_voucher">Resident Group QoS <i title="The group QoS is shared across a resident's devices while the device QoS is allocated to each of the resident's devices." class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" name="vt_product_type" value="Group" <?php echo $selectsn; ?>><label style="display :inline-block;min-width: 40%; max-width: 100%; ">Group QoS per Resident</label><input type="radio" name="vt_product_type" value="Device" <?php echo $selectsh; ?>><label style="display :inline-block;">QoS per Device</label></div>
                                      <!-- $edit_distributor_network_type -->

                            </div>

                            <script type="text/javascript">
            $('input[type=radio][name=vt_product_type]').change(function() {
              if (this.value == 'Group') {
                  $('#vtenant_aditinal_pro_hide').show();
                  $('#vt_additinal_feature').hide();
                  $('.device').hide();
                  $('.group').show();
                  if (group_product) {
                  $('#vt_guest_def_id').empty();
                  $("#vt_guest_def_id").append(vt_group_product);
                  }
              }
              else{
                  $('#vt_additinal_feature').show();
                  $('#vtenant_aditinal_pro_hide').hide();
                  $('.group').hide();
                  $('.device').show();
                  if (group_product) {
                  $('#vt_guest_def_id').empty();
                  $("#vt_guest_def_id").append(vt_default_product);
                }
              }
          });
          </script>
                            <div class="control-group" id="vt_icomme_div">
                                <div class="controls col-lg-5 form-group" style="position: relative;">
                                    <label for="customer_type"><span class="vt_name_new">vTenant</span> Account Number<?php if ($field_array['icomms_number'] == "mandatory") { ?><sup>
                                            <font color="#FF0000"></font>
                                        </sup><?php } ?></label>
                                    <input type="hidden" value="1" name="vt_nu_of_network" id="vt_nu_of_network">
                                    <?php if ($edit_account == 1) {
                                        echo '<div class="sele-disable span4" ></div>';
                                    } ?>
                                    <select required type="text" onchange="fillrealm(this);" class="span4 form-control" id="vt_icomme" name="vt_icomme" <?php if ($edit_account == 1) { ?><?php } ?>>
                                        <option value="">Select Option</option>
                                        <?php
                                        if ($edit_account == '1') {

                                            //$edit_acc_realm=$vtenant_model->getDistributorVtenant($edit_distributor_code);
                                            if ($edit_acc_realm !== false) {
                                                $vt_type = $edit_acc_realm->getType() == 'VTENANT' ? '(VT)' : '(MDU)';
                                                echo '<option selected value="' . $edit_acc_realm->getRealm() . '">' . $edit_acc_realm->getRealm() . $vt_type . '</option>';
                                                //exit();
                                            }
                                        }
                                        //$mno_vtenants = $vtenant_model->getUnusedMNOVtenants($user_distributor);
                                        foreach ($mno_vtenants as $vtenant) {
                                            $vt_type = $vtenant->getType() == 'VTENANT' ? '(VT)' : '(MDU)';
                                            echo '<option value="' . $vtenant->getRealm() . '">' . $vtenant->getRealm() . $vt_type . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div <?php if ($vt_product_group !=1) {echo 'style="display: none;"'; } ?> class="controls col-lg-5 form-group" id="vtenant_aditinal_pro_hide" >

                                  <label for="AP_contrl_guest"><font color="red">No vTenant Override</font>
                                  </label>
                              </div>
                                <div <?php if ($vt_product_group ==1) {echo 'style="display: none;"'; } ?>class="controls col-lg-5 form-group" id="vt_additinal_feature">
                                    <label for="AP_contrl_guest"><span class="vt_name_new">vTenant</span>
                                        additional Override QoS Profile [<font color="red">optional</font>]
                                    </label>
                                    <?php
                                    if ($edit_account == '1') {
                                        $assign_qos = array();
                                        $edit_acc_realm = $vtenant_model->getDistributorVtenant($edit_distributor_code);
                                        if ($edit_acc_realm !== false) {
                                            $vt_type = $edit_acc_realm->getType() == 'VTENANT' ? '(VT)' : '(MDU)';
                                            $realmvt = $edit_acc_realm->getRealm();

                                            // echo $edit_acc_realm;
                                            $selectQ = "SELECT `qos_override`
                            FROM mdu_vetenant 
                            WHERE property_id='$realmvt' AND LENGTH (qos_override) > 0";
                                            $query_Q = $db->selectDB($selectQ);

                                            foreach ($query_Q['data'] as $datanew) {
                                                array_push($assign_qos, $datanew['qos_override']);
                                            }
                                        }
                                    }
                                    $key_query = "SELECT `id`,`qos_id`,`qos_code`,`qos_name`,`network_type`
                            FROM exp_qos 
                            WHERE network_type <> 'VTENANT' AND mno_id='$user_distributor'";
                                    $query_results = $db->selectDB($key_query);
                                    /*$qos_defult=$db->getValueAsf("SELECT QOS as f
                                            FROM exp_products
                                            WHERE network_type='GUEST' AND mno_id='$user_distributor'");*/
                                    if (strlen($edit_distributor_code) != 0) {
                                        $key_queryn = "SELECT qos_id,qos_code
                            FROM exp_qos_distributor
                            WHERE `distributor_code`='$edit_distributor_code'";
                                        $query_resultsn = $db->selectDB($key_queryn);
                                    }
                                    $selected_qos = array();
                                    foreach ($query_resultsn['data'] as $row) {
                                        array_push($selected_qos, $row['qos_id']);
                                    }

                                    foreach ($query_results['data'] as $row) {
                                        //print_r($row);
                                        if ($row['qos_code'] != $qos_defult) {
                                            if (in_array($row['qos_id'], $selected_qos) and in_array($row['qos_id'], $assign_qos)) {
                                                $checked = 'checked';
                                                $disabled = 'readonly';
                                    ?>
                                                <div style="margin-bottom: -15px;">
                                                    <div class="checkbox-disable"> </div>
                                                    <input style="width: 28px !important" <?php echo $checked; ?> <?php echo $disabled; ?> class="span4 form-control <?php echo $disabled; ?>" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['qos_name']; ?>
                                                </div>
                                            <?php } elseif (in_array($row['qos_id'], $selected_qos)) {
                                                $checked = 'checked';
                                            ?>
                                                <input style="width: 28px !important" <?php echo $checked; ?> class="span4 form-control" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                                                <?php echo $row['qos_name']; ?>
                                            <?php } else { ?>
                                                <input style="width: 28px !important" class="span4 form-control" onclick="" name="qos_probation[]" type="checkbox" value="<?php echo $row['id']; ?>">
                                                <?php echo $row['qos_name']; ?>
                                            <?php
                                            }  ?>

                                    <?php //echo $row['qos_name'];
                                            echo "</br>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if ($package_functions->getSectionType('VTENANT_TYPE', $system_package) != '1' && (array_key_exists('vt_QOS_pri', $field_array) || $package_features == "all")) {
                            ?>

                                <div class="control-group" id="vt_guest_pri">

                                    <div class="controls col-lg-5 form-group">

                                        <label for="AP_contrl_guest"><span class="vt_name_new">vTenant</span>
                                            premium QoS Profile
                                        </label>

                                        <select <?php if ($field_array['vt_QOS_pri'] == "mandatory") { ?>required<?php } ?> name="vt_guest_pri" id="vt_guest_pri_id" class="span4 form-control" style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                            <option value="">Select
                                                Profile
                                            </option>
                                            <?php

                                            $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                            $query_results = $db->selectDB($q1);
                                            $arraym = array();
                                            $arrayk = array();
                                            $arrayo = array();

                                            foreach ($query_results['data'] as $row) {
                                                $dis_code = $row[product_code];
                                                $QOS = $row[QOS];
                                                $QOSLast = strtolower(substr($QOS, -1));
                                                $product_name_new = str_replace('_', '-', $row[product_code]);
                                                $name_ar = explode('-', $product_name_new);
                                                $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                                $duration_val = $duration[0];
                                                $qosvalarr = explode('*', $name_ar[2]);
                                                $ab = substr($name_ar[2], 0, 2);
                                                if (!is_numeric($ab)) {
                                                    $ab = substr($name_ar[2], 0, 1);
                                                }
                                                $bb = substr($name_ar[2], -2);
                                                if (!is_numeric($bb)) {
                                                    $bb = substr($name_ar[2], -1);
                                                }
                                                $row['duration'] = $duration_val;
                                                $row['qosval'] = $ab;
                                                $row['qosval2'] = $bb;
                                                if ($QOSLast == 'k') {
                                                    array_push($arrayk, $row);
                                                } else if ($QOSLast == 'm') {
                                                    array_push($arraym, $row);
                                                } else {
                                                    array_push($arrayo, $row);
                                                }
                                            }

                                            CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                            $arrayfinal = array();
                                            if (empty($arrayk)) {
                                                $arrayfinal = $arraym;
                                            } else {
                                                if (empty($arraym)) {
                                                    $arrayfinal = $arrayk;
                                                } else {
                                                    $arrayfinal = array_merge($arrayk, $arraym);
                                                }
                                            }
                                            if (!empty($arrayo)) {
                                                $arrayfinal = array_merge($arrayfinal,$arrayo);
                                            }

                                            foreach ($arrayfinal as $row) {
                                                $select = "";
                                                $dis_code = $row[product_code];
                                                $dis_g_id = $row[product_id];
                                                $dis_name = $row[product_name];
                                                $dis_QOS = $row[QOS];

                                                if ($edit_distributor_product_id_pri == $dis_g_id) {
                                                    $select = "selected";
                                                }

                                                echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                            <?php
                            } ?>
                            <div class="control-group" id="vt_voucher_div">
                                <?php
                                if ($edit_account == '1' && $edit_dpsk_enable) {
                                    if ($edit_dpsk_voucher == 'SINGLEUSE') {
                                        $selectsn = 'checked';
                                    } else {
                                        $selectsh = 'checked';
                                    } ?>
                                    <div class="controls col-lg-5 form-group"><label for="dpsk_voucher"><span class="vt_name_new">vTenant</span> Account Creation Voucher <i title="All tenants will need a voucher to enable them to create an account. depending on level of security you can select from two options: <br>
                      1.Shared voucher means all tenant use the same voucher code for account creation <br>
                      2.Single-use voucher means each tenant gets a unique one time voucher for account creation " class="icon icon-question-sign tooltips" style="color : #0568ea;margin-top: 3px; display:inline-block !important; font-size: 18px"></i> </label><input type="radio" name="dpsk_voucher" value="SHARED" <?php echo $selectsh; ?>><label style="display :inline-block;min-width: 29%; max-width: 100%; ">Shared</label><input type="radio" name="dpsk_voucher" value="SINGLEUSE" <?php echo $selectsn; ?>><label style="display :inline-block;">Single Use</label></div>
                                    <!-- $edit_distributor_network_type -->

                                <?php } ?>

                            </div>


                        </div>

                        <div class="create_r" style="margin-top: 70px;">

                            <div class="control-group" id="vt_guest_def">

                                <div class="controls col-lg-5 form-group">

                                    <label for="AP_contrl_guest"><span class="vt_name_new">vTenant</span>
                                        default Product<?php if ($field_array['g_QOS'] == "mandatory") { ?>
                                        <font color="#FF0000"></font><?php } ?>
                                    <a <?php if ($sync_array['g_QOS_sync'] == 'display') {
                                            echo 'style="margin-left:5px; display: inline-block;"';
                                        } else {
                                            echo 'style="display:none"';
                                        } ?> onclick="gotoSync(1);" class="" style="align: left;"><i class="btn-icon-only icon-refresh"></i>
                                        [Sync Products]</a>
                                    <div style="display: inline-block" id="sync_loader_VT"></div>
                                    </label>

                                    <select required name="vt_guest_def" id="vt_guest_def_id" class="span4 form-control" style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                        <option name="vtenant_pro_name" value="">Select vTenant Profile
                                        </option>
                                        <?php
                                        if ($aaa_type == 'ALE53') {
                                            $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap,default_value
                                            FROM exp_products
                                            WHERE network_type='VTENANT' AND mno_id='$user_distributor' AND (default_value='3' || default_value='1' || default_value IS NULL)";

                                            $query_results = $db->selectDB($q1);
                                            $arraym = array();
                                            $arrayk = array();
                                            $arrayo = array();
                                            foreach ($query_results['data'] as $row) {
                                                $dis_code = $row[product_code];
                                                $QOS = $row[QOS];
                                                $QOSLast = strtolower(substr($QOS, -1));
                                                $product_name_new = str_replace('_', '-', $row[product_code]);
                                                $name_ar = explode('-', $product_name_new);
                                                $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                                $duration_val = $duration[0];
                                                $qosvalarr = explode('*', $name_ar[2]);
                                                $ab = substr($name_ar[2], 0, 2);
                                                if (!is_numeric($ab)) {
                                                    $ab = substr($name_ar[2], 0, 1);
                                                }
                                                $bb = substr($name_ar[2], -2);
                                                if (!is_numeric($bb)) {
                                                    $bb = substr($name_ar[2], -1);
                                                }
                                                $row['duration'] = $duration_val;
                                                $row['qosval'] = $ab;
                                                $row['qosval2'] = $bb;
                                                if ($QOSLast == 'k') {
                                                    array_push($arrayk, $row);
                                                } else if ($QOSLast == 'm') {
                                                    array_push($arraym, $row);
                                                } else {
                                                    array_push($arrayo, $row);
                                                }
                                            }

                                            CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                            $arrayfinal = array();
                                            if (empty($arrayk)) {
                                                $arrayfinal = $arraym;
                                            } else {
                                                if (empty($arraym)) {
                                                    $arrayfinal = $arrayk;
                                                } else {
                                                    $arrayfinal = array_merge($arrayk, $arraym);
                                                }
                                            }
                                            if (!empty($arrayo)) {
                                                $arrayfinal = array_merge($arrayfinal,$arrayo);
                                            }
                                            $exists_in_lis=false;
                                            foreach ($arrayfinal as $row) {
                                                $selectd = "";
                                                $selectg = "";
                                                $dis_code = $row[product_code];
                                                $dis_g_id = $row[product_id];
                                                $dis_name = $row[product_name];
                                                $dis_QOS = $row[QOS];
                                                $dis_val = $row[default_value];
                                                if ($vt_product_group == 1) {
                                                  $styled= 'style="display: none;"';
                                                  if ($edit_distributor_product_id_def == $dis_g_id && $dis_val == 3) {
                                                      $selectg = "selected";
                                                      $exists_in_lis=true;
                                                  }
                                                }else{
                                                  $styleg= 'style="display: none;"';
                                                  if ($edit_distributor_product_id_def == $dis_g_id && $dis_val != 3) {
                                                    $selectd = "selected";
                                                      $exists_in_lis=true;
                                                  }
                                                }

                                                if ($dis_val == 3) {
                                                  echo "<option class='group' " . $selectg . "  ".$styleg." value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                }else{
                                                  echo "<option class='device' " . $selectd . " ".$styled." value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                }
                                            }
                                            if(!$exists_in_lis && $edit_account=='1' && !empty($edit_distributor_product_id_def)){
                                                $product_52 = $db->select1DB("SELECT product_code,QOS FROM exp_products WHERE product_id='$edit_distributor_product_id_def'");
                                                echo "<option selected value='$edit_distributor_product_id_g'>" . $product_52['product_code'] . " [" . $product_52['QOS'] . "]</option>";
                                            }
                                        } else {
                                            $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap,default_value
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor'  AND (default_value='3' || default_value='0' || default_value IS NULL)";

                                            $query_results = $db->selectDB($q1);

                                            foreach ($query_results['data'] as $row) {
                                                $select = "";
                                                $dis_code = $row[product_code];
                                                $dis_g_id = $row[product_id];
                                                $dis_name = $row[product_name];
                                                $dis_QOS = $row[QOS];
                                                $dis_val = $row[default_value];
                                                if ($vt_product_group == 1) {
                                                  $styled= 'style="display: none;"';
                                                  if ($edit_distributor_product_id_def == $dis_g_id && $dis_val == 3) {
                                                      $selectg = "selected";
                                                      $exists_in_lis=true;
                                                  }
                                                }else{
                                                  $styleg= 'style="display: none;"';
                                                  if ($edit_distributor_product_id_def == $dis_g_id && $dis_val != 3) {
                                                    $selectd = "selected";
                                                      $exists_in_lis=true;
                                                  }
                                                }

                                                if ($dis_val == 3) {
                                                  echo "<option class='group' " . $selectg . "  ".$styleg." value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                }else{
                                                  echo "<option class='device' " . $selectd . " ".$styled." value='" . $dis_g_id . "'>" . $dis_code . " [" . $dis_QOS . "]</option>";
                                                }

                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- /controls -->


                            </div>
                            <!-- /control-group -->

                            <?php if ($package_functions->getSectionType('VTENANT_TYPE', $system_package) != '1' && (array_key_exists('vt_QOS_pro', $field_array) || $package_features == "all")) {


                            ?>

                                <div class="control-group" id="vt_guest_pro">

                                    <div class="controls col-lg-5 form-group">

                                        <label for="AP_contrl_guest"><span class="vt_name_new">vTenant</span>
                                            probation QoS Profile
                                        </label>

                                        <select <?php if ($field_array['vt_QOS_pro'] == "mandatory") { ?>required<?php } ?> name="vt_guest_pro" id="vt_guest_pro_id" class="span4 form-control" style="margin-right: 16px !important; margin-bottom: 15px !important;">
                                            <option value="">Select
                                                Profile
                                            </option>
                                            <?php

                                            $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='GUEST' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                            $query_results = $db->selectDB($q1);
                                            $arraym = array();
                                            $arrayk = array();
                                            $arrayo = array();

                                            foreach ($query_results['data'] as $row) {
                                                $dis_code = $row[product_code];
                                                $QOS = $row[QOS];
                                                $QOSLast = strtolower(substr($QOS, -1));
                                                $product_name_new = str_replace('_', '-', $row[product_code]);
                                                $name_ar = explode('-', $product_name_new);
                                                $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                                $duration_val = $duration[0];
                                                $qosvalarr = explode('*', $name_ar[2]);
                                                $ab = substr($name_ar[2], 0, 2);
                                                if (!is_numeric($ab)) {
                                                    $ab = substr($name_ar[2], 0, 1);
                                                }
                                                $bb = substr($name_ar[2], -2);
                                                if (!is_numeric($bb)) {
                                                    $bb = substr($name_ar[2], -1);
                                                }
                                                $row['duration'] = $duration_val;
                                                $row['qosval'] = $ab;
                                                $row['qosval2'] = $bb;
                                                if ($QOSLast == 'k') {
                                                    array_push($arrayk, $row);
                                                } else if ($QOSLast == 'm') {
                                                    array_push($arraym, $row);
                                                } else {
                                                    array_push($arrayo, $row);
                                                }
                                            }

                                            CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                            CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                            $arrayfinal = array();
                                            if (empty($arrayk)) {
                                                $arrayfinal = $arraym;
                                            } else {
                                                if (empty($arraym)) {
                                                    $arrayfinal = $arrayk;
                                                } else {
                                                    $arrayfinal = array_merge($arrayk, $arraym);
                                                }
                                            }
                                            if (!empty($arrayo)) {
                                                $arrayfinal = array_merge($arrayfinal,$arrayo);
                                            }

                                            foreach ($arrayfinal as $row) {
                                                $select = "";
                                                $dis_code = $row[product_code];
                                                $dis_g_id = $row[product_id];
                                                $dis_name = $row[product_name];
                                                $dis_QOS = $row[QOS];

                                                if ($edit_distributor_product_id_pro == $dis_g_id) {
                                                    $select = "selected";
                                                }

                                                echo "<option " . $select . " value='" . $dis_g_id . "'>" . $dis_code . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- /controls -->
                                </div>
                                <!-- /control-group -->

                            <?php
                            }
                            ?>

                        </div>
                        <?php
                        if ($edit_account == '1') {
                            /*Create vTenant Object*/
                            require_once 'models/vtenantModel.php';
                            $vtenant_model = new vtenantModel();
                            $edit_acc_realm = $vtenant_model->getDistributorVtenant($edit_distributor_code);
                            if ($edit_acc_realm !== false) {
                                $vt_realm = $edit_acc_realm->getRealm();
                                $view_vtenant = $vtenant_model->getVtenant($vt_realm);
                                //print_r($view_vtenant);
                                $property_type = $view_vtenant->getType();
                                $deviceLimit = $view_vtenant->getDeviceLimit();
                                $signup_status = $view_vtenant->getSignup_Status();
                                $compact_link = $view_vtenant->getCompactLink();
                                $onboardingVLANID = $view_vtenant->getOnboardingVLANID();
                                $masterAccPurgeTime = $view_vtenant->getMasterAccPurgeTime();
                            }
                        }
                        ?>

                        <div class="details-view-block grid automation">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Property Type</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $property_type; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Account Creation</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $signup_status; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Account Expiration</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo 'Scheduled'; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Account Purge</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $masterAccPurgeTime; ?></div>
                                    </div>

                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Device Limit</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $deviceLimit; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Tiny URL</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $compact_link; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">Onboarding WIFI VLAN</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $onboardingVLANID; ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 item-name">VLAN Start</div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 item-name">:</div>
                                        <div class="col-lg-6 col-md-5 col-sm-6 col-5 item-name"><?php echo $vt_vlan; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>

                    <div class="submit-btn">

                        <?php if ($edit_account == '1') $btn_name = 'Update Location & Save';
                        else $btn_name = 'Add Location & Save';

                        if ($create_location_btn_action == 'create_location_next' || $create_location_btn_action == 'add_location_next'  || $_POST['p_update_button_action'] == 'add_location' || $edit_account == '1') {
                            echo '
                        <input type="hidden" name="location_layout_d" id="location_layout_d" value="new">
                        <button onmouseover="btn_action_change(\'add_location_submit\');" disabled type="submit" name="add_location_submit" id="add_location_submit" class="btn btn-primary">' . $btn_name . '</button><strong><font color="#FF0000"></font> </strong>';
                            $location_count = $db->getValueAsf("SELECT count(id) as f FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'");
                            if ($location_count < 1000  && !isset($_GET['edit_loc_id']) && !isset($_POST['p_update_button_action'])) {
                                echo '<button onmouseover="btn_action_change(\'add_location_next\');"  disabled type="submit" name="add_location_next" id="add_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                            }
                        } else {


                            echo '<button onmouseover="btn_action_change(\'create_location_submit\');"  disabled type="submit" name="create_location_submit" id="create_location_submit"
                class="btn btn-primary">Create Account & Save</button><strong><font color="#FF0000"></font> </strong>';

                            echo '<button onmouseover="btn_action_change(\'create_location_next\');" style="margin-top: 0px !important;" disabled type="submit" name="create_location_next" id="create_location_next" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>';
                        }


                        if ($edit_account == '1' || $_POST['p_update_button_action'] == 'add_location' || $_POST['btn_action'] == 'add_location_next') { ?>
                            <a href="?token7=<?php echo $secret; ?>&t=edit_parent&edit_parent_id=<?php echo $edit_parent_id; ?>" style="text-decoration:none;margin-top: 0px !important;" class="btn btn-info inline-btn">Cancel</a>
                        <?php } ?>


                        <input type="hidden" name="edit_account" value="<?php echo $edit_account; ?>" />
                        <input type="hidden" name="edit_distributor_code" value="<?php echo $edit_distributor_code; ?>" />
                        <input type="hidden" id="edit_distributor_id" name="edit_distributor_id" value="<?php echo $edit_loc_id; ?>" />
                        <input type="hidden" name="btn_action" id="btn_action" value="" />
                        <input type="hidden" name="add_new_location" value="<?php echo  $_POST['p_update_button_action'] == 'add_location' ? '1' : '0' ?>" />
                        <script type="text/javascript">
                            function btn_action_change(action) {
                                $('#btn_action').val(action);
                            }

                            $(document).ready(function() {
                                $(window).keydown(function(event) {
                                    if (event.keyCode == 13) {
                                        event.preventDefault();
                                        return false;
                                    }
                                });
                            });
                        </script>

                    </div>

                    <br>

                    <?php
                    if ($edit_account == '1') {
                        //$get_map_q = "SELECT * FROM `exp_lookup_entry` WHERE `realm` = '$edit_distributor_verification_number'  ORDER BY `id` ASC";
                        //$get_map = $db->selectDB($get_map_q);
                    } ?>

                    <div class="control-group" <?php if ($operator_matchentry != 'Yes') { ?> style="display: none;" <?php } ?>>
                        <h3 style="">Match Table Parameters Network</h3>
                        <br>


                        <div id="wlan_sync">
                            <label>WLAN to Property Zone Mapping <a onclick="gotorelm_matchtabel();" class="btn btn-primary" style="align: left; margin-left:10px"><i class="btn-icon-only icon-refresh"></i>
                                    <?php if ($edit_account == '1') {
                                        echo "Sync WLANs";
                                    } else {
                                        echo "Load WLANs";
                                    } ?>
                                </a>
                                <div style="display: inline-block" id="re_mapp_loader"></div>
                            </label>
                        </div>
                        <div <?php if ($edit_account != 1) { ?> style="display: none;" <?php } ?>>
                            <button onclick="clickWlancreate()" class="btn btn-info" type="button" data-toggle="modal" data-target="#wlanframe_create">Create WLAN</button>
                        </div>


                        <!--<iframe id="wlanframe" style="display: none;"></iframe>-->


                        <div id="network_table" class="controls col-lg-5 form-group" style="margin-left: 0px; margin-top: 33px;width:100%">
                            <div class="widget widget-table action-table">

                                <div class="widget-content ">
                                    <div style="overflow-x:auto;margin:auto" class="theme_response">
                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Network Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">vlan</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Access Group</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Match Table Entry</th>
                                                </tr>
                                            </thead>
                                            <tbody id="realm_mapp">
                                                <?php


                                                //print_r($get_apGroup);
                                                if ($get_map['rowCount'] > 0) {
                                                    foreach ($get_map['data'] as $row) {
                                                        $vlanid = $row['vlan_id'];
                                                        if ($vlanid == '') {
                                                            $vlanid = 'n/a';
                                                        }
                                                        $wlan_name = strtolower($row['wlan_name']);
                                                        if (substr($wlan_name, 0, strlen("guest")) === "guest") {
                                                            if ($vlanid != 'n/a') {
                                                                $vlanid = $g_vlan;
                                                            }
                                                            $wlan_type = "Guest";
                                                            $wlan_typen = 1;
                                                        } elseif (substr($wlan_name, 0, strlen("private")) === "private") {
                                                            if ($vlanid != 'n/a') {
                                                                $vlanid = $pvt_vlan;
                                                            }
                                                            $wlan_type = "Private";
                                                            $wlan_typen = 2;
                                                        } elseif (substr($wlan_name, 0, strlen("vtenant")) === "vtenant") {
                                                            if ($vlanid != 'n/a') {
                                                                $vlanid = $vt_vlan;
                                                            }
                                                            $wlan_type = "vTenant";
                                                            $wlan_typen = 3;
                                                        } else {
                                                            if ($vlanid != 'n/a') {
                                                                $vlanid = $vt_vlan;
                                                            }
                                                            $wlan_type = false;
                                                            $wlan_typen = 4;
                                                        }
                                                        $id = $row['id'];
                                                        $match_entry = $row['match_entry'];
                                                        echo $result = '<tr>
        <td>' . $row['wlan_name'] . '</td>
        <td>' . $vlanid . '</td>
        <td>' . $row['net_realm'] . '</td>
        <td>' . $row['match_entry'] . '</td>';
                                                        if ($wlan_type == 'Guest') {
                                                            echo '<td><button onclick="updatewlan(' . $id . ',' . $wlan_typen . ')" class="btn btn-small btn-info" type="button" data-toggle="modal" data-target="#wlanframe_g">&nbsp;Edit</button></td>';
                                                        } elseif ($wlan_type == 'Private') {
                                                            echo '<td><button onclick="updatewlan(' . $id . ',' . $wlan_typen . ')" class="btn btn-small btn-info" type="button" data-toggle="modal" data-target="#wlanframe_pvt">&nbsp;Edit</button></td>';
                                                        } elseif ($wlan_type == 'vTenant') {
                                                            echo '<td><button onclick="updatewlan(' . $id . ',' . $wlan_typen . ')" class="btn btn-small btn-info" type="button" data-toggle="modal" data-target="#wlanframe_vtn">&nbsp;Edit</button></td>';
                                                        } else {
                                                            echo '<td><button onclick="updatewlan(' . $id . ',' . $wlan_typen . ')" class="btn btn-small btn-info" type="button" data-toggle="modal" data-target="#wlanframe_sub">&nbsp;Edit</button></td>';
                                                            //echo '<td><button disabled class="btn btn-small btn-info" type="button" >&nbsp;Edit</button></td>';
                                                        }
                                                        echo '<td><button onclick="deletewlan(' . $id . ',' . $wlan_typen . ')" class="btn btn-small btn-info" type="button" >&nbsp;Delete</button></td></tr>';
                                                    }
                                                }


                                                ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /controls -->


                    </div>


                </fieldset>


            </div>
        </div>


        <script type="text/javascript">
            $('#icomme').on('keyup change', function() {
                $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
            });

            $('#icomme_pvt').on('keyup change', function() {
                $("#icomme_div_p small[data-bv-validator='notEmpty']").html('<p>This is a required field</p>');
            });

            function wagnamevalidate(edit_account, pr_gateway_type, gateway_type) {
                automation_control();
                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                var edit_account = "<?php echo $_GET['edit_loc_id']; ?>";
                if (edit_account) {
                    var pr_gateway_type = "<?php echo $edit_distributor_pr_gateway_type; ?>";
                    var gateway_type = "<?php echo $edit_distributor_gateway_type; ?>";
                    if (gateway_type != 'WAG' && pr_gateway_type != 'WAG') {
                        bootstrapValidator.enableFieldValidators('wag_name', false);
                    } else {
                        bootstrapValidator.enableFieldValidators('wag_name', true);
                    }

                }
            }

            function check_icom(icomval, type) {

                if ($('#icomme').is('[readonly]')) {


                } else if ($('#icomme_pvt').is('[readonly]')) {


                } else {

                    var valic = icomval.value;
                    var valic = valic.trim();
                    var distributor = "";
                    <?php
                    if ($edit_account == 1) {
                        echo "distributor='" . $edit_distributor_code . "';";
                    }
                    ?>


                    if (valic != "") {
                        if (type == 0) {
                            $('#img_icom_pvt').css('display', 'inline-block');
                        } else {
                            $('#img_icom').css('display', 'inline-block');
                        }
                        var formData = {
                            icom: valic,
                            edit: "<?php echo $edit_account; ?>",
                            distributor: distributor
                        };
                        $.ajax({
                            url: "ajax/validateIcom.php",
                            type: "POST",
                            data: formData,
                            success: function(data) {
                                /*  if:new ok->1
                                 * if:new exist->2 */


                                if (data == '1') {
                                    /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                    if (type == 0) {
                                        $('#img_icom_pvt').hide();
                                    } else {
                                        $('#img_icom').hide();
                                    }

                                    document.getElementById("realm").value = valic;
                                    <?php if ($field_array['network_config'] == 'display_none') { ?>
                                        document.getElementById("zone_name").value = valic;
                                        document.getElementById("zone_dec").value = valic;
                                    <?php } ?>


                                } else if (data == '2') {
                                    //alert(data);
                                    if (type == 0) {
                                        $('#img_icom_pvt').hide();
                                        document.getElementById('icomme_pvt').value = "";
                                        document.getElementById("realm").value = "";
                                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                                            document.getElementById("zone_name").value = "";
                                            document.getElementById("zone_dec").value = "";
                                        <?php } ?>
                                        /* $('#mno_account_name').removeAttr('value'); */
                                        document.getElementById('icomme_pvt').placeholder = "Please enter new Customer Account number";
                                        $("#icomme_div_p small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme_pvt', 'NOT_VALIDATED').validateField('icomme_pvt');

                                    } else {
                                        $('#img_icom').hide();
                                        document.getElementById('icomme').value = "";
                                        document.getElementById("realm").value = "";
                                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                                            document.getElementById("zone_name").value = "";
                                            document.getElementById("zone_dec").value = "";
                                        <?php } ?>
                                        /* $('#mno_account_name').removeAttr('value'); */
                                        document.getElementById('icomme').placeholder = "Please enter new Customer Account number";

                                        $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                        $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');
                                    }
                                }



                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                //alert("error");
                                document.getElementById('icomme').value = "";
                                document.getElementById("realm").value = "";
                                <?php if ($field_array['network_config'] == 'display_none') { ?>
                                    document.getElementById("zone_name").value = "";
                                    document.getElementById("zone_dec").value = "";
                                <?php } ?>
                                if (type == 0) {
                                    $("#icomme_div_p small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');

                                    $('#location_form').data('bootstrapValidator').updateStatus('icomme_pvt', 'NOT_VALIDATED').validateField('icomme_pvt');

                                } else {
                                    $("#icomme_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');


                                    $('#location_form').data('bootstrapValidator').updateStatus('icomme', 'NOT_VALIDATED').validateField('icomme');
                                }




                            }



                        });
                        var bootstrapValidator2 = $('#location_form').data('bootstrapValidator');
                        bootstrapValidator2.enableFieldValidators('realm', true);
                        <?php if ($field_array['network_config'] == 'display_none') { ?>
                            bootstrapValidator2.enableFieldValidators('zone_name', true);
                            bootstrapValidator2.enableFieldValidators('zone_dec', true);

                        <?php } ?>
                    }


                }





            }
        </script>



        <?php


        if (array_key_exists('network_config', $field_array)) {

        ?>




        <?php
            $get_tunnel_q = "SELECT CONCAT('{',GROUP_CONCAT('\"',g.gateway_name,'\":',g.tunnels),'}') AS a FROM exp_gateways g GROUP BY g.is_enable";

            $get_tunnels = $db->selectDB($get_tunnel_q);

            foreach ($get_tunnels['data'] as $tunnels) {
                $tunnelsa = $tunnels[a];
            }
        } ?>

        <input class="span4 form-control" id="row_number" name="row_number" type="hidden">
        <input class="span4 form-control" id="wlan_automation" name="wlan_automation" type="hidden" value="Yes">
        <input class="span4 form-control" id="guest_vlan" name="guest_vlan" type="hidden" value="<?php echo $g_vlan; ?>">
        <input class="span4 form-control" id="pvt_vlan" name="pvt_vlan" type="hidden" value="<?php echo $pvt_vlan; ?>">
        <input class="span4 form-control" id="vt_vlan" name="vt_vlan" type="hidden" value="<?php echo $vt_vlan; ?>">
        <div class="actions clearfix">
            <ul style="list-style: none;float: right;margin: 0;" role="menu" aria-label="Pagination">
                <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-disabled="true"><a href="javascript:void(0)" data-type="previous" class="btn btn-primary" role="menuitem">Previous</a></li>
                <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-hidden="false" aria-disabled="true"><a tabindex="119" href="javascript:void(0)" data-type="next" class="btn btn-primary" role="menuitem">Next</a></li>
                <li class="finishStepone" style="display: none; margin-left: 5px;" aria-hidden="true"><a tabindex="120" href="#steponesubmit" class="btn btn-primary" name="location_submit_one" id="location_submit_one" role="menuitem">Update Account Info</a></li>
                <li class="finishSteptwo" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="#steptwosubmit" class="btn btn-primary" name="location_submit_two" id="location_submit_two" role="menuitem">Update Controller Info</a></li>
                <li class="finishParent" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="#finish" class="btn btn-primary" role="menuitem">Finish</a></li>
                <li class="cancelform" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="?token7=<?php echo $secret; ?>&t=edit_parent&edit_parent_id=<?php echo $edit_parent_id; ?>" class="btn btn-primary" role="menuitem">Cancel</a></li>
            </ul>
        </div>

        <!-- /form-actions -->
    </form>

    <script>
        $(document).ready(function() {
            document.getElementById("wlanframe_create").style.display = "none";
            document.getElementById("wlanframe_g").style.display = "none";
            document.getElementById("wlanframe_pvt").style.display = "none";
            document.getElementById("wlanframe_vtn").style.display = "none";
            document.getElementById("wlanframe_sub").style.display = "none";

            document.getElementById("wag_profile_div").style.display = "none";
            document.getElementById("ac_profile_div").style.display = "none";

            var edit_account = "<?php echo $edit_account; ?>";
            if (edit_account) {
                var controller = "<?php echo $edit_distributor_ap_controller; ?>";
                var gateway_type = "<?php echo $edit_distributor_gateway_type; ?>";
                var support_user = "<?php echo $support_user; ?>";
                var edit_distributor_dns_profile = "<?php echo $edit_distributor_dns_profile; ?>";
                var edit_distributor_wag_profile = "<?php echo $edit_distributor_wag_profile; ?>";
                var operator_matchentry = "<?php echo $operator_matchentry; ?>";
                if (!support_user) {
                    if (!edit_distributor_dns_profile) {
                        seldns(controller);
                    }
                    if (!edit_distributor_wag_profile) {
                        selwags(controller);
                    }

                }
                if (gateway_type == 'WAG') {
                    document.getElementById("content_filter_div").style.display = "none";
                    document.getElementById("wag_profile_div").style.display = "inline-block";
                } else if (gateway_type == 'VSZ') {
                    document.getElementById("content_filter_div").style.display = "inline-block";
                } else {
                    document.getElementById("content_filter_div").style.display = "none";
                    document.getElementById("ac_profile_div").style.display = "inline-block";
                }

                if (operator_matchentry == 'Yes') {
                    gotorelm_matchtabel();
                }



            }
            pvtgatewaytype();
            gatewaytype();

        });

        function pvtgatewaytype() {
            var gateway_type = $("#pr_gateway_type").val();
            $('#lookup_vlan_p').show();
            document.getElementById("lookup_key_pvt").style.width = "65%";
            $('#lookup_vlan_pvt').show();
            document.getElementById("lookup_key_pt").style.width = "65%";
            if (gateway_type == 'AC') {
                document.getElementById("lookup_key_pvt").style.width = "100%";
                $('#lookup_vlan_p').hide();
                document.getElementById("lookup_key_pt").style.width = "100%";
                $('#lookup_vlan_pvt').hide();
            }
        }

        function gatewaytype() {
            var gateway_type = $("#gateway_type").val();
            $('#lookup_vlan_g').show();
            $('#lookup_vlan_guest').show();
            document.getElementById("lookup_key_guest").style.width = "65%";
            document.getElementById("lookup_key_g").style.width = "65%";
            if (gateway_type == 'AC') {
                document.getElementById("lookup_key_guest").style.width = "100%";
                $('#lookup_vlan_g').hide();
                document.getElementById("lookup_key_g").style.width = "100%";
                $('#lookup_vlan_guest').hide();
            }

            if (gateway_type == 'WAG') {
                document.getElementById("content_filter_div").style.display = "none";
                document.getElementById("ac_profile_div").style.display = "none";
                document.getElementById("wag_profile_div").style.display = "inline-block";
            } else if (gateway_type == 'VSZ') {
                document.getElementById("wag_profile_div").style.display = "none";
                document.getElementById("ac_profile_div").style.display = "none";
                document.getElementById("content_filter_div").style.display = "inline-block";
            } else {
                $(".multi_area_option").map(function() {
                    //this.prop;
                    <?php if (!isset($other_multi_area)) { ?>
                        $(this).prop("checked", false);
                    <?php } ?>
                })
                $('#service_areas').hide();
                document.getElementById("ac_profile_div").style.display = "inline-block";
                document.getElementById("wag_profile_div").style.display = "none";
                document.getElementById("content_filter_div").style.display = "none";
            }
        }


        function automation_control() {
            var bootstrapValidator = $('#location_form').data('bootstrapValidator');
            var automation_control = document.getElementById("automation_property").checked;
            if (automation_control) {
                document.getElementById("gateway_type").options[2].disabled = true;
                document.getElementById("gateway_type").options[3].disabled = true;
                bootstrapValidator.enableFieldValidators('zone', false);
                $('#zone_div').hide();
                $('#group_div').hide();
                $('#wlan_sync').show();
                $('#match_entry_tabel').show();
                $('.automation').show();
            } else {
                $('.automation').hide();
                document.getElementById("gateway_type").options[2].disabled = false;
                document.getElementById("gateway_type").options[3].disabled = false;
                bootstrapValidator.enableFieldValidators('zone', true);
                $('#zone_div').show();
                $('#group_div').show();
                $('#wlan_sync').show();
                $('#match_entry_tabel').show();
            }

        }


        function updatewlan(id, wlan_type) {
            var match_entry_arr = <?php echo json_encode($get_map['data']) ?>;
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'ajax/updateWlan.php',
                data: {
                    user_distributor: "<?php echo $user_distributor; ?>",
                    flow_type: "<?php echo $new_flow_account; ?>",
                    wlan_type: 'get',
                    system_package: "<?php echo $system_package; ?>",
                    user_name: "<?php echo $user_name; ?>",
                    query_id: id
                },
                success: function(data) {
                    $("#row_number").val(data['row_number']);
                    var wlan_typen = data['wlan_type'];
                    if (wlan_typen == 'Mdu') {
                        document.getElementById("lookup_key_guest").style.width = "100%";
                        $('#lookup_vlan_g').hide();
                        $("#vlan_guest_update").hide();
                    } else {
                        $("#vlan_guest_update").show();
                    }
                    if (wlan_type == '1') {
                        $("#lookup_key_guest").val(data['lookup_key']);
                        $("#lookup_vlan_g").val(data['vlan']);
                        $("#location_id_guest").val(data['lookup_key']);
                        $("#access_group_guest").val(data['access_group']);
                        $("#redirect_url_guest").val(data['redirect_url']);
                        $("#zone_id_guest").val(data['zone_id']);
                        $("#description_guest").val(data['description']);
                        $("#vlan_g").val(data['vlan']);
                        document.getElementById("wlanframe_g").style.display = "block";
                    }
                    if (wlan_type == '2') {
                        $("#lookup_key_pvt").val(data['lookup_key']);
                        $("#lookup_vlan_p").val(data['vlan']);
                        $("#location_id_pvt").val(data['lookup_key']);
                        $("#access_group_pvt").val(data['access_group']);
                        $("#product_pvt").val(data['product']);
                        $("#zone_id_pvt").val(data['zone_id']);
                        $("#description_pvt").val(data['description']);
                        $("#vlan_p").val(data['vlan']);
                        document.getElementById("wlanframe_pvt").style.display = "block";

                    }
                    if (wlan_type == '3') {
                        $("#onboardvlan").val(data['onboard_vlan']);
                        $("#description_vt").val(data['description']);
                        $("#zone_id_vt").val(data['zone_id']);
                        $("#access_group_vt").val(data['access_group']);

                        document.getElementById("wlanframe_vtn").style.display = "block";

                    }
                    if (wlan_type == '4') {
                        if (data['wlan_name'] == 'onboarding-ac') {
                            document.getElementById("redirct_url_ac").style.display = "block";
                        } else {
                            document.getElementById("redirct_url_ac").style.display = "none";
                        }
                        $("#lookup_key_sub").val(data['lookup_key']);
                        $("#location_id_sub").val(data['lookup_key']);
                        $("#redirect_url_sub").val(data['redirect_url']);
                        $("#zone_id_sub").val(data['zone_id']);
                        $("#description_sub").val(data['description']);

                        document.getElementById("wlanframe_sub").style.display = "block";
                    }
                },
                error: function() {

                }

            });


        }

        function deletewlan(id, wlan_type) {
            if (wlan_type == '1') {
                var wlan_count = $("#g_nu_of_network").val();
            }
            if (wlan_type == '2') {
                var wlan_count = $("#pr_nu_of_network").val();
            }
            if (wlan_type == '3') {
                var wlan_count = $("#vt_nu_of_network").val();
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'ajax/updateWlan.php',
                data: {
                    user_distributor: "<?php echo $user_distributor; ?>",
                    flow_type: "<?php echo $new_flow_account; ?>",
                    wlan_type: 'delete',
                    system_package: "<?php echo $system_package; ?>",
                    user_name: "<?php echo $user_name; ?>",
                    query_id: id,
                    wlan: wlan_type,
                    edit_distributor_code: "<?php echo $edit_distributor_code; ?>"
                },
                success: function(data) {
                    if ($data = 204) {
                        if (wlan_type == '1' && wlan_count > 1) {
                            document.getElementById("g_nu_of_network").value = wlan_count - 1;
                        }
                        if (wlan_type == '2' && wlan_count > 1) {
                            document.getElementById("pr_nu_of_network").value = wlan_count - 1;
                        }
                        if (wlan_type == '3' && wlan_count > 1) {
                            document.getElementById("vt_nu_of_network").value = wlan_count - 1;
                        }
                        gotorelm_matchtabel();
                    }
                },
                error: function() {

                }

            });
        }

        function wlancreate() {
            document.getElementById("createwlan").disabled = true;
            var type = $("input[name='wlan_type_new']:checked").val();
            var icomme = $("#icomme").val();
            if (type == 'Private') {
                var gateway_type = $("#pr_gateway_type").val();
                var wlan_count = $("#pr_nu_of_network").val();
                var lookup_key = $("#lookup_key_pt").val();
                var location_id = $("#location_id_pt").val();
                var product = $("#product_pt").val();
                var description = $("#description_pt").val();
                var vlan = $("#vlan_new_p").val();
            } else {
                var gateway_type = $("#gateway_type").val();
                var wlan_count = $("#g_nu_of_network").val();
                var lookup_key = $("#lookup_key_g").val();
                var location_id = $("#location_id_g").val();
                var redirect_url = $("#redirect_url_g").val();
                var description = $("#description_g").val();
                var vlan = $("#vlan_new_g").val();
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'ajax/updateWlan.php',
                data: {
                    user_distributor: "<?php echo $user_distributor; ?>",
                    flow_type: "<?php echo $new_flow_account; ?>",
                    dis_zone_id: "<?php echo $dis_zone_id; ?>",
                    wlan_type: 'create',
                    location_id: location_id,
                    icomme_number: icomme,
                    lookup_key: lookup_key,
                    redirect_url: redirect_url,
                    system_package: "<?php echo $system_package; ?>",
                    user_name: "<?php echo $user_name; ?>",
                    gateway_type: gateway_type,
                    type: type,
                    wlan_count: wlan_count,
                    vlan: vlan,
                    product: product,
                    description: description,
                    edit_distributor_code: "<?php echo $edit_distributor_code; ?>"
                },
                success: function(data) {
                    document.getElementById("createwlan").disabled = false;
                    //document.getElementById("wlanframe_create").style.display = "none";
                    //$("#wlanframe_create").modal("hide");
                    $("#wlanframe_create .close").click();

                    if (data == 200) {
                        wlan_count++;
                        //alert(wlan_count);
                        if (type == 'Private') {

                            document.getElementById("pr_nu_of_network").value = wlan_count;
                        } else {
                            document.getElementById("g_nu_of_network").value = wlan_count;
                        }
                        //document.getElementById("wlanframe_create").style.display = "none";
                        gotorelm_matchtabel();
                    }
                }

            });

        }

        var sync_no;

        function gotorelm_matchtabel(sync_no) {

            var zone_id = document.getElementById("zone").value;
            var icomme = document.getElementById("icomme").value;
            var icomme_pvt = document.getElementById("icomme_pvt").value;

            var loc_name = document.getElementById("location_name1").value;
            var scrt_var = document.getElementById("conroller").value;
            var vt_icomme = document.getElementById("vt_icomme").value;
            var product = document.getElementById("AP_contrl_guest").value;
            var vt_product = document.getElementById("vt_guest_def_id").value;
            var admin_features = $("#admin_features").val();
            var network_type = $('#network_type').val();
            var gateway_type = document.getElementById("gateway_type").value;
            var pr_gateway_type = document.getElementById("pr_gateway_type").value;

            var vt_wlan_count = document.getElementById("vt_nu_of_network").value;
            var pvt_wlan_count = document.getElementById("pr_nu_of_network").value;
            var g_wlan_count = document.getElementById("g_nu_of_network").value;
            var business_type = document.getElementById("business_type").value;
            var edit_account = "<?php echo $edit_account; ?>";
            var guest_vlan = "<?php echo $g_vlan; ?>";
            var pvt_vlan = "<?php echo $pvt_vlan; ?>";
            var vt_vlan = "<?php echo $vt_vlan; ?>";
            if (document.getElementById('wired_property').checked) {
                var wired_property = 1;
            } else {
                var wired_property = 0;
            }


            var a = product.length;
            var b = icomme.length;
            var c = vt_icomme.length;
            var d = icomme_pvt.length;
            var e = vt_product.length;
            if (b == 0) {
                b = d;
                icomme = icomme_pvt;
            }
            //console.log(network_type);
            //alert(e);
            var guest_n = 0;
            var vt_n = 0;
            var pvt_n = 0;
            if (wired_property == 0) {
            network_type.forEach(function(element) {
                if (element == 'GUEST') {
                    guest_n = 1;
                }
                if (element == 'PRIVATE') {
                    pvt_n = 1;
                }
                if (element == 'VT') {
                    vt_n = 1;
                }
            });
            }
            else{
                vt_n = 1;
            }
            //alert(vt_n);

            if ((guest_n == 1 || pvt_n == 1) && b == 0 ) {
                alert('Please Select Customer Account Number');
            }else if(vt_n == 1 && c == 0){
                alert('Please Select vTenant Account Number');
            }else if(a == 0 && guest_n == 1){
                alert('Please Select Guest Product');
            }else if(e == 0 && vt_n == 1){
                alert('Please Select vTenant Product');
            } else {
                document.getElementById("re_mapp_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

                $.ajax({
                    type: 'POST',
                    url: 'ajax/get_wlan_matchtable.php',
                    data: {
                        wag_ap_name: "<?php echo $wag_ap_name; ?>",
                        ap_control_var: "<?php echo $ap_control_var; ?>",
                        ackey: scrt_var,
                        mno: "<?php echo $user_distributor; ?>",
                        flow_type: "<?php echo $new_flow_account; ?>",
                        loc_name: loc_name,
                        mvno: "<?php echo $edit_distributor_code; ?>",
                        zone_id: zone_id,
                        icomme: icomme,
                        vt_icomme: vt_icomme,
                        vt_wlan_count: vt_wlan_count,
                        vt_product: vt_product,
                        admin_features: admin_features,
                        pvt_wlan_count: pvt_wlan_count,
                        g_wlan_count: g_wlan_count,
                        edit_account: edit_account,
                        product: product,
                        gateway_type: gateway_type,
                        pr_gateway_type: pr_gateway_type,
                        network_type: network_type,
                        sync_no: sync_no,
                        guest_vlan: guest_vlan,
                        pvt_vlan: pvt_vlan,
                        vt_vlan: vt_vlan,
                        business_type: business_type,
                        wired_property: wired_property
                    },
                    success: function(data) {
                        //var str = data;
                        var g_count = data.substring(0, 1);
                        var pvt_count = data.substring(1, 2);
                        // alert(data);
                        console.log(g_count);
                        console.log(pvt_count);

                        $('#realm_mapp').empty();
                        if (sync_no != 1) {
                        if (g_count < 1) {
                            document.getElementById("g_nu_of_network").value = 1;
                            document.getElementById("pr_nu_of_network").value = 1;
                        } else {
                            document.getElementById("g_nu_of_network").value = g_count;
                            document.getElementById("pr_nu_of_network").value = pvt_count;
                        }
                        }


                        $("#realm_mapp").append(data);

                        document.getElementById("re_mapp_loader").innerHTML = "";

                    },
                    error: function() {
                        document.getElementById("re_mapp_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                    }

                });



            }

        }

        function wired_control() {

            var bootstrapValidator = $('#location_form').data('bootstrapValidator');
            if (document.getElementById('wired_property').checked) {
                bootstrapValidator.enableFieldValidators('zone', false);
                $(".wired_div").hide();
                $("#zone_div").hide();
                $("#group_div").hide()
                $("#vTenant_div").show();
                $("#vt_icomme_div").show();
                $("#vt_guest_def").show();




            } else {

                $(".wired_div").show();
                $("#zone_div").show();
                $("#group_div").show();
                <?php if (!isset($edit_wired_enable)) { ?>
                    $("#vTenant_div").hide();
                <?php } ?>

                bootstrapValidator.enableFieldValidators('zone', true);

            }
        }


        function ed_wired_control(wired) {

            var bootstrapValidator = $('#location_form').data('bootstrapValidator');
            if (wired == 1) {
                bootstrapValidator.enableFieldValidators('zone', false);
                $(".wired_div").hide();
                $("#zone_div").hide();
                $("#group_div").hide()
                $("#vt_icomme_div").show();
                $("#vt_guest_def").show();
                $("#vTenant_div").show();
                $("#vTenant_div").show();


            } else {

                $(".wired_div").show();
                $("#zone_div").show();
                $("#group_div").show()
                //$("#vTenant_div").show()


                bootstrapValidator.enableFieldValidators('zone', true);

            }
        }
    </script>

    <script type="text/javascript">
        function location_formfn() {

            //document.getElementById("create_location_submit").disabled = false;

        }
    </script>


    <?php if (isset($_GET['create_location_next']) || isset($_GET['add_location_next'])) {

        $props_q = "SELECT id,distributor_code,verification_number,property_id FROM exp_mno_distributor WHERE parent_id='$edit_parent_id'";
        $props_r = $db->selectDB($props_q);

    ?>

    <?php } ?>

    <!-- Modal -->
    <div id="wlanframe_create" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Create WLAN</b></h4>
                </div>

                <form method="post">
                    <div class="modal-body">

                        <div class="control-group">
                            <div class="controls form-group">
                                Guest &nbsp;<input onclick="clickWlantype()" type="radio" name="wlan_type_new" checked="checked" value="Guest"><label style="display: inline-block;"></label> &nbsp; &nbsp; &nbsp;
                                Private &nbsp;<input onclick="clickWlantype()" type="radio" name="wlan_type_new" value="Private"><label style="display: inline-block;"></label> </div>
                        </div>
                        <div id="guestwlancreate">
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="lookup_key_g">Lookup Key:</label>
                                    <input type="text" name="lookup_key_g" style="width: 65%" id="lookup_key_g" value="" placeholder="" class="span4 form-control">
                                    <input readonly="readonly" type="text" name="lookup_vlan_guest" id="lookup_vlan_guest" value="" placeholder="" class="span4 form-control" style="width: 28%">

                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group" style="display: none">
                                <div class="controls form-group">
                                    <label for="location_id_g">Location ID:</label>
                                    <input type="text" name="location_id_g" id="location_id_g" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="redirect_url_g">Redirect-URL:</label>
                                    <input type="text" name="redirect_url_g" id="redirect_url_g" value="" placeholder="" class="span4 form-control">
                                    <input type="hidden" name="zone_id_guest" id="zone_id_guest" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="description_g">Description:</label>
                                    <input type="text" name="description_g" id="description_g" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="cutom_para_g">Custom Parameter:</label>
                                    <input type="text" name="cutom_para_g" id="cutom_para_g" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="cutom_para_g">Vlan ID:</label>
                                    <input type="text" onkeyup="changegVlan()" name="vlan_new_g" id="vlan_new_g" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                        </div>
                        <div id="privatewlancreate" style="display: none;">
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="lookup_key_pt">Lookup Key:</label>
                                    <input type="text" name="lookup_key_pt" style="width: 65%" id="lookup_key_pt" value="" placeholder="" class="span4 form-control">
                                    <input readonly="readonly" type="text" name="lookup_vlan_pvt" id="lookup_vlan_pvt" value="" placeholder="" class="span4 form-control" style="width: 28%">

                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group" style="display: none">
                                <div class="controls form-group">
                                    <label for="location_id_pt">Location ID:</label>
                                    <input type="text" name="location_id_pt" id="location_id_pt" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="product_pt">Free-Access: <a style="margin-left:5px" onclick="gotoSync(2);" class=""><i class="btn-icon-only icon-refresh"></i>
                                            [Sync Products]</a>
                                        <div style="display: inline-block" id="sync_loader_pvt"></div>
                                    </label>

                                    <select name="product_pt" id="product_pt" class="span4 form-control" style="margin-bottom: 15px !important; width: 347px!important;">
                                        <option value="">Select Option
                                        </option>
                                        <?php

                                        $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='PRIVATE' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                        $query_results = $db->selectDB($q1);

                                        $arraym = array();
                                        $arrayk = array();
                                        $arrayo = array();
                                        foreach ($query_results['data'] as $row) {

                                            $dis_code = $row[product_code];
                                            $QOS = $row[QOS];
                                            $QOSLast = strtolower(substr($QOS, -1));
                                            $product_name_new = str_replace('_', '-', $row[product_code]);
                                            $name_ar = explode('-', $product_name_new);
                                            $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                            $duration_val = $duration[0];
                                            $qosvalarr = explode('*', $name_ar[2]);
                                            $ab = substr($name_ar[2], 0, 2);
                                            if (!is_numeric($ab)) {
                                                $ab = substr($name_ar[2], 0, 1);
                                            }
                                            $bb = substr($name_ar[2], -2);
                                            if (!is_numeric($bb)) {
                                                $bb = substr($name_ar[2], -1);
                                            }
                                            $row['duration'] = $duration_val;
                                            $row['qosval'] = $ab;
                                            $row['qosval2'] = $bb;
                                            if ($QOSLast == 'k') {
                                                array_push($arrayk, $row);
                                            } else if ($QOSLast == 'm') {
                                                array_push($arraym, $row);
                                            } else {
                                                array_push($arrayo, $row);
                                            }
                                        }

                                        CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                        CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                        CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                        $arrayfinal = array();
                                        if (empty($arrayk)) {
                                            $arrayfinal = $arraym;
                                        } else {
                                            if (empty($arraym)) {
                                                $arrayfinal = $arrayk;
                                            } else {
                                                $arrayfinal = array_merge($arrayk, $arraym);
                                            }
                                        }
                                        if (empty($arrayo)) {
                                            $arrayfinal = $arrayfinal;
                                        } else {
                                            $arrayfinal = array_merge($arrayfinal, $arrayo);
                                        }


                                        foreach ($arrayfinal as $row) {
                                            $select = "";
                                            $QOS = $row[QOS];
                                            $dis_id = $row[product_id];
                                            $dis_code = $row[product_code];

                                            echo "<option value='" . $dis_id . "'>" . $dis_code . " [" . $QOS . "]</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="zone_id_pt" id="zone_id_pt" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="description_pt">Description:</label>
                                    <input type="text" name="description_pt" id="description_pt" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="cutom_para_pt">Custom Parameter:</label>
                                    <input type="text" name="cutom_para_pt" id="cutom_para_pt" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                            <div class="control-group">
                                <div class="controls form-group">
                                    <label for="cutom_para_g">Vlan ID:</label>
                                    <input type="text" onkeyup="changepVlan()" name="vlan_new_p" id="vlan_new_p" value="" placeholder="" class="span4 form-control">
                                </div>
                                <!-- /controls -->
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="wlancreate()" id="createwlan" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="wlanframe_g" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Update WLAN</b></h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="lookup_key_guest">Lookup Key:</label>
                                <input type="text" name="lookup_key_guest" style="width: 65%" id="lookup_key_guest" value="" placeholder="" class="span4 form-control">
                                <input readonly="readonly" type="text" name="lookup_vlan_g" id="lookup_vlan_g" value="" placeholder="" class="span4 form-control" style="width: 28%">

                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="access_group_guest">Access-Group:</label>
                                <input type="text" name="access_group_guest" id="access_group_guest" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group" style="display: none;">
                            <div class="controls form-group">
                                <label for="location_id_guest">Location ID:</label>
                                <input type="text" name="location_id_guest" id="location_id_guest" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="redirect_url_guest">Redirect-URL:</label>
                                <input type="text" name="redirect_url_guest" id="redirect_url_guest" value="" placeholder="" class="span4 form-control">
                                <input type="hidden" name="zone_id_guest" id="zone_id_guest" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="description_guest">Description:</label>
                                <input type="text" name="description_guest" id="description_guest" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="cutom_para_guest">Custom Parameter:</label>
                                <input type="text" name="cutom_para_guest" id="cutom_para_guest" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group" id="vlan_guest_update">
                            <div class="controls form-group">
                                <label for="cutom_para_g">Vlan ID:</label>
                                <input type="text" onkeyup="changeguestVlan()" name="vlan_g" id="vlan_g" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="guestwlanedit()" class="btn btn-primary" name="btn_update_g_wlan">Update</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div id="wlanframe_pvt" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Update WLAN</b></h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="lookup_key_pvt">Lookup Key:</label>
                                <input type="text" name="lookup_key_pvt" style="width: 65%" id="lookup_key_pvt" value="" placeholder="" class="span4 form-control">

                                <input readonly="readonly" type="text" name="lookup_vlan_p" id="lookup_vlan_p" value="" placeholder="" class="span4 form-control" style="width: 28%">

                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="access_group_guest">Access-Group:</label>
                                <input type="text" name="access_group_pvt" id="access_group_pvt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group" style="display: none;">
                            <div class="controls form-group">
                                <label for="location_id_pvt">Location ID:</label>
                                <input type="text" name="location_id_pvt" id="location_id_pvt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="product_pvt">Free-Access: <a style="margin-left:5px" onclick="gotoSync(2);" class=""><i class="btn-icon-only icon-refresh"></i>
                                        [Sync Products]</a>
                                    <div style="display: inline-block" id="sync_loader_pt"></div>
                                </label>
                                <select name="product_pvt" id="product_pvt" class="span4 form-control" style="margin-bottom: 15px !important; width: 350px!important;">
                                    <option value="" selected="">Select Option
                                    </option>
                                    <?php

                                    $q1 = "SELECT product_id,product_code,product_name,QOS,time_gap
                                                        FROM exp_products
                                                        WHERE network_type='PRIVATE' AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";

                                    $query_results = $db->selectDB($q1);

                                    $arraym = array();
                                    $arrayk = array();
                                    $arrayo = array();
                                    foreach ($query_results['data'] as $row) {

                                        $dis_code = $row[product_code];
                                        $QOS = $row[QOS];
                                        $QOSLast = strtolower(substr($QOS, -1));
                                        $product_name_new = str_replace('_', '-', $row[product_code]);
                                        $name_ar = explode('-', $product_name_new);
                                        $duration = explode('-', str_replace(' ', '-', CommonFunctions::split_from_num($name_ar[3])));
                                        $duration_val = $duration[0];
                                        $qosvalarr = explode('*', $name_ar[2]);
                                        $ab = substr($name_ar[2], 0, 2);
                                        if (!is_numeric($ab)) {
                                            $ab = substr($name_ar[2], 0, 1);
                                        }
                                        $bb = substr($name_ar[2], -2);
                                        if (!is_numeric($bb)) {
                                            $bb = substr($name_ar[2], -1);
                                        }
                                        $row['duration'] = $duration_val;
                                        $row['qosval'] = $ab;
                                        $row['qosval2'] = $bb;
                                        if ($QOSLast == 'k') {
                                            array_push($arrayk, $row);
                                        } else if ($QOSLast == 'm') {
                                            array_push($arraym, $row);
                                        } else {
                                            array_push($arrayo, $row);
                                        }
                                    }

                                    CommonFunctions::aaasort($arrayk, 'qosval', 'qosval2', 'duration');
                                    CommonFunctions::aaasort($arraym, 'qosval', 'qosval2', 'duration');
                                    CommonFunctions::aaasort($arrayo,'qosval','qosval2','duration');
                                    $arrayfinal = array();
                                    if (empty($arrayk)) {
                                        $arrayfinal = $arraym;
                                    } else {
                                        if (empty($arraym)) {
                                            $arrayfinal = $arrayk;
                                        } else {
                                            $arrayfinal = array_merge($arrayk, $arraym);
                                        }
                                    }
                                    if (empty($arrayo)) {
                                        $arrayfinal = $arrayfinal;
                                    } else {
                                        $arrayfinal = array_merge($arrayfinal, $arrayo);
                                    }

                                    foreach ($arrayfinal as $row) {
                                        $select = "";
                                        $QOS = $row[QOS];
                                        $dis_id = $row[product_id];
                                        $dis_code = $row[product_code];

                                        echo "<option value='" . $dis_id . "'>" . $dis_code . " [" . $QOS . "]</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="zone_id_pvt" id="zone_id_pvt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="description_pvt">Description:</label>
                                <input type="text" name="description_pvt" id="description_pvt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="cutom_para_pvt">Custom Parameter:</label>
                                <input type="text" name="cutom_para_pvt" id="cutom_para_pvt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="cutom_para_g">Vlan ID:</label>
                                <input type="text" onkeyup="changepvtVlan()" name="vlan_p" id="vlan_p" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="pvtwlanedit(event)" class="btn btn-primary" name="btn_update_private_wlan">Update</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="wlanframe_vtn" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Update WLAN</b></h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="access_group_vt">Access-Group:</label>
                                <input type="text" name="access_group_vt" id="access_group_vt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="onboardvlan">Onboardvlan:</label>
                                <input type="text" name="onboardvlan" id="onboardvlan" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>

                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="description">Description:</label>
                                <input type="text" name="description_vt" id="description_vt" value="" placeholder="" class="span4 form-control">
                                <input type="hidden" name="zone_id_vt" id="zone_id_vt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="cutom_para">Custom Parameter:</label>
                                <input type="text" name="cutom_para_vt" id="cutom_para_vt" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="vtwlanedit(event)" class="btn btn-primary" name="btn_update_vt_wlan">Update</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="wlanframe_sub" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Update WLAN</b></h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="lookup_key_sub">Lookup Key:</label>
                                <input type="text" name="lookup_key_sub" id="lookup_key_sub" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group" style="display: none;">
                            <div class="controls form-group">
                                <label for="location_id_pvt">Location ID:</label>
                                <input type="text" name="location_id_sub" id="location_id_sub" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group" id="redirct_url_ac" style="display: none;">
                            <div class="controls form-group">
                                <label for="redirect_url_guest">Redirect-URL:</label>
                                <input type="text" name="redirect_url_sub" id="redirect_url_sub" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>

                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="description">Description:</label>
                                <input type="text" name="description_sub" id="description_sub" value="" placeholder="" class="span4 form-control">
                                <input type="hidden" name="zone_id_sub" id="zone_id_sub" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                        <div class="control-group">
                            <div class="controls form-group">
                                <label for="cutom_para">Custom Parameter:</label>
                                <input type="text" name="cutom_para_sub" id="cutom_para_sub" value="" placeholder="" class="span4 form-control">
                            </div>
                            <!-- /controls -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="vtwlansubedit(event)" class="btn btn-primary" name="btn_update_vt_wlan">Update</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


</div>

<!-- <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
 -->

<script type="text/javascript">
    function guestconfigedit() {
        //alert();
    }

    function changepvtVlan() {
        var vlan_val = $("#vlan_p").val();
        $("#lookup_vlan_p").val(vlan_val);
    }

    function changeguestVlan() {
        var vlan_val = $("#vlan_g").val();
        $("#lookup_vlan_g").val(vlan_val);
    }

    function changepVlan() {
        var vlan_val = $("#vlan_new_p").val();
        $("#lookup_vlan_pvt").val(vlan_val);
    }

    function changegVlan() {
        var vlan_val = $("#vlan_new_g").val();
        $("#lookup_vlan_guest").val(vlan_val);
    }

    function clickWlantype() {
        var type = $("input[name='wlan_type_new']:checked").val();
        var network_type = $('#network_type').val();

        if (type == 'Private') {
            if (network_type.includes("PRIVATE")) {
                $('#privatewlancreate').show();
                $('#guestwlancreate').hide();
            } else {
                alert('Please Select Package Type Private!');
                $("#wlanframe_create .close").click();
                var value = 'Guest';
                $("input[name=wlan_type_new][value=" + value + "]").prop('checked', true);
            }
        } else {
            if (network_type.includes("GUEST")) {
                $('#guestwlancreate').show();
                $('#privatewlancreate').hide();
            } else {
                $('#privatewlancreate').show();
                $('#guestwlancreate').hide();
                alert('Please Select Package Type Guest!');
                $("#wlanframe_create .close").click();
                var value = 'Private';
                $("input[name=wlan_type_new][value=" + value + "]").prop('checked', true);
            }

        }

    }

    function clickWlancreate() {
        var network_type = $('#network_type').val();
        if (network_type.includes("PRIVATE") || network_type.includes("GUEST")) {
            if (!network_type.includes("GUEST")) {
                $('#privatewlancreate').show();
                $('#guestwlancreate').hide();
                var value = 'Private';
                $("input[name=wlan_type_new][value=" + value + "]").prop('checked', true);
            }

        } else {
            alert('Please Select Package Type Guest or Private!');
            $("#wlanframe_create .close").click();
        }

    }



    function guestwlanedit() {
        //event.preventDefault();
        var lookup_key = $("#lookup_key_guest").val();
        var lookup_key_vlan = $("#lookup_vlan_g").val();
        var location_id = $("#location_id_guest").val();
        var redirect_url = $("#redirect_url_guest").val();
        var zone_id = $("#zone_id_guest").val();
        var description = $("#description_guest").val();
        var access_group = $("#access_group_guest").val();
        var row_number = $("#row_number").val();
        var gateway_type = $("#gateway_type").val();
        var edit_account = "<?php echo $edit_account; ?>";
        var vlan = $("#vlan_g").val();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'ajax/updateWlan.php',
            data: {
                user_distributor: "<?php echo $user_distributor; ?>",
                flow_type: "<?php echo $new_flow_account; ?>",
                wlan_type: 'guest',
                location_id: location_id,
                lookup_key: lookup_key,
                lookup_key_vlan: lookup_key_vlan,
                redirect_url: redirect_url,
                system_package: "<?php echo $system_package; ?>",
                user_name: "<?php echo $user_name; ?>",
                zone_id: zone_id,
                description: description,
                access_group: access_group,
                edit_account: edit_account,
                row_number: row_number,
                gateway_type: gateway_type,
                vlan: vlan
            },
            success: function(data) {
                //console.log(data);
                if (data == 200) {
                    $("#wlanframe_g .close").click();
                    //document.getElementById("wlanframe_g").style.display = "none";
                    gotorelm_matchtabel();
                }
                if (data == 201) {
                    $("#wlanframe_g .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel(1);
                } else {

                }

            },
            error: function() {
                //document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
            }

        });
    }

    function pvtwlanedit(event) {
        // event.preventDefault();
        var lookup_key = $("#lookup_key_pvt").val();
        var lookup_key_vlan = $("#lookup_vlan_p").val();
        var location_id = $("#location_id_pvt").val();
        var product = $("#product_pvt").val();
        var zone_id = $("#zone_id_pvt").val();
        var description = $("#description_pvt").val();
        var access_group = $("#access_group_pvt").val();
        var row_number = $("#row_number").val();
        var gateway_type = $("#pr_gateway_type").val();
        var edit_account = "<?php echo $edit_account; ?>";
        var vlan = $("#vlan_p").val();

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'ajax/updateWlan.php',
            data: {
                user_distributor: "<?php echo $user_distributor; ?>",
                flow_type: "<?php echo $new_flow_account; ?>",
                wlan_type: 'pvt',
                location_id: location_id,
                lookup_key: lookup_key,
                lookup_key_vlan: lookup_key_vlan,
                product: product,
                system_package: "<?php echo $system_package; ?>",
                user_name: "<?php echo $user_name; ?>",
                zone_id: zone_id,
                description: description,
                access_group: access_group,
                edit_account: edit_account,
                row_number: row_number,
                gateway_type: gateway_type,
                vlan: vlan
            },
            success: function(data) {
                if (data == 200) {
                    $("#wlanframe_pvt .close").click();
                    //document.getElementById("wlanframe_pvt").style.display = "none";
                    gotorelm_matchtabel();
                }
                if (data == 201) {
                    $("#wlanframe_pvt .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel(1);
                } else {

                }
            },
            error: function() {
                //document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
            }

        });
    }

    function vtwlanedit(event) {
        // event.preventDefault();
        var onboardvlan = $("#onboardvlan").val();
        var zone_id = $("#zone_id_vt").val();
        var description = $("#description_vt").val();
        var access_group = $("#access_group_vt").val();
        var row_number = $("#row_number").val();
        var edit_account = "<?php echo $edit_account; ?>";

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'ajax/updateWlan.php',
            data: {
                user_distributor: "<?php echo $user_distributor; ?>",
                flow_type: "<?php echo $new_flow_account; ?>",
                wlan_type: 'vt',
                onboardvlan: onboardvlan,
                system_package: "<?php echo $system_package; ?>",
                user_name: "<?php echo $user_name; ?>",
                zone_id: zone_id,
                description: description,
                access_group: access_group,
                edit_account: edit_account,
                row_number: row_number
            },
            success: function(data) {
                if (data == 200) {
                    $("#wlanframe_vtn .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel();
                }
                if (data == 201) {
                    $("#wlanframe_vtn .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel(1);
                } else {


                }
            },
            error: function() {
                //document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
            }

        });
    }

    function vtwlansubedit(event) {
        // event.preventDefault();
        var location_id = $("#location_id_sub").val();
        var lookup_key = $("#lookup_key_sub").val();
        var zone_id = $("#zone_id_sub").val();
        var description = $("#description_sub").val();
        var redirect_url = $("#redirect_url_sub").val();
        var row_number = $("#row_number").val();
        var edit_account = "<?php echo $edit_account; ?>";

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'ajax/updateWlan.php',
            data: {
                user_distributor: "<?php echo $user_distributor; ?>",
                flow_type: "<?php echo $new_flow_account; ?>",
                wlan_type: 'sub',
                lookup_key: lookup_key,
                location_id: location_id,
                redirect_url: redirect_url,
                system_package: "<?php echo $system_package; ?>",
                user_name: "<?php echo $user_name; ?>",
                zone_id: zone_id,
                description: description,
                edit_account: edit_account,
                row_number: row_number
            },
            success: function(data) {
                if (data == 200) {
                    $("#wlanframe_sub .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel();
                }
                if (data == 201) {
                    $("#wlanframe_sub .close").click();
                    //document.getElementById("wlanframe_vtn").style.display = "none";
                    gotorelm_matchtabel(1);
                } else {

                }
            },
            error: function() {
                //document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
            }

        });
    }
    //var bootstrapValidatorSteps = $('#location_form').data('bootstrapValidator');
    //console.log(bootstrapValidatorSteps);
    function stepList(index, name) {
        var clz = '';
        if (index == 1) {
            clz = 'current';
        }
        return '<li data-step="' + index + '" role="tab" class="{index' + index + '}" aria-disabled="false" aria-selected="true"><span>' + name + '</span></li>';
    }

    var previousn;
    $('.actions.clearfix').find('a[data-type="previous"]').bind('click', function(e) {
        previousn = 1;
        setSteps((parseInt($('.steps.clearfix li.current').attr('data-step')) - 1), $('#location_form fieldset').length, 'previous', undefined);
    });

    $('.actions.clearfix').find('a[data-type="next"]').bind('click', function(e) {
        setSteps((parseInt($('.steps.clearfix li.current').attr('data-step')) + 1), $('#location_form fieldset').length, 'next', undefined);
    });

    function setSteps(step, stepCount, action, stepListFull) {
        $('#msg27').empty();
        var edit_account = "<?php echo $_GET['edit_loc_id']; ?>";

        if (stepListFull) {
            let index = 1;
            while (index <= stepCount) {
                if (index < step) {
                    stepListFull = stepListFull.replace("{index" + index + "}", "done");
                } else if (index == step) {
                    stepListFull = stepListFull.replace("{index" + index + "}", "current");
                } else {
                    stepListFull = stepListFull.replace("{index" + index + "}", "");
                }
                index++;
            }

        } else {
            if (action != 'previous') {

                $('#location_form').data('bootstrapValidator').validate();
                if (!$('#location_form').data('bootstrapValidator').isValid()) {
                    return false;
                }
                if (step == 3) {
                    if (edit_account) {
                        $("#add_location_submit").prop("disabled", false);
                    } else {
                        $("#create_location_submit").prop("disabled", false);
                        $("#create_location_next").prop("disabled", false);
                    }
                }
            }
            $('.steps.clearfix li').removeClass('current').removeClass('done');
            for (let index1 = 1; index1 < step; index1++) {
                $('.steps.clearfix li:eq(' + (index1 - 1) + ')').addClass('done');
            }
            $('.steps.clearfix li:eq(' + (step - 1) + ')').addClass('current');
            /*  console.log($('#create_property').offset().top); */
            $('html, body').animate({
                scrollTop: 100
            }, 500);
        }

        $('.fieldStep').hide();
        $('.fieldStep.step' + step).css('display', 'block');

        //console.log(bootstrapValidatorSteps);
        if (step == 1) {
            $('.actions.clearfix').find('a[data-type="previous"]').hide();
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').css('display', 'inline-block');
                $('.actions.clearfix').find('.finishSteptwo').hide();
                $('.actions.clearfix').find('.cancelform').css('display', 'inline-block');
            }

            //bootstrapValidatorSteps.enableFieldValidators('zone', false);
        } else if (step == 2) {
            if (previousn != 1) {
                var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                try {
                    bootstrapValidator.enableFieldValidators('groups', false);
                } catch (e) {}
            }
            $('.actions.clearfix').find('a[data-type="previous"]').css('display', 'inline-block');
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').hide();
                $('.actions.clearfix').find('.finishSteptwo').css('display', 'inline-block');
                $('.actions.clearfix').find('.cancelform').hide();
            }
            //if(document.getElementById("automation_property").checked){

            //bootstrapValidatorSteps.enableFieldValidators('zone', true);
            //}
        } else {
            $('.actions.clearfix').find('a[data-type="previous"]').css('display', 'inline-block');
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').hide();
                $('.actions.clearfix').find('.finishSteptwo').hide();
                $('.actions.clearfix').find('.cancelform').hide();
            }
            //bootstrapValidatorSteps.enableFieldValidators('zone', false);
        }

        if (step == stepCount) {
            $('.actions.clearfix').find('a[data-type="next"]').hide();
            $('.actions.clearfix').find('.finishParent').css('display', 'inline-block');

        } else {
            $('.actions.clearfix').find('a[data-type="next"]').css('display', 'inline-block');
            $('.actions.clearfix').find('.finishParent').hide();

        }

        return stepListFull;

    }

    $(document).ready(function() {
        //create_location / MVN(X) account
        var form = $("#location_form");

        var bootstrapValidator = $('#location_form').data('bootstrapValidator');
        var stepListFull = '<div class="steps clearfix" style="margin-top:20px"><ul role="tablist">';
        var stepCount = 0;
        $('#location_form fieldset').each(function(index, element) {
            $(this).addClass('step' + (index + 1)).addClass('fieldStep');
            stepListFull += stepList((index + 1), $(this).attr('data-name'));
            stepCount++;
        });
        stepListFull += '</ul></div>';

        stepListFull = setSteps(1, stepCount, 'ready', stepListFull);

        $('#location_form').prepend(stepListFull);
        $(".finishParent").find('a[href$="#finish"]').replaceWith($('.submit-btn'));
        /* form.children("div").steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex)
            {  
                $('#location_form').data('bootstrapValidator').validate();
                
                return $('#location_form').data('bootstrapValidator').isValid();
               
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
              $(window).scrollTop(10);

            },
            onFinishing: function (event, currentIndex)
            {
                $('#location_form').data('bootstrapValidator').validate();        
                return $('#location_form').data('bootstrapValidator').isValid();
            },
            onFinished: function (event, currentIndex)
            {
            }
        }) */


    });

    function wlanAutomation(val) {

        var bootstrapValidator = $('#location_form').data('bootstrapValidator');
        $('#icomme_div').show();
        $('#icomme_div_p').hide();

        switch (val) {

            case 'GUEST': {
                $('#guest_div').show();
                $('#vTenant_div').hide();
                $('#private_div').hide();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', true);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', false);
                break;
            }

            case 'PRIVATE': {
                $('#icomme_div').hide();
                $('#icomme_div_p').show();
                $('#guest_div').hide();
                $('#vTenant_div').hide();
                $('#private_div').show();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', false);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', true);
                break;
            }
            case 'BOTH': {
                $('#guest_div').show();
                $('#vTenant_div').hide();
                $('#private_div').show();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', true);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', true);
                break;
            }
            case 'VT': {
                $('#guest_div').hide();
                $('#vTenant_div').show();
                $('#private_div').hide();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', false);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', false);
                break;
            }
            case 'VT-GUEST': {
                $('#guest_div').show();
                $('#vTenant_div').show();
                $('#private_div').hide();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', true);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', false);
                break;
            }
            case 'VT-PRIVATE': {
                $('#icomme_div').hide();
                $('#icomme_div_p').show();
                $('#guest_div').hide();
                $('#vTenant_div').show();
                $('#private_div').show();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', false);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', true);
                break;
            }
            case 'VT-BOTH': {
                $('#guest_div').show();
                $('#vTenant_div').show();
                $('#private_div').show();
                bootstrapValidator.enableFieldValidators('g_nu_of_network', true);
                bootstrapValidator.enableFieldValidators('pr_nu_of_network', true);
                break;
            }
            default: {
                $('#guest_div').hide();
                $('#vTenant_div').hide();
                $('#private_div').hide();
            }
        }

    }
</script>
<script>
    $(document).ready(function() {
        $('.finishStepone').click(function() {
            var business_type = $("#business_type").val();
            var location_name1 = $("#location_name1").val();
            var mno_address_1 = $("#mno_address_1").val();
            var mno_address_2 = $("#mno_address_2").val();
            var mno_country = $("#country").val();
            var mno_state = $("#state").val();
            var mno_mobile_1 = $("#mno_mobile_1").val();
            var mno_mobile_2 = $("#mno_mobile_2").val();
            var mno_mobile_3 = $("#mno_mobile_3").val();
            var mno_zip_code = $("#mno_zip_code").val();
            var customer_type = $("#customer_type").val();
            var mno_time_zone = $("#mno_time_zone").val();
            var edit_distributor_id = $("#edit_distributor_id").val();
            var location_name_old = $("#location_name_old").val();
            var dpsk_conroller = $("#dpsk_conroller").val();
            var dpsk_policies = $("#dpsk_policies").val();
            var advance_fe = $("#my_select7").val();
            var admin_features = $("#admin_features").val();


            $.ajax({
                type: 'POST',
                url: 'ajax/updateLocationSteps.php',
                data: {
                    admin_features: admin_features,
                    business_type: business_type,
                    step: 'one',
                    location_name1: location_name1,
                    mno_address_1: mno_address_1,
                    mno_address_2: mno_address_2,
                    mno_country: mno_country,
                    mno_state: mno_state,
                    mno_mobile_1: mno_mobile_1,
                    mno_mobile_2: mno_mobile_2,
                    mno_mobile_3: mno_mobile_3,
                    mno_zip_code: mno_zip_code,
                    customer_type: customer_type,
                    mno_time_zone: mno_time_zone,
                    edit_distributor_id: edit_distributor_id,
                    location_name_old: location_name_old,
                    dpsk_conroller: dpsk_conroller,
                    dpsk_policies: dpsk_policies,
                    advance_fe: advance_fe
                },
                success: function(data) {
                    data = JSON.parse(data);
                    $('#msg27').empty();

                    $("#msg27").append(data.msg);
                    $('html, body').animate({
                        scrollTop: 100
                    }, 500);
                },
                error: function() {

                }

            });
        });

        $('.finishSteptwo').click(function() {
            var business_type = $("#business_type").val();
            var location_name1 = $("#location_name1").val();
            var mno_address_1 = $("#mno_address_1").val();
            var mno_address_2 = $("#mno_address_2").val();
            var mno_country = $("#country").val();
            var mno_state = $("#state").val();
            var mno_mobile_1 = $("#mno_mobile_1").val();
            var mno_mobile_2 = $("#mno_mobile_2").val();
            var mno_mobile_3 = $("#mno_mobile_3").val();
            var mno_zip_code = $("#mno_zip_code").val();
            var customer_type = $("#customer_type").val();
            var mno_time_zone = $("#mno_time_zone").val();
            var edit_distributor_id = $("#edit_distributor_id").val();
            var zone_name = $("#zone_name").val();

            var zone_id = $("#zone").val();
            var conroller = $("#conroller").val();
            var group_id = $("#groups").val();
            var conroller_sw = $("#sw_conroller").val();
            var firewall_conroller = $("#firewall_conroller").val();
            var firewall_organizations = $("#firewall_organizations").val();

            $.ajax({
                type: 'POST',
                url: 'ajax/updateLocationSteps.php',
                data: {
                    business_type: business_type,
                    step: 'two',
                    mno_time_zone: mno_time_zone,
                    edit_distributor_id: edit_distributor_id,
                    zone_name: zone_name,
                    zone_id: zone_id,
                    conroller: conroller,
                    group_id: group_id,
                    conroller_sw: conroller_sw,
                    location_name1: location_name1,
                    firewall_conroller: firewall_conroller,
                    firewall_organizations: firewall_organizations
                },
                success: function(data) {
                    // console.log(data.msg);
                    data = JSON.parse(data);
                    if (data.zonename) {
                        $('.stepnew').empty();
                        $('.stepnew').append('<small>' + data.zonename + '</small>');
                    }

                    $('#msg27').empty();

                    $("#msg27").append(data.msg);
                    $('html, body').animate({
                        scrollTop: 100
                    }, 500);
                },
                error: function() {

                }

            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        var product_json = '<?php echo json_encode($js_array); ?>';
        var product_array = JSON.parse(product_json);
        // console.log(product_json);

        $('#parent_package1').change(function() {
            let vertical = $('#business_type').val();
            //alert('sssssssss');
            var value = $(this).val();

            if (value) {
                $('#customer_type').children('option:not(:first)').remove();
                var apend_ob = product_array[value];


                apend_ob.forEach(function(element) {
                    var aaa = false;
                    if (element['name'] !== null){
                        aaa = element['name'].includes('MDU')
                    }
                    if (aaa) {
                        console.log(vertical);
                    if (vertical == 'VTenant') {
                        element['name'] = element['name'].replace("MDU", "VT");
                    }
                    }
                    //alert(element['code']);
                    $("#customer_type").append('<option value="' + element['code'] + '" data-vt="' + element['vt'] + '">' + element['name'] + '</option>');

                });
                $('#location_form').bootstrapValidator('revalidateField', 'customer_type');
            }
        });

    });
</script>

<style>
    h3 {
        margin-bottom: 10px;
    }

    table {
        margin-top: 15px;
    }

    .row {
        margin-left: 0px;
    }

    .create_l {
        width: 49%;
        float: left;
    }

    div.flex {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
    }

    .create_le {
        width: 100%;
    }

    .create_re {
        width: 100%;
        padding-left: 20px;
    }

    .create_r {
        width: 49%;
        float: right;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .form-horizontal .create_l .controls,
    .form-horizontal .create_le .controls,
    .form-horizontal .create_r .controls,
    .form-horizontal .create_re .controls,
    .fieldStep .controls {
        margin-left: 0px !important;
    }

    .detail-table td {
        border: 2px solid #ddd;
        font-size: 12px;
    }

    .tooltipster-fade-show,
    .tooltipster-default {
        border: 2px solid #fff !important;
        -webkit-box-shadow: 0 0 5px #aaa;
        box-shadow: 0 0 5px #aaa;
    }

    .tooltipster-arrow {
        display: none !important;
    }

    .tooltipster-default {
        background: #fff !important;
        color: #333 !important;
    }

    .tooltipster-content {
        font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif !important;
        font-size: 16px !important;
    }

    .toggle.btn.btn-xs {
        height: 20px !important;
        margin-top: 25px !important;
        min-height: 30px;
    }

    .details-view-block {
        margin-bottom: 15px !important;
    }

    .modal-backdrop,
    .modal-backdrop.fade.in {
        opacity: 0;
    }

    .modal-backdrop.fade.in {}

    .modal-backdrop {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #fff;
    }

    .modal.fade {
        position: absolute !important;
        right: 1% !important;
        bottom: 6% !important;
        top: unset !important;
        left: unset !important;
        width: 375px !important;
    }

    .modal-footer {
        text-align: left;
    }

    .modal-body input {
        width: -webkit-fill-available;

    }

    .modal-body {
        max-height: 500px !important;
    }

    .sele-disable-new {
        position: absolute;
        height: 50px;
        height: 37px;
        cursor: not-allowed;
        opacity: 0.2;
        background: #9a9999;
        margin-left: 0px;
    }

    h4 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    .theme_response{
        max-width: 100%;
    }
    @media (max-width: 768px){
        .create_l, .create_r{
            width: 100%;
        }
        .create_r{
            margin-top: 0 !important;
        }
        .theme_response{
            min-width: 100%;
            max-width: none;
        }
    }
</style>

<script src="modules/create_property/js/2-ap-group.js?v=<?php echo uniqid(); ?>2" type="text/javascript"></script>