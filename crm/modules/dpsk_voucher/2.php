										<!-- ******************* create camp ******************* -->
										<div class="tab-pane <?php echo isset($tab_acc_voucher) ? 'in active' : ''; ?>" id="acc_voucher">


											<?php if (isset($_GET['voucher_email'])) { //show send mail area 

												$voucher_message_q = $db->getEmailTemplate('VOUCHER_MAIL', $mno_package, $mno_id, $user_distributor);
												$voucher_message_title = $voucher_message_q[0]['title'];
												$voucher_message = $voucher_message_q[0]['text_details'];
											?>

												<h1 class="head"><span>Account Voucher Messaging Editor </span></h1>

												<form class="form-horizontal" method="POST" action="?t=acc_voucher">
													<?php

													echo '<input type="hidden" name="form_secret" id="form_secret" value="' . $_SESSION['FORM_SECRET'] . '" />';

													?>
													<fieldset>
														<label class="" for="radiobtns">
															<h6>TAG Description </h6>
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
														<a href="add_tenant.php?t=acc_voucher" class="btn btn-primary btn-info-iefix" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a>

													</fieldset>
												</form>
												<script>
													$(document).ready(function() {

														$("button[name='submit_voucher_new']").easyconfirm({
															locale: {
																title: 'Save Account Voucher Message',
																text: 'Are you sure you want to save this account voucher message?',
																button: ['Cancel', ' Confirm'],
																closeText: 'close'
															}
														});
														$("button[name='submit_voucher_new']").click(function() {});
													});
												</script>
											<?php } else { //show send mail area 
											?>

												<?php if ($dpsk_voucher_type == 'SHARED' || empty($dpsk_voucher_type)) { ?>
													<h1 class="head">New Account Voucher
														<!-- <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> -->
													</h1>

													<form autocomplete="nope" id="shared_voucher_form" name="shared_voucher_form" action="?t=acc_voucher" method="post" class="form-horizontal shared-voucher-form">



														<?php

														echo '<input type="hidden" name="form_secret" id="form_secret_1" value="' . $_SESSION['FORM_SECRET'] . '" />';

														?>

														<fieldset>



															<div class="control-group voucher-group">

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






															<!-- <div class="control-group"> -->
															<?php //if ($dpsk_enable) { 
															?>
															<!-- <div class="controls form-group">

																		<h2 class="head">New Account Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident must first connect to this Wi-Fi 
Network to self-register, create a personal Wi-Fi 
password and register all the MAC Addresses of 
their devices before being able to gain access to 
the Resident Wi-Fi Network. <br><br>
In addition, the resident must use a self-
registration voucher to allow them to initiate the 
registration process." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>


																		<label class="" for="radiobtns" style=" font-size: 20px; "> <b><?php //echo $onboard_ssid; 
																																		?></b></label>


																	</div>
																	
																	<br> -->
															<?php //} 
															?>

															<!-- <div class="controls form-group">
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
																</div> -->
															<!-- </div> -->
															<!-- /control-group -->



															<div id="response_d1"></div>



															<div class="control-group voucher-group">

																<div class="controls form-group">
																	<div style="width: 40%; position: relative;">
																		<label class="" for="radiobtns"> </label>


																		<input class="span4 form-control pass_msg" id="gen_voucher" placeholder="******" name="gen_voucher" type="password" autocomplete="nope" value="<?php echo $vtenant_model->getVoucher_code($user_distributor, 'SHARED'); ?>">
																		<i toggle="#gen_voucher" style="display:inline !important;margin-left: -25px; top: 5px !important;" class="paas_toogle btn-icon-only icon-eye-open toggle-voucher_gen" id="n_pass"></i>

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
																</div>
																<br>
																<br>
																<button id="vouche_ex" name="vouche_ex" class="btn btn-default" style="text-decoration:none;" onclick="return false;"> Generate New</button>
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








															<!-- /form-actions -->
														</fieldset>
													</form>


												<?php } else if ($dpsk_voucher_type == 'SINGLEUSE') { ?>

													<h1 class="head">Account Voucher
														<!-- <img data-toggle="tooltip" title="" src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"> -->
													</h1>

													<form autocomplete="nope" id="shared_voucher_form" name="shared_voucher_form" action="?t=acc_voucher" method="post" class="form-horizontal single-voucher-form">



														<?php

														echo '<input type="hidden" name="form_secret" id="form_secret_1" value="' . $_SESSION['FORM_SECRET'] . '" />';

														?>

														<fieldset>



															<div class="control-group voucher-group">

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



																	<p>

																		This property uses single use voucher for self service resident account creation. You may generate the vouchers below and download the list as a CSV file. A maximum of 2000 voucher codes can be generated at a time.

																	</p>

																</div>
																<!-- /controls -->

																<div class="controls form-group" style="position: relative;">



																	<div class="voucher-form voucher-details">
																		<div class="voucher-form-l">
																			<label class="" id="remining_count">Remaining Vouchers: </label>
																			<input type="hidden" id="remining_count_val" name="remining_count_val" value="">
																		</div>

																		<div class="voucher-form-r">
																			<button id="vouche_re_ex" name="vouche_re_ex" class="btn btn-primary" style="text-decoration:none" onclick="return false;"> Download Vouchers</button> <img data-toggle="tooltip" class="tooltips" title="Download the list of available vouchers as a CSV file." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 0px;cursor: pointer;">
																		</div>

																	</div>

																	<div class="voucher-form voucher-details">
																		<div class="voucher-form-l">
																			<label class="" style="display: inline-block;">Quantity </label> <input class="span2 form-control" id="voucher_count" name="voucher_count" type="number" autocomplete="nope" value="10" min="1" max="2001">

																		</div>

																		<div class="voucher-form-r">
																			<button id="vouche_ex" name="vouche_ex" class="btn btn-primary" style="text-decoration:none" onclick="return false;">Generate Vouchers</button> <img data-toggle="tooltip" class="tooltips" title='Enter the number of account vouchers needed to be generated and click the "Generate Vouchers" button.' src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 0px;cursor: pointer;">

																		</div>

																	</div>

																</div>



																<!-- /form-actions -->
														</fieldset>
													</form>


													<form autocomplete="nope" id="send_voucher_form" name="send_voucher_form" action="?t=acc_voucher" method="post" class="form-horizontal">


														<?php

														echo '<input type="hidden" name="form_secret" id="form_secret_2" value="' . $_SESSION['FORM_SECRET'] . '" />';

														?>

														<fieldset>




															<div class="control-group voucher-group">

																<div class="controls form-group">


																	<p>
																		You can email the vouchers directly to your residents. Enter the resident name, email address and send the voucher via email. You can customize the email content by going to Communicate with Residents >> Email Template tab.
																	</p>

																</div>
																<!-- /controls -->

																<div class="controls form-group voucher-mail-form" style="position: relative;">




																	<div class="voucher-form">
																		<div class="voucher-form-l send-v">
																			<label class="" for="radiobtns" id="remining_count_acc">Account Voucher</label>
																		</div>

																		<div class="voucher-form-r">
																			<label class="" for="radiobtns" id="send_voucher"></label>
																			<input type="hidden" id="send_voucher_id" name="send_voucher_id" />
																		</div>

																	</div>

																	<div class="voucher-form">
																		<div class="voucher-form-l send-v">
																			<label class="" for="radiobtns">Name</label>

																		</div>

																		<div class="voucher-form-r">
																			<input class="span4 form-control" id="voucher_name" name="voucher_name" type="text" autocomplete="nope">
																			<div id="name_error" style="display: inline-block;"></div>


																		</div>

																	</div>


																	<div class="voucher-form">
																		<div class="voucher-form-l send-v">
																			<label class="" for="radiobtns">Email Address</label>

																		</div>

																		<div class="voucher-form-r">
																			<input class="span4 form-control" id="voucher_email" name="voucher_email" type="text" autocomplete="nope">
																			<div id="email_error" style="display: inline-block;"></div>


																		</div>

																	</div>

																	<div class="voucher-form">
																		<div class="voucher-form-l send-v">
																			<!-- <label class="" for="radiobtns">Email Voucher</label> -->

																		</div>

																		<div class="voucher-form-r">
																			<!-- <a><i class="btn-icon-only icon-envelope"></i></a> -->
																			<button id="send_email" name="send_email" class="btn btn-primary" style="text-decoration:none" onclick="return false;"> Send Email</button>
																			<a href="?t=acc_voucher&voucher_email=send" class="btn btn-primary btn-info-iefix" style="text-decoration:none"> Edit template</a> <img data-toggle="tooltip" title="You can edit the standard message by editing template." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;">
																			<div id="voucher_loader" style="display: inline-block;"></div>
																			<!-- <img data-toggle="tooltip" class="tooltips" title="" src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 0px;cursor: pointer;"> -->

																		</div>

																	</div>



																</div>



															</div>
															<!-- /control-group -->



															<!-- <div class="control-group"> -->
															<?php //if ($dpsk_enable) { 
															?>
															<!-- 


																<div class="controls form-group">

																	<h2 class="head">New Account Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident must first connect to this Wi-Fi 
Network to self-register, create a personal Wi-Fi 
password and register all the MAC Addresses of 
thier devices before being able to gain access to 
the Resident Wi-Fi Network. <br><br>
In addition, the resident must use a self-
registration voucher to allow them to initiate the 
registration process." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>


																	<label class="" for="radiobtns"> <b><?php //echo $onboard_ssid; 
																										?></b></label>


																</div>
																
																<br> -->
															<?php //} 
															?>
															<!-- 
															<div class="controls form-group">
																<h2 class="head">Resident Wi-Fi Network<img data-toggle="tooltip" class="tooltips" title="The resident can only connect to this Wi-Fi
Network once they have self-registered. Once
they have a personal Wi-Fi password and have
registered the MAC Addresses of their devices,
they can connect and authenticate using their
unique password." src="layout/ATT/img/help.png" style="width: 28px;margin-bottom: 3px;cursor: pointer;"></h2>

																<label class="" for="radiobtns"><b><?php //echo $internet_ssid; 
																									?></b></label>


															</div>

															<div class="controls form-group" style="margin-top: 20px;">
																<a href="?t=acc_voucher&st=acc_voucher&action=sync_data_tab1&tocken=<?php //echo $secret; 
																																	?>" class="btn btn-primary mar-top" style="align: left;"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
															</div>

														</div> -->
															<!-- /control-group -->

															<div id="response_d1"></div>







															<!-- /form-actions -->
														</fieldset>
													</form>




													<div class="widget widget-table action-table" id="se_te">
														<form action="?t=acc_voucher" method="post" class="form-horizontal" enctype="multipart/form-data">
															<div class="widget-header">
																<i class="icon-th-list"></i>
																<h3>Search Results</h3>
															</div>
															<!-- /widget-header -->
															<div style="margin-bottom: 20px;" id="se_download">
																<div class="control-group">


																	<div class="controls se_ownload_cr">


																	</div>
																</div>
															</div>

															<br>
															<div class="widget-content table_response">

																<div class="controls col-lg-5 form-group" style="position: absolute;top: -36px;z-index: 1000;">
																	<a href="?t=acc_voucher&st=acc_voucher&action=sync_data_tab1&tocken=<?php echo $secret; ?>" class="btn btn-primary mar-top"><i class="btn-icon-only icon-refresh"></i> Refresh</a>
																</div>



																<div style="overflow-x:auto">

																	<style>
																		.dataTables_length {
																			padding: 5px;
																			float: right !important;
																		}

																		.dataTables_length label {
																			margin-bottom: 0px !important;
																		}

																		.dataTables_length select {
																			margin-left: 5px !important;
																			width: 80px !important;
																		}

																		#tenent_search_table th {
																			border-top: 1px solid #ddd !important;
																			background-color: #f4f4f4;
																		}


																		.dataTables_info {
																			margin-left: 10px;
																		}
																	</style>





																	<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="tenent_search_table">
																		<thead>
																			<tr>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>Voucher</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Name</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Email Address</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Registered Email Address</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>status</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>Voucher Date Issued</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10"><span>Voucher Date Used</span></th>
																				<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Delete

																				</th>


																			</tr>
																		</thead>
																		<tbody>

																			<?php



																			$key_query = "SELECT  * FROM `mdu_customer_voucher` WHERE `voucher_type` = 'SINGLEUSE' AND `distributor`='$user_distributor' AND ((`send_email` = 1 AND `status`= 1) OR `status` = 0 ) ";



																			$query_results = $db->selectDB($key_query);
																			foreach ($query_results['data'] as $row) {
																				$voucher_code = $row['voucher_code'];
																				$voucher_id = $row['id'];
																				$voucher_name = $row['name'];
																				$voucher_email = $row['email'];
																				$voucher_reg_email = $row['reg_email'];
																				$voucher_isses_date = $row['isses_date'];
																				$voucher_used_date = $row['used_date'];
																				$voucher_status = $row['status'];
																				$voucher_reg_username = $row['cutomer_user_name'];
																				$data_visible = 1;
																				if ($voucher_email == '') {
																					$voucher_email = 'N/A';
																				}

																				if ($voucher_reg_email == '') {
																					$voucher_reg_email = 'N/A';
																				} else {

																					$customer_q = "SELECT * FROM `mdu_vetenant` WHERE `username` = '$voucher_reg_username'";
																					$customer_re = $db->selectDB($customer_q);
																					if ($customer_re['rowCount'] < 1) {
																						$data_visible = 0;
																					}
																				}

																				if ($voucher_name == '') {
																					$voucher_name = 'N/A';
																				}

																				if ($voucher_used_date == '') {
																					$voucher_used_date = 'N/A';
																				}

																				if ($voucher_isses_date == '') {
																					$voucher_isses_date = 'N/A';
																				}



																				if ($voucher_status == 0) {
																					$voucher_status_val = "Registered";
																				} else {
																					$voucher_status_val = "Not Registered";
																				}


																				// if ($voucher_status == 0 && $voucher_reg_email == 'N/A' && $voucher_used_date == 'N/A') {

																				// }



																				if ($data_visible != 0) {



																					echo '<tr>
                           <td> ' . $voucher_code . ' </td>
                           <td> ' . $voucher_name . ' </td>
                           <td> ' . $voucher_email . ' </td>
                           <td> ' . $voucher_reg_email . ' </td>
                           <td> ' . $voucher_status_val . ' </td>
                           <td> ' . $voucher_isses_date . ' </td>
                           <td> ' . $voucher_used_date . ' </td>';

																					echo '<td class="td_btn" style="position: relative;">';
																					if ($voucher_status == 1) {
																						echo '
         <input type="checkbox" class="voucher_delete_id' . $voucher_id . '" name="voucher_delete_id[]"  value="' . $voucher_id . '" id="voucher_delete_idd' . $voucher_id . '">
         <input type="hidden" name="token"  value="' . $secret . '" id="token">

         <script type="text/javascript">
         $(".voucher_delete_id' . $voucher_id . '").click(function(){      
          if($(this).prop("checked") == true){
            $("#Delete_btn_voucher").attr("disabled", false); 
          }
                                        });
         
         </script>
         ';
																					}

																					echo '</td>';
																				}
																			}

																			?>





																		</tbody>
																	</table>



																</div>

																<br>
																<div align="right">
																	Select All &nbsp;&nbsp; <input type="checkbox" name="customer_delete_all" value="" id="customer_delete_all">


																	<button class="btn btn-info" type="submit" name="Delete_btn_voucher" id="Delete_btn_voucher" disabled>Delete</button>
																</div>
															</div>


															<script type="text/javascript">
																$(document).ready(function() {



																	$("#customer_delete_all").click(function() {
																		$('input[name="voucher_delete_id[]"]').prop('checked', this.checked);

																		if ($(this).prop("checked") == true) {
																			$('#Delete_btn_voucher').attr("disabled", false);
																		} else {
																			$('#Delete_btn_voucher').attr("disabled", true);
																		}
																	});

																	$("#Delete_btn_voucher").easyconfirm({
																		locale: {
																			title: 'Delete Voucher',
																			text: 'Are you sure you want to delete these Voucher?  ',
																			button: ['Cancel', ' Confirm'],
																			closeText: 'close'
																		}
																	});
																	$("#Delete_btn_voucher").click(function() {});






																});
															</script>
														</form>

													</div>


													<?php // $mno_id 
													$voucher_patten_data = $vtenant_model->getVouchers($mno_id, 'VOUCHER');
													$get_Vt = $vtenant_model->getDistributorVtenant($user_distributor);

													$tenant_compat_domain = $db->setVal('tenant_compat_domain', 'ADMIN');
													$tiny_url = $tenant_compat_domain . $get_Vt->getCompactLink();

													?>

													<script>
														$("#vouche_ex").click(function() {

															// var seperator = document.getElementById('pass_seperator').value;
															// var pass_min_length = document.getElementById('pass_min_length').value;
															// var pass_max_length = document.getElementById('pass_max_length').value;
															// var word_count = document.getElementById('pass_w_count').value;


															var voucher_count = parseInt(document.getElementById('voucher_count').value);
															var re_count = parseInt(document.getElementById('remining_count_val').value);

															if (voucher_count > 0 && voucher_count < 2001) {

																var new_count = re_count + voucher_count;

																document.getElementById('remining_count').innerHTML = '';
																document.getElementById('remining_count').innerHTML = 'Remaining Vouchers: ' + new_count;
																document.getElementById('remining_count_val').value = new_count;



																window.location = 'ajax/generater/keys_genCSV.php?csv_mid=<?php echo $mno_id; ?>&csv_mvid=<?php echo $user_distributor; ?>&csv_type=generat&generate=' + voucher_count;

															}


														});




														$("#vouche_re_ex").click(function() {

															window.location = 'ajax/generater/keys_genCSV.php?csv_mid=<?php echo $mno_id; ?>&csv_mvid=<?php echo $user_distributor; ?>&csv_type=remaining';




														});

														function getVoucherData() {

															<?php
															$re_count = $vtenant_model->getVoucher_reminingCount($user_distributor, 'SINGLEUSE');
															$getVoucher_uniq = $vtenant_model->getVoucher_uniq($user_distributor, 'SINGLEUSE');
															$voucher_code_n = $getVoucher_uniq['voucher_code'];
															$voucher_id_n = $getVoucher_uniq['id'];

															?>


															var re_count = "<?php echo $re_count; ?>";
															var voucher_code_n = "<?php echo $voucher_code_n; ?>";
															var voucher_id_n = "<?php echo $voucher_id_n; ?>";

															if (re_count != 0) {
																var voucher_lable = '<b>' + voucher_code_n + '</b>';
															} else {
																var voucher_lable = '<a href="#" onclick="voucher_refresh(); return false;"><i class=" btn-icon-only icon-refresh voucher_refresh" id="voucher_refresh" style="font-size: 22px;color: #000;"></i></a>';
															}



															document.getElementById('send_voucher_id').value = voucher_id_n;
															document.getElementById('send_voucher').innerHTML = voucher_lable;
															document.getElementById('remining_count').innerHTML = 'Remaining Vouchers: ' + re_count;
															document.getElementById('remining_count_val').value = re_count;

														}



														function voucher_refresh() {

															window.location = '?t=acc_voucher';

														};


														$("#send_email").click(function() {

															var send_voucher_id = document.getElementById('send_voucher_id').value;
															var email = document.getElementById('voucher_email').value;
															var name = document.getElementById('voucher_name').value;

															document.getElementById("email_error").innerHTML = "";
															document.getElementById("name_error").innerHTML = "";

															var email_val = "false";
															var name_val = "false";
															var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

															if (email.match(validRegex)) {
																var email_val = "true";
															} else {
																document.getElementById("email_error").innerHTML = "<small style= \"min-width: 240px;top: 0;\" data-bv-validator=\"greaterThan\" data-bv-validator-for=\"voucher_email\" class=\"help-block\"><p>This is not a valid email address.</p></small>";
															}

															if (name !== "") {
																var name_val = "true";
															} else {
																document.getElementById("name_error").innerHTML = "<small style= \"min-width: 240px;top: 0;\" data-bv-validator=\"greaterThan\" data-bv-validator-for=\"voucher_email\" class=\"help-block\"><p>This is a required field</p></small>";
															}


															if (email_val == "true" && name_val == "true" && send_voucher_id != '') {

																document.getElementById("send_email").disabled = true;
																document.getElementById("voucher_loader").innerHTML = "<img src=\"img/loading_ajax.gif\">";

																$.ajax({
																	type: 'POST',
																	url: 'ajax/generater/keys_genCSV.php',
																	data: {
																		csv_mid: "<?php echo $mno_id; ?>",
																		csv_mvid: "<?php echo $user_distributor; ?>",
																		csv_type: "send_email",
																		voucher_id: send_voucher_id,
																		email: email,
																		name: name,
																		onboarding_SSID: "<?php echo $onboard_ssid; ?>",
																		captive_portal: "<?php echo $tiny_url; ?>"

																	},
																	success: function(data) {

																		// alert(data);
																		// if (data == "success") {

																		// 	document.getElementById("msg_div").innerHTML = '<div class="alert alert-success">Email has been sent</div>';
																		// } else {
																		// 	document.getElementById("msg_div").innerHTML = '<div class="alert alert-danger">Email sending has failed</div>';

																		// }
																		// document.documentElement.scrollTop = 0;


																		document.getElementById("voucher_loader").innerHTML = "";
																		document.getElementById("send_email").disabled = false;
																		window.location = '?t=acc_voucher';

																	},
																	error: function() {

																	}

																});

															}

														});





														getVoucherData();
													</script>






												<?php } ?>
											<?php } ?>
										</div>