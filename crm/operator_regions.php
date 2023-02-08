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
                                        <h1 class="head">Operators</h1>
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
									            </tr><tr role="row" class="even">
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>AK</td>
									                <td>West</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="odd">
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>GA</td>
									                <td>South</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="even">
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>NH</td>
									                <td>Northeast</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="odd">
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>WA</td>
									                <td>West</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="even">
									                <td class="">All</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Hosted</td>
									                <td>WI</td>
									                <td>Midwest</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="odd">
									                <td class="">ALT</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Complex</td>
									                <td>CA</td>
									                <td>West</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="even">
									                <td class="">ALT</td>
													<td class="sorting_1"><span class="responsiveExpander"></span>Complex</td>
									                <td>KY</td>
									                <td>South</td>
									                <td>&nbsp;</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="odd">
									                <td class="">COX</td>
													<td class="sorting_1"><span class="responsiveExpander"></span></td>
									                <td>AT</td>
									                <td>East</td>
									                <td>Atlanta</td>
									                <td>&nbsp;</td>
									            </tr><tr role="row" class="even">
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
                                                    <input type="email" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Deployment Type</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">None</option>
                                                        <option value="2">Simple</option>
                                                        <option value="3">Complex</option>
                                                        <option value="4">Hosted</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">State</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">None</option>
                                                        <option value="2">Reseller</option>
                                                        <option value="3">Property Manager</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Region</label>
                                                    <select id="inputState" class="form-select">
                                                        <option value="1">Active</option>
                                                        <option value="2">InActive</option>
                                                        <option value="3">Maintenance</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">State Name</label>
                                                    <input type="state_name" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">City</label>
                                                    <input type="city" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail4" class="form-label">Notes</label>
                                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
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