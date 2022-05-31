<?php ob_start();?>
<!DOCTYPE html>

<html lang="en">

 <?php

session_start();

include 'header_top.php';

//require_once('db/config.php');

/* No cache*/

header("Cache-Control: no-cache, must-revalidate");
 error_reporting(E_ALL & E_NOTICE & E_WARNING);
/*classes & libraries*/

require_once 'classes/dbClass.php';

require_once 'classes/systemPackageClass.php';

$package_functions=new package_functions();

$db = new db_functions();



 $wag_ap_name=$db->getValueAsf("SELECT `settings_value` AS f FROM `exp_settings` WHERE `settings_code`='wag_ap_name' LIMIT 1");
//echo $wag_ap_name='NO_PROFILE';
 if($wag_ap_name!='NO_PROFILE') {
    include 'src/AP/' . $wag_ap_name . '/index.php';
   // $test = new ap_wag();
 }
?>

<head>

<meta charset="utf-8">

<title>Portal Configuration</title>



    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/fonts/css.css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery-ui-alert.css" type="text/css" />
    <link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/formValidation.css">
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

	
<style>
	td > .span2{
		width: 100% !important;
	}
	
	label span input {
            z-index: 999;
            line-height: 0;
            font-size: 50px;
            position: absolute;
            top: -2px;
            left: -700px;
            opacity: 0;
            filter: alpha(opacity = 0);
            -ms-filter: "alpha(opacity=0)";
            cursor: pointer;
            _cursor: hand;
            margin: 0;
            padding:0;
        }
</style>

    <!-- tool tip css -->

    <link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />
    <link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
    <script src="js/jquery.filestyle.js" type="text/javascript" charset="utf-8"></script>


    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>


<!-- on-off switch -->

    <link href="css/bootstrap-toggle.min.css" rel="stylesheet">

	<link rel="stylesheet" href="css/tablesaw.css">





<!--[if lt IE 9]>

      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->



	<!--table colimn show hide-->
	<script type="text/javascript" src="js/tablesaw.js"></script>
	<script type="text/javascript" src="js/tablesaw-init.js"></script>
    <script >
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>

	<?php

//require_once('db/config.php');

require_once 'classes/faqClass.php';


include 'header.php';


    ////////////Tab open////



    if(isset($_GET['t'])){



        $variable_tab='tab'.$_GET['t'];



        $$variable_tab='set';


    }else{



        //initially page loading///



        $tab0="set";







    }





    //echo $variable_tab;

    $base_portal_folder = trim($db->setVal('portal_base_folder','ADMIN'),"/");





    $base_url = trim($db->setVal('portal_base_url','ADMIN'),"/");


$post_data =array(
    'sync_type' => 'qos_new_sync',
    'user_distributor' => $user_distributor,
    'system_package'   => $system_package,
    'user_name'   => $user_name);

function httpPost($url,$data)
{

// A very simple PHP example that sends a HTTP POST to a remote site
//
 

//$fields_string = http_build_query($post);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// In real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close ($ch);

}

if($package_functions->getSectionType('VERTICAL_BUSINESS_TYPES',$system_package)=='ON'){
	
        $opt = json_decode($package_functions->getOptions('VERTICAL_BUSINESS_TYPES',$system_package));
    }

if(isset($_POST['submit_sys_con'])){//11



    if ($_SESSION['FORM_SECRET'] == $_POST['form_secret']) {



        $msg_max_ses = $db->escapeDB($_POST['msg_max_ses']);

        $max_ses_per_day = $db->escapeDB($_POST['max_ses_per_day']);

        //$title = $_POST['title'];

        $dist = $user_distributor;





        $query0 = "REPLACE INTO exp_settings (settings_name,description,category,settings_code,settings_value,distributor,create_date,create_user)

		values ('Max session per day','Max session per day','SYSTEM','max_sessions','$max_ses_per_day','$dist',now(),'$user_name'), ('Max session message','Max session message','SYSTEM','max_sessions_text','$msg_max_ses','$dist',now(),'$user_name')";

        $ex0 = $db->execDB($query0);



        if ($ex0 === true) {

            $_SESSION['msg112']="<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Session Limit Updated.</strong></div>";

        } else {

            $db->userErrorLog('2001', $user_name, 'script - '.$script);

            $_SESSION['msg112']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong> [2001] Transaction failed</strong></div>";

        }

    } else {

        $db->userErrorLog('2004', $user_name, 'script - '.$script);

        $_SESSION['msg112']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$message_functions->showMessage('transection_fail','2004')."</strong></div>";

    }



}//11




if(isset($_POST['property_update'])){
    if($_POST['property_secret']==$_SESSION['FORM_SECRET']){

    	$queryString = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";
    	$queryResult=$db->selectDB($queryString); 
    	if ($queryResult['rowCount']>0) {
    		foreach($queryResult['data'] AS $row){
    			$settingArr = json_decode($row['setting'],true);
    		}
    	}

    	$settingArr['headerImage'] = $_POST['headerImg'];
		$setting_val = [];
		$enable_verticle = array();
    	if($opt){
    	    $set_i=0;
    	    foreach ($opt as $set_key=>$set_val){
    	    	
    	    	if ($_POST['sup_num_en_'.$set_key] == 'on') {
    	    		array_push($enable_verticle, $set_key);
    	    	}
    	    	$setting_val[$set_key]=$_POST['sup_num_'][$set_i];
    	        
    	        $set_i++;
            }
        }
        $settingArr['verticals'] = $enable_verticle;
        $setting_val_json = json_encode($setting_val);

    	$setting = json_encode($settingArr);

    	$q = "UPDATE `exp_mno` SET setting='$setting' WHERE mno_id='$user_distributor'";
    	$q2 = "REPLACE INTO exp_settings (settings_name, description, category, settings_code, settings_value, distributor, create_date, create_user)
		VALUES ('support number','MNO verticel support number','SYSTEM','VERTICAL_SUPPORT_NUM','$setting_val_json','$user_distributor',NOW(),'$user_name')";
		    	//$e = mysql_query($q);
		        $e = $db->execDB($q);
		        $e2 = $db->execDB($q2);

    	if($e === true){
    		$show_msg=$message_functions->showMessage('config_operation_success');
        	$create_log->save('3002',$show_msg,"");
			$_SESSION['system1_msg']='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
    	}else{
    		$show_msg=$message_functions->showMessage('config_operation_failed','2002');
        	$create_log->save('2002',$show_msg,"");
			$_SESSION['system1_msg']='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
    	}

    }else{
        $msg30text=$message_functions->showMessage('transection_fail','2004');
        $db->userErrorLog('2004', $user_name, 'script - '.$script);
        $create_log->save('2004',$msg30text,'faq_edit');
        $_SESSION['msgy']="<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><strong>".$msg30text."</strong></div>";
    }
}

if ($opt) {
	$queryStringm = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";
    	$settingarrnew=$db->selectDB($queryStringm); 
    	if ($settingarrnew['rowCount']>0) {
    		foreach($settingarrnew['data'] AS $row){
    			$settingArrn = json_decode($row['setting'],true);
    		}
    	}
    $enable_verticlearr = $settingArrn['verticals'];
}

		//$archive_path=$db->setVal('LOGS_FILE_DIR','ADMIN');edit_id
if (isset($_GET['edit_id'])) {
	$id = $_GET['edit_id'];
	$key_query = "SELECT id,qos_id,qos_code,qos_name,`network_type`
                FROM exp_qos
                WHERE id='$id'";
    $query_results=$db->selectDB($key_query);
	foreach($query_results['data'] AS $row){
		$id = $row[id];
		$qos_id = $row[qos_id];
		$qos_code = $row[qos_code];
		$qos_name = $row[qos_name];
		$edit_qos_id="1";
		$network_type = $row[network_type];
	}
}


if (isset($_GET['qos_rm_id'])) {
						
	$id = $_GET['qos_rm_id'];

		$query_rm = "DELETE FROM `exp_qos` WHERE `id`='$id'";

		$remove_query=$db->execDB($query_rm);
						
			if($remove_query === true){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_remove_success',NULL)."</strong></div>";
					
			}
			else{

				$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_remove_fail',NULL)."</strong></div>";

			}
	
			
}

