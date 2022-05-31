<?php
											
												   /* if(isset($_SESSION['msg1'])){
													   echo $_SESSION['msg1'];
													   unset($_SESSION['msg1']);


													  }
													  
													  if(isset($_SESSION['msg2'])){
													  	echo $_SESSION['msg2'];
													  	unset($_SESSION['msg2']);
													  
													  
													  } */
													
											      ?>
<style>
.password-strength-main {
    width: 48%  ;
	
	}
@media (max-width: 768px) {
   .password-strength-main{
	width: 80% ;
	
	}
}
</style>
						<div class="widget-header">
							<i class="icon-book"></i>
							<h3>Update My Profile</h3>
						</div>
							<!-- /widget-header -->

						<div class="widget-content">

							<div class="tabbable">

<ul class="nav nav-tabs">

									<li <?php if($tab == '1'){ echo 'class="active"'; } ?> ><a href="#live_camp" data-toggle="tab">My Profile</a></li>
									<li <?php if($tab == '2'){ echo 'class="active"'; } ?> ><a href="#live_camp2" data-toggle="tab">Change Password</a></li>

								</ul>

								<br>



									 <?php 

										$profile_inner = 'layout/'.$camp_layout.'/views/profile_inner.php';

									    include_once $profile_inner;
									
									  
									 ?>

								<div class="tab-content">

										<?php

										$secret=md5(uniqid(rand(), true));
										$_SESSION['FORM_SECRET'] = $secret;



										?>

									<div class="tab-pane <?php if($tab == '1'){ echo 'active'; } ?>" id="live_camp">
									
									
										<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg1'])){
													   echo $_SESSION['msg1'];
													   unset($_SESSION['msg1']);


													  }
													  
											      ?>
											  	</div>
									
									
										<form  class="form-horizontal"	action="profile.php?t=1" method="POST" id="profile_form">

										
										
											  	
										
										

											<fieldset>

												<h2 align="center" style="padding: 50px;">Update My Profile</h2>
											
											  	<?php echo '<input type="hidden" name="form_secret1" id="form_secret1_1" value="'.$_SESSION['FORM_SECRET'].'" />'; ?>

												<div id="fb_response"></div>
												<?php if($activation_method=="number"){?>
												<div class="control-group">
													<label class="control-label" for="radiobtns">Customer Account Number</label>

													<div class="controls form-group">
														

														<?php
														$query_a = "SELECT `verification_number` AS f FROM admin_users WHERE user_distributor = '$user_distributor' AND `verification_number` IS NOT NULL";
														//$query_a = "SELECT `verification_number` AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="verification_number" name="verification_number" type="text" value="<?php echo $db->getValueAsf($query_a); ?>" readonly >

														
													</div>
												</div>
												<?php } ?>
												<div class="control-group">
													<label class="control-label" for="radiobtns">User Name</label>

													<div class="controls form-group">
														

														<?php
														$query_a = "SELECT user_name AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="username" name="username" type="text" value="<?php echo $db->getValueAsf($query_a); ?>" readonly>

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Profile Name</label>

													<div class="controls form-group">
														
														<?php
														$query_b = "SELECT full_name AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="full_name" name="full_name" value="<?php echo $db->getValueAsf($query_b); ?>" type="text" maxlength="23">

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Email Address</label>

													<div class="controls form-group">
														
														<?php
														$query_c = "SELECT email AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="email" name="email" value="<?php echo $db->getValueAsf($query_c); ?>" type="text">

														
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Phone Number </label>

													<div class="controls form-group">
														
														<?php
														$query_d = "SELECT mobile AS f FROM admin_users WHERE user_name = '$login_user_name'";

														?>

														<input class="span4 form-controls" id="mobile" name="mobile" type="text" placeholder="xxx-xxx-xxxx" maxlength="12" value="<?php echo $db->getValueAsf($query_d); ?>">

														
													</div>
												</div>
												
												                                    <script type="text/javascript">

                                        $(document).ready(function() {

                                            $('#mobile').focus(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });

                                            $('#mobile').keyup(function(){
                                                $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'));
                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });

                                            $("#mobile").keydown(function (e) {


                                                var mac = $('#mobile').val();
                                                var len = mac.length + 1;
                                                //console.log(e.keyCode);
                                                //console.log('len '+ len);

                                                if((e.keyCode == 8 && len == 8) ||(e.keyCode == 8 && len == 4)){
                                                    mac1 = mac.replace(/[^0-9]/g, '');


                                                    //var valu = mac1.substr(0, 3) + '-' + mac1.substr(3,3) + '-' + mac1.substr(6,4);

                                                    //console.log(valu);
                                                    //$('#phone_num_val').val(valu);

                                                }
                                                else{

                                                    if(len == 4){
                                                        $('#mobile').val(function() {
                                                            return $(this).val().substr(0, 3) + '-' + $(this).val().substr(3,3);
                                                            //console.log('mac1 ' + mac);

                                                        });
                                                    }
                                                    else if(len == 8 ){
                                                        $('#mobile').val(function() {
                                                            return $(this).val().substr(0,7) + '-' + $(this).val().substr(7,4);
                                                            //console.log('mac2 ' + mac);

                                                        });
                                                    }
                                                }

												//alert(e.keyCode);
                                                // Allow: backspace, delete, tab, escape, enter, '-' and .
                                                if ($.inArray(e.keyCode, [8, 9, 27, 13]) !== -1 ||
                                                            // Allow: Ctrl+A, Command+A
                                                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+C, Command+C
                                                        (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+x, Command+x
                                                        (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: Ctrl+V, Command+V
                                                        (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                                            // Allow: home, end, left, right, down, up
                                                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    // let it happen, don't do anything
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();

                                                }

                                                $('#profile_form').data('bootstrapValidator').updateStatus('mobile', 'NOT_VALIDATED').validateField('mobile');
                                            });



											$('#full_name').keyup(function(e){

												ck_topval1();

											});

											$('#email').keyup(function(e){

												ck_topval1();

											});

											$('#mobile').keyup(function(e){

												ck_topval1();

											});


                                            
											document.getElementById("submit1").disabled = true;

                                        });



										function ck_topval1(){

											var pname=document.getElementById('full_name').value;
											var pemail=document.getElementById('email').value;
											var pemob=document.getElementById('mobile').value;


											if(pname==''||pemail==''||pemob==''){
												document.getElementById("submit1").disabled = true;

												}else{
													document.getElementById("submit1").disabled = false;

													}



											}

                                        

                                        </script>
												
												

												<div class="form-actions">
													<input type="submit" name="submit1" id="submit1" class="btn btn-primary" value="Update">
												</div>
											</fieldset>

										</form>

										

									</div>


									<div class="tab-pane <?php if($tab == '2'){ echo 'active'; } ?> " id="live_camp2">
									
									
										<div id="response_d3">
											
											  	</div>


									<form id="edit-profile" class="form-horizontal"	action="profile.php?t=2" method="POST">

	<?php
												  
													  
												  if(isset($_SESSION['msg2'])){
													  echo $_SESSION['msg2'];
													  unset($_SESSION['msg2']);
												  
												  
												  }
											  ?>

											<fieldset>
		 										<h2 align="center" style="padding: 50px;">Change My Password</h2>
		 										

												<?php echo '<input type="hidden" name="form_secret2" id="form_secret2" value="'.$_SESSION['FORM_SECRET'].'" />'; ?>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Current Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="current_password" name="current_password" type="password"  required="required">

														</div>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">New Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="new_password" name="new_password" type="password" onkeyup="strbar()" required>
															<!-- <meter max="4" id="password-strength-meter" ></meter>
															<p id="password-strength-text"></p> -->
															<!-- <script>


														function strbar(){

															var strength = {
																	0: "Worst ",
																	1: "Bad ",
																	2: "Weak ",
																	3: "Good ",
																	4: "Strong "
																}

															var password = document.getElementById('new_password');
															var meter = document.getElementById('password-strength-meter');
															var text = document.getElementById('password-strength-text');

															var val = document.getElementById('new_password').value;
															var result = zxcvbn(val);

															// Update the password strength meter
															//meter.value = result.score;

															//document.getElementById("password-strength-meter").value = result.score;

															document.getElementById("password-strength-meter").setAttribute("value", result.score);

															// Update the text indicator
															if(val !== "") {
																text.innerHTML = "Strength: " + "<strong>" + strength[result.score] + "</strong>";
															}
															else {
																text.innerHTML = "";
															}

															
															
															}

																
															</script> -->
														</div>
													</div>
													<div class="controls form-group pass_str">
										
										<p > <span id="pass_type">This password is indicator</span></p>
										
									   

										<div id="meter_wrapper" class="password-strength-main">
<div id="meter" style="height: 7px;"></div>
</div>

									<script>
									$(document).ready(function(){
														 $("#new_password").keyup(function(){
													  check_pass();
													 });
													});
									</script>

										

										</div>
												</div>

												<script>
												


														

												function check_pass()
												{
												 var val=document.getElementById("new_password").value;
												 var meter=document.getElementById("meter");
												 var no=0;
												 if(val!="")
												 {
												  // If the password length is less than or equal to 6
												  if(val.length<=6)no=1;
												
												  // If the password length is greater than 6 and contain any lowercase alphabet or any number or any special character
												  if(val.length>6 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))no=2;
												
												  // If the password length is greater than 6 and contain alphabet,number,special character respectively
												  if(val.length>6 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))no=3;
												
												  // If the password length is greater than 6 and must contain alphabets,numbers and special characters
												  if(val.length>6 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))no=4;
												
												  if(no==1)
												  {
												   $("#meter").animate({width:'25%'},300);
												   meter.style.backgroundColor="red";
												   document.getElementById("pass_type").innerHTML="This password is very weak";
												  }
												
												  if(no==2)
												  {
												   $("#meter").animate({width:'50%'},300);
												   meter.style.backgroundColor="yellow";
												   document.getElementById("pass_type").innerHTML="This password is weak";
												  }
												
												  if(no==3)
												  {
												   $("#meter").animate({width:'75%'},300);
												   meter.style.backgroundColor="orange";
												   document.getElementById("pass_type").innerHTML="This password is medium";
												  }
												
												  if(no==4)
												  {
													$("#meter").animate({width:'100%'},300); 
												   meter.style.backgroundColor="green";
												   document.getElementById("pass_type").innerHTML="This password is strong";
												  }
												 }
												
												 else
												 {
													$("#meter").animate({width:'100%'},300); 
												   meter.style.backgroundColor="rgba(0, 0, 0, 0.1)";
												  document.getElementById("pass_type").innerHTML="This password is indicator"; 
												 }
												}
												
												
												
																									
												
												
																									</script>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Confirm New Password</label>

													<div class="controls">
														<div class="input-prepend input-append">

														<input class="span4" id="confirm_password" name="confirm_password" type="password"  required="required">

														</div>
													</div>
												</div>

<script>
function test(){

        $('div.error-wrapper').remove();
        $('input,select').removeClass("error");

}

$(document).ready(function() {


	$('#current_password, #new_password, #confirm_password').keyup(function(e){

		ck_topval2();

	});

    
	document.getElementById("pwsubmit").disabled = true;


	
});


function ck_topval2(){

	var opw=document.getElementById('current_password').value;
	var npw=document.getElementById('new_password').value;
	var cnpw=document.getElementById('confirm_password').value;


	if(opw==''||npw==''||cnpw==''){
		document.getElementById("pwsubmit").disabled = true;

		}else{
			document.getElementById("pwsubmit").disabled = false;

			}



	}

</script>


												<div class="form-actions">
													<input type="submit" id="pwsubmit" name="submit" onclick="test()" class="btn btn-primary" value="Change">
												</div>
											</fieldset>

										</form>

									</div>


								</div>
								</div>


								</div>
					