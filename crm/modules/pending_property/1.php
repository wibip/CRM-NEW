<div <?php if(isset($tab_pending_property)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="pending_property">

    <div class="support_head_visible" style="display:none;"><div class="header_hr"></div><div class="header_f1" style="width: 100%;">
            Pending Account Activation</div>
        <br class="hide-sm"><br class="hide-sm"><div class="header_f2" style="width: 100%;"> </div></div>



    <p>To send an automatic email invitation to the SMB Manager, click on "Email" Button.<br/>
        This email contains the SMB account activation information.</p><br/>

    <form class="form-horizontal ">
        <div class="form-group">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="radiobtns">Select Account Name </label>
                    <div class="controls col-lg-5 form-group">
                        <select  name="pendingLocationsAccount" id="pendingLocationsAccount"  class="span4 form-control" >
                            <option value="">Select Account Name</option>
                            <?php
                            $queryString = "SELECT p.account_name FROM exp_mno m JOIN mno_distributor_parent p ON m.mno_id = p.mno_id LEFT JOIN exp_mno_distributor d ON p.parent_id = d.parent_id LEFT JOIN admin_users u ON p.parent_id = u.verification_number 
                WHERE m.mno_id='$user_distributor' AND u.is_enable ='2' GROUP BY p.parent_id";
                            $queryResult = $db->selectDB($queryString);
                            if ($queryResult['rowCount']>0) {
                                foreach($queryResult['data'] AS $row){
                                    $account_name=$row['account_name'];
                                    echo "<option class='selectors' value='".$account_name."'>".$account_name."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="radiobtns">Search on Business ID </label>
                    <div class="controls col-lg-5 form-group">
                        <input autocomplete="off" type="text" id="pendingLocationsBusId" name="pendingLocationsBusId" class="span4 form-control">
                    </div>
                </div>
                <div class="form-actions">
                    <button name="pendingLocationsSearch" id="pendingLocationsSearch" type="button" class="btn btn-info" style="text-decoration:none"> Search </button>
                </div>
            </fieldset>
        </div>
        <script type="text/javascript">
                        $(document).ready(function () {
                            $('#pendingLocationsBusId').keydown(function (e) {

                                if (e.keyCode == 13) {
                                    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
                                    var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',busId: $('#pendingLocationsBusId').val(),accName: $('#pendingLocationsAccount').val()}
                            ajaxCall1(request);
                                }
                            })
                        });

                        

                    </script>
    </form>


    <div id="response_d1">

    </div>


    <div class="widget widget-table action-table">


        <?php

        if($package_functions->getOptions('PENDING_PROPERTY_DOWNLOAD',$system_package)=='ACTIVE'){

            $isicoms=$package_functions->getOptions('DOWNLOAD_ICOMS',$system_package);
            if ($isicoms=='Yes') {
                $customer_down_key_string_pending = "uni_id_name=Unique Property ID&task=all_distributor_pending_list_icoms&mno_id=".$user_distributor;
            }
            else{
                $customer_down_key_string_pending = "uni_id_name=Customer Account Number&task=all_distributor_pending_list&mno_id=".$user_distributor;
            }

            $customer_down_key_pending =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string_pending);
            $customer_down_key_pending =  urlencode($customer_down_key_pending);
            ?>
            <a href='ajax/export_customer.php?key=<?php echo $customer_down_key_pending?>' class="btn btn-primary" style="text-decoration:none">
                <i class="btn-icon-only icon-download"></i> Download Pending Business ID List
            </a>
            <br/> <br/>
        <?php } ?>
        <div class="widget-header">

            <!--  <i class="icon-th-list"></i> -->

            <h3>Dormant</h3>

            <img id="location_loader_1" src="img/loading_ajax.gif" style="visibility: hidden;">

        </div>

        <?php 
            $is_support = true;
            if (!in_array('support', $access_modules_list)){
                $is_support = false;
            }
            ?>

        <!-- /widget-header -->

        <div class="widget-content table_response" id="location_div">
            <div style="overflow-x:auto">
                <div id="pendingLocationsTable_img" class="paginate_img"><img  src="img/loading_ajax.gif"></div>
                <div class="perpage">
                    Per Page <select id="pendingLocationsTablePerpage">
                        <option>50</option>
                        <option>100</option>
                        <option>150</option>
                        <option>200</option>
                        <select>
                </div>
                <table id="pendingLocationsTable" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                    <script>

                        $(document).ready(function () {
                            $("#pendingLocationsAccount").select2();
                        });

                        $(document).on("click", "#pendingLocationsSearch", function(){
                            var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',busId: $('#pendingLocationsBusId').val(),accName: $('#pendingLocationsAccount').val()}
                            ajaxCall1(request);
                        });

                        

                        $(document).on("change","#pendingLocationsTablePerpage",function (e) {
                            var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',busId: $('#pendingLocationsBusId').val(),accName: $('#pendingLocationsAccount').val()}
                            ajaxCall1(request);
                        });

                        $(document).on("change","#pendingLocationsAccount",function (e) {
                            var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',busId: $('#pendingLocationsBusId').val(),accName: $('#pendingLocationsAccount').val()}
                            ajaxCall1(request);
                        });
                        $(document).on("click", "#pendingLocationsTable_paginate .cusPagination li:not(.disabled) a", function(e){
                            e.preventDefault();
                            var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',nextPage: $(this).data('pagenum'),busId: $('#pendingLocationsBusId').val(),accName: $('#pendingLocationsAccount').val()}
                            ajaxCall1(request);
                        });
                        $(function () {
                            var request = {listsize: $('#pendingLocationsTablePerpage').val(),type:'locationPendingAccounts',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>'}
                            ajaxCall1(request);
                        });

                        function ajaxCall1(request){
                            var init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(request), '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString();
                            $('#pendingLocationsTable_img').show();
                            $.post("ajax/locationAjax.php", {key: init_auth_data},
                                function (data, textStatus, jqXHR) {
                                    var data_ar = JSON.parse(JSON.parse(CryptoJS.AES.decrypt(data, '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8)));
                                    setTable1(data_ar);
                                    $('#pendingLocationsTable_img').hide();
                                }
                            );
                        }

                        function setTable1(data){

                            var table = data.table;
                            var paginate = data.paginate;
                            $('#pendingLocationsTable tbody').html('');

                            if(table.length==0){
                                $('#pendingLocationsTable tbody').append("<tr><td colspan=100><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong><?php echo $message_functions->showMessage('no_results'); ?></strong></div></td></tr>");
                            }else{

                                for (let index = 0; index < table.length; index++) {
                                    const element = table[index];
                                    var tr = "";
                                    tr = tr+"<tr><td>"+element[0]+"</td><td>"+element[1]+"</td><td>"+element[2]+"</td><td>"+element[3]+"</td>";

                                    if(element[4]!='NULL'){
                                        tr = tr+"<td>"+element[4]+"</td>";
                                    }
                                    <?php if($is_support){ ?>
                                    tr = tr+"</td><td><a id='EDITACC1_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-wrench'></i>&nbsp;Edit</a></td><td><a id='SEMAIL_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-envelope'></i>&nbsp;Email</a></td>";
                                    <?php }else{ ?>
                                        tr = tr+"</td><td><a id='DISTRI_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-trash'></i>&nbsp;Remove</a></td><td><a id='EDITACC1_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-wrench'></i>&nbsp;Edit</a></td><td><a id='SEMAIL_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-envelope'></i>&nbsp;Email</a></td>";
                                    
                                        <?php } ?>
                                    if(element[5]!='NULL'){
                                        tr = tr+"<td><a id='REMAIL_"+element[6]+"'  class='btn btn-small btn-primary'><i class='btn-icon-only icon-envelope'></i>&nbsp;Remind</a></td>";
                                    }
                                    tr = tr+"</tr>";
                                    $('#pendingLocationsTable tbody').append(tr);

                                    <?php if(!$is_support){ ?>

                                    $('#DISTRI_'+element[6]).easyconfirm({locale: {
                                            title: 'Account Remove',
                                            text: 'Are you sure you want to remove[ '+element[0]+' ] account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                            button: ['Cancel',' Confirm'],
                                            closeText: 'close'
                                        }});

                                    $('#DISTRI_'+element[6]).click(function() {
                                        window.location = "?token5=<?php echo $secret; ?>&t=pending_property&remove_par_code="+element[0]+"&remove_par_id="+element[6];
                                    });

                                    <?php } ?>

                                    $('#EDITACC1_'+element[6]).easyconfirm({locale: {
                                            title: 'Account Edit',
                                            text: 'Are you sure you want to edit this Account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                            button: ['Cancel',' Confirm'],
                                            closeText: 'close'
                                        }});
                                    $('#EDITACC1_'+element[6]).click(function() {
                                        window.location = "?token7=<?php echo $secret; ?>&t=edit_parent&edit_parent_id="+element[0];
                                    });

                                    $('#SEMAIL_'+element[6]).easyconfirm({locale: {
                                            title: 'Send Email',
                                            text: 'Are you sure you want to send an email invitation?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                            button: ['Cancel',' Confirm'],
                                            closeText: 'close'
                                        }});
                                    $('#SEMAIL_'+element[6]).click(function() {
                                        window.location = "?form_secret5=<?php echo $secret; ?>&t=pending_property&distributor_code="+element[0]+"&resendMail=set";
                                    });

                                    if(element[5]!='NULL'){

                                        $('#REMAIL_'+element[6]).easyconfirm({locale: {
                                                title: 'Send Email',
                                                text: 'Are you sure you want to send an email remind?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                button: ['Cancel',' Confirm'],
                                                closeText: 'close'
                                            }});
                                        $('#REMAIL_'+element[6]).click(function() {
                                            window.location = "?form_secret5=<?php echo $secret; ?>&t=pending_property&distributor_code="+element[0]+"&remindMail=set";
                                        });

                                    }
                                }
                            }

                            $('#pendingLocationsTable_paginate').html(paginate);
                            new Tablesaw.Table("#pendingLocationsTable").destroy();
                            Tablesaw.init();
                            $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox,[data-toggle^=toggle])").after('<label style="display: inline-block; margin-top: 10px;"></label>');
                        }
                    </script>

                    <thead>

                    <tr>
                        <?php
                        $pending_tbl_column = json_decode($package_functions->getOptions('PENDING_PARENT_TBL_COLUMN',$system_package),true);

                        echo '<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Business Account Name</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">PROPERTIES</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Creation Date</th>';
                        if(array_key_exists('hardware_installed',$pending_tbl_column)) {
                            echo '<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">'.
                                $pending_tbl_column['hardware_installed']['title']
                                .'</th>';
                        }
                        if(!$is_support){
                        echo'<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove</th>';
                        }
                                                                    echo '<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Edit</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Send</th>';
                        if($package_functions->getOptions('PENDING_PROPERTY_MAIL',$system_package)=='ACTIVE'){
                            echo'<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Send</th>';
                        }
                        ?>
                    </tr>

                    </thead>

                    <tbody>

                    </tbody>
                </table>
                <div id="pendingLocationsTable_paginate"></div>
            </div>
        </div>
    </div>


</div>