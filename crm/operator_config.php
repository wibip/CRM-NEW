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

<script>
    $(document).ready(function () {
        $('#qos-table').dataTable();
        $('#bid-scope-table').dataTable();
        $('#service-type-table').dataTable();
    });
</script>