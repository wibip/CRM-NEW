<div <?php if(isset($tab_blacklist_mac)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="blacklist_mac">



                                                <!--whitelist form-->

                                                <form name="whitelist_form" id="whitelist_form" class="form-horizontal" method="post" action="?t=blacklist_mac" onsubmit="return macvalidate();">
                                                <div class="form-group">
                                                
                                                
                                                
                                                   <fieldset>

                                                       <!-- <input type="hidden" id="check_post_val" name="blacklist_all_search_dis"> -->

                                                       <h3>Search MAC Address</h3>

                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">MAC Address</label>

                                                            <div class="controls col-lg-5 form-group">

                                                                <!--pattern="^[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}:[0-9A-Fa-f]{2}$"-->

                                                                    <input maxlength="17" autocomplete="off" type="text" id="search_mac" name="search_mac" class="span4" data-toggle="tooltip" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">

                                                                    <small id="mac_val" class="help-block" data-fv-validator="regexp" data-fv-for="search_mac" data-fv-result="NOT_VALIDATED" style="display: none;"><p>Please enter a valid MAC address matching the pattern with the value range from 0-9, A-F</p></small>
                                                           

                                                            </div>
                                                        </div>
                                                        
                                                        
                                                         <div class="form-actions border-non">
                                                        
                                                        
                                                                    <button name="blacklist_mac_search" id="blacklist_mac_search" type="submit" class="btn btn-primary" style="text-decoration:none">Search</button>
                                                                    <button id="blacklist_all_search_b1" type="button" class="btn btn-info inline-btn" style="text-decoration:none">List all disabled MACs</button>
                                                        
                                                        </div>
                                                        
                                                    </fieldset>
                                                </div>
                                                     </form>

                                                     <div style="display:none">
                                                <form  class="form-horizontal" method="post" action="?t=blacklist_mac">
                                                <input type="hidden" id="check_post_val" name="blacklist_all_search_dis">
                                                <button id="blacklist_all_search" type="submit" class="btn btn-info inline-btn" style="text-decoration:none">List all disabled MACs</button>

                                                </form>
                                                                </div>

                                                      <!--blacklist form-->
                                                <h2>Manage MAC Addresses</h2>

                                                <br>

                                                <form name="blacklist_form" id="blacklist_form" class="form-horizontal" method="post" action="?t=blacklist_mac">
                                                <div class="form-group">
                                                   <fieldset>

                                                            <h3>Add MAC Address</h3>


                                                        <div class="control-group">
                                                            <label class="control-label" for="radiobtns">MAC Address</label>

                                                            <div class="controls col-lg-5 form-group">

                                                                    <input maxlength="17" data-toggle="tooltip"  autocomplete="off" type="text" id="black_mac" name="black_mac" class="span4" title="The MAC Address can be added manually or you can paste in an address. The system will autoformat the MAC Address to either aa:bb:cc:dd:ee:ff or AA:BB:CC:DD:EE:FF.">
                                                                <small id="bl_mac_ext" class="help-block" style="display: none;"></small>

                                                                <script type="text/javascript">

                                                                $(document).ready(function() {
                                                                    
                                                                     $('#black_mac').tooltip(); 
                                                                     $('#search_mac').tooltip(); 

                                                                });

                                                                    function vali_blacklist(rlm) {

                                                                        var val = rlm.value;
                                                                        var val = val.trim();



                                                                        if(val!="") {
                                                                            document.getElementById("bl_mac_ext").innerHTML = "<img src=\"img/loading_ajax.gif\">";
                                                                            var formData = {blmac: val, user: "<?php echo $user_distributor; ?>"};
                                                                            $.ajax({
                                                                                url: "ajax/validateblacklist.php",
                                                                                type: "POST",
                                                                                data: formData,
                                                                                success: function (data) {
                                                                                   

                                                                                    if (data == '1') {
                                                                                        /*   document.getElementById("img").innerHTML = "<img src=\"img/Ok.png\">";   */
                                                                                        document.getElementById("bl_mac_ext").innerHTML ="";
                                                                                        $('#bl_mac_ext').hide();
                                                                                        

                                                                                    } else if (data == '2') {
                                                                                        //inline-block
                                                                                        
                                                                                        $('#bl_mac_ext').css('display', 'inline-block');
                                                                                        document.getElementById("bl_mac_ext").innerHTML = "<p>The MAC ["+val+"] you are trying to add is already disabled, please try a different MAC.</p>";
                                                                                        document.getElementById('black_mac').value = "";
                                                                                        /* $('#mno_account_name').removeAttr('value'); */
                                                                                        document.getElementById('black_mac').placeholder = "Please enter new MAC";
                                                                                    }
                                                                                },
                                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                                    //alert("error");
                                                                                    document.getElementById('black_mac').value = "";
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                    
                                                                    

                                                                </script>

                                                            </div>
                                                            
                                                        </div>
                                                        
                                                         <div class="control-group">
                                                            <div class="controls col-lg-5 form-group">
                                                            <!-- <div style="display: none" id="bl_mac_ext"></div> -->
                                                            </div>
                                                            </div>
                                                        
                                                        <!-- /control-group -->



                                                       <div class="control-group" id="search_time_range" >
                                                            <label class="control-label" for="radiobtns">Suspension Period</label>

                                                            <div class="controls">
                                                                <div class="input-prepend input-append">
                                                                    <select autocomplete="off" class="span4" name="blacklist_period" id="blacklist_period">
                                                                        
                                                                    <option value="PT24H">24 Hours</option>
                                                                        <option value="PT48H">48 Hours</option>
                                                                        <option value="P7D">1 Week</option>
                                                                        <option value="P14D">2 Weeks</option>
                                                                        <option value="P28D">4 Weeks</option>
                                                                        <option value="P91D">13 Weeks</option>
                                                                        <option value="P182D">26 Weeks</option>
                                                                        <option value="P364D">52 Weeks</option>
                                                                        <option value="P21D">21 Days</option>
                                                                        <option value="P180D">180 Days</option>
                                                                        <option value="P3Y">3 Years</option>
                                                                        <option value="indefinite">Indefinite</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- /controls -->
                                                        </div>
                                                        <!-- /control-group -->

                                                       <div class="form-actions border-non">

                                                           <input type="hidden" name="black_form_secret" value="<?php echo $secret; ?>">
                                                           <br><br>
                                                           <button disabled name="blacklist" id="blacklist" type="submit" class="btn btn-primary" style="text-decoration:none">
                                                               <i class="btn-icon-only icon-download"></i> Add MAC Address

                                                           </button>

                                                            <?php
                                                           $customer_down_key_string = "task=all_blacklist&mno_id=".$user_distributor."&user=cox";
                                                           $customer_down_key =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string);
                                                           $customer_down_key =  urlencode($customer_down_key);
                                                           ?>
                                                           &nbsp;&nbsp;<a href="ajax/export_customer.php?key=<?php echo $customer_down_key?>" class="btn btn-primary" style="text-decoration:none">
                                                               <i class="btn-icon-only icon-download"></i>Download all blocked MACs
                                                           </a>

                                                       </div>
                                                    </fieldset>
                                                    </div>
                                                </form>
                                                <div class="widget widget-table action-table">
                                                    <div class="widget-header">
                                                        <!--  <i class="icon-th-list"></i> -->

                                                        <h3>Session Search Result</h3>
                                                    </div>
                                                    <!-- /widget-header -->
                                                    <div class="widget-content table_response">
                                                        <div style="overflow-x:auto">
                                                            <table id="blacklist_search_table" class="table table-striped table-bordered tablesaw" cellspacing="0" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Device MAC</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3">Blacklist Date</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Suspension</th>
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Whitelist Date</th>
                                                                   <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">remove MAC</th> -->
                                                                  
                                                                  <?php if(isset($_POST[blacklist_mac_search])){ ?>
                                                                   <!-- <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Whitelist type</th> -->
                                                                  
                                                                  
                                                                  <?php }?>
                                                                  
                                                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">WIFI</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                
                                                                if(isset($_POST[blacklist_all_search])){
                                                                    
                                                                    $get_blacklist_q="SELECT *,'main' as ar FROM exp_customer_blacklist WHERE mno='$user_distributor'";
                                                                    
                                                                }elseif(isset($_POST[blacklist_mac_search])){
                                                                    
                                                                $ser_mac=$_POST[search_mac];
                                                                $ser_mac = str_replace(':', '', $ser_mac);
                                                                $ser_mac = str_replace('-', '', $ser_mac);

                                                                $get_blacklist_q="SELECT *,'main' as ar, type as type1 FROM exp_customer_blacklist WHERE mno='$user_distributor' and mac='$ser_mac'";
                                                                /*$new_get_blacklist_q="SELECT *,'arc' as ar, IF(type='Manual', 'Manual', 'Automatic') as type1 FROM exp_customer_blacklist_archive WHERE mno='$user_distributor' and mac='$ser_mac'";
                                                                $get_blacklist_new = mysql_query($new_get_blacklist_q);
                                                                while ($blacklist_row_new = mysql_fetch_assoc($get_blacklist_new)){
                                                                        $whitelist_type=$blacklist_row_new['type1'];
                                                                      }*/

                                                                    
                                                                }else{
                                                                    $get_blacklist_q="";
                                                                    
                                                                }
                                                                


                                                                //$get_blacklist_q="SELECT * FROM exp_customer_blacklist WHERE mno='$user_distributor'";
                                                                $get_blacklist_r = $db->selectDB($get_blacklist_q);

                                                                    foreach ($get_blacklist_r['data'] as $blacklist_row) {
                                                                        $device_mac=$blacklist_row['mac'];
                                                                        $device_mac_display = $db->macFormat($device_mac,$mac_format);
                                                                        
                                                                        $rwid=$blacklist_row['id'];

                                                                        $tz = new DateTimeZone($mno_time_zone);

                                                                        //convert blacklist date
                                                                        $blacklist_date = date_create();
                                                                        date_timestamp_set($blacklist_date, $blacklist_row['bl_timestamp']);
                                                                        $blacklist_date->setTimezone($tz);
                                                                        $blacklist_date=$blacklist_date->format('m/d/Y h:i A');


                                                                        //convert whitelist name
                                                                        $whitelist_date  = date_create();
                                                                        date_timestamp_set($whitelist_date, $blacklist_row['wl_timestamp']);
                                                                        $whitelist_date->setTimezone($tz);
                                                                        $whitelist_date=$whitelist_date->format('m/d/Y h:i A');


                                                                        $suspension=$blacklist_row['period'];
                                                                        
                                                                        if($suspension=='indefinite'){
                                                                            
                                                                            $gap='Indefinite';
                                                                            $whitelist_date='N/A';
                                                                        }else{

                                                                        $gap = "";
                                                                        if($suspension != ''){

                                                                            $interval = new DateInterval($suspension);

                                                                            if($interval->y != 0){
                                                                                $gap .= $interval->y.' Years ';
                                                                            }
                                                                            if($interval->m != 0){
                                                                                $gap .= $interval->m.' Months ';
                                                                            }
                                                                            if($interval->d != 0){
                                                                                $gap .= $interval->d.' Days ';
                                                                            }
                                                                            if(($interval->y != 0 || $interval->m != 0 || $interval->d != 0) && ($interval->i != 0  || $interval->h != 0) ){
                                                                                $gap .= ' And ';
                                                                            }
                                                                            if($interval->h != 0){
                                                                                $gap .= $interval->h.' Hours ';
                                                                            }
                                                                            if($interval->i != 0){
                                                                                $gap .= $interval->i.' Minutes ';
                                                                            }

                                                                        }
                                                                        
                                                                        }

                                                                        $remove_mac='<a href="javascript:void();" id="do_white_mac'.$blacklist_row["id"].'" class="btn btn-small btn-primary">
                                                                                        <i class="btn-icon-only icon-info-sign"></i>&nbsp;Remove</a>
                                                                                        <script type="text/javascript">
                                                                                            $(document).ready(function() {
                                                                                            $(\'#do_white_mac'.$blacklist_row["id"].'\').easyconfirm({locale: {
                                                                                                    title: \'Whitelist MAC\',
                                                                                                    text: \'Are you sure you want to whitelist this MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                                    button: [\'Cancel\',\' Confirm\'],
                                                                                                    closeText: \'close\'
                                                                                                     }});
                                        
                                                                                                $(\'#do_white_mac'.$blacklist_row["id"].'\').click(function() {
                                                                                                    window.location = "?wl_secret='.$secret.'&t=blacklist_mac&wl_id='.$blacklist_row["id"].'"
                                        
                                                                                                });
                                        
                                                                                                });
                                        
                                                                                            </script>
                                                                                        ';
                                                                        echo'<tr>
                                                                            <td>'.$device_mac_display.'</td>
                                                                            <td>'.$blacklist_date.'</td>
                                                                            <td>'.$gap.'</td>
                                                                            <td>'.$whitelist_date.'</td>';

                                                                        /*if(isset($_POST[blacklist_mac_search])){
                                                                          
                                                                           echo '<td>'.$whitelist_type.'</td>';
                                                                           
                                                                        }*/
                                                                        
                                                                        $isenn=$blacklist_row['is_enable'];
                                                                        $main_tbl=$blacklist_row['ar'];
                                                                        
                                                                        echo '<td>';
                                                                        
                                                                        if($main_tbl=='main'){
                                                                            
                                                                            
                                                                        if($isenn=='1'){

                                                                   /* echo   '<div class="toggle2"><input onchange="" type="checkbox" class="hide_checkbox">
                                                                             <a href="javascript:void();" id="ST_'.$rwid.'"><span class="toggle2-on-dis">Enable</span></a>
                                                                    <span class="toggle2-off">Disable</span>
                                                                    </div>'; */

                                                                    echo '<a class="btn btn-info" href="javascript:void();" id="ST_'.$rwid.'">Enable</a>';
                                                                             
                                                                          

                                                                    echo '<script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#ST_'.$rwid.'\').easyconfirm({locale: {

                                                                            title: \'Enable MAC\',

                                                                            text: \'Are you sure you want to enable this MAC?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#ST_'.$rwid.'\').click(function() {



                                                                        window.location = "?t=blacklist_mac&modify_bl_en=2&is_enable=0&id='.$rwid.'"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                        
                                                                        
                                                                            
                                                                        }else{
                                                                            echo  '<div class="toggle2"><input checked onchange="" href="javascript:void();" id="ST_'.$rwid.'" type="checkbox" class="hide_checkbox"><span class="toggle2-on">Enable</span>
                                                                            <a href="javascript:void();" id="CE_'.$rwid.'"><span class="toggle2-off-dis">Disable</span></a>
                                                                        </div>'; 
                                                                     

                                                                    
                                                              echo '<script type="text/javascript">

                                                                    $(document).ready(function() {

                                                                    $(\'#CE_'.$rwid.'\').easyconfirm({locale: {

                                                                            title: \'Disable MAC\',

                                                                            text: \'Are you sure you want to disable this  MAC?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',

                                                                            button: [\'Cancel\',\' Confirm\'],

                                                                            closeText: \'close\'

                                                                             }});

                                                                        $(\'#CE_'.$rwid.'\').click(function() {

                                                                            window.location = "?t=blacklist_mac&modify_bl_en=2&is_enable=1&id='.$rwid.'"

                                                                        });

                                                                        });

                                                                    </script>';
                                                                            
                                                                            
                                                                        }
                                                                            
                                                                            
                                                                        }else{
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    echo '</td>';

                                                                            
                                                                            
                                                                            echo '</tr>';
                                                                    }

                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                </div>