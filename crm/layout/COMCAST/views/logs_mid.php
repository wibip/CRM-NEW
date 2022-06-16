
<div class="main">

		<div class="main-inner">

			<div class="container">

				<div class="row">

					<div class="span12">

						<div class="widget ">

							<div class="widget-header">
								<!-- <i class="icon-warning-sign"></i> -->
								<h3>Logs</h3>
							</div>
							<!-- /widget-header -->

							<div class="widget-content">

								<div class="tabbable">
									<ul class="nav nav-tabs">
										<!-- <li class="active"><a href="#error_logs" data-toggle="tab">Error Logs</a></li> -->



										<?php
											if ($user_type == 'MVNE' || $user_type == 'MVNO') {
										?>
											<li <?php if(isset($tab2)){?>class="active" <?php }?>><a href="#access_logs" data-toggle="tab">Access Logs</a></li>
										<?php } ?>

										<?php
											if ($user_type == 'MVNE' || $user_type == 'MVNO') {
										?>
											<li <?php if(isset($tab1)){?>class="active" <?php }?>><a href="#error_logs" data-toggle="tab">Error Logs</a></li>
										<?php } ?>




										<?php
											if ($user_type == 'ADMIN') {
										?>
											<!-- <li <?php if(isset($tab4)){?>class="active" <?php }?>><a href="#redirection_log" data-toggle="tab">Redirection Logs</a></li>
											<li <?php if(isset($tab10)){?>class="active" <?php }?>><a href="#user_act" data-toggle="tab">AP/SSID API Logs</a></li>
											<li <?php if(isset($tab5)){?>class="active" <?php }?>><a href="#session_profile_logs" data-toggle="tab">Session API Logs</a></li>
											<li <?php if(isset($tab6)){?>class="active" <?php }?>><a href="#aaa_profile" data-toggle="tab">AAA API Logs</a></li>
											<li <?php if(isset($tab8)){?>class="active" <?php }?>><a href="#dsf_api" data-toggle="tab">DSF API Logs</a></li>
											<li <?php if(isset($tab7)){?>class="active" <?php }?>><a href="#purge_logs" data-toggle="tab">Purge Logs</a></li> -->
											
										<?php } ?>

										<?php
											if ($user_type == 'MNO' || $user_type=="SALES") {
										?>
										<li <?php if(isset($tab3)){?>class="one_tab active" <?php } else{ echo 'class="one_tab"'; }?>><a href="#user_activity_logs" data-toggle="tab">User Activity Logs</a></li>

										<?php }
										else{ ?>

										<li <?php if(isset($tab3)){?>class="active" <?php }?>><a href="#user_activity_logs" data-toggle="tab">User Activity Logs</a></li>
										<li <?php if(isset($tab11)){?>class="active" <?php }?>><a href="#auth_logs" data-toggle="tab">Auth Logs</a></li>

										<?php } ?>
									</ul>

								</div>


								<div class="tab-content">
									<!-- /* +++++++++++++++++++++++++++++++ Exp SESSION API Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab5)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="session_profile_logs">
										
										<br>
										<form id="session_log" name="session_log" method="post" class="form-horizontal" action="?t=5">
											<fieldset>

												<div id="response_d3">
													<?php
													if(isset($_SESSION['msg5'])){
														echo $_SESSION['msg5'];
														unset($_SESSION['msg5']);


													}
													?>
												</div>
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$secret.'" />';
												?>

												<div class="control-group">
													<label class="control-label" for="ssid">Function Name</label>
													<div class="controls form-group">
														<select class="span2 form-control" id="ses_fun_name" name="ses_fun_name">
																	<option value="">All</option>
																	<option value="Session Search"> Session Search </option>
																	<option value="Session Start"> Session Start </option>
																	<option value="Session Delete"> Session Delete </option>
														</select>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="limit">Limit</label>
													<div class="controls form-group">
                                                    <?php 
													if(!isset($ses_limit)){
														$ses_limit=50;
														}
													 ?>
														<?php echo '<input class="span2 form-control limit_log" id="ses_limit" name="ses_limit" value="'.$ses_limit.'"  type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                        
                                                        <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#ses_limit').tooltip(); 
                                                                     

                                                                });
</script>
													</div>
												</div>


												<div class="control-group">
													<label class="control-label" for="radiobtns">Period</label>

													<div class="controls form-group">
														

															<input class="span2 form-control" id="ses_start_date" name="ses_start_date"
																   type="text" value="<?php echo $ses_time_start_date; ?>" placeholder="mm/dd/yyyy">
															to
															<input class="span2 form-control" id="ses_end_date" name="ses_end_date" type="text"
															value="<?php echo $ses_time_end_date; ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="ses_date" />

														
													</div>
													<!-- /controls -->
												</div>

												<div class="form-actions">
													<button type="submit" name="session_log_submit" id="session_log_submit" class="btn btn-primary">GO</button>
												</div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
												$row_count = mysql_num_rows($session_query_results);
												if ($row_count>0) {
													?>
													<h3>Session API Logs
													<?php
												}else{
													?>
													<h3>Session API Logs
													<?php
												}
												?>
											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
													<tr>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">REALM/MAC</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function Name</th>
													<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">API URL</th> -->
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API LOG</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Status</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>

													</tr>
													</thead>
													<tbody>
													<?php
													while($row=mysql_fetch_array($session_query_results)){
                                                        $ses_cr_date = $row['create_date'];
                                                        $dt2 = new DateTime($ses_cr_date);
                                                        $ses_cr_date = $dt2->format('m/d/Y h:i:s A');

														echo "<tr>";
														//echo "<td>".$row['id']."</td>";
														echo "<td>";
														$mac_f = $row['mac'];
														if(strlen($mac_f)>0){
															echo $mac_f;
														}else{
														echo $row['realm'];
														}
														echo "</td>";
														echo "<td>".$row['function_name']."</td>";
														echo "<td><a href=\"ajax/log_view.php?ses_log_id=".$row['id']."\" target='_blank'> View </a></td>";
														echo "<td>".$row['api_status']."</td>";
														echo "<td>".$ses_cr_date."</td>";
														echo "</tr>";
													}
													?>

													</tbody>
												</table>
											</div>
											</div>
										</div>

									</div>

                                    <!-- /* +++++++++++++++++++++++++++++++ DSF API Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab8)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="dsf_api">

										<br>
										<form id="dsf_api_log" name="dsf_api_log" method="post" class="form-horizontal" action="?t=8">
											<fieldset>

												<div id="response_d8">
													<?php
													if(isset($_SESSION['msg8'])){
														echo $_SESSION['msg8'];
														unset($_SESSION['msg8']);


													}
													?>
												</div>
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$secret.'" />';
												?>

												<div class="control-group">
													<label class="control-label" for="ssid">Function Name</label>
													<div class="controls form-group">
														<select class="span2 form-control" id="dsf_api_name" name="dsf_api_name">
																	<option value="">All</option>
																	<option <?php echo $dsf_api_fun_name=='getClientAndSessions'?'selected':'' ?> value="getClientAndSessions"> Get Client And Sessions </option>
																	<option <?php echo $dsf_api_fun_name=='getBandwidthTrend'?'selected':'' ?> value="getBandwidthTrend"> Get Bandwidth Trend </option>
																	<option <?php echo $dsf_api_fun_name=='getSPDeviceTypes'?'selected':'' ?> value="getSPDeviceTypes"> Get SP Device Types </option>
														</select>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="limit">Limit</label>
													<div class="controls form-group">
                                                    <?php
													if(!isset($dsf_api_limit)){
														$dsf_api_limit=50;
														}
													 ?>
														<?php echo '<input class="span2 form-control limit_log" id="dsf_api_limit" name="dsf_api_limit" value="'.$dsf_api_limit.'"  type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>

                                                        <script type="text/javascript">
                                                            $(document).ready(function() {
                                                                     $('#dsf_api_limit').tooltip();
                                                                });
                                                        </script>
													</div>
												</div>


												<div class="control-group">
													<label class="control-label" for="radiobtns">Period</label>

													<div class="controls form-group">


															<input class="span2 form-control" id="dsf_api_start_date" name="dsf_api_start_date"
																   type="text" value="<?php echo $dsf_api_time_start_date; ?>" placeholder="mm/dd/yyyy">
															to
															<input class="span2 form-control" id="dsf_api_end_date" name="dsf_api_end_date" type="text"
															value="<?php echo $dsf_api_time_end_date; ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="dsf_api_date" />


													</div>
													<!-- /controls -->
												</div>

												<div class="form-actions">
													<button type="submit" name="dsf_api_log_submit" id="dsf_api_log_submit" class="btn btn-primary">GO</button>
												</div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
												$row_count = mysql_num_rows($dsf_api_query_results);
												if ($row_count>0) {
													?>
													<h3>DSF API Logs
													<?php
												}else{
													?>
													<h3>DSF API Logs
													<?php
												}
												?>
											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
													<tr>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function Name</th>
													<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">API URL</th> -->
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API LOG</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Status</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>

													</tr>
													</thead>
													<tbody>
													<?php
													while($row=mysql_fetch_array($dsf_api_query_results)){
                                                        $dsf_api_cr_date = $row['create_date'];
                                                        $dt2 = new DateTime($dsf_api_cr_date);
                                                        $dsf_api_cr_date = $dt2->format('m/d/Y h:i:s A');

														echo "<tr>";
														//echo "<td>".$row['id']."</td>";
														echo "<td>".$row['function_name']."</td>";
														echo "<td><a href=\"ajax/log_view.php?dsf_api_log_id=".$row['id']."\" target='_blank'> View </a></td>";
														echo "<td>".$row['api_status']."</td>";
														echo "<td>".$dsf_api_cr_date."</td>";
														echo "</tr>";
													}
													?>

													</tbody>
												</table>
											</div>
											</div>
										</div>

									</div>
									<!-- /* +++++++++++++++++++++++++++++++ Exp AAA API Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab6)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="aaa_profile">
										
										<br>
										<form id="aaa_log" name="aaa_log" method="post" class="form-horizontal" action="?t=6">
											<fieldset>

												<div id="response_d3">
													<?php
													if(isset($_SESSION['msg5'])){
														echo $_SESSION['msg5'];
														unset($_SESSION['msg5']);


													}
													?>
												</div>
												<?php
												echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$secret.'" />';
												?>

												<div class="control-group">
													<label class="control-label" for="ssid">Function Name</label>
													<div class="controls form-group">
														<select class="span2 form-control" id="aaa_fun_name" name="aaa_fun_name">
															<option value="">All</option>
															<option value="checkAccount"> Check Account </option>
															<option value="updateAccount"> Update Account </option>
															<option value="createAccount"> Create Account </option>
															<option value="deleteAccount"> Delete Account </option>
														</select>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="limit">Limit</label>
                                                    
                                                    <?php 
														
														if(!isset($aaa_limit)){
															$aaa_limit=50;
															}
														
														?>
													<div class="controls form-group">
														<?php echo '<input class="span2 form-control limit_log" id="aaa_limit" name="aaa_limit" value="'.$aaa_limit.'"  type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                        
                                                        <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#aaa_limit').tooltip(); 
                                                            

                                                                });
</script>
													</div>
												</div>

											<div class="control-group">
													<label class="control-label" for="realm">Realm</label>
													<div class="controls form-group">
														<?php echo '<input class="span2 form-control" id="aaa_realm" name="aaa_realm" value="'.$aaa_realm.'"  type="text">' ?>
													</div>
												</div>

												<div class="control-group">
													<label class="control-label" for="radiobtns">Period</label>

													<div class="controls form-group">
														

															<input class="span2 form-control" id="aaa_start_date" name="aaa_start_date"
																   type="text"  value="<?php echo $aaa_time_start_date; ?>" placeholder="mm/dd/yyyy">
															to
															<input class="span2 form-control" id="aaa_end_date" name="aaa_end_date" type="text"
															value="<?php echo $aaa_time_end_date; ?>" placeholder="mm/dd/yyyy">

															<input type="hidden" name="aaa_log_date" />

													</div>
													<!-- /controls -->
												</div>

												<div class="form-actions">
													<button type="submit" name="aaa_log_submit" id="aaa_log_submit" class="btn btn-primary">GO</button>
												</div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
												$row_count = mysql_num_rows($aaa_query_results);
												if ($row_count>0) {
													?>
													<h3>AAA API Logs
													<?php
												}else{
													?>
													<h3>AAA API Logs
													<?php
												}
												?>
											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
													<tr>
													<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">ID </th>  -->
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Realm</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Username</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API log</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Status</th>
														<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>
														<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">API URL</th> -->

													</tr>
													</thead>
													<tbody>
													<?php
													while($row=mysql_fetch_array($aaa_query_results)){
                                                        $aaa_cr_date = $row['create_date'];
                                                        $dt2 = new DateTime($aaa_cr_date);
                                                        $aaa_cr_date = $dt2->format('m/d/Y h:i:s A');
														echo "<tr>";
														//echo "<td>".$row['id']."</td>";
														echo "<td>".$row['group_id']."</td>";
														echo "<td>".$row['username']."</td>";
														echo "<td>".$row['function_name']."</td>";
														echo "<td><a href=\"ajax/log_view.php?aaa_log_id=".$row['id']."\" target='_blank'> View </a></td>";
														echo "<td>".$row['api_status']."</td>";
														echo "<td>".$aaa_cr_date."</td>";
														echo "</tr>";
													}
													?>

													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>


									<!-- /* +++++++++++++++++++++++++++++++ Exp Error Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab1)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="error_logs">
										<br>
										<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=1">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg1'])){
													   echo $_SESSION['msg1'];
													   unset($_SESSION['msg1']);


													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="error_lg" id="error_lg" value="error_lg" />

													<div class="control-group">
														<label class="control-label" for="ssid">SSID</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="ssid" name="ssid" value="'.$ssid.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="mac">MAC</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="mac" name="mac" value="'.$mac.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="email">E-mail</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="email" name="email" value="'.$email.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit">Limit</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit" name="limit" value="'.$limit.'"  type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="span2 form-control" id="start_date" name="start_date"
																	type="text" value="<?php if(isset($mg_start_date)){echo $mg_start;} ?>" placeholder="mm/dd/yyyy">
																	to
																	<input class="span2 form-control" id="end_date" name="end_date" type="text"
																	 value="<?php if(isset($mg_end_date)){echo $mg_end;} ?>" placeholder="mm/dd/yyyy">
																	  
																	 <input type="hidden" name="error_date" />
															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													$row_count = mysql_num_rows($result_error_lgs);
													if ($row_count>0) {
												?>
													<h3>Error Logs - <small> <?php echo $row_count; ?> Result(s)</small></h3>
												<?php
													}else{
												?>
													<h3>Error Logs - <small> 0 Result(s)</small></h3>
												<?php
													}
												 ?>
											</div>
											<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered">
													<thead>
														<tr>
															<th>SSID</th>
															<th>MAC</th>
															<th>E-mail</th>
															<th>Error Description</th>
															<th>Error Comment</th>
															<th>Error Time</th>
														</tr>
													</thead>
													<tbody>
														<?php
														while($row=mysql_fetch_array($result_error_lgs)){
                                                            $er_cr_date = $row['create_date'];
                                                            $dt2 = new DateTime($er_cr_date);
                                                            $er_cr_date = $dt2->format('m/d/Y h:i:s A');
															echo "<tr>";
															echo "<td>".$row[ssid]."</td>";
															echo "<td>".$row[mac]."</td>";
															echo "<td>".$row[email]."</td>";
															echo "<td>".$row[description]."</td>";
															echo "<td>".$row[error_details]."</td>";
															echo "<td>".$er_cr_date."</td>";
															echo "</tr>";
														}
														 ?>

													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>

									<!-- /* ++++++++++++++++++++++++++++++++++++++ Exp Access Logs +++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="access_logs">
										<br>
										<form id="error_log2" name="error_log2" method="post" class="form-horizontal" action="?t=2">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg2'])){
													   echo $_SESSION['msg2'];
													   unset($_SESSION['msg2']);


													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="access_lg" id="access_lg" value="access_lg" />

													<div class="control-group">
														<label class="control-label" for="ssid2">SSID</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="ssid2" name="ssid2" value="'.$ssid2.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="mac2">MAC</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="mac2" name="mac2" value="'.$mac2.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="email_2">E-mail</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="email_2" name="email_2" value="'.$email_2.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit2">Limit</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit2" name="limit2" value="'.$limit2.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="span2 form-control" id="start_date2" name="start_date2"
																	type="text" value="<?php if(isset($mg_start_date2)){echo $mg_start2;} ?>" placeholder="mm/dd/yyyy">
																	 to
																	<input class="span2 form-control" id="end_date2" name="end_date2" type="text"
																	 value="<?php if(isset($mg_end_date2)){echo $mg_end2;} ?>" placeholder="mm/dd/yyyy">
																	  
																	 <input type="hidden" name="error_date2" />
															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>


											</fieldset>
										</form>

	                                    <div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
												//echo $query_2;
													$row_count2 = mysql_num_rows($query_results2);
													if ($row_count2>0) {
												?>
													<h3>Access Logs - <small> <?php echo $row_count2; ?> Result(s)</small></h3>
												<?php
													}else{
												?>
													<h3>Access Logs - <small> 0 Result(s)</small></h3>
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table  class="table table-bordered">
													<thead>
														<tr>
															<th width="10px">#</th>
															<th>SSID</th>
															<th>MAC</th>
															<th>E-mail</th>
															<th>Description</th>
															<th>Access Details</th>
															<th>Date</th>


														</tr>
													</thead>
													<tbody>

													<?php


                                                    $color_var = 1;
                                                    $get_val = 0;
                                                    $step = 0;
													while($row=mysql_fetch_array($query_results2)){

														$ssid = $row[ssid];
														$mac = $row[mac];
														$email = $row[email];
														$description = $row[description];
														$access_details = $row[access_details];
														$create_date = $row[create_date];
														$token_id = $row[token_id];


                                                        $dt2 = new DateTime($create_date);
                                                        $create_date = $dt2->format('m/d/Y h:i:s A');

                                                        if($color_var == 1 && $get_val == 0){
                                                            $temp = $token_id;
                                                            $get_val = $get_val+1;
                                                        }

                                                        if($temp != $token_id){
                                                            $color_var = $color_var+1;
                                                            $temp = $token_id;
                                                            $step = 0;
                                                        }

                                                        $step = $step+1;

                                                        echo '<tr';
                                                            if ($color_var % 2 == 0) {
                                                                echo ' bgcolor="#e0eeee"';
                                                            }else{
                                                                echo ' bgcolor="#fffac9"';
                                                            }
                                                        echo '>';

														echo '<td> '.$step.' </td>
														<td> '.$ssid.' </td>
														<td> '.$mac.' </td>
														<td> '.$email.' </td>
														<td> '.$description.' </td>
														<td> <input type="text" class="invisibletb" value="'.$access_details.'" readonly/> </td>
														<td> '.$create_date.' </td>';

                                                        //$token_id.'<br>'.$access_details

													}

													?>
													<style type="text/css">
												.invisibletb{
												 border:none;
												 width:100%;
												 height:100%;
												 cursor: text !important;
												}
												</style>


													</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>

									
									<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab7)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="purge_logs">
										<br>
										<form id="activity_log" name="purgr_logs" method="post" class="form-horizontal" action="?t=7">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg7'])){
													   echo $_SESSION['msg7'];
													   unset($_SESSION['msg7']);


													  }
													  
													  
													  
													  $query_purge11 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'DB' GROUP BY `type`";
													  	
													  $query_results11_mod=mysql_query($query_purge11);
													  while($row1=mysql_fetch_array($query_results1_mod)){
													  	$last_run_days1 = $row1[last_run_days];
													  }
													  
													  
													  
													  
													  $query_purge2 = "SELECT `last_run_days` FROM admin_purge_logs where `type` = 'archive_db' GROUP BY `type`";
													  
													  $query_results2_mod=mysql_query($query_purge2);
													  while($row2=mysql_fetch_array($query_results2_mod)){
													  	$last_run_days2 = $row2[last_run_days];
													  }


													  $log_older_days=$db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='DB'");
												$archive_log_days=$db->getValueAsf("SELECT `frequencies` AS f FROM admin_purge_logs WHERE `type`='archive_db'");

													  
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />


													<h2>Archive DB logs</h2><br>
											<div class="control-group">
														<label class="control-label" for="limit3">Logs Older Than</label>
														<div class="controls">
															<?php echo '<input class="span2" id="log_older_days" name="log_older_days" value="'.$log_older_days.'" type="number" min="3" max="365" required step="1" >' ?> Days
														</div>
													</div>
													
													<h2>Permanently remove archived logs</h2><br>
													<div class="control-group">
														<label class="control-label" for="limit3">Archive Logs Older Than</label>
														<div class="controls">
															<?php echo '<input class="span2" id="archive_log_days" name="archive_log_days" value="'.$archive_log_days.'" type="number" min="3" max="365" required step="1">' ?> Days
														</div>
													</div>


													<h2>Archive directory</h2><br>
													<div class="control-group">
														<label class="control-label">Directory Path</label>
														<div class="controls">
															<?php echo '<input class="span2" id="archive_log_path" name="archive_log_path" type="text" required value="'.$archive_path.'">' ; ?>
															<small><font color="red">Folder permission should be granted</font></small>
														</div>
													</div>



													<div class="form-actions">
														<button type="submit" name="purge_now" id="purge_now" class="btn btn-primary">Save</button>
	                                                </div>

											</fieldset>
										</form>
										


										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												
													<h3>Archive Information</h3>
												
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered">
													<thead>
														<tr>
															<th>Logs</th>
															<!-- <th>DB usage (Estimated)</th> -->
															<th>Last archived date</th>


														</tr>
													</thead>
													<tbody>

													<?php
													
													$base_purge_query = "SELECT * FROM `admin_purge_logs` WHERE is_enable=1";
													$query_results0 = mysql_query($base_purge_query);

													$fsize = 0;
													while($row=mysql_fetch_array($query_results0)){
																		
														$log_name = $row[log_name];
														$last_run = $row[last_run];
                                                        $dt2 = new DateTime($last_run);
                                                        $last_run = $dt2->format('m/d/Y h:i:s A');
														$table_name = $row[system_table_name];
														$date_column = $row[date_column];
														$last_run_days = $row[last_run_days];
														
														
													 	$log_purge_q ="SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 2) `size`
														FROM information_schema.TABLES
														WHERE table_schema = '$db_name' AND table_name = '$table_name'";
														$query_results111 = mysql_query($log_purge_q);
															
														while($row2=mysql_fetch_array($query_results111)){
														
															$size = $row2[size];
															$fsize = $fsize + $size;
														}
													
														echo '<tr>
														<td> '.$log_name.' </td>';
														//echo '<td> '.$size.' MB </td>';
														echo '<td> '.$last_run.' </td>
														</tr>';
														
													
													}
													
													
													
												

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>


									<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab3)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="user_activity_logs">
										<br>
										<form id="activity_log1" name="activity_log" method="post" class="form-horizontal" action="?t=3">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg2'])){
													   echo $_SESSION['msg2'];
													   unset($_SESSION['msg2']);


													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="activity_lg" id="activity_lg" value="activity_lg" />

													<div class="control-group ">
														<div class="controls form-group">
														<label class="" for="name">User</label>
															
																<select class="span2 form-control" name="name" id="name" value=<?php echo $name ?>>
																	<option value="-1"> All </option>
																	<?php
																	$user_select_qu = "SELECT user_name FROM `admin_users` WHERE `user_distributor` = '$user_distributor'";
																	$user_select_re = mysql_query($user_select_qu);
																	while($row_user = mysql_fetch_array($user_select_re)){
																		if ($row_user[user_name] == $name) {
																			echo "<option value='".$row_user[user_name]."' selected> ".$row_user[user_name]." </option>";
																		} else {
																			echo "<option value='".$row_user[user_name]."'> ".$row_user[user_name]." </option>";
																		}

																	}
																	 ?>
																</select>
															

														</div>
													</div>

													<div class="control-group ">
														
                                                        <?php 
														
														if(!isset($limit3)){
															$limit3=50;
															}
														
														?>
                                                      
														<div class="controls form-group">
															<label class="" for="limit3">Limit</label>
															<?php echo '<input class="span2 form-control limit_log" id="limit3" name="limit3" value="'.$limit3.'" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                            
                                                              <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#limit3').tooltip(); 
                                                            

                                                                });
</script>
														</div>
													</div>

													<div class="control-group">
														

														<div class="controls form-group">
															<label class="" for="radiobtns">Period</label>

																<input class="inline_error inline_error_1 span2 form-control" id="start_date3" name="start_date3"
																	type="text" value="<?php if(isset($mg_start_date3)){echo $mg_start3;} ?>" placeholder="mm/dd/yyyy">
																	to
																	<input class="inline_error inline_error_1 span2 form-control" id="end_date3" name="end_date3" type="text"
																	 value="<?php if(isset($mg_end_date3)){echo $mg_end3;} ?>" placeholder="mm/dd/yyyy">

																	 <input type="hidden" name="date3" />

															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													 $row_count33 = mysql_num_rows($query_results1);
													if ($row_count33>0) {
												?>
													<h3>User Activity Logs
												<?php
													}else{
												?>
													<h3>User Activity Logs
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th	scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">User Name</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Module Name</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Task</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Reference</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">IP</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


														</tr>
													</thead>
													<tbody>

													<?php


													while($row=mysql_fetch_array($query_results1)){
														$user_name = $row[user_name];
														$module = $row[module];
														$create_date = $row[create_date];

														$task = $row[task];
														$reference = $row[reference];
														$ip = $row[ip];

														$unixtimestamp = (int) $row[unixtimestamp];

														//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

														//echo $admin_timezone;

														$dt = new DateTime("@$unixtimestamp");
														$dt->setTimezone(new DateTimeZone($log_time_zone));
    													//$dt->setTimestamp($unixtimestamp);
    													//date_default_timezone_set($admin_timezone);
    													//$dt->setTimeZone(new DateTimeZone($admin_timezone));
    													$unix_date=$dt->format('m/d/Y h:i:s A');   

														//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);
														//echo date_default_timezone_get();

                                                        $dt2 = new DateTime($create_date);
                                                        $create_date = $dt2->format('m/d/Y h:i:s A');

														echo '<tr>
														<td> '.$user_name.' </td>
														<td> '.$module.' </td>
														<td> '.$task.' </td>
														<td> '.$reference.' </td>
														<td> '.$ip.' </td>
														<td> '.$unix_date.' </td>';

													}

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>
									


								<!-- /* +++++++++++++++++++++++++++++++++++++ User Activity Logs +++++++++++++++++++++++++++++++++++++ */ -->
								<div <?php if(isset($tab11)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="auth_logs">
										<br>
										<form id="auth_log" name="auth_log" method="post" class="form-horizontal" action="?t=11">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg11'])){
													   echo $_SESSION['msg11'];
													   unset($_SESSION['msg11']);


													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="auth_lg" id="auth_lg" value="auth_lg" />

													<div class="control-group ">
														<label class="control-label" for="name">Method</label>
														<div class="controls form-group">
															
																<select class="span2 form-control" name="name" id="name" value=<?php echo $name ?>>
																	<option value="-1"> All </option>
																	<option value="SSO"> SSO Login </option>
																	<option value="SLO"> SSO Logout </option>
																	<?php
																	/* $user_select_qu = "SELECT user_name FROM `admin_users` WHERE `user_distributor` = '$user_distributor'";
																	$user_select_re = mysql_query($user_select_qu);
																	while($row_user = mysql_fetch_array($user_select_re)){
																		if ($row_user[user_name] == $name) {
																			echo "<option value='".$row_user[user_name]."' selected> ".$row_user[user_name]." </option>";
																		} else {
																			echo "<option value='".$row_user[user_name]."'> ".$row_user[user_name]." </option>";
																		}

																	} */
																	 ?>
																</select>
															

														</div>
													</div>

													<div class="control-group ">
														<label class="control-label" for="limit3">Limit</label>
                                                        <?php 
														
														if(!isset($limit3)){
															$limit3=50;
															}
														
														?>
                                                      
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control limit_log" id="limit3" name="limit3" value="'.$limit3.'" type="text"  title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                            
                                                              <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#limit3').tooltip(); 
                                                            

                                                                });
