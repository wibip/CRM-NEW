<?php
include 'header_new.php';
?>
<?php
$page = 'Properties';
// TAB Organization
if (isset($_GET['t'])) {
    $variable_tab = 'tab' . $_GET['t'];
    $$variable_tab = 'set';
} else {
    $tab8 = "set";
}

$clientArray = [];
$businessArray = [];


$client_name = isset($_POST['client_name']) ? $_POST['client_name'] : null;
$business_name = isset($_POST['business_name']) ? $_POST['business_name'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

$subQuery = "SELECT user_name FROM admin_users WHERE user_distributor='$user_distributor'";
if($client_name != null && $client_name != 'all') {
    $subQuery .= " AND full_name='".$client_name."'";
}

$propertyQuery = "SELECT id,property_id,business_name,status,create_user FROM exp_crm WHERE create_user IN (".$subQuery.")";

/* get values for filters before filtering */
$filter_results = $db->selectDB($propertyQuery);
if ($filter_results['rowCount'] > 0) {
    foreach ($filter_results['data'] as $row) {
        $clientDetails = $CommonFunctions->getAdminUserDetails('user_name', $row['create_user'], 'full_name');
        if (!empty($clientDetails['data'])) {
            $clientName = $clientDetails['data'][0]['full_name'];
            $clientArray[$row['create_user']] = $clientName;
        }
        $businessArray[$row['business_name']] = $row['business_name'];
    }
}

/* Add filtering */
if($business_name != null && $business_name != 'all') {
    $propertyQuery .= " AND business_name='".$business_name."'";
}

if($status != null && $status != 'all') {
    $propertyQuery .= " AND status='".$status."'";
}

$query_results = $db->selectDB($propertyQuery);
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
                                            <form method="post">
                                                <div class="flex-form">
                                                    <div class="control-group">
                                                        <label>Client Name</label>
                                                        <div class="controls col-lg-5 form-group">
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
                                                    </div>
                                                    <div class="control-group">
                                                        <label>Business Name</label>
                                                        <div class="controls col-lg-5 form-group">
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
                                                    </div>
                                                    <div class="control-group">
                                                        <label>Status</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select id="status" name="status">
                                                                <option value='all' <?=(($status == null) ? "selected" : "")?>>All</option>
                                                                <option value='Completed' <?=(($status != null && $status == "Completed") ? "selected" : "")?>>Completed</option> 
                                                                <option value='Processing' <?=(($status != null && $status == "Processing") ? "selected" : "")?>>Processing</option>
                                                                <option value='Pending' <?=(($status != null && $status == "Pending") ? "selected" : "")?>>Pending</option>                                                               
                                                                <option value='Failed' <?=(($status != null && $status == "Failed") ? "selected" : "")?>>Failed</option>
                                                            </select> 
                                                        </div> 
                                                    </div>
                                                    <button class="btn btn-primary">Filter</button>
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
                                                    // $propertyQuery = "SELECT id,property_id,business_name,status,create_user FROM exp_crm WHERE create_user IN (SELECT user_name FROM admin_users WHERE user_distributor='$user_distributor')";
                                                    // $query_results = $db->selectDB($propertyQuery);
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

    <script>
    $(document).ready(function () {
        $('#property-table').dataTable();
    });
</script>


