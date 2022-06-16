
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<style type="text/css">

    @media (max-width: 480px){
        #feild_gp_taddg_divt1 .form-group .net_div{
            width: 100%;
        }

        #feild_gp_taddg_divt1 .net_div .net_div_child:nth-child(1){
            width: 50%;
            margin-bottom: 10px;
        }

    }

    label img{
        margin-left: 10px;
    }

</style>


<div <?php if(isset($tab_guestnet_tab_1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>   id="guestnet_tab_1">
        <!-- Tab 1 start-->
        <?php if(isset($_SESSION['tab7'])){
    echo $_SESSION['tab7'];
    unset($_SESSION['tab7']);
    } ?>





        <div id="guest_modify_network"></div>

        <?php if ($tooltip_enable=='Yes') { ?>

            <h1 class="head container">SSID Name <img data-toggle="tooltip" title="<?php echo $tooltip_arr['SSID_name']; ?>" src="layout/FRONTIER/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h1>
            <!-- <p><b><i>&nbsp;&nbsp;&nbsp;&nbsp;So your guests can easily identify and connect</i></b></p> -->
        <?php } else{ ?>
            <h1 class="head container">SSID Name</h1>
        <?php }?>

        <p>
            Name your network so your guests can easily identify and connect. Select the current SSID name from the dropdown below. Then enter the new name of your Guest <?php echo __WIFI_TEXT__; ?> Network.
        </p>


        <br/>

        <?php if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='NO' ) {

            ?>

            <div class="controls col-lg-5 form-group">
                <a href="?t=guestnet_tab_1&st=guestnet_tab_1&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
            </div>
            <br/>
            </br>

        <?php } ?>


        <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>×</button><strong>


                <?php
                    $no_aps_installed = $message_functions->showMessage('no_aps_installed');;
                    $vars = array(
                        '{$support_number}' => $sup_mobile
                    );

                    $no_aps_installed = strtr($no_aps_installed, $vars);
                    echo $no_aps_installed; 
                ?>

            </strong>
        </div>



        <form id="update_default_qos_table" name="update_default_qos_table" class="form-horizontal" action="?t=guestnet_tab_1" method="post">

            <div class="widget widget-table action-table" >
                <div class="widget-header">
                    <!-- <i class="icon-th-list"></i> -->
                    <h3></h3>
                </div>
                <div class="widget-content table_response" id="ssid_tbl">
                    <div style="overflow-x:auto;" >
                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                            <thead>
                            <tr>

                                <!-- <th>AP MAC Address</th> -->
                                <!--    <th>WLAN Name</th>  -->
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Guest SSID</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Location Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Service Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /* $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id`, l.`group_tag`
                                       FROM `exp_locations_ssid` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d,`exp_locations_ap_ssid` l
                                     WHERE s.`distributor`=d.`distributor_code`
                                     AND s.`distributor`= a.`distributor_code`
                                     AND a.`ap_code`=l.`ap_id`
                                     AND s.`distributor`='$user_distributor'
                                     AND l.`distributor`='$user_distributor'
                                 --    GROUP  BY  a.`ap_code`
                             GROUP  BY   s.`ssid`";  */

                            $all_na = 0;

                            $ssid_q="SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id` ,d.`verification_number` as 'group_tag', count(DISTINCT a.`ap_code`) AS ap_count ,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                FROM
                                                                `exp_mno_distributor` d
                                                                LEFT JOIN
                                                                `exp_locations_ssid` s
                                                                ON s.`distributor`=d.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_mno_distributor_aps` a
                                                                ON s.`distributor`= a.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ap_ssid` l
                                                                ON a.`ap_code`=l.`ap_id`

                                                                WHERE  d.`distributor_code`='$user_distributor'
                                                                GROUP  BY   s.`ssid`";
                            $ssid_res=$db->selectDB($ssid_q);
                            $i=0;

                            if($ssid_res['rowCount'] > 0){

                                
                                foreach ($ssid_res['data'] AS $ssid_name) {
                                    //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                    //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                    //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                    $gorup_tag = $ssid_name['group_tag'];

                                    if(strlen($gorup_tag) < 1){
                                        $location_id = 'N/A';
                                    }else{
                                        $location_id = $gorup_tag;
                                    }

                                    $all_na = $ssid_name['ap_count'];

                                    echo  "<td>".$ssid_name['ssid']."</td>";

                                    echo    "<td>".$location_id."</td>";
                                    echo    "<td>".$ssid_name['bussiness_address1']."&nbsp;,&nbsp;".$ssid_name['bussiness_address2']."&nbsp;".$ssid_name['state_region']."</td>";

                                    echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

                                    echo"</tr>";
                                    //  $ssidName=$ssid_name['ssid'];
                                    //  $wlanId=$ssid_name['wlan_name'];


                                    $i++;
                                }

                                if($all_na == 0){

                                    echo '<style> .all_na{ display: block !important; } </style>';

                                }

                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><br/>

            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="ssid_name">Current SSID Name : </label>
                    <div class="controls col-lg-5 form-group">



                        <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                            <option value="">Select SSID</option>
                            <?php
                            $ssid_q="SELECT s.`ssid`
                                                                                    FROM
                                                                                    `exp_mno_distributor` d
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ssid` s
                                                                                    ON s.`distributor`=d.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_mno_distributor_aps` a
                                                                                    ON s.`distributor`= a.`distributor_code`
                                                                                    LEFT JOIN
                                                                                    `exp_locations_ap_ssid` l
                                                                                    ON a.`ap_code`=l.`ap_id`

                                                                                    WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                    GROUP  BY   s.`ssid`";
                            $ssid_res=$db->selectDB($ssid_q);
                            
                            foreach ($ssid_res['data'] AS $ssid_names) {
                                echo'<option value="'.$ssid_names[ssid].'">'.$ssid_names[ssid].'</option>';
                            }
                            ?>
                        </select>
                        <script>
                            function loadSSIDForm(ssid){

                                /*  alert(ssid);    */
                                var ssid=ssid;
                                var formData={ssid:ssid,dis:"<?php echo $user_distributor; ?>"};
                                $.ajax({
                                    url : "ajax/getSsidDetails.php",
                                    type: "POST",
                                    data : formData,
                                    success: function(data)
                                    {
                                        /*   alert(data);   */
                                        var data_array = data.split(',');

                                        document.getElementById("network_id").value=data_array[1];
                                        document.getElementById("wlan_name").value=data_array[0];
                                    },
                                    error: function (jqXHR, textStatus, errorThrown)
                                    {

                                    }
                                });



                            }
                        </script>
                        <input  id="wlan_name" name="wlan_name" type="hidden" value="" >
                        <input  id="network_id" name="network_id" type="hidden" value="" >


                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="mod_ssid_name">New SSID Name : </label>
                    <div >
                        <div class="controls col-lg-5 form-group">
                            <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" maxlength="32" value="<?php echo ''; ?>">
                            <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer"><p>SSID Name is invalid</p></small>

                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('#mod_ssid_name').bind("cut copy paste", function (e) {
                                        e.preventDefault();
                                    });


                                    $("#mod_ssid_name").keypress(function (event) {
                                        var ew = event.which;
                                        if (ew == 8 || ew == 0 || ew == 45 || ew == 95)
                                            return true;
                                        if (48 <= ew && ew <= 57)
                                            return true;
                                        if (65 <= ew && ew <= 90)
                                            return true;
                                        if (97 <= ew && ew <= 122)
                                            return true;
                                        return false;


                                    });

                                    $("#mod_ssid_name").blur(function (event) {
                                        var temp_ssid_name = $('#mod_ssid_name').val();
                                        if (checkWords(temp_ssid_name.toLowerCase())) {

                                            $("#mod_ssid_name").val("");
                                            $('#invalid_ssid').css('display', 'inline-block');
                                            $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                            $('#update_ssid').attr('disabled', true);
                                        } else {
                                            $('#invalid_ssid').hide();
                                        }
                                    });

                                    $("#mod_ssid_name").keyup(function (event) {

                                        var temp_ssid_name;
                                        temp_ssid_name = $('#mod_ssid_name').val();
                                        var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
                                        var lastCharCode = lastChar.charCodeAt(0);

                                        if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 45 || lastCharCode == 95) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                            (65 <= lastCharCode && lastCharCode <= 90) ||
                                            (97 <= lastCharCode && lastCharCode <= 122))) {
                                            $("#mod_ssid_name").val(temp_ssid_name.substring(0, temp_ssid_name.length - 1));
                                        }

                                        temp_ssid_name = $('#mod_ssid_name').val();
                                        if (checkWords(temp_ssid_name.toLowerCase())) {

                                            $("#mod_ssid_name").val("");
                                            $('#invalid_ssid').css('display', 'inline-block');
                                            $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                            $('#update_ssid').attr('disabled', true);
                                        } else {
                                            $('#invalid_ssid').hide();
                                        }
                                    });


                                    function past() {

                                        setTimeout(function () {

                                            var temp_ssid_name = $('#mod_ssid_name').val();


                                            if (checkWords(temp_ssid_name.toLowerCase())) {

                                                $("#mod_ssid_name").val("");
                                                $('#invalid_ssid').css('display', 'inline-block');

                                                $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");

                                                $('#update_ssid').attr('disabled', true);
                                            } else {
                                                $('#invalid_ssid').hide();
                                            }


                                        }, 100);

                                    }


                                    function checkWords(inword) {

                                        var words =<?php
                                            $words = $db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");
                                            $words_ar = explode(",", $words);
                                            $script_ar = '[';
                                            for ($i = 0; $i < count($words_ar); $i++) {
                                                $script_ar .= "\"" . $words_ar[$i] . "\",";
                                            }

                                            $script_ar = rtrim($script_ar, ",");
                                            $script_ar .= "]";
                                            echo $script_ar;

                                            ?>;

                                        if (words.indexOf(inword) >= 0) {

                                            return true;

                                        }
                                        else {

                                            var regex = /^[a-zA-Z0-9_-]+$/;

                                            if (regex.test(inword) == false) {

                                                $('#update_ssid').attr('disabled', true);
                                            }

                                            return false;

                                        }


                                    }
                                });
                            </script>

                        </div>
                        <br>
                        <small>
                            <b>Note: The SSID Name is limited to 32 characters and may use a combination of letters, numbers and special characters. The only special characters that may be used are the underscore symbol [_] or the hyphen symbol [-]. Other special characters are not available for SSID names. The SSID Name can not start with prohibited words such as "guest," "administrative," "admin," "test," "demo," or "production." These words cannot be used without other descriptive words. </b>
                        </small>
                    </div>
                </div>
                <?php
                if($package_functions->getSectionType('NET_GUEST_LOC_UPDATE',$system_package)=='YES' || $package_features=="all") {
                    ?>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Use
                            Existing Location : </label>

                        <div class="controls col-lg-5 form-group">
                            <div>
                                <select class="span4 form-control" id="old_location_name"
                                        name="old_location_name"
                                        onchange="setNewSSID(this.value)">
                                    <option value="">SELECT LOCATION
                                    </option>
                                    <?php
                                    $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                    $get_group_tag_r = $db->selectDB($get_group_tag_q);
                                    
                                    foreach ($get_group_tag_r['data'] AS $get_group_tag) {
                                        echo '<option value="' . $get_group_tag['tag_name'] . '">' . $get_group_tag['tag_name'] . '</option>';
                                    }
                                    ?>
                                </select> &nbsp;Or
                            </div>
                        </div>
                    </div>

                    <script>
                        function setNewSSID(grout_tag) {
                            if (grout_tag == '') {
                                document.getElementById("location_name").value = '';
                                document.getElementById("location_name").readOnly = false;
                                document.getElementById("loc_label").innerHTML = 'Create a New Location :';
                            } else {
                                document.getElementById("location_name").value = grout_tag;
                                document.getElementById("location_name").readOnly = true;
                                document.getElementById("loc_label").innerHTML = 'Assign Location :';
                            }
                        }
                    </script>

                    <div class="control-group">
                        <label class="control-label" for="radiobtns"
                               id="loc_label">Create a New Location
                            : </label>

                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input class="span4 form-control" id="location_name"
                                       name="location_name" type="text"
                                       value="<?php echo ''; ?>" required>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </fieldset>


            <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET'];?>">
            <div class="form-actions">
                <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>

            </div>

        </form>


        <h2>SSID Enable</h2>

        <?php if(strpos($system_package, 'COX')>-1){ ?>

            <p>Choose when you would like for your Guest <?php echo __WIFI_TEXT__; ?> Network to be enabled. Select the correct SSID from the dropdown menu and then choose "Always On" or "Always Off" to manage your Power Schedule.</p>

            <p>If you enable a Power Schedule, your "Always On" option will be replaced by your "Power Schedule" option. If you disable a Power Schedule, the "Power Schedule" option will be replaced by "Always On" option.</p>
        <?php } else{ ?>

            <p>Choose when you would like for your Guest <?php echo __WIFI_TEXT__; ?> Network to be enabled. Select the correct SSID from the dropdown menu and then choose "Always On" or "Always Off". You can also set a Network Schedule to enable the SSID during specific time periods.</p>

            <p>If you enable a Network Schedule, your "Always On" option will be replaced by your "Network Schedule" option. If you disable a Network Schedule, the "Network Schedule" option will be replaced by "Always On" option.</p> <?php }  ?>
        <div class="widget widget-table action-table">
            <div class="widget-header">
                <!-- <i class="icon-th-list"></i> -->
                <h3></h3>
            </div>
            <div class="widget-content table_response" id="ssid_tb2">


                <div style="overflow-x:auto;" >

                    <table class="table table-striped table-bordered" >
                        <thead>

                        <tr>
                            <th>Guest SSID</th>
                            <th>SSID Status</th>


                        </tr>

                        </thead>

                        <tbody>
                        <?php

                        $delete_from_schedule_assign="DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='GUEST'";
                        $db->execDB($delete_from_schedule_assign);

                        $insert_schedule_assign_guest="INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'GUEST',NOW(),'system' FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor'
                                                                                          ON DUPLICATE KEY UPDATE
                                                                                            ssid = VALUES(ssid),
                                                                                            network_method = 'GUEST',
                                                                                            create_date = NOW()";

                        $db->execDB($insert_schedule_assign_guest);


                        $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                        $get_private_ssid_res_assign=$db->selectDB($ssid_assign_q);

                        
                        foreach ($get_private_ssid_res_assign['data'] AS $row) {

                            $ssid_name_a=$row['ssid'];
                            $b_cast=$row['ssid_broadcast'];
                            $netid=$row['network_id'];

                            // $zone_id = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

                            $network_sche_data=$wag_obj->retrieveOneNetwork($zone_id,$netid);

                            parse_str($network_sche_data, $network_sche_result);

                            array_push($retrieveOneNetworkCache,array("wlan"=>$netid,"data"=>$network_sche_result));

                            $obj = (array)json_decode(urldecode($network_sche_result['Description']));
                            $she_ar=$obj['schedule'];
                            $api_ssid = $obj['ssid'];

                            $vlan_ar=$obj['vlan'];
                            $vl_ar = json_decode(json_encode($vlan_ar), True);
                            $vlanac=$vl_ar[accessVlan];



                            $data = get_object_vars($she_ar);

                            //  $data['type'];

                            //$ssid_name_a

                            if($data['id']==NULL){
                                $data['id']="";
                            }
                            // $data['type'];
                            $assign_schedule_update="UPDATE `exp_distributor_network_schedul_assign`
                                                                            SET `ssid_broadcast`='".$data['type']."',`shedule_uniqu_id`='".$data['id']."'
                                                                            WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                            $db->execDB($assign_schedule_update);

                            echo'<tr><td>'.$ssid_name_a.'</td>';
                            echo'<td data-id="'.$netid.'" data-value="'.$data['type'].'">';

                            if($data['type']=='Customized'){

                                echo 'Power Schedule';

                            }

                            if($data['type']=='AlwaysOn'){

                                echo 'Always On';

                            }

                            if($data['type']=='AlwaysOff'){

                                echo 'Always Off';

                            }
                            
                            



                            echo '</td>';
                            echo '</tr>';

                            $vlan_upq="UPDATE `exp_locations_ssid` SET `vlan` = '$vlanac' WHERE `network_id`='$netid'";

                            $vlan_upq_exe=$db->execDB($vlan_upq);

                        }

                        //echo $vlanac;

                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <form id="modify_gst_ssid_broadcast_f" name="modify_gst_ssid_broadcast_f" class="form-horizontal" action="?t=guestnet_tab_1" method="post">

            <fieldset>


                <div class="control-group">
                    <label class="control-label" for="radiobtns">Select SSID</label>
                    <div >
                        <div class="controls col-lg-5 form-group">
                            <select class="span4 form-control" id="sel_ssid_name" onchange="set_rad(this.value);" name="sel_ssid_name" <?php echo $ssidName; ?> required onchange="loadSSIDForm(this.value)">
                            <option value="">Select SSID</option>
                                <?php
                                $ssid_q="SELECT s.`ssid`,s.`network_id`
                                                                                    FROM
                                                                                        `exp_mno_distributor` d
                                                                                        LEFT JOIN
                                                                                        `exp_locations_ssid` s
                                                                                        ON s.`distributor`=d.`distributor_code`
                                                                                        LEFT JOIN
                                                                                        `exp_mno_distributor_aps` a
                                                                                        ON s.`distributor`= a.`distributor_code`
                                                                                        LEFT JOIN
                                                                                        `exp_locations_ap_ssid` l
                                                                                        ON a.`ap_code`=l.`ap_id`

                                                                                        WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>''
                                                                                        GROUP  BY   s.`ssid`";
                                $ssid_res=$db->selectDB($ssid_q);
                                $i=0;
                                foreach ($ssid_res['data'] AS $ssid_names) {
                                    
                                    if ($i==0) {
                                        $ssid_name=$ssid_names[ssid];
                                        $active_schedule=$db->getValueAsf("SELECT s.ssid_broadcast AS f  FROM exp_distributor_network_schedul_assign s
                                                                                WHERE s.ssid='$ssid_name' AND s.distributor='$user_distributor' ");
                                        $array_ssid_b = array($ssid_names[ssid] =>  $active_schedule);
                                    }
                                    else{
                                        $active_schedules=$db->getValueAsf("SELECT s.ssid_broadcast AS f  FROM exp_distributor_network_schedul_assign s
                                                                                WHERE s.ssid='$ssid_names[ssid]' AND s.distributor='$user_distributor' ");
                                        $array_ssid_ba = array($ssid_names[ssid] =>  $active_schedules);
                                        $array_ssid_b=array_merge($array_ssid_b,$array_ssid_ba);
                                    }

                                    echo'<option data-ssid="'.$ssid_names[ssid].'" value="'.$ssid_names[network_id].'">'.$ssid_names[ssid].'</option>';
                                    $i=$i+1;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" for="radiobtns">SSID Enable</label>
                    <div >
                        <div class="controls " id="ssid_broadcast_div">

                            <?php 
                            $customized_ssid='<input type="radio" name="ssid_broadcast" id="Customized" ><label style="display: inline-block;"></label> Power Schedule &nbsp;<input type="radio" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"><label style="display: inline-block;"></label> Always Off';
                            $other_ssid='<input type="radio" name="ssid_broadcast" id="AlwaysOn" value="AlwaysOn"><label style="display: inline-block;"></label> Always On &nbsp;<input type="radio" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"><label style="display: inline-block;"></label> Always Off';

                            $array_ssid_b= json_encode($array_ssid_b);        
                           // if($active_schedule=='Customized'){
                                ?>
                                <!-- <input type="radio" checked="checked" name="ssid_broadcast" id="Customized" value="<?php echo $active_schedule; ?>"> Power Schedule &nbsp;
                                <input type="radio" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"> Always Off -->

                                <?php
                           // }elseif ($active_schedule=='AlwaysOn') {
                                ?>
                                <!-- <input type="radio" checked="checked" name="ssid_broadcast" id="AlwaysOn" value="AlwaysOn"> Always On &nbsp;
                                <input type="radio" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"> Always Off -->
                                <?php
                           // }else{ ?>
                                <!-- <input type="radio" name="ssid_broadcast" id="AlwaysOn" value="AlwaysOn"> Always On &nbsp;
                                <input type="radio" checked="checked" name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"> Always Off -->
                            <?php
                            // }

                            ?>
                            <input type="radio" name="ssid_broadcast" id="AlwaysOn" value="AlwaysOn"> Always On &nbsp;
                                <input type="radio"  name="ssid_broadcast" id="AlwaysOff" value="AlwaysOff"> Always Off
                            <!-- &nbsp;
                            <input type="radio" name="ssid_broadcast" value="Customized"> Use Network Schedule  -->


                        </div>
                    </div>
                </div>

            </fieldset>




            <div class="form-actions">
                <button type="submit" name="modify_gst_ssid_broadcast" id="modify_gst_ssid_broadcast" class="btn btn-primary">Update</button>

                <script type="text/javascript">


                    $(document).ready(function(){
                        function broadcastSSIDcheck() {

                            $('#modify_gst_ssid_broadcast').attr("disabled", true);

                            if($('#sel_ssid_name').val() !=''){

                                $('#modify_gst_ssid_broadcast').attr("disabled", false);

                            }
                        }

                        function broadcastSSIDset() {
                            $('#ssid_broadcast_div').empty();
                            var ssid = $("#sel_ssid_name option:selected").data('ssid');
                            var ssid_details = '<?php echo $array_ssid_b; ?>';
                            var customized_ssid = '<?php echo $customized_ssid; ?>';
                            var other_ssid = '<?php echo $other_ssid; ?>';
                            var ssid_data =JSON.parse(ssid_details);
                            console.log(ssid_data[ssid]);
                            if (ssid_data[ssid]=='Customized') {
                                $('#ssid_broadcast_div').append(customized_ssid);
                            }else{
                                $('#ssid_broadcast_div').append(other_ssid);
                            }
                            document.getElementById(ssid_data[ssid]).checked = true;

                            
                        }

                        // broadcastSSIDcheck();


                        $('#sel_ssid_name').change(function () {
                            
                            //alert(ssid);
                            broadcastSSIDcheck();
                            if($('#sel_ssid_name').val() !=''){
                            broadcastSSIDset();
                            }
                        });

                    });

                </script>
            </div>



        </form>





    </div>



