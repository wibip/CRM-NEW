                                        <div <?php if(isset($tab_guest_schedule)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="guest_schedule">
                                            <!-- Tab 3 start-->



                                            <h2>SSID <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule</h2>
                                             <!--  <font color="#005580"><h3>You can help!</h3></font> -->

                                            <?php if($package_functions->getOptions('NET_GUEST_SCHEDULE_TEXT',$system_package,$user_type)=="COX_COMPLEX_001" ){?>
                                                <p>Conserve energy and enable controls for your employees and guests who have access to your network.</p>
                                          
                                                        <div>
                                                        <!-- <div style="display: inline-block;float: right">
                                                        <img alt="" src="img/cox_power.png" width="100px;">
                                                        </div> -->
                                                        <div style="display: inline-block;float: left">
                                                       <!--  <p>
                                                           Through Cox Conserves, we have a goal to be carbon neutral by 2044. We're looking at every possible way - big and small - to
                                                           lessen our impact on the environment. Our focus on carbon reduction takes place through&nbsp;<font color="#0099cc">alternative energy, energy conservation</font> and <font color="#0099cc">fleet operations.</font>
                                                       </p> -->
                                                        </div>
                                                        </div>
                                                    
                                            <br/>
                                                <p><font color="#19bc9c;">Step 1.</font> With the SSID Broadcast scheduler you can control the hours that
                                                    your employees and guests will be able to connect to your network. You can set the broadcast schedule to
                                                    coincide with your operating hours.<br/>
                                                    <b><i>EX. Set the broadcast schedule to 8am-8pm every day.</i></b></p><br/>

                                                <p><font color="#19bc9c;">Step 2.</font> Optionally to limit the guest SSID broadcast, you can go one step further, you can
                                                    also go "green" and conserve energy by allowing the scheduler to not only stop the SSID
                                                    broadcast, but actually turn of the power to all your Access Points.<br/>
                                                    <b><i>NOTE: This option will effect your Private SSID as well</i></b></p><br/>
                                            <?php }
                                            elseif($package_functions->getOptions('NET_GUEST_SCHEDULE_TEXT',$system_package,$user_type)=="COX_SIMPLE_001"){
                                                ?>

                                                        <style type="text/css">
                                                            @media (max-width: 668px){
                                                                .main_cox{
                                                                    width: 100% !important;
                                                                }
                                                                .main_img{
                                                                    display: block !important;
                                                                    float: none !important;
                                                                    text-align: center !important;
                                                                }
                                                                .main_para{
                                                                    display: block !important;
                                                                    float: none !important;
                                                                    width: 100% !important;
                                                                }
                                                            }
                                                        </style>

<p>Conserve energy and enable controls for your employees and guests who have access to your network.</p>
                                          
                                                            <div class="main_cox" style="width: 90%">
                                                        <!-- <div class="main_img" style="display: inline-block;float: right">
                                                            <img alt="" src="img/cox_power.png" width="100px;">
                                                            </div> -->
                                                        <div class="main_para" style="display: inline-block;float: left;width: 80%">

                                                            <!-- <p>
                                                                Through Cox Conserves, we have a goal to be carbon neutral by 2044. We're looking at every possible way - big and small - to lessen our impact on the environment. 
                                                                Our focus on carbon reduction takes place through &nbsp;<font color="#0099cc">alternative energy, energy conservation</font> and <font color="#0099cc">fleet operations.</font>
                                                            </p> -->
                                                            
                                                        
                                                <br/>
                                                </div>
                                                </div>
                                                 <div style="display: inline-block;float: left">
                                                <p>With the <?php echo _POWER_SCHEDULE_NAME_; ?>Scheduler, you can control the hours that your employees and guests will be able to connect to your <?php echo __WIFI_TEXT__; ?> network. By setting when your SSID is turned on and off, you can reduce energy consumption by only enabling it during your business hours.  Turning off your SSID puts the Access Point in "low power mode", which reduces the power consumption from an already low 10W to an almost insignificant 2.5W. 
                                                <br/>
                                                 
                                                 
                                                    <br/>
                                                    <h3>Create <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule</h3>
                                                    Set the broadcast schedule to coincide with your hours of business.</p>
                                                    </div>
                                                   
                                                    <br/>
                                                    <div style="display: inline-block;float: left">
                                                <p>You can create multiple <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules and access them under "My <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules". You can turn these schedules on and off as needed, but only one may be active at a time.</p>

                                                <p>
                                                    To create a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule, use the options below to select whether each day should be listed as "Always On", have a set schedule (use the dropdowns to schedule the times) or "Always Off". Each day may only have one of the three options selected.
                                                </p>
                                                <p> Click the "Set" button to save your configuration.</p>
                                                </div>
                                                <?php
                                            }elseif($package_functions->getOptions('NET_GUEST_SCHEDULE_TEXT',$system_package,$user_type)=="GENARIC_MVNO_001"){
                                                ?>

<p>Conserve energy and enable controls for your employees and guests who have access to your network.</p>
                                          
                                                <p>With the <?php echo _POWER_SCHEDULE_NAME_; ?>Scheduler you control the hours that your guests will be able to connect to your network as well as the
                                                    energy consumed. This is accomplished by automatically turning the SSID Name broadcast on and off. Turning off the
                                                    SSID puts the Access Point in "low power mode" significantly reducing the power consumption from an already low 10W
                                                    to an almost insignificant 2.5W<br/>
                                                    <b><i>EX. Set the broadcast schedule to coincide with your opening hours.</i></b></p><br/>
                                                <p>You can create multiple <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules and you can toggle them on/off. When you turn a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule off,
                                                    all SSIDs will be put in a state of Always on.</p>
                                                <p>
                                                    Note: When you turn "on" a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule all your SSIDs, both Guest and Public that are in a state of
                                                    "Always On" will be assigned to this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule. SSIDs in a state of "Always Off" will not be affected.
                                                </p>
                                                <p>
                                                    To remove a schedule, you have to turn that scheduler off first and secondly turn on another schedule so the SSIDs gets reassigned.
                                                </p>

                                                <?php
                                            }
                                                elseif($package_functions->getOptions('NET_GUEST_SCHEDULE_TEXT',$system_package,$user_type)=="GEN_SIMP_001"){
                                                ?>

<br/>

<h3>Create <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule</h3>
                                                   <p> Set the broadcast schedule to coincide with your hours of business.</p>

                                                   <br/>
                                                    <div style="display: inline-block;float: left">
                                                <p>You can create multiple <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules and you can turn these schedules on and off as needed, but only one may be active at a time.</p>

                                                <p>
                                                    To create a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule,  use the options below to select whether each day should be listed as "Always On", have a set schedule (use the dropdowns to schedule the times) or "Always Off". Each day may only have one of the three options selected.
                                                </p>
                                                <p> Click the "Set" button to save your configuration.</p>
                                                </div>
                                                <?php
                                            }else{
                                                ?>

<p>Conserve energy and enable controls for your employees and guests who have access to your network.</p>
                                          
                                                <p>With the <?php echo _POWER_SCHEDULE_NAME_; ?>Scheduler you control the hours that your guests will be able to connect to your network as well as the
                                                    energy consumed. This is accomplished by automatically turning the SSID Name broadcast on and off. Turning off the
                                                    SSID puts the Access Point in "low power mode" significantly reducing the power consumption from an already low 10W
                                                    to an almost insignificant 2.5W<br/>
                                                    <b><i>EX. Set the broadcast schedule to coincide with your opening hours.</i></b></p><br/>
                                                <p>You can create multiple <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules and you can toggle them on/off. When you turn a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule off,
                                                    all SSIDs will be put in a state of Always on.</p>
                                                <p>
                                                    Note: When you turn "on" a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule all your SSIDs, both Guest and Public that are in a state of
                                                    "Always On" will be assigned to this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule. SSIDs in a state of "Always Off" will not be affected.
                                                </p>
                                                <p>
                                                    To remove a schedule, you have to turn that scheduler off first and secondly turn on another schedule so the SSIDs gets reassigned.
                                                </p>
                                                <?php
                                            }
                                            ?>


                                            <?php 

                                            $power_schedule_mid = 'layout/'.$camp_layout.'/views/power_schedule_mid.php';

                                            if(($new_design=='yes') && file_exists($power_schedule_mid)){ 

                                                $delete_from_schedule_assign="DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='GUEST'";
                                                          $db->execDB($delete_from_schedule_assign);

                                                          $insert_schedule_assign_guest="INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'GUEST',NOW(),'system' FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor'";

                                                          $db->execDB($insert_schedule_assign_guest);


                                                          $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                                                          $get_private_ssid_res_assign=$db->selectDB($ssid_assign_q);

                                                          
                                                        foreach ($get_private_ssid_res_assign['data'] AS $row) {

                                                            $ssid_name_a=$row['ssid'];
                                                            $b_cast=$row['ssid_broadcast'];
                                                            $netid=$row['network_id'];

                                                           // $zone_id = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

                                                            $network_sche_data=$wag_obj->retrieveOneNetwork($zone_id,$netid);

                                                            parse_str($network_sche_data);


                                                            $obj = (array)json_decode(urldecode($Description));
                                                            $she_ar=$obj['schedule'];
                                                            $api_ssid = $obj['ssid'];
                                                            
                                                            $vlan_ar=$obj['vlan'];
                                                            $vl_ar = json_decode(json_encode($vlan_ar), True);
                                                            $vlanac=$vl_ar[accessVlan];
                                                            
                                                            $data = get_object_vars($she_ar);

                                                              if($data['id']==NULL){
                                                                  $data['id']="";
                                                              }
                                                              // $data['type'];
                                                              $assign_schedule_update="UPDATE `exp_distributor_network_schedul_assign`
                                                                            SET `ssid_broadcast`='".$data['type']."',`shedule_uniqu_id`='".$data['id']."'
                                                                            WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                                                              
                                                              $db->execDB($assign_schedule_update);
                                                              
                                                              $vlan_upq="UPDATE `exp_locations_ssid` SET `vlan` = '$vlanac' WHERE `network_id`='$netid'";
                                                              
                                                              $vlan_upq_exe=$db->execDB($vlan_upq);

                                                          }

                                                include $power_schedule_mid;
                                                ?>

                                                <?php

                                            }
                                            else{

                                             ?>

                                            <form id="tab5_form1" name="tab5_form1" method="post" action="?t=1" class="form-horizontal">
                                                <br/>
                                                <fieldset class="fieset">
                                                <br>
                                                    <div class="control-group" id="feild_gp_taddg_divt">
                                                        <label class="control-label" for="gt_mvnx">Name</label>
                                                        <div class="controls ">
                                                            <input  <?php if(isset($_GET["edit_schedule"]) ){ echo 'value="'.$edit_sched_ar["name"].'" readonly'; } ?>   type="text" name="schedule_name" id="schedule_name" class="span4" maxlength="20"> <!-- onkeyup="validateShedulname(this.value)" --> <div style="display:none;" class="help-block error-wrapper bubble-pointer mbubble-pointer" id="shedule_name_dup"><p><?php echo _POWER_SCHEDULE_NAME_; ?>Schedule name already exists</p></div>
                                                            <?php if(isset($_GET["edit_schedule"]) ){ echo'<input type="hidden" value="'. $edit_sched_ar["ID"].'" name="edit_sched_id">'; } ?>
                                                            <script type="text/javascript">

                                                                $("#schedule_name").keypress(function(event){
                                                                    var ew = event.which;
                                                                  //  alert(ew);
                                                                    if(ew == 32 || ew == 8 ||ew == 0 ||ew == 36 ||ew == 33 ||ew == 64 )
                                                                        return true;
                                                                    if(48 <= ew && ew <= 57)
                                                                        return true;
                                                                    if(65 <= ew && ew <= 90)
                                                                        return true;
                                                                    if(97 <= ew && ew <= 122)
                                                                        return true;
                                                                    return false;
                                                                });

                                                                $("#schedule_name").keyup(function(event) {
                                                                    var schedule_name;
                                                                    schedule_name = $('#schedule_name').val();
                                                                    var lastChar = schedule_name.substr(schedule_name.length - 1);
                                                                    var lastCharCode = lastChar.charCodeAt(0);

                                                                    if (!(( lastCharCode == 8 ||lastCharCode == 0 ||lastCharCode == 36 ||lastCharCode == 33 ||lastCharCode == 64 ||lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                                        (65 <= lastCharCode && lastCharCode <= 90) ||
                                                                        (97 <= lastCharCode && lastCharCode <= 122))) {
                                                                        $("#schedule_name").val(schedule_name.substring(0, schedule_name.length - 1));
                                                                    }
                                                                });

                                                            </script>

                                                        </div>
                                                    </div>

                                                    <br/>


<style type="text/css">

div.top{
        display: inline-block;
    }


    .top .check_val{
        display: inline-block;
        margin-left: 5px;
    }

    .below .check_val{
        display: inline-block;
        margin-left: 0px;
    }

@media (min-width:768px){

    

    .sp1 {
        width: 70px !important;
        display: inline-block !important;
    }

    .below{
        position: absolute;
   /*  margin-top: -145px; */
        left: 48%;
        display: inline-block;
        margin-left: 0px;
    }

    .test{
        display: inline-block !important;
    margin-left: 0px !important;
    }

}

 .fieset{
 
 width: 100%;
 
 }


@media (min-width:768px) and (max-width:979px){
 /*    .sp1 {
 width: 158px;
 display: block !important;
 margin-bottom: 5px !important;
 }
 
 .test{
 display: block !important;
 margin-left: 0px !important;
 } */

}
@media (min-width:1200px){
   /*   .sp1 {
       width: 60px;
       min-width: 80px !important;
   } */



}
@media (min-width:476px) and (max-width:768px){
    .sp1 {/* 
    width: 158px !important;
    display: block !important;
    margin-bottom: 5px !important; */
}
.below,.below_or,.test{/* 
        display: block !important;
    margin-left: 0px !important; */

}
}


.top_or,.below,.below_or{
        display: inline-block;
    margin-left: 10px;
}
.test{
    display: inline-block;
    margin-left: 10px;
    padding-left: 15px;
}
@media (max-width: 768px){

.sp1 {
    width: 100% !important;
    display: inline-block !important;
}

.test{
    display: block;
    margin-left: 0px;
    padding-left: 0px;
}
.top_or{
        position: initial;
        margin-left: 0px;
        display: inline-block;
}
.below_or{
    position: absolute;
    /* margin-top: -145px; */
    left: 48%;
    display: inline-block;
    margin-left: 0px;
}
.below{
        position: absolute;
   /*  margin-top: -145px; */
    right: 6% !important;
    display: inline-block;
    margin-left: 0px;
}
}
</style>




                                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                   
                                                </div>

                                                <div class="widget-content table_response" id="">


                                                    <div style="overflow-x:auto;" >
                                                        <table data-tablesaw-mode="columntoggle" class="table table-striped table-bordered tablesaw" >
                                                            <thead>

                                                            <tr>
                                                                <th  scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Days</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Power Option</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Customized Power Option</th>

                                                            </tr>

                                                            </thead>

                                                            <tbody>

                                                            <tr>

                                                            <td class="mini_td">
                                                                <label class="" for="gt_mvnx">Monday</label>
                                                            </td>

                                                   <!--  <div class="control-group" id="feild_gp_taddg_divt">
                                                       
                                                       <div class="controls "> -->
                                                       <!--  <div class="top">
                                                           <input type="radio" name="mon_all" id="mon_all" value="on" ><div class="check_val">Always On</div>
                                                       </div>
                                                       
                                                           <div style="" class="below">
                                                           <input type="radio" name="mon_all" id="mon_close" value="off"> <div class="check_val">Always Off</div></div> -->

                                                           <td>

                                                          <!--  <div class="ss">
                                                             <div class="radio-wrapper">
                                                               <input value="on" type="radio" name="mon_all" class="yes hide_rad" checked id="mon_all" />
                                                          
                                                               <label for="radio-yes">ON</label>
                                                          
                                                               <input type="radio" id="mon_custom" disabled="disabled" name="mon_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                               <label for="radio-neutral"></label>
                                                          
                                                          
                                                               <input value="off" type="radio" name="mon_all" class="no hide_rad" id="mon_close" style="margin-left: 76px;" />
                                                               <label for="radio-no">OFF</label>
                                                             </div>
                                                           </div> -->

                                                           <select class="select_days" name="mon_all" id="mon_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Mon"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Mon"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Mon"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>

                                                            <td id="mon_td">
                                                           <style>
                                                           
                                                           .test{margin-right: 10px; }
                                                           @media screen and (min-width: 970px) {
                                                            .test1{
                                                            display: inline-block !important; margin-left: 0px !important 
   															}
                                                       	 }
                                                     
                                                            .test1{
                                                            display: none; 
   															}
                                                       	 
                                                           </style>

                                                            <!-- <div class="top_or">or</div> -->  <div class="test" >From:</div>
                                                            <select name="mon_from1" id="mon_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][fromVal] == $val){
                                                                        $mon_from_sel = 'selected';
                                                                    }else{
                                                                        $mon_from_sel = '';
                                                                    }


                                                                    echo '<option '.$mon_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select  name="mon_from2" id="mon_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="mon_to1" id="mon_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][toVal] == $val){
                                                                        $mon_to_sel = 'selected';
                                                                    }else{
                                                                        $mon_to_sel = '';
                                                                    }


                                                                    echo '<option '.$mon_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="mon_to2" id="mon_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Mon][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select> <!-- <div class="below_or">or</div> -->
                                                            <div id="mon_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>

                                                            </td>
                                                            </tr>
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                    <!-- <div class="control-group" id="feild_gdp_tag_divt"> -->
                                                    <tr>
                                                    <td class="mini_td">
                                                        <label class="" for="gt_mvnx">Tuesday</label>
                                                    </td>
                                                        <!-- <div class="controls "> -->
                                                        <!-- <div class="top">
                                                            <input type="radio" name="tue_all" id="tue_all" value="on"><div class="check_val">Always On</div>
                                                        </div>
                                                            <div class="below">
                                                            <input type="radio" name="tue_all" id="tue_close" value="off"> <div class="check_val">Always Off</div></div> -->

                                                            <td>

                                                            <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="tue_all" class="yes hide_rad" checked id="tue_all" />
                                                            
                                                                <label for="radio-yes">ON</label>
                                                            
                                                                <input type="radio" id="tue_custom" disabled="disabled" name="tue_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
                                                            
                                                            
                                                                <input value="off" type="radio" name="tue_all" class="no hide_rad" id="tue_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->

                                                            <select class="select_days" name="tue_all" id="tue_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Tue"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Tue"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Tue"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>
                                                            <!-- <div class="top_or">or</div> -->  

                                                            <td id="tue_td"><div class="test">From:</div>
                                                            <select name="tue_from1" id="tue_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][fromVal] == $val){
                                                                        $tue_from_sel = 'selected';
                                                                    }else{
                                                                        $tue_from_sel = '';
                                                                    }


                                                                    echo '<option '.$tue_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="tue_from2" id="tue_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="tue_to1" id="tue_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][toVal] == $val){
                                                                        $tue_to_sel = 'selected';
                                                                    }else{
                                                                        $tue_to_sel = '';
                                                                    }


                                                                    echo '<option '.$tue_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="tue_to2" id="tue_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Tue][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><!-- <div class="below_or">or</div> -->
                                                            
                                                            <div id="tue_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                           
                                                            </td>
                                                            </tr>
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                    <!-- <div class="control-group" id="feild_gpd_tag_divt"> -->
                                                    <tr>
                                                    <td class="mini_td">
                                                        <label class="" for="gt_mvnx">Wednesday</label>
                                                        </td>
                                                        <!-- <div class="controls "> -->
                                                        <!-- <div class="top">
                                                            <input type="radio" name="wed_all" id="wed_all" value="on"><div class="check_val">Always On</div>
                                                        </div>
                                                            <div class="below">
                                                            <input type="radio" name="wed_all" id="wed_close" value="off"> <div class="check_val">Always Off</div></div> -->

                                                            <td>

                                                            <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="wed_all" class="yes hide_rad" checked id="wed_all" />
                                                            
                                                                <label for="radio-yes">ON</label>
                                                            
                                                                <input type="radio" id="wed_custom" disabled="disabled" name="wed_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
                                                            
                                                            
                                                                <input value="off" type="radio" name="wed_all" class="no hide_rad" id="wed_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->


                                                            <select class="select_days" name="wed_all" id="wed_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Wed"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Wed"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Wed"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>
                                                            <td id="wed_td">

                                                            <!-- <div class="top_or">or</div> -->  <div class="test">From:</div>
                                                            <select name="wed_from1" id="wed_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][fromVal] == $val){
                                                                        $wed_from_sel = 'selected';
                                                                    }else{
                                                                        $wed_from_sel = '';
                                                                    }


                                                                    echo '<option '.$wed_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="wed_from2" id="wed_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="wed_to1" id="wed_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][toVal] == $val){
                                                                        $wed_to_sel = 'selected';
                                                                    }else{
                                                                        $wed_to_sel = '';
                                                                    }


                                                                    echo '<option '.$wed_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="wed_to2" id="wed_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Wed][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><!-- <div class="below_or">or</div> -->
                                                            
                                                            <div id="wed_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                           
                                                            </td>
                                                            </tr>
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                    <!-- <div class="control-group" id="feild_dgp_tag_divt"> -->
                                                    <tr>
                                                    <td class="mini_td">
                                                        <label class="" for="gt_mvnx">Thursday</label>

                                                        </td>
                                                        <!-- <div class="controls "> -->
                                                        <!-- <div class="top">
                                                            <input type="radio" name="thu_all" id="thu_all" value="on"><div class="check_val">Always On</div>
                                                        </div>
                                                            <div class="below">
                                                            <input type="radio" name="thu_all" id="thu_close" value="off"> <div class="check_val">Always Off</div></div> -->

                                                            <td>

                                                            <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="thu_all" class="yes hide_rad" checked id="thu_all" />
                                                            
                                                                <label for="radio-yes">ON</label>
                                                            
                                                                <input type="radio" id="thu_custom" disabled="disabled" name="thu_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
                                                            
                                                            
                                                                <input value="off" type="radio" name="thu_all" class="no hide_rad" id="thu_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->

                                                            <select class="select_days" name="thu_all" id="thu_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Thu"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Thu"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Thu"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>

                                                            <!-- <div class="top_or">or</div> -->  

                                                            <td id="thu_td">
                                                            <div class="test">From:</div>
                                                            <select name="thu_from1" id="thu_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][fromVal] == $val){
                                                                        $thu_from_sel = 'selected';
                                                                    }else{
                                                                        $thu_from_sel = '';
                                                                    }


                                                                    echo '<option '.$thu_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select name="thu_from2" id="thu_from2" class="sp1 mini_select">
                                                            <select name="thu_from2" id="thu_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][From] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="thu_to1" id="thu_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][toVal] == $val){
                                                                        $thu_to_sel = 'selected';
                                                                    }else{
                                                                        $thu_to_sel = '';
                                                                    }


                                                                    echo '<option '.$thu_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="thu_to2" id="thu_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Thu][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><!-- <div class="below_or">or</div> -->
                                                            
                                                            <div id="thu_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                           
                                                            </td>
                                                            </tr>
                                                       <!--  </div> -->
                                                    <!-- </div> -->
                                                   <!--  <div class="control-group" id="feildd_gp_tag_divt"> -->

                                                   <tr>
                                                   <td class="mini_td">
                                                        <label class="" for="gt_mvnx">Friday</label>

                                                    </td>
                                                        <!-- <div class="controls "> -->
                                                        <!-- <div class="top">
                                                            <input type="radio" name="fri_all" id="fri_all" value="on"><div class="check_val">Always On</div>
                                                        </div>
                                                            <div class="below">
                                                            <input type="radio" name="fri_all" id="fri_close" value="off"> <div class="check_val">Always Off</div></div> -->
                                                            <td>

                                                            <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="fri_all" class="yes hide_rad" checked id="fri_all" />
                                                            
                                                                <label for="radio-yes">ON</label>
                                                            
                                                                <input type="radio" id="fri_custom" disabled="disabled" name="fri_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
                                                            
                                                            
                                                                <input value="off" type="radio" name="fri_all" class="no hide_rad" id="fri_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->

                                                            <select class="select_days" name="fri_all" id="fri_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Fri"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Fri"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Fri"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>

                                                            <!-- <div class="top_or">or</div> -->  

                                                            <td id="fri_td">
                                                            <div class="test">From:</div>
                                                            <select name="fri_from1" id="fri_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][fromVal] == $val){
                                                                        $fri_from_sel = 'selected';
                                                                    }else{
                                                                        $fri_from_sel = '';
                                                                    }


                                                                    echo '<option '.$fri_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="fri_from2" id="fri_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="fri_to1" id="fri_to1" class="sp1 mini_select">>
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][toVal] == $val){
                                                                        $fri_to_sel = 'selected';
                                                                    }else{
                                                                        $fri_to_sel = '';
                                                                    }


                                                                    echo '<option '.$fri_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="fri_to2" id="fri_to2" class="sp1 mini_select">>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Fri][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><!-- <div class="below_or">or</div> -->
                                                            
                                                            <div id="fri_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                           
                                                            </td>
                                                            </tr>

                                                       <!--  </div> -->
                                                    <!-- </div> -->
                                                   <!--  <div class="control-group" id="feild_dgp_tag_divt"> -->
                                                   <tr>
                                                   <td class="mini_td">
                                                        <label class="" for="gt_mvnx">Saturday</label>
                                                    </td>
                                                       <!--  <div class="controls "> -->
<!--                                                         <div class="top">
    <input type="radio" name="sat_all" id="sat_all" value="on"><div class="check_val">Always On</div>
</div>
    <div class="below">
    <input type="radio" name="sat_all" id="sat_close" value="off"> <div class="check_val">Always Off</div></div> -->

    <td>

    <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="sat_all" class="yes hide_rad" checked id="sat_all" />
    
                                                                <label for="radio-yes">ON</label>
    
                                                                <input type="radio" id="sat_custom" disabled="disabled" name="sat_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
    
    
                                                                <input value="off" type="radio" name="sat_all" class="no hide_rad" id="sat_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->

                                                            <select class="select_days" name="sat_all" id="sat_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sat"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sat"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sat"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>
                                                            <!-- <div class="top_or">or</div> -->  

                                                            <td id="sat_td">
                                                            <div class="test">From:</div>
                                                            <select name="sat_from1" id="sat_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][fromVal] == $val){
                                                                        $sat_from_sel = 'selected';
                                                                    }else{
                                                                        $sat_from_sel = '';
                                                                    }


                                                                    echo '<option '.$sat_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="sat_from2" id="sat_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="sat_to1" id="sat_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][toVal] == $val){
                                                                        $sat_to_sel = 'selected';
                                                                    }else{
                                                                        $sat_to_sel = '';
                                                                    }


                                                                    echo '<option '.$sat_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="sat_to2" id="sat_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sat][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><!-- <div class="below_or">or</div> -->
                                                            
                                                            <div id="sat_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                           
                                                            </td>
                                                            </tr>
                                                       <!--  </div> -->
                                                    <!-- </div> -->
                                                    <!-- <div class="control-group" id="feidld_gp_tag_divt"> -->
                                                    <tr>
                                                    <td class="mini_td" >
                                                        <label class="" for="gt_mvnx">Sunday</label>

                                                        </td>
                                                        <!-- <div class="controls "> -->
                                                           <!--  <div class="top">
                                                               <input type="radio" name="sun_all" id="sun_all" value="on"><div class="check_val">Always On</div>
                                                           </div>
                                                           <div class="below">
                                                           <input type="radio" name="sun_all" id="sun_close" value="off"> <div class="check_val">Always Off</div></div> -->

                                                           <td>

                                                           <!-- <div class="ss">
                                                              <div class="radio-wrapper">
                                                                <input value="on" type="radio" name="sun_all" class="yes hide_rad" checked id="sun_all" />
                                                           
                                                                <label for="radio-yes">ON</label>
                                                           
                                                                <input type="radio" id="sun_custom" disabled="disabled" name="sun_all" class="neutral hide_rad" id="radio-neutral" style="margin-left: 40px;" />
                                                                <label for="radio-neutral"></label>
                                                           
                                                           
                                                                <input value="off" type="radio" name="sun_all" class="no hide_rad" id="sun_close" style="margin-left: 76px;" />
                                                                <label for="radio-no">OFF</label>
                                                              </div>
                                                            </div> -->

                                                             <select class="select_days" name="sun_all" id="sun_all">
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sun"]["po"]== "ON"){ echo "selected"; } ?> value="on">Always On</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sun"]["po"]== "OFF"){ echo "selected"; } ?> value="off">Always Off</option>
                                                               <option <?php if(isset($_GET["edit_schedule"]) && $edit_sched_ar["Sun"]["po"]== "CUS"){ echo "selected"; } ?> value="custom">Customized</option>
                                                           </select>

                                                            </td>

                                                            <!-- <div class="top_or">or</div> -->  

                                                            <td id="sun_td">
                                                            <div class="test">From:</div>
                                                            <select name="sun_from1" id="sun_from1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    echo $edit_sched_ar[Sun][fromVal] . $val;

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][fromVal] == $val){
                                                                        $sun_from_sel = 'selected';
                                                                    }else{
                                                                        $sun_from_sel = '';
                                                                    }


                                                                echo '<option '.$sun_from_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="sun_from2" id="sun_from2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][from] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][from] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                            </select><div class="test">To:</div>
                                                            <select name="sun_to1" id="sun_to1" class="sp1 mini_select">
                                                                <?php for($i=1;$i<13;$i++){

                                                                    $val= sprintf('%02d', $i);

                                                                    if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][toVal] == $val){
                                                                        $sun_to_sel = 'selected';
                                                                    }else{
                                                                        $sun_to_sel = '';
                                                                    }


                                                                    echo '<option '.$sun_to_sel.' value="'.$val.'">'.$val.'</option>';

                                                                } ?>
                                                            </select>
                                                            <select name="sun_to2" id="sun_to2" class="sp1 mini_select">
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][to] == 'AM'){echo "selected"; } ?> value="AM">AM</option>
                                                                <option <?php if(isset($_GET['edit_schedule']) && $edit_sched_ar[Sun][to] == 'PM'){echo "selected"; } ?> value="PM">PM</option>
                                                               <!--  <option value="30">30</option>
                                                               <option value="45">45</option> -->
                                                            </select><!-- <div class="below_or">or</div> -->
                                                           
                                                            <div id="sun_err" style="display: none" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>Invalid time</p></div>
                                                            </td>
                                                            </tr>
                                                            </tbody>
                                                            </table>
                                                            </div>
                                                            </div>
                                                            </div>
                                                        <!-- </div> -->
                                                    <!-- </div> -->
                                                    <input type="hidden" name="schedule_submit_secret" value="<?php echo $_SESSION['FORM_SECRET']?>">
                                                    <div class="form-actions">

                                                        <button type="submit" disabled="disabled" name="schedule_submit" id="schedule_submit"  class="btn btn-primary">Set</button>

                                                    </div>



                                                </fieldset>
                                            </form>
                                            <script>
                                                //



