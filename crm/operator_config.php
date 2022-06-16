<?php ob_start();?>
<!DOCTYPE html>
<html lang="en">
 <?php
session_start();

include 'header_top.php';

/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';



/*classes & libraries*/
require_once 'classes/dbClass.php';
$db = new db_functions();

require_once 'classes/CommonFunctions.php';

?> 



<head>
<meta charset="utf-8">
<title>Manage Controller</title>

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

	<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>





<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>


    <?php

    include 'header.php';

    // TAB Organization
    if (isset($_GET['t'])) {

        $variable_tab = 'tab' . $_GET['t'];
        $$variable_tab = 'set';

    } else {

        $tab1 = "set";

    }

$ap_control_var = $db->setVal('ap_controller', 'ADMIN');


if($ap_control_var=='SINGLE'){
	
	$tab17="set";
	$tab1=NULL;
}



 ?>

<?php 
// Create product submit
	if(isset($_POST['create_ap_controller'])){
		

		if($_SESSION['FORM_SECRET']==$_POST['form_secret']) {//refresh validate
            //echo "dsdsd";

            $ap_con_name = trim($_POST['ap_con_name']);
            $brand = trim($_POST['brand']);
            $model = trim($_POST['model']);
            $desc = trim($_POST['desc']);
            $time_zone = trim($_POST['apc_time_zone']);
            $ip_address = $_POST['ip_address'];
            
            $api_profile = $_POST['api_profile_name'];
            $api_url = trim($_POST['api_url']);
 
            $api_url_se = trim($_POST['api_url_se']);
            
            $api_uname = $_POST['api_uname'];
            $api_pass = $_POST['api_pass'];
			$type = trim($_POST['type']);
			if($type=='FIREWALL CONTROLLER'){
			$api_profile = 'meraki1';
			}

			if($type=='DPSK'){
				$api_profile = 'CloudPath';
				}
			
			$api_key_se = trim($_POST['api_key_se']);

			$controller_description=array();

			$controller_description['api_key'] = $api_key_se;

			$controller_description_json= json_encode($controller_description);




            $query0 = "INSERT INTO  `exp_locations_ap_controller` (`time_zone`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_name`, `brand`, `model`, `description`, `ip_address`, `create_date`, `create_user`, `type`,`controller_description`)
			VALUES ('$time_zone','$api_profile','$api_url','$api_url_se','$api_uname','$api_pass','$ap_con_name', '$brand', '$model', '$desc', '$ip_address', NOW(), '$user_name', '$type', '$controller_description_json')";
            $ex0 = $db->execDB($query0);

            if ($ex0===true) {
            	
            	$create_log->save('',$message_functions->showMessage('ap_controller_create_success'),'');

                 $_SESSION['msg2'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_create_success')."</strong></div>";
            } else {
                $db->userErrorLog('2001', $user_name, 'script - ' . $script);
                
                $create_log->save('2001',$message_functions->showMessage('ap_controller_create_failed','2001'),'');

                $_SESSION['msg2'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_create_failed','2001')."</strong></div>";

            }

		}//key validation
						else{
                            $db->userErrorLog('2004', $user_name, 'script - '.$script);
                            $create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
							
							$_SESSION['msg2']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
							header('Location: operator_config.php?t=2');
							
							}	
			
	
	
	
	}//



	
	
	
	else if(isset($_GET['remove_controller'])){

		if($_SESSION['FORM_SECRET']==$_GET['token2']) {//refresh validate
			//echo "dsdsd";
	
			$remove_controller = trim($_GET['remove_controller']);
			
			
			$arc_q="INSERT INTO `exp_locations_ap_controller_archive`
					(`controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`create_date`,`create_user`,`last_update`,`archive_by`,`status`)
					SELECT `controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`create_date`,`create_user`,`last_update`,'$user_name','Delete'
					FROM `exp_locations_ap_controller`
					WHERE `id`='$remove_controller'";
			
			$arc_q_exe=$db->execDB($arc_q);
		
	
			$query0 = "DELETE FROM `exp_locations_ap_controller` WHERE `id` = '$remove_controller'";
			$ex0 = $db->execDB($query0);
	
			if ($ex0===true) {
				
				$create_log->save('',$message_functions->showMessage('ap_controller_remove_success'),'');
	
				$_SESSION['msg1'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_remove_success')."</strong></div>";
			} else {
				$db->userErrorLog('2001', $user_name, 'script - ' . $script);
				
				$create_log->save('2001',$message_functions->showMessage('ap_controller_remove_failed','2001'),'');
	
				$_SESSION['msg1'] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_remove_failed','2001')."</strong></div>";
	
			}
	
		}//key validation
		else{
			$db->userErrorLog('2004', $user_name, 'script - '.$script);
			$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
				
			$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
			header('Location: operator_config.php?t=1');
				
		}
			
	
	
	
	}//	
	
	
	
	
	else if(isset($_GET['edit_controller'])){
	
		if($_SESSION['FORM_SECRET']==$_GET['token2']) {//refresh validate
			//echo "dsdsd";
	
			$edit_controller = trim($_GET['edit_controller']);
	

			$get_wag_q="SELECT	* FROM `exp_locations_ap_controller` WHERE `id` = '$edit_controller'";
			
			$get_wag=$db->selectDB($get_wag_q);
			
			//while($edit_wag_r=mysql_fetch_assoc($get_wag)){
			foreach($get_wag['data'] AS $edit_wag_r){
				
				$edit_ap_control_name = $edit_wag_r['controller_name'];
				
				$edit_ap_brand = $edit_wag_r['brand'];
				
				$edit_ap_mobile = $edit_wag_r['model'];
				
				$edit_ap_ip_address = $edit_wag_r['ip_address'];

				$edit_wag_dis=$edit_wag_r['description'];
				$edit_time_zone=$edit_wag_r['time_zone'];

				
				
				$edit_api_profile = $edit_wag_r['api_profile'];
				
				$edit_wag_url=$edit_wag_r['api_url'];
				
				$edit_wag_url_se=$edit_wag_r['api_url_se'];
			
				$edit_wag_uname=$edit_wag_r['api_username'];
			
				$edit_wag_pass=$edit_wag_r['api_password'];

				$edit_wag_controller_description=json_decode($edit_wag_r['controller_description'],true);

				$edit_wag_type=$edit_wag_r['type'];


			
			}
			
			$edit_wag=2;

	
		}//key validation
		else{
			$db->userErrorLog('2004', $user_name, 'script - '.$script);
			
			$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');
	
			$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
			header('Location: operator_config.php?t=1');
	
		}
			
	
	
	
	}//
	

	if(isset($_POST['api_update'])){
		
		$tab1="set";
		$edit_wag=2;
	
		$wag_secret=$_POST['update_wag_secret'];
		if($wag_secret==$_SESSION['FORM_SECRET']){

			$update_wag_name=$_POST['edit_ap_controller_name'];
			
			$update_brand=$_POST['edit_brand'];
			
			$update_model=$_POST['edit_model'];
						
			
			$update_wag_dis=$_POST['edit_wag_dis'];
			$update_time_zone=$_POST['edit_apc_time_zone'];

			$update_ip_address=$_POST['edit_ip_address'];


			$edit_api_profile_name=$_POST['edit_api_profile_name'];

			$controll_type=$db->getValueAsf("SELECT `type` as f FROM `exp_locations_ap_controller` WHERE `controller_name`='$update_wag_name' LIMIT 1");
			if($controll_type=='FIREWALL CONTROLLER'){
			$edit_api_profile_name = 'meraki1';
			}

			if($controll_type=='DPSK'){
				$edit_api_profile_name = 'CloudPath';
				}
	
			$update_wag_url=trim($_POST['edit_wag_url']);
			
			$update_wag_url_se=$_POST['edit_wag_url_se'];
	
			$update_wag_uname=$_POST['edit_wag_uname'];
	
			$update_wag_pass=$_POST['edit_wag_pass'];

			$api_key_se = trim($_POST['edit_api_key_se']);

			$controller_description=array();

			$controller_description['api_key'] = $api_key_se;

			$controller_description_json= json_encode($controller_description);
			
			
			
			$archive_q="INSERT INTO `exp_locations_ap_controller_archive`
						(`controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_description`,`create_date`,`create_user`,`last_update`,`archive_by`,`status`)
						SELECT `controller_name`,`brand`,`model`,`description`,`time_zone`,`ip_address`,`api_profile`,`api_url`,`api_url_se`,`api_username`,`api_password`,`controller_description`,`create_date`,`create_user`,`last_update`,'$user_name','Update'
						FROM `exp_locations_ap_controller`
						WHERE `controller_name`='$update_wag_name'";
			$archive_exe=$db->execDB($archive_q);
	
			
			$update_wag_q="UPDATE `exp_locations_ap_controller` SET
															`time_zone`='$update_time_zone',
															`api_profile`='$edit_api_profile_name',
															`brand`='$update_brand',`model`='$update_model',
															`ip_address`='$update_ip_address',
															`description`='$update_wag_dis',
															`api_url`='$update_wag_url',
															`api_url_se`='$update_wag_url_se',
															`api_username`='$update_wag_uname',
															`api_password`='$update_wag_pass',
															`controller_description`='$controller_description_json'
															WHERE `controller_name`='$update_wag_name'";
	
			$update_wag=$db->execDB($update_wag_q);
	
	
			
			$edit_ap_control_name = $update_wag_name;
			
			$edit_ap_brand = $update_brand;
			
			$edit_ap_mobile = $update_model;
			
			$edit_ap_ip_address = $update_ip_address;
				
			
			
			$edit_wag_dis=$update_wag_dis;
			$edit_time_zone=$update_time_zone;

			
			
			$edit_api_profile = $edit_api_profile_name;
			
			$edit_wag_url=$update_wag_url;
			
			$edit_wag_url_se=$update_wag_url_se;
				
			$edit_wag_uname=$update_wag_uname;
				
			$edit_wag_pass=$update_wag_pass;

			$edit_wag_controller_description=json_decode($controller_description_json,true);

			$edit_wag_type=$db->getValueAsf("SELECT `type` as f
			FROM `exp_locations_ap_controller`
			WHERE `controller_name`='$update_wag_name'");
			
			if($update_wag===true){
				$create_log->save('3001',$message_functions->showMessage('ap_controller_update_success'),'');
				
				$_SESSION['msg1']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_update_success')."</strong></div>";
			}else{
				
				$create_log->save('2001',$message_functions->showMessage('ap_controller_update_failed','2001'),'');
				
				$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('ap_controller_update_failed','2001')."</strong></div>";
			}
		}else{
			$db->userErrorLog('2004', $user_name, 'script - '.$script);
			
			$create_log->save('2004',$message_functions->showMessage('transection_fail','2004'),'');

			$_SESSION['msg1']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";
			header('Location: operator_config.php?t=1');
		}
	}
?>

<?php
								
	//Form Refreshing avoid secret key/////
	$secret=md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;

/*function formatOffset($offset) {
	$hours = $offset / 3600;
	$remainder = $offset % 3600;
	$sign = $hours > 0 ? '+' : '-';
	$hour = (int) abs($hours);
	$minutes = (int) abs($remainder / 60);
	if ($hour == 0 AND $minutes == 0) {
		$sign = ' ';
	}
	return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');

}*/
?>


<div class="main">
		<div class="main-inner">
			<div class="container">
				<div class="row">
					<div class="span12">
						<div class="widget ">
							<div class="widget-header">
								<i class="icon-tags"></i>
								<h3>Manage AP Controller</h3>
							</div>
							
								<?php

										if(isset($_SESSION['msg17'])){
											echo $_SESSION['msg17'];
											unset($_SESSION['msg17']);

										}


												   if(isset($_SESSION['msg1'])){
													   echo $_SESSION['msg1']; 
													   unset($_SESSION['msg1']);
													   
													   
													  }

												   if(isset($_SESSION['msg2'])){
													   echo $_SESSION['msg2']; 
													   unset($_SESSION['msg2']);
													   
													   
													  }
											      ?>
							
							
							<!-- /widget-header -->
							<div class="widget-content">

								<div class="tabbable">
									<ul class="nav nav-tabs">
									
									<?php 
									
									
									
									
									?>
								<?php if($ap_control_var=='MULTIPLE'){?>
                                            <li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#viewap" data-toggle="tab">Active Controllers</a></li>
           									<li <?php if(isset($tab2)){?>class="active" <?php }?>><a href="#addap" data-toggle="tab">Add Controllers</a></li>
											
									<?php }
									
									else if($ap_control_var=='SINGLE'){?>		
											
											<li <?php if(isset($tab17)){?>class="active" <?php }?>><a href="#wifi_gateway" data-toggle="tab">AP Controller API Profile</a></li>

										<?php } ?>
									</ul>

									<br>

									<div class="tab-content">
									
<!-- ////////////////////////////////////////////////////////////////////////////////////////////// -->									
									
									
									<!-- ====================== wifi gateway configuration ============================ -->



									<div <?php if(isset($tab17)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="wifi_gateway">





									<!--	<div id="loc_thm_response"></div> -->







										<form id="save_wg" class="form-horizontal" >

											<fieldset>

											<input type="hidden" name="t" value="17">

											<?php

											echo '<input type="hidden" name="save_wag_secret" id="save_wag_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>





												<div class="control-group">

													<label class="control-label" for="approfile">WAG API profile</label>

													<div class="controls">

														<div class="input-prepend input-append span4">

															<select class="span4" name="ap_profile_name" id="ap_profile_name" required="required">

																<?php

																	$wag_ap_q="SELECT `description`,`wag_ap_name` FROM `exp_wag_ap_profile`";

																	/*$wag_ap=mysql_query($wag_ap_q);

																	while($wag_aps=mysql_fetch_assoc($wag_ap)) {*/
																	$wag_ap=$db->selectDB($wag_ap_q);

																	foreach($wag_ap['data'] AS $wag_aps){



																	echo'<option value="'.$wag_aps[wag_ap_name].'">'.$wag_aps[description].'</option>';



																	}

																?>

															</select>

															&nbsp;<input type="submit" name="save_wag"  value="Active" class="btn btn-primary">

														</div>

													</div>

												</div>

											</fieldset>

										</form>







										<hr>



										<form id="edit_wg" class="form-horizontal" >

											<input type="hidden" name="t" value="17">

											<?php

											echo '<input type="hidden" name="edit_wag_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>



											<fieldset>

												<div class="control-group">

													<label class="control-label" for="approfile">WAG API profile </label>

													<div class="controls">

														<div class="input-prepend input-append span4">

															<select class="span4" name="edit_ap_profile_name" id="edit_ap_profile_name" required="required">

																<?php

																$wag_ap_q="SELECT `description`,`wag_ap_name` FROM `exp_wag_ap_profile`";

																$wag_ap=$db->selectDB($wag_ap_q);
																	
																	foreach($wag_ap['data'] AS $wag_aps){

																	if($edit_wag_name==$wag_aps[wag_ap_name]){

																		$select="selected";

																		}else{

																		$select="";

																	}

																	echo'<option '.$select.' value="'.$wag_aps[wag_ap_name].'">'.$wag_aps[description].'</option>';



																}

																?>

															</select>

															&nbsp;<input type="submit" name="edit_wag"  value="Edit" class="btn btn-primary">

														</div>

													</div>

												</div>

											</fieldset>

										</form>





										<?php

										if($edit_wag==1){

										?>



										<form class="form-horizontal">



											<input type="hidden" name="t" value="17">

											<?php

											echo '<input type="hidden" name="update_wag_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>

											<fieldset>

												<div class="control-group">

													<label class="control-label" for="approfile">Profile name</label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text" readonly value="<?php echo $edit_wag_name;?>" name="edit_wag_name" class="span4" required="required">

														</div>



													</div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile">Profile description<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_dis;?>" name="edit_wag_dis" class="span4" required="required">

														</div>



													</div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile"> API URL<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_url;?>" name="edit_wag_url" class="span4" required="required">

														</div>



													</div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile"> API Username<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_uname;?>" name="edit_wag_uname" class="span4" required="required">

														</div>



													</div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile"> API Password<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_pass;?>" name="edit_wag_pass" class="span4 password_f" required="required">

														</div>



													</div>

												</div>

											</fieldset>

											<div class="form-actions">

												<button type="submit" name="wag_update" id="admin_update"

														class="btn btn-primary">Update</button>

												&nbsp; <strong><font color="#FF0000"></font><small> Required Field</small></strong>



											</div>

										</form>




											<hr>
										<?php

										}

										?>

									</div>									
									
									
									
									
									
									
									
									
									
									
<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
										<!-- create_product tab -->
										<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="viewap">


											

											      
											      
									<?php

										if($edit_wag==2){

										?>



										<form   onkeyup="admin_updatefn();" onchange="admin_updatefn();" class="form-horizontal" method="post" action="?t=1">



											<input type="hidden" name="t" value="1">

											<?php

											echo '<input type="hidden" name="update_wag_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>

											<fieldset>
											
											
												<div class="control-group">

													<label class="control-label" for="approfile">AP Controller Name<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text" readonly value="<?php echo $edit_ap_control_name;?>" name="edit_ap_controller_name" class="span4" required="required">

														</div>



													</div>

												</div>											
											


												<div class="control-group">

													<label class="control-label" for="approfile">Brand<font color="#FF0000"></font></label>

                                                        <div class="controls col-lg-5">

                                                        	<select class="span4" name="edit_brand" id="brand" required="required">
                                                                    <option value="">Select Brand</option>
																	<?php
															
																		$key_query = "SELECT brand FROM `exp_locations_ap_controller_model` ORDER BY brand";

																$query_results=$db->selectDB($key_query);
																	
																foreach($query_results['data'] AS $row){
																	$brand = $row['brand'];
																	
																	
																	if($edit_ap_brand==$brand){
																	
																		$selbrand='selected';
																	
																	}else{
																	
																		$selbrand='';
																	
																	}
																	
																	
									
																	echo '<option '.$selbrand.' value="'.$brand.'">'.$brand.'</option>';
																}
																?>
																</select>
                                                        
                                                          </div>

												</div>


												<div class="control-group">

													<label class="control-label" for="approfile">Model<font color="#FF0000"></font></label>

                                                        <div class="controls col-lg-5">

                                                        	<select class="span4" name="edit_model" id="model" required="required">
                                                                    <option value="">Select Model</option>
																	<?php
															
																		$key_query = "SELECT model FROM `exp_locations_ap_controller_model` ORDER BY model";
																	
								
																$query_results=$db->selectDB($key_query);
																	
																foreach($query_results['data'] AS $row){
																	$model = $row['model'];
																	
																	if($edit_ap_mobile==$model){
																		
																		$selmodel='selected';
																		
																	}else{
																		
																		$selmodel='';
																		
																	}
																	
							
																	echo '<option '.$selmodel.' value="'.$model.'">'.$model.'</option>';
																}
																?>
																</select>
                                                        
                                                          </div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile">Description<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_dis;?>" name="edit_wag_dis" class="span4" required="required">

														</div>



													</div>

												</div>

												<div class="control-group ed_ap_sw">
													<label class="control-label" for="mg_product_code_1">Time Zone<font color="#FF0000"></font></label>
													<div class="controls col-lg-5">
														<select class="span4" id="edit_apc_time_zone" name="edit_apc_time_zone" >
															<option value="">Select Time-zone</option>
															<?php

															$utc = new DateTimeZone('UTC');
															$dt = new DateTime('now', $utc);

															foreach(DateTimeZone::listIdentifiers() as $tz) {
																$current_tz = new DateTimeZone($tz);
																$offset =  $current_tz->getOffset($dt);
																$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																$abbr = $transition[0]['abbr'];
																if($edit_time_zone==$tz){
																	$select="selected";
																}else{
																	$select="";
																}

																echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
																// $select="";
															}
															// $select="";
															?>
														</select>
													</div>
												</div>
												

											<!--	<div class="control-group">

													<label class="control-label" for="approfile">IP Address<font color="#FF0000">*</font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php //echo $edit_ap_ip_address;?>" name="edit_ip_address" class="span4" required="required">

														</div>



													</div>

												</div>	-->


												<div class="control-group ed_ap_sw">

													<label class="control-label" for="approfile">AP Controller API Profile</label>

														<div class="controls col-lg-5">

															<select class="span4" name="edit_api_profile_name" id="edit_api_profile_name" >

																<?php

																	$wag_ap_q="SELECT `description`,`wag_ap_name` FROM `exp_wag_ap_profile`";

																	
																	$wag_ap=$db->selectDB($wag_ap_q);
																	
																	foreach($wag_ap['data'] AS $wag_aps){

																		
																		if($edit_api_profile==$wag_aps['wag_ap_name']){
																		
																			$selap='selected';
																		
																		}else{
																		
																			$selap='';
																		
																		}																		
																		
																		

																	echo'<option '.$selap.' value="'.$wag_aps['wag_ap_name'].'">'.$wag_aps['description'].'</option>';



																	}

																?>

															</select>

														

														</div>

												</div>



												<div class="control-group">

													<label class="control-label" for="approfile"> API URL<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_url;?>" name="edit_wag_url" class="span4" required="required">

														</div>



													</div>

												</div>

												<div class="control-group ed_firewall">

													<label class="control-label" for="approfile">  API Key</label>

													<div class="controls col-lg-5 form-group">

														

															<textarea   rows="5" id="edit_api_key_se" name="edit_api_key_se" class="span4 form-control" >
															<?php echo $edit_wag_controller_description['api_key'];?>
															</textarea>

													</div>

												</div>


												<div class="control-group ed_ap_sw">

													<label class="control-label" for="approfile"> API Secondary URL</label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_url_se;?>" name="edit_wag_url_se" class="span4">

														</div>



													</div>

												</div>


												<div class="control-group ed_ap_sw ed_dpsk">

													<label class="control-label" for="approfile"> API Username<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_uname;?>" name="edit_wag_uname" class="span4">

														</div>



													</div>

												</div>



												<div class="control-group ed_ap_sw ed_dpsk">

													<label class="control-label" for="approfile"> API Password<font color="#FF0000"></font></label>

													<div class="controls">

														<div class="input-prepend input-append ">

															<input type="text"  value="<?php echo $edit_wag_pass;?>" name="edit_wag_pass" class="span4 password_f" >

														</div>



													</div>

												</div>

											</fieldset>

											<div class="form-actions">

												<button disabled type="submit" name="api_update" id="admin_update" class="btn btn-primary">Update</button>
												<button type="button" class="btn btn-info inline-btn"  onclick="goto1();" class="btn btn-danger">Cancel</button> 

                                                                                                <script>

                                                                                                    function admin_updatefn() {
                                                                                                        //alert("fn");
                                                                                                        $("#admin_update").prop('disabled', false);
                                                                                                    }
                                                                                                    
                                                                                                    function goto1(url){              
                                                                                                    window.location = "?";              
                                                                                                    }

																									
																		var value = '<?php echo $edit_wag_type; ?>';
																		if(value=='FIREWALL CONTROLLER'){
																			$(".ed_ap_sw").css("display", "none");
																			$(".ed_firewall").css("display", "block");
																		}else if(value=='DPSK'){
																			$(".ed_ap_sw").css("display", "none");
																			$(".ed_firewall").css("display", "block");
																			$(".ed_dpsk").css("display", "block");
																			
																		}else{
																			$(".ed_firewall").css("display", "none");
																			$(".ed_ap_sw").css("display", "block");
																		}
																
                                                                                                </script>
												



											</div>

										</form>





										<?php

										}

										?>											      
											      
											      
											      
											      
											      

											<div class="widget widget-table action-table">
												<div class="widget-header">
													<i class="icon-th-list"></i>
													<h3>Active controller</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response ">
												<div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Controller</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">API Version</th>
																
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API URL</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>

															</tr>
														</thead>
														<tbody>
								
														<?php

															//	echo	$key_query = " SELECT id,product_code,description,time_gap,create_date,default_value FROM exp_products WHERE mno_id = '$user_distributor' ORDER BY description ";

                                                                 $key_query="SELECT c.controller_name,c.description,c.brand,c.model,c.brand,c.description,c.create_date,c.ip_address,c.api_url,c.api_profile,c.id,count(d.id) as assign_count FROM `exp_locations_ap_controller` c LEFT JOIN exp_mno_distributor d ON c.controller_name=d.ap_controller
                                                                            group by c.description,c.brand,c.model,c.brand,c.description,c.create_date,c.ip_address,c.api_url,c.api_profile,c.id";

																	$query_results=$db->selectDB($key_query);
																	
																foreach($query_results['data'] AS $row){
																		$controller_name = $row['controller_name'];
																		$description = $row['description'];
																		$brand = $row['brand'];
																		$model = $row['model'];
																		$create_date = $row['create_date'];
																		$ip_address = $row['ip_address'];
																		
																		$api_url = $row['api_url'];
																		$api_profile=$row['api_profile'];
																		
																		$id = $row['id'];
																		$assign_count = $row['assign_count'];
                                                                        echo '<tr>
																		<td> '.$controller_name.' </td>
																		<td> '.$api_profile.' </td>
																		
															    		<td> '.$api_url.' </td>';
																		
																		


                                                                            echo '<td><a href="javascript:void();" id="AP_'.$id.'"  class="btn btn-small btn-info">
																				<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
																				$(document).ready(function() {
																				$(\'#AP_'.$id.'\').easyconfirm({locale: {
																						title: \'AP Controller\',
																						text: \'Are you sure you want to edit this AP Controller?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																						button: [\'Cancel\',\' Confirm\'],
																						closeText: \'close\'
																					     }});
																					$(\'#AP_'.$id.'\').click(function() {
																						window.location = "?token2='.$secret.'&t=1&edit_controller='.$id.'"
																					});
																					});
																				</script></td>';
            		
            		
                                                                        /*$query_con1 = "SELECT d.id FROM exp_mno_distributor d WHERE `ap_controller` = '$controller_name'";
                                                                        $query_results=$db->selectDB($query_con1);
                                                                        $num_rows = $query_results['rowCount'];*/

                                                                        if($assign_count==0){
                                                                        	
	            															echo '<td><a href="javascript:void();" id="AP_R_'.$id.'"  class="btn btn-small btn-danger">
																			<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">
	                                                                            $(document).ready(function() {
	                                                                            $(\'#AP_R_'.$id.'\').easyconfirm({locale: {
	                                                                                    title: \'AP Controller\',
	                                                                                    text: \'Are you sure you want to remove this AP Controller?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
	                                                                                    button: [\'Cancel\',\' Confirm\'],
	                                                                                    closeText: \'close\'
	                                                                                     }});
	                                                                                $(\'#AP_R_'.$id.'\').click(function() {
	                                                                                    window.location = "?token2='.$secret.'&t=1&remove_controller='.$id.'"
	                                                                                });
	                                                                                });
	                                                                            </script></td>';
            															
                                                                        }
                                                                        else{
                                                                        	
                                                                        	
                                                                        	echo '<td><a class="btn btn-small btn-warning" disabled ><i class="icon icon-lock"></i>&nbsp;Remove</a></td>';
                                                                        	 
                                                                        	
                                                                        	//echo '';
                                                                        }
            		
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
										</div><!-- /over product tab -->

                                        <!-- assign_product tab -->
										<div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="addap">
											<form autocomplete="off" onkeyup="create_ap_controllerfn();" onchange="create_ap_controllerfn();"  id="create_ap_controller_form" name="create_ap_controller_form" method="post" class="form-horizontal" action="?t=2">
												<fieldset>
													<div id="response_d3">

											  	</div>
											  	<?php 
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>	

													<?php 
														echo '<input type="hidden" name="create_user" id="create_user" value="'.$user_distributor.'" />';
													?>	
													<div class="control-group">
													
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Type<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">

                                     								<select class="span4 form-control" name="type" id="type" >
                                                                    <option value="">Select Type</option>
																	<option value="AP">AP Controller</option>
																	<option value="SW">SW Controller</option>
																	<option value="FIREWALL CONTROLLER">Firewall Controller</option>
																	<option value="DPSK">DPSK Controller</option>
																</select>
                                                        
                                                          </div>
                                                    </div>													
														
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Controller Name<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="ap_con_name" name="ap_con_name" type="text">
                                                        </div>
                                                    </div>
														
														
													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Brand<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">

                                     								<select class="span4 form-control" name="brand" id="brand" >
                                                                    <option value="">Select Brand</option>
																	<?php
															
																		$key_query = "SELECT brand FROM `exp_locations_ap_controller_model` ORDER BY brand";
																	
																$query_results=$db->selectDB($key_query);
																foreach($query_results['data'] AS $row){
																	$brand = $row['brand'];									
									
																	echo '<option value="'.$brand.'">'.$brand.'</option>';
																}
																?>
																</select>
                                                        
                                                          </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
 													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Model<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">

                                                        	<select class="span4 form-control" name="model" id="model">
                                                                    <option value="">Select Model</option>
																	<?php
															
																		$key_query = "SELECT model FROM `exp_locations_ap_controller_model` ORDER BY model";
																	
								
																$query_results=$db->selectDB($key_query);
																foreach($query_results['data'] AS $row){
																	$model = $row[model];									
							
																	echo '<option value="'.$model.'">'.$model.'</option>';
																}
																?>
																</select>
                                                        
                                                          </div>
                                                    </div>                                                   

													<div class="control-group">
                                                        <label class="control-label" for="mg_product_code_1">Description<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <input class="span4 form-control" id="desc" name="desc" type="text" >
                                                        </div>
                                                    </div>

													<div class="control-group ap_sw">
                                                        <label class="control-label" for="mg_product_code_1">Time Zone<font color="#FF0000"></font></label>
                                                        <div class="controls col-lg-5 form-group">
                                                            <select class="span4 form-control" id="apc_time_zone" name="apc_time_zone" >
																<option value="">Select Time-zone</option>
																<?php

																$utc = new DateTimeZone('UTC');
																$dt = new DateTime('now', $utc);

																foreach(DateTimeZone::listIdentifiers() as $tz) {
																	$current_tz = new DateTimeZone($tz);
																	$offset =  $current_tz->getOffset($dt);
																	$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																	$abbr = $transition[0]['abbr'];

																	echo '<option  value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';
																	// $select="";
																}
																// $select="";
																?>
															</select>
                                                        </div>
                                                    </div>

                                                  
                                                    
                          
                                                    
                                         

												<div class="control-group ap_sw">

													<label class="control-label" for="approfile">AP Controller API Profile</label>

														<div class="controls col-lg-5 form-group">

															<select class="span4 form-control" name="api_profile_name" id="api_profile_name" >

																<?php

																	$wag_ap_q="SELECT `description`,`wag_ap_name` FROM `exp_wag_ap_profile`";

																	$wag_ap=$db->selectDB($wag_ap_q);

																	foreach($wag_ap['data'] AS $wag_aps){



																	echo'<option value="'.$wag_aps['wag_ap_name'].'">'.$wag_aps['description'].'</option>';



																	}

																?>

															</select>

														

														</div>

													</div>
													
													
													



												<div class="control-group">

													<label class="control-label" for="approfile">  API URL<font color="#FF0000"></font></label>

													<div class="controls col-lg-5 form-group">

														

															<input type="text"  name="api_url" id="api_url" class="span4 form-control" >

														



													</div>

												</div>

												<div class="control-group firewall">

													<label class="control-label" for="approfile">  API Key</label>

													<div class="controls col-lg-5 form-group">

														

															<textarea rows="5" id="api_key_se" name="api_key_se" class="span4 form-control" >

															</textarea>

													</div>

												</div>


												<div class="control-group ap_sw">

													<label class="control-label" for="approfile">  API Secondary URL</label>

													<div class="controls col-lg-5 form-group">

														

															<input type="text"  name="api_url_se" id="api_url_se" class="span4 form-control" >

														

													</div>

												</div>



												<div class="control-group ap_sw dpsk">

													<label class="control-label" for="approfile"> API Username<font color="#FF0000"></font></label>

													<div class="controls col-lg-5 form-group">

														

															<input autocomplete="off" type="text"  name="api_uname" id="api_uname" class="span4 form-control">

														



													</div>

												</div>



												<div class="control-group ap_sw dpsk">

													<label class="control-label" for="approfile"> API Password<font color="#FF0000"></font></label>

													<div class="controls col-lg-5 form-group">

														

															<input autocomplete="off" type="text"  name="api_pass" id="api_pass" class="span4 form-control password_f">

														



													</div>

												</div>
													

												
													
													
													<div class="form-actions">
														<button disabled type="submit" name="create_ap_controller" id="create_ap_controller"
																class="btn btn-primary">Save</button>
																
																
																<script>
                                                                                                                                    function create_ap_controllerfn() {
                                                                                                                                        //alert("fn");
                                                                                                                                        $("#create_ap_controller").prop('disabled', false);
                                                                                                                                    }


														        $('#type').on('change', function() {
																		var value = $(this).val();
																		var bootstrapValidator = $('#create_ap_controller_form').data('bootstrapValidator');

																		if(value=='FIREWALL CONTROLLER'){
																			$(".ap_sw").css("display", "none");
																			$(".firewall").css("display", "block");

																			bootstrapValidator.enableFieldValidators('apc_time_zone', false);
																			bootstrapValidator.enableFieldValidators('api_uname', false);
																			bootstrapValidator.enableFieldValidators('api_pass', false);

																			bootstrapValidator.enableFieldValidators('api_key_se', true);
																		
																		}else if(value=='DPSK'){
																			$(".ap_sw").css("display", "none");
																			$(".firewall").css("display", "block");
																			$(".dpsk").css("display", "block");

																			bootstrapValidator.enableFieldValidators('apc_time_zone', false);
																			bootstrapValidator.enableFieldValidators('api_uname', true);
																			bootstrapValidator.enableFieldValidators('api_pass', true);

																			bootstrapValidator.enableFieldValidators('api_key_se', true);
																			
																		
																		}else{
																			$(".firewall").css("display", "none");
																			$(".ap_sw").css("display", "block");

																			bootstrapValidator.enableFieldValidators('apc_time_zone', true);
																			bootstrapValidator.enableFieldValidators('api_uname', true);
																			bootstrapValidator.enableFieldValidators('api_pass', true);

																			bootstrapValidator.enableFieldValidators('api_key_se', false);
																		}
																});
                                                                                                                                    
                                                                                                                                   
                                                                                                                                </script>													
	                                                </div>	
												</fieldset>
											</form>

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
    
    
<?php
include 'footer.php';
?>




<script type="text/javascript" src="js/formValidation.js"></script>
<script type="text/javascript" src="js/bootstrapValidator.js"></script>

<script type="text/javascript">
	$('#assign_product_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ap_con_name: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                brand : {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                model: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                desc : {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                apc_time_zone: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                api_url: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				api_key_se: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                api_uname : {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                api_pass: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });
</script>



<script type="text/javascript">
	$('#create_ap_controller_form').bootstrapValidator({
            framework: 'bootstrap',
            excluded: ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                ap_con_name : {
                    validators: {
						<?php echo $db->validateField('notEmpty'); ?>,
						remote: {
                            message: '<p>Controller Name already exists</p>',
                            method: 'POST',
                            url: 'ajax/validate_apcontroller.php',
                        }
						
									
                    }
                },
                brand: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                model : {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                desc: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				apc_time_zone: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				
                api_url: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				api_key_se: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                api_uname : {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                api_pass: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        });
</script>

<!--    <script>
        $(document).ready(function() {
            $('#create_product_form')
                .formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        num1: {
                            validators: {
                                notEmpty: {
                                    message: 'Please provide the Social Security number'
                                },
                                regexp: {
                                    regexp: /^(?!(000|666|9))\d{3}(?!00)\d{2}(?!0000)\d{4}$/,
                                    message: 'The format of your num1 is invalid. It should be XXXXXXXXX with no dashes'
                                }
                            }
                        },
                        num2: {
                            // Disable validators
                            enabled: false,
                            validators: {
                                notEmpty: {
                                    message: 'Or the Drivers License number'
                                },
                                stringLength: {
                                    min: 8,
                                    max: 20,
                                    message: 'The Drivers License number must be more than 8 and less than 20 characters long'
                                }
                            }
                        }
                    }
                })
                .on('keyup', '[name="num1"], [name="num2"]', function(e) {
                    var num2 = $('#create_product_form').find('[name="num2"]').val(),
                        num1           = $('#create_product_form').find('[name="num1"]').val(),
                        fv            = $('#create_product_form').data('formValidation');

                    switch ($(this).attr('name')) {
                        // User is focusing the num1 field
                        case 'num1':
                            fv.enableFieldValidators('num2', num1 === '').revalidateField('num2');

                            if (num1 && fv.getOptions('num1', null, 'enabled') === false) {
                                fv.enableFieldValidators('num1', true).revalidateField('num1');
                            } else if (num1 === '' && num2 !== '') {
                                fv.enableFieldValidators('num1', false).revalidateField('num1');
                            }
                            break;

                        // User is focusing the drivers license field
                        case 'num2':
                            if (num2 === '') {
                                fv.enableFieldValidators('num1', true).revalidateField('num1');
                            } else if (num1 === '') {
                                fv.enableFieldValidators('num1', false).revalidateField('num1');
                            }

                            if (num2 && num1 === '' && fv.getOptions('num2', null, 'enabled') === false) {
                                fv.enableFieldValidators('num2', true).revalidateField('num2');
                            }
                            break;

                        default:
                            break;
                    }
                });
        });
    </script>
   
-->
<!-- Alert messages js-->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>


<!-- 	<script src="js/bootstrap.js"></script>  -->
	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
 $(document).ready(function() { 
    $("#product_code").chained("#category");

    $("#create_ap_controller").easyconfirm({locale: {
		title: 'AP Controller',
		text: 'Are you sure you want to create this AP Controller?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#create_ap_controller").click(function() {
	});
  
  });
  </script>


	<script type="text/javascript">







  

  
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
  
</script>

    <script src="js/jquery.multi-select.js" type="text/javascript"></script>

    <script type="text/javascript">

        $( document ).ready(function() {

            //$('#my_select').multiSelect({ cssClass: "template",keepOrder: true  });
            $('#my_select').multiSelect();
            $('#my_select_assign').multiSelect();

        });

    </script>




</body>

</html>
