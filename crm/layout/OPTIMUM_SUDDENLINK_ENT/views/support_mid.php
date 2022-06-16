
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget ">
						<div class="widget-header">
							<i class="icon-wrench"></i>
							<h3>Account Search</h3>
						</div>

						<!-- /widget-header -->

			                              	<?php

									      		if(isset($_SESSION['msg1'])){

										   		echo $_SESSION['msg1'];

										   		unset($_SESSION['msg1']);





	  									    }?>


						<div class="widget-content">

							<div class="tabbable">

								<ul class="nav nav-tabs">

					

									<?php

										if($user_type == 'MNO'){

											?>


										<li <?php if(isset($tab16)){?>class="one_tab active" <?php } else{ echo 'class="one_tab"'; }?>><a href="#create_camp" data-toggle="tab">Search</a></li>
										
										
										<?php

										}

									?>

				

								</ul><br>

						<div class="tab-content">





					<div <?php if(isset($tab16)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="search">







					<p>If a customer needs support, please follow the steps below to login to the property and provide support.</p>

<p><b>Step 1.</b> IDENTIFY ACCOUNT NUMBER OR PROPERTY ID OR BUSINESS ID OR BUSINESS ACCOUNT NAME: Ask the customer for their Account Number or Property ID or Business ID or Business Account Name. The Business ID is 12 alphanumeric characters assigned to each Administrator. </p>

<p><b>Step 2.</b> FIND ACCOUNT NUMBER OR PROPERTY ID OR BUSINESS ID OR BUSINESS ACCOUNT NAME: Enter Account Number or Property ID or Business ID or Business Account Name in the text box below and click on "Search" button.</p>

<p><b>Step 3.</b> SIGN INTO THE BUSINESS ID ADMIN: Click on the "Sign In" link to login to the Business ID admin portal as an administrator.</p>

<p><b>Step 4.</b> IDENTIFY THE PROPERTY: If the customer has more than one property, ask them for the Account Number or Property ID for the property they need assistance with. Click on the "Sign In" link to login to the Property admin portal as an administrator to provide support.</p>


<br>
					<form method="post">
					
					<input class="span4" type="text" id="icom" name="icom"  >
					
					<script>
					        $(document).ready(function() {
						        $('#icom').keydown(function (e){

								    if(e.keyCode == 13){
								    	event.preventDefault ? event.preventDefault() : (event.returnValue = false);
								        var request = {listsize: $('#supportSearchTablePerpage').val(),type:'supportSearch',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',icom: $('#icom').val()}
                                        ajaxCall(request);
								    }
								})
						    });

					</script>
					
					<!-- <p>Format: ABC0000000</p> -->
					
					<button type="submit" name="search_user" id="search_user" class="btn btn-primary" style="display: block">Search</button>
					
					</form>
					<style type="text/css">
					
                                                        .paginate_img{
                                                            width: 100%;
                                                            bottom: 0;
                                                            text-align: center;
                                                            position: absolute;
                                                            background: #ffffff99;
                                                            display: none;
                                                            top:-40px;
                                                            z-index:55555;
                                                        }
														.cusPagination{
															-webkit-box-pack: end;
														    -webkit-justify-content: flex-end;
														    -ms-flex-pack: end;
														    justify-content: flex-end;
														    display: -ms-flexbox;
														    display: flex;
														    margin-top: 20px;
														    padding-left: 0;
														    list-style: none;
														    border-radius: .25rem;
														}

														.cusPagination a{
															min-width: 11px;
    														text-align: center;
															text-decoration: none;
														    -webkit-transition: all .2s linear;
														    -o-transition: all .2s linear;
														    transition: all .2s linear;
														    -webkit-border-radius: 0px !important;
														    border-radius: 0px !important;
														    position: relative;
														    display: block;
														    padding: .5rem .75rem;
														    margin-left: -1px;
														    line-height: 20px;
														    border-width: 0px;
														}
														.cusPagination a:hover{
															text-decoration: none;
															background-color: #eee;
														}

														.cusPagination .disabled a{
														    color: #6c757d;
														    pointer-events: none;
														    cursor: auto;
														    border-color: #dee2e6;
														}
														.cusPagination .disabled{
															pointer-events: none!important;
														}
														.cusPagination li{
															border: 1px solid #dee2e6;
    														margin-left: -1px;
														}
														.cusPagination li.pre{
															border-top-left-radius: 3px;
    														border-bottom-left-radius: 4px;
    														margin-left: 0px;
														}
														.cusPagination li.nxt{
															border-top-right-radius: 3px;
    														border-bottom-right-radius: 4px;
														}
                                                        .perpage{
                                                            position: absolute;
                                                            top: -37px;
															right: 170px;
															z-index: 2;
                                                        }
                                                        .perpage select{
                                                            margin-bottom: 0px
                                                        }
													</style>

<script>
						$(function () {
                            var request = {listsize: $('#supportSearchTablePerpage').val(),type:'supportSearch',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>'}
                            ajaxCall(request);
                        });

						$(document).on("click", "#search_user", function(){
																var request = {listsize: $('#supportSearchTablePerpage').val(),type:'supportSearch',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',icom: $('#icom').val()}
                                                                ajaxCall(request);
                                                            });
						$(document).on("change", "#supportSearchTablePerpage", function(){
																var request = {listsize: $('#supportSearchTablePerpage').val(),type:'supportSearch',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',icom: $('#icom').val()}
                                                                ajaxCall(request);
                                                            });
						$(document).on("click", "#supportSearchTable_paginate .cusPagination li:not(.disabled) a", function(e){
							e.preventDefault();
																var request = {listsize: $('#supportSearchTablePerpage').val(),type:'supportSearch',user_distributor:'<?php echo $user_distributor; ?>',user_type:'<?php echo $user_type; ?>',system_package:'<?php echo $system_package; ?>',icom: $('#icom').val(),nextPage: $(this).data('pagenum')}
                                                                ajaxCall(request);
                                                            });

						function ajaxCall(request){

            				var init_auth_data = CryptoJS.AES.encrypt(JSON.stringify(request), '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString();
            
                            $('#supportSearchTable_img').show();
							$('#search_user').attr('disabled', true);
                            $.post("ajax/locationAjax.php", {key: init_auth_data},
								function (data, textStatus, jqXHR) {
									var data_ar = JSON.parse(JSON.parse(CryptoJS.AES.decrypt(data, '<?php echo $data_secret; ?>', {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8)));
									setTable(data_ar);
									$('#supportSearchTable_img').hide();
									$('#search_user').attr('disabled', false);
								});
                        }

						function setTable(data){

                                var table = data.table;
                                var paginate = data.paginate;
                                $('#supportSearchTable tbody').html('');
                                $('#supportSearchTable tbody').append(table);
                                $('#supportSearchTable_paginate').html(paginate);
                                new Tablesaw.Table("#supportSearchTable").destroy();
                                Tablesaw.init();
								$('[data-toggle="tooltip"]').tooltip();
                                $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
                            
						}
					</script>




<br>
		<?php if($SUPPORT_SEARCH_RESULTS == '1'){ ?>

											<div class="widget widget-table action-table" style="margin-bottom: 40px">
												<div class="widget-header">
													<!--  <i class="icon-th-list"></i> -->
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="product_tbl">


                                                    <div style="overflow-x:auto;" >
													<div id="supportSearchTable_img" class="paginate_img"><img  src="img/loading_ajax.gif"></div>
                                                    <div class="perpage">
                                                        Per Page <select id="supportSearchTablePerpage">
                                                            <option>50</option>
                                                            <option>100</option>
                                                            <option>150</option>
                                                            <option>200</option>
                                                        <select>
                                                    </div>
													<table id="supportSearchTable" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" colspan="2">Business ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" >Business Account Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"  colspan="2">Property ID</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" >Account Number</th>
																
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Status</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">ACCOUNT NAME</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">ACCOUNT ADDRESS</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														</table>
														<div id="supportSearchTable_paginate"></div>
														<script type="text/javascript">
															function change_val(this1,token_id) {
																var count = $(this1).data('id');
																var link = '<a style="align:center" href="support.php?log_other=1&key='+$(this1).find(':selected').data('link')+'&security_token='+token_id+'" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a>';
																$('#link'+count).html(link);
																$('#ac_name'+count+' span').html($(this1).find(':selected').data('name')).attr("title",$(this1).find(':selected').data('name'));
																$('#ac_address'+count+' span').html($(this1).find(':selected').data('address')).attr("title",$(this1).find(':selected').data('address'));
																$('#account_number'+count).html($(this1).find(':selected').val());
															}
														</script>
                                                        </div>
												</div>
												<!-- /widget-content -->
											</div>

											<?php }else{ ?>


											<div class="widget widget-table action-table" style="margin-bottom: 40px">
												<div class="widget-header">
													<!--  <i class="icon-th-list"></i> -->

													<h3 style="display: block !important">Business ID</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="product_tbl">


                                                    <div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Business ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Business Account Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Admin Link</th>
															</tr>
														</thead>
														<tbody>
								
														<?php

															//	echo	$key_query = " SELECT id,product_code,description,time_gap,create_date,default_value FROM exp_products WHERE mno_id = '$user_distributor' ORDER BY description ";

														if($serch_details==1){

														
															$token_id= uniqid();
															$_SESSION['security_token'] = $token_id;
															
																	$query_results=$db->selectDB($key_query12);
																	foreach ($query_results['data'] as $row) {
																		$icom = $row[verification_number];
																		$parent_id = $row[parent_id];
																		$distributor_name = $row[distributor_name];
																		$account_name = $row[user_name];
																		
																		$f_name = $row[full_name];
																		$a_role = $row[access_role];


																		$string_pass = 'uname='.$account_name.'&fname='.$f_name.'&urole='.$a_role;
				
																		$encript_resetkey = $app->encrypt_decrypt('encrypt',$string_pass);

                                                                        echo '<tr>
																		<td> '.$parent_id.' </td>
																		<td> '.$distributor_name.' </td>
																		<td> <a style="align:center" href="support.php?log_other=1&key='.$encript_resetkey.'&security_token='.$token_id.'" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a> </td>';
																		
																		}
																		

														}			
																	
														?>		
														</tbody>
														</table>
                                                        </div>
												</div>
												<!-- /widget-content -->
											</div>
	<div class="widget widget-table action-table" style="margin-bottom: 40px">
												<div class="widget-header">
													<!--  <i class="icon-th-list"></i> -->

													<h3 style="display: block !important">Properties</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="product_tbl2">


                                                    <div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Property ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Account Number</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Account Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Account Address</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Admin Link</th>
															</tr>
														</thead>
														<tbody>
								
														<?php

															//	echo	$key_query = " SELECT id,product_code,description,time_gap,create_date,default_value FROM exp_products WHERE mno_id = '$user_distributor' ORDER BY description ";

														if($serch_details==1){

														
																	$query_results=$db->selectDB($key_query122);
																	foreach ($query_results['data'] as $row) {
																		$icom = $row[verification_number];
																		$parent_id = $row[parent_id];
																		$property_id = $row[property_id];
																		$distributor_name = $row[distributor_name];
																		$account_name = $row[user_name];
																		$address1 = $row[bussiness_address1];
																		$address2 = $row[bussiness_address2];
																		$address3 = $row[bussiness_address3];
																		
																		$f_name = $row[full_name];
																		$a_role = $row[access_role];

																		$full_address=$address1.",".$address2.",".$address3;

																		$string_pass = 'uname='.$account_name.'&fname='.$f_name.'&urole='.$a_role;
				
																		$encript_resetkey = $app->encrypt_decrypt('encrypt',$string_pass);

                                                                        echo '<tr>
																		<td> '.$property_id.' </td>
																		<td> '.$icom.' </td>
																		<td> '.$distributor_name.' </td>
																		<td> '.trim($full_address,', ').' </td>
																		<td> <a style="align:center" href="support.php?log_other=1&key='.$encript_resetkey.'&security_token='.$token_id.'" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a> </td>';
																		
																		}
																		

														}			
																	
														?>		
														</tbody>
														</table>
                                                        </div>
												</div>
												<!-- /widget-content -->
											</div>


											<?php } ?>



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

