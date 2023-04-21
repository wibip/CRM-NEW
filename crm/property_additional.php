<?php
include 'header_new.php';

require_once 'classes/AdditionalInfo.php';
$AdditionalInfo = AdditionalInfo;

$CommonFunctions = new CommonFunctions();
$page = 'Properties Additional';
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

$propertyResult = $CommonFunctions->getProperties(2,$user_group,$user_name,$user_distributor,$property_city,$property_state,$property_zip,$start_date,$end_date,$limit,$client_name,$business_name,$status);

$query_results = $propertyResult['query_results'];
$clientArray = $propertyResult['clientArray'];
$businessArray = $propertyResult['businessArray'];
$cityArray = $propertyResult['cityArray'];
$stateArray = $propertyResult['stateArray'];
$zipArray = $propertyResult['zipArray'];
$clientApiArray = $propertyResult['client_api'];

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
                                        <button class="nav-link active" id="properties" data-bs-toggle="tab" data-bs-target="#properties-tab-pane" type="button" role="tab" aria-controls="operators" aria-selected="true">Property Additional Info</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <?php if (isset($_SESSION['msg6'])) {
                                        echo $_SESSION['msg6'];
                                        unset($_SESSION['msg6']);
                                    } ?>
                                    <div div class="tab-pane fade show active" id="properties-tab-pane" role="tabpanel" aria-labelledby="properties" tabindex="0">
                                        <h1 class="head">Property Additional Info</h1>
                                        <div class="border card my-4">
                                            <div class="border-bottom card-header p-4">
                                                <div class="g-3 row">
                                                    <span class="fs-5">Property Filters</span>
                                                </div>
                                            </div>
                                            <form method="post" class="row g-3 p-4">
                                                <div class="col-md-3">
                                                    <label>Property Name</label>
                                                    <select id="business_name" name="business_name">
                                                        <option value='all' <?=(($business_name == null) ? "selected" : "")?>>All</option>
                                                        <?php 
                                                            if(!empty($businessArray)) {
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
                                                    <label>Property City</label>
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
                                                <div class="col-md-3">
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
                                                <div class="col-md-3">
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
                                                <div class="col-md-3">
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
                                                    <div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="radiobtns">Order Raise from</label>
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
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Property Name</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Wifi Info</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Product Info</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Qualifying Questions</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property City</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property State</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Property Zip</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Order Raise At</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Order Raise By</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Show Details</th>
                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // var_dump($query_results['data']);
                                                    if($query_results['rowCount'] > 0) {
                                                        $repeatCounter = 1;
                                                        foreach($query_results['data'] AS $row){
                                                            $clientDetails = $CommonFunctions->getAdminUserDetails('user_name',$row['create_user'],'full_name');
                                                            if(!empty($clientDetails['data'])) {
                                                                $clientName = $clientDetails['data'][0]['full_name'];
                                                            }
                                                            // var_dump($row['wifi_information']);
                                                            echo '<tr>
                                                            <td> '.$row['business_name'].' </td>
                                                            <td> <button type="button" class="btn btn-primary open_info" data-backdrop="static" data-bs-toggle="modal" id="open_wifi_info'.$repeatCounter.'" data-name="Wifi Information" data-infotype="wifi_information" data-id="'.$row['id'].'">View</button></td>
                                                            <td> <button type="button" class="btn btn-primary open_info" data-backdrop="static" data-bs-toggle="modal" id="open_product_info'.$repeatCounter.'" data-name="Product Information" data-infotype="product_information" data-id="'.$row['id'].'">View</button> </td>
                                                            <td> <button type="button" class="btn btn-primary open_info" data-backdrop="static" data-bs-toggle="modal" id="open_questions'.$repeatCounter.'" data-name="Qualifying Questions" data-infotype="qualifying_questions" data-id="'.$row['id'].'">View</button></td>
                                                            <td> '.$row['city'].' </td>
                                                            <td> '.$row['state'].' </td>
                                                            <td> '.$row['zip'].' </td>
                                                            <td> '.date('d-m-Y',strtotime($row['create_date'])).' </td>
                                                            <td> '.$clientName.' </td>';
                                                            echo '<td><a href="javascript:void();" id="VIEWACC_'.$row['id'].'"  class="btn btn-small btn-info">
                                                                    <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
                                                                    $(document).ready(function() {
                                                                        $(\'#VIEWACC_' .$row['id'].'\').easyconfirm({
                                                                            locale: {
                                                                                title: \'Property View\',
                                                                                text: \'Are you sure you want to view this property?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\', \' Confirm\'],
                                                                                closeText: \'close\'
                                                                            }
                                                                        });
                                                                        $(\'#VIEWACC_'.$row['id'].'\').click(function () {
                                                                            window.location = "?t=3&token='. $secret.'&property_edit&property_id='.$row['id'].'&client_id='.$_GET['edit_id'].'";
                                                                        });
                                                                    });
                                                                    </script>
                                                                </td>';
                                                            
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
                                                            $repeatCounter++;
                                                        }
                                                    } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="6" style="text-align: center;">Property Additional Info not found</td>
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

<!-- Modal -->
<div id="infoModal" class="modal fade" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
<!-- <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Alert messages js-->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
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

        $(".open_info").click(function(){
            var title = $(this).data('name');
            var orderId = $(this).data('id');
            var infoType = $(this).data('infotype');
            var AdditionalInfo = <?php echo json_encode($AdditionalInfo); ?>;
            console.log(AdditionalInfo);
            $('.modal-body').empty();
            $("#overlay").css("display","block");
            $.ajax({	
                type: "POST",
                url: "ajax/load_additional_informaions.php",
                data: {
                    order_id: orderId,
                    info_type: infoType
                },
                success: function(responseData) {
                    responseData = JSON.parse(responseData);
                    if(responseData['rowCount'] > 0){
                        var infoDetails = jQuery.parseJSON(responseData['data'][0][infoType]);
                        html = "";
                        html += '<table class="table">';
                        $.each(infoDetails, function(key,value) {
                            html += "<tr><td><strong>"+AdditionalInfo[key]+"</strong></td><td><strong>:</strong></td><td>" + value +"</td></tr>";
                        }); 
                        html += '</table>';
                        $('.modal-body').empty('').append(html);
                    } else {}
                    $("#overlay").css("display","none");
                },
                error: function() {
                    $("#overlay").css("display","none");
                }
            });

            $( ".modal-title" ).text(title);
            $("#infoModal").modal('show');
        });

        
    });
</script>


