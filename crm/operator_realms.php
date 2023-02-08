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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operator Realms</button>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Operator Realms</h1>
                                        <table class="table table-striped" style="width:100%" id="operator-table">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>SubOperator Code</th>
                                                    <th>Region</th>
                                                    <th>Realm Prefix</th>
                                                    <th>Realm Range From</th>
                                                    <th>Realm Range To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
													<td class="sorting_1">ALT</td>
													<td>SDL</td>
													<td>West</td>
													<td>421</td>
													<td>421800000</td>
													<td>421803000</td>
												</tr>
                                                <tr role="row" class="odd">
													<td class="sorting_1">ATT</td>
													<td><span class="responsiveExpander"></span></td>
													<td>East</td>
													<td>358</td>
													<td>358180000</td>
													<td>358180400</td>
												</tr>
                                                <tr role="row" class="odd">
													<td class="sorting_1">COX</td>
													<td>OPT</td>
													<td>Nort East</td>
													<td>628</td>
													<td>628700000</td>
													<td>628709000</td>
												</tr>
                                                <tr role="row" class="even">
													<td class="sorting_1">FRT</td>
													<td><span class="responsiveExpander"></span></td>
													<td>West</td>
													<td>953</td>
													<td>953700000</td>
													<td>953709000</td>
												</tr>
                                                <tr role="row" class="odd">
													<td class="sorting_1">MCOM</td>
													<td><span class="responsiveExpander"></span></td>
													<td>Nort East</td>
													<td>865</td>
													<td>865100000</td>
													<td>865109000</td>
												</tr>
                                                <tr role="row" class="even">
													<td class="sorting_1">VER</td>
													<td><span class="responsiveExpander"></span></td>
													<td>Nort East</td>
													<td>297</td>
													<td>297700000</td>
													<td>297709000</td>
												</tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <h4>Create Realm Scope</h4>
                                                </div>
                                            </div>
                                            <form class="row g-3 p-4">
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Operator Code</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">ATL</option>
                                                        <option value="2">FRT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">NONE</option>
                                                        <option value="2">SDL</option>
                                                        <option value="3">OPT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Realm Range From</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Realm Range To</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Service Type</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="ENT-SMB-NON-AP-VYOS">ENT-SMB-NON-AP-VYOS</option>
                                                        <option value="ENT-SMB-NON-AP-FORTIGATE">ENT-SMB-NON-AP-FORTIGATE</option>
                                                        <option value="ENT-SMB-NON-AP-MERAK">ENT-SMB-NON-AP-MERAK</option>
                                                        <option value="SMB-ENT">SMB-ENT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Region</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="East">East</option>
                                                        <option value="West">West</option>
                                                        <option value="North">North</option>
                                                        <option value="South">South</option>
                                                        <option value="SouthWest">South West</option>
                                                        <option value="NorthEast">North East</option>
                                                        <option value="NorthWest">North West</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Realm Prefix</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail4" class="form-label">Notes</label>
                                                    <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
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
        $('#operator-table').dataTable();
    });
</script>