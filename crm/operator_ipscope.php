<?php
include 'header_new.php';
$page = "Operator IP Scope";
require_once 'classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();

$operators = $OperatorClass->getOperators();
$scopes = $adminConfig->getScopes(); 

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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operator IP Scope</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                     
                                    <h1 class="head">Operator IP Scope</h1>
                                        <br/>
                                        <h5 class="head">Operator Management IP Scope</h5>
                                        <table class="table table-striped" style="width:100%" id="oip-table" data-modal-target="#opt_mgt_ip_scope" data-modal-btn-txt="Add Management IP Scope">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Region</th>
                                                    <th>IP Range: From</th>
                                                    <th>IP Range: To</th>
                                                    <th>Netmask</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($scopes['MIPS'] as $scopeMIPS) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$scopeMIPS['operator_code']?></td>
                                                        <td><?=$scopeMIPS['sub_operator_code']?></td>
                                                        <td><?=$scopeMIPS['region']?></td>
                                                        <td><?=$scopeMIPS['range_from']?></td>
                                                        <td><?=$scopeMIPS['range_to']?></td>
                                                        <td><?=$scopeMIPS['netmask']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope</h5>
                                        <table class="table table-striped" style="width:100%" id="pip-table" data-modal-target="#property_ip_scope" data-modal-btn-txt="Add Property IP Scope">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Property</th>
                                                    <th>Customer Peer ID</th>
                                                    <th>IP Network</th>
                                                    <th>Netmask</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($scopes['PIPS'] as $scopePIPS) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$scopePIPS['operator_code']?></td>
                                                        <td><?=$scopePIPS['sub_operator_code']?></td>
                                                        <td><?=$scopePIPS['property_name']?></td>
                                                        <td><?=$scopePIPS['peer_id']?></td>
                                                        <td><?=$scopePIPS['ip_network']?></td>
                                                        <td><?=$scopePIPS['netmask']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope :: Public</h5>
                                        <table class="table table-striped" style="width:100%" id="pips-public-table"  data-modal-target="#public_property_ip_scope" data-modal-btn-txt="Add Public Property IP Scope">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Property Name</th>
                                                    <th>Customer Peer ID</th>
                                                    <th>Firewall Public Net</th>
                                                    <th>Firewall Public IP</th>
                                                    <th>Firewall VLAN50 IP</th>
                                                    <th>Firewall Serial No</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($scopes['PUBPIPS'] as $scopePUBPIPS) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$scopePUBPIPS['operator_code']?></td>
                                                        <td><?=$scopePUBPIPS['sub_operator_code']?></td>
                                                        <td><?=$scopePUBPIPS['property_name']?></td>
                                                        <td><?=$scopePUBPIPS['peer_id']?></td>
                                                        <td><?=$scopePUBPIPS['firewall_public_net']?></td>
                                                        <td><?=$scopePUBPIPS['firewall_public_ip']?></td>
                                                        <td><?=$scopePUBPIPS['firewall_vlan50_ip']?></td>
                                                        <td><?=$scopePUBPIPS['firewall_serial_no']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope :: Private</h5>
                                        <table class="table table-striped" style="width:100%" id="pips-private-table"   data-modal-target="#private_property_ip_scope" data-modal-btn-txt="Add Private Property IP Scope">
                                        <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Property Name</th>
                                                    <th>Customer Peer ID</th>
                                                    <th>VLAN Static IP</th>
                                                    <th>Underlay Net</th>
                                                    <th>VLAN DHCP AP IP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($scopes['PVTPIPS'] as $scopePVTPIPS) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$scopePVTPIPS['operator_code']?></td>
                                                        <td><?=$scopePVTPIPS['sub_operator_code']?></td>
                                                        <td><?=$scopePVTPIPS['property_name']?></td>
                                                        <td><?=$scopePVTPIPS['peer_id']?></td>
                                                        <td><?=$scopePVTPIPS['vlan_static_ip']?></td>
                                                        <td><?=$scopePVTPIPS['underlay_net']?></td>
                                                        <td><?=$scopePVTPIPS['vlan_dhcp_ap_ip']?></td>
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

<!-- The Modal opt_mgt_ip_scope-->
<div class="modal" id="opt_mgt_ip_scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Operator Management IP Scope</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="operator_mip_scope" name="operator_mip_scope" method="post">
                        <input type="hidden" id="modal_name_mip" name="modal_name_mip" value="opt_mgt_ip_scope" />
                        <input type="hidden" id="scope_type" name="scope_type" value="MIPS" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="operator_code" class="form-label">Operator Code</label>
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
                            <label for="sub_operator_code" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="range_from" class="form-label">IP Range: From</label>
                            <input type="text" id="range_from" name="range_from" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP Range: To</label>
                            <input type="text" id="range_to" name="range_to" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="region" class="form-label">Region</label>
                            <select id="region" name="region" class="form-select">
                                <option value="">Select Region</option>
                                <option value="Central">Central</option>
                                <option value="East">East</option>
                                <option value="Midwest">Midwest</option>
                                <option value="West">West</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="netmask" class="form-label">Netmask</label>
                            <input type="text" id="netmask" name="netmask" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="omip_scope_save" name="omip_scope_save">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal property_ip_scope-->
