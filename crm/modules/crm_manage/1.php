<div <?php if (isset($tab_crm_manage)) { ?>class="tab-pane fade in active" <?php } else { ?> class="tab-pane fade" <?php } ?> id="crm_manage">

<?php

if (isset($_SESSION['msg_crm_manage'])) {
    echo $_SESSION['msg_crm_manage'];
    unset($_SESSION['msg_crm_manage']);

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
                                $fullCountQuery = "SELECT business_name FROM exp_crm WHERE mno_id='$user_distributor' ";
                                $queryResult = $db->selectDB($fullCountQuery);
                                if ($queryResult['rowCount'] > 0) {
                                    foreach ($queryResult['data'] AS $row) {
                                        echo "<option class='selectors' value='" . $row['business_name'] . "'>" . $row['business_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" style="display: none;">
                        <label class="control-label" for="radiobtns">Search on Business ID </label>
                        <div class="controls col-lg-5 form-group">
                            <input autocomplete="off" type="text" id="activeLocationsBusId" name="activeLocationsBusId"
                                   class="span4 form-control">

                        </div>
                    </div>
                    <div class="form-actions">
                        <button name="activeLocationsSearch" id="activeLocationsSearch" type="button"
                                class="btn btn-info" style="text-decoration:none"> Search or Refresh
                        </button>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#activeLocationsBusId').keydown(function (e) {

                                if (e.keyCode == 13) {
                                    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
                                    var request = {
                                        listsize: $('#activeLocationsTablePerpage').val(),
                                        type: 'crmActiveAccounts',
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
            // $isicoms = $package_functions->getOptions('DOWNLOAD_ICOMS', $system_package);
            // if ($isicoms == 'Yes') {
            //     $customer_down_key_string = "uni_id_name=Unique Property ID&task=all_distributor_list_icoms&mno_id=" . $user_distributor;
            // } else {
            //     $customer_down_key_string = "uni_id_name=Customer Account Number&task=all_distributor_list&mno_id=" . $user_distributor;
            // }

            // $customer_down_key = cryptoJsAesEncrypt($data_secret, $customer_down_key_string);
            // $customer_down_key = urlencode($customer_down_key);
            ?>
            <!-- <a id="download_parent_list" href='ajax/export_customer.php?key=<?php echo $customer_down_key ?>' class="btn btn-primary" style="text-decoration:none">
                <i class="btn-icon-only icon-download"></i> Download Business ID List
            </a> -->
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
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Property ID</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Business Name</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">status</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>                           
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
                                    type: 'crmActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });

                            $(document).on("change", "#activeLocationsTablePerpage", function (e) {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'crmActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>',
                                    busId: $('#activeLocationsBusId').val(),
                                    accName: $('#activeLocationsAccount').val()
                                }
                                ajaxCall(request);
                            });

                            $(document).on("change", "#activeLocationsAccount", function (e) {
                                var request = {
                                    listsize: $('#activeLocationsTablePerpage').val(),
                                    type: 'crmActiveAccounts',
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
                                    type: 'crmActiveAccounts',
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
                                    type: 'crmActiveAccounts',
                                    user_distributor: '<?php echo $user_distributor; ?>'
                                }
                                ajaxCall(request);
                            });

                            function ajaxCall(request) {
                                $('#activeLocationsTable_img').show();
                                var init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(request), '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString();

                                $.post("ajax/provision/manage.php", {key: init_auth_data},
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
                                        
                                        tr = tr + "<tr><td>" + element[0] + "</td><td class='tablesaw-priority-2'>" + element[1] + "</td><td class='tablesaw-priority-3'>" + element[2] + "</td><td><a id='VIEWACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-wrench'></i>&nbsp;View</a></td><td class='tablesaw-priority-5'><a id='REMOVEACC_" + element[3] + "'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-trash'></i>&nbsp;Remove</a></td></tr>";
                                        
                                        $('#activeLocationsTable tbody').append(tr);

                                        // $('#EDITACC_' + element[3]).easyconfirm({
                                        //     locale: {
                                        //         title: 'Account Edit',
                                        //         text: 'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                        //         button: ['Cancel', ' Confirm'],
                                        //         closeText: 'close'
                                        //     }
                                        // });
                                        // $('#EDITACC_' + element[3]).click(function () {
                                        //     window.location = "?t=crm_create&token=<?php echo $secret; ?>&edit&id=" + element[3];
                                        // });

                                        $('#VIEWACC_' + element[3]).easyconfirm({
                                            locale: {
                                                title: 'Account View',
                                                text: 'Are you sure you want to view this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                button: ['Cancel', ' Confirm'],
                                                closeText: 'close'
                                            }
                                        });
                                        $('#VIEWACC_' + element[3]).click(function () {
                                            window.location = "?t=crm_create&token=<?php echo $secret; ?>&edit&id=" + element[3];
                                        });

                                        $('#REMOVEACC_' + element[3]).easyconfirm({
                                            locale: {
                                                title: 'Account Remove',
                                                text: 'Are you sure you want to remove[ ' + element[0] + ' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                button: ['Cancel', ' Confirm'],
                                                closeText: 'close'
                                            }
                                        });
                                        $('#REMOVEACC_' + element[3]).click(function () {
                                            window.location = "?token=<?php echo $secret; ?>&remove_id=" + element[3];
                                        });
                                    }
                                }

                                $('#activeLocationsTable_paginate').html(paginate);
                                new Tablesaw.Table("#activeLocationsTable").destroy();
                                Tablesaw.init();
                                $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;'></label>");
                            }

                            function editAccount(id){
                                var request = {
                                    id: id
                                }
                                $('#activeLocationsTable_img').show();
                                var init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(request), '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString();

                                $.post("ajax/provision/manage.php?view=true", {key: init_auth_data},
                                    function (data, textStatus, jqXHR) {
                                        
                                        var data_ar = JSON.parse(JSON.parse(CryptoJS.AES.decrypt(data, '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8)));
                                        console.log(data_ar);
                                        $('#activeLocationsTable_img').hide();
                                    }
                                );
                            }
                        </script>

                        <?php

                        if ($user_type == 'MNO' || $user_type == 'SALES') {

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

            <!-- /widget-content -->

        </div>
</div>