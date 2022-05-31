<div class="tab-pane <?php echo isset($tab_group_message)?'in active':''; ?>" id="group_message">
							
							

<h1 class="head"><span>
    Group Messaging Editor </span>
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

														<?php 
														$mno_system_package=$db->getValueAsf("SELECT `system_package` AS f FROM `exp_mno` WHERE `mno_id`='$mno_id'");
														$gr_message_q = $db->getEmailTemplate('MDU_GROUP_MAIL',$mno_system_package,$mno_id,$user_distributor); 
														$gr_message_title = $gr_message_q[0]['title'];
                        								$gr_message = $gr_message_q[0]['text_details'];
														$voucher_message_q = $db->getEmailTemplate('VOUCHER_MAIL',$mno_system_package,$mno_id,$user_distributor); 
														
														$voucher_message_title = $voucher_message_q[0]['title'];
                        								$voucher_message = $voucher_message_q[0]['text_details'];
														?>

															<label class="" for="radiobtns"><h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;
															</label>


															<div class="">
																				
																<textarea width="100%;" id="group_message" name="group_message" class="group_message"><?php echo $gr_message; ?></textarea>
																
																<input type="hidden" name="group_title" value="<?php echo $gr_message_title; ?>">
																
															</div>
														<!-- </div>
													</div>	 -->	
									
																	
													<!-- <div class="form-actions">	 -->																	
									<br>
														<button type="submit" name="submit_group_new" class="btn btn-primary">Save</button>

													<!-- </div> -->
			
													<!-- /form-actions -->
												</fieldset>
											</form>
									<?php if($voucher_enable){ ?>
											<h1 class="head"><span>Account Voucher Messaging Editor </span></h1>

											<form class="form-horizontal" method="POST" action="?t=group_message">
											<?php
												
								echo '<input type="hidden" name="form_secret_g" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G'].'" />';
												
								?>
											<fieldset>
											<label class="" for="radiobtns"><h6>TAG Description </h6>
													User Full Name : {$user_full_name}&nbsp;&nbsp;|&nbsp;
													Account Voucher : {$voucher}&nbsp;&nbsp;|&nbsp;
													Onboarding SSID : {$onboarding_SSID}&nbsp;&nbsp;|&nbsp;
													URL for accessing resident portal : {$captive_portal}&nbsp;&nbsp;
											</label>

											<div class="">				
												<textarea width="100%;" id="voucher_message" name="voucher_message" class="group_message"><?php echo $voucher_message; ?></textarea>					
											</div>
											<br>
											<input type="hidden" name="voucher_title" value="<?php echo $voucher_message_title; ?>">
											<button type="submit" name="submit_voucher_new" class="btn btn-primary">Save</button>


											</fieldset>	
										</form>
										<?php } ?>

										<script>
								$(document).ready(function() {
									$("button[name='submit_group_new']").easyconfirm({locale: {
										title: 'Save Group Message',
										text: 'Are you sure you want to save this group message?',
										button: ['Cancel',' Confirm'],
										closeText: 'close'
										}});
									$("button[name='submit_group_new']").click(function() {
									});

									$("button[name='submit_voucher_new']").easyconfirm({locale: {
										title: 'Save Account Voucher Message',
										text: 'Are you sure you want to save this account voucher message?',
										button: ['Cancel',' Confirm'],
										closeText: 'close'
										}});
									$("button[name='submit_voucher_new']").click(function() {
									});
								});
								</script>
										</div>