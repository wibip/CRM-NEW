

<?php 
function product_name_convertionnew(array $list){

    $qos=[];

    foreach ($list as $value) {
        $product_name_new = str_replace('_', '-', $value['product_code']);
        $qosspeed = substr($value['QOS'], -1);
        $name_ar = explode('-', $product_name_new);
        $duration = explode('-',str_replace(' ', '-', split_from_num($name_ar[3])));
        $duration_val = $duration[0];
        $duration_type = $duration[1];
        $qos_arr = explode('-', $value['QOS']);
        $n = sizeof($qos_arr)-1;
        $qos_new = substr($qos_arr[$n], 0,-1);
        $name_ar = explode('-', $product_name_new);
        if (strlen($name_ar[3])<1) {
          $name_ar[3] = $name_ar[2];
          $name_ar[2] = $qos_new;
        }
        if(array_key_exists($name_ar[2], $qos)){
            array_push($qos[$name_ar[2]], ["product"=>split_from_num($name_ar[3]),"product_id"=>$value['product_code'],"id"=>$value['product_id'],"qos"=>$qosspeed,"duration_val"=>$duration_val]);
        }else{
            $qos[$name_ar[2]]=[["product"=>split_from_num($name_ar[3]),"product_id"=>$value['product_code'],"id"=>$value['product_id'],"qos"=>$qosspeed,"duration_val"=>$duration_val]];
        }
        
    }/*
    print_r($qos);
    exit();*/
    return $qos;
}

