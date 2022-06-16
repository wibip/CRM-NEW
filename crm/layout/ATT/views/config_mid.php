
<div class="main">

	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

						
						
						<?php 
$camp_base_url=$db->setVal('camp_base_url','ADMIN');
$post_data =array(
    'sync_type' => 'qos_new_sync',
    'user_distributor' => $user_distributor,
    'system_package'   => $system_package,
    'user_name'   => $user_name);
/*function httpPost($url,$data)
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
*/						

	//$archive_path=$db->setVal('LOGS_FILE_DIR','ADMIN');
if (isset($_POST['purge_now'])) {
						
		
			
			$log_older_days = $_POST['log_older_days'];
			$archive_log_days = $_POST['archive_log_days'];

			$archive_path = $_POST['archive_log_path'];
			$archive_log_path_update="UPDATE exp_settings SET `settings_value`='$archive_path' WHERE `settings_code`='LOGS_FILE_DIR' AND `distributor`='ADMIN'";
			$db->execDB($archive_log_path_update);



			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('purge_now_update_failed',NULL)."</strong></div>";
				
			$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$log_older_days' WHERE `type` = 'DB'";
			$query_log_remove_update_q1 = $db->execDB($query_log_remove_update1);
			
			$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$archive_log_days' WHERE `type` = 'archive_db'";
			$query_log_remove_update_q1 = $db->execDB($query_log_remove_update1);
			
			if($query_log_remove_update_q1===true){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('purge_now_update_success',NULL)."</strong></div>";
					
			}
	
			
		}
  

