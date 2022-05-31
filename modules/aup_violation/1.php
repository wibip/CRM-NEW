                                     <div <?php if(isset($tab_aup_violation)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?> id="aup_violation">

                                        <!-- <h1 class="head">AUP Violation</h1> -->

                
                 <?php if(isset($send_customer_mail_enable)){ //show send mail area ?>         
                        
                        
                      <h3>AUP Violation Editor</h3>
                        <p>In the below text editor you will send an email to the subscriber and post the violation message that will appear on the subscribers self-care portal. This action will also trigger a forced redirect of the user to his self care management portal to accept the violation to regain service<br/>
                        
                        Please verify that the name in the greeting line is correct and add the violation description before posting.
                        </p> <br/>  
                        
                        
                        
                        
<form id="edit-profile" class="form-horizontal" method="POST">
                                
                                
                                <?php
                              
                                
                                $cust_query = "SELECT first_name,last_name,email,username FROM mdu_vetenant WHERE customer_id = '$mg_customer_id'";
                                
                                $query_results=$db->selectDB($cust_query);
                                //while($row=mysql_fetch_array($query_results)){
                                foreach ($query_results['data'] AS $row) {
                                    $first_name = $row[first_name];
                                    $last_name = $row[last_name];
                                    $email = $row[email];
                                    $username = $row[username];
                                    
                                }
                                
                                
                                $secret=md5(uniqid(rand(), true));
                                $_SESSION['FORM_SECRET_G'] = $secret;
                                                
                                echo '<input type="hidden" name="form_secret_g" id="form_secret_g" value="'.$_SESSION['FORM_SECRET_G'].'" />';
                                echo '<input type="hidden" name="full_name" id="full_name" value="'.$first_name.' '.$last_name.'" />';
                                echo '<input type="hidden" name="email" id="email" value="'.$email.'" />';
                                echo '<input type="hidden" name="username" id="username" value="'.$username.'" />';
                                
                                $vars_aup = array(
                                        '{$user_full_name}' => $first_name.' '.$last_name,
                                        '{$user_email},'        => $email
                                
                                );
                                    
                               
                                if(strlen($db->textVal('AUP',$user_distributor))>0){  
                                    $text_aup = $db->textVal('AUP',$user_distributor);

                                }
                                else{
                                    $text_aup = $db->textVal('AUP',$system_package);
                                }

                                //echo 'AAA';
                                
                                $message_full = strtr($text_aup, $vars_aup);
                                
                                ?>
                                
                                    <fieldset>
                                                    
                            <div class="control-group">

                                                        <div class="controls">
                            <label for="radiobtns"><strong>Violation Message :</strong></label>
                                                            
                                                       

                                                            <textarea name="aup_msg" id="aup_msg" cols="150" style="" maxlength="256"  required ></textarea>
                                                                <script type="text/javascript">
                                                                    $("#aup_msg").keypress(function(event){
                                                                        var ew = event.which;
                                                                        if(ew == 34 || ew== 39 || ew==92)
                                                                            return false;
                                                                        return true;
                                                                    });

                                                                    $(function(){

                                                                        $( "#aup_msg" ).bind( 'paste',function()
                                                                        {
                                                                            setTimeout(function()
                                                                            {
                                                                                //get the value of the input text
                                                                                var data= $("#aup_msg").val() ;
                                                                                //replace the special characters to ''
                                                                                var dataFull = data.replace(/[^\w\s]/gi, '');
                                                                                //set the new value of the input text without special characters
                                                                                $("#aup_msg").val(dataFull);
                                                                            });

                                                                        });
                                                                    });
                                                                </script>
                                                          
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                  
                                  <!-- 
                        <div class="control-group">
                            <label class="control-label" for="radiobtns"><strong>User Message :</strong></label>

                                                        <div class="controls">
                                                            <div class="input-prepend input-append">
                                                       

                                                            <textarea name="user_msg" id="user_msg" cols="150" style="width:560px; height:40px;" maxlength="256" required ></textarea>
                                                                
                                                          </div>
                                                        </div>
                                                        
                                                    </div>   
                                  
                                  
                                       -->

                                        <style>
                                            textarea {
                                                width: 100% !important;
                                            }
                                        </style>
                                                                    
                                                    
                                        <div class="control-group">
                                                        
                                                    </div>
                                                    <!-- /control-group --> 
                                                                
                                                    <h6>TAG Description </h6>
                                                    Violation Message : {$violation_message}&nbsp;&nbsp;
                                                    
                                                    
                                                    <textarea width="100%" id="aup_message" name="aup_message" class="jqte-test1"><?php echo $message_full; ?></textarea>

                                                                    
                                                                                                                            
                                <br>
                                                            <button type="submit" name="submit_aup" class="btn btn-primary" >Send & Post</button>
            
                                                    <!-- /form-actions -->
                                                </fieldset>
                                            </form>                        
                        
                        
                        
                        
                        
                        
                        
                     <?php }else{ ?>     
                            
                            
                            
                            
                                <div id="email_response"></div>
                                <form id="edit-profile" action="?t=aup_violation" method="post" class="form-horizontal" >
                                   <?php 
                                   
                    $secret2=md5(uniqid(rand(), true));
                    $_SESSION['FORM_SECRET5'] = $secret2;
                                   
                
                                                                            
                                echo '<input type="hidden" name="form_secret" id="form_secret" value="'.$_SESSION['FORM_SECRET5'].'" />';
                                                
                                ?>
                                
                                    <fieldset>

                                        <div class="control-group">

                                                        <div class="controls">


                            <h3>Tenant Search <img data-toggle="tooltip" title="Use the Search Tenant field to search tenants that have been identified for AUP Violation." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;"> </h3>

                                                        </div>

                                                    </div>

                                    
                                                    
                                                    <div class="control-group">

                                                        <div class="controls">
                                                        <label  for="radiobtns">Limit Search to</label>
                                                            
                                                                <select name="property_id" id="property_id" required>  
                                                                <option value="ALL">ALL Groups</option>

                                                                <?php
                                                                
                                                                $key_query ="SELECT o.property_id, o.property_number
                                                                FROM mdu_organizations o, mdu_distributor_organizations u, `exp_mno_distributor` d
                                                                WHERE d.`distributor_code`= u.`distributor_code` AND o.property_number = u.property_id
                                                                AND d.mno_id = '$user_distributor'";
                                                                                                                    
                                                                foreach ($query_results['data'] AS $row) {
                                                                    $property_id = $row[property_id];
                                                                    $property_number = $row[property_number];
                                                                    
                                                                    echo '<option value="'.$property_number.'">'.$property_id.'</option>';
                                                                }
                                                                
                                                                ?>
                                                                
                                                                
                                                                </select>
                                                                
                                                                <img data-toggle="tooltip" title="You can search a tenant across all your properties or limit the search to a specific property." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px;cursor: pointer;">
                                                                
                                                            
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->
                                                    
                                                                                                
                                                     
                                                    
                                                    <div class="control-group">

                                                        <div class="controls">
                                                        <label for="radiobtns">Search Tenant</label>
                                                            
                                                                <input type="text" name="search_word" id="search_word" >
                                                                <button class="btn btn-primary" type="submit" name="search_btn" id="search_btn">Search</button>
                                                                <img data-toggle="tooltip" title="Note: You can search using First Name, Last Name or Email Address." src="layout/ATT/img/help.png" style="width: 20px;margin-bottom: 6px; margin-top: 20px; cursor: pointer;">                                                 
                                                                
                                                            
                                                        </div>
                                                        <!-- /controls -->
                                                    </div>
                                                    <!-- /control-group -->                                                 
                                        </fieldset>
                                    </form>
                                            
                                            
<?php if($record_found==1){ ?>

    <form class="form-horizontal">

    <div class="control-group">

                                                        <div class="controls">
<?php
$customer_down_key_string_pending = "task=aup_data&mno_id=".$user_distributor;
$customer_down_key_pending =  cryptoJsAesEncrypt($data_secret,$customer_down_key_string_pending);
$customer_down_key_pending =  urlencode($customer_down_key_pending);

?>
                                            
<a href="ajax/export_customer.php?key=<?php echo "$customer_down_key_pending" ?>" class="btn btn-info" style="text-decoration:none"><i class="btn-icon-only icon-download"></i> Download Search Results</a>
                            <br>                            <br>       

                            </div>
                            </div>    
                             </form>                    
                                       
    <?php } ?>                                          
                                            <?php
                                            if(isset($_SESSION['msg'])){
                                                echo $_SESSION['msg'];
                                                unset($_SESSION['msg']);
                                                
                                                }
                                            
                                            ?>
                                           <?php if($record_found==1){

                                                    $s_id = "SELECT `customer_list` FROM `mdu_search_id` WHERE id = '$search_id'";
                                                    $query_resultss=$db->select1DB($s_id);
                                                    //$rows=mysql_fetch_array($query_resultss);
                                                    $customer_list = $query_resultss['customer_list'];
                                                    $customer_list_array=explode(",",$customer_list);
                                                    $customer_list_array_count=count($customer_list_array);
                                                    $default_table_rows=$db->setVal('tbl_max_row_count','ADMIN');
                                                    if($default_table_rows=="" || $default_table_rows=="0"){
                                                        $default_table_rows=100;
                                                    }
                                                    $page_count=ceil($customer_list_array_count/$default_table_rows);

                                                    if(isset($_GET['page_number'])){
                                                    $page_number=$_GET['page_number'];
                                                    }else{
                                                    $page_number=1;
                                                    }
                                                    $start_row_count=($page_number*$default_table_rows)-$default_table_rows;
                                                    $end_row_count=($page_number*$default_table_rows);
                                                    $view_customer_list="";
                                                    for($i=$start_row_count;$i<min($end_row_count,$customer_list_array_count);$i++) {
                                                    $view_customer_list =$view_customer_list.",".$customer_list_array[$i];
                                                    $last_row_number=$i;
                                                    }
                                                    //  echo $view_customer_list;
                                                    $view_customer_list=ltrim($view_customer_list,",");
                                                    $view_customer_list=rtrim($view_customer_list,",");
                                                    if($page_count!=1){
                                                    ?>


                                                    <ul class="pagination" style="float: right">
                                                        <?php
                                                        for ($i = 1; $i <= $page_count; $i++) {
                                                            if($page_number==$i){
                                                                $active="class=\"active\"";
                                                            }else{
                                                                $active="";
                                                            }
                                                            echo "<li ".$active."><a href=\"?page_number=".$i."&search_id=".$search_id."\">$i</a></li>";

                                                        }
                                                        }
                                                        ?>
                                                    </ul>

                                                   

                                                    <div class="widget widget-table action-table">
                                                        
                                                        <div class="widget-header">
                                                    <i class="icon-th-list"></i>
                                                    <h3>Search Results</h3>
                                                </div>
                                                <!-- /widget-header -->
                                                <div class="widget-content table_response">

                                                     <p align="left">
                                                            Records  <?php echo$start_row_count+1 ?> - <?php echo$last_row_number+1 ?> of <?php echo$customer_list_array_count ?>
                                                    </p>

                                                <div style="overflow-x:auto">
                                                    <table class="table table-striped table-bordered tablesaw i-enable" id="tenent_search_table" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist"><span>First Name</span><i style="float: right" class="icon-sort"></i></th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>Last Name</span><i style="float: right" class="icon-sort"></i></th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2"><span>Email</span><i style="float: right" class="icon-sort"></i></th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="3"><span>Group Name</span><i style="float: right" class="icon-sort"></i></th>

                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1"><span>#of AUPs</span><i style="float: right" class="icon-sort"></i></th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Action</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Re Activate</th>
                                                                
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                
                    <?php

                    
                   $key_query = "SELECT `username`,`customer_id`,`first_name`,`last_name`,`email`,`property_id`,`room_apt_no`,`first_login_date`,warning_message,violation
                     FROM `mdu_vetenant` WHERE customer_id IN ($view_customer_list) ORDER BY first_name ASC";
                    
                                

                                $query_results=$db->selectDB($key_query);
                                //while($row=mysql_fetch_array($query_results)){
                                foreach ($query_results['data'] AS $row) {
                                    $customer_id = $row['customer_id'];
                                    $username = $row['username'];
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $email = $row['email'];
                                    $property_id = $row['property_id'];
                                    $room_apt_no = $row['room_apt_no'];
                                    $first_login_date = $row['first_login_date'];
                                    $warning_message = $row['warning_message'];
                                    $violation = $row['violation'];

//echo "SELECT * FROM `mdu_aup_violation` WHERE username = '$username' AND ack_status IN(0,2)";

                                    /*$rrr = $db->selectDB("SELECT * FROM `mdu_aup_violation` WHERE username = '$username' AND ack_status IN(0,2)");
                                    $cunt = mysql_num_rows($rrr);

                                    $total_warnings = $cunt;*/
                                    
                                    
                                    /*$mdu_aup_react = $db->selectDB("SELECT * FROM `mdu_aup_violation` WHERE username = '$username' ORDER BY ID DESC LIMIT 1");
                                    while($rowr=mysql_fetch_array($mdu_aup_react)){
                                        $ack_status_get = $rowr['ack_status'];
                                    }*/

                                    //$rrr2 = $db->selectDB("SELECT warning_message,violation FROM `mdu_customer` WHERE username = '$username'");

                                    //$rowr=mysql_fetch_array($rrr2);

                                    //$warning_message = $rowr['warning_message'];
                                    //$total_warnings = $row['violation'];
                                    switch ($violation){
                                        case 0:{
                                            if(strlen($warning_message)>0 && $warning_message != '0'){
                                                $total_warnings = 1;
                                            }else{
                                                $total_warnings = 0;
                                            }
                                            break;
                                        }
                                        case 1:{
                                            if(strlen($warning_message)>0 && $warning_message != '0'){
                                                $total_warnings = 2;
                                            }else{
                                                $total_warnings = 1;
                                            }
                                            break;
                                        }
                                        case 2:{
                                            if(strlen($warning_message)>0 && $warning_message != '0'){
                                                $total_warnings = 3;
                                            }else{
                                                $total_warnings = 2;
                                            }
                                            break;
                                        }
                                    }


                                    if($warning_message == '0' || $warning_message == NULL){
                                        $vio_enable = 1;
                                    }
                                    else{
                                        $vio_enable = 0;
                                    }


                                    $get_property_id_get=$db->selectDB("SELECT property_id FROM `mdu_organizations` WHERE property_number='$property_id' LIMIT 1");
                                        
                                  
                                    foreach ($get_property_id_get['data'] AS $rowe) {
                                        $property_id_display = $rowe['property_id'];
                                    }
                                    
                                    
                                    
                                    echo '<tr>
                                    <td> '.$first_name.' </td>
                                    <td> '.$last_name.' </td>
                                    <td> '.$email.' </td>
                                    <td> '.$property_id.' </td>

                                    <td> '.$total_warnings.' </td>';
                                    
                                    
                                    echo '<td>';                            
                                    echo '&nbsp;';
                                    
                                    if($total_warnings < 3 && ($vio_enable == 1)){
                                    
                                    echo '<a id="CEMAIL_'.$customer_id.'"  class="btn btn-small vt_icon"><i class="btn-icon-only icon-envelope"></i></a><script type="text/javascript">
                                $(document).ready(function() {
                                $(\'#CEMAIL_'.$customer_id.'\').easyconfirm({locale: {
                                        title: \'Send Customer Notice\',
                                        text: \'Are you sure you want to send a notice to this customer?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                        button: [\'Cancel\',\' Confirm\'],
                                        closeText: \'close\'
                                         }});
                                    $(\'#CEMAIL_'.$customer_id.'\').click(function() {
                                        window.location = "session.php?t=aup_violation&token='.$secret2.'&search_id='.$search_id.'&mg_customer_id='.$customer_id.'"
                                    });
                                    });
                                </script>';
                                    }else if($total_warnings != 3){
                                        echo '<a href="javascript:void();"  class="btn btn-small vt_icon" data-toggle="tooltip" title="The AUP is disabled until the user has acknowledged the previous AUP."><i class="btn-icon-only icon-envelope" ></i></a>';
                                        
                                    }
                                    
                                    
                                    echo '<td>';
                                    
                                    
                                    
                                if(($violation >= 2 && ($vio_enable == 0)) || $violation > 2){
                                    
                                $ack_status_get = '';
                                echo '<a id="REACT_'.$customer_id.'"  class="btn btn-small vt_icon">
                                <i class="btn-icon-only icon-refresh"></i></a></td><script type="text/javascript">
                                $(document).ready(function() {
                                $(\'#REACT_'.$customer_id.'\').easyconfirm({locale: {
                                        title: \'Re Enable ['.$first_name.' '.$last_name.']\',
                                        text: \'Are you sure you want to Re Enable this account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                        button: [\'Cancel\',\' Confirm\'],
                                        closeText: \'close\'
                                         }});
                                    $(\'#REACT_'.$customer_id.'\').click(function() {
                                        window.location = "session.php?t=aup_violation&token='.$secret2.'&re_customer_id='.$customer_id.'"
                                    });
                                    });
                                </script>
                                
                                
                                </td>';
                                        
                                    
                                }





                                    
                                    
                                }

                    ?>                  
                                
                                
                                  
        
                                
                                </tbody>
                        </table>
                        </div>
                        </div>
                        </div>
                                                    <script type="text/javascript">
                                                        $(function(){
                                                            // $('#tenent_search_table').tablesorter();
                                                        });
                                                    </script>
                    
                     <?php } else if($record_found==0 && isset($_POST['search_btn'])) {echo $msg; } ?>
                     
                     
                      <?php }  ?>  
                     </div>