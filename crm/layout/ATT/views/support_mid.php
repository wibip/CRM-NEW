
<script>
					        
					        $(document).ready(function() {
								Tablesaw.init();
                                $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;''></label>");
							});</script>
							<style>
							.support_table .tablesaw th, .support_table .tablesaw td {
								padding: .5em 5px;
							}
							</style>
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget ">
					

						<!-- /widget-header -->



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




			                              	<?php

									      		if(isset($_SESSION['msg1'])){

										   		echo $_SESSION['msg1'];

										   		unset($_SESSION['msg1']);





	  									    }?>

					<div <?php if(isset($tab16)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="create_camp">



						<h1 class="head">Support</h1>



						<p>If a customer needs support, please follow the steps below to login to the property and provide support.</p>

<p><b>Step 1.</b> IDENTIFY ACCOUNT NUMBER OR PROPERTY ID OR BUSINESS ID OR BUSINESS ACCOUNT NAME: Ask the customer for their Account Number or Property ID or Business ID or Business Account Name. The Business ID is 12 alphanumeric characters assigned to each Administrator. </p>

<p><b>Step 2.</b> FIND ACCOUNT NUMBER OR PROPERTY ID OR BUSINESS ID OR BUSINESS ACCOUNT NAME: Enter Account Number or Property ID or Business ID or Business Account Name in the text box below and click on "Search" button.</p>

<p><b>Step 3.</b> SIGN INTO THE BUSINESS ID ADMIN: Click on the "Sign In" link to login to the Business ID admin portal as an administrator.</p>

<p><b>Step 4.</b> IDENTIFY THE PROPERTY: If the customer has more than one property, ask them for the Account Number or Property ID for the property they need assistance with. Click on the "Sign In" link to login to the Property admin portal as an administrator to provide support.</p>

<br>
					<form method="post" class="form-horizontal">

						<div class="control-group">

                                                            <div class="controls col-lg-5 form-group">
					
					<input class="span4" type="text" id="icom" name="icom" >

				</div>
			</div>
					
					<script>
					        
					        $(document).ready(function() {
					                function checkSearchIcom(){
					                        var a =$('#icom').val();
					                        if(a.length<1){
					                        
					                                //$('#search_user').prop('disabled', true);
					                        }else{
					                        
					                                $('#search_user').prop('disabled', false);
					                        }
				                        }
				                        
				                        checkSearchIcom();
				                        
				                   $( "#icom" ).on('input',function() {
                                                          checkSearchIcom();
                                                        });
					        });
					</script>
					
					<!-- <p>Format: ABC0000000</p> -->

					<div class="form-actions" style="border-top: 1px !important;">
					
					<button type="submit" name="search_user" id="search_user" class="btn btn-primary" style="display: block">Search</button>
					
					</div>
					</form>
					
<br>
		<?php if($SUPPORT_SEARCH_RESULTS == '1'){ ?>

											<div class="widget widget-table action-table support_table" style="margin-bottom: 40px">
												<div class="widget-header">
													<!--  <i class="icon-th-list"></i> -->

													<h3 style="display: block !important">Results</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content support_table" id="product_tbl">


                                                    <div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" colspan="2">Business ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1" >Business Account Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"  colspan="2">Property Id</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" >Account Number</th>
																
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">ACCOUNT NAME</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">ACCOUNT ADDRESS</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Status</th>
															</tr>
														</thead>
														<tbody>
								
														<?php

															//	echo	$key_query = " SELECT id,product_code,description,time_gap,create_date,default_value FROM exp_products WHERE mno_id = '$user_distributor' ORDER BY description ";

														if($serch_details==1){

														
															$token_id= uniqid();
															$_SESSION['security_token'] = $token_id;

															$yy = 0;
															
																	$query_results=$db->selectDB($key_query12);
																	foreach ($query_results['data'] as $row) {
																		$icom = $row[verification_number];
																		$parent_id = $row[parent_id];
																		$distributor_name = $row[distributor_name];
																		$account_name = $row[user_name];
																		
																		$f_name = $row[full_name];
																		$a_role = $row[access_role];


																		if($row[is_enable]=='2'){
																			$is_enable = 'DORMANT';
																		}
																		else{
																			$is_enable = 'ACTIVE';
																		}


																		$string_pass = 'uname='.$account_name.'&fname='.$f_name.'&urole='.$a_role;
				
																		$encript_resetkey = $app->encrypt_decrypt('encrypt',$string_pass);

																		echo '<tr>
																		<td> '.$parent_id.' </td>
																		<td style=" border-left: 0px solid;"> <a style="align:center" href="support.php?log_other=1&key='.$encript_resetkey.'&security_token='.$token_id.'" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a> </td><td> '.$distributor_name.' </td><td><select data-id='.$yy.' onchange="change_val(this);">';


																		if(!isset($_POST['search_user']) || strlen($_POST['icom'])<1 || $search_by_name){


 																		$key_query122 = "SELECT a.distributor_name, b.full_name ,b.access_role ,a.verification_number ,a.property_id ,a.parent_id ,b.user_name , a.bussiness_address1 ,a.bussiness_address2 ,a.bussiness_address3
																			FROM `exp_mno_distributor` a,`admin_users` b
																			WHERE b.user_distributor=a.distributor_code AND b.verification_number IS NOT NULL
																			AND a.parent_id='".$parent_id."' AND a.mno_id='$user_distributor' ";

																		}


																		//$query_results1=mysql_query($key_query122);

																		$xx = 0;

																	$query_results1=$db->selectDB($key_query122);
																	foreach ($query_results1['data'] as $row1) {

																		$icom1 = $row1[verification_number];
																		$parent_id1 = $row1[parent_id];
																		$property_id1 = $row1[property_id];
																		$distributor_name1 = $row1[distributor_name];
																		$account_name1 = $row1[user_name];
																		$address1 = $row1[bussiness_address1];
																		$address2 = $row1[bussiness_address2];
																		$address3 = $row1[bussiness_address3];
																		
																		$f_name1 = $row1[full_name];
																		$a_role1 = $row1[access_role];
																		$distributor_name1=htmlentities($distributor_name1);
																		$property_id1=htmlentities($property_id1);

																		$string_pass1 = 'uname='.$account_name1.'&fname='.$f_name1.'&urole='.$a_role1;

																		$full_address=$address1.','.$address2.','.$address3;
																		$full_address=htmlentities($full_address);

																		$encript_resetkey1 = $app->encrypt_decrypt('encrypt',$string_pass1);

																		echo '<option data-link='.$encript_resetkey1.' data-name='.$distributor_name1.' data-address="'.trim($full_address,', ').'" value='.$icom1.'>'.$property_id1.' - '.$distributor_name1.'</option>';

																		if($xx == 0){
																			$first_ac_name = $distributor_name1;
																			$first_ac_address = $full_address;
																			$first_link = $encript_resetkey1;
                                                                            $icomm_first = $icom1;
																		}

																		$xx++;

																		
																	}



                                                                        echo '</select></td>
																		<td id="link'.$yy.'"  style=" border-left: 0px solid;"> <a style="align:center" href="support.php?log_other=1&key='.$first_link.'&security_token='.$token_id.'" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a> </td>
																		<td id="account_number'.$yy.'">'.$icomm_first.'</td>
																		<td id="ac_name'.$yy.'"> <span data-toggle="tooltip" title="'.$first_ac_name.'">'.$first_ac_name.'</span></td>
																		<td id="ac_address'.$yy.'"> <span data-toggle="tooltip" title="'.trim($first_ac_address,', ').'">'.trim($first_ac_address,', ').'</span></td>
																		<td > '.$is_enable.'</td>';

																		$yy++;
																		
																		}
																		

														}			
																	
														?>		
														</tbody>
														</table>

														<script type="text/javascript">
															$(document).ready(function(){
																$('[data-toggle="tooltip"]').tooltip();
															});
															function change_val(this1) {
																var count = $(this1).data('id');
																var link = '<a style="align:center" href="support.php?log_other=1&key='+$(this1).find(':selected').data('link')+'&security_token=<?php echo $token_id; ?>" class="btn btn-small btn-info"><i class="btn-icon-only icon-signin"></i>Sign In</a>';
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


											<div class="widget widget-table action-table support_table" style="margin-bottom: 40px">
												<div class="widget-header">
													<!--  <i class="icon-th-list"></i> -->

													<h3 style="display: block !important">Business ID</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content support_table" id="product_tbl">


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

</style>