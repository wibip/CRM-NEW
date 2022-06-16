<div class="tab-pane <?php if (isset($tab_customer_session_report)){ echo 'active'; } ?>" id="customer_session_report">


										<div class="header_hr" style="display: none;"></div>
											<div class="header_f1" style="display: none;">Total Sessions</div>

											<?php
                                                    $ses_down_key_string = "dist=".$user_distributor."&type=total_sessions&offset_val=".$offset_val;
                                                    $ses_down_key =  cryptoJsAesEncrypt($data_secret,$ses_down_key_string);
                                                    $ses_down_key =  urlencode($ses_down_key);
                                            ?>

                                            <select name="report_interval" id="report_interval" class="span2" style="margin-bottom:0px">
												<option value="30">Last 30 days</option>
												<option value="60">Last 60 days</option>
												<option value="90">Last 90 days</option>
												<option value="180">Last 180 days</option>
												<option value="360">Last 360 days</option>
											</select>
											<a id="session_report_link" href="#" class="btn btn-info"> Download Session Report</a>
											<br /><br />
											
											<script>
												$(function () {
													$('#session_report_link').click(function (e) { 
														e.preventDefault();
														window.location = "ajax/export_session.php?key=<?php echo $ses_down_key;?>&interval="+$('#report_interval').val();
													});
												});
											</script>

											<div class="widget widget-table action-table">
												<div class="widget-header">
													
													<h3>Total Sessions</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="today_session">

													<div style="overflow-x:auto;" class="last24">
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">FIRST NAME</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">LAST NAME</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">MAC</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">EMAIL ADDRESS</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">MOBILE NUMBER</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">FIRST LOGIN DATE</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">LAST SESSION DATE</th>
															</tr>
														</thead>
														<tbody>

                                                            <?php

                                                                $key_query = "SELECT first_name,last_name,act_email,mac,gender,mobile_number,birthday,first_login_date,s.session_auth_time
                                                                FROM exp_customer c, exp_customer_session s
                                                                WHERE c.customer_id = s.customer_id AND s.location_id = '$user_distributor' AND s.session_status = '2' AND DATE(CONVERT_TZ(NOW(),'SYSTEM','$offset_val')) - INTERVAL 30 DAY <= DATE(CONVERT_TZ(FROM_UNIXTIME(s.unixtimestamp),'SYSTEM','$offset_val')) order by s.id desc";

                                                                $query_results=$db->selectDB($key_query);
                                                                
                                                                foreach ($query_results['data'] AS $row) {
                                                                    $first_name = $row[first_name];
                                                                    $last_name = $row[last_name];
                                                                    $email = $row[act_email];
                                                                    $mac = $row[mac];
                                                                    $mobile_number = $row[mobile_number];
                                                                    $first_login_date = $row[first_login_date];
                                                                    $last_login_date = $row[session_auth_time];

                                                                    echo '<tr>
                                                                    <td> '.$first_name.' </td>
                                                                    <td> '.$last_name.' </td>
                                                                    <td> '.$mac.' </td>
                                                                    <td> '.$email.' </td>
                                                                    <td> '.$mobile_number.' </td>
                                                                    <td> '.$first_login_date.' </td>
                                                                    <td> '.$last_login_date.' </td>

                                                                    </tr>';


                                                                }
                                                            ?>


								                        </tbody>
													</table>
														</div>
												</div>
												<!-- /widget-content -->
											</div>
											<!-- /widget -->

										</div>