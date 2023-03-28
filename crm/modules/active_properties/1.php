<div <?php if (isset($tab_active_properties)){ ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?>
     id="active_properties">

    <div class="support_head_visible" style="display:none;">
        <div class="header_hr"></div>
        <div class="header_f1" style="width: 100%;">
            Accounts
        </div>
        <br class="hide-sm"><br class="hide-sm">
        <div class="header_f2" style="width: 100%;"></div>
    </div>

    <div id="response_d1">

    </div>

    <?php if (isset($_GET['view_loc_code'])){ //v1

    ///Show account mac details///////
    $view_loc_code = $_GET['view_loc_code'];
    $view_loc_name = $_GET['view_loc_name'];

    ?>


    <div id="response_d1">

    </div>


    <div class="widget widget-table action-table">
        <div class="widget-header">
            <!-- <i class="icon-th-list"></i> -->
            <h3>View Account</h3>


        </div>


        <!-- /widget-header -->

        <div class="widget-content table_response">

            <div style="overflow-x:auto">


                <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle"
                       data-tablesaw-minimap>
                    <thead>
                    <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Business ID</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Customer Account#
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Serial</th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Model</th>
                        <?php // echo$package_functions->getSectionType('AP_ACTIONS',$system_package);
                        if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') { ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Actions</th>
                        <?php } ?>

                    </tr>

                    </thead>
                    <tbody>
                    <?php


                    /*echo  $key_query="SELECT  l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`
                                    FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d
                                    ON d.`ap_code`= l.`ap_code`
                                    AND d.`distributor_code`='$view_loc_code' GROUP BY d.`ap_code`";*/
                    /* $key_query=  "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                     FROM `exp_locations_ap` l INNER JOIN `exp_mno_distributor_aps` d ON d.`ap_code`= l.`ap_code`, `exp_mno_distributor` a
                                     WHERE d.`distributor_code`='$view_loc_code' AND a.`distributor_code`=d.`distributor_code` GROUP BY d.`ap_code`"; */

                    $key_query = "SELECT l.serial,l.model, l.id ,d.`ap_code`,d.`distributor_code`,l.`mac_address`,l.`create_date`,a.`distributor_name`,a.`verification_number`
                                                                        FROM `exp_mno_distributor` a LEFT JOIN `exp_mno_distributor_aps` d  ON a.`distributor_code`=d.`distributor_code` LEFT JOIN `exp_locations_ap` l ON d.`ap_code`= l.`ap_code`
                                                                        WHERE a.parent_id='$view_loc_code' GROUP BY d.`ap_code`,a.verification_number";

                    $query_results = $db->selectDB($key_query);

                    
                    foreach ($query_results['data'] AS $row) {

                        $cpe_id = $row[id];
                        $cpe_name = $row[ap_code];
                        $ip = $row[distributor_name];

                        if (empty($row[verification_number])) {
                            $icoms = "N/A";
                        } else {
                            $icoms = $row[verification_number];
                        }

                        if (empty($row[mac_address])) {
                            $mac_address = "N/A";
                        } else {
                            $mac_address = $row[mac_address];
                        }

                        if (empty($row[create_date])) {
                            $created_date = "N/A";
                        } else {
                            $created_date = $row[create_date];
                        }

                        if (empty($row[serial])) {
                            $serial = "N/A";
                        } else {
                            $serial = $row[serial];
                        }

                        if (empty($row[model])) {
                            $model = "N/A";
                        } else {
                            $model = $row[model];
                        }


                        echo '<tr>
                                                                    <td> ' . $view_loc_code . ' </td>
                                                                    <td> ' . $icoms . ' </td>
                                                                    <td> ' . $mac_address . ' </td>
                                                                    <td> ' . $serial . ' </td>

                                                                    <td> ' . $model . ' </td>';
                        if ($package_functions->getSectionType('AP_ACTIONS', $system_package) == '1' || $system_package == 'N/A') {
                            echo '<td>';
                            //print_r($action_event=(array)json_decode($package_functions->getOptions('AP_ACTIONS',$system_package)));
                            $action_event = (array)json_decode($package_functions->getOptions('AP_ACTIONS', $system_package));

                            if (in_array('edit', $action_event) || $system_package == 'N/A') {
                                echo '<a href="javascript:void();" id="EDITAP_' . $cpe_id . '"  class="btn btn-small btn-info">

                                                        <i class="btn-icon-only icon-wrench"></i>&nbsp;Edit</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#EDITAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                            title: \'CPE Edit\',
                                                            text: \'Are you sure,you want to edit this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#EDITAP_' . $cpe_id . '\').click(function() {
                                                            window.location = "?token7=' . $secret . '&t=2&edit_ap_id=' . $cpe_id . '&edit_loc_code=' . $view_loc_code . '&edit_loc_name=' . $view_loc_name . '"

                                                        });

                                                        });

                                                    </script>&nbsp;&nbsp;';
                            }
                            if (in_array('remove', $action_event) || $system_package == 'N/A') {


                                echo '<a href="javascript:void();" id="REMAP_' . $cpe_id . '"  class="btn btn-small btn-danger">

                                                        <i class="btn-icon-only icon-trash"></i>&nbsp;Remove</a><script type="text/javascript">

                                                    $(document).ready(function() {
                                                    $(\'#REMAP_' . $cpe_id . '\').easyconfirm({locale: {
                                                            title: \'CPE Remove\',
                                                            text: \'Are you sure,you want to remove this cpe ?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            button: [\'Cancel\',\' Confirm\'],
                                                            closeText: \'close\'
                                                             }});

                                                        $(\'#REMAP_' . $cpe_id . '\').click(function() {
                                                            window.location = "?token7=' . $secret . '&t=active_properties&view_loc_name=' . $view_loc_name . '&remove_ap_name=' . $cpe_name . '&rem_ap_id=' . $cpe_id . '&view_loc_code=' . $view_loc_code . '"

                                                        });

                                                        });

                                                    </script>';
                            }

                            echo '</td>';
                        }
                        echo '</tr>';


                    }

                    ?>


                    </tbody>

                </table>
            </div>
        </div>

        <div class="controls col-lg-5 form-group" style="display:inline-block;padding-top:10px;">
            <a href="?view_loc_name=<?php echo $view_loc_name; ?>&view_loc_code=<?php echo $view_loc_code ?>&t=active_properties&action=sync_data_tab1&token8=<?php echo $secret; ?>"
               class="btn btn-primary" style="align: left;" data-toggle="tooltip"
               title="Please click on the Refresh button to reload the AP list if the AP information is not properly loaded."><i
                        class="btn-icon-only icon-refresh"></i>Refresh</a>

            <!-- <a href="location.php" style="text-decoration:none;" class="btn btn-info inline-btn" >Back</a>-->

        </div>

        <?php
        //////////////////////////////////////////////////
        }else {//v1
        ?>

        <?php

        if (isset($_SESSION['msg_location_update'])) {
            echo $_SESSION['msg_location_update'];
            unset($_SESSION['msg_location_update']);

        }

        ?>

        <form class="form-horizontal ">
            <div class="form-group">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Select Account Name </label>
                        <div class="controls col-lg-5 form-group">
                            <select name="activeLocationsAccount" id="activeLocationsAccount"
                                    class="span4 form-control">
                                <option value="">Select Account Name</option>
                                <?php
                                $queryString = "SELECT p.account_name FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                WHERE m.mno_id='$user_distributor' AND u.is_enable <>'2' GROUP BY p.parent_id";
                                $queryResult = $db->selectDB($queryString);
                                if ($queryResult['rowCount'] > 0) {
                                    foreach ($queryResult['data'] AS $row) {
                                        $account_name = $row['account_name'];
                                        echo "<option class='selectors' value='" . $account_name . "'>" . $account_name . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="radiobtns">Search on Business ID </label>
                        <div class="controls col-lg-5 form-group">
                            <input autocomplete="off" type="text" id="activeLocationsBusId" name="activeLocationsBusId"
                                   class="span4 form-control">

                        </div>
                    </div>
                    <div class="form-actions">
                        <button name="activeLocationsSearch" id="activeLocationsSearch" type="button"
                                class="btn btn-info" style="text-decoration:none"> Search
                        </button>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#activeLocationsBusId').keydown(function (e) {

                                if (e.keyCode == 13) {
                                    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
                                    var request = {
                                        listsize: $('#activeLocationsTablePerpage').val(),
                                        type: 'locationActiveAccounts',
                                        user_distributor: '<?php echo $user_distributor; ?>',
                                        busId: $('#activeLocationsBusId').val(),
                                        accName: $('#activeLocationsAccount').val()
                                    }
                                    ajaxCall(request);
                                }
                            })
                        });


                    </script>
                </fieldset>
            </div>
        </form>

        <div class="widget widget-table action-table">
            <?php
            $isicoms = $package_functions->getOptions('DOWNLOAD_ICOMS', $system_package);
            if ($isicoms == 'Yes') {
                $customer_down_key_string = "uni_id_name=Unique Property ID&task=all_distributor_list_icoms&mno_id=" . $user_distributor;
            } else {
                $customer_down_key_string = "uni_id_name=Customer Account Number&task=all_distributor_list&mno_id=" . $user_distributor;
            }

            $customer_down_key = cryptoJsAesEncrypt($data_secret, $customer_down_key_string);
            $customer_down_key = urlencode($customer_down_key);
            ?>
            <a id="download_parent_list" href='ajax/export_customer.php?key=<?php echo $customer_down_key ?>' class="btn btn-primary" style="text-decoration:none">
                <i class="btn-icon-only icon-download"></i> Download Business ID List
            </a>
            <br/> <br/>
            <div class="widget-header">
                <!-- <i class="icon-th-list"></i> -->
                <h3>Active</h3>

            </div>

            <!-- /widget-header -->

            <?php 
            $is_support = true;
            if (!in_array('support', $access_modules_list)){
                $is_support = false;
            }
            ?>

            <div class="widget-content table_response">
                <div style="overflow-x:auto">
                    <div id="activeLocationsTable_img" class="paginate_img"><img src="img/loading_ajax.gif"></div>
                    <div class="perpage">
                        Per Page <select id="activeLocationsTablePerpage">
                            <option>50</option>
                            <option>100</option>
                            <option>150</option>
                            <option>200</option>
                            <select>
                    </div>
                    <table id="activeLocationsTable" class="table table-striped table-bordered tablesaw"
                           data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                        <thead>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">
                                <?php if (array_key_exists('icomms_number', $field_array) || array_key_exists('icomms_number_m', $field_array)) { ?>
                                    Business ID
                                <?php } elseif (array_key_exists('uui_number', $field_array)) { ?>
                                    UUI#
                                <?php } ?>
                            </th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Account Name</th>
                            <!-- th>Account Type</th> -->
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Properties</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Details</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                            <?php if(!$is_support){ ?>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>
                            <?php } ?>
                        </tr>

                        </thead>
                        <style type="text/css">
                            .paginate_img {
                                width: 100%;
                                bottom: 0;
                                text-align: center;
                                position: absolute;
                                background: #ffffff99;
                                display: none;
                                top: -40px;
                                z-index: 55555;
                            }

                            .cusPagination {
                                -webkit-box-pack: end;
                                -webkit-justify-content: flex-end;
                                -ms-flex-pack: end;
                                justify-content: flex-end;
                                display: -ms-flexbox;
                                display: flex;
                                margin-top: 20px;
                                padding-left: 0;
                                list-style: none;
                                border-radius: .25rem;
                            }

                            .cusPagination a {
                                min-width: 11px;
                                text-align: center;
                                text-decoration: none;
                                -webkit-transition: all .2s linear;
                                -o-transition: all .2s linear;
                                transition: all .2s linear;
                                -webkit-border-radius: 0px !important;
                                border-radius: 0px !important;
                                position: relative;
                                display: block;
                                padding: .5rem .75rem;
                                margin-left: -1px;
                                line-height: 20px;
                                border-width: 0px;
                            }

                            .cusPagination a:hover {
                                text-decoration: none;
                                background-color: #eee;
                            }

                            .cusPagination .disabled a {
                                color: #6c757d;
                                pointer-events: none;
                                cursor: auto;
                                border-color: #dee2e6;
                            }

                            .cusPagination .disabled {
                                pointer-events: none !important;
                            }

                            .cusPagination li {
                                border: 1px solid #dee2e6;
                                margin-left: -1px;
                            }

                            .cusPagination li.pre {
                                border-top-left-radius: 3px;
                                border-bottom-left-radius: 4px;
                                margin-left: 0px;
                            }

                            .cusPagination li.nxt {
                                border-top-right-radius: 3px;
                                border-bottom-right-radius: 4px;
                            }

                            .perpage {
                                position: absolute;
                                top: -37px;
                                right: 170px;
                                z-index: 2;
                            }

                            .perpage select {
                                margin-bottom: 0px
                            }
							
							@media (max-width:480px){
								.perpage {
									top: -55px;
								}

								.perpage select {
									width: 120px;
								}
							}
                        </style>
                        <tbody>

                        <script>

                            $(document).ready(function () {
                                $("#activeLocationsAccount").select2();
                            });

                            $(document).on("click", "#activeLocationsSearch", function () {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });

                            $(document).on("change", "#activeLocationsTablePerpage", function (e) {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });

                            $(document).on("change", "#activeLocationsAccount", function (e) {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });
                            $(document).on("click", "#activeLocationsTable_paginate .cusPagination li:not(.disabled) a", function (e) {
                                e.preventDefault();
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    nextPage: $(this).data('pagenum'),
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });
                            $(function () {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'locationActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>'
                                }
                                ajaxCall(request);
                            });

                            function ajaxCall(request) {
                                $('#activeLocationsTable_img').show();
                                var init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(request), '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString();

                                $.post("ajax/locationAjax.php", {key: init_auth_data},
                                    function (data, textStatus, jqXHR) {
                                        var data_ar = JSON.parse(JSON.parse(CryptoJS.AES.decrypt(data, '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8)));
                                        setTable(data_ar);
                                        $('#activeLocationsTable_img').hide();
                                    }
                                );
                            }

                            function setTable(data) {

                                var table = data.table;
                                var paginate = data.paginate;

                                $('#activeLocationsTable tbody').html('');
                                if (table.length == 0) {
                                    $('#activeLocationsTable tbody').append("<tr><td colspan=100><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong><?php echo $message_functions->showMessage('no_results'); ?></strong></div></td></tr>");
                                } else {
                                    for (let index = 0; index < table.length; index++) {
                                        var tr = "";
                                        const element = table[index];
                                        <?php if($is_support){ ?>
                                        tr = tr + "<tr><td>" + element[0] + "</td><td class='tablesaw-priority-2'>" + element[1] + "</td><td class='tablesaw-priority-3'>" + element[2] + "</td><td class='tablesaw-priority-4'><a id='VIEWACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-info-sign'></i>&nbsp;View</a></td><td><a id='EDITACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-wrench'></i>&nbsp;Edit</a></td></tr>";
                                        <?php }else{ ?>
                                            tr = tr + "<tr><td>" + element[0] + "</td><td class='tablesaw-priority-2'>" + element[1] + "</td><td class='tablesaw-priority-3'>" + element[2] + "</td><td class='tablesaw-priority-4'><a id='VIEWACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-info-sign'></i>&nbsp;View</a></td><td><a id='EDITACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-wrench'></i>&nbsp;Edit</a></td><td class='tablesaw-priority-5'><a id='REMOVEACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-trash'></i>&nbsp;Remove</a></td></tr>";
                                        <?php } ?>
                                        $('#activeLocationsTable tbody').append(tr);

                                        $('#VIEWACC_' + element[3]).click(function () {
                                            window.location = "?token8=<?php echo $secret; ?>&t=active_properties&view_loc_code=" + element[0] + "&view_loc_name=" + element[4];
                                        });

                                        $('#EDITACC_' + element[3]).easyconfirm({
                                            locale: {
                                                title: 'Account Edit',
                                                text: 'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                button: ['Cancel', ' Confirm'],
                                                closeText: 'close'
                                            }
                                        });
                                        $('#EDITACC_' + element[3]).click(function () {
                                            window.location = "?token7=<?php echo $secret; ?>&t=edit_parent&edit_parent_id=" + element[0];
                                        });

                                        <?php if(!$is_support){ ?>

                                        $('#REMOVEACC_' + element[3]).easyconfirm({
                                            locale: {
                                                title: 'Account Remove',
                                                text: 'Are you sure you want to remove[ ' + element[0] + ' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                button: ['Cancel', ' Confirm'],
                                                closeText: 'close'
                                            }
                                        });
                                        $('#REMOVEACC_' + element[3]).click(function () {
                                            window.location = "?token5=<?php echo $secret; ?>&t=active_properties&remove_par_code=" + element[0] + "&remove_par_id=" + element[3] + "";
                                        });
                                        <?php } ?>
                                    }
                                }

                                $('#activeLocationsTable_paginate').html(paginate);
                                new Tablesaw.Table("#activeLocationsTable").destroy();
                                Tablesaw.init();
                                $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;'></label>");
                            }
                        </script>

                        <?php

                        if ($user_group == 'operation') {
                            $check_column = "d.mno_id";
                        } else {
                            $check_column = "d.distributor_code";

                        }

                        ?>

                        </tbody>

                    </table>
                    <div id="activeLocationsTable_paginate"></div>
                </div>
            </div>
            <?php } //v1 ?>


            <!-- /widget-content -->

        </div>

        <!-- /widget -->
    </div>

