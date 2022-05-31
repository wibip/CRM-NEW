										<!-- ******************* create camp ******************* -->
										<div class="tab-pane <?php echo isset($tab_acc_voucher) ? 'in active' : ''; ?>" id="acc_voucher">




											<?php if ($dpsk_voucher_type == 'SHARED' || empty($dpsk_voucher_type)) { ?>
												<h1 class="head">New Account Voucher
													<!-- <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> -->
												</h1>

												<form autocomplete="nope" id="shared_voucher_form" name="shared_voucher_form" action="?t=acc_voucher" method="post" class="form-horizontal">



													<?php

													echo '<input type="hidden" name="form_secret" id="form_secret_1" value="' . $_SESSION['FORM_SECRET'] . '" />';

													?>

													<fieldset>



														<div class="control-group">

															<div class="controls form-group">

																<h2 class="head">Account Voucher<img data-toggle="tooltip" class="tooltips" title="This property uses a shared voucher for
self-service account creation. The residents must
enter this voucher during the account creation
process. <br><br> You may choose to change this voucher periodically
to mitigate non-resident account creation." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 0px;cursor: pointer;"></h2>
																<br>
																<h4><b>To change account voucher you can either: </b></h4>

																<!-- <label class="" for="radiobtns">Registration Voucher: <?php //echo $onboard_ssid_pass; 
																															?></label>	 -->

																<p>

																	-Manually enter a new voucher (The voucher code must have a minimum of 1 character and a maximum of 32) and click the "Update" button.
																	<br><b>OR</b><br>
																	-Auto generate a new voucher by clicking the "Generate New" followed by the "Update" button.

																</p>

															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->






														<div class="control-group">
															<?php if ($dpsk_enable) { ?>
																<div class="controls form-group">

																	<h2 class="head">New Account Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident must first connect to this Wi-Fi 
Network to self-register, create a personal Wi-Fi 
password and register all the MAC Addresses of 
their devices before being able to gain access to 
the Resident Wi-Fi Network. <br><br>
In addition, the resident must use a self-
registration voucher to allow them to initiate the 
registration process." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>


																	<label class="" for="radiobtns" style=" font-size: 20px; "> <b><?php echo $onboard_ssid; ?></b></label>


																</div>
																<!-- /controls -->
																<br>
															<?php } ?>

															<div class="controls form-group">
																<h2 class="head">Resident Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident can only connect to this Wi-Fi
Network once they have self-registered. Once
they have a personal Wi-Fi password and have
registered the MAC Addresses of their devices,
they can connect and authenticate using their
unique password." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>

																<label class="" for="radiobtns" style=" font-size: 20px; "><b><?php echo $internet_ssid; ?></b></label>


															</div>

															<div class="controls form-group" style="margin-top: 20px;">
																<a href="?t=acc_voucher&st=acc_voucher&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
															</div>
														</div>
														<!-- /control-group -->



														<div id="response_d1"></div>



														<div class="control-group">

															<div class="controls form-group" style="position: relative;">

																<label class="" for="radiobtns"> </label>


																<input class="span4 form-control pass_msg" id="gen_voucher" placeholder="******" name="gen_voucher" type="password" autocomplete="nope" value="<?php echo $vtenant_model->getVoucher_code($user_distributor, 'SHARED'); ?>">
																<i toggle="#gen_voucher" style="display:inline !important;margin-left: -25px; top: 10px !important;" class="paas_toogle btn-icon-only icon-eye-open toggle-voucher_gen" id="n_pass"></i>

																<script type="text/javascript">
																	$(".toggle-voucher_gen").click(function() {

																		$(this).toggleClass("icon-eye-close");
																		var input = $($(this).attr("toggle"));
																		if (input.attr("type") == "password") {
																			//	$('#password').attr('type', 'text');
																			input.attr("type", "text");
																		} else {
																			input.attr("type", "password");
																		}
																	});
																</script>


															</div>
															<br>
															<br>
															<button id="vouche_ex" name="vouche_ex" class="btn btn-default" style="text-decoration:none;margin-left: 48px;" onclick="return false;"> Generate New</button>
															<button type="submit" name="shared_voucher_submit" id="shared_voucher_submit" class="btn btn-primary">Update</button>



															<!-- /controls -->


														</div>
														<!-- /control-group -->

														<?php // $mno_id 
														$voucher_patten_data = $vtenant_model->getVouchers($mno_id, 'VOUCHER');

														if (empty($voucher_patten_data->min_length)) {
															$voucher_patten_data = $vtenant_model->getVouchers('ADMIN', 'VOUCHER');
														}

														?>

														<script>
															$("#vouche_ex").click(function() {

																// var seperator = document.getElementById('pass_seperator').value;
																// var pass_min_length = document.getElementById('pass_min_length').value;
																// var pass_max_length = document.getElementById('pass_max_length').value;
																// var word_count = document.getElementById('pass_w_count').value;

																var seperator = "<?php echo $voucher_patten_data->seperator; ?>";
																var pass_min_length = "<?php echo $voucher_patten_data->min_length; ?>";
																var pass_max_length = "<?php echo $voucher_patten_data->max_length; ?>";
																var word_count = "<?php echo $voucher_patten_data->word_count; ?>";




																$.ajax({
																	type: 'POST',
																	url: 'ajax/generater/keys_gen.php',
																	data: {
																		seperator: seperator,
																		pass_min_length: pass_min_length,
																		pass_max_length: pass_max_length,
																		word_count: word_count,
																		generate_count: '1'
																	},
																	success: function(data) {

																		//alert(data); 
																		document.getElementById('gen_voucher').value = data;
																		var bootstrapValidator = $('#shared_voucher_form').data('bootstrapValidator');
																		bootstrapValidator.enableFieldValidators('gen_voucher', true);

																	},
																	error: function() {

																	}

																});


															});
														</script>







														<div class="form-actions">


														</div>


														<!-- /form-actions -->
													</fieldset>
												</form>


											<?php } else if ($dpsk_voucher_type == 'SINGLEUSE') { ?>

												<h1 class="head">Account Voucher
													<!-- <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> -->
												</h1>

												<form autocomplete="nope" id="shared_voucher_form" name="shared_voucher_form" action="?t=acc_voucher" method="post" class="form-horizontal">



													<?php

													echo '<input type="hidden" name="form_secret" id="form_secret_1" value="' . $_SESSION['FORM_SECRET'] . '" />';

													?>

													<fieldset>



														<div class="control-group">

															<div class="controls form-group">

																<h2 class="head">Account Voucher<img data-toggle="tooltip" class="tooltips" title="This property uses single-use voucher for
self-service resident account creation. The
residents must enter this voucher during the
account creation process. <br><br>
If you need more than 2,000 vouchers, then you
may generate multiple files. Each voucher expires
after one use." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 0px;cursor: pointer;"></h2>
																<br>
																<h4><b>To generate a Account Voucher List in CSV Format:</b></h4>

																<!-- <label class="" for="radiobtns">Registration Voucher: <?php //echo $onboard_ssid_pass; 
																															?></label>	 -->

																<p>

																	-Simply select the number of vouchers required (maximum in 2,000),
																	then click the "Generate New List" button. The list will automatically
																	start to download to your device.

																</p>

															</div>
															<!-- /controls -->
														</div>
														<!-- /control-group -->


														<div class="control-group">

															<?php if ($dpsk_enable) { ?>



																<div class="controls form-group">

																	<h2 class="head">New Account Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident must first connect to this Wi-Fi 
Network to self-register, create a personal Wi-Fi 
password and register all the MAC Addresses of 
thier devices before being able to gain access to 
the Resident Wi-Fi Network. <br><br>
In addition, the resident must use a self-
registration voucher to allow them to initiate the 
registration process." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>


																	<label class="" for="radiobtns"> <b><?php echo $onboard_ssid; ?></b></label>


																</div>
																<!-- /controls -->

															<?php } ?>

															<div class="controls form-group">
																<h2 class="head">Resident Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident can only connect to this Wi-Fi
Network once they have self-registered. Once
they have a personal Wi-Fi password and have
registered the MAC Addresses of their devices,
they can connect and authenticate using their
unique password." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>

																<label class="" for="radiobtns"><b><?php echo $internet_ssid; ?></b></label>


															</div>
															<!-- /controls -->

															<div class="controls form-group" style="margin-top: 20px;">
																<a href="?t=acc_voucher&st=acc_voucher&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
															</div>


														</div>
														<!-- /control-group -->

														<div id="response_d1"></div>



														<div class="control-group">

															<div class="controls form-group" style="position: relative;">

																<label class="" for="radiobtns"> </label>


																<input class="span2 form-control" id="voucher_count" name="voucher_count" type="number" autocomplete="nope" value="10" min="1" max="2500">





															</div>
															<!-- /controls -->
															<br>
															<br>

															<button id="vouche_ex" style="text-decoration:none;margin-left: 48px;" name="vouche_ex" class="btn btn-primary" style="text-decoration:none" onclick="return false;"> Generate New List</button>


														</div>
														<!-- /control-group -->

														<?php // $mno_id 
														$voucher_patten_data = $vtenant_model->getVouchers($mno_id, 'VOUCHER');

														?>

														<script>
															$("#vouche_ex").click(function() {

																// var seperator = document.getElementById('pass_seperator').value;
																// var pass_min_length = document.getElementById('pass_min_length').value;
																// var pass_max_length = document.getElementById('pass_max_length').value;
																// var word_count = document.getElementById('pass_w_count').value;

																var voucher_count = document.getElementById('voucher_count').value;

																window.location = 'ajax/generater/keys_genCSV.php?csv_mid=<?php echo $mno_id; ?>&csv_mvid=<?php echo $user_distributor; ?>&generate=' + voucher_count;




															});
														</script>




														<div class="control-group">


														</div>
														<!-- /control-group -->

														<div class="form-actions">


														</div>


														<!-- /form-actions -->
													</fieldset>
												</form>

											<?php } ?>
										</div>