<?php
include 'header_new.php';
$page = "Operator Regions";
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
                                        <button class="nav-link active" id="operators" data-bs-toggle="tab" data-bs-target="#operators-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Operator Regions</button>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <div div class="tab-pane fade show active" id="operators-tab-pane" role="tabpanel" aria-labelledby="operators" tabindex="0">
                                        <h1 class="head">Operator Regions</h1>
                                        <table class="table table-striped" style="width:100%" id="operator-table">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>Environment</th>
                                                    <th>State</th>
                                                    <th>Region</th>
                                                    <th>State Name</th>
                                                    <th>City</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr role="row" class="odd">
									                <td class="">ALT</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Simple (SMB)</td>
									                <td>AK</td>
									                <td>West</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr>
                                                <tr role="row" class="even">									                
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>WI</td>
									                <td>Midwest</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr>
                                                <tr role="row" class="odd">
									                <td class="">ALT</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Complex</td>
									                <td>CA</td>
									                <td>West</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr>
                                                <tr role="row" class="odd">
									                <td class="">COX</td>
													<td class="sorting_1"><span class="responsiveExpander"></span></td>
									                <td>AT</td>
									                <td>East</td>
									                <td>Atlanta</td>
									                <td>&nbsp;</td>
									            </tr>
                                                <tr role="row" class="even">
									                <td class="">COX</td>
													<td class="sorting_1"><span class="responsiveExpander"></span></td>
									                <td>AR</td>
									                <td>Central</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <h4>Create Operator Region</h4>
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
                                                    <label for="inputPassword4" class="form-label">Environment</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">None</option>
                                                        <option value="2">Hosted</option>
                                                        <option value="3">Simple (SMB)</option>
                                                        <option value="4">Complex</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">State</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">None</option>
                                                        <option value="2">WI</option>
                                                        <option value="3">AK</option>
                                                        <option value="2">CA</option>
                                                        <option value="3">AR</option>
                                                    </select>
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
                                                    <label for="inputEmail4" class="form-label">State Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">City</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="col-md-12">
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