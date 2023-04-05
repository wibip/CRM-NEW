<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<?php
include 'header_new.php';
$page = "Operators";
$priority_zone_array = array(
    "America/New_York",
    "America/Chicago",
    "America/Denver",
    "America/Los_Angeles",
    "America/Anchorage",
    "Pacific/Honolulu",
);

require_once './classes/systemPackageClass.php';
$package_functions = new package_functions();
require_once './classes/OperatorClass.php';
$OperatorClass = new OperatorClass();
//load countries
$country_sql="SELECT * FROM (SELECT `country_code` AS a,`country_name` AS b FROM `exp_mno_country` WHERE `default_select`=1 ORDER BY `country_name` ASC) AS a
UNION ALL
SELECT * FROM (SELECT `country_code`,`country_name` FROM `exp_mno_country` WHERE `default_select`=0 ORDER BY `country_name` ASC) AS b";
$country_result = $db->selectDB($country_sql);
//load country states
$regions_sql="SELECT `states_code`, `description` FROM `exp_country_states` ORDER BY description";
$get_regions = $db->selectDB($regions_sql);
$s_a = '';
$s_a_val = '';
foreach ($get_regions['data'] as $state) {
$s_a .= $state['description'].'|';
$s_a_val .= $state['states_code'].'|';
}

$utc = new DateTimeZone('UTC');
$dt = new DateTime('now', $utc);

$key_query2 = "SELECT settings_value FROM exp_settings WHERE settings_code = 'service_account_form' LIMIT 1";
$query_result2 = $db->select1DB($key_query2);
$mno_form_type = $query_result2['settings_value'];

$mno_operator_check="SELECT p.product_code,p.`product_name`,c.options
                        FROM `admin_product` p LEFT JOIN admin_product_controls c ON p.product_code=c.product_code AND c.feature_code='VTENANT_MODULE'
                        WHERE `is_enable` = '1' AND p.`user_type` = 'MNO'";
$mno_op = $db->selectDB($mno_operator_check);

$key_query="SELECT c.controller_name,c.description,c.brand,c.api_profile,c.id FROM `exp_locations_ap_controller` c ";
$query_results=$db->selectDB($key_query);

$operators = $OperatorClass->getOperators();

