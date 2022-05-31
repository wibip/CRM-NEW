 
                                            <div <?php if(isset($tab_quaterly_seesion)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="quaterly_seesion">






                                     <form name="lawful_form2" id="lawful_form2" class="form-horizontal" method="post" action="?t=quaterly_seesion" onchange="change_li_view()">
                                                <div class="form-group">
                                                   <fieldset>



                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Public IP Address</label>

                                                            <div class="controls col-lg-5 form-group">
                                                                
                                                                    <input autocomplete="off" type="text" id="ipaddress2" name="ipaddress2" class="span2 li_download_class form-control">

                                                                    

                                                                     </div>

                                                        </div>
                                                        <!-- /control-group -->

                                                        <div class="control-group" id="search_time_range" >
                                                            <label class="control-label" for="radiobtns">Period</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select autocomplete="off" class="span2" name="session_period" id="session_period">
                                                                        
                                                                        <option value="PT24H">Last 24 Hours</option>
                                                                        <option value="PT7D">Last 7 Days</option>
                                                                        <option value="PT30D">Last 30 Days</option>
                                                                        <option value="PT3M">Last 3 Months</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <script type="text/javascript">
                                                            $('.inline_error').on('change',function(){
                                                                $( function() {
                                                                    $( "#to_li_date2").datepicker( "option", "minDate", $( "#from_li_date2" ).datepicker( "getDate" ));
                                                                    $( "#from_li_date2").datepicker( "option", "maxDate", $( "#to_li_date2" ).datepicker( "getDate" ));
                                                                   $('#lawful_form2').formValidation('revalidateField', 'dob');
                                                                } );



                                                            });
                                                           
                                                        



                                                        </script>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                         <div class="form-actions">
                                                            <input type="hidden" name="secret2" value="<?php echo $secret;?>">
                                                                <button name="li_view2" id="li_view2"  type="submit" class="btn btn-primary" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Generate Report

                                                                <?php if($camp_layout!="COX"){ ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                            $("#li_view2").easyconfirm({locale: {
                                                                            title: 'Historical Sessions',
                                                                            text: 'Are you sure you want to view the historical session report?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                                            button: ['Cancel',' Confirm'],
                                                                            closeText: 'close'
                                                                            }});
                                                                            $("#li_view2").click(function() {

                                                                            });
                                                                        });
                                                                    </script>

                                                                    <?php } ?>
                                                    </button>

                                                            <?php
                                                            if($li_success2=='success'){
                                                            ?>
                                                            <a id="li_download2" href="ajax/export_report.php?li_report_q=<?php echo $li_view_id2; ?>&user_name=<?php echo $user_name; ?>" class="btn btn-info" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Download as CSV</a>
                                                            <?php }  ?>
                                                            </div>
                                                        
                                                        
                                                        
                                                        

                                                       <?php
                                                            if($li_success2=='success'){
                                                       ?>

                                                       <div class="widget widget-table action-table">
                                                           <div class="widget-header">
                                                               <h3>Quarterly Historical Sessions Report</h3>
                                                           </div>

                                                           <div class="widget-content table_response">
                                                               <div style="overflow-x:auto;" >
                                                                   <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                       <thead>
                                                                       <tr>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">PUBLIC IP</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">CUSTOMER ACCOUNT NUMBER</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">START Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">End Time</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">DURATION (Sec)</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="6">DEVICE MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="7">AP/AC MAC</th>
                                                                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">AC/WAG</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">VLAN</th>
                                                                          
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">DL (Bytes)</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">UP (Bytes)</th>
                                                                           
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">PROPERTY ID</th>
                                                                           
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">SSID/Network</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range From</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Port Range To</th>
                                                                           <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="10">Internal IP</th>
                                                                       </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                       <?php

                                                                      $key_query="SELECT
                                                                                  IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS public_ip,
                                                                                  IF(nas_type = 'ac',l.framed_ip_address,'') AS internal_ip,
                                                                                  IF(l.`session_start_time`='0','',FROM_UNIXTIME(l.`session_start_time`,'%m/%d/%Y %h:%i %p')) AS 'Session_start_time',
                                                                                  FROM_UNIXTIME(l.`unixtimestamp` / 1000, '%m/%d/%Y %h:%i %p') AS 'Session_End_Time',
                                                                                  l.`acct_session_time` AS 'Duration',
                                                                                  l.`vlan_id` AS 'VLAN',
                                                                                  l.`nas_identifier1` AS 'AC_WAG',
                                                                                  l.`session_mac` AS 'MAC',
                                                                                  l.`acct_input_octets` AS 'Down',
                                                                                  l.`acct_output_octets` AS 'Up',
                                                                                  l.`grp_realm` AS 'ICOMS',
                                                                                  d.`property_id` AS 'Property_ID',
                                                                                  l.`called_station_id` AS 'AP_MAC',
                                                                                  l.`nas_port_id` AS 'SSID',
                                                                                  l.`nas_port_range` AS 'Port_Range',
                                                                                  l.`dhcp_ip` AS 'dhcp_ip'
                                                                                  
                                                                                FROM
                                                                                  `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
                                                                                  ON l.`grp`=d.`verification_number`
                                                                                WHERE
                                                                                `uniqid_id`='$li_view_id2'";

                                                                                //echo $key_query; die();


                                                                       $query_results=$db->selectDB($key_query);
                                                                      
                                                                       foreach ($query_results['data'] AS $row) {

                                                                        
                                                                        $public_ip_display = $row[public_ip];
                                                                        $Session_start_time_display = $row[Session_start_time];
                                                                        $Session_End_Time_display = $row[Session_End_Time];
                                                                        $Duration_display = $row[Duration];
                                                                        $VLAN_display = $row[VLAN];
                                                                        $AC_WAG = $row[AC_WAG];
                                                                        $MAC_display = $row[MAC];
                                                                        $Down_display = $row[Down];
                                                                        $Up_display = $row[Up];
                                                                        $ICOMS_display = $row[ICOMS];
                                                                        $Property_ID_display = $row[Property_ID];
                                                                        $AP_MAC_display = $row[AP_MAC];
                                                                        $SSID_display = $row[SSID];
                                                                        $Port_Range_display = $row[Port_Range];
                                                                        $internal_ip_display = $row[internal_ip];
                                                                        
                                                                        if(strlen($public_ip_display)==0){
                                                                            $public_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        if($AC_WAG==ac){
                                                                            $AC_WAG = 'AC';
                                                                        }
                                                                        if($AC_WAG==wag){
                                                                            $AC_WAG = 'WAG';
                                                                        }
                                                                        
                                                                        if(strlen($AC_WAG)==0){
                                                                            $AC_WAG = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(strlen($Session_start_time_display)==0){
                                                                            $Session_start_time_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Session_End_Time_display)==0){
                                                                            $Session_End_Time_display = 'N/A';
                                                                        }                                                                           
                                                                        if(strlen($Duration_display)==0){
                                                                            $Duration_display = 'N/A';
                                                                        }
                                                                        if(strlen($VLAN_display)==0){
                                                                            $VLAN_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($MAC_display)==0){
                                                                            $MAC_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Down_display)==0){
                                                                            $Down_display = 'N/A';
                                                                        }
                                                                        
                                                                        if(strlen($Up_display)==0){
                                                                            $Up_display = 'N/A';
                                                                        }   
                                                                        if(strlen($ICOMS_display)==0){
                                                                            $ICOMS_display = 'N/A';
                                                                        }   
                                                                        if(strlen($Property_ID_display)==0){
                                                                            $Property_ID_display = 'N/A';
                                                                        }   
                                                                        if(strlen($AP_MAC_display)==0){
                                                                            $AP_MAC_display = 'N/A';
                                                                        }   
                                                                        if(strlen($SSID_display)==0){
                                                                            $SSID_display = 'N/A';
                                                                        }   
                                                                       
                                                                        
                                                                        if(strlen($internal_ip_display)==0){
                                                                            $internal_ip_display = 'N/A';
                                                                        }
                                                                        
                                                                        
                                                                        $row_ar=explode('-',$row[Port_Range]);
                                                                        
                                                                        if(strlen($row_ar[0])==0){
                                                                            $row_ar[0] = 'N/A';
                                                                        }
                                                                        if(strlen($row_ar[1])==0){
                                                                            $row_ar[1] = 'N/A';
                                                                        }
                                                                        
                                                                           echo '<tr>';
                                                                           echo '<td>'.$public_ip_display.'</td>';
                                                                           echo '<td>'.$ICOMS_display.'</td>';
                                                                           echo '<td>'.$Session_start_time_display.'</td>';
                                                                           echo '<td>'.$Session_End_Time_display.'</td>';
                                                                           echo '<td>'.$Duration_display.'</td>';
                                                                           echo '<td>'.$MAC_display.'</td>';
                                                                           echo '<td>'.$AP_MAC_display.'</td>';
                                                                           echo '<td>'.$AC_WAG.'</td>';
                                                                           
                                                                           echo '<td>'.$VLAN_display.'</td>';
                                                                          
                                                                           echo '<td>'.$Down_display.'</td>';
                                                                           echo '<td>'.$Up_display.'</td>';
                                                                           
                                                                           echo '<td>'.$Property_ID_display.'</td>';
                                                                          
                                                                           echo '<td>'.$SSID_display.'</td>';
                                                                           
                                                                           echo '<td>'.$row_ar[0].'</td>';
                                                                           echo '<td>'.$row_ar[1].'</td>';
                                                                           echo '<td>'.$internal_ip_display.'</td>';
                                                                           echo '</tr>';
                                                                       }

                                                                       ?>

                                                                       </tbody>
                                                                   </table>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <?php }
                                                                else{
                                                                    echo '';
                                                                }
                                                       ?>
                                                       


                                                            <!-- /form-actions -->



                                                    </fieldset> 
                                                    </div>
                                                </form>

<script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                    document.getElementById("li_view2").disabled = true;
                                                                    
                                                                });


                                                                $('#ipaddress2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });


                                                                $('#from_li_date2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });


                                                                $('#to_li_date2').keyup(function (e) {
                                                                    
                                                                    change_li_view2();
                                                                });

                                                                
                                                                function change_li_view2(){

                                                                    if(($('#ipaddress2').val()!='')&&($('#from_li_date2').val()!='')&&($('#to_li_date2').val()!='')){
                                                                        document.getElementById("li_view2").disabled = false;
                                                                        //console.log('f');
                                                                        }
                                                                    else{
                                                                        document.getElementById("li_view2").disabled = true;
                                                                        //console.log('t');
                                                                    }
                                                                        }
                                                                
                                                                </script>

                                            

                                            </div>