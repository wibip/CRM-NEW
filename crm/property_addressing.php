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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operators</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Property Addressing</h1>
                                        <br/>
                                        <h5 class="head">Properties</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#property">Add Property</button>
                                        <table class="table table-striped" style="width:100%" id="property-addressing-table">
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
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>SDL</td>
                                                    <td>ENT</td>
                                                    <td>Upfield Foods</td>
                                                    <td>421666600002</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>ALT</td>
                                                    <td>&nbsp;</td>
                                                    <td>HOS</td>
                                                    <td>Radisson</td>
                                                    <td>421666600043</td>
                                                    <td>AC</td>
                                                    <td>CHCGIL</td>
                                                    <td>448NLASALLE</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <h5 class="head">Property IP Addressing</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#property_ip_addressing">Add IP Addressing</button>
                                        <table class="table table-striped" style="width:100%" id="pip-addressing-table">
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
                                                <tr>
                                                    <td>448 N LaSalle</td>
                                                    <td>MXU</td>
                                                    <td>Firewall - VPN</td>
                                                    <td>Fortinet 60F</td>
                                                    <td>448NLaSalle-FGT-01</td>
                                                    <td>10.92.1.129</td>
                                                    <td>VLAN50 - MGMT - 10.92.1.128/26 - Netmask 255.255.255.192 - GW 10.92.1.129</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>448 N LaSalle</td>
                                                    <td>MXU</td>
                                                    <td>AC-IPMI</td>
                                                    <td>SMC SYS-5019S-L</td>
                                                    <td>448NLaSalle-IPMI-01</td>
                                                    <td>10.92.1.131</td>
                                                    <td>VLAN50 - MGMT - 10.92.1.128/26 - Netmask 255.255.255.192 - GW 10.92.1.129</td>
                                                    <td>&nbsp;</td>
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
                            <label for="inputEmail4" class="form-label">Vertical</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">ENT</option>
                                <option value="2">HOS</option>
                            </select>
                        </div>   
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Property Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Realm</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Type</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">AC</option>
                            </select>
                        </div>  
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">CLLI</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Property Short Name</label>
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
                            <label for="inputEmail4" class="form-label">Vertical</label>
                            <select id="inputState" class="form-select">
                                <option value="1">None</option>
                                <option value="2">ENT</option>
                                <option value="2">HOS</option>
                            </select>
                        </div>   
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Node Type</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Model Number</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Host Name</label>
                            <input type="text" class="form-control">
                        </div> 
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">IP</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">VLAN-Type-Network-Netmask-Gateway</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail4" class="form-label">Notes</label>
                            <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
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

<script>
    $(document).ready(function () {
        $('#property-addressing-table').dataTable();
        $('#pip-addressing-table').dataTable();
    });
</script>