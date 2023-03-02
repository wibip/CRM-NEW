<style>
    #crm-create-progress{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(102 102 102);
        opacity: 0.75;
        z-index: 100;
        cursor: progress;
        display: none;
    }
    .prov-sub-headers {padding: 0em 0em 0em 0.7em; line-height: unset; font-weight: bold;}

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
    .form-horizontal .create_l .controls, .form-horizontal .create_le .controls, .form-horizontal .create_r .controls, .form-horizontal .create_re .controls, .fieldStep .controls {
        margin-left: 0px !important;
    }
    .actions.clearfix{
        width: 100%;
    }
    .radio-controls label{
        margin-bottom: 0;
    }

    .hide{display:none}
</style>

<?php
$serviceTypes = null;
$baseUrl = $apiUrl.'/api/'.$apiVersion;
//generating api call to get Token

$data = json_encode(['username'=>$apiUsername, 'password'=>$apiPassword]);
$tokenReturn = json_decode( $CommonFunctions->httpPost($baseUrl.'/token',$data,true),true);
//generating api call to get Service Types
if($tokenReturn['status'] == 'success') {
    $token = $tokenReturn['data']['token'];
    $serviceTypesReturn = json_decode($CommonFunctions->getServiceTypes($baseUrl.'/service-types',$token),true);
    if($serviceTypesReturn['status'] == 'success') {
        $serviceTypes = $serviceTypesReturn['data'];
    }
}

