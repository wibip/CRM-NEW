<div class="tab-pane <?php if (isset($tab_customer_report_last_hour )){ echo 'active'; } ?>" id="customer_report_last_hour">

											<div class="widget widget-table action-table">
												<div class="widget-header">
													
													<h3>Connected Last Hour</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="session_tbl">

													<div style="overflow-x:auto;" >
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">First Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Last Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">MAC</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email Address / Social ID</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Gender</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Birthday</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">First Login Date</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">Last Login Date</th>
															</tr>
														</thead>
														<tbody>

                                                            <?php

                                                                 $key_query = "SELECT first_name,last_name,email,mac,gender,birthday,first_login_date,s.session_auth_time
                                                                FROM exp_customer c, exp_customer_session s
                                                                WHERE s.location_id = '$user_distributor' AND s.session_status = '2' AND c.customer_id = s.customer_id AND  s.session_auth_time > DATE_SUB(NOW(), INTERVAL 1 HOUR) order by s.id desc";

                                                                $query_results=$db->selectDB($key_query);
                                                               
                                                                foreach ($query_results['data'] AS $row) {
                                                                    $first_name = $row[first_name];
                                                                    $last_name = $row[last_name];
                                                                    $mac = $row[mac];
                                                                    $email = $row[email];
                                                                    $gender = $row[gender];
																	
																	if($gender == 'all'){
																		$gender = 'NA';
																		}
																		
																		
                                                                    $birthday = $row[birthday];
																	
																	if($birthday == '0000-00-00'){
																		$birthday = 'NA';
																		}
																		
																		
                                                                    $first_login_date = $row[first_login_date];
                                                                    $last_login_date = $row[session_auth_time];

                                                                    echo '<tr>
                                                                    <td> '.$first_name.' </td>
                                                                    <td> '.$last_name.' </td>
                                                                    <td> '.$mac.' </td>
                                                                    <td> '.$email.' </td>
                                                                    <td> '.ucfirst($gender).' </td>
                                                                    <td> '.$birthday.' </td>
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