<div class="modal" id="property_ip_scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Property IP Scope</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="operator_pip_scope" name="operator_pip_scope"  method="post">
                        <input type="hidden" id="modal_name_pip" name="modal_name_pip" value="property_ip_scope" />
                        <input type="hidden" id="scope_type" name="scope_type" value="PIPS" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="operator_code" class="form-label">Operator Code</label>
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
                            <label for="sub_operator_code" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" ame="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>                        
                        <div class="col-md-6">
                            <label for="property_name" class="form-label">Property</label>
                            <select id="property_name" name="property_name" class="form-select">
                                <option value="">None</option>
                                <option value="Full Gospel">Full Gospel</option>
                                <option value="Creekside">Creekside</option>
                                <option value="MPM Bio Impact">MPM Bio Impact</option>
                                <option value="Rio Del Sol Needles">Rio Del Sol Needles</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="peer_id" class="form-label">Customer Peer ID</label>
                            <input type="text" id="peer_id" name="peer_id" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP Network</label>
                            <input type="text" id="ip_network" name="ip_network" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Netmask</label>
                            <input type="text" id="netmask" name="netmask" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="pip_scope_save" name="pip_scope_save">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal public_property_ip_scope-->
<div class="modal" id="public_property_ip_scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Public Property IP Scope</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="operator_pubpip_scope" name="operator_pubpip_scope"  method="post">
                        <input type="hidden" id="modal_name_pubpip" name="modal_name_pubpip" value="public_property_ip_scope" />
                        <input type="hidden" id="scope_type" name="scope_type" value="PUBPIPS" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="operator_code" class="form-label">Operator Code</label>
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
                            <label for="sub_operator_code" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>      
                        <div class="col-md-6">
                            <label for="property_name" class="form-label">Property Name</label>
                            <input type="text" id="property_name" name="property_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="peer_id" class="form-label">Customer Peer ID</label>
                            <input type="text" id="peer_id" name="peer_id" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="firewall_public_net" class="form-label">Firewall Public Net</label>
                            <input type="text" id="firewall_public_net" name="firewall_public_net" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="firewall_public_ip" class="form-label">Firewall Public IP</label>
                            <input type="text" id="firewall_public_ip" name="firewall_public_ip" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="firewall_vlan50_ip" class="form-label">Firewall VLAN50 Net</label>
                            <input type="text" id="firewall_vlan50_ip" name="firewall_vlan50_ip" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="firewall_serial_no" class="form-label">Firewall Serial No</label>
                            <input type="text" id="firewall_serial_no" name="firewall_serial_no" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="pubpip_scope_save" name="pubpip_scope_save">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal private_property_ip_scope-->
<div class="modal" id="private_property_ip_scope">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Private Property IP Scope</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="operator_pvtpip_scope" name="operator_pvtpip_scope"  method="post">
                        <input type="hidden" id="modal_name_pvtpip" name="modal_name_pvtpip" value="private_property_ip_scope" />
                        <input type="hidden" id="scope_type" name="scope_type" value="PVTPIPS" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="operator_code" class="form-label">Operator Code</label>
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
                            <label for="sub_operator_code" class="form-label">Sub Operator Code</label>
                            <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                <option value="">None</option>
                                <option value="SDL">SDL</option>
                            </select>
                        </div>      
                        <div class="col-md-6">
                            <label for="property_name" class="form-label">Property Name</label>
                            <input type="text" id="property_name" name="property_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Customer Peer ID</label>
                            <input type="text" id="property_name" name="property_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="vlan_static_ip" class="form-label">VLAN Static IP</label>
                            <input type="text" id="vlan_static_ip" name="vlan_static_ip" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="underlay_net" class="form-label">Underlay Net</label>
                            <input type="text" id="underlay_net" name="underlay_net" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="vlan_dhcp_ap_ip" class="form-label">VLAN DHCP AP IP</label>
                            <input type="text" id="vlan_dhcp_ap_ip" name="vlan_dhcp_ap_ip" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="pvtpip_scope_save" name="pvtpip_scope_save">Submit</button>
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
        $('#display_message').hide();
        $('#oip-table').dataTable();
        $('#pip-table').dataTable();
        $('#pips-public-table').dataTable();
        $('#pips-private-table').dataTable();

        $("#operator_mip_scope").submit(function(event){
            // var modal_name = $('#modal_name').val();
            var modal_name = $('input[name=modal_name_mip]').val();
            // alert(modal_name)
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('operator_mip_scope');
            return false;
        });
        $("#operator_pip_scope").submit(function(event){
            var modal_name = $('input[name=modal_name_pip]').val();
            // alert(modal_name)
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('operator_pip_scope');
            return false;
        });
        $("#operator_pubpip_scope").submit(function(event){
            var modal_name = $('input[name=modal_name_pubpip]').val();
            // alert(modal_name)
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('operator_pubpip_scope');
            return false;
        });
        $("#operator_pvtpip_scope").submit(function(event){
            var modal_name = $('input[name=modal_name_pvtpip]').val();
            // alert(modal_name)
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('operator_pvtpip_scope');
            return false;
        });

        $("#alert_close").click(function() {
            location.reload(true);
        });

    });

    function saveScope(formId) {
        $.ajax({	
            type: "POST",
            url: "ajax/save_ipsope.php",
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

                $( "#scope_alert .modal-title" ).html(title);
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