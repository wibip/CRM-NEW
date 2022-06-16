<div class="tab-pane <?php echo isset($tab_individual_message)?'in active':''; ?>" id="individual_message">
									
										<?php if(isset($send_customer_mail_enable1)){ //show send mail area 
											?>         
                        
                        <h1 class="head"><span>
    Individual Message Editor <img data-toggle="tooltip" title="Please verify that the name in the greeting line is correct and add the description before posting." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>

					
						  
						  
						  
						  
  <form id="edit-profile" class="form-horizontal" method="POST">
								  
								  
								  <?php
								  
								  
								  $cust_query = "SELECT first_name,last_name,email,username FROM mdu_vetenant WHERE customer_id = '$mg_customer_id'";
								  
								  $query_results=$db->selectDB($cust_query);
								  foreach ($query_results['data'] as $row) {
									  $first_name = $row[first_name];
									  $last_name = $row[last_name];
									  $email = $row[email];
									  $username = $row[username];
									  
								  }
								  
								  
								  $secret=md5(uniqid(rand(), true));
								  $_SESSION['FORM_SECRET_G3'] = $secret;
												  
								  echo '<input type="hidden" name="form_secret_g3" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G3'].'" />';
								  echo '<input type="hidden" name="full_name" id="full_name" value="'.$first_name.' '.$last_name.'" />';
								  echo '<input type="hidden" name="email" id="email" value="'.$email.'" />';
								  echo '<input type="hidden" name="username" id="username" value="'.$username.'" />';
								  
								  $vars_aup = array(
										  '{$user_full_name}' => $first_name.' '.$last_name,
										  '{$user_email},'        => $email
								  
								  );
									  
								  $text_ind = $db->textVal('MDU_IND_MAIL',$distributercode);

							  
								  $message_full = strtr($text_ind, $vars_aup);
								  
								  ?>
								  
									  <fieldset>
													  
										  <div class="control-group">
														  
													  </div>
													  
													  
													  <textarea width="100%" id="aup_message" name="aup_message" class="group_message"><?php echo $message_full; ?></textarea>
																	  
																															  
								  <br>
														  <button type="submit" name="submit_ind" class="btn btn-primary"> Send</button>
			  												<a href="communicate.php" class="btn btn-primary btn-info-iefix" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a>
													  <!-- /form-actions -->
												  </fieldset>
											  </form>                        
						  
						  
						<?php }elseif(isset($_GET['group'])){ 
											?> 
											<h1 class="head"><span>
    Group Messaging Editor <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with all residents at a property. The message goes to the resident's email on record." src="layout/<?php echo $camp_layout; ?>/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1>


							
							
							
								<div id="toc_response"></div>
								<form id="edit-profile" class="form-horizontal" method="POST" action="?t=individual_message">
								
								
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
													User Full Name : {$user_full_name}&nbsp;&nbsp;
															</label>


															<div class="">
																				
																<textarea width="100%;" id="group_message" name="group_message" class="group_message"><?php echo $db->textVal('MDU_GROUP_MAIL',$distributercode); ?></textarea>
																
																
																
															</div>
														<!-- </div>
													</div>	 -->	
									
																	
													<!-- <div class="form-actions">	 -->																	
									<br>
														<button type="submit" name="submit_group" class="btn btn-primary" id="email_sa">Send</button>
														<a href="communicate.php" class="btn btn-primary btn-info-iefix" style="text-decoration:none"><i class="icon-white icon-chevron-left"></i> Go Back</a>
													<!-- </div> -->
			
													<!-- /form-actions -->
												</fieldset>
											</form>
					   <?php }else{?>    

						<h1 class="head"><span>
						Group Message <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with all of your registered residents." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1> 

<form id="edit-profile" action="?t=individual_message&group=send" method="post" class="form-horizontal">

<button type="submit" name="submit_send_group_editor" class="btn btn-primary">Send Group Message</button>
</form>

					   <h1 class="head"><span>
    Individual Message <img data-toggle="tooltip" title="You can use this feature to communicate via email directly with an individual resident. The message will be sent to the resident's email on record." src="layout/ATT/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;"></span>
</h1> 
							
<h3 style="margin-bottom: 20px;">Send customized individual messages to your registered residents.</h3>
							  
								  <div id="email_response"></div>
								  <form id="edit-profile" action="?type=im" method="post" class="form-horizontal middle" >
									 <?php 
									 
					  $secret4=md5(uniqid(rand(), true));
					  $_SESSION['FORM_SECRET4'] = $secret4;
									 
				  
																			  
								  echo '<input type="hidden" name="form_secret4" id="form_secret4" value="'.$_SESSION['FORM_SECRET4'].'" />';
												  
								  ?>
								  
									  <fieldset>
  
									  
													  
													  <div class="control-group" style="display: none;">
														 
														  <div class="controls">

														  	 <label class="" for="radiobtns">Limit Search to</label>
  

															  <div class="">
																  <select name="property_id" id="property_id" required>  
																  <option value="ALL">ALL Groups</option>
  
																  <?php
																  

																  $query_results = $db->get_property($user_distributor);
														  
																  foreach ($query_results as $row) {
																	  $property_number = $row[property_number];
																	  $property_id = $row[property_id];
																	  $org_name = $row[org_name];
																	  
																	  echo '<option value="'.$property_number.'">'.$property_id.'</option>';
																  }
																  
																  ?>
																  
																  
																  </select>
																  
																  
																  
															  </div>
														  </div>
														  <!-- /controls -->
													  </div>
													  <!-- /control-group -->
													  
																								  
													  
													  
													  <div class="control-group">
														 
														  <div class="controls">

														  	 <label class="" for="radiobtns">Search Residents <img data-toggle="tooltip" title=" Note: You can search using First Name, Last Name or Email Address." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"> </label>
  

															  <div class="">
																  <input type="text" name="search_word" id="search_word" >
																  <button class="btn" type="submit" name="search_btn2" id="search_btn2">Search</button>
																  <br />
																 														
																  
															  </div>
														  </div>
														  <!-- /controls -->
													  </div>
													  <!-- /control-group -->													
										  </fieldset>
									  </form>
											  

											 <?php if($record_found2==1){
  
											 $s_id = "SELECT `customer_list` FROM `mdu_search_id` WHERE id = '$search_id2'";
											 $rows=$db->select1DB($s_id);
											 $customer_list = $rows['customer_list'];
//											 $customer_list_array=explode(",",$customer_list);
//											 $customer_list_array_count=count($customer_list_array);
//											 $default_table_rows=$db->setVal('tbl_max_row_count','ADMIN');
//											 if($default_table_rows=="" || $default_table_rows=="0"){
//												 $default_table_rows=100;
//											 }
//											 $page_count=ceil($customer_list_array_count/$default_table_rows);
//
//											 if(isset($_GET['page_number'])){
//												 $page_number=$_GET['page_number'];
//											 }else{
//												 $page_number=1;
//											 }
//											 $start_row_count=($page_number*$default_table_rows)-$default_table_rows;
//											 $end_row_count=($page_number*$default_table_rows);
//											 $view_customer_list="";
//											 for($i=$start_row_count;$i<min($end_row_count,$customer_list_array_count);$i++) {
//												 $view_customer_list =$view_customer_list.",".$customer_list_array[$i];
//												 $last_row_number=$i;
//											 }
											 //  echo $view_customer_list;
											 $view_customer_list=ltrim($customer_list,",");
											 $view_customer_list=rtrim($customer_list,",");
//											 if($page_count!=1){
//											 ?>
<!--  -->
<!--  -->
<!--										  -->
<!--													  --><?php
//
//													  }
  
													  ?>
											  
											  <script type="text/javascript">
             $(document).ready(function(){

                                    var table = $('#tenent_search_table').DataTable({
                                        dom: 'Bfrtip',
                                       "pageLength": 50,
                                       "language": {
                                          "emptyTable": "No Results"
                                        }
                                        
                                     });

                                    

              });

          </script>
  
												  <div class="widget widget-table action-table">
													  
												  <div class="widget widget-table action-table">
												  <div class="widget-header">
													  <i class="icon-th-list"></i>
													  <h3>Search Results</h3>
												  </div>
												  <!-- /widget-header -->
												  <div class="widget-content">
												  <div>
													  <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap id="tenent_search_table">
														  <thead>
															  <tr>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>First Name</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Last Name</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>Email</span><i class="icon-sort "></i></th>
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Group / Realm</span></th>
  
																  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Action</th>
																  
																  
															  </tr>
														  </thead>
														  <tbody>
								  
					  <?php
  
								  
									 $key_query = "SELECT `username`,`customer_id`,`first_name`,`last_name`,`email`,`property_id`,`room_apt_no`,`first_login_date`
  FROM `mdu_vetenant` WHERE customer_id IN ($view_customer_list) ORDER BY first_name ASC";
					  
								  
  
								  $query_results=$db->selectDB($key_query);
								  foreach ($query_results['data'] as $row) {
									  $customer_id = $row['customer_id'];
									  $username = $row['username'];
									  $first_name = $row['first_name'];
									  $last_name = $row['last_name'];
									  $email = $row['email'];
									  $property_id = $row['property_id'];
									  $room_apt_no = $row['room_apt_no'];
  
									  $rrr = $db->selectDB("SELECT * FROM `mdu_aup_violation` WHERE username = '$username'");
									  $cunt = $rrr['rowCount'];
  
									  $total_warnings = $cunt;
									  
									  $get_property_id_get=$db->selectDB("SELECT property_id FROM `mdu_organizations` WHERE property_number='$property_id' LIMIT 1");
										  
									  foreach ($get_property_id_get['data'] as $rowe) {
										  $property_id_display = $rowe['property_id'];
									  }
																		  
									  echo '<tr>
									  <td> '.$first_name.' </td>
									  <td> '.$last_name.' </td>
									  <td> '.$email.' </td>
									  <td> '.$property_id_display.' </td>';
									  
									  //Send Message  <i class="btn-icon-only icon-envelope"></i>&nbsp;GO&nbsp;
									  echo '<td class="td_btn">';
									  echo ' <a id="C2MAIL_'.$customer_id.'"  class="btn btn-small btn-info td_btn_last">Create Message<i class="btn-icon-only icon-envelope"></i></a><script type="text/javascript">
  // --commented for data table plugin easy confirm click issue-- $(document).ready(function() {
  $(\'#C2MAIL_'.$customer_id.'\').easyconfirm({locale: {
		  title: \'Send Customer Message ['.$first_name.' '.$last_name.']\',
		  text: \'Are you sure you want to send a message to this customer?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
		  button: [\'Cancel\',\' Confirm\'],
		  closeText: \'close\'
		   }});
	  $(\'#C2MAIL_'.$customer_id.'\').click(function() {
	  	window.location = "?go=ind&token='.$secret4.'&search_id='.$search_id2.'&mg_customer_id='.$customer_id.'"
		  
	  });
	 // });
  </script></td></tr>';
  
  
  
  
  
									  
									  
								  }
  
					  ?>					
								  
								  
									
		  
								  
								  </tbody>
						  </table>
						  
  
		  <div id="datatable_response" style="display: none;"></div>
  
						  </div>
													  <script type="text/javascript">
														/*   $(function(){
															  $('#tenent_search_table').tablesorter();
														  }); */
													  </script>
					   </div></div> </div>
					   <?php } else if($record_found2==0) {echo ''; } ?>   
					   
					   
						<?php }  ?>  
					   
  
								<script>
								$(document).ready(function() {
									$("button[name='submit_group']").easyconfirm({locale: {
										title: 'Send Group Message',
										text: 'Are you sure you want to send this group message?',
										button: ['Cancel',' Confirm'],
										closeText: 'close'
										}});
									$("button[name='submit_group']").click(function() {
									});
								});
								</script>			
											                        
                                  </div>