if (isset($_POST['qos_update'])) {
						
	$qos_profile = $_POST['qos_profile'];
	$qos_category = $_POST['qos_category'];
	$qos_description = $_POST['qos_description'];
	$qos_id = $_POST['qos_id'];

		$query_pro0 = "UPDATE
                  `exp_qos`
                SET
                  `qos_name` = '$qos_description',
                  `qos_code` = '$qos_profile',
                  `network_type` = '$qos_category'
                WHERE `qos_id` = '$qos_id' ";

			$query_pro=$db->execDB($query_pro0);
						
			if($query_pro === true){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_update_success',NULL)."</strong></div>";
					
			}
			else{

				$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_update_fail',NULL)."</strong></div>";

			}
	
			
		}

if (isset($_POST['qos_submit'])) {
						
		
			$qos_id=uniqid();
			$qos_profile = $_POST['qos_profile'];
			$qos_category = $_POST['qos_category'];
			$qos_description = $_POST['qos_description'];
			$max_sessions = "";
		    $max_sessions_alert  = "";
		    $tm_gap  = "";
		    $purg_time  = "";
		    $description  = "";
		    $description_up  = "";

			$archive_path = $_POST['archive_log_path'];

			$query_pro0 = "INSERT INTO `exp_qos` (`qos_id`,`max_session`,`session_alert`,`time_gap`,`purge_time`,`qos_name`,`qos_code`, `network_type`,`mno_id`,`create_date`,`create_user`,`sync_status`)
					   VALUES ('$qos_id','$max_sessions','$max_sessions_alert','$tm_gap','$purg_time','$qos_description','$qos_profile', '$qos_category', '$user_distributor', now(), '$user_name','$sync_id')";

			$query_pro=$db->execDB($query_pro0);
						
			if($query_pro === true){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_creat_success',NULL)."</strong></div>";
					
			}
			else{

				$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_creat_fail',NULL)."</strong></div>";

			}
	
			
		}




$secret=md5(uniqid(rand(), true));

$_SESSION['FORM_SECRET'] = $secret;



 ?>



