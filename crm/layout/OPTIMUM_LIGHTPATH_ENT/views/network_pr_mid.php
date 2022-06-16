<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<script id="tootip_script">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div class="tab-content">

    <?php

    if (isset($_SESSION['prtab10'])) {
        echo $_SESSION['prtab10'];
        unset($_SESSION['prtab10']);
    }


    if (isset($_SESSION['prtab9'])) {
        echo $_SESSION['prtab9'];
        unset($_SESSION['prtab9']);
    }
    if (isset($_SESSION['prtab21'])) {
        echo $_SESSION['prtab21'];
        unset($_SESSION['prtab21']);
    }
    ?>


    <?php if (in_array("NET_PRI_ENCRYP", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab7)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_1">
            <!-- Tab 1 start-->


            <?php

            if (isset($_SESSION['prtab7'])) {
                echo $_SESSION['prtab7'];
                unset($_SESSION['prtab7']);
            }
            ?>






            <div id="guest_modify_network"></div>

            <?php
            $tags = array("<min>" => $passcode_min);
            //  print_r($tags);
            echo $message_functions->getNamePageContent('private_wifi_introduction', $system_package, $tags);

            ?>

            <br />


            <!--    password change form-->










        </div>
        <!-- Tab 1 End-->
    <?php
    }
    ?>









    <?php if (in_array("NET_PRI_SSID", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab10)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_4">


            <h1 class="head">
                Your backoffice and
                employees deserve privacy. <img data-toggle="tooltip" title='In a few simple steps, you will be up and running with your Private WiFi Service. Your Private WiFi Service is encrypted and password protected. This is separate from your Guest WiFi Service. As an added security feature, you have the option to show or hide your SSID name. If hidden you can still connect to the SSID if you know the SSID name.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
            </h1>



            <br />

            <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>×</button><strong>


                    <?php echo $message_functions->showMessage('no_aps_installed'); ?>

                </strong>
            </div>
            <div class="controls col-lg-5 form-group" style="position: absolute; z-index: 10;">
                <a href="?t=10&st=7&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary" style="align: left; "><i class="btn-icon-only icon-refresh"></i> Refresh</a>
            </div>
            <form id="update_private_ssid" autocomplete="off" name="update_private_ssid" class="form-horizontal" action="?t=10" method="post">


                <div class="widget widget-table action-table">

                    <!--  <div class="controls col-lg-5 form-group" >
                                                <a href="?t=10&st=7&action=sync_data_tab1&tocken=<? php // echo $secret; 
                                                                                                    ?>" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/> -->
                    <br>
                    <div class="widget-header">
                        <!-- <i class="icon-th-list"></i> -->
                        <h3>Private SSID</h3>
                    </div>
                    <div class="widget-content table_response" id="ssid_tbl">


                        <div style="overflow-x:auto;">

                            <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                <thead>

                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Private SSID</th>

                                        <!--      <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">WLAN Name</th> -->

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">SHOW SSID</th>

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Service Address</th>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">VLAN Number</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php
                                    $get_private_ssid_q = "SELECT d.ap_sync,d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.vlan,s.`ssid`,s.`network_id`, s.ssid_password, s.is_enable,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                                FROM
                                                                                `exp_mno_distributor` d
                                                                                LEFT JOIN
                                                                                `exp_locations_ssid_private` s
                                                                                ON s.`distributor`=d.`distributor_code`
                                                                                LEFT JOIN
                                                                                `exp_mno_distributor_aps` a
                                                                                ON s.`distributor`= a.`distributor_code`
                                                                                LEFT JOIN
                                                                                `exp_locations_ap_ssid_private` l
                                                                                ON a.`ap_code`=l.`ap_id`

                                                                                WHERE  d.`distributor_code`='$user_distributor'
                                                                                GROUP  BY   s.`ssid`";/*"SELECT  a.`ap_code`,s.`ssid`,s.`ssid_password`,s.`description`,s.`network_id`,s.`wlan_name`
                                                                                  FROM `exp_locations_ssid_private` s , `exp_mno_distributor_aps` a, `exp_mno_distributor` d
                                                                  WHERE s.`distributor`=d.`distributor_code` AND s.`distributor`= a.`distributor_code` AND
                                                                  s.`distributor`='$user_distributor' GROUP BY s.`ssid`"; */
                                    $get_private_ssid_res = $db->selectDB($get_private_ssid_q);
                                    $i = 0;
                                    foreach ($get_private_ssid_res['data'] as $get_private_ssid) {
                                        $ssid_name = $get_private_ssid['ssid'];
                                        $ssid_pass = $get_private_ssid['ssid_password'];
                                        $network_id = $get_private_ssid['network_id'];
                                        $wlanID = $get_private_ssid['wlan_name'];
                                        $vlanID = $get_private_ssid['vlan'];
                                        $is_enable = $get_private_ssid['is_enable'];
                                        $gorup_tag = $get_private_ssid['gorup_tag'];
                                        $ap_code = $get_private_ssid['ap_code'];
                                        $ap_sync = $get_private_ssid['ap_sync'];

                                        echo '<tr><td class="pr_ssid">';
                                        if ($ap_sync == '1' && empty($ssid_name)) {
                                            echo 'Loading...';
                                            echo '<script>
                                                                            $(function() {
                                                                                var formData={dis:"' . $user_distributor . '"};
                                                                                var check_count = 0;
                                                                                var check_ap_sync = () => $.ajax({
                                                                                  url : "ajax/checkSync.php",
                                                                                  type: "POST",
                                                                                  data : formData,
                                                                                  success: function(data)
                                                                                  {
                                                                                      if(data=="1"){
                                                                                          setTimeout(function(){ check_count++; check_ap_sync(); }, 5000);
                                                                                      }else {
                                                                                          $(".pr_ssid").html("<a href=\"javascript: location.reload();\" >Refresh</a>");
                                                                                      }
                                                                                  },
                                                                                  error: function (jqXHR, textStatus, errorThrown)
                                                                                  {
                                                                                      check_ap_sync();
                                                                                  }
                                                                              });
                                                                                
                                                                                check_ap_sync();
                                                                            });
                                                                            
                                                                        </script>';
                                        } else {
                                            echo $ssid_name;
                                        }
                                        echo '</td>';
                                        //echo'<td>'.$get_private_ssid['ap_code'].'</td>';
                                        //   echo'<td>'.$wlanID.'</td>';


                                        if (strlen($ap_code) < 1) {
                                            //echo 'sddsdsd';

                                        } else {
                                            $all_na = "0";
                                        }

                                        if ($ori_user_type != 'SALES') {
                                            if ($is_enable == 1) {

                                                //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                                                echo   '<td><div class="toggle1-l"><input checked class="hide_checkbox" type="checkbox"><a href="javascript:void();" id="CE_' . $network_id . '"><span class="toggle1-on-dis">SHOW</span></a><span class="toggle1-off">HIDE</span></div>';


                                                echo '

                                                                <script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CE_' . $network_id . '\').easyconfirm({locale: {

																			title: \'Show SSID\',

																			text: \'Are you sure you want to show this SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CE_' . $network_id . '\').click(function() {

																			window.location = "?t=10&token=' . $secret . '&show_modify=2&is_enable=0&id=' . $network_id . '"

																		});

																		});

																	</script>';
                                            } else {

                                                // echo '<td><font color=red><strong>DISABLED</strong></font></td>';



                                                ////
                                                echo   '<td><div class="toggle1-l"><input type="checkbox" class="hide_checkbox"><span class="toggle1-on">SHOW</span><a href="javascript:void();" id="ST_' . $network_id . '"><span class="toggle1-off-dis">HIDE</span></a></div>';


                                                echo '<script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#ST_' . $network_id . '\').easyconfirm({locale: {

																			title: \'Hide SSID\',

																			text: \'Are you sure you want to hide this SSID?&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#ST_' . $network_id . '\').click(function() {



																		window.location = "?t=10&token=' . $secret . '&show_modify=2&is_enable=1&id=' . $network_id . '"

																		});

																		});

																	</script>';
                                            }
                                        } else {
                                            $test = $_SESSION['testarray'];
                                            $reversed = array_reverse($test);
                                            if (in_array($ad_id, $reversed)) {
                                                $key = array_search($ad_id, $reversed);
                                                $a = $key - 1;

                                                if ($reversed[$a] == 0) {
                                                    $is_enable = 0;
                                                } else {
                                                    $is_enable = 1;
                                                }
                                            } //$test = array_reverse($reversed);
                                            $_SESSION['testarray'] = $test;

                                            if ($is_enable == 1) {

                                                //echo '<td><font color=green><strong>ENABLED</strong></font></td>';

                                                echo   '<td><div class="toggle1-l"><input checked class="hide_checkbox" type="checkbox"><a href="javascript:void();" id="CE_' . $network_id . '"><span class="toggle1-on-dis">SHOW</span></a><span class="toggle1-off">HIDE</span></div>';


                                                echo '

                                                                <script type="text/javascript">

                                  $(document).ready(function() {

                                  $(\'#CE_' . $network_id . '\').easyconfirm({locale: {

                                      title: \'Show SSID\',

                                      text: \'Are you sure you want to show this SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                      button: [\'Cancel\',\' Confirm\'],

                                      closeText: \'close\'

                                         }});

                                    $(\'#CE_' . $network_id . '\').click(function() {

                                      window.location = "?t=10&token=' . $secret . '&show_modify=2&is_enable=0&id=' . $network_id . '"

                                    });

                                    });

                                  </script>';
                                            } else {

                                                // echo '<td><font color=red><strong>DISABLED</strong></font></td>';



                                                ////
                                                echo   '<td><div class="toggle1-l"><input type="checkbox" class="hide_checkbox"><span class="toggle1-on">SHOW</span><a href="javascript:void();" id="ST_' . $network_id . '"><span class="toggle1-off-dis">HIDE</span></a></div>';


                                                echo '<script type="text/javascript">

                                  $(document).ready(function() {

                                  $(\'#ST_' . $network_id . '\').easyconfirm({locale: {

                                      title: \'Hide SSID\',

                                      text: \'Are you sure you want to hide this SSID?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                      button: [\'Cancel\',\' Confirm\'],

                                      closeText: \'close\'

                                         }});

                                    $(\'#ST_' . $network_id . '\').click(function() {



                                    window.location = "?t=10&token=' . $secret . '&show_modify=2&is_enable=1&id=' . $network_id . '"

                                    });

                                    });

                                  </script>';
                                            }
                                        }
                                        echo "</td><td>" . $get_private_ssid['bussiness_address1'] . "&nbsp;,&nbsp;" . $get_private_ssid['bussiness_address2'] . "&nbsp;" . $get_private_ssid['state_region'];

                                        echo '<input type="hidden" name="ap[' . $i . ']" value="' . $get_private_ssid['ap_code'] . '"></td>';
                                        echo '<td>' . $vlanID . '</td>';

                                        echo '</tr>';


                                        $i++;
                                    }
                                    $i = 0;

                                    if ($all_na != "0") {

                                        echo '<style> .all_na{ display: block !important; } </style>';
                                    }

                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <fieldset>
                    <div class="control-group">

                        <div>
                            <div class="controls col-lg-5 form-group">

                                <label class="" for="radiobtns">Current SSID Name<img data-toggle="tooltip" title="Name your SSID so your employees can easily identify and connect." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                <select style="display: inline-block" class="span4 form-control" name="ssid_name" id="ssid_name" required>
                                    <option value="">Select SSID</option>
                                    <?php
                                    $get_private_ssid_q = "SELECT  s.ssid , CONCAT(s.ssid,'/',s.network_id,'/',s.wlan_name) as value
                                                                            FROM