//mon

                                                    function CheckValues(res,res1,res2,res3){

                                                        //alert(res);
                                                        var check_disable;



                                                        /* switch (res2) {

                                                            case '12':

                                                                if(res=='from1'){
                                                                    $('#'+res3+'_from2').val('PM');
                                                                }
                                                                else{
                                                                    $('#'+res3+'_to2').val('PM');
                                                                }
                                                                
                                                                break;    
                                                            
                                                            case 'AM':

                                                                if(res=='from2'){

                                                                    if($('#'+res3+'_from1').val()=='12'){
                                                                        $('#'+res3+'_from1').val('00');
                                                                    }

                                                                }
                                                                else{
                                                                    
                                                                    if($('#'+res3+'_to1').val()=='12'){
                                                                        $('#'+res3+'_to1').val('00');
                                                                    }
                                                                }
                                                                
                                                                break;
                                                            
                                                            case 'PM':

                                                                if(res=='from2'){

                                                                    if($('#'+res3+'_from1').val()=='00'){
                                                                        $('#'+res3+'_fSrom1').val('12');
                                                                    }
                                                                }
                                                                else{
                                                                    if($('#'+res3+'_to1').val()=='00'){
                                                                        $('#'+res3+'_to1').val('12');
                                                                    }
                                                                }
                                                                
                                                                break;

                                                            default:
                                                                break;
                                                        } */

                                                       


                                                        check_disable = 1;

                                                        $('#schedule_submit').attr("disabled", true);

                                                        var arrr = ['mon','tue','wed','thu','fri','sat','sun'];

                                                        for(var i=0;i<7;i++){
                                                            var ele_1 = arrr[i];
                                                            /* $('#'+ele_1+'_err').html(''); */
                                                            $('#'+ele_1+'_err').hide();
                                                            if($('#'+ele_1+'_all').val()=='on') {
                                                                //console.log('1');
                                                                

                                                            }
                                                            else if($('#'+ele_1+'_all').val()=='off') {
                                                                //console.log('2');
                                                               
                                                            }
                                                            else{

                                                                //alert();
                                                                $('#'+ele_1+'_td select.sp1').attr('disabled', false);
                                                                /*var start = $('#'+ele_1+'_from1').val()+$('#'+ele_1+'_from2').val();
                                                                var end = $('#'+ele_1+'_to1').val()+$('#'+ele_1+'_to2').val();*/

                                                                var int_start = $('#'+ele_1+'_from1').val();
                                                                var int_end = $('#'+ele_1+'_to1').val();

                                                             /*    if(int_start=='00'){
                                                                    int_start = 24;
                                                                }

                                                                if(int_end=='00'){
                                                                    int_end = 24;
                                                                } */


                                                                if($('#'+ele_1+'_from2').val()=='PM'){

                                                                    if(int_start!=12){
                                                                        int_start = parseInt(int_start) + 12;
                                                                    }
                                                                    
                                                                }
                                                                else{
                                                                    if(int_start==12){
                                                                        int_start = parseInt(int_start) - 12;
                                                                    }
                                                                }

                                                                if($('#'+ele_1+'_to2').val()=='PM'){

                                                                    if(int_end!=12){
                                                                        int_end = parseInt(int_end) + 12;
                                                                    }
                                                                   

                                                                }
                                                                else{
                                                                    if(int_end==12){
                                                                        int_end = parseInt(int_end) + 12;
                                                                    }
                                                                }

                                                                var start = int_start;
                                                                var end = int_end;

                                                                if((parseInt(end) - parseInt(start))>=24){
                                                                    $('#'+ele_1+'_err').css('display', 'inline-block');
                                                               
                                                                    /*return false;*/
                                                                    check_disable = 0;
                                                                }

                                                                if(parseInt(end)>=2400){
																/* $('#'+ele_1+'_err').html('<p>Invalid time</p>'); */
                                                                $('#'+ele_1+'_err').css('display', 'inline-block');
                                                               
                                                                    /*return false;*/
                                                                    check_disable = 0;
                                                                }

                                                                if(parseInt(start)<parseInt(end)){
                                                                    //console.log('pass');
                                                                }
                                                                else{
                                                                    //console.log('fail');
																if(parseInt(start)>parseInt(end)){
																	if((res == 'to1') || (res == 'to2')){

                                                                        if($('#'+ele_1+'_to1').val()!='00'){

																		/* $('#'+ele_1+'_err').html('<p>Invalid time</p>'); */
																		$('#'+ele_1+'_err').css('display', 'inline-block');
                                                                        }
																	}
																	else{
																	if((end != '0000')){

                                                                        if($('#'+ele_1+'_to1').val()!='00'){

																		/* $('#'+ele_1+'_err').html('<p>Invalid time</p>'); */
																		$('#'+ele_1+'_err').css('display', 'inline-block');
                                                                         }
																	}
																	}
																}
                                                                    /*return false;*/
                                                                    /* $('#'+ele_1+'_err').html('<p>Invalid time</p>'); */
                                                                    $('#'+ele_1+'_err').css('display', 'inline-block');
                                                                    check_disable = 0;

                                                                }


                                                            }
                                                        }

                                                        if($('#schedule_name').val()==''){
                                                            return false;
                                                        }

                                                        <?php if(!isset($_GET['edit_schedule'])){ ?>
                                                        if(!validateShedulname($('#schedule_name').val())){
                                                            return false;
                                                        }
                                                        <?php } ?>



                                                        //console.log('success');

                                                        if(check_disable != 0){
                                                            $('#schedule_submit').attr("disabled", false);
                                                        }
                                                        


                                                    }
