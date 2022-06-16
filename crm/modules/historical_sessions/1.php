 <!--**********LI tab-->

                                            <div <?php if(isset($tab_historical_sessions)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="historical_sessions">

                                <!--            <p>
                                            Lawful interception (LI) is obtaining communications network data pursuant to lawful authority for the purpose of analysis or evidence. Such data generally consist of signalling or network management information or, in fewer instances, the content of the communications.                                                <br/>
                                        <br>   <font color="#19bc9c"> Step 1.</font> Enter the Public IP address provided in the Lawful Intercept (LI) request (Ex. 122.122.122.12)  <br/>
                                            <font color="#19bc9c">    Step 2.</font> Set the Date Period requested In the LI request. Our records are stored on a 12 month rolling schedule. (Ex. 01/01/2016 to 02/01/2016)  <br/>
                                            <font color="#19bc9c">    Step 3.</font> [Optional] Provide the CGN Port Number if provided in the LI Request. It will be a number between 1-65535. (Do not use spaces or comma in the number)<br/>
                                            <font color="#19bc9c">    Step 4.</font> Click the "Download as CSV" button. The report will be generated automatically and downloaded to your computer as a "comma-separated values" file for post processing.<br/>
                                        
                                            </p> --> 

                                     <form name="lawful_form" id="lawful_form" class="form-horizontal" method="post" action="?t=historical_sessions" onchange="change_li_view()">
                                                <div class="form-group">
                                                   <fieldset>



                                                        <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">
                                                            <label class="" for="radiobtns">Public IP Address</label>
                                                                
                                                                    <input autocomplete="off" type="text" id="ipaddress" name="ipaddress" class="span4 li_download_class form-control">

                                                                    

                                                                     </div>

                                                                    <!-- <script>
                                                                        var pattern = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
                                                                       var x_ip = 46;
                                                                        $('#ipaddress').keypress(function (e) {
                                                                            if (e.which != 8 && e.which != 0 && e.which != x_ip && (e.which < 48 || e.which > 57)) {
                                                                                /*console.log(e.which);*/
                                                                                return false;
                                                                            }
                                                                        }).keyup(function () {
                                                                            var this1_ip = $(this);
                                                                            if (!pattern.test(this1_ip.val())) {
                                                                                $('[data-fv-for=ipaddress]').css("display", "inline-block");
                                                                               
                                                                                while (this1_ip.val().indexOf("..") !== -1) {
                                                                                    this1_ip.val(this1_ip.val().replace('..', '.'));
                                                                                }
                                                                                x_ip = 46;
                                                                            } else {
                                                                                x_ip = 0;
                                                                                var lastChar_ip = this1_ip.val().substr(this1_ip.val().length - 1);
                                                                                if (lastChar_ip == '.') {
                                                                                    this1_ip.val(this1_ip.val().slice(0, -1));
                                                                                }
                                                                                var ip_ip = this1_ip.val().split('.');
                                                                                if (ip_ip.length == 4) {
                                                                                    $('[data-fv-for=ipaddress]').css("display", "none");
                                                                                    
                                                                                }
                                                                            }
                                                                        });
                                                                    </script> -->
                                                                    
                                                               
                                                                <!-- <small style="font: xx-small; color: red" id="validate_ip"></small> -->
                                                                                                                        <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

<?php /* ?>
                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">Search Type</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select name="search_type" id="search_type">
                                                                        <option value="days">Date Range</option>
                                                                        <option value="time">Time Range</option>
                                                                    </select>
                                                                    <script>
                                                                        $('#search_type').on('change',function () {
                                                                            if($('#search_type').val()=='days'){

                                                                                $('#search_time_range').hide();
                                                                                $('#search_date_range').show();
                                                                            }else{
                                                                                $('#search_date_range').hide();
                                                                                $('#search_time_range').show();
                                                                            }
                                                                        });
                                                                    </script>

                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->
                                                        
                                                        
                                                        <?php */ ?>
                                                        



                                                       <div class="control-group">

                                                            <div class="controls col-lg-5 form-group" style="margin-bottom: 10px;">
                                                            <label class="" for="radiobtns">Date Range (GMT)</label>
                                                               
                                                                    <input autocomplete="off" type="text" class="inline_error inline_error_1 span2 li_download_class form-control li-time" name="from" id="from_li_date" placeholder="mm/dd/yyyy">

                                                                     To
                                                                     
                                                                    <input autocomplete="off" type="text" class="inline_error inline_error_2 span2 li_download_class form-control li-time" name="to" id="to_li_date" placeholder="mm/dd/yyyy">
                                                                    <input class="li-time" type="hidden" name="dob" />
                                                                    </div>
                                                                    
                                                              
                                                                <script>
                                                                    $( function() {
                                                                        $( "#from_li_date" ).datepicker({
                                                                            dateFormat: "mm/dd/yy",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
        maxDate: '0'
                                                                        });
                                                                    } );
                                                                </script>
                                                                <script>
                                                                    $( function() {
                                                                        $( "#to_li_date" ).datepicker({
                                                                            dateFormat: "mm/dd/yy",
        dayNamesMin: [ "SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT" ],
        beforeShow: function(input, inst) {
          var minDate = $('#from_li_date').datepicker('getDate');
          $('#to_li_date').datepicker('option', 'minDate', minDate);
          var dat = new Date();
          $('#to_li_date').datepicker('option', 'maxDate', dat);
          /*var maxDate = new Date(minDate.valueOf());
          maxDate.setDate(maxDate.getDate()+1);
          var dat = new Date();
          if (maxDate > dat) {
            $('#to_li_date').datepicker('option', 'maxDate', dat);
          }
          else{
            $('#to_li_date').datepicker('option', 'maxDate', maxDate);
          }*/
        }

                                                                        });
                                                                    } );
                                                                </script>
                                                            </div>
                                                            <!-- /controls -->
                                                                                                                <!-- /control-group -->





                                                       <div class="control-group" id="search_time_range" >

                                                            <div class="controls col-lg-5 form-group">

                                                            <label class="" for="radiobtns">Time Range (GMT)</label>


                                                                    <select autocomplete="off" class="span2 li_download_class li-time" name="from_time" id="from_li_time">
                                                                        <?php
                                                                        $dt = new DateTime('GMT');
                                                                        $dt->setTime(0, 0);
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        for($i=0;$i<23;$i++){
                                                                            $dt->add(new DateInterval('PT1H'));
                                                                            echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>  To
                                                                    <select autocomplete="off" class="span2 li_download_class li-time" name="to_time" id="to_li_time">
                                                                        <?php
                                                                        $dt = new DateTime('GMT');
                                                                        $dt->setTime(0, 0);
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        for($i=0;$i<23;$i++){
                                                                            $dt->add(new DateInterval('PT1H'));
                                                                            echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        }
                                                                        $dt->add(new DateInterval('PT59M59S'));
                                                                        echo '<option value="'.$dt->format('H:i:s').'">'.$dt->format('h:i A').'</option>';
                                                                        ?>
                                                                    </select>
                                                                <input type="hidden" name="timeValidation" id="timeValidation" value="valid">
                                                            </div>
                                                           <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->



                                                       <div class="control-group">

                                                            <div class="controls col-lg-5 form-group">

                                                            <label class="" for="radiobtns">CGN Port Number</label>
                                                                    <input autocomplete="off"  class="span2 form-control" name="port_number_from" id="port_number">  [1-65535] <!--  &nbsp; to
                                                                    <input type="number" min="2" max="65000" class="span2 li_download_class" name="port_number_to" id="port_number">-->
                                                                <script>
                                                                    $("#port_number").keypress(function(event){
                                                                        var ew = event.which;
                                                                        if(ew==8 || ew==0)
                                                                            return true;
                                                                        if(48 <= ew && ew <= 57)
                                                                            return true;

                                                                        return false;
                                                                    });
                                                                </script>


                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                        <script type="text/javascript">
                                                            $('.inline_error').on('change',function(){
                                                                $( function() {
                                                                    $( "#to_li_date").datepicker( "option", "minDate", $( "#from_li_date" ).datepicker( "getDate" ));
                                                                    $( "#from_li_date").datepicker( "option", "maxDate", $( "#to_li_date" ).datepicker( "getDate" ));
                                                                   $('#lawful_form').formValidation('revalidateField', 'dob');
                                                                } );



                                                            });
                                                           
                                                        



                                                        </script>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                         <div class="form-actions border-non">
                                                            <input type="hidden" name="secret" value="<?php echo $secret;?>">
                                                                <button name="li_view" id="li_view"  type="submit" class="btn btn-primary inline-btn" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Generate Report

                                                                <?php if($camp_layout!="COX"){ ?>
                                                                    <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                            $("#li_view").easyconfirm({locale: {
                                                                            title: 'Historical Sessions',
                                                                            text: 'Are you sure you want to view the historical session report?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                                            button: ['Cancel',' Confirm'],
                                                                            closeText: 'close'
                                                                            }});
                                                                            $("#li_view").click(function() {

                                                                            });
                                                                        });
                                                                    </script>

                                                                    <?php } ?>
                                                    </button>

                                                            <?php
                                                            if($li_success=='success' ){
                                                            ?>
                                                            <a id="li_download" href="ajax/export_report.php?li_report=<?php echo $li_view_id; ?>&user_name=<?php echo $user_name; ?>" class="btn btn-info inline-btn" style="text-decoration:none">
                                                                <i class="btn-icon-only icon-download"></i> Download as CSV</a>
                                                            <?php }  ?>
                                                            </div>
                                                        
                                                        
                                                        
                                                        

                                                       <?php
                                                            if($li_success=='success' ){
                                                       ?>
                                                        
                                                       <div class="widget widget-table action-table tablesaw-widget">
                                                           <div class="widget-header">
                                                               <h3>Historical Sessions Report</h3>
                                                           </div>

                                                           <div class="widget-content table_response" id="histo_table_div">
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
                                                                       /*IF(l.`session_start_time`='0','',DATE_FORMAT(l.`session_start_time`,'%m/%d/%Y %h:%i %p')) AS 'Session_start_time',
                                                                                  FROM_UNIXTIME(LEFT(l.`unixtimestamp`, 10),'%m/%d/%Y %h:%i %p') AS 'Session_End_Time',*/

                                                                      $key_query="SELECT
                                                                                  IF(nas_type = 'ac',l.nas_ip_address,l.`framed_ip_address`) AS public_ip,
                                                                                  IF(nas_type = 'ac',l.framed_ip_address,'') AS internal_ip,
                                                                                  FROM_UNIXTIME(LEFT(l.`session_start_time`, 10),'%m/%d/%Y %h:%i %p') AS 'Session_start_time',
                                                                                  FROM_UNIXTIME(LEFT(l.`session_end_time`, 10),'%m/%d/%Y %h:%i %p') AS 'Session_End_Time',
                                                                                  l.`acct_session_time` AS 'Duration',
                                                                                  l.`vlan_id` AS 'VLAN',
                                                                                  l.`nas_type` AS 'AC_WAG',
                                                                                  l.`session_mac` AS 'MAC',
                                                                                  l.`acct_input_octets` AS 'Up',
                                                                                  l.`acct_output_octets` AS 'Down',
                                                                                  l.`realm` AS 'ICOMS',
                                                                                  d.`property_id` AS 'Property_ID',
                                                                                  l.`called_station_id` AS 'AP_MAC',
                                                                                  l.`nas_port_id` AS 'SSID',
                                                                                  l.`nas_port_range` AS 'Port_Range',
                                                                                  l.`dhcp_ip` AS 'dhcp_ip'
                                                                                  
                                                                                FROM
                                                                                  `exp_li_report` l LEFT JOIN `exp_mno_distributor` d
                                                                                  ON l.`realm`=d.`verification_number`
                                                                                WHERE
                                                                                `uniqid_id`='$li_view_id'";


                                                                       $query_results=$db->selectDB($key_query);
                                                                       foreach ($query_results['data'] as $row) {

                                                                        
                                                                        $public_ip_display = $row[public_ip];
                                                                        $Session_start_time_display = date_convert($row[Session_start_time]);
                                                                        $Session_End_Time_display = date_convert($row[Session_End_Time]);
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
                                                                        if(strlen($VLAN_display)==0 || $VLAN_display==0){
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
                                                                        
                                                                        if(strlen($row_ar[0])==0 || $row_ar[0] ==0){
                                                                            $row_ar[0] = 'N/A';
                                                                        }
                                                                        if(strlen($row_ar[1])==0 || $row_ar[1] ==0 ){
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
                                                                    
                                                                    document.getElementById("li_view").disabled = true;

                                                                    $('body').on('click', '#histo_table_div .tablesaw-columntoggle-btnwrap', function(){ 
		if($(this).hasClass('visible') && ($('#histo_table_div table tbody tr').length < 7)){
            if($('#histo_table_div table tbody tr').length < 5){
                $('#histo_table_div').css('margin-bottom','300px');
            }else{
                $('#histo_table_div').css('margin-bottom','150px');
            }
			
		}else{
			$('#histo_table_div').css('margin-bottom','0px');
		}
	});
                                                                    
                                                                });


                                                                $('#ipaddress').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });


                                                                $('#from_li_date').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });


                                                                $('#to_li_date').keyup(function (e) {
                                                                    
                                                                    change_li_view();
                                                                });

                                                                
                                                                function change_li_view(){

                                                                    if(($('#ipaddress').val()!='')&&($('#from_li_date').val()!='')&&($('#to_li_date').val()!='')){
                                                                        document.getElementById("li_view").disabled = false;
                                                                        //console.log('f');
                                                                        }
                                                                    else{
                                                                        document.getElementById("li_view").disabled = true;
                                                                        //console.log('t');
                                                                    }
                                                                        }
                                                                
                                                                </script>

                                            </div>