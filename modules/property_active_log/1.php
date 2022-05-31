 	<!-- Property Activity Logs -->
				<div <?php if(isset($tab_property_activity_log)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="property_activity_log">
									<div id="response_d3">

										<h1 class="head" style="display: none">Property Activity Logs</h1>
									<br>


									<p><!-- Search AP controller logs to identify failures that may be impacting the customer's experience. -->													
									</p><br>
									<form id="property_activity_logs_form" name="property_activity_logs_form" method="post" class="form-horizontal" action="?t=property_activity_log">
											<fieldset>


													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
												<!-- 	<input type="hidden" name="api_lg" id="api_lg" value="api_lg" /> -->

													



													<div class="control-group">
														<label class="control-label" for="limit_api">Limit</label>
														<div class="controls">
															<?php if(!isset($limit_api)){$limit_api=100;} echo '<input placeholder="100" class="span2" id="limit5" name="limit5" value="'.$limit_api.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">
															

																<input class="inline_error inline_error_1 span2 form-control" id="start_date5" name="start_date5" 
																	type="text"   value="<?php if(isset($mg_start_5)){echo $mg_start_5;} ?>" placeholder="mm/dd/yyyy">
                                                                    
																	To
																	<input class="inline_error inline_error_1 span2 form-control" id="end_date5" name="end_date5" type="text" value="<?php if(isset($mg_end_5)){echo $mg_end_5;} ?>" placeholder="mm/dd/yyyy">
                                                                     
                                                                     <input type="hidden" name="date5" />

															
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="property_log_submit" id="property_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

                                        <?php
                                        $row_count33 = $query_results5['rowCount']; 
                                        if($row_count33>0) {
                                            $key = uniqid('property_log_search')
                                            ?>
                                            <a href="ajax/export_report.php?property_activity_logs=<?php echo$key; ?>"
                                               class="btn btn-primary" style="text-decoration:none">
                                                <i class="btn-icon-only icon-download"></i> Download search Result
                                            </a>
                                            <?php
                                        }
                                        ?>

										<div class="widget widget-table action-table tablesaw-minimap-mobile" <?php echo $table_saw_style; ?>>
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
                                                <h3>Property Activity Logs - <small> <?php echo $row_count33; ?> Result(s)</small></h3>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto">
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
                                                    $activity_arr = array();

													
													foreach ($query_results5 AS $row) {

                                                        $one_arr = array();

														$user_name = $row->user_name;
														if(empty($user_name)){$user_name="N/A";}
                                                        $one_arr['User Name'] = $user_name;

														$module = $row->module;
														if(empty($module)){$module="N/A";}
                                                        $one_arr['Module Name'] = $module;

														$create_date = $row->create_date;

														$task = $row->task;
                                                        $one_arr['Task'] = $task;
														$reference = $row->reference;

														if(empty($reference)){$reference="N/A";}
                                                        $one_arr['Reference'] = $reference;
														$ip = $row->ip;
                                                        $one_arr['IP'] = $ip;

														$unixtimestamp = (int) $row->unixtimestamp;

														//$admin_timezone=$db->getValueAsf("SELECT `timezones` AS f FROM `exp_mno` WHERE `mno_id`='$user_distributor'");

														//echo $admin_timezone;

														$dt = new DateTime("@$unixtimestamp");
														$dt->setTimezone(new DateTimeZone($log_time_zone));
    													//$dt->setTimestamp($unixtimestamp);
    													//date_default_timezone_set($admin_timezone);
    													//$dt->setTimeZone(new DateTimeZone($admin_timezone));
    													$unix_date=$dt->format('m/d/Y h:i:s A');
                                                        $one_arr['Date'] = $unix_date;

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

                                                        array_push($activity_arr,$one_arr);
													}
                                                    $_SESSION[$key]=json_encode($activity_arr);

													?>





												</tbody>
												</table>
											</div>
											</div>
												<!-- /widget-content -->
										</div>




									</div>






				</div>