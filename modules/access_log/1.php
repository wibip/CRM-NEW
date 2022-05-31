 								<div <?php if(isset($tab_access_log)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="access_log">

									<h1 class="head" style="display: none">Access Logs</h1>
									<br>

									<div id="response_d3">

									</div>
									<p>Search logs to identify failures during the device onboarding process.</p>
									<br/>



									<p><b>Step 1. </b>REVIEW ACCESS LOGS:
										Enter the customer information in the search dialog fields below to filter the access logs as required and click Search.  
									</p>
									<p><b>Step 2. </b>LOGS:
										Please note the LOG ID for the first error reported during the onboarding process. Submit the LOG ID to the system administrator for review.  Return to the Support menu to onboard the customer's device manually.
									</p>



									<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=access_log">
										<fieldset>


											<?php
											echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
											?>
											<input type="hidden" name="access_lg" id="access_lg" value="access_lg" />



											<div class="control-group">
												<label class="control-label" for="mac2">MAC</label>
												<div class="controls">
													<input class="span2"  id="mac2" name="mac2" maxlength="17" type="text" oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >
												</div>
											</div>
											<script type="text/javascript">

         function mac_val(element) {



             setTimeout(function () {
               var mac = $('#mac2').val();

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");

              // alert(mac);
               var result ='';
               var len = mac.length;

              // alert(len);

              var regex = /^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/;



               if(regex.test(mac)==true){

            //  if( (len<5 && mac.charAt(3)==':') || (len<8 && mac.charAt(3)==':' && mac.charAt(6)==':') || (len<11 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':') || (len<14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':') || (len>14 && mac.charAt(3)==':' && mac.charAt(6)==':' && mac.charAt(9)==':' && mac.charAt(12)==':' && && mac.charAt(15)==':') ){

                }else{

               /*for (i = 0; i < len; i+=2) {




                 if(i==10){

                   result+=mac.charAt(i)+mac.charAt(i+1);

                   }else{

                 result+=mac.charAt(i)+mac.charAt(i+1)+':';

                   }



               }*/

               var pattern = new RegExp( "[/-]", "g" );
               var mac = mac.replace(pattern,"");
               var pattern1 = new RegExp( "[/:]", "g" );
               mac = mac.replace(pattern1,"");

               var mac1 = mac.match(/.{1,2}/g).toString();

               var pattern = new RegExp( "[/,]", "g" );

               var mac2 = mac1.replace(pattern,":");


               document.getElementById('mac2').value = mac2;

               $('#device_form').formValidation('revalidateField', 'mac2');


                }


             }, 100);


         }

         $("#mac2").on('paste',function(){

          mac_val(this.value);

         });


         </script>




                     <script type="text/javascript">

                             $(document).ready(function() {

                              $('#mac2').change(function(){


                                 $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))


                                });



                               $('#mac2').keyup(function(e){
                                 var mac = $('#mac2').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac2').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
                                });


                               $('#mac2').keydown(function(e){
                                 var mac = $('#mac2').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac2').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }





                                 // Allow: backspace, delete, tab, escape, enter, '-' and .
                                 if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190]) !== -1 ||
                                       // Allow: Ctrl+A, Command+A
                                     (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+C, Command+C
                                     (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+x, Command+x
                                     (e.keyCode == 88 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: Ctrl+V, Command+V
                                     (e.keyCode == 86 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                                       // Allow: home, end, left, right, down, up
                                     (e.keyCode >= 35 && e.keyCode <= 40)) {
                                   // let it happen, don't do anything
                                   return;
                                 }
                                 // Ensure that it is a number and stop the keypress
                                 if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 70)) {
                                   e.preventDefault();

                                 }
                               });


                             });

                             </script>

											<div class="control-group">
												<label class="control-label" for="email_2">E-mail</label>
												<div class="controls">
													<?php echo '<input class="span2" id="email_2" name="email_2" value="'.$email_2.'" type="text">' ?>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="limit2">Limit</label>
												<div class="controls">
													<?php if(!isset($limit2)){$limit2=100;} echo '<input placeholder="50" class="span2" id="limit2" name="limit2" value="'.$limit2.'" type="text">' ?>
												</div>
											</div>
<script type="text/javascript">

                                             $("#limit2").keypress(function(event){
                                                                var ew = event.which;
                                                                if(ew == 8||ew == 0)
                                                                    return true;
                                                                if(48 <= ew && ew <= 57)
                                                                    return true;
                                                                return false;
                                                            });



                                            </script>

											<div class="control-group">
												<label class="control-label" for="radiobtns">Period</label>

												<div class="controls">
													<div class="input-prepend input-append">

														<input class="span2" id="start_date2" name="start_date2"
															   type="text"  max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>" value="<?php if(isset($mg_start_date2)){echo $mg_start2;} ?>">
														to
														<input class="span2" id="end_date2" name="end_date2" type="text" max=<?php echo  date("Y-m-d"); ?>
														value="<?php if(isset($mg_end_date2)){echo $mg_end2;} ?>">

													</div>
												</div>
												<!-- /controls -->
											</div>

											<div class="form-actions">
												<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">Search</button>
											</div>


										</fieldset>
									</form>

									<div class="widget widget-table action-table tablesaw-minimap-mobile">
										<div class="widget-header">
											<!-- <i class="icon-th-list"></i> -->
											<?php
											//echo $query_2;
											$row_count2 = count($query_results2);
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
											<div style="overflow-x:auto">
											<table id="access_logs" class="table table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
												<thead>
												<tr>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2" width="10px">#</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Log ID</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">E-mail</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Description</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Access Details</th>
													<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Date</th>


												</tr>
												</thead>
												<tbody>

												<?php


												$color_var = 1;
												$get_val = 0;
												$step = 0;
												foreach ($query_results2 as $row) {
													$ssid = $row->ssid;


                                                    if(empty($ssid) || $ssid=='NA' || $ssid=='N/A'){
                                                    	$ssid="N/A";
                                                        $other_param_array = json_decode($row->other_parameters,true);

                                                        if(array_key_exists('location-id',$other_param_array)){
                                                            //$ssid=$other_param_array['location-id'];
                                                        }
                                                    }


													$id = $row->id;
													$mac = $row->mac;
													$email = $row->email;
													$description = $row->description;
													$access_details = $row->access_details;
													$create_date = $row->create_date;
													$token_id = $row->token_id;
													//$row_log->id=$row['id'];

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


													if($mac==$email || $email==''){

														$email='N/A';
													}

													echo '<td> '.$step.' </td>
														<td> '.$id.' </td>
													
														<td> '.$db->macFormat($mac,$mac_format).' </td>
														<td> '.$email.' </td>
														<td> '.$description.' </td>
														<td> <input type="text" class="invisibletb" value="'.$access_details.'"/> </td>
														<td> '.$create_date.' </td>';

													//$token_id.'<br>'.$access_details

												}

												?>
												<style type="text/css">
													.invisibletb{
														border:none;
														width:100%;
														height:100%;
													}
												</style>


												</tbody>
											</table>
										</div>
										</div>
										<!-- /widget-content -->
									</div>


								</div>