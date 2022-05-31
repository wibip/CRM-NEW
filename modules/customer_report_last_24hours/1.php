<div class="tab-pane <?php if (isset($tab_customer_report_last_24hours )){ echo 'active'; } ?>" id="customer_report_last_24hours">


											<?php
                                                    $ses_down_key_string = "dist=".$user_distributor;
                                                    $ses_down_key =  cryptoJsAesEncrypt($data_secret,$ses_down_key_string);
                                                    $ses_down_key =  urlencode($ses_down_key);
                                            ?>

                                            <a href="ajax/export_session.php?key=<?php echo $ses_down_key;?>" class="btn btn-info"> Download Full Records</a>
                                            <br /><br />

											<div class="widget widget-table action-table">
												<div class="widget-header">
													
													<h3>Connected Last 24 Hours</h3>
												</div>
												<!-- /widget-header -->
												<div class="widget-content table_response" id="today_session">

													<div style="overflow-x:auto;" class="last24">
													<table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
														<thead>
															<tr>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">First Name</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Last Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">MAC</th>
																<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Email Address  / Social ID</th>
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
                                                                WHERE c.customer_id = s.customer_id AND s.location_id = '$user_distributor' AND s.session_status = '2' AND DATE(s.session_auth_time) = CURDATE() order by s.id desc";

                                                                $query_results=$db->selectDB($key_query);
                                                             
                                                                foreach ($query_results['data'] AS $row) {
                                                                    $first_name = $row[first_name];
                                                                    $last_name = $row[last_name];
                                                                    $email = $row[email];
                                                                    $mac = $row[mac];
                                                                    $gender = $row[gender];
                                                                    $birthday = $row[birthday];
																	
																		if($gender == 'all'){
																		$gender = 'NA';
																		}
																		
																		
                                                                    
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