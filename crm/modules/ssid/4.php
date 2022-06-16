<?php

function product_name_convertion($mno_id, $db,$user_distributor)
{
    if ($GLOBALS['qos_ale_version'] == 'ale4') {
        $qos_q = "SELECT `product_id`,LEFT(`product_code`,LENGTH(`product_code`)-1) as `product_code`,pd.`duration` ,`product_code` AS `QOS` 
            FROM `exp_products` p JOIN `exp_products_duration` pd ON 1=1 AND pd.`distributor`='$mno_id' AND pd.`is_default`='1' WHERE p.`mno_id`='$mno_id' AND `network_type`='GUEST'
            ";
        $qos_data = $db->selectDB($qos_q);
    } else {
        $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST' AND `default_product` = '1'";
        $qos_data = $db->selectDB($qos_q);
        if ($qos_data['rowCount'] == 0) {
            $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST'";
            $qos_data = $db->selectDB($qos_q);
        }else{
            $qos_qs = "SELECT p.`product_id`,p.`product_code`,p.`QOS` FROM `exp_products` p INNER JOIN `exp_products_distributor` d ON p.`product_code` = d.`product_code` WHERE p.`mno_id`='$mno_id' AND p.`network_type`='GUEST' AND d.`distributor_code` = '$user_distributor'";
            $qos_data_sel = $db->select1DB($qos_qs);
            array_push($qos_data['data'], $qos_data_sel);
                      
        }
    }
    
    $list = $qos_data['data'];
    $qos = [];

    foreach ($list as $value) {
        $product_name_new = str_replace('_', '-', $value['product_code']);
        $qosspeed = substr(trim($value['QOS']), -1);
        $name_ar = explode('-', $product_name_new);
        if ($GLOBALS['qos_ale_version'] == 'ale4') {
            try {
                $gap = "";
                $interval = new DateInterval($value['duration']);

                if ($interval->y != 0) {
                    $gap .= $interval->y . ' Years ';
                }
                if ($interval->m != 0) {
                    $gap .= $interval->m . ' Months ';
                }
                if ($interval->d != 0) {
                    $gap .= $interval->d . ' Days ';
                }
                if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0)) {
                    $gap .= ' And ';
                }
                if ($interval->i != 0) {
                    $gap .= $interval->i . ' Minutes ';
                }
                if ($interval->h != 0) {
                    $gap .= $interval->h . ' Hours ';
                }
            } catch (Exception $e) {
                $gap = "";
            }
            $gap_ar = explode(" ", $gap);
            $duration_val = $gap_ar[0];
            $name_ar = explode('-', $product_name_new);
        } else {
            $duration = explode('-', str_replace(' ', '-', split_from_num($name_ar[3])));
            $duration_val = $duration[0];
            //$duration_type = $duration[1];

            $duration_type = '';
            if ($duration[1] == 'Day') {
                $duration_type = 'Days';
            } else {
                $duration_type = $duration[1];
            }

            $name_ar[3] = $duration_val . " " . $duration_type;
        }

        $qos_arr = explode('-', $value['QOS']);
        $n = sizeof($qos_arr) - 1;
        $qos_new = substr($qos_arr[$n], 0, -1);

        if (strlen($name_ar[3]) < 1) {
            $name_ar[3] = $GLOBALS['qos_ale_version'] == 'ale4' ? $gap : $name_ar[2];
            $name_ar[2] = $qos_new;
        }

        $dat_ar = ["product" => split_from_num($name_ar[3]), "product_id" => $value['product_code'], "id" => $value['product_id'], "qos" => $qosspeed, "duration_val" => $duration_val];
        if (array_key_exists($name_ar[2], $qos)) {
            array_push($qos[$name_ar[2]], $dat_ar);
        } else {
            $qos[$name_ar[2]] = [$dat_ar];
        }
    }
    //print_r($qos);
    //exit();
    return $qos;
}

function split_from_num($a)
{

    $num = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    for ($i = 0; $i < strlen($a); $i++) {
        if (!in_array($a[$i], $num)) {
            $pos = $i;
            break;
        }
    }
    //echo $pos;
    //echo substr($a,0,$pos);
    //echo substr($a,$pos,strlen($a)-$pos);
    return substr($a, 0, $pos) . " " . ucfirst(substr($a, $pos, strlen($a) - $pos));
}

function aasort(&$array, $key)
{
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}