$q1 = "SELECT product_id,product_code,product_name,QOS,time_gap,network_type
                                                        FROM exp_products
                                                        WHERE (network_type='GUEST' || network_type='PRIVATE' || network_type='VTENANT') AND mno_id='$user_distributor' AND (default_value='1' || default_value IS NULL)";
    $query_results = $db->selectDB($q1);
    $arraym = array();
    $arrayk = array();
    $arrayo = array();
    $guest_product_arr = array();
    $pvt_product_arr = array();
    $vt_product_arr = array();

    foreach ($query_results['data'] as $row) {
    $dis_code = $row['product_code'];
    $QOS = $row['QOS'];
    $QOSLast = strtolower(substr($QOS, -1));
    $product_name_new = str_replace('_', '-', $row['product_code']);
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

?>
<div div class="tab-pane fade show active" id="create_orders-tab-pane" role="tabpanel" aria-labelledby="create_orders" tabindex="0">
    <div class="border card my-4">
        <div class="border-bottom card-header p-4">
            <div class="g-3 row">
                <h4><?=$formTitle?></h4>
            </div>
        </div>  
        <form onkeyup="" onchange="" autocomplete="off" id="crm_form" name="crm_form" method="post" class="g-3 p-4" action="">
        <?php
        echo '<input type="hidden" name="form_secret5" id="form_secret5" value="' . $_SESSION['FORM_SECRET'] . '" />';
        ?>
            <fieldset id="customer_info" data-name="Customer Information" class="row">
                <div class="col-md-6">
                    <label for="radiobtns">Business Name</label>
                    <input type="text" name="business_name" id="business_name" class="span4 form-control" value="<?php echo $edit===true?$get_business_name:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Contact Phone</label>
                    <input placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" type="text" name="contact_Phone" id="contact_Phone" class="span4 form-control mobile3_vali" value="<?php echo $edit===true?$get_contact_phone:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Account Number</label>
                    <input type="text" name="account_number" id="account_number" class="span4 form-control" value="<?php echo $edit===true?$get_account_number:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Street</label>
                    <input type="text" name="street" id="street" class="span4 form-control" value="<?php echo $edit===true?$get_street:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">State</label>
                    <select name="state" id="state" class="span4 form-control">
                        <option value="">Select State</option>
                        <?php
                        $get_regions = $db->selectDB("SELECT
                                                    `states_code`,
                                                    `description`
                                                    FROM
                                                    `exp_country_states` ORDER BY description ASC");
                        foreach ($get_regions['data'] as $state) {
                            if (($edit===true?$get_state:'') == $state['states_code']) {
                                echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                            } else {

                                echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                            }
                        }
                        //echo '<option value="other">Other</option>';
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Service Type</label>
                    <select name="service_type" id="service_type" class="span4 form-control">
                        <?php if($serviceTypes != null){ ?>
                        <option value="0">Please select service type</option>
                        <?php   foreach($serviceTypes as $serviceType){ ?>
                            <option value="<?=$serviceType['id']?>"><?=$serviceType['service_type']?></option>
                        <?php
                            }
                        } else { ?>
                        <option value="0">Service type not found</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Contact</label>
                    <input type="text" name="contact" id="contact" class="span4 form-control" value="<?php echo $edit===true?$get_contact_name:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Contact Email</label>
                    <input type="text" name="contact_email" id="contact_email" class="span4 form-control" value="<?php echo $edit===true?$get_contact_email:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Order Number</label>
                    <input type="text" name="order_number" id="order_number" class="span4 form-control" value="<?php echo $edit===true?$get_order_number:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">City</label>
                    <input type="text" name="city" id="city" class="span4 form-control" value="<?php echo $edit===true?$get_city:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Zip</label>
                    <input type="text" name="zip" id="zip" class="span4 form-control" value="<?php echo $edit===true?$get_zip:''?>">
                </div>
            </fieldset>

            <fieldset id="wifi_info" data-name="Wi-Fi Site Information"  class="row hide">
                <div class="col-md-6">
                    <label for="radiobtns">Will this customer have more than one site on the WiFi Now service? </label>
                    <input type="radio" name="more_than_one_sites" id="more_than_one_sites-yes" class="span4 form-control">&nbsp;Yes 
                    <input type="radio" name="more_than_one_sites" id="more_than_one_sites-no" class="span4 form-control">&nbsp;No
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Startup Guest SSID</label>
                    <input type="text" name="guest_ssid" id="guest_ssid" class="span4 form-control" value="<?php echo $edit===true?$get_guest_ssid:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Street</label>
                    <input type="text" name="wifi_street" id="wifi_street" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_street:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">State</label>
                    <select name="wifi_state" id="wifi_state" class="span4 form-control">
                        <option value="">Select State</option>
                        <?php
                        $get_regions = $db->selectDB("SELECT
                                                    `states_code`,
                                                    `description`
                                                FROM
                                                `exp_country_states` ORDER BY description ASC");
                        foreach ($get_regions['data'] as $state) {
                            if (($edit===true?$get_wifi_state:'') == $state['states_code']) {
                                echo '<option selected value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                            } else {

                                echo '<option value="' . $state['states_code'] . '">' . $state['description'] . '</option>';
                            }
                        }
                        //echo '<option value="other">Other</option>';
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Access Contact </label>
                    <input type="text" name="wifi_contact" id="wifi_contact" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_contact:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Contact Email</label>
                    <input type="text" name="wifi_email" id="wifi_email" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_email:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Reflect a Unique Property ID (Need to Build this logically or just a sequential number like WFN-000001?)</label>
                    <input type="text" name="wifi_unique" id="wifi_unique" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_unique:''?>">
                </div>

                <div class="col-md-6">
                    <label for="radiobtns">Preferred Install Time Slot</label>
                    <input type="text" name="wifi-ins-time" id="wifi_ins_time" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_ins_time:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns"> Name </label>
                    <input type="text" name="wifi_site-name" id="wifi_site_name" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_site_name:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Startup Private SSID</label>
                    <input type="text" name="private_ssid" id="private_ssid" class="span4 form-control" value="<?php echo $edit===true?$get_private_ssid:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">City</label>
                    <input type="text" name="wifi_city" id="wifi_city" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_city:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">zip</label>
                    <input type="text" name="wifi_zip" id="wifi_zip" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_zip:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Contact Phone</label>
                    <input placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14"  type="text" name="wifi_phone" id="wifi_phone" class="span4 form-control mobile3_vali" value="<?php echo $edit===true?$get_wifi_phone:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Property Type</label>
                    <input type="text" name="wifi_prop_type" id="wifi_prop_type" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_prop_type:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">Requested Install Date</label>
                    <input type="text" name="wifi_ins_date" id="wifi_ins_date" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_ins_date:''?>">
                </div>
                <div class="col-md-6">
                    <label for="radiobtns">If After Hours, Please Specify Start Time (Install can be 8+ hours if 4 APs are included)</label>
                    <input type="text" name="wifi_ins_start" id="wifi_ins_start" class="span4 form-control" value="<?php echo $edit===true?$get_wifi_ins_start:''?>">
                </div>
            </fieldset>

            <!-- Product Information  -->
            <fieldset id="wifi_product_info" data-name="Product Information" class="row hide">
                <div class="col-md-6">
                    <label for="radiobtns">Order Type </label>
                    <select name="prod_order_type" id="prod_order_type" class="span4 form-control">
                        <option value="new">New</option>
                        <option value="replacement">Replacement</option>
                        <option value="macd">MACD</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Indoor AP Quantity </label>
                    <input type="text" name="prod_in_ap_quant" id="prod_in_ap_quant" class="span4 form-control" value="<?php echo $edit===true?$get_prod_in_ap_quant:''?>">
                </div>
                <div class="col-md-6">
                    <label>Is Content Filtering Required? </label>
                    <select name="prod_content_filter" id="prod_content_filter" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Circuit Type </label>
                    <select name="prod_circuit_type" id="prod_circuit_type" class="span4 form-control">
                        <option value="DIA">DIA</option>
                        <option value="FiOS">FiOS</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>QoS For Guest Network </label>
                    <select name="prod_guest" id="prod_guest" class="span4 form-control">
                        <option value="">Select product</option>
                        <?php
                        foreach ($arrayfinal as $value) {
                            $product_id = $value['product_id'];
                            $product_code = $value['product_code'];
                                if ($value['network_type'] == 'GUEST') {
                                echo '<option value="'.$product_id.'">'.$product_code.'</option>]';
                                }
                            } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Does the site have a rack where the Telco equipment is installed? </label>
                    <select name="prod_telco" id="prod_telco" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Are the cabling paths from the Telco room into the site where Access Points will be mounted open and accessible? (drop ceiling, open conduit, etc.) </label>
                    <select name="prod_cabling" id="prod_cabling" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Please attach a Floor Plan of the property </label>
                    <input type="file" name="prod_flow_plan" id="prod_flow_plan" class="span4 form-control" value="<?php echo $edit===true?$get_prod_flow_plan:''?>">
                </div>
                <div class="col-md-6">
                    <label>Please attach Pictures of the areas to be covered with WiFi </label>
                    <input type="file" name="prod_cover_area" id="prod_cover_area" class="span4 form-control" value="<?php echo $edit===true?$get_prod_cover_area:''?>">
                </div>
                <div class="col-md-6">
                    <label>Indoor Square Footage </label>
                    <input type="text" name="prod_square_footage" id="prod_square_footage" class="span4 form-control" value="<?php echo $edit===true?$get_prod_square_footage:''?>">
                </div>
                <div class="col-md-6">
                    <label>Outdoor AP Required?</label>
                    <select name="prod_outdoor" id="prod_outdoor" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Maximum Guest Capacity </label>
                    <input type="text" name="prod_guest_capacity" id="prod_guest_capacity" class="span4 form-control" value="<?php echo $edit===true?$get_prod_guest_capacity:''?>">
                </div>
                <div class="col-md-6">
                    <label>Circuit Size </label>
                    <input type="text" name="prod_circuit_size" id="prod_circuit_size" class="span4 form-control" value="<?php echo $edit===true?$get_prod_circuit_size:''?>">
                </div>
                <div class="col-md-6">
                    <label>QoS for Private Network </label>
                    <select name="prod_private" id="prod_private" class="span4 form-control">
                        <option value="">Select product</option>
                        <?php
                            foreach ($arrayfinal as $value) {
                                $product_id = $value['product_id'];
                                $product_code = $value['product_code'];
                                    if ($value['network_type'] == 'PRIVATE') {
                                    echo '<option value="'.$product_id.'">'.$product_code.'</option>]';
                                    }
                                } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Does the rack have available space for the new equipment? (Approximately 5 Rack Units) </label>
                    <select name="prod_rack_space" id="prod_rack_space" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>If wiring paths are not open, is surface mounted wire molding is acceptable? </label>
                    <select name="prod_wiring_paths" id="prod_wiring_paths" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>If wiring paths are not open, is surface mounted wire molding is acceptable? </label>
                    <input type="file" name="prod_telco_room" id="prod_telco_room" class="span4 form-control" value="<?php echo $edit===true?$get_prod_telco_room:''?>">
                </div>
            </fieldset>
                <!-- Qualifying Questions   -->
            <fieldset id="wifi_qualify_info" data-name="Qualifying Questions" class="row hide">
                <div class="col-md-6">
                    <label>Ceiling Heights </label>
                    <input type="text" name="qq_ceiling_hight" id="qq_ceiling_hight" class="span4 form-control" value="<?php echo $edit===true?$get_qq_ceiling_hight:''?>">
                </div>
                <!-- Interior Wall Type  -->
                <div class="col-md-6">
                    <label>Interior Wall Type </label>
                    <input type="text" name="qq_int_wall" id="qq_int_wall" class="span4 form-control" value="<?php echo $edit===true?$get_qq_int_wall:''?>">
                </div>
                <div class="col-md-6">
                    <label>Do you have other networks that need to communicate through this network? (Examples: proprietary IT systems or office network, security system, cameras with a DVR/Video Monitoring System, PMI or POP systems, inventory systems, IoT devices, etc.) </label>
                    <select name="qq_communicate_other" id="qq_communicate_other" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <!-- Is this site a residential property?  -->
                <div class="col-md-6">
                    <label>Is this site a residential property?</label>
                    <select name="qq_residential" id="qq_residential" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Does this site have atmospheric conditioning to control temperature and humidity?</label>
                    <select name="qq_atmospheric" id="qq_atmospheric" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Ceiling Type </label>
                    <input type="text" name="qq_ceiling_type" id="qq_ceiling_type" class="span4 form-control" value="<?php echo $edit===true?$get_qq_ceiling_type:''?>">
                </div>
                <div class="col-md-6">
                    <label>Exterior Wall Type </label>
                    <input type="text" name="qq_ext_wall" id="qq_ext_wall" class="span4 form-control" value="<?php echo $edit===true?$get_qq_ext_wall:''?>">
                </div>
                <!-- Do you require a fully customizable UI?  -->
                <div class="col-md-6">
                    <label>Do you require a fully customizable UI?</label>
                    <select name="qq_customizable_ui" id="qq_customizable_ui" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <!-- Is this site a warehouse?  -->
                <div class="col-md-6">
                    <label>Is this site a warehouse?</label>
                    <select name="qq_warehouse" id="qq_warehouse" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Are there IoT devices that need to be controlled or monitored by the system? </label>
                    <select name="qq_IoT_devices" id="qq_IoT_devices" class="span4 form-control">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </fieldset>

            <div class="col-md-12">
                <ul style="list-style: none;float: right;margin: 0;" role="menu" aria-label="Pagination">
                    <?php if($activatePopup == true && $get_status == "Completed") {  ?>
                        <!-- <li class="locationPopup" style="display: inline-block;margin-left: 5px;" aria-hidden="true"><a  class="btn btn-primary" role="menuitem">Add Location</a></li> -->
                        <button onmouseover="" class="btn btn-primary pop-up-open">Add Location</button>
                    <?php } ?>
                    <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-disabled="true"><button href="javascript:void(0)" data-type="previous" class="btn btn-primary" role="menuitem">Previous</button></li>
                    <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-hidden="false" aria-disabled="true"><button tabindex="119" href="javascript:void(0)" data-type="next" class="btn btn-primary" role="menuitem">Next</button></li>
                    <li class="finishStepone" style="display: none; margin-left: 5px;" aria-hidden="true"><a tabindex="120" href="#steponesubmit" class="btn btn-primary" name="location_submit_one" id="location_submit_one" role="menuitem">Update Account Info</a></li>
                    <li class="finishSteptwo" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="#steptwosubmit" class="btn btn-primary" name="location_submit_two" id="location_submit_two" role="menuitem">Update Controller Info</a></li>
                    <?php if (!isset($_GET['edit']) && !isset($_GET['property_id'])){ ?>
                    <li class="finishParent" style="display: none; margin-left: 5px;" aria-hidden="true">
                        <!-- <a href="#finish" class="btn btn-primary" name="create_location_submit" id="create_location_submit" role="menuitem" >Finish</a></li> -->
                        <button onmouseover="" type="submit" name="<?php if (isset($_GET['edit'])){echo 'update_crm_submit';}else{echo 'create_crm_submit';}?>" id="create_crm_submit" class="btn btn-primary">Save</button>
                    </li>
                    <?php } ?>
                    <li class="cancelform" style="display: inline-block;margin-left: 5px;" aria-hidden="true"><a href="/" class="btn btn-primary" role="menuitem">Cancel</a></li>
                </ul>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    function stepList_crm(index, name) {
        var clz = '';
        if (index == 1) {
            clz = 'current';
        }
        return '<li data-step="' + index + '" role="tab" class="{index' + index + '}" aria-disabled="false" aria-selected="true"><span>' + name + '</span></li>';
    }


    function stepSetter_crm(step, stepCount, action, stepListFull, edit_account){

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

                try {
                    $('#crm_form').data('bootstrapValidator').validate();
                    if (!$('#crm_form').data('bootstrapValidator').isValid()) {
                        return false;
                    }
                } catch (e) {
                    console.log(e);
                }
                if (step == 3) {
                    if (edit_account) {
                        $("#create_crm_submit").prop("disabled", false);
                    } else {
                        $("#create_crm_submit").prop("disabled", false);
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
            $("#create_crm_submit").prop("disabled", false);
        }


        // $('.fieldStep').hide();
        // $('.fieldStep.step' + step).css('display', 'block');

        $('.fieldStep').addClass('hide');
        $('.fieldStep.step' + step).removeClass('hide');

        //console.log(bootstrapValidatorSteps);
        if (step == 1) {
            $('.actions.clearfix').find('button[data-type="previous"]').hide();
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').css('display', 'inline-block');
                $('.actions.clearfix').find('.finishSteptwo').hide();
                $('.actions.clearfix').find('.cancelform').css('display', 'inline-block');
            }

            //bootstrapValidatorSteps.enableFieldValidators('zone', false);
        } else if (step == 2) {
            if (previousn_crm != 1) {
                var bootstrapValidator = $('#crm_form').data('bootstrapValidator');
                try {
                    bootstrapValidator.enableFieldValidators('groups', false);
                } catch (e) {}
            }
            $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').hide();
                $('.actions.clearfix').find('.finishSteptwo').css('display', 'inline-block');
                $('.actions.clearfix').find('.cancelform').hide();
            }
            //if(document.getElementById("automation_property").checked){

            //bootstrapValidatorSteps.enableFieldValidators('zone', true);
            //}
        } else {
            $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
            if (edit_account) {
                $('.actions.clearfix').find('.finishStepone').hide();
                $('.actions.clearfix').find('.finishSteptwo').hide();
                $('.actions.clearfix').find('.cancelform').hide();
            }
            //bootstrapValidatorSteps.enableFieldValidators('zone', false);
        }

        if (step == stepCount) {
            $('.actions.clearfix').find('button[data-type="next"]').hide();
            $('.actions.clearfix').find('.finishParent').css('display', 'inline-block');

        } else {
            $('.actions.clearfix').find('button[data-type="next"]').css('display', 'inline-block');
            $('.actions.clearfix').find('.finishParent').hide();

        }
        //return stepListFull;
        if(action=='ready'){
            $('#crm_form').prepend(stepListFull);
            //$(".finishParent").find('a[href$="#finish"]').replaceWith($('.submit-btn'));
        }
    }

    async function setSteps_crm(step, stepCount, action, stepListFull) {
        $('#msg27').empty();
        var edit_account = "<?php echo $_GET['edit_loc_id']; ?>";
        let submit_status;

        /*if (action == 'next') {
            await stepsubmit(step-1).then(function(res){
                if(res===true){
                    stepSetter_crm(step, stepCount, action, stepListFull,edit_account);
                }
            });

            return true;
        }*/

        stepSetter_crm(step, stepCount, action, stepListFull);
    }


    $(document).ready(function(e) {
        $('.mobile3_vali').focus(function() {
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
            $('#crm_form').data('bootstrapValidator').updateStatus('contact_Phone', 'NOT_VALIDATED').validateField('contact_Phone');
        });

        $('.mobile3_vali').keyup(function() {
            var phone_1 = $(this).val().replace(/[^\d]/g, "");
            if (phone_1.length > 9) {
            //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
            var phone2 = phone_1.length;
            if (phone_1.length > 10) {
                var phone2 = phone_1.length;
                $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'contact_Phone', false);
                var phone_1 = phone_1.slice(0,10);

                        }
                        $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        //console.log(phone_1+'sss');
                        if (phone2 == 10) {
                            $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'contact_Phone', true);
                    }

                        }
                        else{
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
            $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'contact_Phone', true)
            }

        $('#crm_form').bootstrapValidator('revalidateField', 'contact_Phone');
        });

        //$('#phone_number').val($('#phone_number').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


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
            $('#crm_form').data('bootstrapValidator').updateStatus('contact_Phone', 'NOT_VALIDATED').validateField('contact_Phone');
        });

        $('.mobile3_vali').focus(function() {
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
            $('#crm_form').data('bootstrapValidator').updateStatus('wifi_phone', 'NOT_VALIDATED').validateField('wifi_phone');
        });

        $('.mobile3_vali').keyup(function() {
            var phone_1 = $(this).val().replace(/[^\d]/g, "");
            if (phone_1.length > 9) {
            //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
            var phone2 = phone_1.length;
            if (phone_1.length > 10) {
                var phone2 = phone_1.length;
                $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'wifi_phone', false);
                var phone_1 = phone_1.slice(0,10);

                        }
                        $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                        //console.log(phone_1+'sss');
                        if (phone2 == 10) {
                            $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'wifi_phone', true);
                    }

                        }
                        else{
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
            $('#crm_form')
                        .bootstrapValidator('enableFieldValidators', 'wifi_phone', true)
            }

        $('#crm_form').bootstrapValidator('revalidateField', 'wifi_phone');
        });

        //$('#phone_number').val($('#phone_number').val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));


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
            $('#crm_form').data('bootstrapValidator').updateStatus('wifi_phone', 'NOT_VALIDATED').validateField('wifi_phone');
        });
        //create_crm_submit
        $('#create_crm_submit').click(function(){
            $("#overlay").css("display","block");
        });

        var stepListFull = '<div class="steps clearfix" style="margin-top:20px"><ul role="tablist">';
        var stepCount = 0;
        $('#crm_form fieldset').each(function(index, element) {
            $(this).addClass('step' + (index + 1)).addClass('fieldStep');
            stepListFull += stepList_crm((index + 1), $(this).attr('data-name'));
            stepCount++;
        });
        stepListFull += '</ul></div>';

        setSteps_crm(1, stepCount, 'ready', stepListFull);

    });

    var previousn_crm;
    $('.actions.clearfix').find('button[data-type="previous"]').bind('click', function(e) {
        previousn_crm = 1;
        setSteps_crm((parseInt($('.steps.clearfix li.current').attr('data-step')) - 1), $('#crm_form fieldset').length, 'previous', undefined);
        e.preventDefault();
    });

    $('.actions.clearfix').find('button[data-type="next"]').bind('click',async function(e) {
        let in_html = $(this).html();
        $(this).attr('disabled','disabled');
        $(this).html('<img src="img/loading_me.gif">');
        setSteps_crm((parseInt($('.steps.clearfix li.current').attr('data-step')) + 1), $('#crm_form fieldset').length, 'next', undefined);
        $(this).attr('disabled',false);
        $(this).html(in_html);
        e.preventDefault();
    });
</script>