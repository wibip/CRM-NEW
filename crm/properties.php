<?php
include 'header_new.php';

$CommonFunctions = new CommonFunctions();
$page = 'Properties';
$issub = 0;

if($client_name == null && $client_name != 'all' && $user_group != 'super_admin') {
    $issub = 1;
} elseif($client_name == null && $client_name != 'all' && $user_group == 'super_admin') {
    $issub = 2;
} 

$client_name = null;
$business_name = null;
$status = null;
$limit = null;
$start_date = null;
$end_date = null;
$property_city = null;
$property_state = null;
$property_zip = null;

//activity_logs
if (isset($_POST['filter'])) {
    $client_name = isset($_POST['client_name']) ? $_POST['client_name'] : null;
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : null;
    $property_city = isset($_POST['property_city']) ? $_POST['property_city'] : null;
    $property_state = isset($_POST['property_state']) ? $_POST['property_state'] : null;
    $property_zip = isset($_POST['property_zip']) ? $_POST['property_zip'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $limit = isset($_POST['limit'])  ? $_POST['limit'] : null;
    $start_date = null;
    $end_date = null;

    if ($_POST['start_date'] != NULL && $_POST['end_date'] != NULL) {
        $user_mg_end = $_POST['end_date'];
        $user_mg_start = $_POST['start_date'];

        $en_date = DateTime::createFromFormat('m/d/Y', $user_mg_end)->format('Y-m-d');
        $st_date = DateTime::createFromFormat('m/d/Y', $user_mg_start)->format('Y-m-d');

        $start_date = $st_date . ' 00:00:00';
        $end_date = $en_date . ' 23:59:59';
    }
} 

if (isset($_GET['remove_id']) && isset($_GET['remove_property'])) {
    var_dump($_GET['token']);
    if ($_GET['token'] == $_SESSION['FORM_SECRET']) { 
        $remove_id = $_GET['remove_id'];
        $api_id = $_GET['api_id'];
        $businessId = 0;
        $property_details = $CommonFunctions->getPropertyDetails($remove_id,'business_id');
        if(!empty($property_details['data'])) {
            $businessId = $property_details['data'][0]['business_id'];
        }

        $crm = new crm($api_id, $system_package);
        $response = $crm->deleteParent($businessId);
// var_dump($response);
        if($response == 200) {   
            $delete = $db->execDB("DELETE FROM exp_crm WHERE id='$remove_id'");
            if ($delete === true) {
                $success_msg = "CRM Property is deleted successfully.";
                $db->addLogs($user_name, 'SUCCESS',$user_group, $page, 'Delete CRM Property',$remove_id,'3001',$success_msg);
                //delete form user
                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg ."</strong></div>";
            } else {                    
                $success_msg = "CRM Property deleting is failed.";
                $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Delete CRM Property',$remove_id,'2009',$success_msg);
                $_SESSION['msg20'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$success_msg ."</strong></div>";
            }
        } else {
            $success_msg = "CRM Property deleting is failed. ".$response["data"]["message"];
            $db->addLogs($user_name, 'ERROR',$user_group, $page, 'Delete CRM Property',$remove_id,'2009',$success_msg);
            $_SESSION['msg20'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>" . $success_msg . "</strong></div>";
        }
    }
}

$propertyResult = $CommonFunctions->getProperties(1,$user_group,$user_name,$user_distributor,$property_city,$property_state,$property_zip,$start_date,$end_date,$limit,$client_name,$business_name,$status);

$query_results = $propertyResult['query_results'];
$clientArray = $propertyResult['clientArray'];
$businessArray = $propertyResult['businessArray'];
$cityArray = $propertyResult['cityArray'];
$stateArray = $propertyResult['stateArray'];
$zipArray = $propertyResult['zipArray'];
$clientApiArray = $propertyResult['client_api'];

// $api = $api_details['data'][0];
// var_dump($api);
$serviceTypes = null;
// $baseUrl = $api['api_url'] . '/api/v1_0';//'http://bi-development.arrisi.com/api/v1_0';
// //generating api call to get Token
// $apiUsername = $api['api_username'];//'dev_hosted_api_user';
// $apiPassword = $api['api_password'];//'development@123!';
// $baseUrl = $apiUrl.'/api/'.$apiVersion;
// //generating api call to get Token

// $data = json_encode(['username'=>$apiUsername, 'password'=>$apiPassword]);
// $tokenReturn = json_decode( $CommonFunctions->httpPost($baseUrl.'/token',$data,true),true);
// //generating api call to get Service Types
// if($tokenReturn['status'] == 'success') {
//     $token = $tokenReturn['data']['token'];
//     $serviceTypesReturn = json_decode($CommonFunctions->httpPost($baseUrl.'/service-types',$token),true);
//     if($serviceTypesReturn['status'] == 'success') {
//         $serviceTypes = $serviceTypesReturn['data'];
//     }
// }

?>
<style>
#live_camp .tablesaw-columntoggle-popup .btn-group > label {
    float: left !important;
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" />

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
                                        <button class="nav-link active" id="properties" data-bs-toggle="tab" data-bs-target="#properties-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Properties</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <?php if (isset($_SESSION['msg6'])) {
                                        echo $_SESSION['msg6'];
                                        unset($_SESSION['msg6']);
                                    } ?>
                                    <div div class="tab-pane fade show active" id="properties-tab-pane" role="tabpanel" aria-labelledby="properties" tabindex="0">
                                        <h1 class="head">Properties</h1>
                                        <div class="border card my-4">
                                            <!-- <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <span class="fs-5">Property Filters</span>
                                                </div>
                                            </div> -->
                                            <form method="post" class="row g-3 p-4">
                                                <div class="col-md-3">
                                                    <label>Property Name</label>
                                                    <select id="business_name" name="business_name">
                                                        <option value='all' <?=(($business_name == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($businessArray)){
                                                                foreach($businessArray AS $key=>$value) {
                                                        ?>
                                                                <option value='<?=$key?>' <?=(($business_name != null && $business_name == $key) ? "selected" : "")?>><?=$value?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select> 
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Property City</label><br/>
                                                    <select id="property_city" name="property_city">
                                                        <option value='all' <?=(($property_city == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($cityArray)){
                                                                foreach($cityArray AS $key=>$value) {
                                                        ?>
                                                                <option value='<?=$key?>' <?=(($property_city != null && $property_city == $key) ? "selected" : "")?>><?=$value?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select> 
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Property State</label>
                                                    <select id="property_state" name="property_state">
                                                        <option value='all' <?=(($property_state == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($stateArray)){
                                                                foreach($stateArray AS $key=>$value) {
                                                        ?>
                                                                <option value='<?=$key?>' <?=(($property_state != null && $property_state == $key) ? "selected" : "")?>><?=$value?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select> 
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Property Zip</label>
                                                    <select id="property_zip" name="property_zip">
                                                        <option value='all' <?=(($property_zip == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($zipArray)){
                                                                foreach($zipArray AS $key=>$value) {
                                                        ?>
                                                                <option value='<?=$key?>' <?=(($property_zip != null && $property_zip == $key) ? "selected" : "")?>><?=$value?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select> 
                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <label for="radiobtns">Service Type</label>
                                                    <select name="service_type" id="service_type" class="span4 form-control">
                                                        < ?php if($serviceTypes != null){ ?>
                                                        <option value="0">Please select service type</option>
                                                        < ?php   foreach($serviceTypes as $serviceType){ ?>
                                                            <option value="< ?=$serviceType['id']?>">< ?=$serviceType['service_type']?></option>
                                                        < ?php
                                                            }
                                                        } else { ?>
                                                        <option value="0">Service type not found</option>
                                                        < ?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div> -->
                                                <div class="col-md-2">
                                                    <label>Status</label>
                                                    <select id="status" name="status">
                                                        <option value='all' <?=(($status == null) ? "selected" : "")?>>All</option>
                                                        <option value='Completed' <?=(($status != null && $status == "Completed") ? "selected" : "")?>>Completed</option> 
                                                        <option value='Processing' <?=(($status != null && $status == "Processing") ? "selected" : "")?>>Processing</option>
                                                        <option value='Pending' <?=(($status != null && $status == "Pending") ? "selected" : "")?>>Pending</option>                                                               
                                                        <option value='Failed' <?=(($status != null && $status == "Failed") ? "selected" : "")?>>Failed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Order Raise By</label>
                                                    <select id="client_name" name="client_name">
                                                        <option value='all' <?=(($client_name == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($clientArray)){
                                                                foreach($clientArray AS $key=>$value) {
                                                        ?>
                                                                <option value='<?=$key?>' <?=(($client_name != null && $client_name == $key) ? "selected" : "")?>><?=$value?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Order Raise </label>
                                                    <div>
                                                        <div class="col-md-1" style="display: inline-block;text-align: right;"> from </div> 
                                                        <div class="col-md-4" style="display: inline-block;">
                                                            <input class="inline_error inline_error_1 span2 form-control" id="start_date" name="start_date" type="text" value="<?php if (isset($user_mg_start)) {
                                                                                                                                                                                        echo $user_mg_start;
                                                                                                                                                                                } ?>" placeholder="<?=(isset($show_start) ? $show_start : 'mm/dd/yyyy')?>">
                                                        </div> 
                                                        <div class="col-md-1" style="display: inline-block;text-align: right;"> to </div> 
                                                        <div class="col-md-4" style="display: inline-block;">
                                                            <input class="inline_error inline_error_1 span2 form-control" id="end_date" name="end_date" type="text" value="<?php if (isset($user_mg_end)) {
                                                                                                                                                                                    echo $user_mg_end;
                                                                                                                                                                            } ?>" placeholder="<?=(isset($show_end) ? $show_end : 'mm/dd/yyyy')?>">

                                                        </div> 
                                                    </div>
                                                    <!-- /controls -->
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary" id="filter" name="filter">Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                        <br/>
                                        <table class="table table-striped" style="width:100%" id="property-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Unique Property ID</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property City</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property State</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property Zip</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Status</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Order Raise At</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Order Raise By</th>
                                                    <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Show Details</th> -->
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if($query_results['rowCount'] > 0) {
                                                        foreach($query_results['data'] AS $row){
                                                            $clientDetails = $CommonFunctions->getAdminUserDetails('user_name',$row['create_user'],'full_name');
                                                            if(!empty($clientDetails['data'])) {
                                                                $clientName = $clientDetails['data'][0]['full_name'];
                                                            }
                                                            
                                                            echo '<tr>
                                                            <td> '.$row['property_id'].' </td>
                                                            <td> '.$row['business_name'].' </td>
                                                            <td> '.$row['city'].' </td>
                                                            <td> '.$row['state'].' </td>
                                                            <td> '.$row['zip'].' </td>
                                                            <td> '.$row['status'].' </td>
                                                            <td> '.date('d-m-Y',strtotime($row['create_date'])).' </td>
                                                            <td> '.$clientName.' </td>';
                                                            // echo '<td><a href="javascript:void();" id="VIEWACC_'.$row['id'].'"  class="btn btn-small btn-info">
                                                            //         <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                                            //         $(document).ready(function() {
                                                            //             $(\'#VIEWACC_' .$row['id'].'\').easyconfirm({
                                                            //                 locale: {
                                                            //                     title: \'Property View\',
                                                            //                     text: \'Are you sure you want to view this property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            //                     button: [\'Cancel\', \' Confirm\'],
                                                            //                     closeText: \'close\'
                                                            //                 }
                                                            //             });
                                                            //             $(\'#VIEWACC_'.$row['id'].'\').click(function () {
                                                            //                 window.location = "?t=3&token='. $secret.'&property_edit&property_id='.$row['id'].'&client_id='.$_GET['edit_id'].'";
                                                            //             });
                                                            //         });
                                                            //         </script>
                                                            //     </td>';
                                                            
                                                                if($_SESSION['SADMIN'] == true) {
                                                                	echo '<td><a href="javascript:void();" id="remove_api_'.$row['id'].'"  class="btn btn-small btn-danger">
                                                                	<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
                                                                	<script type="text/javascript">
                                                                		$(document).ready(function() {
                                                                			$(\'#remove_api_'.$row['id'].'\').easyconfirm({locale: {
                                                                					title: \'Remove Property'.$clientApiArray[$row['id']].'\',
                                                                					text: \'Are you sure you want to remove this Property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                					button: [\'Cancel\',\' Confirm\'],
                                                                					closeText: \'close\'
                                                                			}});
                                                                			$(\'#remove_api_'.$row['id'].'\').click(function() {                                                                                        
                                                                				$("#overlay").css("display","block");
                                                                				window.location = "?token='.$secret.'&remove_id='.$row['id'].'&api_id='.$clientApiArray[$row['id']].'&remove_property"
                                                                			});
                                                                		});
                                                                	</script></td>';
                                                                }
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="6" style="text-align: center;">Properties not found</td>
                                                    </tr>
                                                    <?php
                                                    }	
                                                    ?>		
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
                <!-- /span12 -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /main-inner -->
</div>
<!-- /main -->

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<!-- Alert messages js-->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
<script>
    $(document).ready(function () {
        var randomNumber = Math.floor(Math.random() * 10000);
        $('#property-table').dataTable({
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                {
                extend: 'spacer',
                style: '',
                text: 'Download Data'
            },{
                extend: 'spacer',
                style: 'bar',
                text: ''
            },
            {
                extend: 'csv',
                title: 'property_additional_'+randomNumber,
                footer: true
            },
            {
                extend: 'excel',
                title: 'property_additional_'+randomNumber,
                footer: true
            },
            {
                extend: 'pdf',
                title: 'property_additional_'+randomNumber,
                footer: true
            },
            {
                extend: 'print',
                title: 'property_additional_'+randomNumber,
                footer: true
            }
        ]
        });

        $(function() {
			$("#start_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#start_date").attr("autocomplete", "off");

		$(function() {
			$("#end_date").datepicker({
				dateFormat: "mm/dd/yy",
				dayNamesMin: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
				maxDate: '0'
			});
		});
		$("#end_date").attr("autocomplete", "off");

        $(function() {
            $('#datepicker').datepicker();
        });
    });
</script>


