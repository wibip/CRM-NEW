<?php
include 'header_new.php';
$page = "Operator Regions";
require_once 'classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();

if(isset($_POST['regions_save'])){
    // var_dump($_POST);
    $result = $adminConfig->saveRegions($_POST,$user_name,$user_group,$page);
    if ($result===true) {
        $_SESSION['message_regions'] = "<div class='alert alert-success' role='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Region has been successfully added</strong></div>";
    } else {
        $_SESSION['message_regions'] = "<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error on Region save</strong></div>";
    }

    /*To prevent resumbits*/
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
// unset($_POST);
$operators = $OperatorClass->getOperators();
$regions = $adminConfig->getRegions();
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
                                        <?php
                                            if (isset($_SESSION['message_regions'])) {
                                                echo $_SESSION['message_regions'];
                                                unset($_SESSION['message_regions']);
                                            }
                                        ?>
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
                                                <?php 
                                                    if($regions['rowCount'] > 0) {
                                                        foreach($regions['data'] as $region) {
                                                ?>
                                                        <tr role="row" class="odd">
                                                            <td><?=$region['operator_code']?></td>
                                                            <td><?=$region['development_type']?></td>
                                                            <td><?=$region['region_state']?></td>
                                                            <td><?=$region['region']?></td>
                                                            <td><?=$region['state_name']?></td>
                                                            <td><?=$region['city']?></td>
                                                        </tr>
                                                <?php

                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <h4>Create Operator Region</h4>
                                                </div>
                                            </div>
                                            <form class="row g-3 p-4" id="operator_region" name="operator_region" method="post">
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">Operator Code</label>
                                                    <select id="operator_code" name="operator_code" class="form-select">
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
                                                    <label for="inputPassword4" class="form-label">Environment</label>
                                                    <select id="development_type" name="development_type" class="form-select">
                                                        <option value="">None</option>
                                                        <option value="Hosted">Hosted</option>
                                                        <option value="Simple (SMB)">Simple (SMB)</option>
                                                        <option value="Complex">Complex</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">State</label>
                                                    <select id="region_state" name="region_state" class="form-select">
                                                        <option value="">None</option>
                                                        <option value="WI">WI</option>
                                                        <option value="AK">AK</option>
                                                        <option value="CA">CA</option>
                                                        <option value="AR">AR</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Region</label>
                                                    <select id="region" name="region" class="form-select">
                                                        <option value="">None</option>
                                                        <option value="Central">Central</option>
                                                        <option value="East">East</option>
                                                        <option value="Midwest">Midwest</option>
                                                        <option value="West">West</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">State Name</label>
                                                    <input type="text" id="state_name" name="state_name" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4" class="form-label">City</label>
                                                    <input type="text" id="city" name="city" class="form-control">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="inputEmail4" class="form-label">Notes</label>
                                                    <textarea class="form-control" id="notes" name="notes" placeholder="" id="floatingTextarea"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" id="regions_save" name="regions_save" class="btn btn-primary">Submit</button>
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