//mon
                                                $(document).ready(function(){

                                                    $('select.sp1').attr('disabled', true);

                                                    $(".select_days").change(function(e){


                                                        var res = e.target.id.split('_');
                                                        // console.log(res[0]);
                                                        $("#"+res[0]+"_from1").val('12');
                                                        $("#"+res[0]+"_from2").val('AM');
                                                        $("#"+res[0]+"_to1").val('12');
                                                        $("#"+res[0]+"_to2").val('AM');

                                                        if($('#'+res[0]+'_all').val()=='custom') {

                                                            $('#'+res[0]+'_td select.sp1').attr('disabled', false);

                                                        }
                                                        else{
                                                            $('#'+res[0]+'_td select.sp1').attr('disabled', true);
                                                        }

                                                        

                                                        CheckValues(res[1],'test','test1','test2');

                                                    });


                                                    $('#schedule_name').on('keyup change', function(event) {

                                                       CheckValues('to2','test','test1','test2');

                                                    });



                                                    $(".sp1").change(function(e){
                                                        var res = e.target.id.split('_');
                                                        /*$("#"+res[0]+"_all").prop('checked', false);
                                                        $("#"+res[0]+"_close").prop('checked', false);*/

                                                        /*$("#"+res[0]+"_custom").prop('checked', true);*/
                                                        //console.log(res[0]);
                                                        //console.log('2');

                                                        var sp_value = $(this).val();
                                                        

                                                        CheckValues(res[1],'sp1',sp_value,res[0]);


                                                    });


                                                });



                                            </script>
      <script>
          $(document).ready(function() {
              //alert()
              CheckValues('to1','test','test1','test2');
          });
      </script>



                                            <h2>My <?php echo _POWER_SCHEDULE_NAME_; ?>Schedules</h2>
                                            <p>Choose which <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule you would like to activate from the list below. If you do not select a <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule, then your SSID will be configured to "Always On" unless otherwise specified.</p>
                                            </br>



                                            <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Active <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule</h3>
                                                </div>

                                                <div class="widget-content table_response" id="schedule_tbl">


                                                    <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered" >
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Days</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Hours</th>

                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                            $status_code="0";
                                                            $schedule_API_sesponce=$wag_obj->retrieveSchedulelist($zone_id);
                                                            parse_str($schedule_API_sesponce);
                                                            if($status_code==200){

                                                                $create_log->save('3009','get zone Schedules',$zone_id.$schedule_API_sesponce);
                                                                //mysql_query("DELETE FROM `exp_distributor_network_schedul` WHERE `distributor_id` ='$user_distributor'");
                                                                //print_r( $Description );
                                                                $Description=(array)json_decode(urldecode($Description));
                                                                $schedule_list_count=$Description['totalCount'];
                                                                
                                                                
                                                                
                                                                print_r($listru);
                                                                $day_arr=array('sun' => 'Sunday',
                                                                    'mon' => 'Monday',
                                                                    'tue' => 'Tuesday',
                                                                    'wed' => 'Wednesday',
                                                                    'thu' => 'Thursday',
                                                                    'fri' => 'Friday',
                                                                    'sat' => 'Saturday'
                                                                );

                                                                reset($day_arr);
                                                                $db_data_array_name="db_array";
                                                                
                                                                $comearry=array();

                                                                $js_ar_string='';
                                                                
                                                                for($x=0;$x<$schedule_list_count;$x++){


                                                                    //genarate_array_name
                                                                    $db_data_array=$db_data_array_name.$x;

                                                                    $$db_data_array = Array("mon"=>Array(),"tue"=>Array(),"wed"=>Array(),"thu"=>Array(),"fri"=>Array(),"sat"=>Array(),"sun"=>Array());

                                                                    $schedule_array=$$db_data_array;

                                                                    $list=(array)$Description['list'][$x];
                                                                    //print_r($list);
                                                                    $new_schedule_id=$list[id];
                                                                    $new_schedule_zid=$list[zoneId];
                                                                    $new_schedule_name=$list[name];
                                                                    $new_schedule_des=$list[description];

                                                                    $js_ar_name_ar=explode('-',$new_schedule_name);
                                                                    $js_ar_name_str=$js_ar_name_ar[0];

                                                                    $js_ar_string.='"'.$js_ar_name_str.'",';
                                                                    //echo $x.' ';
                                                                    
                                                                    array_push($comearry,$new_schedule_id);

                                                                    //time convert loop
                                                                    foreach($day_arr as $key=>$val ) {
                                                                        //echo $key;

                                                                        $day_time_count=count($list[$key]);

                                                                        for($y=0;$y<$day_time_count;$y++) {

                                                                            $day_time = explode("-", $list[$key][$y]);
                                                                            $day_time_start = $day_time[0];
                                                                            //echo"*".$day_time_start."/".$x.$y;
                                                                            $day_time_end = $day_time[1];
                                                                            //echo"*".$day_time_end."/".$x.$y;

                                                                            //convert timezone;
                                                                            timeComvert($user_time_zone,$user_time_zone,$day_time_start,$day_time_end,$schedule_array,$key);
                                                                        }
                                                                    }

                                                                    $shedule_exists=$db->getValueAsf("SELECT `uniqu_name` AS f FROM `exp_distributor_network_schedul` WHERE `uniqu_name`='$new_schedule_name' GROUP BY`uniqu_name`");


                                                                    //insert to db
                                                                        //print_r($$db_data_array);
                                                                    foreach($day_arr as $key=>$val ) {
                                                                        $power_times="";
                                                                        //echo $key;
                                                                        $power_times_r=$schedule_array[$key];
                                                                        //print_r($power_times_r);
                                                                        foreach($power_times_r as $time_range){
                                                                            $power_times.=$time_range.",";
                                                                        }
                                                                        $power_times=rtrim($power_times," ,");
                                                                        //echo $power_times;
                                                                        //$$db_data_array[$key]
                                                                        if ($shedule_exists != "") {
                                                                            $ins_q = "UPDATE `exp_distributor_network_schedul`
                                                                                        SET `active_fulltime`='$power_times'

                                                                                        WHERE `uniqu_name`='$new_schedule_name' AND `uniqu_id`='$new_schedule_id' AND `day`='$val'";
                                                                        } else {

                                                                            $ins_q = "INSERT INTO `exp_distributor_network_schedul`
                                                                                    (`uniqu_id`,`uniqu_name`,`schedul_name`,`is_enable`,`schedul_description`,`network_method`,`distributor_id`,`day`,`active_fulltime`,`from`,`to`,`create_user`,`create_date`)
                                                                                VALUES	('$new_schedule_id','$new_schedule_name','$new_schedule_name','0','$new_schedule_des','','$user_distributor','$val','$power_times','','','$user_name',NOW())";
                                                                        }
                                                                            $db->execDB($ins_q);
                                                                    }
                                                                    //print_r($$db_data_array);
                                                                   // $$db_data_array="";

                                                                }

                                                                //
                                                                
                                                                
                                                               // print_r($comearry);
                                                                
                                                                $a2=$comearry;
                                                                
                                                                 $sql = "SELECT DISTINCT uniqu_id FROM `exp_distributor_network_schedul` WHERE `distributor_id` = '$user_distributor'";
                                                                
                                                                $result_array_1 = $db->selectDB($sql);
                                                                
                                                                $types=array();
                                                                
                                                                
                                                                foreach ($result_array_1['data'] AS $rowx) {	

                                                                	array_push($types,$rowx['uniqu_id']);
                                                                	
                                                                }
                                                                
                                                               // print_r($types);
                                                                
                                                                $result_array=array_diff($types,$a2);
                                                                
                                                                foreach ($result_array as $keyq => $valq){
                                                                	 $db->execDB("DELETE FROM exp_distributor_network_schedul WHERE `uniqu_id` = '$valq'");
                                                                }
                                                                
                                                                
                                                            }
                                                            $js_ar_string=rtrim($js_ar_string,',');

                                                            $get_schedule_names_q="SELECT `id` ,`uniqu_id`,`schedul_name`,`is_enable` FROM `exp_distributor_network_schedul`
                                                                                WHERE `distributor_id`='$user_distributor' GROUP BY `schedul_name`";
                                                            $get_schedule_names=$db->selectDB($get_schedule_names_q);
                                                            
                                                            foreach ($get_schedule_names['data'] AS $schedule_names) {

                                                                $is_enable_schedule=$schedule_names['is_enable'];
                                                                $id_schedule=$schedule_names['id'];
                                                                $display_power_s_name=explode('-',$schedule_names['schedul_name']);
                                                                echo '<tr style="font-weight: bold; border-top: dashed">
                                                                        <td colspan="3">'.$display_power_s_name[0].'</td></tr>';

                                                                  if($is_enable_schedule=="1" ){
                                                                      $dl_button_class='warning';
                                                                      $dl_button_icon='icon-lock';
                                                                      $checked='checked';

                                                                  }elseif($is_enable_schedule=="0" ){
                                                                    $dl_button_class='danger';
                                                                    $dl_button_icon='icon-remove-circle';
                                                                    $checked="";
                                                                    }elseif($is_enable_schedule=="2"){
                                                                      $dl_button_class='warning';
                                                                      $dl_button_icon='icon-lock';
                                                                      $checked="";
                                                                  }


                                                                $schedule_active_q="SELECT `day`,`active_fulltime`,`from`,`to` FROM `exp_distributor_network_schedul`
                                                                                  WHERE `uniqu_name`='$schedule_names[schedul_name]' AND `distributor_id`='$user_distributor'";

                                                                $schedule_active=$db->selectDB($schedule_active_q);
                                                                $uniqe_shedul_row_id=0;
                                                                
                                                                foreach ($schedule_active['data'] AS $schedule) {
                                                                    if($uniqe_shedul_row_id==0){
                                                                        ?>
                                                                <!-- ----------------------------------- -->
                                                                <tr>
                                                                    <td>

                                                                    

                                                                    <div class="toggle1">

                                                                        <input class="hide_checkbox" <?php echo $checked; ?> type='checkbox' name="is_enable_<?php echo$schedule_names[schedul_name];?>" >

                                                                        <?php
                                                                    if ($checked=="checked") {
                                                                        ?>

                                                                        <span class="toggle1-on">ON</span>
                                                                        <a id="is_enable_<?php echo$schedule_names[id];?>"><span style="cursor: pointer" class="toggle1-off-dis">OFF</span></a>

                                                                        <?php }else{ ?>

                                                                            <a id="is_enable_<?php echo$schedule_names[id];?>"><span style="cursor: pointer" class="toggle1-on-dis">ON</span></a>
                                                                        <span class="toggle1-off">OFF</span>

                                                                        <?php } ?>

                                                                    </div>

                                                                    

                                                                    <?php
                                                                    if ($checked=="checked") {
                                                                        ?>

                                                                        <script type="text/javascript">
                                                                            $(document).ready(function() {



                                                                                $("#is_enable_<?php echo$schedule_names[id];?>").easyconfirm({locale: {
                                                                                    title: 'Deactivate',
                                                                                    text: 'Are you sure you want to deactivate this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule?',
                                                                                    button: ['Cancel',' Confirm'],
                                                                                    closeText: 'close'
                                                                                }
                                                                                });
                                                                                $("#is_enable_<?php echo$schedule_names[id];?>").click(function() {
                                                                                    scheduleStatusChange<?php echo$schedule_names[id];?>(false);
                                                                                });
                                                                            });
                                                                        </script>
                                                                    <?php }
                                                                    else{ ?>

                                                                        <script type="text/javascript">
                                                                            $(document).ready(function() {

                                                                                $("#is_enable_<?php echo$schedule_names[id];?>").easyconfirm({locale: {
                                                                                    title: 'Activate',
                                                                                    text: 'Are you sure you want to activate this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule?',
                                                                                    button: ['Cancel',' Confirm'],
                                                                                    closeText: 'close'
                                                                                }
                                                                                });
                                                                                $("#is_enable_<?php echo$schedule_names[id];?>").click(function() {
                                                                                    scheduleStatusChange<?php echo$schedule_names[id];?>(true);
                                                                                });
                                                                            });
                                                                        </script>
                                                                    <?php } ?>





                                                                <script>
                                                                    function scheduleStatusChange<?php echo$schedule_names[id];?>(val) {
                                                                        var value=val;
                                                                        /*alert(value);*/
                                                                        if(value){
                                                                            window.location ='?schedule_name=<?php echo urlencode($schedule_names['schedul_name']) ; ?>&schedule_id=<?php echo$schedule_names[uniqu_id]; ?>&scheduleStatusChange=1&t=1&secret=<?php echo $secret; ?>';
                                                                        }else{
                                                                            window.location ='?schedule_name=<?php echo urlencode($schedule_names['schedul_name']) ; ?>&schedule_id=<?php echo$schedule_names[uniqu_id]; ?>&scheduleStatusChange=0&t=1&secret=<?php echo $secret; ?>';
                                                                        }
                                                                    }
                                                                </script>
                                                                    </td>
                                                                <!-- ----------------------------------- -->

                                                                <?php
                                                                    }
                                                                    elseif($uniqe_shedul_row_id==1){

                                                                    echo'<tr><td>';

                                                                if($is_enable_schedule=="0"){
                                                                echo'<a href="javascript:void();" id="SCHEDULE_' . $schedule_names[uniqu_id] . '"  class="btn btn-small btn-'.$dl_button_class.'">
                                                                             <i class="btn-icon-only '.$dl_button_icon.'"></i>&nbsp;Remove</a>';
                                                                ?>
                                                                        <script>
                                                                            $(document).ready(function() {

                                                                                $('#SCHEDULE_<?php echo $schedule_names[uniqu_id]; ?>' ).easyconfirm({locale: {
                                                                                    title: 'Remove',
                                                                                    text: 'Are you sure you want to remove this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule?',
                                                                                    button: ['Cancel',' Confirm'],
                                                                                    closeText: 'close'
                                                                                }
                                                                                });

                                                                                $('#SCHEDULE_<?php echo $schedule_names[uniqu_id]; ?>' ).click(function() {
                                                                                    window.location ='?t=1&schedule_id=<?php echo $schedule_names[uniqu_id];?>&rm_schedule=true&secret=<?php echo $_SESSION['FORM_SECRET']; ?>&schedule_name=<?php echo $display_power_s_name[0]; ?>';
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }else{
                                                                        echo'<a id="SCHEDULE_' . $schedule_names[uniqu_id] . '"  class="not-active btn btn-small btn-'.$dl_button_class.'" disabled >
                                                                             <i class="btn-icon-only '.$dl_button_icon.'"></i>&nbsp;Remove</a>';

                                                                    }

                                                                    echo'</td>';

                                                                    }
                                                                    elseif($uniqe_shedul_row_id==2){

                                                                    echo'<tr><td>';

                                                                if($is_enable_schedule=="0"){
                                                                echo'<a href="javascript:void();" id="SCHEDULE_' . $schedule_names[uniqu_id] . '_EDIT"  class="btn btn-small btn-'.$dl_button_class.'">
                                                                             <i class="btn-icon-only '.$dl_button_icon.'"></i>&nbsp;Edit</a>';
                                                                ?>
                                                                        <script>
                                                                            $(document).ready(function() {

                                                                                $('#SCHEDULE_<?php echo $schedule_names[uniqu_id]; ?>_EDIT' ).easyconfirm({locale: {
                                                                                    title: 'Edit',
                                                                                    text: 'Are you sure you want to edit this <?php echo _POWER_SCHEDULE_NAME_; ?>Schedule?',
                                                                                    button: ['Cancel',' Confirm'],
                                                                                    closeText: 'close'
                                                                                }
                                                                                });

                                                                                $('#SCHEDULE_<?php echo $schedule_names[uniqu_id]; ?>_EDIT' ).click(function() {
                                                                                    window.location ='?t=1&schedule_id=<?php echo $schedule_names[uniqu_id];?>&edit_schedule=true&secret=<?php echo $_SESSION['FORM_SECRET']; ?>';
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <?php
                                                                    }
                                                                    else{
                                                                        echo'<a id="SCHEDULE_' . $schedule_names[uniqu_id] . '_EDIT"  class="not-active btn btn-small btn-'.$dl_button_class.'" disabled >
                                                                             <i class="btn-icon-only '.$dl_button_icon.'"></i>&nbsp;Edit</a>';

                                                                    }

                                                                    echo'</td>';

                                                                    }
                                                                    else{

                                                                        echo'<tr><td></td>';
                                                                    }
                                                                    
                                                                    $splitsche=explode("-",$schedule['active_fulltime']);
                                                                    
                                                                    $coll_split_var=date("g:i A", strtotime( $splitsche[0] )).'-'.date("g:i A", strtotime( $splitsche[1] ));
                                                                    
                                                                    if($schedule['active_fulltime']==''){
                                                                    	
                                                                    	$coll_split_var='';
                                                                    }
                                                                    
                                                                    echo '<td>'.substr($schedule['day'],0,3).'
                                                                 </td><td>'.$coll_split_var;
                                                                    if($schedule['active_fulltime']==''){
                                                                        //echo date("g:i A", strtotime( substr($schedule['from'],0,5) )).'-'.date("g:i A", strtotime( substr($schedule['to'],0,5) ));
                                                                        echo "OFF";
                                                                    }
                                                                    echo'</td></tr>';
                                                                    $uniqe_shedul_row_id++;
                                                                }

                                                            }


                                                            ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php } ?>
 


                                            <!-- Tab 3 End-->
                                        </div>