if (isset($_GET['update_ssid'])) {
    if ($_SESSION['guestnet_tab_1_MOD_SECRET'] == $_GET['token']) { //refresh validate

        $i = $_GET['n'];
        $ssid_name = $_GET['ssid_old'];
        $ssid_network_id = $_GET['network_id'];
        //  $ssid_description = $_POST['description'];
        $wlan_name = $_GET['name'];
        $mod_ssid = trim($_GET['ssid_new']);

        if ($ori_user_type != 'SALES') {
            $policyvar = $db->getValueAsf("SELECT `policies` AS f FROM `exp_policies` WHERE `policy_code`='SSID_name'");

            $policyvarmod = str_replace(",", "|", $policyvar);

            if (preg_match("#\A(" . $policyvarmod . ")\Z#i", $mod_ssid) == 0) {


                //   $old_loc_name = $_POST['old_location_name'];
                $loc_name = $_POST['location_name'];
                $mac_array = $_POST['ap'];
                $num_of_mac = count($mac_array);
                //$zone_id=$db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
                $tunnel = $db->getValueAsf("SELECT tunnel_type AS f FROM exp_mno_distributor WHERE distributor_code='$user_distributor'");
                // API CALL **********************
                //modifynetwork($zoneid,$id,$name,$ssid,$description)
                $api_result = $wag_obj->modifynetwork($zone_id, $ssid_network_id, $wlan_name, $mod_ssid, $loc_name, $tunnel);

                parse_str($api_result, $api_resp);
                //$status_code=200;
                // echo $status_code;
                // echo $Description;
                if ($api_resp['status_code'] == 200) {


                    $archive_q = "INSERT INTO `exp_locations_ssid_archive` (ssid,wlan_name,description,create_date,distributor,create_user,archive_by,archive_date,`status`)
                    SELECT ssid,wlan_name,description,create_date,distributor,create_user,'$user_distributor',NOW(),'update' FROM `exp_locations_ssid` WHERE ssid='$ssid_name'";

                    $archive_ssid = $db->execDB($archive_q);


                    $update_ssid_q = "UPDATE `exp_locations_ssid` SET `ssid`='$mod_ssid' WHERE `distributor`='$user_distributor' AND `ssid`='$ssid_name'";
                    $update_ssid = $db->execDB($update_ssid_q);
                    if ($update_ssid === true) {
                        $rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_themes'");
                        //$rowe = mysql_fetch_array($br);
                        $auto_increment = $rowe['Auto_increment'];

                        $theme_unique_id = 'th_en_' . $auto_increment;

                        $is_enable = '1';
                        if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $system_package) == 'YES' || $package_features == "all") {
                            if ($old_loc_name == '') {
                                $create_group_tag_q = "REPLACE INTO `exp_mno_distributor_group_tag` (
                                              `tag_name`,
                                              `description`,
                                              `distributor`,
                                              `theme_name`,
                                              `create_date`,
                                              `create_user`,
                                              `last_update`
                                            )
                                            VALUES
                                              (
                                                '$loc_name',
                                                '$loc_name',
                                                '$user_distributor',
                                                '$theme_unique_id',
                                                NOW(),
                                                '$user_name',
                                                NOW())";
                                $db->execDB($create_group_tag_q);
                            } else {
                                $update_group_tag_q = "UPDATE `exp_mno_distributor_group_tag` SET `tag_name`='$loc_name',`description`='$loc_name' WHERE `distributor`='$user_distributor' AND `tag_name`='$old_loc_name' ";
                                $db->execDB($update_group_tag_q);
                            }
                            for ($k = 0; $k < $num_of_mac; $k++) {
                                $insert_ap = "REPLACE INTO `exp_locations_ap_ssid` (
                              `ap_id`,
                              `network_id`,
                              `location_ssid`,
                              `group_tag`,
                              `distributor`,
                              `distributor_type`,
                              `is_enable`,
                              `create_date`,
                              `last_update`
                            )
                            VALUES
                              (
                                '$mac_array[$k]',
                                '$ssid_network_id',
                                '$mod_ssid',
                                '$loc_name',
                                '$user_distributor',
                                '$distributor_type',
                                '$is_enable',
                                NOW(),
                                NOW()
                              ) ";
                                $db->execDB($insert_ap);
                            }
                        } elseif ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $system_package) == 'NO') {
                            /*for ($k = 0; $k < $num_of_mac; $k++) {
                    $insert_ap = "UPDATE `exp_locations_ap_ssid` SET
                              `location_ssid`='$mod_ssid'
                              WHERE `ap_id`='$mac_array[$k]'";
                    $db->execDB($insert_ap);
                }*/
                            $insert_ap = "UPDATE `exp_locations_ap_ssid` SET
                              `location_ssid`='$mod_ssid'
                              WHERE `distributor`='$user_distributor' AND `location_ssid`='$ssid_name'";
                            $db->execDB($insert_ap);
                        }


                        //server log
                        $create_log->save('3002', $message_functions->showNameMessage('guest_ssid_update_success', $mod_ssid), '');

                        $_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('guest_ssid_update_success', $mod_ssid) . "</strong></div>";
                    } else {


                        $db->userErrorLog('2002', $user_name, 'script - ' . $script);

                        //server log
                        $create_log->save('2002', $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid), '');

                        $_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid, '2002') . "</strong></div>";
                    }
                } else {
                    $db->userErrorLog('2009', $user_name, 'script - ' . $script);

                    //server log
                    $create_log->save('2009', $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid), '');

                    $_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid, '2009') . "</strong></div>";
                }
            } else {

                $db->userErrorLog('2011', $user_name, 'script - ' . $script);

                //server log
                $create_log->save('2011', $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid), '');

                $_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('guest_ssid_update_error', $mod_ssid, '2011') . "</strong></div>";
            }
        } else {

            $_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showNameMessage('guest_ssid_update_success', $mod_ssid) . "</strong></div>";
        }
    } //key validation
    else {
        $db->userErrorLog('2004', $user_name, 'script - ' . $script);

        //server log
        $create_log->save('2004', $message_functions->showMessage('transection_fail'), '');

        $_SESSION['msg2'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>" . $message_functions->showMessage('transection_fail', '2004') . "</strong></div>";
        //header('Location: location.php?t=3');

    }
}

