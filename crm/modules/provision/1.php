<?php 
require_once 'models/vtenantModel.php';
$vtenant_model = new vtenantModel();
$vt_realm_ar = array();
if ($edit===true && array_key_exists($prop_details['property'][0]['location_info'][0]['vt_location_id']) && !empty($prop_details['property'][0]['location_info'][0]['vt_location_id'])) {

    $edit_acc_realm = $vtenant_model->getDistributorVtenant('tpo'.$prop_details['property'][0]['location_info'][0]['location_id']);
    var_dump($edit_acc_realm);
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
    $edit_acc_realm = false;
    $vt_select = "";
}
$location_no_n =$parent_properties_count;


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


?>
<style>
    #prov-create-progress{
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
</style>
<div <?php if (isset($tab_provision_create)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="provision_create">
<div id="prov-create-progress"></div>
    <div id="msg27"></div>

    <form onkeyup="" onchange="" autocomplete="off" id="location_form" name="location_form" method="post" class="form-horizontal" action="">

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
        </style>
        <div>
            <div class="content clearfix">
                <fieldset id="account_info" data-name="Account Info">
                    <h3>Account Info</h3>
                    <div class="flex">
                        <div class="create_le">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="business_id">Business ID (Set your own or <a style="text-decoration: underline;" onclick="generateParentID();">use system generated</a>)<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="1" <?php echo $edit===true?'readonly':'' ?> type="text" id="business_id" name="business_id" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['business_id']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="admin_f_name">Admin First Name<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="3" name="admin_f_name" id="admin_f_name" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['first_name']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="admin_email">Admin Email<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="5" type="text" name="admin_email" id="admin_email" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['email']:''?>">
                                </div>
                            </div>
                        </div>
                        <div class="create_re">
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="business_name">Business Name<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="2" type="text" id="business_name" name="business_name" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['business_name']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="admin_l_name">Admin Last Name<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="4" type="text" span4 form-control id="admin_l_name" name="admin_l_name" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['last_name']:''?>">
                                    <input type="hidden" name="update_id" id="update_id">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="verify_email">Verify Email<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="6" name="verify_email" id="verify_email" class="span4 form-control" value="<?php echo $edit===true?$prop_details['account_info']['email']:''?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="location_setup" data-name="Location Setup">
                    <h3>Location Setup</h3>
                    <div class="flex">
                        <div class="create_le">
                            <div class="control-group" id="location_nos" style="display: none;">
                                <div class="controls col-lg-5 form-group">
                                    <label for="location_no">Location No<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select onchange="changeLocation();" name="location_no" id="location_no" class="span4 form-control">
                                        <?php 
                                        if (!isset($parent_properties_count) || $parent_properties_count == 0) {
                                           $parent_properties_count = 1;
                                        }
                                        for ($i=1; $i < $parent_properties_count+1; $i++) { 
                                            $select = '';
                                            if ($i==1) {
                                                $select = "selected";
                                            }
                                            echo '<option '.$select.' value="'.$i.'">'.$i.'</option>';
                                        }
                                        ?>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="service_type">Service Type<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>

                                    <select name="service_type" id="service_type" class="span4 form-control">
                                        <option value="">Select Service Type</option>
                                        <?Php
                                            $service_types = [];
                                            $service_q = "SELECT id,service_type,setting FROM `exp_provisioning_setting` WHERE mno_id='$user_distributor'";
                                            $service_data = $db->selectDB($service_q);
                                            foreach ($service_data['data'] as $service_datum){
                                                if($edit===true){
                                                    $selected = $service_datum['id']==$prop_details_new['location_info'][0]['service_type']?'selected':'';
                                                }else{
                                                    $selected='';
                                                }
                                                echo '<option '.$selected.' value="'.$service_datum['id'].'">'.$service_datum['service_type'].'</option>';

                                                //
                                                $service_types[$service_datum['id']]=json_decode($service_datum['setting'],true);
                                            }
                                        ?>
                                        <script>
                                            var vt_enable = false;
                                            function loadServiceOptions() {
                                                let service_types = JSON.parse('<?php echo json_encode($service_types)?>');
                                                let serviceTypeSelected = $('#service_type').find(":selected").val();
                                                //alert(serviceTypeSelected);
                                                if(!serviceTypeSelected){
                                                    return false;
                                                }

                                                let selectedServiceOptions = service_types[serviceTypeSelected];
                                                if(selectedServiceOptions['package_type']){
                                                    let package_type = selectedServiceOptions['package_type'] = selectedServiceOptions['package_type']
                                                    let guest_count_div = $('#guest_ssid_count_div');
                                                    let private_count_div = $('#private_ssid_count_div');
                                                    let guest_realm_div = $('#location_id_div');
                                                    let vt_realm_div = $('#vt_location_id_div');
                                                    let vt_realm = $('#vt_location_id');
                                                    let vt_count = $('#no_of_vt_ssid');
                                                    switch (package_type) {
                                                        case 'GUEST':{
                                                            guest_realm_div.show();
                                                            vt_realm_div.hide();
                                                            guest_count_div.show();
                                                            private_count_div.hide();
                                                            vt_enable = false;
                                                            vt_count.val(0);
                                                            vt_realm.find(':selected').attr('selected',false);
                                                            break;
                                                        }
                                                        case 'PRIVATE':{
                                                            guest_realm_div.show();
                                                            vt_realm_div.hide();
                                                            guest_count_div.hide();
                                                            private_count_div.show();
                                                            vt_enable = false;
                                                            vt_count.val(0);
                                                            vt_realm.find(':selected').attr('selected',false);
                                                            break;
                                                        }
                                                        case 'BOTH':{
                                                            guest_realm_div.show();
                                                            vt_realm_div.hide();
                                                            guest_count_div.show();
                                                            private_count_div.show();
                                                            vt_enable = false;
                                                            vt_count.val(0);
                                                            vt_realm.find(':selected').attr('selected',false);
                                                            break;
                                                        }
                                                        case 'VT':{
                                                            guest_realm_div.hide();
                                                            vt_realm_div.show();
                                                            guest_count_div.hide();
                                                            private_count_div.hide();
                                                            vt_enable = true;
                                                            vt_count.val(1);
                                                            break;
                                                        }
                                                        case 'VT-BOTH':{
                                                            guest_realm_div.show();
                                                            vt_realm_div.show();
                                                            guest_count_div.show();
                                                            private_count_div.show();
                                                            vt_enable = true;
                                                            vt_count.val(1);
                                                            break;
                                                        }
                                                        case 'VT-GUEST':{
                                                            guest_realm_div.show();
                                                            vt_realm_div.show();
                                                            guest_count_div.show();
                                                            private_count_div.hide();
                                                            vt_enable = true;
                                                            vt_count.val(1);
                                                            break
                                                        }
                                                        case 'VT-PRIVATE':{
                                                            guest_realm_div.hide();
                                                            vt_realm_div.show();
                                                            guest_count_div.hide();
                                                            private_count_div.show();
                                                            vt_enable = true;
                                                            vt_count.val(1);
                                                            break;
                                                        }
                                                    }
                                                }
                                            }

                                            $(function () {
                                                loadServiceOptions();
                                            });
                                            $('#service_type').on('change',loadServiceOptions);
                                        </script>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="location_name">Location Name<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input type="text" id="location_name" name="location_name" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['location_name']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="address">Address<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input name="address" id="address" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['address']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="country">Country<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select name="country" id="country" class="span4 form-control">
                                        <option value="">Select country</option>
                                        <?php


                                        $count_results = $db->selectDB("SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
UNION ALL
SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b");

                                        foreach ($count_results['data'] as $row) {

                                            if ($row[a] == ($edit===true?$prop_details_new['location_info'][0]['country']:'') || $row[a] == "US") {
                                                $select = "selected";
                                            } else {
                                                $select = "";
                                            }
                                            echo '<option value="' . $row[a] . '" ' . $select . '>' . $row[b] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <script type="text/javascript">
                                        // Countries
                                        var country_arr = ["United States of America", "Afghanistan", "Albania", "Algeria", "American Samoa", "Angola", "Anguilla", "Antartica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Island", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burma", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Clipperton Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czeck Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Europa Island", "Falkland Islands (Islas Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern and Antarctic Lands", "Gabon", "Gambia, The", "Gaza Strip", "Georgia", "Germany", "Ghana", "Gibraltar", "Glorioso Islands", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard Island and McDonald Islands", "Holy See (Vatican City)", "Honduras", "Hong Kong", "Howland Island", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Ireland, Northern", "Israel", "Italy", "Jamaica", "Jan Mayen", "Japan", "Jarvis Island", "Jersey", "Johnston Atoll", "Jordan", "Juan de Nova Island", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Man, Isle of", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Midway Islands", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcaim Islands", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romainia", "Russia", "Rwanda", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and South Sandwich Islands", "Spain", "Spratly Islands", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tobago", "Toga", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands", "Wales", "Wallis and Futuna", "West Bank", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];

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
                                        for (let sa = 2;sa<=252;sa++){
                                            s_a[sa] = "Others";
                                            s_a_val[sa] = "N/A";
                                        }

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
                                        $(function (){
                                            populateCountries("country", "state");
                                        })
                                    </script>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="zip_code">Zip Code<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input type="text" name="zip_code" id="zip_code" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['zip_code']:''?>">
                                </div>
                            </div>
                        </div>
                        <div class="create_re">
                            <div class="control-group" id="location_id_div">
                                <div class="controls col-lg-5 form-group">
                                    <label for="location_id">Location ID (Set your own or <a style="text-decoration: underline" onclick="generateLocationID();">use system generated</a>)<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input onblur="check_icom(this)" type="text" <?php echo ($edit===true && $edit_acc_state>1)?'readonly':'' ?> id="location_id" name="location_id" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['location_id']:''?>">
                                    <?php
                                    if($edit!=true){
                                        ?>
                                        <div style="display: none" id="img_icom"><img src="img/loading_ajax.gif"></div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group" id="vt_location_id_div" style="display:none;">
                                <div class="controls col-lg-5 form-group">
                                    <label for="vt_location_id">VTenant Location ID<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input type="hidden" id="vt_location_ida" name="vt_location_ida" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['vt_location_id']:''?>">
                                    <?php if ($edit===true) {
                                        echo '<div class="sele-disable span4" ></div>';
                                    } ?>
                                    <select type="text" onchange="fillrealm(this);" class="span4 form-control" id="vt_location_id" name="vt_location_id" <?php if ($edit===true) { ?><?php } ?>>
                                        <option value="">Select Option</option>
                                        <?php
                                        if ($edit===true) {
                                            $edit_acc_realm=$vtenant_model->getDistributorVtenant('tpo'.$prop_details_new['location_info'][0]['location_id']);
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
                            </div>

                            <script type="text/javascript">
                                function check_icom(icomval) {
                                    if ($('#location_id').is('[readonly]') || $('#location_id').val().length === 0) {
                                    }else{
                                        var valic = icomval.value;
                                        var valic = valic.trim();
                                        var distributor = "";
                                        <?php
                                            if ($edit_account == 1) {
                                                echo "distributor='" . $edit_distributor_code . "';";
                                            }
                                            ?>
                                        if (valic != "") {
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
                                        if (data == '1') {
                                            $('#img_icom').hide();
                                        } else if (data == '2') {
                                                $('#img_icom').hide();
                                                document.getElementById('location_id').value = "";
                                                document.getElementById('location_id').placeholder = "Please Enter New Customer Account Number";

                                                if (valic != "") {
                                                    $("#location_id_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account Exists.</p>');
                                                }else{
                                                    $("#location_id_div small[data-bv-validator='notEmpty']").html('<p> This is a required field.</p>');
                                                }
                                                

                                                $('#location_form').data('bootstrapValidator').updateStatus('location_id', 'NOT_VALIDATED').validateField('location_id');
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        //alert("error");
                                        document.getElementById('location_id').value = "";
                                            $("#location_id_div small[data-bv-validator='notEmpty']").html('<p>' + valic + ' - Customer Account exists.</p>');


                                            $('#location_form').data('bootstrapValidator').updateStatus('location_id', 'NOT_VALIDATED').validateField('location_id');




                                    }
                                    });
                                    }

                                }
                            </script>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="phone_number">Phone Number<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input tabindex="115" class="span4 form-control mobile3_vali" id="phone_number" name="phone_number" type="text" placeholder="xxx-xxx-xxxx" pattern="^[0-9]{3}-[0-9]{3}-[0-9]{4}$" oninvalid="setCustomValidity('Invalid mobile number format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')" maxlength="14" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['phone_number']:''?>">
                                </div>
                            </div>
                            <script type="text/javascript">
                            $(document).ready(function() {

                                $('.mobile3_vali').focus(function() {
                                    $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                    $('#location_form').data('bootstrapValidator').updateStatus('phone_number', 'NOT_VALIDATED').validateField('phone_number');
                                });

                                $('.mobile3_vali').keyup(function() {
                                  var phone_1 = $(this).val().replace(/[^\d]/g, "");
                                  if (phone_1.length > 9) {
                                    //$('#customer_form').bootstrapValidator().enableFieldValidators('phone', false);
                                    var phone2 = phone_1.length;
                                    if (phone_1.length > 10) {
                                      var phone2 = phone_1.length;
                                      $('#location_form')
                                                .bootstrapValidator('enableFieldValidators', 'phone_number', false);
                                      var phone_1 = phone_1.slice(0,10);
                                                
                                                }
                                              $(this).val(phone_1.replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'))
                                              //console.log(phone_1+'sss');
                                              if (phone2 == 10) {
                                                  $('#location_form')
                                                .bootstrapValidator('enableFieldValidators', 'phone_number', true);
                                            }

                                              }
                                              else{
                                  $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/, '$1-$2-$3'));
                                  $('#location_form')
                                                .bootstrapValidator('enableFieldValidators', 'phone_number', true)
                                  }
                                  
                                $('#location_form').bootstrapValidator('revalidateField', 'phone_number');
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
                                    $('#location_form').data('bootstrapValidator').updateStatus('phone_number', 'NOT_VALIDATED').validateField('phone_number');
                                });


                            });
                        </script>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="city">City<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <input name="city" id="city" class="span4 form-control" value="<?php echo $edit===true?$prop_details_new['location_info'][0]['city']:''?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="state">State/Region<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select name="state" id="state" class="span4 form-control">
                                        <option value="">Select State</option>
                                        <?php
                                        $get_regions = $db->selectDB("SELECT
                              `states_code`,
                              `description`
                            FROM
                            `exp_country_states` ORDER BY description ASC");


                                        foreach ($get_regions['data'] as $state) {
                                            if (($edit===true?$prop_details_new['location_info'][0]['state']:'') == $state['states_code']) {
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
                            <div class="control-group">
                                <div class="controls col-lg-5 form-group">
                                    <label for="time_zone">Time Zone<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select name="time_zone" id="time_zone" class="span4 form-control">
                                        <option value="">Select Time Zone</option>
                                        <?php
                                        $priority_zone_array = array(
                                            "America/New_York",
                                            "America/Chicago",
                                            "America/Denver",
                                            "America/Los_Angeles",
                                            "America/Anchorage",
                                            "Pacific/Honolulu",
                                        );
                                        $utc = new DateTimeZone('UTC');
                                        $dt = new DateTime('now', $utc);
                                        foreach ($priority_zone_array as $tz) {
                                            $current_tz = new DateTimeZone($tz);
                                            $offset =  $current_tz->getOffset($dt);
                                            $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
                                            $abbr = $transition[0]['abbr'];
                                            if (($edit===true?$prop_details_new['location_info'][0]['time_zone']:'') == $tz) {
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
                                            if (($edit===true?$prop_details_new['location_info'][0]['time_zone']:'') == $tz) {
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
                        </div>
                    </div>
                </fieldset>
                <fieldset id="network_setup" data-name="Network Setup">
                    <h3>Network Setup</h3>
                    <div class="flex">
                        <div class="create_le">
                            <div class="control-group" id="guest_ssid_count_div">
                                <div class="controls col-lg-5 form-group">

                                    <label for="service_type">Number Of Guest SSIDs<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select onchange="network_config();" name="no_of_guest_ssid" id="no_of_guest_ssid" class="span4 form-control">
                                        <option value="">Select</option>
                                        <option <?php echo $prop_details_new['network_info']['Guest']['count']==1?'selected':''; ?> value="1">1</option>
                                        <option <?php echo $prop_details_new['network_info']['Guest']['count']==2?'selected':''; ?> value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="create_re">
                            <div class="control-group" id="private_ssid_count_div">
                                <div class="controls col-lg-5 form-group">

                                    <label for="service_type">Number Of Private SSIDs<sup>
                                            <font color="#FF0000"></font>
                                        </sup></label>
                                    <select onchange="network_config();" name="no_of_pvt_ssid" id="no_of_pvt_ssid" class="span4 form-control">
                                        <option value="">Select</option>
                                        <option <?php echo $prop_details_new['network_info']['Private']['count']==1?'selected':''; ?> value="1">1</option>
                                        <option <?php echo $prop_details_new['network_info']['Private']['count']==2?'selected':''; ?> value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="no_of_vt_ssid" id="no_of_vt_ssid" value="0">
                        </div>
                    <div id="match_entry_tabel" class="controls col-lg-5 form-group" style="margin-left: 0px; margin-top: 33px;width:100%">
                            <div class="widget widget-table action-table">

                                <div class="widget-content ">
                                    <div style="overflow-x:auto;margin:auto" class="theme_response">
                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Network Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Change</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Filter</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Select Product(QoS & Duration)</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Broadcast</th>
                                                </tr>
                                            </thead>
                                            <tbody id="realm_mapp">
                                            <div style="display: inline-block" id="zones_loader"></div>

                                            </tbody>
                                        </table>
                                    </div>
                        </div>
                </div>
            </div>
            </div>



        </div>
        </fieldset>
        <div class="actions clearfix">
            <ul style="list-style: none;float: right;margin: 0;" role="menu" aria-label="Pagination">
                <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-disabled="true"><button href="javascript:void(0)" data-type="previous" class="btn btn-primary" role="menuitem">Previous</button></li>
                <li class="{2} disabled" style="display: inline-block;margin-left: 5px;" aria-hidden="false" aria-disabled="true"><button tabindex="119" href="javascript:void(0)" data-type="next" class="btn btn-primary" role="menuitem">Save & Next</button></li>
                
                <li class="finishParent" style="display: none; margin-left: 5px;" aria-hidden="true">
                    <!-- <a href="#finish" class="btn btn-primary" name="create_location_submit" id="create_location_submit" role="menuitem" >Finish</a></li> -->
                    <button href="javascript:void(0)" style="margin-left: -10px; margin-right: 3px;" data-type="previous" onclick="addnewLocation();" class="btn btn-primary">Add Location</button>
                    <button onmouseover="" type="submit" name="create_location_submit" id="create_location_submit" style="margin-right: 3px;" class="btn btn-primary">Save</button>
                <li class="cancelform" style="display: none; margin-left: 5px;" aria-hidden="true"><a href="?token7=<?php echo $secret; ?>&t=provision_create&id=<?php echo $id; ?>" class="btn btn-primary" role="menuitem">Cancel</a></li>
            </ul>
        </div>
    </form>
    <script type="text/javascript">

        var update = <?php echo $edit?1:0; ?>;
        var update_id <?php echo $edit?'="'.$id.'"':''; ?>;
        $("#update_id").val(update_id);
        async  function stepsubmit(index) {
            //Validate inputs
            try {
                $('#location_form').data('bootstrapValidator').validate();
                if (!$('#location_form').data('bootstrapValidator').isValid()) {
                    return false;
                }
            } catch (e) {
                console.log(e);
            }

            let result;
            let data;
            if (index == 1) {
                var business_id = $("#business_id").val();
                var business_name = $("#business_name").val();
                var admin_f_name = $("#admin_f_name").val();
                var admin_l_name = $("#admin_l_name").val();
                var admin_email = $("#admin_email").val();
                var verify_email = $("#verify_email").val();

                let formData={
                   business_id: business_id,
                   business_name: business_name,
                   bis_admin_first_name:admin_f_name,
                   bis_admin_last_name: admin_l_name,
                   email: admin_email,
                   verify_email: verify_email
                };


                let action = !update?'create_account_info':'update_account_info&id='+update_id;

                try{
                    result = await $.ajax({
                            url : "ajax/provision/create.php?action="+action,
                            type: "POST",
                            data : formData
                        });

                        data = JSON.parse(result);
                        if(data['status']=='success'){
                            //alert('success')
                            update = 1;
                            update_id=data['id'];
                            $("#update_id").val(update_id);

                            try{
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>'
                                }
                                ajaxCall(request);
                            }catch(e){
                                console.log(e);
                            }

                            return true;
                        }else{
                            $('#msg27').html('<div class="alert alert-danger"> <strong>'+data["message"]+'. Account info Saving is failed.</strong></div>');
                            return false;
                        }
                }catch(er){
                    console.log(er);
                    return false;
                }

            }else{
                let service_type = $("#service_type").val();
                let num = $("#location_no").val();
                let location_id = $("#location_id").val();
                let location_name = $("#location_name").val();
                let phone_number = $("#phone_number").val();
                let address = $("#address").val();
                let city = $("#city").val();
                let country = $("#country").val();
                let time_zone = $("#time_zone").val();
                let state = $("#state").val();
                let zip_code = $("#zip_code").val();
                let vt_location_id = $("#vt_location_id").find(':selected').val();


                let formData = {
                    id:update_id,
                    num:num,
                    service_type: service_type,
                    location_id: location_id,
                    location_name: location_name,
                    phone_number:phone_number,
                    address:address,
                    city:city,
                    country:country,
                    state:state,
                    time_zone:time_zone,
                    zip_code:zip_code,
                    vt_location_id:vt_location_id
                }
                result = await $.ajax({
                    url : "ajax/provision/create.php?action=location_info",
                    type: "POST",
                    data : formData
                });

                data = JSON.parse(result);
                if(data['status']=='success'){
                    //$(".finishParent").addClass('btn btn-primary');
                    $('.actions.clearfix').find('.finishParent').show();
                    //alert('success')
                    //update = 1;
                    //update_id=data['id'];
                    return true;
                }else{
                    $('#msg27').html('<div class="alert alert-danger"> <strong>'+data["message"]+'. Location info Saving is failed.</strong></div>');
                    return false;
                }
            }
        }

        function stepList(index, name) {
            var clz = '';
            if (index == 1) {
                clz = 'current';
            }
            return '<li data-step="' + index + '" role="tab" class="{index' + index + '}" aria-disabled="false" aria-selected="true"><span>' + name + '</span></li>';
        }


        function stepSetter(step, stepCount, action, stepListFull, edit_account){

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
                        $('#location_form').data('bootstrapValidator').validate();
                        if (!$('#location_form').data('bootstrapValidator').isValid()) {
                            return false;
                        }
                    } catch (e) {
                        console.log(e);
                    }
                    if (step == 3) {
                        if (edit_account) {
                            $("#add_location_submit").prop("disabled", false);
                            $("#create_location_submit").prop("disabled", false);
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
                $('.actions.clearfix').find('button[data-type="previous"]').hide();
                if (edit_account) {
                    $('.actions.clearfix').find('.finishStepone').css('display', 'inline-block');
                    $('.actions.clearfix').find('.finishSteptwo').hide();
                }

                //bootstrapValidatorSteps.enableFieldValidators('zone', false);
            } else if (step == 2) {
                if (previousn != 1) {
                    var bootstrapValidator = $('#location_form').data('bootstrapValidator');
                    try {
                        bootstrapValidator.enableFieldValidators('groups', false);
                    } catch (e) {}
                }
                $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
                if (edit_account) {
                    $('.actions.clearfix').find('.finishStepone').hide();
                    $('.actions.clearfix').find('.finishSteptwo').css('display', 'inline-block');
                    
                }
                //if(document.getElementById("automation_property").checked){

                //bootstrapValidatorSteps.enableFieldValidators('zone', true);
                //}
            } else {
                $('.actions.clearfix').find('button[data-type="previous"]').css('display', 'inline-block');
                if (edit_account) {
                    $('.actions.clearfix').find('.finishStepone').hide();
                    $('.actions.clearfix').find('.finishSteptwo').hide();
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
                $('#location_form').prepend(stepListFull);
                //$(".finishParent").find('a[href$="#finish"]').replaceWith($('.submit-btn'));
            }
        }

        async function setSteps(step, stepCount, action, stepListFull) {
            $('#msg27').empty();
            var edit_account = false;
            <?php
            if($edit===true){
                ?>
                edit_account = true;
                <?php
                }
                ?>
            let submit_status;
            if (action == 'next') {
                await stepsubmit(step-1).then(function(res){
                    if(res===true){
                        stepSetter(step, stepCount, action, stepListFull,edit_account);
                    }
                });

                return true;
            }

            stepSetter(step, stepCount, action, stepListFull);
        }


        $(document).ready(function() {
            var stepListFull = '<div class="steps clearfix" style="margin-top:20px"><ul role="tablist">';
            var stepCount = 0;
            $('#location_form fieldset').each(function(index, element) {
                $(this).addClass('step' + (index + 1)).addClass('fieldStep');
                stepListFull += stepList((index + 1), $(this).attr('data-name'));
                stepCount++;
            });
            stepListFull += '</ul></div>';

            setSteps(1, stepCount, 'ready', stepListFull);

        });

        var previousn;
        $('.actions.clearfix').find('button[data-type="previous"]').bind('click', function(e) {
            previousn = 1;
            setSteps((parseInt($('.steps.clearfix li.current').attr('data-step')) - 1), $('#location_form fieldset').length, 'previous', undefined);
        });

        $('.actions.clearfix').find('button[data-type="next"]').bind('click',async function(e) {
            let in_html = $(this).html();
            $(this).attr('disabled','disabled');
            $(this).html('<img src="img/loading_me.gif">');
            await setSteps((parseInt($('.steps.clearfix li.current').attr('data-step')) + 1), $('#location_form fieldset').length, 'next', undefined);
            $(this).attr('disabled',false);
            $(this).html(in_html);
        });
        var product_name;
        var network_name;
        var new_val;

        function addnewLocation() {
            //console.log(vt_enable);
        //var a = $("#location_no").val();
        var a = $('#location_no option:last-child').val();

        var b = 1;
        val = parseInt(a) + parseInt(b);

        $("#service_type").val('');
        $("#location_id").val('');
        document.getElementById("location_id").readOnly = false;
        $("#location_name").val('');
        $("#phone_number").val('');
        $("#address").val('');
        $("#city").val('');
        $("#country option:selected").removeAttr("selected");
        $("#time_zone option:selected").removeAttr("selected");
        $("#state option:selected").removeAttr("selected");
        $("#zip_code").val('');
        $("#vt_location_id option:selected").removeAttr("selected");
        $("#no_of_guest_ssid option:selected").removeAttr("selected");
        $("#no_of_pvt_ssid option:selected").removeAttr("selected");
        $("#location_nos").show();
        $("#realm_mapp").empty();
        $("#location_no").append('<option selected value='+val+'>'+val+'</option>');

        }

        function changeLocation(){
        var num = $("#location_no").val();
        $.ajax({
                    type: 'POST',
                    url: 'ajax/provision/create.php?action=get_location_info',
                    data: {
                        num:num,
                        id: update_id
                    },
                    success: function(response) {
                        let data =  JSON.parse(response);

                        if (!data.location_id) {
                            $('#location_id').prop('readonly', false);
                        }else{
                            $('#location_id').prop('readonly',true);
                        }
                        $("#service_type").val(data.service_type);
                        $("#location_id").val(data.location_id);
                        $("#location_name").val(data.location_name);
                        $("#phone_number").val(data.phone_number);
                        $("#address").val(data.address);
                        $("#city").val(data.city);
                        $("#country").val(data.country);
                        $("#time_zone").val(data.time_zone);
                        $("#state").val(data.state);
                        $("#zip_code").val(data.zip_code);
                        $("#vt_location_id").val(data.vt_location_id);
                        $("#no_of_guest_ssid").val(data.no_of_guest_ssid);
                        $("#no_of_pvt_ssid").val(data.no_of_pvt_ssid);
                        $("#no_of_vt_ssid").val(data.no_of_vt_ssid);
                        <?php
                        if($edit===true){
                            ?>
                            if (num != 1 && data.vt_location_id) {
                                $("#vt_location_id").append('<option selected value='+data.vt_location_id+'>'+data.vt_location_id+'</option>');
                            }
                        <?php
                            }
                            ?>
                        var resultnew = '';
                        network_config('edit');
                        loadServiceOptions();

                    },
                    error: function() {
                    }

                });
        }

        function network_config(val) {
            //console.log(vt_enable);

        var no_of_guest = $('#no_of_guest_ssid').val();
        var no_of_pvt = $('#no_of_pvt_ssid').val();
        var no_of_vt = $('#no_of_vt_ssid').val();
        var location_id = $('#location_id').val();
        let num = $("#location_no").val();
        var result = '';
        var resultnew = '';
        var aaa = true;
        if (val && val!='edit') {
            aaa = false;
            new_val = val;
            product_name = $('#product_'+val).val();
            network_name = $('#network_'+val).val();
        }
        if((network_name != null && network_name != '') || ((!val || val=='edit') && (aaa || network_name != ''))) {
        document.getElementById("zones_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                $.ajax({
                    type: 'POST',
                    url: 'ajax/provision/get_network.php',
                    data: {
                        no_of_guest: no_of_guest,
                        no_of_pvt: no_of_pvt,
                        no_of_vt:no_of_vt,
                        num:num,
                        sync_type: 'network_sync',
                        location: location_id,
                        network_name: network_name,
                        update_id: update_id,
                        new_val: val,
                        product: product_name,
                        system_package: "<?php echo $system_package; ?>",
                        mno: "<?php echo $user_distributor; ?>"
                    },
                    success: function(data) {

                        /* alert(data); */
                        $("#realm_mapp").empty();

                        $("#realm_mapp").append(data);
                        //$("#pvt_network").append(data.guest);


                        document.getElementById("zones_loader").innerHTML = "";

                    },
                    error: function() {
                        document.getElementById("zones_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
                    }

                });
            }else{
                if (network_name == '') {
                    alert('Empty Network Name');
                }else{
                    alert('Please Select Product');
                }
            }
}
<?php
if($edit===true){
    ?>
        $(function () {
            
            $("#location_nos").show();
            var location_count = '<?php echo $location_no_n; ?>';

            if (location_count > 0) {
                network_config('edit');
            }
            $('.actions.clearfix').find('.cancelform').css('display', 'inline-block');
            
        })
        <?php
}
?>
        function fillrealm(val) {
            if (!$('#location_id').is(":visible")) {
                $('#location_id').val($(val).val());
            }
        }

        function generateParentID() {
            if(update)
                return false;

            let action  = 'generateParentID';
            $('#prov-create-progress').show();
            $.ajax({
                url : "ajax/provision/create.php?action="+action,
                type: "POST",
                data : {},
                success : function (response) {
                    let data =  JSON.parse(response);
                    update = 1;
                    update_id=data['id'];
                    $("#update_id").val(update_id);

                    //Disable & set value
                    $('#business_id').val(data['business_id']);
                    $('#location_form').data('bootstrapValidator').enableFieldValidators('business_id',false)
                    $('#business_id').attr('readonly',true);
                    $('#prov-create-progress').hide();
                    try{
                        let request = {
                            listsize: $('#activeLocationsTablePerpage').val(),
                            type: 'locationActiveAccounts',
                            user_distributor: '<?php echo $user_distributor; ?>'
                        }
                        ajaxCall(request);
                    }catch(e){
                        console.log(e);
                    }
                },
                error: function () {
                    $('#prov-create-progress').hide();
                }
            });
        }

        function generateLocationID() {
            let realm_new = $("#location_id").val();
            var edit = '<?php echo $edit; ?>';
            if (!edit || !realm_new) {
                let action  = 'generateLocationID';
            $('#prov-create-progress').show();
            let num = $("#location_no").val();
            $.ajax({
                url : "ajax/provision/create.php?action="+action,
                type: "POST",
                data : {
                    id : update_id,
                    num:num,
                    system_package: "<?php echo $system_package; ?>"
                },
                success : function (response) {
                    let data =  JSON.parse(response);
                    if(data['status']=='failed'){
                        $('#prov-create-progress').hide();
                        return false;
                    }
                    // update = 1;
                    // update_id=data['id'];
                    $("#update_id").val(update_id);

                    //Disable & set value
                    $('#location_id').val(data['location_id']);
                    $('#location_id').attr('readonly',true);
                    $('#prov-create-progress').hide();
                },
                error: function () {
                    $('#prov-create-progress').hide();
                }
                });

            }
            
            
        }
    </script>
</div>
