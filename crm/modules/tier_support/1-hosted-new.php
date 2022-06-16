<?php $db = new db_functions();

$prodcutfield_val = true;

$q_mno_product = "SELECT * FROM `exp_products` WHERE `mno_id` = '$mno_id' AND `network_type`='GUEST'";
$re_mno_product = $db->selectDB($q_mno_product);



$q_network_realms = "SELECT network_realm,wLan_id,s.ssid FROM exp_network_realm nr
                                                                                JOIN exp_mno_distributor d ON nr.realm=d.verification_number
                                                                                JOIN exp_locations_ssid s ON d.distributor_code=s.distributor
                                                                                WHERE nr.network_type='gues' AND (s.network_id=nr.wLan_id OR s.wlan_name=nr.wLan_name) AND  realm='$realm'";
$network_realms = $db->selectDB($q_network_realms);
$multi_ssid_venue = false;
if ($network_realms['rowCount'] == 0 && $other_multi_area == 1) {
    $multi_ssid_venue = true;
    $ssid_arr = "SELECT s.wlan_name,s.ssid FROM exp_locations_ssid s WHERE s.distributor='$user_distributor'";
    $ssid_arr = $db->selectDB($ssid_arr);
    $q_network_realms = "SELECT network_realm FROM exp_network_realm nr
                                                                                WHERE nr.network_type='gues' AND  nr.realm='$realm' AND nr.network_realm<>'$realm'";
    $network_realms = $db->selectDB($q_network_realms);
    foreach ($ssid_arr['data'] as $value2) {
        $num = substr($value2['wlan_name'], -1);
        $is_access_group = false;
        foreach ($network_realms['data'] as $value) {
            $num2 = substr($value['network_realm'], -1);
            if ($num == $num2) {
                $is_access_group = true;
            }
        }
        if (!$is_access_group) {
            $access_group = $realm . 'G' . $num;
            $network_wlan_ex = "INSERT INTO `exp_network_realm` (`id`, `realm`, `network_realm`, `network_type`, `wLan_id`, `wLan_name`, `vLan_id`, `create_user`, `create_date`, `last_update`) VALUES (NULL, '$realm', '$access_group', 'gues', '', '', '', '$mno_id', NOW(), NOW())";
            $db->execDB($network_wlan_ex);
        }
    }
    if (!$is_access_group) {
        $q_network_realms = "SELECT network_realm FROM exp_network_realm nr
                                                                                WHERE nr.network_type='gues' AND  nr.realm='$realm' AND nr.network_realm<>'$realm'";
        $network_realms = $db->selectDB($q_network_realms);
    }
    //print_r(expression)
    $newarr = array();
    foreach ($network_realms['data'] as $value) {
        $number = substr($value['network_realm'], -1);
        foreach ($ssid_arr['data'] as $value2) {
            $number2 = substr($value2['wlan_name'], -1);
            if ($number == $number2) {
                $ssid = $value2['ssid'];
            }
        }
        $value['ssid'] = $ssid;
        array_push($newarr, $value);
    }
    $network_realms['data'] = $newarr;
}
?>
<style type="text/css">
    .form_control_n {
        /*margin-left: 0px !important;*/
    }
