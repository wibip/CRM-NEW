
<div class="main">

	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

						<div class="widget-header">

							<!-- <i class="icon-wrench"></i> -->

							<h3>Configuration</h3>

						</div>
						
						<?php 
						

	//$archive_path=$db->setVal('LOGS_FILE_DIR','ADMIN');
if (isset($_POST['purge_now'])) {
						
		
			
			$log_older_days = $_POST['log_older_days'];
			$archive_log_days = $_POST['archive_log_days'];

			$archive_path = mysql_escape_string($_POST['archive_log_path']);
			$archive_log_path_update="UPDATE exp_settings SET `settings_value`='$archive_path' WHERE `settings_code`='LOGS_FILE_DIR' AND `distributor`='ADMIN'";
			mysql_query($archive_log_path_update);



			$_SESSION['msg7'] = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('purge_now_update_failed',NULL)."</strong></div>";
				
			$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$log_older_days' WHERE `type` = 'DB'";
			$query_log_remove_update_q1 = mysql_query($query_log_remove_update1);
			
			$query_log_remove_update1 = "UPDATE  admin_purge_logs set frequencies = '$archive_log_days' WHERE `type` = 'archive_db'";
			$query_log_remove_update_q1 = mysql_query($query_log_remove_update1);
			
			if($query_log_remove_update_q1){
				$_SESSION['msg7'] = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>x</button><strong>".$message_functions->showMessage('purge_now_update_success',NULL)."</strong></div>";
					
			}
	
			
		}
		
