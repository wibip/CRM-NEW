
				<!-- tool tip css -->

<link rel="stylesheet" type="text/css" href="css/tooltipster-shadow.css" />

<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
<script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>		
									<form id="create_campaign" name="create_campaign" action="campaign.php?t=2"
										  method="post" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
										  <div class="form-group">
										<?php
										$key_query1 = "SELECT category_id,category, description,create_date, is_enable FROM exp_camphaign_ad_category where distributor='$user_distributor' ORDER BY description";
										$query_results1 = $db->selectDB($key_query1);
										$count_ad_cat = $query_results1['rowCount'];

										$key_query2 = "SELECT t.id,tag_name, description,t.create_date
                                    FROM exp_mno_distributor_group_tag t
                                    WHERE t.distributor = '$user_distributor'";
										$query_results2 = $db->selectDB($key_query2);
										$count_gt = $query_results2['rowCount'];
										if ($package_features == "all") {
											if ($count_ad_cat == 0 || $count_gt == 0) {
												$warning_text = '<div class="alert alert-warning" role="alert"><h3><i class="icon-info-sign"></i> Notice <small>';

												if ($count_ad_cat == 0) {
													$warning_text .= '<br>Please create a <a href="campaign.php?t=3" class="alert-link">Campaign Category</a> before trying to create a campaign';
												}
												if ($count_gt == 0) {
													$warning_text .= '<br>Please create a <a href="campaign.php?t=4" class="alert-link">Location</a> before trying to create a campaign';
												}
												$warning_text .= '</small></h3></div>';
												echo $warning_text;
											}
										}

										$secret = md5(uniqid(rand(), true));
										$_SESSION['FORM_SECRET'] = $secret;

										echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

										?>

										<fieldset>
										 
											
											<div class="control-group form-group">
												
												<div class="controls form-group">
													<h3>Campaign name & type
													<img id="ad_loader_gif" src="img/loading_ajax.gif"
														 style="visibility: hidden;"></h3>

													<div class="input-prepend input-append">
													
														<input class="span4 form-control special_input_camp"  placeholder="Campaign Name" type="text" id="camp_name" name="camp_name" maxlength="30"
														  value="<?php if (isset($mg_ad_name)) {
															echo $mg_ad_name;
														} ?>"> &nbsp;&nbsp;&nbsp;&nbsp;
														
														<small class="help-block " data-bv-validator="notEmpty" id="camp_name_msg"   style="display:none; margin-left: 0px !important; "><p>This is a required field</p></small>

													</div> 
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->
											
                                            
                                            <?php if($package_functions->getOptions('CAMPAIGN_CREATE_SIMPLE',$system_package,$user_type)=="ON"){ ?>

                                                
												    <input type="text" class="span4" id="camp_description" name="camp_description" value="" style="display: none">
                                            
													<select name="ad_category" class="span4" id="ad_category" style="display: none">>
                                                        <option selected value="Default Ad Category">Default Ad Category</option>
													</select>
                                            
                                                    <?php }else{ ?>

                                                        <div class="control-group form-group">
												<label class="control-label"
													   for="radiobtns"><strong>Description<sup><font
																color="#FF0000">*</font></sup> :</strong></label>

												<div class="controls">
													<div class="input-prepend input-append">
														<input type="text" class="span4" id="camp_description"
															   name="camp_description" required
															   value="<?php if (isset($mg_ad_discription)) {
																   echo $mg_ad_discription;
															   } ?>"> &nbsp;&nbsp;&nbsp;&nbsp;

													</div>
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->
                                            
                        


											<div class="control-group form-group">
												<label class="control-label" for="password2"><strong>Ad
														Category<sup><font color="#FF0000">*</font></sup>
														:</strong></label>
												<div class="controls">
													<select name="ad_category" class="span4" id="ad_category"
															required="required">


														<?php

														if (isset($mg_ad_category)) {
															$set_order_by = "category='" . $mg_ad_category . "' DESC";
														} else {

															echo '<option value="">Select Ad Category</option>';

															$set_order_by = "description ASC";

														}

														$key_query = "SELECT category, description FROM exp_camphaign_ad_category where distributor='$user_distributor' AND is_enable=1 ORDER BY " . $set_order_by;


														$query_results = $db->selectDB($key_query);
														foreach ($query_results['data'] as $row) {
															$category = $row['category'];
															$description = $row['description'];

															echo '<option value="' . $category . '">' . $description . '</option>';
														}

														?>

													</select>
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->

                                                    <?php }  ?>


											<div class="control-group form-group">
												
												<div class="controls col-lg-5 form-group">
													<select id="ad_type" class="span4 form-control" onchange="getInfoBox();"
															name="ad_type" >
														<?php
														if (isset($mg_ad_type)) {
															$key_query2 = "SELECT ad_type, description FROM exp_camphaign_ad_type ORDER BY ad_type='" . $mg_ad_type . "' DESC";

														} else {
															$key_query2 = "SELECT ad_type, description FROM exp_camphaign_ad_type ORDER BY description ASC";
															echo '<option value="">Select Campaign Type</option>';
														}

														$query_results2 = $db->selectDB($key_query2);
														foreach ($query_results2['data'] as $row2) {
															$category = $row2['ad_type'];
															$description = $row2['description'];

															echo '<option value="' . $category . '">' . $description . '</option>';
														}

														?>
													</select>
												</div>
												<!-- /controls -->
											</div>
											<!-- /control-group form-group -->


											<div class="control-group form-group table_response" id="ad_type_response">
												<?php
												if (isset($mg_ad_type)) {

													switch ($mg_ad_type) {
														case 'default_ad' :
															?>

															<div class="control-group form-group">
																<label class="control-label" for="radiobtns"><strong>Count
																		down (sec)<sup><font
																				color="#FF0000">*</font></sup>
																		:</strong></label>


																<div class="controls">
																	<div class="input-prepend input-append">

																		<input class="span2"
																			   id="default_ad_waiting_time"
																			   name="default_ad_waiting_time"
																			   type="number" min="0" max="300" required
																			   value="<?php echo $mg_waiting_time; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																<label class="control-label" for="radiobtns"><strong>Landing
																		Page<sup><font color="#FF0000">*</font></sup> :</strong></label>

																<div class="controls">
																	<div class="input-prepend input-append">

																		<input class="span4" id="default_ad_welcome_url"
																			   placeholder="eg: http://www.google.com"
																			   name="default_ad_welcome_url" type="text"
																			   required url
																			   value="<?php echo $mg_welcome_url; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->
															<?php
															break;


														case 'slider' :
															?>

															<div class="controls">
			
																<h3 style="display: inline-block;">Illustrative rendering of the template</h3><img data-toggle="tooltip" title="The arrows indicates which elements of the template that can be changed" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
																										

																<img src="img/slider_img.png" style="width:400px; max-height:250px;display:block">

															</div>


															<div class="control-group form-group">
																

																<div class="controls form-group">

																	<h3 style="display: inline-block;">Welcome Message</h3><img data-toggle="tooltip" title="A maximum of 30 characters allowed including spaces" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">


																	<div class="input-prepend input-append">

																		<input class="span4 form-control special_input"  id="slider_top_text" maxlength="30" 
																			   name="slider_top_text"
																			   value="<?php echo $mg_top_text; ?>"></input>
																		<!--					<input class="span4" id="slider_top_text" name="slider_top_text" type="text" required value="-->
																		<?php //echo $mg_top_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->
															<hr>
															<br>


															


															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Upload logo image</h3><img data-toggle="tooltip" title="The logo image must be a transparent png, gif, png, jpeg, jpg Maximum size 600 Kb. Use aspect ratio 8 by 3." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="input-prepend input-append"
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class="input-prepend input-append"
																		 id="img_div5">

																		 <div class="dooo" id='yourId5'>
																		 	<?php if (strlen($mg_image5_name) > 0) { ?>
																		 
																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image5_name; ?>"
																			style='width:193px; display:inline; max-height: 71px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image5_name); ?>"
																			style='width:193px; display:inline; max-height: 71px;'>
																		
																		<?php } ?>

																		</div>
																		<input type="hidden" name="image_5_name"
																			   id="image_5_name"
																			   value="<?php echo $mg_image5_name; ?>"/>

																		<input type="hidden" name="image_5_name_prev"
																			   id="image_5_name_prev"
																			   value="<?php echo $mg_image5_name; ?>"/>

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															

															<div class="controls">

		<h3 style="display: inline-block;">Upload slider images</h3><img data-toggle="tooltip" title="The images must be a .png or jpg. Maximum size 600Kb. Use aspect ratio 1 by 1." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

	</div>



															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="input-prepend input-append"
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class="input-prepend input-append"
																		 id="img_div1">

																		 <div class="dooo" id='yourId1'>
																		 <?php if (strlen($mg_image1_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image1_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image1_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>

																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_1_name"
																			   id="image_1_name"
																			   value="<?php echo $mg_image1_name; ?>"/>

																		<input type="hidden" name="image_1_name_prev"
																			   id="image_1_name_prev"
																			   value="<?php echo $mg_image1_name; ?>"/>
																	</div>


																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="input-prepend input-append"
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class="input-prepend input-append"
																		 id="img_div2">
																		 <div class="dooo" id='yourId2'>
																		 <?php if (strlen($mg_image2_name) > 0) { ?>
																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image2_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image2_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>

																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_2_name"
																			   id="image_2_name"
																			   value="<?php echo $mg_image2_name; ?>"/>

																		<input type="hidden" name="image_2_name_prev"
																			   id="image_2_name_prev"
																			   value="<?php echo $mg_image2_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="input-prepend input-append"
																		 style="vertical-align:top;">
																	
																	</div>
																	<div class="input-prepend input-append"
																		 id="img_div3">
																		 <div class="dooo" id='yourId3'>
																		 <?php if (strlen($mg_image3_name) > 0) { ?>
																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image3_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image3_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>


																		<?php } ?>

																			</div>
																		<input type="hidden" name="image_3_name"
																			   id="image_3_name"
																			   value="<?php echo $mg_image3_name; ?>"/>

																		<input type="hidden" name="image_3_name_prev"
																			   id="image_3_name_prev"
																			   value="<?php echo $mg_image3_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="input-prepend input-append"
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class="input-prepend input-append"
																		 id="img_div4">
																		 <div class="dooo" id='yourId4'>
																		 <?php if (strlen($mg_image4_name) > 0) { ?>
																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image4_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image4_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>


																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_4_name"
																			   id="image_4_name"
																			   value="<?php echo $mg_image4_name; ?>"/>

																		<input type="hidden" name="image_4_name_prev"
																			   id="image_4_name_prev"
																			   value="<?php echo $mg_image4_name; ?>"/>

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls form-group">

																	  <h3 style="display: inline-block;">Set background color</h3><img data-toggle="tooltip" title="Either select with the color picker or type in the HEX value of your preferred color." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<div id="button_color_div" class="input-group colorpicker-component">
					<input id="background_color" name="background_color" type="text" value="" >
				<span class="input-group-addon"><i></i></span></div>

																		<!-- <input style="width:30px; height:30px;"
																			   class="span6" id="background_color"
																			   name="background_color" type="color"
																			   value="<?php //echo $mg_bg_color; ?>"
																			   required> -->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															<br>
                                                 <hr>
                                                 <br>  


															<div class="control-group form-group">
															

																<div class="controls form-group">

																	   <h3 style="display: inline-block;">Redirect button</h3><img data-toggle="tooltip" title="The button text field can use a maximum of 15 characters including spaces. The redirect URL is where the visitor will land after watching this campaign." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

												<input class="span4 form-control special_input" id="slider_bottom_text" maxlength="15" name="slider_bottom_text"
														value="<?php echo $mg_bottom_text; ?>" placeholder="Button text">
																		<!--					<input class="span4" id="slider_bottom_text" name="slider_bottom_text" type="text" required value="-->
																		<?php //echo $mg_bottom_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls form-group">
																	<div class="">

																	<select class="span2" name="slider_urlsecure" style="width: 104px;">
<option <?php if($secslider=='http://'){echo 'selected';} ?> value="http://">http://</option>
<option <?php if($secslider=='https://'){echo 'selected';} ?> value="https://">https://</option>
</select>

																		<input class="span4 form-control" id="slider_url"
																			   name="slider_url"
																			   placeholder="Redirect address Ex. www.google.com"
																			   type="text" required
																			   value="<?php echo $mg_welcome_url; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<?php

															break;

														case 'survey' :
															?>

															<div class="controls">
			
																<h3 style="display: inline-block;">Illustrative rendering of the template</h3><img data-toggle="tooltip" title="The arrows indicates which elements of the template that can be changed" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
																										

																<img src="img/mini_survy.JPG" style="width:400px; max-height:250px;display:block">
															</div>

															


															<div class="control-group">
			
															<div class="controls form-group">

																<h3 style="display: inline-block;">Welcome Message</h3><img data-toggle="tooltip" title="A maximum of 30 characters allowed including spaces" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																<div class="">

																	
													
																	<input type="text" class="countdown_top_text span4 form-control special_input" maxlength="30" id="countdown_top_text" name="countdown_top_text"  value="<?php echo $mg_top_text; ?>" required placeholder="Welcome Message">
												<!--					<input class="span4" id="countdown_top_text" name="countdown_top_text" type="text" required="required">-->

																</div>
															</div>
															<!-- /controls -->
													</div>
													<!-- /control-group -->

                                                 <hr>
                                                 <br>  

                                                 	<div class="control-group">
			
															<div class="controls form-group">

																<h3 style="display: inline-block;">Upload logo image</h3><img data-toggle="tooltip" title="The logo image must be a transparent png, gif, png, jpeg, jpg Maximum size 600 Kb. Use aspect ratio 8 by 3." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

														                 <div class="" style="vertical-align:top;">
														               <!--  <label class="filebutton">
														                Browse Image
														                <span><input class="span4 form-control" id="image5" name="image5" type="file" style="width:90px;" onchange="return ajaxFileUpload(5);"></span>
														                </label>&nbsp;&nbsp;<img id="loading_5" src="img/loading_ajax.gif" style="display:none;"> -->

														                 <div class="dooo" id='yourId5'>
																		 <?php if (strlen($mg_image5_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image5_name; ?>"
																			style='width:193px; display:inline; max-height: 71px;'>-->


																			<img
																			src="<?php echo $upload_img->get_image($mg_image5_name); ?>"
																			style='width:193px; display:inline; max-height: 71px;'>


																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_5_name"
																			   id="image_5_name"
																			   value="<?php echo $mg_image5_name; ?>"/>

																		<input type="hidden" name="image_5_name_prev"
																			   id="image_5_name_prev"
																			   value="<?php echo $mg_image5_name; ?>"/>

																	</div>       
														            <div class="" id="img_div5"></div>
																	
																
																	</div>
																	<!-- /controls -->
															</div>
															<!-- /control-group -->	


																<div class="control-group">
			
																<div class="controls form-group">

																	<h3 style="display: inline-block;">Survey Question</h3><img data-toggle="tooltip" title="The question must be a simple multiple choice question. A maximum of 30 characters are allowed including spaces. EX. Which of these colors do you prefer?. You have to provide a minimum of two and maximum three possible predetermined answers. Ex. Yellow, Blue, Other. Each answer must be accompanied by an image." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">
																		<input id="survey_top_text" name="survey_top_text" class="span4 form-control special_input_q" type="text" maxlength="30" value="<?php echo $mg_survey_top_text; ?>" required placeholder="Survey Question">
													<!--					<input class="span4" id="survey_top_text" name="survey_top_text" type="text" required>-->
																	</div>

																

																</div>
																<!-- /controls -->
														</div>
														<!-- /control-group -->



															<div class="control-group">
			
			<div class="controls form-group">

				<h3 style="display: inline-block;">Possible Answers</h3><img data-toggle="tooltip" title="Each predetermined answer can be a maximum of 20 characters. The image must be a .png or .jpg. Maximum size 200 Kb. Use aspect ratio 1 by 1." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

				<div class="">

					<input class="span4 form-control special_input" id="survey_answer_1" name="survey_answer_1" maxlength="20" type="text" required value="<?php echo $mg_answer1_text; ?>" placeholder="Answer 01">
	
				</div>

			</div>
			<!-- /controls -->
	</div>
	<!-- /control-group -->	







															<div class="control-group form-group">
																

																<div class="controls">
																	<div class=""
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class=""
																		 id="img_div1">
																		 <div class="dooo" id='yourId1'>
																		 <?php if (strlen($mg_image1_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image1_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->


																			<img
																			src="<?php echo $upload_img->get_image($mg_image1_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>


																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_1_name"
																			   id="image_1_name"
																			   value="<?php echo $mg_image1_name; ?>"/>

																		<input type="hidden" name="image_1_name_prev"
																			   id="image_1_name_prev"
																			   value="<?php echo $mg_image1_name; ?>"/>

																	</div>


																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="">

																		<input class="span4" id="survey_answer_2"
																			   name="survey_answer_2" type="text" maxlength="20"
																			   required placeholder="Answer 02"
																			   value="<?php echo $mg_answer2_text; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class=""
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class=""
																		 id="img_div2">
																		 <div class="dooo" id='yourId2'>

																		 <?php if (strlen($mg_image2_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image2_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image2_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>
																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_2_name"
																			   id="image_2_name"
																			   value="<?php echo $mg_image2_name; ?>"/>

																		<input type="hidden" name="image_2_name_prev"
																			   id="image_2_name_prev"
																			   value="<?php echo $mg_image2_name; ?>"/>

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="">

																		<input class="span4" id="survey_answer_3"
																			   name="survey_answer_3" type="text" maxlength="20"
																			   placeholder="Answer 03"  
																			   value="<?php echo $mg_answer3_text; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															<div class="control-group form-group">
																

																<div class="controls">
																	<div class=""
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class=""
																		 id="img_div3">

																		 <div class="dooo" id='yourId3'>
																		 <?php if (strlen($mg_image3_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image3_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image3_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>


																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_3_name"
																			   id="image_3_name"
																			   value="<?php echo $mg_image3_name; ?>"/>

																		<input type="hidden" name="image_3_name_prev"
																			   id="image_3_name_prev"
																			   value="<?php echo $mg_image3_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->



															<div class="control-group form-group">
															

																<div class="controls">

																	<h3 style="display: inline-block;">Set background color</h3><img data-toggle="tooltip" title="Either select with the color picker or type in the HEX value of your preferred color." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																	<div id="button_color_div" class="input-group colorpicker-component">
					<input id="background_color" name="background_color" type="text" value="" >
				<span class="input-group-addon"><i></i></span></div>												

																		

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<br>
                                                 <hr>
                                                 <br> 


															<div class="control-group form-group">
																

																<div class="controls">

																	 <h3 style="display: inline-block;">Redirect button</h3><img data-toggle="tooltip" title="The button text field can use a maximum of 15 characters including spaces. The redirect URL is where the visitor will land after watching this campaign." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input class="span4 form-control special_input" id="countdown_bottom_text"
																			   name="countdown_bottom_text" type="text" maxlength="15" 
																			   value="<?php echo $mg_bottom_text; ?>" required placeholder="Button Text">
																		<!--					<input class="span4" id="countdown_bottom_text" name="countdown_bottom_text" type="text" required value="-->
																		<?php // echo $mg_bottom_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->




														




															<div class="control-group form-group">
																
															
																<div class="controls">
																	<div class="">

																	<select class="span2" name="survay_urlsecure" style="width: 104px;">
<option <?php if($sec_survay_url=='http://'){echo 'selected';} ?> value="http://">http://</option>
<option <?php if($sec_survay_url=='https://'){echo 'selected';} ?> value="https://">https://</option>
</select>

																		<input class="span3" id="survay_url"
																			   required placeholder="Redirect address Ex. www.google.com"
																			   name="survay_url" type="text" required
																			   value="<?php echo $survay_url; ?>">

																	</div>

																	

																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<?php
															break;
															
														case 'countdown_image' :
															?>


															<div class="controls">
			
																<h3 style="display: inline-block;">Illustrative rendering of the template</h3><img data-toggle="tooltip" title="The arrows indicates which elements of the template that can be changed" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
																										

																<img src="img/count_down_img.JPG" style="width:400px; max-height:250px;display:block">
															</div>


															<div class="control-group form-group">
														
																<div class="controls">

																	<h3 style="display: inline-block;">Welcome Message</h3><img data-toggle="tooltip" title="A maximum of 30 characters allowed including spaces" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input class="span4 form-control special_input" id="countdown_top_text" placeholder="Welcome Message" 
																			   name="countdown_top_text" type="text" maxlength="30" 
																			   value="<?php echo $mg_top_text; ?>">
																		<!--					<input class="span4" id="countdown_top_text" name="countdown_top_text" type="text" required value="-->
																		<?php // echo $mg_top_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															 <hr>
                                                 <br> 

                                                 			<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Upload logo image</h3><img data-toggle="tooltip" title=" The logo image must be a transparent png, gif, png, jpeg, jpg Maximum size 600 Kb. Use aspect ratio 8 by 3." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class=""
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class=""
																		 id="img_div5">

																		 <div class="dooo" id='yourId5'>
																		 <?php if (strlen($mg_image5_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image5_name; ?>"
																			style='width:193px; display:inline; max-height: 71px;'>-->


																			<img
																			src="<?php echo $upload_img->get_image($mg_image5_name); ?>"
																			style='width:193px; display:inline; max-height: 71px;'>

																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_5_name"
																			   id="image_5_name"
																			   value="<?php echo $mg_image5_name; ?>"/>

																		<input type="hidden" name="image_5_name_prev"
																			   id="image_5_name_prev"
																			   value="<?php echo $mg_image5_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Upload Campaign image</h3><img data-toggle="tooltip" title="The image must be a .png or jpg. Maximum size 600Kb. Use aspect ratio 1 by 1." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class=""
																		 style="vertical-align:top;">
																	
																	</div>
																	<div class=""
																		 id="img_div1">

																		 <div class="dooo" id='yourId1'>
																		 	<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image1_name; ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image1_name); ?>"
																			style='width:193px; display:inline; max-height: 160px; height: 160px;'>


																		</div>
																		<input
																			type="hidden" name="image_1_name"
																			id="image_1_name"
																			value="<?php echo $mg_image1_name; ?>"/>

																		<input
																			type="hidden" name="image_1_name_prev"
																			id="image_1_name_prev"
																			value="<?php echo $mg_image1_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->



															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Countdown</h3><img data-toggle="tooltip" title="Set the amount of time the progression bar will show before the user is redirected to the final redirect URL." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input class="span2" id="countdown_waiting_time"
																			   name="countdown_waiting_time"
																			   type="text" 
																			   required="required" placeholder="Countdown (sec)" 
																			   value="<?php echo $mg_waiting_time; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Set background color</h3><img data-toggle="tooltip" title="Either select with the color picker or type in the HEX value of your preferred color." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																			<div id="button_color_div" class="input-group colorpicker-component">
					<input id="background_color" name="background_color" type="text" value="" >
				<span class="input-group-addon"><i></i></span></div>

																		<!-- <input style="width:30px; height:30px;"
																			   class="span6" id="background_color"
																			   name="background_color" type="color"
																			   value="<?php //echo $mg_bg_color; ?>"
																			   required> -->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<br>
                                                 			<hr>
                                                 			<br>  


															<div class="control-group form-group">
																

																<div class="controls">

																	  <h3 style="display: inline-block;">Redirect button</h3><img data-toggle="tooltip" title="The button text field can use a maximum of 15 characters including spaces. The redirect URL is where the visitor will land after watching this campaign." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																			<input class="span4 form-control special_input" id="countdown_bottom_text" placeholder="Button text" 
																			   name="countdown_bottom_text" type="text" maxlength="15" 
																			   value="<?php echo $mg_bottom_text; ?>">

																		

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="">
																	<select class="span2" name="countdown_urlsecure" style="width: 104px;">
<option <?php if($seccountdown=='http://'){echo 'selected';} ?> value="http://">http://</option>
<option <?php if($seccountdown=='https://'){echo 'selected';} ?> value="https://">https://</option>
</select>		
																	<input class="span3" id="countdown_url"
																			   placeholder="Redirect address Ex. www.google.com"
																			   name="countdown_url" type="text" required
																			   value="<?php echo $mg_welcome_url; ?>">
																		<!--					<input class="span4" id="countdown_bottom_text" name="countdown_bottom_text" type="text" required value="-->
																	

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<!--	<div class="control-group form-group">
                                                                        <label class="control-label" for="radiobtns">Offer Name</label>

                                                                        <div class="controls">
                                                                            <div class="input-prepend input-append">

                                                                                <input class="span4" id="countdown_offer_name" name="countdown_offer_name" type="text" >

                                                                            </div>
                                                                        </div>

                                                                </div>-->
															<!-- /control-group form-group -->


															<?php

															break;

														case 'video' :
															?>


															<div class="controls">
			
																<h3 style="display: inline-block;">Illustrative rendering of the template</h3><img data-toggle="tooltip" title="The arrows indicates which elements of the template that can be changed." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
																										

																<img src="img/video_add.JPG" style="width:400px; max-height:250px;display:block">
															</div>


															<div class="control-group form-group">
															

																<div class="controls">

																	<h3 style="display: inline-block;">Welcome Message</h3><img data-toggle="tooltip" title="A maximum of 30 characters allowed including spaces" src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input class="span4 form-control special_input" placeholder="Welcome Message" id="countdown_top_text"
																			   name="countdown_top_text" type="text" maxlength="30"
																			   value="<?php echo $mg_top_text; ?>">
																		<!--					<input class="span4" id="countdown_top_text" name="countdown_top_text" type="text" required value="-->
																		<?php // echo $mg_top_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															<hr>
                                                 			<br>  


															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Upload logo image</h3><img data-toggle="tooltip" title="The logo image must be a transparent png, gif, png, jpeg, jpg Maximum size 600 Kb. Use aspect ratio 8 by 3." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class=""
																		 style="vertical-align:top;">
																		
																	</div>
																	<div class=""
																		 id="img_div5">
																		 <div class="dooo" id='yourId5'>

																		 <?php if (strlen($mg_image5_name) > 0) { ?>

																			<!--<img
																			src="<?php //echo $original_Ads_Image_Folder . $mg_image5_name; ?>"
																			style='width:193px; display:inline; max-height: 71px;'>-->

																			<img
																			src="<?php echo $upload_img->get_image($mg_image5_name); ?>"
																			style='width:193px; display:inline; max-height: 71px;'>

																		<?php } ?>
																		</div>
																		<input type="hidden" name="image_5_name"
																			   id="image_5_name"
																			   value="<?php echo $mg_image5_name; ?>"/>

																		<input type="hidden" name="image_5_name_prev"
																			   id="image_5_name_prev"
																			   value="<?php echo $mg_image5_name; ?>"/>
																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
															

																<div class="controls">

																	<h3 style="display: inline-block;">Set background color</h3><img data-toggle="tooltip" title="Either select with the color picker or type in the HEX value of your preferred color." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																			<div id="button_color_div" class="input-group colorpicker-component">
					<input id="background_color" name="background_color" type="text" value="" >
				<span class="input-group-addon"><i></i></span></div>

																		<!-- <input style="width:30px; height:30px;"
																			   class="span6" id="background_color"
																			   name="background_color" type="color"
																			   value="<?php //echo $mg_bg_color; ?>"
																			   required> -->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															<br>
                                                 			<hr>
                                                 			<br> 




															<div class="control-group form-group">
																
																<div class="controls">

																	<h3 style="display: inline-block;">Video Requirements</h3><img data-toggle="tooltip" title="Your video can be either 15 or 30 seconds long. We only accept videos from the youtube domain." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input onclick="" id="v_length" name="v_length"
																			   type="radio" checked="checked"
																			   value="15"> 15 Seconds&nbsp;&nbsp;&nbsp;&nbsp;
																		<input onclick="" id="v_length" name="v_length"
																			   type="radio" value="30"> 30 Seconds

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->



															<div class="control-group form-group">
															

																<div class="controls">
																	<div class="">
																	<select class="span2" name="video_urlsecure" style="width: 104px;">
<option <?php if($secvideo=='http://'){echo 'selected';} ?> value="http://">http://</option>
<option <?php if($secvideo=='https://'){echo 'selected';} ?> value="https://">https://</option>
</select>

																		<input class="span3" id="video_url"
																			   name="video_url" type="text"
																			   placeholder="Video URL eg: www.youtube.com/watch?v=..."
																			   required
																			   value="<?php echo $mg_video_url; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">

																	<h3 style="display: inline-block;">Redirect button</h3><img data-toggle="tooltip" title="The button text field can use a maximum of 15 characters including spaces. The redirect URL is where the visitor will land after watching this campaign." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

																	<div class="">

																		<input class="span4 form-control special_input" id="countdown_bottom_text"
																			   name="countdown_bottom_text" type="text" maxlength="15" 
																			   value="<?php echo $mg_bottom_text; ?>" placeholder="Button text" >
																		<!--					<input class="span4" id="countdown_bottom_text" name="countdown_bottom_text" type="text" required value="-->
																		<?php // echo $mg_bottom_text;
																		?><!--">-->

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->


															<div class="control-group form-group">
																

																<div class="controls">
																	<div class="">
																	<select class="span2" name="wvideo_urlsecure" style="width: 104px;">
<option <?php if($sec_wvideo=='http://'){echo 'selected';} ?> value="http://">http://</option>
<option <?php if($sec_wvideo=='https://'){echo 'selected';} ?> value="https://">https://</option>
</select>
																		<input class="span3" id="video_welcome_url"
																			   placeholder="Redirect address Ex. www.google.com"
																			   name="video_welcome_url" type="text"
																			   required
																			   value="<?php echo $mg_welcome_url; ?>">

																	</div>
																</div>
																<!-- /controls -->
															</div>
															<!-- /control-group form-group -->

															<?php

															break;


													}

												} else {
													?>
													<label class="control-label" for="password2">
													</label>
													<div class="controls">
														<div></div>
													</div>

												<?php } ?>
											</div>
                                            <!-- /control-group form-group -->
                                            
                                            <?php  if($package_functions->getOptions('CAMPAIGN_CREATE_SIMPLE',$system_package,$user_type)=="ON"){ ?>

                                                        <div style="display: none">
                                                        <input type="date" name="start_date" id="start_date" value='<?php echo date('Y-m-d'); ?>'>
                                                        <input type="date" name="end_date" id="end_date" value='<?php echo date('Y-m-d', strtotime('+5 years')); ?>'>
                                                        <select name="time_start" id="time_start"><option value="0"></option></select>
                                                        <select name="time_end" id="time_start"><option value="23"></option></select>
                                                        <select name="priority" id="priority"><option value="MEDIUM">MEDIUM</option></select>
                                                        <input type="checkbox" name="mon" checked="checked" id="list1">
                                                        <input type="checkbox" name="tue" id="list1" checked="checked">
                                                        <input type="checkbox" name="wed" id="list1" checked="checked">
                                                        <input type="checkbox" name="thu" id="list1" checked="checked">
                                                        <input type="checkbox" name="fri" id="list1" checked="checked">
                                                        <input type="checkbox" name="sat" id="list1" checked="checked">
                                                        <input type="checkbox" name="sun" id="list1" checked="checked">
                                                        </div>
                                                    <?php }else{ ?>


											<div class="control-group form-group">
												<label class="control-label" for="radiobtns"><strong>Campaign
														Period<sup><font color="#FF0000">*</font></sup>
														:</strong></label>

												<div class="controls">
													<div class="input-prepend input-append">

														<input class="span2" id="start_date" name="start_date"
															   type="date" min="<?php if (isset($mg_start_date)) {
															echo $mg_start_date;
														} else {
															echo date('Y-m-d', strtotime("-1 days"));
														} ?>" required value="<?php if (isset($mg_start_date)) {
															echo $mg_start_date;
														} ?>"> to <input
															class="span2" id="end_date" name="end_date" type="date"
															min="<?php if (isset($mg_start_date)) {
																echo $mg_start_date;
															} else {
																echo date("Y-m-d");
															} ?>" required value="<?php if (isset($mg_end_date)) {
															echo $mg_end_date;
														} ?>">

													</div>
												</div>
												<!-- /controls -->
											</div>
											<!-- /control-group form-group -->


											<div class="control-group form-group">
												<label class="control-label" for="radiobtns"><strong>Campaign Hours<sup><font
																color="#FF0000">*</font></sup> :</strong> </label>

												<div class="controls">
													<div class="input-prepend input-append">

														<select id="time_start" name="time_start" class="span2">
															<?php
															for ($i = 0; $i <= 23; $i++) {


																if ($mg_start_hour == $i) {
																	echo '<option selected="selected" value="' . $i . '">' . date("g:i A", strtotime($i . ':00')) . '</option>';
																} else {
																	echo '<option  value="' . $i . '">' . date("g:i A", strtotime($i . ':00')) . '</option>';
																}
															}

															?>


														</select>
														to
														<select id="time_end" name="time_end" class="span2">
															<?php
															for ($i = 1; $i <= 24; $i++) {
																if ($i == '24') {
																	$ival = '23';
																	$min = ':59';
																} else {
																	$min = ':00';
																	$ival = $i;
																}

																if ($mg_end_hour == $i) {
																	echo '<option selected="selected" value="' . $ival . '">' . date("g:i A", strtotime($ival . $min)) . '</option>';
																} else {
																	echo '<option  value="' . $ival . '">' . date("g:i A", strtotime($ival . $min)) . '</option>';
																}
															}

															?>

														</select>


													</div>
												</div>
												<!-- /controls -->
											</div>
											<!-- /control-group form-group -->


											<div class="control-group form-group">
												<label class="control-label" for="radiobtns"><strong>Priority<sup><font
																color="#FF0000">*</font></sup> :</strong> </label>

												<div class="controls">
													<div class="input-prepend input-append">

														<select id="priority" name="priority" class="span4">
															<?php if (isset($mg_priority)) {
																echo '<option value="' . $mg_priority . '">' . $mg_priority . '</option>';
															} ?>
															<option value="LOW">LOW</option>
															<option value="MEDIUM">MEDIUM</option>
															<option value="HIGH">HIGH</option>

														</select>


													</div>
												</div>
												<!-- /controls -->
											</div>
											<!-- /control-group form-group -->


											<div class="control-group form-group">
												<label class="control-label" for="radiobtns"><strong>Campaign
														Days<sup><font color="#FF0000">*</font></sup> :</strong>
												</label>

												<div class="controls">
													<div class="input-prepend input-append">

													<div class="mobi_camp">

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="mon"
															   type="checkbox" <?php if (!isset($mg_mon) || $mg_mon == 1) { ?> checked="checked" <?php } ?> >
														Mon 
															
														</div>

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="tue"
															   type="checkbox" <?php if (!isset($mg_tue) || $mg_tue == 1) { ?> checked="checked" <?php } ?>>
														Tue
	

														</div>
														
														
														

													</div>

													<div class="mobi_camp">

													<div class="mobi_child">

													<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="wed"
															   type="checkbox" <?php if (!isset($mg_wed) || $mg_wed == 1) { ?> checked="checked" <?php } ?>>
														Wed

														</div>

														<div class="mobi_child">
														<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="thu"
															   type="checkbox" <?php if (!isset($mg_thu) || $mg_thu == 1) { ?> checked="checked" <?php } ?>>
														Thu

														</div>
													</div>

													<div class="mobi_camp">

													<div class="mobi_child">

													<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="fri"
															   type="checkbox" <?php if (!isset($mg_fri) || $mg_fri == 1) { ?> checked="checked" <?php } ?>>
														Fri

														</div>

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="sat"
															   type="checkbox" <?php if (!isset($mg_sat) || $mg_sat == 1) { ?> checked="checked" <?php } ?>>
														Sat

														</div>

													</div>

													<div class="mobi_camp">

													<div class="mobi_child">
														<input onclick="checkset(document.create_campaign.list1,1)"
															   id="list1" name="sun"
															   type="checkbox" <?php if (!isset($mg_sun) || $mg_sun == 1) { ?> checked="checked" <?php } ?>>
														Sun

														</div>

													</div>

														
														
														
														

													</div>
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->
                                            
                                                        <?php } ?>
                                                        
                                                       
                                                 <hr>
                                                 <br>    

											<div class="control-group form-group">
											
											

												<div class="controls form-group">

													<h3 style="display: inline-block;">Campaign target audience</h3><img data-toggle="tooltip" title=" If using a Facebook or Manual Registration splash page theme you can create multiple campaigns targeting a specific demographic audience based on what data your splash page collect." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">

													<div class="input-prepend input-append">

													<div class="mobi_camp">

													
														</div>

													</div>
												</div>
												<!-- /controls -->
											</div>
											<!-- /control-group form-group -->


											<div class="control-group form-group">
												

												<div class="controls">
													<div class="input-prepend input-append">

														<div class="mobi_child" style="width: 115px">

														<input onclick="checkset(document.create_campaign.list2,2)"
															   id="list2" name="gender_male"
															   type="checkbox" <?php if (!isset($mg_male) || $mg_male == 1) { ?> checked="checked" <?php } ?>>
														Male

													</div>

													<div class="mobi_child">

														<input class="form-control" onclick="checkset(document.create_campaign.list2,2)"
															   id="list2" name="gender_female"
															   type="checkbox" <?php if (!isset($mg_female) || $mg_female == 1) { ?> checked="checked" <?php } ?>>
														Female

														</div>

														<?php

														$key_query = "SELECT age_group_id,age_group FROM exp_age_groups";
														$query_results = $db->selectDB($key_query);


														foreach ($query_results['data'] as $row) {
															$age_group_id = $row['age_group_id'];
															$age_group = $row['age_group'];

															if (isset($_GET['mg_ad_id'])) {
																if ($age_group_id == "10_17" && $mg_age_10_17 == 0) {
																	$set = '';

																} elseif ($age_group_id == "18_34" && $mg_age_18_34 == 0) {

																	$set = '';
																} elseif ($age_group_id == "35_54" && $mg_age_35_54 == 0) {

																	$set = '';

																} elseif ($age_group_id == "55_99" && $mg_age_55_99 == 0) {
																	$set = '';


																} else {
																	$set = 'checked="checked"';

																}
															} else {
																$set = 'checked="checked"';
															}

															echo '<div class="mobi_child">';
															echo '<input onclick="checkset(document.create_campaign.list3,3)" id="list3" name="age_group_' . $age_group_id . '" value="' . $age_group_id . '"  type="checkbox" ' . $set . '> ' . $age_group . '&nbsp;&nbsp;&nbsp;&nbsp;';

															echo '</div>';
														}

														?>


													</div>
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->
                                            
                                            <?php  if($package_functions->getOptions('CAMPAIGN_CREATE_SIMPLE',$system_package,$user_type)=="ON"){ ?>

                                                <input type="checkbox" name="ios" id="list4" checked="checked" style="display: none;">
                                                <input type="checkbox" name="android" id="list4" checked="checked" style="display: none;">
                                                <input type="checkbox" name="windows" id="list4" checked="checked" style="display: none;">
                                                <input type="checkbox" name="other" id="list4" checked="checked" style="display: none;">

                                            <?php }else{ ?>


											<div class="control-group form-group">
												<label class="control-label" for="radiobtns"><strong>OS<sup><font
																color="#FF0000">*</font></sup> :</strong> </label>

												<div class="controls">
													<div class="input-prepend input-append">

													<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list4,4)"
															   id="list4" name="ios"
															   type="checkbox" <?php if (!isset($mg_ios) || $mg_ios == 1) { ?> checked="checked" <?php } ?>>
														iOS

														</div>

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list4,4)"
															   id="list4" name="android"
															   type="checkbox" <?php if (!isset($mg_android) || $mg_android == 1) { ?> checked="checked" <?php } ?>>
														Android

														</div>

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list4,4)"
															   id="list4" name="windows"
															   type="checkbox" <?php if (!isset($mg_windows) || $mg_windows == 1) { ?> checked="checked" <?php } ?>>
														Windows

														</div>

														<div class="mobi_child">

														<input onclick="checkset(document.create_campaign.list4,4)"
															   id="list4" name="other"
															   type="checkbox" <?php if (!isset($mg_other) || $mg_other == 1) { ?> checked="checked" <?php } ?>>
														Other

														</div>

													</div>
												</div>
												<!-- /controls -->
											</div>
                                            <!-- /control-group form-group -->
                                            
                                            <?php } ?>

                                            <br>
                                                 <hr>
                                                 <br>  


											<?php if ($package_functions->getSectionType("CAMP_CREATE_LOCATION", $system_package, $user_type) == "locations" || $package_features == "all") { ?>
												<div class="control-group form-group" style="display:none">

													<div class="controls form-group">
													<h3 style="display: inline-block;">Campaign target location</h3><img data-toggle="tooltip" title="If you have more then one location you could create multiple campaigns and select which locations receive which campaign. Click the location in the left box to move it to the right box to activate the campaign for that location." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
														<div class="input-prepend input-append multi_sele_parent">
															<select name="group_tag[]" id="group_tag"
																	multiple="multiple" class="form-control">
																<?php

																$key_query = "SELECT tag_name,description FROM exp_mno_distributor_group_tag WHERE distributor = '$user_distributor'";
																$query_results = $db->selectDB($key_query);


																foreach ($query_results['data'] as $row) {
																	$tag_name = $row['tag_name'];
																	$description = $row['description'];


																	//check for edit//
																	$set2 = ' selected="selected"';


																	echo '<option value="' . $tag_name . '" ' . $set2 . '> ' . $tag_name . '</option>';
																}

																?>

															</select>
														</div>
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group form-group -->
											<?php } ?>



											<?php if ($package_functions->getSectionType("CAMP_CREATE_LOCATION", $system_package, $user_type) == "system_package") { ?>
												<div class="control-group form-group" style="display:none">

													<div class="controls form-group">
													<h3 style="display: inline-block;">Campaign target location</h3><img data-toggle="tooltip" title="If you have more then one location you could create multiple campaigns and select which locations receive which campaign. Click the location in the left box to move it to the right box to activate the campaign for that location." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
														<div class="input-prepend input-append multi_sele_parent">
															<select name="group_tag[]" id="group_tag"
																	required="required" class="form-control">
																<?php

																$key_query = "SELECT `product_name`,`product_code` FROM `admin_product` WHERE `user_type`='MVNO'";
																$query_results = $db->selectDB($key_query);


																foreach ($query_results['data'] as $row) {
																	$tag_name = $row['product_code'];
																	$description = $row['product_name'];


																	//check for edit//
																	$set2 = ' selected="selected"';


																	echo '<option value="' . $tag_name . '" ' . $set2 . '> ' . $description . '</option>';
																}

																?>

															</select>
														</div>
													</div>
													<!-- /controls -->
												</div>
												<!-- /control-group form-group -->
											<?php } ?>


											<!--			<div class="control-group form-group">
                                                            <label class="control-label" for="radiobtns">Top 10 APs</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">

                                                                    <input id="top10apy" name="top10ap" type="radio"> Yes&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input id="top10apn" name="top10ap" type="radio" checked="checked"> No (All APs)&nbsp;&nbsp;&nbsp;&nbsp;




                                                                </div>
                                                            </div>

                                                        </div>-->
											<!-- /control-group form-group -->

											<div id="isactive" class="control-group form-group">





<div class="controls">



	<h3 style="display: inline-block;">Active<img data-toggle="tooltip" title="Select the check box if you want this campaign to go live immediately. Alternatively use the manage section to activate this campaign at a later date." src="layout/ARRIS/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" "=""></h3>

	<div class="">



	<input id="is_active" name="is_active" type="checkbox" <?php if ($mg_is_active == 1) { ?> checked <?php } ?>/>
		<label for="is_active"></label>


	</div>
	<p><b></b></p>

</div>

<!-- /controls -->

</div>


											<div class="form-actions">
												<?php if (isset($edit_ad_id)) { ?>
													<button type="submit" name="campign_update" id="campign_update"
															class="btn btn-success">Update
													</button>&nbsp;&nbsp;
													<button type="button" name="preview_btn" id="preview_btn"
															onclick="preview_popup();" class="btn btn-inverse">Preview
													</button>&nbsp;
													<button type="button" name="campign_update_cancel"
															id="campign_update_cancel" class="btn btn-warning">Cancel
													</button>&nbsp;<strong><font color="#FF0000">*</font>
														<small> Required Fields</small>
													</strong><input type="hidden" name="submit_type" id="submit_type"
																	value="update"/><input type="hidden"
																						   name="edit_ad_id"
																						   id="edit_ad_id"
																						   value="<?php echo $edit_ad_id; ?>"/>

												<?php } else { ?>
													<button type="submit" name="campign_submit" id="campign_submit"
															class="btn btn-primary">Save
													</button>&nbsp;&nbsp;<!--<button type="button" name="preview_btn" id="preview_btn" onclick="preview_popup();" class="btn btn-inverse">Preview</button>&nbsp;<strong><font color="#FF0000">*</font><small> Required Fields</small></strong><input type="hidden" name="submit_type" id="submit_type" value="submit"/> -->
												<?php } ?>


											</div>
											<!-- /form-actions -->
										</fieldset>
										</div>
									</form>


                                    <div id="campcreate_response"></div>
                                    