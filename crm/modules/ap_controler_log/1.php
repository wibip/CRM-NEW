 	<!-- AP LOGS start -->
				<div <?php if(isset($tab_ap_controler_log)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="ap_controler_log">
									<div id="response_d3">

										<h1 class="head" style="display: none">AP Controller Logs</h1>
									<br>


									<p>Search AP controller logs to identify failures that may be impacting the customer's experience.
									</p><br>
									<form id="api_logs" name="api_logs" method="post" class="form-horizontal" action="?t=ap_controler_log">
											<fieldset>


													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="api_lg" id="api_lg" value="api_lg" />

													<div class="control-group">
														<label class="control-label" for="name">Function</label>
														<div class="controls">




													<?php

													if(strlen($_POST['function_select'])){
														$selected_i = "all";
													}
													else{
														$selected_i = $_POST['function_select'];
													}

													$selected_i = "all";
													?>

													<script type="text/javascript">
																 jQuery(document).ready(function(){

 																 jQuery('select#function_select').val('<?php echo $selected_i; ?>');

 																});
																	</script>

															<div class="input-prepend input-append">
																<select name="function_select" class="span4" id="function_select">
																	<option  value="all"> All </option>

																	<?php
if ($property_wired !='1') {
																	$functionsl=$test->Functionlist();

																	$array_function_list=json_decode($functionsl,true);

																	asort($array_function_list);

                                                                    foreach ($array_function_list as $key => $value) {
                                                                        ?>
																	<option value="<?php echo $key ?>"><?php echo ucfirst($value)?>  </option>
																	<?php
                                                                    }
																} ?>


																</select>
															</div>

														</div>
													</div>



													<div class="control-group">
														<label class="control-label" for="limit_api">Limit</label>
														<div class="controls">
															<?php if(!isset($limit_api)){$limit_api=100;} echo '<input placeholder="100" class="span2" id="limit_api" name="limit_api" value="'.$limit_api.'" placeholder="100" type="text">' ?>
														</div>
													</div>
<script type="text/javascript">

                                             $("#limit_api").keypress(function(event){
                                                                var ew = event.which;
																//alert(ew);
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            });



                                            </script>
													<div class="control-group">
														<label class="control-label" for="radiobtns">Period</label>

														<div class="controls form-group">


																<input class="inline_error inline_error_1 span2 form-control" id="start_date_api" name="start_date_api"
																	type="text"   value="<?php if(isset($start_date_apia)){echo $start_date_apia;} ?>" placeholder="mm/dd/yyyy">

																	To
																	<input class="inline_error inline_error_1 span2 form-control" id="end_date_api" name="end_date_api" type="text" value="<?php if(isset($end_date_apia)){echo $end_date_apia;} ?>" placeholder="mm/dd/yyyy">

                                                                     <input type="hidden" name="date3" />


														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<?php
											 $row_count33 = count($query_api_results);
											 if ($row_count33<3) {
											 	$table_saw_style = 'style="margin-bottom: 60px !important;"';
											 }
											 else{
											 	$table_saw_style = '';
											 }
										 ?>

										<div class="widget widget-table action-table tablesaw-minimap-mobile" <?php echo $table_saw_style; ?>>
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php

													if ($row_count33>0) {
												?>
													<h3>AP/SSID Logs - <small> <?php echo $row_count33; ?> Result(s)</small></h3>
												<?php
													}else{
												?>
													<h3>AP/SSID Logs - <small> 0 Result(s)</small></h3>
												<?php
													}
												 ?>
											</div>
												<!-- /widget-header -->
											<div class="widget-content table_response">
												<div style="overflow-x:auto">
												<table id="controller_logs_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Realm</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Function</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">API Log</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">API Status</th>

															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Create Date</th>


														</tr>
													</thead>
													<tbody>

													<?php
													//echo $query_api;

													foreach ($query_api_results as  $row) {
														$function_name = $row->function_name;
														$description = $row->description;
														$api_status = $row->api_status;
														$api_method = $row->api_method;
														$api_description = $row->api_description;
														//$api_data = $row['api_data'];
														$create_date = $row->create_date;

														$unixtimestamp = (int) $row->unixtimestamp;

                                                        $dt2 = new DateTime($create_date, new DateTimeZone(date_default_timezone_get()));
                                                        $dt2->setTimezone(new DateTimeZone($tome_zone));
                                                        $create_date = $dt2->format('m/d/Y h:i:s A');

                                                        $dt = new DateTime("@$unixtimestamp");
														$dt->setTimezone(new DateTimeZone($log_time_zone));
														$unix_date=$dt->format('m/d/Y h:i:s A');


														$realm_a=$row->realm;
														$api_id = $row->id;

														echo '<tr>
														<td> '.$realm_a.' </td>
														<td> '.ucfirst($function_name).' </td>
														<td><a href=ajax/log_view.php?ap_log_id='.$api_id.' target="_blank"> View </a></td>

														<td> '.$api_status.' </td>

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






				</div>

<!-- AP LOGS END -->