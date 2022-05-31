<div class="tab-pane <?php echo isset($tab_group_message)?'in active':''; ?>" id="group_message">
							
							

<h1 class="head"><span>
    Group Messaging Editor <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with all residents at a property. The message goes to the resident's email on record." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>


							
							
							
								<div id="toc_response"></div>
								<form id="edit-profile" class="form-horizontal" method="POST" action="?t=group_message">
								
								
								<?php
								
								$secret=md5(uniqid(rand(), true));
								$_SESSION['FORM_SECRET_G'] = $secret;
												
								echo '<input type="hidden" name="form_secret_g" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G'].'" />';
												
								?>
								
									<fieldset>
													
													
													
										<div class="control-group" style="display: none;">
														
														<div class="controls">

															<label class="" for="radiobtns">Group / Realm</label>


															<div class="">
																<select name="property_id" id="property_id" onchange="f_change()" required>
																

																<?php
																

																$query_results = $db->get_property($user_distributor);
														
																$property_number = $query_results[0][property_number];
																	$property_id = $query_results[0][property_id];
																	$org_name = $query_results[0][org_name];
																	
																	echo '<option value="'.$property_number.'">'.$org_name.'</option>';
																//}
																
																?>
																
																</select>
																
																
																
															</div>
														</div>
														<!-- /controls -->
													</div>
													<!-- /control-group -->	

										<!-- <div class="control-group">
														
														<div class="controls" style=""> -->

															<label class="" for="radiobtns"><h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Portal Short Name : {$short_name}&nbsp;&nbsp;
															</label>


															<div class="">
																				
																<textarea width="100%;" id="group_message" name="group_message" class="group_message"><?php echo $db->textVal('MDU_GROUP_MAIL',$distributercode); ?></textarea>
																
																
																
															</div>
														<!-- </div>
													</div>	 -->	
									
																	
													<!-- <div class="form-actions">	 -->																	
									<br>
														<button type="submit" name="submit_group" class="btn btn-primary" id="email_sa" disabled>Send</button>

													<!-- </div> -->
			
													<!-- /form-actions -->
												</fieldset>
											</form>





										</div>