
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
<title>Operation Accounts</title>
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
$page = 'Operation Account';
// TAB Organization
if (isset($_GET['t'])) {
    $variable_tab = 'tab' . $_GET['t'];
    $$variable_tab = 'set';
} else {
    $tab8 = "set";
}

$accountArray = [];
$operationArray = [];


$account_name = isset($_POST['account_name']) ? $_POST['account_name'] : null;
$operation_name = isset($_POST['operation_name']) ? $_POST['operation_name'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

$key_query = "SELECT m.mno_description,m.mno_id, m.features,u.full_name, u.email, u.mobile , u.user_distributor, u.group
                FROM exp_mno m, admin_users u
                WHERE u.group = 'operation' AND u.user_distributor = m.mno_id AND u.is_enable ";

/* get values for filters before filtering */
$filter_results = $db->selectDB($key_query);
if ($filter_results['rowCount'] > 0) {
    foreach ($filter_results['data'] as $row) {
        $accountArray[$row['full_name']] = $row['full_name'];       
        $operationArray[$row['mno_description']] = $row['mno_description'];
    }
}

/* Add filtering */

if($account_name != null && $account_name != 'all') {
    $key_query .= " AND u.full_name='".$account_name."'";
}

if($operation_name != null && $operation_name != 'all') {
    $key_query .= " AND m.mno_description='".$operation_name."'";
}

if($status != null && $status != 'all') {
    $key_query .= " AND u.is_enable='".$status."'";
}

$key_query .= " ORDER BY m.id";

// echo $key_query;
$query_results = $db->selectDB($key_query);

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
                                        <li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#operation_list" data-toggle="tab">Operation Account</a></li>
									</ul>
									
									<div class="tab-content">

                                        <?php if (isset($_SESSION['msg6'])) {
                                            echo $_SESSION['msg6'];
                                            unset($_SESSION['msg6']);
                                        } ?>
                                        <!-- ***************Activate Accounts List******************* -->
                                        <div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="operation_list">
										<h1 class="head">Operation Accounts</h1>	
                                        <div id="response_d1"></div>
											<div class="widget widget-table action-table">
												<div class="widget-header">
													<h3>Operation Accounts</h3>
												</div>
                                                <form method="post">
                                                    <div class="flex-form">
                                                        <div class="control-group">
                                                            <label>Account Name</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select id="account_name" name="account_name">
                                                                    <option value='all' <?=(($account_name == null) ? "selected" : "")?>>All</option>
                                                                    <?php 
                                                                        if(!empty($accountArray)){
                                                                            foreach($accountArray AS $key=>$value) {
                                                                    ?>
                                                                            <option value='<?=$key?>' <?=(($account_name != null && $account_name == $key) ? "selected" : "")?>><?=$value?></option>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div> 
                                                        </div>
                                                        <div class="control-group">
                                                            <label>Operation Name</label>
                                                            <div class="controls col-lg-5 form-group">
                                                                <select id="operation_name" name="operation_name">
                                                                    <option value='all' <?=(($operation_name == null) ? "selected" : "")?>>All</option>
                                                                    <?php 
                                                                        if(!empty($operationArray)){
                                                                            foreach($operationArray AS $key=>$value) {
                                                                    ?>
                                                                            <option value='<?=$key?>' <?=(($operation_name != null && $operation_name == $key) ? "selected" : "")?>><?=$value?></option>
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
                                                                    <option value='all' <?=(($status != null && $status == "all") ? "selected" : "")?>>All</option>
                                                                    <option value='1' <?=(($status != null && $status == "1") ? "selected" : "")?>>Enable</option>                                                              
                                                                    <option value='0' <?=(($status != null && $status == "0") ? "selected" : "")?>>Disable</option>
                                                                    <option value='2' <?=(($status != null && $status == "2") ? "selected" : "")?>>Pending</option>  
                                                                </select> 
                                                            </div> 
                                                        </div>
                                                        <button class="btn btn-primary">Filter</button>
                                                    </div>
                                                </form>
												<!-- /widget-header -->
												<div class="widget-content table_response">
                                                    <div style="overflow-x:auto">
                                                    <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Account Name</th>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Operation</th>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email</th>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Mobile</th>
                                                                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        foreach ($query_results['data'] as $row) {
                                                                            $mno_description = $row['mno_description'];
                                                                            $mno_id = $row['mno_id'];
                                                                            $full_name = $row['full_name'];
                                                                            $email = $row['email'];
                                                                            $mobile = $row['mobile'];
                                                                            $user_distributor = $row['user_distributor'];
                                                                            $user_group = $row['user_group'];
                                                                            // $s= $row[s];
                                                                            // $is_enable= $row[is_enable];
                                                                            // $icomm_num=$row[verification_number];
                                                                            $api_profiles = json_decode($row['features']);
                                                                            $show_profile = "";
                                                                            foreach($api_profiles as $api_profile) {
                                                                                $profile = $db->getValueAsf("SELECT `api_profile` as f FROM `exp_locations_ap_controller` WHERE `id`=".$api_profile);
                                                                                $show_profile .= $profile."<br/>";
                                                                            }
                                                                            echo '<tr>
                                                                            <td class="table_row"> '.$full_name.' </td>
                                                                            <td class="table_row"> '.$mno_description.' </td>
                                                                            <td> '.$email.' </td>
                                                                            <td> '.$mobile.' </td>';
                                                                            echo '<td class="table_row"> '.

                                                                                //******************************** Clients ************************************
                                                                                '<a href="javascript:void();" id="VIEWCLIENTS_'.$mno_id.'"  class="btn btn-small btn-info">
                                                                                <i class="btn-icon-only icon-pencil"></i>&nbsp;View Clients</a><script type="text/javascript">
                                                                                $(document).ready(function() {
                                                                                    $(\'#VIEWCLIENTS_'.$mno_id.'\').easyconfirm({locale: {
                                                                                        title: \'View Clients\',
                                                                                        text: \'Are you sure you want to view related clients?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                        button: [\'Cancel\',\' Confirm\'],
                                                                                        closeText: \'close\'
                                                                                        }});

                                                                                    $(\'#VIEWCLIENTS_'.$mno_id.'\').click(function() {
                                                                                        window.location = "clients?show=clients&t=1&ud='.$user_distributor.'&ug='.$user_group.'"
                                                                                    });
                                                                                });

                                                                                </script></td>';
                                                                            echo '</tr>';
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