function split_from_num($a){

$num = ['1','2','3','4','5','6','7','8','9','0'];
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

function aasort(&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

 ?>
<script type="text/javascript">
    $('.bandwidthUpdate').click(function(event) {
        event.preventDefault();
    });
    function change_qos(elem) {
        var qos = $('#qos_'+elem).val();
        var net_id = $('#ssid_id_'+elem).val();

        $('#duration_'+elem).empty();

        var formData={qos:qos,dis:"<?php echo $user_distributor;?>",task:'SyncDuaration',network_id:net_id};
        //console.log(formData);
        $.ajax({
            url: "ajax/updateSSIDBandwidth.php",
            type: "POST",
            data : formData,
            success: function(result){
                //console.log(result);
                //var obj = JSON.parse(result);

                $('#duration_'+elem).append(result);

            }});
    }
    function bandwidthUpdate(elem) {
        var qos = $('#qos_'+elem).val();
        var dure = $('#duration_'+elem).val();
        var net_id = $('#ssid_id_'+elem).val();
        $('#ap_id').empty();
        if(!qos){
            //alert("Please select Bandwidth profile");
            $('#ap_id').append('Please select Bandwidth profile');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            return false;
        }
        if(!dure){
            $('#ap_id').append('Please select Duration profile');
            $('#servicearr-check-div').show();
            $('#sess-front-div').show();
            //alert("Please select Duration profile");
            return false
        }
        $( "#guest_modify_network" ).empty();
        $('html,body').scrollTop(0);
        var formData={qos:qos,dure:dure,dis:"<?php echo $user_distributor;?>",task:'updateProduct',network_id:net_id};
        //console.log(formData);
        $.ajax({
            url: "ajax/updateSSIDBandwidth.php",
            type: "POST",
            data : formData,
            success: function(result){
                var obj = JSON.parse(result);
                if(obj.status=='success'){
                    $( "#guest_modify_network" ).append(obj.message);
                    $("#check_update"+elem).val('no');
                    $("#check1_update"+elem).val('no');
                }else{
                    $( "#guest_modify_network" ).append(obj.message);
                }
            }});
    }
    function ssidBroadcast(val1,val2,val3) {
        /*var value=$('#auto_passcode:checked').val();*/
        /*alert(value);*/
        if(val1=='on'){
            window.location ='modules/ssid/2-submit?ssid_broadcast&t=guestnet_tab_1&status=1&network_id='+val2+'&ssid='+val3+'&secret=<?php echo $tab_secret; ?>';
        }else{
            window.location ='modules/ssid/2-submit?ssid_broadcast&t=guestnet_tab_1&status=0&network_id='+val2+'&ssid='+val3+'&secret=<?php echo $tab_secret; ?>';
        }
    }
</script>

<?php if(in_array("CONTENT_FILTER_QOS",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($tab12)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="tab_1">

                                            <div id="guest_modify_network"></div>
                                            <!-- Tab 3 start-->


                                            <?php 
                                                if(isset($tab12)){
                                                    if(isset($_SESSION['tab1'])){
                                                        echo$_SESSION['tab1'];
                                                        unset($_SESSION['tab1']);
                                                    }
                                                }

                                             ?>

                                             <h1 class="head">QoS</h1>

                                            <p>
                                                A user will have internet access for a certain amount of time in a 24 hour period after registration. You can choose for how long each session during that 24 hour period should last. Each time the session expires the visitor will be redirected to your splash page and see your active campaign, or if no campaign is active the visitor will see your service providers default campaign
                                            </p>


                                            <p>

                                                  <?php

/* 
                                           $sup_data = $db->getSupportProfile($distributor_mno, $user_distributor);



                                          $sup_available=$sup_data[0][0];
                                           $sup_text=$sup_data[0][1];
                                           $sup_mobile=$sup_data[0][2]; */
                                                  
                                                  
                                                 $sup_mobile = $package_functions->getMessageOptions('SUPPORT_NUMBER',$system_package,$property_business_type); 
                                                  

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


                                                        <br>
                                                        <?php if ($other_multi_area == 1) { ?>
               <div class="widget-content table_response" id="ssid_tbl" style="position: relative;width: 930px;">
                    <div style="overflow-x:auto;" >
                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap >
                            <thead>
                            <tr>
                                <th scope="col" colspan="2" data-tablesaw-sortable-col data-tablesaw-priority="persist">SSID Name</th>
                                
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Product <span style="text-transform: none;">(QoS & Duration)</span></th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $all_na = 0;

                            $ssid_q= "SELECT sa.ssid_broadcast,p.`product_code`,sa.shedule_uniqu_id,s.product_id,s.duration_id,s.id, d.`zone_id`, count(DISTINCT a.`ap_code`) AS ap_count,s.`wlan_name`,s.`ssid`,s.`network_id` ,l.`group_tag`,d.bussiness_address1,d.state_region,d.bussiness_address2
                                                                FROM
                                                                `exp_mno_distributor` d 
                                                                LEFT JOIN
                                                                `exp_products_distributor` p
                                                                ON d.`distributor_code`=p.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ssid` s
                                                                ON s.`distributor`=d.`distributor_code` AND network_method='GUEST'
                                                                LEFT JOIN
                                                                `exp_mno_distributor_aps` a
                                                                ON s.`distributor`= a.`distributor_code`
                                                                LEFT JOIN
                                                                `exp_locations_ap_ssid` l
                                                                ON l.`distributor`= a.`distributor_code`
                                                                LEFT JOIN exp_distributor_network_schedul_assign sa ON s.network_id=sa.network_id AND s.distributor=sa.distributor

                                                                WHERE  d.`distributor_code`='$user_distributor' -- AND p.ssid='All'
                                                                GROUP BY s.`ssid`";
                            $ssid_res=$db->selectDB($ssid_q);
                            $i=0;

                            $qos_q = "SELECT `product_id`,`product_code`,`QOS` FROM `exp_products` WHERE `mno_id`='$mno_id' AND `network_type`='GUEST'";
                            $qos_data = $db->selectDB($qos_q);
                            $display_data = product_name_convertionnew($qos_data['data']);

                            $duration_q = "SELECT profile_code,duration FROM exp_products_duration WHERE distributor='$mno_id' AND is_default='1'";
                            $duration_data = $db->selectDB($duration_q);

                            $no =0;

                            if($ssid_res['rowCount'] > 0){
                                $ssids=[];
                               
                                foreach ($ssid_res['data'] AS $ssid_name) {
                                    $product_new = "";
                                    echo '<form id="ssid_form'.$i.'" name="ssid_form'.$i.'" method="post">';
                                    echo '<input type="hidden" name="check_update'.$i.'" class="check_update" id="check_update'.$i.'" value="no"><input type="hidden" name="check1_update'.$i.'" class="check_update" id="check1_update'.$i.'" value="no">';
                                    $bandwidth_input = '<input  type="hidden" id="qos_'.$i.'" value=""><input class="span2" type="text" readOnly value="Select QoS">&nbsp;&nbsp;';

                                    $no++;
                                    $qos_options = "";
                                    $duration_options="";
                                    $selected_qos = "";
                                    $selected_duration = "";
                                    //$product_new = $db->getValueAsf("SELECT product_code as f FROM exp_products_distributor WHERE distributor_code='$user_distributor' AND ssid='$ssid_name[network_id]' AND network_type='GUEST'");
                                    $product_new = $db->getValueAsf("SELECT p.product_code AS f FROM exp_products p JOIN exp_locations_ssid s ON p.`product_id` =s.`product_id` WHERE s.distributor='$user_distributor' AND s.network_id='$ssid_name[network_id]' AND p.`network_type`='GUEST'");
                                    if (strlen($product_new)<1) {
                                        $product_new = $ssid_name['product_code'];
                                    }
                                    $qos_profile = array();
                                    $qos_profile_k = array();
                                    if($qos_data['rowCount']>0){
                                        $selected_key = '';
                                        foreach ($display_data as $display_key=>$display_value) {
                                        if (strlen($display_key) >0) {
                                            $sel_0= '';
                                        foreach ($display_value as $display_value_value) {
                                            if($GLOBALS['qos_ale_version']=='ale4') {
                                                $comp_ar = explode('-',$display_value_value['product_id']);
                                                unset($comp_ar[0]);
                                                $comp_val = implode('-',$comp_ar);
                                                $speed = "Mbps";
                                            }else{
                                                $comp_val = $display_value_value['product_id'];
                                                $speed = $display_value_value['qos'];
                                                if ($speed == 'M') {
                                                    $speed = "Mbps";
                                                }elseif ($speed == 'G') {
                                                    $speed = "Gbps";
                                                }else{
                                                    $speed = "Kbps";
                                                }
                                            }
                                                                        
                                        if($product_new==$comp_val){
                                            $selected_qos = $display_key;
                                            $sel_0='selected';
                                            $selected_key = $display_key;
                                        }


                                    }
                                    $ab= substr($display_key, 0,2);
                                    if (!is_numeric($ab)) {
                                        $ab= substr($display_key, 0,1);
                                    }
                                    $bb= substr($display_key, -2);
                                    if (!is_numeric($bb)) {
                                        $bb= substr($display_key, -1);
                                    }
                                    if ($speed == 'Mbps') {
                                        array_push($qos_profile, array('product' =>$display_key,
                                                                    'qosval' =>$ab,
                                                                    'qosval' =>$bb,
                                                                    'speed' =>$speed,
                                                                 'select' =>$sel_0));
                                    }else{
                                        array_push($qos_profile_k, array('product' =>$display_key,
                                                                    'qosval' =>$ab,
                                                                    'qosval' =>$bb,
                                                                    'speed' =>$speed,
                                                                 'select' =>$sel_0));
                                    }
                                    
                                    //$qos_options.= "<option ".$sel_0." value='".$display_key."'>".$display_key." ".$speed."</option>";
                                        }
                                        }
                                        $sel_1 = '';
                                    aasort($display_data[$selected_key],'duration_val');
                                    CommonFunctions::aaasort($qos_profile,'qosval','qosval2');
                                    CommonFunctions::aaasort($qos_profile_k,'qosval','qosval2');
                                    
                                    foreach ($qos_profile_k as $value) {

                                        $qos_options.= "<option ".$value[select]." value='".$value[product]."'>".$value[product]." ".$value[speed]."</option>";
                                    }
                                    foreach ($qos_profile as $value) {

                                        $qos_options.= "<option ".$value[select]." value='".$value[product]."'>".$value[product]." ".$value[speed]."</option>";
                                    }
                                    
                                    foreach ($display_data[$selected_key] as $qos_value) {
                                        if($GLOBALS['qos_ale_version']=='ale4') {
                                            $comp_val = $duration_prof_code.'-'.$product_new;
                                        }else{
                                            $comp_val = $product_new;;
                                        }
                                    if($comp_val==$qos_value['product_id']){
                                        $selected_duration = $qos_value[product];
                                            $sel_1='selected';
                                        }else{
                                            
                                            $sel_1='';
                                        }
                                        if (strlen($qos_value[product]) >0) {
                                            $duration_options.= "<option ".$sel_1." value='".$qos_value[product]."'>".$qos_value[product]."</option>";
                                        }
                                        
                                    }

                                    }

                                    
                                    
                                    $gorup_tag = $ssid_name['group_tag'];

                                    if(strlen($gorup_tag) < 1){
                                        $location_id = 'N/A';
                                    }else{
                                        $location_id = $gorup_tag;
                                        //$all_na = "0";
                                    }
                                    $all_na = $ssid_name['ap_count'];

                                    
                                $datanew =  '<input  id="wlan_name_'.$i.'" name="wlan_name_'.$i.'" type="hidden" value="'.$ssid_name[wlan_name].'" >
                                <input  id="network_id_'.$i.'" name="network_id_'.$i.'" type="hidden" value="'.$ssid_name[network_id].'" >';

                                    $ssidname = '';
                                   
                                        if(!empty($ssid_name['ssid'])){
                                            $ssids[]=$ssid_name['ssid'];
                                         echo  "<td  style='font-size:15.5px'>".$ssid_name['ssid']." </td>";
                                   
                                        }else{
                                            echo  "<td></td>";
                                        }
                                    echo '<td style="border-left-width: 0;>"
                                    
                                    </td> ';
 
                                    if(1==1){
                                        $bandwidth='<select onchange="checkChange('.$i.',\''.$selected_qos.'\',this);change_qos(\'' . $i . '\');" class="span2" id="qos_'.$i.'">
                                                    <option value="">Select QoS</option>
                                                    '.$qos_options.'
                                                </select>&nbsp;&nbsp;';
                                    }else{
                                        $bandwidth=$bandwidth_input;
                                    }


                                    
                                    //echo    "<td>".$bandwidth."</td>";

                                    $update = '<a style="margin-left: 8px;" id="BANDWITH_'.$i.'"  class="btn btn-small btn-info bandwidthUpdate">Update</a>
                                    <script type="text/javascript">
                                    $(document).ready(function() {

                                    $(\'#BANDWITH_' . $i . '\').easyconfirm({locale: {

                                            title: \'Update Bandwith Profile \',

                                            text: \'Are you sure you want to update this?&nbsp;&nbsp;&nbsp;&nbsp;\',

                                            button: [\'Cancel\',\' Confirm\'],

                                            closeText: \'close\'

                                             }});

                                         $(\'#BANDWITH_' . $i . '\').click(function() {
                                            
                                            bandwidthUpdate('.$i.');
                                            });

                                        });
                                    </script>';

                                    $duration = '<select onchange="checkChange1('.$i.',\''.$selected_duration.'\',this);" class="span2" id="duration_'.$i.'"><option value="">Select Duration</option>'.$duration_options.'</select>';
                                    
                                    echo "<td style='min-width: 275px;'><div style='display: inline-block; vertical-align: top; margin-bottom: 5px'>".$bandwidth."</div><div style='display: inline-block;'>".$duration.$update."</div>";
                                    
                                    echo "<input type='hidden' name='ap[$i]' value='$ssid_name[ap_code]'/>";
                                    echo "<input type='hidden' name='ssid_id_".$i."' id='ssid_id_".$i."' value='$ssid_name[network_id]'/></td>";

                                    echo '<script>'; ?>

                                    function eneble_she<?php echo $no; ?>(){
                                        $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                        window.location.href = 'modules/ssid/2-submit?enable_p_schedule&network_id=<?php echo $ssid_name['network_id']?>';

                                    }

                                 <?php   if($ssid_status!='3'){ ?>


                                            $(document).ready(function() {
                                                $('#ssid_always_off_<?php echo $i?>').easyconfirm({locale: {
                                                        title: 'SSID Disable',
                                                        text: 'Are you sure you want to disable SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                        button: ['Cancel',' Confirm'],
                                                        closeText: 'close'
                                                    }});
                                                $('#ssid_always_off_<?php echo $i?>').click(function() {
                                                    $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                                    ssidBroadcast("off","<?php echo $ssid_name['network_id']; ?>","<?php echo $ssid_name['ssid']; ?>");
                                                });
                                            });

                                    <?php }

                                    if($ssid_status!='1'){ ?>


                                            $(document).ready(function() {
                                                $('#ssid_always_on_<?php echo $i?>').easyconfirm({locale: {
                                                        title: 'SSID Enable',
                                                        text: 'Are you sure you want to enable SSID?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                        button: ['Cancel',' Confirm'],
                                                        closeText: 'close'
                                                    }});
                                                $('#ssid_always_on_<?php echo $i?>').click(function() { 
                                                    $( "#ssid_tbl" ).append( "<div style='position: absolute; width: 100%; height: 100%; z-index: 10000;top: 0;'> </div>" );
                                                    ssidBroadcast("on","<?php echo $ssid_name['network_id']; ?>","<?php echo $ssid_name['ssid']; ?>");
                                                });
                                            });


                                    <?php }
                                    if($ssid_status!='2' && !empty($ssid_name['shedule_uniqu_id'])){ ?>
                                            $(document).ready(function() {
                                                $('#ssid_schedule_<?php echo $i?>').easyconfirm({locale: {
                                                        title: 'Schedule Enable',
                                                        text: 'Are you sure you want to enable schedule?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                                                        button: ['Cancel',' Confirm'],
                                                        closeText: 'close'
                                                    }});
                                                $('#ssid_schedule_<?php echo $i?>').click(function() {
                                                eneble_she<?php echo $no?>();
                                                });
                                            });


                                    <?php }

                                    echo '</script>';



                                    echo"</td></tr></form>";
                                    $i++;
                                }

                                if($all_na == 0){

                                    echo '<style> .all_na{ display: block !important; } </style>';

                                }



                            }

                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                                                        <?php }else{ ?> 
                                                            <div class="widget-content table_response" id="product_tbl" style="margin-top: 20px">

                                                           

                                                            <div style="overflow-x:auto;" >
                                                        <table class="table table-striped table-bordered tablesaw" data-tablesaw-mode="columntoggle" data-tablesaw-minimap>
                                                            <thead>

                                                            <tr>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Name</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">QoS</th>
                                                               <!--  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">UL</th> -->
                                                               <!--  <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Active Session Duration</th> -->
                                                            <?php if($package_functions->getSectionType('NET_GUEST_BANDWIDTH_EDIT',$system_package,$user_type)=="EDIT" || $package_features=="all"){
                                                            ?>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="4">Active on</th>
                                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="5">Edit</th>
                                                            <?php } ?>

                                                            </tr>

                                                            </thead>

                                                            <tbody>
                                                            <?php
                                                                $dist_guest_prof_q="SELECT d.id,d.`product_name`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`,d.`network_type`
                                                                                    FROM `exp_products_distributor` d ,`exp_products` p
                                                                                    WHERE d.`product_code`=p.`product_code` AND`distributor_code`='$user_distributor'
                                                                                    AND p.`mno_id`='$distributor_mno' AND d.`network_type` in ('GUEST','SUBCRIBE') AND p.`network_type`='GUEST'
                                                                                    GROUP BY d.id";
                                                                    /*"SELECT d.id,d.`product_name`,p.`QOS`,p.`QOS_up_link`,d.`time_gap` , d.`active_on`, d.`duration_prof_code`,d.`network_type`,if(s.ssid IS NULL ,'Default',s.ssid) AS ssid FROM `exp_products_distributor` d
                                                                            JOIN `exp_products` p ON d.`product_code`=p.`product_code`
                                                                            LEFT JOIN exp_locations_ssid s ON d.ssid = s.network_id AND s.distributor=d.distributor_code
                                                                        WHERE `distributor_code`='$user_distributor' AND p.`mno_id`='$distributor_mno' AND d.`network_type` in ('GUEST','SUBCRIBE') AND p.`network_type`='GUEST' GROUP BY d.id";*/
                                                                $dist_guest_prof_res=$db->selectDB($dist_guest_prof_q);
                                                            foreach ($dist_guest_prof_res['data'] as $dist_guest_prof) {
                                                                $prof_id=$dist_guest_prof['id'];
                                                                $network_type=$dist_guest_prof['network_type'];
                                                                //$pr_name=$dist_guest_prof['ssid'];
                                                                if($network_type == 'GUEST'){
                                                                    $pr_name='Guest Visitors';
                                                                    $but="ge_qos_change";
                                                                }else if($network_type == 'SUBCRIBE'){
                                                                    $pr_name='WOW Subscribers';
                                                                    $but="sub_qos_change";
                                                                }
                                                                echo "<tr><td>".$pr_name."</td>";
                                                               // echo "<td>".$dist_guest_prof['QOS']." Mbps</td>";
                                                                //echo "<td>".$dist_guest_prof['QOS_up_link']." Mbps</td>";

                                                                echo "<td><form style='margin-bottom:0px !important;' action='?t=12' method='post'>
                                                                <select style='margin-bottom:0px !important;' name='qos_value' class='span3'>";
                                                        
                                                                $qos_query ="SELECT `product_id`,`product_name` FROM `exp_products` WHERE `mno_id`='$distributor_mno' ";

                                                                $qos_query_ex =$db->selectDB($qos_query);

                                                                foreach ($qos_query_ex['data'] as $qos_query_result) {

                                                                    if($dist_guest_prof['product_name']==$qos_query_result['product_name']){
                                                                    
                                                                        $sel_0='selected';
                                                                    }else{
                                                                        
                                                                        $sel_0='';
                                                                    }

                                                            echo "<option ".$sel_0." value='".$qos_query_result['product_id']."'>".$qos_query_result['product_name']."</option>";

                                                                }


                                                                
                                                        echo "</select>
                                                                "; 
                                                
                                                echo '<input type="hidden" name="qos_id" value="'.$prof_id.'">';
                                                
                                                echo "<button style='margin-left: 5px; margin-top: 5px;float: right;' 
                                                    type='submit' name='".$but."' id='".$but."' class='btn btn-small btn-primary'>Update</button></td>";
                                                    

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

                                                                /*echo "<td><form style='margin-bottom:0px !important;' action='?t=12' method='post'>
                                                                        <select style='margin-bottom:0px !important;' name='du_value' class='span2'>";
                                                                
                                                                
                                                                if($timegap1==$timegap){
                                                                    
                                                                    $sel_0='selected';
                                                                }else{
                                                                    
                                                                    $sel_0='';
                                                                }

                                                                    echo "<option ".$sel_0." value='".$du_pro_code."'>".$gap."</option>";

                                                            $def_durationq="SELECT * FROM `exp_products_duration` WHERE `is_default`='1' AND `distributor`='$distributor_mno'";

                                                            $def_durationq_exe=$db->selectDB($def_durationq);
                                                            while($defduraw=mysql_fetch_assoc($def_durationq_exe)){

                                                                $de_du=$defduraw['duration'];
                                                                $de_du_code=$defduraw['profile_code'];
                                                                if($timegap==$de_du){
                                                                    continue;
                                                                }


                                                                if($timegap1==$de_du){
                                                                    
                                                                    $sel_1='selected';
                                                                    
                                                                }else{
                                                                    
                                                                    $sel_1='';
                                                                    
                                                                }
                                                                
                                                                
                                                                
                                                                $gap = "";
                                                                if($de_du != ''){
                                                                
                                                                    $interval = new DateInterval($de_du);
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
                                                                    if($interval->i != 0){
                                                                        $gap .= $interval->i.' Minutes ';
                                                                    }
                                                                    if($interval->h != 0){
                                                                        $gap .= $interval->h.' Hours ';
                                                                    }
                                                                }                                                               
                                                                
                                                                
                                                                echo "<option ".$sel_1." value='".$de_du_code."'>".$gap."</option>";
                                                                
                                                                
                                                                
                                                            }


                                                                        
                                                                echo "</select>
                                                                        "; */
                                                        
                                                        echo '<input type="hidden" name="du_id" value="'.$prof_id.'">';
                                                        
                                                        /*echo "<button style='margin-left: 5px; margin-top: 5px;float: right;' 
                                                            type='submit' name='du_pro_change' id='du_pro_change' class='btn btn-small btn-primary'>Update</button></td>";*/
                                                                
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
                                                        </table>
                                                        
                                                                </div>
                                                    </div>


                                                        <?php } ?>
                                                        
                                                </div>

                                            <!-- Tab 3 End-->
                                        </div>
                                    <?php }  ?>

<?php if(in_array("CONTENT_FILTER_MAIN",$features_array) || $package_features=="all"){?>
                                        <div <?php if(isset($tab2)){?>class="tab-pane fade in active" <?php }else {?> class="tab-pane fade" <?php }?>  id="tab_2">
                                            <?php 
                                                if(isset($tab12)){
                                                    if(isset($_SESSION['tab1'])){
                                                        echo$_SESSION['tab1'];
                                                        unset($_SESSION['tab1']);
                                                    }
                                                }

                                             ?>

                                            <h1 class="head">Content Filtering</h1>
                                            <?php
                                            $dns_q = $db->selectDB("SELECT dns_profile_enable,dns_profile,content_filter_enable,wag_profile_enable,gateway_type FROM `exp_mno_distributor` WHERE `distributor_code`='$user_distributor'");

                                            foreach ($dns_q['data'] as $row) {
                                                $content_filter=$row[dns_profile_enable];
                                                $content_filter_dns=$row[dns_profile];
                                                $content_filter_enable=$row[content_filter_enable];
                                                $wag_profile_enable=$row[wag_profile_enable];
                                                $gateway_type=$row[gateway_type];
                                            }

                                            if($gateway_type=='VSZ'){ ?>
                                            <p>
                                                Once Content Filtering is activated by your service provider you have the option to enable or disable the content filtering feature. Content Filtering is only applicable to your Guest <?php echo __WIFI_TEXT__; ?> SSIDs. Filtered content will be indicated by an informational block message.
                                            </p>
                                            <?php }elseif ($gateway_type=='WAG'){?>
                                                This is an optional feature. If you would like to purchase or enable this feature, please contact <?php echo $package_functions->getMessageOptions('SUPPORT_SALES_AGENT_NAME',$system_package); ?>.
                                                If you would like to disconnect, disable or obtain support on this feature, please contact customer support at <?php if(strlen($sup_mobile)){echo ''.$sup_mobile;} ?>.
                                                <?php }else{?>
                                                This Feature is not applicable.
                                                <?php } ?>

      <div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>Content Filter</h3>
                                                </div>

                                                <div class="widget-content table_response" id="act_profile_tbl">

                                                   

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




                                                                if($content_filter_enable==1 && $gateway_type=='VSZ'){

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

                                                                            }else if($wag_profile_enable && $gateway_type=='WAG'){
                                                                    echo "Enabled";
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
