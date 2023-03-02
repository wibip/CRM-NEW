<?php
include 'header_new.php';
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
                                        <table class="table table-striped" style="width:100%" id="qos-table">
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
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>28K</td>
                                                    <td>QoS-Profile-28k</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>28K</td>
                                                    <td>QoS-Profile-28k</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">BusinessID Scope</h5>
                                        <table class="table table-striped" style="width:100%" id="bid-scope-table">
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
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>ENT-SMB-NON-AP-MERA</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>ENT-SMB-NON-AP-MERA</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">ServiceType Map</h5>
                                        <table class="table table-striped" style="width:100%" id="service-type-table">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Service Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>ENT-SMB-NON-AP-MERA</td>
                                                </tr>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>&nbsp;</td>
                                                    <td>ENT-SMB-NON-AP-VYOS</td>
                                                </tr>
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
                    <form class="row g-3 p-4">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="inputState" class="form-select">
                                <option value="1">ATL</option>
                                <option value="2">FRT</option>
                                <option value="2">MCOM</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Qos Profile</label>
                            <select id="inputState" class="form-select">
                                <option value="1">28K</option>
                                <option value="2">10X10M</option>
                                <option value="3">150x150M</option>
                                <option value="1">1X1G</option>
                                <option value="2">10X10M</option>
                                <option value="3">150x150M</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Qos Profile ID</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">vSZ Mapping</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">WAG Magic</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Product Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Group</label>
                            <select id="inputState" class="form-select">
                                <option value="">None</option>
                                <option value="Att">Att</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Account Template</label>
                            <select id="inputState" class="form-select">
                                <option value="">None</option>
                                <option value="East">att-account-template</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Profile</label>
                            <select id="inputState" class="form-select">
                                <option value="">None</option>
                                <option value="1">QoS-Profile-128K</option>
                                <option value="2">QoS-Profile-10x10</option>
                                <option value="3">QoS-Profile-100x100</option>
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
                    <form class="row g-3 p-4">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="inputState" class="form-select">
                                <option value="1">ATL</option>
                                <option value="2">FRT</option>
                                <option value="2">MCOM</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">SDL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Type</label>
                            <select id="inputState" class="form-select">
                                <option value="1">ENT-SMB-NON-AP-MERAKI</option>
                                <option value="2">ENT-SMB-NON-AP-MERAKI</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Business Type</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Business Prefix</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">BusinessID From</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">BusinessID To</label>
                            <input type="text" class="form-control">
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
<div class="modal" id="service_type_map">
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
                    <form class="row g-3 p-4">
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Operator Code</label>
                            <select id="inputState" class="form-select">
                                <option value="1">ATL</option>
                                <option value="2">FRT</option>
                                <option value="2">MCOM</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">SDL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Service Type</label>
                            <select id="inputState" class="form-select">
                                <option value="1">ENT-SMB-NON-AP-MERAKI</option>
                                <option value="2">ENT-SMB-NON-AP-MERAKI</option>
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

<script>
    $(document).ready(function () {
        $('#qos-table').dataTable({
            "initComplete": function(settings, json) {
                $('#qos-table_filter').find('input').removeClass('form-control-sm');
                $('#qos-table_wrapper').find('.btn-div').prepend('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qosprofile">Add QoS Profile</button>');
            },
            "dom": "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'<'btn-div'l>>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "language": {
            "lengthMenu": "_MENU_",
            "search": "_INPUT_",
        "searchPlaceholder": "Search..."
        }
        });
        $('#bid-scope-table').dataTable({
            "initComplete": function(settings, json) {
                $('#bid-scope-table_filter').find('input').removeClass('form-control-sm');
                $('#bid-scope-table_wrapper').find('.btn-div').prepend('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qosprofile">Add QoS Profile</button>');
           },
            "dom": "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'<'btn-div'l>>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "language": {
            "lengthMenu": "_MENU_",
            "search": "_INPUT_",
        "searchPlaceholder": "Search..."
        }
        });
        $('#service-type-table').dataTable({
            "initComplete": function(settings, json) {
                $('#service-type-table_filter').find('input').removeClass('form-control-sm');
                $('#service-type-table_wrapper').find('.btn-div').prepend('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qosprofile">Add QoS Profile</button>');
           },
            "dom": "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'<'btn-div'l>>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "language": {
            "lengthMenu": "_MENU_",
            "search": "_INPUT_",
        "searchPlaceholder": "Search..."
        }
        });
    });
</script>