<?php 
    if(isset($_SESSION['tab1'])){
        echo$_SESSION['tab1'];
        unset($_SESSION['tab1']);
    }


function split_from_num($a){

$num = ['1','2','3','4','5','6','7','8','9',];
for($i = 0 ; $i<strlen($a); $i++){
    if(!in_array($a[$i],$num)){
        $pos=$i;
        break;
    }
}

//echo $pos;
//echo substr($a,0,$pos);
//echo substr($a,$pos,strlen($a)-$pos);
return substr($a,0,$pos)." ".ucfirst(substr($a,$pos,strlen($a)-$pos));
}

 ?>


<?php if(in_array("CONTENT_FILTER_QOS",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="tab_1">
                                            <!-- Tab 3 start-->

                                            <!--  <h2>QoS & Duration</h2>

                                            <p>
                                                A user will have internet access for a certain amount of time in a 24 hour period after registration. You can choose for how long each session during that 24 hour period should last. Each time the session expires the visitor will be redirected to your splash page and see your active campaign, or if no campaign is active the visitor will see your service providers default campaign
                                            </p> -->


                                            <p>

                                                  <?php

/* 
                                           $sup_data = $db->getSupportProfile($distributor_mno, $user_distributor);



                                          $sup_available=$sup_data[0][0];
                                           $sup_text=$sup_data[0][1];
                                           $sup_mobile=$sup_data[0][2]; */
                                                  
                                                  
                                                 $sup_mobile = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package); 
                                                  

                                            ?>



                                                       <?php if($package_functions->getMessageOptions('IS_SUPPORT',$system_package)=='YES'){?>

                                                     

                                                <?php }?>

                                            </p>

                                          

                                            <?php
                                            if($package_functions->getSectionType('CONTENT_FILTER_CHANGE',$system_package)=="YES" || $package_features=="all") {

                                                ?>
                                                    <form id="tab2_form1" name="tab2_form1" method="post"
                                                      class="form-horizontal">

                                                    <fieldset>

                                                        <input <?php

                                                        if ($content_filter == '1') echo "  checked   " ?>
                                                            onchange="contentFilter()" id="content_filter_check"
                                                            name="content_filter_check" type="checkbox"
                                                            data-toggle="toggle" data-on="On" data-off="Off"
                                                            data-width="30">
                                                        <script>
                                                            function contentFilter() {
                                                                var value = $('#content_filter_check:checked').val();
                                                                /*alert(value);*/
                                                                if (value == 'on') {
                                                                    window.location = '?content_filter=1&t=12&secret=<?php echo $secret; ?>';
                                                                } else {
                                                                    window.location = '?content_filter=0&t=12&secret=<?php echo $secret; ?>';
                                                                }
                                                            }
                                                        </script>
                                                    </fieldset>
                                                </form>
                                                <?php
                                            }
                                            ?>


                                             <div class="widget widget-table action-table">


                                                        <div class="widget-header">
                                                            <!-- <i class="icon-th-list"></i> -->
                                                            <h3>Active Profiles</h3>
                                                        </div>

                                                        <h3 style="display: inline-block;">QoS & Duration<img data-toggle="tooltip" title="A user will have internet access for a certain amount of time in a 24 hour period after registration. You can choose for how long each session during that 24 hour period should last. Each time the session expires the visitor will be redirected to your splash page and see your active campaign, or if no campaign is active the visitor will see your service providers default campaign" src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;" ></h3>

                                                        <br>
                                                        <div class="widget-content table_response" id="product_tbl" style="margin-top: 20px">

                                                           

                                                            <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">QoS</th>
                                                               <!--  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UL</th> -->
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Active Session Duration</th>
                                                            <?php if($package_functions->getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                            ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Active on</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
                                                            <?php } ?>

                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                $dist_guest_prof_q="SELECT d.id,d.`product_name`,p.`product_code`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type`='GUEST' AND p.`network_type`='GUEST'
                                                                                    GROUP BY d.id";
                                                                $dist_guest_prof_res=$db->selectDB($dist_guest_prof_q);
                                                            foreach ($dist_guest_prof_res['data'] as $dist_guest_prof) {
                                                                $prof_id=$dist_guest_prof['id'];
                                                                $duration_prof_code = $dist_guest_prof['duration_prof_code'];
                                                                if ($ori_user_type!='SALES') {
                                                                echo "<tr><td>".$dist_guest_prof['product_code']."</td>";}
                                                                else{
                                                                 if (empty($_POST['qos_value'])) {
                                                                    $_POST['qos_value']=$dist_guest_prof['product_code'];
                                                                 }
                                                                echo "<tr><td>".$_POST['product_code']."</td>";
                                                                }
                                                               // echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                                                                //echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";
                                                                $qos_query ="SELECT `product_id`,`product_code` FROM `exp_products` WHERE `mno_id`='$distributor_mno' AND `network_type`='GUEST' ";

                                                                $qos_query_ex =$db->selectDB($qos_query);
                                                                $display_data = product_name_convertion($qos_query_ex['data'],$db,$user_distributor);

                                                                echo "<td>
                                                                <select style='margin-bottom:0px !important;' name='qos_qos' id='qos_qos' class='span2'>";
                                                        
                                                                $selected_key="";

                                                                foreach ($display_data as $display_key=>$display_value) {
                                                                    //$qos_query_result
                                                                    if ($ori_user_type!='SALES') {
                                                                        $sel_0='';
                                                                        foreach ($display_value as $display_value_value) {
                                                                            if($GLOBALS['qos_ale_version']=='ale4') {
                                                                                $comp_ar = explode('-',$display_value_value['product_id']);
                                                                                unset($comp_ar[0]);
                                                                                $comp_val = implode('-',$comp_ar);
                                                                            }else{
                                                                                $comp_val = $display_value_value['product_id'];
                                                                            }
                                                                            if($dist_guest_prof['product_code']==$comp_val){
                                                                                $sel_0='selected';
                                                                                $selected_key = $display_key;
                                                                            }
                                                                        }

                                                            echo "<option ".$sel_0." value='".$display_key."'>".$display_key." Mbps</option>";

                                                                }
                                                                else{
                                                                    if($_POST['qos_value']==$qos_query_result['product_code']){
                                                                    
                                                                        $sel_0='selected';
                                                                    }else{
                                                                        
                                                                        $sel_0='';
                                                                    }
                                                                     echo "<option ".$sel_0." value='".$qos_query_result['product_code']."'>".$qos_query_result['product_code']."</option>";
                                                                }
                                                            }


                                                                
                                                        echo "</select></td>";  
                                                
                                                echo '<input type="hidden" name="qos_id" value="'.$prof_id.'">';
                                                echo "<td><form style='margin-bottom:0px !important;' action='?t=12' method='post'>
                                                        <select style='margin-bottom:0px !important;' name='qos_value' id='qos_value' class='span2'>";

                                                        foreach ($display_data[$selected_key] as $durations_value) {
                                                            if($GLOBALS['qos_ale_version']=='ale5') {
                                                                $comp_val = $dist_guest_prof['product_code'];
                                                            }else{
                                                                $comp_val = $duration_prof_code.'-'.$dist_guest_prof['product_code'];
                                                            }
                                                            if($comp_val==$durations_value['product_id']){
                                                                    
                                                                        $sel_0='selected';
                                                                    }else{
                                                                        
                                                                        $sel_0='';
                                                                    }
                                                                     echo "<option ".$sel_0." value='".$durations_value['id']."'>".$durations_value['product']."</option>";
                                                                }

                                                        echo "</select>";
                                                
                                                echo "<button style='margin-left: 5px; margin-top: 5px;float: right;' 
                                                    type='submit' name='qos_change' id='qos_change' class='btn btn-small btn-primary'>Update</button></td>";
                                                    

                                                        echo'</form> </td>';



                                                                $timegap1=$dist_guest_prof['time_gap'];
                                                                $du_pro_code=$dist_guest_prof['duration_prof_code'];
                                                           
                                                                
                                                                $d_proq="SELECT `duration`
                                                                        FROM `exp_products_duration`
                                                                        WHERE `profile_code`='$du_pro_code'";
                                                                $dpro_exe=$db->selectDB($d_proq);
                                                                foreach ($dpro_exe['data'] as $dup) {
                                                                    
                                                                    $timegap=$dup['duration'];
                                                                    
                                                                }
           
                                                                
                                                                $gap = "";
                                                                if($timegap != ''){

                                                                    $interval = new DateInterval($timegap);
                                                                    //echo $interval->m;



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

                                                                
                                                             if($package_functions->getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                                echo "<td>";
                                                                if($dist_guest_prof['active_on'] == 'all'){
                                                                    echo 'All Week';
                                                                }
                                                                else{
                                                                    echo $dist_guest_prof['active_on'];
                                                                }

                                                                echo "</td>";

                                                                echo  '<td><a href="javascript:void();" id="PROF_' . $prof_id . '"  class="btn btn-small btn-danger">
                                                                        <i class="btn-icon-only icon-remove-circle"></i>&nbsp;Remove</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Remove [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to remove this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_rm_token=' . $_SESSION['FORM_SECRET'] . '&t=2&remove_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>
                                                                        <a href="javascript:void();" id="PROF_ED_' . $prof_id . '"  class="btn btn-small btn-info">
                                                                        <i class="btn-icon-only icon-pencil"></i>&nbsp;Edit</a>&nbsp;
                                                                        <img id="ap_loader_' . $prof_id . '" src="img/loading_ajax.gif" style="visibility: hidden;">
                                                                        <script type="text/javascript">
                                                                        $(document).ready(function() {
                                                                        $(\'#PROF_ED_' . $prof_id . '\').easyconfirm({locale: {
                                                                                title: \'Product Edit [' . $dist_guest_prof['product_name'] . ']\',
                                                                                text: \'Are you sure you want to edit this Product?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
                                                                                button: [\'Cancel\',\' Confirm\'],
                                                                                closeText: \'close\'
                                                                                 }});
                                                                            $(\'#PROF_ED_' . $prof_id . '\').click(function() {
                                                                                window.location = "?prof_ed_token=' . $_SESSION['FORM_SECRET'] . '&t=5&edit_prof_id=' . $prof_id . '"
                                                                            });
                                                                            });
                                                                        </script>

                                                                        </td>'; }
                                                                echo'</tr></form>';
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table><script type="text/javascript">
                                                            var data=<?php echo json_encode($display_data);?>;
                                                            var product = '<?php  echo $GLOBALS['qos_ale_version']=='ale5'?$dist_guest_prof['product_code']:$duration_prof_code.'-'.$dist_guest_prof['product_code'];?>';
                                                            $(function(){                                                                
                                                                $('#qos_qos').on('change', function() {
                                                                    var val = this.value;
                                                                    $('#qos_value').empty();
                                                                    data[val].forEach((item, index)=> {
                                                                        if(item.product_id==product){
                                                                            var select = 'selected="selected"';
                                                                        }else{
                                                                            var select = '';
                                                                        }
                                                                        $('#qos_value').append('<option '+select+' value="'+item.id+'">'+item.product+'</option>');
                                                                      //document.getElementById("demo").innerHTML += index + ":" + item + "<br>"; 
                                                                    });
                                                                  //console.log( data[val] );
                                                                });
                                                            });
                                                        </script>
                                                        
                                                                </div>
                                                    </div>
                                                </div>

                                            <!-- Tab 3 End-->
                                        </div>
                                    <?php }  ?>

<?php if(in_array("CONTENT_FILTER_MAIN",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="tab_2">

                                           <!--  <h2>Content Filtering</h2>

                                            <p>
                                                Once Content Filtering is activated by your service provider you have the option to enable or disable the content filtering feature. Content Filtering is only applicable to your Guest WiFi SSIDs. Filtered content will be indicated by an informational block message.
                                            </p> -->

      <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Content Filter</h3>
                                                </div>



                                                <div class="widget-content table_response" id="act_profile_tbl">

                                                    <h3 style="display: inline-block;">Content Filtering<img data-toggle="tooltip" title="Content Filtering is add-on service, to activate content filtering, you must contact customer service at the phone number located at the bottom of the portal. Content Filtering is only applicable to your Guest WiFi SSIDs. Filtered content will be indicated by an informational block message." src="layout/OPTIMUM/img/help.png" style="width: 30px;margin-bottom: 6px;cursor: pointer;display:  inline-block;"></h3>

                                                    <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered" >
                                                            <thead>

                                                            <tr>
                                                                <th>Service</th>
                                                                <th>Status</th>
                                                            </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Content Filtering</td>
                                                                    <td>
                                                                        <?php
                                                                       $dnssecret=md5(uniqid(rand(), true));
                                                                        $_SESSION['DNS_FORM_SECRET'] = $dnssecret;


                                                                        $dns_q = $db->selectDB("SELECT * FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

 
                                                                        foreach ($dns_q['data'] as $row) {
                                                                            $content_filter=$row[dns_profile_enable];
                                                                            $content_filter_dns=$row[dns_profile];
                                                                            $content_filter_enable=$row[content_filter_enable];
                                                                        }

                                                                if($content_filter_enable==1){

                                                                      if(empty($content_filter_dns)){
                                                                        // $is_d = 'disabled';

                                                                         $is_d = 'enabled'; 

                                                                        }else{
                                                                            $is_d = 'enabled'; 
                                                                        }

                                                                        if($content_filter=='1'){
                                                                            echo '<div style=" width: 145px; " class="toggle1 new"><input checked '.$is_d.' onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox"><span class="toggle1-on">Enabled</span>';
                                                                            if( $is_d == 'disabled'){ echo '<input  '.$is_d.'  onchange="" href="javascript:void();"   type="checkbox" class="hide_checkbox"><span class="toggle1-off-dis">Disabled</span>'; 
                                                                            }else{
                                                                          echo ' <a href="javascript:void();" id="DNSChange"><span class="toggle1-off-dis">Disabled</span>
                                    </a>'; }
                                     echo'  </div><img id="camplivead_loader_'.$ad_id.'" src="img/loading_ajax.gif" style="visibility: hidden; display: none"><script type="text/javascript">
$(document).ready(function() {
$(\'#DNSChange\').easyconfirm({locale: {
        title: \'Disable Content Filtering\',
        text: \'Are you sure you want to disable content filtering?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        button: [\'Cancel\',\' Confirm\'],
        closeText: \'close\'
         }});
    $(\'#DNSChange\').click(function() {
        window.location = "?token='.$dnssecret.'&t=2&action=disable&changeContentFilter"
    });
    });
</script></td>';
                                                                        }else{
                                                                            echo '<div style=" width: 145px; " class="toggle1 new"><input checked '.$is_d.' onchange="" href="javascript:void();" type="checkbox" class="hide_checkbox">';
                                                                            if( $is_d == 'disabled'){ echo '<input  '.$is_d.'  onchange="" href="javascript:void();"  type="checkbox" class="hide_checkbox"><span class="toggle1-on-dis">Enabled</span>'; 
                                                                            }else{ 
                                                                          echo ' <a href="javascript:void();" id="DNSChange"><span class="toggle1-on-dis">Enabled</span>
                                    </a>';} echo '<span class="toggle1-off">Disabled</span></div><img id="camplivead_loader_'.$ad_id.'" src="img/loading_ajax.gif" style="visibility: hidden; display: none"><script type="text/javascript">
$(document).ready(function() {
$(\'#DNSChange\').easyconfirm({locale: {
        title: \'Enable Content Filtering\',
        text: \'Are you sure you want to enable content filtering?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
        button: [\'Cancel\',\' Confirm\'],
        closeText: \'close\'
         }});
    $(\'#DNSChange\').click(function() {
        window.location = "?token='.$dnssecret.'&t=2&action=enable&changeContentFilter"
    });
    });
</script></td>';
                                                                        }

                                                                            }else{
                                                                                echo "Disabled";
                                                                            }


                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


<?php } ?>
                                      


                                            <br/>


</div>