$tab_secret = md5(uniqid(rand(), true));
$_SESSION['guestnet_tab_1_MOD_SECRET'] = $tab_secret;
?>
<!-- <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" /> -->

<style type="text/css">
    @media (max-width: 480px) {
        #feild_gp_taddg_divt1 .form-group .net_div {
            width: 100%;
        }

        #feild_gp_taddg_divt1 .net_div .net_div_child:nth-child(1) {
            width: 50%;
            margin-bottom: 10px;
        }

    }

    @media (min-width: 1200px) {
        select.span2 {
            width: 133px;
        }
    }

    label img {
        margin-left: 10px;
    }

    .tablesaw-bar {
        width: 80%;
        margin-left: 20%;
    }
</style>


<div <?php if (isset($tab_guestnet_tab_1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_1">
    <!-- Tab 1 start-->

    <div id="guest_modify_network"></div>

    <?php
    if (isset($_SESSION['msg2'])) {

        echo $_SESSION['msg2'];

        unset($_SESSION['msg2']);
    }
    ?>

    <h1 class="head">
        Manage Network Name, QoS and Schedule. <img data-toggle="tooltip" title="Your account comes with a default SSID name. This name can be changed to fit your business. Name your network so your guests can easily identify and connect. " src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
    </h1>

    <br />

    <?php if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $system_package) == 'NO') {

    ?>

        <div class="controls col-lg-5 form-group">
            <a href="?t=guestnet_tab_1&st=guestnet_tab_1&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
        </div>


    <?php } ?>


    <div style="display: none;margin-bottom: 40px;" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>×</button><strong>


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

        <script>
            function checkChange(id, val, now) {
                if (now.value == val) {
                    $('#check_update' + id).val('no');
                } else {
                    $('#check_update' + id).val('yes');
                }
            }

            function checkChange1(id, val, now) {
                if (now.value == val) {
                    $('#check1_update' + id).val('no');
                } else {
                    $('#check1_update' + id).val('yes');
                }
            }
        </script>
        <div class="widget widget-table action-table">
            <div class="widget-header">
                <!-- <i class="icon-th-list"></i> -->
                <h3></h3>
            </div>
            <div class="widget-content table_response" id="ssid_tbl" style="position: relative;width: 930px;">
                <div style="overflow-x:auto;">
                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                        <thead>
                            <tr>
                                <th scope="col" colspan="2" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID Name</th>

                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Product <span style="text-transform: none;">(QoS & Duration)</span></th>

                                <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Duration</th>-->
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3" style="width: 10%;">Broadcast Status</th>
                                <!--<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Schedule</th>-->
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

                            $ssid_q = "SELECT sa.ssid_broadcast,p.`product_code`,sa.shedule_uniqu_id,s.product_id,s.duration_id,s.id, d.`zone_id`, count(DISTINCT a.`ap_code`) AS ap_count,s.`wlan_name`,s.`ssid`,s.`network_id` ,l.`group_tag`,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                FROM
                                                                `exp_mno_distributor` d 
                                                                LEFT JOIN
                                                                `exp_products_distributor` p
                                                                ON d.`distributor_code`=p.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ssid` s
                                                                ON s.`distributor`=d.`distributor_code` AND network_method='GUEST'
                                                                LEFT JOIN
                                                                `exp_mno_distributor_aps` a
                                                                ON s.`distributor`= a.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ap_ssid` l
                                                                ON l.`distributor`= a.`distributor_code`
                                                                LEFT JOIN exp_distributor_network_schedul_assign sa ON s.network_id=sa.network_id AND s.distributor=sa.distributor

                                                                WHERE  d.`distributor_code`='$user_distributor' -- AND p.ssid='All'
                                                                GROUP BY s.`ssid`";
                            $ssid_res = $db->selectDB($ssid_q);
                            $i = 0;

                            //                            $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST'";
                            //                            $qos_data = $db->selectDB($qos_q);
                            $display_data = product_name_convertion($mno_id, $db,$user_distributor);


                            $duration_q = "SELECT profile_code,duration FROM exp_products_duration WHERE distributor='$mno_id' AND is_default='1'";
                            $duration_data = $db->selectDB($duration_q);

                            $no = 0;

                            if ($ssid_res['rowCount'] > 0) {
                                $ssids = [];

                                foreach ($ssid_res['data'] as $ssid_name) {
                                    $product_new = "";
                                    echo '<form id="ssid_form' . $i . '" name="ssid_form' . $i . '" method="post">';
                                    echo '<input type="hidden" name="check_update' . $i . '" class="check_update" id="check_update' . $i . '" value="no"><input type="hidden" name="check1_update' . $i . '" class="check_update" id="check1_update' . $i . '" value="no">';
                                    $bandwidth_input = '<input  type="hidden" id="qos_' . $i . '" value=""><input class="span2" type="text" readOnly value="Select QoS">&nbsp;&nbsp;';

                                    $no++;
                                    $qos_options = "";
                                    $duration_options = "";
                                    $selected_qos = "";
                                    $selected_duration = "";
                                    //$product_new = $db->getValueAsf("SELECT product_code as f FROM exp_products_distributor WHERE distributor_code='$user_distributor' AND ssid='$ssid_name[network_id]' AND network_type='GUEST'");
                                    //echo $get_ssid_product_q="SELECT p.product_code,s. AS f FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id` WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'";

                                    if ($GLOBALS['qos_ale_version'] == 'ale4') {

                                        $get_ssid_product_q = "SELECT p.product_code, d.`duration` FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id`  
                                    JOIN exp_products_duration d ON s.`duration_id`=d.`profile_code`
                                    WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'";
                                    } else {
                                        $get_ssid_product_q = "SELECT p.product_code FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id`  
                                    WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'";
                                    }


                                    $product_new_data = $db->select1DB($get_ssid_product_q);
                                    $product_new = $product_new_data['product_code'];
                                    //$product_new_due = ;
                                    /*
                                     * extract duration
                                     * */
                                    try {
                                        $gap = "";
                                        $interval = new DateInterval($product_new_data['duration']);

                                        if ($interval->y != 0) {
                                            $gap .= $interval->y . ' Years ';
                                        }
                                        if ($interval->m != 0) {
                                            $gap .= $interval->m . ' Months ';
                                        }
                                        if ($interval->d != 0) {
                                            $gap .= $interval->d . ' Days ';
                                        }
                                        if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0)) {
                                            $gap .= ' And ';
                                        }
                                        if ($interval->i != 0) {
                                            $gap .= $interval->i . ' Minutes ';
                                        }
                                        if ($interval->h != 0) {
                                            $gap .= $interval->h . ' Hours ';
                                        }
                                    } catch (Exception $e) {
                                        $gap = "";
                                    }
                                    /*
                                     * end
                                     * */

                                    if (strlen($product_new) < 1) {
                                        //$product_new = $ssid_name['product_code'];
                                        $product_new = $db->getValueAsf("SELECT `product_code` AS f FROM `exp_products_distributor` WHERE `distributor_code` = '$user_distributor' AND `network_type`='GUEST'  AND `ssid`='All'");
                                    }


                                    $qos_profile = array();
                                    $qos_profile_k = array();
                                    $qos_profile_g = array();
                                    if (count($display_data) > 0) {
                                        $selected_key = '';
                                        foreach ($display_data as $display_key => $display_value) {
                                            if (strlen($display_key) > 0) {
                                                $sel_0 = '';
                                                foreach ($display_value as $display_value_value) {
                                                    if ($GLOBALS['qos_ale_version'] == 'ale4') {
                                                        //                                                $comp_ar = explode('-',$display_value_value['product_id']);
                                                        //                                                unset($comp_ar[0]);
                                                        $comp_val = $display_value_value['product_id'] . "M";
                                                        $speed = "Mbps";
                                                    } else {
                                                        $comp_val = $display_value_value['product_id'];
                                                        $speed = $display_value_value['qos'];
                                                        if ($speed == 'M') {
                                                            $speed = "Mbps";
                                                        } elseif ($speed == 'G') {
                                                            $speed = "Gbps";
                                                        } else {
                                                            $speed = "Kbps";
                                                        }
                                                    }

                                                    if ($product_new == $comp_val) {
                                                        $selected_qos = $display_key;
                                                        $sel_0 = 'selected';
                                                        $selected_key = $display_key;
                                                    }
                                                }
                                                $ab = substr($display_key, 0, 2);
                                                if (!is_numeric($ab)) {
                                                    $ab = substr($display_key, 0, 1);
                                                }
                                                $bb = substr($display_key, -2);
                                                if (!is_numeric($bb)) {
                                                    $bb = substr($display_key, -1);
                                                }
                                                if ($speed == 'Mbps') {
                                                    array_push($qos_profile, array(
                                                        'product' => $display_key,
                                                        'qosval' => $ab,
                                                        'qosval2' => $bb,
                                                        'speed' => $speed,
                                                        'select' => $sel_0
                                                    ));
                                                } elseif ($speed == 'Gbps') {
                                                    array_push($qos_profile_g, array(
                                                        'product' => $display_key,
                                                        'qosval' => $ab,
                                                        'qosval2' => $bb,
                                                        'speed' => $speed,
                                                        'select' => $sel_0
                                                    ));
                                                } else {
                                                    array_push($qos_profile_k, array(
                                                        'product' => $display_key,
                                                        'qosval' => $ab,
                                                        'qosval2' => $bb,
                                                        'speed' => $speed,
                                                        'select' => $sel_0
                                                    ));
                                                }

                                                //$qos_options.= "<option ".$sel_0." value='".$display_key."'>".$display_key." ".$speed."</option>";
                                            }
                                        }
                                        $sel_1 = '';
                                        aasort($display_data[$selected_key], 'duration_val');
                                        CommonFunctions::aaasort($qos_profile, 'qosval', 'qosval2');
                                        CommonFunctions::aaasort($qos_profile_g, 'qosval', 'qosval2');
                                        CommonFunctions::aaasort($qos_profile_k, 'qosval', 'qosval2');

                                        foreach ($qos_profile_k as $value) {

                                            $qos_options .= "<option " . $value[select] . " value='" . $value[product] . "'>" . $value[product] . " " . $value[speed] . "</option>";
                                        }
                                        foreach ($qos_profile as $value) {

                                            $qos_options .= "<option " . $value[select] . " value='" . $value[product] . "'>" . $value[product] . " " . $value[speed] . "</option>";
                                        }
                                        foreach ($qos_profile_g as $value) {

                                            $qos_options .= "<option " . $value[select] . " value='" . $value[product] . "'>" . $value[product] . " " . $value[speed] . "</option>";
                                        }

                                        foreach ($display_data[$selected_key] as $qos_value) {
                                            if ($GLOBALS['qos_ale_version'] == 'ale4') {
                                                $comp_val = str_replace(" ", "", $gap) == str_replace(" ", "", $qos_value['product']);
                                            } else {
                                                $comp_val = $product_new == $qos_value['product_id'];;
                                            }
                                            if ($comp_val) {
                                                $selected_duration = $qos_value[product];
                                                $sel_1 = 'selected';
                                            } else {

                                                $sel_1 = '';
                                            }
                                            if (strlen($qos_value[product]) > 0) {
                                                $duration_options .= "<option " . $sel_1 . " value='" . $qos_value[product] . "'>" . $qos_value[product] . "</option>";
                                            }
                                        }
                                    }



                                    $gorup_tag = $ssid_name['group_tag'];

                                    if (strlen($gorup_tag) < 1) {
                                        $location_id = 'N/A';
                                    } else {
                                        $location_id = $gorup_tag;
                                        //$all_na = "0";
                                    }
                                    $all_na = $ssid_name['ap_count'];


                                    $datanew =  '<input  id="wlan_name_' . $i . '" name="wlan_name_' . $i . '" type="hidden" value="' . $ssid_name[wlan_name] . '" >
                                <input  id="network_id_' . $i . '" name="network_id_' . $i . '" type="hidden" value="' . $ssid_name[network_id] . '" >';

                                    $ssidname = '<script id="script_' . $i . '" type="text/javascript">
                                    $(document).ready(function() {
                                        
                                    $(\'#update_ssid_' . $i . '\').easyconfirm({locale: {

                                            title: \'SSID Name \',

                                            text: \'Are you sure you want to update the SSID?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                            button: [\'Cancel\',\' Confirm\'],

                                            closeText: \'close\'

                                             }});
                                    $(\'#update_ssid_' . $i . '\').click(function() {
                                            var ssid_new = $("#mod_ssid_name_' . $i . '").val();

                                            if(ssid_new){
                                                window.location =  "?t=guestnet_tab_1&token=' . $tab_secret . '&update_ssid&n=' . $i . '&ssid_old=' . $ssid_name[ssid] . '&network_id=' . $ssid_name[network_id] . '&name=' . $ssid_name[wlan_name] . '&ssid_new="+ssid_new
                                            }else{
                                                $("#ap_id").html("Please Set Network Name");
                                                $("#servicearr-check-div").show();
                                                $("#sess-front-div").show();
                                            }
                                            });
                                        });
                                    </script>';

                                    if (!empty($ssid_name['ssid'])) {
                                        $ssids[] = $ssid_name['ssid'];
                                        echo  "<td  style='font-size:15.5px'>" . $ssid_name['ssid'] . " <img data-toggle='tooltip' title='Easily change the network name that is broadcast by entering a new name in the field and click the UPDATE link.' src='layout/OPTIMUM/img/help.png' style='width: 18px;cursor: pointer;'></td>";
                                    } else {
                                        echo  "<td></td>";
                                    }
                                    echo '<td style="border-left-width: 0;>"
                                    <input type="hidden" id="ssid_name_' . $i . '" name="ssid_name_' . $i . '" value="' . $ssid_name['ssid'] . '" data-bv-field="ssid_name"> 
                                    <input type="text" class="span2 form-control mod_ssid_name" id="mod_ssid_name_' . $i . '" name="mod_ssid_name_' . $i . '"  placeholder="Change Network Name"  data-bv-field="mod_ssid_name" onInput="ssidcheckLength(32,this);validateDuplicate(this,\'update_ssid_' . $i . '\',\'script_' . $i . '\');" > <img data-toggle="tooltip" title="Note: The SSID Name is limited to 32 characters and may include a combination of letters, numbers, and the special characters “_” and “-“ (other special characters are not available for SSID names). The SSID Name cannot start with prohibited words such as “guest,” “administrative,” “admin,” “test,” “demo,” or “production.” These words cannot be used without other descriptive words." src="layout/OPTIMUM/img/help.png" style="width: 18px;cursor: pointer;">
                                    <a style="margin-left: 8px;" type="submit" name="update_ssid_' . $i . '" id="update_ssid_' . $i . '" class="btn btn-small btn-primary">Update</a>' . $ssidname . $datanew . '
                                    </td> ';

                                    if (1 == 1) {
                                        $bandwidth = '<select onchange="checkChange(' . $i . ',\'' . $selected_qos . '\',this);change_qos(\'' . $i . '\');" class="span2" id="qos_' . $i . '">
                                                    <option value="">Select QoS</option>
                                                    ' . $qos_options . '
                                                </select>&nbsp;&nbsp;';
                                    } else {
                                        $bandwidth = $bandwidth_input;
                                    }



                                    //echo    "<td>".$bandwidth."</td>";

                                    $update = '<a style="margin-left: 8px;" id="BANDWITH_' . $i . '"  class="btn btn-small btn-info bandwidthUpdate">Update</a>
                                    <script type="text/javascript">
                                    $(document).ready(function() {

                                    $(\'#BANDWITH_' . $i . '\').easyconfirm({locale: {

                                            title: \'Update Bandwith Profile \',

                                            text: \'Are you sure you want to update this?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                            button: [\'Cancel\',\' Confirm\'],

                                            closeText: \'close\'

                                             }});

                                         $(\'#BANDWITH_' . $i . '\').click(function() {
                                            
                                            bandwidthUpdate(' . $i . ');
                                            });

                                        });
                                    </script>';

                                    $duration = '<select onchange="checkChange1(' . $i . ',\'' . $selected_duration . '\',this);" class="span2" id="duration_' . $i . '"><option value="">Select Duration</option>' . $duration_options . '</select>';

                                    echo "<td style='min-width: 275px;'><div style='display: inline-block; vertical-align: top; margin-bottom: 5px'>" . $bandwidth . "</div><div style='display: inline-block;'>" . $duration . $update . "</div>";

                                    echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";
                                    echo "<input type='hidden' name='ssid_id_" . $i . "' id='ssid_id_" . $i . "' value='$ssid_name[network_id]'/></td>";

                                    //echo $ssid_name['ssid_broadcast'];
                                    if ($ssid_name['ssid_broadcast'] == 'AlwaysOn') {
                                        $ssid_status = '1';
                                    } else if ($ssid_name['ssid_broadcast'] == 'Customized') {
                                        $ssid_status = '2';
                                    } else {
                                        $ssid_status = '3';
                                    }
                                    $ssid_on = $ssid_status == '1' ? '  checked   ' : '';

                                    /*$schedule = '<div class="toggle1">
                                    <input style="z-index: -1;" class="hide_checkbox" '.$ssid_on.'  id="ssid_brodcast'.$i.'" type="checkbox">';
                                   
                                    if($ssid_status=='1'){
                                        $schedule.='
                                        <a id="ssid_always_on_'.$i.'"> <span style="cursor: pointer" class="toggle1-off-dis">OFF</span></a><span class="toggle1-on">ON</span>';

                                     }else if($ssid_status=='2'){
                                        
                                        $schedule.='
                                        <a id="ssid_always_on_'.$i.'"> <span style="cursor: pointer" class="toggle1-off-dis">OFF</span></a><span class="toggle1-on" style="background-color: #808080;">ON</span>';
                                     }else{
                                        $schedule.='<a id="ssid_always_on_'.$i.'"> <span style="cursor: pointer" class="toggle1-on-dis">ON</span> </a>
                                        <span class="toggle1-off">OFF</span>';

                                     }
                                    $schedule.='</div>';*/

                                    /*$schedule2 = '<input type="radio" '.($ssid_status=='1'?'checked':'').' id="ssid_always_on_'.$i.'" href="javascript:void();" name="broadcast_status_'.$i.'" class="ssidc_'.$i.'"> <a class="btn btn-primary" style="display: inline-block;margin-left: -19px;min-width: 36px;font-size: 15px !important;color:#000">&nbsp;On</a>';

                                    $schedule2 .= '<input type="radio" '.($ssid_status=='3'?'checked':'').' id="ssid_always_off_'.$i.'" href="javascript:void();" name="broadcast_status_'.$i.'" class="ssidc_'.$i.'"> <a class="btn btn-primary" style="display: inline-block;margin-left: -19px;min-width: 36px;font-size: 15px !important;color:#000">&nbsp;Off</a>';

                                    $schedule2 .='<div style="display: inline-block;" data-toggle="tooltip" '.(empty($ssid_name['shedule_uniqu_id'])?'title="There is no Schedule set for this SSID. Click the Schedule text link or select the Schedule tab to get to the Schedule configuration page."':'').'>
                                                  <input type="radio" '.($ssid_status=='2'?'checked':'').' '.(empty($ssid_name['shedule_uniqu_id'])?'disabled="disabled"  ':'').' name="broadcast_status_'.$i.'" class="ssidc_'.$i.'" id="ssid_schedule_'.$i.'" href="javascript:void();" name="broadcast_status_'.$i.'" class="ssidc_'.$i.'" > 
                                                  <a class="btn btn-primary" href="?t=guestnet_schedule" style="display: inline-block;margin-left: -19px;font-size: 15px !important;">&nbsp;Schedule</a></div>';*/

                                    $schedule2 = $ssid_status == '1' ? 'On' : ($ssid_status == '2' ? 'Schedule' : 'Off');
                                    // echo "<td >".$schedule."</td>";
                                    echo "<td ><a style='display: inline-block;min-width: 36px;font-size: 15px !important;color:#000;cursor: default;text-decoration: none !important;'>&nbsp;" . $schedule2 . "</a>";
                                    echo '<script>'; ?>

                                    function eneble_she<?php echo $no; ?>(){
                                    $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                    window.location.href = 'modules/ssid/2-submit?enable_p_schedule&network_id=<?php echo $ssid_name['network_id'] ?>';

                                    }

                                    <?php if ($ssid_status != '3') { ?>


                                        $(document).ready(function() {
                                        $('#ssid_always_off_<?php echo $i ?>').easyconfirm({locale: {
                                        title: 'SSID Disable',
                                        text: 'Are you sure you want to disable SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        button: ['Cancel',' Confirm'],
                                        closeText: 'close'
                                        }});
                                        $('#ssid_always_off_<?php echo $i ?>').click(function() {
                                        $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                        ssidBroadcast("off","<?php echo $ssid_name['network_id']; ?>","<?php echo $ssid_name['ssid']; ?>");
                                        });
                                        });

                                    <?php }

                                    if ($ssid_status != '1') { ?>


                                        $(document).ready(function() {
                                        $('#ssid_always_on_<?php echo $i ?>').easyconfirm({locale: {
                                        title: 'SSID Enable',
                                        text: 'Are you sure you want to enable SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        button: ['Cancel',' Confirm'],
                                        closeText: 'close'
                                        }});
                                        $('#ssid_always_on_<?php echo $i ?>').click(function() {
                                        $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                        ssidBroadcast("on","<?php echo $ssid_name['network_id']; ?>","<?php echo $ssid_name['ssid']; ?>");
                                        });
                                        });


                                    <?php }
                                    if ($ssid_status != '2' && !empty($ssid_name['shedule_uniqu_id'])) { ?>
                                        $(document).ready(function() {
                                        $('#ssid_schedule_<?php echo $i ?>').easyconfirm({locale: {
                                        title: 'Schedule Enable',
                                        text: 'Are you sure you want to enable schedule?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        button: ['Cancel',' Confirm'],
                                        closeText: 'close'
                                        }});
                                        $('#ssid_schedule_<?php echo $i ?>').click(function() {
                                        eneble_she<?php echo $no ?>();
                                        });
                                        });


                            <?php }

                                    echo '</script>';



                                    echo "</td></tr></form>";
                                    $i++;
                                }

                                if ($all_na == 0) {

                                    echo '<style> .all_na{ display: block !important; } </style>';
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br />


    </form>

</div>
<script type="text/javascript">
    $('.bandwidthUpdate').click(function(event) {
        event.preventDefault();
    });

    function change_qos(elem) {
        var qos = $('#qos_' + elem).val();
        var net_id = $('#ssid_id_' + elem).val();

        $('#duration_' + elem).empty();

        var formData = {
            qos: qos,
            dis: "<?php echo $user_distributor; ?>",
            task: 'SyncDuaration',
            network_id: net_id
        };
        //console.log(formData);
        $.ajax({
            url: "ajax/updateSSIDBandwidth.php",
            type: "POST",
            data: formData,
            success: function(result) {
                //console.log(result);
                //var obj = JSON.parse(result);

                $('#duration_' + elem).append(result);

            }
        });
    }

    function bandwidthUpdate(elem) {
        var qos = $('#qos_' + elem).val();
        var dure = $('#duration_' + elem).val();
        var net_id = $('#ssid_id_' + elem).val();
        $('#ap_id').empty();
        if (!qos) {
            //alert("Please select Bandwidth profile");
            $('#ap_id').append('Please select Bandwidth profile');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            return false;
        }
        if (!dure) {
            $('#ap_id').append('Please select Duration profile');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            //alert("Please select Duration profile");
            return false
        }
        $("#guest_modify_network").empty();
        $('html,body').scrollTop(0);
        var formData = {
            qos: qos,
            dure: dure,
            dis: "<?php echo $user_distributor; ?>",
            task: 'updateProduct',
            network_id: net_id
        };
        //console.log(formData);
        $.ajax({
            url: "ajax/updateSSIDBandwidth.php",
            type: "POST",
            data: formData,
            success: function(result) {
                var obj = JSON.parse(result);
                if (obj.status == 'success') {
                    $("#guest_modify_network").append(obj.message);
                    $("#check_update" + elem).val('no');
                    $("#check1_update" + elem).val('no');
                } else {
                    $("#guest_modify_network").append(obj.message);
                }
            }
        });
    }

    function ssidBroadcast(val1, val2, val3) {
        /*var value=$('#auto_passcode:checked').val();*/
        /*alert(value);*/
        if (val1 == 'on') {
            window.location = 'modules/ssid/2-submit?ssid_broadcast&t=guestnet_tab_1&status=1&network_id=' + val2 + '&ssid=' + val3 + '&secret=<?php echo $tab_secret; ?>';
        } else {
            window.location = 'modules/ssid/2-submit?ssid_broadcast&t=guestnet_tab_1&status=0&network_id=' + val2 + '&ssid=' + val3 + '&secret=<?php echo $tab_secret; ?>';
        }
    }
</script>

<!--SSID Name validations-->
<script type="text/javascript">
    $(document).ready(function() {
        $('.mod_ssid_name').bind("cut copy paste", function(e) {
            e.preventDefault();
        });


        $(".mod_ssid_name").keypress(function(event) {
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

        $(".mod_ssid_name").blur(function(event) {

            var temp_ssid_name = $(event.target).val();
            var temp_ssid_id = event.target.id;
            var temp_id = temp_ssid_id.split('_')[3];
            if (checkWords(temp_ssid_name.toLowerCase())) {

                $(event.target).val("");
                //$('#invalid_ssid').css('display', 'inline-block');
                //$("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                $('#update_ssid_' + temp_id).attr('disabled', true);
            } else {
                if (temp_ssid_name.length > 0) {
                    $('#update_ssid_' + temp_id).attr('disabled', false);
                }
            }
        });

        $(".mod_ssid_name").keyup(function(event) {

            var temp_ssid_name;
            temp_ssid_name = $(event.target).val();
            var lastChar = temp_ssid_name.substr(temp_ssid_name.length - 1);
            var lastCharCode = lastChar.charCodeAt(0);

            if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 45 || lastCharCode == 95) || (48 <= lastCharCode && lastCharCode <= 57) ||
                    (65 <= lastCharCode && lastCharCode <= 90) ||
                    (97 <= lastCharCode && lastCharCode <= 122))) {
                $(event.target).val(temp_ssid_name.substring(0, temp_ssid_name.length - 1));
            }

            temp_ssid_name = $(event.target).val();
            var temp_ssid_id = event.target.id;
            var temp_id = temp_ssid_id.split('_')[3];
            if (checkWords(temp_ssid_name.toLowerCase())) {

                $(event.target).val("");
                //   $('#invalid_ssid').css('display', 'inline-block');
                //   $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                $('#update_ssid_' + temp_id).attr('disabled', true);
            } else {
                if (temp_ssid_name.length > 0) {
                    $('#update_ssid_' + temp_id).attr('disabled', false);
                }
            }
        });


        function past() {

            setTimeout(function() {

                var temp_ssid_name = $('#mod_ssid_name').val();


                if (checkWords(temp_ssid_name.toLowerCase())) {

                    $("#mod_ssid_name").val("");
                    //   $('#invalid_ssid').css('display', 'inline-block');

                    //   $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");

                    $('#update_ssid').attr('disabled', true);
                } else {
                    //$('#invalid_ssid').hide();
                }


            }, 100);

        }


        function checkWords(inword) {

            var words = <?php
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

            } else {

                var regex = /^[a-zA-Z0-9_-]+$/;

                if (regex.test(inword) == false) {

                    $('#update_ssid').attr('disabled', true);
                }

                return false;

            }


        }
    });

    function ssidcheckLength(len, ele) {
        var fieldLength = ele.value.length;
        if (fieldLength <= len) {
            return true;
        } else {
            var str = ele.value;
            str = str.substring(0, str.length - 1);
            ele.value = str;
        }
    }

    function validateDuplicate(ele, id, script) {
        var data = <?php echo json_encode($ssids); ?>;

        if (data.includes(ele.value)) {
            //console.log('off');
            $("#" + id).off('click');
            $("#" + id).prop('title', 'Same SSID Name exists');
            $("#" + id).attr("data-toggle", "tooltip");
            $('[data-toggle="tooltip"]').tooltip();
        } else {
            $("#" + id).prop('title', 'Are you sure you want to update the SSID?');
            var attr = $("#" + id).attr('data-toggle');
            if (typeof attr !== typeof undefined && attr !== false) {
                //alert();
                eval(document.getElementById(script).innerHTML);
                $("#" + id).removeAttr('title');
                $("#" + id).removeAttr("data-toggle");
            }
        }
    }
</script>