`exp_mno_distributor` d
LEFT JOIN
`exp_locations_ssid_private` s
ON s.`distributor`=d.`distributor_code`
LEFT JOIN
`exp_mno_distributor_aps` a
ON s.`distributor`= a.`distributor_code`
LEFT JOIN
`exp_locations_ap_ssid_private` l
ON a.`ap_code`=l.`ap_id`

WHERE  d.`distributor_code`='$user_distributor'
GROUP  BY   s.`ssid`";

                                    $get_private_ssid_res = $db->selectDB($get_private_ssid_q);

                                    foreach ($get_private_ssid_res['data'] as $get_private_ssid) {
                                        $ssid_drop = $get_private_ssid['ssid'];
                                        $value_drop = $get_private_ssid['value'];

                                    ?>
                                        <option value="<?php echo $value_drop; ?>"><?php echo $ssid_drop; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                                <!-- <a href="?t=10&st=7&action=sync_data_tab1&tocken=<?php //echo $secret; 
                                                                                        ?>" class="btn btn-primary" style="align: left; margin-top: 5px;"><i class="btn-icon-only icon-refresh"></i> Refresh</a> -->


                            </div>
                        </div>
                    </div>
                    <div class="control-group">

                        <div>
                            <div class="controls col-lg-5 form-group">

                                <label class="" for="radiobtns">New SSID Name <img data-toggle="tooltip" title='Note: The SSID Name is limited to 32 characters and may include a combination of letters, numbers, and the special characters “_” and “-“ (other special characters are not available for SSID names). The SSID Name cannot start with prohibited words such as “guest,” “administrative,” “admin,” “test,” “demo,” or “production.” These words cannot be used without other descriptive words.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                <input autocomplete="off" class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" value="<?php echo ''; ?>" maxlength="32">



                                <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer">
                                    <p>SSID Name is invalid</p>
                                </small>

                                <script type="text/javascript">
                                    $('#mod_ssid_name').bind("cut copy paste", function(e) {
                                        e.preventDefault();
                                    });

                                    $("#mod_ssid_name").keypress(function(event) {
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

                                    $("#mod_ssid_name").blur(function(event) {
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

                                    $("#mod_ssid_name").keyup(function(event) {

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

                                        setTimeout(function() {

                                            var temp_ssid_name = $('#mod_ssid_name').val();
                                            if (checkWords(temp_ssid_name.toLowerCase())) {

                                                $("#mod_ssid_name").val("");
                                                $('#invalid_ssid').css('display', 'inline-block');
                                                $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                                $('#update_ssid').attr('disabled', true);
                                            } else {
                                                $('#invalid_ssid').hide();
                                            }

                                        }, 0);

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

                                        if (words.indexOf(inword) >= 0)
                                            return true;
                                        return false;
                                    }
                                </script>
                            </div>
                            <br>
                        </div>
                    </div>
                </fieldset>



                <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">
                <div class="form-actions">
                    <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>
                </div>

            </form>











        </div>

    <?php } ?>



    <?php
    if (isset($_SESSION['GUEST_acl_setup_msg_CPE']) || ((isset($_GET['edit_token1'])) && ($_GET['acl_method_type'] == "CPE"))) {


    ?>

        <script type="text/javascript">
            $(document).ready(function() {

                $('html, body').animate({
                    scrollTop: $('#upload_result_2').offset().top
                }, 1000);

            });
        </script>
    <?php
    }
    ?>




    <div style="display: none !important;"> <?php if (isset($subtab4)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_4">
    </div>
    <?php if (in_array("NET_PRI_SHEDULE", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab3)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_3">
            <!-- Tab 3 start-->
            <?php

            if (isset($_SESSION['prtab3'])) {
                echo $_SESSION['prtab3'];
                unset($_SESSION['prtab3']);
            }
            ?>
            <h2>Private Network Schedule</h2></br>
            <p>
                You can choose to have your Private Network SSID Visible or Hidden. You can set a separate SSID broadcast schedule of your Private WiFi. Since the SSID is encrypted and requires a password, we recommend to set the SSID to hidden and have it accessible 24/7 by anyone that knows the SSID name and its password.

            </p>

            </br>





            <div class="widget widget-table action-table">
                <div class="widget-header">
                    <!-- <i class="icon-th-list"></i> -->
                    <h3>Create Schedule</h3>
                </div>

                <div class="widget-content table_response" id="act_profile_tbl">


                    <div style="overflow-x:auto;">
                        <table class="table table-striped table-bordered">
                            <thead>

                                <tr>
                                    <th>SSID Name</th>
                                    <th>Access Point MAC Address</th>
                                    <th>Description</th>
                                    <th>SSID Status</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $ssid_discription_q = "SELECT s.`ssid`,a.`ap_id`,s.`description` ,s.`is_enable` FROM `exp_locations_ssid_private` s,`exp_locations_ap_ssid_private` a
                                                                            WHERE s.`ssid`=a.`location_ssid` AND s.`distributor`='$user_distributor' AND a.`distributor`='$user_distributor'";
                                $ssid_discription_res = $db->selectDB($ssid_discription_q);
                                foreach ($ssid_discription_res['data'] as $ssid_discription) {
                                    $ssid_name = $ssid_discription['ssid'];
                                    echo '<tr><td>' . $ssid_name . '</td>';
                                    echo '<td>' . $ssid_discription['ap_id'] . '</td>';
                                    echo '<td>' . $ssid_discription['description'] . '</td>';
                                    echo '<td>' . $ssid_discription['is_enable'] . '</td>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="tab5_form1" name="tab5_form1" method="post" action="?t=3" class="form-horizontal">
                <fieldset>
                    <div class="control-group" id="feild_gp_tag_divt">
                        <label class="control-label" for="gt_mvnx">SSID Name</label>
                        <div class="controls ">
                            <input type="text" readonly name="ssid_name" id="ssid_name" class="span4 form-control" value="<?php echo $ssid_name; ?>">
                        </div>
                    </div>
                    <div class="control-group" id="feild_gp_tag_divt">
                        <label class="control-label" for="gt_mvnx">SSID Name</label>
                        <div class="controls ">
                            <input type="radio" name="pr_ssid_visible" id="pr_ssid_visible" value="true"> &nbsp;&nbsp;Visible&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="pr_ssid_visible" id="pr_ssid_visible" value="false"> &nbsp;&nbsp;Hidden
                        </div>
                    </div>
                    <br />

                    <input type="hidden" name="secret" value="<?php echo $_SESSION['FORM_SECRET'] ?>">

                    <div class="form-actions">
                        <button type="submit" name="privete_ssid_visible" id="privete_ssid_visible" class="btn btn-primary">Update</button>
                    </div>
                </fieldset>
            </form>
            <br /><br />
            <div class="widget widget-table action-table">
                <div class="widget-header">
                    <!-- <i class="icon-th-list"></i> -->
                    <h3>Existing Schedule</h3>
                </div>

                <div class="widget-content table_response" id="schedule_tbl">


                    <div style="overflow-x:auto;">
                        <table class="table table-striped table-bordered">
                            <thead>

                                <tr>
                                    <th>Scheduler Name</th>
                                    <th>On/Off (Energy Saving)</th>
                                    <th></th>
                                    <th>Delete</th>

                                </tr>

                            </thead>

                            <tbody>
                                <?php
                                $get_schedule_names_q = "SELECT `schedul_name`,`is_enable` FROM `exp_distributor_network_schedul`
                                                                                WHERE `distributor_id`='$user_distributor' GROUP BY `schedul_name`";
                                $get_schedule_names = $db->selectDB($get_schedule_names_q);
                                foreach ($get_schedule_names['data'] as $schedule_names) {
                                    $is_enable_schedule = $schedule_names['is_enable'];
                                    echo '<tr style="font-weight: bold; border-top: dashed"><td>' . $schedule_names['schedul_name'] . '</td><td></td><td></td><td></td>';


                                    echo '<tr><td></td><td><b>Day Active</b></td><td><b>Time Active</b></td><td></td></tr>';
                                    $schedule_active_q = "SELECT `day`,`active_fulltime`,`from`,`to` FROM `exp_distributor_network_schedul`
                                                                                  WHERE `schedul_name`='$schedule_names[schedul_name]' AND `distributor_id`='$user_distributor'";
                                    $schedule_active = $db->selectDB($schedule_active_q);
                                    foreach ($schedule_active['data'] as $schedule) {
                                        echo '<tr><td></td><td>' . $schedule['day'] . '</td>
                                                                 <td>' . $schedule['active_fulltime'];
                                        if ($schedule['active_fulltime'] == '') {
                                            echo $schedule['from'] . ' to ' . $schedule['to'];
                                        }
                                        echo '</td><td></td></tr>';
                                    }
                                }


                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab 3 End-->
        </div>
    <?php } ?>


    <?php if (in_array(" ", $features_array) || $package_features == "all") { ?>
        <div style="font-size: medium" <?php if (isset($subtab8)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_intruduct">
            <div class="header2_part1">
                <h2>Welcome to your Hotspot Set-up Guide</h2>
            </div>


            <p style="font-size: medium">We have taken care of most of the complexity behind the scenes to enable your venue to utilize our WiFi service.</p>
            <p style="font-size: medium">In a few simple steps you will customize the experience and be on your way offering your guests free WiFi.</p>
            <br />
            <p style="font-size: medium">
                Your service comes standard with two WiFi networks. One networks is public for your guests,
                and one is private for you. <br />This guide will take you step by step through the process of
                enabling both these networks.
            </p><br />

            <h2>Guest Networks Explain</h2><br />

            <p style="font-size: medium">Your guests will connect to your Guest Networks customized "vanity name" (SSID).
            </p><br />
            <p style="font-size: medium">Your guests will be automatically redirected to your customized "captive portal"
            </p><br />
            <p style="font-size: medium">The captive portal can be used to require your guests to register to gain access to the WiFi or just a simple click and connect</p><br />
            <div style="width:100%;height:500pX;position:relative;">
                <div style="position:absolute;height:500pX; left:0px; width:50%;">
                    If you require your guests to register to gain access, you will be able to collect valuable demographic
                    information you can use to better understand who is visiting you and when. This information will be visible in the
                    dashboard area, and available for download in the reports area.
                    <br />
                    <br />
                    During the Guest Network set-up you will be able to:
                    <ol>
                        <li>
                            Customize the SSID name
                        </li>
                        <li>
                            Set the total bandwidth you want to allocate your geusts
                        </li>
                        <li>
                            Set the days and times that you want your guest network to be available
                        </li>
                        <li>
                            Brand the captive portal with your logo and background image
                        </li>
                        <li>
                            Decide to use social media and/or manaual registration or simple click & connect
                        </li>
                        <li>
                            If you chose registration, select witch demographic information to collect using optional Facebook or manaual methods
                        </li>
                        <li>
                            Create on optional "splash page" using the Campaign Manager
                        </li>
                        <li>
                            Set the landing page that your guests will be redirected to after they are conencted. (i.e your company home page, facebook page etc.)
                        </li>
                    </ol>

                </div>
                <div style="position: absolute; height: 493px; left: 558px; width: 506px; top: 1px;">
                    <div>
                        <h4 align="center">Captive Portal</h4>
                    </div>
                    <div style="width:50%;align:center;">
                        <img src="img/theme_img_001.jpg" style="width:50%; alignment-adjust:central">
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>






    <?php if (in_array("NET_PRI_BANDWIDTH", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab2)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_2">
            <!-- Tab 7 start-->


            <h1 class="head">
                Broadcast your SSID,
                but on your terms. <img data-toggle="tooltip" title='You can set a broadcast schedule for each of your SSIDs. This means your SSIDs will only be visible to your visitors during the hours you have specified for each day. Ex. your hours of operations. If you select “Always ON” the SSID is visible 24/7, while “Always Off” means the SSID is turned off.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
            </h1>


            <div class="widget-content table_response" id="ssid_tb2">


                <div style="overflow-x:auto;">

                    <table class="table table-striped table-bordered">
                        <thead>

                            <tr>
                                <th>PRIVATE SSID</th>
                                <th>SSID Status</th>


                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            if ($ori_user_type != 'SALES') {
                                $delete_from_schedule_assign = "DELETE FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND `network_method`='PRIVATE'";
                                $db->execDB($delete_from_schedule_assign);

                                $insert_schedule_assign_private = "INSERT INTO `exp_distributor_network_schedul_assign`(`network_id`,`ssid`,`distributor`,`network_method`,`create_date`,`create_user`)
                                                                                          SELECT  `network_id`,`ssid`,`distributor`,'PRIVATE',NOW(),'system' FROM `exp_locations_ssid_private` WHERE `distributor`='$user_distributor'";

                                $db->execDB($insert_schedule_assign_private);

                                $ssid_assign_q = "SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='PRIVATE'";
                                $get_private_ssid_res_assign = $db->selectDB($ssid_assign_q);

                                foreach ($get_private_ssid_res_assign['data'] as $row) {

                                    $ssid_name_a = $row['ssid'];
                                    $b_cast = $row['ssid_broadcast'];
                                    $netid = $row['network_id'];

                                    $zone_id = $db->getValueAsf("SELECT `zone_id` AS f FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");
                                    // echo $netid;
                                    // echo $zone_id;
                                    $network_sche_data = $wag_obj->retrieveOneNetwork($zone_id, $netid);

                                    parse_str($network_sche_data);


                                    $obj = (array)json_decode(urldecode($Description));
                                    $she_ar = $obj['schedule'];
                                    $api_ssid = $obj['ssid'];

                                    $vlan_ar = $obj['vlan'];
                                    $vl_ar = json_decode(json_encode($vlan_ar), True);
                                    $vlanac = $vl_ar[accessVlan];

                                    $enc_ary = $obj['encryption'];

                                    $data_enc = get_object_vars($enc_ary);

                                    $data = get_object_vars($she_ar);
                                    if ($data['id'] == NULL) {
                                        $data['id'] = "";
                                    }
                                    // $data['type'];
                                    $assign_schedule_update = "UPDATE `exp_distributor_network_schedul_assign`
                                                                            SET `ssid_broadcast`='" . $data['type'] . "',`shedule_uniqu_id`='" . $data['id'] . "'
                                                                            WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                                    $db->execDB($assign_schedule_update);


                                    $password_update = "UPDATE `exp_locations_ssid_private`
                                      SET `ssid_password`='" . $data_enc['passphrase'] . "'
                                      WHERE `network_id`='$netid' AND `distributor`='$user_distributor'";
                                    $db->execDB($password_update);


                                    //$ssid_name_a

                                    echo '<tr><td>' . $ssid_name_a . '</td>';
                                    echo '<td data-id="' . $netid . '" data-value="' . $data['type'] . '">';

                                    if ($data['type'] == 'Customized') {

                                        echo 'Network Schedule';
                                    } else {

                                        echo $data['type'];
                                    }

                                    echo '</td>';
                                    echo '</tr>';

                                    $vlan_upq = "UPDATE `exp_locations_ssid_private` SET `vlan` = '$vlanac' WHERE `network_id`='$netid'";

                                    $vlan_upq_exe = $db->execDB($vlan_upq);
                                }
                            } else {
                                $ssid_assign_q = "SELECT ssid,ssid_broadcast,network_id FROM `exp_distributor_network_schedul_assign` WHERE `distributor`='$user_distributor' AND network_method='PRIVATE'";
                                $get_private_ssid_res_assign = $db->selectDB($ssid_assign_q);

                                foreach ($get_private_ssid_res_assign['data'] as $row) {

                                    $ssid_name_a = $row['ssid'];
                                    $netid = $row['network_id'];
                                }
                                if (strlen($ssid_name_mode) == 0) {
                                    $ssid_name_mode = 'AlwaysOff';
                                }
                                echo '<tr><td>' . $ssid_name_a . '</td>';
                                echo '<td>' . $ssid_name_mode . '</td>';
                                echo '</tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <?php include_once 'layout/' . $camp_layout . '/views/power_schedule_pr_mid.php'; ?>

            <!-- Tab 7 start-->


        </div>
    <?php } ?>

    <?php if (in_array("NET_PRI_PASS", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab9)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_5">


            <h1 class="head">
                A secure network starts
                with a great password.<img data-toggle="tooltip" title=" If you would like to restrict access to your Private WiFi network, you can set a password. Choose a password that is easy to remember but hard to guess." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
            </h1>



            <form id="update_private_ssid_pass" autocomplete="off" name="update_private_ssid_pass" class="form-horizontal" action="?t=9" method="post">

                <fieldset class="form-horizontal">

                    <div class="control-group">

                        <div>
                            <div class="controls col-lg-5 form-group">

                                <label class="" for="radiobtns">SSID Name</label>

                                <select style="display: inline-block" class="span4 form-control" onchange="loadSSIDDetails(this.options[this.selectedIndex].value);" name="pass_update_hidden" id="pass_update_hidden">
                                    <option value="">Select SSID</option>
                                    <?php
                                    $get_private_ssid_q = "SELECT  s.ssid , CONCAT(s.ssid,'/',s.network_id,'/',s.wlan_name) as value
                                                                            FROM
`exp_mno_distributor` d
LEFT JOIN
`exp_locations_ssid_private` s
ON s.`distributor`=d.`distributor_code`
LEFT JOIN
`exp_mno_distributor_aps` a
ON s.`distributor`= a.`distributor_code`
LEFT JOIN
`exp_locations_ap_ssid_private` l
ON a.`ap_code`=l.`ap_id`

WHERE  d.`distributor_code`='$user_distributor'
GROUP  BY   s.`ssid`";

                                    $get_private_ssid_res = $db->selectDB($get_private_ssid_q);

                                    foreach ($get_private_ssid_res['data'] as $get_private_ssid) {
                                        $ssid_drop = $get_private_ssid['ssid'];
                                        $value_drop = $get_private_ssid['value'];

                                    ?>
                                        <option value="<?php echo $value_drop; ?>"><?php echo $ssid_drop; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div style="display: inline-block" id="ssid_name_error"></div>

                                <script type="text/javascript">
                                    function loadSSIDDetails(ssid) {

                                        /*   alert(ssid);  */
                                        $('#pass_update_hidden').val(ssid);

                                        $('#ssid_name_error').html('<img src="img/loading_ajax.gif">');

                                        var formData = {
                                            ssid_pr: ssid,
                                            dis: "<?php echo $user_distributor; ?>"
                                        };
                                        $.ajax({
                                            url: "ajax/getSsidDetails.php",
                                            type: "POST",
                                            data: formData,
                                            success: function(data) {

                                                $('#password').val(data);

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                $('#ssid_name_error').html('Network Error');
                                            }
                                        });

                                        $('#ssid_name_error').html('');

                                    }
                                </script>


                            </div>
                        </div>
                    </div>
                    <div class="control-group">

                        <div>
                            <div class="controls col-lg-5 form-group">

                                <label class="" for="radiobtns">Encryption Type</label>
                                <select class="span4 form-control" id="encryption_type" name="encryption_type" required>
                                    <?php
                                    $network_enc_q = "SELECT   `discription` AS dis,`encryp_method` AS method,`eccryp_algorithm` AS algo FROM `exp_locations_ssid_encryption_types` WHERE `is_enable`='1'";
                                    $network_enc_r = $db->selectDB($network_enc_q);
                                    foreach ($network_enc_r['data'] as $network_enc) {
                                        echo "<option value=\"" . $network_enc['method'] . "/" . $network_enc['algo'] . "\"> " . $network_enc['dis'] . "</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="control-group">

                        <div>
                            <div class="controls col-lg-5 form-group">

                                <label class="" for="radiobtns">Password <img data-toggle="tooltip" title="Your password must be minimum <?php echo $passcode_min; ?> characters and should not contain the following special characters ' $ ( ," src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                                <input autocomplete="off" required title="<?php echo $passcode_min; ?> to <?php echo $passcode_max; ?> characters" class="span4 form-control" id="password" onkeyup="strbar()" name="password" type="password" required minlength="<?php echo $passcode_min; ?>" maxlength="<?php echo $passcode_max; ?>" />



                                <script>
                                    $('#password').bind("cut copy paste", function(e) {
                                        e.preventDefault();
                                    });

                                    //$ ! # @
                                    $("#password").keypress(function(event) {
                                        var ew = event.which;
                                        if (ew == 96)
                                            return false;
                                        if (ew == 64 || ew == 35 || ew == 8 || ew == 33 || ew == 36)
                                            return true;
                                        if (33 <= ew && ew <= 47)
                                            return true;
                                        if (48 <= ew && ew <= 64)
                                            return true;
                                        if (65 <= ew && ew <= 90)
                                            return true;
                                        if (91 <= ew && ew <= 126)
                                            return true;
                                        return false;


                                    });

                                    $("#password").keyup(function(event) {
                                        var password;
                                        password = $('#password').val();
                                        var lastChar = password.substr(password.length - 1);
                                        var lastCharCode = lastChar.charCodeAt(0);

                                        if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 36 || lastCharCode == 33 || lastCharCode == 64 || lastCharCode == 35) ||
                                                (33 <= lastCharCode && lastCharCode <= 126)) && lastCharCode == '96') {
                                            $("#password").val(password.substring(0, password.length - 1));
                                        }
                                    });
                                </script>
                            </div>
                            <div class="controls col-lg-5">
                                <meter class="span4 form-control" max="4" id="password-strength-meter"></meter>
                                <input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> Show password

                                <p id="password-strength-text"></p>
                                <script>
                                    function strbar() {
                                        var strength = {
                                            0: "Worst ",
                                            1: "Bad ",
                                            2: "Weak ",
                                            3: "Good ",
                                            4: "Strong "
                                        }

                                        var password = document.getElementById('password');
                                        var meter = document.getElementById('password-strength-meter');
                                        var text = document.getElementById('password-strength-text');

                                        var val = password.value;

                                        // If the password length is less than or equal to passcode_min

                                        if (val !== "") {
                                            if (val.length <= <?php echo $passcode_min; ?>) no = 1;

                                            // If the password length is greater than passcode_min and contain any lowercase alphabet or any number or any special character
                                            if (val.length > <?php echo $passcode_min; ?> && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))) no = 2;

                                            // If the password length is greater than passcode_min and contain alphabet,number,special character respectively
                                            if (val.length > <?php echo $passcode_min; ?> && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) no = 3;

                                            // If the password length is greater than passcode_min and must contain alphabets,numbers and special characters
                                            if (val.length > <?php echo $passcode_min; ?> && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) no = 4;

                                            text.innerHTML = "Strength: " + "<strong>" + strength[no] + "</strong>";

                                        } else {
                                            text.innerHTML = "";
                                        }
                                        /*
                                                                                                                      var val = password.value;
                                                                                                                      var result = zxcvbn(val);

                                                                                                                      // Update the password strength meter
                                                                                                                     // meter.value = result.score;

                                                                                                                     document.getElementById("password-strength-meter").setAttribute("value", result.score);

                                                                                                                      // Update the text indicator
                                                                                                                      if(val !== "") {
                                                                                                                          text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>";
                                                                                                                      }
                                                                                                                      else {
                                                                                                                          text.innerHTML = "";
                                                                                                                      }*/

                                    }
                                </script>
                            </div>



                        </div>
                    </div>

                    <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">
                    <div class="form-actions">
                        <button type="submit" name="update_ssid_pass" id="update_ssid_pass" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-info inline-btn" onclick="gopto();" style="margin-top: 0px !important;">Cancel</button>
                    </div>

                </fieldset>





            </form>


            <script>
                function gopto(url) {
                    window.location = "?t=9";
                }
            </script>


        </div>

    <?php } ?>

    <?php if (in_array("NET_AUTHENTICATION", $features_array) || $package_features == "all") { ?>
        <div <?php if (isset($subtab20)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_6">



            <h2>
                Authentication

                <?php  //echo $_SESSION['s_token'];// echo $camp_base_url.'/ajax/syncAP.php?distributor='.$user_distributor; 
                ?>
            </h2>

            <p>
                <!--  If you would like to restrict access to your Private <?php // echo __WIFI_TEXT__; 
                                                                            ?> network, you can set a password. Choose a password that is easy to remember but hard to guess. -->
                You can log-in to your private network SSID in two ways.Through regular password authentication using WPA2/AES encryption or enterprise authentication using WPA2/AES encryption. To enable enterprise authentication you must first set-up your AAA server.
            </p>

            <hr>

            <form id="update_private_authentication" autocomplete="off" name="update_private_authentication" class="form-horizontal" action="?t=20" method="post">

                <fieldset>

                    <div class="control-group">
                        <label class="control-label" for="radiobtns">SSID Name</label>
                        <div>
                            <div class="controls col-lg-5 form-group">

                                <select style="display: inline-block" class="span4 form-control" onchange="loadSSIDDetails(this.options[this.selectedIndex].value);" name="pass_update_hidden" id="pass_update_hidden">
                                    <option value="">Select SSID</option>
                                    <?php
                                    $get_private_ssid_q = "SELECT  s.ssid , CONCAT(s.ssid,'/',s.network_id,'/',s.wlan_name) as value
                                FROM
`exp_mno_distributor` d
LEFT JOIN
`exp_locations_ssid_private` s
ON s.`distributor`=d.`distributor_code`
LEFT JOIN
`exp_mno_distributor_aps` a
ON s.`distributor`= a.`distributor_code`
LEFT JOIN
`exp_locations_ap_ssid_private` l
ON a.`ap_code`=l.`ap_id`

WHERE  d.`distributor_code`='$user_distributor'
GROUP  BY   s.`ssid`";

                                    $get_private_ssid_res = $db->selectDB($get_private_ssid_q);


                                    foreach ($get_private_ssid_res['data'] as $get_private_ssid) {
                                        $ssid_drop = $get_private_ssid['ssid'];
                                        $value_drop = $get_private_ssid['value'];

                                    ?>
                                        <option value="<?php echo $value_drop; ?>"><?php echo $ssid_drop; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div style="display: inline-block" id="ssid_name_error"></div>

                                <script type="text/javascript">
                                    function loadSSIDDetails(ssid) {

                                        /*   alert(ssid);  */
                                        $('#pass_update_hidden').val(ssid);

                                        $('#ssid_name_error').html('<img src="img/loading_ajax.gif">');

                                        var formData = {
                                            ssid_pr: ssid,
                                            dis: "<?php echo $user_distributor; ?>"
                                        };
                                        var formData_aaa = {
                                            ssid_aaa: ssid,
                                            dis: "<?php echo $user_distributor; ?>"
                                        };
                                        var formData_aaa_type = {
                                            ssid_aaa_type: ssid,
                                            dis: "<?php echo $user_distributor; ?>"
                                        };
                                        $.ajax({
                                            url: "ajax/getSsidDetails.php",
                                            type: "POST",
                                            data: formData,
                                            success: function(data) {

                                                $('#password').val(data);

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                $('#ssid_name_error').html('Network Error');
                                            }
                                        });


                                        $.ajax({
                                            url: "ajax/getSsidDetails.php",
                                            type: "POST",
                                            data: formData_aaa,
                                            success: function(data) {
                                                //  alert(data);
                                                //$('#aaa_type').val("<option value=''>Select AAA1</option>");

                                                $("#aaa_type").val(data);

                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                $('#ssid_name_error').html('Network Error');
                                            }
                                        });


                                        $.ajax({
                                            url: "ajax/getSsidDetails.php",
                                            type: "POST",
                                            data: formData_aaa_type,
                                            success: function(data) {


                                                if (data == 'Password') {
                                                    $("#pass").click();
                                                    document.getElementById("update_authentication").disabled = true;

                                                } else if (data == '802') {
                                                    $("#802").click();
                                                    document.getElementById("update_authentication").disabled = true;

                                                }


                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                $('#ssid_name_error').html('Network Error');
                                            }
                                        });

                                        $('#ssid_name_error').html('');

                                    }
                                </script>


                            </div>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="radiobtns"></label>
                        <div>
                            <div class="controls col-lg-5 form-group" style="position: relative;">


                                <!-- <input class="se_au_type" name="se_au" type="radio" id="pass" checked onclick="au_load('sh_pass','sh_aaa')" value="Password"> Password &nbsp; &nbsp; &nbsp;
<br>
<br>
<input class="se_au_type" name="se_au" type="radio" id="802" onclick="au_load_2('sh_aaa','sh_pass')" value="802"> Enterprise -->

                                <? php // if(!$_SESSION['s_token']){ 
                                ?>
                                <!--  <div class="au_disable"></div>  -->
                                <?php //} 
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="control-group" id="sh_pass4">


                        <!-- <label class="control-label" for="radiobtns">Encryption Type</label> -->
                        <label class="control-label" for="radiobtns" style="position: relative;">
                            <?php if (!$_SESSION['s_token']) { ?>
                                <div class="au_disable"></div>
                            <?php } ?>
                            <input class="se_au_type" name="se_au" type="radio" id="pass" onclick="au_load('sh_pass','sh_aaa')" value="Password">&nbsp; &nbsp;Encryption
                        </label>

                        <div>
                            <div class="controls col-lg-5 form-group" style="position: relative;">
                                <select class="span4 form-control sh_pass3" id="encryption_type" name="encryption_type" required>
                                    <?php
                                    $network_enc_q = "SELECT   `discription` AS dis,`encryp_method` AS method,`eccryp_algorithm` AS algo FROM `exp_locations_ssid_encryption_types` WHERE `is_enable`='1'";
                                    $network_enc_r = $db->selectDB($network_enc_q);

                                    foreach ($network_enc_r['data'] as $network_enc) {

                                        echo "<option value=\"" . $network_enc['method'] . "/" . $network_enc['algo'] . "\"> " . $network_enc['dis'] . "</option>";
                                    }
                                    ?>

                                </select>
                                <div class="sh_pass2 au_disable "></div>
                            </div>
                        </div>
                    </div>


                    <div class="control-group" id="sh_pass">
                        <label class="control-label" for="radiobtns">Password</label>
                        <div>
                            <div class="controls col-lg-5 form-group" style="position: relative;">

                                <input autocomplete="off" required title="<?php echo $passcode_min; ?> to <?php echo $passcode_max; ?> characters" class="span4 form-control sh_pass3" id="password" onkeyup="strbar()" name="password" type="password" required minlength="<?php echo $passcode_min; ?>" maxlength="<?php echo $passcode_max; ?>">
                                <script>
                                    $('#password').bind("cut copy paste", function(e) {
                                        e.preventDefault();
                                    });

                                    //$ ! # @
                                    $("#password").keypress(function(event) {
                                        var ew = event.which;
                                        if (ew == 64 || ew == 35 || ew == 8 || ew == 33 || ew == 36)
                                            return true;
                                        if (48 <= ew && ew <= 57)
                                            return true;
                                        if (65 <= ew && ew <= 90)
                                            return true;
                                        if (97 <= ew && ew <= 122)
                                            return true;
                                        return false;


                                    });

                                    $("#password").keyup(function(event) {
                                        var password;
                                        password = $('#password').val();
                                        var lastChar = password.substr(password.length - 1);
                                        var lastCharCode = lastChar.charCodeAt(0);

                                        if (!((lastCharCode == 8 || lastCharCode == 0 || lastCharCode == 36 || lastCharCode == 33 || lastCharCode == 64 || lastCharCode == 35) || (48 <= lastCharCode && lastCharCode <= 57) ||
                                                (65 <= lastCharCode && lastCharCode <= 90) ||
                                                (97 <= lastCharCode && lastCharCode <= 122))) {
                                            $("#password").val(password.substring(0, password.length - 1));
                                        }
                                    });
                                </script>


                                <div class="sh_pass2 au_disable "></div>
                            </div>

                            <div class="controls col-lg-5 " style="position: relative;">
                                <div class="sh_pass2 au_disable"></div>
                                <meter class="span4 form-control" max="4" id="password-strength-meter"></meter>
                                <input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> Show password
                                <p style="font-size: small"><b>Note: Your password must be at least <?php echo $passcode_min; ?> characters long and include at least one number, one upper case letter, one lowercase letter and one special character: $ ! # @.</b></p>
                                <p id="password-strength-text"></p>
                                <script>
                                    function strbar() {
                                        var strength = {
                                            0: "Worst ",
                                            1: "Bad ",
                                            2: "Weak ",
                                            3: "Good ",
                                            4: "Strong "
                                        }

                                        var password = document.getElementById('password');
                                        var meter = document.getElementById('password-strength-meter');
                                        var text = document.getElementById('password-strength-text');

                                        var val = password.value;

                                        // If the password length is less than or equal to passcode_min

                                        if (val !== "") {
                                            if (val.length <= <?php echo $passcode_min; ?>) no = 1;

                                            // If the password length is greater than passcode_min and contain any lowercase alphabet or any number or any special character
                                            if (val.length > <?php echo $passcode_min; ?> && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))) no = 2;

                                            // If the password length is greater than passcode_min and contain alphabet,number,special character respectively
                                            if (val.length > <?php echo $passcode_min; ?> && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))) no = 3;

                                            // If the password length is greater than passcode_min and must contain alphabets,numbers and special characters
                                            if (val.length > <?php echo $passcode_min; ?> && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) no = 4;

                                            text.innerHTML = "Strength: " + "<strong>" + strength[no] + "</strong>";

                                        } else {
                                            text.innerHTML = "";
                                        }



                                        /*var val = password.value;
                                  var result = zxcvbn(val);

                                  // Update the password strength meter
                                 // meter.value = result.score;

                                 document.getElementById("password-strength-meter").setAttribute("value", result.score);

                                  // Update the text indicator
                                  if(val !== "") {
                                      text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>";
                                  }
                                  else {
                                      text.innerHTML = "";
                                  }*/

                                    }
                                </script>
                            </div>



                        </div>
                    </div>



                    <!--AAA Server-->

                    <div class="control-group" id="sh_aaa">


                        <!--  <label class="control-label" for="radiobtns">AAA</label> -->
                        <label class="control-label" for="radiobtns" style="position: relative;">
                            <?php if (!$_SESSION['s_token']) { ?>
                                <div class="au_disable"></div>
                            <?php } ?>
                            <input class="se_au_type " name="se_au" type="radio" id="802" onclick="au_load_2('sh_aaa','sh_pass')" value="802">&nbsp; Enterprise
                        </label>


                        <div>
                            <div class="controls col-lg-5 form-group" style="position: relative;">
                                <select class="span4 form-control sh_aaa3" id="aaa_type" name="aaa_type" required>
                                    <option value="">Select AAA</option>
                                    <?php
                                    $network_aaa_q = "select * from exp_radius_profile where `distributor_code`='$user_distributor'";
                                    $network_aaa_r = $db->selectDB($network_aaa_q);

                                    foreach ($network_aaa_r['data'] as $network_aaa) {

                                        echo "<option value='" . $network_aaa['vsz_id'] . "'> " . $network_aaa['profile_name'] . "</option>";
                                    }
                                    ?>

                                </select>

                                <div class="sh_aaa2 au_disable "></div>
                                <p style="font-size: small"><b>Note: There must be a AAA server configured in order to select Enterprise. Please contact Tier 1 Support at <?php echo $package_functions->getMessageOptions('SUPPORT_NUMBER', $system_package); ?> to add your AAA server details if you would like to select Enterprise.</b></p>
                                <p id="password-strength-text"></p>
                            </div>
                        </div>

                    </div>


                    <!--encryption type-->



                </fieldset>



                <input type="hidden" name="authentication_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">
                <div class="form-actions">
                    <button type="submit" name="update_authentication" id="update_authentication" class="btn btn-primary inline-btn" disabled>Update</button>
                    <button type="button" class="btn btn-info inline-btn" onclick="gopto();">Cancel</button>
                </div>

            </form>

            <script>
                function gopto(url) {
                    window.location = "?t=20";
                }
            </script>



        </div>

    <?php } ?>
    <!--AAA SET-up-->



    <?php if ((in_array("NET_AAA_SET", $features_array) || $package_features == "all") && $_SESSION['s_token']) { ?>
        <div <?php if (isset($subtab21)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_7" style="position: relative;">


            <?php if (!$_SESSION['s_token']) { ?>
                <div class="au_disable"></div>
            <?php } ?>
            <!-- Tab 7 start-->
            <h2>
                AAA
            </h2>

            <p>
                The system supports RADIUS authentication. To set-up your RADIUS you must know all the configurations, if you are unsure please contact your local IT department.
            </p>


            <br />




            </strong>


            <form id="update_private_aaa" autocomplete="off" name="update_private_aaa" class="form-horizontal" action="?t=21" method="post">


                <div class="widget widget-table action-table">
                    <div class="widget-header">
                        <!-- <i class="icon-th-list"></i> -->
                        <h3>Private SSID</h3>
                    </div>
                    <div class="widget-content table_response" id="ssid_tbl">


                        <div style="overflow-x:auto;">

                            <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                <thead>

                                    <tr>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>

                                        <!--      <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">WLAN Name</th> -->

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Primary ip</th>

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Shared secret</th>

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Secondary Primary ip</th>

                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Secondary Shared secret</th>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Delete</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php

                                    $all_na = '2';

                                    $get_private_aaa_q = "select * from exp_radius_profile where `distributor_code`='$user_distributor'";


                                    $get_private_aaa_res = $db->selectDB($get_private_aaa_q);


                                    foreach ($get_private_aaa_res['data'] as $get_private_aaa_data) {
                                        $aaa_id = $get_private_aaa_data['id'];
                                        $profile_name = $get_private_aaa_data['profile_name'];
                                        $primary_ip = $get_private_aaa_data['primary_ip'];
                                        $shared_secret = $get_private_aaa_data['shared_secret'];

                                        $se_primary_ip = $get_private_aaa_data['second_primary_ip'];
                                        $se_shared_secret = $get_private_aaa_data['second_shared_secret'];

                                        if (empty($se_shared_secret)) {
                                            $se_shared_secret = "N/A";
                                        }
                                        if (empty($se_primary_ip)) {
                                            $se_primary_ip = "N/A";
                                        }


                                        echo '<tr><td>' . $profile_name . '</td>';
                                        echo '<td>' . $primary_ip . '</td>';
                                        echo '<td>' . $shared_secret . '</td>';
                                        echo '<td>' . $se_primary_ip . '</td>';
                                        echo '<td>' . $se_shared_secret . '</td>';




                                        if (!$_SESSION['s_token']) {

                                            echo '<td><a  class="btn btn-small btn-primary">Edit</a></td>';
                                        } else {
                                            echo   '<td><a href="javascript:void();" id="CE_' . $aaa_id . '" class="btn btn-small btn-primary">Edit</a>';


                                            echo '

                                                                <script type="text/javascript">

																	$(document).ready(function() {

																	$(\'#CE_' . $aaa_id . '\').easyconfirm({locale: {

																			title: \'Edit RADIUS\',

																			text: \'Are you sure you want to modify this radius?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

																			button: [\'Cancel\',\' Confirm\'],

																			closeText: \'close\'

																		     }});

																		$(\'#CE_' . $aaa_id . '\').click(function() {

																			window.location = "?t=21&token=' . $secret . '&show_modify_aaa=2&is_enable=0&id=' . $aaa_id . '"

																		});

																		});

																	</script>';
                                        }

                                        if (!$_SESSION['s_token']) {

                                            echo '<td><a  class="btn btn-small btn-primary">Delete</a></td>';
                                        } else {
                                            echo   '<td><a href="javascript:void();" id="DE_' . $aaa_id . '" class="btn btn-small btn-primary">Delete</a>';


                                            echo '

                                                            <script type="text/javascript">

                                                                $(document).ready(function() {

                                                                $(\'#DE_' . $aaa_id . '\').easyconfirm({locale: {

                                                                        title: \'Delete RADIUS\',

                                                                        text: \'Are you sure you want to delete this radius?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                        button: [\'Cancel\',\' Confirm\'],

                                                                        closeText: \'close\'

                                                                         }});

                                                                    $(\'#DE_' . $aaa_id . '\').click(function() {

                                                                        window.location = "?t=21&token=' . $secret . '&delete_aaa=2&is_enable=0&id=' . $aaa_id . '"

                                                                    });

                                                                    });

                                                                </script>';
                                        }
                                    }


                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Name</label>
                        <div>
                            <div class="controls col-lg-5 form-group">

                                <input autocomplete="off" class="span4 form-control" id="aaa_name" name="aaa_name" type="text" value="<?php echo $sh_aaa_name; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                    } ?>>

                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Port</label>
                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input autocomplete="off" class="span4 form-control" id="aaa_port" name="aaa_port" type="text" value="<?php echo $sh_aaa_port; ?>" maxlength="4" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                    } ?>>


                            </div>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Primary IP</label>
                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input autocomplete="off" class="span4 form-control" id="aaa_prid" name="aaa_prid" type="text" value="<?php echo $sh_aaa_prid; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                    } ?>>


                            </div>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Shared Secret</label>
                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input autocomplete="off" class="span4 form-control" id="aaa_shared_secret" name="aaa_shared_secret" type="text" value="<?php echo $sh_aaa_shared_secret; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                } ?>>


                            </div>

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Comfirm Secret</label>
                        <div>
                            <div class="controls col-lg-5 form-group">
                                <input autocomplete="off" class="span4 form-control" id="aaa_com_secret" name="aaa_com_secret" type="text" value="<?php echo $sh_aaa_com_secret; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                        } ?>>


                            </div>

                        </div>
                    </div>

                    <!--Secondary-->

                    <div id="secondary_div" <?php if ($check_re_back != 'checked') { ?> style="display: none;" <?php } ?>>
                        <div class="control-group">
                            <label class="control-label" for="radiobtns">Secondary Primary IP</label>
                            <div>
                                <div class="controls col-lg-5 form-group">
                                    <input autocomplete="off" class="span4 form-control" id="sec_aaa_prid" name="sec_aaa_prid" type="text" value="<?php echo $sh_se_aaa_prid; ?>" maxlength="32" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                                    } ?>>


                                </div>

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="radiobtns">Secondary Shared Secret</label>
                            <div>
                                <div class="controls col-lg-5 form-group">
                                    <input autocomplete="off" class="span4 form-control" id="sec_aaa_shared_secret" name="sec_aaa_shared_secret" type="text" value="<?php echo $sh_se_aaa_shared_secret; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                                } ?>>


                                </div>

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="radiobtns">Secondary Comfirm Secret</label>
                            <div>
                                <div class="controls col-lg-5 form-group">
                                    <input autocomplete="off" class="span4 form-control" id="sec_aaa_com_secret" name="sec_aaa_com_secret" type="text" value="<?php echo $sh_se_aaa_com_secret; ?>" <?php if (!$_SESSION['s_token']) {
                                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                                    } ?>>


                                </div>

                            </div>
                        </div>

                    </div>





                    <div class="control-group">
                        <label class="control-label" for="radiobtns"></label>
                        <div>
                            <div class="controls col-lg-5 form-group">


                                <input class="rad_backup" id="rad_backup" name="rad_backup" type="checkbox" <?php if ($check_re_back == 'checked') { ?> checked <?php } ?> value="add_second"> Add Backup RADIUS &nbsp; &nbsp; &nbsp;
                                <script type="text/javascript">
                                    $(document).ready(function() {



                                        /* $('#update_private_aaa').bootstrapValidator().enableFieldValidators('sec_aaa_prid', false);
                                        $('#update_private_aaa').bootstrapValidator().enableFieldValidators('sec_aaa_shared_secret', false);
                                        $('#update_private_aaa').bootstrapValidator().enableFieldValidators('sec_aaa_com_secret', false); */

                                        $('#rad_backup').change(function() {


                                            if (this.checked) {

                                                $('#secondary_div').fadeIn('slow');
                                                var bootstrapValidator2 = $('#update_private_aaa').data('bootstrapValidator');
                                                bootstrapValidator2.enableFieldValidators('sec_aaa_prid', true);
                                                bootstrapValidator2.enableFieldValidators('sec_aaa_shared_secret', true);
                                                bootstrapValidator2.enableFieldValidators('sec_aaa_com_secret', true);

                                            } else {
                                                $('#secondary_div').fadeOut('slow');
                                                var bootstrapValidator21 = $('#update_private_aaa').data('bootstrapValidator');
                                                bootstrapValidator21.enableFieldValidators('sec_aaa_prid', false);
                                                bootstrapValidator21.enableFieldValidators('sec_aaa_shared_secret', false);
                                                bootstrapValidator21.enableFieldValidators('sec_aaa_com_secret', false);

                                            }
                                        });
                                    });
                                </script>
                            </div>
                </fieldset>



                <input type="hidden" name="update_aaa_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">
                <div class="form-actions">
                    <?php if (isset($_GET['show_modify_aaa'])) { ?>

                        <input type="hidden" name="update_aaa_id" value="<?php echo $sh_id_aaa; ?>">
                        <input type="hidden" name="update_aaa_vsz_id" value="<?php echo $sh_vsz_id_aaa; ?>">

                        <button type="submit" name="update_aaa" id="update_aaa" class="btn btn-primary">Update</button>

                    <?php } else { ?>
                        <button type="submit" name="create_aaa" id="create_aaa" class="btn btn-primary">Create</button>
                    <?php } ?>
                </div>

            </form>

            <!-- Tab 7 End-->
        </div>

    <?php } ?>

