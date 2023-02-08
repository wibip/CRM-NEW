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
                                        <table class="table table-striped" style="width:100%" id="operator-table">
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
                                                    <td>Altice</td>
                                                    <td>OPT</td>
                                                    <td>Optimum</td>
                                                    <td>Complex</td>
                                                    <td>Active</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <h4>Create Operator</h4>
                                                </div>
                                            </div>
                                            <form class="row g-3 p-4">
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Operator Code</label>
                                                    <input type="email" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Operator Name</label>
                                                    <input type="password" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                                                    <input type="email" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Sub Operator Name</label>
                                                    <input type="password" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputState" class="form-label">Environment</label>
                                                    <select id="inputState" class="form-select">
                                                        <option selected>None</option>
                                                        <option>Complex</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputState" class="form-label">Status</label>
                                                    <select id="inputState" class="form-select">
                                                        <option selected>Active</option>
                                                        <option>Inactive</option>
                                                    </select>
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