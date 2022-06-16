<div <?php if (isset($tab_guestnet_tab_1)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="guestnet_tab_1">

    <?php

    if (isset($_SESSION['tab7'])) {
        echo $_SESSION['tab7'];
        unset($_SESSION['tab7']);
    }
    ?>
    <h1 class="head">
        It is your business, so let the SSID show it. <img data-toggle="tooltip" title="Your account comes with a default SSID name. This name can be changed to fit your business. Name your network so your guests can easily identify and connect. " src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
    </h1>






    <div id="guest_modify_network"></div>



    <div style="display: none" class='alert alert-danger all_na'><button type='button' class='close' data-dismiss='alert'>�</button><strong>


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

        <div class="widget widget-table action-table">

            <?php if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $system_package) == 'NO') {

            ?>

                <!-- <div class="controls col-lg-5 form-group">
                                                <a href="?t=7&st=7&action=sync_data_tab1&tocken=<? php // echo $secret; 
                                                                                                ?>" class="btn btn-primary" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
                                            </div>
                                             <br/>-->
                </br>

            <?php } ?>

            <div class="widget-header">
                <!-- <i class="icon-th-list"></i> -->
                <h3></h3>
            </div>
            <div class="widget-content table_response" id="ssid_tbl">
                <div style="overflow-x:auto;">
                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
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

                            $all_na = '2';

                            $ssid_q = "SELECT d.`zone_id`, a.`ap_code`,s.`wlan_name`,s.`ssid`,s.`network_id` ,l.`group_tag`,d.bussiness_address1,d.state_region,d.bussiness_address2
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
                                                                ON l.`distributor`= d.`distributor_code`

                                                                WHERE  d.`distributor_code`='$user_distributor' AND s.network_method<>'MDO'
                                                                GROUP  BY   s.`ssid`";
                            $ssid_res = $db->selectDB($ssid_q);
                            $i = 0;

                            if ($ssid_res['rowCount'] > 0) {


                                foreach ($ssid_res['data'] as $ssid_name) {
                                    //   echo'<input type="hidden" name="network_id" value="'.$ssid_name['network_id'].'">';
                                    //   echo'<input type="hidden" name="description" value="'.$ssid_name['description'].'">';
                                    //    echo "<tr><td>".$ssid_name['ap_code']."</td>";

                                    $gorup_tag = $ssid_name['group_tag'];

                                    if (strlen($gorup_tag) < 1) {
                                        $location_id = 'N/A';
                                    } else {
                                        $location_id = $gorup_tag;
                                        $all_na = "0";
                                    }

                                    echo  "<td>" . $ssid_name['ssid'] . "</td>";

                                    echo    "<td>" . $location_id . "</td>";
                                    echo    "<td>" . $ssid_name['bussiness_address1'] . "&nbsp;,&nbsp;" . $ssid_name['bussiness_address2'] . "&nbsp;" . $ssid_name['state_region'] . "</td>";

                                    echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";

                                    echo "</tr>";
                                    //  $ssidName=$ssid_name['ssid'];
                                    //  $wlanId=$ssid_name['wlan_name'];


                                    $i++;
                                }

                                if ($all_na != "0") {

                                    echo '<style> .all_na{ display: block !important; } </style>';
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br />

        <fieldset>
            <div class="control-group">

                <div class="controls col-lg-5 form-group">


                    <label class="" for="ssid_name">Current SSID Name : <img data-toggle="tooltip" title="Select the SSID name you wish to change from the drop-down below. Then, enter the new name of your Guest WiFi Network." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                    <select required class="span4 form-control" id="ssid_name" name="ssid_name" <?php echo $ssidName; ?> onchange="loadSSIDForm(this.value)">
                        <option value="">Select SSID</option>
                        <?php
                        $ssid_q = "SELECT s.`ssid`
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
                                                                                    ON l.`distributor`= d.`distributor_code`

                                                                                    WHERE  d.`distributor_code`='$user_distributor' AND s.ssid<>'' AND s.network_method<>'MDO'
                                                                                    GROUP  BY   s.`ssid`";
                        $ssid_res = $db->selectDB($ssid_q);

                        foreach ($ssid_res['data'] as $ssid_names) {
                            echo '<option value="' . $ssid_names[ssid] . '">' . $ssid_names[ssid] . '</option>';
                        }
                        ?>
                    </select>

                    <a href="?t=guestnet_tab_1&st=7&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary" style="align: left; margin-top: 5px;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>

                    <script>
                        function loadSSIDForm(ssid) {

                            /*  alert(ssid);    */
                            var ssid = ssid;
                            var formData = {
                                ssid: ssid,
                                dis: "<?php echo $user_distributor; ?>"
                            };
                            $.ajax({
                                url: "ajax/getSsidDetails.php",
                                type: "POST",
                                data: formData,
                                success: function(data) {
                                    /*   alert(data);   */
                                    var data_array = data.split(',');

                                    document.getElementById("network_id").value = data_array[1];
                                    document.getElementById("wlan_name").value = data_array[0];
                                },
                                error: function(jqXHR, textStatus, errorThrown) {

                                }
                            });



                        }
                    </script>
                    <input id="wlan_name" name="wlan_name" type="hidden" value="">
                    <input id="network_id" name="network_id" type="hidden" value="">


                </div>
            </div>
            <div class="control-group">

                <div>
                    <div class="controls col-lg-5 form-group">

                        <label class="" for="mod_ssid_name">New SSID Name : <img data-toggle="tooltip" title='Note: The SSID Name is limited to 32 characters and may include a combination of letters, numbers, and the special characters “_” and “-“ (other special characters are not available for SSID names). The SSID Name cannot start with prohibited words such as “guest,” “administrative,” “admin,” “test,” “demo,” or “production.” These words cannot be used without other descriptive words.' src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></label>

                        <input required class="span4 form-control" id="mod_ssid_name" name="mod_ssid_name" type="text" maxlength="32" value="<?php echo ''; ?>">




                        <small id="invalid_ssid" style="display: none;" class="help-block error-wrapper bubble-pointer mbubble-pointer">
                            <p>SSID Name is invalid</p>
                        </small>

                        <script type="text/javascript">
                            $(document).ready(function() {
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
                                        //$('#invalid_ssid').css('display', 'inline-block');
                                        //$("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                        $('#update_ssid').attr('disabled', true);
                                    } else {
                                        //$('#invalid_ssid').hide();
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
                                        //   $('#invalid_ssid').css('display', 'inline-block');
                                        //   $("#mod_ssid_name").attr("placeholder", "Invalid SSID name");
                                        $('#update_ssid').attr('disabled', true);
                                    } else {
                                        //$('#invalid_ssid').hide();
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
                        </script>

                    </div>
                    <br>

                </div>
            </div>
            <?php
            if ($package_functions->getSectionType('NET_GUEST_LOC_UPDATE', $system_package) == 'YES' || $package_features == "all") {
            ?>
                <div class="control-group">
                    <label class="control-label" for="radiobtns">Use
                        Existing Location : </label>

                    <div class="controls col-lg-5 form-group">
                        <div>
                            <select class="span4 form-control" id="old_location_name" name="old_location_name" onchange="setNewSSID(this.value)">
                                <option value="">SELECT LOCATION
                                </option>
                                <?php
                                $get_group_tag_q = "SELECT `tag_name` FROM `exp_mno_distributor_group_tag` WHERE `distributor`='$user_distributor' GROUP BY `tag_name`";
                                $get_group_tag_r = $db->selectDB($get_group_tag_q);

                                foreach ($get_group_tag_r['data'] as $get_group_tag) {
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
                    <label class="control-label" for="radiobtns" id="loc_label">Create a New Location
                        : </label>

                    <div>
                        <div class="controls col-lg-5 form-group">
                            <input class="span4 form-control" id="location_name" name="location_name" type="text" value="<?php echo ''; ?>" required>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>

            <div class="form-actions">
                <button type="submit" name="update_ssid" id="update_ssid" class="btn btn-primary">Update</button>

            </div>

        </fieldset>


        <input type="hidden" name="update_ssid_secret" value="<?php echo $_SESSION['FORM_SECRET']; ?>">


    </form>

</div>