</div>

<script type="text/javascript" src="js/bootstrapValidator.js?v=18"></script>
<script type="text/javascript" src="js/bootstrapValidator_new.js?v=18"></script>


<script>
    $(document).ready(function() {
        //create ssid form validation


        $('#modify_pvt_ssid_broadcast_f').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {

                sel_ssid_name: {
                    validators: {
                        notEmpty: {
                            message: '<p>This is a required field</p>'
                        }
                    }
                }
            }
        });

        $('#update_private_ssid').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ssid_name: {
                    validators: {
                        notEmpty: {
                            message: '<p>This is a required field</p>'
                        }
                    }
                },
                mod_ssid_name: {
                    validators: {
                        notEmpty: {
                            message: '<p>This is a required field</p>'
                        },
                        stringLength: {
                            max: 32,
                            message: '<p>This field value is too long</p>'
                        }
                    }
                }
            }
        });

        $('#update_private_ssid_pass').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                pass_update_hidden: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                encryption_type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                password: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>,
                        stringLength: {
                            max: <?php echo $passcode_max; ?>,
                            message: '<p>This field value is too long</p>'
                        },
                        stringLength: {
                            min: <?php echo $passcode_min; ?>,
                            message: '<p>This field value is too short</p>'
                        },
                        <?php echo $db->validateField('password_val_new'); ?>
                    }
                }

            }
        }).on('error.validator.bv', function(e, data) {
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name
            //alert(data);
            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();

            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(true);
            }

        }).on('success.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }

            /*if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
                 data.fv.disableSubmitButtons(true);
             } */
        });


        $('#update_private_authentication').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                pass_update_hidden: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                encryption_type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },

                aaa_type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                password: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>,
                        stringLength: {
                            max: <?php echo $passcode_max; ?>,
                            message: '<p>This field value is too long</p>'
                        },
                        stringLength: {
                            min: <?php echo $passcode_min; ?>,
                            message: '<p>This field value is too short</p>'
                        },
                        <?php echo $db->validateField('password_val'); ?>
                    }
                }

            }
        }).on('error.validator.bv', function(e, data) {
            // $(e.target)    --> The field element
            // data.bv        --> The BootstrapValidator instance
            // data.field     --> The field name
            // data.element   --> The field element
            // data.validator --> The current validator name
            //alert(data);
            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').css('display', 'inline-block');

            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(true);
            }

        }).on('success.field.bv', function(e, data) {
            if (data.bv.getSubmitButton()) {
                data.bv.disableSubmitButtons(false);
            }

            /*if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
                 data.fv.disableSubmitButtons(true);
             } */
        });


    });
</script>
