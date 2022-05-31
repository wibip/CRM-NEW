	<?php $db = new db_functions();
 			?>	
 								<div <?php if(isset($tab_tier_support)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="tier_support">

									<h1 class="head" style="display: none;">Manually onboard a customer device</h1>

									<h2>Device and Session Management</h2>
									<br/>


								
								<p><b>LIST ALL DEVICES: </b>Clicking this button will return a list of all devices currently registered at the location. The devices can either have active or inactive sessions.
								</p>
									<p><b>SEARCH FOR A DEVICE: </b>Enter the MAC Address of the device in the Search dialog and click "Search" to determine if the device is registered and has an active or inactive session.
									</p>
									<p><b>DELETE DEVICE OR REMOVE A SESSION: </b>Once you have identified a device you have the option to delete the device and/or remove the session. If a device is deleted, that device has to re-register to get online once its current session expires. If a session is removed, that device will automatically get a new session if the device is registered. Or if the device has been deleted, the session can be removed to immediately end that session.
									</p>

									<br/>

								<form action="?t=tier_support" id="mac_search" class="form-horizontal" method="post">
									<fieldset>
										<div class="control-group">
										<div class="controls form-group">
                                            <input type="text" class="span4 form-control" name="search_mac" id="search_mac" placeholder="xx:xx:xx:xx:xx:xx" autocomplete="off" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS." />

                                            <button type="submit" name="search_mac_sessions" id="search_mac_sessions" class="btn btn-primary inline-btn"><i class="btn-icon-only icon-search"></i> Search</button>

                                            <a data-toggle="tooltip" title="List All devices button will display Active Authenticated Clients on Network" name="all_search" id="all_search" class="btn btn-info inline-btn"  onclick="manual_btn();"><i class="btn-icon-only icon-search"></i> List All Devices</a>
                                            <img id="tooltip1" data-toggle="tooltip" title="Use the List All Devices button to see how many devices are registered and online right now. Or use the field and Search button to find a specific device using its MAC address." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 0px;cursor: pointer;display:  inline-block;">

									</div>
									<br/>
								
												<br/>
											<script type="text/javascript">

											function manual_btn() {
												window.location = "?all_search=1";
											}

											
											</script>

										</div>
									</fieldset>
								</form>

									<form action="?t=tier_support" class="form-horizontal">
									<div class="widget widget-table action-table tablesaw-minimap-mobile">
										<div class="widget-header">
											<!-- <i class="icon-th-list"></i> -->
											<h3>Devices & Sessions</h3>
										</div>
										<div class="widget-content table_response">
											<div style="overflow-x:auto">
									<table id="device_sessions" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
										<thead>
										<tr>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AP MAC/GW MAC</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Session State</th>
										<?php	if($private_module==1){
										                ?>
										                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Session Type</th>     
										                <?php
										        }   
										?>
											
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">SSID</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Customer Account #</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">GW IP</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">GW Type</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Session Start Time</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Delete Device</th>
											<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Remove Session</th>
										</tr>

										</thead>
										<tbody>
										<?php
										$tb_arr_data = [];
										if(isset($_POST['search_mac_sessions']) || isset(
											$set_search_mac_sessions) || isset($_GET['search_mac_sessions'])) {
											//print_r($newjsonvalue);
											if (!$newjsonvalue) {
												echo "<td colspan=\"1\">No Device</td>";
												echo "<td colspan=\"10\">No Sessions</td>";
											}
											$session_row_count=0;
											foreach ($newjsonvalue as $value2) {
												$next_search_pram='search_mac_sessions';
												$session_row_count=$session_row_count+1;
												
												$tb_arr = [];
												$mac=($value2['Mac']);
												$AP_Mac=($value2['AP_Mac']);
												$newstate=($value2['State']);
												if (empty($value2['State'])) {
													$value2['State']="No Session/offline";
												}
												$state=($value2['State']);
												$ssid=($value2['SSID']);
												$GW_ip=($value2['GW_ip']);
												$sh_realm=($value2['Realm']);
												$GW_Type=($value2['GW-Type']);
												$start_time=($value2['Session-Start-Time']);
                                                $ses_type = $value2['session_type'];
                                                $device_mac= $value2['Device-Mac'];
                                                $type= $value2['TYPE'];
                                                $ses_id= $value2['Ses_token'];
												
												if (strlen($mac)<1) {
                                                    		$mac="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                    		$AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                    		$ssid="N/A"; }
                                                if (strlen($type)<1) {
                                                    		$type="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                    		$GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                    		$sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                    		$GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                    		$start_time="N/A"; }

												array_push($tb_arr,$db->macFormat($mac, $mac_format));
												array_push($tb_arr,$AP_Mac);
												array_push($tb_arr,$state);
												if($private_module==1){
													array_push($tb_arr,$type);
										        } 
												
												array_push($tb_arr,$ssid);
												array_push($tb_arr,$sh_realm);
												array_push($tb_arr,$GW_ip);
												array_push($tb_arr,$GW_Type);
												array_push($tb_arr,$start_time);

											

											 //echo '<td>'; 
													if(strlen($ses_id)>0 && $_GET['rm_session_mac']!=$mac){
													$a = '<a href="" id="'.$session_row_count.'SESSION_DELETE_' . $mac .'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&mac='.$mac.'&state='.$state.'&t=tier_support&rm_session_mac='.$mac.'&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                });
                                                        </script>
														
														'; 
														array_push($tb_arr,$a);
													}
														elseif ($_GET['rm_session_mac']==$mac){
                                                        $a = '<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck'.$mac.' = function (){
														    checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
														        
														    if(data == \'0\'){
														    
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_'.$mac.'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck'.$mac.'();
														    }   
														});
														    
														}
														deleteSessionCheck'.$mac.'();
                                                        </script>
														';
														array_push($tb_arr,$a);
                                                    }
														else{
															$a = '<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
														array_push($tb_arr,$a);
													}
											//echo'</td>'; 
											//echo '<td>';
												if(strlen($device_mac)>0) {
													$b =  '<a id="' . $session_row_count . 'DEVICE_DELETE"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=tier_support&rm_device_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $mac . '"
                                                                });
                                                                });
                                                        </script>
														';
														array_push($tb_arr,$b);
												}
												else{
													 $b = '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>'; 

														array_push($tb_arr,$b);	
												}
												//echo '</td>';
											 //echo "</tr>";
											 array_push($tb_arr_data,$tb_arr);
											}
											
										}


										//=============================================
										elseif(isset($_POST['all_search']) || isset($_GET['all_search'])){
											$next_search_pram='all_search';
                                            $next_search_value='all_search';
                                            if (!$newjsonvalue) {
                                            	echo "<td colspan=\"1\">No Devices</td>";
												echo "<td colspan=\"10\">No Sessions</td>";
												
											}

											
											$session_row_count=0;
											foreach ($newjsonvalue as $value2) {
												if (strlen($value2['Mac'])>0) {
													
												
												$session_row_count=$session_row_count+1;
												
												$tb_arr = [];
												$mac=($value2['Mac']);
												$AP_Mac=($value2['AP_Mac']);
												$ssid=($value2['SSID']);
												$GW_ip=($value2['GW_ip']);
												$sh_realm=($value2['Realm']);
												$GW_Type=($value2['GW-Type']);
												$start_time=($value2['Session-Start-Time']);
												$newstatus=$value2['State'];
                                                $ses_type = $value2['session_type'];
                                                $device_mac= $value2['Device-Mac'];
                                                $type= $value2['TYPE'];
                                                $ses_id= $value2['Ses_token'];
												
												if (empty($value2['State'])) {
													$value2['State']="No Session/offline";
												}
												$state=($value2['State']);
												
												
                                                  if (strlen($mac)<1) {
                                                    		$mac="N/A"; }
                                                if (strlen($state)<1) {
                                                    		$state="N/A"; }
                                                if (strlen($type)<1) {
                                                    		$type="N/A"; }
                                                if (strlen($AP_Mac)<1) {
                                                    		$AP_Mac="N/A"; }
                                                if (strlen($ssid)<1) {
                                                    		$ssid="N/A"; }
                                                if (strlen($GW_ip)<1) {
                                                    		$GW_ip="N/A"; }
                                                if (strlen($sh_realm)<1) {
                                                    		$sh_realm="N/A"; }
                                                if (strlen($GW_Type)<1) {
                                                    		$GW_Type="N/A"; }
                                                if (strlen($start_time)<1) {
                                                    		$start_time="N/A"; }

															array_push($tb_arr,$db->macFormat($mac, $mac_format));
															array_push($tb_arr,$AP_Mac);
															array_push($tb_arr,$state);
												if($private_module==1){
													array_push($tb_arr,$type);
										        }
												array_push($tb_arr,$ssid);
												array_push($tb_arr,$sh_realm);
												array_push($tb_arr,$GW_ip);
												array_push($tb_arr,$GW_Type);
												array_push($tb_arr,$start_time);
											 /*foreach ($value2 as $key => $value) {
											 	//$session_row_count++;

											 	if (strlen($value)<1) {
											 		$value="N/A";
											 		# code...
											 	}
											 	echo "<td>".$value."</td>";
											 	

											 }*/


											 //echo '<td>';
												if(strlen($device_mac)>0) {
													$a = '<a id="' . $session_row_count . 'DEVICE_DELETE"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#' . $session_row_count . 'DEVICE_DELETE\').easyconfirm({locale: {
                                                                    title: \'Delete Device\',
                                                                    text: \'Are you sure you want to Delete this device?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#' . $session_row_count . 'DEVICE_DELETE\').click(function() {
                                                                    window.location = "?token=' . $secret . '&t=tier_support&rm_device_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&rm_device_mac=' . $mac . '&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                });
                                                        </script>
														';
														array_push($tb_arr,$a);
												}
												else{
													 $a = '<a disabled   id="' . $session_row_count . 'DEVICE_DELETE"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-mobile-phone"></i>&nbsp;Delete</a>'; 

														array_push($tb_arr,$a);	
												}
												//echo '</td>';
												//echo '<td>';
													if(strlen($ses_id)>0 && $_GET['rm_session_mac']!=$mac ){
													$b = '<a href="" id="'.$session_row_count.'SESSION_DELETE_' . $mac .'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>
														<script type="text/javascript">
                                                            $(document).ready(function() {
                                                            $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').easyconfirm({locale: {
                                                                    title: \'Remove Session\',
                                                                    text: \'Are you sure you want to Remove this session?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                    closeText: \'close\'
                                                                     }});
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_' . $mac .'\').click(function() {
                                                                    window.location = "?token=' . $secret . '&rm_session_realm='.$sh_realm.'&rm_session_token='.$ses_id.'&mac='.$mac.'&state='.$state.'&t=tier_support&rm_session_mac='.$mac.'&' . $next_search_pram . '=' . $next_search_value . '"
                                                                });
                                                                });
                                                        </script>
														
														'; 
														array_push($tb_arr,$b);
													}elseif ($_GET['rm_session_mac']==$mac){
                                                        $b = '<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $mac.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;In Progress...</a>
														<script type="text/javascript">
														var deleteSessionCheck'.$mac.' = function (){
														    checkSessionDeleted(\''.$sh_realm.'\',\''.$mac.'\',function(data){
														        //alert(data);
														    if(data == \'0\'){
														    
                                                                $(\'#'.$session_row_count.'SESSION_DELETE_'.$mac.'\').html(\'<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Deleted\');
                                                                
														    }else{
														        deleteSessionCheck'.$mac.'();
														    }   
														});
														    
														}
														deleteSessionCheck'.$mac.'();
                                                        </script>
														';
														array_push($tb_arr,$b);
                                                    }
														else{
															$b = '<a disabled id="'.$session_row_count.'SESSION_DELETE_' . $session_id.'"  class="btn btn-small btn-danger">

														<i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>';
														array_push($tb_arr,$b);
													}
														//echo'</td>'; 
											 //echo "<td><a href='#' disabled> REMOVE</a></td>";
											 //echo "</tr>";
											 array_push($tb_arr_data,$tb_arr);
											}
										}

										}

										else{
											echo "<td colspan=\"1\">No Devices</td>";
											echo "<td colspan=\"10\">No Sessions</td>";
											
										}
										
										
										
										
										$vernum=$db->getValueAsf("SELECT `verification_number` AS f FROM `admin_users` WHERE `user_distributor`='$user_distributor'");
										$nettype=$db->getValueAsf("SELECT `network_type` AS f FROM `exp_mno_distributor` WHERE `verification_number`='$vernum'");
										
										if($nettype=='GUEST'){
											 
											$key_query.=" AND session_type='Guest'";
											 
										}elseif($nettype=='PRIVATE'){
											 
											$key_query.=" AND session_type='Private'";
										}
										
										

										?>

										</tbody>

									</table>
									<style>
                        #device_sessions_processing{
                            -webkit-box-pack: center;
                            -ms-flex-pack: center;
                                justify-content: center;
                        margin-left: 0;
                        -webkit-box-align: center;
                            -ms-flex-align: center;
                                align-items: center;
                        background: rgba(255,255,255,0.6);
                        display: -webkit-box;
                        display: -ms-flexbox;
                        display: flex;
                        width: 100%;
                        top: 0;
                        bottom: 0;
                        left: 0;
                        margin-left: 0;

                        }
                    </style>
					<script type="text/javascript">
                                   $(document).ready(function() {
                            $('#device_sessions').on( 'processing.dt', function ( e, settings, processing ) {
        $('#device_sessions_processing').css( 'display', processing ? '' : 'none' );
    } ).DataTable({
                                "deferRender": true,
                                "processing": true,
                                "data":<?php echo json_encode($tb_arr_data) ?>,
                                       "pageLength": <?php echo $default_table_rows; ?>,
                                       "columns": [
                                         null,
                                         null,
                                         null,
                                         <?php if($private_module==1){ ?>
                                         null,
                                         <?php } ?>
                                         null,
                                         null,
                                         null,
                                         null,
                                         null,
                                         { "orderable": false },
                                         { "orderable": false }
                                       ],
                                       "autoWidth": false,
                                       "language": {
                                          "emptyTable": "No Device"
                                        },
										"drawCallback": function () {
                                    new Tablesaw.Table("#device_sessions").destroy();
                                    Tablesaw.init();
                                    $("input:checkbox:not(#manual_passcode,#auto_passcode,.hide_checkbox)").after("<label style='display: inline-block; margin-top: 10px;'></label>");
                                },
                                       /*"language": {
                                         "lengthMenu": "Per page _MENU_ "
                                      },
         */
                                      "bFilter" : false,

                                       "lengthMenu": '[[100, 250, 500, -1], [100, 250, 500, "All"]]'

                                     });
                                   });
                                 </script>
										</div>
										</div>
										</div>
								</form>

								
									<p><b>DETERMINE IF A SESSION IS AVAILABLE: </b>If no device or session is available you can add the device manually in Step 4 below. If a session is available, but the customer still cannot access the Internet, click Delete Device followed by deleting any sessions remaining for the device. Then add the device manually as per Step 4.
									</p>
									

									<p><b>ADD DEVICE:</b> Enter the MAC address in the Add dialog field and click "Add".
									</p>


									<form action="?t=tier_support" class="form-horizontal" method="post" id="add_mac_form" name="add_mac_form">

                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls form-group">
												<input type="text"  name="add_mac" class="span4" id="add_mac" maxlength="17" placeholder="xx:xx:xx:xx:xx:xx" data-fv-regexp="true"  autocomplete="off"  data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. Acceptable formats are: aa:bb:cc:dd:ee:ff, aa-bb-cc-dd-ee-ff, or aabbccddeeff in lowercase or all CAPS."/>
                                                    <button type="submit" name="add_mac_sessions" id="add_mac_sessions" class="btn btn-primary inline-btn"> Add</button>
                                                    <input type="hidden" name="tocked" value="<?php echo $_SESSION['FORM_SECRET']?>">
                                                </div>
                                            </div>
                                        </fieldset>
										
									</form>

									<p><b>VERIFY ACTIVE SESSION: </b>After the device is added, verify the device has an active session using the Search function. Ask the customer to refresh their browser and verify access to the Internet. If the customer has Internet access, the issue has been resolved. If the customer still cannot access the Internet, click Delete Session to remove the session. To re-initiate the Device Session, ask the customer to refresh the browser once again. </p>
									

								</div>