?>
				<?php

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

                        <div id="system1_response">
                       <?php
					  
                       if(isset($_SESSION['system1_msg']) ){
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



										if($user_type == 'MNO' || $user_type == 'SALES'){
//print_r($features_array);	
//echo  $tab11;

											?>

										<!-- <li class="active"><a href="#live_camp3" data-toggle="tab">System Configuration</a></li>	 -->
										<?php if(in_array("CONFIG_PROFILE",$features_array)){ ?>
										<li <?php if(isset($tab1)){ ?>class="active" <?php } ?>><a href="#product_create" data-toggle="tab">Profile</a></li>
										<?php }
										 if(in_array("CONFIG_DURATION",$features_array)){ ?>
										<li <?php if(isset($tab2)){ ?>class="active" <?php } ?>><a href="#duration_create" data-toggle="tab">Duration</a></li>
										<?php }?>

										
										<li <?php if(isset($tab0)){ ?>class="active" <?php } ?>><a href="#live_camp3" data-toggle="tab">Portal</a></li>
										
										    <li <?php if(isset($tab11)){ ?>class="active" <?php } ?>><a href="#toc" data-toggle="tab">Guest T&C</a></li>
											

										<?php	if(in_array("VTENANT_TC",$features_array) && $package_functions->getSectionType('VTENANT_TYPE',$system_package)=='1' ){ ?>
										<li <?php if(isset($tab32)){ ?>class="active" <?php } ?>><a href="#vt_toc" data-toggle="tab">Vtenant T&C</a></li>
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
									<?php } ?>
									
									<?php if(in_array("CONFIG_POWER",$features_array)){ ?>
											<li><a href="#power_shedule" data-toggle="tab">Power Schedule</a></li>
										<?php }
                                            if(in_array("CONFIG_GUEST_FAQ",$features_array) || $system_package=='N/A'){ ?>
                                                <li <?php if(isset($tab30)){ ?>class="active" <?php } ?>><a href="#faq" data-toggle="tab">FAQ</a></li>
                                        <?php }
                                            if(in_array("CONFIG_FOOTER",$features_array) || $system_package=='N/A'){ ?>
                                               <li <?php if(isset($tab31)){ ?>class="active" <?php } ?>><a href="#footer" data-toggle="tab">FAQ</a></li>
											<?php }
											
											if(in_array("CONFIG_BLACKLIST",$features_array)){ ?>
                                            	<li <?php if(isset($tab34)){ ?>class="active" <?php } ?>><a href="#blacklist" data-toggle="tab">Blacklist</a></li>
                                        <?php
                                            }
										}

									?>

								</ul><br>

								<div class="tab-content">
									<?php if(in_array("CONFIG_PROPERTY_SETTINGS",$features_array)){ ?>
									<div <?php if(isset($tab23)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="property_settings" >
										<form id="active_property_submitfn"  method="post" action="?t=23" class="form-horizontal fv-form fv-form-bootstrap">

											<br>
											<br>

											<?php 
												echo '<input type="hidden" name="property_secret" id="property_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
											 ?>

											<div class="control-group">
												<label class="control-label" for="radiobtns">Header Image</label>
												<div class="controls form-group">
													<select id="headerImg" name="headerImg">

														<?php 

															$queryString = "SELECT setting FROM `exp_mno` WHERE mno_id='$user_distributor'";

													    	$queryResult=$db_class1->selectDB($queryString); 
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

											<div class="form-actions pd-zero-form-action">

												<button disabled type="submit" id="property_update" name="property_update" class="btn btn-primary">Save</button>

											</div>

										</form>
									</div>
									<?php }?>
								
								<?php if(in_array("CONFIG_BLACKLIST",$features_array)){ ?>
							   <div <?php if(isset($tab34) && $user_type == 'MNO'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="blacklist">

<div id="email_response"></div>



<div id="response_d3">



</div>




 <form onkeyup="blacklist_email_submitfn();" onchange="blacklist_email_submitfn();"     id="edit-profile"  method="post" action="?t=34">
	 <?php
	 echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
	 ?>
	 <fieldset>
		 <legend>Blacklist Content</legend>


		 <br><br>


		 <div class="control-group">
			 <div class="controls ">
			 <label class="" for="">Blacklist Headline</label>

				 <?php
		 $black_val = $db->textTitle('BLACKLIST_CONTENT',$user_distributor);

		 if(strlen($black_val)==0){

			  $black_val = $db->textTitle("BLACKLIST_CONTENT", $system_package);

		  }
		 

		 ?>

		 <input type="text" name="black_head" value="<?php echo $black_val; ?>">

	 </div>

 </div>

		 <div class="control-group">
			 <div class="controls ">
			 <label class="" for="">Blacklist Text</label>

		 <textarea class="blacklist_email_submit_tarea"  width="100%" id="blacklist_email" name="blacklist_email" ><?php
		 $mail_format= $db->textVal('BLACKLIST_CONTENT',$user_distributor);

		 if(strlen($mail_format)==0){

			  $mail_format = $db->textVal("BLACKLIST_CONTENT", $system_package);

		  }
		 echo $mail_format;
		 

		 ?></textarea>

	 </div>

 </div>

		 <div class="form-actions pd-zero-form-action" >

			 <input type="submit" value="Save" name="blacklist_email_submit" id="blacklist_email_submit" class="btn btn-primary">


		 </div>
		 <script>
			 function blacklist_email_submitfn() {

				 $("#blacklist_email_submit").prop('disabled', false);

			 }

		 </script>


		 <img id="email_loader" src="img/loading_ajax.gif" style="visibility: hidden;">

		 <!-- /form-actions -->

	 </fieldset>

 </form>





</div>

						<?php }?>		
								
							<?php if(in_array("CONFIG_FOOTER",$features_array)){?>
									<div class="tab-pane <?php if(isset($tab31)){ ?>active <?php } ?>" id="footer">
									
									
									<div id="response_d3">

											<?php




						   					  $footerq="SELECT * FROM `exp_footer` WHERE `distributor`='$user_distributor'";
						   					  
						   					  $footer_results1=mysql_query($footerq);
						   					  
						   					  while($rowf=mysql_fetch_array($footer_results1)){
						   					  	
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
													<div class="controls ">
													<label class="" for="gt_mvnx">URL</label>
														
														
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
								
							

                                    <!--====================== FAQ ======================-->
                                    <?php if(in_array("CONFIG_GUEST_FAQ",$features_array)){ ?>
                                        <div class="tab-pane <?php if(isset($tab30)){ ?>active <?php } ?>" id="faq">


                                            <form  id="faq_form1" name="faq_form1" method="post" action="?t=30" class="form-horizontal">
                                                <fieldset>
                                                    <div class="control-group" id="">
                                                        <div class="controls ">
                                                        <label class="" for="gt_mvnx">Title</label>
                                                            <input class="span6" style="" type="text" name="faq_title" required value="<?php if($edit_faq=='1'){echo $edit_faq_details['text']; } ?>">

                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="">
                                                        <div class="controls ">
                                                        <label class="" for="gt_mvnx">Description</label>
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
									<?php if(in_array("PURGE_LOGS",$features_array)|| $package_features=="all" ){ ?>
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
													  	
													  $query_results11_mod=mysql_query($query_purge11);
													  while($row1=mysql_fetch_array($query_results1_mod)){
													  	$last_run_days1 = $row1[last_run_days];
													  }
													  
													  
													  
													  
													  $query_purge2 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'archive_db' GROUP BY `type`";
													  
													  $query_results2_mod=mysql_query($query_purge2);
													  while($row2=mysql_fetch_array($query_results2_mod)){
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
														<div class="controls">
														<label class="" for="limit3">Logs Older Than</label>
															<?php echo '<input class="span2" id="log_older_days" name="log_older_days" value="'.$log_older_days.'" type="number" min="3" max="365" required step="1" >' ?> Days
														</div>
													</div>
													
													<h3>Permanently remove archived logs</h3><br>
													<div class="control-group">
														<div class="controls">
														<label class="" for="limit3">Archive Logs Older Than</label>
															<?php echo '<input class="span2" id="archive_log_days" name="archive_log_days" value="'.$archive_log_days.'" type="number" min="3" max="365" required step="1">' ?> Days
														</div>
													</div>


													<h3>Archive directory</h3><br>
													<div class="control-group">
														<div class="controls">
														<label class="">Directory Path</label>
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
													$query_results0 = mysql_query($base_purge_query);

													$fsize = 0;
													while($row=mysql_fetch_array($query_results0)){
																		
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
														$query_results111 = mysql_query($log_purge_q);
															
														while($row2=mysql_fetch_array($query_results111)){
														
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
                                    <?php } ?>




<?php

	//Form Refreshing avoid secret key/////
	//$secret=md5(uniqid(rand(), true));
	//$_SESSION['FORM_SECRET'] = $secret;


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


													<div class="controls">
													<label class="" for="radiobtns">Network Profile</label>

														<div class="input-prepend input-append">

															<select name="network_name" id="network_name" required>



															<?php



															$network_name = $db->setVal("network_name","ADMIN");

															//$get_2 = "SELECT `description` as f FROM exp_plugins WHERE plugin_code = '$network_name' AND `type` = 'NETWORK' LIMIT 1";

															echo '<option value="'.$network_name.'">'.$network_name.'</option>';

															$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `network_profile` <> '$network_name' AND `visible` = 1 ORDER by network_profile";



															$query_results=mysql_query($key_query);



															while($row=mysql_fetch_array($query_results)){

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







													<div class="controls">
													<label class="" for="radiobtns">Network Profile</label>

														<div class="input-prepend input-append">


															<select name="network_edit" id="network_edit" required>

															<?php
															$key_query = "SELECT `network_profile` FROM `exp_network_profile` WHERE `visible` = 1";

															$query_results=mysql_query($key_query);



															while($row=mysql_fetch_array($query_results)){



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

										<form  id="submit_toc"  method="POST" action="?t=11">


											<?php

											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                            $email_template = $db_class1->getEmailTemplate('TOC',$system_package,'MNO',$user_distributor);
                                            $subject = $email_template[0][title];
                                            $mail_text  = $email_template[0][text_details];
                                            echo '<input id="tc_code" name="tc_code" type="hidden"  value="TOC">';
                                            echo '<input id="tc_distributor" name="tc_distributor" type="hidden"  value="'.$user_distributor.'">';


											?>

											<fieldset>



												<legend>Guest Terms and Conditions</legend>

												<?php
												
												if($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE',$system_package)=="1"){
												
												?>
												<script src="js/select2-3.5.2/select2.min.js"></script>
                                    <link rel="stylesheet" href="js/select2-3.5.2/select2.css" />
                                    <link rel="stylesheet" href="css/select2-bootstrap/select2-bootstrap.css" />
                                    <script type="text/javascript">
                                    $(document).ready(function() {
                                      $("#business_type").select2();
                                    });
                                    </script>

	<div class="control-group">
                                                                                <div class="controls col-lg-5 form-group" style="margin-bottom: 25px;">


                                                                                <label class="" for="location_name1">Property ID<sup><font color="#FF0000"></font></sup></label>
                                                                                
                                                                                    <select  class="span4 form-control business_type" id="business_type" name="business_type" onchange="select_vertical(this.value);">
                                                                                      
                                                                                        <option value="All">All Properties</option>
                                                                                        <?php

                                                                        $key_query = "SELECT d.`distributor_name`,d.`distributor_code`,g.`group_number` FROM `exp_mno_distributor` d,`exp_distributor_groups` g
                                                                                WHERE d.`distributor_code`=g.`distributor`
                                                                                AND `mno_id`='$user_distributor' ORDER BY g.`group_number` ASC";

                                                                        $query_results=mysql_query($key_query);
                                                                        while($row=mysql_fetch_array($query_results)){
                                                                            $distributor_code = $row[distributor_code];
                                                                            $distributor_name = $row[group_number];

                                                                            echo '<option value="'.$distributor_name.'">'.$distributor_name.'</option>';
                                                                        }

                                                                        ?>
                                                                                    </select>
																					<div style="display: inline-block" id="loader"></div>
                                                                                </div>
																				
                                                                            </div>
                                                                            <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
																			<script>



																			function select_vertical(vertical){
																				
																				if(vertical == 'All'){ 
																					document.getElementById("submit_toc_btn").disabled = true;
																				}else{
																					submit_tocfn();
																				}
									document.getElementById("loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";
																			  $.ajax({
        type: 'POST',
        url: 'ajax/getTerms.php',
        dataType :'html',
        data: { vertical: vertical,user_distributor: "<?php echo $user_distributor; ?>",system_package: "<?php echo $system_package; ?>" },
        success: function(data) {

 			
           	//tinymce.activeEditor.setContent('<span>some</span> html');

           	
			tinymce.remove();
			//tinymce.init({selector: "textarea.submit_arg1ta"}); 
			//eval(document.getElementById('tinymce_editors'));
			initTinymces();
			$('#vertical_terms').empty().append(data);
			//eval(document.getElementById('ajax_load_tc'));
			//tinymce.get('toc1').setContent("data");

			


            document.getElementById("loader").innerHTML = "";

        }/* ,
         error: function(){
             document.getElementById("sync_loader").innerHTML = " &nbsp;&nbsp;&nbsp; <font color='red'>Network Error</font>";
         } */

    });

																			}
																			</script>

<?php }else{
	 echo '<input id="business_type" name="business_type" type="hidden"  value="All">';
} ?>

<div id="vertical_terms">



						<?php if($package_functions->getSectionType('CAPTIVE_TOC_TYPE',$system_package)=="checkbox"){
							$text_arr = $db->textVal('TOC',$user_distributor);
							$text_arr1 = json_decode($text_arr, true);

							?>

									<div class="control-group" id="feild_gp_taddg_divt1">

                                                        <div class="controls col-lg-5 ">
										<label class="" for="gt_mvnx">TOC 1</label>
                                                          <textarea width="100%" id="toc1" name="toc1" class="span6"><?php print_r($text_arr1['toc1']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 ">
                                                    	<label class="" for="gt_mvnx">TOC 2</label>
                                                        <textarea width="100%" id="toc2" name="toc2" class="span6"><?php print_r($text_arr1['toc2']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 ">
                                                    	<label class="" for="gt_mvnx">TOC 3</label>
                                                          <textarea width="100%" id="toc3" name="toc3" class="span6"><?php print_r($text_arr1['toc3']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 ">
                                                    	<label class="" for="gt_mvnx">TOC 4</label>
                                                         <textarea width="100%" id="toc4" name="toc4" class="span6"><?php print_r($text_arr1['toc4']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 ">
                                                    	<label class="" for="gt_mvnx">TOC 5</label>
                                                         <textarea width="100%" id="toc5" name="toc5" class="span6"><?php print_r($text_arr1['toc5']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5 ">
                                                    	<label class="" for="gt_mvnx">SUBMIT</label>
                                                        <textarea width="100%" id="submit" name="submit" class="span6"><?php print_r($text_arr1['submit']); ?></textarea>
									</div>
                                                    </div>
                                                    <div class="control-group" id="feild_gp_taddg_divt1">
                                                        <div class="controls col-lg-5">
                                                    	<label class="" for="gt_mvnx">CANCEL</label>
                                                       <textarea width="100%" id="cancel" name="cancel" class="span6"><?php print_r($text_arr1['cancel']); ?></textarea>
</div>
                                                    </div>


						<?php }else{
					
												
												if($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE',$system_package)=="0"){

												/* 	$toc_val = $db->textVal('TOC',$system_package);

												}else{ */
													//echo 'Ok';
													$toc_val = $db->textVal('TOC',$user_distributor);
													if(empty($toc_val)){
														$toc_val = $db->textVal('TOC',$system_package);
													}
												}else{
													//$toc_val = $db->textVal('TOC',$user_distributor);
													$toc_val = $db->textVal_vertical('TOC',$user_distributor,'All');
													if(empty($toc_val)){
														$toc_val = $db->textVal_vertical('TOC',$system_package,'All');
													}
													
												}
												
												?>

												<textarea width="100%" id="toc1" name="toc1" class="submit_tocta"><?php echo  $toc_val; ?></textarea>


	<?php } ?>

	</div>

												<div class="form-actions pd-zero-form-action">

												<button disabled type="submit" id="submit_toc_btn" name="submit_toc" class="btn btn-primary">Save</button>







												<img id="toc_loader" src="img/loading_ajax.gif" style="visibility: hidden;">



												</div>
												<script>
                                                                                        function submit_tocfn() {
																							$("#submit_toc_btn").prop('disabled', false);
																							<?php
												
												//if($package_functions->getSectionType('BUSINESS_VERTICAL_ENABLE',$system_package)=="1"){
												
												?>
                                                                                        //	var bt=$("#business_type").val();
																							
                                                                                        	/* if(bt == 'All'){
                                                                                        		$("#submit_toc_btn").prop('disabled', true);
                                                                                        	}else{
                                                                                        		$("#submit_toc_btn").prop('disabled', false);
                                                                                        	} */
																						<?php //}else{ ?>
																							/* $("#submit_toc_btn").prop('disabled', false); */
																							
																						<?php // } ?>
                                                                                            }
                                                                   
                                                                                </script>











															<!-- /form-actions -->







											</fieldset>







										</form>



									</div>




										<!-- ==================== VT toc ========================= -->
									<?php	if(in_array("VTENANT_TC",$features_array) && $package_functions->getSectionType('VTENANT_TYPE',$system_package)=='1' ){ ?>

									<div <?php if(isset($tab32)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="vt_toc">

<div id="response_">

</div>

<form onkeyup="vt_submit_tocfn();" onchange="vt_submit_tocfn();" id="vt_submit_toc"  method="POST" action="?t=32">


	<?php

	echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
	$email_template = $db_class1->getEmailTemplate('VT_TOC',$system_package,'MNO',$user_distributor);
	$subject = $email_template[0][title];
	$mail_text  = $email_template[0][text_details];
	echo '<input id="email_code" name="email_code" type="hidden"  value="VT_TOC">';
	echo '<input id="email_distributor" name="email_distributor" type="hidden"  value="'.$user_distributor.'">';


	?>

	<fieldset>



		<legend>Vtenant Terms and Conditions</legend>





<?php if($package_functions->getSectionType('CAPTIVE_TOC_TYPE',$system_package)=="checkbox"){
$text_arr = $db->textVal('VT_TOC',$user_distributor);
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

<?php } ?>




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
										<!-- onkeyup="submit_arg1fn();" onchange="submit_arg1fn();" -->
										<form   id="edit_profile_b"  method="POST" action="?t=20">



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
															

																<input class="span5 form-control" id="arg_title1" name="email_subject" type="text"  value="<?php echo $subject; ?>">

															
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


<?php 
// OPS ADMIN CREATION TEMPLATE
if($user_type == 'ADMIN'){

?>	
<!-- 	onkeyup="active_email_submitfn();" onchange="active_email_submitfn();" --> 		
<form      id="active_email_submitfn"  method="post" action="?t=21">
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
<input class="span5 form-control" id="email_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
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
				<!-- 	onkeyup="active_email_submitfn();" onchange="active_email_submitfn();" --> 													
<form     id="active_email_submitfn"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Business ID Activation Email</legend>
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

<input class="span5 form-control" id="email_subject_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
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
<legend>Activation Email(Master Admin)</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
Portal Short Name : {$short_name}&nbsp;&nbsp;|&nbsp;
Account Type : {$account_type}&nbsp;&nbsp;
<br>
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
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

<!-- onkeyup="venue_activated_emailfn();" onchange="venue_activated_emailfn();" -->
<form  id="venue_activated_email" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
                                                <legend>Activation Confirmation Email</legend>
                                                <h6>TAG Description </h6>
                                                User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
                                                Portal Link : {$link}&nbsp;&nbsp;|&nbsp;Rest Link : {$reset_link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}&nbsp;&nbsp;|&nbsp;Customer Account # : {$account_number}<br>
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

                                                        <input class="span5 form-control" id="email_subject_activated" name="email_subject" type="text"  value="<?php echo $subject; ?>"/>
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
											<!-- onkeyup="new_venue_activated_emailfn();" onchange="new_venue_activated_emailfn();" -->
                                        <form  id="new_venue_activated_email" method="post" action="?t=21">
                                            <?php
                                            echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
                                            ?>

                                            <fieldset>
                                                <legend>New Location Email</legend>
                                                <h6>TAG Description </h6>
                                                User Full Name : {$user_full_name}&nbsp;&nbsp;|
                                                &nbsp;Portal Link : {$link}&nbsp;&nbsp;|
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

                                                        <input class="span5 form-control" id="new_location_activated" name="email_subject" type="text"  value="<?php echo $subject; ?>"/>
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
	<!-- onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" -->
<form  id="active_sup_email"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email (Support)</legend>
<h6>TAG Description </h6>
User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
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

<input class="span5 form-control" id="email_subject_sup_main" name="email_subject" type="text"  value="<?php echo $subject; ?>">
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
<!-- onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();" -->
<form  onkeyup="active_sup_email_submitfn();" onchange="active_sup_email_submitfn();"     id="active_sup_email"  method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>
<fieldset>
<legend>Activation Email (Support)</legend>
<h6>TAG Description </h6>
User Full Name : {Tier 1 Support Name}&nbsp;&nbsp;|&nbsp;
User Name : {$user_name}&nbsp;&nbsp;|&nbsp;
Password : {$password}&nbsp;&nbsp;|&nbsp;
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

										
										
<!-- onkeyup="email_subject_passcodeifn();" onchange="email_subject_passcodeifn();" -->									
<form   id="passcode_email_form" method="post" action="?t=21">
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
<input class="span5 form-control" id="email_subject_passcode" name="email_subject" type="text"  value="<?php echo $subject; ?>">
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

<!-- onkeyup="tech_emailfn();" onchange="tech_emailfn();" -->
	<?php 
		$isTechAdmin = $package_functions->getOptions('MASTER_TECH_ADMIN',$system_package);
	?>

	<?php if($isTechAdmin== 'NO'){ ?>

		<!-- No need to display Master tech admin-->

	<?php }else{?>


      <form  id="tech_activation__email" method="post" action="?t=21">
          <?php
          echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
          ?>

          <fieldset>
              <legend>Activation Email (Tech)</legend>
              <h6>TAG Description </h6>
              User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
              Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}<br>
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

                      <input class="span5 form-control" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
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

    
	  <!-- onkeyup="hardware_emailfn();" onchange="hardware_emailfn();" -->
      <form  id="hardware_info_email" method="post" action="?t=21">
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

                      <input class="span5 form-control" id="email_subject_tech_activate" name="email_subject" type="text" value="<?php echo $subject; ?>">
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
										
										
										
										
<!-- onkeyup="password_reset_emailfn();" onchange="password_reset_emailfn();" -->										
<form  id="password_reset_email" method="post" action="?t=21">
<?php
echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
?>

<fieldset>
<legend>Password Reset Email</legend>
<h6>TAG Description </h6>
User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
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

<input class="span5 form-control" id="email_subject_pass_reset" name="email_subject" type="text" value="<?php echo $subject; ?>">
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
Reset Link : {$link}&nbsp;&nbsp;|&nbsp;User ID : {$user_ID}<br>
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


<!-- ////////////////////////////////product create //////////////////// -->



									<?php if(in_array("CONFIG_PROFILE",$features_array)){ ?>
                                    <div <?php if((isset($tab1)&&$user_type == 'MNO' )|| (isset($tab1)&&$user_type == 'SALES')){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="product_create">

                                        <div id="response_">



                                        </div>

<!-- ///////////////////////////////////////////////////////////// -->


													<script>

													$(document).ready(function() {
													    $("#description").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
															
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>


													<script>

													$(document).ready(function() {
													    $("#description_up").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>



													<script>

													$(document).ready(function() {
													    $("#description1").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
                                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                                                                // Allow: Ctrl+A, Command+A
                                                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>


												<script>

													$(document).ready(function() {
													    $("#description1_up").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
                                                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
                                                                // Allow: Ctrl+A, Command+A
                                                                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>
                                                    <script>

													$(document).ready(function() {
														
													    $("#Purge_delay_time").keydown(function (e) {
															
													        // Allow: backspace, delete, tab, escape, enter and .
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>
                                                    
                                                    <script>

													$(document).ready(function() {
													    $("#Purge_delay_time2").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>
													<script>

													$(document).ready(function() {
													    $("#max_sessions_alert").keydown(function (e) {
													        // Allow: backspace, delete, tab, escape, enter and .
													        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
													             // Allow: Ctrl+A, Command+A
													            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
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


													</script>


<style></style>
<script></script>


<?php $network_opt= $package_functions->getOptions('NETWORK_AVAILABLE',$system_package); 

if($network_opt =='privat' || $network_opt =='both' ){

?>


										<h3>Create Private QoS Profile(s)</h3>
											<br>
											<form id="create_product_form" name="create_product_form" method="post" class="form-horizontal" action="?t=1" autocomplete="off">
												<fieldset>

												<div id="response_d3">

											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>



<?php //echo $edit_product_pvt; ?>


										 			<div class="control-group" style="margin-bottom: 0px !important">
														<label class="control-label" for="product_name">Name<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input required class="span4 form-control" id="product_name" name="product_name" type="text" value="<?php if($edit_product_pvt==1){echo $edit_p_name_pvt;} ?>" <?php if($edit_product_pvt==1){ echo 'readonly'; } ?>>
															
														</div>
														
													</div>
													<font class="controls" style="font-size: small">Format: QoS-Profile-10M</font>


													<div class="control-group" style="margin-top: 10px;">
														<label class="control-label" for="description">QoS<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input  class="form-control span2" id="description" name="description" placeholder="Downlink" type="text" value="<?php if($edit_product_pvt==1){echo $edit_p_QOS_pvt;} ?>"<?php  echo 'readonly'; ?>>&nbsp;
															<input  class="form-control span2" id="description_up" name="description_up" placeholder="Uplink" type="text" value="<?php if($edit_product_pvt==1){echo $edit_p_QOS_up_pvt;} ?>" <?php  echo 'readonly'; ?>>&nbsp;Mbps

															<input type="hidden" name="dob1" />
														</div>
													</div>
<script>
$('#description').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });

$('#description_up').bind("cut copy paste",function(e) {
                                                                              e.preventDefault();
                                                                           });



</script>

											
													<div class="control-group">
														<label class="control-label" for="product_code">Purge Delay Time</label>
														<div class="controls col-lg-5">
															<input type="text" class="span4" id="Purge_delay_time" name="Purge_delay_time" value="<?php if($edit_product_pvt==1){echo $edit_p_prug_time_pvt;} ?>">&nbsp;Sec
														</div>
													</div>

													<?php if($edit_product_pvt==1){?>
																		<input type="hidden" name="pvt_package_edit" value="<?php echo $edit_p_id_pvt; ?>">
																		<input type="hidden" name="edit_pvt_id" value="<?php echo $edit_p_id_pvt;?>">
													<?php }
													?>

													<div class="form-actions">
														<button type="submit" name="create_product_submit" id="create_product_submit"
																class="btn btn-primary">Save</button>

	                                                </div>
	                                            </fieldset>
											</form>

<script type="text/javascript">

$(document).ready(function() {

	$('#product_name, #description, #description_up, #Purge_delay_time').keyup(function(e){

		ck_pvtval();

	});

    var edit_product_pvt='<?php echo $edit_product_pvt;?>';
	document.getElementById("create_product_submit").disabled = true;
	if(edit_product_pvt!=1){
		document.getElementById("description").readOnly = false;
		document.getElementById("description_up").readOnly = false;
			}

	
});


function ck_pvtval(){

	var name=document.getElementById('product_name').value;
	var qos1=document.getElementById('description').value;
	var qos2=document.getElementById('description_up').value;
	var pdtime=document.getElementById('Purge_delay_time').value;


	if(name==''||qos1==''||qos2==''||pdtime==''){
		document.getElementById("create_product_submit").disabled = true;

		}else{
			document.getElementById("create_product_submit").disabled = false;

			}



	}

</script>


											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3>Private Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													 <div style="overflow-x:auto">
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>



														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DL</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">UL</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Purge time</th>

																<!-- <th style="min-width: 100px;">Status</th> -->
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Remove</th>

															</tr>
														</thead>
														<tbody>
														<?php
																$key_q1 = "SELECT p.id,p.product_code,p.QOS,p.QOS_up_link,p.time_gap,p.create_date,p.default_value ,d.product_id, IF(d.product_id IS NULL,0,IF(group_concat(d.distributor_code) ='' ,0,1))  AS assign, d.`distributor_code`,p.`max_session`,p.`purge_time`
																				FROM exp_products p LEFT JOIN exp_products_distributor d
																				ON p.`product_id`=d.`product_id`
																				WHERE p.mno_id = '$user_distributor' AND p.network_type='PRIVATE'
																				GROUP BY p.id
																				ORDER BY p.`QOS`";

																$query_results1=mysql_query($key_q1);

																while($row=mysql_fetch_array($query_results1)){
																	$product_code = $row[product_code];
																	$description = $row[QOS];
																	$description_up = $row[QOS_up_link];


																	$create_date = $row[create_date];
																	$default_value = $row[default_value];
																	$product_id = $row[id];
																	$assign=$row[assign];
																	$purge_time=$row[purge_time];

																	$timegap = $row[time_gap];
																	$gap = "";
																	if($timegap != ''){

																		$interval = new DateInterval($timegap);

																		if($interval->y != 0){
																			$gap .= $interval->y.' Years ';
																		}
																		if($interval->m != 0){
																			$gap .= $interval->m.' Months ';
																		}
																		if($interval->d != 0){
																			$gap .= $interval->d.' Days ';
																		}
																		if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
																			$gap .= ' And ';
																		}
																		if($interval->i != 0){
																			$gap .= $interval->i.' Minutes ';
																		}
																		if($interval->h != 0){
																			$gap .= $interval->h.' Hours ';
																		}

																	}



																	echo '<tr>
																		<td> '.$product_code.' </td>
																		<td> '.$description.' Mbps </td>
																		<td> '.$description_up.' Mbps </td>
																		
																		<td> '.$purge_time.'</td>';

														

																///////////////////////////////////////////																	
																	
																	echo '<td>';
																	echo'
                                                                        <a href="javascript:void();" id="EDIT_AP_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_AP_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_AP_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&edit_product_pvt_id=' . $product_id . '"
                                                                            });
                                                                            });
                                                                        </script></td>';
																	
//////////////////////////////////////////																	
																	echo '<td>';
																	if($assign==0){
																	echo'<a href="javascript:void();" id="AP_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#AP_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});


                                                                            $(\'#AP_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&remove_product_id=' . $product_id . '&api_id='.$api_id.'"
                                                                            });
                                                                            });
                                                                        </script>';}else{


                                                                        echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-lock"></i>&nbsp;Remove</a></center>';

																	}
																	echo'</td>';

																}
																?>


														</tbody>
														</table>
												</div>
												</div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->





											<!-- /////////////////////////////////////////////////////// -->
<hr>
															<?php } ?>

											<h3 id="create_guest_prof_h3">Create Guest QoS Profile(s)</h3>
											<br>
											<form id="create_guest_form" name="create_product_form" method="post" class="form-horizontal" action="?t=1" autocomplete="off">
												<fieldset>

												<div id="response_d3">

											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>

													<div class="control-group" style="margin-bottom: 0px !important">
														<label class="control-label" for="product_name">Name<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input required class="form-control span4" id="product_name2" name="product_name" type="text" value="<?php echo $edit_p_name;?>" <?php if($edit_guest_product==1){echo'readonly';}?>>
															
															
														</div>
														
													</div>
													<font class="controls" style="font-size: small">Format : QoS-Profile-10M</font>


													<div class="control-group" style="margin-top: 10px;">
														<label class="control-label" for="description1">QoS<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input  class="form-control span2" id="description1" name="description1" placeholder="Downlink" type="text" value="<?php echo $edit_p_QOS;?>" <?php echo'readonly';?>>&nbsp;
															<input  class="form-control span2" id="description1_up" name="description1_up" placeholder="Uplink" type="text"value="<?php echo $edit_p_QOS_up;?>" <?php echo'readonly';?>>&nbsp;Mbps

															<input type="hidden" name="dob2" />
														</div>
													</div>
											
													 <div class="control-group">
                                                        <label class="control-label" for="product_code">Purge Delay Time</label>
                                                        <div class="controls col-lg-5">
															<input type="text" class="span4" id="Purge_delay_time2" name="Purge_delay_time"  value="<?php echo $edit_p_prug_time;?>">&nbsp;Sec
                                                        </div>
                                                    </div>

<script type="text/javascript">


function seshrselect(v){

	var x = $( "#sesson_du_select3" ).val();

	$('#max_sessions').empty();




		$("#max_sessions").append('<option value="1">1</option>');
		$("#max_sessions").append('<option value="2">2</option>');
		$("#max_sessions").append('<option value="3">3</option>');
		$("#max_sessions").append('<option value="4">4</option>');
		$("#max_sessions").append('<option value="5">5</option>');
		$("#max_sessions").append('<option value="6">6</option>');
		$("#max_sessions").append('<option value="7">7</option>');
		$("#max_sessions").append('<option value="8">8</option>');
		$("#max_sessions").append('<option value="9">9</option>');
		$("#max_sessions").append('<option value="10">10</option>');
		$("#max_sessions").append('<option value="11">11</option>');
		$("#max_sessions").append('<option value="12">12</option>');
		$("#max_sessions").append('<option value="13">13</option>');
		$("#max_sessions").append('<option value="14">14</option>');
		$("#max_sessions").append('<option value="15">15</option>');
		$("#max_sessions").append('<option value="16">16</option>');
		$("#max_sessions").append('<option value="17">17</option>');
		$("#max_sessions").append('<option value="18">18</option>');
		$("#max_sessions").append('<option value="19">19</option>');
		$("#max_sessions").append('<option value="20">20</option>');
		$("#max_sessions").append('<option value="21">21</option>');
		$("#max_sessions").append('<option value="22">22</option>');
		$("#max_sessions").append('<option value="23">23</option>');
		$("#max_sessions").append('<option value="24">24</option>');



}


</script>

													<div class="control-group">
														<label class="control-label" for="max_sessions">Max Sessions/24 Hours<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5">
                                                           <select id="max_sessions" name="max_sessions" class="span2">

															   <?php
															   		for($i=1;$i<=24;$i++){
																		?>

                                                               			<option <?php if($edit_p_maxses==$i){echo ' selected ';}?> value="<?php echo $i;?>"><?php echo $i;?></option>

																		<?php
																	}
															   ?>
                                                           </select>


														</div>
													</div>



													<div class="control-group">
														<label class="control-label" for="max_sessions_alert">Max Session Alert<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input required class="span4 form-control" id="max_sessions_alert" name="max_sessions_alert" type="text" value="<?php echo $edit_p_alert;?>">


														</div>
													<font class="controls" style="font-size: small">(Hint: You reached the maximum number of sessions per day. Please come back.)</font>
													</div>


												<!--  	<div class="control-group">
														<label class="control-label" for="product_code">Profile Values</label>
														<div class="controls col-lg-5">
															<input class="span4" id="product_code1" name="product_code1" type="text" required>
													-->

															<!-- &nbsp;, -->

															<!--<input class="span2" id="product_code2" name="product_code2" type="text" required>&nbsp;,
															<input class="span2" id="product_code3" name="product_code3" type="text" required>  -->
													<!--
														</div>
													</div> -->




																	<?php if($edit_guest_product==1){?>
																		<input type="hidden" name="guest_package_edit" value="<?php echo $edit_p_id; ?>">
																		<input type="hidden" name="edit_guest_id" value="<?php echo $edit_p_id;?>">
													<?php }
																	?>

													<div class="form-actions">
														<button type="submit" name="create_product_submit_guest" id="create_product_submit_guest"
																class="btn btn-primary">Save</button>

	                                                </div>
	                                            </fieldset>
											</form>


<script type="text/javascript">

$(document).ready(function() {


	$('#product_name2, #description1, #description1_up, #Purge_delay_time2, #max_sessions_alert').keyup(function(e){

		ck_gstval();

	});

<?php if(!isset($edit_p_id)){ ?>    
	document.getElementById("create_product_submit_guest").disabled = true;

<?php } ?> 
var edit_product_gst='<?php echo $edit_guest_product;?>';
	if(edit_product_gst!=1){
		document.getElementById("description1").readOnly = false;
		document.getElementById("description1_up").readOnly = false;
			}   
	
});


function ck_gstval(){

	var name=document.getElementById('product_name2').value;
	var qos1=document.getElementById('description1').value;
	var qos2=document.getElementById('description1_up').value;
	var pdtime=document.getElementById('Purge_delay_time2').value;
	var maxses=document.getElementById('max_sessions_alert').value;


	var format = /^[^\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\[|\{|\]|\}|\||\\|\'|\<|\,|\.|\>|\?|\/|\""|\;|\:]+$/i;

	if( name.match(format) ){
		name = 'set';
	}else{
		name = '';
	}


	if(name==''||qos1==''||qos2==''||pdtime==''||maxses==''){
		document.getElementById("create_product_submit_guest").disabled = true;

		}else{
			document.getElementById("create_product_submit_guest").disabled = false;

			}



	}

</script>


										<div id="view_guest_pof_div" class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3> Guest Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													<div style="overflow-x:auto">
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Profile Name</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">DL</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">UL</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Max Sessions</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Purge time</th>
																
																<!-- <th style="min-width: 100px;">Status</th> -->
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5" >Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6" >Remove</th>

															</tr>
														</thead>
														<tbody>

														<?php
																$key_q1 = "SELECT p.id,p.product_code,p.QOS,p.QOS_up_link,p.time_gap,p.create_date,p.default_value ,d.product_id, IF(d.product_id IS NULL,0,IF(group_concat(d.distributor_code) ='' ,0,1))  AS assign, d.`distributor_code`,p.`max_session`,p.`purge_time`
																			FROM exp_products p LEFT JOIN exp_products_distributor d
																			ON p.`product_id`=d.`product_id`
																			WHERE p.mno_id = '$user_distributor' AND p.network_type='GUEST'
																			GROUP BY p.id
																			ORDER BY p.`QOS`";

																$query_results1=mysql_query($key_q1);

																while($row=mysql_fetch_array($query_results1)){
																	$product_code = $row[product_code];
																	$description = $row[QOS];
																	$description_up = $row[QOS_up_link];


																	$create_date = $row[create_date];
																	$default_value = $row[default_value];
																	$product_id = $row[id];
																	$assign=$row[assign];
																	$max_ses=$row[max_session];
																	$purge_time=$row[purge_time];

																	$timegap = $row[time_gap];
																	$gap = "";
																	if($timegap != ''){

																		$interval = new DateInterval($timegap);

																		if($interval->y != 0){
																			$gap .= $interval->y.' Years';
																		}
																		if($interval->m != 0){
																			$gap .= $interval->m.' Months';
																		}
																		if($interval->d != 0){
																			$gap .= $interval->d.' Days';
																		}
																		if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
																			$gap .= ' And ';
																		}
																		if($interval->i != 0){
																			$gap .= $interval->i.' Minutes';
																		}
																		if($interval->h != 0){
																			$gap .= $interval->h.' Hours';
																		}

																	}



																	echo '<tr>
																		<td> '.$product_code.' </td>
																		
																		<td> '.$description.' Mbps </td>
	     																<td> '.$description_up.' Mbps </td>

																		<td> '.$max_ses.'</td>
																		<td> '.$purge_time.'</td>';

																	if($default_value==1){
																		
																		/*
																		echo '<td><a href="javascript:void();" id="CD1_'.$product_id.'"  class="btn btn-small btn-success">
															Active<i class="btn-icon-only icon-thumbs-up">   </i> </a>&nbsp;<img id="campcreate_loader_'.$product_id.'" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#CD1_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Inactive Profile\',
																				text: \'Are you sure you want to inactive this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                $(\'#CD1_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&status=1&mno_id='.$user_distributor.'&pro_default_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script></td>';
																				*/
																		//echo '</td>';

																	}else {
                                                                      /*      echo '<td>';

                                                                            echo '<a href="javascript:void();" id="CD1_'.$product_id.'"  class="btn btn-small btn-warning">
															Inactive<i class="btn-icon-only icon-thumbs-down"> </i> </a>&nbsp;
															<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            		$(\'#CD1_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Active Profile\',
																				text: \'Are you sure you want to active this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                $(\'#CD1_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&status=0&mno_id='.$user_distributor.'&pro_default_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script>

                                                            </td>'; */
																		/*
																		 * $("#create_product_submit").easyconfirm({locale: {
																				title: 'Product Creation',
																				text: 'Are you sure you want to save this informations ?',
																				button: ['Cancel',' Confirm'],
																				closeText: 'close'
																				 }
																			});
																			$("#create_product_submit").click(function() {
																			});
																		 * */

																	} 

																	echo '<td>';
																	echo'
                                                                        <a href="javascript:void();" id="EDIT_AP1_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_AP1_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_AP1_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&edit_product_id=' . $product_id . '#create_guest_prof_h3"
                                                                            });
                                                                            });
                                                                        </script></td>';
																	echo'<td>';
																	if($assign==0){
																	echo'<a href="javascript:void();" id="AP1_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>&nbsp;<img id="ap_loader_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																		$(\'#AP1_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#AP1_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=1&remove_product_id=' . $product_id . '&api_id='.$api_id.'"
                                                                            });
                                                                            });
                                                                        </script>';}else{

                                                                        echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-lock"></i>&nbsp;Remove</a></center>';

																	}
																		echo'</td>';

																}
																?>
														</tbody>
														</table>
												</div>
												</div>
												</div>


<!-- /////////////////////////////////////////////////////////////// -->

                                    </div>

                                   <?php } ?>



<!-- ////////////////////////////////////// -->
<!-- ////////////////////////////////product create //////////////////// -->



	<?php if(in_array("CONFIG_DURATION",$features_array)){ ?>
                                    <div <?php if((isset($tab2)&&$user_type == 'MNO') || (isset($tab2)&&$user_type == 'SALES')){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="duration_create">

                                        <div id="response_">

   

                                        </div>

<!-- ///////////////////////////////////////////////////////////// -->



										<h3>Create Session Duration Profile(s)</h3>
											<br>
											<form onkeyup="dura_ck();" onchange="dura_ck();" id="create_duration_form" name="create_duration_form" method="post" class="form-horizontal" action="?t=2" autocomplete="off">
												<fieldset>

												<div id="response_d3">
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>






										 			<div class="control-group">
														<label class="control-label" for="product_name">Name<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5 form-group">
															<input class="span4" id="duration_product_name" name="duration_product_name" type="text" value="<?php if($edit_product_duration==1){echo $edit_dura_name;} ?>" <?php if($edit_product_duration==1){ echo 'readonly'; } ?>>

														</div>

													</div>

													<?php
														if($edit_product_duration==1){
															$timegap1 = $edit_dura_timegap;
															if($timegap1 != ''){

																$interval1 = new DateInterval($timegap1);

																if($interval1->y != 0){
																	$gap_year1 = $interval1->y;
																}
																if($interval1->m != 0){
																	$gap_month1= $interval1->m;
																}
																if($interval1->d != 0){
																	$gap_day1= $interval1->d;
																}
																if($interval1->i != 0){
																	$gap_min1= $interval1->i;
																}
																if($interval1->h != 0){
																	$gap_hour1= $interval1->h;
																}

															}
														}
													?>


													<div class="control-group">
														<label class="control-label" for="product_code">Session Duration<strong><font color="#FF0000"></font></strong></label>
														<div class="controls col-lg-5">
															
																	
																		<select id="du_select1" name="du_select1" class="span0" >
																			<option  selected value="0">0</option>
																		<?php for($i=1;$i<=12;$i++) {

																				if($gap_month1==$i || $gap_day1==$i){
																					echo '<option selected value="' . $i . '">' . $i . '</option>';
																				}else{
																					echo '<option value="' . $i . '">' . $i . '</option>';
																				}
																			}
																			?>
																			<script type="text/javascript">
																			
																			
																	$(document).ready(function(){
																	$("#du_select2").change(function() {
															    	var parent = $(this).val(); 
															    switch(parent){ 
															        case 'M':
															        $("#du_select1").html("");
															        var i;
																	for (i = 0; i <= 12; i++) { 
																	   
															        $("#du_select1").append('<option value="'+i+'">'+i+'</option>');

															    }
															        break;   
																	            //break;
																	case 'D':
																	$("#du_select1").html("");
																	 var i;
																	for (i = 0; i <= 30; i++) { 
																	   
															       $("#du_select1").append('<option value="'+i+'">'+i+'</option>');
															    }
																	break;             	
																
																	           }
																	})}); 
																	//function to populate child select box


																		
																	</script>
																		</select>
																	
																	
																		<select id="du_select2" name="du_select2" class="span0" >
																			<option <?php if(isset($gap_month1)){echo 'selected';}?> value="M">Months</option>
																			<option <?php if(isset($gap_day1)){echo 'selected';}?> value="D">Days</option>
																		</select>
															</div>
															<div class="controls col-lg-5">
																<!-- <td><b> +</p> </b></td> -->	
																
																		<select id="du_select3" name="du_select3" class="span0">
																			<option  value="0">0</option>
																			<?php

																			for($i=1;$i<25;$i++){
																				?>
																				<option <?php if($gap_hour1==$i ){echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>

																			<?php } ?>

																		</select>
																	
																		<select id="du_select4" name="du_select4" class="span0">

																			<option <?php if(isset($gap_hour1)){echo 'selected';}?> value="H">Hours</option>

																		</select>
																	</div>
																	<style type="text/css">

																	@media (max-width: 979px) and (min-width: 768px){

																		#du_select1,#du_select2,#du_select3,#du_select4,#du_select5,#du_select6{
																			width: 112px !important;
																		}

																	}

																	@media (min-width: 980px){
																		#du_select1,#du_select2,#du_select3,#du_select4,#du_select5,#du_select6{
																			width: 148px !important;
																		}
																	}

																	@media (max-width: 768px) and (min-width: 480px){

																		#du_select1,#du_select3,#du_select5{
																			width: 62px !important;
																			display: inline-block !important;
																		}
																		#du_select2,#du_select4,#du_select6{
																			width: 92px !important;
																			display: inline-block !important;
																		}

																	}

																	@media (max-width: 480px) and (min-width: 392px){

																		#du_select1,#du_select3,#du_select5,#du_select2,#du_select4,#du_select6{
																			display: inline-block !important;
    																		width: 124px !important;
																		}
																		

																	}
																	@media (max-width: 392px){

																		#du_select1,#du_select3,#du_select5,#du_select2,#du_select4,#du_select6{
																			display: inline-block !important;
    																		width: 49.2% !important;
																		}
																		

																	}
																	@media (min-width: 1200px){

																		#du_select1,#du_select3,#du_select5,#du_select2,#du_select4,#du_select6{
																			width: 183px !important;
																		}
																	}
																		
																	</style>
																	<!-- <td><b> +</p> </b></td> -->	
																
																	
																	<div class="controls col-lg-5">
																		<select id="du_select5" name="du_select5" class="span0">
																			<option  value="0">0</option>
																			<?php

																			for($i=1;$i<61;$i++){
																				?>
																				<option <?php if($gap_min1==$i ){echo 'selected';}?> value="<?php echo $i;?>"><?php echo $i;?></option>

																			<?php } ?>

																		</select>
																	
																		<select id="du_select6" name="du_select6" class="span0">

																			<option <?php if(isset($gap_min1)){echo 'selected';}?> value="M">Minutes</option>

																		</select>
																	
														            </div>

													</div>
                                                    <div style=" margin-top: -22px; " class="control-group">
                                                        <div class="controls col-lg-5 form-group">
                                                            <input type="hidden" name="duration" id="duration">
                                                        </div>

                                                    </div>

													<div class="control-group">
														<label class="control-label" for="product_code">Profile Type<strong><font color="#FF0000"></font></strong></label>
															<div class="controls col-lg-5 form-group">
																		<select onchange="isdef()" id="product_du_type" name="product_du_type" class="span4" >
																			<option  <?php echo $edit_dure_type=='1'?'selected':''; ?> value="1">Guest Only</option>
																			<?php if($network_opt =='privat' || $network_opt =='both' ){ ?>	<option <?php echo $edit_dure_type=='2'?'selected':''; ?>  value="2">Private Only</option> <?php } ?>

																		</select>
															</div>
													</div>
													
													<div id="default_ckeck" class="control-group">
														<label class="control-label" for="radiobtns">Is Default</label>
														<div class="controls">
															<div class="">
															<input id="is_default" <?php if($edit_is_def=='1'){echo 'checked';} ?> name="is_default" type="checkbox" >
															</div>
														</div>
													</div>
													
													
													<script type="text/javascript">

													function isdef(){
														var type =$("#product_du_type").val();

														if(type=='1'){

															$("#default_ckeck").show();
														}else{

															$("#default_ckeck").hide();
														}
															
														}


														$( document ).ready(function() {
															isdef();
														});


													</script>
													

													<?php if($edit_product_duration==1){ ?>
																		<input type="hidden" name="edit_duration_id" value="<?php echo $edit_dura_id;?>">
																		<input type="hidden" name="duration_package_edit" value="<?php echo $edit_dura_code;?>">
													<?php }
													?>

													<div class="form-actions">
														<?php if($edit_product_duration==1){ ?>
															<button type="submit" name="duration_product_cancel" id="duration_product_cancel"
																	class="btn btn-primary">Cancel</button>
														<?php }
														?>
														<button type="submit" name="duration_product_submit" id="duration_product_submit"
																class="btn btn-primary" disabled="disabled">Save</button>


	                                                </div>
	                                            </fieldset>
											</form>

<script type="text/javascript">

function dura_ck(){


			document.getElementById("duration_product_submit").disabled = false;


	
}


</script>


											<div class="widget widget-table action-table">
												<div class="widget-header">
													<!-- <i class="icon-th-list"></i> -->
													<h3> Duration Profiles</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response">
													 <div style="overflow-x:auto">
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>



														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" >Profile Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Session Duration</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Type</th>

																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3" >Edit</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4" >Remove</th>

															</tr>
														</thead>
														<tbody>
														<?php
																$key_q1 = "SELECT	p.`id`,p.`profile_name`,p.`duration`,p.`profile_type`,p.`is_enable`,p.`is_default`,if(ISNULL(d.duration_prof_code),'0','1') AS riserv
FROM `exp_products_duration` p  LEFT JOIN exp_products_distributor d ON p.profile_code=d.duration_prof_code
WHERE `distributor`='$user_distributor' GROUP BY id ORDER BY is_default DESC";

																$query_results1=mysql_query($key_q1);

																while($row=mysql_fetch_array($query_results1)){
																	$product_id = $row['id'];
																	$product_name = $row['profile_name'];
																	$product_duration = $row['duration'];
																	$product_type = $row['profile_type'];
																	$assign = $row['riserv'];
																	
																	$duration_isdef= $row['is_default'];
																	
																	if($duration_isdef=='1'){
																		
																		$isdef_tableval=' (Default)';
																		
																	}else{
																		$isdef_tableval='';
																		
																		}
																	
																	
																	switch($product_type){
																		case '1': {
																			$product_type='Guest';
																			break;
																		}case '2': {
																			$product_type='Private';
																			break;
																		}case '3': {
																			$product_type='Guest & Private';
																			break;
																		}
																	}
																	$product_status = $row['is_enable'];

																	$gap = "";
																	if($product_duration != ''){

																		$interval = new DateInterval($product_duration);

																		if($interval->y != 0){
																			$gap .= $interval->y.' Year(s) ';
																		}
																		if($interval->m != 0){
																			$gap .= $interval->m.' Month(s) ';
																		}
																		if($interval->d != 0){
																			$gap .= $interval->d.' Day(s) ';
																		}
																		if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
																			$gap .= ' And ';
																		}
																		if($interval->h != 0){
																			$gap .= $interval->h.' Hour(s) ';
																		}
																		if($interval->i != 0){
																			$gap .= $interval->i.' Minute(s) ';
																		}

																	}



																	echo '<tr>
																		<td> '.$product_name.' </td>
																		<td> '.$gap.'</td>
																		<td> '.$product_type.$isdef_tableval.'</td>';

																/*	if($product_status==1){
																		echo '<td><a href="javascript:void();" id="dura_'.$product_id.'"  class="btn btn-small btn-success">Active
															<i class="btn-icon-only icon-thumbs-up">   </i> </a>&nbsp;<img id="campcreate_loader2_'.$product_id.'" src="img/loading_ajax.gif" style="display: none;"><script type="text/javascript">
                                                            $(document).ready(function() {
                                                             $(\'#dura_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Inactive Profile\',
																				text: \'Are you sure you want to inactive this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});

                                                                $(\'#dura_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&t=2&status=0&duration_pro_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script></td>';

																		//echo '</td>';

																	}else {
                                                                            echo '<td>';

                                                                            echo '<a href="javascript:void();" id="dura_'.$product_id.'"  class="btn btn-small btn-warning">Inactive
															<i class="btn-icon-only icon-thumbs-down"> </i> </a>&nbsp;<img id="campcreate_loader2_'.$product_id.'" src="img/loading_ajax.gif" style="display: none">

      													<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#dura_'.$product_id.'\').easyconfirm({locale: {
																				title: \'Active Profile\',
																				text: \'Are you sure you want to active this Profile ?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                $(\'#dura_'.$product_id.'\').click(function() {
                                                                    //modifyBox(\'campcreate\',\'campcreate_response\','.$product_id.',\'0\');
                                                                    window.location = "?token='.$secret.'&t=2&status=1&duration_pro_id='.$product_id.'"
                                                                });
                                                                });
                                                            </script></td>';

																	}  */

																///////////////////////////////////////////

																	echo '<td>';
																	echo'
                                                                        <a href="javascript:void();" id="EDIT_dura_' . $product_id . '"  class="btn btn-small btn-primary">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a><img id="ap_loader2_' . $product_id . '" src="img/loading_ajax.gif" style="display:none">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
																			$(\'#EDIT_dura_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Edit Profile\',
																				text: \'Are you sure you want to edit this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});
                                                                            $(\'#EDIT_dura_' . $product_id . '\').click(function() {
                                                                                window.location = "?token=' . $secret . '&t=2&edit_dura_product_id=' . $product_id . '"
                                                                            });
                                                                            });
                                                                        </script></td>';

//////////////////////////////////////////
																	echo '<td>';
																	if($assign==0){
																	echo'<a href="javascript:void();" id="rm_dura_' . $product_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="icon icon-remove-circle"></i>&nbsp;Remove</a>&nbsp;<img id="rm_dura_' . $product_id . '" src="img/loading_ajax.gif" style="display:none"><script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#rm_dura_' . $product_id . '\').easyconfirm({locale: {
																				title: \'Remove Profile\',
																				text: \'Are you sure you want to remove this Profile?\',
																				button: [\'Cancel\',\' Confirm\'],
																				closeText: \'close\'
																				 }
																			});


                                                                            $(\'#rm_dura_' . $product_id . '\').click(function() {
                                                                                window.location = "?token2=' . $secret . '&t=2&remove_duration_id=' . $product_id .'"
                                                                            });
                                                                            });
                                                                        </script>';}else{


                                                                        echo '<a class="btn btn-small btn-warning" disabled ><i class="icon icon-lock"></i>&nbsp;Remove</a></center>';

																	}
																	echo'</td>';

																}
																?>


														</tbody>
														</table>
												</div>
												</div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->


<!-- /////////////////////////////////////////////////////////////// -->

                                    </div>

                                <?php } ?>



<!-- ////////////////////////////////////// -->




										<!-- ==================== registration ==================== -->
									<?php if(in_array("CONFIG_REGISTER",$features_array)){?>
									<div class="tab-pane <?php if(isset($tab22)){ ?>active <?php } ?>" id="registration">
                                    
                                    
                                    
                                    <form id="fb_form" method="post" action="?t=22" name ="fb_form" class="form-horizontal">

                                    	<div class="control-group">
													<div class="controls">
                                    
                                    <legend>Facebook</legend>

                                </div>
                            </div>

												<div id="fb_response"></div>
												<div class="control-group">
													<div class="controls">
													<label class="" for="radiobtns">Facebook App ID</label>
														<div class="input-prepend input-append">
														<input class="span4" id="fb_app_id" name="fb_app_id" type="text" value="<?php echo $db->setSocialVal("FACEBOOK","app_id",$user_distributor); ?>" required>
														</div>
													</div>
													<!-- /controls -->
											</div>

											<!-- /control-group -->
												<?php
														$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_social_profile'");
														$rowe = mysql_fetch_array($br);
														$auto_increment = $rowe['Auto_increment'];
														$social_profile = 'social_'.$auto_increment;
												?>

											<input class="span4" id="social_profile" name="social_profile" type="hidden" value="<?php echo $social_profile; ?>" >
												<input class="span4" id="app_xfbml" name="app_xfbml" type="hidden" value="true" >
												<input class="span4" id="app_cookie" name="app_cookie" type="hidden" value="true" >
												<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>" >
												<div class="control-group">
													<div class="controls">
													<label class="" for="radiobtns">Facebook App Version</label>
											<div class="input-prepend input-append">
												<input class="span4" id="fb_app_version" name="fb_app_version" type="text" value="<?php echo $db->setSocialVal("FACEBOOK","app_version",$user_distributor); ?>" required>
													</div>
													</div>
												</div>
                                        <?php
                                        $q1 = "SELECT `config_file` FROM `exp_plugins` WHERE `plugin_code` = 'FACEBOOK'";
                                        $r1 = mysql_query($q1);
                                        while ($row = mysql_fetch_array($r1)) {
                                            $additionalFields = strlen($row[config_file])>0?'1':'0';

                                            $array_plugin =  explode(',', $row[config_file]);
                                        }

                                        if($additionalFields=='1'){?>
												<div class="control-group">
													

											<?php


													$q11 = "SELECT `fields` FROM `exp_social_profile` WHERE `social_media` = 'FACEBOOK' AND `distributor` = '$user_distributor'";
													$r11 = mysql_query($q11);
													while ($row1 = mysql_fetch_array($r11)) {
														$array_db_field =  explode(',', $row1[fields]);
													}


													foreach ($array_plugin as $arr) {

                                                        echo '<div class="controls">
                                                        <label class="" for="radiobtns">Facebook Additional Fields</label>
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

												<div class="control-group">


														<div class="controls">

												<legend>Manual Registration</legend>

											</div>
										</div>

												<div id="manual_response"></div>

												<div class="col-sm-6">


													<div class="control-group">


														<div class="controls">
														<label class="" for="radiobtns">First Name</label>

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

														



														<div class="controls">

															<label class="" for="radiobtns">Last Name</label>

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


														<div class="controls">
														<label class="" for="radiobtns">E-mail</label>

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

															$br = mysql_query("SHOW TABLE STATUS LIKE 'exp_manual_reg_profile'");

															$rowe = mysql_fetch_array($br);
															$auto_increment = $rowe['Auto_increment'];
															$manual_profile = 'manual_'.$auto_increment;

													?>

													<input class="span4" id="manual_profile" name="manual_profile" type="hidden" value="<?php echo $manual_profile; ?>" >


													<input class="span4" id="distributor" name="distributor" type="hidden" value="<?php echo $user_distributor; ?>" >

												</div>



												<div class="col-sm-6">

													<div class="control-group">




														<div class="controls">
														<label class="" for="radiobtns">Gender</label>

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


														<div class="controls">

														<label class="" for="radiobtns">Age Group</label>






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




														<div class="controls">
														<label class="" for="radiobtns">Mobile Number</label>

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

											$query_results=mysql_query($key_query);

											while($row=mysql_fetch_array($query_results)){

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

												<?php // echo $system_package; ?>

												<div class="control-group"   <?php
												if(!array_key_exists('time_zone',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  >

												<label class="control-label" for="radiobtns">Time Zone</label>

													<div class="controls form-group">
														<div class="input-prepend input-append">
															<select class="span4 form-control" id="time_zone" name="time_zone">
																<option value="">- Select Time-zone -</option>

																<?php 

																$get_tz = "SELECT timezones FROM exp_mno

																WHERE mno_id = '$user_distributor' LIMIT 1";

																$reslts=mysql_query($get_tz);

																$timezones='';
																while($r=mysql_fetch_array($reslts)){

																	$timezones = $r['timezones'];

																}


																$utc = new DateTimeZone('UTC');
																$dt = new DateTime('now', $utc);

																$select="";
																foreach(DateTimeZone::listIdentifiers() as $tz) {
																	$current_tz = new DateTimeZone($tz);
																	$offset =  $current_tz->getOffset($dt);
																	$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
																	$abbr = $transition[0]['abbr'];
																	if($timezones===$tz){
																		$select="selected";
																		//echo $timezones.'=='.$tz;
																	}else{
																		$select="";
																	}
																	echo '<option '.$select.' value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';
																}
																
															?>
															</select>
														</div>
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

                                                <div class="control-group" <?php
                                                if(!array_key_exists('reCapture',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none"';}
                                                ?> >
                                                    <h5><label>Google reCAPTURA</label></h5>

                                                    <label class="control-label" for="radiobtns">Secret Key</label>

                                                    <div class="controls form-group">

                                                        <input type="texy" class="span4 form-control" id="g-reCAPTCHA" name="g-reCAPTCHA" value="<?php echo $db->setVal("g-reCAPTCHA",'ADMIN'); ?>">

                                                    </div>
                                                    <br>

                                                    <label class="control-label" for="radiobtns">Site Key</label>

                                                    <div class="controls form-group">

                                                        <input type="texy" class="span4 form-control" id="g-reCAPTCHA-site-key" name="g-reCAPTCHA-site-key" value="<?php echo $db->setVal("g-reCAPTCHA-site-key",'ADMIN'); ?>">

                                                    </div>
                                                    <br>
                                                </div>

												
												<div class="control-group"  <?php
												if(!array_key_exists('mdu_camp_base_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Tenant Portal URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="tenant_url" name="tenant_url" type="text" value="<?php echo $db->setVal("mdu_portal_base_url",$user_distributor); ?>">
															

														

													</div>
													
													<div class="control-group">
													<div class="controls form-group">
													<font size="1">Ex: http://yourcompany.com/tenant</font>
													</div>
												</div>
													

												</div>


												<div class="control-group"  <?php
												if(!array_key_exists('mdu_camp_base_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

													<label class="control-label" for="radiobtns">Tenant Portal Internal URL</label>

													<div class="controls form-group">

														

															<input class="span4 form-control" id="tenant_internal_url" name="tenant_internal_url" type="text" value="<?php echo $db->setVal("mdu_camp_base_url",$user_distributor); ?>">
															

														

													</div>
													
													<div class="control-group">
													<div class="controls form-group">
													<font size="1">Ex: http://10.1.1.1/tenant</font>
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

                                                    <label class="control-label" for="radiobtns">Admin Profile</label>

                                                    <?php if($system_package!='N/A'){ ?>

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
																	$flatforms_q=mysql_query("SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN' AND is_enable=1");
																while($flatforms=mysql_fetch_assoc($flatforms_q)){
																	if($system_package==$flatforms['product_code']){
																	echo'<option selected value='.$flatforms['product_code'].' > '.$flatforms['discription'].' </option>';
																	}else{
																	echo'<option value='.$flatforms['product_code'].' > '.$flatforms['discription'].' </option>';
																	}
																}
																?>

                                                            </select>

                                                        

                                                    </div>



                                                </div>

                                                <div class="control-group"   <?php
												if(!array_key_exists('platform',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												//if(true){echo' style="display:none";';}
												?>  >

                                                    <label class="control-label" for="radiobtns">Login Profile</label>
                                                    <div class="controls form-group">
                                                    <?php

                                                    	$login_profiles = json_decode($db->setVal('ALLOWED_LOGIN_PROFILES','ADMIN'),true);

                                                    	//print_r($login_profiles); die();

                                                        foreach ($login_profiles as $key=>$value){
                                                            $checked = $value=='1'?'checked':'';
                                                            echo '<input '.$checked.' type="checkbox" value="'.$key.'" name"login_profiles" class="login_profiles"/>&nbsp&nbsp&nbsp'.$key.'<br>';
                                                        }

                                                    ?>
                                                    </div>

                                                    <div class="controls form-group">

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

$query_results=mysql_query($get_l);

while($row=mysql_fetch_array($query_results)){

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

									<div <?php if((isset($tab0)&&$user_type == 'MNO' )|| (isset($tab0)&&$user_type == 'SALES')){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp3">


										<div class="control-group form-horizontal">

													

													<div class="controls col-lg-5 form-group">

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

											$query_results=mysql_query($key_query);

											while($row=mysql_fetch_array($query_results)){

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

									</div>
									</div>

											<br>








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

														<label class="" for="radiobtns">Master Email</label>

															<input class="form-control span4" id="master_email1" name="master_email1" type="text" value="<?php echo $db->setVal("email",$user_distributor); ?>">



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

<!-- <?php  $platformfh= $db->getValueAsf("SELECT system_package AS f FROM exp_mno WHERE mno_id='ADMIN'") ; ?>

<?php //if($platformfh!='N/A'){ ?>


<script type="text/javascript">

$(document).ready(function() {

	$('#dble_fo_na').hide();


    });


</script>



<?php// } ?> -->

<div id="dble_fo_na" <?php if($platformfh!='N/A'){echo 'style="display: none;"'; }?>>


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





										<!-- ====================== live_camp2 ============================ -->

									<div <?php if(isset($tab1) && $user_type != 'ADMIN' && $user_type != 'MNO' && $user_type != "SALES"){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp2">





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

											$query_results=mysql_query($key_query);

											while($row=mysql_fetch_array($query_results)){

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

													<label class="control-label" for="radiobtns">Site Title</label>

													<div class="controls">

														<div class="input-prepend input-append">

															<?php

															$get_l = "SELECT site_title,camp_theme_color FROM exp_mno_distributor

															WHERE distributor_code = '$user_distributor' LIMIT 1";

															$query_results=mysql_query($get_l);

															while($row=mysql_fetch_array($query_results)){

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

															$query_results=mysql_query($get_l);

															while($row=mysql_fetch_array($query_results)){

																$time_zone = $row[time_zone];

															}



															echo '<select class="span4" name="php_time_zone0" id="php_time_zone0">';

															echo '<option value="'.$time_zone.'">'.$time_zone.'</option>';

															foreach(DateTimeZone::listIdentifiers() as $tz) {

																$current_tz = new DateTimeZone($tz);

																$offset =  $current_tz->getOffset($dt);

																$transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());

																$abbr = $transition[0]['abbr'];

																echo '<option value="' .$tz. '">' .$tz. ' [' .$abbr. ' '. formatOffset($offset). ']</option>';

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

															$query_results=mysql_query($get_l);

															while($row=mysql_fetch_array($query_results)){

																$language_code = $row[language_code];

																$language = $row[language];

															}

															echo '<option value="'.$language_code.'">'.$language.'</option>';

															$key_query = "SELECT language_code, `language` FROM system_languages WHERE language_code <> '$lang' AND ex_portal_status = 1 ORDER BY `language`";

															$query_results=mysql_query($key_query);

															while($row=mysql_fetch_array($query_results)){

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

									<!--<div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="veryfi">

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

                                                    $rr = mysql_query($qq);

                                                    $cnt_theme = mysql_num_rows($rr);

                                                    if($cnt_theme != 0){

                                                        $isalert = 1;

                                                        echo '<legend>Theme</legend>';

                                                        $warning_text = '<div class="alert alert-warning" role="alert"><h3><small>';

                                                        $warning_text .= 'Themes are not assigned to below SSIDs';

                                                        $warning_text .= '</small></h3><ul>';



                                                        while($row11 = mysql_fetch_array($rr)){

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

                                                    $query_results00=mysql_query($query_warning00);

                                                    $cnt_location = mysql_num_rows($query_results00);



                                                    if($cnt_location > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Locations</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    APs are not assigned to below SSIDs</small></h3><ul>';



                                                        while($row0=mysql_fetch_array($query_results00)){

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

                                                    $query_results00=mysql_query($query_warning00);

                                                    $cnt_campaign = mysql_num_rows($query_results00);



                                                    if($cnt_campaign > 0){

                                                        $isalert = 1;

                                                        echo '<legend>Campaign</legend>';

                                                        echo  '<div class="alert alert-warning" role="alert"><h3><small>

		                                                    No live campaigns are assigned to below group tags</small></h3><ul>';



                                                        while($row0=mysql_fetch_array($query_results00)){

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

                                                    $query_results=mysql_query($key_query);

                                                    $cnt_ssid = mysql_num_rows($query_results);



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

                                                    $query_results=mysql_query($key_query);

                                                    $cnt_ap = mysql_num_rows($query_results);



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

									</div> -->









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


                                            $query_results=mysql_query($key_query);

                                            while($row=mysql_fetch_array($query_results)){

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

                                                $key_result = mysql_query($key_query);

                                                while($row=mysql_fetch_array($key_result)){

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