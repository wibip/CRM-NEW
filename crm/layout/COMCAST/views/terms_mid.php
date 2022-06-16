
<script src='js/jquery.elevatezoom.js'></script>
<div class="main">

	<div class="main-inner">

		<div class="container">

			<div class="row">

				<div class="span12">

					<div class="widget ">

						<div class="widget-header">
							<!-- <i class="icon-leaf"></i> -->
							<h3>Theme Management</h3>
						</div>
						<!-- /widget-header -->
						<div id="system1_response">
							<?php
							if(isset($_SESSION['system1_msg'])){
								echo $_SESSION['system1_msg'];
								unset($_SESSION['system1_msg']);
							}
							
							if(isset($_SESSION['msg22'])){
								echo $_SESSION['msg22'];
								unset($_SESSION['msg22']);

							}
							if (isset($_SESSION['msg5'])) {
								echo $_SESSION['msg5'];
								unset($_SESSION['msg5']);


							}
							?> 


						</div>
						<div class="widget-content">



							<div class="tabbable">
								<ul class="nav nav-tabs">
									<?php if(in_array("GENERIC_THEME",$features_array) || $package_features=="all"){ ?>
										<li <?php if($lan == 'en') echo ' class="active"'; ?> ><a href="#en" data-toggle="tab">Generic Theme</a></li>
									<?php } //print_r($features_array);?>


									<?php if($user_type == 'MNO' || $user_type == 'SALES'){
											//$tab20=1;
											//echo $system_package;
										//	print_r($features_array);
										?>

										<?php if(in_array("DEFAULT_THEME",$features_array) || $package_features=="all"){
                                        	//$tab20=1;
                                        	//echo "string";
											?>


											<li <?php
											if(isset($tab20)){$any_tab='0';$tab20='set';?>class="active" <?php }else if($any_tab=='1'){$any_tab='0';$tab20='set';?> class="active"<?php } ?>><a href="#view_generic_theme" data-toggle="tab">Default Theme</a></li>	
											
										<?php } ?>

										<?php if(in_array("TENANT_THEME",$features_array) || $package_features=="all"){
                                        	//$tab20=1;
											?>

											<li <?php if(isset($tab21)){$any_tab='0';$tab21='set';?>class="active" <?php }else if($any_tab=='1'){$any_tab='0';$tab21='set';?> class="active"<?php } ?>><a href="#theme_create" data-toggle="tab"><?php if(isset($_GET['modify_theme'])){echo "Edit Tenant Theme";}else{echo "Tenant Theme";} ?></a></li>	
											
										<?php } ?>

										<?php if(in_array("TENANT_THEME_PREVIEW",$features_array) || $package_features=="all"){
                                        	//$tab20=1;
											?>

											<li <?php if(isset($tab23)){?>class="active" <?php }?>><a href="#theme_preview" data-toggle="tab">Tenant Theme Preview</a></li>	
											
										<?php } ?>


									<?php } if(in_array("CAMP_DEFAULT",$features_array) || $package_features=="all"){
										?>
										<li <?php
										if(isset($tab5)){$any_tab='0';$tab5='set';?>class="active" <?php }else if($any_tab=='1'){$any_tab='0';$tab5='set';?> class="active"<?php } ?>><a href="#def_camp" data-toggle="tab">Default Campaign</a></li>


									<?php }?>

									<?php if(in_array("TERMS_REGISTER",$features_array)){ ?>
										<li <?php if(isset($tab22)){?>class="active" <?php } ?>><a href="#registration" data-toggle="tab">Registration</a></li>
									<?php } ?>
									

									<?php if(in_array("OPERATOR_THEME",$features_array) || $package_features=="all"){ 

										if((isset($tab20)) || ((in_array("GENERIC_THEME",$features_array) || $package_features=="all") && ($lan == 'en'))){

										}else{ 
											$tab19=1; 
										}
										?>

										<li <?php if(isset($tab19)){?>class="active" <?php }?>><a href="#upload_images" data-toggle="tab">Operator Theme</a></li>
									<?php } ?>




								</ul>

								<br>







								<div class="tab-content">





									<?php if(in_array("GENERIC_THEME",$features_array) || $package_features=="all"){ ?>

										<div class="tab-pane <?php if($lan == 'en') echo ' active'; ?>" id="en">
											<div id="en_response"></div>
											<form id="edit-profile" class="form-horizontal" method="POST">


												<?php

												$secret=md5(uniqid(rand(), true));
												$_SESSION['FORM_SECRET'] = $secret;

												echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';

												?>
												<input type="hidden" name="lan" id="lan" value="en" />

												<fieldset>



									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">Social Login Text</label>

										<div class="controls">
											<div class="">

											<textarea width="100%" id="social_login" name="social_login" class="jqte-test"><?php echo $social_login_txt; ?></textarea>


											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->



									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">Manual Login Text</label>

										<div class="controls">
											<div class="">

											<textarea width="500px" id="create_account" name="create_account" class="jqte-test"><?php echo $manual_login_txt; ?></textarea>


											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->








									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">Manual Registration Button</label>

										<div class="controls">
											<div class="">

											<textarea width="500px" id="sign_up" name="sign_up" class="jqte-test"><?php echo $registration_btn; ?></textarea>


											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->



									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">Connect free wifi button</label>

										<div class="controls">
											<div class="">

											<textarea width="500px" id="connectwifi" name="connectwifi" class="jqte-test"><?php echo $connect_btn; ?></textarea>


											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->


										<div class="control-group">
											<label class="control-label" for="radiobtns">Registration Type</label>

											<div class="controls">
												<div class="">

													<select id="reg_type" name="reg_type" required="required" onchange="choice1(this)">
														<option id="Click &amp; Connect" value="CLICK">Click &amp; Connect</option>
													</select>


												</div>
											</div>
											<!-- /controls -->
										</div>
										<div class="control-group">

											<label class="control-label" for="radiobtns">Browser Title</label>



											<div class="controls">

												<div class="">

													<input type="text" id="title_t" class="span6" name="title_t" value="<?php echo $title_t; ?>" required="required">

												</div>

											</div>

											<!-- /controls -->

										</div>

										<div class="control-group">
											<label class="control-label" for="radiobtns">Loading text</label>

											<div class="controls">
												<div class="">

													<input class="span6" id="loading" name="loading" type="text" value="<?php echo $loading_txt; ?>" required>

												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->

										<div id="backimg" class="control-group">

											<label class="control-label" id="up_logo_name1" for="radiobtns">Background</label>



											<div class="controls">

												<div id="bg_img_up1" class="" style="vertical-align:top;">

													<label class="filebutton">
														<font size="1">
															Browse Image
														</font>
														<span><input class="span4" id="image1" name="image1" type="file" style="width:90px;" onchange="return ajaxFileUpload(1,'');"></span>
														<input type="hidden" id="check_back" value="0">
														<input type="hidden" id="check_color" value="0">
													</label>&nbsp;&nbsp;<img id="loading_1" src="img/loading_ajax.gif" style="display:none;">
													<lable id="up_logo_desc1">(GIF, JPEG or PNG, Recommended 1600px*1000px)</lable>
												</div>



												<div class="" id="img_div1">
													<?php



													if(strlen($theme_bg_image)){
														?>
														&nbsp;&nbsp;<img src="<?php echo $original_bg_Image_Folder.$theme_bg_image; ?>" style='width:125px;height:100px; display:inline;'>
														<input type="hidden" name="image_1_name" id="image_1_name" value="<?php echo $theme_bg_image; ?>" />
														<?php
													}
													?>
												</div>
											</div>
										</div>
										<div id="logoimg" class="control-group">

											<label class="control-label" id="up_logo_name2" for="radiobtns">Logo</label>



											<div class="controls">

												<div id="bg_img_up2" class="" style="vertical-align:top;">

													<label class="filebutton">
														<font size="1">
															Browse Image
														</font>
														<span><input class="span4" id="image2" name="image2" type="file" style="width:90px;" onchange="return ajaxFileUpload(2,'');"></span>
														<input type="hidden" id="template_name" name="template_name" value="default_theme">
													</label>&nbsp;&nbsp;<img id="loading_2" src="img/loading_ajax.gif" style="display:none;">
													<lable id="up_logo_desc2">(GIF, JPEG or PNG, Recommended 1600px*1000px)</lable>
												</div>



												<div class="" id="img_div2">
													<?php

													if(strlen($theme_logo)){
														?>
														&nbsp;&nbsp;<img src="<?php echo $original_logo_Image_Folder.$theme_logo; ?>" style='width:125px;height:100px; display:inline;'>
														<input type="hidden" name="image_2_name" id="image_2_name" value="<?php echo $theme_logo; ?>" />
														<?php
													}
													?>
												</div>
											</div>
										</div>
										<div id="btncolor" class="control-group">

											<label class="control-label" for="radiobtns">Button Design</label>



											<div class="controls">

												<div class="">


													<table style="width:100%">
														<tr>
															<td width="25%"><input style="width:30px; height:30px;" class="span6" id="button_color" name="button_color" type="color" value="<?php echo $btn_color; ?>" required></td>

															<td width="25%"> <input style="width:30px; height:30px;" class="span6" id="btn_color_disable" name="btn_color_disable" type="color" value="<?php echo $btn_color_disable; ?>" required></td>

															<td width="25%"><input style="width:30px; height:30px;" class="span6" id="button_ho_color" name="button_ho_color" type="color" value="<?php echo $btn_border; ?>" required></td>

															<td width="25%"><input style="width:30px; height:30px;" class="span6" id="button_text_color" name="button_text_color" type="color" value="<?php echo $btn_text_color; ?>" required></td>

														</tr>
														<tr>

															<td width="25%" class="span2">(Active)</td>
															<td width="25%" class="span2">(Disabled)</td>
															<td width="25%" class="span2">(Border)</td>
															<td width="25%" class="span2">(Text)</td>


														</tr>


													</table>



												</div>

											</div>

											<!-- /controls -->

										</div>
										<div class="control-group">
											<label class="control-label" for="radiobtns">Welcome Text</label>

											<div class="controls">
												<div class="">

													<textarea width="500px" id="welcome" name="welcome" class="jqte-test"><?php echo $welcome_txt; ?></textarea>


												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->













										<div class="control-group">
											<label class="control-label" for="radiobtns">Welcome back text</label>

											<div class="controls">
												<div class="">

													<textarea width="500px" id="welcome_back" name="welcome_back" class="jqte-test"><?php echo $welcome_back_txt; ?></textarea>

												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->

										<div class="control-group">

											<label class="control-label" for="radiobtns">Default button text</label>



											<div class="controls">


												<div class="">

													<textarea width="500px" id="connectwifi" name="connectwifi" class="jqte-test"><?php echo $connect_btn; ?></textarea>

												</div>

											</div>

											<!-- /controls -->

										</div>

										<div class="control-group">
											<label class="control-label" for="radiobtns">Registration Button
											</label>

											<div class="controls">
												<div class="">

													<textarea width="500px" id="sign_up" name="sign_up" class="jqte-test"><?php echo $registration_btn; ?></textarea>


												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->
									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">CNA Page Text</label>

										<div class="controls">
											<div class="">

											<textarea width="500px" id="cna_page" name="cna_page" class="jqte-test"><?php echo $cna_page_field; ?></textarea>

											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->

									<!-- <div class="control-group">
										<label class="control-label" for="radiobtns">CNA Button Text</label>

										<div class="controls">
											<div class="">

											<textarea width="500px" id="cna_button" name="cna_button" class="jqte-test"><?php echo $cna_button_field; ?></textarea>

											</div>
										</div> -->
										<!-- /controls -->
										<!-- </div> -->
										<!-- /control-group -->
										<div class="control-group">
											<label class="control-label" for="radiobtns">Terms and Conditions text</label>

											<div class="controls">
												<div class="">

													<textarea width="500px" id="toc" name="toc" class="jqte-test"><?php echo $toc_txt; ?></textarea>


												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->

										<div class="control-group">
											<label class="control-label" for="radiobtns">Accept Check Box Text</label>

											<div class="controls">
												<div class="">

													<textarea width="500px" id="acpt_text" name="acpt_text" class="jqte-test"><?php echo $acpt_text_field; ?></textarea>

												</div>
											</div>
											<!-- /controls -->
										</div>
										<!-- /control-group -->















										<div class="form-actions">
											<button type="submit" name="update_default_theme" id="update_default_theme"
											class="btn btn-primary">Update</button>

										</div>
										<!-- /form-actions -->
									</fieldset>
								</form>
							</div>


						<?php } ?>

						<?php if(in_array("DEFAULT_THEME",$features_array) || $package_features=="all"){
                                        	//$tab20=1;
							?>


							<div <?php if(isset($tab20)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="view_generic_theme">


								<h3>Default Captive Portal Theme</h3>

								<p>This will be the default captive portal theme a guest will see when they try to connect to an SSID at a property that has activated the service, but the Property Admin has yet to create a custom captive portal theme.</p>

								<br>


								<?php 
								$package_mvno=$package_functions->getOptions("MVNO_PRODUCTS", $system_package);
								$pieces_mvno = explode(",", $package_mvno);
								$len1 = count($pieces_mvno);

								if($len1 > 1){

									?>

									<script type="text/javascript">
										$(document).ready(function () {

											default_img('');

										});

									</script>
									<div class="control-group">
										<!-- <label class="control-label" for="customer_type">Default Captive Portal Theme</label> -->
										<div class="controls col-lg-5 form-group">
											<select name="customer_type" id="customer_type" class="span4 form-control" onchange="default_img(this.value);">
												<option value="">Select Default Captive Portal Theme</option>

												<?php


												for($i=0;$i<$len1;$i++){

													$get_option2="SELECT `product_code`, `discription2` FROM admin_product WHERE `product_code`='$pieces_mvno[$i]' ";
													$get_option2_ex=mysql_query($get_option2);

													while($get_option2_row=mysql_fetch_assoc($get_option2_ex)){

														$mvno_val=$get_option2_row[product_code];
														$default_theme_image=getSectionType("GENERIC_TEMPLATE_NAME",$system_package,$user_type);
														$default_theme_image_name=getSectionType("GENERIC_TEMPLATE_IMAGE_NAME",$mvno_val,"MVNO");

														if(strlen($default_theme_image_name) < 1){
															$default_theme_image_name= 'template_image.jpg';
														}

														$img_path = $db_class1->setVal(portal_base_folder, 'ADMIN');

														if(!empty($get_option2_row[discription2])){

														echo '<option  value='.$img_path.'/template/'.$default_theme_image.'/img/'.$default_theme_image_name.'>'.$get_option2_row[discription2].'</option>';
														}
													}

												}
												?>

											</select>

										</div>

									</div>

								<?php } ?>
								<div id="default_theme">												

									<?php
									$default_theme_image=getSectionType("GENERIC_TEMPLATE_NAME",$system_package,$user_type);
									$default_theme_image_name=getSectionType("GENERIC_TEMPLATE_IMAGE_NAME",$system_package,$user_type);

									if(strlen($default_theme_image_name) < 1){
										$default_theme_image_name= 'template_image.jpg';
									}

									$img_path = $db_class1->setVal(portal_base_folder, 'ADMIN');

									echo '<center><img style="max-width: 100%" src="'.$img_path.'/template/'.$default_theme_image.'/img/'.$default_theme_image_name.'" ></center>';

									?>
								</div>
							</div>
							<!--  default tab ///////////////// -->


							<?php
						}?>

						<?php if(in_array("TENANT_THEME",$features_array) || $package_features=="all"){
                                        	//$tab20=1;
							?>


<div <?php if(isset($tab21)){?>class="tab-pane active" <?php }else {?> class="tab-pane fade" <?php }?> id="theme_create">


								<?php
								if(isset($_SESSION['msg3'])){
									echo $_SESSION['msg3'];
									unset($_SESSION['msg3']);
								}
								?>



								<form id="theme_form" method="post" action="?t=21" class="form-horizontal">
									<fieldset>

										<?php

										echo '<input type="hidden" name="theme_secret" id="theme_secret" value="'.$_SESSION['FORM_SECRET_THEME'].'" />';
										?>								 
										<div class="control-group">
											<label class="control-label" for="radiobtns">Theme Name<sup><font color="#FF0000" >*</font></sup></label>
											<div class="controls form-group">

												<input class="span4 form-control" id="theme_name" name="theme_name" type="text" value="<?php echo $edit_theme_name; ?>" required>

											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="radiobtns">Portal Title<sup><font color="#FF0000" >*</font></sup></label>
											<div class="controls form-group">

												<input class="span4 form-control" id="theme_title" name="theme_title" type="text" value="<?php echo $edit_theme_title; ?>" required>

											</div>
										</div>



										<div class="control-group">
											<label class="control-label" for="radiobtns">Template<sup><font color="#FF0000" >*</font></sup></label>
											<div class="controls form-group">

												<select class="span4 form-control" id="template_code" name="template_code" onchange="Template(this.value)">


													<?php 
                                                                             // echo $camp_layout ." --------------------------<br>";
                                                                            //  echo     $operator_type = $package_functions->getOptions('PRODUCT_LIST',$my_product);
													 $my_product = $package_functions->getPackage($user_name);
													        $theme_type = $package_functions->getSectionType('STYLE_LAYOUT',$my_product);
													$temp_q = "SELECT * FROM mdu_template WHERE type='$theme_type' and is_enable = 1";

													$temp_q_result = mysql_query($temp_q);

													while ($temp_row = mysql_fetch_array($temp_q_result)) {

														if($temp_row['template_code'] == $edit_template_code){
															$selected = 'selected';
														}
														else{
															$selected = '';
														}

														echo '<option value="'.$temp_row['template_code'].'" '.$selected.'>'.$temp_row['template_name'].'</option>';

													} 
													?>
												</select>

												&nbsp;&nbsp;<img id="loading_img" src="img/loading_ajax.gif" style="display:none;">

											</div>

										</div>  

										<div class="control-group">
											<div class="controls form-group">
												<img id="img_load" style="max-width: 200px;">
												<div class="movertxt" style="margin: auto;">Move over to zoom in <i class="icon-zoom-in" style="display: inline !important"></i></div>
											</div>
										</div>




										<div class="control-group">

											<label class="control-label" for="radiobtns">Property<sup><font color="#FF0000" >*</font></sup></label>



											<div class="controls form-group">



												<select class="span4 form-control" name="property_id_cre" class="span4" id="property_id_cre">

													<option value="">Select Property</option>

													<?php
													



																	 /* $key_query1 = "SELECT o.`property_id` FROM `system_mno_organizations` m,system_organizations o  
																	 WHERE mno='$mdu_mno_id' AND m.`property_id` = o.`property_id` AND o.`property_type` = 'VTENANT' GROUP BY o.`property_id`"; */
																	 $key_query1 = "SELECT o.`property_id` ,o.`property_number` FROM `mdu_organizations` o LEFT JOIN `mdu_mno_organizations` m ON m.`property_id` = o.`property_number` WHERE m.`mno` = '$mdu_mno_id' AND o.`property_type` = 'VTENANT'";


//echo $edit_pro_id;

																	 $query_results1=mysql_query($key_query1);

																	 while($row=mysql_fetch_array($query_results1)){

																	 	$pro_id = $row[property_id];
																	 	if($pro_id == $edit_pro_id){
																	 		$selected = 'selected';
																	 	}
																	 	else{
																	 		$selected = '';
																	 	}

																	 	echo '<option value="'.$pro_id.'" '.$selected.'>'.$pro_id.'</option>';

																	 }

																	 ?>

																	</select>



																</div>

																<!-- /controls -->

															</div>	

															<div class="t_hidden">


																<div class="control-group">
																	<label class="control-label" for="radiobtns">Welcome Text<sup><font color="#FF0000" >*</font></sup></label>
																	<div class="controls form-group">

																		<textarea class="span4 form-control" id="theme_welcome_text" name="theme_welcome_text" type="text" ><?php echo $edit_welcome_txt; ?></textarea>

																	</div>
																</div>

																<div class="control-group">
																	<label class="control-label" for="radiobtns">Welcome Description</label>
																	<div class="controls form-group">

																		<textarea class="span4 form-control" id="theme_welcome_des" name="theme_welcome_des" type="text" ><?php echo $edit_welcome_des; ?></textarea>

																	</div>
																</div>	

															</div>  

															<div class="control-group">
																<label id="contactText" class="control-label" for="radiobtns">Contact Us</label>
																<div class="controls form-group">

																	<textarea class="span4 form-control jqte-test" id="theme_contactus" name="theme_contactus" type="text" ><?php echo $edit_contact_us; ?></textarea>

																</div>
															</div>  




															<div class="control-group t_hidden" id="theme_color_div">
																<label class="control-label" for="radiobtns">Theme Color </label>
																<div class="controls form-group" id="header_color_div">

																	<input class="span4 form-control" id="theme_color" name="theme_color" type="hidden" value="">
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>	

															<div class="control-group t_hidden">
																<label class="control-label" for="radiobtns">Button Color ( Primary) </label>
																<div class="controls form-group" id="btn_color_div">

																	<input class="span4 form-control" id="btn_color" name="btn_color" type="hidden" value="">
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>	

															<div class="control-group t_hidden">
																<label class="control-label" for="radiobtns">Button Color (Secondary) </label>
																<div class="controls form-group" id="btn_secondary_color_div">

																	<input class="span4 form-control" id="btn_secondary_color" name="btn_secondary_color" type="hidden" value="">
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>	

															<div class="control-group t_hidden">
																<label class="control-label" for="radiobtns">Background Color </label>
																<div class="controls form-group" id="bg_color_div">

																	<input class="span4 form-control" id="bg_color" name="bg_color" type="hidden" value="">
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>


															<div class="control-group t_hidden">
																<label class="control-label" for="radiobtns">Footer Background Color </label>
																<div class="controls form-group" id="f_bg_color_div">

																	<input class="span4 form-control" id="f_bg_color" name="f_bg_color" type="hidden" value="">
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>								 

															<div class="control-group t_hidden">
																<label class="control-label" for="radiobtns">Selfcare Portal Login Screen Logo</label>

																<div class="controls form-group">
																	<div class="" style="vertical-align:top;">
																		<label class="filebutton">
																			Browse Image
																			<span><input class="span4 form-control" id="image4" name="image4" type="file" style="width:90px;" onchange="return ajaxFileUpload(4,'VTENANT');"></span>
																		</label>&nbsp;&nbsp;<img id="loading_4" src="img/loading_ajax.gif" style="display:none;">
																	</div>
																	<div class="" id="img_div4">

																		<?php
																		if(strlen($edit_theme_img4) > 0){
																			?>


																			&nbsp;&nbsp;<img  src="<?php echo $original_logo_Img_path.$edit_theme_img4; ?>" style='width:90px; display:inline;'>
																			<input type="hidden" name="image_4_name" id="image_4_name" value="<?php echo $edit_theme_img4; ?>" />

																			<?php
																		}
																		?>


																	</div>

																</div>
															</div>



															<div class="control-group">
																<label id="portalBackTxt" class="control-label" for="radiobtns">Selfcare Portal Login Screen Image</label>

																<div class="controls form-group">
																	<div class="" style="vertical-align:top;">
																		<label class="filebutton">
																			Browse Image
																			<span><input class="span4 form-control" id="image7" name="image7" type="file" style="width:90px;" onchange="return ajaxFileUpload(7,'VTENANT');"></span>
																		</label>&nbsp;&nbsp;<img id="loading_7" src="img/loading_ajax.gif" style="display:none;">
																	</div>
																	<div class="" id="img_div7">

																	

																		<?php
																		if(strlen($edit_theme_img7) > 0){
																			?>


																			&nbsp;&nbsp;<img  src="<?php echo $original_logo_Img_path.$edit_theme_img7; ?>" style='width:90px; display:inline;'>
																			<input type="hidden" name="image_7_name" id="image_7_name" value="<?php echo $edit_theme_img7; ?>" />

																			<?php
																		}
																		?>


																	</div>

																</div>
															</div>



															<div class="control-group">
																<label id="portalLogoTxt" class="control-label" for="radiobtns">Selfcare Portal Top Logo</label>

																<div class="controls form-group">
																	<div class="" style="vertical-align:top;">
																		<label class="filebutton">
																			Browse Image
																			<span><input class="span4 form-control" id="image5" name="image5" type="file" style="width:90px;" onchange="return ajaxFileUpload(5,'VTENANT');"></span>
																		</label>&nbsp;&nbsp;<img id="loading_5" src="img/loading_ajax.gif" style="display:none;">
																	</div>
																	<div class="" id="img_div5">

																	

																		<?php
																		if(strlen($edit_theme_img5) > 0) {
																			?>

																			&nbsp;&nbsp;<img
																			src="<?php echo $original_logo_Img_path.$edit_theme_img5; ?>"
																			style='width:90px; display:inline;'>
																			<input type="hidden" name="image_5_name"
																			id="image_5_name"
																			value="<?php echo $edit_theme_img5; ?>"/>

																			<?php
																		}
																		?>
																	</div>
																</div>
															</div>


															<div class="control-group" id="favDiv">
																<label class="control-label" for="radiobtns">Selfcare Favicon Icon</label>

																<div class="controls form-group">
																	<div class="" style="vertical-align:top;">
																		<label class="filebutton">
																			Browse Image
																			<span><input class="span4 form-control" id="image6" name="image6" type="file" style="width:90px;" onchange="return ajaxFileUpload_Favicon(6);"></span>
																		</label>&nbsp;&nbsp;<img id="loading_6" src="img/loading_ajax.gif" style="display:none;">
																	</div>
																	<div class="" id="img_div6">

																		<?php
																		if(strlen($edit_theme_img6) > 0) {
																			?>
																			&nbsp;&nbsp;<img
																			src="<?php echo $original_logo_Img_path.$edit_theme_img6; ?>"
																			style='width:64px; display:inline;'>
																			<input type="hidden" name="image_6_name"
																			id="image_6_name"
																			value="<?php echo $edit_theme_img6; ?>"/>

																			<?php
																		}
																		?>
																	</div>
																</div>
															</div>                                                                
															<?php if(strlen($theme_edit)>0){?>

																<input name="edit_id" type="hidden" value="<?php echo $edit_theme_id; ?>">

																<div class="form-actions">
																	<input type="submit"  name="edit_theme" id="edit_theme" class="btn btn-primary" value="Save">
																	<a href="?t=21" class="btn btn-info inline-btn">Back</a>
																</div>									


															<?php }else{?>

																<div class="form-actions">
																	<input type="submit"  name="submit_theme" id="submit_theme" class="btn btn-primary" value="Save" disabled>

																</div>								


															<?php }?>								

														</fieldset>
													</form>

													<div class="widget widget-table action-table">
														<div class="widget-header">
															<i class="icon-th-list"></i>

															<h3>Themes</h3>
														</div>
														<!-- /widget-header -->
														<div class="widget-content table_response">
															<div style="overflow-x:auto">
																<table class="table table-striped table-bordered tablesaw themes_table" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
																	<thead>
																		<tr>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Theme Name</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Property ID</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Template</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Status</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Edit</th>
																			<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Delete</th>

																		</tr>
																	</thead>
																	<tbody>

																		<?php 

																		$gettheme="SELECT t.*, tem.`template_name` FROM `mdu_themes` t, `mdu_template` tem
																		WHERE t.`template_code` = tem.`template_code` AND t.`distributor_code`='$mdu_mno_id' ORDER BY t.property_id ";

																		$get_theme_exe=mysql_query($gettheme);
																		while($row=mysql_fetch_array($get_theme_exe)){

																			$id=$row['id'];

																			$title=$row['title'];
																			$theme_name=$row['theme_name'];
																			$property_id=$row['property_id'];

																			$status=$row['is_enable'];
																			$template_code=$row['template_name'];

																			echo '<tr>';

																			echo '<td>'.$theme_name.'</td>';
																			echo '<td>'.$property_id.'</td>';
																			echo '<td>'.$template_code.'</td>';

																			if($status==1){
																				$chek='checked';
																				$en_dis='Disable';
																				$en_dissimp='disable';

																			}else{

																				$chek='';
																				$en_dis='Enable';
																				$en_dissimp='enable';

																			}

																			echo '<td><a class="s_toggle" href="javascript:void();" id="ST_'.$id.'">
																					<input '.$chek.' href="javascript:void();" id="ST_'.$id.'" type="checkbox"  data-toggle="toggle" data-onstyle="success" data-offstyle="warning">
																						</a>';

																			echo '

																			<script type="text/javascript">

																			$(document).ready(function() {

																				$(\'#ST_'.$id.'\').easyconfirm({locale: {

																					title: \''.$en_dis.' Theme\',

																					text: \'Are you sure you want to '.$en_dissimp.' this theme?&nbsp;&nbsp;&nbsp;&nbsp;\',

																					button: [\'Cancel\',\' Confirm\'],

																					closeText: \'close\'

																					}});

																					$(\'#ST_'.$id.'\').click(function() {



																						window.location = "?modify_status=1&is_enable='.$status.'&id='.$id.'&theme_name='.addslashes($title).'&property_id='.$property_id.'&t=21"

																						});

																						});

																						</script>';
																						echo '</td>';

																						echo '<td class="td_btn">';



																						echo '<a id="CVTM_'.$id.'"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Edit</a><script type="text/javascript">
																						$(document).ready(function() {
																							$(\'#CVTM_'.$id.'\').easyconfirm({locale: {
																								title: \'Edit Theme\',
																								text: \'Are you sure, you want to edit this Theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																								button: [\'Cancel\',\' Confirm\'],
																								closeText: \'close\'
																								}});
																								$(\'#CVTM_'.$id.'\').click(function() {
																									window.location = "?modify_theme=1&t=21&mtheme_id='.$id.'"
																									});
																									});
																									</script></td>';



																									echo '</td>';


																									echo '<td class="td_btn">';
																									if($status==1){

																									}else{


																										echo '<a id="CVTD_' . $id . '"  class="btn btn-small btn-danger td_btn_last" ><i class="icon icon-remove-circle"></i>&nbsp;Remove</a><script type="text/javascript">
																										$(document).ready(function() {
																											$(\'#CVTD_' . $id . '\').easyconfirm({locale: {
																												title: \'Delete Theme\',
																												text: \'Are you sure you want to delete this Theme?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
																												button: [\'Cancel\',\' Confirm\'],
																												closeText: \'close\'
																												}});
																												$(\'#CVTD_' . $id . '\').click(function() {
																													window.location = "?t=21&action=delete_theme&delete_theme_id=' . $id . '"
																													});
																													});
																													</script>';
																												}

																												echo '</td>';



																												echo '</tr>';

																											}
																											?>                                                   

																										</tbody>
																									</table>
																								</div>
																							</div>
																						</div> 

																					</div>

																					<?php
																				}?>

	<?php if(in_array("TENANT_THEME_PREVIEW",$features_array) || $package_features=="all"){ ?>

	<div <?php if(isset($tab23)){?>class="tab-pane active" <?php }else {?> class="tab-pane fade" <?php }?> id="theme_preview">
		
		<form id="tag_form" class="form-horizontal">

			<fieldset>

				<div class="control-group">

					<label class="control-label" for="radiobtns">Theme</label>



					<div class="controls form-group">



						<select name="theme_id" class="span3 form-control" id="theme_id">

							<option value="">Select Theme</option>

							<?php

							echo $mdu_mno_id;

							$key_query = "SELECT * FROM `mdu_themes` WHERE `distributor_code`='$mdu_mno_id'";



							$query_results=mysql_query($key_query);

							while($row=mysql_fetch_array($query_results)){

								$theme_id = $row[id];

								$theme_name = $row[theme_name];
								$theme_code = $row[theme_code];



								echo '<option value="'.$theme_code.'">'.$theme_name.'</option>';

							}

							?>

						</select>



					</div>

					<!-- /controls -->

				</div>										


				<div class="control-group">

					<label class="control-label" for="radiobtns">Property</label>



					<div class="controls form-group">



						<select name="property_id" class="span3 form-control" id="property_id">

							<option value="">Select Property</option>

							<?php

										//$key_query1 = "SELECT `property_id` FROM `system_mno_organizations` WHERE mno='$mdu_mno_id' GROUP BY `property_id`";

							$key_query1 = "SELECT o.`property_id` ,o.`property_number` FROM `mdu_organizations` o LEFT JOIN `mdu_mno_organizations` m ON m.`property_id` = o.`property_number` WHERE m.`mno` = '$mdu_mno_id' AND o.`property_type` = 'VTENANT'";


							$query_results1=mysql_query($key_query1);

							while($row=mysql_fetch_array($query_results1)){

								$pro_id = $row[property_id];


								echo '<option value="'.$pro_id.'">'.$pro_id.'</option>';

							}

							?>

						</select>



					</div>

					<!-- /controls -->

				</div>		


				<div class="form-actions" >

					<button type="button" name="submit" id="gen_url" onclick="url_creation();"

					class="btn btn-danger inline-btn" data-toggle="tooltip" >
				Generate URL</button>


				<button type="button" name="submit" id="gen_url" onclick="previewurl();"

				class="btn btn-danger inline-btn" data-toggle="tooltip" >
			Preview</button>
		</div>

	</fieldset>

</form>

<script type="text/javascript">

	function url_creation(){

		var mac = "DEMO_MAC";

		var e = document.getElementById("theme_id");
		var theme_code = e.options[e.selectedIndex].value;

		var f = document.getElementById("property_id");
		var property_id = f.options[f.selectedIndex].value;									



		loc="<?php echo $global_url.'/'.$portal_base_folder; ?>/index.php?mac=DEMO_MAC&property="+property_id+"&th="+theme_code;
										//index.php?mac=DEMO_MAC&property=Suddenlink_MDUA&th=aea614be-8c94-11e7-9363-1a1d7d1e3fc9

										$('#tag_form').formValidation().formValidation('validate');

										var isValidForm = $('#tag_form').data('formValidation').isValid();  

										if(isValidForm){

											document.getElementById('preview_url').innerHTML = '<textarea id="preview_url_val" rows="3" style="margin: 0px 0px 9px; width: 95%; height: 79px;">'+loc+'</textarea><br><br>';

										}
										else{
											return false;
										}  



									}



								</script>

								<div id="preview_url"></div>
								 

	</div>
	<?php }?>

																				<?php
																				if(in_array("CAMP_DEFAULT",$features_array) || $package_features=="all"){?>


																					<div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="def_camp">

																						<form id="def_form" name="def_form" method="post" class="form-horizontal"  action="?t=5">
																							<?php
																							echo '<input type="hidden" name="form_secret5" id="form_secret5" value="'.$_SESSION['FORM_SECRET'].'" />';

																							?>


																							<div id="response_d8">

																							</div>
																							<fieldset>
																								<p>
																								The default campaign will run if you do not create a new Campaign. Please set the redirect URL and the minimum time the guest will wait before being redirected. The URL can be your company site or your Facebook site.</p>
																								<br>

																								<?php


																								if($user_type == 'MNO'){

												//echo $pieces_mvno[0];
																									$default_ad_id_new=$package_functions->getOptions("DEFAULT_AD_ID", $pieces_mvno[0]); 

																									$default_ad_preview_img=$package_functions->getOptions("DEFAULT_AD_PREVIEW_IMG", $pieces_mvno[0]);

												//$query_get_default_ad = $q_generic=mysql_query("SELECT default_campaign_id FROM exp_mno WHERE mno_id = '$user_distributor'");

																								}
																								else{
																									$query_get_default_ad = $q_generic=mysql_query("SELECT default_campaign_id FROM exp_mno_distributor WHERE distributor_code = '$user_distributor'");
																									$rowt=mysql_fetch_array($query_get_default_ad);
																									$default_ad_id_new=$rowt['default_campaign_id'];
																								}


																								if((strlen($default_ad_preview_img) < 1) || !file_exists('img/'.$default_ad_preview_img) ){
																									$default_ad_preview_img = 'captive.png';
																								}

																							/* 	echo "SELECT a.`top_text`,a.`bottom_text`,a.`image1`,a.`image5`,a.`ad_id`,a.`duration_seconds`,a.`welcome_url`
																								FROM `exp_camphaign_ads` a
																								WHERE a.`ad_id`= '$default_ad_id_new'"; */

																								$q_generic=mysql_query("SELECT a.`top_text`,a.`bottom_text`,a.`image1`,a.`image5`,a.`ad_id`,a.`duration_seconds`,a.`welcome_url`
																									FROM `exp_camphaign_ads` a
																									WHERE a.`ad_id`= '$default_ad_id_new'");
																										
																								if(mysql_num_rows($q_generic) > 0){
																									$rowt=mysql_fetch_array($q_generic);

																									$ad_id_new=$rowt['ad_id'];
																									$generic_top1=$rowt['top_text'];
																									$generic_bottom1=$rowt['bottom_text'];
																									$image_def=$rowt['image1'];
																									$image_logo=$rowt['image5'];
																									$generic_waiting=$rowt['duration_seconds'];
																									$generic_welcome=$rowt['welcome_url'];
																									$printpath1=$base_portal_folder.'/ads/';
																									$update_set=1;

																								}
																								else{
																									$update_set=0;

																								}


																								?>
																								<br>


																								<div class="control-group">

																									<div class="controls col-lg-5 form-group">
																									<center><img style="max-height:250px;margin-top:-22px;max-width: 100%" src="img/<?php echo $default_ad_preview_img; ?>" alt=""></center>
																								</div>
																								</div>



																								<div class="control-group">

																									<div class="controls col-lg-5 form-group">
																									<label class="" for="group_tag">Top Text</label>

																										<input type="text" name="generic_top" class="span4 form-controls" value="<?php echo $generic_top1; ?>">



																									</div>
																									<!-- /controls -->
																								</div>
																								<!-- /control-group -->



																								<div class="control-group">

																									<div class="controls col-lg-5 form-group">
																									<label class="" for="group_tag">Button text</label>



																										<input type="text" id="generic_bottom" name="generic_bottom" class="span4 form-controls" value="<?php echo $generic_bottom1; ?>">


																										<input type="hidden" name="ad_id_new" id="ad_id_new" value="<?php echo $ad_id_new; ?>" />
																										<input type="hidden" name="update_set" id="update_set" value="<?php echo $update_set; ?>" />


																									</div>
																									<!-- /controls -->
																								</div>
																								<!-- /control-group -->
																								<?php if(!empty($image_logo)){ ?>
																								<br>
																								<div class="control-group">

																									<div class="controls">
																									<label class="" for="radiobtns">Logo :</label>
																										<div class="input-prepend input-append" style="vertical-align:top;">
																											<label class="btn btn-primary">
																												Browse Image
																												<span><input class="span4" id="image12" name="image12" type="file" style="width:90px;" onchange="return ajaxFileUpload(12,'');"></span>
																											</label>&nbsp;&nbsp;<img id="loading_12" src="img/loading_ajax.gif" style="display:none;">
																										</div>


																										<div class="input-prepend input-append"  id="img_div12"><?php if($update_set==1){ ?>&nbsp;&nbsp;<img src="<?php echo $original_Ads_Image_Folder.$image_logo; ?>" style='width:125px; display:inline;'><input type="hidden" name="image_12_name" id="image_12_name" value="<?php echo $image_logo; ?>" /><?php } ?>
																									</div>

																									<lable id="up_logo_desc1">(GIF, JPEG or PNG)</lable>


																								</div>

																							</div>
																								<?php } ?>
																							<div class="control-group">

																								<div class="controls">
																								<label class="" for="radiobtns">Image :</label>
																									<div class="input-prepend input-append" style="vertical-align:top;">
																										<label class="btn btn-primary">
																											Browse Image
																											<span><input class="span4" id="image11" name="image11" type="file" style="width:90px;" onchange="return ajaxFileUpload(11,'');"></span>
																										</label>&nbsp;&nbsp;<img id="loading_11" src="img/loading_ajax.gif" style="display:none;">
																									</div>


																									<div class="input-prepend input-append"  id="img_div11"><?php if($update_set==1){ ?>&nbsp;&nbsp;<img src="<?php echo $original_Ads_Image_Folder.$image_def; ?>" style='width:125px; display:inline;'><input type="hidden" name="image_11_name" id="image_11_name" value="<?php echo $image_def; ?>" /><?php } ?>
																								</div>

																								<lable id="up_logo_desc1">(GIF, JPEG or PNG, Recommended 320px*530px)</lable>


																							</div>

																						</div>
																						<div class="control-group">

																							<div class="controls col-lg-5 form-group">
																							<label class="" for="group_tag">Waiting Seconds </label>
																								<input class="span4" id="default_ad_waiting" name="default_ad_waiting" min="0" type="number" value="<?php echo $generic_waiting; ?>" required>


																							</div>
																							<!-- /controls -->
																						</div>
																						<!-- /control-group -->


																						<div class="control-group">

																							<div class="controls col-lg-5 form-group">
																							<label class="" for="tag_description">Redirect URL </label>
																								<input class="span4" id="default_ad_welcome" name="default_ad_welcome" type="url" value="<?php echo $generic_welcome; ?>" required>

																							</div>
																							<!-- /controls -->
																						</div>
																						<!-- /control-group -->

																						<input type="hidden" name="group_tag_desc" id="group_tag_desc" value="<?php echo $user_distributor; ?>" />


																						<div class="form-actions" >
																							<button type="submit" name="camp_ap_submit" id="camp_ap_submit"
																							class="btn btn-primary">Update</button>

																						</div>
																						<!-- /form-actions -->
																					</fieldset>
																				</form>

																			</div>
																			<!-- ///////////////////////////////// register tab /////////////// -->
																			<?php if(in_array("TERMS_REGISTER",$features_array)){?>
																				<div class="tab-pane <?php if(isset($tab22)){ ?>active <?php } ?>" id="registration">

                                                                                    <?php
                                                                                    $theme_reg_conf_type = json_decode($package_functions->getOptions('THEME_REG_TYPE_CONFIG',$system_package),true);
                                                                                    //print_r($theme_reg_conf_type);
                                                                                    $theme_reg_conf_count = count($theme_reg_conf_type);
                                                                                    //echo $system_package;
                                                                                    ?>
                                                                                    <?php if(array_key_exists('facebook',$theme_reg_conf_type) || $theme_reg_conf_count==0){ ?>
																					<form id="fb_form" method="post" action="?t=22" name ="fb_form" class="form-horizontal">

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
																							<label class="control-label" for="radiobtns">Facebook App Version</label>
																							<div class="controls">
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
																								<label class="control-label" for="radiobtns">Facebook Additional Fields</label>

																								<?php


																								$q11 = "SELECT `fields` FROM `exp_social_profile` WHERE `social_media` = 'FACEBOOK' AND `distributor` = '$user_distributor'";
																								$r11 = mysql_query($q11);
																								while ($row1 = mysql_fetch_array($r11)) {
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
                                                                                    <?php } ?>

                                                                                    <?php if(array_key_exists('manual',$theme_reg_conf_type) || $theme_reg_conf_count==0){ ?>
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
                                                                                    <?php } ?>

                                                                                    <?php if(array_key_exists('twitter',$theme_reg_conf_type) || $theme_reg_conf_count==0){ ?>


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
                                                                                    <?php } ?>


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
													

												</div>
												<div class="control-group">
													<div class="controls form-group">
														<font size="1">Ex: http://10.1.1.1/campaign_portal</font>
													</div>
												</div>



												
												
												
												
												
												<div class="control-group"  <?php
												if(!array_key_exists('global_url',$tab1_field_ar) && $system_package!='N/A'){echo' style="display:none";';}
												?>  style="margin-bottom: 0px !important;" >

												<label class="control-label" for="radiobtns">Campaign Portal Global URL</label>

												<div class="controls form-group">



													<input class="span4 form-control" id="global_url" name="global_url" type="text" value="<?php echo $db->setVal("global_url",$user_distributor); ?>">




												</div>


											</div>
											<div class="control-group">
												<div class="controls form-group">
													<font size="1">Ex: http://yourcompany.com/campaign_portal</font>
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
		$flatforms_q=mysql_query("SELECT product_code,discription FROM admin_product WHERE user_type='ADMIN'");
		while($flatforms=mysql_fetch_assoc($flatforms_q)){
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

                                                <div <?php if(isset($tab0) && $user_type == 'MNO'){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="live_camp3">



                                                	<h3>Admin Portal Image </h3>


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

																		function formatOffset($offset) {

																			$hours = $offset / 3600;

																			$remainder = $offset % 3600;

																			$sign = $hours > 0 ? '+' : '-';

																			$hour = (int) abs($hours);

																			$minutes = (int) abs($remainder / 60);

																			if ($hour == 0 AND $minutes == 0) {

																				$sign = ' ';

																			}

																			return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');



																		}



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
								<script>



					//document.getElementById("default_theme").innerHTML = '';


					function default_img(default_img) {

		//		alert(default_img== '');

		document.getElementById("default_theme").innerHTML = '<center><img src="'+default_img+'" style="max-width: 100%"></center>';


	}

</script>
<?php } ?>

<?php 

$theme_load_method=$package_functions->getOptions("VTENANT_THEME_METHOD", $system_package);

 ?>

                                    
	<script type="text/javascript">

	$(document).ready(function () {
	img_load1($('#template_code').val());
	});

	function img_load1(template){

		var loadMethod = "<?php echo $theme_load_method; ?>";

	var src_n = "img/"+ template +"_img.png";

	if(template == 'SUDDENLINK_OLD'){
	$('#theme_color_div').hide();
	}else{
	$('#theme_color_div').show();
	}

	$('#loading_img').show();
	$('#img_load').on('load', function() {  $('#loading_img').hide();; }).attr({"src": src_n, "data-zoom-image":src_n});

	$('#img_load').elevateZoom({
		zoomType : "lens",
  		lensSize:  "400"
	}); 

	if(loadMethod == 'SIMPLE'){

	$('.t_hidden').hide();
	$('#favDiv').hide();
	$('#theme_welcome_text').val('Support & Documentation');
	$('#theme_welcome_des').val('Welcome');
	$('#portalBackTxt').html('Background Image');
	$('#portalLogoTxt').html('Logo Image');
	$('#contactText').html('Contact Text');


	}
	else{
	$('.t_hidden').show();
	$('#favDiv').show();
	$('#theme_welcome_text').val('');
	$('#theme_welcome_des').val('');
	$('#portalBackTxt').html('Selfcare Portal Login Screen Image');
	$('#portalLogoTxt').html('Selfcare Portal Top Logo');
	$('#contactText').html('Contact Us');
	}
	}

	function previewurl(){

	url_creation();

	$('#tag_form').formValidation().formValidation('validate');

	var isValidForm = $('#tag_form').data('formValidation').isValid();  

	if(isValidForm){

	var url = document.getElementById("preview_url_val").value;
	//var url = e.options[e.selectedIndex].value;
	//alert(url);
	window.open(url,'_blank');

	}

	}

	</script>


<?php if(in_array("OPERATOR_THEME",$features_array) || $package_features=="all"){  

	if((isset($tab20)) || ((in_array("GENERIC_THEME",$features_array) || $package_features=="all") && ($lan == 'en'))){

	}else{ 
		$tab19=1; 
	}

	?>


	<div <?php if(isset($tab19)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="upload_images">


		<?php
		if($user_type == 'MNO'){

			?>






			<form id="edit-profile" class="form-horizontal" method="POST">

				<fieldset>
					<div class="control-group" id="vis_div"></div>
					<h3>Operator Theme </h3>

					<div class="control-group">
						<label class="control-label" for="radiobtns">Visibility</label>
						<div class="controls">
							<div class="">

								<?php
                                                    //$mno = $parent;
								$r = $db->setVal('mno_theme', $user_distributor);
								if ($r != 'no') {
									echo '<input id="mno_the_visible" type="checkbox" data-size="mini" checked data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
								} else {
									echo '<input id="mno_the_visible" type="checkbox" data-size="mini" data-toggle="toggle" data-onstyle="success" data-offstyle="warning">';
								}
								echo '<img id="vi_loader" src="img/loading_ajax.gif" style="visibility: hidden;">';
								echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
								echo '<input type="hidden" name="user_name" id="user_name" value="'.$user_name.'" />';
								echo '<input type="hidden" name="dist" id="dist" value="'.$distributor.'" />';

								?>
							</div>
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->



					<h3>Top Line </h3>

					<?php

					$query_mno = "SELECT m.top_line_color,m.top_line_size,m.favicon_image,m.top_bg_pattern_image
					from exp_mno m where mno_id = '$user_distributor'";
					$query_results=mysql_query($query_mno);
					while($row=mysql_fetch_array($query_results)){
						$top_line_color = $row[top_line_color];
						$top_line_size = $row[top_line_size];
						$favicon_image = $row[favicon_image];
						$top_bg_pattern_image = $row[top_bg_pattern_image];
					}
					?>




					<div class="control-group">
						<label class="control-label" for="radiobtns">Top Line width</label>

						<div class="controls">
							<div class="">

								<input class="span6" id="line_width" name="line_width" type="number" min="0" max="99" value="<?php echo $top_line_size; ?>" required>

							</div>
						</div>
						<!-- /controls -->
					</div>
					<!-- /control-group -->




					<div class="control-group">
						<label class="control-label" for="radiobtns">Top Line Color</label>

						<div class="controls">
							<div class="">
								<div id="button_color_div" class="input-group colorpicker-component">
									<input id="line_color" name="line_color" type="text" value="primary" >
											<!-- <input class="span6" id="line_color" name="line_color" type="color" value="<?php echo $top_line_color; ?>" required>
											-->
											<span class="input-group-addon"><i></i></span></div>
											
										</div>
									</div>
									<!-- /controls -->
								</div>
								<!-- /control-group -->









								<div class="form-actions">
									<button type="submit" name="update_top_bar" id="update_top_bar"
									class="btn btn-primary">Update</button>

								</div>
								<!-- /form-actions -->
							</fieldset>
						</form>







						<h3>Operator Logo </h3>
						<p>Max Size (160 x 30)</p>

						<div style="width:600px">
							<?php $url = '?type=mno_logo&id='.$user_distributor; ?>
							<form id="imageform" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>
								Upload your image <input type="file" name="photoimg" id="photoimg" />
							</form>

							<?php
							$key_query = "SELECT logo FROM exp_mno WHERE mno_id = '$user_distributor'";

							$query_results=mysql_query($key_query);
							while($row=mysql_fetch_array($query_results)){
								$logo = $row[logo];
							}
							?>


							<div id='img_preview'>
								<?php if(strlen($logo)){?>
									<img src="<?php echo $base_folder;?>/image_upload/logo/<?php echo $logo; ?>" border="0" />
								<?php }
								else{
									echo 'No Images';
								}?>
							</div>
						</div>





						<br /><br />





						<h3>Guest WiFi Favicon Icon </h3>
						<p>Size (32 x 32)</p>

						<div style="width:600px">
							<?php $url = '?type=mno_favicon&id='.$user_distributor; ?>
							<form id="imageform2" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>
								Upload your image <input type="file" name="photoimg2" id="photoimg2" />
							</form>

							<?php
							$key_query = "SELECT favicon_image FROM exp_mno WHERE mno_id = '$user_distributor'";

							$query_results=mysql_query($key_query);
							while($row=mysql_fetch_array($query_results)){
								$favicon_image = $row[favicon_image];
							}
							?>


							<div id='img_preview2'>
								<?php if(strlen($favicon_image)){?>
									<img src="<?php echo $base_folder;?>/image_upload/favicon/<?php echo $favicon_image; ?>" border="0" />
								<?php }
								else{
									echo 'No Images';
								}?>
							</div>
						</div>






						<br /><br />



						<h3>Guest WiFi Logo Background Image </h3>
						<p>Max Size (512 x 512)</p>

						<div style="width:600px">
							<?php $url = '?type=mno_bg_pattern&id='.$user_distributor; ?>
							<form id="imageform3" method="post" enctype="multipart/form-data" action='ajax/ajaximage.php<?php echo $url; ?>'>
								Upload your image <input type="file" name="photoimg3" id="photoimg3" />
							</form>

							<?php
							$key_query = "SELECT top_bg_pattern_image FROM exp_mno WHERE mno_id = '$user_distributor'";

							$query_results=mysql_query($key_query);
							while($row=mysql_fetch_array($query_results)){
								$top_bg_pattern_image = $row[top_bg_pattern_image];
							}
							?>


							<div id='img_preview3'>
								<?php if(strlen($top_bg_pattern_image)){?>
									<img width="160px;" src="<?php echo $base_folder;?>/image_upload/background/<?php echo $top_bg_pattern_image; ?>" border="0" />
								<?php }
								else{
									echo 'No Images';
								}?>
							</div>
						</div>









						<?php
					}

					?>

				</div>



			<?php } ?>






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