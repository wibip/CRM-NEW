<?php
include 'header_new.php';
$page = "Operator Realms";
require_once 'classes/adminConfigClass.php';
$adminConfig = new adminConfig();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();
// var_dump($_POST);
if(isset($_POST['realms_save'])){
    // var_dump($_POST);
    $result = $adminConfig->saveRealm($_POST,$user_name,$user_group,$page);
    if ($result===true) {
        $_SESSION['message_realms'] = "<div class='alert alert-success' role='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Realm has been successfully added</strong></div>";
    } else {
        $_SESSION['message_realms'] = "<div class='alert alert-danger' role='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error on Realm save</strong></div>";
    }

    /*To prevent resumbits*/
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
// unset($_POST);
$operators = $OperatorClass->getOperators();
$realms = $adminConfig->getRealms();
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
                                        <?php
                                            if (isset($_SESSION['message_realms'])) {
                                                echo $_SESSION['message_realms'];
                                                unset($_SESSION['message_realms']);
                                            }
                                        ?>
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
                                                <?php 
                                                    if($realms['rowCount'] > 0) {
                                                        foreach($realms['data'] as $realm) {
                                                ?>
                                                        <tr role="row" class="odd">
                                                            <td><?=$realm['operator_code']?></td>
                                                            <td><?=$realm['sub_operator_code']?></td>
                                                            <td><?=$realm['region']?></td>
                                                            <td><?=$realm['prefix']?></td>
                                                            <td><?=$realm['range_from']?></td>
                                                            <td><?=$realm['range_to']?></td>
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
                                                    <h4>Create Realm Scope</h4>
                                                </div>
                                            </div>
                                            <form class="row g-3 p-4" id="operator_realm" name="operator_realm" method="post">
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
                                                    <label for="inputEmail4" class="form-label">Sub Operator Code</label>
                                                    <select id="sub_operator_code" name="sub_operator_code" class="form-select">
                                                        <option value="">NONE</option>
                                                        <option value="SDL">SDL</option>
                                                        <option value="OPT">OPT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Realm Range From</label>
                                                    <input type="text" id="range_from" name="range_from" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputPassword4" class="form-label">Realm Range To</label>
                                                    <input type="text" id="range_to" name="range_to" class="form-control">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Service Type</label>
                                                    <select id="service_type" name="service_type" class="form-select">
                                                         <option value="">Select Servicce Type</option>
                                                        <option value="ENT-SMB-NON-AP-VYOS">ENT-SMB-NON-AP-VYOS</option>
                                                        <option value="ENT-SMB-NON-AP-FORTIGATE">ENT-SMB-NON-AP-FORTIGATE</option>
                                                        <option value="ENT-SMB-NON-AP-MERAK">ENT-SMB-NON-AP-MERAK</option>
                                                        <option value="SMB-ENT">SMB-ENT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Region</label>
                                                    <select id="region" name="region" class="form-select">
                                                        <option value="">None</option>
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
                                                    <input type="text" id="prefix" name="prefix" class="form-control">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="inputEmail4" class="form-label">Notes</label>
                                                    <textarea class="form-control" id="notes" name="notes" placeholder="" id="floatingTextarea"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit"  id="realms_save" name="realms_save"  class="btn btn-primary">Submit</button>
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