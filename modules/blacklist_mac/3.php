<style type="text/css">
    .alert {
        margin-top: -15px;
    }
</style>
<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);*/
if ($user_type == 'MVNO') {
    $user_distributor_new = $db->getValueAsf("SELECT `parent_id` as f FROM exp_mno_distributor WHERE `distributor_code` = '$user_distributor'");
} else {
    $mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$user_distributor'");
    $user_distributor_new = $user_distributor;
}

$period_array = array("PT24H" => "24 Hours", "PT48H" => "48 Hours", "P7D" => "7 Days", "P14D" => "14 Days", "P28D" => "4 Weeks", "P91D" => "13 Weeks", "P182D" => "26 Weeks", "P364D" => "52 Weeks", "P21D" => "21 Days", "P180D" => "180 Days", "P3Y" => "3 Years", "indefinite" => "Indefinite");

if (empty($mno_time_zone)) {
    $mno_time_zone = $db->getValueAsf("SELECT timezones AS f from exp_mno WHERE mno_id='$mno_id'");
    if (empty($mno_time_zone)) {
        $mno_time_zone = $user_timezone;
    }
}

if (isset($_GET['modify_bl_en'])) {

    $modd_type = $_GET['modify_bl_en'];
    $modd_id = $_GET['id'];

    $mod_is_en = $_GET['is_enable'];

    if ($mod_is_en == '0') {

        $modd_msg = 'Enabling';
    } else {

        $modd_msg = 'Disabling';
    }


    ///////////
    $key_query11 = "SELECT mac FROM `exp_customer_blacklist` WHERE id = '$modd_id'";
    $query_results11 = $db->selectDB($key_query11);
    foreach ($query_results11['data'] as $row11) {
        $rm_session_mac_mac = $db->macFormat($row11[mac], $mac_format);
    }

    //$modd_q = "UPDATE `exp_customer_blacklist` SET `is_enable`='$mod_is_en' WHERE `id`='$modd_id'";
    // $modd_q_exe = $db->execDB($modd_q);


    $this_time_stamp = time();
    $arc_1 = "INSERT INTO exp_customer_blacklist_archive
            (`type`,`mac`,`period`,`bl_timestamp`,`wl_timestamp`,`mno`,`create_date`)
            SELECT 'Manual',`mac`,`period`,`bl_timestamp`,'$this_time_stamp',`mno`,`create_date` FROM `exp_customer_blacklist`
            WHERE id = '$modd_id'";
    $ex1 = $db->execDB($arc_1);

    $arc_2 = "DELETE FROM `exp_customer_blacklist` WHERE id = '$modd_id'";
    $ex2 = $db->execDB($arc_2);


    if ($ex2 === true) {
        $_SESSION['msg8'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('whitelist_mac_success', $rm_session_mac_mac) . "</strong></div>";
    } else {
        $_SESSION['msg8'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('whitelist_mac_fail', $rm_session_mac_mac, '2001') . "</strong></div>";
    }
}

if (isset($_POST['blacklist1'])) {

    $form_secret = $_POST['black_form_secret'];
    if ($form_secret == $_POST['black_form_secret']) {
        $do_blacklist_mac = $_POST['black_mac'];

        //clear mac
        $do_blacklist_mac = str_replace(':', '', $do_blacklist_mac);
        $do_blacklist_mac = str_replace('-', '', $do_blacklist_mac);
        $do_blacklist_mac = strtolower($do_blacklist_mac);

        $do_black_period = $_POST['blacklist_period'];

        //calculate whitelist date

        if ($do_black_period != 'indefinite') {

            $diff_time = new DateInterval($do_black_period);
            $current_time = new DateTime();

            $do_black_time = $current_time->format('U');

            $do_white_time = $current_time->add($diff_time);
            $do_white_time = $do_white_time->format('U');
        } else {
            $current_time = new DateTime();
            $do_black_time = $current_time->format('U');
            $do_white_time = 'indefinite';
        }



        //$customer_realm=$db->getValueAsf("SELECT realm AS f FROM exp_customer_sessions_mac WHERE mac='$do_blacklist_mac'");
        $q_rlm = "SELECT DISTINCT s.realm FROM exp_customer_sessions_mac s JOIN exp_mno_distributor d ON s.distributor_code=d.distributor_code
                        WHERE d.parent_id = '" . $user_distributor_new . "' s.mac ='" . $do_blacklist_mac . "' AND s.realm <>'' AND s.realm IS NOT NULL";
        $rlm_data = $db->selectDB($q_rlm);


        if ($rlm_data['rowCount'] > 0) {
            foreach ($rlm_data['data'] as $rlm_datum) {
                $customer_realm = $rlm_datum['realm'];
                $customer_mac = $rlm_datum['mac'];
                if ($customer_mac == $do_blacklist_mac) {
                    $remove_aaa_acc = $nf->deleteAccount($do_blacklist_mac, $customer_realm);

                    parse_str($remove_aaa_acc, $remove_aaa_acc);
                    $sessionresult = $ale->getSessionsbymac($do_blacklist_mac, $customer_realm);
                    if ($ses_type == 'REDIRECT') {
                        $startsession = $ale->disconnectUserSessions($do_blacklist_mac, $customer_realm, $token);
                    }
                }
            }
        }

        $period_view = $period_array[$do_black_period];

        $blacklist_mac_q = "REPLACE INTO exp_customer_blacklist (is_enable,mac, period, period_view, bl_timestamp, wl_timestamp, mno, create_date) VALUES ('1','$do_blacklist_mac','$do_black_period','$period_view','$do_black_time','$do_white_time','$user_distributor_new',NOW())";
        $blacklist_r = $db->execDB($blacklist_mac_q);



        if ($blacklist_r === true) {
            $_SESSION['msg8'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('blacklist_mac_success', $_POST['black_mac']) . "</strong></div>";
        } else {
            $_SESSION['msg8'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('blacklist_mac_fail', $_POST['black_mac'], '2001') . "</strong></div>";
        }
    } else {
        $_SESSION['msg8'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>" . $message_functions->showMessage('transection_fail') . "</strong></div>";
    }
} elseif (isset($_GET['wl_id'])) {
    if ($_SESSION['FORM_SECRET'] == $_SESSION['FORM_SECRET']) {
        $wl_mac_id = $_GET['wl_id'];

        $wl_mac_archive_q = "INSERT INTO exp_customer_blacklist_archive (mac, period, bl_timestamp, wl_timestamp, create_date, last_update, mno)
                    SELECT mac, period, bl_timestamp, wl_timestamp, create_date, last_update, mno FROM exp_customer_blacklist WHERE id='$wl_mac_id'";
        $wl_mac_archive_r = $db->execDB($wl_mac_archive_q);
        if ($wl_mac_archive_r === true) {
            $wl_q = "DELETE FROM exp_customer_blacklist WHERE id='$wl_mac_id'";
            $wl_r = $db->execDB($wl_q);
            if ($wl_r) {
                $_SESSION['msg8'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showMessage('whitelist_mac_success', $wl_mac_id) . "</strong></div>";
            } else {
                $_SESSION['msg8'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showMessage('whitelist_mac_fail', $wl_mac_id, '2003') . "</strong></div>";
            }
        } else {
            $_SESSION['msg8'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showMessage('whitelist_mac_fail', $wl_mac_id, '2001') . "</strong></div>";
        }
    } else {
        $_SESSION['msg8'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>" . $message_functions->showMessage('transection_fail') . "</strong></div>";
    }
}
if (isset($_POST['csv_update'])) {

    $configArr = array();
    $keyArr = array();
    $path = "import/api_config/";
    $name_blacklist = $_FILES['blacklist_mac_list']['name'];
    $size_blacklist = $_FILES['blacklist_mac_list']['size'];
    $tmp_blacklist = $_FILES['blacklist_mac_list']['tmp_name'];
    $maxSize = 1000;
    $blacklist_valid_formats = array("csv", "txt");
    $valid_formats = array("csv");
    $valid_value = 'yes';
    $valid_key = 'yes';

    if (strlen($name_blacklist)) {
        $status_code_blacklist = '200';

        $replace_arr_new = array("%", "@", "&", "}", "{", "#", "^");
        $name_blacklist = str_replace($replace_arr_new, '0', $name_blacklist);
        $parts = explode('.', $name_blacklist);
        $last = array_pop($parts);
        $parts = array(implode('.', $parts), $last);
        $txt = $parts[0];
        $ext = $parts[1];


        $q_rlm = "SELECT DISTINCT s.realm,s.mac FROM exp_customer_sessions_mac s JOIN exp_mno_distributor d ON s.distributor_code=d.distributor_code
                        WHERE d.parent_id = '" . $user_distributor_new . "' AND s.realm <>'' AND s.realm IS NOT NULL";
        $rlm_data = $db->selectDB($q_rlm);




        if (in_array($ext, $blacklist_valid_formats)) {
            $blacklist_file = 'yes';
            if ($size_blacklist < (1024 * $maxSize)) {

                $csv_name_blacklist = "blacklist_mac_" . time() . "." . $ext;

                if (move_uploaded_file($tmp_blacklist, $path . $csv_name_blacklist)) {

                    $row = 1;
                    if (($handle = fopen($path . $csv_name_blacklist, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $num = count($data);
                            $macarr = explode(',', $data[0]);

                            $do_blacklist_mac = $macarr['0'];
                            echo "</br>";

                            $do_blacklist_mac = str_replace(':', '', $do_blacklist_mac);
                            $do_blacklist_mac = str_replace('-', '', $do_blacklist_mac);
                            $do_blacklist_mac = strtolower($do_blacklist_mac);

                            $do_blacklist_mac_tr = CommonFunctions::checkMac($do_blacklist_mac);

                            $period_view = $macarr['1'];
                            if (empty($period_view)) {
                                $period_view = 'Indefinite';
                            }
                            $do_black_period = array_search($period_view, $period_array);
                            //calculate whitelist date
                            if (strlen($do_black_period) > 0 and $do_blacklist_mac_tr) {

                                if ($do_black_period != 'indefinite') {

                                    $diff_time = new DateInterval($do_black_period);
                                    $current_time = new DateTime();

                                    $do_black_time = $current_time->format('U');

                                    $do_white_time = $current_time->add($diff_time);
                                    $do_white_time = $do_white_time->format('U');
                                } else {
                                    $current_time = new DateTime();
                                    $do_black_time = $current_time->format('U');
                                    $do_white_time = 'indefinite';
                                }

                                if ($rlm_data['rowCount'] > 0) {
                                    foreach ($rlm_data['data'] as $rlm_datum) {
                                        $customer_realm = $rlm_datum['realm'];
                                        $customer_mac = $rlm_datum['customer_mac'];
                                        if ($customer_mac == $do_blacklist_mac) {
                                            $remove_aaa_acc = $nf->deleteAccount($do_blacklist_mac, $customer_realm);

                                            parse_str($remove_aaa_acc, $remove_aaa_acc);
                                            $sessionresult = $ale->getSessionsbymac($do_blacklist_mac, $customer_realm);
                                            if ($ses_type == 'REDIRECT') {
                                                $startsession = $ale->disconnectUserSessions($do_blacklist_mac, $customer_realm, $token);
                                            }
                                        }
                                    }
                                }




                                $blacklist_mac_q = "REPLACE INTO exp_customer_blacklist (is_enable,mac, period, period_view, bl_timestamp, wl_timestamp, mno, create_date) VALUES ('1','$do_blacklist_mac','$do_black_period','$period_view','$do_black_time','$do_white_time','$user_distributor_new',NOW())";
                                $blacklist_r = $db->execDB($blacklist_mac_q);
                            } else {
                                //$status_code_blacklist = '400';
                                /*$response = 'Update has failed. Can`t read file.';*/
                            }
                            $row++;
                        }
                        fclose($handle);
                    }
                } else {
                    $status_code_blacklist = '400';
                    $response = 'Update has failed. Can`t write file.';
                }
            } else {
                $status_code_blacklist = '400';
                $response = 'Image file size max ' . $maxSize . ' KB.';
            }
        } else {

            $status_code_blacklist = '400';
            $response = 'Invalid format. Acceptable formats: CSV.';
        }
    } else {
        $status_code_blacklist = '400';
        $response = 'Please select a file';
    }


    if ($status_code_blacklist == '200') {
        $show_msg = $message_functions->showMessage('api_network_profile_update_succe');
        $create_log->save('3009', $show_msg, "");
        $_SESSION['msg8'] = "<div class='alert alert-success'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $show_msg . "</strong></div>";
    } else {

        $show_msg = $message_functions->showMessage('api_network_profile_update_faile');
        $create_log->save('3009', $show_msg, "");
        $_SESSION['msg8'] = "<div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $response . "</strong></div>";
    }
}

if (isset($_POST['whitelist'])) {

    $form_secret = $_POST['white_form_secret'];
    if ($form_secret == $_POST['white_form_secret']) {
        $do_whitelist_mac = $_POST['white_mac'];

        //clear mac
        $do_whitelist_mac = str_replace(':', '', $do_whitelist_mac);
        $do_whitelist_mac = str_replace('-', '', $do_whitelist_mac);
        $do_whitelist_mac = strtolower($do_whitelist_mac);



        $whitelist_mac_q = "DELETE FROM exp_customer_blacklist WHERE mac='$do_whitelist_mac' AND `mno` = '$user_distributor_new'";
        $whitelist_r = $db->execDB($whitelist_mac_q);

        if ($whitelist_r === true) {
            $_SESSION['msg8'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('whitelist_mac_success', $_POST['white_mac']) . "</strong></div>";
        } else {
            $_SESSION['msg8'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button>
                                <strong>" . $message_functions->showNameMessage('whitelist_mac_fail', $_POST['white_mac'], '2001') . "</strong></div>";
        }
    } else {
        $_SESSION['msg8'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button>
                            <strong>" . $message_functions->showMessage('transection_fail') . "</strong></div>";
    }
}

if (isset($_POST['csv_update_whitelist'])) {

    $configArr = array();
    $keyArr = array();
    $path = "import/api_config/";
    $name_whitelist = $_FILES['whitelist_mac_list']['name'];
    $size_whitelist = $_FILES['whitelist_mac_list']['size'];
    $tmp_whitelist = $_FILES['whitelist_mac_list']['tmp_name'];
    $maxSize = 1000;
    $whitelist_valid_formats = array("csv", "txt");
    $valid_formats = array("csv");
    $valid_value = 'yes';
    $valid_key = 'yes';

    if (strlen($name_whitelist)) {
        $status_code_whitelist = '200';

        $replace_arr_new = array("%", "@", "&", "}", "{", "#", "^");
        $name_whitelist = str_replace($replace_arr_new, '0', $name_whitelist);
        $parts = explode('.', $name_whitelist);
        $last = array_pop($parts);
        $parts = array(implode('.', $parts), $last);
        $txt = $parts[0];
        $ext = $parts[1];

        if (in_array($ext, $whitelist_valid_formats)) {
            $whitelist_file = 'yes';
            if ($size_whitelist < (1024 * $maxSize)) {

                $csv_name_whitelist = "whitelist_mac_" . time() . "." . $ext;

                if (move_uploaded_file($tmp_whitelist, $path . $csv_name_whitelist)) {

                    $row = 1;
                    if (($handle = fopen($path . $csv_name_whitelist, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $num = count($data);
                            $macarr = explode(',', $data[0]);

                            $do_whitelist_mac = $macarr['0'];

                            $do_whitelist_mac = str_replace(':', '', $do_whitelist_mac);
                            $do_whitelist_mac = str_replace('-', '', $do_whitelist_mac);
                            $do_whitelist_mac = strtolower($do_whitelist_mac);


                            //calculate whitelist date
                            if (strlen($do_whitelist_mac) > 0) {

                                $whitelist_mac_q = "DELETE FROM exp_customer_blacklist WHERE mac='$do_whitelist_mac' AND `mno` = '$user_distributor_new'";

                                $whitelist_r = $db->execDB($whitelist_mac_q);
                            } else {
                                $status_code_whitelist = '400';
                                $response = 'Update has failed. Can`t read file.';
                            }
                            $row++;
                        }
                        fclose($handle);
                    }
                } else {
                    $status_code_whitelist = '400';
                    $response = 'Update has failed. Can`t write file.';
                }
            } else {
                $status_code_whitelist = '400';
                $response = 'Image file size max ' . $maxSize . ' KB.';
            }
        } else {

            $status_code_whitelist = '400';
            $response = 'Invalid format. Acceptable formats: CSV.';
        }
    } else {
        $status_code_whitelist = '400';
        $response = 'Please select a file';
    }


    if ($status_code_whitelist == '200') {
        $show_msg = $message_functions->showMessage('api_network_profile_update_succe');
        $create_log->save('3009', $show_msg, "");
        $_SESSION['msg8'] = "<div class='alert alert-success'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $show_msg . "</strong></div>";
    } else {

        $show_msg = $message_functions->showMessage('api_network_profile_update_faile');
        $create_log->save('3009', $show_msg, "");
        $_SESSION['msg8'] = "<div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert'>×</button>
                                        <strong>" . $response . "</strong></div>";
    }
}


if (isset($_SESSION['msg8'])) {
    echo $_SESSION['msg8'];
    unset($_SESSION['msg8']);
} ?>
<div <?php if (isset($tab_blacklist_mac)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="blacklist_mac">

    <div>

    </div>
    <style type="text/css">
        @media (min-width: 1200px) {
            .new_blacklist {
                margin-left: 28% !important;
                /* width: 360px; */
            }
        }

        .form-horizontal .controls {
            margin-left: 0px !important;
        }
    </style>
    <!--blacklist form-->

    <br>
    <h1 class="head" style="display: none;">Manage Blacklist</h1>
    <div>Retrieve a list of all Blacklisted devices in this property. Use this section to immediately delete a device
        from the system and force the device to re-register for access. You can remove Blacklisted devices by clicking
        the ENABLE button.
    </div>
    <br>

    <form name="blacklist_form" id="blacklist_form" class="form-horizontal" method="post" action="?t=blacklist_mac">
        <div class="form-group">
            <fieldset>


                <div class="control-group">

                    <div class="controls col-lg-5 form-group">

                        <h3>Blacklist Device</h3>

                        <div class="" for="radiobtns">MAC Address <span class="new_blacklist" for="radiobtns" style="margin-left: 21%">Suspension Period</span>
                        </div>

                        <input maxlength="17" data-toggle="tooltip" autocomplete="off" type="text" id="black_mac" name="black_mac" class="span4" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">
                        <select autocomplete="off" class="span2" name="blacklist_period" id="blacklist_period">

                            <option value="PT24H">24 Hours</option>
                            <option value="PT48H">48 Hours</option>
                            <option value="P7D">7 Days</option>
                            <option value="P14D">14 Days</option>
                            <option value="P21D">21 Days</option>
                            <option value="P180D">180 Days</option>
                            <option value="indefinite">Indefinite</option>
                        </select>

                        <input type="hidden" name="black_form_secret" value="<?php echo $secret; ?>">

                        <button disabled name="blacklist1" id="blacklist1" type="submit" class="btn btn-primary" style="text-decoration:none">
                            <i class="btn-icon-only icon-download"></i> Add Mac Address

                        </button>
                        <small id="bl_mac_ext" class="help-block" style="display: none;"></small>

                        <script type="text/javascript">
                            $(document).ready(function() {

                                $('#black_mac').tooltip();
                                $('#search_mac').tooltip();

                            });

                            function vali_blacklist(rlm) {

                                var val = rlm.value;
                                var val = val.trim();


                                if (val != "") {
                                    document.getElementById("bl_mac_ext").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                    var formData = {
                                        blmac: val,
                                        user: "<?php echo $user_distributor_new; ?>"
                                    };
                                    $.ajax({
                                        url: "ajax/validateblacklist.php",
                                        type: "POST",
                                        data: formData,
                                        success: function(data) {


                                            if (data == '1') {
                                                /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                document.getElementById("bl_mac_ext").innerHTML = "";
                                                $('#bl_mac_ext').hide();


                                            } else if (data == '2') {
                                                //inline-block

                                                $('#bl_mac_ext').css('display', 'inline-block');
                                                document.getElementById("bl_mac_ext").innerHTML = "<p>The MAC [" + val + "] you are trying to add is already disabled, please try a different MAC.</p>";
                                                document.getElementById('black_mac').value = "";
                                                /* $('#mno_account_name').removeAttr('value'); */
                                                document.getElementById('black_mac').placeholder = "Please enter new MAC";
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            //alert("error");
                                            document.getElementById('black_mac').value = "";
                                        }
                                    });
                                }
                            }
                        </script>

                    </div>


                    <div class="input-prepend input-append">

                    </div>
                    <!-- /controls -->
                </div>
                <!-- /control-group -->


            </fieldset>
        </div>
    </form>

    <form name="upload_csv" id="upload_csv" class="form-horizontal" method="post" action="?t=blacklist_mac" enctype="multipart/form-data">
        <div class="form-group">
            <fieldset>
                <?php

                echo '<input type="hidden" name="update_csv_secret" id="update_api_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

                ?>
                <div class="control-group">
                    <div class="controls col-lg-5 form-group">
                        <h3>Blacklist Devices</h3>
                    </div>
                </div>


                <div class="control-group">

                    <div class="controls form-group">
                        <label class="" for="radiobtns">Add Mac List </label>
                        <div class="">

                            <input type="file" class="span4 form-control" name="blacklist_mac_list" id="blacklist_mac_list">
                            <img id="tooltip1" data-toggle="tooltip" title="You can blacklist or whitelist multiple devices by downloading and using our CSV template.

                                                                To blacklist a device add the MAC Address and specify the time_range.

                                                                To whitelist a blacklisted device only add the MAC Address and leave the time_range empty.

                                                                Valid Time Range Formats are: 24 Hours, 48 Hours, 7 Days,14 Days, 21 Days, 180 Days, Indefinite." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">

                            <button disabled type="submit" name="csv_update" id="csv_update" class="btn btn-primary">Add Mac Address List
                            </button>

                            <a href='export/csv/blacklist.csv' class="btn btn-primary">
                                <i class="btn btn-primary icon-download"></i> Download Template
                            </a>

                        </div>

                    </div>

                </div>


                <!-- /control-group -->


            </fieldset>
        </div>
    </form>

    <!--whitelist form-->

    <form name="whitelist_form" id="whitelist_form" class="form-horizontal" method="post" action="?t=blacklist_mac" onsubmit="return macvalidate();">
        <div class="form-group">


            <fieldset>

                <!-- <input type="hidden" id="check_post_val" name="blacklist_all_search_dis"> -->


                <div class="control-group">

                    <div class="controls col-lg-5 form-group">

                        <h3>Search Blacklisted Devices</h3>

                        <div>MAC Address</div>
                        <!-- <label class="" for="radiobtns">MAC Address</label> -->

                        <!--pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$"-->

                        <input maxlength="17" autocomplete="off" type="text" id="search_mac" name="search_mac" class="span4" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">


                        <small id="mac_val" class="help-block" data-fv-validator="regexp" data-fv-for="search_mac" data-fv-result="NOT_VALIDATED" style="display: none;">
                            <p>Please enter a valid MAC address
                                matching the pattern with the value range from 0-9, A-F</p>
                        </small>
                        <button name="blacklist_mac_search" id="blacklist_mac_search" type="submit" class="btn btn-primary" style="text-decoration:none">Search
                        </button>
                        <img id="tooltip1" data-toggle="tooltip" title="You can search for a specific MAC address or load all blacklisted devices. The results will be displayed in the table below.

                                                                    A blacklisted devices can be manually whitelisted prior to it's automatic whitelist date by clicking the 'Enable' link in the table." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                        <button id="blacklist_all_search_b1" type="button" class="btn btn-info inline-btn" style="text-decoration:none">List Blacklisted MACs
                        </button>


                    </div>
                </div>


            </fieldset>
        </div>
    </form>

    <div style="display:none">
        <form class="form-horizontal" method="post" action="?t=blacklist_mac">
            <input type="hidden" id="check_post_val" name="blacklist_all_search_dis">
            <button id="blacklist_all_search" type="submit" class="btn btn-info inline-btn" style="text-decoration:none">List Blacklisted MACs
            </button>

        </form>
    </div>

    <div class="widget widget-table action-table tablesaw-widget">
        <div class="widget-header">
            <!--  <i class="icon-th-list"></i> -->

            <h3>Session Search Result</h3>
        </div>
        <!-- /widget-header -->
        <div class="widget-content table_response">
            <div style="overflow-x:auto">
                <table id="blacklist_search_table1" class="table table-striped table-bordered tablesaw" cellspacing="0" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                    <thead>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Blacklist Date</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Suspension</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Whitelist Date</th>
                            <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">remove MAC</th> -->

                            <?php if (isset($_POST[blacklist_mac_search])) { ?>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Whitelist type</th>


                            <?php } ?>

                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">WI-FI Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (isset($_POST[blacklist_all_search])) {

                            $get_blacklist_q = "SELECT *,'main' as ar FROM exp_customer_blacklist WHERE mno='$user_distributor_new'";
                        } elseif (isset($_POST[blacklist_mac_search])) {

                            $ser_mac = $_POST[search_mac];
                            $ser_mac = str_replace(':', '', $ser_mac);
                            $ser_mac = str_replace('-', '', $ser_mac);

                            $get_blacklist_q = "SELECT *,'main' as ar, type as type1 FROM exp_customer_blacklist WHERE mno='$user_distributor_new' and mac='$ser_mac'
                                                                            UNION
                                                                            SELECT *,'arc' as ar, IF(type='Manual', 'Manual', 'Automatic') as type1 FROM exp_customer_blacklist_archive WHERE mno='$user_distributor_new' and mac='$ser_mac'";
                        } else {
                            $get_blacklist_q = "";
                        }


                        //$get_blacklist_q="SELECT * FROM exp_customer_blacklist WHERE mno='$user_distributor_new'";
                        $get_blacklist_r = $db->selectDB($get_blacklist_q);

                        foreach ($get_blacklist_r['data'] as $blacklist_row) {
                            $device_mac = $blacklist_row['mac'];
                            $device_mac_display = $db->macFormat($device_mac, $mac_format);

                            $rwid = $blacklist_row['id'];

                            $tz = new DateTimeZone($mno_time_zone);

                            //convert blacklist date
                            $blacklist_date = date_create();
                            date_timestamp_set($blacklist_date, $blacklist_row['bl_timestamp']);
                            $blacklist_date->setTimezone($tz);
                            $blacklist_date = $blacklist_date->format('m/d/Y h:i A');


                            //convert whitelist name
                            $whitelist_date = date_create();
                            date_timestamp_set($whitelist_date, $blacklist_row['wl_timestamp']);
                            $whitelist_date->setTimezone($tz);
                            $whitelist_date = $whitelist_date->format('m/d/Y h:i A');


                            $suspension = $blacklist_row['period'];

                            if ($suspension == 'indefinite') {

                                $gap = 'Indefinite';
                                $whitelist_date = 'N/A';
                            } else {

                                $gap = "";
                                if ($suspension != '') {

                                    $interval = new DateInterval($suspension);

                                    if ($interval->y != 0) {
                                        $gap .= $interval->y . ' Years ';
                                    }
                                    if ($interval->m != 0) {
                                        $gap .= $interval->m . ' Months ';
                                    }
                                    if ($interval->d != 0) {
                                        $gap .= $interval->d . ' Days ';
                                    }
                                    if (($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0 || $interval->h != 0)) {
                                        $gap .= ' And ';
                                    }
                                    if ($interval->h != 0) {
                                        $gap .= $interval->h . ' Hours ';
                                    }
                                    if ($interval->i != 0) {
                                        $gap .= $interval->i . ' Minutes ';
                                    }
                                }
                            }

                            $remove_mac = '<a href="javascript:void();" id="do_white_mac' . $blacklist_row["id"] . '" class="btn btn-small btn-primary">
                                                                                <i class="btn-icon-only icon-info-sign"></i>&nbsp;Remove</a>
                                                                                <script type="text/javascript">
                                                                                    $(document).ready(function() {
                                                                                    $(\'#do_white_mac' . $blacklist_row["id"] . '\').easyconfirm({locale: {
                                                                                            title: \'Whitelist MAC\',
                                                                                            text: \'Are you sure you want to whitelist this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                            button: [\'Cancel\',\' Confirm\'],
                                                                                            closeText: \'close\'
                                                                                             }});
                                
                                                                                        $(\'#do_white_mac' . $blacklist_row["id"] . '\').click(function() {
                                                                                            window.location = "?wl_secret=' . $secret . '&t=blacklist_mac&wl_id=' . $blacklist_row["id"] . '"
                                
                                                                                        });
                                
                                                                                        });
                                
                                                                                    </script>
                                                                                ';
                            echo '<tr>
                                                                    <td>' . $device_mac_display . '</td>
                                                                    <td>' . $blacklist_date . '</td>
                                                                    <td>' . $gap . '</td>
                                                                    <td>' . $whitelist_date . '</td>';

                            if (isset($_POST[blacklist_mac_search])) {

                                echo '<td>' . $blacklist_row[type1] . '</td>';
                            }

                            $isenn = $blacklist_row['is_enable'];
                            $main_tbl = $blacklist_row['ar'];

                            echo '<td>';

                            if ($main_tbl == 'main') {


                                if ($isenn == '1') {

                                    /* echo   '<div class="toggle2"><input onchange="" type="checkbox" class="hide_checkbox">
                                          <a href="javascript:void();" id="ST_'.$rwid.'"><span class="toggle2-on-dis">Enable</span></a>
                                 <span class="toggle2-off">Disable</span>
                                 </div>'; */

                                    echo '<a class="btn btn-small btn-primary" href="javascript:void();" id="ST_' . $rwid . '">Enable</a>';


                                    echo '<script type="text/javascript">

                                                            $(document).ready(function() {

                                                            $(\'#ST_' . $rwid . '\').easyconfirm({locale: {

                                                                    title: \'Enable MAC\',

                                                                    text: \'Are you sure you want to enable this MAC?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                    button: [\'Cancel\',\' Confirm\'],

                                                                    closeText: \'close\'

                                                                     }});

                                                                $(\'#ST_' . $rwid . '\').click(function() {



                                                                window.location = "?t=blacklist_mac&modify_bl_en=2&is_enable=0&id=' . $rwid . '"

                                                                });

                                                                });

                                                            </script>';
                                } else {
                                    echo '<div class="toggle2"><input checked onchange="" href="javascript:void();" id="ST_' . $rwid . '" type="checkbox" class="hide_checkbox"><span class="toggle2-on">Enable</span>
                                                                    <a href="javascript:void();" id="CE_' . $rwid . '"><span class="toggle2-off-dis">Disable</span></a>
                                                                </div>';


                                    echo '<script type="text/javascript">

                                                            $(document).ready(function() {

                                                            $(\'#CE_' . $rwid . '\').easyconfirm({locale: {

                                                                    title: \'Disable MAC\',

                                                                    text: \'Are you sure you want to disable this  MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                    button: [\'Cancel\',\' Confirm\'],

                                                                    closeText: \'close\'

                                                                     }});

                                                                $(\'#CE_' . $rwid . '\').click(function() {

                                                                    window.location = "?t=blacklist_mac&modify_bl_en=2&is_enable=1&id=' . $rwid . '"

                                                                });

                                                                });

                                                            </script>';
                                }
                            } else {
                            }

                            echo '</td>';


                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form style="display: none !important;" name="whitelist_formn" id="whitelist_formn" class="form-horizontal" method="post" action="?t=blacklist_mac">
        <div class="form-group">
            <fieldset>


                <div class="control-group">

                    <div class="controls col-lg-5 form-group">

                        <h3>Remove From Blacklist
                            <!--Whitelisted Device-->
                        </h3>

                        <div class="" for="radiobtns">MAC Address
                        </div>

                        <input maxlength="17" data-toggle="tooltip" autocomplete="off" type="text" id="white_mac" name="white_mac" class="span4" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">

                        <input type="hidden" name="white_form_secret" value="<?php echo $secret; ?>">

                        <button disabled name="whitelist" id="whitelist" type="submit" class="btn btn-primary" style="text-decoration:none">
                            <i class="btn-icon-only icon-download"></i> Enable Mac Address

                        </button>
                        <small id="wl_mac_ext" class="help-block" style="display: none;"></small>

                        <script type="text/javascript">
                            $(document).ready(function() {

                                $('#white_mac').tooltip();

                            });

                            function vali_whitelist(rlm) {

                                var val = rlm.value;
                                var val = val.trim();



                                if (val != "") {
                                    document.getElementById("wl_mac_ext").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                    var formData = {
                                        blmac: val,
                                        user: "<?php echo $user_distributor_new; ?>"
                                    };
                                    $.ajax({
                                        url: "ajax/validateblacklist.php",
                                        type: "POST",
                                        data: formData,
                                        success: function(data) {


                                            if (data == '1') {
                                                /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                document.getElementById("wl_mac_ext").innerHTML = "";
                                                $('#wl_mac_ext').hide();


                                            } else if (data == '2') {
                                                //inline-block

                                                $('#wl_mac_ext').css('display', 'inline-block');
                                                document.getElementById("wl_mac_ext").innerHTML = "<p>The MAC [" + val + "] you are trying to add is already disabled, please try a different MAC.</p>";
                                                document.getElementById('white_mac').value = "";
                                                /* $('#mno_account_name').removeAttr('value'); */
                                                document.getElementById('white_mac').placeholder = "Please enter new MAC";
                                            }
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            //alert("error");
                                            document.getElementById('white_mac').value = "";
                                        }
                                    });
                                }
                            }
                        </script>

                    </div>


                    <!-- /controls -->
                </div>
                <!-- /control-group -->


            </fieldset>
        </div>
    </form>

    <form name="upload_csvn" id="upload_csvn" class="form-horizontal" method="post" action="?t=blacklist_mac" enctype="multipart/form-data">
        <div class="form-group">

            <fieldset>
                <?php

                echo '<input type="hidden" name="update_csv_secret2" id="update_api_secret2" value="' . $_SESSION['FORM_SECRET'] . '" />';

                ?>
                <div class="control-group">
                    <div class="controls col-lg-5 form-group">

                        <br>
                        <h3>Remove Devices from Blacklist</h3>
                    </div>
                </div>


                <div class="control-group">

                    <div class="controls form-group">
                        <label class="" for="radiobtns">Add Mac List</label>
                        <div class="">

                            <input type="file" class="span4 form-control" name="whitelist_mac_list" id="whitelist_mac_list">

                            <img data-placement="top" id="tooltip1" data-toggle="tooltip" title="You can blacklist or whitelist multiple devices by downloading and using our CSV template.

                                                                To blacklist a device add the MAC Address and specify the time_range.

                                                                To whitelist a blacklisted device only add the MAC Address and leave the time_range empty.

                                                                Valid Time Range Formats are: 24 Hours, 48 Hours, 7 Days,14 Days, 21 Days, 180 Days, Indefinite." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">
                            <button disabled type="submit" name="csv_update_whitelist" id="csv_update_whitelist" class="btn btn-primary">Enable Mac Address List
                            </button>

                            <a href='export/csv/whitelist.csv' class="btn btn-primary">
                                <i class="btn btn-primary icon-download"></i> Download Template
                            </a>

                        </div>

                    </div>

                </div>

                <!-- /control-group -->


            </fieldset>
        </div>
    </form>


    <style type="text/css">
        .nav-tabs>li:last-child>a {
            border-right: none !important;
        }


        input[name="blacklist_mac_list"]::before {
            width: 250px;
            height: 30px;
            color: #fff;
            content: 'Select CSV file';
            background-color: #0084d6 !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border-radius: 8px !important;
            padding: 4px 15px;
            min-width: 70px !important;
            cursor: pointer;
            font-size: 14px;
            line-height: 22px;
            font-family: 'Open Sans';
        }

        input[name="blacklist_mac_list"]:hover:before {
            background-color: #369a87 !important;
        }

        input[name="blacklist_mac_list"] {
            color: transparent;
            outline: 0 !important;
            top: 0px;
            right: 0px;
            width: 120px !important;
        }


        input[name="whitelist_mac_list"]::before {
            width: 250px;
            height: 30px;
            color: #fff;
            content: 'Select CSV file';
            background-color: #0084d6 !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border-radius: 8px !important;
            padding: 4px 15px;
            min-width: 70px !important;
            cursor: pointer;
            font-size: 14px;
            line-height: 22px;
            font-family: 'Open Sans';
        }

        input[name="whitelist_mac_list"] {
            color: transparent;
            outline: 0 !important;
            top: 0px;
            right: 0px;
            width: 120px !important;
        }


        input[name="whitelist_mac_list"]:hover:before {
            background-color: #369a87 !important;
        }
    </style>

</div>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/formValidation.js"></script>
<script type="text/javascript" src="js/bootstrap_form.js"></script>
<script type="text/javascript">
    $('#blacklist_all_search').click(function(e) {
        $('#check_post_val').attr('name', 'blacklist_all_search');
    });

    $('#blacklist_all_search_b1').click(function(e) {
        $("#blacklist_all_search").click();
    });

    $(document).ready(function() {

        $('#upload_csv').formValidation({
            framework: 'bootstrap',
            fields: {
                blacklist_mac_list: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });

        $('#upload_csvn').formValidation({
            framework: 'bootstrap',
            fields: {
                whitelist_mac_list: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });

        $('#blacklist_form').formValidation({
            framework: 'bootstrap',
            fields: {

                black_mac: {
                    validators: {
                        <?php echo $db->validateField('mac'); ?>
                        remote: {
                            url: 'ajax/validateblacklist.php',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator, $field, value) {
                                return {
                                    blmac: validator.getFieldElements('black_mac').val(),
                                    user: "<?php echo $user_distributor_new; ?>"
                                };
                            },
                            message: '<p>The MAC Address you are trying to add has already been disabled. Please try with a different MAC Address.</p>',
                            type: 'POST'
                        }
                    }
                },
                blacklist_period: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });
    });
</script>

<script type="text/javascript">
    var blacklist_tbl = $('#blacklist_search_table1').DataTable({
        "ordering": false,
        "pageLength": 50,
        "paging": false,
        "info": false
    });

    <?php if (isset($_POST[blacklist_all_search]) || isset($_GET[blacklist_all_search])) { ?>

        $('#search_mac').on('keyup', function() {
            blacklist_tbl.search(this.value).draw();
        });

    <?php } ?>


    $(document).ready(function() {
        $("#blacklist1").easyconfirm({
            locale: {
                title: 'Blacklist MAC',
                text: 'Are you sure you want to disable Wi-Fi access for this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                button: ['Cancel', ' Confirm'],
                closeText: 'close'
            }
        });
        $("#blacklist1").click(function() {

        });
    });
</script>