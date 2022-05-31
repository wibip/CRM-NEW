 									<!-- /* +++++++++++++++++++++++++++++++ Exp Error Logs +++++++++++++++++++++++++++++++++++++++++++ */ -->
									<div <?php if(isset($tab_error_logs)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="error_logs">

										<h1 class="head" style="display: none">Error Logs</h1>
									<br>

									<p>Search error logs to identify failures that may be impacting the customer's experience.
									</p><br>


										<form id="error_log" name="error_log" method="post" class="form-horizontal" action="?t=error_logs">
											<fieldset>

												<div id="response_d3">
												<?php


													  if(isset($_POST['error_log_submit'])){
													  	$ssid_submit = $_POST['ssid'];
													  	$mac3_submit = $_POST['mac3'];
													  	$email_submit = $_POST['email'];
													  	$limit_submit = $_POST['limit'];

													  }
											      ?>
											  	</div>
													<?php
														echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET'].'" />';
													?>
													<input type="hidden" name="error_lg" id="error_lg" value="error_lg" />



											<div class="control-group">
												<label class="control-label" for="mac3">MAC</label>
												<div class="controls">
													<input class="span2"  id="mac3" name="mac3" maxlength="17" type="text" oninvalid="setCustomValidity('Invalid MAC format')" oninput="setCustomValidity('')" onfocus="setCustomValidity('')"  title="Format - xx:xx:xx:xx:xx:xx" pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$" >
												</div>
											</div>
											<script type="text/javascript">

         function mac_vall(element) {



             setTimeout(function () {
               var mac = $('#mac3').val();

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

               var mac3 = mac1.replace(pattern,":");


               document.getElementById('mac3').value = mac3;

               $('#device_form').formValidation('revalidateField', 'mac3');


                }


             }, 100);


         }

         $("#mac3").on('paste',function(){

          mac_vall(this.value);

         });


         </script>




                     <script type="text/javascript">

                             $(document).ready(function() {

                              $('#mac3').change(function(){


                                 $(this).val($(this).val().replace(/(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})\-?(\d{2})/,'$1:$2:$3:$4:$5:$6'))


                                });



                               $('#mac3').keyup(function(e){
                                 var mac = $('#mac3').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac3').val(function() {
                                       return $(this).val().substr(0,len) + ':' + $(this).val().substr(len);
                                       //i++;
                                     });
                                   }
                                 }
                                });


                               $('#mac3').keydown(function(e){
                                 var mac = $('#mac3').val();
                                 var len = mac.length + 1;


                                 if(e.keyCode != 8){

                                   if(len%3 == 0 && len != 0 && len < 18){
                                     $('#mac3').val(function() {
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
														<label class="control-label" for="email">E-mail</label>
														<div class="controls">
															<?php echo '<input class="span2" id="email" name="email" value="'.$email_submit.'" type="text">' ?>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="limit">Limit</label>
														<div class="controls">
															<?php if(!isset($limit_submit)){$limit_submit=100;} echo '<input placeholder="100" class="span2" id="limit" name="limit" value="'.$limit_submit.'"  type="text">' ?>
														</div>
													</div>

											<script type="text/javascript">

                                             $("#limit").keypress(function(event){
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

																<input class="span2" id="start_date" name="start_date"
																	type="text"  max="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>" value="<?php if(isset($mg_start_date)){echo $mg_start;} ?>">
																	to
																	<input class="span2" id="end_date" name="end_date" type="text" max=<?php echo  date("Y-m-d"); ?>
																	 value="<?php if(isset($mg_end_date)){echo $mg_end;} ?>">

															</div>
														</div>
														<!-- /controls -->
													</div>

													<div class="form-actions">
														<button type="submit" name="error_log_submit" id="error_log_submit" class="btn btn-primary">GO</button>
	                                                </div>

											</fieldset>
										</form>

										<div class="widget widget-table action-table tablesaw-minimap-mobile">
											<div class="widget-header">
												<!-- <i class="icon-th-list"></i> -->
												<?php
													//$row_count = count($result_error_lgs);
													$row_count = $result_error_lgs['rowCount'];
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
												 <div style="overflow-x:auto">
												<table id="error_logs_table" class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
													<thead>
														<tr>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">MAC</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">E-mail</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Error Description</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Error Comment</th>
															<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Error Time</th>
														</tr>
													</thead>
													<tbody>
														<?php
														//while($row=mysql_fetch_array($result_error_lgs)){
															
															foreach($result_error_lgs AS $row){
																echo "<tr>";
																echo "<td>".$row->ssid."</td>";
																echo "<td>".$db->macFormat($row->mac,$mac_format)."</td>";
																if($row->mac==$row->email || $row->email=='' ){
																	$re_email='N/A';
																}else{
																	$re_email=$row->email;
																	}
																echo "<td>".$re_email."</td>";
																echo "<td>".$row->description."</td>";
																echo "<td>".$row->error_details."</td>";
																echo "<td>".$row->create_date."</td>";
																echo "</tr>";
															}
														 ?>

													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>