if (isset($_POST['submit_mno_form'])) { //6
    if (isset($_GET['mno_edit'])) {
        $edit_mno_id = $_GET['mno_edit_id'];
        $get_edit_get = 1;
        $get_mno_unque_q = "SELECT `unique_id`,`features` FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
        $get_mno_unque = $db->selectDB($get_mno_unque_q);

        foreach ($get_mno_unque['data'] as $get_mno_unque_arr) {
            $mno_unque = $get_mno_unque_arr['unique_id'];
            $featurearrold = $get_mno_unque_arr['features'];
        }
    }

    $isDynamic_q = "SELECT `access_method` FROM `admin_product_controls` WHERE `product_code`='DYNAMIC_MNO_001' AND `feature_code`='IS_DYNAMIC'";
    $isDynamic_res = $db->select1DB($isDynamic_q);
    //$isDynamic_row = mysql_fetch_assoc($isDynamic_res);
    $isDynamic = $isDynamic_res['access_method'];

        if ($_SESSION['FORM_SECRET'] == $_POST['form_secret6']) { //refresh validate
            $mno_account_name = $db->escapeDB(trim($_POST['mno_account_name']));
            $mno_sys_package = trim($_POST['mno_sys_package']);
            $operator_code = trim($_POST['operator_code']);
            $sub_operator_code = trim($_POST['sub_operator_code']);
            $sub_operator_name = trim($_POST['sub_operator_name']);
            $mno_system_package = $mno_sys_package;
            $api_profile = $_POST['api_profile'];
            $login_user_name = $_SESSION['user_name'];
            $br = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_mno'");
            $auto_inc = $br['Auto_increment'];
            $auto_inc++;
            $mno_id = "OPERATION11" . $auto_inc;
            $u_id = str_pad($auto_inc, 8, "0", STR_PAD_LEFT);
            $unique_id = '1' . $u_id;
            $new_user_name = str_replace(' ', '_', strtolower(substr($mno_full_name, 0, 5) . 'm' . $auto_inc));
            $password = CommonFunctions::randomPassword();
            ////////////MNO Default theme insert///////////////////////////////////
            if ($get_edit_get == 1) {
                //*************************UPDATE********************************************
                if ($mno_form_type == 'advanced_menu') { //advanced_menu
                    $query0 = "UPDATE `exp_mno`
                                SET
                                `mno_description`='$mno_account_name',
                                `mno_type`='$mnoAccType'
                                WHERE `mno_id`='$edit_mno_id'";
           
                } else {
                    $query0 = "UPDATE `exp_mno` SET `full_name`='$mno_full_name',`email`='$mno_email',`mno_type`='$mnoAccType' WHERE `user_distributor`='$edit_mno_id' AND `access_role`='admin'";

                    $query1 = "UPDATE
                                `admin_users`
                                SET
                                `full_name` = '$mno_full_name',
                                `email` = '$mno_email',
                                `mobile` = '$mno_mobile_1',
                                `timezone` = '$mno_time_zone'
                                WHERE `user_distributor` = '$edit_mno_id' ORDER BY id LIMIT 1";
                }

                $lastfeatures = json_decode($featurearrold, true);
                $ex0 = $db->execDB($query0);
                // var_dump($ex0);die;
                if ($ex0 === true) {
                    $ex1 = $db->execDB($query1);

                    $message_response = $message_functions->showMessage('operator_update_success') ;
                    $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Modify Operation',$edit_mno_id,'3001',$message_response);
                    $_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                } else {
                    $message_response = $message_functions->showMessage('operator_update_failed', '2001');
                    $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Modify Operation',$edit_mno_id,'2001',$message_response);
                    // $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                    $_SESSION['msg7'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response. "</strong></div>";
                }

            } else {
                $query0 = "INSERT INTO `exp_mno` (
                    `mno_id`,
                    `unique_id`,
                    `operator_code`,
                    `mno_description`,
                    `sub_operator_code`,
                    `sub_operator_name`,
                    `features`,
                    `is_enable`,
                    `create_date`,
                    `create_user`,
                    `system_package`)
                    VALUES
                    ( '$mno_id',
                      '$unique_id',
                      '$operator_code',
                      '$mno_account_name',
                      '$sub_operator_code',
                      '$sub_operator_name',
                      '$api_profile',
                      '1',
                      NOW(),
                      '$login_user_name',
                      '$mno_system_package')";
     

                // echo $query0;die;
                $ex0 = $db->execDB($query0);
                $idContAutoInc = $db->getValueAsf("SELECT LAST_INSERT_ID() as f");
                
                if ($ex0 === true) {
                    // echo '---------------------------------------------> Debug Point 01'; 
                    if (isset($mno_sys_package)) {
                        $access_role_id = $mno_id . "_provider";
                        $access_role_name = $mno_id . " Provider";
                        if ($package_functions->getSectionType("SUPPORT_AVAILABLE", $mno_sys_package) == '1') {
                            // echo '---------------------------------------------> Debug Point 02'; 
                            $query0 = "INSERT INTO `admin_access_roles` (`access_role`,`description`,`distributor`,`create_user`,`create_date`)
                                        VALUES ('$access_role_id', 'Support', '$mno_id', '$user_name',now())";
                            $result0 = $db->execDB($query0);
                            if ($result0 === true) {
                                $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Create Access Role',$idContAutoInc,'3001',$result0);
                            } else {
                                $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create Access Role',$idContAutoInc,'2001',$result0);
                            }
                            $sys_pack = $mno_sys_package;
                            $gt_support_optioncode = $package_functions->getOptions('SUPPORT_AVAILABLE', $sys_pack, 'MNO');
                            $pieces1 = explode(",", $gt_support_optioncode);
                            $len1 = count($pieces1);

                            for ($i = 0; $i < $len1; $i++) {
                                // echo '---------------------------------------------> Debug Point 03'; 
                                $query1 = "INSERT INTO `admin_access_roles_modules`
                                        (`access_role`, `module_name`, `distributor` , `create_user`, `create_date`)
                                        VALUES ('$access_role_id', '$pieces1[$i]', '$mno_id', '$user_name', now())";
                                $result1 = $db->execDB($query1);
                                if ($result1 === true) {
                                    $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Create Access Role Modules',$idContAutoInc,'3001',$result1);
                                } else {
                                    $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create Access Role Modules',$idContAutoInc,'2001',$result1);
                                }
                            }
                        }
                    }

                    ///////////////////////////////////////////////
                    $message_response = $message_functions->showMessage('operator_create_success') ;
                    $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Create Operatorn',$idContAutoInc,'3001',$message_response);
                    // $db->userLog($user_name, $script, 'Create Operator', '');
                    $_SESSION['msg6'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                } else {
                    $message_response = $message_functions->showMessage('operator_create_failed', '2001');
                    $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create Operatorn',$idContAutoInc,'2001',$message_response);
                    // $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                    $_SESSION['msg6'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
                }
            }
        } //key validation
        else {
            $message_response = $message_functions->showMessage('transection_fail', '2004');
            $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Create Operatorn',$idContAutoInc,'2004',$message_response);
            // $db->userErrorLog('2004', $user_name, 'script - ' . $script);
            $_SESSION['msg6'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $message_response . "</strong></div>";
            header('Location: operations.php');
        }
} elseif (isset($_GET['edit_mno_id'])) {
    // var_dump('ssssssss');
    $edit_mno_id = $_GET['edit_mno_id'];
    $get_edit_mno_details_q = "SELECT * FROM `exp_mno` WHERE `mno_id`='$edit_mno_id'";
    $mno_data = $db->select1DB($get_edit_mno_details_q);
    $get_edit_mno_id = $mno_data['id'];
    $get_edit_mno_mno_id = $mno_data['mno_id'];
    $get_edit_mno_unique_id = $mno_data['unique_id'];
    $get_edit_mno_description = $mno_data['mno_description'];
    $get_edit_mno_mno_type = $mno_data['mno_type'];
    $get_edit_mno_api_prefix = $mno_data['api_prefix'];
    $get_edit_mno_features = $mno_data['features'];
    if (strlen($get_edit_mno_api_prefix) > 0) {
        $edit_mno_api_access = '1';
    } else {
        $edit_mno_api_access = '0';
    }

    $get_edit_mno_sys_pack = $mno_data['system_package'];
    $get_sys_package_arr = explode('-', $get_edit_mno_sys_pack);
    $get_sys_package_prefix = array_shift($get_sys_package_arr);


        $mno_edit = 1;
} //edit_mno
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
                                        <?php
                                            if (isset($_SESSION['msg5'])) {
                                                echo $_SESSION['msg5'];
                                                unset($_SESSION['msg5']);
                                            }

                                            if (isset($_SESSION['msg1'])) {
                                                echo $_SESSION['msg1'];
                                                unset($_SESSION['msg1']);
                                            }


                                            if (isset($_SESSION['msg2'])) {
                                                echo $_SESSION['msg2'];
                                                unset($_SESSION['msg2']);
                                            }

                                            if (isset($_SESSION['msg3'])) {
                                                echo $_SESSION['msg3'];
                                                unset($_SESSION['msg3']);
                                            }

                                            if (isset($_SESSION['msg6'])) {
                                                echo $_SESSION['msg6'];
                                                unset($_SESSION['msg6']);
                                            } 	
                                        ?>
                                        <h1 class="head">Operators</h1>
                                        <table class="table table-striped" style="width:100%" id="operator-table">
                                            <thead>
                                                <tr>
                                                    <th>Operator Code</th>
                                                    <th>Operator Name</th>
                                                    <th>Sub Operator Code</th>
                                                    <th>Sub Operator Name</th>
                                                    <th>Environment</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if($operators['rowCount'] > 1){ 
                                                    //foreach($operators['data'] AS $operator) {
                                                    foreach ($operators['data'] as $row) {
                                                        $mno_description = $row['mno_description'];
                                                        $mno_id = $row['mno_id'];
                                                        $full_name = $row['full_name'];
                                                        $email = $row['email'];
                                                        $mobile = $row['mobile'];
                                                        // $s= $row[s];
                                                        $is_enable = ($row['is_enable'] == 1 ? "Active" : "Inactive");
                                                        // $icomm_num=$row[verification_number];
                                                        $api_profiles = json_decode($row['features']);
                                                        $show_profile = "";
                                                        foreach($api_profiles as $api_profile) {
                                                            $profile = $db->getValueAsf("SELECT `api_profile` as f FROM `exp_locations_ap_controller` WHERE `id`=".$api_profile);
                                                            $show_profile .= $profile."<br/>";
                                                        }
                                                ?>
                                                    <tr>
                                                        <td><?=$mno_id?></td>
                                                        <td><?=$full_name?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?=$is_enable?></td>
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
                                                    <span class="fs-5"><?= ($mno_edit==1 ? "Update" : "Create")?> Operator</span>
                                                </div>
                                            </div>
                                            <form onkeyup="submit_mno_formfn();" onchange="submit_mno_formfn();" id="mno_form" name="mno_form" class="row g-3 p-4" method="POST" action="operators.php?<?php if($mno_edit==1){echo "t=8&mno_edit=1&mno_edit_id=$edit_mno_id";}else{echo "t=6";}?>" >
                                                <input type="hidden" name="form_secret6" id="form_secret6" value="<?=$_SESSION['FORM_SECRET']?>" />
                                                <div class="col-md-6">
                                                    <label class="control-label" for="api_profile">BI API Profile</label>
                                                    <select onchange="add_module(this)" name="api_profile" id="api_profile" class="span4 form-control" required>
                                                        <option value="">Select API profile</option>
                                                        <?php
                                                        if($query_results['rowCount'] > 1) {
                                                            foreach($query_results['data'] AS $rowe){
                                                                if(in_array($rowe['id'], $features_controler_array)){
                                                                    $select="selected";
                                                                }else{
                                                                    $select="";
                                                                }
                                                                echo '<option '.$select.' value='.$rowe['id'].' data-vt="'.$rowe['controller_name'].'" >'.$rowe['api_profile'].'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>                                                    
                                                <div class="col-md-6">
                                                    <label class="control-label" for="mno_sys_package">Operations Type</label>
                                                    <select name="mno_sys_package" id="mno_sys_package"  class="span4 form-control form-control" <?php if($mno_edit==1) echo "readonly";?> required>
                                                        <option value="">Select Type of Operator</option>
                                                        <?php
                                                            if($mno_op['rowCount']>1 && ($user_group == 'admin' || $user_group == 'super_admin')){
                                                                foreach($mno_op['data'] AS $mno_op_row){
                                                                    if($get_edit_mno_sys_pack==$mno_op_row['product_code']){
                                                                        $select="selected";
                                                                    }else{
                                                                        $select="";
                                                                    }
                                                                    echo '<option '.$select.' value='.$mno_op_row['product_code'].' data-vt="'.$mno_op_row['options'].'" >'.$mno_op_row['product_name'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>                                              
                                                <div class="col-md-6">
                                                    <label class="control-label" for="operator_code">Operator Code</label>
                                                    <input class="span4 form-control" id="operator_code" name="operator_code" maxlength="12" placeholder="Operator Code" type="text" value="<?php echo $operator_code;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="operator_name">Operator Name</label>
                                                    <input class="span4 form-control form-control" id="mno_account_name" placeholder="Frontier" name="mno_account_name" type="text" value="<?php echo $mno_account_name;?>" required>
                                                </div>                                               
                                                <div class="col-md-6">
                                                    <label class="control-label" for="sub_operator_code">Sub Operator Code</label>
                                                    <input class="span4 form-control" id="sub_operator_code" name="sub_operator_code" maxlength="12" placeholder="Operator Code" type="text" value="<?php echo $sub_operator_code;?>" autocomplete="off" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label" for="sub_operator_name">Sub Operator Name</label>
                                                    <input class="span4 form-control form-control" id="sub_operator_name" name="sub_operator_name" placeholder="Frontier" type="text" value="<?php echo $sub_operator_name;?>" required>
                                                </div> 
                                                
                                                    <div  class="col-md-12">
                                                        <button type="submit" id="submit_mno_form" name="submit_mno_form" class="btn btn-primary"><?= ($mno_edit==1 ? "Update" : "Create")?> Operator</button>
                                                        <?php if($mno_edit==1){ ?> <button type="button" class="btn btn-info inline-btn"  onclick="goto();" class="btn btn-danger">Cancel</button> <?php } ?>
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

        $("#mno_zip_code").keydown(function (e) {
            var mac = $('#mno_zip_code').val();
            var len = mac.length + 1;
            // Allow: backspace, delete, tab, escape, enter, '-' and .
            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                    (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+C, Command+C
                    (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+x, Command+x
                    (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+V, Command+V
                    (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $('#mno_form #mno_mobile_1').focus(function(){
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
        });

        $('#mno_form #mno_mobile_1').keyup(function(){
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))
        });

        $("#mno_form #mno_mobile_1").keydown(function (e) {
            var mac = $('#mno_form #mno_mobile_1').val();
            var len = mac.length + 1;
            if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                mac1 = mac.replace(/[^0-9]/g, '');
            }
            else{
                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3) + '-' + $(this).val().substr(7,4);

                if(len == 4){
                    $('#mno_form #mno_mobile_1').val(function() {
                        return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                        //console.log('mac1 ' + mac);

                    });
                }
                else if(len == 8 ){
                    $('#mno_form #mno_mobile_1').val(function() {
                        return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                        //console.log('mac2 ' + mac);

                    });
                }
            }

            // Allow: backspace, delete, tab, escape, enter, '-' and .
            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110]) !== -1 ||
                        // Allow: Ctrl+A, Command+A
                    (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+C, Command+C
                    (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+x, Command+x
                    (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: Ctrl+V, Command+V
                    (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                        // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });

    function submit_mno_formfn() {
        //alert("fn");
        $("#submit_mno_form").prop('disabled', false);
    }

    function goto(url){
        window.location = "?";
    }
</script>

<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('#api_profile').multiSelect();  
    });
  </script>
