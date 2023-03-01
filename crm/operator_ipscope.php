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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operator IP Scope</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Operator IP Scope</h1>
                                        <br/>
                                        <h5 class="head">Operator Management IP Scope</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#opt_mgt_ip_scope">Add Management IP Scope</button>
                                        <table class="table table-striped" style="width:100%" id="oip-table">
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
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>West</td>
                                                    <td>10.1.0.1</td>
                                                    <td>10.1.0.120</td>
                                                    <td>28</td>
                                                </tr>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>East</td>
                                                    <td>10.1.1.200</td>
                                                    <td>10.1.1.400</td>
                                                    <td>25</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#property_ip_scope">Add Property IP Scope</button>
                                        <table class="table table-striped" style="width:100%" id="pip-table">
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
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>Full Gospel</td>
                                                    <td>FULLGSPLHLYTMPL</td>
                                                    <td>10.95.255.208</td>
                                                    <td>27</td>
                                                </tr>
                                                <tr>
                                                    <td>FRT</td>
                                                    <td>SDL</td>
                                                    <td>Carlinville National Bank</td>
                                                    <td>CARLINVILLEBANK</td>
                                                    <td>10.130.0.32</td>
                                                    <td>28</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope :: Public</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#public_property_ip_scope">Add Public Property IP Scope</button>
                                        <table class="table table-striped" style="width:100%" id="pips-public-table">
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
                                                <tr>
                                                    <td>ATT</td>
                                                    <td>SDL</td>
                                                    <td>Full Gospel</td>
                                                    <td>FULLGSPLHLYTMPL</td>
                                                    <td>12.13.57.88/29</td>
                                                    <td>12.13.57.90</td>
                                                    <td>10.95.255.193</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>ATT</td>
                                                    <td>&nbsp;</td>
                                                    <td>Creekside</td>
                                                    <td>CREEKSIDE</td>
                                                    <td>12.13.57.88/29</td>
                                                    <td>12.13.57.90</td>
                                                    <td>10.95.255.193</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Scope :: Private</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#private_property_ip_scope">Add Private Property IP Scope</button>
                                        <table class="table table-striped" style="width:100%" id="pips-private-table">
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
                                                <tr>
                                                    <td>ATT</td>
                                                    <td>SDL</td>
                                                    <td>Full Gospel</td>
                                                    <td>FULLGSPLHLYTMPL</td>
                                                    <td>10.95.1.66-75</td>
                                                    <td>32.143.114.154/30</td>
                                                    <td>10.95.1.76-90</td>
                                                </tr>
                                                <tr>
                                                    <td>ATT</td>
                                                    <td>&nbsp;</td>
                                                    <td>Creekside</td>
                                                    <td>CREEKSIDE</td>
                                                    <td>10.95.255.194 - 197</td>
                                                    <td>&nbsp;</td>
                                                    <td>10.95.255.198 - 206</td>
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
                            <label for="inputEmail4" class="form-label">IP Range: From</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP Range: To</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Region</label>
                            <select id="inputState" class="form-select">
                                <option value="1">Central</option>
                                <option value="2">East</option>
                                <option value="3">Midwest</option>
                                <option value="3">West</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Netmask</label>
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
                            <label for="inputEmail4" class="form-label">Property</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">Full Gospel</option>
                                <option value="2">Creekside</option>
                                <option value="2">MPM Bio Impact</option>
                                <option value="2">Rio Del Sol Needles</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Customer Peer ID</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP Network</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Netmask</label>
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
                            <label for="inputEmail4" class="form-label">Property Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Customer Peer ID</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Firewall Public Net</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Firewall Public IP</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Firewall VLAN50 Net</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Firewall Serial No</label>
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

<!-- The Modal private_property_ip_scope-->
<div class="modal" id="private_property_ip_scope">
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
                            <label for="inputEmail4" class="form-label">Property Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Customer Peer ID</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">VLAN Static IP</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Underlay Net</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">VLAN DHCP AP IP</label>
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

<script>
    $(document).ready(function () {
        $('#oip-table').dataTable();
        $('#pip-table').dataTable();
        $('#pips-public-table').dataTable();
        $('#pips-private-table').dataTable();
    });
</script>