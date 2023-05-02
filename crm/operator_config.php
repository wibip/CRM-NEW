<?php
include 'header_new.php';
$page = "Operator Config";

require_once 'classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();

$operators = $OperatorClass->getOperators();
$propertyConfigs = $adminConfig->getPropertyConfigs(); 
// var_dump($propertyConfigs);
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-content">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operator Config</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Operator Config</h1>
                                        <br/>
                                        <h5 class="head">QoS Profile</h5>
                                        <table class="table table-striped" style="width:100%" id="qos-table" data-modal-target="#qosprofile" data-modal-btn-txt="Add QoS Profile">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>Qos Profile</th>
                                                    <th>Qos Profile ID</th>
                                                    <th>vSZ Mapping</th>
                                                    <th>WAG Magic</th>
                                                    <th>Product Name</th>
                                                    <th>Group</th>
                                                    <th>Account Template</th>
                                                    <th>Service Profiles</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($propertyConfigs['QOSP'] as $QOSProfile) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$QOSProfile['operator_code']?></td>
                                                        <td><?=$QOSProfile['qos_profile']?></td>
                                                        <td><?=$QOSProfile['qos_profile_id']?></td>
                                                        <td><?=$QOSProfile['vsz_mapping']?></td>
                                                        <td><?=$QOSProfile['wag_magic']?></td>
                                                        <td><?=$QOSProfile['product_name']?></td>
                                                        <td><?=$QOSProfile['group']?></td>
                                                        <td><?=$QOSProfile['account_template']?></td>
                                                        <td><?=$QOSProfile['service_profile']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">BusinessID Scope</h5>
                                        <table class="table table-striped" style="width:100%" id="bid-scope-table" data-modal-target="#business_id_scope" data-modal-btn-txt="Add BusinessID Scope">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Service Type</th>
                                                    <th>Business Type</th>
                                                    <th>BusinessID Prefix</th>
                                                    <th>BusinessID From</th>
                                                    <th>BusinessID To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($propertyConfigs['BIDS'] as $BIDScope) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$BIDScope['operator_code']?></td>
                                                        <td><?=$BIDScope['sub_operator_code']?></td>
                                                        <td><?=$BIDScope['service_type']?></td>
                                                        <td><?=$BIDScope['business_type']?></td>
                                                        <td><?=$BIDScope['business_prefix']?></td>
                                                        <td><?=$BIDScope['business_id_from']?></td>
                                                        <td><?=$BIDScope['business_id_to']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">ServiceType Map</h5>
                                        <table class="table table-striped" style="width:100%" id="service-type-table" data-modal-target="#service_typemap" data-modal-btn-txt="Add ServiceType Map">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Service Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($propertyConfigs['STM'] as $STMap) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$STMap['operator_code']?></td>
                                                        <td><?=$STMap['sub_operator_code']?></td>
                                                        <td><?=$STMap['service_type']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->
                </div>
                <!-- /span8 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->

