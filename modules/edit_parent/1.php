

<?php 
$isDynamic = package_functions::isDynamic($system_package);
?>
<div <?php if(isset($tab_edit_parent)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="edit_parent">


    <div class="support_head_visible" style="display:none;"><div class="header_hr"></div><div class="header_f1" style="width: 100%;">
            Account Info</div>
        <br class="hide-sm"><br class="hide-sm"><div class="header_f2" style="width: 100%;"> </div></div>

    <form action="?t=create_property<?php if(isset($get_edit_parent_id)) echo '&location_parent_id='.$get_edit_parent_id.'&token7='.$secret.'&t=edit_parent&edit_parent_id='.$get_edit_parent_id; ?>" id="parent_form" name="parent_form" class="form-horizontal" method="POST"   >

        <?php
        echo '<input type="hidden" name="form_secret12" id="form_secret12" value="'.$secret.'" />';
        ?>

        <fieldset>


            <div class="control-group">
                <label class="control-label" for="mno_full_name">Business ID</label>
                <div class="controls col-lg-5 form-group">
                    <input maxlength="12" readonly class="span4 form-control" id="up_parent_id" placeholder="" name="parent_id" type="text" value="<?php echo$get_edit_parent_id;?>">
                    <script type="text/javascript">
                        $("#up_parent_id").keypress(function(event){
                            var ew = event.which;
                            if(ew == 32)
                                return true;
                            if(48 <= ew && ew <= 57 || 65 <= ew && ew <= 90 || 97 <= ew && ew <= 122 || ew == 0  || ew == 8 || ew == 189)
                                return true;
                            return false;
                        });
                    </script>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="mno_full_name">Business Account Name</label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="parent_ac_name1" placeholder="" name="parent_ac_name" type="text" value="<?php echo htmlspecialchars(str_replace("\\",'',$get_edit_parent_ac_name)); ?>">
                </div>
            </div>

            <script type="text/javascript">

                $(document).ready(function() {

                    $("#parent_ac_name").keypress(function(event){
                        var ew = event.which;
                        // if(ew == 32)
                        //   return true;
                        if(34 != ew && 39 != ew && 62 != ew && 60 != ew )
                            return true;
                        return false;
                    });

                    $("#parent_ac_name1").keypress(function(event){
                        var ew = event.which;
                        // if(ew == 32)
                        //   return true;
                        if(34 != ew && 39 != ew && 62 != ew && 60 != ew )
                            return true;
                        return false;
                    });
                    $("#mno_address_1").keypress(function(event){
                        var ew = event.which;
                        // if(ew == 32)
                        //   return true;
                        if(34 != ew && 39 != ew && 62 != ew && 60 != ew )
                            return true;
                        return false;
                    });
                    $("#mno_address_2").keypress(function(event){
                        var ew = event.which;
                        // if(ew == 32)
                        //   return true;
                        if(34 != ew && 39 != ew && 62 != ew && 60 != ew )
                            return true;
                        return false;
                    });
                    $("#location_name1").keypress(function(event){
                        var ew = event.which;
                        // if(ew == 32)
                        //   return true;
                        if(34 != ew && 39 != ew && 62 != ew && 60 != ew )
                            return true;
                        return false;
                    });
                });

            </script>

            <div class="control-group">
                <label class="control-label" for="mno_full_name">First Name</label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control pname" id="parent_first_name" placeholder="First Name" name="parent_first_name" type="text" maxlength="30" value="<?php echo $edit_parent_first_name;?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="mno_full_name">Last Name</label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control pname" id="parent_last_name" placeholder="Last Name" name="parent_last_name" type="text" maxlength="30" value="<?php echo$edit_parent_last_name;?>">
                </div>
            </div>
            <script>

                $(".pname").keyup(function() {
                    $(this).val($(this).val().replace(/\s/g, ""));
                });

            </script>


            <?php
            if(array_key_exists('new_features',$field_array) || $package_features=="all"){
                ?>
                <div class="control-group">
                    <label class="control-label" for="mno_features">Features</label>
                    <div class="controls col-lg-5 form-group">
                        <select onchange="new_features();" class="form-control span4" multiple="multiple" id="parent_features" name="parent_features[]">
                            <option value="" disabled="disabled"> Choose Feature(s)</option>

                            <?php

                            $fearuresjson=$db->getValueAsf("SELECT features as f FROM `exp_mno` WHERE mno_id='$user_distributor'");
                            $mno_feature=json_decode($fearuresjson);

                            $qf = "SELECT `service_id`,`service_name`,`mno_feature`,`feature_json` FROM `exp_service_activation_features`  WHERE `service_type`='MVNO_ADMIN_FEATURES'
                                                                   ORDER BY `service_id`";

                            $featureaccesss=array();
                            $query_resultsf=$db->selectDB($qf);
                            foreach($query_resultsf['data'] AS $row) {

                                $feature_code = $row[service_id];
                                $feature_name = $row[service_name];
                                $m_features = $row[mno_feature];
                                $feature_json = $row[feature_json];

                                if (in_array($m_features, $mno_feature) || (strlen($m_features)<1)) {
                                    $fearurearr=array();
                                    $fearurear=json_decode($feature_json,true);
                                    $fearurearr[$feature_code]=$fearurear;
                                    if ((!$isDynamic && $feature_code!="CAMPAIGN_MODULE") || ($isDynamic)) {
                                    if (array_key_exists($feature_code, $edit_parent_features)) {
                                        echo "<option selected value='" . $feature_code . "'>".  $feature_name . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $feature_code . "'>".  $feature_name . "</option>";
                                    }
                                    if (!empty($fearurear)) {
                                        array_push($featureaccesss, $fearurearr);
                                    }
                                }
                            }
                                //

                            }
                            $featureaccesss=json_encode($featureaccesss); ?>


                        </select>
                    </div>
                </div>

                <div id="fearure_dpsk">
                <div class="control-group">
                
                <label class="control-label" for="mno_features">CloudPath Controller</label>
                        <div class="controls col-lg-5 form-group">

<?php if(!empty($edit_dpsk_controller)){ ?>
                        <input  readonly="" class="span4 form-control" id="dpsk_conroller" placeholder="" name="dpsk_conroller" type="text" value="<?php echo $edit_dpsk_controller; ?>" >
<?php }else{ ?>
                            <select  name="dpsk_conroller" id="dpsk_conroller"  class="span4 form-control" onchange="getdpsk_policies('get_policies')">
                                <option value="">CloudPath Controller</option>
                               <?php
                                            $q1 = "SELECT exp_mno_ap_controller.`mno_id`,exp_mno_ap_controller.`ap_controller`
                                                        FROM exp_mno_ap_controller
                                                        LEFT JOIN exp_locations_ap_controller ON exp_mno_ap_controller.`ap_controller`= exp_locations_ap_controller.`controller_name`  WHERE mno_id='$user_distributor' AND type='DPSK'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row) {

                                                //$mnoid=$row[mno_id];
                                                $apc=$row['ap_controller'];

                                                $ap_controller = preg_replace('/\s+/', '', $apc);
                                                if($edit_dpsk_controller==$apc){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option   ".$controller_sel."  class='".$ap_controller."' value='".$apc."'>".$apc."</option>";
                                            }
                                            ?>
                            </select>
                            <?php } ?>
                        </div>
                        
                    </div>

                    <div class="control-group" >
                    <label class="control-label" for="dpsk_policies">CloudPath Policies</label>
<div class="controls col-lg-5 form-group">
    <select  name="dpsk_policies" id="dpsk_policies"  class="span4 form-control" >
        <option value="">CloudPath Policies</option>

        <?php
                                            $q1 = "SELECT * FROM `mdu_dpsk_policies` WHERE `controller`= '$edit_dpsk_controller'";

                                            $query_results=$db->selectDB($q1);
                                            
                                            foreach ($query_results['data'] AS $row_s) {

                                                $dpsk_policies_id = $row_s['dpsk_policies_id'];
                                                $dpsk_policiesName = $row_s['dpsk_policiesName'];

                                               //echo $edit_dpsk_policies."==".$dpsk_policies_id;
                                                if($edit_dpsk_policies==$dpsk_policies_id){
                                                    $controller_sel='selected';
                                                }else{
                                                    $controller_sel='';
                                                }

                                                echo "<option  ".$controller_sel." value='".$dpsk_policies_id."'>".$dpsk_policiesName."</option>"
;
                                            }
                                            ?>
  
    </select>
    <a style="display: inline-block; padding: 6px 20px !important;" onclick="getdpsk_policies('sync')" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
<div style="display: inline-block" id="cloud_policies_loader"></div>

</div>
   
<script type="text/javascript">
function getdpsk_policies(get_type){

ctrl_name=document.getElementById("dpsk_conroller").value;

var a = ctrl_name.length;

if(a==0){

alert('Please Select DPSKController before Refresh!');

}else{
    document.getElementById("cloud_policies_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
$.ajax({
    type: 'POST',
    url: 'ajax/getdpsk_policies.php',
    data: { ctrl_name:ctrl_name,get_type:get_type,mno:"<?php echo $user_distributor; ?>" },
    success: function(data) {

       

        $("#dpsk_policies").empty(data);
        $("#dpsk_policies").append(data);



        document.getElementById("cloud_policies_loader").innerHTML = "";

    },
    error: function(){
        document.getElementById("cloud_policies_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
    }

});

}

}

</script>

</div>




                </div>
                <div id="fearure_arrr"></div>
                <script type="text/javascript">

                    $(document).ready(function() {
                        var admin_features_val = $('#parent_features').val();
                        var features_arr = '<?php echo $featureaccesss ?>';
                        var edit_parent_features = '<?php echo json_encode($edit_parent_features) ?>';
                        var array_new = JSON.parse(features_arr);
                        var edit_parent_feature = JSON.parse(edit_parent_features);
                        var result='';
                        $("#fearure_dpsk").css("display", "none");

                        for (var key in admin_features_val) {

                            if (admin_features_val[key]=='CLOUD_PATH_DPSK') { 
                                $("#fearure_dpsk").css("display", "block");
                            }
                        }

                        for (var i = 0; i < array_new.length; i++) {
                            //array_new[i];

                            for (var key in array_new[i]) {
                                if (admin_features_val) {
                                    var a = admin_features_val.indexOf(key);
                                }
                                if (edit_parent_feature) {
                                    var b = edit_parent_feature[key];
                                }

                                //.log(edit_parent_feature[key]);
                                if (a>-1) {

                                    var value=array_new[i][key];
                                    var type=value['type'];
                                    var name=value['id'];
                                    var label=value['label'];
                                    var check1=value['value']['operator'];
                                    var check2=value['value']['parent'];

                                    var checked=check1['selected'];
                                    var label_n=check1['label'];
                                    var enable=check1['enable'];
                                    var checkedp=check2['selected'];
                                    var label_np=check2['label'];
                                    var enablep=check2['enable'];

                                   if (b==2) {
                                        result+='<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">'+label+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checkedp+' value="'+enable+'"><label for="ed_pr_fe_'+type+'" style="display :inline-block; min-width: 45%; max-width: 100%;">'+label_n+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checked+' value="'+enablep+'"><label style="display :inline-block;">'+label_np+'</label></div></div>';
                                    }else{
                                        result+='<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">'+label+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checked+' value="'+enable+'"><label for="ed_pr_fe_'+type+'" style="display :inline-block; min-width: 45%; max-width: 100%;">'+label_n+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checkedp+' value="'+enablep+'"><label style="display :inline-block;">'+label_np+'</label></div></div>';
                                    }

                                }
                            }


                        }
                        $('#fearure_arrr').empty();

                        $('#fearure_arrr').html(result);
                    });

                    function new_features() {
                        //alert("fn");
                        $("#submit_p_form").prop('disabled', false);
                        var admin_features_val = $('#parent_features').val();
                        var features_arr = '<?php echo $featureaccesss ?>';
                        var edit_parent_features = '<?php echo json_encode($edit_parent_features) ?>';
                        var array_new = JSON.parse(features_arr);
                        var edit_parent_feature = JSON.parse(edit_parent_features);
                        var result='';
                        //console.log(array_new);

                        $("#fearure_dpsk").css("display", "none");

                        for (var key in admin_features_val) {
//alert(admin_features_val[key]);
                            if (admin_features_val[key]=='CLOUD_PATH_DPSK') { 
                                $("#fearure_dpsk").css("display", "block");
                            }
                        }

                        for (var i = 0; i < array_new.length; i++) {
                            //array_new[i];

                            for (var key in array_new[i]) {
                                if (admin_features_val) {
                                    var a = admin_features_val.indexOf(key); }
                                if (edit_parent_feature) {
                                    var b = edit_parent_feature[key];
                                }
                                if (a>-1) {

                                    var value=array_new[i][key];
                                    var type=value['type'];
                                    var name=value['id'];
                                    var label=value['label'];
                                    var check1=value['value']['operator'];
                                    var check2=value['value']['parent'];

                                    var checked=check1['selected'];
                                    var label_n=check1['label'];
                                    var enable=check1['enable'];
                                    var checkedp=check2['selected'];
                                    var label_np=check2['label'];
                                    var enablep=check2['enable'];

                                    if (b==2) {
                                        result+='<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">'+label+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checkedp+' value="'+enable+'"><label for="ed_pr_fe_'+type+'" style="display :inline-block; min-width: 45%; max-width: 100%;">'+label_n+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checked+' value="'+enablep+'"><label style="display :inline-block;">'+label_np+'</label></div></div>';
                                    }else{
                                        result+='<div class="control-group"><div class="controls col-lg-5 form-group"><label for="parent_feature_type">'+label+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checked+' value="'+enable+'"><label for="ed_pr_fe_'+type+'" style="display :inline-block; min-width: 45%; max-width: 100%;">'+label_n+'</label><input type="'+type+'" name="'+name+'" id="'+name+'" '+checkedp+' value="'+enablep+'"><label style="display :inline-block;">'+label_np+'</label></div></div>';
                                    }

                                }
                            }


                        }
                        $('#fearure_arrr').empty();

                        $('#fearure_arrr').html(result);
                        // $('#device_arr').html(resultsn);
                    }
                </script>
            <?php } ?>
            <div class="control-group">
                <!--<div style="display: inline-block;width: 68%;">-->
                <label class="control-label" for="mno_email">Email</label>
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="parent_email" name="parent_email" type="text" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                    <input type="checkbox" data-toggle="tooltip" title="Alert! Checking this box and submitting change will update/replace Business Admin Credentials. Submitting will also require update to User ID and Password." id="parent_username_change" name="parent_username_change"><font id="replace_user_lbl" style="width: 40%;">Update/Replace Business Admin Credentials</font>
                    <style type="text/css">
                        input[id="parent_username_change"] + label{
                            margin-right: 0px !important;
                        }
                        @media only screen and (min-width : 768px) {
                            #replace_user_lbl {
                                float: right;
                            }
                        }
                    </style>
                    <div style="display:none" id="parent_update_conf_msg" >Are you sure you want to update this account?</div>
                    <script type="text/javascript">
                        $('#parent_username_change').click(function(){
                            setTimeout(function () {
                                if($('#parent_username_change').is(':checked')){
                                    $('#submit_p_form_confirm').addClass('parent-update-conf-div-long');
                                    $('#submit_p_form_confirm').removeClass('parent-update-conf-div-small');
                                    $('#parent_update_conf_msg').html('Warning! Submitting this change will update current Business Admin </br>or establish a New Business Admin credentials. Submitting will also</br> require update to User ID and Password');
                                }else{
                                    $('#submit_p_form_confirm').addClass('parent-update-conf-div-small');
                                    $('#submit_p_form_confirm').removeClass('parent-update-conf-div-long');
                                    $('#parent_update_conf_msg').html('Are you sure you want to update this account?');
                                }

                                eval($('#easy_confirm').html());
                            },5);
                        })
                    </script>
                </div>
                <!--</div>-->
                <!--<div style="display: inline-block;width: 31%;position: absolute;"> Update/Replace Business Admin Credentials</div>-->
            </div>
            <div class="control-group">
                <label class="control-label" for="mno_email"></label>
                <input type="hidden" id="check_p_email" value="<?php echo $edit_parent_email;?>">
                <div class="controls col-lg-5 form-group">
                    <input class="span4 form-control" id="change_0" name="change_0" type="hidden" placeholder="wifi@company.com" value="<?php echo $edit_parent_email;?>">
                </div>
            </div>


            <?php


            $parent_package=$package_functions->getOptions('MVNO_ADMIN_PRODUCT',$system_package);
            $parent_package_array =explode(',',$parent_package);
            //print_r($parent_package_array);
            if(count($parent_package_array)>1){


                ?>

                <div class="control-group">
                    <label class="control-label" for="parent_package_type">Admin Type</label>
                    <div class="controls col-lg-5 form-group">
                        <?php
                        echo'<select class="span4 form-control" id="parent_package" name="parent_package_type">';
                        echo '<option value="">Select Business ID type</option>';

                        foreach($parent_package_array as $value){
                            $parent_package_name = $db->getValueAsf("SELECT product_name AS f FROM admin_product WHERE product_code='$value'");
                            echo '<option value="'.$value.'"';
                            if($edit_parent_system_package == $value){
                                echo ' selected';
                            }
                            echo '>'.$parent_package_name.'</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                </div>
                <?php

                /*
                                                                        ?>

                                                                        <div class="control-group">
                                                                            <label class="control-label" for="parent_package_type">Admin Type</label>
                                                                            <div class="controls col-lg-5 form-group">

                                                                                    <input readonly class="span4 form-control" type="text" placeholder=""   value="<?php echo $package_functions->getPackageName($edit_parent_system_package); ?>">
                                                                                    <input  id="parent_package_type" name="parent_package_type" type="hidden" placeholder="BBB"   value="<?php echo $edit_parent_system_package; ?>">

                                                                            </div>
                                                                        </div>
                                                                    <?php
                */
            }else{
                echo ' <div class="control-group"> <div class="controls col-lg-5 form-group"><input   id="parent_package_type" name="parent_package_type" type="hidden" value="'.$parent_package_array[0].'"></div></div>';
            } ?>






            <div class="form-actions">

                <button onmouseover="parent_btn_action('submit_p_form');" disabled type="submit" id="submit_p_form" value="submit_p_form" name="submit_p_form" class="btn btn-primary" onClick="(function(){
                                                            $('#submit_p_form_confirm_text').html($('#parent_update_conf_msg').html());
                                                            $('.ui-widget-overlay').show();
                                                            $('#submit_p_form_confirm').show();
                                                                    return false;
                                                                })();return false;">Update Account</button>

                <?php if(!in_array('support', $access_modules_list)){ ?>
                    <button onmouseover="parent_btn_action('add_location');" type="submit" name="add_location" id="add_location" value="add_location" class="btn btn-info inline-btn">Add Location</button><strong><font color="#FF0000"></font> </strong>
                <?php } ?>
                <button type="button" class="btn btn-info inline-btn"  onclick="gopto();" >Cancel</button>
                <input type="hidden" name="p_update_button_action" id="p_update_button_action">

            </div>
            <script type="text/javascript">
                function parent_btn_action(action) {
                    $('#p_update_button_action').val(action);
                }

                function gopto(url){
                    window.location = "?";
                }
            </script>
            <!-- /form-actions -->

        </fieldset>

    </form>

    <div class="widget widget-table action-table">

        <div class="widget-header">

            <!--  <i class="icon-th-list"></i> -->

            <h3>Locations</h3>

        </div>

        <!-- /widget-header -->

        <div class="widget-content table_response" id="location_div">
            <div style="overflow-x:auto">

                <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>

                    <?php  if(array_key_exists('how_many_buildings',$field_array)){

                        $location_q = "SELECT t.*,GROUP_CONCAT(' ',j.`icom`) AS icom FROM (SELECT DISTINCT  d.`gateway_type`,d.`private_gateway_type`,d.`network_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.id AS userid,u.`verification_number`,u.is_enable,u.user_name
                                                                                FROM `exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.parent_id = '$get_edit_parent_id'
                                                                                AND u.access_role='admin' AND u.`verification_number` IS NOT NULL ORDER BY u.`verification_number` ASC) t  LEFT JOIN `exp_icoms` j ON t.distributor_code=j.distributor GROUP BY j.distributor";
                        ?>

                        <thead>


                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Location/Realm/Property ID</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ICOM(S)</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Name</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">GATEWAY</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                            <?php  if(in_array('support', $access_modules_list)){ ?>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ASSIGNED ADMIN</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UNASSIGNED ADMIN</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Resend</th>
                            <?php } ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Remove</th>

                        </tr>




                        </thead>

                        <tbody>



                        <?php





                        $query_results=$db->selectDB($location_q);
                        foreach($query_results['data'] AS $row){

                            $distributor_code = $row[distributor_code];
                            $distributor_name = htmlentities(str_replace("\\",'',$row[distributor_name]));
                            $distributor_type = $row[distributor_type];
                            $distributor_icoms = $row[verification_number];
                            $icomArr = $row[icom];
                            $distributor_gateway_type = $row[gateway_type];
                            if ($row[network_type] == 'PRIVATE' || $row[network_type] == 'VT-PRIVATE') {
                               $distributor_gateway_type = $row[private_gateway_type];
                            }
                            if ($row[network_type] == 'VT') {
                               $distributor_gateway_type = 'AC';
                            }
                            

                            $distributor_id_number = $row[dis_id];
                            $userid = $row[userid];
                            $distributor_user_name = $row['user_name'];
                            $is_enable = $row[is_enable];
                            if(empty($distributor_user_name)|| $is_enable==8){
                                $pa_act_user = "NO";
                            }else{
                                $pa_act_user= "YES";
                            }

                            $distributor_name_display=str_replace("'","\'",$distributor_name);

                            echo '<tr>';
                            echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->

                                                                <td> '.$distributor_icoms.' </td>
                                                                <td> '.$icomArr.' </td>
                                                                <td> '.$distributor_name.' </td>
                                                                
                                                                <td> '.$distributor_gateway_type.' </td>';

                            echo '<td><a href="javascript:void();" id="EDITACCd_'.$distributor_id_number.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITACCd_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITACCd_'.$distributor_id_number.'\').click(function() {
                                                            window.location = "?token7='.$secret.'&t=create_property&edit_loc_id='.$distributor_id_number.'&location_parent_id='.$get_edit_parent_id.'"

                                                        });

                                                        });

                                                    </script></td>';


                            if(in_array('support', $access_modules_list)) {
                                echo '<td>' . $pa_act_user . ' &nbsp;/';

                                echo '<a href="javascript:void();" id="edSup_' . $distributor_id_number . '"  class="btn btn-small btn-primary">
                                            <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
                                            $(document).ready(function() {
                                            $(\'#edSup_' . $distributor_id_number . '\').easyconfirm({locale: {
                                                    title: \'Assign Admin \',
                                                    text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                    button: [\'Cancel\',\' Confirm\'],
                                                    closeText: \'close\'
                                                     }});
                                                $(\'#edSup_' . $distributor_id_number . '\').click(function() {
                                                    window.location = "?t=13tokene=' . $secret . '&assign_loc_admin=' . $distributor_id_number . '"
                                                });
                                                });
                                            </script>';


                                echo '</td>';

                                echo '<td>';
                                if( $is_enable=='8'){
                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a>';
                                }else{

                                    //t=12&edit_parent_id
                                    echo '<a href="javascript:void();" id="Unassign_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a><script type="text/javascript">
                                                          $(document).ready(function() {
                                                          $(\'#Unassign_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                  title: \'Unassign Admin\',
                                                                  text: \'Are you sure you want to Unassign this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                  button: [\'Cancel\',\' Confirm\'],
                                                                  closeText: \'close\'
                                                                   }});
                                                              $(\'#Unassign_'.$distributor_id_number.'\').click(function() {
                                                                window.location = "?t=edit_parent&tokene=' . $secret . '&unassign_loc_admin=' . $userid .'&edit_parent_id='.$get_edit_parent_id.'"
                                                              });
                                                              });
                                                          </script>';


                                }

                                echo '</td>';


                                echo '<td>';

                                if($pa_act_user=='YES' && $is_enable=='2'){
                                    //t=12&edit_parent_id
                                    echo '<a href="javascript:void();" id="resend_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_'.$distributor_id_number.'\').click(function() {
                                                                    window.location = "?tokene='.$secret.'&e_resend_a='.$distributor_code.'&t=edit_patent&edit_parent_id='.$get_edit_parent_id.'"
                                                                });
                                                                });
                                                            </script>';

                                }else{
                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                }

                                echo '</td>';







                            }


                            echo '<td><a href="javascript:void();" id="DISTRI1_'.$distributor_id_number.'"  class="btn btn-small btn-primary" >

                                <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><img id="distributor_loader_'.$distributor_id_number.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">

                                    $(document).ready(function() {

                                    $(\'#DISTRI1_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Account Remove\',
                                            text: "Are you sure you want to remove[ '.$distributor_icoms.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#DISTRI1_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=edit_parent&remove_loc_code='.$distributor_code.'&remove_loc_name='.$distributor_name.'&remove_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });
                                        });
                                    </script></td>';





                            echo '</tr>';

                        }
                        ?>


                        </tbody>


                    <?php }else{

$suspend_location_view=$package_functions->getOptions('SUSPEND_LOCATION_VIEW',$system_package);

                        $location_q = "SELECT DISTINCT  d.`is_enable` AS loc_is_enable,d.`gateway_type`,d.id AS dis_id,d.`distributor_code`,d.`distributor_name`,d.`distributor_type` ,d.`state_region` ,d.`mno_id`,d.`country`,u.id AS userid,u.`verification_number`,u.is_enable,u.user_name
                                                                                FROM `exp_mno_distributor` d
                                                                                LEFT JOIN admin_users u ON d.`distributor_code`=u.`user_distributor`
                                                                                WHERE d.parent_id = '$get_edit_parent_id'
                                                                                AND u.access_role='admin' AND u.`verification_number` IS NOT NULL ORDER BY u.`verification_number` ASC";
                        ?>

                        <thead>


                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Name</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">GATEWAY</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                            <?php if($suspend_location_view=='ENABLE'){ ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5" style="width: 240px;">Status</th>
                            <?php } ?>
                            <?php  if(in_array('support', $access_modules_list)){ ?>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">ASSIGNED ADMIN</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UNASSIGNED ADMIN</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Resend</th>
                            <?php } ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Remove</th>

                        </tr>




                        </thead>

                        <tbody>



                        <?php





                        $query_results=$db->selectDB($location_q);
                        foreach($query_results['data'] AS $row){

                            $distributor_code = $row[distributor_code];
                            $distributor_name = str_replace("\\",'',$row[distributor_name]);
                            $distributor_type = $row[distributor_type];
                            $distributor_icoms = $row[verification_number];

                            $distributor_gateway_type = $row[gateway_type];
                            if ($row[network_type] == 'PRIVATE' || $row[network_type] == 'VT-PRIVATE') {
                               $distributor_gateway_type = $row[private_gateway_type];
                            }
                            if ($row[network_type] == 'VT') {
                               $distributor_gateway_type = 'AC';
                            }
                            $loc_is_enable = $row[loc_is_enable];
                            $active_st="";
                            $susspend_st="";

                            $active_st_eq=true;
                            $susspend_st_eq=true;

                            if($loc_is_enable==3){
                                //$loc_is_enable = 'Suspended';
                            $susspend_st="checked";
                            $susspend_st_eq=false;

                            }else{
                                //$loc_is_enable = 'Active';
                            $active_st="checked";
                            $active_st_eq=false;
                               // echo $distributor_icoms;
                            }

                            $distributor_id_number = $row[dis_id];

                            $loc_is_enable ="ACTIVE &nbsp;<a href='javascript:void();' id='st_active_".$distributor_id_number."'> <input type='radio' name='Acc_type_".$distributor_id_number."' value='Active' ".$active_st." class='sml_radio' /></a>";
                            $loc_is_susspend ="SUSPENDED &nbsp;<a href='javascript:void();' id='st_suspend_".$distributor_id_number."'><input type='radio' name='Acc_type_".$distributor_id_number."' value='Suspended' ".$susspend_st." class='sml_radio' /> </a>";


                            $userid = $row[userid];
                            $distributor_user_name = $row['user_name'];
                            $is_enable = $row[is_enable];
                            if(empty($distributor_user_name)|| $is_enable==8){
                                $pa_act_user = "NO";
                            }else{
                                $pa_act_user= "YES";
                            }

                            $distributor_name_display=str_replace("'","\'",$distributor_name);

                            echo '<tr>';
                            echo '<!--<td> '.$db->getValueAsf("SELECT `flow_name`AS f FROM `exp_mno_flow` WHERE `flow_type`='$distributor_type'").' </td> -->

                                                                <td> '.$distributor_icoms.' </td>
                                                                <td> '.$distributor_name.' </td>
                                                                
                                                                <td> '.$distributor_gateway_type.' </td>';

                            echo '<td><a href="javascript:void();" id="EDITACCd_'.$distributor_id_number.'"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITACCd_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                            title: \'Account Edit\',
                                                            text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITACCd_'.$distributor_id_number.'\').click(function() {
                                                            window.location = "?token7='.$secret.'&t=create_property&edit_loc_id='.$distributor_id_number.'&location_parent_id='.$get_edit_parent_id.'"

                                                        });

                                                        });

                                                    </script></td>';
                                                    if($suspend_location_view=='ENABLE'){ 
                                                        echo '<td> '.$loc_is_enable.' '.$loc_is_susspend;
                            if($active_st_eq){

                                echo '
                            <script type="text/javascript">
                                    $(document).ready(function() {

                                    $(\'#st_active_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Active Account\',
                                            text: "Are you sure you want to active this location? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#st_active_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=edit_parent&status_code=1&status_loc_code='.$distributor_code.'&status_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });


                                        

                                        
                                        });
                                    </script>';

                            }else if($susspend_st_eq){

                                echo '
                            <script type="text/javascript">
                                    $(document).ready(function() {

                                    

                                        $(\'#st_suspend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Suspend Account\',
                                            text: "Are you sure you want to suspend this location?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#st_suspend_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=edit_parent&status_code=3&status_loc_code='.$distributor_code.'&status_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });


                                        
                                        });
                                    </script>';

                            }
                            echo '</td>';



                                                    }

                            if(in_array('support', $access_modules_list)) {
                                echo '<td>' . $pa_act_user . ' &nbsp;/';

                                echo '<a href="javascript:void();" id="edSup_' . $distributor_id_number . '"  class="btn btn-small btn-primary">
                                            <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">
                                            $(document).ready(function() {
                                            $(\'#edSup_' . $distributor_id_number . '\').easyconfirm({locale: {
                                                    title: \'Assign Admin \',
                                                    text: \'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                    button: [\'Cancel\',\' Confirm\'],
                                                    closeText: \'close\'
                                                     }});
                                                $(\'#edSup_' . $distributor_id_number . '\').click(function() {
                                                    window.location = "?t=13tokene=' . $secret . '&assign_loc_admin=' . $distributor_id_number . '"
                                                });
                                                });
                                            </script>';


                                echo '</td>';

                                echo '<td>';
                                if( $is_enable=='8'){
                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a>';
                                }else{

                                    //t=12&edit_parent_id
                                    echo '<a href="javascript:void();" id="Unassign_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                          <i class="btn-icon-only icon-envelope"></i>Unassign</a><script type="text/javascript">
                                                          $(document).ready(function() {
                                                          $(\'#Unassign_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                  title: \'Unassign Admin\',
                                                                  text: \'Are you sure you want to Unassign this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                  button: [\'Cancel\',\' Confirm\'],
                                                                  closeText: \'close\'
                                                                   }});
                                                              $(\'#Unassign_'.$distributor_id_number.'\').click(function() {
                                                                window.location = "?t=edit_parent&tokene=' . $secret . '&unassign_loc_admin=' . $userid .'&edit_parent_id='.$get_edit_parent_id.'"
                                                              });
                                                              });
                                                          </script>';


                                }

                                echo '</td>';


                                echo '<td>';

                                if($pa_act_user=='YES' && $is_enable=='2'){
                                    //t=12&edit_parent_id
                                    echo '<a href="javascript:void();" id="resend_'.$distributor_id_number.'"  class="btn btn-small btn-primary">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#resend_'.$distributor_id_number.'\').easyconfirm({locale: {
                                                                    title: \'Resend Email\',
                                                                    text: \'Are you sure you want to resend email?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#resend_'.$distributor_id_number.'\').click(function() {
                                                                    window.location = "?tokene='.$secret.'&e_resend_a='.$distributor_code.'&t=edit_parent&edit_parent_id='.$get_edit_parent_id.'"
                                                                });
                                                                });
                                                            </script>';

                                }else{
                                    echo '<a href="javascript:void();"  class="btn btn-small btn-primary disabled">
                                                            <i class="btn-icon-only icon-envelope"></i>Email</a>';
                                }

                                echo '</td>';







                            }


                            echo '<td><a href="javascript:void();" id="DISTRI2_'.$distributor_id_number.'"  class="btn btn-small btn-primary" >

                                <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><img id="distributor_loader_'.$distributor_id_number.'" src="img/loading_ajax.gif" style="display:none;"><script type="text/javascript">

                                    $(document).ready(function() {

                                    $(\'#DISTRI2_'.$distributor_id_number.'\').easyconfirm({locale: {
                                            title: \'Account Remove\',
                                            text: "Are you sure you want to remove[ '.$distributor_icoms.' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                            button: [\'Cancel\',\' Confirm\'],
                                            closeText: \'close\'
                                             }});
                                        $(\'#DISTRI2_'.$distributor_id_number.'\').click(function() {
                                            window.location = "?token7='.$secret.'&t=edit_parent&remove_loc_code='.$distributor_code.'&remove_loc_name='.$distributor_name.'&remove_loc_id='.$distributor_id_number.'&edit_parent_id='.$get_edit_parent_id.'"
                                        });
                                        });
                                    </script></td>';





                            echo '</tr>';

                        }
                        ?>


                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>



</div>