</style>
<div <?php if (isset($tab_tier_support)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="tier_support" style="margin-top: 30px;">


    <h1 class="head" style="display: none;">Manually onboard a customer device</h1>

    <h2>Device and Session Management</h2>
    <br />

    <p><b>LIST ALL DEVICES: </b>Clicking this button will return a list of all devices currently registered at the location. The devices can either have active or inactive sessions.
    </p>
    <br />

    <form action="?t=tier_support" id="mac_search_all" class="form-horizontal" method="post">
        <fieldset>
            <div class="control-group">
                <div class="controls form-group form_control_n" style="margin-left: 0px !important;">

                    <a data-toggle="tooltip" title="List All devices button will display Active Authenticated Clients on Network" name="all_search" id="all_search" class="btn btn-info inline-btn" onclick="manual_btn();"><i class="btn-icon-only icon-search"></i> List All Devices</a>
                    <img id="tooltip1" data-toggle="tooltip" title="Use the List All Devices button to see how many devices are registered and online right now. Or use the field and Search button to find a specific device using its MAC address." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                    <?php $session_down_key_string = "uni_id_name=Customer Sessions&task=all_sessions&user_distributor=" . $user_distributor . "&realm=" . $realm . "&session_profile=" . $session_profile . "&network_name=" . $network_name . "&internal_url=" . $internal_url;


                    $session_down_key =  cryptoJsAesEncrypt($data_secret, $session_down_key_string);
                    $session_down_key =  urlencode($session_down_key);
                    ?>
                    <a href='ajax/export_customer.php?key=<?php echo $session_down_key ?>' class="btn btn-primary" style="text-decoration:none">
                        <i class="btn-icon-only icon-download"></i> Download Sessions
                    </a>

                </div>

                <script type="text/javascript">
                    function manual_btn() {
                        window.location = "?all_search=1";
                    }
                </script>

            </div>
        </fieldset>
    </form>

    <p><b>SEARCH FOR A DEVICE: </b>Select the SSID,then enter the MAC Address of the device in the Search dialog and then click "Search" to determine if the device is registered and has an active or inactive session.
    </p>
    <br />
    <form action="?t=tier_support" id="mac_search" class="form-horizontal" method="post">
        <fieldset>
            <div class="control-group">
                <div class="controls form-group form_control_n" style="margin-left: 0px !important;">
                    <?php
                    if ($network_realms['rowCount'] < 1 || $other_multi_area != 1) {
                        echo '<input type="hidden" name="net_realm_search" value="' . $realm . '">';
                    } else {
                        if ($multi_ssid_venue) {
                            echo '<input type="hidden" value="1" id"multi_ssid_venue" name="multi_ssid_venue">';
                        }
                    ?>
                        <select name="net_realm_search" class="span3">
                            <?php
                            foreach ($network_realms['data'] as $row) {
                                echo '<option value="' . $row['network_realm'] . '">' . $row['ssid'] . '</option>';
                            }
                            ?>
                        </select>
                        <img id="tooltip1" data-toggle="tooltip" title="Before searching for a specific device you must first select a SSID." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                    <?php } ?>
                    <input style="font-size:14px;" type="text" class="span3 form-control" name="search_mac" id="search_mac" placeholder="XX:XX:XX:XX:XX:XX" autocomplete="off" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS." onkeypress="return event.keyCode != 13;" />

                    <button type="submit" name="search_mac_sessions" id="search_mac_sessions" class="btn btn-primary inline-btn"><i class="btn-icon-only icon-search"></i> Search</button>
                </div>
            </div>
        </fieldset>
    </form>
    <p><b>DELETE DEVICE OR REMOVE A SESSION: </b>Once you have identified a device you have the option to delete the device and/or remove the session. If a device is deleted, that device has to re-register to get online once its current session expires. If a session is removed, that device will automatically get a new session if the device is registered. Or if the device has been deleted, the session can be removed to immediately end that session.
    </p>


    <?php
    if ((isset($_POST['search_mac_sessions']) || isset(
        $set_search_mac_sessions
    ) || isset($_GET['search_mac_sessions'])) && $pre_paid_enable) {
        echo '<div><b>Download</b> : ' . $download . ' &nbsp;&nbsp; <b>Upload</b> : ' . $upload . '</div>';
    }
    ?>
    <br />
    <form action="?t=tier_support" class="form-horizontal">
        <div class="widget widget-table action-table tablesaw-minimap-mobile">
            <div class="widget-header">
                <!-- <i class="icon-th-list"></i> -->
                <h3>Devices & Sessions</h3>
            </div>
            <div class="widget-content table_response">

                <?php

                $default_table_rows = $db->setVal('tbl_max_row_count', 'ADMIN');

                if ($default_table_rows == "" || $default_table_rows == "0") {
                    $default_table_rows = 50;
                }

                ?>
                <div style="overflow-x:auto">
                    <style>
                        .dataTables_length {
                            padding: 5px;
                            float: right !important;
                        }

                        .dataTables_length label {
                            margin-bottom: 0px !important;
                        }

                        .dataTables_length select {
                            margin-left: 5px !important;
                            width: 80px !important;
                        }

                        #tenent_search_table th {
                            border-top: 1px solid #ddd !important;
                            background-color: #f4f4f4;
                        }


                        .dataTables_info {
                            margin-left: 10px;
                        }
                    </style>
                    
                    <table id="device_sessions" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AP MAC/GW MAC</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Session State</th>
                                <?php if ($private_module == 1) {
                                ?>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Session Type</th>
                                <?php
                                }
                                ?>

                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">SSID</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Customer Account #</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">VLAN Subnet</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Account Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">GW IP</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">GW Type</th>
                                <?php if($property_wired != '1'){?>
                                         <!--  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AP MAC
                                          </th> -->
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AP Name
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Host Name
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">OS Vendor
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Model Name
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Device Type
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Uplink
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Downlink
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Effective Data Rate
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">RSSI
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">SNR
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP Address
                                          </th>
                                          <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">User Name
                                          </th>
            <?php } ?>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Session Start Time</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Remove Session
                                    <img id="tooltip1" data-toggle="tooltip" title="Redirect Session deletion may take up to several minutes to be recognized and removed from the table. If deletion is a success wait 2 minutes and then refresh this page." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                                </th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Delete Device</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $tb_arr_data = [];
                            if (isset($_POST['search_mac_sessions']) || isset(
                                $set_search_mac_sessions
                            ) || isset($_GET['search_mac_sessions'])) {
                                //print_r($newjsonvalue);
                                if (!$newjsonvalue) {
                                    //echo "<td colspan=\"1\">No Device</td>";
                                    //echo "<td colspan=\"10\">No Sessions</td>";
                                }
                                $session_row_count = 0;
                                foreach ($newjsonvalue as $value2) {
                                    $tb_arr = [];
                                    $next_search_pram = 'search_mac_sessions';
                                    $session_row_count = $session_row_count + 1;

                                    //echo "<tr>";
                                    $mac = ($value2['Mac']);
                                    $AP_Mac = ($value2['AP_Mac']);
                                    $nas_type = ($value2['Nas-Type']);
                                    $newstate = ($value2['State']);
                                    if (empty($value2['State'])) {
                                        $value2['State'] = "No Session/offline";
                                    }
                                    $state = ($value2['State']);
                                    $ssid = ($value2['SSID']);
                                    $GW_ip = ($value2['GW_ip']);
                                    $sh_realm = ($value2['Realm']);
                                    $GW_Type = ($value2['GW-Type']);
                                    $start_time = (date_convert($value2['Session-Start-Time']));
                                    $ses_type = $value2['session_type'];
                                    $device_mac = $value2['Device-Mac'];
                                    $type = $value2['TYPE'];
                                    $ses_id = $value2['Ses_token'];
                                    $Client_IP = ($value2['Client_IP']);
                                    $Account_Name = ($value2['Account_Name']);
                                    $vLAN = ($value2['vLAN']);
                                    $Device_Type = ($value2['Device-Type']);

                                    if (strlen($mac) < 1) {
                                        $mac = "N/A";
                                    }
                                    if (strlen($AP_Mac) < 1) {
                                        $AP_Mac = "N/A";
                                    }
                                    if (strlen($ssid) < 1) {
                                        $ssid = "N/A";
                                    }
                                    if (strlen($type) < 1) {
                                        $type = "N/A";
                                    }
                                    if (strlen($GW_ip) < 1) {
                                        $GW_ip = "N/A";
                                    }
                                    if (strlen($sh_realm) < 1) {
                                        $sh_realm = "N/A";
                                    }
                                    if (strlen($GW_Type) < 1) {
                                        $GW_Type = "N/A";
                                    }
                                    if (strlen($start_time) < 1) {
                                        $start_time = "N/A";
                                    }
                                    if (strlen($Client_IP) < 1) {
                                        $Client_IP = "N/A";
                                    }
                                    if (strlen($Account_Name) < 1) {
                                        $Account_Name = "N/A";
                                    }
                                    if (strlen($vLAN) < 1) {
                                        $vLAN = "N/A";
                                    }
                                    if (strlen($Device_Type) < 1) {
                                        $Device_Type = "N/A";
                                    }

                                    array_push($tb_arr,$db->macFormat($mac, $mac_format));
                                    array_push($tb_arr,$AP_Mac);
                                    array_push($tb_arr,$state);

                                    //echo "<td>" . $db->macFormat($mac, $mac_format) . "</td>";
                                    //echo "<td>" . $AP_Mac . "</td>";
                                    //echo "<td>" . $state . "</td>";
                                    if ($private_module == 1) {
                                        array_push($tb_arr,$type);
                                        //echo "<td>" . $type . "</td>";
                                    }

                                    array_push($tb_arr,$ssid);
                                    array_push($tb_arr,$sh_realm);
                                    array_push($tb_arr,$vLAN);
                                    array_push($tb_arr,$Account_Name);
                                    array_push($tb_arr,$GW_ip);
                                    array_push($tb_arr,$GW_Type);

                                    //echo "<td>" . $ssid . "</td>";
                                    //echo "<td>" . $sh_realm . "</td>";
                                    //echo "<td>" . $vLAN . "</td>";
                                    //echo "<td>" . $Account_Name . "</td>";
                                    //echo "<td>" . $GW_ip . "</td>";
                                    //echo "<td>" . $GW_Type . "</td>";
                                    if($property_wired != '1'){
                                                    $apMac= $value2['apMac'];
                                                $apName= $value2['apName'];
                                                $hostname=$value2['hostname'];
                                                $osType=$value2['osType'];
                                                $modelName=$value2['modelName'];
                                                $deviceType=$value2['deviceType'];
                                                $uplink= $value2['uplink'];
                                                $downlink= $value2['downlink'];
                                                $txRatebps=$value2['txRatebps'];
                                                $rssi=$value2['rssi'];
                                                $snr=$value2['snr'];
                                                $ipAddress=$value2['ipAddress'];
                                                $userCase=$value2['userCase'];

                                                if (strlen($apMac)<1) {
                                                            $apMac="N/A"; }
                                                if (strlen($apName)<1) {
                                                            $apName="N/A"; }
                                                if (strlen($hostname)<1) {
                                                            $hostname="N/A"; }
                                                if (strlen($osType)<1) {
                                                            $osType="N/A"; }
                                                if (strlen($modelName)<1) {
                                                            $modelName="N/A"; }
                                                if (strlen($deviceType)<1) {
                                                            $deviceType="N/A"; }
                                                if (strlen($uplink)<1) {
                                                            $uplink="N/A"; }
                                                if (strlen($downlink)<1) {
                                                            $downlink="N/A"; }
                                                if (strlen($rssi)<1) {
                                                            $rssi="N/A"; }
                                                if (strlen($snr)<1) {
                                                            $snr="N/A"; }
                                                if (strlen($txRatebps)<1 || $txRatebps=='bps') {
                                                            $txRatebps="N/A"; }
                                                if (strlen($ipAddress)<1) {
                                                            $ipAddress="N/A"; }
                                                if (strlen($userCase)<1) {
                                                            $userCase="N/A"; }

                                                array_push($tb_arr,$apName);
                                                array_push($tb_arr,$hostname);
                                                array_push($tb_arr,$osType);
                                                array_push($tb_arr,$modelName);
                                                array_push($tb_arr,$deviceType);
                                                array_push($tb_arr,$uplink);
                                                array_push($tb_arr,$downlink);
                                                array_push($tb_arr,$txRatebps);
                                                array_push($tb_arr,$rssi);
                                                array_push($tb_arr,$snr);
                                                array_push($tb_arr,$ipAddress);
                                                array_push($tb_arr,$userCase);

                                                //echo "<td>".$apName."</td>";
                                                //echo "<td>".$hostname."</td>";
                                                //echo "<td>".$osType."</td>";
                                                //echo "<td>".$modelName."</td>";
                                                //echo "<td>".$deviceType."</td>";
                                                //echo "<td>".$uplink."</td>";
                                                //echo "<td>".$downlink."</td>";
                                                //echo "<td>".$txRatebps."</td>";
                                                //echo "<td>".$rssi."</td>";
                                                //echo "<td>".$snr."</td>";
                                                //echo "<td>".$ipAddress."</td>";
                                                //echo "<td>".$userCase."</td>";
                                            }
                                            array_push($tb_arr,$start_time);
                                    //echo "<td>" . $start_time . "</td>";

                                    //echo '<td>';
                                    if ($state == 'Inactive' && $nas_type == 'ac') {
                                        $a = '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                      <i class="btn-icon-only icon-trash"></i>Remove</a>';
                                      array_push($tb_arr,$a);
                                    } else {
                                        if (strlen($ses_id) > 0 && $_GET['rm_session_mac'] != $mac) {
                                            $a = '<a href="" id="' . $session_row_count . 'SESSION_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            
                                                            $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm=' . $sh_realm . '&rm_session_token=' . $ses_id . '&mac=' . $mac . '&state=' . $state . '&t=tier_support&rm_session_mac=' . $mac . '&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                
                                                        </script>
														
														';
                                                        array_push($tb_arr,$a);
                                        } elseif ($_GET['rm_session_mac'] == $mac) {
                                            $a = '<a disabled id="' . $session_row_count . 'SESSION_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck' . $mac . ' = function (){
														    checkSessionDeleted(\'' . $sh_realm . '\',\'' . $mac . '\',function(data){
														        
														    if(data == \'0\'){
														    
                                                                $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck' . $mac . '();
														    }   
														});
														    
														}
														deleteSessionCheck' . $mac . '();
                                                        </script>
														';
                                                        array_push($tb_arr,$a);
                                        } else {
                                            $a = '<a disabled id="' . $session_row_count . 'SESSION_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';

                                                        array_push($tb_arr,$a);
                                        }
                                    }
                                    //echo '</td>';
                                    //echo '<td>';

                                    if (strlen($device_mac) > 0) {
                                        $b = '<a id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=tier_support&rm_device_realm=' . $sh_realm . '&rm_session_token=' . $ses_id . '&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                
                                                        </script>
														';
                                                        array_push($tb_arr,$b);
                                    } else {
                                        $b = '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>';
                                                        array_push($tb_arr,$b);
                                    }
                                    //echo '</td>';
                                    //echo "</tr>";
                                    array_push($tb_arr_data,$tb_arr);
                                }
                            }


                            //=============================================
                            elseif (isset($_POST['all_search']) || isset($_GET['all_search'])) {
                                $next_search_pram = 'all_search';
                                $next_search_value = 'all_search';
                                if (!$newjsonvalue) {
                                    //echo "<td colspan=\"1\">No Devices</td>";
                                    //echo "<td colspan=\"10\">No Sessions</td>";

                                }


                                $session_row_count = 0;
                                foreach ($newjsonvalue as $value2) {
                                    $tb_arr = [];
                                    $session_row_count = $session_row_count + 1;

                                    //echo "<tr>";
                                    $mac = ($value2['Mac']);
                                    $AP_Mac = ($value2['AP_Mac']);
                                    $nas_type = ($value2['Nas-Type']);
                                    $ssid = ($value2['SSID']);
                                    $GW_ip = ($value2['GW_ip']);
                                    $sh_realm = ($value2['Realm']);
                                    $GW_Type = ($value2['GW-Type']);
                                    $start_time = (date_convert($value2['Session-Start-Time']));
                                    $newstatus = $value2['State'];
                                    $ses_type = $value2['session_type'];
                                    $device_mac = $value2['Device-Mac'];
                                    $type = $value2['TYPE'];
                                    $ses_id = $value2['Ses_token'];
                                    $Client_IP = ($value2['Client_IP']);
                                    $Account_Name = ($value2['Account_Name']);
                                    $vLAN = ($value2['vLAN']);
                                    $Device_Type = ($value2['Device-Type']);

                                    if (empty($value2['State'])) {
                                        $value2['State'] = "No Session/offline";
                                    }
                                    $state = ($value2['State']);


                                    if (strlen($mac) < 1) {
                                        $mac = "N/A";
                                    }
                                    if (strlen($state) < 1) {
                                        $state = "N/A";
                                    }
                                    if (strlen($type) < 1) {
                                        $type = "N/A";
                                    }
                                    if (strlen($AP_Mac) < 1) {
                                        $AP_Mac = "N/A";
                                    }
                                    if (strlen($ssid) < 1) {
                                        $ssid = "N/A";
                                    }
                                    if (strlen($GW_ip) < 1) {
                                        $GW_ip = "N/A";
                                    }
                                    if (strlen($sh_realm) < 1) {
                                        $sh_realm = "N/A";
                                    }
                                    if (strlen($GW_Type) < 1) {
                                        $GW_Type = "N/A";
                                    }
                                    if (strlen($start_time) < 1) {
                                        $start_time = "N/A";
                                    }
                                    if (strlen($Client_IP) < 1) {
                                        $Client_IP = "N/A";
                                    }
                                    if (strlen($Account_Name) < 1) {
                                        $Account_Name = "N/A";
                                    }
                                    if (strlen($vLAN) < 1) {
                                        $vLAN = "N/A";
                                    }
                                    if (strlen($Device_Type) < 1) {
                                        $Device_Type = "N/A";
                                    }

                                    array_push($tb_arr,$db->macFormat($mac, $mac_format));
                                    array_push($tb_arr,$AP_Mac);
                                    array_push($tb_arr,$state);
                                    

                                    //echo "<td>" . $db->macFormat($mac, $mac_format) . "</td>";
                                    //echo "<td>" . $AP_Mac . "</td>";
                                    //echo "<td>" . $state . "</td>";
                                    if ($private_module == 1) {
                                        array_push($tb_arr,$type);
                                        //echo "<td>" . $type . "</td>";
                                    }
                                    array_push($tb_arr,$ssid);
                                    array_push($tb_arr,$sh_realm);
                                    array_push($tb_arr,$vLAN);
                                    array_push($tb_arr,$Account_Name);
                                    array_push($tb_arr,$GW_ip);
                                    array_push($tb_arr,$GW_Type);

                                    //echo "<td>" . $ssid . "</td>";
                                    //echo "<td>" . $sh_realm . "</td>";
                                    //echo "<td>" . $vLAN . "</td>";
                                    //echo "<td>" . $Account_Name . "</td>";
                                    //echo "<td>" . $GW_ip . "</td>";
                                    //echo "<td>" . $GW_Type . "</td>";
                                    if($property_wired != '1'){
                                                    $apMac= $value2['apMac'];
                                                $apName= $value2['apName'];
                                                $hostname=$value2['hostname'];
                                                $osType=$value2['osType'];
                                                $modelName=$value2['modelName'];
                                                $deviceType=$value2['deviceType'];
                                                $uplink= $value2['uplink'];
                                                $downlink= $value2['downlink'];
                                                $txRatebps=$value2['txRatebps'];
                                                $rssi=$value2['rssi'];
                                                $snr=$value2['snr'];
                                                $ipAddress=$value2['ipAddress'];
                                                $userCase=$value2['userCase'];

                                                if (strlen($apMac)<1) {
                                                            $apMac="N/A"; }
                                                if (strlen($apName)<1) {
                                                            $apName="N/A"; }
                                                if (strlen($hostname)<1) {
                                                            $hostname="N/A"; }
                                                if (strlen($osType)<1) {
                                                            $osType="N/A"; }
                                                if (strlen($modelName)<1) {
                                                            $modelName="N/A"; }
                                                if (strlen($deviceType)<1) {
                                                            $deviceType="N/A"; }
                                                if (strlen($uplink)<1) {
                                                            $uplink="N/A"; }
                                                if (strlen($downlink)<1) {
                                                            $downlink="N/A"; }
                                                if (strlen($rssi)<1) {
                                                            $rssi="N/A"; }
                                                if (strlen($snr)<1) {
                                                            $snr="N/A"; }
                                                if (strlen($txRatebps)<1 || $txRatebps=='bps') {
                                                            $txRatebps="N/A"; }
                                                if (strlen($ipAddress)<1) {
                                                            $ipAddress="N/A"; }
                                                if (strlen($userCase)<1) {
                                                            $userCase="N/A"; }

                                                array_push($tb_arr,$apName);
                                                array_push($tb_arr,$hostname);
                                                array_push($tb_arr,$osType);
                                                array_push($tb_arr,$modelName);
                                                array_push($tb_arr,$deviceType);
                                                array_push($tb_arr,$uplink);
                                                array_push($tb_arr,$downlink);
                                                array_push($tb_arr,$txRatebps);
                                                array_push($tb_arr,$rssi);
                                                array_push($tb_arr,$snr);
                                                array_push($tb_arr,$ipAddress);
                                                array_push($tb_arr,$userCase);

                                                //echo "<td>".$apName."</td>";
                                                //echo "<td>".$hostname."</td>";
                                                //echo "<td>".$osType."</td>";
                                                //echo "<td>".$modelName."</td>";
                                                //echo "<td>".$deviceType."</td>";
                                                //echo "<td>".$uplink."</td>";
                                                //echo "<td>".$downlink."</td>";
                                                //echo "<td>".$txRatebps."</td>";
                                                //echo "<td>".$rssi."</td>";
                                                //echo "<td>".$snr."</td>";
                                                //echo "<td>".$ipAddress."</td>";
                                                //echo "<td>".$userCase."</td>";
                                            }
                                            array_push($tb_arr,$start_time);
                                    //echo "<td>" . $start_time . "</td>";
                                    /*foreach ($value2 as $key => $value) {
											 	//$session_row_count++;

											 	if (strlen($value)<1) {
											 		$value="N/A";
											 		# code...
											 	}
											 	echo "<td>".$value."</td>";
											 	

											 }*/

                                    //echo '<td>';
                                    if ($state == 'Inactive' && $nas_type == 'ac') {
                                        $a = '<a  class="btn  btn-small td_btn_last disabled" data-toggle="tooltip" title="The system does not allow to delete inactive sessions">
                                     		        <i class="btn-icon-only icon-trash"></i>Remove</a>';
                                                     array_push($tb_arr,$a);
                                    } else {
                                        if (strlen($ses_id) > 0 && $_GET['rm_session_mac'] != $mac) {
                                            $a = '<a href="" id="' . $session_row_count . 'SESSION_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            
                                                            $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm=' . $sh_realm . '&rm_session_token=' . $ses_id . '&mac=' . $mac . '&state=' . $state . '&t=tier_support&rm_session_mac=' . $mac . '&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                
                                                        </script>
														
														';
                                                        array_push($tb_arr,$a);
                                        } elseif ($_GET['rm_session_mac'] == $mac) {
                                            $a = '<a disabled id="' . $session_row_count . 'SESSION_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck' . $mac . ' = function (){
														    checkSessionDeleted(\'' . $sh_realm . '\',\'' . $mac . '\',function(data){
														        //alert(data);
														    if(data == \'0\'){
														    
                                                                $(\'#' . $session_row_count . 'SESSION_DELETE_' . $mac . '\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck' . $mac . '();
														    }   
														});
														    
														}
														deleteSessionCheck' . $mac . '();
                                                        </script>
														';
                                                        array_push($tb_arr,$a);
                                        } else {
                                            $a = '<a disabled id="' . $session_row_count . 'SESSION_DELETE_' . $session_id . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
                                                        array_push($tb_arr,$a);
                                        }
                                    }
                                    //echo '</td>';
                                    //echo '<td>';
                                    if (strlen($device_mac) > 0) {
                                        $b = '<a id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE_' . $mac . '\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=tier_support&rm_device_realm=' . $sh_realm . '&rm_session_token=' . $ses_id . '&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                
                                                        </script>
														';
                                                        array_push($tb_arr,$b);
                                    } else {
                                        $b = '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE_' . $mac . '"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>';
                                                        array_push($tb_arr,$b);
                                        }
                                    //echo '</td>';

                                    //echo "<td><a href='#' disabled> REMOVE</a></td>";
                                   // echo "</tr>";
                                   array_push($tb_arr_data,$tb_arr);
                                }
                            } else {
                                //echo "<td colspan=\"1\">No Devices</td>";
                                //echo "<td colspan=\"10\">No Sessions</td>";

                            }




                            $vernum = $db->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
                            $nettype = $db->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");

                            if ($nettype == 'GUEST') {

                                $key_query .= " AND session_type='Guest'";
                            } elseif ($nettype == 'PRIVATE') {

                                $key_query .= " AND session_type='Private'";
                            }



                            ?>

                        </tbody>

                    </table>
                    <style>
                        #device_sessions_processing{
                            -webkit-box-pack: center;
                            -ms-flex-pack: center;
                                justify-content: center;
                        margin-left: 0;
                        -webkit-box-align: center;
                            -ms-flex-align: center;
                                align-items: center;
                        background: rgba(255,255,255,0.6);
                        display: -webkit-box;
                        display: -ms-flexbox;
                        display: flex;
                        width: 100%;
                        top: 0;
                        bottom: 0;
                        left: 0;
                        margin-left: 0;

                        }
                        #device_sessions_processing.show{
                            display: -webkit-box !important;
                        display: -ms-flexbox !important;
                        display: flex !important
                        }
                    </style>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#device_sessions').on( 'processing.dt', function ( e, settings, processing ) {
        $('#device_sessions_processing').css( 'display', processing ? '' : 'none' );
    } ).DataTable({
                                "deferRender": true,
                                "processing": true,
                                "data":<?php echo json_encode($tb_arr_data) ?>,
                                "pageLength": <?php echo $default_table_rows; ?>,
                                "columns": [
                                    null,
                                         null,
                                         null,
                                         <?php if($private_module==1){ ?>
                                         null,
                                         <?php } ?>
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                    {
                                        "orderable": false
                                    },
                                    {
                                        "orderable": false
                                    }
                                ],
                                "drawCallback": function () {
                                    new Tablesaw.Table("#device_sessions").destroy();
                                    Tablesaw.init();
                                    $('#device_sessions_processing').removeClass('show');
                                    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;'></label>");
                                },
                                "autoWidth": false,
                                "language": {
                                    "emptyTable": "No Device"
                                },
                                /*"language": {
                                         "lengthMenu": "Per page _MENU_ "
                                      },
         */
                                "bFilter": false,

                                "lengthMenu": '[[100, 250, 500, -1], [100, 250, 500, "All"]]'

                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </form>


    <p><b>DETERMINE IF A SESSION IS AVAILABLE: </b>If no device or session is available you can add the device manually in below. If a session is available, but the customer still cannot access the Internet, click Delete Device followed by deleting any sessions remaining for the device. Then add the device manually.
    </p>





    <form action="?t=tier_support" class="form-horizontal" method="post" id="add_mac_form" name="add_mac_form">

        <fieldset>
            <div class="control-group">
                <div class="controls form-group form_control_n" style="margin-left: 0px !important;">
                    <?php

                    if ($network_realms['rowCount'] < 1) {
                        echo '<input type="hidden" name="net_realm" value="' . $realm . '">';
                    } else {
                    ?>
                        <select name="net_realm" class="span3">
                            <?php
                            foreach ($network_realms['data'] as $row) {
                                echo '<option value="' . $row['network_realm'] . '">' . $row['ssid'] . '</option>';
                            }
                            ?>
                        </select>
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls form-group form_control_n" style="margin-left: 0px !important;">

                    <select name="net_product" id="net_product" class="span3">
                        <?php
                        echo '<option value="">Select Guest Profile</option>';
                        if (!empty($product)) {
                            echo '<option  value="' . $product . '">' . $product . ' [Default]</option>';
                        }
                        foreach ($re_mno_product['data'] as $pr_row) {

                            if ($product == $pr_row['product_code']) {
                                //  echo '<option selected value="' . $pr_row['product_code'] . '">' . $pr_row['product_code'] . ' [Default]</option>';
                            } else {
                                echo '<option value="' . $pr_row['product_code'] . '">' . $pr_row['product_code'] . '</option>';
                            }
                        }
                        ?>
                    </select>



                </div>
            </div>
            <div class="control-group">
                <p><b>ADD DEVICE:</b>Select the SSID,then enter the MAC address in the dialog field and then click "Add".
                </p>
                <div class="controls form-group form_control_n" style="margin-left: 0px !important;">


                    <input style="font-size:14px;" type="text" name="add_mac" class="span3" id="add_mac" maxlength="17" placeholder="XX:XX:XX:XX:XX:XX" data-fv-regexp="true" autocomplete="off" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS." onkeypress="return event.keyCode != 13;" />
                    <button type="submit" name="add_mac_sessions" id="add_mac_sessions" class="btn btn-primary inline-btn"> Add</button>
                    <input type="hidden" name="tocked" value="<?php echo $_SESSION['FORM_SECRET'] ?>">
                </div>
            </div>
        </fieldset>

    </form>

    <p><b>VERIFY ACTIVE SESSION: </b>After the device is added, verify the device has an active session using the Search function. Ask the customer to refresh their browser and verify access to the Internet. If the customer has Internet access, the issue has been resolved. If the customer still cannot access the Internet, click Delete Session to remove the session. To re-initiate the Device Session, ask the customer to refresh the browser once again. </p>


</div>