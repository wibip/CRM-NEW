
<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'header_top.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

require_once 'classes/CommonFunctions.php';
$CommonFunctions = new CommonFunctions();

require_once './classes/systemPackageClass.php';
$package_functions = new package_functions();

?> 
<head>
<meta charset="utf-8">
<title>Properties</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<!--Alert message css--> 
<link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
<!--    <link rel="stylesheet" href="css/bootstrapValidator.css"/> -->
<link rel="stylesheet" type="text/css" href="css/formValidation.css">
<link rel="stylesheet" href="css/tablesaw.css?v1.0">
<style>
.table_row {
    vertical-align: top !important;
}
</style>
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/locationpicker.jquery.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--table colimn show hide-->
<script type="text/javascript" src="js/tablesaw.js"></script>
<script type="text/javascript" src="js/tablesaw-init.js"></script>
<!--table colimn show hide-->
 <!--Encryption -->
<script type="text/javascript" src="js/aes.js"></script>
<script type="text/javascript" src="js/aes-json-format.js"></script>


<?php
include 'header.php';
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
$statusArray = [];

$propertyQuery = "SELECT id,property_id,business_name,status,create_user FROM exp_crm WHERE create_user IN (SELECT user_name FROM admin_users WHERE user_distributor='$user_distributor')";
$query_results = $db->selectDB($propertyQuery);
if ($query_results['rowCount'] > 0) {
    foreach ($query_results['data'] as $row) {
        $clientDetails = $CommonFunctions->getAdminUserDetails('user_name', $row['create_user'], 'full_name');
        if (!empty($clientDetails['data'])) {
            $clientName = $clientDetails['data'][0]['full_name'];
            $clientArray[$row['create_user']] = $clientName;
        }
        $businessArray[$row['business_name']] = $row['business_name'];
        $statusArray[$row['status']] = $row['status'];
    }
}

?>
<style>
#live_camp .tablesaw-columntoggle-popup .btn-group > label {
    float: left !important;
}
</style>

<div class="main" >
		<div class="main-inner" >
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
							<div class="widget-content">
								<div class="tabbable">
									<ul class="nav nav-tabs">
                                        <li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#active_properties" data-toggle="tab">Properties</a></li>
									</ul>
									
									<div class="tab-content">

                                        <?php if (isset($_SESSION['msg6'])) {
                                            echo $_SESSION['msg6'];
                                            unset($_SESSION['msg6']);
                                        } ?>
                                        <!-- ***************Activate Accounts List******************* -->
                                        <div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="active_properties">
										<h1 class="head">Active Properties</h1>	
                                        <div id="response_d1"></div>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													<h3>Active Properties</h3>
												</div>
                                                <div class="flex-form">
                                                    <div class="control-group">
                                                        <label>Client Name</label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select id="client_name" name="client_name">
                                                                <option value='all'>All</option>
                                                                <?php 
                                                                    if(!empty($clientArray)){
                                                                        foreach($clientArray AS $key=>$value) {
                                                                ?>
                                                                        <option value='<?=$key?>'><?=$value?></option>
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
                                                            <select id="client_name" name="business_name">
                                                                <option value='all'>All</option>
                                                                <?php 
                                                                    if(!empty($businessArray)){
                                                                        foreach($businessArray AS $key=>$value) {
                                                                ?>
                                                                        <option value='<?=$key?>'><?=$value?></option>
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
                                                            <select id="client_name" name="business_name">
                                                                <option value='all'>All</option>
                                                                <?php 
                                                                    if(!empty($statusArray)){
                                                                        foreach($statusArray AS $key=>$value) {
                                                                ?>
                                                                        <option value='<?=$key?>'><?=$value?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </select> 
                                                        </div> 
                                                    </div>
                                                    <button class="btn btn-primary">Filter</button>
                                                </div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
                                                    <div style="overflow-x:auto">
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
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
												<!-- /widget-content -->
											</div>
											<!-- /widget -->
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

<style type="text/css">

</style>
<!-- /widget -->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>

<script src="js/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#api_profile').multiSelect();  
    });
  </script>