</script>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="inline_error inline_error_1 span2 form-control" id="start_date11" name="start_date11"
																	type="text" value="<?php if(isset($mg_start_date11)){echo $mg_start11;} ?>" placeholder="mm/dd/yyyy">
																	to
																	<input class="inline_error inline_error_1 span2 form-control" id="end_date11" name="end_date11" type="text"
																	 value="<?php if(isset($mg_end_date11)){echo $mg_end11;} ?>" placeholder="mm/dd/yyyy">

																	 <input type="hidden" name="date11" />

															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="auth_error_log_submit" id="auth_error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													 $row_count311 = mysql_num_rows($query_results11);
													if ($row_count311>0) {
												?>
													<h3>Auth Logs
												<?php
													}else{
												?>
													<h3>Auth Logs
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th	scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Function</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function Name</th>
															<th	scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Method</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Status</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Details</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Date</th>


														</tr>
													</thead>
													<tbody>

													<?php


													while($row11=mysql_fetch_array($query_results11)){
														$id = $row11[id];
														$function = $row11['function'];
														$function_name = $row11[function_name];
														$api_method = $row11[api_method];
														$api_status = $row11[api_status];
														$api_description = $row11[api_description];
														$create_date = $row11[create_date];

														$unixtimestamp = (int) $row11[unixtimestamp];

														//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

														$dt = new DateTime("@$unixtimestamp");
														$dt->setTimezone(new DateTimeZone($log_time_zone));
														$unix_date=$dt->format('m/d/Y h:i:s A');
														//$unix_date=date('m/d/Y h:i:s A',$unixtimestamp);
														
                                                        $dt11 = new DateTime($create_date);
                                                        $create_date = $dt11->format('m/d/Y h:i:s A');

														echo '<tr>
														<td> '.$function.' </td>
														<td> '.$function_name.' </td>
														<td> '.$api_method.' </td>
														<td> '.$api_status.' </td>
														<td>';
														
															echo'<a id="redirect_url_'.$id.'"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#redirect_url_'.$id.'\').tooltipster({
												                content: $(\'<p style= word-wrap:break-word>'.$api_description.'</p>\'),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script>';
														

														echo'</td>

														<td> '.$unix_date.' </td>';

													}

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>


									<!-- Api logs  -->
									<div <?php if(isset($tab10)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="user_act">
										<br>
										<form id="api_logs" name="api_logs" method="post" class="form-horizontal" action="?t=10">
											<fieldset>


													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="api_lg" id="api_lg" value="api_lg" />

													<div class="control-group">
														<label class="control-label" for="name">Function</label>
														<div class="controls form-group">


													<script type="text/javascript">
																 jQuery(document).ready(function(){

 																 jQuery('select#function_select').val('<?php echo $_POST['function_select'];?>');

 																});
																	</script>

															
																<select class="span2 form-control" name="function_select" id="function_select">
																	<option value="all"> All </option>

																	<?php
																	
																	$functionsl=$wag_obj->Functionlist();
																	
																	$array_function_list=json_decode($functionsl,true);
																	
																	asort($array_function_list);
																	
																	foreach ($array_function_list as $key => $value) {
																	?>
																	<option value="<?php echo $key ?>"><?php echo ucfirst($value)?>  </option>
																	<?php } ?>






																</select>
															

														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="realm_api">Realm</label>
														<div class="controls form-group">
															<?php echo '<input class="span2 form-control" id="realm_api" name="realm_api" value="'.$api_realm.'" placeholder="realm" type="text">' ?>
														</div>
													</div>


													<div class="control-group">
														<label class="control-label" for="limit_api">Limit</label>
														<div class="controls form-group">
                                                          <?php 
														
														if(!isset($limit_api)){
															$limit_api=50;
															}
														
														?>
															<?php echo '<input class="span2 form-control limit_log" id="limit_api" name="limit_api" value="'.$limit_api.'"  type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                            
                                                            <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#limit_api').tooltip(); 
                                                            

                                                                });
</script>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="span2 form-control" id="start_date_api" name="start_date_api"
																	type="text" value="<?php if(isset($start_date_apia)){echo $start_date_apia;} ?>" placeholder="mm/dd/yyyy">
																	to
																	<input class="span2 form-control" id="end_date_api" name="end_date_api" type="text"
																	 value="<?php if(isset($end_date_apia)){echo $end_date_apia;} ?>" placeholder="mm/dd/yyyy">

																	 <input type="hidden" name="api_date" />
															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													 $row_count33 = mysql_num_rows($query_api_results);
													if ($row_count33>0) {
												?>
													<h3>AP/SSID Logs
												<?php
													}else{
												?>
													<h3>AP/SSID Logs
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Realm</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function</th>
														<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">API URL</th> -->
														<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">Method</th> -->
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API Log</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Status</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


														</tr>
													</thead>
													<tbody>

													<?php


													while($row=mysql_fetch_array($query_api_results)){
														$function_name = $row['function_name'];
														$description = $row['description'];
														$api_status = $row['api_status'];
														$api_method = $row['api_method'];
														$api_description = $row['api_description'];
														//$api_data = $row['api_data'];
														$create_date = $row['create_date'];

                                                        $dt2 = new DateTime($create_date);
                                                        $create_date = $dt2->format('m/d/Y h:i:s A');

														$realm_a=$row['realm'];
														$api_id = $row['id'];

														echo '<tr>
														<td> '.$realm_a.' </td>
														<td> '.ucfirst($function_name).' </td>
														<td><a href=ajax/log_view.php?ap_log_id='.$api_id.' target="_blank"> View </a></td>
														<td> '.$api_status.' </td>

														<td> '.$create_date.' </td>';


													}

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>

									<!-- /* +++++++++++++++++++++++++++++++++++++ User Redirection Logs +++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab4)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="redirection_log">
										<br>
										<form id="redirection_log_f" name="redirection_log_f" method="post" class="form-horizontal" action="?t=4">
											<fieldset>

												<div id="response_d3">
												<?php
												   if(isset($_SESSION['msg4'])){
													   echo $_SESSION['msg4'];
													   unset($_SESSION['msg4']);


													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="redirection_lg" id="redirection_lg" value="redirection_lg" />


													<div class="control-group">
														<label class="control-label" for="mac_rd">MAC</label>
														<div class="controls form-group">
															<input class="span2 form-control" id="mac4" name="mac4" value="<?php echo $mac4; ?>" type="text">
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="realm_rd">Realm</label>
														<div class="controls form-group">
															<input class="span2 form-control" id="realm4" name="realm4" value="<?php echo $realm4; ?>" type="text">
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit4">Limit</label>
														<div class="controls form-group">
                                                        <?php 
														
														if(!isset($limit4)){
															$limit4=50;
															}
														
														?>
															<?php echo '<input class="span2 form-control limit_log" id="limit4" name="limit4" value="'.$limit4.'" type="text" title="Set the upper limit of how many log records you want to be displayed in the table below." placeholder="50">' ?>
                                                            
                                                            <script type="text/javascript">
 $(document).ready(function() {
                                                                    
                                                                     $('#limit4').tooltip(); 
                                                            

                                                                });
</script>

														</div>
													</div>


													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="span2 form-control" id="start_date4" name="start_date4"
																	type="text" value="<?php if(isset($mg_start_date4)){echo $mg_start_4;} ?>" placeholder="mm/dd/yyyy">
																	to
																	<input class="span2 form-control" id="end_date4" name="end_date4" type="text"
																	 value="<?php if(isset($mg_end_date4)){echo $mg_end_4;} ?>" placeholder="mm/dd/yyyy">

																	 <input type="hidden" name="date4" />

														</div>
														<!-- /controls -->
													</div>



													<div class="form-actions">
														<button type="submit" name="redirection_log_submit" id="redirection_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													 $row_count33 = mysql_num_rows($query_results4);
													if ($row_count33>0) {
												?>
													<h3>Redirection Logs
												<?php
													}else{
												?>
													<h3>Redirection Logs
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto;" >
												<table style="table-layout: fixed;" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
														<!--	<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Page</th> -->
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" >Device MAC</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">REDIRECT URL</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Realm</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">ORIGINATING URL</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Date</th>

														</tr>
													</thead>
													<tbody>

													<?php


													while($row=mysql_fetch_array($query_results4)){
														$mac = $row[mac];
														$page = $row[page];
														$request_uri = $row[request_uri];
														$referer = $row[referer];
														$create_date = $row[create_date];
														$id=$row['id'];
														$realm = $row[group_id];

														echo '<tr>
														<td> '.$mac.' </td>
														<td>';
														if(strlen($request_uri)>0){
															echo'<a id="redirect_url_'.$id.'"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#redirect_url_'.$id.'\').tooltipster({
												                content: $("<p style= word-wrap:break-word>'.$request_uri.'</p>"),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script>';
														}

														echo'</td>
														<td> '.$realm.' </td>';
														echo'<td>';
														if(strlen($referer)>0){
															echo'
														<a id="origination_url_'.$id.'"> View </a> <script>
												        $(document).ready(function() {

												            $(\'#origination_url_'.$id.'\').tooltipster({
												                content: $("<p style= word-wrap:break-word>'.$referer.'</p>"),
												                theme: \'tooltipster-shadow\',
												                animation: \'grow\',
												                onlyOne: true,
												                trigger: \'click\'

												            });


												        });
												    </script> ';
														}

														echo '</td>';
														echo'
														<td> '.date_format(date_create($create_date),'d/m/Y h:i:s A').' </td>';

													}

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>
									</div>
								</div>
							</div>
							<!-- /widget-content -->

						</div>
						<!-- /widget -->

					</div>
					<!-- /span12 -->




				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /main-inner -->

	</div>
	<!-- /main -->