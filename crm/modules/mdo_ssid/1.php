<?php
if(isset($_GET['modify']) && $_GET['modify']=='1'){

    if($_GET['token']==$_SESSION['MDO_SSID_MANAGE_FORM_SECRET']){
        require_once __DIR__ . '/../../src/AP/apClass.php';
        $apObj = new apClass();
        $wag_obj = $apObj->getControllerInst();
        $WLanID = $_GET['wlanID'];
        $zone_id = $wag_obj->getZoneId();
        if ($_GET['is_enable'] == '1') {
            parse_str($wag_obj->modifySchedule($zone_id, $WLanID, 'AlwaysOn','',''), $modify_sche_respo);
        } elseif ($_GET['is_enable'] == '0') {
            parse_str($wag_obj->modifySchedule($zone_id, $WLanID, 'AlwaysOff','',''), $modify_sche_respo);
        }

        if($modify_sche_respo['status_code']==200){
            $msg = $message_functions->showMessage('ssid_enable_update_success');
            $_SESSION['mdo_ssid_manage'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg."</strong></div>";

        }else{
            $msg = $message_functions->showMessage('ssid_enable_update_fail');
            $_SESSION['mdo_ssid_manage'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg."</strong></div>";

        }

    }else{
        $msg = $message_functions->showMessage('transection_fail','2004');
        $_SESSION['mdo_ssid_manage'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg."</strong></div>";

    }
}

//Form Refreshing avoid secret key/////
$secret=md5(uniqid(rand(), true));
$_SESSION['MDO_SSID_MANAGE_FORM_SECRET'] = $secret;
?>
<div <?php if(isset($tab_mdo_ssid_manage)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="mdo_ssid_manage">
    <?php

    if(isset($_SESSION['mdo_ssid_manage'])){
        echo$_SESSION['mdo_ssid_manage'];
        unset($_SESSION['mdo_ssid_manage']);
    }
    ?>
    <h1 class="head">
        Manage the Mobile Data Offload SSID. <img data-toggle="tooltip" title="By default the MDO switch should be set to ON. If a customer has opted out of the MDO set the switch to OFF." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
    </h1>
    <div class="widget widget-table action-table">
    <div class="widget-content table_response" id="ssid_tbl">
        <div style="overflow-x:auto;" >
            <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                <thead>
                <tr>

                    <!-- <th>AP MAC Address</th> -->
                    <!--    <th>WLAN Name</th>  -->
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">MDO SSID</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Service Address</th>
                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($ori_user_type!='SALES') {

                    require_once __DIR__.'/../../src/AP/apClass.php';
                    $apObj = new apClass();
                    $wag_obj = $apObj->getControllerInst();
                    $delete_from_schedule_assign="DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='MDO'";
                    $db->execDB($delete_from_schedule_assign);

                    $insert_schedule_assign_guest="INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'MDO',NOW(),'system' FROM `exp_locations_ssid` WHERE `distributor`='$user_distributor' AND network_method='MDO'";

                    $db->execDB($insert_schedule_assign_guest);


                    $ssid_assign_q="SELECT a.id,ssid,ssid_broadcast,network_id,d.`zone_id`,d.bussiness_address1,d.state_region,d.bussiness_address2 FROM `exp_distributor_network_schedul_assign` a JOIN exp_mno_distributor d ON a.distributor=d.distributor_code WHERE `distributor`='$user_distributor' AND network_method='MDO'";
                    $get_private_ssid_res_assign=$db->selectDB($ssid_assign_q);


                    foreach ($get_private_ssid_res_assign['data'] AS $row) {

                        $ssid_name_a=$row['ssid'];
                        $b_cast=$row['ssid_broadcast'];
                        $netid=$row['network_id'];
                        $auto_id = $row['id'];
                        $network_sche_data=$wag_obj->retrieveOneNetwork($wag_obj->getZoneId(),$netid);

                        parse_str($network_sche_data, $shedule_response);


                        $obj = (array)json_decode(urldecode($shedule_response['Description']));
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
                        echo	"<td>".$row['bussiness_address1']."&nbsp;,&nbsp;".$row['bussiness_address2']."&nbsp;".$row['state_region']."</td>";


                        echo	"<td>";
                        if($data['type']!="AlwaysOff"){

                            //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                            echo   '<div class="toggle1"><input checked onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">ON</span>
																		<a id="ST_'.$auto_id.'" href="javascript:void();" ><span class="toggle1-off-dis">OFF</span></a>
																		</div>';

                            echo '';

                            echo '

																	<script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#ST_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Disable SSID\',

																			text: \'Are you sure you want to disable this SSID?&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#ST_'.$auto_id.'\').click(function() {



																		window.location = "?token='.$secret.'&modify=1&is_enable=0&id='.$auto_id.'&wlanID='.$netid.'"

																		});

																		});

																	</script>';


                        }
                        else{

                            // echo '<td><font color=red><strong>DISABLED</strong></font></td>';

                            echo   '<div class="toggle1"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                    <a href="javascript:void();" id="CE_'.$auto_id.'"><span class="toggle1-on-dis">ON</span></a>
                                                                    <span class="toggle1-off">OFF</span>
                                                                    </div>';

                            echo '';

                            echo '

                                                                <script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CE_'.$auto_id.'\').easyconfirm({locale: {

																			title: \'Activate SSID\',

																			text: \'Are you sure you want to enable this SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CE_'.$auto_id.'\').click(function() {

																			window.location = "?token='.$secret.'&modify=1&is_enable=1&id='.$auto_id.'&wlanID='.$netid.'"

																		});

																		});

																	</script>';




                        }

                        echo"</td>";




                        echo '</tr>';
//bi_portal_opt.exp_locations_ssid.distributor
                        $vlan_upq="UPDATE `exp_locations_ssid` SET `vlan` = '$vlanac' WHERE `network_id`='$netid' AND distributor='$user_distributor'";

                        $vlan_upq_exe=$db->execDB($vlan_upq);

                    }
                }
                else{
                    $ssid_assign_q="SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='GUEST'";
                    $get_private_ssid_res_assign=$db->selectDB($ssid_assign_q);


                    foreach ($get_private_ssid_res_assign['data'] AS $row) {

                        $ssid_name_a=$row['ssid'];
                        $b_cast=$row['ssid_broadcast'];
                        $netid=$row['network_id'];
                    }
                    if (strlen($ssid_name_mode)==0) {
                        $ssid_name_mode='AlwaysOff';
                    }
                    echo'<tr><td>'.$ssid_name_a.'</td>';
                    echo'<td>'.$ssid_name_mode.'</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();


    });

</script>