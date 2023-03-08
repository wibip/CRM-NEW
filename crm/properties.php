<?php
include 'header_new.php';

$CommonFunctions = new CommonFunctions();
$page = 'Properties';

// var_dump($client_name);
$issub = 0;

if($client_name == null && $client_name != 'all' && $user_type != 'SADMIN') {
    $issub = 1;
} elseif($client_name == null && $client_name != 'all' && $user_type == 'SADMIN') {
    $issub = 2;
} 

// $today = $show_end  = date('m/d/Y');
// $day_before_week = $show_start = date('m/d/Y', strtotime('-7 days'));

// $en_date = DateTime::createFromFormat('m/d/Y', $today)->format('Y-m-d');
// $st_date = DateTime::createFromFormat('m/d/Y', $day_before_week)->format('Y-m-d');

// $start_date = $st_date . ' 00:00:00';
// $end_date = $en_date . ' 23:59:59';

$client_name = null;
$business_name = null;
$status = null;
$limit = null;
$start_date = null;
$end_date = null;

//activity_logs
if (isset($_POST['filter'])) {
    $client_name = isset($_POST['client_name']) ? $_POST['client_name'] : null;
    $business_name = isset($_POST['business_name']) ? $_POST['business_name'] : null;
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
// var_dump($business_name);
$propertyResult = $CommonFunctions->getProperties($user_type,$user_name,$user_distributor,$start_date,$end_date,$limit,$client_name,$business_name,$status);

$query_results = $propertyResult['query_results'];
$clientArray = $propertyResult['clientArray'];
$businessArray = $propertyResult['businessArray'];


$serviceTypes = null;
$baseUrl = $apiUrl.'/api/'.$apiVersion;
//generating api call to get Token

$data = json_encode(['username'=>$apiUsername, 'password'=>$apiPassword]);
$tokenReturn = json_decode( $CommonFunctions->httpPost($baseUrl.'/token',$data,true),true);
//generating api call to get Service Types
if($tokenReturn['status'] == 'success') {
    $token = $tokenReturn['data']['token'];
    $serviceTypesReturn = json_decode($CommonFunctions->getServiceTypes($baseUrl.'/service-types',$token),true);
    if($serviceTypesReturn['status'] == 'success') {
        $serviceTypes = $serviceTypesReturn['data'];
    }
}
?>
<style>
#live_camp .tablesaw-columntoggle-popup .btn-group > label {
    float: left !important;
}
</style>

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
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <span class="fs-5">Property Filters</span>
                                                </div>
                                            </div>
                                            <form method="post" class="row g-3 p-4">
                                                <div class="col-md-4">
                                                    <label>Business Name</label>
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
                                                <div class="col-md-4">
                                                    <label for="radiobtns">Service Type</label>
                                                    <select name="service_type" id="service_type" class="span4 form-control">
                                                        <?php if($serviceTypes != null){ ?>
                                                        <option value="0">Please select service type</option>
                                                        <?php   foreach($serviceTypes as $serviceType){ ?>
                                                            <option value="<?=$serviceType['id']?>"><?=$serviceType['service_type']?></option>
                                                        <?php
                                                            }
                                                        } else { ?>
                                                        <option value="0">Service type not found</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Status</label>
                                                    <select id="status" name="status">
                                                        <option value='all' <?=(($status == null) ? "selected" : "")?>>All</option>
                                                        <option value='Completed' <?=(($status != null && $status == "Completed") ? "selected" : "")?>>Completed</option> 
                                                        <option value='Processing' <?=(($status != null && $status == "Processing") ? "selected" : "")?>>Processing</option>
                                                        <option value='Pending' <?=(($status != null && $status == "Pending") ? "selected" : "")?>>Pending</option>                                                               
                                                        <option value='Failed' <?=(($status != null && $status == "Failed") ? "selected" : "")?>>Failed</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
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
                                                <div class="col-md-4">
                                                    <div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="radiobtns">Period</label>
                                                            <input class="inline_error inline_error_1 span2 form-control" id="start_date" name="start_date" type="text" value="<?php if (isset($user_mg_start)) {
                                                                                                                                                                                        echo $user_mg_start;
                                                                                                                                                                                } ?>" placeholder="<?=(isset($show_start) ? $show_start : 'mm/dd/yyyy')?>">
                                                        </div> 
                                                        <div class="col-md-2"> to </div> 
                                                        <div class="col-md-5">
                                                            <input class="inline_error inline_error_1 span2 form-control" id="end_date" name="end_date" type="text" value="<?php if (isset($user_mg_end)) {
                                                                                                                                                                                    echo $user_mg_end;
                                                                                                                                                                            } ?>" placeholder="<?=(isset($show_end) ? $show_end : 'mm/dd/yyyy')?>">

                                                        </div> 
                                                        <input type="hidden" name="date3" />
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
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Client Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Business Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Status</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Show Details</th>
                                                    <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th> -->
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
                                                            <td> '.$clientName.' </td>
                                                            <td> '.$row['business_name'].' </td>
                                                            <td> '.$row['status'].' </td>';
                                                            echo '<td><a href="javascript:void();" id="VIEWACC_'.$row['id'].'"  class="btn btn-small btn-info">
                                                                <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                // $(document).ready(function() {
                                                                //     $(\'#VIEWACC_' .$row['id'].'\').easyconfirm({
                                                                //         locale: {
                                                                //             title: \'Property View\',
                                                                //             text: \'Are you sure you want to view this property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                //             button: [\'Cancel\', \' Confirm\'],
                                                                //             closeText: \'close\'
                                                                //         }
                                                                //     });
                                                                //     $(\'#VIEWACC_'.$row['id'].'\').click(function () {
                                                                //         window.location = "?t=3&token='. $secret.'&property_edit&property_id='.$row['id'].'&client_id='.$_GET['edit_id'].'";
                                                                //     });
                                                                // });
                                                                </script></td>';
                                                            
                                                            // if($_SESSION['SADMIN'] == true) {
                                                            // 	echo '<td><a href="javascript:void();" id="remove_api_'.$row['id'].'"  class="btn btn-small btn-danger">
                                                            // 	<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
                                                            // 	<script type="text/javascript">
                                                            // 		$(document).ready(function() {
                                                            // 			$(\'#remove_api_'.$row['id'].'\').easyconfirm({locale: {
                                                            // 					title: \'Remove Property\',
                                                            // 					text: \'Are you sure you want to remove this Property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                            // 					button: [\'Cancel\',\' Confirm\'],
                                                            // 					closeText: \'close\'
                                                            // 			}});
                                                            // 			$(\'#remove_api_'.$row['id'].'\').click(function() {                                                                                        
                                                            // 				$("#overlay").css("display","block");
                                                            // 				window.location = "?token='.$secret.'&id='.$id.'&remove_location&location_id='.$locationId.'&location_unique='.$locationUnique.'&business_id='.$businessID.'"
                                                            // 			});
                                                            // 		});
                                                            // 	</script></td>';
                                                            // }
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
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#property-table').dataTable();

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