<div class="main">

	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

						<div class="widget-header">

							<!-- <i class="icon-wrench"></i> -->

							<h3>Portal Configuration</h3>

						</div>
						
						<?php 
						
						if(isset($_SESSION['msgft'])){
						
							echo $_SESSION['msgft'];
						
							unset($_SESSION['msgft']);
						
						}
						


                         if(isset($_SESSION['msg30'])){
                            echo $_SESSION['msg30'];
                            unset($_SESSION['msg30']);

                                            }



						  if(isset($_SESSION['msg1'])){
								 echo $_SESSION['msg1'];
								  unset($_SESSION['msg1']);
								  
								  $isalert = 0;

						   					  }


                           if(isset($_SESSION['msg112'])){

                                 echo $_SESSION['msg112'];

                                 unset($_SESSION['msg112']);

                                            }
							if(isset($_SESSION['msg7'])){

                                 echo $_SESSION['msg7'];

                                 unset($_SESSION['msg7']);

                                            }


											   if(isset($_SESSION['msg'])){
												   echo $_SESSION['msg'];
												   unset($_SESSION['msg']);


						   					  }



											   if(isset($_SESSION['msgx'])){

												   echo $_SESSION['msgx'];

												   unset($_SESSION['msgx']);

						   					  }



											   if(isset($_SESSION['msgy'])){

												   echo $_SESSION['msgy'];

												   unset($_SESSION['msgy']);

						   					  }




											   if(isset($_SESSION['msgy1'])){

												   echo $_SESSION['msgy1'];

												   unset($_SESSION['msgy1']);

						   					  }




                                            if(isset($_SESSION['msg41'])){
                                                echo $_SESSION['msg41'];
                                                unset($_SESSION['msg41']);


                                            }




                                            if(isset($_SESSION['msg2'])){

                                                echo $_SESSION['msg2'];

                                                unset($_SESSION['msg2']);

                                            }



										if(isset($_SESSION['msg17'])){
											echo $_SESSION['msg17'];
											unset($_SESSION['msg17']);

										}



										if(isset($_SESSION['msg18'])){
											echo $_SESSION['msg18'];
											unset($_SESSION['msg18']);

                                    }
                                    
                                        if(isset($_SESSION['msg22'])){
											echo $_SESSION['msg22'];
											unset($_SESSION['msg22']);

										}

										?>

                        <div id="system1_response">
                       <?php
                       if(isset($_SESSION['system1_msg'])){
							echo $_SESSION['system1_msg'];
							unset($_SESSION['system1_msg']);
							}
						?> 
					   
					   
                        </div>
                        

						<!-- /widget-header -->



						<div class="widget-content">

							<div class="tabbable">

								<ul class="nav nav-tabs">

									<?php



										if($user_type == 'MNO'){

											?>

										
										<li <?php if(isset($tab0)){ ?>class="active" <?php } ?>><a href="#live_camp3" data-toggle="tab">Portal</a></li>

										<?php if(in_array("CONFIG_QOS",$features_array)){
										httpPost($camp_base_url . '/ajax/get_profile.php',$post_data);
										  ?>
										<li <?php if(isset($tab4)){ ?>class="active" <?php } ?>><a href="#qos_set" data-toggle="tab">QoS</a></li>
									<?php } ?>
										<?php if(in_array("CONFIG_PROPERTY_SETTINGS",$features_array)){ ?>
										<li <?php if(isset($tab23)){?>class="active" <?php } ?>><a href="#property_settings" data-toggle="tab">Property Settings</a></li>
									<?php } ?>
										  
                                            <?php 
										}

									?>

								</ul><br>

								<div class="tab-content">
								




										<!-- ====================== live_camp3 ====================== -->

									<div <?php if(isset($tab0) && $user_type == 'MNO'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp3">



										<h3>Admin Portal</h3>

										
										<div class="img_logo">

										<p>Max Size (160 x 30 px)</p>

										<div>



										

											<?php $url = '?type=mno_tlogo&id='.$user_distributor; ?>

											<form onkeyup="edit_profile_afn();" onchange="edit_profile_afn();" id="imageform" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>' >

												<label class="btn btn-primary">
																			Browse Image
																			<span><input type="file" name="photoimg" class="span4" id="photoimg" />
																			</span></label>

											</form>



											<?php

											$key_query = "SELECT theme_logo FROM exp_mno WHERE mno_id = '$user_distributor'";

											$query_results=$db->selectDB($key_query);

											
											foreach ($query_results['data'] AS $row) {

												$logo = $row[theme_logo];

											}

											?>

											<div id='img_preview'>

												<?php

												if(strlen($logo)){?>

												<img src="image_upload/logo/<?php echo $logo; ?>" border="0"  style="background-color:#ddd;width: 100%; max-width: 200px;" />

												<?php }

												else{

													echo 'No Images';

												}?>

											</div>

										</div>

									</div>



											<br><br>








										<form id="edit_profile_a" class="form-horizontal" method="post" >

											<?php



											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>


                                            <div id="edit_profile_a_hidden_input">
                                                <input type="hidden" name="header_logo_img" id="header_logo_img" value="<?php echo $logo; ?>">
                                            </div>
                                            <fieldset>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Portal Title</label>

													<div class="controls col-lg-5 form-group">

														

															<input class="form-control span4" id="main_title1" name="main_title1" type="text" value="<?php echo $db->getValueAsf("SELECT  theme_site_title AS f FROM exp_mno WHERE mno_id='$user_distributor'"); ?>">

														

													</div>

												</div>





												<div class="control-group">

													<label class="control-label" for="radiobtns">Short Title</label>

													<div class="controls col-lg-5 form-group">

														

															<input class="form-control span4" id="short_title1" name="short_title1" type="text" value="<?php echo $db->setVal("short_title",$user_distributor); ?>">

														

													</div>

												</div>







												<div class="control-group">

													<label class="control-label" for="radiobtns">Master Email</label>

													<div class="controls col-lg-5 form-group">



															<input class="form-control span4" id="master_email1" name="master_email1" type="text" value="<?php echo $db->setVal("email",$user_distributor); ?>">



													</div>

												</div>

                                                <div class="control-group">

<label class="control-label" for="radiobtns">NOC Email</label>

<div class="controls col-lg-5 form-group">
        <input class="form-control span4" id="noc_email1" name="noc_email1" type="text" value="<?php echo $package_functions->getOptions("TECH_BCC_EMAIL",$system_package); ?>">
</div>

</div>







											<!--	<div class="control-group">

													<label class="control-label" for="radiobtns">Ex Deny Redirect URL</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input class="span4" id="deni_url1" name="deni_url1" type="text" value="<?php //echo $db->setVal("deni_url",$user_distributor); ?>" required="required">

														</div>

													</div>

												</div>  -->











												<!--<div class="control-group">

													<label class="control-label" for="radiobtns">Campaign Portal Theme Color</label>

													<div class="controls">

														<div class="input-prepend input-append">

														<input class="span6" id="mno_header_color" name="mno_header_color" type="color" value="<?php /*echo $db->setVal("mno_color",$user_distributor); */?>" required="required">

														</div>

													</div>

												</div>

-->

<?php  $platformfh= $db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='ADMIN'") ; ?>

<?php if($platformfh!='N/A'){ ?>


<script type="text/javascript">

$(document).ready(function() {

	$('#dble_fo_na').hide();


    });


</script>



<?php } ?>

<div id="dble_fo_na">


                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Style Type</label>





                                                    <div class="controls form-group">

                                                        

                                                            <select class="span4" id="style_type1" name="style_type">

                                                                <option value="dark" <?php if($style_type == 'dark'){ echo 'selected'; } ?> > Dark Style </option>

                                                                <option value="light" <?php if($style_type == 'light'){ echo 'selected'; } ?> > Light Style </option>

                                                            </select>

                                                       

                                                    </div>



                                                </div>

















                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Theme Color </label>

                                                    <div class="controls form-group">

                                                        

                                                            <input class="span4 jscolor {hash:true}" id="mno_header_color" name="mno_header_color1" type="color" value="<?php echo strlen($camp_theme_color)<7?'#000000':$camp_theme_color; ?>">

                                                        

                                                    </div>

                                                </div>



                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Light Color </label>

                                                    <div class="controls form-group">

                                                        

                                                            <?php
                                                            $light_color=strlen($light_color)<7?'#000000':$light_color;
                                                            if($style_type == 'light'){

                                                                echo '<input class="span4 jscolor {hash:true}" id="light_color1" name="light_color" type="color" value="'.$light_color.'" >';

                                                            }else{

                                                                echo '<input class="span4 jscolor {hash:true}" id="light_color1" name="light_color" type="color" value="'.$light_color.'" disabled>';

                                                            }

                                                            ?>



                                                      

                                                    </div>

                                                </div>





                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Top Line Color </label>

                                                    <div class="controls form-group">

                                                       

                                                            <?php



                                                            if(strlen($top_line_color) <= 0){

                                                                ?>

                                                                <input class="span4 jscolor {hash:true}" id="top_line_color1" name="top_line_color1" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" disabled>

                                                                <br>

                                                                <input type="checkbox" id="top_che1"> Enable top line bar



                                                            <?php

                                                            }else {



                                                                ?>

                                                                <input class="span4 jscolor {hash:true}" id="top_line_color1" name="top_line_color1" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" >

                                                                <br>

                                                                <input type="checkbox" id="top_che1" checked> Enable top line bar



                                                            <?php

                                                            }

                                                            ?>





                                                     

                                                    </div>

                                                </div>

</div>



                                                <script>

                                                    $('#style_type1').on('change', function(){

                                                        var st =  $('#style_type1').val();

                                                        if(st == 'light'){

                                                            $('#light_color1').prop('disabled', false);

                                                            $('#style_img_div1').html('<img src="img/light.png" width="290" height="190">')

                                                        }else{

                                                            $('#light_color1').prop('disabled', true);

                                                            $('#style_img_div1').html('<img src="img/dark.png" width="290" height="190">')

                                                        }

                                                    });



                                                    $('#top_che1').on('change', function(){

                                                        var va = $(this).is(':checked');

                                                        if(va){

                                                            $('#top_line_color1').prop('disabled', false);

                                                        }else{

                                                            $('#top_line_color1').prop('disabled', true);

                                                            $('#top_line_color1').val("");

                                                        }

                                                    });

                                                </script>


                                                <div class="form-actions">

													<button disabled type="submit" id="portal_submit" name="portal_submit" class="btn btn-primary">Save</button>

													<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>
                                                <script>
                                                    function edit_profile_afn() {

                                                        $("#portal_submit").prop('disabled', false);
                                                    }

                                                </script>




											</fieldset>







										</form>













									</div>


									<!-- =================== aup ============================ -->

									<!-- <div class="tab-pane" id="aup"> -->
									<?php if(in_array("CONFIG_QOS",$features_array) || $system_package=='N/A'){ ?>
									<div <?php if(isset($tab4)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="qos_set">




										<h3>Override QoS<img data-toggle="tooltip" title="When creating a new property a product is set as the default for all residents. The product has a QoS and a Duration.The “Override QoS” feature allows the property admin to temporarily override the default product QoS for an individual account. As an example, a probation profile could be used to temporarily slow down the QoS due to late payment of rent" src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"></h3>


										<div id="response_d3">









										</div>

										<?php if ($edit_qos_id=="1") {
											$readonly="readonly";
										}

										?>


										<form id="qos-profile_submit" class="form-horizontal" method="post" action="?t=4">

											<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label class="" for="radiobtns">QoS Profile</label>
															<?php if($edit_qos_id==1){ echo '<div class="sele-disable span4" ></div>';} ?>
															<select name="qos_profile" class="form-control span4" id="qos_profile" <?php echo $readonly; ?> >

																	<option value="">Select available QoS Profile</option>

																	<?php
                                                                    
                                                                        $q1_1 = "SELECT qos_id,qos_code,qos_name
                                                                                                FROM exp_qos
                                                                                                WHERE network_type='VTENANT' AND mno_id='$user_distributor'";

                                                                        $query_results_1 = $db->selectDB($q1_1);
                                                                       
                                                                        foreach ($query_results_1['data'] AS $sub_row) {
                                                                            $sub_select = "";
                                                                            $sub_dis_code = $sub_row[qos_id];
                                                                            $sub_dis_g_id = $sub_row[qos_code];
                                                                            $sub_dis_name = $sub_row[qos_name];
                                                                           
                                                                            if ($qos_code == $sub_dis_g_id) {
                                                                                $sub_select = "selected";
                                                                            }

                                                                            echo "<option " . $sub_select . " value='" . $sub_dis_g_id . "'>" . $sub_dis_g_id . "</option>";
                                                                        }
                                                                        ?>

																	</select>
																</div>
                                                                    </div>
																<div class="controls col-lg-5 form-group" style="margin-top: -25px; margin-bottom: 15px; display: none;">


                                                                        <?php

                                                                        $json_sync_fields = $package_functions->getOptions('SYNC_PRODUCTS_FROM_AAA', $system_package);
                                                                        $sync_array = json_decode($json_sync_fields, true);

                                                                        ?>
                                                                        <style>
                                                                            @media (max-width: 520px){
                                                                                .qos-sync-button {
                                                                                    margin-bottom: 15px; !important;
                                                                                }
                                                                            }
                                                                            @media (min-width: 520px){
                                                                                .qos-sync-button {
                                                                                    margin-top: 20px; !important;
                                                                                    float:right;
                                                                                    margin-right: 22%;
                                                                                }
                                                                            }
                                                                        </style>

                                                                        <a <?php if ($sync_array['g_QOS_sync'] == 'display') {
                                                                            echo 'style="display: inline-block;padding: 6px 20px !important;"';
                                                                        } else {
                                                                            echo 'style="display:none"';
                                                                        } ?> onclick="gotoSync();"
                                                                             class="btn btn-primary qos-sync-button"
                                                                             style="align: left;"><i
                                                                                    class="btn-icon-only icon-refresh"></i>
                                                                            Sync</a>
                                                                        <div style="display: inline-block"
                                                                             id="sync_loader"></div>


											</div>
											<script type="text/javascript">
												 function gotoSync(){

								//var a = scrt_var.length;

								    
								        document.getElementById("sync_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
								        //window.location = "?t=5&refreshzone=1&ackey="+scrt_var;

								     $.ajax({
								        type: 'POST',
								        url: 'ajax/get_profile.php',
								        data: { sync_type: "qos_new_sync",user_distributor: "<?php echo $user_distributor; ?>",system_package: "<?php echo $system_package; ?>",user_name: "<?php echo $user_name; ?>" },
								        success: function(data) {

								 //alert(data); 
								            

								            $('#qos_profile').empty();
								            $("#qos_profile").append(data);


								            document.getElementById("sync_loader").innerHTML = "";

								        },
								         error: function(){
								             document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
								         }

								    });



        

								}   

											</script>
											<?php $array_qos_type= array('VT-Probation' => 'Probation',
																		"VT-Premium" => 'Premium'
											 ); 
											 ?>
											<div class="control-group">
														<div class="controls col-lg-5 form-group">
															<label class="" for="radiobtns">QoS Category</label>
															<select name="qos_category" class="form-control span4" id="qos_category">

																	 <option value="">Select Category</option>
																	 <?php
																	 foreach ($array_qos_type as $key => $value) {
																	 	if ($network_type==$key) {
																	 		$selected_qos="selected";
																	 	echo "<option ".$selected_qos." value=".$key.">".$value."</option>";
																	 	}
																	 	else{
																	 	echo "<option value=".$key.">".$value."</option>";	
																	 	}
																	 	
																	 }
																	 	 ?>
																	 	
																	  
															</select>

														</div>

											</div>
											<input class="form-control span4" id="qos_id" name="qos_id"  type="hidden" value="<?php echo $qos_id; ?>">

											<div class="control-group">


													<div class="controls col-lg-5 form-group">

													<label class="" for="radiobtns">Description</label>
														

															<input class="form-control span4" id="qos_description" name="qos_description"  type="text" value="<?php echo $qos_name; ?>">

														

													</div>

												</div>

												<div class="form-actions" style="border-top: 0px !important; ">

													
													<?php if ($edit_qos_id=="1") {?>
													<button type="submit" id="qos_update" name="qos_update" class="btn btn-primary">Update</button>

													<!-- <button type="reset" id="" name="" class="btn btn-primary">Cancel</button> -->

													<input type="button" value="Cancel" onclick="window.location='?t=4';" class="btn btn-primary" name="">
													<?php } else{?>
													<button type="submit" id="qos_submit" name="qos_submit" class="btn btn-primary">Save</button>
													<?php }?>

													<img id="system1_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>

										</form>


										<div class="widget tablesaw-widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3>Active Users</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" class="uppercase">QoS PROFILE</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Description</th>																
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Remove <img data-toggle="tooltip" title="If a QoS has been assigned and is in use by a property it cannot be removed. Please deactivate the QoS to enable removal." src="layout/ATT/img/help.png" style="width: 16px;margin-bottom: 6px;cursor: pointer;"></th>


															</tr>
														</thead>
														<tbody>

										<?php

											
											$key_query = "SELECT q.`id`,q.`qos_id`,q.`qos_code`,q.`qos_name`,`network_type` FROM exp_qos q
															WHERE q.`network_type` <> 'VTENANT' AND q.`mno_id`='$user_distributor'";											

											//echo $key_query;

											$query_results=$db->selectDB($key_query);
											foreach($query_results['data'] AS $row){
												$id = $row[id];
												$qos_code = $row[qos_code];
												$qos_name = $row[qos_name];
												$qos_id = $row[qos_id];

												$network_type = $row[network_type];
												$qos=$db->getValueAsf("SELECT qos_id as f FROM exp_qos_distributor WHERE qos_id='$qos_id'");
												

												/*$q_desc_get = "SELECT description FROM `admin_access_roles` WHERE access_role = '$access_role'";
												$query_results_a=mysql_query($q_desc_get);
												while($row1=mysql_fetch_array($query_results_a)){
													$access_role_desc = $row1[description];

												}*/


												echo '<tr>
												<td> '.$qos_code.' </td>
												<td> '.$qos_name.' </td>';
												/////////////////////////////////////////////

												echo '<td><a href="javascript:void();" id="APE_'.$id.'"  class="btn btn-small btn-primary">
												<i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><script type="text/javascript">
												$(document).ready(function() {
												$(\'#APE_'.$id.'\').easyconfirm({locale: {
														title: \'Edit User\',
														text: \'Are you sure you want to edit this QoS?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
														button: [\'Cancel\',\' Confirm\'],
														closeText: \'close\'
													     }});
													$(\'#APE_'.$id.'\').click(function() {
														window.location = "?token='.$secret.'&t=4&edit_id='.$id.'"
													});
													});
												</script></td>';
												if(strlen($qos)<1) {
												echo '<td><a href="javascript:void();" id="RU_'.$id.'"  class="btn btn-small btn-danger">
	                                            <i class="btn-icon-only icon-remove"></i>&nbsp;Remove</a><script type="text/javascript">
	                                            $(document).ready(function() {
	                                            $(\'#RU_'.$id.'\').easyconfirm({locale: {
	                                                    title: \'Remove User\',
	                                                    text: \'Are you sure you want to remove QoS?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
	                                                    button: [\'Cancel\',\' Confirm\'],
	                                                    closeText: \'close\'
	                                                     }});
	                                                $(\'#RU_'.$id.'\').click(function() {
	                                                    window.location = "?token='.$secret.'&t=4&qos_rm_id='.$id.'"
	                                                });
	                                                });
	                                            </script>';
	                                            }
												else{
													 echo '<td><a disabled href="javascript:void();" id="RU_'.$id.'"  class="btn btn-small btn-danger">
	                                            		<i class="btn-icon-only icon-remove"></i>&nbsp;Remove</a>'; 

														
												}
												echo '</td>';


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
									<?php }?>




										<div <?php if(isset($tab23)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="property_settings" >
										<form id="active_property_submitfn"  method="post" action="?t=23" class="form-horizontal" autocomplete="on">

											<br>
											<br>

											<?php 
												echo '<input type="hidden" name="property_secret" id="property_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
											 ?>

											<div class="control-group">
												<label class="control-label" for="radiobtns">Header Image</label>
												<div class="controls form-group">
													<select <?php if($opt){ echo 'style="margin-left: 45px"'; }?> id="headerImg" name="headerImg">

														<?php 

															$queryString = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";

													    	$queryResult=$db->selectDB($queryString); 
													    	if ($queryResult['rowCount']>0) {
													    		foreach($queryResult['data'] AS $row){
													    			$settingArr = json_decode($row['setting'],true);
													    		}
													    	}

														 ?>

															<option value="">Select a type</option>
															<option <?php if($settingArr['headerImage']!='NO'){ echo 'selected'; } ?> value="YES">ON</option>
															<option <?php if($settingArr['headerImage']=='NO'){ echo 'selected'; } ?> value="NO">OFF</option>
													</select>
												</div>
											</div>

											<?php

                                                    if($opt){
                                                        $sup_nums = json_decode($db->setVal('VERTICAL_SUPPORT_NUM',$user_distributor));
                                                        $sup_num = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package);
                                                        $i = 0;
                                                        $required = false;
                                                        foreach($opt as $key=>$value){
                                                            $value = $sup_nums->$key;
                                                            $ischeck = '';
                                                            $required = false;
                                                            if(in_array($key, $enable_verticlearr)){
                                                            	$ischeck = 'checked';
                                                            	$required = true;
                                                                //$value = $sup_num;
                                                            }
                                                            //echo $ischeck;
                                                            ?>
                                                            <div class="control-group">
                                                                <label class="control-label" for="sup_num_<?php echo $key;?>"><?php echo $key; ?>
                                                                	
                                                                </label>
                                                                <div class="controls form-group" >
                                                                	
                                                                	<input <?php echo $ischeck;?> id="sup_enable_<?php echo $key;?>" name="sup_num_en_<?php echo $key;?>" type="checkbox" onclick="changebuttons('<?php echo $key;?>',1)">
                                                                    <input value="<?php echo $value;?>" class="support_number" pattern="^(1-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$" maxlength="14" id="sup_num_<?php echo $key;?>" name="sup_num_[]" type="text" oninput="setCustomValidity('')"  autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            echo '<script type="text/javascript">
                                                            	
                                                            	$(document).ready(function () {
                                                            		
                                                            	
                                                            	});

                                                            	

                                                            	
                                                            	
                                                            </script>'?>
                                                            <script type="text/javascript">
                                                            	function changebuttons(key,n){
                                                            		var enable = '';
                                                        			if (n==1) {
                                                        				$("#property_update").removeClass("disabled");
                                                        				$("#property_update").prop('disabled', false);
                                                        		}

                                                        			enable=document.getElementById("sup_enable_"+key).value;
                                                        			if (enable=='on') {
                                                        				$("#sup_num_"+key).attr("required", "true");

                                                        			}else{
                                                        				$("#sup_num_"+key).attr("required", "false");
                                                        			}
                                                            	
                                                            	
                                                            							
                                                            	}
                                                            	
                                                            </script>

                                                            <?php
                                                            $i = $i +1;
                                                        }
                                                        ?>
                                                        <script>
                                                            $(document).ready(function () {
                                                                var firstnum;
                                                                $(".support_number").keypress(function (event) {
                                                                    var ew = event.which;
                                                                    //alert(ew);
                                                                    //if(ew == 8||ew == 0||ew == 46||ew == 45)
                                                                    //if(ew == 8||ew == 0||ew == 45)
                                                                    if (ew == 8 || ew == 0)
                                                                        return true;
                                                                    if (48 <= ew && ew <= 57)
                                                                        return true;
                                                                    return false;
                                                                });
                                                                $(".support_number").keydown(function (e) {
                                                                    var mac = $(this).val();
                                                                    var len = mac.length + 1;
                                                                    if (len == 2) {
                                                                        firstnum = mac;
                                                                    }
                                                                    console.log(e.keyCode);
                                                                    //console.log(firstnum);
                                                                    console.log('len '+ len);

                                                                    if ((e.keyCode == 8 && len == 8) || (e.keyCode == 8 && len == 4)|| (e.keyCode == 8 && len == 2)|| (e.keyCode == 8 && len == 6)|| (e.keyCode == 8 && len == 10)) {
                                                                        mac1 = mac.replace(/[^0-9]/g, '');


                                                                        //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                                        //console.log(valu);
                                                                        //$('#phone_num_val').val(valu);

                                                                    }
                                                                    else {
                                                                        if (firstnum == '1') {
                                                                         if (len == 2) {
                                                                            $(this).val(function () {
                                                                                return $(this).val().substr(0, 1) + '-' + $(this).val().substr(1, 3);
                                                                                //console.log('mac1 ' + mac);

                                                                            });
                                                                        }
                                                                        else if (len == 6) {
                                                                            $(this).val(function () {
                                                                                return $(this).val().substr(0, 5) + '-' + $(this).val().substr(5, 3);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }
                                                                        else if (len == 10) {
                                                                            $(this).val(function () {
                                                                                return $(this).val().substr(0, 9) + '-' + $(this).val().substr(9, 4);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }

                                                                        }
                                                                        else{
                                                                            if (len == 4) {
                                                                            $(this).val(function () {
                                                                                return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3, 3);
                                                                                //console.log('mac1 ' + mac);

                                                                            });
                                                                        }
                                                                        else if (len == 8) {
                                                                            $(this).val(function () {
                                                                                return $(this).val().substr(0, 7) + '-' + $(this).val().substr(7, 4);
                                                                                //console.log('mac2 ' + mac);

                                                                            });
                                                                        }
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                            ?>

											<div class="form-actions pd-zero-form-action">

												<button disabled type="submit" id="property_update" name="property_update" class="btn btn-primary">Save</button>

											</div>

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


	<script src="js/base.js"></script>
	<script src="js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">


 $(document).ready(function() {

    $("#product_code").chained("#category");

    $("#portal_submit").easyconfirm({locale: {
		title: 'Admin Portal',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#portal_submit").click(function() {

	});

	$("#submit_toc_btn").easyconfirm({locale: {
		title: 'Guest T&C',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#submit_toc_btn").click(function() {
		
	});

	$("#submit_arg1").easyconfirm({locale: {
		title: 'Activation T&C',
		text: 'Are you sure you want to update the terms and conditions?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#submit_arg1").click(function() {
		
	});

	$("#active_email_submit").easyconfirm({locale: {
		title: 'Activation Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#active_email_submit").click(function() {
		//getInfoBox('email','email_response');
	});

	$("#active_sup_email_submit").easyconfirm({locale: {
		title: 'Activation Email (Support)',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});

	$("#new_location_activated_sub").easyconfirm({locale: {
		title: 'New Location Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	

	$("#email_activated_sub").easyconfirm({locale: {
		title: 'Activation Confirmation Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});

	$("#active_user_email_submit").easyconfirm({locale: {
		title: 'User Activation Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});

	$("#active_property_submit").easyconfirm({locale: {
		title: 'Property Admin Activation',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	
	$("#active_sup_email_submit").click(function() {
		//getInfoBox('email','email_response');
	});
	
	$("#email_subject_passcodei").easyconfirm({locale: {
		title: 'Passcode Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#email_subject_passcodei").click(function() {
		//getInfoBox('email','email_response');
	});
	
	$("#email_pass_reset").easyconfirm({locale: {
		title: 'Password Reset Email',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#email_pass_reset").click(function() {
		//getInfoBox('email','email_response');
	});
	

	$("#system_info").easyconfirm({locale: {
		title: 'General Config',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#system_info").click(function() {
		
	});

	$("#login_screen_config").easyconfirm({locale: {
		title: 'Login Screen Config',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#login_screen_config").click(function() {
		getInfoBoxLogin('loc_thm','loc_thm_response');
	});

	$("#activation_admin1").easyconfirm({locale: {
		title: 'Activation T & C',
		text: 'Are you sure you want to update this information?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#activation_admin1").click(function() {
		
	});

	$("#faq_submit").easyconfirm({locale: {
		title: 'Submit FAQ ',
		text: 'Are you sure you want to save this FAQ?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#faq_submit").click(function() {

	});
<?php if($edit_faq=='1'){ ?>
	$("#faq_update").easyconfirm({locale: {
		title: 'Submit FAQ ',
		text: 'Are you sure you want to update this FAQ?',
		button: ['Cancel',' Confirm'],
		closeText: 'close'
	     }
	});
	$("#faq_update").click(function() {

	});
<?php } ?>
  });







</script>



<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">


tinymce.init({

    selector: "textarea.active_user_email_submit_tarea",

    theme: "modern",

    removed_menuitems: 'visualaid',

    height: 250,

    plugins: [

        "lists charmap",

        "searchreplace wordcount code nonbreaking",

        "contextmenu directionality paste textcolor"

    ],



    toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

	fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

	font_formats: "Andale Mono=andale mono,times;"+

    "Arial=arial,helvetica,sans-serif;"+

    "Arial Black=arial black,avant garde;"+

    "Book Antiqua=book antiqua,palatino;"+

    "Comic Sans MS=comic sans ms,sans-serif;"+

    "Courier New=courier new,courier;"+

    "Georgia=georgia,palatino;"+

    "Helvetica=helvetica;"+

    "Impact=impact,chicago;"+

    "Symbol=symbol;"+

    "Tahoma=tahoma,arial,helvetica,sans-serif;"+

    "Terminal=terminal,monaco;"+

    "Times New Roman=times new roman,times;"+

    "Trebuchet MS=trebuchet ms,geneva;"+

    "Verdana=verdana,geneva;"+

    "Webdings=webdings;"+

    "Wingdings=wingdings,zapf dingbats",
    
            
    init_instance_callback: function (editor) {
    editor.on('change', function (e) {
        active_user_email_submitfn();
    });
}


});
/////////////////
tinymce.init({

    selector: "textarea.active_user_email_submit_tarea1",

    theme: "modern",

    removed_menuitems: 'visualaid',

    height: 250,

    plugins: [

        "lists charmap",

        "searchreplace wordcount code nonbreaking",

        "contextmenu directionality paste textcolor"

    ],



    toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

	fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

	font_formats: "Andale Mono=andale mono,times;"+

    "Arial=arial,helvetica,sans-serif;"+

    "Arial Black=arial black,avant garde;"+

    "Book Antiqua=book antiqua,palatino;"+

    "Comic Sans MS=comic sans ms,sans-serif;"+

    "Courier New=courier new,courier;"+

    "Georgia=georgia,palatino;"+

    "Helvetica=helvetica;"+

    "Impact=impact,chicago;"+

    "Symbol=symbol;"+

    "Tahoma=tahoma,arial,helvetica,sans-serif;"+

    "Terminal=terminal,monaco;"+

    "Times New Roman=times new roman,times;"+

    "Trebuchet MS=trebuchet ms,geneva;"+

    "Verdana=verdana,geneva;"+

    "Webdings=webdings;"+

    "Wingdings=wingdings,zapf dingbats",
    
            
    init_instance_callback: function (editor) {
    editor.on('change', function (e) {
        active_property_submitfn();
    });
}


});

tinymce.init({

        selector: "textarea.new_location_activated_email",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
            new_venue_activated_emailfn();
        });
  }

    });




tinymce.init({

        selector: "textarea.activation_adminta",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",


        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                activation_admin1fn();
        });
  }

    });




tinymce.init({

        selector: "textarea.submit_tocta",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                submit_tocfn();
        });
  }

    });


tinymce.init({

        selector: "textarea.submit_arg1ta",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                submit_arg1fn();
        });
  }

    });


tinymce.init({

        selector: "textarea.password_reset_emailta",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                password_reset_emailfn();
        });
  }

    });


tinymce.init({

        selector: "textarea.venue_activated_confirm",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",


        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
            venue_activated_emailfn();
        });
  }

    });


tinymce.init({

        selector: "textarea.passcode_email_formta",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                email_subject_passcodeifn();
        });
  }

    });




    tinymce.init({

        selector: "textarea.active_email_submit_tarea",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                active_email_submitfn();
        });
        }

	});
	

    tinymce.init({

        selector: "textarea.active_sup_email_submit_tarea",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats",
        
                
        init_instance_callback: function (editor) {
        editor.on('change', function (e) {
                active_sup_email_submitfn();
        });
        }

    });

</script>





<script type="text/javascript">

    tinymce.init({

        selector: "textarea.jqte-test",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 250,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],



        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats"

    });

</script>

	<script type="text/javascript">

    tinymce.init({

        selector: "textarea.jqte-test-m",

        theme: "modern",

        removed_menuitems: 'visualaid',

        height: 20,

        plugins: [

            "lists charmap",

            "searchreplace wordcount code nonbreaking",

            "contextmenu directionality paste textcolor"

        ],


        toolbar: "undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor | code",

		fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt",

		font_formats: "Andale Mono=andale mono,times;"+

        "Arial=arial,helvetica,sans-serif;"+

        "Arial Black=arial black,avant garde;"+

        "Book Antiqua=book antiqua,palatino;"+

        "Comic Sans MS=comic sans ms,sans-serif;"+

        "Courier New=courier new,courier;"+

        "Georgia=georgia,palatino;"+

        "Helvetica=helvetica;"+

        "Impact=impact,chicago;"+

        "Symbol=symbol;"+

        "Tahoma=tahoma,arial,helvetica,sans-serif;"+

        "Terminal=terminal,monaco;"+

        "Times New Roman=times new roman,times;"+

        "Trebuchet MS=trebuchet ms,geneva;"+

        "Verdana=verdana,geneva;"+

        "Webdings=webdings;"+

        "Wingdings=wingdings,zapf dingbats"

    });

</script>



	<!-- on-off switch js -->







    <script src="js/bootstrap-toggle.min.js"></script>





<script type="text/javascript">

	var xmlHttp3;

	function getInfoBox(type,response)	{



		//alert('OK');

		xmlHttp3=GetXmlHttpObject();

		if (xmlHttp3==null)

		 {



			 alert ("Browser does not support HTTP Request");

			 return;

		 }


		var loader = type+"_loader";

		document.getElementById(loader).style.visibility= 'visible';

		var url="ajax/updateConfig.php";

		url=url+"?type="+type;
//alert(type);


		switch(type){

			case 'system' :



				var base_url=document.getElementById("base_url").value;

				var camp_url=document.getElementById("camp_url").value;

				var captive_portal_url = '';

				var menu_type = document.getElementById("menu_type").value;

				var main_title=document.getElementById("main_title").value;

				var master_email=document.getElementById("master_email").value;

				var ssl_on=document.getElementById("ssl_on").value;

				var global_url=document.getElementById("global_url").value;
				

                var header_color=document.getElementById("header_color").value;

                var style_type=document.getElementById("style_type").value;

                var light_color=document.getElementById("light_color").value;

				var flatform=document.getElementById("platform").value;

				var login_title=document.getElementById("login_title").value;
				var header_logo_img5=document.getElementById("header_logo_img5").value;



                var va = $('#top_che').is(':checked');

                if(va){

                    var top_line_color=document.getElementById("top_line_color").value;

                }else{

                    var top_line_color="";

                }



				url = url+"&header_logo_img5="+encodeURIComponent(header_logo_img5)+"&global_url="+encodeURIComponent(global_url)+"&login_title="+encodeURIComponent(login_title)+"&menu_type="+encodeURIComponent(menu_type)+"&header_color="+encodeURIComponent(header_color)+"&captive_portal_url="+encodeURIComponent(captive_portal_url)+"&base_url="+encodeURIComponent(base_url)+"&camp_url="+encodeURIComponent(camp_url)+"&main_title="+encodeURIComponent(main_title)+"&master_email="+encodeURIComponent(master_email)+"&style_type="+encodeURIComponent(style_type)+"&light_color="+encodeURIComponent(light_color)+"&top_line_color="+encodeURIComponent(top_line_color)+"&ssl_on="+ssl_on+"&flatform="+encodeURIComponent(flatform);

				break;



			case 'system1' :



			/**	var deni_url1=document.getElementById("deni_url1").value; */

				var main_title1=document.getElementById("main_title1").value;
                var noc_email1=document.getElementById("noc_email1").value;
				var short_title1=document.getElementById("short_title1").value;

				var master_email1=document.getElementById("master_email1").value;

				var mno_header_color=document.getElementById("mno_header_color").value;



                var style_type=document.getElementById("style_type1").value;

                var light_color=document.getElementById("light_color1").value;

                var header_logo_img=document.getElementById("header_logo_img").value;





                var va = $('#top_che1').is(':checked');

                if(va){

                    var top_line_color=document.getElementById("top_line_color1").value;

                }else{

                    var top_line_color="";

                }



				url = url+"&noc_email1="+encodeURIComponent(noc_email1)+"&header_logo_img="+encodeURIComponent(header_logo_img)+"&mno_header_color="+encodeURIComponent(mno_header_color)+"&main_title="+encodeURIComponent(main_title1)+"&short_title="+encodeURIComponent(short_title1)+"&master_email="+encodeURIComponent(master_email1)+"&dist="+encodeURIComponent('<?php echo $user_distributor; ?>')+"&style_type="+encodeURIComponent(style_type)+"&light_color="+encodeURIComponent(light_color)+"&top_line_color="+encodeURIComponent(top_line_color);

				break;



			case 'loc' :



				var site_title=document.getElementById("site_title0").value;

				var php_time_zone=document.getElementById("php_time_zone0").value;

				var portal_lang=document.getElementById("language0").value;

				var distributor_code=document.getElementById("distributor_code0").value;

				var header_color=document.getElementById("header_color0").value;



				var style_type=document.getElementById("style_type0").value;

				var light_color=document.getElementById("light_color0").value;



                var va = $('#top_che0').is(':checked');

                if(va){

                    var top_line_color=document.getElementById("top_line_color0").value;

                }else{

                    var top_line_color="";

                }



				url = url+"&header_color="+encodeURIComponent(header_color)+"&distributor_code="+encodeURIComponent(distributor_code)+"&title="+encodeURIComponent(site_title)+"&php_time_zone="+encodeURIComponent(php_time_zone)+"&portal_language="+encodeURIComponent(portal_lang)+"&style_type="+encodeURIComponent(style_type)+"&light_color="+encodeURIComponent(light_color)+"&top_line_color="+encodeURIComponent(top_line_color);

				//console.log(url);

                break;



			case 'network' :

				var network_name = document.getElementById("network_name").value;



				url = url+"&network_name="+encodeURIComponent(network_name);

				break;



			case 'caphaign' :

				var default_ad_waiting= document.getElementById("default_ad_waiting").value;

				var default_ad_welcome= document.getElementById("default_ad_welcome").value;



				url = url+"&default_ad_waiting="+encodeURIComponent(default_ad_waiting)+"&default_ad_welcome="+encodeURIComponent(default_ad_welcome)+"&dist="+encodeURIComponent('<?php echo $user_distributor; ?>');

				break;



			case 'toc' :



				var toc1= document.getElementById("toc1").value;



				url = url+"&toc="+encodeURIComponent(toc1)+"&dist="+encodeURIComponent('<?php echo $user_distributor; ?>');

				break;



			case 'aup' :



				var aup= document.getElementById("aup1").value;



				url = url+"&aup="+encodeURIComponent(aup)+"&dist="+encodeURIComponent('<?php echo $user_distributor; ?>');

				break;



			case 'email' :

				/* var email1= document.getElementById("email1").value; */
				var email1= $('#email1_ifr').contents().find('#tinymce').html();
				/* alert(email1); */

				url = url+"&email="+encodeURIComponent(email1)+"&dist="+encodeURIComponent('<?php echo $user_distributor; ?>');

				break;





			case 'fb' :

				var fb_app_id= document.getElementById("fb_app_id").value;

				var fb_app_version= document.getElementById("fb_app_version").value;

				var app_cookie= document.getElementById("app_cookie").value;

				var app_xfbml= document.getElementById("app_xfbml").value;

				var distributor = document.getElementById("distributor").value;

				var social_profile = document.getElementById("social_profile").value;





				var fb_additional_fields = '';

				var fb_fields = document.edit_profile.fb_fields;



				for (var i = 0; i < fb_fields.length; i++) {

					if (fb_fields[i].checked == true ) {



						fb_additional_fields += fb_fields[i].value +',';

					};

				}

				//console.log(fb_additional_fields);

				url = url+"&fb_app_id="+encodeURIComponent(fb_app_id)+"&fb_app_version="+encodeURIComponent(fb_app_version)+"&app_xfbml="+encodeURIComponent(app_xfbml)+"&app_cookie="+encodeURIComponent(app_cookie)+"&distributor="+encodeURIComponent(distributor)+"&social_profile="+encodeURIComponent(social_profile)+"&fb_additional_fields="+encodeURIComponent(fb_additional_fields);

				break;



			case 'manual' :

				var first_name= document.getElementById("m_first_name").checked;

				var last_name= document.getElementById("m_last_name").checked;

				var email= document.getElementById("m_email").checked;

				var age_group= document.getElementById("m_age_group").checked;

				var gender = document.getElementById("m_gender").checked;

				var mobile = document.getElementById("m_mobile_num").checked;

				//var social_profile = document.getElementById("social_profile").value;

				var distributor = document.getElementById("distributor").value;

				var manual_profile = document.getElementById("manual_profile").value;

						//console.log(last_name);

				url = url+"&first_name="+encodeURIComponent(first_name)+"&last_name="+encodeURIComponent(last_name)+"&email="+encodeURIComponent(email)+"&age_group="+encodeURIComponent(age_group)+"&distributor="+encodeURIComponent(distributor)+"&gender="+encodeURIComponent(gender)+"&manual_profile="+encodeURIComponent(manual_profile)+"&mobile_number="+encodeURIComponent(mobile);

				break;

		}


		xmlHttp3.onreadystatechange=stateChanged;

		xmlHttp3.open("GET",url,true);

		xmlHttp3.send(null);


		function stateChanged()
		{

			if (xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")			{

			    if(type=='manual'){
                    window.location = "?t=22";
                }else{
                    window.location = "?t=<?php echo $user_type=='MNO'?'0':'1'?>";
                }
				document.getElementById(loader).style.visibility= 'hidden';

			}

		}

	}

</script>















<script type="text/javascript">

	var xmlHttp5 = null;
	var xmlHttp6 = null;
	function editNetPro(){

		var network_profile = $("#network_edit").val();		//console.log(network_profile);
		xmlHttp5=GetXmlHttpObject();
		if (xmlHttp5==null)

		 {
			 alert ("Browser does not support HTTP Request");
			 return;
		 }

		document.getElementById('network_edit_loader').style.visibility= 'visible';
		var url="ajax/updateConfigNetEdit.php";
		url = url+"?network_profile="+network_profile;
		xmlHttp5.onreadystatechange=stateChanged;
		xmlHttp5.open("GET",url,true);
		xmlHttp5.send(null);

		function stateChanged()
		{
			if (xmlHttp5.readyState==4 || xmlHttp5.readyState=="complete")
			{
				document.getElementById('editable').innerHTML=xmlHttp5.responseText;
				document.getElementById('save_as_net_pro').value = network_profile;
				document.getElementById('network_edit_loader').style.visibility= 'hidden';
				document.getElementById("network_edit").disabled=true;
				document.getElementById("cancel").style.visibility = "visible";
				document.getElementById("edit").style.visibility = "hidden";
            }
		}
	}















	function cancelNetPro(){

		//console.log('dfsf');

		document.getElementById('network_save_loader').style.visibility= 'visible';

		document.getElementById("cancel").style.visibility = "hidden";

		document.getElementById("edit").style.visibility = "visible";

		document.getElementById("network_edit").disabled=false;

		document.getElementById('editable').innerHTML="";

		document.getElementById('network_save_loader').style.visibility= 'hidden';

	}






	function activeSaveAs(){

		if (document.getElementById("save_as").checked) {

			document.getElementById("save_as_net_pro").disabled = false;

			document.getElementById("save_as_net_pro").focus();

		} else{

			document.getElementById("save_as_net_pro").disabled = true;

		};

	}



</script>



<script type="text/javascript" src="js/formValidation.js"></script>
 <script type="text/javascript" src="js/bootstrap_form.js"></script>

 <script type="text/javascript">
    $(document).ready(function() {

        //duration from
        $('#create_duration_form').formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            fields: {
                duration_product_name: {
                    validators: {
                        <?php echo $db->validateField('special_character'); ?>
                    }
                },
                product_du_type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                duration: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }

            }
        }).on('change', function(e) {

            if ($('#du_select1').val() == '0' && $('#du_select3').val() == '0' && $('#du_select5').val() == '0') {

                $('#duration').val('');
            }
            else {
                $('#duration').val('set');
            }

            $('#create_duration_form').formValidation('revalidateField', 'duration');

        });

        $('#create_product_form').formValidation({
            framework: 'bootstrap',
            fields: {
                 description: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				 description_up: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                product_name: {
                    validators: {
                        <?php echo $db->validateField('special_character'); ?>
                    }
                },
				Purge_delay_time: {
                    validators: {
						<?php echo $db->validateField('notEmpty'); ?>
					}
                },
				Purge_delay_time: {
                    validators: {
						<?php echo $db->validateField('number'); ?>
					}
                },
				
                dob1: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
            }
        }).on('change', 'input[name="description"], input[name="description_up"]', function(e) {
            var from = $('#create_product_form').find('[name="description"]').val(),
                to = $('#create_product_form').find('[name="description_up"]').val();

            // Set the dob field value
            $('#create_product_form').find('[name="dob1"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

            // Revalidate it
            $('#create_product_form').formValidation('revalidateField', 'dob1');
        });

        $('#create_product_submit').on('click', function(e) {
        	 var from = $('#create_product_form').find('[name="description"]').val(),
                to = $('#create_product_form').find('[name="description_up"]').val();

            // Set the dob field value
            $('#create_product_form').find('[name="dob1"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

            // Revalidate it
            $('#create_product_form').formValidation('revalidateField', 'dob1');
             $('#create_product_form').formValidation('revalidateField', 'product_name');
        });


        $('#create_guest_form').formValidation({
            framework: 'bootstrap',
            fields: {
                
                product_name: {
                    validators: {
                        <?php echo $db->validateField('special_character'); ?>
                    }
                },
                dob2: {
                    excluded: false,
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
				Purge_delay_time: {
                    validators: {
						<?php echo $db->validateField('number'); ?>
					}
                },
                max_sessions_alert: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }
                
            }
        }).on('change', 'input[name="description1"], input[name="description1_up"]', function(e) {
            var from = $('#create_guest_form').find('[name="description1"]').val(),
                to = $('#create_guest_form').find('[name="description1_up"]').val();

            // Set the dob field value
            $('#create_guest_form').find('[name="dob2"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

            // Revalidate it
            $('#create_guest_form').formValidation('revalidateField', 'dob2');
        });

        $('#create_product_submit_guest').on('click', function(e) {
        	 var from = $('#create_guest_form').find('[name="description1"]').val(),
                to = $('#create_guest_form').find('[name="description1_up"]').val();

            // Set the dob field value
            $('#create_guest_form').find('[name="dob2"]').val(from === '' || to === '' ? '' : [from, to].join('.'));

            // Revalidate it
            $('#create_guest_form').formValidation('revalidateField', 'dob2');
            $('#create_guest_form').formValidation('revalidateField', 'product_name');
            $('#create_guest_form').formValidation('revalidateField', 'max_sessions_alert');
        });

        $('#edit_profile_a').formValidation({
            framework: 'bootstrap',
            button: {
            	selector: '#portal_submit',
            	disabled: 'disabled'
        	},
            fields: {
            	main_title1: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                short_title1: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                master_email1: {
                    validators: {
                        <?php echo $db->validateField('master_email1'); ?>
                    }
                },
                noc_email1: {
                    validators: {
                        <?php echo $db->validateField('master_email1'); ?>
                    }
                }

            }

            }).on('success.form.fv', function(e) {
            	e.preventDefault();
            	getInfoBox('system1','system1_response');
            });


            $('#edit_profile_b').formValidation({
            framework: 'bootstrap',
            fields: {

            	arg_title1: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                }

            }
        });

            $('#edit_profile_c').formValidation({
            framework: 'bootstrap',
            button: {
            	selector: '#system_info',
            	disabled: 'disabled'
        	},
            fields: {

                base_url: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                menu_type: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                camp_url: {
                    validators: {
                        <?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                master_email: {
                    validators: {
                        <?php echo $db->validateField('master_email1'); ?>
                    }
                }

            }

            }).on('success.form.fv', function(e) {
            	e.preventDefault();
            	getInfoBox('system','system_response');
            });

            $('#active_property_submitfn').formValidation({
            framework: 'bootstrap',
            fields: {

            	propertyName: {
                    validators: {
						<?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                headerImg: {
                    validators: {
						<?php echo $db->validateField('notEmpty'); ?>
                    }
                },
                <?php
                if($opt){
                    foreach($opt as $key=>$value){
                    ?>
                    sup_num_<?php echo $key;?>: {
                        validators: {
                            <?php echo $db->validateField('mobile_new'); ?>
                        }
                    },
                    <?php
                    }
                }
                ?>

            }
        });

    });

    
</script>



<script type="text/javascript" >

 $(document).ready(function() {

            $('#photoimg').on('change', function(){

			           $("#preview").html('');

			    $("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');

			$("#imageform").ajaxForm({

						target: '#preview'

		}).submit();

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

	  {	  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");

	  }

	 }

	return xmlHttp;

	}

</script>



<script type="text/javascript" src="js/jquery.form.js"></script>


<script type="text/javascript" >


 $(document).ready(function() {

            $('#photoimg5').on('change', function(){

			           $("#img_preview5").html('');

			    $("#img_preview5").html('<img src="img/loader.gif" alt="Uploading...."/>');

			$("#imageform5").ajaxForm({

						//target: '#img_preview5'

                success: function (response) {
                    // this happens after the ajax request
                    var res_array=response.split(',');
                    $('#img_preview5').html(res_array[0]);
                    $('#header_logo_img5').val(res_array[1]);
                }

		}).submit();

			});

        });

</script>









<script type="text/javascript" >







 $(document).ready(function() {

            $('#photoimg').on('change', function(){

			           //$("#img_preview").html('');

			    $("#img_preview").html('<img src="img/loader.gif" alt="Uploading...."/>');

			$("#imageform").ajaxForm({
                //target: '#img_preview'
                success: function (response) {
                    // this happens after the ajax request
                    var res_array=response.split(',');
                    $('#img_preview').html(res_array[0]);
                    $('#header_logo_img').val(res_array[1]);
                }

		}).submit();

			});

        });

</script>




<script type="text/javascript" >

 $(document).ready(function() {

            $('#photoimg2').on('change', function(){

			           $("#img_preview2").html('');

			    $("#img_preview2").html('<img src="img/loader.gif" alt="Uploading...."/>');

			$("#imageform2").ajaxForm({

						target: '#img_preview2'

		}).submit();

			});

        });

</script>


<script type="text/javascript">

	$(document).ready(function(){

		$("#cancel").on('change', function(){



			$("#editable").html("");

		});

	});

</script>

<script>

    function setTimeGapEditDis(){

        mg_dis_num1_1 = document.getElementById("mg_dis_num1_1").value;

        mg_dis_num2_2 = document.getElementById("mg_dis_num2_2").value;

        mg_dis_select1_1 = document.getElementById("mg_dis_select1_1").value;

        mg_dis_select2_2 = document.getElementById("mg_dis_select2_2").value;


        if(mg_dis_num1_1 != 0 && mg_dis_num2_2 != 0){

            assign_timegap_edit = 'P'+mg_dis_num1_1+mg_dis_select1_1+'T'+mg_dis_num2_2+mg_dis_select2_2;

        }else if(mg_dis_num1_1 == 0 && mg_dis_num2_2 == 0){

            assign_timegap_edit = '';

        }else if(mg_dis_num2_2 == 0){

            assign_timegap_edit = 'P'+mg_dis_num1_1+mg_dis_select1_1;

        }else if(mg_dis_num1_1 == 0){

            assign_timegap_edit = 'PT'+mg_dis_num2_2+mg_dis_select2_2;

        }

        document.getElementById("temp_account_timegap").value = assign_timegap_edit;

    }


    function setTimeGapEditDis12(){

        mg_dis_num1_12 = document.getElementById("mg_dis_num1_12").value;

        mg_dis_num2_22 = document.getElementById("mg_dis_num2_22").value;

        mg_dis_select1_12 = document.getElementById("mg_dis_select1_12").value;

        mg_dis_select2_22 = document.getElementById("mg_dis_select2_22").value;


        if(mg_dis_num1_12 != 0 && mg_dis_num2_22 != 0){

            assign_timegap_edit2 = 'P'+mg_dis_num1_12+mg_dis_select1_12+'T'+mg_dis_num2_22+mg_dis_select2_22;

        }else if(mg_dis_num1_12 == 0 && mg_dis_num2_22 == 0){

            assign_timegap_edit22 = '';

        }else if(mg_dis_num2_22 == 0){

            assign_timegap_edit22 = 'P'+mg_dis_num1_12+mg_dis_select1_12;

        }else if(mg_dis_num1_12 == 0){

            assign_timegap_edit2 = 'PT'+mg_dis_num2_22+mg_dis_select2_22;

        }



        document.getElementById("api_mater_timegap").value = assign_timegap_edit2;

        //console.log(assign_timegap_edit);

    }



    function setTimeGapEditDis123(){

        mg_dis_num1_123 = document.getElementById("mg_dis_num1_123").value;

        mg_dis_num2_223 = document.getElementById("mg_dis_num2_223").value;

        mg_dis_select1_123 = document.getElementById("mg_dis_select1_123").value;

        mg_dis_select2_223 = document.getElementById("mg_dis_select2_223").value;



        //console.log(num1+'/'+num2+'/'+select1+'/'+select2+'/')

        if(mg_dis_num1_123 != 0 && mg_dis_num2_223 != 0){

            assign_timegap_edit23 = 'P'+mg_dis_num1_123+mg_dis_select1_123+'T'+mg_dis_num2_223+mg_dis_select2_223;

        }else if(mg_dis_num1_123 == 0 && mg_dis_num2_223 == 0){

            assign_timegap_edit223 = '';

        }else if(mg_dis_num2_223 == 0){

            assign_timegap_edit223 = 'P'+mg_dis_num1_123+mg_dis_select1_123;

        }else if(mg_dis_num1_123 == 0){

            assign_timegap_edit23 = 'PT'+mg_dis_num2_223+mg_dis_select2_223;

        }



        document.getElementById("api_sub_timegap").value = assign_timegap_edit23;

        //console.log(assign_timegap_edit);

    }





</script>



<script>

    $(document).ready(function() {

        $('#photoimg23').on('change', function(){

            $("#img_preview23").html('');

            $("#img_preview23").html('<img src="img/loader.gif" alt="Uploading...."/>');

            $("#imageform23").ajaxForm({

                //target: '#img_preview23'
                success: function (response) {
                    // this happens after the ajax request
                    var res_array=response.split(',');
                    $('#img_preview23').html(res_array[0]);
                    $('#header_logo_img23').val(res_array[1]);
                }

            }).submit();

        });

    });





    var xmlHttp4;

    function getInfoBoxLogin(type,response)	{



        //alert('OK');

        xmlHttp4=GetXmlHttpObject();

        if (xmlHttp4==null)

        {



            alert ("Browser does not support HTTP Request");

            return;

        }


        var loader = type+"_loader";

        document.getElementById(loader).style.visibility= 'visible';

        var url="ajax/updateConfig.php";

        url=url+"?type="+type;

        var header_color=document.getElementById("header_color_log").value;

        var header_logo_img23=document.getElementById("header_logo_img23").value;



        url = url+"&header_color="+encodeURIComponent(header_color)+"&header_logo_img23="+encodeURIComponent(header_logo_img23);
        console.log(url);
        xmlHttp4.onreadystatechange=stateChanged;
        xmlHttp4.open("GET",url,true);
        xmlHttp4.send(null);

        function stateChanged()
        {

            if (xmlHttp4.readyState==4 || xmlHttp4.readyState=="complete")			{
                document.getElementById(response).innerHTML=xmlHttp4.responseText;
                document.getElementById(loader).style.visibility= 'hidden';
            }
        }
    }

</script>





<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.easy-confirm-dialog.min.js"></script>
<script src="js/jscolor.js"></script>

    <script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(".faq_content_fancy").fancybox({
                'transitionIn'	:	'elastic',
                'transitionOut'	:	'elastic',
                'speedIn'		:	600,
                'speedOut'		:	200,
                'overlayShow'	:	false,
                'width'         :   "50%",
                'height'        :   "50%"
            });

            $('.fancy_close').click(function(event) {  $.fancybox.close(); });
        });
    </script>
</body>

</html>
