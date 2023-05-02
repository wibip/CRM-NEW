<?php
include 'header_new.php';
$page = "Property Addressing";

require_once 'classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();

$operators = $OperatorClass->getOperators();
$properties = $adminConfig->getProperty(); 

// var_dump($properties);
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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operators</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Property Addressing</h1>
                                        <br/>
                                        <h5 class="head">Properties</h5>
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#property">Add Property</button> -->
                                        <table class="table table-striped" style="width:100%" id="property-addressing-table" data-modal-target="#property" data-modal-btn-txt="Add Property">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Vertical</th>
                                                    <th>Property Name</th>
                                                    <th>Realm</th>
                                                    <th>Type</th>
                                                    <th>CLLI</th>
                                                    <th>Property Short Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($properties['PROP'] as $property) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$property['operator_code']?></td>
                                                        <td><?=$property['sub_operator_code']?></td>
                                                        <td><?=$property['vertical']?></td>
                                                        <td><?=$property['property_name']?></td>
                                                        <td><?=$property['realm']?></td>
                                                        <td><?=$property['property_type']?></td>
                                                        <td><?=$property['clli']?></td>                                                        
                                                        <td><?=$property['short_name']?></td>
                                                    </tr>
                                                <?php

                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Addressing</h5>
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#property_ip_addressing">Add IP Addressing</button> -->
                                        <table class="table table-striped" style="width:100%" id="pip-addressing-table" data-modal-target="#property_ip_addressing" data-modal-btn-txt="Add IP Addressing">
                                            <thead>
                                                <tr>
                                                    <th>Property Name</th>
                                                    <th>Vertical</th>
                                                    <th>Node Type</th>
                                                    <th>Model Number</th>
                                                    <th>Host Name</th>
                                                    <th>IP</th>
                                                    <th>VLAN-Type-Network-Netmask-Gateway</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach($properties['PIPA'] as $property) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?=$property['property_name']?></td>
                                                        <td><?=$property['vertical']?></td>
                                                        <td><?=$property['node_type']?></td>
                                                        <td><?=$property['model_number']?></td>
                                                        <td><?=$property['host_name']?></td>
                                                        <td><?=$property['ip']?></td>
                                                        <td><?=$property['vlan_netmask_gateway']?></td>
                                                        <td><?=$property['notes']?></td>
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

<!-- The Modal property-->
<div class="modal" id="property">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Property</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="property" name="property"  method="post">
                        <input type="hidden" id="modal_name_property" name="modal_name_property" value="property" />
                        <input type="hidden" id="type" name="type" value="PROP" />
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
                            <label for="inputEmail4" class="form-label">Vertical</label>
                            <select id="vertical" name="vertical" class="form-select">
                                <option value="">None</option>
                                <option value="ENT">ENT</option>
                                <option value="HOS">HOS</option>
                            </select>
                        </div>   
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Property Name</label>
                            <input type="text" id="property_name" name="property_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Realm</label>
                            <input type="text" id="realm" name="realm" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Type</label>
                            <select id="property_type" name="property_type" class="form-select">
                                <option value="None">None</option>
                                <option value="AC">AC</option>
                            </select>
                        </div>  
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">CLLI</label>
                            <input type="text" id="clli" name="clli" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Property Short Name</label>
                            <input type="text" id="short_name" name="short_name" class="form-control">
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

<!-- The Modal property_ip_addressing-->
<div class="modal" id="property_ip_addressing">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="border card my-4">
                    <div class="border-bottom card-header p-4">
                        <div class="g-3 row">
                            <h4>Create Property IP Addressing</h4>
                        </div>
                    </div>
                    <form class="row g-3 p-4" id="property_ip" name="property_ip"  method="post">
                        <input type="hidden" id="modal_name_property_ip" name="modal_name_property_ip" value="property_ip_addressing" />
                        <input type="hidden" id="type" name="type" value="PIPA" />
                        <input type="hidden" id="user_name" name="user_name" value="<?=$user_name?>" />
                        <input type="hidden" id="user_group" name="user_group" value="<?=$user_group?>" />
                        <input type="hidden" id="page" name="page" value="<?=$page?>" />
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Property Name</label>
                            <input type="text" id="property_name" name="property_name" class="form-control">
                        </div>   
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Vertical</label>
                            <select id="vertical" name="vertical" class="form-select">
                                <option value="">None</option>
                                <option value="ENT">ENT</option>
                                <option value="HOS">HOS</option>
                            </select>
                        </div>   
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Node Type</label>
                            <input type="text" id="node_type" name="node_type" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Model Number</label>
                            <input type="text" id="model_number" name="model_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Host Name</label>
                            <input type="text" id="host_name" name="host_name" class="form-control">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP</label>
                            <input type="text" id="ip" name="ip" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">VLAN-Type-Network-Netmask-Gateway</label>
                            <input type="text" id="vlan_netmask_gateway" name="vlan_netmask_gateway" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Notes</label>
                            <textarea class="form-control" placeholder="" id="notes" name="notes" ></textarea>
                        </div>
                        <div class="col-md-12">
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
        $('#property-addressing-table').dataTable();
        $('#pip-addressing-table').dataTable();

        $("#property").submit(function(event){
            var modal_name = $('input[name=modal_name_property]').val();
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('property');
            return false;
        });
        $("#property_ip").submit(function(event){
            var modal_name = $('input[name=modal_name_property_ip]').val();
            $('#'+modal_name).modal('hide');
            $("#overlay").css("display","block");
            saveScope('property_ip');
            return false;
        });

        $("#alert_close").click(function() {
            location.reload(true);
        });
    });

    function saveScope(formId) {
        $.ajax({	
            type: "POST",
            url: "ajax/save_property.php",
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