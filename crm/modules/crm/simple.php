<?php

$api = $api_details['data'][0];
// var_dump($api);
$serviceTypes = null;
$baseUrl = $api['api_url'] . '/api/v1_0';//'http://bi-development.arrisi.com/api/v1_0';
//generating api call to get Token
$apiUsername = $api['api_username'];//'dev_hosted_api_user';
$apiPassword = $api['api_password'];//'development@123!';
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
<div <?php if (isset($tab_crm_create)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="crm_create">
    <h1 class="head"><?=$formTitle?></h1>    
<div id="crm-create-progress"></div>
    <div id="msg27"></div>
    <?php
    if (isset($_SESSION['msg_crm_create'])) {
        echo $_SESSION['msg_crm_create'];
        unset($_SESSION['msg_crm_create']);
    }
    ?>
    <form onkeyup="" onchange="" autocomplete="off" id="crm_form" name="crm_form" method="post" class="form-horizontal" action="">
        <?php
        echo '<input type="hidden" name="form_secret5" id="form_secret5" value="' . $_SESSION['FORM_SECRET'] . '" />';
        ?>
        <style>
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
            
        </style>
        <div>
            <div class="content clearfix">
                <fieldset id="customer_info" data-name="Customer Information ">
                    <div class="flex">
                        <!-- LEFT -->
                        <div class="create_le">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Business Name</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="business_name" id="business_name" class="span4 form-control" value="<?php echo $edit===true?$get_business_name:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact Name</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="contact" id="contact" class="span4 form-control" value="<?php echo $edit===true?$get_contact_name:''?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact Email</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="contact_email" id="contact_email" class="span4 form-control" value="<?php echo $edit===true?$get_contact_email:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">City</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="city" id="city" class="span4 form-control" value="<?php echo $edit===true?$get_city:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">State</label>
                                    <div class="controls col-lg-5 form-group">
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
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- RIGHT -->
                        <div class="create_re">   
                            <input type="hidden" name="method" value="simple">
                            <div class="control-group mask">
                                    <label for="radiobtns">Unique Property ID</label>
                                    <div class="controls col-lg-5 form-group">
                                        <div>
                                        <!-- <span>< ?php echo $get_opt_code; ?></span> -->
                                        <input class="wifi_unique" type="text" name="wifi_unique" class="span4 form-control"
                                        value="<?php echo $edit===true?$get_wifi_unique:''?>">
                                        </div>
                                    </div>
                            </div>

                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Contact Number</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" class="mobile3_vali" type="text" name="contact_Phone" id="contact_Phone" class="span4 form-control"
                                        value="<?php echo $edit===true?$get_contact_phone:''?>">
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('.mobile3_vali').focus(function() {
                                        $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                        $('#crm_form').data('bootstrapValidator').updateStatus('contact_number', 'NOT_VALIDATED').validateField('contact_number');
                                    });

                                    $('.mobile3_vali').keyup(function() {
                                    var phone_1 = $(this).val().replace(/[^\d]/g, "");
                                    if (phone_1.length > 9) {
                                        //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                                        var phone2 = phone_1.length;
                                        if (phone_1.length > 10) {
                                        var phone2 = phone_1.length;
                                        $('#crm_form')
                                                    .bootstrapValidator('enableFieldValidators', 'contact_number', false);
                                        var phone_1 = phone_1.slice(0,10);

                                                    }
                                                $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                                //console.log(phone_1+'sss');
                                                if (phone2 == 10) {
                                                    $('#crm_form')
                                                    .bootstrapValidator('enableFieldValidators', 'contact_number', true);
                                                }

                                                }
                                                else{
                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                    $('#crm_form')
                                                    .bootstrapValidator('enableFieldValidators', 'contact_number', true)
                                    }

                                    $('#crm_form').bootstrapValidator('revalidateField', 'contact_number');
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
                                        $('#crm_form').data('bootstrapValidator').updateStatus('contact_number', 'NOT_VALIDATED').validateField('contact_number');
                                    });
                                });
                            </script>

                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Address</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="street" id="street" class="span4 form-control" value="<?php echo $edit===true?$get_street:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Zip</label>
                                    <div class="controls col-lg-5 form-group">
                                        <input type="text" name="zip" id="zip" class="span4 form-control" value="<?php echo $edit===true?$get_zip:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="radiobtns">Timezone</label>
                                    <div class="controls col-lg-5 form-group">
                                        <select class="span4 form-control" id="time_zone" name="time_zone" autocomplete="off">
                                            <option value="">Select Time Zone</option>
                                            <?php
                                            $utc = new DateTimeZone('UTC');
                                            $dt = new DateTime('now', $utc);
                                            foreach ($priority_zone_array as $tz){
                                                $current_tz = new DateTimeZone($tz);
                                                $offset =  $current_tz->getOffset($dt);
                                                $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                $abbr = $transition[0]['abbr'];
                                                if($get_timezone==$tz){
                                                    $select="selected";
                                                }else{
                                                    $select="";
                                                }
                                                echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                            }

                                            foreach(DateTimeZone::listIdentifiers() as $tz) {
                                                //Skip
                                                if(in_array($tz,$priority_zone_array))
                                                    continue;

                                                $current_tz = new DateTimeZone($tz);
                                                $offset =  $current_tz->getOffset($dt);
                                                $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                                $abbr = $transition[0]['abbr'];
                                                
                                                if($get_timezone==$tz){
                                                    $select="selected";
                                                }else{
                                                    $select="";
                                                }
                                                echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <style>
                    .radio-controls label{
                        margin-bottom: 0;
                    }
                </style>

                
                <div class="actions clearfix">
                    <ul style="list-style: none;float: right;margin: 0;" role="menu" aria-label="Pagination">
                        <?php if($activatePopup == true && $get_status == "Completed") {  ?>
                            <!-- <li class="locationPopup" style="display: inline-block;margin-left: 5px;" aria-hidden="true"><a  class="btn btn-primary" role="menuitem">Add Location</a></li> -->
                            <button onmouseover="" class="btn btn-primary pop-up-open">Add Location</button>
                        <?php } 
                        if (!isset($_GET['edit']) && !isset($_GET['property_id'])){ ?>
                        <li class="finishParent" style="display: inline-block;margin-left: 5px;" aria-hidden="true">
                            <button onmouseover="" type="submit" name="<?php if (isset($_GET['edit'])){echo 'update_crm_submit';}else{echo 'create_crm_submit';}?>" id="create_crm_submit" class="btn btn-primary">Save</button>
                        </li>
                        <?php } ?>
                        <li class="cancelform" style="display: inline-block;margin-left: 5px;" aria-hidden="true"><button type="button" onclick="goto()" class="btn btn-danger">Cancel</button>&nbsp;</li>
                    </ul>
                </div>
            </div>
                    </div>
                </form>
            </div>
    <script type="text/javascript">
            $(document).ready(function(e) {
                //create_crm_submit
                $('#create_crm_submit').click(function(){
                    $("#overlay").css("display","block");
                });
            });
    </script>
            