<!-- The Modal qosProfile-->
<div class="modal" id="qosprofile">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create QoS Profile</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="qos_profile" name="qos_profile"  method="post">                        
                        <input type="hidden" id="modal_name_qp" name="modal_name_qp" value="qosprofile" />
                        <input type="hidden" id="property_type" name="property_type" value="QOSP" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="operator_code" name="operator_code" class="form-select" required>
                                <option value="">Select Operator Code</option>
                                <?php 
                                    if($operators['rowCount'] > 0) {
                                        foreach($operators['data'] as $operator) {
                                ?>
                                        <option value="<?=$operator['operator_code']?>"><?=$operator['operator_code']?></option>
                                <?php

                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Qos Profile</label>
                            <select id="qos_profile" name="qos_profile" class="form-select">
                                <option value="">Select Qos Profile</option>
                                <option value="28K">28K</option>
                                <option value="10X10M">10X10M</option>
                                <option value="150x150M">150x150M</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Qos Profile ID</label>
                            <input type="text" id="qos_profile_id" name="qos_profile_id" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">vSZ Mapping</label>
                            <input type="text" id="vsz_mapping" name="vsz_mapping" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">WAG Magic</label>
                            <input type="text" id="wag_magic" name="wag_magic" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Product Name</label>
                            <input type="text" id="product_name" name="product_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Group</label>
                            <select id="group" name="group"  class="form-select">
                                <option value="">None</option>
                                <option value="Att">Att</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Account Template</label>
                            <select id="account_template" name="account_template"  class="form-select">
                                <option value="">None</option>
                                <option value="East">att-account-template</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Profile</label>
                            <select id="service_profile" name="service_profile"  class="form-select">
                                <option value="">None</option>
                                <option value="QoS-Profile-128K">QoS-Profile-128K</option>
                                <option value="QoS-Profile-10x10">QoS-Profile-10x10</option>
                                <option value="QoS-Profile-100x100">QoS-Profile-100x100</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal business ID Scope-->
<div class="modal" id="business_id_scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create BusinessID Scope</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4"  id="business_scope" name="business_scope"  method="post">                        
                        <input type="hidden" id="modal_name_bs" name="modal_name_bs" value="business_id_scope" />
                        <input type="hidden" id="property_type" name="property_type" value="BIDS" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="operator_code" name="operator_code" class="form-select" required>
                                <option value="">Select Operator Code</option>
                                <?php 
                                    if($operators['rowCount'] > 0) {
                                        foreach($operators['data'] as $operator) {
                                ?>
                                        <option value="<?=$operator['operator_code']?>"><?=$operator['operator_code']?></option>
                                <?php

                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Type</label>
                            <select id="service_type" name="service_type" class="form-select">
                                <option value="">Select Service Type</option>
                                <option value="ENT-SMB-NON-AP-MERAKI">ENT-SMB-NON-AP-MERAKI</option>
                                <option value="ENT-SMB-NON-AP-MERAK">ENT-SMB-NON-AP-MERAKI</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Business Type</label>
                            <input type="text" id="business_type" name="business_type" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Business Prefix</label>
                            <input type="text" id="business_prefix" name="business_prefix" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">BusinessID From</label>
                            <input type="text" id="business_id_from" name="business_id_from" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">BusinessID To</label>
                            <input type="text" id="business_id_to" name="business_id_to" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal business ID Scope-->
<div class="modal" id="service_typemap">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create ServiceType Map</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="service_type_map" name="service_type_map"  method="post">
                        <input type="hidden" id="modal_name_stp" name="modal_name_stp" value="service_typemap" />
                        <input type="hidden" id="property_type" name="property_type" value="STM" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="operator_code" name="operator_code" class="form-select" required>
                                <option value="">Select Operator Code</option>
                                <?php 
                                    if($operators['rowCount'] > 0) {
                                        foreach($operators['data'] as $operator) {
                                ?>
                                        <option value="<?=$operator['operator_code']?>"><?=$operator['operator_code']?></option>
                                <?php

                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Type</label>
                            <select id="service_type" name="service_type" class="form-select">
                                <option value="">Select Service Type</option>
                                <option value="ENT-SMB-NON-AP-MERAKI">ENT-SMB-NON-AP-MERAKI</option>
                                <option value="ENT-SMB-NON-AP-ERTI">ENT-SMB-NON-AP-ERTI</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="scope_alert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="alert_close" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#qos-table').dataTable();
        $('#bid-scope-table').dataTable();
        $('#service-type-table').dataTable();

        $("#qos_profile").submit(function(event){
            var modal_name = $('input[name=modal_name_qp]').val();
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('qos_profile');
            return false;
        });
        $("#business_scope").submit(function(event){
            var modal_name = $('input[name=modal_name_bs]').val();
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('business_scope');
            return false;
        });
        $("#service_type_map").submit(function(event){
            var modal_name = $('input[name=modal_name_stp]').val();
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('service_type_map');
            return false;
        });

        $("#alert_close").click(function() {
            location.reload(true);
        });
    });

    function saveScope(formId) {
        $.ajax({	
            type: "POST",
            url: "ajax/save_property_config.php",
            data:  $('form#'+formId+'').serialize(),
            success: function(responseData) {
                responseData = JSON.parse(responseData);
                // console.log(responseData);
                var title = '';
                var html = '';
                if(responseData == true) {
                    $('#scope_name').text('Data Has been saved');
                    title = '<b>Success</b>';
                    html = "<p>Scope data has been saved</p>";
                } else {
                    $('#scope_name').text('Error on data save');
                    title = '<b>Error !</b>';
                    html = "<p>Error on Scope data save</p>";
                }

                $("#scope_alert .modal-title" ).html(title);
                $('#scope_alert .modal-body').empty('').html(html);
                $('#scope_alert').modal('show');
                $("#overlay").css("display","none");
            },
            error: function() {
                $("#overlay").css("display","none");
            }
        });
    }
</script>