if(isset($_POST['property_updatenew'])){
	unset($_POST['property_updatenew']);

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

    	if($e === true && $e2 === true){
    		$show_msg=$message_functions->showMessage('config_operation_success');
        	$create_log->save('3002',$show_msg,"");
			$_SESSION['system1_msg']='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
    	}else{
    		$show_msg=$message_functions->showMessage('config_operation_failed','2002');
        	$create_log->save('2002',$show_msg,"");
			$_SESSION['system1_msg']='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.$show_msg.'</strong></div>';
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
/*if (isset($_GET['edit_id'])) {
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
}*/




/*if (isset($_POST['qos_update'])) {
						
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

			$query_pro=$db->selectDB($query_pro0);
						
			if($query_pro){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_update_success',NULL)."</strong></div>";
					
			}
			else{

				$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_update_fail',NULL)."</strong></div>";

			}
	
			
		}*/

/*if (isset($_POST['qos_submit'])) {
						
		
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

			$query_pro=$db->selectDB($query_pro0);
						
			if($query_pro){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_creat_success',NULL)."</strong></div>";
					
			}
			else{

				$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('vt_prof_creat_fail',NULL)."</strong></div>";

			}
	
			
		}*/
		
?>
			
                        <div id="system1_response">
                       <?php
                       
						?> 
					   
					   
                        </div>
                        

						<!-- /widget-header -->



						<div class="widget-content">

							<div class="tabbable">

								<ul class="nav nav-tabs">

									<?php

										if($user_type == 'MVNO' || $user_type == 'MVNE'){

											?>

										<li <?php if(isset($tab1)){?>class="active" <?php } ?>><a href="#live_camp2" data-toggle="tab">Admin</a></li>
									<?php if(in_array("CONFIG_REGISTER",$features_array)){ ?>
										<li <?php if(isset($tab22)){?>class="active" <?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
										<?php } ?>
										<li <?php if(isset($tab11)){ ?>class="active" <?php } ?>><a href="#toc" data-toggle="tab">T & C</a></li>

										<!--
										<li <?php //if(isset($tab12)){?>class="active" <?php //}?>><a href="#veryfi" data-toggle="tab">Verify Settings</a></li>
                                        -->
                                        <li <?php if(isset($tab112)){ ?>class="active" <?php } ?>><a href="#sys_controllers" data-toggle="tab">Session</a></li>

											<?php



										}

									?>

									<?php

										if($user_type == 'ADMIN'){

											?>

										<li <?php if(isset($tab1)){ ?>class="active" <?php } ?>><a href="#live_camp" data-toggle="tab">General Config</a></li>
									<?php if(in_array("CONFIG_REGISTER",$features_array)){ ?>
										<li><a href="#registration" data-toggle="tab">Registration</a></li>
										<?php } ?>
										<li <?php if(isset($tab15)){ ?>class="active" <?php } ?>><a href="#live_cam3" data-toggle="tab">Login Screen</a></li>
										<li <?php if(isset($tab13)){ ?>class="active" <?php } ?>><a href="#agreement" data-toggle="tab">Activation T&C</a></li>
										<li <?php if(isset($tab21)){ ?>class="active" <?php } ?>><a href="#email" data-toggle="tab">Activation Email</a></li>
										
										<!-- <li <?php if(isset($tab7)){?>class="active" <?php }?>><a href="#purge_logs" data-toggle="tab">Purge Log Config</a></li> -->
										<?php if(in_array("PURGE_LOGS",$features_array)|| $package_features=="all" ){ ?>
										<li <?php if(isset($tab7)){?>class="active" <?php } ?>><a href="#purge_logs" data-toggle="tab">Purge Log Config</a></li>
																			<?php } ?>										<?php
										}



										if($user_type == 'MNO'){

											//echo $tab0;
//print_r($features_array);
											?>

										<!-- <li class="active"><a href="#live_camp3" data-toggle="tab">System Configuration</a></li>	 -->
										<?php if(in_array("CONFIG_PROFILE",$features_array)){ ?>
										<li <?php if(isset($tab1)){ ?>class="active" <?php } ?>><a href="#product_create" data-toggle="tab">Profile</a></li>
										<?php }
										 if(in_array("CONFIG_DURATION",$features_array)){ ?>
										<li <?php if(isset($tab2)){ ?>class="active" <?php } ?>><a href="#duration_create" data-toggle="tab">Duration</a></li>
										<?php }?>	

										<li <?php if(isset($tab0)){ ?>class="active" <?php } ?>><a href="#live_camp3" data-toggle="tab">Portal</a></li>

										<?php
										 if(in_array("CONFIG_QOS",$features_array)){
										 CommonFunctions::httpPost($camp_base_url . '/ajax/get_profile.php',$post_data);
										  ?>
										<li <?php if(isset($tab1)){ ?>class="active" <?php } ?>><a href="#qos_set" data-toggle="tab">QoS</a></li>
										<?php }?>
										<?php	//if( $package_functions->getSectionType('VTENANT_TYPE',$system_package)!='1' ){ ?>
										    <li <?php if(isset($tab11)){ ?>class="active" <?php } ?>><a href="#toc" data-toggle="tab">Guest T&C</a></li>
											<?php //}?>

										<?php	if(in_array("VTENANT_TC",$features_array) && $package_functions->getSectionType('VTENANT_TYPE',$system_package)=='1' ){ ?>
										<li <?php if(isset($tab32)){ ?>class="active" <?php } ?>><a href="#vt_toc" data-toggle="tab">vTenant T&C</a></li>
										<?php }?>	

									<?php if(in_array("CONFIG_GUEST_AUP",$features_array) || $system_package=='N/A'){ ?>
									    <li <?php if(isset($tab10)){ ?>class="active" <?php } ?>><a href="#aup" data-toggle="tab">Guest AUP</a></li>
											<?php } ?>

					    				<li <?php if(isset($tab20)){ ?>class="active" <?php } ?>><a href="#agreement2" data-toggle="tab">Activation T&C</a></li>
									<?php if(in_array("CONFIG_REGISTER",$features_array)){ ?>
										<li <?php if(isset($tab22)){?>class="active" <?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
									<?php } ?>
										<li <?php if(isset($tab21)){ ?>class="active" <?php } ?>><a href="#email" data-toggle="tab">Email Templates</a></li>
									<?php if(in_array("CONFIG_PROPERTY_SETTINGS",$features_array)){ ?>
										<li <?php if(isset($tab23)){?>class="active" <?php } ?>><a href="#property_settings" data-toggle="tab">Property Settings</a></li>
									<?php } 
										if(in_array("CONFIG_POWER",$features_array)){ ?>
											<li><a href="#power_shedule" data-toggle="tab">Power Schedule</a></li>
										<?php }
                                            if(in_array("CONFIG_GUEST_FAQ",$features_array) || $system_package=='N/A'){ ?>
                                                <li <?php if(isset($tab30)){ ?>class="active" <?php } ?>><a href="#faq" data-toggle="tab">FAQ</a></li>
                                        <?php }
                                            if(in_array("CONFIG_FOOTER",$features_array) || $system_package=='N/A'){ ?>
                                               <li <?php if(isset($tab31)){ ?>class="active" <?php } ?>><a href="#footer" data-toggle="tab">FAQ</a></li>
                                            <?php }
										}

									?>

								</ul><br>

								<div class="tab-content">

										<?php

										if(isset($_SESSION['system1_msg'])){
							echo $_SESSION['system1_msg'];
							unset($_SESSION['system1_msg']);
							}

				if(isset($_SESSION['msg7'])){
						
							echo $_SESSION['msg7'];
						
							unset($_SESSION['msg7']);
						
						}

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

								
								
							<?php if(in_array("CONFIG_FOOTER",$features_array)){?>
									<div class="tab-pane <?php if(isset($tab31)){ ?>active <?php } ?>" id="footer">
									
									
									<div id="response_d3">

											<?php




						   					  $footerq="SELECT * FROM `exp_footer` WHERE `distributor`='$user_distributor'";
						   					  
						   					  $footer_results1=$db->selectDB($footerq);
						   					  
						   					 foreach ($footer_results1['data'] as $rowf) {
						   					  	$editftype=$rowf[footer_type];
						   					  	$editgtitle=$rowf[group_title];
						   					  	$editlinktitle=$rowf[link_title];
						   					    $editfurl=$rowf[url];
						   					  	
						   					  	
						   					  	
						   					  	
						   					  }
						   					  

										      ?>

										</div>


									
									
										<form onkeyup="footer_submitfn();" onchange="footer_submitfn();" id="footer_form" name="footer_form" method="post" action="?t=31" class="form-horizontal">
											
										<?php
										echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
										?>
											
											<fieldset>
											
											
											
											<input type="hidden" value="link" name="footer_type">
											<input type="hidden" value="Need Help?" name="group_title">
											<input type="hidden" value="faq" name="link_title">

												
												
												<div class="control-group" id="foot_ur">
													<label class="control-label" for="gt_mvnx">URL</label>
													<div class="controls ">
														
														
														<textarea style="width: 100%;" placeholder="http://www.google.com" id="footer_url" name="footer_url" required ><?php echo $editfurl; ?></textarea>

													</div>
												</div>
										
										<div class="form-actions">

										<button disabled id="footer_submit" type="submit" name="footer_submit" id="footer_submit"  class="btn btn-primary">Save</button>

										</div>

                                                <script>
                                                    function footer_submitfn() {
                                                        //alert("fn");
                                                        $("#footer_submit").prop('disabled', false);
                                                    }
                                                </script>
										
										</fieldset>
										</form>
									
									
								
								</div>
								<?php }?>

								<div <?php if(isset($tab23)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="property_settings" >
										<form id="active_property_submitfn"  method="post" action="?t=23" class="form-horizontal"  autocomplete="on">

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
                                                        foreach($opt as $key=>$value){
                                                        	$value = $sup_nums->$key;
                                                            $ischeck = 'checked';
                                                            if(empty($value)){
                                                                //$ischeck = '';
                                                                //$value = $sup_num;
                                                            }
                                                            if (!in_array($key, $enable_verticlearr)) {
                                                                $ischeck = '';
                                                            }
                                                            ?>
                                                            <div class="control-group">
                                                                <label class="control-label" for="sup_num_<?php echo $key;?>"><?php echo $key; ?></label>
                                                                <div class="controls form-group">
                                                                	<input <?php echo $ischeck;?> id="sup_enable_<?php echo $key;?>" name="sup_num_en_<?php echo $key;?>" type="checkbox" onclick="changebuttons()">
                                                                    <input  autocomplete="off" value="<?php echo $value;?>" class="support_number" placeholder="xxx-xxx-xxxx" pattern="^(1-)?[0-9]{3}-[0-9]{3}-[0-9]{4}$" maxlength="14" id="sup_num_<?php echo $key;?>" name="sup_num_[]" type="text" oninput="setCustomValidity('')">
                                                                </div>
                                                            </div>
                                                            <script type="text/javascript">
                                                            	var key = "<?php echo $key;?>";
                                                            	//$("#sup_num_"+key).attr("required", "true");
                                                            	var enable = $('#sup_num_en_'+key).val();
                                                                
                                                            	 if (enable == 'on') {
                                                            		//$("#sup_num_"+key).attr("required", "true");
                                                            	}else{
                                                            		//$("#sup_num_"+key).attr("required", "false");
                                                            	}

                                                            	function changebuttons(){
                                                            	$("#property_updatenew").removeClass("disabled");
                                                            	$("#property_updatenew").prop('disabled', false);

                                                            	
                                                            							
                                                            	}
                                                            	
                                                            </script>
                                                            <?php
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

												<button disabled type="submit" id="property_updatenew" name="property_updatenew" class="btn btn-primary">Save</button>

											</div>

										</form>
									</div>
								
							

                                    <!--====================== FAQ ======================-->
                                    <?php if(in_array("CONFIG_GUEST_FAQ",$features_array)){ ?>
                                        <div class="tab-pane <?php if(isset($tab30)){ ?>active <?php } ?>" id="faq">


                                            <form  id="faq_form1" name="faq_form1" method="post" action="?t=30" class="form-horizontal">
                                                <fieldset>
                                                    <div class="control-group" id="">
                                                        <label class="control-label" for="gt_mvnx">Title</label>
                                                        <div class="controls ">
                                                            <input class="span6" style="" type="text" name="faq_title" required value="<?php if($edit_faq=='1'){echo $edit_faq_details['text']; } ?>">

                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="">
                                                        <label class="control-label" for="gt_mvnx">Description</label>
                                                        <div class="controls ">
                                                            <textarea class="span6" style="height: 80px !important;" name="faq_content" required ><?php if($edit_faq=='1'){echo $edit_faq_details['content']; } ?></textarea>

                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="faq_submit_secret" value="<?php echo $_SESSION['FORM_SECRET']?>">
                                                    <div class="form-actions">
                                                        <?php
                                                        if($edit_faq=='1'){
                                                            echo'<button type="submit" name="faq_update" id="faq_update"  class="btn btn-primary">Update</button>';
                                                            echo'<input type="hidden" name="faq_update_code" value="'.$edit_faq_code.'"  class="btn btn-primary">';
                                                        }else{
                                                            echo'<button type="submit" name="faq_submit" id="faq_submit"  class="btn btn-primary">Save</button>';
                                                        }

                                                        ?>
                                                    </div>

                                                </fieldset>
                                            </form>
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>FAQ</h3>
                                                </div>
                                                <!-- /widget-header -->
                                                <div class="widget-content table_response">
                                                    <div style="overflow-x:auto">
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">FAQ Title</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">View</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Remove</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php

                                                                $faqClassFunInit=new faq_functions();

                                                                $faq_array=$faqClassFunInit->getMNOfaq($user_distributor);

                                                                //print_r($faq_array);
                                                                foreach ($faq_array as $faq_row){
                                                                    echo'<tr>';

                                                                    echo'<td>'.$faq_row['text'].'</td>';
                                                                    echo'<td><a class="faq_content_fancy" href="#fancyid_'.$faq_row['unique_id'].'" >View</a></td>';
                                                                    echo'<div style="display: none" id="fancyid_'.$faq_row['unique_id'].'"><p class="fancy-text">'.$faq_row['content'].'</p><button class="fancy_close btn btn-primary" style="display: none">Close</button></div>';
                                                                    echo'<td>
                                                            <a href="javascript:void();" id="faq_edit_'.$faq_row['unique_id'].'"  class="btn btn-small btn-primary">Edit
															<i class="btn-icon-only icon-pencil"></i> </a>
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                             $(\'#faq_edit_'.$faq_row['unique_id'].'\').easyconfirm({locale: {
																				title: \'Edit FAQ\',
																				text: \'Are you sure you want to edit this FAQ ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});

                                                                $(\'#faq_edit_'.$faq_row['unique_id'].'\').click(function() {
                                                                  
                                                                    window.location = "?t=30&edit_faq_code='.$faq_row['unique_id'].'&faqsecret='.$secret.'"
                                                                });
                                                                });
                                                            </script>
                                                                        </td>';

                                                            echo'<td>
                                                            <a href="javascript:void();" id="faq_remove_'.$faq_row['unique_id'].'"  class="btn btn-small btn-danger">Remove
															<i class="btn-icon-only icon-circle"></i> </a>
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                             $(\'#faq_remove_'.$faq_row['unique_id'].'\').easyconfirm({locale: {
																				title: \'Remove FAQ\',
																				text: \'Are you sure you want to remove this FAQ ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});

                                                                $(\'#faq_remove_'.$faq_row['unique_id'].'\').click(function() {
                                                                  
                                                                    window.location = "?t=30&delete_faq_code='.$faq_row['unique_id'].'&faqsecret='.$secret.'"
                                                                });
                                                                });
                                                            </script>
                                                                        </td>';



                                                                    echo'</tr>';
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
                                    <?php } ?>
                                    <!-- ============== FAQ ==================== -->



<!-- /* +++++++++++++++++++++++++++++++++++++purge logs
....................................... User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab7)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="purge_logs">
										<br>
										<form id="activity_log" name="purgr_logs" method="post" class="form-horizontal" action="?t=7">
											<fieldset>

												<div id="response_d3">
												<?php
												  /* if(isset($_SESSION['msg7'])){
													   echo $_SESSION['msg7'];
													   unset($_SESSION['msg7']);


													  }*/
													  
													  $archive_path=$db->setVal('LOGS_FILE_DIR','ADMIN');
													  
													  $query_purge11 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'DB' GROUP BY `type`";
													  	
													  $query_results11_mod=$db->selectDB($query_purge11);
													  foreach ($query_results11_mod['data'] as $row1) {
													  	$last_run_days1 = $row1[last_run_days];
													  }
													  
													  
													  
													  
													  $query_purge2 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'archive_db' GROUP BY `type`";
													  
													  $query_results2_mod=$db->selectDB($query_purge2);
													  foreach ($query_results2_mod['data'] as $row2) {
													  	$last_run_days2 = $row2[last_run_days];
													  }


													  $log_older_days=$db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='DB'");
												$archive_log_days=$db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='archive_db'");

													  
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />


													<h3>Archive DB logs</h3><br>
											<div class="control-group">
														<label class="control-label" for="limit3">Logs Older Than</label>
														<div class="controls">
															<?php echo '<input class="span2" id="log_older_days" name="log_older_days" value="'.$log_older_days.'" type="number" min="3" max="365" required step="1" >' ?> Days
														</div>
													</div>
													
													<h3>Permanently remove archived logs</h3><br>
													<div class="control-group">
														<label class="control-label" for="limit3">Archive Logs Older Than</label>
														<div class="controls">
															<?php echo '<input class="span2" id="archive_log_days" name="archive_log_days" value="'.$archive_log_days.'" type="number" min="3" max="365" required step="1">' ?> Days
														</div>
													</div>


													<h3>Archive directory</h3><br>
													<div class="control-group">
														<label class="control-label">Directory Path</label>
														<div class="controls">
															<?php echo '<input class="span2" id="archive_log_path" name="archive_log_path" type="text" required value="'.$archive_path.'">' ; ?>
															<small><font color="red">Folder permission should be granted</font></small>
														</div>
													</div>



													<div class="form-actions">
														<button type="submit" name="purge_now" id="purge_now" class="btn btn-primary">Save</button>
	                                                </div>

											</fieldset>
										</form>
										


										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												
													<h3>Archive Information</h3>
												
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered">
													<thead>
														<tr>
															<th>Logs</th>
															<!-- <th>DB usage (Estimated)</th> -->
															<th>Last archived date</th>


														</tr>
													</thead>
													<tbody>

													<?php
													
													$base_purge_query = "SELECT * FROM `admin_purge_logs` WHERE is_enable=1";
													$query_results0 = $db->selectDB($base_purge_query);

													$fsize = 0;
													  foreach ($query_results0['data'] as $row) {
																		
														$log_name = $row[log_name];
														$last_run = $row[last_run];
                                                        $dt2 = new DateTime($last_run);
                                                        $last_run = $dt2->format('m/d/Y h:i:s A');
														$table_name = $row[system_table_name];
														$date_column = $row[date_column];
														$last_run_days = $row[last_run_days];
														
														
													 	$log_purge_q ="SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 2) `size`
														FROM information_schema.TABLES
														WHERE table_schema = '$db_name' AND table_name = '$table_name'";
														$query_results111 = $db->selectDB($log_purge_q);
															
														foreach ($query_results111['data'] as $row2) {
														
															$size = $row2[size];
															$fsize = $fsize + $size;
														}
													
														echo '<tr>
														<td> '.$log_name.' </td>';
														//echo '<td> '.$size.' MB </td>';
														echo '<td> '.$last_run.' </td>
														</tr>';
														
													
													}
													
													
													
												

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>



<?php

	//Form Refreshing avoid secret key/////
	$secret=md5(uniqid(rand(), true));
	$_SESSION['FORM_SECRET'] = $secret;


?>
<!--------------------------------------------------------------------------------------->


                                    <div class="tab-pane" id="create_camp">

										<div id="network_response"></div>

										<form   id="edit-profile" class="form-horizontal">

											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>

											<fieldset>

												<div class="control-group">

													<label class="control-label" for="radiobtns">Network Profile</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<select name="network_name" id="network_name" required>



															<?php



															$network_name = $db->setVal("network_name","ADMIN");

															//$get_2 = "SELECT `description` as f FROM exp_plugins WHERE plugin_code = '$network_name' AND `type` = 'NETWORK' LIMIT 1";

															echo '<option value="'.$network_name.'">'.$network_name.'</option>';

															$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `network_profile` <> '$network_name' AND `visible` = 1 ORDER by network_profile";



															$query_results=$db->selectDB($key_query);

															foreach ($query_results['data'] as $row) {

																$network_profile = $row[network_profile];

																//$description = $row[description];

																echo '<option value="'.$network_profile.'">'.$network_profile.'</option>';

															}



															?>



															</select>



														</div>



															<button type="button" name="submit" onclick="getInfoBox('network','network_response');"



																class="btn btn-primary">Activate</button>



															<img id="network_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



													</div>



													<!-- /controls -->



												</div>







												<!-- /control-group -->



											</fieldset>



										</form>





										<hr>



										<!--  __________________________________________________________ -->



										<form class="form-horizontal">



											<fieldset>





												<div class="control-group">







													<label class="control-label" for="radiobtns">Network Profile</label>
													<div class="controls">

														<div class="input-prepend input-append">


															<select name="network_edit" id="network_edit" required>

															<?php
															$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `visible` = 1";

															$query_results=$db->selectDB($key_query);



															foreach ($query_results['data'] as $row) {



																$network_profile = $row[network_profile];



																//$description = $row[description];



																echo '<option value="'.$network_profile.'">'.$network_profile.'</option>';



															}



															?>



															</select>



														</div>



															<button type="button" name="submit1" onclick="editNetPro();"



																class="btn btn-warning" id="edit">Edit</button>







															<img id="network_edit_loader" src="img/loading_ajax.gif"  style="visibility: hidden;">



													</div>



												</div>



											</fieldset>



										</form>



										<div id="editable"></div>



									</div>





										<!-- ==================== toc ========================= -->

									<div <?php if(isset($tab11)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="toc">

										<div id="response_">

										</div>

										<h1 class="head">Guest T&C</h1>


										<form onkeyup="submit_tocfn();" onchange="submit_tocfn();" id="submit_toc"  method="POST" action="?t=11">


											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                            $email_template = $db_class1->getEmailTemplate('TOC',$system_package,'MNO',$user_distributor);
                                            $subject = $email_template[0][title];
                                            $mail_text  = $email_template[0][text_details];
                                            echo '<input id="email_code" name="email_code" type="hidden"  value="TOC">';
                                            echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';


											?>

											<fieldset>



												<legend>Guest Terms and Conditions</legend>





						<?php if($package_functions->getSectionType('CAPTIVE_TOC_TYPE',$system_package)=="checkbox"){
							$text_arr = $db->textVal('TOC',$user_distributor);
							$text_arr1 = json_decode($text_arr, true);

							?>

									<div class="control-group" id="feild_gp_taddg_divt1">
										<label class="control-label" for="gt_mvnx">TOC 1</label>

                                                        <div class="controls col-lg-5 ">
                                                          <textarea width="100%" id="toc1" name="toc1" class="span6"><?php print_r($text_arr1['toc1']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">TOC 2</label>
                                                        <div class="controls col-lg-5 ">
                                                        <textarea width="100%" id="toc2" name="toc2" class="span6"><?php print_r($text_arr1['toc2']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">TOC 3</label>
                                                        <div class="controls col-lg-5 ">
                                                          <textarea width="100%" id="toc3" name="toc3" class="span6"><?php print_r($text_arr1['toc3']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">TOC 4</label>
                                                        <div class="controls col-lg-5 ">
                                                         <textarea width="100%" id="toc4" name="toc4" class="span6"><?php print_r($text_arr1['toc4']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">TOC 5</label>
                                                        <div class="controls col-lg-5 ">
                                                         <textarea width="100%" id="toc5" name="toc5" class="span6"><?php print_r($text_arr1['toc5']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">SUBMIT</label>
                                                        <div class="controls col-lg-5 ">
                                                        <textarea width="100%" id="submit" name="submit" class="span6"><?php print_r($text_arr1['submit']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                    	<label class="control-label" for="gt_mvnx">CANCEL</label>
                                                        <div class="controls col-lg-5">
                                                       <textarea width="100%" id="cancel" name="cancel" class="span6"><?php print_r($text_arr1['cancel']); ?></textarea>
</div>
                                                    </div>


						<?php }else{
						 ?>

												<textarea width="100%" id="toc1" name="email1" class="submit_tocta"><?php echo $mail_text; ?></textarea>











	<?php } ?>

												<div class="form-actions pd-zero-form-action">

												<button disabled type="submit" id="submit_toc_btn" name="email_form_update" class="btn btn-primary">Save</button>







												<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



												</div>
												<script>
                                                                                        function submit_tocfn() {
                                                                                        
                                                                                            $("#submit_toc_btn").prop('disabled', false);
                                                                                            }
                                                                   
                                                                                </script>











															<!-- /form-actions -->







											</fieldset>







										</form>



									</div>




										<!-- ==================== VT toc ========================= -->

									<div <?php if(isset($tab32)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="vt_toc">

<div id="response_">

</div>

<h1 class="head">vTenant T&C</h1>


<form onkeyup="vt_submit_tocfn();" onchange="vt_submit_tocfn();" id="vt_submit_toc"  method="POST" action="?t=32">


	<?php

	echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
	
	if($package_functions->getSectionType('VT_TC_TYPE',$system_package) =="LINK"){ 
		$email_template = $db_class1->getEmailTemplate('VT_TOC_LINK',$system_package,'MNO',$user_distributor);
		echo '<input id="email_code" name="email_code" type="hidden"  value="VT_TOC_LINK">';
	}else{
		$email_template = $db_class1->getEmailTemplate('VT_TOC',$system_package,'MNO',$user_distributor);
		echo '<input id="email_code" name="email_code" type="hidden"  value="VT_TOC">';
	}
	
	$subject = $email_template[0][title];
	 $mail_text  = $email_template[0][text_details];
 


	
	echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';


	?>

	<fieldset>



		<legend>vTenant Terms and Conditions</legend>

<?php if($package_functions->getSectionType('VT_TC_TYPE',$system_package) =="LINK"){ ?>
<div class="control-group">
														<label class="control-label" for="radiobtns"> T&C link<sup><font color="#FF0000"></font></sup></label>

														<div class="controls form-group">
															

																<input class="span8 form-control" id="email1" name="email1" type="text" value="<?php echo $mail_text; ?>">

															
														</div>
														<!-- /controls -->
													</div>



<?php }else{ ?>

		<textarea width="100%" id="toc1" name="email1" class="submit_vttocta"><?php echo $mail_text; ?></textarea>











<?php } ?>

		<div class="form-actions pd-zero-form-action">

		<button disabled type="submit" id="vttoc_form_update" name="vttoc_form_update" class="btn btn-primary">Save</button>







		<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



		</div>
		<script>
												function vt_submit_tocfn() {
												
													$("#vttoc_form_update").prop('disabled', false);
													}
						   
										</script>











					<!-- /form-actions -->







	</fieldset>







</form>



</div>




                                    <!-- ==================== sys_controllers ========================= -->

                                    <div <?php if(isset($tab112)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="sys_controllers">

                                        <div id="response_">



                                        </div>



                                        <form id="sys_controllers_form" class="form-horizontal" method="POST" action="?t=112">



                                            <?php

                                            echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

                                            ?>

                                            <div class="control-group">

                                                <label class="control-label" for="radiobtns">Max Sessions Per Day</label>

                                                <div class="controls col-lg-5">

                                                    <div class="input-prepend input-append">

                                                        <input class="span4" id="max_ses_per_day" name="max_ses_per_day" type="number" required value="<?php echo $db->setVal('max_sessions',$user_distributor); ?>">

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="control-group">

                                                <label class="control-label" for="radiobtns">Message</label>

                                                <div class="controls col-lg-5">

                                                    <div class="input-prepend input-append">

                                                        <textarea width="100%" id="msg_max_ses" name="msg_max_ses" class="jqte-test"><?php echo $db->setVal('max_sessions_text',$user_distributor); ?></textarea>



                                                    </div>

                                                </div>

                                            </div>



                                            <div class="form-actions">

                                                <button type="submit" name="submit_sys_con" class="btn btn-primary">Save</button>

                                                <img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

                                            </div>









                                        </form>



                                    </div>
                                    <!-- =================== aup ============================ -->

									<!-- <div class="tab-pane" id="aup"> -->
									<?php if(in_array("CONFIG_QOS",$features_array) || $system_package=='N/A'){ ?>
									<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="qos_set">




										<h1 class="head">Override QoS<img data-toggle="tooltip" title="When creating a new property a product is set as the default for all vTenants. The product has a QoS and a Duration.The “Override QoS” feature allows the property admin to temporarily override the default product QoS for an individual account. As an example, a probation profile could be used to temporarily slow down the QoS due to late payment of rent" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></h1>


										<div id="response_d3">









										</div>

										<?php if ($edit_qos_id=="1") {
											$readonly="readonly";
										}

										?>


										<form id="qos-profile_submit" class="form-horizontal" method="post" action="?t=1">

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
                                                                        foreach ($query_results_1['data'] as $sub_row) {
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

													<input type="button" value="Cancel" onclick="window.location='?t=1';" class="btn btn-primary" name="">
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
												$query_results_a=$db->selectDB($q_desc_get);
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
														window.location = "?token='.$secret.'&t=1&edit_id='.$id.'"
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
	                                                    window.location = "?token='.$secret.'&t=1&qos_rm_id='.$id.'"
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


                                    <!-- =================== aup ============================ -->

									<!-- <div class="tab-pane" id="aup"> -->
									<?php if(in_array("CONFIG_GUEST_AUP",$features_array) || $system_package=='N/A'){ ?>
									<div <?php if(isset($tab10)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="aup">







										<div id="response_d3">









										</div>



										<form id="edit-profile" class="form-horizontal" method="post" action="?t=10">











										<?php







										/*$secret=md5(uniqid(rand(), true));



										$_SESSION['FORM_SECRET2'] = $secret;*/







										echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';







										?>







											<fieldset>




















													<div class="control-group">
														<label class="control-label" for="radiobtns">AUP Link Title<sup><font color="#FF0000" ></font></sup></label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span5" id="title" name="title" type="text"  value="<?php echo $db->textTitle('AUP',$user_distributor) ?>" required>

															</div>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->













<legend>Guest AUP</legend>





													<input type="hidden" name="secret" value="<?php echo $secret; ?>">



													<textarea width="100%" id="aup1" name="aup1" class="jqte-test"><?php echo $db->textVal('AUP',$user_distributor); ?></textarea>











												<div class="form-actions">



													<button type="submit" name="submit_f" class="btn btn-primary">Save</button>



													<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>





												<!-- /form-actions -->



											</fieldset>



										</form>



									</div>
									<?php }?>








									<!-- =================== agreement ============================ -->

									<!-- <div class="tab-pane" id="agreement"> -->

									<div <?php if(isset($tab20)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="agreement2">



										<div id="response_d3">



										</div>

										<h1 class="head">Activation T&C</h1>


										<form onkeyup="submit_arg1fn();" onchange="submit_arg1fn();"  id="edit_profile_b"  method="POST" action="?t=20">



										<?php

										echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

                                        $email_template = $db_class1->getEmailTemplate('AGREEMENT',$system_package,'MNO',$user_distributor);
                                        $subject = $email_template[0][title];
                                        $mail_text  = $email_template[0][text_details];
                                        echo '<input id="email_code" name="email_code" type="hidden"  value="AGREEMENT">';
                                        echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

										?>

											<fieldset>





													<div class="control-group">
														<label class="control-label" for="radiobtns">Title<sup><font color="#FF0000" ></font></sup></label>

														<div class="controls form-group">
															

																<input class="span8 form-control" id="arg_title1" name="email_subject" type="text"  value="<?php echo $subject; ?>">

															
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->




													<input type="hidden" name="secret" value="<?php echo $secret; ?>">



													<legend>Activation Terms and Conditions</legend>

													<textarea width="100%"  id="argeement1" name="email1" class="submit_arg1ta"><?php echo $mail_text; ?></textarea>











												<div class="form-actions pd-zero-form-action">



													<button disabled type="submit" name="email_form_update"  id="submit_arg1" class="btn btn-primary">Save</button>



													<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>
												
												<script>
                                                                                                        function submit_arg1fn() {
                                                                                                       
                                                                                                            $("#submit_arg1").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>





												<!-- /form-actions -->



											</fieldset>



										</form>



									</div>





										<!-- =================== agreement ============================ -->

									<!-- <div class="tab-pane" id="agreement"> -->

									<div <?php if(isset($tab13)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="agreement">



										<div id="response_d3">



										</div>

										<form onkeyup="activation_admin1fn();" onchange="activation_admin1fn();" id="edit-profile"  method="POST" action="?t=13">



										<?php

										echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                        $email_template = $db_class1->getEmailTemplate('AGREEMENT',$system_package,'ADMIN');
                                        $subject = $email_template[0][title];
                                        $mail_text  = $email_template[0][text_details];
                                        echo '<input id="email_code" name="email_code" type="hidden"  value="AGREEMENT">';
                                        echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$system_package.'">';
										?>

											<fieldset>





													<div class="control-group">
														<label class="control-label" for="radiobtns">Title<sup><font color="#FF0000" ></font></sup></label>

														<div class="controls">
															<div class="input-prepend input-append">

																<input class="span8" id="arg_title" name="email_subject" type="text"  value="<?php echo $subject; ?>" required>

															</div>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->




													<input type="hidden" name="secret" value="<?php echo $secret; ?>">



													<legend>Operator Activation Terms and Conditions</legend>

													<textarea width="100%"  id="argeement" name="email1" class="activation_adminta"><?php echo $mail_text; ?></textarea>











												<div class="form-actions pd-zero-form-action">



													<button disabled type="submit" id="activation_admin1" name="email_form_update" class="btn btn-primary">Save</button>



													<img id="aup_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
													<script>
                                                                                        function activation_admin1fn() {
                                                                                        
                                                                                            $("#activation_admin1").prop('disabled', false);
                                                                                            }
             
                                                                                </script>

												</div>





												<!-- /form-actions -->



											</fieldset>



										</form>



									</div>





										<!-- ================== e-mail ========================== -->

									<div <?php if(isset($tab21)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="email" >

										<div id="email_response"></div>
										
										<div id="response_d3">
										</div>

										<h1 class="head">Email Templates</h1>



<?php 
// OPS ADMIN CREATION TEMPLATE
if($user_type == 'ADMIN'){

?>	

<form onkeyup="active_email_submitfn();" onchange="active_email_submitfn();"     id="edit-profile"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;	
Support Phone Number : {$support_number}&nbsp;|&nbsp;										
Activation Link : {$link}&nbsp;&nbsp;

<br><br>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">
		
<?php 

$email_template = $db_class1->getEmailTemplate('MAIL',$system_package,'ADMIN');
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$system_package.'">';

?>
<input class="span8 form-control" id="email_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
</div>

<textarea class="active_email_submit_tarea"  width="100%" id="email1" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >
    <input disabled type="submit" value="Save" name="email_form_update" id="active_email_submit" class="btn btn-primary">
</div>
<script>
function active_email_submitfn() {
$("#active_email_submit").prop('disabled', false);
}
</script>
<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">
</fieldset>

</form>


<?php } 




// PARENT INVITE Template
if($user_type == 'MNO'){

?>	
																		
<form onkeyup="active_email_submitfn();" onchange="active_email_submitfn();"     id="edit-profile"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
<?php if($package_functions->getOptions('VENUE_ACTIVATION_TYPE',$system_package)=="ICOMMS NUMBER"){?>
Business ID: {$business_id}&nbsp;&nbsp;|&nbsp;
<?php }else{?>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
<?php } ?>
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;

<br><br>
<?php 

$email_template = $db_class1->getEmailTemplate('PARENT_INVITE_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="PARENT_INVITE_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->




<textarea class="active_email_submit_tarea"  width="100%" id="email1" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >

<input disabled type="submit" value="Save" name="email_form_update" id="active_email_submit" class="btn btn-primary">

</div>
<script>
function active_email_submitfn() {
                                                                                                       
$("#active_email_submit").prop('disabled', false);
 }
</script>


<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

</fieldset>

</form>

<?php } ?>






<?php 
// User Activation Template
//echo $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package);
if($user_type == 'MNO' && $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package)=="own"){

?>
	<form onkeyup="active_user_email_submitfn();" onchange="active_user_email_submitfn();" id="edit-profile"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>User Activation Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;

<br><br>
<?php 

	$email_template = $db->getEmailTemplate('USER_MAIL',$system_package,'MNO',$user_distributor);
	$subject = $email_template[0][title];
	$mail_text  = $email_template[0][text_details];
	echo '<input id="email_code" name="email_code" type="hidden"  value="USER_MAIL">';
	echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_user_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->

<textarea class="active_user_email_submit_tarea"  width="100%" id="active_user_email_submit_tarea" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >
<input disabled type="submit" value="Save" name="email_form_update" id="active_user_email_submit" class="btn btn-primary">
</div>
<script>
function active_user_email_submitfn() {
$("#active_user_email_submit").prop('disabled', false);
}
</script>

<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

<!-- /form-actions -->

</fieldset>
<!--- //////////////////////////////////    Property Account                      ///////////////////////////////////////////// --->
</form>
<?php }
?>

<?php
if($user_type == 'MNO' && $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package)=="own"){

?>
<form onkeyup="active_property_submitfn();" onchange="active_property_submitfn();" id="edit-profile1"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend> Property Admin Activation</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
<!--User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;--> 
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;|&nbsp;
Property Id : {$property_id}&nbsp;&nbsp;


<br><br>
<?php 

	$email_template = $db->getEmailTemplate('VENUE_ADD_ADMIN',$system_package,'MNO',$user_distributor);
	$subject = $email_template[0][title];
	$mail_text  = $email_template[0][text_details];
	echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_ADD_ADMIN">';
	echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_user_subject_main1" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->

<textarea class="active_user_email_submit_tarea1"  width="100%" id="active_user_email_submit_tarea1" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >
<input disabled type="submit" value="Save" name="email_form_update" id="active_property_submit" class="btn btn-primary">
</div>
<script>
function active_property_submitfn() {
$("#active_property_submit").prop('disabled', false);
}
</script>

<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

<!-- /form-actions -->

</fieldset>

</form>
<?php }
?>




<?php 
// User Activation Template
//echo $package_functions->getSectionType('EMAIL_USER_TEMPLATE',$system_package);
if($user_type == 'ADMIN'){

?>
	<form onkeyup="active_user_email_submitfn();" onchange="active_user_email_submitfn();" id="edit-profile"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>User Activation Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;

<br><br>
<?php 

$email_template = $db->getEmailTemplate('USER_MAIL',$system_package,'ADMIN');
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="USER_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$system_package.'">';
          


?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_user_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->

<textarea class="active_user_email_submit_tarea"  width="100%" id="active_user_email_submit_tarea" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >
<input disabled type="submit" value="Save" name="email_form_update" id="active_user_email_submit" class="btn btn-primary">
</div>
<script>
function active_user_email_submitfn() {
$("#active_user_email_submit").prop('disabled', false);
}
</script>

<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

<!-- /form-actions -->

</fieldset>

</form>
<?php }
?>





<?php if($user_type != 'ADMIN'){ ?>
<form onkeyup="venue_activated_emailfn();" onchange="venue_activated_emailfn();" id="venue_activated_email" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
                                                <legend>Activation Confirmation Email</legend>
                                                <h6>TAG Description </h6>
                                                User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
                                                Portal Link : {$link}&nbsp;&nbsp;|&nbsp;Rest Link : {$reset_link}&nbsp;&nbsp;|&nbsp;Support Phone Number : {$support_number}&nbsp;|&nbsp;User ID : {$user_ID}&nbsp;&nbsp;|&nbsp;Customer Account # : {$account_number}<br>
 <br>
<?php 

$email_template = $db_class1->getEmailTemplate('VENUE_CONFIRM_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_CONFIRM_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
?>
                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
                                                    <div class="controls form-group">

                                                        <input class="span8 form-control" id="email_subject_activated" name="email_subject" type="text"  value="<?php echo $subject; ?>"/>
                                                    </div>
                                                    <!-- /controls -->
                                                </div>
                                                <!-- /control-group -->


                                                <textarea  width="100%" id="email_activated" name="email1" class="venue_activated_confirm">
                                                <?php echo $mail_text; ?></textarea>

                                                <div class="form-actions pd-zero-form-action" >

                                                    <input disabled type="submit" value="Save" name="email_form_update" id="email_activated_sub" class="btn btn-primary">

                                                </div>
                                                <script>
                                                    function venue_activated_emailfn() {

                                                        $("#email_activated_sub").prop('disabled', false);

                                                    }

                                                </script>


                                                <!-- /form-actions -->

                                            </fieldset>

                                        </form>
                                        <?php } ?>





                                        <?php if($user_type != 'ADMIN'){ ?>
                                        <form onkeyup="new_venue_activated_emailfn();" onchange="new_venue_activated_emailfn();" id="new_venue_activated_email" method="post" action="?t=21">
                                            <?php
                                            echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                            ?>

                                            <fieldset>
                                                <legend>New Location Email</legend>
                                                <h6>TAG Description </h6>
                                                User Full Name : {$user_full_name}&nbsp;&nbsp;|
                                                &nbsp;Support Phone Number : {$support_number}&nbsp;|&nbsp;Portal Link : {$link}&nbsp;&nbsp;|
                                                &nbsp;Customer Account # : {$account_number}<br>
                                                <br>
<?php 

$email_template = $db_class1->getEmailTemplate('VENUE_NEW_LOCATION',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="VENUE_NEW_LOCATION">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

?>
                                                <div class="control-group">
                                                    <label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
                                                    <div class="controls form-group">

                                                        <input class="span8 form-control" id="new_location_activated" name="email_subject" type="text"  value="<?php echo $subject; ?>"/>
                                                    </div>
                                                    <!-- /controls -->
                                                </div>
                                                <!-- /control-group -->


                                                <textarea  width="100%" id="new_location_activated_email" name="email1" class="new_location_activated_email">
                                                <?php echo $mail_text; ?>
                                                    </textarea>

                                                <div class="form-actions pd-zero-form-action" >

                                                    <input disabled type="submit" value="Save" name="email_form_update" id="new_location_activated_sub" class="btn btn-primary">

                                                </div>
                                                <script>
                                                    function new_venue_activated_emailfn() {
                                                        //alert();

                                                        $("#new_location_activated_sub").prop('disabled', false);

                                                    }

                                                </script>


                                                <!-- /form-actions -->

                                            </fieldset>

                                        </form>
                                        <?php } ?>





<?php if($user_type == 'ADMIN'){ ?>

<form onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" id="active_sup_email"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email (Support)</legend>
<h6>TAG Description </h6>
User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;

<?php 

$email_template = $db_class1->getEmailTemplate('SUPPORT_MAIL',$system_package,'ADMIN');
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="SUPPORT_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$system_package.'">';
?>
<br><br>

<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_subject_sup_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>

<textarea class="active_sup_email_submit_tarea"  width="100%" id="sup_email1" name="email1" >
<?php echo $mail_text; ?>
</textarea>
<div class="form-actions pd-zero-form-action" >
<input disabled type="submit" value="Save" name="email_form_update" id="active_sup_email_submit" class="btn btn-primary">


                                                                                                </div>
                                                                                                 <script>
                                                                                                        function active_sup_email_submitfn() {
                                                                                                       
                                                                                                            $("#active_sup_email_submit").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>

<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

<!-- /form-actions -->

</fieldset>

</form>

<?php }


?>
										
										
										

  <?php if($user_type == 'MNO'){
if($package_functions->getSectionType('EMAIL_SUPPORT_TEMPLATE',$system_package)=="own"){
?>

<form onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();"     id="active_sup_email"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email (Support)</legend>
<h6>TAG Description </h6>
User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;
<br><br>
<?php 

$email_template = $db_class1->getEmailTemplate('SUPPORT_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="SUPPORT_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_subject_sup_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->

<textarea class="active_sup_email_submit_tarea"  width="100%" id="sup_email1" name="email1" >
<?php echo $mail_text; ?>
</textarea>
 <div class="form-actions pd-zero-form-action" >

    <input disabled type="submit" value="Save" name="email_form_update" id="active_sup_email_submit" class="btn btn-primary">


                                                                                                </div>
                                                                                                 <script>
                                                                                                        function active_sup_email_submitfn() {
                                                                                                       
                                                                                                            $("#active_sup_email_submit").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>


<img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

<!-- /form-actions -->

</fieldset>

</form>

<?php }
?>

										
										
										
<form onkeyup="email_subject_passcodeifn();" onchange="email_subject_passcodeifn();"  id="passcode_email_form" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>

<fieldset>
<legend>Passcode Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
<?php if($package_functions->getOptions('VENUE_ACTIVATION_TYPE',$system_package)=="ICOMMS NUMBER"){?>

Customer Account: {$account_number}&nbsp;&nbsp;|&nbsp;
Business Name : {$business_name}&nbsp;&nbsp;|&nbsp;
<br>
Passcode : {$passcode}&nbsp;&nbsp;|&nbsp;
Valid from : {$valid_from}&nbsp;&nbsp;|&nbsp;
Valid to : {$valid_to}&nbsp;&nbsp;|&nbsp;
<?php }else{?>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;

<?php } ?>
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Portal Link : {$link}&nbsp;&nbsp;<br><br>

<?php 

$email_template = $db_class1->getEmailTemplate('PASSCODE_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="PASSCODE_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';

?>

<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">
<input class="span8 form-control" id="email_subject_passcode" name="email_subject" type="text"  value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->

<textarea class="passcode_email_formta" width="100%" id="email2" name="email1">
<?php echo $mail_text; ?>
</textarea>

                                                                                                <div class="form-actions pd-zero-form-action" >

    <input disabled type="submit" value="Save" name="email_form_update" id="email_subject_passcodei" class="btn btn-primary">

                                                                                                </div>
                                                                                                
                                                                                                <script>
                                                                                                        function email_subject_passcodeifn() {
                                                                                                       
                                                                                                            $("#email_subject_passcodei").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>



<!-- /form-actions -->

</fieldset>

</form>

	<?php 
		$isTechAdmin = $package_functions->getOptions('MASTER_TECH_ADMIN',$system_package);
	?>

	<?php if($isTechAdmin== 'NO'){ ?>

		<!-- No need to display Master tech admin-->

	<?php }else{?>

      <form onkeyup="tech_emailfn();" onchange="tech_emailfn();" id="tech_activation__email" method="post" action="?t=21">
          <?php
          echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
          ?>

          <fieldset>
              <legend>Activation Email (Tech)</legend>
              <h6>TAG Description </h6>
              User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp; Activation Link : {$link}&nbsp;&nbsp;|&nbsp; User Name : {$user_name}&nbsp;&nbsp;|&nbsp;Password : {$password}&nbsp;&nbsp;|&nbsp;Support Phone Number : {$support_number}&nbsp;|&nbsp;Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;Account Type : {$account_type}<br>
              <br>
              <?php

              $email_template = $db_class1->getEmailTemplate('TECH_INVITE_MAIL',$system_package,'MNO',$user_distributor);
              $subject = $email_template[0][title];
              $mail_text  = $email_template[0][text_details];
              echo '<input id="email_code" name="email_code" type="hidden"  value="TECH_INVITE_MAIL">';
              echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
              ?>
              <div class="control-group">
                  <label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
                  <div class="controls form-group">

                      <input class="span8 form-control" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
                  </div>
                  <!-- /controls -->
              </div>
              <!-- /control-group -->


              <textarea  width="100%" id="email4" name="email1" class="email_tech">
<?php echo $mail_text;
?></textarea>

              <div class="form-actions pd-zero-form-action" >

                  <input disabled type="submit" value="Save" name="email_form_update" id="tech_form_update" class="btn btn-primary">

              </div>
              <script>
                  function tech_emailfn() {

                      $("#tech_form_update").prop('disabled', false);

                  }

              </script>


              <!-- /form-actions -->

          </fieldset>

      </form>

      <?php } ?>

      <form onkeyup="hardware_emailfn();" onchange="hardware_emailfn();" id="hardware_info_email" method="post" action="?t=21">
          <?php
          echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
          ?>

          <fieldset>
              <legend>Hardware Details Email</legend>
              <h6>TAG Description </h6>
              Business ID : {$business_id}&nbsp;&nbsp;|&nbsp;
              Location ID : {$account_number}&nbsp;&nbsp;|&nbsp;
              Hardware Details : {$hardware_table}&nbsp;&nbsp;|&nbsp;
              User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
              Support Phone Number : {$support_number}&nbsp;|&nbsp;
              Portal Link : {$link}
              <br>
              <br>
              <?php

              $email_template = $db_class1->getEmailTemplate('HARDWARE_DETAIL_MAIL',$system_package,'MNO',$user_distributor);
              $subject = $email_template[0][title];
              $mail_text  = $email_template[0][text_details];
              echo '<input id="email_code" name="email_code" type="hidden"  value="HARDWARE_DETAIL_MAIL">';
              echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
              ?>
              <div class="control-group">
                  <label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
                  <div class="controls form-group">

                      <input class="span8 form-control" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
                  </div>
                  <!-- /controls -->
              </div>
              <!-- /control-group -->


              <textarea  width="100%" id="email5" name="email1" class="email_hardware">
<?php echo $mail_text;
?></textarea>

              <div class="form-actions pd-zero-form-action" >

                  <input disabled type="submit" value="Save" name="email_form_update" id="hardware_email_update" class="btn btn-primary">

              </div>
              <script>
                  function hardware_emailfn() {

                      $("#hardware_email_update").prop('disabled', false);

                  }

              </script>


              <!-- /form-actions -->

          </fieldset>

      </form>



  <?php }
?>										
										
										
										
										
										
<form onkeyup="password_reset_emailfn();" onchange="password_reset_emailfn();" id="password_reset_email" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>

<fieldset>
<legend>Password Reset Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}<br>
<br>
<?php 

$email_template = $db_class1->getEmailTemplate('PASSWORD_RESET_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="PASSWORD_RESET_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_subject_pass_reset" name="email_subject" type="text" value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->


<textarea  width="100%" id="email3" name="email1" class="password_reset_emailta">
<?php echo $mail_text;
?></textarea>

                                                                                                <div class="form-actions pd-zero-form-action" >

    <input disabled type="submit" value="Save" name="email_form_update" id="email_pass_reset" class="btn btn-primary">

                                                                                                </div>
                                                                                                <script>
                                                                                                        function password_reset_emailfn() {
                                                                                                       
                                                                                                            $("#email_pass_reset").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>


<!-- /form-actions -->

</fieldset>



<!--tech-->

</form>

<?php

//echo  $package_functions->getOptions('VTENANT_MODULE',$system_package) ;

if($package_functions->getOptions('VTENANT_MODULE',$system_package) == "Vtenant"){ ?>

<form onkeyup="vt_noytification_emailfn();" onchange="vt_noytification_emailfn();" id="vt_noytification_email" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>

<fieldset>
<legend>VTenant Portal Email Notification</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Support Phone Number : {$support_number}&nbsp;|&nbsp;
Activation Link : {$link}&nbsp;&nbsp;|&nbsp;User Name : {$user_name}&nbsp;&nbsp;|&nbsp;Password : {$password}&nbsp;&nbsp;|&nbsp;Property Name : {$Property_Name}<br>
<br>
<?php 

$email_template = $db_class1->getEmailTemplate('CUSTOMER_MAIL',$system_package,'MNO',$user_distributor);
$subject = $email_template[0][title];
$mail_text  = $email_template[0][text_details];
echo '<input id="email_code" name="email_code" type="hidden"  value="CUSTOMER_MAIL">';
echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';
?>
<div class="control-group">
<label class="control-label" for="radiobtns">Email Subject<sup><font color="#FF0000" ></font></sup></label>
<div class="controls form-group">

<input class="span8 form-control" id="email_subject_vt_noytification" name="email_subject" type="text" value="<?php echo $subject; ?>">
</div>
<!-- /controls -->
</div>
<!-- /control-group -->


<textarea  width="100%" id="email3" name="email1" class="vt_notification">
<?php echo $mail_text;
?></textarea>

                                                                                                <div class="form-actions pd-zero-form-action" >

    <input disabled type="submit" value="Save" name="email_vt_noytification" id="email_vt_noytification" class="btn btn-primary">

                                                                                                </div>
                                                                                                <script>
                                                                                                        function vt_noytification_emailfn() { 
                                                                                                       
                                                                                                            $("#email_vt_noytification").prop('disabled', false);
                                                                                                                                                                                 
                                                                                                        }
                                                                                                     
                                                                                                </script>


<!-- /form-actions -->

</fieldset>



<!--tech-->

</form>

<?php } ?>


</div>










										<!-- ==================== registration ==================== -->
									<?php if(in_array("CONFIG_REGISTER",$features_array)){?>
									<div class="tab-pane <?php if(isset($tab22)){ ?>active <?php } ?>" id="registration">
                                    
                                    
                                    
                                    <form id="fb_form" method="post" action="?t=22" name ="fb_form" class="form-horizontal"style="display: none;">
                                    
                                    <legend>Facebook</legend>

												<div id="fb_response"></div>
												<div class="control-group">
													<label class="control-label" for="radiobtns">Facebook App ID</label>
													<div class="controls">
														<div class="input-prepend input-append">
														<input class="span4" id="fb_app_id" name="fb_app_id" type="text" value="<?php echo $db->setSocialVal("FACEBOOK","app_id",$user_distributor); ?>" required>
														</div>
													</div>
													<!-- /controls -->
											</div>

											<!-- /control-group -->
												<?php
														$rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_social_profile'");
														//$rowe = mysql_fetch_array($br);
														$auto_increment = $rowe['Auto_increment'];
														$social_profile = 'social_'.$auto_increment;
												?>

											<input class="span4" id="social_profile" name="social_profile" type="hidden" value="<?php echo $social_profile; ?>" >
												<input class="span4" id="app_xfbml" name="app_xfbml" type="hidden" value="true" >
												<input class="span4" id="app_cookie" name="app_cookie" type="hidden" value="true" >
												<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>" >
												<div class="control-group">
													<label class="control-label" for="radiobtns">Facebook App Version</label>
													<div class="controls">
											<div class="input-prepend input-append">
												<input class="span4" id="fb_app_version" name="fb_app_version" type="text" value="<?php echo $db->setSocialVal("FACEBOOK","app_version",$user_distributor); ?>" required>
													</div>
													</div>
												</div>
                                        <?php
                                        $q1 = "SELECT `config_file` FROM `exp_plugins` WHERE `plugin_code` = 'FACEBOOK'";
                                        $r1 = $db->selectDB($q1);
                                        foreach ($r1['data'] as $row) {
                                            $additionalFields = strlen($row[config_file])>0?'1':'0';

                                            $array_plugin =  explode(',', $row[config_file]);
                                        }

                                        if($additionalFields=='1'){?>
												<div class="control-group">
													<label class="control-label" for="radiobtns">Facebook Additional Fields</label>

											<?php


													$q11 = "SELECT `fields` FROM `exp_social_profile` WHERE `social_media` = 'FACEBOOK' AND `distributor` = '$user_distributor'";
													$r11 = $db->selectDB($q11);
													foreach ($r11['data'] as $row1) {
														$array_db_field =  explode(',', $row1[fields]);
													}


													foreach ($array_plugin as $arr) {

                                                        echo '<div class="controls">
														<div class="input-prepend input-append">';

                                                        if (in_array($arr, $array_db_field)) {
                                                            echo '<input name="fb_fields[]" id="fb_fields" type="checkbox" value="' . $arr . '" checked> ' . $arr . ' <br>';
                                                        } else {

                                                            echo '<input name="fb_fields[]" id="fb_fields" type="checkbox" value="' . $arr . '"> ' . $arr . ' <br>';

                                                        }
                                                        echo '</div>
												</div>
												</div>';


                                                    }
													}

											?>


								<div class="form-actions">

										<button name="fb_submit" type="submit"

														class="btn btn-primary">Save</button>

									<img id="fb_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

											</div>

														<!-- /form-actions -->

									</fieldset>   
                                    
                                    </form>
                                    
                                    

										<form id="manual_reg" class="form-horizontal" action="" method="POST" name="manual_reg">


											<?php


											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';



											?>
                                            
                                           
											<fieldset>

												<legend>Manual Registration</legend>


												<div id="manual_response"></div>

												<div class="col-sm-6">


													<div class="control-group">

														<label class="control-label" for="radiobtns">First Name</label>

														<div class="controls">

															<div class="input-prepend input-append">



															<?php

																//$mno = $parent;

																$r = $db->getManualReg('first_name', $mno_id, $user_distributor);

																if ($r == 1) {

																	echo '<input id="m_first_name" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																} else {

																	echo '<input id="m_first_name" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																}

															?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->





													<div class="control-group">

														<label class="control-label" for="radiobtns">Last Name</label>



														<div class="controls">

															<div class="input-prepend input-append">

															<?php

																$r = $db->getManualReg('last_name', $mno_id, $user_distributor);

																if ($r == 1) {

																	echo '<input id="m_last_name" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																} else {

																	echo '<input id="m_last_name" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																}

															?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->


													<div class="control-group">

														<label class="control-label" for="radiobtns">E-mail</label>

														<div class="controls">

															<div class="input-prepend input-append">


															<?php



																$r = $db->getManualReg('email', $mno_id, $user_distributor);

																if ($r == 1) {


																	echo '<input id="m_email" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';



																} else {


																	echo '<input id="m_email" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';


																}


															?>


															</div>


														</div>

														<!-- /controls -->

													</div>


													<!-- /control-group -->


													<?php

															$rowe = $db->select1DB("SHOW TABLE STATUS LIKE 'exp_manual_reg_profile'");

															//$rowe = mysql_fetch_array($br);
															$auto_increment = $rowe['Auto_increment'];
															$manual_profile = 'manual_'.$auto_increment;

													?>

													<input class="span4" id="manual_profile" name="manual_profile" type="hidden" value="<?php echo $manual_profile; ?>" >


													<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>" >

												</div>



												<div class="col-sm-6">

													<div class="control-group">

														<label class="control-label" for="radiobtns">Gender</label>



														<div class="controls">

															<div class="input-prepend input-append">


															<?php


																$r = $db->getManualReg('gender', $mno_id, $user_distributor);
																if ($r == 1) {

																	echo '<input id="m_gender" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';


																} else {

																	echo '<input id="m_gender" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																}

															?>


															</div>







														</div>







													</div>


													<div class="control-group">

														<label class="control-label" for="radiobtns">Age Group</label>

														<div class="controls">







															<div class="input-prepend input-append">

															<?php


																$r = $db->getManualReg('age_group', $mno_id, $user_distributor);
																if ($r == 1) {

																	echo '<input id="m_age_group" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';


																} else {

																	echo '<input id="m_age_group" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																}


															?>

															</div>

														</div>

													</div>


													<div class="control-group">

														<label class="control-label" for="radiobtns">Mobile Number</label>



														<div class="controls">

															<div class="input-prepend input-append">

															<?php

																$r = $db->getManualReg('mobile_number', $mno_id, $user_distributor);

																if ($r == 1) {

																	echo '<input id="m_mobile_num" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																} else {

																	echo '<input id="m_mobile_num" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';

																}

															?>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->




												</div>


												<div class="form-actions">

													<button type="button" name="manual_reg" onclick="getInfoBox('manual','manual_response')"

														class="btn btn-primary">Save</button>
														<img id="manual_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



												</div>


														<!-- /form-actions -->

											</fieldset>

										</form>


										<form id="edit_profile" class="form-horizontal"

											action="stock.php" method="POST" name="edit_profile">


											<?php


											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';


											?>



											<fieldset>


											<!-- <fieldset>







												<legend>Twitter</legend>







												<div id="twitter_response"></div>







												<div class="control-group">







													<label class="control-label" for="radiobtns">Twitter Sign IN option</label>















													<div class="controls">







														<div class="input-prepend input-append">







														<input type="checkbox" name="twitter_status" > Enable















														</div>







													</div>







												</div>















												<div class="control-group">







													<label class="control-label" for="radiobtns">Twitter App ID</label>















													<div class="controls">







														<div class="input-prepend input-append">















														<input class="span4" id="twitter_ap_id" name="twitter_ap_id" type="text" value=" " required="required">















														</div>







													</div>







												</div>















												<div class="form-actions">







													<button type="button" name="submit"







														class="btn btn-primary">Save</button>







														<img id="twitter_loader" src="img/loading_ajax.gif" style="visibility: hidden;">















												</div>







											</fieldset>	 -->







										</form>



									</div>
									<?php } ?>






										<!-- ======================= live_camp =============================== -->

									<div <?php if(isset($tab1) && $user_type == 'ADMIN'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp">

									<?php

									//echo $package_functions->getOptions('CONFIG_GENARAL_FIELDS',$system_package);
										  $tab1_field_ar=json_decode($package_functions->getOptions('CONFIG_GENARAL_FIELDS',$system_package),true);
										//print_r($tab1_field_ar);
									?>

										<div id="system_response"></div>



										<h3>ADMIN - Portal Image </h3>

										<p>Recommend Size (160 x 30 px)</p>

										<div>

											<?php


											$url = '?type=admin_tlogo&id=ADMIN'; ?>

											<form onkeyup="edit_profilefn();" onchange="edit_profilefn();" id="imageform5" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

												<label class="btn btn-primary">
																			Browse Image
																			<span> <input type="file" name="photoimg5" id="photoimg5" /></span>
																			</label>

											</form>



											<?php

											$key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'site_logo' LIMIT 1";

											$query_results=$db->selectDB($key_query);

											foreach ($query_results['data'] as $row) {
												$settings_value = $row[settings_value];

											}

											?>

											<div id='img_preview5'>

												<?php

												if(strlen($settings_value)){?>

												<img src="image_upload/logo/<?php echo $settings_value; ?>" border="0" style="background-color:#ddd;width: 100%; max-width: 200px;" />

												<?php }

												else{

													echo 'No Image';

												}?>

											</div>

										</div>





											<br><br>











										<form onkeyup="edit_profilefn();" onchange="edit_profilefn();" id="edit_profile_c" class="form-horizontal" >



										<?php

										echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
										echo '<input type="hidden" name="header_logo_img5" id="header_logo_img5" value="'.$settings_value.'" />';

										?>





											<fieldset>

												<div class="control-group" <?php

													if(!array_key_exists('site_title',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?> >

													<label class="control-label" for="radiobtns">Site Title</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="main_title" name="main_title" type="text" value="<?php echo $db->setVal("site_title",$user_distributor); ?>">

														

													</div>

												</div>

												<div class="control-group" <?php

													if(!array_key_exists('login_title',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?> >

													<label class="control-label" for="radiobtns">Login Title</label>

													<div class="controls form-group">



															<input class="span4 form-control" id="login_title" name="login_title" type="text" value="<?php echo $db->setVal("login_title",$user_distributor); ?>">



													</div>

												</div>




												<div class="control-group"  <?php
												if(!array_key_exists('admin_email',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  >

													<label class="control-label" for="radiobtns">Admin Email</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="master_email" name="master_email" type="text" value="<?php echo $db->setVal("email",$user_distributor); ?>">

														

													</div>

												</div>















												<div class="control-group"  <?php
												if(!array_key_exists('captive_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?> style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Captive Portal Internal URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="base_url"  name="base_url" type="text" value="<?php echo $db->setVal("portal_base_url",$user_distributor); ?>">
															

														

													</div>
													

												</div>
												<div class="control-group">
													<div class="controls form-group">
													 <font size="1">Ex: http://10.1.1.1/Ex-portal</font>
													</div>
												</div>
												<!--REDIRECT URL-->
												<?php /*
												onkeyup="setRedirectURL();"
												<script type="text/javascript">
													function setRedirectURL(){
														var base_url=document.getElementById("base_url").value;
														document.getElementById("captive_portal_url").value=base_url+"/checkpoint.php";
													}
												</script>


												<div class="control-group">

													<label class="control-label" for="radiobtns">Redirection URL</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<input readonly class="span4" id="captive_portal_url" name="captive_portal_url" type="text" value="<?php echo $db->setVal("captive_portal_url",$user_distributor); ?>" required="required">

														</div>

													</div>

												</div>*/	?>







												<div class="control-group"  <?php
												if(!array_key_exists('captive_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Campaign Portal Internal URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="camp_url" name="camp_url" type="text" value="<?php echo $db->setVal("camp_base_url",$user_distributor); ?>">
															

														

													</div>
													

													<div class="control-group">
													<div class="controls form-group">
													<font size="1">Ex: http://10.1.1.1/campaign_portal</font>
													</div>
												</div>	


												</div>
												



												
												
												
												
												
												<div class="control-group"  <?php
												if(!array_key_exists('global_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Campaign Portal Global URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="global_url" name="global_url" type="text" value="<?php echo $db->setVal("global_url",$user_distributor); ?>">
															

														

													</div>
													
													
													<div class="control-group">
													<div class="controls form-group">
													<font size="1">Ex: http://yourcompany.com/campaign_portal</font>
													</div>
												</div>
													

												</div>
												
												

												
												<div class="control-group"  <?php
												if(!array_key_exists('mdu_camp_base_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Tenant Portal URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="tenant_url" name="tenant_url" type="text" value="<?php echo $db->setVal("mdu_camp_base_url",$user_distributor); ?>">
															

														

													</div>
													
													<div class="control-group">
													<div class="controls form-group">
													<font size="1">Ex: http://yourcompany.com/tenant</font>
													</div>
												</div>
													

												</div>
												
												
												
												


												<div class="control-group" <?php
												if(!array_key_exists('menu_option',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none"';}
												?> >

													<label class="control-label" for="radiobtns">Menu Option</label>

													<div class="controls form-group">

														

															<select class="span4 form-control" id="menu_type" name="menu_type">

																<?php $menu_type = $db->setVal("menu_type",'ADMIN'); ?>

																<option value="SUB_MENU">Sub menu</option>

																<option value="MAIN_MENU">Main menu</option>

															</select>

														

													</div>

												</div>









                                                <div id="st_type" class="control-group"   <?php
												if(!array_key_exists('style_type',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  >

                                                    <label class="control-label" for="radiobtns">Style Type</label>





                                                    <div class="controls form-group">

                                                        

                                                            <select class="span4 form-control" id="style_type" name="style_type">

                                                                <option value="dark" <?php if($style_type == 'dark'){ echo 'selected'; } ?> > Dark Style </option>

                                                                <option value="light" <?php if($style_type == 'light'){ echo 'selected'; } ?> > Light Style </option>

                                                            </select>

                                                        

                                                    </div>



                                                </div>



<!-- https -->

											<div class="control-group"   <?php
												if(!array_key_exists('style_type',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  >

                                                    <label class="control-label" for="radiobtns">HTTPS</label>



<?php $edit_ssl_on= $db->setVal("SSL_ON",$user_distributor); ?>

                                                    <div class="controls form-group">

                                                       

                                                            <select class="span4 form-control" id="ssl_on" name="ssl_on">

                                                                <option value="1" <?php if($edit_ssl_on == '1'){ echo 'selected'; } ?> > ON </option>

                                                                <option value="0" <?php if($edit_ssl_on == '0'){ echo 'selected'; } ?> > OFF </option>

                                                            </select>

                                                        

                                                    </div>



                                                </div>


												<div class="control-group"   <?php
												if(!array_key_exists('platform',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												//if(true){echo' style="display:none";';}
												?>  >

                                                    <label class="control-label" for="radiobtns">Platform</label>



<?php  $platform= $db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='ADMIN'") ; ?>


<?php if($platform!='N/A'){ ?>

<script type="text/javascript">

//N/A

$(document).ready(function() {

	$('#st_type').hide();


    });


</script>
<?php } ?>

                                                    <div class="controls form-group">

                                                        

                                                            <select class="span4 form-control" id="platform" name="platform">
																<?php
																//echo"SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN'";
																	$flatforms_q=$db->selectDB("SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN'");
																foreach ($flatforms_q['data'] as $flatforms) {
																	if($platform==$flatforms['product_code']){
																	echo'<option selected value='.$flatforms['product_code'].' > '.$flatforms['discription'].' </option>';
																	}else{
																	echo'<option value='.$flatforms['product_code'].' > '.$flatforms['discription'].' </option>';
																	}
																}
																?>

                                                            </select>

                                                        

                                                    </div>



                                                </div>

												<script type="text/javascript">
													$('#platform').on('change',function () {

														if($('#platform').val()!='N/A'){

															var platform = $('#platform').val();
															var formData={"action":"admin_header_color_bar","platform":platform};
															$.ajax({
																url : "ajax/getData.php",
																type: "POST",
																data : formData,
																success: function(data)
																{
																	var obj=data.split('/');



																	if(obj.indexOf("theme_color")>0){
																		$('#theme_color_div').show();
																	}else{
																		$('#theme_color_div').hide();
																	}
																	if(obj.indexOf("light_color")>0){
																		$('#light_color_div').show();
																	}else{
																		$('#light_color_div').hide();
																	}
																	if(obj.indexOf("top_line_color")>0){
																		$('#top_line_color_div').show();
																	}else{
																		$('#top_line_color_div').hide();
																	}
																	$('#st_type').hide();
																	
																},
																error: function (jqXHR, textStatus, errorThrown)
																{
																	//alert("error");
																}
															});
														}else{
															$('#top_line_color_div').show();
															$('#theme_color_div').show();
															$('#light_color_div').show();
															$('#st_type').show();
														}
													});
												</script>


<?php 

$get_l = "SELECT * FROM exp_mno

WHERE mno_id = '$user_distributor' LIMIT 1";

$query_results=$db->selectDB($get_l);

foreach ($query_results['data'] as $row) {

	$camp_theme_color = $row[theme_color];

}


//echo $camp_theme_color;
?>






                                                <div id="theme_color_div" class="control-group"   <?php
												if(!array_key_exists('theme_color',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  >

                                                    <label class="control-label" for="radiobtns"> Accent Color </label>

                                                    <div class="controls form-group">

                                                       

                                                            <input class="span4 form-control jscolor {hash:true}" id="header_color" name="header_color" type="color" value="<?php echo strlen($camp_theme_color)<7?'#ffffff':$camp_theme_color ?>">

                                                        

                                                    </div>

                                                </div>



                                                <div id="light_color_div" class="control-group" <?php
												if(!array_key_exists('light_color',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>   >

                                                    <label class="control-label" for="radiobtns"> Light Color </label>

                                                    <div class="controls form-group">

                                                        

                                                            <?php
                                                            $light_color=strlen($light_color)<7?'#000000':$light_color;
                                                            if($style_type == 'light'){

                                                                echo '<input class="span4 form-control jscolor {hash:true}" id="light_color" name="light_color" type="color" value="'.$light_color.'" >';

                                                            }else{

                                                                echo '<input class="span4 form-control jscolor {hash:true}" id="light_color" name="light_color" type="color" value="'.$light_color.'" disabled>';

                                                            }

                                                            ?>



                                                       

                                                    </div>

                                                </div>





                                                <div id="top_line_color_div" class="control-group"   <?php
												if(!array_key_exists('top_line_color',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>   >

                                                    <label class="control-label" for="radiobtns"> Top Line Color </label>

                                                    <div class="controls form-group">

                                                        

                                                            <?php



                                                            if(strlen($top_line_color) <= 0){

                                                                ?>

                                                                <input class="span4 form-control jscolor {hash:true}" id="top_line_color" name="top_line_color" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" disabled>

                                                                <br>

                                                                <input type="checkbox" id="top_che"> Enable top line bar



                                                            <?php

                                                            }else {



                                                                ?>

                                                                <input class="span4 form-control jscolor {hash:true}" id="top_line_color" name="top_line_color" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" >

                                                                <br>

                                                                <input type="checkbox" id="top_che" checked> Enable top line bar



                                                            <?php

                                                            }

                                                            ?>





                                                       

                                                    </div>

                                                </div>





                                            <!--    <script>

                                                    $('#style_type').on('change', function(){

                                                        var st =  $('#style_type').val();

                                                        if(st == 'light'){

                                                            $('#light_color').prop('disabled', false);

                                                            $('#style_img_div').html('<img src="img/light.png" width="290" height="190">')

                                                        }else{

                                                            $('#light_color').prop('disabled', true);

                                                            $('#style_img_div').html('<img src="img/dark.png" width="290" height="190">')

                                                        }

                                                    });



                                                    $('#top_che').on('change', function(){

                                                        var va = $(this).is(':checked');

                                                        if(va){

                                                            $('#top_line_color').prop('disabled', false);

                                                        }else{

                                                            $('#top_line_color').prop('disabled', true);

                                                            $('#top_line_color').val("");

                                                        }

                                                    });

                                                </script> -->



												<div class="form-actions ">

													<button disabled type="submit" id="system_info" name="submit" class="btn btn-primary">Save</button>

													<img id="system_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>
												<script>
                                                                                        function edit_profilefn() {
                                                                                       
                                                                                            $("#system_info").prop('disabled', false);
                                                                                            }
                                 
                                                                                </script>







											</fieldset>







										</form>








                                                <!--    <div id="style_img_div" style="box-shadow: 10px 10px 5px #888888;">

                                                        <?php

                                                        if($style_type == 'dark'){

                                                            echo '<img src="img/dark.png" width="290" height="190">';

                                                        }else{

                                                            echo '<img src="img/light.png" width="290" height="190">';

                                                        }

                                                        ?>



                                                    </div> -->









									</div>





										<!-- ====================== live_camp3 ====================== -->

									<div <?php if(isset($tab0) && $user_type == 'MNO'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp3">


										<h1 class="head">Portal</h1>



										<!-- <h3>Admin Portal Image </h3> -->

										
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

											foreach ($query_results['data'] as $row) {
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


										<form id="edit_profile_a" class="form-horizontal" method="post" >

											<?php



											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>


                                            <div id="edit_profile_a_hidden_input">
                                                <input type="hidden" name="header_logo_img" id="header_logo_img" value="<?php echo $logo; ?>">
                                            </div>
                                            <fieldset>

												<div class="control-group">


													<div class="controls col-lg-5 form-group">

													<label class="" for="radiobtns">Portal Title</label>
														

															<input class="form-control span4" id="main_title1" name="main_title1" type="text" value="<?php echo $db->getValueAsf("SELECT  theme_site_title AS f FROM exp_mno WHERE mno_id='$user_distributor'"); ?>">

														

													</div>

												</div>





												<div class="control-group">


													<div class="controls col-lg-5 form-group">

													<label class="" for="radiobtns">Short Title</label>
														

															<input class="form-control span4" id="short_title1" name="short_title1" type="text" value="<?php echo $db->setVal("short_title",$user_distributor); ?>">
															


													</div>

												</div>







												<div class="control-group">


													<div class="controls col-lg-5 form-group">

													<label class="" for="radiobtns">Master Email <img data-toggle="tooltip" title="Format: noreply@arris.com or Company Name <noreply@arris.com>" src="layout/ATT/img/help.png" style="width: 16px;margin-bottom: 6px;cursor: pointer;"></label>


															<input class="form-control span4" id="master_email1" name="master_email1" type="text" value="<?php echo $db->setVal("email",$user_distributor); ?>">
															
															

													</div>

												</div>

												<div class="control-group">
												<div class="controls col-lg-5 form-group">
													<label class="" for="radiobtns">NOC Email</label>
								
													
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

<?php //if($platformfh!='N/A'){ ?>


<!-- <script type="text/javascript">

$(document).ready(function() {

	$('#dble_fo_na').hide();


    });
 -->

</script>



<?php //} ?>

<div id="dble_fo_na" <?php if($platformfh!='N/A'){echo 'style="display: none;"'; }?>>


                                                <div class="control-group">


                                                    <div class="controls form-group">

                                                    <label class="" for="radiobtns">Style Type</label>
                                                        

                                                            <select class="span4" id="style_type1" name="style_type">

                                                                <option value="dark" <?php if($style_type == 'dark'){ echo 'selected'; } ?> > Dark Style </option>

                                                                <option value="light" <?php if($style_type == 'light'){ echo 'selected'; } ?> > Light Style </option>

                                                            </select>

                                                       

                                                    </div>



                                                </div>

















                                                <div class="control-group">


                                                    <div class="controls form-group">

                                                    <label class="" for="radiobtns"> Theme Color </label>
                                                        
                                                            <input class="span4 jscolor {hash:true}" id="mno_header_color" name="mno_header_color1" type="color" value="<?php echo strlen($camp_theme_color)<7?'#000000':$camp_theme_color; ?>">
                                                        
                                                    </div>

                                                </div>



                                                <div class="control-group">


                                                    <div class="controls form-group">

                                                    <label class="" for="radiobtns"> Light Color </label>
                                                        
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

                                                    <div class="controls form-group">

                                                    <label class="" for="radiobtns"> Top Line Color </label>
                                                       
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


                                                <div class="form-actions" style="border-top: 0px !important; ">

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

										<!-- ====================== live_camp2 ============================ -->

									<div <?php if(isset($tab1) && $user_type != 'ADMIN' && $user_type != 'MNO'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp2">





										<div id="loc_response"></div>

											<h3>Admin Portal Image </h3>

									<div class="img_logo">				
											<p>Max Size (160 x 30)</p>

										<div>



											<?php $url = '?type=mvnx_tlogo&id='.$user_distributor; ?>

											<form  id="imageform2" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>



												<label class="btn btn-primary">
																			Browse Image
																			<span><input type="file" name="photoimg2" id="photoimg2" /></span></label>



											</form>





											<?php

											$key_query = "SELECT theme_logo FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'";

											$query_results=$db->selectDB($key_query);

											foreach ($query_results['data'] as $row) {

												$logo2 = $row[theme_logo];

											}

											?>



											<div id='img_preview2'>

												<?php

												if(strlen($logo2)){?>

												<img src="image_upload/logo/<?php echo $logo2; ?>" border="0"  style="background-color:#ddd;width: 100%; max-width: 200px;"  />

												<?php }

												else{

													echo 'No Images';

												}?>

											</div>

										</div>
									</div>	

											<br><br>





                                        <table>

                                            <tr>

                                                <td>





										<form id="edit-profile" class="form-horizontal" >

										<?php

										echo '<input type="hidden" name="distributor_code0" id="distributor_code0" value="'.$user_distributor.'" />';

										?>

											<fieldset>



												<div class="control-group">


													<div class="controls">

													<label class="" for="radiobtns">Site Title</label>
														<div class="input-prepend input-append">

															<?php

															$get_l = "SELECT site_title,camp_theme_color FROM exp_mno_distributor

															WHERE distributor_code = '$user_distributor' LIMIT 1";

															$query_results=$db->selectDB($get_l);

															foreach ($query_results['data'] as $row) {

																$site_title = $row[site_title];

																$camp_theme_color = $row[camp_theme_color];

															}



														?>

															<input class="span4" id="site_title0" name="site_title0" type="text" value="<?php echo $site_title; ?>" required>



														</div>

													</div>

												</div>







												<div class="control-group">

													<label class="control-label" for="radiobtns">Default Time Zone</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<?php

															
															$utc = new DateTimeZone('UTC');

															$dt = new DateTime('now', $utc);

															$get_l = "SELECT time_zone FROM exp_mno_distributor

															WHERE distributor_code = '$user_distributor' LIMIT 1";

															$query_results=$db->selectDB($get_l);

															foreach ($query_results['data'] as $row) {

																$time_zone = $row[time_zone];

															}



															echo '<select class="span4" name="php_time_zone0" id="php_time_zone0">';

															echo '<option value="'.$time_zone.'">'.$time_zone.'</option>';

															foreach(DateTimeZone::listIdentifiers() as $tz) {

																$current_tz = new DateTimeZone($tz);

																$offset =  $current_tz->getOffset($dt);

																$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());

																$abbr = $transition[0]['abbr'];

																echo '<option value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. CommonFunctions::formatOffset($offset). ']</option>';

															}



															echo '</select>';

															?>

																														</div>



													</div>

												</div>







												<div class="control-group">

													<label class="control-label" for="radiobtns">Ex Portal Language</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<select name="language0" id="language0" required>

															<?php

															 $get_l = "SELECT language_code,l.language  FROM system_languages l, exp_mno_distributor d

															 WHERE l.language_code = d.language AND d.distributor_code = '$user_distributor' LIMIT 1";

															$query_results=$db->selectDB($get_l);

															foreach ($query_results['data'] as $row) {


																$language_code = $row[language_code];

																$language = $row[language];

															}

															echo '<option value="'.$language_code.'">'.$language.'</option>';

															$key_query = "SELECT language_code, `language` FROM system_languages WHERE language_code <> '$lang' AND ex_portal_status = 1 ORDER BY `language`";

															$query_results=$db->selectDB($key_query);

															foreach ($query_results['data'] as $row) {


																$language_code = $row[language_code];

																$language = $row[language];

																echo '<option value="'.$language_code.'">'.$language.'</option>';

															}

															?>





															</select>

														</div>

													</div>

												</div>













                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Style Type</label>





                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <select class="span4" id="style_type0" name="style_type0">

                                                                <option value="dark" <?php if($style_type == 'dark'){ echo 'selected'; } ?> > Dark Style </option>

                                                                <option value="light" <?php if($style_type == 'light'){ echo 'selected'; } ?> > Light Style </option>

                                                            </select>

                                                        </div>

                                                    </div>



                                                </div>

















                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Theme Color </label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <input class="span4 jscolor {hash:true}" id="header_color0" name="header_color0" type="color" value="<?php echo strlen($camp_theme_color)<7?'#ffffff':$camp_theme_color ?>" required>

                                                        </div>

                                                    </div>

                                                </div>



                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Light Color </label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <?php

                                                            $light_color = strlen($light_color)<7?'#000000':$light_color;
                                                            if($style_type == 'light'){

                                                                echo '<input class="span4 jscolor {hash:true}" id="light_color0" name="light_color0" type="color" value="'.$light_color.'" >';

                                                            }else{

                                                                echo '<input class="span4 jscolor {hash:true}" id="light_color0" name="light_color0" type="color" value="'.$light_color.'" disabled>';

                                                            }

                                                            ?>



                                                        </div>

                                                    </div>

                                                </div>





                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns"> Top Line Color </label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <?php

                                                            if(strlen($top_line_color) <= 0){

                                                                ?>

                                                                <input class="span4 jscolor {hash:true}" id="top_line_color0" name="top_line_color0" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" disabled>

                                                                <br>

                                                                <input type="checkbox" id="top_che0"> Enable top line bar



                                                            <?php

                                                            }else {

                                                                ?>

                                                                <input class="span4 jscolor {hash:true}" id="top_line_color0" name="top_line_color0" type="color" value="<?php echo strlen($top_line_color)<7?'#ffffff':$top_line_color ?>" >

                                                                <br>

                                                                <input type="checkbox" chacked id="top_che0" checked> Enable top line bar



                                                            <?php

                                                            }

                                                            ?>





                                                        </div>

                                                    </div>

                                                </div>





                                                <script>

                                                    $('#style_type0').on('change', function(){

                                                        var st =  $('#style_type0').val();

                                                        if(st == 'light'){

                                                            $('#light_color0').prop('disabled', false);

                                                            $('#style_img_div0').html('<img src="img/light.png" width="290" height="190">')

                                                        }else{

                                                            $('#light_color0').prop('disabled', true);

                                                            $('#style_img_div0').html('<img src="img/dark.png" width="290" height="190">')

                                                        }

                                                    });



                                                    $('#top_che0').on('change', function(){

                                                        var va = $(this).is(':checked');

                                                        if(va){

                                                            $('#top_line_color0').prop('disabled', false);

                                                        }else{

                                                            $('#top_line_color0').prop('disabled', true);

                                                            $('#top_line_color0').val("");

                                                        }

                                                    });

                                                </script>









                                                <div class="form-actions">

													<button type="button" onclick="getInfoBox('loc','loc_response');" name="submit" class="btn btn-primary">Save</button>

													<img id="loc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

												</div>

												<!-- /form-actions -->

											</fieldset>

										</form>



                                                </td><td valign="top">



                                                    <div id="style_img_div0" style="box-shadow: 10px 10px 5px #888888;">

                                                        <?php

                                                        if($style_type == 'dark'){

                                                            echo '<img src="img/dark.png" width="290" height="190">';

                                                        }else{

                                                            echo '<img src="img/light.png" width="290" height="190">';

                                                        }

                                                        ?>



                                                    </div>

                                                </td>

                                            </tr>

                                        </table>

									</div>





									<!-- ==================== verify ========================= -->

									<div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="veryfi">

										<div id="response_">



										</div>



										<form id="submit_veryfi_settings" class="form-horizontal" method="POST" action="?t=12">

											<?php

											/*$secret=md5(uniqid(rand(), true));



											$_SESSION['FORM_SECRET'] = $secret;*/

											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

											?>

											<fieldset>





                                                <div>

                                                    <?php

                                                    $qq = "SELECT * FROM exp_locations_ssid WHERE `current_theme` IS NULL AND distributor = '$user_distributor'";

                                                    $rr = $db->selectDB($qq);

                                                    $cnt_theme = $rr['rowCount'];

                                                    if($cnt_theme != 0){

                                                        $isalert = 1;

                                                        echo '<legend>Theme</legend>';

                                                        $warning_text = '<div class="alert alert-warning" role="alert"><h3><small>';

                                                        $warning_text .= 'Themes are not assigned to below SSIDs';

                                                        $warning_text .= '</small></h3><ul>';



                                                        foreach ($rr['data'] as $row11) {

                                                            $ssid_q = $row11[ssid];

                                                            //$theme_name = $row[theme_name];



                                                            $warning_text .= '<li>'.$ssid_q.'</option>';

                                                        }



                                                        $warning_text .= '</ul><a href="theme'.$extension.'?active_tab=create_theme" class="alert-link">Click here to create themes</a></div>';

                                                        echo $warning_text;

                                                    }

                                                    ?>

                                                </div>





                                                <div>

                                                    <?php



                                                    // warning

                                                    $query_warning00 = "SELECT ssid as wssid FROM `exp_locations_ssid` s LEFT JOIN `exp_locations_ap_ssid` a

	                                                    ON s.`ssid` = a.`location_ssid` WHERE a.`ap_id` IS NULL AND s.`distributor` = '$user_distributor'";

                                                    $query_results00=$db->selectDB($query_warning00);

                                                    $cnt_location = $query_results00['rowCount'];



                                                    if($cnt_location > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Locations</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    APs are not assigned to below SSIDs</small></h3><ul>';



                                                        foreach ($query_results00['data'] as $row0) {

                                                            echo '<li>'.$row0[wssid].'</li>';

                                                        }

                                                        echo '</ul>

		                                                    <a href="location'.$extension.'?t=4" class="alert-link">Click here to Assign APs</a></small></div>';

                                                    }

                                                    ?>

                                                </div>







                                                <div>

                                                    <?php



                                                    // warning

                                                    $query_warning00 = "SELECT m.`description`, m.`tag_name`, m.`distributor`, t.`ad_id`

                                                                FROM `exp_mno_distributor_group_tag` m

                                                                LEFT OUTER JOIN `exp_camphaign_ad_live` t

                                                                ON t.`group_tag` = m.`tag_name`

                                                                WHERE m.`distributor` = '$user_distributor'

                                                                AND t.`ad_id` IS NULL

                                                                GROUP BY m.`tag_name` ";

                                                    $query_results00=$db->selectDB($query_warning00);

                                                    $cnt_campaign = $query_results00['rowCount'];



                                                    if($cnt_campaign > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Campaign</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No live campaigns are assigned to below group tags</small></h3><ul>';



                                                        foreach ($query_results00['data'] as $row0) {

                                                            echo '<li>'.$row0[description].'</li>';

                                                        }

                                                        echo '</ul>

		                                                    <a href="campaign'.$extension.'" class="alert-link">Click here to manage campaigns</a></small></div>';

                                                    }

                                                    ?>

                                                </div>





                                                <div>

                                                    <?php



                                                    // warning

                                                    $key_query = "SELECT * FROM exp_locations_ssid WHERE distributor = '$user_distributor'";

                                                    $query_results=$db->selectDB($key_query);

                                                    $cnt_ssid = $query_results['rowCount'];



                                                    if($cnt_ssid == 0){

                                                        $isalert = 1;

                                                        echo '<legend>SSID</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No SSIDs are created</small></h3>';

                                                        echo '<a href="location'.$extension.'?t=3" class="alert-link">Click here to create a SSID</a></div>';

                                                    }

                                                    ?>

                                                </div>



                                                <div>

                                                    <?php



                                                    // warning

                                                    $key_query = "SELECT * FROM `exp_mno_distributor_aps` WHERE `distributor_code` = '$user_distributor'";

                                                    $query_results=$db->selectDB($key_query);

                                                    $cnt_ap = $query_results['rowCount'];



                                                    if($cnt_ap == 0){

                                                        $isalert = 1;

                                                        echo '<legend>Aps</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No Aps are created</small></h3>';

                                                        echo '</div>';

                                                    }

                                                    ?>

                                                </div>



                                                <div>

                                                    <?php





                                                    if($isalert == 0){





                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    There are no verification alerts</small></h3>';

                                                        echo '</div>';

                                                    }

                                                    ?>

                                                </div>





											</fieldset>

										</form>

									</div>









                                    <!-- ====================== login screen config ============================ -->

                                    <div <?php if(isset($tab15)){?>class="tab-pane in active" <?php }else {?> class="tab-pane " <?php }?> id="live_cam3">





                                        <div id="loc_thm_response"></div>

                                        <h3>Login Screen Image </h3>

                                        <p>Max Size (160 x 30 px)</p>

                                        <div>



                                            <?php

                                            if($user_type == 'ADMIN'){

                                                $url = '?type=login_screen&id=ADMIN&user_type='.$user_type;

                                            }

                                            ?>

                                            <form onkeyup="imageform23fn();" onchange="imageform23fn();" id="imageform23" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>

                                               <label class="btn btn-primary">
																			Browse Image
																			<span><input type="file" name="photoimg23" id="photoimg23" /></span></label>

                                            </form>


                                            <?php



                                            if($user_type == 'ADMIN'){

                                                $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_LOGO'";

                                            }


                                            $query_results=$db->selectDB($key_query);

											foreach ($query_results['data'] as $row) {

                                                $logo2 = $row[settings_value];

                                            }



                                            ?>


                                            <div id='img_preview23'>

                                                <?php

                                                if(strlen($logo2)){?>

                                                    <img style="background-color:#ddd;width: 100%; max-width: 200px;"  src="image_upload/welcome/<?php echo $logo2; ?>" border="0" />

                                                <?php }

                                                else{

                                                    echo 'No Images';

                                                }?>

                                            </div>

                                        </div>

                                        <br><br>



                                        <form onkeyup="imageform23fn();" onchange="imageform23fn();" id="edit-profile"  >

                                            <?php

                                            echo '<input type="hidden" name="distributor_code" id="distributor_code" value="'.$user_distributor.'" />';

                                            echo '<input type="hidden" name="user_type" id="user_type" value="'.$user_type.'" />';

                                            echo '<input type="hidden" name="header_logo_img23" id="header_logo_img23" value="'.$logo2.'" />';

                                            ?>



                                            <fieldset>

                                                <?php



                                                $key_query = "SELECT settings_value FROM exp_settings WHERE settings_code = 'LOGIN_SCREEN_THEME_COLOR'";

                                                $key_result = $db->selectDB($key_query);

												foreach ($key_result['data'] as $row) {

                                                    $login_color = $row[settings_value];

                                                }



												
												if($package_functions->getAdminPackage()!='COX_ADMIN_001'){
													?>



													<div class="control-group">

														<label class="control-label" for="radiobtns">Login Accent Color</label>

														<div class="controls">

															<div class="input-prepend input-append">

																<input class="span6 jscolor {hash:true}" id="header_color_log" name="header_color_log" type="color" value="<?php echo strlen($login_color)<7?'#ffffff':$login_color ?>" required>

															</div>

														</div>

														<!-- /controls -->

													</div>

													<!-- /control-group -->



													<?php
												}else{
													?>
													<input class="span6 jscolor {hash:true}" id="header_color_log" name="header_color_log" type="hidden" value="<?php echo strlen($login_color)<7?'#ffffff':$login_color ?>" required>


													<?php
												}
                                                ?>






                                                <div class="form-actions">

                                                    <button disabled type="button" id="login_screen_config" name="submit" class="btn btn-primary" >Save</button>

                                                    <img id="loc_thm_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

                                                </div>
                                                
                                              
                                                 <script>
                                                                                        function imageform23fn() {
                                                                                        
                                                                                            $("#login_screen_config").prop('disabled', false);
                                                                                            }
                                                                         
                                                                                </script>

                                                <!-- /form-actions -->

                                            </fieldset>

                                        </form>

                                    </div>




                                    <!-- ======================= live_camp =============================== -->

                                    <div <?php if(isset($tab15)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="footer_config">





                                        <div id="system_response"></div>

                                        <form id="edit-profile" class="form-horizontal" >

                                            <?php

                                            echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

                                            ?>



                                            <fieldset>

                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Site Title</label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <input class="span4" id="main_title" name="main_title" type="text" value="<?php echo $db->setVal("site_title",$user_distributor); ?>">

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Admin Email</label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <input class="span4" id="master_email" name="master_email" type="text" value="<?php echo $db->setVal("email",$user_distributor); ?>" required>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Ex Portal base URL</label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <input class="span4" id="base_url" name="base_url" type="text" value="<?php echo $db->setVal("portal_base_url",$user_distributor); ?>" required>
                                                            <br> <font size="1">Ex: http://10.1.1.1/Ex-portal</font>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="control-group">

                                                    <label class="control-label" for="radiobtns">Campaign Portal Internal URL</label>

                                                    <div class="controls">

                                                        <div class="input-prepend input-append">

                                                            <input class="span4" id="camp_url" name="camp_url" type="text" value="<?php echo $db->setVal("camp_base_url",$user_distributor); ?>" required>
                                                            <br> <font size="1">Ex: http://10.1.1.1/campaign_portal</font>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="form-actions">

                                                    <button type="button" onclick="getInfoBox('system','system_response');" name="submit" class="btn btn-primary">Save</button>

                                                    <img id="system_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

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

<style type="text/css">
   #ex-btn-div{
        text-align: center;
    }

    #ex-btn-div .tablesaw-bar{
        text-align: center;
        top: 30px;
    }

    #ex-btn-div .export-customer-a{
        margin-bottom: 20px;
    }

    .table_response{
        margin: auto;
    }
  .widget-header{
        display: none;
  }
  .widget-content{
    padding: 0px !important;
    border: 1px solid #ffffff !important;
  }
  .intro_page{
    z-index: -4;
  }
  .nav-tabs{
    padding-left: 30% !important;
  }
  body .nav-tabs>.active>a, body .nav-tabs>.active>a:hover{
        background-color: #000000;
    border: none;
  }

  .nav-tabs>li>a{
    background: none !important;
    border: none !important;
  }
  .nav-tabs>li>a{
    color: #0568ae !important;
    border-radius: 0px 0px 0 0 !important;
  }

  .nav-tabs>li:nth-child(3)>a{
    border-right: none !important;
  }

  body {
    background: #ffffff !important;
}

h1.head {
    padding: 0px;
    padding-bottom: 40px;
    width: 960px;
    margin: auto;
    font-size: 34px;
    text-align: center;
    color: #000;
    font-family: Rbold;
    box-sizing: border-box;
}


/*footer styles*/

.contact{
    font-size: 16px;
    font-family: Rregular;
    color: #fff;
        margin-right: 50px;
}

.call span:not(.glyph), .footer-live-chat-link span:not(.glyph){
    font-family: Rmedium;
    font-size: 20px;
    color: #fff;
}

.number{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-live-chat-link{
        display: inline-block;
    margin-left: 50px;
}

.call a{
    font-family: Rmedium;
    font-size: 20px;
}

.footer-inner a:hover{
    text-decoration: none !important;
    color: #fff;
}

.main-inner{
  position: relative;
}

.main {
    padding-bottom: 0 !important;
}

  /*network styles
*/

.tab-pane{
  padding-bottom: 50px;
/*  padding-top: 50px;*/
    /*border-bottom: 1px solid #000000;*/
}

.tab-pane:nth-child(1){
  padding-top: 0px;
}

.tab-pane:last-child{
  border-bottom: none;
}

.alert {
  /*position: absolute;
    top: 60px;*/
    width: 100%;
} 
.uppercase{
	    text-transform: unset !important;
}

.form-horizontal .controls{
    width: 370px;
    margin: auto;
}

.form-horizontal .contact.controls{
    width: 700px;
}

form.form-horizontal .form-actions{
    width: 350px;
    margin: auto;
    background-color: #fff;
    padding-left: 0px;
}

form .qos-sync-button {
    float: none;
}

@media (max-width: 979px){
    .form-horizontal .controls{
        width: 320px;
    }

    form.form-horizontal .form-actions{
        width: 300px;
    }

    .form-horizontal .contact.controls{
        width: 90%;
    }

    .tab-pane {
        padding-top: 0px !important;
    }
	.head{
		margin-top: 40px !important;
	}
}

@media (max-width: 768px){
    .form-horizontal .controls{
        width: 280px;
    }

    form.form-horizontal .form-actions{
        width: 260px;
    }


    .form-horizontal .contact.controls{
        width: 100%;
    }

    select.inline-btn, input.inline-btn, button.inline-btn, a.inline-btn {
        display: block !important;
    }

    a.inline-btn, button.inline-btn, input[type="submit"].inline-btn {
        margin-top: 10px !important;
        margin-left: 0px !important;
    }

}

@media (max-width: 480px){
    form.form-horizontal .form-actions{
        width: 270px;
    }
}

.sele-disable{
            position: absolute;
            height: 50px;
            height: 37px;
            cursor: not-allowed;
            opacity: 0.2;
            background: #9a9999;
            margin-left: 0px;
        }
@media (max-width: 420px){
            .sele-disable.span4{
                width: 100% !important;
            }
        }

</style>